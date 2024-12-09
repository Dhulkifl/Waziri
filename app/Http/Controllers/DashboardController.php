<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transactions;
use App\Models\TransactionItems;
use App\Models\Accounts;
use Illuminate\Support\Facades\DB;

use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf;


class DashboardController extends Controller
{

    public function dashboard()
    {

        // Pass all data to the Blade view
        return view(
            'dashboard', /*compact(
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
)*/
        );
    }


}
