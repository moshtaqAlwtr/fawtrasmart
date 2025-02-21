<?php

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
        Route::prefix('reports/orders')->group(function () {
            Route::get('/', [OrdersReportController::class, 'index'])->name('reports.orders.index');
            Route::get('/supply-order', [OrdersReportController::class, 'supplyOrder'])->name('reports.orders.supplyOrder');
            Route::get('/tagged-supply-orders', [OrdersReportController::class, 'taggedSupplyOrders'])->name('reports.orders.taggedSupplyOrders');
            Route::get('/supply-orders-schedule', [OrdersReportController::class, 'supplyOrdersSchedule'])->name('reports.orders.supplyOrdersSchedule');
            Route::get('/supply-orders-profit-summary', [OrdersReportController::class, 'supplyOrdersProfitSummary'])->name('reports.orders.supplyOrdersProfitSummary');
            Route::get('/supply-orders-profit-details', [OrdersReportController::class, 'supplyOrdersProfitDetails'])->name('reports.orders.supplyOrdersProfitDetails');
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
                Route::get('/employee-payment-report', [SalesReportsController::class, 'employeePaymentReport'])->name('salesReports.employeePaymentReport');
                Route::get('/payment-method-report', [SalesReportsController::class, 'paymentMethodReport'])->name('salesReports.paymentMethodReport');
                Route::get('/papatyment', [SalesReportsController::class, 'patyment'])->name('salesReports.patyment');
                Route::get('/reports/profits', [SalesReportsController::class, 'profits'])->name('salesReports.profits');
                Route::get('/sales-reports/profit-timeline', [SalesReportsController::class, 'profitTimeline'])
                ->name('salesReports.profitTimeline');
                Route::get('/reports/customerProfits', [SalesReportsController::class, 'customerProfits'])->name('salesReports.customerProfits');
                Route::get('/reports/employeeProfits', [SalesReportsController::class, 'employeeProfits'])->name('salesReports.employeeProfits');
                Route::get('/salaryRep', [SalesReportsController::class, 'salaryRep'])->name('salesReports.salaryRep');
                Route::get('/byProduct', [SalesReportsController::class, 'byProduct'])->name('salesReports.byProduct');
                Route::get('/Weekly_by_Product', [SalesReportsController::class, 'WeeklybyProduct'])->name('reports.sals.Weekly_by_Product');
                Route::get('/Monthly_by_Product', [SalesReportsController::class, 'MonthlybyProduct'])->name('reports.sals.Monthly_by_Product');
                Route::get('/Annual_by_Product', [SalesReportsController::class, 'AnnualbyProduct'])->name('reports.sals.Annual_by_Product');
                Route::get('/D_Sales', [SalesReportsController::class, 'Dsales'])->name('reports.sals.D_Sales');
                Route::get('/W_Sales', [SalesReportsController::class, 'Wsales'])->name('reports.sals.W_Sales');
                Route::get('/M_Sales', [SalesReportsController::class, 'Msales'])->name('reports.sals.M_Sales');
                Route::get('/A_Sales', [SalesReportsController::class, 'Asales'])->name('reports.sals.A_Sales');
                Route::get('/Payments_by_Customer', [SalesReportsController::class, 'byCust'])->name('reports.sals.Payments_by_Customer');
                Route::get('/Payments_by_Employee', [SalesReportsController::class, 'byembl'])->name('reports.sals.Payments_by_Employee');
                Route::get('/Payments_by_Payment_Method', [SalesReportsController::class, 'bypay'])->name('reports.sals.Payments_by_Payment_Method');
                Route::get('/Daily_Payments', [SalesReportsController::class, 'DailyPayments'])->name('reports.sals.Daily_Payments');
                Route::get('/Weekly_Payments', [SalesReportsController::class, 'WeeklyPayments'])->name('reports.sals.Weekly_Payments');
                Route::get('/Monthly_Payments', [SalesReportsController::class, 'MonthlyPayments'])->name('reports.sals.Monthly_Payments');
                Route::get('/Annual_Payments', [SalesReportsController::class, 'AnnualPayments'])->name('reports.sals.Annual_Payments');
                Route::get('/products_profit', [SalesReportsController::class, 'productsprofit'])->name('reports.sals.products_profit');
                Route::get('/Customer_Profit', [SalesReportsController::class, 'CustomerProfit'])->name('reports.sals.Customer_Profit');
                Route::get('/Employee_Profit', [SalesReportsController::class, 'EmployeeProfit'])->name('reports.sals.Employee_Profit');
                Route::get('/Manager_Profit', [SalesReportsController::class, 'ManagerProfit'])->name('reports.sals.Manager_Profit');
                Route::get('/Daily_Profits', [SalesReportsController::class, 'DailyProfits'])->name('reports.sals.Daily_Profits');
                Route::get('/Weekly_Profits', [SalesReportsController::class, 'WeeklyProfits'])->name('reports.sals.Weekly_Profits');
                Route::get('/Annual_Profits', [SalesReportsController::class, 'AnnualProfits'])->name('reports.sals.Annual_Profits');
                Route::get('/Item_Sales_By_Item', [SalesReportsController::class, 'ItemSalesByItem'])->name('reports.sals.Sales_By_Item');
                Route::get('/Item_Sales_By_Category', [SalesReportsController::class, 'ItemSalesByCategory'])->name('reports.sals.Sales_By_Category');
                Route::get('/Item_Sales_By_Brand', [SalesReportsController::class, 'ItemSalesByBrand'])->name('reports.sals.Sales_By_Brand');
                Route::get('/Item_Sales_By_Employee', [SalesReportsController::class, 'ItemSalesByEmployee'])->name('reports.sals.Sales_By_Employee');
                Route::get('/Item_Sales_By_SalesRep', [SalesReportsController::class, 'ItemSalesBySalesRep'])->name('reports.sals.Sales_By_SalesRep');
                Route::get('/Item_Sales_By_Customer', [SalesReportsController::class, 'ItemSalesByCustomer'])->name('reports.sals.Sales_By_Customer');
            });
    },
);
