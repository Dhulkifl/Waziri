<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf;
use Morilog\Jalali\Jalalian;
use App\Helpers\JalaliHelper;
use App\Models\Apartments;
use App\Models\Shops;
use App\Models\Accounts;
use App\Models\Projects;
use App\Models\FeesRecords;
use App\Models\Invoices;
use App\Models\InvoiceItems;
use App\Models\Transactions;
use App\Models\ApartmentsResidents;
use App\Models\ShopsResidents;
use App\Models\TransactionItems;
use App\Models\Employees;
use App\Models\Salaries;


class ReportsController extends Controller
{

    function accountsLedger() {
        $apartments = Apartments::all();
        $accounts = Accounts::all();
        $projects = Projects::all();
        $count_fees_account = 1;    
        return view('contents.reports.accountsLedger', compact('apartments', 'accounts', 'projects', 'count_fees_account'));
    }

    public function getAccountLedger(Request $request) {
        
        //dd($request->all());
        $projectId = $request->project_id;
        $accountId = $request->account_id;
        $from = $request->input('from_date');
        $to = $request->input('to_date');
        $exportToPdf = $request->has('export_to_pdf'); // Check if PDF export is requested

        // Convert Jalali dates to Gregorian dates
        $fromGregorian = Jalalian::fromFormat('Y-m-d', $from)->toCarbon()->format('Y-m-d');
        $toGregorian = Jalalian::fromFormat('Y-m-d', $to)->toCarbon()->format('Y-m-d');

        // Convert Gregorian dates to Carbon instances
        $fromCarbon = Carbon::createFromFormat('Y-m-d', $fromGregorian);
        $toCarbon = Carbon::createFromFormat('Y-m-d', $toGregorian);
    
        // Fetch account type
        $account = Accounts::find($accountId);
        $accountName = $account->account_name;
        // Initialize data and totals
        $data = [];
        $totals = [
            'AFN' => ['cash_in' => 0, 'cash_out' => 0],
            'USD' => ['cash_in' => 0, 'cash_out' => 0]
        ];
    
        // Check if account type is 'Assets'
        if ($account->account_type === 'Assets') {
            // Fetch transaction items for 'Assets'
            $transactionItems = TransactionItems::where('transaction_items.account_id', $accountId)
            ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->where('transactions.project_id', $projectId)
            ->whereDate('transactions.created_at', '>=', $fromCarbon)
            ->whereDate('transactions.created_at', '<=', $toCarbon)
            ->get();
               
            foreach ($transactionItems as $item) {
                // Fetch the related transaction
                $transaction = Transactions::find($item->transaction_id);
    
                if ($transaction && $transaction->project_id == $projectId) {
                    $cashIn = $item->debit;
                    $cashOut = $item->credit;
    
                    $projectName = Projects::where('id', $transaction->project_id)->value('project_name');
                    
                    // Check if payer is 'apartment' and fetch apartment name
                    $description = $transaction->description;
                    if ($transaction->payer === 'apartment') {
                        $apartmentName = Apartments::where('id', $transaction->payer_id)->value('apartment_name');
                        $description .= ' ' . $apartmentName;
                    }else if ($transaction->payer === 'shop') {
                        $ShopName = Shops::where('id', $transaction->payer_id)->value('Shop_name');
                        $description .= ' ' . $ShopName;
                    }else if ($transaction->recipient === 'employee') {
                        $EmployeeName = Employees::where('id', $transaction->recipient_id)->value('name');
                        $description .= ' ' . $EmployeeName;
                    } else {
                        $description .= ' ' . $transaction->payer;
                    }
                    $data[] = [
                        'project_name' => $projectName,
                        'description' => $description,
                        'cash_in' => $cashIn,
                        'cash_out' => $cashOut,
                        'currency' => $item->currency,
                        'date' => $transaction->created_at->format('Y-m-d')
                    ];

    
                    if ($item->currency === 'AFN') {
                        $totals['AFN']['cash_in'] += $cashIn;
                        $totals['AFN']['cash_out'] += $cashOut;
                    } elseif ($item->currency === 'USD') {
                        $totals['USD']['cash_in'] += $cashIn;
                        $totals['USD']['cash_out'] += $cashOut;
                    }
                }
            }
        } else {
            // Handle other account types
            $transactions = Transactions::where('project_id', $projectId)
            ->where('account_id', $accountId)
            ->whereDate('created_at', '>=', $fromCarbon)
            ->whereDate('created_at', '<=', $toCarbon)
            ->get();
    
            foreach ($transactions as $transaction) {
                $transactionItems = TransactionItems::where('transaction_id', $transaction->id)
                    ->where('account_id', $accountId)
                    ->get();
    
                    foreach ($transactionItems as $item) {
                        $cashIn = $item->credit;
                        $cashOut = $item->debit;
                    
                        $projectName = Projects::where('id', $transaction->project_id)->value('project_name');
                    
                        // Check if payer is 'apartment' and fetch apartment name
                        $description = $transaction->description;
                        if ($transaction->payer === 'apartment') {
                            $apartmentName = Apartments::where('id', $transaction->payer_id)->value('apartment_name');
                            $description .= ' ' . $apartmentName;
                        } else {
                            $description .= ' ' . $transaction->payer;
                        }
                    
                        $data[] = [
                            'project_name' => $projectName,
                            'description' => $description,
                            'cash_in' => $cashIn,
                            'cash_out' => $cashOut,
                            'currency' => $item->currency,
                            'date' => $transaction->created_at->format('Y-m-d')
                        ];
                    
                        // Update totals
                        if ($item->currency === 'AFN') {
                            $totals['AFN']['cash_in'] += $cashIn;
                            $totals['AFN']['cash_out'] += $cashOut;
                        } elseif ($item->currency === 'USD') {
                            $totals['USD']['cash_in'] += $cashIn;
                            $totals['USD']['cash_out'] += $cashOut;
                        }
                    }
            }
        }
        // If the request is for PDF export
        if ($exportToPdf) {
            $reportData[] = [
                'data' => $data,
                'totals' => $totals,
                'account_name' => $accountName
            ];
             // Add totals to data
            
            $pdf = LaravelMpdf::loadView('contents.reports.accountLedgerPDF', ['report' => $reportData]);
            return $pdf->download('accountLedgerReport.pdf');
        }else{
            return response()->json(['data' => $data, 'totals' => $totals]);

        }
    }

