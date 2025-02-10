<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\POS\ReportsController;
use App\Http\Controllers\POS\SalesStartController;
use App\Http\Controllers\POS\SessionsController;
use App\Http\Controllers\POS\SettingsController;
use App\Http\Controllers\POS\DevicesController;
use App\Http\Controllers\POS\ShiftController;

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

Route::get('/search', [SalesStartController::class, 'search'])->name('sales_start.search');


Route::group(

    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath',]
    ], function(){

        Route::prefix('POS')->middleware(['auth'])->group(function () {

            # employee routes
            Route::prefix('pos_reports')->group(function () {
                Route::get('/index',[ReportsController::class,'index'])->name('pos_reports.index');
                Route::get('/Category',[ReportsController::class,'Category'])->name('pos_reports.Category');
                Route::get('/Product_Sales',[ReportsController::class,'Product'])->name('pos_reports.Product');
                Route::get('/Shift',[ReportsController::class,'Shift'])->name('pos_reports.Shift');
                Route::get('/Detailed_Shift_Transactions',[ReportsController::class,'Detailed'])->name('pos_reports.Detailed');
                Route::post('/Shift_Profitability',[ReportsController::class,'Prof'])->name('pos_reports.Shift_Profitability');
                Route::post('/CategoryProfitability',[ReportsController::class,'Cate'])->name('pos_reports.Category_Profitability');
                Route::post('/ProductProfitability',[ReportsController::class,'Prod'])->name('pos_reports.Product_Profitabilit');

            });

            # employee managing employee roles
            Route::prefix('Sales_Start')->group(function () {
                Route::get('/index',[SalesStartController::class,'index'])->name('POS.sales_start.index');
            });

            # employee shift management
            Route::prefix('Sessions')->group(function () {
                Route::get('/index',[SessionsController::class,'index'])->name('pos.sessions.index');
                Route::get('/create',[SessionsController::class,'create'])->name('sessions_shifts_management.create');
                Route::post('/store',[SessionsController::class,'store'])->name('sessions_shifts_management.store');
                Route::get('/edit/{id}',[SessionsController::class,'edit'])->name('sessions_shifts_management.edit');
                Route::post('/update/{id}',[SessionsController::class,'update'])->name('sessions_shifts_management.update');
                Route::get('/delete/{id}',[SessionsController::class,'delete'])->name('sessions_shifts_management.delete');
                Route::get('/show/{id}',[SessionsController::class,'show'])->name('sessions_shifts_management.show');
            });



            # employee routes
            Route::prefix('Settings')->group(function () {
                Route::get('/index',[SettingsController::class,'index'])->name('pos.settings.index');
                Route::get('/general',[SettingsController::class,'general'])->name('pos.settings.general');

            });
            Route::prefix('Devices')->group(function () {
                Route::get('/index',[DevicesController::class,'index'])->name('pos.settings.devices.index');
                Route::get('/Create',[DevicesController::class,'Create'])->name('pos.settings.devices.create');

            });
            Route::prefix('Shift')->group(function () {
                Route::get('/index',[ShiftController::class,'index'])->name('pos.settings.shift.index');
                Route::get('/create',[ShiftController::class,'create'])->name('pos.settings.shift.create');
            });

        });



});
