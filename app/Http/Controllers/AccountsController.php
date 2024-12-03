<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Projects;
use App\Models\Accounts;


class AccountsController extends Controller
{
    function accounts() {
        $accounts = Accounts::all();
        $count = 1;
        return view('contents.finance.accounts', compact('accounts', 'count'));
    }

    //save Accounts
    function saveAccounts(Request $request) {
        //dd($request->all());
        $account_id = $request->input('account_id');
        $account_name = $request->input('account_name');
        $account_type = $request->input('account_type');
        $opening_balance = $request->input('opening_balance');
        $description = $request->input('description');
        $save_type = $request->input('save_type');
        
        if ($save_type == 'new') {
            $account_exist = Accounts::where('account_name', $account_name)->first();
            
            if (!$account_exist) {
                //insert into database
                $new_account = new Accounts;
                $new_account->account_name = $account_name;
                $new_account->account_type = $account_type;
                $new_account->opening_balance = $opening_balance;
                $new_account->description = $description;
                $new_account->created_by = Auth::user()->id;
                $new_account-> save();     
            }   
        }elseif ($save_type == 'update') {
            //uptade the details
            $account = accounts::where('id', $account_id)->first();
            $account->account_name = $account_name;
            $account->account_type = $account_type;
            $account->opening_balance = $opening_balance;
            $account->description = $description;
            $account->save();
        }
        $accounts = Accounts::all();
        return response()->json([
            'accounts' => $accounts
        ]); 
    }
}
