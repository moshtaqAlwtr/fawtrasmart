<?php


use App\Http\Controllers\Stock\StorePermitsManagementController;
use App\Http\Controllers\SupplyOrders\SupplyOrdersController;
use App\Http\Controllers\SupplyOrders\SupplySittingController;
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

    Route::prefix('Supply')->middleware(['auth', 'role:manager'])->group(function () {

        #questions routes
        Route::prefix('SupplyOrders')->group(function () {
            Route::get('/index',[SupplyOrdersController::class,'index'])->name('SupplyOrders.index');
            Route::get('/create',[SupplyOrdersController::class,'create'])->name('SupplyOrders.create');
            Route::get('/show/{id}',[SupplyOrdersController::class,'show'])->name('SupplyOrders.show');
            Route::get('/edit/{id}',[SupplyOrdersController::class,'edit'])->name('SupplyOrders.edit');

            Route::get('/edit_status',[SupplyOrdersController::class,'edit_status'])->name('SupplyOrders.edit_status');
            Route::post('/store',[SupplyOrdersController::class,'store'])->name('SupplyOrders.store');
            Route::put('/update/{id}',[SupplyOrdersController::class,'update'])->name('SupplyOrders.update');
            Route::delete('/destroy/{id}',[SupplyOrdersController::class,'destroy'])->name('SupplyOrders.destroy');



        });
        Route::prefix('SupplySittings')->group(function () {
            Route::get('/index',[SupplySittingController::class,'index'])->name('SupplySittings.index');
            Route::get('/edit_procedures',[SupplySittingController::class,'edit_procedures'])->name('SupplySittings.edit_procedures');
            Route::get('/edit_supply_number',[SupplySittingController::class,'edit_supply_number'])->name('SupplySittings.edit_supply_number');
            Route::get('/sitting_serial_number',[SupplySittingController::class,'sitting_serial_number'])->name('SupplySittings.sitting_serial_number');




        });



    });

});

