<?php

use App\Http\Controllers\Manufacturing\SettingsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Manufacturing\BOMController;
use App\Http\Controllers\Manufacturing\OrdersController;
use App\Http\Controllers\Manufacturing\IndirectCostsController;
use App\Http\Controllers\Manufacturing\WorkstationsController;
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

Route::get('/api/workstations/{id}', [BOMController::class, 'get_cost_total']);

Route::group(

    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath',]
    ], function(){

        Route::prefix('Manufacturing')->middleware(['auth'])->group(function () {

            # قوائم مواد الأنتاج
            Route::prefix('BOM')->group(function () {
                Route::get('/index',[BOMController::class,'index'])->name('BOM.index');
                Route::get('/create',[BOMController::class,'create'])->name('BOM.create');
                Route::get('/edit/{id}',[BOMController::class,'edit'])->name('Bom.edit');
                Route::get('/show/{id}',[BOMController::class,'show'])->name('Bom.show');
                Route::post('/store',[BOMController::class,'store'])->name('Bom.store');
                Route::post('/update/{id}',[BOMController::class,'update'])->name('Bom.update');
                Route::post('/updatePassword/{id}',[BOMController::class,'updatePassword'])->name('Bom.updatePassword');
                Route::get('/delete/{id}',[BOMController::class,'destroy'])->name('Bom.delete');
                Route::get('/login/to/{id}', [BOMController::class, 'login_to'])->name('Bom.login_to');
                Route::get('/export/view',[BOMController::class,'export_view'])->name('Bom.export_view');
                Route::post('/export',[BOMController::class,'export'])->name('Bom.export');
            });

            # أوامر التصنيع
            Route::prefix('Orders')->group(function () {
                Route::get('/index',[OrdersController::class,'index'])->name('manufacturing.orders.index');
                Route::get('/create',[OrdersController::class,'create'])->name('manufacturing.orders.create');
                Route::post('/store',[OrdersController::class,'store'])->name('manufacturing.orders.store');
                Route::get('/edit/{id}',[OrdersController::class,'edit'])->name('manufacturing.orders.edit');
                Route::get('/show/{id}',[OrdersController::class,'show'])->name('manufacturing.orders.show');
                Route::post('/update/{id}',[OrdersController::class,'update'])->name('manufacturing.orders.update');
                Route::get('/delete/{id}',[OrdersController::class,'delete'])->name('manufacturing.orders.delete');
            });

            # التكاليف غير المباشرة
            Route::prefix('IndirectCosts')->group(function () {
                Route::get('/index',[IndirectCostsController::class,'index'])->name('manufacturing.indirectcosts.index');
                Route::get('/create',[IndirectCostsController::class,'create'])->name('manufacturing.indirectcosts.create');
                Route::post('/store',[IndirectCostsController::class,'store'])->name('manufacturing.indirectcosts.store');
                Route::get('/edit/{id}',[IndirectCostsController::class,'edit'])->name('manufacturing.indirectcosts.edit');
                Route::post('/update/{id}',[IndirectCostsController::class,'update'])->name('manufacturing.indirectcosts.update');
                Route::get('/delete/{id}',[IndirectCostsController::class,'destroy'])->name('manufacturing.indirectcosts.delete');
                Route::get('/show/{id}',[IndirectCostsController::class,'show'])->name('manufacturing.indirectcosts.show');
            });

            # محطات العمل
            Route::prefix('Workstations')->group(function () {
                Route::get('/index',[WorkstationsController::class,'index'])->name('manufacturing.workstations.index');
                Route::get('/create',[WorkstationsController::class,'create'])->name('manufacturing.workstations.create');
                Route::post('/store',[WorkstationsController::class,'store'])->name('manufacturing.workstations.store');
                Route::get('/edit/{id}',[WorkstationsController::class,'edit'])->name('manufacturing.workstations.edit');
                Route::post('/update/{id}',[WorkstationsController::class,'update'])->name('manufacturing.workstations.update');
                Route::get('/delete/{id}',[WorkstationsController::class,'destroy'])->name('manufacturing.workstations.delete');
                Route::get('/show/{id}',[WorkstationsController::class,'show'])->name('manufacturing.workstations.show');
            });
                # الأعدادات
                Route::prefix('Settings')->group(function () {
                Route::get('/index',[SettingsController::class,'index'])->name('Manufacturing.settings.index');
                Route::get('/General',[SettingsController::class,'General'])->name('manufacturing.settings.general');
                Route::post('general_settings/update',[SettingsController::class,'general_settings'])->name('Manufacturing.general_settings.update');
                Route::get('/Manual',[SettingsController::class,'Manual'])->name('Manufacturing.settings.Manual');
                Route::post('order_manual_status/update',[SettingsController::class,'order_manual_status'])->name('Manufacturing.order_manual_status.update');

                # الأعدادات مسارات الأنتاج
                Route::prefix('Paths')->group(function () {
                    Route::get('/index',[SettingsController::class,'paths_index'])->name('manufacturing.paths.index');
                    Route::get('/create',[SettingsController::class,'paths_create'])->name('manufacturing.paths.create');
                    Route::post('/store',[SettingsController::class,'paths_store'])->name('manufacturing.paths.store');
                    Route::get('/edit/{id}',[SettingsController::class,'paths_edit'])->name('manufacturing.paths.edit');
                    Route::post('/update/{id}',[SettingsController::class,'paths_update'])->name('manufacturing.paths.update');
                    Route::get('/delete/{id}',[SettingsController::class,'paths_destroy'])->name('manufacturing.paths.delete');
                    Route::get('/show/{id}',[SettingsController::class,'paths_show'])->name('manufacturing.paths.show');
                });
            });

        });



});
