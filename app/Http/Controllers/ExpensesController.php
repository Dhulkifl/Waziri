<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Accounts;
use App\Models\Projects;

class ExpensesController extends Controller
{
    //expenses page
    function expenses() {

        $expenses = Accounts::where('account_type', 'Expense')->get();
        $projects = projects::all();
        return view('contents.finance.expenses', compact('expenses', 'projects'));
    }

    public function saveExpense(Request $request) {
        $projectId = $request->input('project_id');
        $accountId = $request->input('account_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');
        $description = $request->input('description');
    
        // Start transaction
        DB::beginTransaction();
    
        try {
            // Fetch account name
            $accountName = DB::table('accounts')->where('id', $accountId)->value('account_name');
    
            // Insert into transactions table
            $transactionId = DB::table('transactions')->insertGetId([
                'project_id' => $projectId,
                'account_id' => $accountId,
                'payer' => null,
                'payer_id' => null,
                'recipient' => null,
                'recipient_id' => null,
                'description' => $description,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    
            // Insert into transaction_items table
            DB::table('transaction_items')->insert([
                [
                    'transaction_id' => $transactionId,
                    'account_id' => $accountId,
                    'currency' => $currency,
                    'debit' => $amount,
                    'credit' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'transaction_id' => $transactionId,
                    'account_id' => $this->getAssetsAccountId(), // Function to get 'Assets' account ID
                    'currency' => $currency,
                    'debit' => 0,
                    'credit' => $amount,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
    
            // Commit transaction
            DB::commit();
    
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollBack();
            return response()->json(['error' => 'Transaction failed.'], 500);
        }
    }
    
    private function getAssetsAccountId() {
        return DB::table('accounts')
            ->where('account_type', 'Assets')
            ->value('id');
    }
}