    public function getAccountSummary(Request $request) {

        $projectId = $request->project_id;
        $accountId = $request->account_id;
        $from = $request->input('from_date');
        $to = $request->input('to_date');

        // Convert Jalali dates to Gregorian dates
        $fromGregorian = Jalalian::fromFormat('Y-m-d', $from)->toCarbon()->format('Y-m-d');
        $toGregorian = Jalalian::fromFormat('Y-m-d', $to)->toCarbon()->format('Y-m-d');

        // Convert Gregorian dates to Carbon instances
        $fromCarbon = Carbon::createFromFormat('Y-m-d', $fromGregorian);
        $toCarbon = Carbon::createFromFormat('Y-m-d', $toGregorian);

        $accounts = Accounts::all();

        $assetsAccounts = [];
        $otherAccounts = [];

        foreach ($accounts as $account) {
            $balances = [
                'AFN' => [
                    'opening_balance' => $account->opening_balance_afn,
                    'cash_in' => 0,
                    'cash_out' => 0,
                    'closing_balance' => 0,
                ],
                'USD' => [
                    'opening_balance' => $account->opening_balance_usd,
                    'cash_in' => 0,
                    'cash_out' => 0,
                    'closing_balance' => 0,
                ],
            ];

            $transactionItems = TransactionItems::where('account_id', $account->id)
                ->whereDate('created_at', '>=', $fromCarbon)
                ->whereDate('created_at', '<=', $toCarbon)
                ->get();

            foreach ($transactionItems as $transactionItem) {
                if ($transactionItem->currency === 'AFN') {
                    if ($account->account_type === 'Assets') {
                        $balances['AFN']['cash_in'] += $transactionItem->debit;
                        $balances['AFN']['cash_out'] += $transactionItem->credit;
                    } else {
                        $balances['AFN']['cash_in'] += $transactionItem->credit;
                        $balances['AFN']['cash_out'] += $transactionItem->debit;
                    }
                } elseif ($transactionItem->currency === 'USD') {
                    if ($account->account_type === 'Assets') {
                        $balances['USD']['cash_in'] += $transactionItem->debit;
                        $balances['USD']['cash_out'] += $transactionItem->credit;
                    } else {
                        $balances['USD']['cash_in'] += $transactionItem->credit;
                        $balances['USD']['cash_out'] += $transactionItem->debit;
                    }
                }
            }

            $balances['AFN']['closing_balance'] = $balances['AFN']['opening_balance'] + $balances['AFN']['cash_in'] - $balances['AFN']['cash_out'];
            $balances['USD']['closing_balance'] = $balances['USD']['opening_balance'] + $balances['USD']['cash_in'] - $balances['USD']['cash_out'];

            if ($account->account_type === 'Assets') {
                $assetsAccounts[] = [
                    'account_name' => $account->account_name,
                    'account_type' => $account->account_type,
                    'balances' => $balances,
                ];
            } else {
                $otherAccounts[] = [
                    'account_name' => $account->account_name,
                    'account_type' => $account->account_type,
                    'balances' => $balances,
                ];
            }
        }

        $data = array_merge($otherAccounts, $assetsAccounts);

        return response()->json(['data' => $data]);
    }

