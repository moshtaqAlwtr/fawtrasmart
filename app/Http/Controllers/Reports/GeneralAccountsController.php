<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GeneralAccountsController extends Controller
{
    // دالة لعرض الحسابات العامة
    public function index()
    {
        return view('reports.general_accounts.index'); // يعرض الملف الذي يحتوي على الحسابات العامة
    }

    // دالة لتقرير الضرائب
    public function taxReport()
    {
        return view('reports.general_accounts.Tax_Report');
    }

    // دالة لإقرار ضريبي
    public function taxDeclaration()
    {
        return view('reports.general_accounts.Tax_Declaration');
    }

    // دالة لقائمة الدخل
    public function incomeStatement()
    {
        return view('reports.general_accounts.income_Statement');
    }

    // دالة للميزانية العمومية
    public function balanceSheet()
    {
        return view('reports.general_accounts.Balance_Sheet');
    }

    // دالة للربح والخسارة
    public function profitLoss()
    {
        return view('reports.general_accounts.Profit_Loss');
    }

    // دالة للحركات المالية
    public function financialTransactions()
    {
        return view('reports.general_accounts.Financial_Transactions');
    }

    // دالة لتقرير التدفقات النقدية
    public function cashFlowReport()
    {
        return view('reports.general_accounts.Cash_Flow_Report');
    }

    // دالة للأصول
    public function assets()
    {
        return view('reports.general_accounts.Assets');
    }

    // دالة لتقرير ميزان مراجعة مجاميع وأرصدة
    public function trialBalanceSummaryAndBalancesReport()
    {
        return view('reports.general_accounts.Trial_Balance_Summary_and_Balances_Report');
    }

    // دالة لتقرير حساب مراجعة
    public function trialBalanceAccountReport()
    {
        return view('reports.general_accounts.Trial_Balance_Account_Report');
    }

    // دالة لتقرير ميزان مراجعة أرصدة
    public function trialBalanceBalancesReport()
    {
        return view('reports.general_accounts.Trial_Balance_Balances_Report');
    }

    // دالة لحساب الأستاذ
    public function generalLedger()
    {
        return view('reports.general_accounts.General_Ledger');
    }

    // دالة لمراكز التكلفة
    public function costCenters()
    {
        return view('reports.general_accounts.Cost_Centers');
    }

    // دالة لتقرير القيود
    public function journalEntriesReport()
    {
        return view('reports.general_accounts.Journal_Entries_Report');
    }

    // دالة لدليل الحسابات العامة
    public function chartOfAccounts()
    {
        return view('reports.general_accounts.General_Chart_of_Accounts');
    }

    // دالة للمصروفات حسب التصنيف
    public function expensesByCategory()
    {
        return view('reports.general_accounts.Expenses_By_Category');
    }

    // دالة للمصروفات حسب البائع
    public function expensesByVendor()
    {
        return view('reports.general_accounts.Expenses_By_Vendor');
    }

    // دالة للمصروفات حسب الموظف
    public function expensesByEmployee()
    {
        return view('reports.general_accounts.Expenses_By_Employee');
    }

    // دالة للمصروفات حسب العميل
    public function expensesByCustomer()
    {
        return view('reports.general_accounts.Expenses_By_Customer');
    }

    // دالة للمصروفات اليومية
    public function dailyExpenses()
    {
        return view('reports.general_accounts.Daily_Expenses');
    }

    // دالة للمصروفات الأسبوعية
    public function weeklyExpenses()
    {
        return view('reports.general_accounts.Weekly_Expenses');
    }

    // دالة للمصروفات الشهرية
    public function monthlyExpenses()
    {
        return view('reports.general_accounts.Monthly_Expenses');
    }

    // دالة للمصروفات السنوية
    public function annualExpenses()
    {
        return view('reports.general_accounts.Annual_Expenses');
    }

    // دالة لسندات القبض حسب التصنيف
    public function receivablesByCategory()
    {
        return view('reports.general_accounts.Receivables_By_Category');
    }

    // دالة لسندات القبض حسب البائع
    public function receivablesByVendor()
    {
        return view('reports.general_accounts.Receivables_By_Vendor');
    }

    // دالة لسندات القبض حسب الموظف
    public function receivablesByEmployee()
    {
        return view('reports.general_accounts.Receivables_By_Employee');
    }

    // دالة لسندات القبض حسب العميل
    public function receivablesByCustomer()
    {
        return view('reports.general_accounts.Receivables_By_Customer');
    }

    // دالة لسندات القبض اليومية
    public function dailyReceivables()
    {
        return view('reports.general_accounts.Daily_Receivables');
    }

    // دالة لسندات القبض الأسبوعية
    public function weeklyReceivables()
    {
        return view('reports.general_accounts.Weekly_Receivables');
    }

    // دالة لسندات القبض الشهرية
    public function monthlyReceivables()
    {
        return view('reports.general_accounts.Monthly_Receivables');
    }

    // دالة لسندات القبض السنوية
    public function annualReceivables()
    {
        return view('reports.general_accounts.Annual_Receivables');
    }
    public function tacses()
    {
        return view('reports.general_accounts.tacses');
    }
}
