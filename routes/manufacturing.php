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

// Route::get('/', function () {
//     return view('master');
// });

require __DIR__ . '/auth.php';


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
                Route::get('/delete/{id}',[BOMController::class,'delete'])->name('Bom.delete');
                Route::get('/login/to/{id}', [BOMController::class, 'login_to'])->name('Bom.login_to');
                Route::get('/export/view',[BOMController::class,'export_view'])->name('Bom.export_view');
                Route::post('/export',[BOMController::class,'export'])->name('Bom.export');
            });

            # أوامر التصنيع
            Route::prefix('Orders')->group(function () {
                Route::get('/index',[OrdersController::class,'index'])->name('manufacturing.orders.index');
                Route::get('/create',[OrdersController::class,'create'])->name('manufacturing.orders.create');
                Route::post('/store',[OrdersController::class,'store'])->name('Orders_managing_employee_roles.store');
                Route::get('/edit/{id}',[OrdersController::class,'edit'])->name('Orders_managing_employee_roles.edit');
                Route::post('/update/{id}',[OrdersController::class,'update'])->name('Orders_managing_employee_roles.update');
                Route::get('/delete/{id}',[OrdersController::class,'delete'])->name('Orders_managing_employee_roles.delete');
            });

            # التكاليف غير المباشرة
            Route::prefix('IndirectCosts')->group(function () {
                Route::get('/index',[IndirectCostsController::class,'index'])->name('manufacturing.indirectcosts.index');
                Route::get('/create',[IndirectCostsController::class,'create'])->name('manufacturing.indirectcosts.create');
                Route::post('/store',[IndirectCostsController::class,'store'])->name('IndirectCosts_shift_management.store');
                Route::get('/edit/{id}',[IndirectCostsController::class,'edit'])->name('IndirectCosts_shift_management.edit');
                Route::post('/update/{id}',[IndirectCostsController::class,'update'])->name('IndirectCosts_shift_management.update');
                Route::get('/delete/{id}',[IndirectCostsController::class,'delete'])->name('IndirectCosts_shift_management.delete');
                Route::get('/show/{id}',[IndirectCostsController::class,'show'])->name('IndirectCosts_shift_management.show');
            });



            # محطات العمل
            Route::prefix('Workstations')->group(function () {
                Route::get('/index',[WorkstationsController::class,'index'])->name('manufacturing.workstations.index');
                Route::get('/create',[WorkstationsController::class,'create'])->name('manufacturing.workstations.create');
                Route::get('/add_shift',[WorkstationsController::class,'add_shift'])->name('add_shift');
                Route::get('/employee_role_management/add_new_role',[WorkstationsController::class,'add_new_role'])->name('employee.employee_role_management.add_new_role');
            });
                  # الأعدادات
                  Route::prefix('Settings')->group(function () {
                    Route::get('/index',[SettingsController::class,'index'])->name('Manufacturing.settings.index');
                    Route::get('/General',[SettingsController::class,'General'])->name('Manufacturing.settings.General');
                    Route::get('/Manual',[SettingsController::class,'Manual'])->name('Manufacturing.settings.Manual');
                });
                     # الأعدادات مسارات الأنتاج
                     Route::prefix('Settings\Paths')->group(function () {
                        Route::get('/index',[SettingsController::class,'Paths'])->name('Manufacturing.settings.Paths.index');
                        Route::get('/create',[SettingsController::class,'Machines'])->name('Manufacturing.settings.Paths.create');
                    });

        });



});
