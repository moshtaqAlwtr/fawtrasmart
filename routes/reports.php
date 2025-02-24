<?php

use App\Http\Controllers\Reports\Customers\CustomerReportController;
use App\Http\Controllers\Reports\OrdersReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Reports\ReportsController;
use App\Http\Controllers\Reports\SalesReportsController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

require __DIR__ . '/auth.php';

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
    ],
    function () {
        Route::prefix('Reports')
            ->middleware(['auth'])
            ->group(function () {
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
        Route::prefix('ClientReport')->group(function () {
            Route::get('/', [CustomerReportController::class, 'index'])->name('ClientReport.index');
            Route::get('/debtReconstructionInv', [CustomerReportController::class, 'debtReconstructionInv'])->name('ClientReport.debtReconstructionInv');
            Route::get('/debtAgingGeneralLedger', [CustomerReportController::class, 'debtAgingGeneralLedger'])->name('ClientReport.debtAgingGeneralLedger');
            Route::get('/customerGuide', [CustomerReportController::class, 'customerGuide'])->name('ClientReport.customerGuide');
            Route::get('/customerBalances', [CustomerReportController::class, 'customerBalances'])->name('ClientReport.customerBalances');
            Route::get('/customerSales', [CustomerReportController::class, 'customerSales'])->name('ClientReport.customerSales');
            Route::get('/customerPayments', [CustomerReportController::class, 'customerPayments'])->name('ClientReport.customerPayments');
            Route::get('/customerAppointments', [CustomerReportController::class, 'customerAppointments'])->name('ClientReport.customerAppointments');
            Route::get('/customerInstallments', [CustomerReportController::class, 'customerInstallments'])->name('ClientReport.customerInstallments');
            Route::get('/customerAccountStatement', [CustomerReportController::class, 'customerAccountStatement'])->name('ClientReport.customerAccountStatement');
        });


        Route::prefix('salesReports')
            ->middleware(['auth'])
            ->group(function () {
                // تقارير الفواتير
                Route::get('/index', [SalesReportsController::class, 'index'])->name('salesReports.index');
                Route::get('/byCustomer', [SalesReportsController::class, 'byCustomer'])->name('salesReports.byCustomer');
                Route::get('/byEmployee', [SalesReportsController::class, 'byEmployee'])->name('salesReports.byEmployee');
                Route::get('/byInvoice', [SalesReportsController::class, 'byInvoice'])->name('salesReports.byInvoice');
                Route::get('/sales/by-employee/export', [SalesReportsController::class, 'exportByEmployeeToExcel'])->name('salesReports.byEmployee.export');
                Route::get('/exportByCustomerToExcel', [SalesReportsController::class, 'exportByCustomerToExcel'])->name('salesReports.exportByCustomerToExcel');
                Route::get('/sales/by-employee/export', [SalesReportsController::class, 'clientPaymentReport'])->name('salesReports.clientPaymentReport');
                Route::get('/sales-reports/export-by-product', [SalesReportsController::class, 'exportByProductToExcel'])->name('salesReports.exportByProduct');
                Route::get('/sales-reports/ProfitReportTime', [SalesReportsController::class, 'ProfitReportTime'])->name('salesReports.ProfitReportTime');
                Route::get('/employee-payment-report', [SalesReportsController::class, 'employeePaymentReport'])->name('salesReports.employeePaymentReport');
                Route::get('/payment-method-report', [SalesReportsController::class, 'paymentMethodReport'])->name('salesReports.paymentMethodReport');
                Route::get('/byItem', [SalesReportsController::class, 'byItem'])->name('salesReports.byItem');
                Route::get('/papatyment', [SalesReportsController::class, 'patyment'])->name('salesReports.patyment');
                Route::get('/reports/profits', [SalesReportsController::class, 'profits'])->name('salesReports.profits');
                Route::get('/sales-reports/profit-timeline', [SalesReportsController::class, 'profitTimeline'])
                ->name('salesReports.profitTimeline');
                Route::get('/reports/customerProfits', [SalesReportsController::class, 'customerProfits'])->name('salesReports.customerProfits');
                Route::get('/reports/employeeProfits', [SalesReportsController::class, 'employeeProfits'])->name('salesReports.employeeProfits');
                Route::get('/salaryRep', [SalesReportsController::class, 'salaryRep'])->name('salesReports.salaryRep');
                Route::get('/byProduct', [SalesReportsController::class, 'byProduct'])->name('salesReports.byProduct');


            });
    },
);
