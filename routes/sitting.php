<?php

use App\Http\Controllers\Appointments\ApplicationManagementController as AppointmentsApplicationManagementController;
use App\Http\Controllers\Sitting\ApplicationManagementController;
use App\Http\Controllers\Sitting\CurrencyRatesController;
use App\Http\Controllers\Sitting\PaymentMethodsController;
use App\Http\Controllers\Sitting\SittingAccountController;
use App\Http\Controllers\Sitting\SittingInfoController;
use App\Http\Controllers\Sitting\SMPTController;
use App\Http\Controllers\Sitting\SmsController;
use App\Http\Controllers\Sitting\TaxSittingController;
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
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
    ],
    function () {
        Route::prefix('Sitting')
            ->middleware(['auth', 'role:manager'])
            ->group(function () {
                Route::prefix('accountInfo')->group(function () {
                    Route::get('/index', [SittingInfoController::class, 'index'])->name('AccountInfo.index');
                    Route::get('/create', [SittingInfoController::class, 'create'])->name('AccountInfo.create');
                    Route::post('/store', [SittingInfoController::class, 'store'])->name('AccountInfo.store');
                    Route::get('/backup', [SittingInfoController::class, 'backup'])->name('AccountInfo.backup'); 
                    Route::post('/backup/download', [SittingInfoController::class, 'download'])->name('AccountInfo.download');  
                  
                    
                });

                Route::prefix('SittingAccount')->group(function () {
                    Route::get('/index', [SittingAccountController::class, 'index'])->name('SittingAccount.index');
                    Route::post('/create', [SittingAccountController::class, 'store'])->name('SittingAccount.store');
                    Route::post('/Change_email', [SittingAccountController::class, 'Change_email'])->name('SittingAccount.Change_email');
                    Route::post('/change_password', [SittingAccountController::class, 'change_password'])->name('SittingAccount.change_password');
                    Route::get('/backgroundColor', [SittingAccountController::class, 'color'])->name('AccountInfo.backgroundColor');
                    Route::post('/updateColor', [SittingAccountController::class, 'updateColor'])->name('AccountInfo.updateColor');  

                    
                });

                Route::prefix('CurrencyRates')->group(function () {
                    Route::get('/index', [CurrencyRatesController::class, 'index'])->name('CurrencyRates.index');
                    Route::get('/create', [CurrencyRatesController::class, 'create'])->name('CurrencyRates.create');
                    Route::get('/edit/{id}', [CurrencyRatesController::class, 'edit'])->name('CurrencyRates.edit');
                });
                Route::prefix('SMPT')->group(function () {
                    Route::get('/index', [SMPTController::class, 'index'])->name('SMPT.index');
                    Route::get('/sendTestMail', [SMPTController::class, 'sendTestMail'])->name('SMPT.sendTestMail');
                    
                });
                Route::prefix('PaymentMethods')->group(function () {
                    Route::get('/index', [PaymentMethodsController::class, 'index'])->name('PaymentMethods.index');
                    Route::get('/create', [PaymentMethodsController::class, 'create'])->name('PaymentMethods.create');
                    Route::post('/store', [PaymentMethodsController::class, 'store'])->name('PaymentMethods.store');
                    Route::put('/payments/update-status', [PaymentMethodsController::class, 'updatePaymentStatus'])->name('update.payment.status');
                });
                Route::prefix('ApplicationManagement')->group(function () {
                    Route::get('/index', [ApplicationManagementController::class, 'index'])->name('Application.index');
                    Route::post('/update', [ApplicationManagementController::class, 'update'])->name('Application.update');
                });
                Route::prefix('TaxSitting')->group(function () {
                    Route::get('/index', [TaxSittingController::class, 'index'])->name('TaxSitting.index');
                    Route::post('/update', [TaxSittingController::class, 'update'])->name('TaxSitting.update');
                });
                Route::prefix('Sms')->group(function () {
                    Route::get('/index', [SmsController::class, 'index'])->name('Sms.index');
                 
                });
                
                
                
            });
    },
);
