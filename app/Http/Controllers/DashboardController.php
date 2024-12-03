<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transactions;
use App\Models\TransactionItems;
use App\Models\Accounts;
use App\Models\Apartments;
use App\Models\Shops;
use Illuminate\Support\Facades\DB;

use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf;


class DashboardController extends Controller
{
    
    public function dashboard()
    {
        // Existing calculations
        $assetsDebitAFN = DB::table('transaction_items')
            ->join('accounts', 'transaction_items.account_id', '=', 'accounts.id')
            ->where('accounts.account_type', 'Assets')
            ->where('transaction_items.currency', '=', 'AFN')
            ->sum('transaction_items.debit');

        $assetsCreditAFN = DB::table('transaction_items')
            ->join('accounts', 'transaction_items.account_id', '=', 'accounts.id')
            ->where('accounts.account_type', 'Assets')
            ->where('transaction_items.currency', '=', 'AFN')
            ->sum('transaction_items.credit');

        $incomeCreditAFN = DB::table('transaction_items')
            ->join('accounts', 'transaction_items.account_id', '=', 'accounts.id')
            ->whereIn('accounts.account_type', ['Income', 'Income/fees'])
            ->where('transaction_items.currency', '=', 'AFN')
            ->sum('transaction_items.credit');

        $expensesAFN = DB::table('transaction_items')
            ->join('accounts', 'transaction_items.account_id', '=', 'accounts.id')
            ->where('accounts.account_type', 'Expense')
            ->where('transaction_items.currency', '=', 'AFN')
            ->sum('transaction_items.debit');

        $expenseSalaryAFN = DB::table('transaction_items')
            ->join('accounts', 'transaction_items.account_id', '=', 'accounts.id')
            ->where('accounts.account_type', 'Expense/Salary')
            ->where('transaction_items.currency', '=', 'AFN')
            ->sum('transaction_items.debit');
        $expenseDebitAFN = $expensesAFN + $expenseSalaryAFN;
        $assetsAFN = $assetsDebitAFN - $assetsCreditAFN;

        $assetsDebitUSD = DB::table('transaction_items')
            ->join('accounts', 'transaction_items.account_id', '=', 'accounts.id')
            ->where('accounts.account_type', 'Assets')
            ->where('transaction_items.currency', '=', 'USD')
            ->sum('transaction_items.debit');

        $assetsCreditUSD = DB::table('transaction_items')
            ->join('accounts', 'transaction_items.account_id', '=', 'accounts.id')
            ->where('accounts.account_type', 'Assets')
            ->where('transaction_items.currency', '=', 'USD')
            ->sum('transaction_items.credit');

        $incomeCreditUSD = DB::table('transaction_items')
            ->join('accounts', 'transaction_items.account_id', '=', 'accounts.id')
            ->whereIn('accounts.account_type', ['Income', 'Income/fees'])
            ->where('transaction_items.currency', '=', 'USD')
            ->sum('transaction_items.credit');

        $expenseDebitUSD = DB::table('transaction_items')
            ->join('accounts', 'transaction_items.account_id', '=', 'accounts.id')
            ->where('accounts.account_type', 'Expense')
            ->where('transaction_items.currency', '=', 'USD')
            ->sum('transaction_items.debit');

        $assetsUSD = $assetsDebitUSD - $assetsCreditUSD;

        // New calculations for apartments, shops, and customers
        $totalApartments = Apartments::count();
        $totalShops = Shops::count();
        $totalCustomers = $totalApartments + $totalShops;

        // New calculations for invoices
        $oldBalanceAFN = DB::table('invoice_items')->where('currency', 'AFN')->sum('old_balance'); // Total balance
        $currentFeeAFN = DB::table('invoice_items')->where('currency', 'AFN')->sum('current_fee'); // Total balance
        
        $totalInvoicesAFN = $oldBalanceAFN + $currentFeeAFN;

        $totalPaidAmountAFN = DB::table('invoice_items')->where('currency', 'AFN')->sum('paid_amount'); // Total paid amount        
        $totalDiscountAFN = DB::table('invoice_items')->where('currency', 'AFN')->sum('discount');
        $totalBalanceAFN = DB::table('invoice_items')->where('currency', 'AFN')->sum('total_balance');

        // New calculations for invoices
        $oldBalanceUSD = DB::table('invoice_items')->where('currency', 'USD')->sum('old_balance'); // Total balance
        $currentFeeUSD = DB::table('invoice_items')->where('currency', 'USD')->sum('current_fee'); // Total balance
        
        $totalInvoicesUSD = $oldBalanceUSD + $currentFeeUSD;

        $totalPaidAmountUSD = DB::table('invoice_items')->where('currency', 'USD')->sum('paid_amount'); // Total paid amount        
        $totalDiscountUSD = DB::table('invoice_items')->where('currency', 'USD')->sum('discount');
        $totalBalanceUSD = DB::table('invoice_items')->where('currency', 'USD')->sum('total_balance');

        // Pass all data to the Blade view
        return view('dashboard', compact(
            //AFN Balances
            'assetsDebitAFN', 
            'incomeCreditAFN', 
            'expenseDebitAFN', 
            'assetsAFN', 
            //USD Balances
            'assetsDebitUSD', 
            'incomeCreditUSD', 
            'expenseDebitUSD', 
            'assetsUSD', 
            //TOTAl Customers
            'totalApartments', 
            'totalShops', 
            'totalCustomers',
            //AFN Invoices Balance
            'totalInvoicesAFN', 
            'totalPaidAmountAFN',
            'totalBalanceAFN',
            'totalDiscountAFN',
            //USD Invoices balances
            'totalInvoicesUSD', 
            'totalPaidAmountUSD',
            'totalDiscountUSD',
            'totalBalanceUSD',
        ));
    }

    
}