    public function getAccountSummaryPDF(Request $request)
    {
        $projectId = $request->project_id;
        $accountId = $request->account_id;
        $from = $request->input('from_date');
        $to = $request->input('to_date');

        // Convert Jalali dates to Gregorian dates
        $fromGregorian = Jalalian::fromFormat('Y-m-d', $from)->toCarbon()->format('Y-m-d');
        $toGregorian = Jalalian::fromFormat('Y-m-d', $to)->toCarbon()->format('Y-m-d');

        // Convert Gregorian dates to Carbon instances
        $fromCarbon = Carbon::createFromFormat('Y-m-d', $fromGregorian);
        $toCarbon = Carbon::createFromFormat('Y-m-d', $toGregorian);

        $accounts = Accounts::all();

        $assetsAccounts = [];
        $otherAccounts = [];

        $incomes = [];
        $expenses = [];
        $totalIncomeAFN = 0;
        $totalIncomeUSD = 0;
        $totalExpensesAFN = 0;
        $totalExpensesUSD = 0;
        $balanceAFN = 0;
        $balanceUSD = 0;

        foreach ($accounts as $account) {
            $balances = [
                'AFN' => [
                    'opening_balance' => $account->opening_balance_afn,
                    'cash_in' => 0,
                    'cash_out' => 0,
                    'closing_balance' => 0,
                ],
                'USD' => [
                    'opening_balance' => $account->opening_balance_usd,
                    'cash_in' => 0,
                    'cash_out' => 0,
                    'closing_balance' => 0,
                ],
            ];

            $transactionItems = TransactionItems::where('account_id', $account->id)
                ->whereDate('created_at', '>=', $fromCarbon)
                ->whereDate('created_at', '<=', $toCarbon)
                ->get();

            foreach ($transactionItems as $transactionItem) {
                if ($transactionItem->currency === 'AFN') {
                    if ($account->account_type === 'Assets') {
                        $balances['AFN']['cash_in'] += $transactionItem->debit;
                        $balances['AFN']['cash_out'] += $transactionItem->credit;
                    } else {
                        $balances['AFN']['cash_in'] += $transactionItem->credit;
                        $balances['AFN']['cash_out'] += $transactionItem->debit;
                    }
                } elseif ($transactionItem->currency === 'USD') {
                    if ($account->account_type === 'Assets') {
                        $balances['USD']['cash_in'] += $transactionItem->debit;
                        $balances['USD']['cash_out'] += $transactionItem->credit;
                    } else {
                        $balances['USD']['cash_in'] += $transactionItem->credit;
                        $balances['USD']['cash_out'] += $transactionItem->debit;
                    }
                }
            }

            $balances['AFN']['closing_balance'] = $balances['AFN']['opening_balance'] + $balances['AFN']['cash_in'] - $balances['AFN']['cash_out'];
            $balances['USD']['closing_balance'] = $balances['USD']['opening_balance'] + $balances['USD']['cash_in'] - $balances['USD']['cash_out'];

            if ($account->account_type === 'Assets') {
                $assetsAccounts[] = [
                    'account_name' => $account->account_name,
                    'account_type' => $account->account_type,
                    'balances' => $balances,
                ];
            } else {
                $otherAccounts[] = [
                    'account_name' => $account->account_name,
                    'account_type' => $account->account_type,
                    'balances' => $balances,
                ];

                // Calculate incomes and expenses
                foreach ($balances as $currency => $balance) {
                    if ($balance['cash_in'] > 0) {
                        $incomes[] = [
                            'account_name' => $account->account_name,
                            'currency' => $currency,
                            'amount' => $balance['cash_in'],
                        ];
                        if ($currency === 'AFN') {
                            $totalIncomeAFN += $balance['cash_in'];
                        } elseif ($currency === 'USD') {
                            $totalIncomeUSD += $balance['cash_in'];
                        }
                    }
                    if ($balance['cash_out'] > 0) {
                        $expenses[] = [
                            'account_name' => $account->account_name,
                            'currency' => $currency,
                            'amount' => $balance['cash_out'],
                        ];
                        if ($currency === 'AFN') {
                            $totalExpensesAFN += $balance['cash_out'];
                        } elseif ($currency === 'USD') {
                            $totalExpensesUSD += $balance['cash_out'];
                        }
                    }
                }
            }
        }

        $balanceAFN = $totalIncomeAFN - $totalExpensesAFN;
        $balanceUSD = $totalIncomeUSD - $totalExpensesUSD;

        $data = array_merge($otherAccounts, $assetsAccounts);

        $reportData[] = [
            'data' => $data,
            'incomes' => $incomes,
            'expenses' => $expenses,
            'totalIncomeAFN' => $totalIncomeAFN,
            'totalIncomeUSD' => $totalIncomeUSD,
            'totalExpensesAFN' => $totalExpensesAFN,
            'totalExpensesUSD' => $totalExpensesUSD,
            'balanceAFN' => $balanceAFN,
            'balanceUSD' => $balanceUSD,
            'from' => $from,
            'to' => $to,
        ];

        $pdf = LaravelMpdf::loadView('contents.reports.accountSummaryPDF', ['report' => $reportData]);
        return $pdf->download('accountSummaryReport.pdf');
    }

