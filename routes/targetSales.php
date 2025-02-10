<?php
use App\Http\Controllers\TargetSales\CommissionRulesController;
use App\Http\Controllers\TargetSales\SalesCommissionController;
use App\Http\Controllers\TargetSales\SalesPeriodsController;
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
        Route::prefix('TargetSales')
            ->middleware(['auth', 'role:manager'])
            ->group(function () {
                Route::prefix('CommissionRules')->group(function () {
                    Route::get('/index', [CommissionRulesController::class, 'index'])->name('CommissionRules.index');
                    Route::get('/create', [CommissionRulesController::class, 'create'])->name('CommissionRules.create');
                    Route::get('/show/{id}', [CommissionRulesController::class, 'show'])->name('CommissionRules.show');
                    Route::get('/edit/{id}', [CommissionRulesController::class, 'edit'])->name('CommissionRules.edit');
                });
                Route::prefix('SalesPeriods')->group(function () {
                    Route::get('/index', [SalesPeriodsController::class, 'index'])->name('SalesPeriods.index');
                    Route::get('/create', [SalesPeriodsController::class, 'create'])->name('SalesPeriods.create');
                    Route::get('/show/{id}', [SalesPeriodsController::class, 'show'])->name('SalesPeriods.show');
                    Route::get('/edit/{id}', [SalesPeriodsController::class, 'edit'])->name('SalesPeriods.edit');
                });


                Route::prefix('SalesCommission')->group(function () {
                    Route::get('/index', [SalesCommissionController::class, 'index'])->name('SalesCommission.index');

                    Route::get('/show/{id}', [SalesCommissionController::class, 'show'])->name('SalesCommission.show');
                });
            });
    },
);
