<?php

use App\Http\Controllers\PointsAndBalances\BalanceTypeController;
use App\Http\Controllers\PointsAndBalances\ManagingBalanceConsumptionController;
use App\Http\Controllers\PointsAndBalances\MangRechargeBalancesController;
use App\Http\Controllers\PointsAndBalances\PackageManagementController;
use App\Http\Controllers\PointsAndBalances\SittingController;
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
        Route::prefix('RechargeBalances')
            ->middleware(['auth', 'role:manager'])
            ->group(function () {
                Route::prefix('MangRechargeBalances')->group(function () {
                    Route::get('/index', [MangRechargeBalancesController::class, 'index'])->name('MangRechargeBalances.index');
                    Route::get('/create', [MangRechargeBalancesController::class, 'create'])->name('MangRechargeBalances.create');
                    Route::get('/show/{id}', [MangRechargeBalancesController::class, 'show'])->name('MangRechargeBalances.show');
                    Route::get('/edit/{id}', [MangRechargeBalancesController::class, 'edit'])->name('MangRechargeBalances.edit');
                });
                Route::prefix('PackageManagement')->group(function () {
                    Route::get('/index', [PackageManagementController::class, 'index'])->name('PackageManagement.index');
                    Route::get('/create', [PackageManagementController::class, 'create'])->name('PackageManagement.create');
                    Route::get('/show/{id}', [PackageManagementController::class, 'show'])->name('PackageManagement.show');
                    Route::get('/edit/{id}', [PackageManagementController::class, 'edit'])->name('PackageManagement.edit');
                });
                Route::prefix('BalanceType')->group(function () {
                    Route::get('/index', [BalanceTypeController::class, 'index'])->name('BalanceType.index');
                    Route::get('/create', [BalanceTypeController::class, 'create'])->name('BalanceType.create');
                    Route::get('/show/{id}', [BalanceTypeController::class, 'show'])->name('BalanceType.show');
                    Route::get('/edit/{id}', [BalanceTypeController::class, 'edit'])->name('BalanceType.edit');
                });
                Route::prefix('ManagingBalanceConsumption')->group(function () {
                    Route::get('/index', [ManagingBalanceConsumptionController::class, 'index'])->name('ManagingBalanceConsumption.index');
                    Route::get('/create', [ManagingBalanceConsumptionController::class, 'create'])->name('ManagingBalanceConsumption.create');
                    Route::get('/show/{id}', [ManagingBalanceConsumptionController::class, 'show'])->name('ManagingBalanceConsumption.show');
                    Route::get('/edit/{id}', [ManagingBalanceConsumptionController::class, 'edit'])->name('ManagingBalanceConsumption.edit');
                });
                Route::prefix('Sitting')->group(function () {
                    Route::get('/index', [SittingController::class, 'index'])->name('sitting.index');
                });
            });
    },
);
