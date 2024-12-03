<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LocaleController;
use App\http\Controllers\AccountsController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\EmployeesController;


Route::post('/locale', LocaleController::class)->name('locale.change');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Apartments & Shops
Route::middleware('auth')->group(function () {
    //Dashboard
    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

});

//Finance
Route::middleware('auth')->group(function () {

    
    //expenses page
    Route::get('expenses', [ExpensesController::class, 'expenses'])->name('expenses');
    Route::get('saveExpense', [ExpensesController::class, 'saveExpense'])->name('saveExpense');

    //Employees
    Route::get('employees', [EmployeesController::class, 'employees'])->name('employees');
    Route::get('saveEmployee', [EmployeesController::class, 'saveEmployee'])->name('saveEmployee');

    //Salaries
    Route::get('salaries', [EmployeesController::class, 'salaries'])->name('salaries');
    //get all the employees of the selected project
    Route::get('getEmployees', [EmployeesController::class, 'getEmployees'])->name('getEmployees');
    // get Employee salary details
    Route::get('getEmployeeDetails', [EmployeesController::class, 'getEmployeeDetails'])->name('getEmployeeDetails');
    // Save salary payment
    Route::get('saveSalaryPayment', [EmployeesController::class, 'saveSalaryPayment'])->name('saveSalaryPayment');

    
});

//Reports
Route::middleware('auth')->group(function () {
    
    //Accounts' ledger Details Report
    Route::get('accountsLedger' ,[ReportsController::class, 'accountsLedger'])->name('accountsLedger');
    Route::get('getAccountLedger', [ReportsController::class, 'getAccountLedger'])->name('getAccountLedger');

    // Account ledger Summary Report
    Route::get('getAccountSummary', [ReportsController::class, 'getAccountSummary'])->name('getAccountSummary');
    Route::get('getAccountSummaryPDF', [ReportsController::class, 'getAccountSummaryPDF'])->name('getAccountSummaryPDF');


    //Entities Report
    Route::get('apartmentsAndShopsReport' ,[ReportsController::class, 'apartmentsAndShopsReport'])->name('apartmentsAndShopsReport');
    Route::get('getProjectDetails' ,[ReportsController::class, 'getProjectDetails'])->name('getProjectDetails');

    //Print Entities Invoices
    Route::get('printEntityInvoices' ,[ReportsController::class, 'printEntityInvoices'])->name('printEntityInvoices');
    Route::get('printEntityBills' ,[ReportsController::class, 'printEntityBills'])->name('printEntityBills');

    //Salaries Report
    Route::get('salariesReport', [ReportsController::class, 'salariesReport'])->name('salariesReport');
    //print salaries report
    Route::get('printSalariesReport', [ReportsController::class, 'printSalariesReport'])->name('printSalariesReport');
});
require __DIR__.'/auth.php';
