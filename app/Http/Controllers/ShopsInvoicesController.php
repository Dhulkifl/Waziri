<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shops;
use App\Models\Accounts;
use App\Models\Projects;
use App\Models\FeesRecords;
use Illuminate\Support\Facades\DB;
use App\Models\Invoices;
use App\Models\InvoiceItems;
use App\Models\Transactions;
use App\Models\ShopsResidents;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf;
use App\Helpers\JalaliHelper;

class ShopsInvoicesController extends Controller
{

    public function saveShopPayment(Request $request) {
        $projectId = $request->input('project_id');
        $entityType = $request->input('entity_type');
        $shopId = $request->input('entity_id');
        $exchangeRate = $request->input('exchange_rate');
        $note = $request->input('note');
        $payments = $request->input('payments');

        DB::beginTransaction();
    
        try {
            $latestInvoice = Invoices::where('entity_type', 'shop')->where('entity_id', $shopId)
                ->orderBy('created_at', 'desc')
                ->first();
    
            if (!$latestInvoice) {
                return response()->json(['error' => 'No invoice found.'], 404);
            }
    
            foreach ($payments as $accountId => $payment) {
                $invoiceItem = DB::table('invoice_items')
                    ->where('invoice_id', $latestInvoice->id)
                    ->where('account_id', $accountId)
                    ->first();
        
                if ($invoiceItem) {
                    $paymentAmount = $payment['amount'];
                    $paymentCurrency = $payment['currency'];
                    $discount = $payment['discount'];
        
                    
        
                    if ($paymentCurrency == $invoiceItem->currency) {
                        $newPaidAmount = $invoiceItem->paid_amount + $paymentAmount;
                        $newTotalBalance = $invoiceItem->total_balance - $paymentAmount;
        
                        if ($invoiceItem->paid_amount == 0) {
                            $newTotalBalance -= $discount;
                        }
                    } elseif ($paymentCurrency == 'AFN' && $invoiceItem->currency == 'USD') {
                        $paymentAmountInUSD = $paymentAmount / $exchangeRate;
                        $newPaidAmount = $invoiceItem->paid_amount + $paymentAmountInUSD;
                        $newTotalBalance = $invoiceItem->total_balance - $paymentAmountInUSD;
        
                        if ($invoiceItem->paid_amount == 0) {
                            $newTotalBalance -= $discount;
                        }
                    } else {
                        // Handle other currency conversions if needed
                    }
        
                    DB::table('invoice_items')
                        ->where('id', $invoiceItem->id)
                        ->update([
                            'paid_amount' => $newPaidAmount,
                            'discount' => $discount,
                            'total_balance' => $newTotalBalance,
                            'exchange_rate' =>  ($invoiceItem->currency == 'USD') ? $exchangeRate : 1,
                        ]);
        
                    $accountName = DB::table('accounts')->where('id', $accountId)
                        ->value('account_name');
        
                    $transactionId = DB::table('transactions')->insertGetId([
                        'project_id' => $projectId,
                        'account_id' => $accountId,
                        'payer' => 'shop',
                        'payer_id' => $shopId,
                        'recipient' => null,
                        'recipient_id' => null,
                        'description' => $accountName,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
        
                    DB::table('transaction_items')->insert([
                        [
                            'transaction_id' => $transactionId,
                            'account_id' => $accountId,
                            'currency' => $paymentCurrency,
                            'debit' => 0,
                            'credit' => $paymentAmount,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ],
                        [
                            'transaction_id' => $transactionId,
                            'account_id' => $this->getAssetsAccountId(),
                            'currency' => $paymentCurrency,
                            'debit' => $paymentAmount,
                            'credit' => 0,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ],
                    ]);
                }
            }
            DB::table('invoices')
                ->where('id', $latestInvoice->id)
                ->update([
                    'note' => $note,
                ]);

            DB::commit();

            // Calculate the new total balance for the invoice
            $newInvoiceTotalBalance = DB::table('invoice_items')
                ->where('invoice_id', $latestInvoice->id)
                ->sum('total_balance');

            $latestInvoice->update([
                'paid_amount' => $latestInvoice->paid_amount + array_sum(array_column($payments, 'amount')),
            ]);

            $fees = DB::table('invoice_items')
                ->join('accounts', 'invoice_items.account_id', '=', 'accounts.id')
                ->join('invoices', 'invoice_items.invoice_id', '=', 'invoices.id')
                ->select('invoice_items.account_id', 'accounts.account_name', 'invoice_items.currency', DB::raw('SUM(invoice_items.total_balance) as total_unpaid'))
                ->where('entity_type', 'shop')->where('invoices.entity_id', $shopId)
                ->where('invoices.created_at', function ($query) use ($shopId) {
                    $query->selectRaw('MAX(created_at)')
                        ->from('invoices')
                        ->where('entity_type', 'shop')
                        ->where('invoices.entity_id', $shopId);
                })
                ->groupBy('invoice_items.account_id', 'accounts.account_name', 'invoice_items.currency')
                ->get();

            $totalBalanceByCurrency = DB::table('invoice_items')
                ->join('invoices', 'invoice_items.invoice_id', '=', 'invoices.id')
                ->select('invoice_items.currency', DB::raw('SUM(invoice_items.total_balance) as total_balance'))
                ->where('entity_type', 'shop')->where('invoices.entity_id', $shopId)
                ->where('invoices.created_at', function ($query) use ($shopId) {
                    $query->selectRaw('MAX(created_at)')
                        ->from('invoices')
                        ->where('entity_type', 'shop')
                        ->where('invoices.entity_id', $shopId);
                })
                ->groupBy('invoice_items.currency')
                ->get();

            return response()->json([
                'success' => true,
                'fees' => $fees,
                'total_balance_by_currency' => $totalBalanceByCurrency,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to create invoices',
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ], 500);
        }
    }
    private function getAssetsAccountId() {
        return DB::table('accounts')->where('account_type', 'Assets')
        ->value('id');
    }
    public function printShopInvoices(Request $request) {

        $projectId = $request->input('project_id');

        // Fetch shops for the selected project
        $shops = Shops::where('project_id', $projectId)->get();

        // Initialize an empty array to store the invoice data
        $invoiceData = [];
        $months = [
            '',
            'حمل',
            'ثور',
            'جوزا',
            'سرطان',
            'اسد',
            'سنبله',
            'میزان',
            'عقرب',
            'قوس',
            'جدی',
            'دلو',
            'حوت',
        ];

        // Loop through each shop
        foreach ($shops as $shop) {
            // Fetch the resident's name
            $residentName = ShopsResidents::where('shop_id', $shop->id)->first()->r_name;

            // Fetch the latest invoice for the shop
            $latestInvoice = Invoices::where('entity_type', 'shop')->where('entity_id', $shop->id)->latest()->first();

            if ($latestInvoice) {
                // Fetch the invoice items for the latest invoice
                $invoiceItems = InvoiceItems::where('invoice_id', $latestInvoice->id)->get();

                // Initialize totals for each currency
                $totals = [
                    'AFN' => [
                        'old_balance' => 0,
                        'current_fee' => 0,
                        'paid_amount' => 0,
                        'total_balance' => 0,
                    ],
                    'USD' => [
                        'old_balance' => 0,
                        'current_fee' => 0,
                        'paid_amount' => 0,
                        'total_balance' => 0,
                    ],
                ];

                // Initialize an empty array to store the invoice items data
                $invoiceItemsData = [];

                // Loop through each invoice item
                foreach ($invoiceItems as $invoiceItem) {
                    // Fetch the account name
                    $accountName = Accounts::where('id', $invoiceItem->account_id)->first()->account_name;
                    $currency = $invoiceItem->currency;

                    // Add the invoice item data to the array
                    $invoiceItemsData[] = [
                        'account_name' => $accountName,
                        'old_balance' => $invoiceItem->old_balance,
                        'current_fee' => $invoiceItem->current_fee,
                        'paid_amount' => $invoiceItem->paid_amount,
                        'total_balance' => $invoiceItem->total_balance,
                        'currency' => $currency,
                    ];

                    // Accumulate totals by currency
                    if (isset($totals[$currency])) {
                        $totals[$currency]['old_balance'] += $invoiceItem->old_balance;
                        $totals[$currency]['current_fee'] += $invoiceItem->current_fee;
                        $totals[$currency]['paid_amount'] += $invoiceItem->paid_amount;
                        $totals[$currency]['total_balance'] += $invoiceItem->total_balance;
                    }
                }

                // Add the shop data to the array
                $invoiceData[] = [
                    'project_name' => Projects::where('id', $projectId)->first()->project_name,
                    'entity_name' => $shop->shop_name,
                    'floor_no' => $shop->floor_no,
                    'resident_name' => $residentName,
                    'month' => $months[abs($latestInvoice->month)],
                    'year' => $latestInvoice->year,
                    'invoice_no' => $latestInvoice->id,
                    'invoice_items' => $invoiceItemsData,
                    'totals' => $totals,
                ];
            }
        }

        $invoice_name = $invoiceData[0]['project_name'].'ـ دوکاکین ـ'.
        $invoiceData[0]['month'].'_'.$invoiceData[0]['year'].'_';

        // Send the invoice data to the blade view and generate the PDFs
        $pdf = LaravelMpdf::loadView('contents.finance.invoices.invoiceShopPDF', ['invoices' => $invoiceData]);
        return $pdf->download($invoice_name.'invoices.pdf');
    }

    public function printShopInvoice(Request $request){

        $projectId = $request->input('project_id');
        $shopId = $request->input('shop_id');

        // Fetch shops for the selected project
        $shops = Shops::where('id', $shopId)->get();
        // Initialize an empty array to store the invoice data
        $invoiceData = [];
        $months = [
            '',
            'حمل',
            'ثور',
            'جوزا',
            'سرطان',
            'اسد',
            'سنبله',
            'میزان',
            'عقرب',
            'قوس',
            'جدی',
            'دلو',
            'حوت',
        ];

        // Loop through each shop
        foreach ($shops as $shop) {
            // Fetch the resident's name
            $residentName = ShopsResidents::where('shop_id', $shop->id)->first()->r_name;

            // Fetch the latest invoice for the shop
            $latestInvoice = Invoices::where('entity_type', 'shop')->where('entity_id', $shop->id)->latest()->first();

            if ($latestInvoice) {
                // Fetch the invoice items for the latest invoice
                $invoiceItems = InvoiceItems::where('invoice_id', $latestInvoice->id)->get();

                // Initialize totals for each currency
                $totals = [
                    'AFN' => [
                        'old_balance' => 0,
                        'current_fee' => 0,
                        'paid_amount' => 0,
                        'total_balance' => 0,
                    ],
                    'USD' => [
                        'old_balance' => 0,
                        'current_fee' => 0,
                        'paid_amount' => 0,
                        'total_balance' => 0,
                    ],
                ];

                // Initialize an empty array to store the invoice items data
                $invoiceItemsData = [];

                // Loop through each invoice item
                foreach ($invoiceItems as $invoiceItem) {
                    // Fetch the account name
                    $accountName = Accounts::where('id', $invoiceItem->account_id)->first()->account_name;
                    $currency = $invoiceItem->currency;

                    // Add the invoice item data to the array
                    $invoiceItemsData[] = [
                        'account_name' => $accountName,
                        'old_balance' => $invoiceItem->old_balance,
                        'current_fee' => $invoiceItem->current_fee,
                        'paid_amount' => $invoiceItem->paid_amount,
                        'total_balance' => $invoiceItem->total_balance,
                        'currency' => $currency,
                    ];

                    // Accumulate totals by currency
                    if (isset($totals[$currency])) {
                        $totals[$currency]['old_balance'] += $invoiceItem->old_balance;
                        $totals[$currency]['current_fee'] += $invoiceItem->current_fee;
                        $totals[$currency]['paid_amount'] += $invoiceItem->paid_amount;
                        $totals[$currency]['total_balance'] += $invoiceItem->total_balance;
                    }
                }

                // Add the shop data to the array
                $invoiceData[] = [
                    'project_name' => Projects::where('id', $projectId)->first()->project_name,
                    'shop_name' => $shop->shop_name,
                    'floor_no' => $shop->floor_no,
                    'resident_name' => $residentName,
                    'month' => $months[abs($latestInvoice->month)],
                    'year' => $latestInvoice->year,
                    'invoice_no' => $latestInvoice->id,
                    'invoice_items' => $invoiceItemsData,
                    'totals' => $totals,
                ];
            }
        }

        $invoice_name = $invoiceData[0]['project_name'].'_'.$invoiceData[0]['shop_name'].'_'.
        $invoiceData[0]['month'].'_'.$invoiceData[0]['year'].'_';

        // Send the invoice data to the blade view and generate the PDFs
        $pdf = LaravelMpdf::loadView('contents.finance.invoices.invoiceShopPDF', ['invoices' => $invoiceData]);
        return $pdf->download($invoice_name.'_invoices.pdf');
    }

    public function printShopBill(Request $request) {

        $projectId = $request->input('project_id');
        $shopId = $request->input('shop_id');
    
        $shops = Shops::where('id', $shopId)->get();
        $invoiceData = [];
        $months = [
            '',
            'حمل',
            'ثور',
            'جوزا',
            'سرطان',
            'اسد',
            'سنبله',
            'میزان',
            'عقرب',
            'قوس',
            'جدی',
            'دلو',
            'حوت',
        ];
    
        foreach ($shops as $shop) {
            $residentName = ShopsResidents::where('shop_id', $shop->id)->first()->r_name;
            $latestInvoice = Invoices::where('entity_type', 'shop')->where('entity_id', $shop->id)->latest()->first();
            $invoiceItems = InvoiceItems::where('invoice_id', $latestInvoice->id)->get();
    
            $invoiceItemsData = [];
            foreach ($invoiceItems as $invoiceItem) {
                $accountName = Accounts::where('id', $invoiceItem->account_id)->first()->account_name;
    
                $invoiceItemsData[] = [
                    'account_name' => $accountName,
                    'discount' => $invoiceItem->discount, // Set your discount amount here if applicable
                    'paid_amount' => $invoiceItem->paid_amount,
                    'currency' => $invoiceItem->currency,
                    'total_balance' => $invoiceItem->total_balance,
                ];
            }
    
            $invoiceData[] = [
                'project_name' => Projects::where('id', $projectId)->first()->project_name,
                'shop_name' => $shop->shop_name,
                'resident_name' => $residentName,
                'month' => $months[abs($latestInvoice->month)],
                'year' => $latestInvoice->year,
                'invoice_no' => $latestInvoice->id, // Assuming invoice ID as invoice number
                'invoice_items' => $invoiceItemsData,
            ];
        }
        $name = $invoiceData[0]['project_name'].'_'.$invoiceData[0]['shop_name'].'_'.
        $invoiceData[0]['shop_name'].'_'.$invoiceData[0]['month'].'_'.$invoiceData[0]['year'];
        $pdf = LaravelMpdf::loadView('contents.finance.invoices.billShopPDF', ['invoices' => $invoiceData]);
        return $pdf->download($name.'_Bill.pdf');
    }

}
