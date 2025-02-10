<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Reports\ReportsController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

require __DIR__ . '/auth.php';

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        Route::prefix('Reports')->middleware(['auth'])->group(function () {

            Route::get('/purchases/orders', [ReportsController::class, 'purchases'])->name('reports.purchases.orders');
            Route::get('/purchases/by_supplier', [ReportsController::class, 'supplier'])->name('reports.purchases.by_supplier');
            Route::get('/purchases/supplier_directory', [ReportsController::class, 'supplierDirectory'])->name('reports.purchases.supplier_directory');
            Route::get('/purchases/by_employee', [ReportsController::class, 'employee'])->name('reports.purchases.by_employee');
            Route::get('/purchases/balances', [ReportsController::class, 'balances'])->name('reports.purchases.balances');
            Route::get('/purchases/aged', [ReportsController::class, 'aged'])->name('reports.purchases.aged');
            Route::get('/purchases/payments', [ReportsController::class, 'payments'])->name('reports.purchases.payments');
            Route::get('/purchases/suppliers_purchases', [ReportsController::class, 'suppliersPurchases'])->name('reports.purchases.suppliers_purchases');
            Route::get('/purchases/supplier_statement', [ReportsController::class, 'supplierStatement'])->name('reports.purchases.supplier_statement');
            Route::get('/purchases/daily_payments', [ReportsController::class, 'dailyPayments'])->name('reports.purchases.daily_payments');
            Route::get('/purchases/weekly_payments', [ReportsController::class, 'weeklyPayments'])->name('reports.purchases.weekly_payments');
            Route::get('/purchases/monthly_payments', [ReportsController::class, 'monthlyPayments'])->name('reports.purchases.monthly_payments');
            Route::get('/purchases/annual_payments', [ReportsController::class, 'annualPayments'])->name('reports.purchases.annual_payments');
            Route::get('/products/by_product', [ReportsController::class, 'byProduct'])->name('reports.purchases.by_product');
            Route::get('/purchases/by_supplier', [ReportsController::class, 'purchasesBySupplier'])->name('reports.purchases.by_supplier');
            Route::get('/purchases/products_by_employee', [ReportsController::class, 'productsByEmployee'])->name('reports.purchases.products_by_employee');

    });
    }
);
