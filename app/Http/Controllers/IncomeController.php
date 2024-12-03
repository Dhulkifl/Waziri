<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Accounts;
use App\Models\Apartments;
use App\Models\Shops;
use App\Models\Projects;
use App\Models\Invoices;


class IncomeController extends Controller
{   
    // cash receipt page
    function cashReceipt() {
        $accounts = Accounts::all();
        $apartments = Apartments::all();
        $projects = Projects::all();
        return view('contents.finance.invoices.cashReceipt', compact('accounts', 'apartments', 'projects'));
    }

    public function getEntities(Request $request) {

        $projectId = $request->input('project_id');
        $entityType = $request->input('entity_type');

        if ($entityType === 'apartment') {
            $entities = Apartments::where('project_id', $projectId)->get(['id', 'apartment_name as name']);
        } elseif ($entityType === 'shop') {
            $entities = Shops::where('project_id', $projectId)->get(['id', 'shop_name as name']);
        } else {
            return response()->json(['error' => 'Invalid entity type'], 400);
        }

        return response()->json(['entities' => $entities]);
    }

    public function getEntityFees(Request $request) {

        //dd($request->all());
        $entityId = $request->input('entity_id');
        $entityType = $request->input('entity_type');

        if ($entityType === 'apartment') {
            $fees = DB::table('invoice_items')
                ->join('accounts', 'invoice_items.account_id', '=', 'accounts.id')
                ->join('invoices', 'invoice_items.invoice_id', '=', 'invoices.id')
                ->join('apartments_fees', function($join) use ($entityId) {
                    $join->on('invoice_items.account_id', '=', 'apartments_fees.fees_id')
                        ->where('apartments_fees.apartment_id', $entityId);
                })
                ->select('invoice_items.account_id', 'accounts.account_name', 
                        DB::raw('SUM(invoice_items.total_balance) as total_unpaid'),
                        'apartments_fees.discount',
                        'invoice_items.currency')
                ->where('invoices.entity_id', $entityId)
                ->where('invoices.entity_type', $entityType)
                ->where('invoices.created_at', function ($query) use ($entityId, $entityType) {
                    $query->selectRaw('MAX(created_at)')
                        ->from('invoices')
                        ->where('entity_id', $entityId)
                        ->where('entity_type', $entityType);
                })
                ->groupBy('invoice_items.account_id', 'accounts.account_name', 'apartments_fees.discount', 'invoice_items.currency')
                ->get();
        } elseif ($entityType === 'shop') {
            $fees = DB::table('invoice_items')
                ->join('accounts', 'invoice_items.account_id', '=', 'accounts.id')
                ->join('invoices', 'invoice_items.invoice_id', '=', 'invoices.id')
                ->join('shops_fees', function($join) use ($entityId) {
                    $join->on('invoice_items.account_id', '=', 'shops_fees.fees_id')
                        ->where('shops_fees.shop_id', $entityId);
                })
                ->select('invoice_items.account_id', 'accounts.account_name', 
                        DB::raw('SUM(invoice_items.total_balance) as total_unpaid'),
                        'shops_fees.discount',
                        'invoice_items.currency')
                ->where('invoices.entity_id', $entityId)
                ->where('invoices.entity_type', $entityType)
                ->where('invoices.created_at', function ($query) use ($entityId, $entityType) {
                    $query->selectRaw('MAX(created_at)')
                        ->from('invoices')
                        ->where('entity_id', $entityId)
                        ->where('entity_type', $entityType);
                })
                ->groupBy('invoice_items.account_id', 'accounts.account_name', 'shops_fees.discount', 'invoice_items.currency')
                ->get();
        } else {
            return response()->json(['error' => 'Invalid entity type'], 400);
        }

        $totalBalancesQuery = DB::table('invoice_items')
            ->join('invoices', 'invoice_items.invoice_id', '=', 'invoices.id')
            ->where('invoices.entity_id', $entityId)
            ->where('invoices.entity_type', $entityType)
            ->where('invoices.created_at', function ($query) use ($entityId, $entityType) {
                $query->selectRaw('MAX(created_at)')
                    ->from('invoices')
                    ->where('entity_id', $entityId)
                    ->where('entity_type', $entityType);
            })
            ->select('invoice_items.currency', DB::raw('SUM(invoice_items.total_balance) as total_balance'))
            ->groupBy('invoice_items.currency');

        $totalBalances = $totalBalancesQuery->get();

        return response()->json([
            'fees' => $fees,
            'total_balances' => $totalBalances
        ]);
    }


        
    public function showInvoices($apartmentId) {
        $apartment = Apartments::find($apartmentId);
    
        $invoices = DB::table('invoices')
            ->where('apartment_id', $apartmentId)
            ->get();
    
        $invoices->each(function ($invoice) {
            $invoice->items = DB::table('invoice_items')
                ->join('accounts', 'invoice_items.account_id', '=', 'accounts.id')
                ->select('invoice_items.*', 'accounts.account_name', 'accounts.account_type')
                ->where('invoice_items.invoice_id', $invoice->id)
                ->get();
        });
    
        return view('contents.finance.invoices.balances', [
            'apartmentName' => $apartment->apartment_name,
            'invoices' => $invoices
        ]);
    }

    

}