    public function apartmentsAndShopsReport() {

        $projects = Projects::all();
        return view('contents.reports.apartmentsReport', compact('projects'));
    }

    public function printEntityInvoices(Request $request) {
        //dd($request->all());
        $project_id = $request->input('project_id');
        $entity_type = $request->input('entity_type');
        $entity_id = $request->input('entity_id');

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

        // Fetch the entity's invoices
        $invoices = Invoices::where('project_id', $project_id)
            ->where('entity_type', $entity_type)
            ->where('entity_id', $entity_id)
            ->get();

        // Loop through each invoice
        foreach ($invoices as $invoice) {
            // Fetch the entity's name
            $entityName = '';
            if ($entity_type == 'apartment') {
                $entityName = Apartments::where('id', $entity_id)->first()->apartment_name;
            } elseif ($entity_type == 'shop') {
                $entityName = Shops::where('id', $entity_id)->first()->shop_name;
            }

            // Fetch the resident's name
            $residentName = '';
            if ($entity_type == 'apartment') {
                $residentName = ApartmentsResidents::where('apartment_id', $entity_id)->first()->r_name;
            }

            // Fetch the invoice items for the invoice
            $invoiceItems = InvoiceItems::where('invoice_id', $invoice->id)->get();

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

            // Add the invoice data to the array
            $invoiceData[] = [
                'project_name' => Projects::where('id', $project_id)->first()->project_name,
                'entity_name' => $entityName,
                'entity_type' => $entity_type,
                'resident_name' => $residentName,
                'month' => $months[abs($invoice->month)],
                'year' => $invoice->year,
                'invoice_no' => $invoice->id,
                'invoice_items' => $invoiceItemsData,
                'totals' => $totals,
            ];
        }

        $invoice_name = $invoiceData[0]['project_name'].'_'.$invoiceData[0]['entity_type'].'_'.$invoiceData[0]['entity_name'].'_'.$invoiceData[0]['month'].'_'.$invoiceData[0]['year'].'_';

        // Send the invoice data to the blade view and generate the PDFs
        $pdf = LaravelMpdf::loadView('contents.finance.invoices.invoicePdf', ['invoices' => $invoiceData]);
        return $pdf->download($invoice_name.'_invoices.pdf');
    }

