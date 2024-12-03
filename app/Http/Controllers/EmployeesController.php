<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employees;
use App\Models\Projects;
use App\Models\Accounts;
use App\Models\Transactions;
use App\Models\TransactionItems;
use App\Models\Salaries;

class EmployeesController extends Controller
{
    function employees() {

        $projects = Projects::all();
        $employees = employees::all();
        $count = 1;
        return view('contents.finance.employees.employees', compact('employees', 'projects', 'count'));
    }

    function saveEmployee(Request $request) {
        
        //dd($request->all());
        $employee_id = $request->input('employee_id');
        $project_id = $request->input('project_id');
        $name = $request->input('name');
        $father_name = $request->input('father_name');
        $phone = $request->input('phone');
        $job = $request->input('job');
        $salary = $request->input('salary');
        $save_type = $request->input('save_type');
        
        if ($save_type == 'new') {
            $employee_exist = Employees::where('project_id', $project_id)->
            where('name', $name)->where('father_name', $father_name)->first();
            
            if (!$employee_exist) {
                //insert into database
                $new_employee = new Employees;
                $new_employee->project_id = $project_id;
                $new_employee->name = $name;
                $new_employee->father_name = $father_name;
                $new_employee->phone = $phone;
                $new_employee->job_title = $job;
                $new_employee->salary_amount = $salary;
                $new_employee-> save();     
            }   
        }elseif ($save_type == 'update') {
            //uptade the details
            $employee = Employees::where('id', $employee_id)->first();
            $employee->project_id = $project_id;
            $employee->name = $name;
            $employee->father_name = $father_name;
            $employee->phone = $phone;
            $employee->job_title = $job;
            $employee->salary_amount = $salary;
            $employee->save();
        }
        $projects = Projects::all();
        $employees = Employees::all();
        return response()->json([
            'employees' => $employees,
            'projects' => $projects,
        ]); 
    }

    function salaries() {
        $accounts = Accounts::all();
        $projects = Projects::all();
        return view('contents.finance.employees.salaries', compact('accounts', 'projects'));
    }

    public function getEmployees(Request $request) {
        //dd($request->all());
        $projectId = $request->input('project_id');
        $employees = Employees::where('project_id', $projectId)->get();
    
        return response()->json([
            'employees' => $employees
        ]);
    }

    public function getEmployeeDetails(Request $request) {
        
        //dd($request->all());
        $project_id = $request->input('project_id');
        $employee_id = $request->input('employee_id');
        $year = $request->input('year');
        $month =$request->input('month');

        $employee = Employees::where('project_id', $project_id)->where('id', $employee_id)->first();
        $salaryDetails = Salaries::where('project_id', $project_id)
        ->where('employee_id', $employee_id)
        ->where('year', $year)->where('month', $month)->first();

        $paid = 0;
        $due = $employee->salary_amount;

        if ($salaryDetails) {
            $paid = $salaryDetails->paid;
            $due = $salaryDetails->due;
        }
        return response()->json([
            'employee' => $employee,
            'paid' => $paid,
            'due' => $due,
        ]);
    }

    function saveSalaryPayment(Request $request) {
        //dd($request->all());

        $project_id = $request->input('project_id');
        $employee_id = $request->input('employee_id');
        $year = $request->input('year');
        $month =$request->input('month');
        $paid_amount = $request->input('paid_amount');
        
        $employee = employees::where('id', $employee_id)->first();
        
        // insert into salaries table
        $salary = Salaries::where('project_id', $project_id)
        ->where('employee_id', $employee_id)
        ->where('year', $year)->where('month', $month)->first();

        if (!$salary) {
            $salary = new Salaries;
            $salary->project_id = $project_id;
            $salary->employee_id = $employee_id;
            $salary->year = $year;
            $salary->month = $month;
            $salary->salary = $employee->salary_amount;
            $salary->currency = 'AFN';
            $salary->paid = $paid_amount;
            $salary->due = $employee->salary_amount - $paid_amount;
            $salary->save();
        }
        $salary->project_id = $project_id;
        $salary->employee_id = $employee_id;
        $salary->year = $year;
        $salary->month = $month;
        $salary->salary = $employee->salary_amount;
        $salary->currency = 'AFN';
        $salary->paid = $salary->paid + $paid_amount;
        $salary->due = $salary->due - $paid_amount;
        $salary->save();

        // Find account with account_type 'Expense/Salary'
        $salaryAccount = Accounts::where('account_type', 'Expense/Salary')->first();
        // Find account with account_type 'Assets'
        $assetAccount = Accounts::where('account_type', 'Assets')->first();
    
        if ($salaryAccount && $assetAccount) {
            $salaryAccountId = $salaryAccount->id;
            $assetAccountId = $assetAccount->id;
    
            // Insert into transactions table
            $transaction = new Transactions;
            $transaction->project_id = $project_id;
            $transaction->account_id = $salaryAccountId; // The main account for this transaction
            $transaction->payer = null;
            $transaction->payer_id = null;
            $transaction->recipient = 'employee';
            $transaction->recipient_id = $employee_id;
            $transaction->description = 'معاش'. ' '.$employee->name;
            $transaction->save();
    
            // First entry: Expense/Salary account
            $transactionItem1 = new TransactionItems;
            $transactionItem1->transaction_id = $transaction->id;
            $transactionItem1->account_id = $salaryAccountId; // Expense/Salary account
            $transactionItem1->currency = 'AFN';
            $transactionItem1->debit = $paid_amount; // Debit the salary account
            $transactionItem1->credit = 0;
            $transactionItem1->save();
    
            // Second entry: Assets account
            $transactionItem2 = new TransactionItems;
            $transactionItem2->transaction_id = $transaction->id;
            $transactionItem2->account_id = $assetAccountId; // Assets account
            $transactionItem2->currency = 'AFN';
            $transactionItem2->debit = 0; // Reduce the asset account (credit)
            $transactionItem2->credit = $paid_amount;
            $transactionItem2->save();
    
            return response()->json([
                'paid' => $salary->paid,
                'due' => $salary->due,
            ]);
        } else {
            return response()->json(['message' => 'Account not found.'], 404);
        }
    }
}
