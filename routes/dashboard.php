<?php

use App\Http\Controllers\Dashboard\DashboardSalesController;
use Illuminate\Support\Facades\Route;
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

require __DIR__ . '/auth.php';

Route::group(

    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath','check.branch']
    ], function(){


        Route::get('', function () {
            return view('dashboard.sales.index');
        })->middleware(['auth']);

        Route::prefix('dashboard')->middleware(['auth'])->group(function () {

            #questions routes
            Route::prefix('sales')->group(function () {
                Route::get('/index',[DashboardSalesController::class,'index'])->name('dashboard_sales.index');
            });

        });

});


