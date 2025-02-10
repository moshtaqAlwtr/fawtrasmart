<?php

use App\Http\Controllers\Sitting\CurrencyRatesController;
use App\Http\Controllers\Sitting\PaymentMethodsController;
use App\Http\Controllers\Sitting\SittingAccountController;
use App\Http\Controllers\Sitting\SittingInfoController;
use App\Http\Controllers\Sitting\SMPTController;
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
                });

                Route::prefix('SittingAccount')->group(function () {
                    Route::get('/index', [SittingAccountController::class, 'index'])->name('SittingAccount.index');
                });

                Route::prefix('CurrencyRates')->group(function () {
                    Route::get('/index', [CurrencyRatesController::class, 'index'])->name('CurrencyRates.index');
                    Route::get('/create', [CurrencyRatesController::class, 'create'])->name('CurrencyRates.create');
                    Route::get('/edit/{id}', [CurrencyRatesController::class, 'edit'])->name('CurrencyRates.edit');
                });
                Route::prefix('SMPT')->group(function () {
                    Route::get('/index', [SMPTController::class, 'index'])->name('SMPT.index');
                });
                Route::prefix('PaymentMethods')->group(function () {
                    Route::get('/index', [PaymentMethodsController::class, 'index'])->name('PaymentMethods.index');
                    Route::get('/create', [PaymentMethodsController::class, 'create'])->name('PaymentMethods.create');
                });
            });
    },
);