    public function printEntityBills(Request $request) {
        //dd($request->all());
        $project_id = $request->input('project_id');
        $entity_type = $request->input('entity_type');
        $entity_id = $request->input('entity_id');

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

        // Fetch the entity's invoices
        $invoices = Invoices::where('project_id', $project_id)
            ->where('entity_type', $entity_type)
            ->where('entity_id', $entity_id)
            ->get();

        // Loop through each invoice
        foreach ($invoices as $invoice) {
            // Fetch the entity's name
            $entityName = '';
            if ($entity_type == 'apartment') {
                $entityName = Apartments::where('id', $entity_id)->first()->apartment_name;
            } elseif ($entity_type == 'shop') {
                $entityName = Shops::where('id', $entity_id)->first()->shop_name;
            }

            // Fetch the resident's name
            $residentName = '';
            if ($entity_type == 'apartment') {
                $residentName = ApartmentsResidents::where('apartment_id', $entity_id)->first()->r_name;
            } else if ($entity_type == 'shop') {
                $residentName = ShopsResidents::where('shop_id', $entity_id)->first()->r_name;
            }

            // Fetch the invoice items for the invoice
            $invoiceItems = InvoiceItems::where('invoice_id', $invoice->id)->get();

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
                    'old_balance' => $invoiceItem->total_balance + $invoiceItem->paid_amount + $invoiceItem->discount,
                    'discount' => $invoiceItem->discount,
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

            // Add the invoice data to the array
            $invoiceData[] = [
                'project_name' => Projects::where('id', $project_id)->first()->project_name,
                'entity_name' => $entityName,
                'entity_type' => $entity_type,
                'resident_name' => $residentName,
                'month' => $months[abs($invoice->month)],
                'year' => $invoice->year,
                'invoice_no' => $invoice->id,
                'invoice_items' => $invoiceItemsData,
                'totals' => $totals,
            ];
        }

        $invoice_name = $invoiceData[0]['project_name'].'_'.$invoiceData[0]['entity_type'].'_'.$invoiceData[0]['entity_name'].'_'.$invoiceData[0]['month'].'_'.$invoiceData[0]['year'].'_';

        // Send the invoice data to the blade view and generate the PDFs
        $pdf = LaravelMpdf::loadView('contents.finance.invoices.billPDF', ['invoices' => $invoiceData]);
        return $pdf->download($invoice_name.'_bills.pdf');
    }

    public function getProjectDetails(Request $request) {

        $projectId = $request->input('project_id');
        
        $projectName = Projects::where('id', $projectId)->value('project_name');

        $apartments = Apartments::where('project_id', $projectId)->get();
    
        $details = $apartments->map(function ($apartment) {
            $resident = DB::table('apartments_residents')
                ->where('apartment_id', $apartment->id)
                ->first();
    
            $balance = DB::table('invoices')
                ->where('apartment_id', $apartment->id)
                ->sum('total_balance');
    
            return [
                'apartment_name' => $apartment->apartment_name,
                'resident_name' => $resident ? $resident->r_name : 'N/A',
                'balance' => $balance,
            ];
        });
    
        return response()->json([
            'details' => $details,
            'project_name' => $projectName,
            'apartments' => $apartments
        ]);
    }

    public function salariesReport() {

        $projects = Projects::all();
        $accounts = Accounts::where('account_type', 'Expense/Salary')->get();
        return view('contents.reports.salariesReport', compact('projects', 'accounts'));
    }

    public function printSalariesReport(Request $request)
    {
        //dd($request->all());
        $project_id = $request->input('project_id');
        $year = $request->input('year');
        $month = $request->input('month');

        $salaries = Salaries::join('employees', 'salaries.employee_id', '=', 'employees.id')
            ->where('salaries.project_id', $project_id)
            ->where('year', $year)->where('month', $month)
            ->select('salaries.*', 'employees.name as employee_name')
            ->get();

            $project_name = Projects::where('id', $project_id)->first()->project_name;
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

        $pdf = LaravelMpdf::loadView('contents.reports.salariesReportPDF', [
            'salaries' => $salaries,
            'project_name' => $project_name,
            'month' => $months[abs($month)],
            'year' => $year,
        ]);

        return $pdf->download('Salaries.pdf');
    }


    
}
