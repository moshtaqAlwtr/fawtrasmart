<?php

use App\Http\Controllers\Reports\WorkflowController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Reports\OrdersController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

require __DIR__ . '/auth.php';

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        Route::prefix('reports/orders')->group(function () {
            Route::get('/', [OrdersController::class, 'index'])->name('reports.orders.index');
            Route::get('/supply-order', [OrdersController::class, 'supplyOrder'])->name('reports.orders.supplyOrder');
            Route::get('/tagged-supply-orders', [OrdersController::class, 'taggedSupplyOrders'])->name('reports.orders.taggedSupplyOrders');
            Route::get('/supply-orders-schedule', [OrdersController::class, 'supplyOrdersSchedule'])->name('reports.orders.supplyOrdersSchedule');
            Route::get('/supply-orders-profit-summary', [OrdersController::class, 'supplyOrdersProfitSummary'])->name('reports.orders.supplyOrdersProfitSummary');
            Route::get('/supply-orders-profit-details', [OrdersController::class, 'supplyOrdersProfitDetails'])->name('reports.orders.supplyOrdersProfitDetails');
        });
    }
);
