<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Reports\GeneralAccountsController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

require __DIR__ . '/auth.php';

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath','check.branch']
    ],
    function () {
        Route::prefix('general_accounts')->middleware(['auth'])->group(function () {
            // صفحة الحسابات العامة
            Route::get('/index', [GeneralAccountsController::class, 'index'])->name('reports.general_accounts.index');

            // تقارير الضرائب
            Route::get('/taxReport', [GeneralAccountsController::class, 'taxReport'])->name('reports.general_accounts.Tax_Report');
            Route::get('/taxDeclaration', [GeneralAccountsController::class, 'taxDeclaration'])->name('reports.general_accounts.Tax_Declaration');

            // تقارير قائمة الدخل
            Route::get('/incomeStatement', [GeneralAccountsController::class, 'incomeStatement'])->name('reports.general_accounts.income_Statement');

            // تقارير الميزانية العمومية
            Route::get('/balanceSheet', [GeneralAccountsController::class, 'balanceSheet'])->name('reports.general_accounts.Balance_Sheet');

            // تقارير الربح والخسارة
            Route::get('/profitLoss', [GeneralAccountsController::class, 'profitLoss'])->name('reports.general_accounts.Profit_Loss');

            // تقارير الحركات المالية
            Route::get('/financialTransactions', [GeneralAccountsController::class, 'financialTransactions'])->name('reports.general_accounts.Financial_Transactions');

            // تقارير التدفقات النقدية
            Route::get('/cashFlowReport', [GeneralAccountsController::class, 'cashFlowReport'])->name('reports.general_accounts.Cash_Flow_Report');

            // تقارير الأصول
            Route::get('/assets', [GeneralAccountsController::class, 'assets'])->name('reports.general_accounts.Assets');

            // تقارير ميزان المراجعة
            Route::get('/trialBalanceSummaryAndBalancesReport', [GeneralAccountsController::class, 'trialBalanceSummaryAndBalancesReport'])->name('reports.general_accounts.Trial_Balance_Summary_and_Balances_Report');
            Route::get('/trialBalanceAccountReport', [GeneralAccountsController::class, 'trialBalanceAccountReport'])->name('reports.general_accounts.Trial_Balance_Account_Report');
            Route::get('/trialBalanceBalancesReport', [GeneralAccountsController::class, 'trialBalanceBalancesReport'])->name('reports.general_accounts.Trial_Balance_Balances_Report');

            // تقارير حسابات الأستاذ
            Route::get('/generalLedger', [GeneralAccountsController::class, 'generalLedger'])->name('reports.general_accounts.General_Ledger');

            // تقارير مراكز التكلفة
            Route::get('/costCenters', [GeneralAccountsController::class, 'costCenters'])->name('reports.general_accounts.Cost_Centers');

            // تقارير القيود
            Route::get('/journalEntriesReport', [GeneralAccountsController::class, 'journalEntriesReport'])->name('reports.general_accounts.Journal_Entries_Report');

            // تقارير دليل الحسابات العامة
            Route::get('/chartOfAccounts', [GeneralAccountsController::class, 'chartOfAccounts'])->name('reports.general_accounts.General_Chart_of_Accounts');

            // تقارير المصروفات حسب التصنيف
            Route::get('/expensesByCategory', [GeneralAccountsController::class, 'expensesByCategory'])->name('reports.general_accounts.Expenses_By_Category');
            Route::get('/expensesByVendor', [GeneralAccountsController::class, 'expensesByVendor'])->name('reports.general_accounts.Expenses_By_Vendor');
            Route::get('/expensesByEmployee', [GeneralAccountsController::class, 'expensesByEmployee'])->name('reports.general_accounts.Expenses_By_Employee');
            Route::get('/expensesByCustomer', [GeneralAccountsController::class, 'expensesByCustomer'])->name('reports.general_accounts.Expenses_By_Customer');

            // تقارير المصروفات حسب الزمن
            Route::get('/dailyExpenses', [GeneralAccountsController::class, 'dailyExpenses'])->name('reports.general_accounts.Daily_Expenses');
            Route::get('/weeklyExpenses', [GeneralAccountsController::class, 'weeklyExpenses'])->name('reports.general_accounts.Weekly_Expenses');
            Route::get('/monthlyExpenses', [GeneralAccountsController::class, 'monthlyExpenses'])->name('reports.general_accounts.Monthly_Expenses');
            Route::get('/annualExpenses', [GeneralAccountsController::class, 'annualExpenses'])->name('reports.general_accounts.Annual_Expenses');

            // تقارير سندات القبض حسب التصنيف
            Route::get('/receivablesByCategory', [GeneralAccountsController::class, 'receivablesByCategory'])->name('reports.general_accounts.Receivables_By_Category');
            Route::get('/receivablesByVendor', [GeneralAccountsController::class, 'receivablesByVendor'])->name('reports.general_accounts.Receivables_By_Vendor');
            Route::get('/receivablesByEmployee', [GeneralAccountsController::class, 'receivablesByEmployee'])->name('reports.general_accounts.Receivables_By_Employee');
            Route::get('/receivablesByCustomer', [GeneralAccountsController::class, 'receivablesByCustomer'])->name('reports.general_accounts.Receivables_By_Customer');

            // تقارير سندات القبض حسب الزمن
            Route::get('/dailyReceivables', [GeneralAccountsController::class, 'dailyReceivables'])->name('reports.general_accounts.Daily_Receivables');
            Route::get('/weeklyReceivables', [GeneralAccountsController::class, 'weeklyReceivables'])->name('reports.general_accounts.Weekly_Receivables');
            Route::get('/monthlyReceivables', [GeneralAccountsController::class, 'monthlyReceivables'])->name('reports.general_accounts.Monthly_Receivables');
            Route::get('/annualReceivables', [GeneralAccountsController::class, 'annualReceivables'])->name('reports.general_accounts.Annual_Receivables');
            Route::get('/tacses', [GeneralAccountsController::class, 'tacses'])->name('reports.general_accounts.tacses');
        });
    });
