<?php

use App\Http\Controllers\Reports\Customers\CustomerReportController;
use App\Http\Controllers\Reports\GeneralAccountsController;
use App\Http\Controllers\Reports\Inventory\InventoryReportController;
use App\Http\Controllers\Reports\OrdersReportController;
use App\Http\Controllers\Reports\PurchasesReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Reports\ReportsController;
use App\Http\Controllers\Reports\SalesReportsController;
use App\Models\PurchaseQuotation;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

require __DIR__ . '/auth.php';

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath','check.branch'],
    ],
    function () {
        Route::prefix('Reports')
            ->middleware(['auth'])
            ->group(function () {
                Route::get('/index', [PurchasesReportController::class, 'index'])->name('ReportsPurchases.index');


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
            Route::get('/invoices/month/{month}', [CustomerReportController::class, 'getInvoicesByMonth']);
            Route::get('/customerAccountStatement', [CustomerReportController::class, 'customerAccountStatement'])->name('ClientReport.customerAccountStatement');
            Route::get('/rechargeBalancesReport', [CustomerReportController::class, 'rechargeBalancesReport'])->name('ClientReport.rechargeBalancesReport');
            Route::get('/BalancesClient', [CustomerReportController::class, 'BalancesClient'])->name('ClientReport.BalancesClient');

        });
        Route::prefix('ReportsPurchases')->group(function () {

            Route::get('/', [PurchasesReportController::class, 'index'])->name('ReportsPurchases.index');
            Route::get('/bySupplier', [PurchasesReportController::class, 'bySupplier'])->name('ReportsPurchases.bySupplier');
            Route::get('/purchaseByEmployee', [PurchasesReportController::class, 'purchaseByEmployee'])->name('ReportsPurchases.purchaseByEmployee');
            Route::get('/SuppliersDirectory', [PurchasesReportController::class, 'SuppliersDirectory'])->name('ReportsPurchases.SuppliersDirectory');
            Route::get('/balnceSuppliers', [PurchasesReportController::class, 'balnceSuppliers'])->name('ReportsPurchases.balnceSuppliers');
            Route::get('/purchaseSupplier', [PurchasesReportController::class, 'purchaseSupplier'])->name('ReportsPurchases.purchaseSupplier');
            Route::get('/paymentPurchases', [PurchasesReportController::class, 'paymentPurchases'])->name('ReportsPurchases.paymentPurchases');
            Route::get('/prodectPurchases', [PurchasesReportController::class, 'prodectPurchases'])->name('ReportsPurchases.prodectPurchases');
            Route::get('/supplierPurchases', [PurchasesReportController::class, 'supplierPurchases'])->name('ReportsPurchases.supplierPurchases');
            Route::get('/employeePurchases', [PurchasesReportController::class, 'employeePurchases'])->name('ReportsPurchases.employeePurchases');
            Route::get('/supplierPayments', [PurchasesReportController::class, 'supplierPayments'])->name('ReportsPurchases.supplierPayments');

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
            Route::prefix('StorHouseReport')->group(function () {
                Route::get('/', [InventoryReportController::class, 'index'])->name('StorHouseReport.index');
                Route::get('/inventorySheet', [InventoryReportController::class,'inventorySheet'])->name('StorHouseReport.inventorySheet');
                Route::get('/summaryInventory', [InventoryReportController::class,'summaryInventory'])->name('StorHouseReport.summaryInventory');
                Route::get('/detailedMovementInventory', [InventoryReportController::class,'detailedMovementInventory'])->name('StorHouseReport.detailedMovementInventory');
                Route::get('/valueInventory', [InventoryReportController::class,'valueInventory'])->name('StorHouseReport.valueInventory');
                Route::get('/inventoryBlance', [InventoryReportController::class,'inventoryBlance'])->name('StorHouseReport.inventoryBlance');
                Route::get('/trialBalance', [InventoryReportController::class,'trialBalance'])->name('StorHouseReport.trialBalance');
                Route::get('/Inventory_mov_det_product', [InventoryReportController::class,'Inventory_mov_det_product'])->name('StorHouseReport.Inventory_mov_det_product');
            });

    },
    Route::prefix('GeneralAccountReports')->group(function () {

        Route::get('/', [GeneralAccountsController::class, 'index'])->name('GeneralAccountReports.index');
        Route::get('/taxReport', [GeneralAccountsController::class, 'taxReport'])->name('GeneralAccountReports.taxReport');
        Route::get('/taxDeclaration', [GeneralAccountsController::class, 'taxDeclaration'])->name('GeneralAccountReports.taxDeclaration');
        Route::get('/incomeStatement', [GeneralAccountsController::class, 'incomeStatement'])->name('GeneralAccountReports.incomeStatement');

        Route::get('/splitExpensesByCategory', [GeneralAccountsController::class, 'splitExpensesByCategory'])->name('GeneralAccountReports.splitExpensesByCategory');
        Route::get('/splitExpensesBySeller', [GeneralAccountsController::class, 'splitExpensesBySeller'])->name('GeneralAccountReports.splitExpensesBySeller');
        Route::get('/splitExpensesByEmployee', [GeneralAccountsController::class, 'splitExpensesByEmployee'])->name('GeneralAccountReports.splitExpensesByEmployee');
        Route::get('/splitExpensesByClient', [GeneralAccountsController::class, 'splitExpensesByClient'])->name('GeneralAccountReports.splitExpensesByClient');
        Route::get('/splitExpensesByTimePeriod', [GeneralAccountsController::class, 'splitExpensesByTimePeriod'])->name('GeneralAccountReports.splitExpensesByTimePeriod');
        Route::get('/ReceiptByCategory', [GeneralAccountsController::class, 'ReceiptByCategory'])->name('GeneralAccountReports.ReceiptByCategory');
        Route::get('/ReceiptBySeller', [GeneralAccountsController::class, 'ReceiptBySeller'])->name('GeneralAccountReports.ReceiptBySeller');
        Route::get('/ReceiptByEmployee', [GeneralAccountsController::class, 'ReceiptByEmployee'])->name('GeneralAccountReports.ReceiptByEmployee');
        Route::get('/ReceiptByClient', [GeneralAccountsController::class, 'ReceiptByClient'])->name('GeneralAccountReports.ReceiptByClient');
        Route::get('/ReceiptByTimePeriod', [GeneralAccountsController::class, 'ReceiptByTimePeriod'])->name('GeneralAccountReports.ReceiptByTimePeriod');
        Route::get('/trialBalance', [GeneralAccountsController::class, 'trialBalance'])->name('GeneralAccountReports.trialBalance');
        Route::get('/accountBalanceReview', [GeneralAccountsController::class, 'accountBalanceReview'])->name('GeneralAccountReports.accountBalanceReview');
        Route::get('/generalLedger', [GeneralAccountsController::class, 'generalLedger'])->name('GeneralAccountReports.generalLedger');
        Route::get('/CostCentersReport', [GeneralAccountsController::class, 'CostCentersReport'])->name('GeneralAccountReports.CostCentersReport');
        Route::get('/ReportJournal', [GeneralAccountsController::class, 'ReportJournal'])->name('GeneralAccountReports.ReportJournal');
        Route::get('/ChartOfAccounts', [GeneralAccountsController::class, 'ChartOfAccounts'])->name('GeneralAccountReports.ChartOfAccounts');
        Route::get('/BalanceSheet', [GeneralAccountsController::class, 'BalanceSheet'])->name('GeneralAccountReports.BalanceSheet');

    })


);
