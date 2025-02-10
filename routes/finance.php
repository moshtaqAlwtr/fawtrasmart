<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Finance\ExpensesController;
use App\Http\Controllers\Finance\FinanceSettingsController;
use App\Http\Controllers\Finance\IncomesController;
use App\Http\Controllers\Finance\TreasuryController;
use App\Http\Controllers\Finance\TreasuryEmployeeController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('master');
// });


require __DIR__ . '/auth.php';

Route::group(

    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath',]
    ], function(){

        # finance routes
        Route::prefix('finance')->middleware(['auth'])->group(function () {

            #expenses routes
            Route::prefix('expenses')->group(function () {
                Route::get('/index',[ExpensesController::class,'index'])->name('expenses.index');
                Route::get('/create',[ExpensesController::class,'create'])->name('expenses.create');
                Route::post('/store',[ExpensesController::class,'store'])->name('expenses.store');
                Route::get('/show/{id}',[ExpensesController::class,'show'])->name('expenses.show');
                Route::get('/edit/{id}',[ExpensesController::class,'edit'])->name('expenses.edit');
                Route::post('/update/{id}',[ExpensesController::class,'update'])->name('expenses.update');
                Route::get('/delete/{id}',[ExpensesController::class,'delete'])->name('expenses.delete');
            });

            #incomes routes
            Route::prefix('incomes')->group(function () {
                Route::get('/index',[IncomesController::class,'index'])->name('incomes.index');
                Route::get('/create',[IncomesController::class,'create'])->name('incomes.create');
                Route::post('/store',[IncomesController::class,'store'])->name('incomes.store');
                Route::get('/show/{id}',[IncomesController::class,'show'])->name('incomes.show');
                Route::get('/edit/{id}',[IncomesController::class,'edit'])->name('incomes.edit');
                Route::post('/update/{id}',[IncomesController::class,'update'])->name('incomes.update');
                Route::get('/delete/{id}',[IncomesController::class,'delete'])->name('incomes.delete');
            });

            #treasury routes
            Route::prefix('treasury')->group(function () {
                Route::get('/index',[TreasuryController::class,'index'])->name('treasury.index');
                Route::get('/create',[TreasuryController::class,'create'])->name('treasury.create');
                Route::get('/create/account_bank',[TreasuryController::class,'create_account_bank'])->name('treasury.create_account_bank');
                Route::post('/store',[TreasuryController::class,'store'])->name('treasury.store');
                Route::post('/store/account_bank',[TreasuryController::class,'store_account_bank'])->name('treasury.store_account_bank');
                Route::get('/show/{id}',[TreasuryController::class,'show'])->name('treasury.show');
                Route::get('/edit/{id}',[TreasuryController::class,'edit'])->name('treasury.edit');
                Route::get('/edit/account_bank/{id}',[TreasuryController::class,'edit_account_bank'])->name('treasury.edit_account_bank');
                Route::post('/update/{id}',[TreasuryController::class,'update'])->name('treasury.update');
                Route::post('/update/update_account_bank/{id}',[TreasuryController::class,'update_account_bank'])->name('treasury.update_account_bank');
                Route::get('/delete/{id}',[TreasuryController::class,'delete'])->name('treasury.delete');
            });

            #finance_settings routes
            Route::prefix('finance_settings')->group(function () {
                Route::get('/index',[FinanceSettingsController::class,'index'])->name('finance_settings.index');
                Route::get('/expenses_category',[FinanceSettingsController::class,'expenses_category'])->name('finance_settings.expenses_category');
                Route::post('/expenses_category/store',[FinanceSettingsController::class,'expenses_category_store'])->name('finance_settings.expenses_category_store');
                Route::post('/expenses_category/update/{id}',[FinanceSettingsController::class,'expenses_category_update'])->name('finance_settings.expenses_category_update');
                Route::get('/expenses_category/delete/{id}',[FinanceSettingsController::class,'expenses_category_delete'])->name('finance_settings.expenses_category_delete');

                #receipt_category
                Route::get('/receipt_category',[FinanceSettingsController::class,'receipt_category'])->name('finance_settings.receipt_category');
                Route::post('/receipt_category/store',[FinanceSettingsController::class,'receipt_category_store'])->name('finance_settings.receipt_category_store');
                Route::post('/receipt_category/update/{id}',[FinanceSettingsController::class,'receipt_category_update'])->name('finance_settings.receipt_category_update');
                Route::get('/receipt_category/delete/{id}',[FinanceSettingsController::class,'receipt_category_delete'])->name('finance_settings.receipt_category_delete');

                #treasury_employee
                Route::get('/treasury_employee',[TreasuryEmployeeController::class,'index'])->name('finance_settings.treasury_employee');
                Route::get('/treasury_employee/create',[TreasuryEmployeeController::class,'create'])->name('treasury_employee.create');
                Route::get('/treasury_employee/delete/{id}',[TreasuryEmployeeController::class,'delete'])->name('treasury_employee.delete');
                Route::get('/treasury_employee/edit/{id}',[TreasuryEmployeeController::class,'edit'])->name('treasury_employee.edit');
                Route::post('/treasury_employee/update/{id}',[TreasuryEmployeeController::class,'update'])->name('treasury_employee.update');
                Route::post('/treasury_employee/store',[TreasuryEmployeeController::class,'store'])->name('treasury_employee.store');

            });

        });



});
