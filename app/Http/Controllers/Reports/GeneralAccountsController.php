<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Branch;
use App\Models\Client;
use App\Models\CostCenter;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\ExpensesCategory;
use App\Models\Invoice;
use App\Models\JournalEntry;
use App\Models\JournalEntryDetail;
use App\Models\PurchaseInvoice;
use App\Models\Receipt;
use App\Models\ReceiptCategory;
use App\Models\SupplyOrder;
use App\Models\Treasury;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GeneralAccountsController extends Controller
{
    // دالة لعرض الحسابات العامة
    public function index()
    {
        return view('reports.general_accounts.index'); // يعرض الملف الذي يحتوي على الحسابات العامة
    }
    public function taxReport(Request $request)
    {
        // جلب فواتير المبيعات
        $salesInvoices = Invoice::where('type', 'normal')->get();

        // جلب فواتير المرتجعات
        $returnInvoices = Invoice::where('type', 'returned')->get();

        // جلب فواتير المشتريات
        $purchaseInvoices = PurchaseInvoice::all();

        $taxData = [
            'sales' => $salesInvoices,
            'returns' => $returnInvoices,
            'purchases' => $purchaseInvoices,
        ];

        return view('reports.general_accounts.accountGeneral.tax_report', compact('taxData'));
    }
    public function taxDeclaration(Request $request)
    {
        $branches = Branch::all();

        // فلترة البيانات بناءً على الطلب
        $salesQuery = Invoice::query();
        $purchasesQuery = PurchaseInvoice::query();

        if ($request->has('tax_type') && $request->tax_type != '') {
            $salesQuery->where('tax_type', $request->tax_type);
            $purchasesQuery->where('tax_type', $request->tax_type);
        }

        if ($request->has('income_type') && $request->income_type != '') {
            if ($request->income_type == 'مستحقة') {
                $salesQuery->where('payment_status', 3); // غير مدفوع
                $purchasesQuery->where('is_paid', false);
            } elseif ($request->income_type == 'مدفوع بالكامل') {
                $salesQuery->where('payment_status', 1); // مدفوع بالكامل
                $purchasesQuery->where('is_paid', true);
            } elseif ($request->income_type == 'مدفوع جزئيا') {
                $salesQuery->where('payment_status', 2); // مدفوع جزئياً
                $purchasesQuery->where('is_paid', false);
            }
        }

        if ($request->has('branch') && $request->branch != '') {
            $salesQuery->where('branch_id', $request->branch);
            $purchasesQuery->where('branch_id', $request->branch);
        }

        if ($request->has('dateRange') && $request->dateRange != '') {
            $dateRange = explode(' - ', $request->dateRange);
            $startDate = $dateRange[0];
            $endDate = $dateRange[1];

            $salesQuery->whereBetween('invoice_date', [$startDate, $endDate]);
            $purchasesQuery->whereBetween('date', [$startDate, $endDate]);
        }

        // جلب البيانات
        $salesTaxDeclaration = $salesQuery->get();
        $purchasesTaxDeclaration = $purchasesQuery->get();

        return view('reports.general_accounts.accountGeneral.tax_declaration', compact('branches', 'salesTaxDeclaration', 'purchasesTaxDeclaration'));
    }

    public function incomeStatement(Request $request)
    {
        $branches = Branch::all();
        $costCenters = CostCenter::all();

        // جلب الإيرادات والمصروفات مع الحسابات الفرعية
        $revenuesQuery = Account::where('name', 'الإيرادات')->with('childrenRecursive');
        $expensesQuery = Account::where('name', 'المصروفات')->with('childrenRecursive');

        // تطبيق الفلترة
        if ($request->has('financial_year')) {
            $years = $request->input('financial_year');
            if (in_array('current', $years)) {
                $revenuesQuery->whereYear('created_at', date('Y'));
                $expensesQuery->whereYear('created_at', date('Y'));
            } elseif (in_array('all', $years)) {
                // لا تطبيق فلترة على السنة
            } else {
                $revenuesQuery->whereIn(DB::raw('YEAR(created_at)'), $years);
                $expensesQuery->whereIn(DB::raw('YEAR(created_at)'), $years);
            }
        }

        if ($request->has('account')) {
            $accountFilter = $request->input('account');
            if ($accountFilter == '1') {
                // عرض الحسابات التي عليها معاملات
                $revenuesQuery->has('transactions');
                $expensesQuery->has('transactions');
            } elseif ($accountFilter == '2') {
                // إخفاء الحسابات الصفرية
                $revenuesQuery->where('balance', '<>', 0);
                $expensesQuery->where('balance', '<>', 0);
            }
        }

        if ($request->has('branch')) {
            $branchFilter = $request->input('branch');
            $revenuesQuery->where('branch_id', $branchFilter);
            $expensesQuery->where('branch_id', $branchFilter);
        }

        if ($request->has('cost_center')) {
            $costCenterFilter = $request->input('cost_center');
            $revenuesQuery->where('cost_center_id', $costCenterFilter);
            $expensesQuery->where('cost_center_id', $costCenterFilter);
        }

        $revenues = $revenuesQuery->first();
        $expenses = $expensesQuery->first();

        return view('reports.general_accounts.accountGeneral.income_statement', compact('branches', 'revenues', 'expenses', 'costCenters'));
    }
    public function BalanceSheet(Request $request)
    {
        $branches = Branch::all();
        $costCenters = CostCenter::all();

        // جلب الأصول والخصوم مع جميع الحسابات الفرعية
        $assetsQuery = Account::where('name', 'الأصول')->with('childrenRecursive');
        $liabilitiesQuery = Account::where('name', 'الخصوم')->with('childrenRecursive');

        // تطبيق الفلترة
        if ($request->has('before_date')) {
            $beforeDate = $request->input('before_date');
            $assetsQuery->whereDate('created_at', '<=', $beforeDate);
            $liabilitiesQuery->whereDate('created_at', '<=', $beforeDate);
        }

        if ($request->has('cost_center')) {
            $costCenterId = $request->input('cost_center');
            $assetsQuery->where('cost_center_id', $costCenterId);
            $liabilitiesQuery->where('cost_center_id', $costCenterId);
        }

        if ($request->has('financial_year')) {
            $years = $request->input('financial_year');
            if (in_array('current', $years)) {
                $assetsQuery->whereYear('created_at', date('Y'));
                $liabilitiesQuery->whereYear('created_at', date('Y'));
            } elseif (in_array('all', $years)) {
                // لا تطبيق فلترة على السنة
            } else {
                $assetsQuery->whereIn(DB::raw('YEAR(created_at)'), $years);
                $liabilitiesQuery->whereIn(DB::raw('YEAR(created_at)'), $years);
            }
        }

        if ($request->has('account')) {
            $accountFilter = $request->input('account');
            if ($accountFilter == '1') {
                // عرض الحسابات التي عليها معاملات
                $assetsQuery->has('transactions');
                $liabilitiesQuery->has('transactions');
            } elseif ($accountFilter == '2') {
                // إخفاء الحسابات الصفرية
                $assetsQuery->where('balance', '<>', 0);
                $liabilitiesQuery->where('balance', '<>', 0);
            }
        }

        if ($request->has('branch')) {
            $branchFilter = $request->input('branch');
            $assetsQuery->where('branch_id', $branchFilter);
            $liabilitiesQuery->where('branch_id', $branchFilter);
        }

        $assets = $assetsQuery->first();
        $liabilities = $liabilitiesQuery->first();

        return view('reports.general_accounts.accountGeneral.balance_sheet', compact('branches', 'assets', 'liabilities', 'costCenters'));
    }
    // المصروفات
    public function splitExpensesByCategory(Request $request)
    {
        // جلب البيانات للفلاتر
        $branches = Branch::all();
        $treasuries = Treasury::all();
        $expensesCategory = ExpensesCategory::all();
        $accounts = Account::all();
        $employees = Employee::all();

        // فلترة البيانات بناءً على الطلب
        $query = Expense::query();

        if ($request->has('treasury') && $request->treasury != '') {
            $query->where('treasury_id', $request->treasury);
        }

        if ($request->has('employee') && $request->employee != '') {
            $query->where('seller', $request->employee);
        }

        if ($request->has('date_from') && $request->date_from != '') {
            $query->where('date', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to != '') {
            $query->where('date', '<=', $request->date_to);
        }

        if ($request->has('group_by') && $request->group_by != '') {
            $query->where('expenses_category_id', $request->group_by);
        }

        if ($request->has('branch') && $request->branch != '') {
            $query->where('branch_id', $request->branch);
        }

        if ($request->has('currency') && $request->currency != 'all') {
            $query->where('currency', $request->currency);
        }

        // جلب البيانات مع العلاقات
        $expenses = $query->with(['expenses_category', 'treasury', 'employee', 'branch'])->get();

        // تجميع البيانات حسب التصنيف
        $groupedExpenses = $expenses->groupBy('expenses_category_id');

        // إعداد بيانات المخطط
        $chartLabels = [];
        $chartData = [];

        foreach ($groupedExpenses as $categoryId => $expensesInCategory) {
            $category = $expensesInCategory->first()->expenses_category;
            $chartLabels[] = $category->name ?? 'غير مصنف';
            $chartData[] = $expensesInCategory->sum('amount') + $expensesInCategory->sum('tax1_amount') + $expensesInCategory->sum('tax2_amount');
        }

        return view('reports.general_accounts.split_expenses.expenses_by_category', compact('branches', 'expensesCategory', 'treasuries', 'accounts', 'employees', 'expenses', 'groupedExpenses', 'chartLabels', 'chartData'));
    }
    public function splitExpensesBySeller(Request $request)
    {
        // جلب البيانات للفلاتر
        $branches = Branch::all();
        $treasuries = Treasury::all();
        $expensesCategory = ExpensesCategory::all();
        $accounts = Account::all();
        $employees = Employee::all();

        // فلترة البيانات بناءً على الطلب
        $query = Expense::query();

        if ($request->has('treasury') && $request->treasury != '') {
            $query->where('treasury_id', $request->treasury);
        }

        if ($request->has('employee') && $request->employee != '') {
            $query->where('seller', $request->employee);
        }

        if ($request->has('date_from') && $request->date_from != '') {
            $query->where('date', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to != '') {
            $query->where('date', '<=', $request->date_to);
        }

        if ($request->has('branch') && $request->branch != '') {
            $query->where('branch_id', $request->branch);
        }

        if ($request->has('currency') && $request->currency != 'all') {
            $query->where('currency', $request->currency);
        }

        // جلب البيانات مع العلاقات
        $expenses = $query->with(['expenses_category', 'treasury', 'employee', 'branch'])->get();

        // تجميع البيانات حسب البائع
        $groupedExpenses = $expenses->groupBy('seller');

        // إعداد بيانات المخطط
        $chartLabels = [];
        $chartData = [];

        foreach ($groupedExpenses as $sellerId => $expensesInSeller) {
            $seller = $expensesInSeller->first()->employee;
            $chartLabels[] = $seller->full_name ?? 'غير معروف';
            $chartData[] = $expensesInSeller->sum('amount') + $expensesInSeller->sum('tax1_amount') + $expensesInSeller->sum('tax2_amount');
        }

        return view('reports.general_accounts.split_expenses.expenses_by_seller', compact('branches', 'expensesCategory', 'treasuries', 'accounts', 'employees', 'expenses', 'groupedExpenses', 'chartLabels', 'chartData'));
    }
    public function splitExpensesByEmployee(Request $request)
    {
        // جلب البيانات للفلاتر
        $branches = Branch::all();
        $treasuries = Treasury::all();
        $expensesCategory = ExpensesCategory::all();
        $accounts = Account::all();
        $employees = Employee::all();

        // فلترة البيانات بناءً على الطلب
        $query = Expense::query();

        if ($request->has('treasury') && $request->treasury != '') {
            $query->where('treasury_id', $request->treasury);
        }

        if ($request->has('employee') && $request->employee != '') {
            $query->where('seller', $request->employee);
        }

        if ($request->has('date_from') && $request->date_from != '') {
            $query->where('date', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to != '') {
            $query->where('date', '<=', $request->date_to);
        }

        if ($request->has('branch') && $request->branch != '') {
            $query->where('branch_id', $request->branch);
        }

        if ($request->has('currency') && $request->currency != 'all') {
            $query->where('currency', $request->currency);
        }

        // جلب البيانات مع العلاقات
        $expenses = $query->with(['expenses_category', 'treasury', 'employee', 'branch'])->get();

        // تجميع البيانات حسب البائع
        $groupedExpenses = $expenses->groupBy('seller');

        // إعداد بيانات المخطط
        $chartLabels = [];
        $chartData = [];

        foreach ($groupedExpenses as $sellerId => $expensesInSeller) {
            $seller = $expensesInSeller->first()->employee;
            $chartLabels[] = $seller->full_name ?? 'غير معروف';
            $chartData[] = $expensesInSeller->sum('amount') + $expensesInSeller->sum('tax1_amount') + $expensesInSeller->sum('tax2_amount');
        }

        return view('reports.general_accounts.split_expenses.expenses_by_employee', compact('branches', 'expensesCategory', 'treasuries', 'accounts', 'employees', 'expenses', 'groupedExpenses', 'chartLabels', 'chartData'));
    }

    public function splitExpensesByClient(Request $request)
    {
        // جلب البيانات للفلاتر
        $branches = Branch::all();
        $treasuries = Treasury::all();
        $expensesCategory = ExpensesCategory::all();
        $accounts = Account::all();
        $employees = Employee::all();
        $clients = Client::all(); // جلب جميع العملاء

        // فلترة البيانات بناءً على الطلب
        $query = Expense::query();

        if ($request->has('treasury') && $request->treasury != '') {
            $query->where('treasury_id', $request->treasury);
        }

        if ($request->has('client') && $request->client != '') {
            $query->where('client_id', $request->client);
        }

        if ($request->has('date_from') && $request->date_from != '') {
            $query->where('date', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to != '') {
            $query->where('date', '<=', $request->date_to);
        }

        if ($request->has('branch') && $request->branch != '') {
            $query->where('branch_id', $request->branch);
        }

        if ($request->has('currency') && $request->currency != 'all') {
            $query->where('currency', $request->currency);
        }

        // جلب البيانات مع العلاقات
        $expenses = $query->with(['expenses_category', 'treasury', 'client', 'branch'])->get();

        // تجميع البيانات حسب العميل
        $groupedExpenses = $expenses->groupBy('client_id');

        // إعداد بيانات المخطط
        $chartLabels = [];
        $chartData = [];

        foreach ($groupedExpenses as $clientId => $expensesInClient) {
            $client = $expensesInClient->first()->client;
            $chartLabels[] = $client->name ?? 'غير معروف';
            $chartData[] = $expensesInClient->sum('amount') + $expensesInClient->sum('tax1_amount') + $expensesInClient->sum('tax2_amount');
        }

        return view('reports.general_accounts.split_expenses.expenses_by_client', compact('branches', 'expensesCategory', 'treasuries', 'accounts', 'employees', 'clients', 'expenses', 'groupedExpenses', 'chartLabels', 'chartData'));
    }

    public function splitExpensesByTimePeriod(Request $request)
    {
        // استخراج الفترة الزمنية من الرابط
        $period = $request->route('period');

        // Fetch necessary dropdown data
        $branches = Branch::all();
        $treasuries = Treasury::all();
        $employees = Employee::all();
        $expensesCategories = ExpensesCategory::all();

        // Base query for expenses
        $query = Expense::query();

        // Apply filters
        if ($request->filled('treasury')) {
            $query->where('treasury_id', $request->treasury);
        }

        if ($request->filled('employee')) {
            $query->where('employee_id', $request->employee);
        }

        // Date range filtering with flexible parsing
        if ($request->filled('date_from') && $request->filled('date_to')) {
            $dateFrom = Carbon::parse($request->date_from);
            $dateTo = Carbon::parse($request->date_to);
            $query->whereBetween('date', [$dateFrom, $dateTo]);
        }

        if ($request->filled('branch') && $request->branch != 'all') {
            $query->where('branch_id', $request->branch);
        }

        if ($request->filled('currency') && $request->currency != 'all') {
            $query->where('currency', $request->currency);
        }

        // Determine grouping method based on route parameter or request input
        $reportType = $period ?? $request->input('report_type', 'monthly');

        // Fetch expenses with all related data
        $expenses = $query->with(['treasury', 'expenses_category', 'branch', 'employee'])->get();

        // Group expenses by time periods
        $groupedExpenses = $expenses->groupBy(function ($expense) use ($reportType) {
            $date = Carbon::parse($expense->date);

            switch ($reportType) {
                case 'daily':
                    return $date->format('Y-m-d');
                case 'weekly':
                    return $date->year . ' Week ' . $date->weekOfYear;
                case 'monthly':
                    return $date->format('Y-m');
                case 'quarterly':
                    return $date->year . ' Q' . ceil($date->month / 3);
                case 'yearly':
                    return $date->year;
                default:
                    return $date->format('Y-m');
            }
        });

        // Prepare period display names
        $periodDisplayNames = [
            'daily' => 'المصروفات اليومية',
            'weekly' => 'المصروفات الأسبوعية',
            'monthly' => 'المصروفات الشهرية',
            'quarterly' => 'المصروفات الربع سنوية',
            'yearly' => 'المصروفات السنوية',
        ];
        $periodDisplayName = $periodDisplayNames[$reportType] ?? $reportType;

        // Prepare chart data
        $chartLabels = array_keys($groupedExpenses->toArray());
        $chartData = $groupedExpenses
            ->map(function ($group) {
                return $group->sum('amount') + $group->sum('tax1_amount') + $group->sum('tax2_amount');
            })
            ->toArray();

        return view('reports.general_accounts.split_expenses.expenses_time_period', [
            'branches' => $branches,
            'treasuries' => $treasuries,
            'employees' => $employees,
            'expensesCategories' => $expensesCategories,
            'expenses' => $expenses,
            'groupedExpenses' => $groupedExpenses,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'reportType' => $reportType,
            'period' => $periodDisplayName,
        ]);
    }
    public function ReceiptByCategory(Request $request)
    {
        try {
            // Default to current month if no date range specified
            $fromDate = $request->input('from_date', Carbon::now()->startOfMonth());
            $toDate = $request->input('to_date', Carbon::now()->endOfMonth());

            // Fetch necessary dropdown data
            $branches = Branch::all();
            $treasuries = Treasury::all();
            $accounts = Account::all();
            $employees = Employee::all();
            $receiptsCategory = ReceiptCategory::all();
            $clients = Client::all();

            // Base query for receipts
            $query = Receipt::with(['incomes_category', 'treasury', 'account', 'client'])->whereBetween('date', [$fromDate, $toDate]);

            // Apply filters
            if ($request->filled('branch')) {
                $query->where('branch_id', $request->branch);
            }

            if ($request->filled('treasury')) {
                $query->where('treasury_id', $request->treasury);
            }

            if ($request->filled('employee')) {
                $query->where('employee_id', $request->employee);
            }

            if ($request->filled('client')) {
                $query->where('client_id', $request->client);
            }

            if ($request->filled('incomes_category')) {
                $query->where('incomes_category_id', $request->incomes_category);
            }

            // Fetch receipts
            $receipts = $query->get();

            // Group receipts by category
            $groupedReceipts = $receipts->groupBy('incomes_category_id');

            // Prepare chart data
            $chartData = [
                'labels' => $groupedReceipts
                    ->keys()
                    ->map(function ($categoryId) use ($receiptsCategory) {
                        return $receiptsCategory->find($categoryId)->name ?? 'غير مصنف';
                    })
                    ->toArray(),
                'values' => $groupedReceipts
                    ->map(function ($categoryReceipts) {
                        return $categoryReceipts->sum('amount');
                    })
                    ->values()
                    ->toArray(),
            ];

            return view('reports.general_accounts.receipt_bonds.receipt_by_category', [
                'branches' => $branches,
                'treasuries' => $treasuries,
                'accounts' => $accounts,
                'employees' => $employees,
                'receiptsCategory' => $receiptsCategory,
                'clients' => $clients,
                'receipts' => $receipts,
                'groupedReceipts' => $groupedReceipts,
                'chartData' => $chartData,
                'fromDate' => Carbon::parse($fromDate),
                'toDate' => Carbon::parse($toDate),
            ]);
        } catch (\Exception $e) {
            // Log the full error
            Log::error('Error in receipts by category report', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Optionally, return an error view or redirect with a message
            return back()->with('error', 'حدث خطأ أثناء إنشاء التقرير: ' . $e->getMessage());
        }
    }
    public function ReceiptBySeller(Request $request)
    {
        try {
            // Default to current month if no date range specified
            $fromDate = $request->input('from_date', Carbon::now()->startOfMonth());
            $toDate = $request->input('to_date', Carbon::now()->endOfMonth());

            // Fetch necessary dropdown data
            $branches = Branch::all();
            $treasuries = Treasury::all();
            $accounts = Account::all();
            $employees = Employee::all();
            $receiptsCategory = ReceiptCategory::all();
            $clients = Client::all();

            // Base query for receipts
            $query = Receipt::with(['incomes_category', 'treasury', 'account', 'client'])->whereBetween('date', [$fromDate, $toDate]);

            // Apply filters
            if ($request->filled('branch')) {
                $query->where('branch_id', $request->branch);
            }

            if ($request->filled('treasury')) {
                $query->where('treasury_id', $request->treasury);
            }

            if ($request->filled('employee')) {
                $query->where('employee_id', $request->employee);
            }

            if ($request->filled('client')) {
                $query->where('client_id', $request->client);
            }

            if ($request->filled('seller')) {
                $query->where('seller', $request->seller);
            }

            // Fetch receipts
            $receipts = $query->get();

            // Group receipts by seller
            $groupedReceipts = $receipts->groupBy('seller');

            // Prepare chart data
            $chartData = [
                'labels' => $groupedReceipts->keys()->toArray(),
                'values' => $groupedReceipts
                    ->map(function ($sellerReceipts) {
                        return $sellerReceipts->sum('amount');
                    })
                    ->values()
                    ->toArray(),
            ];

            return view('reports.general_accounts.receipt_bonds.receipt_by_seller', [
                'branches' => $branches,
                'treasuries' => $treasuries,
                'accounts' => $accounts,
                'employees' => $employees,
                'receiptsCategory' => $receiptsCategory,
                'clients' => $clients,
                'receipts' => $receipts,
                'groupedReceipts' => $groupedReceipts,
                'chartData' => $chartData,
                'fromDate' => Carbon::parse($fromDate),
                'toDate' => Carbon::parse($toDate),
            ]);
        } catch (\Exception $e) {
            // Log the full error
            Log::error('Error in receipts by seller report', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Optionally, return an error view or redirect with a message
            return back()->with('error', 'حدث خطأ أثناء إنشاء التقرير: ' . $e->getMessage());
        }
    }
    public function ReceiptByEmployee(Request $request)
{
    try {
        // تحديد التاريخ الافتراضي إن لم يُحدّد
        $fromDate = $request->input('from_date', Carbon::now()->startOfMonth());
        $toDate = $request->input('to_date', Carbon::now()->endOfMonth());

        // جلب بيانات القوائم المنسدلة
        $branches = Branch::all();
        $treasuries = Treasury::all();
        $accounts = Account::all();
        $employees = Employee::all(); // ممكن لاحقاً نحذفها لو ما نحتاجها
        $receiptsCategory = ReceiptCategory::all();
        $clients = Client::all();
        $users = User::all(); // المستخدمين

        // إنشاء الاستعلام الأساسي
        $query = Receipt::with(['incomes_category', 'treasury', 'account', 'client', 'user'])
                        ->whereBetween('date', [$fromDate, $toDate]);

        // تطبيق الفلاتر حسب الاختيار
        if ($request->filled('branch')) {
            $query->where('branch_id', $request->branch);
        }

        if ($request->filled('treasury')) {
            $query->where('treasury_id', $request->treasury);
        }

        if ($request->filled('employee')) {
            $query->where('employee_id', $request->employee);
        }

        if ($request->filled('client')) {
            $query->where('client_id', $request->client);
        }

        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        // تنفيذ الاستعلام
        $receipts = $query->get();

        // تجميع السندات حسب المستخدم (من أنشأ السند)
        $groupedReceipts = $receipts->groupBy('created_by');

        // إعداد بيانات المخطط البياني
        $chartData = [
            'labels' => $groupedReceipts->keys()->toArray(),
            'values' => $groupedReceipts
                ->map(function ($userReceipts) {
                    return $userReceipts->sum('amount');
                })
                ->values()
                ->toArray(),
        ];

        return view('reports.general_accounts.receipt_bonds.receipt_by_employee', [
            'branches' => $branches,
            'treasuries' => $treasuries,
            'accounts' => $accounts,
            'employees' => $employees,
            'users' => $users,
            'receiptsCategory' => $receiptsCategory,
            'clients' => $clients,
            'receipts' => $receipts,
            'groupedReceipts' => $groupedReceipts,
            'chartData' => $chartData,
            'fromDate' => Carbon::parse($fromDate),
            'toDate' => Carbon::parse($toDate),
        ]);
    } catch (\Exception $e) {
        Log::error('Error in receipts by user report', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        return back()->with('error', 'حدث خطأ أثناء إنشاء التقرير: ' . $e->getMessage());
    }
}

    public function ReceiptByClient(Request $request)
    {
        // Default to current month if no date range specified
        $fromDate = $request->input('from_date', Carbon::now()->startOfMonth());
        $toDate = $request->input('to_date', Carbon::now()->endOfMonth());

        // Fetch necessary dropdown data
        $branches = Branch::all();
        $treasuries = Treasury::all();
        $accounts = Account::all();
        $employees = Employee::all();
        $receiptsCategory = ReceiptCategory::all();
        $clients = Client::all();

        // Base query for receipts
        $query = Receipt::with(['incomes_category', 'treasury', 'account', 'client'])->whereBetween('date', [$fromDate, $toDate]);

        // Apply filters
        if ($request->filled('branch')) {
            $query->where('branch_id', $request->branch);
        }

        if ($request->filled('treasury')) {
            $query->where('treasury_id', $request->treasury);
        }

        if ($request->filled('employee')) {
            $query->where('employee_id', $request->employee);
        }

        if ($request->filled('client')) {
            $query->where('client_id', $request->client);
        }

        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        // Fetch receipts
        $receipts = $query->get();

        // Group receipts by
        $groupedReceipts = $receipts->groupBy('employee');

        // Prepare chart data
        $chartData = [
            'labels' => $groupedReceipts->keys()->toArray(),
            'values' => $groupedReceipts
                ->map(function ($employeeReceipts) {
                    return $employeeReceipts->sum('amount');
                })
                ->values()
                ->toArray(),
        ];

        return view('reports.general_accounts.receipt_bonds.receipt_by_client', [
            'branches' => $branches,
            'treasuries' => $treasuries,
            'accounts' => $accounts,
            'employees' => $employees,
            'receiptsCategory' => $receiptsCategory,
            'clients' => $clients,
            'receipts' => $receipts,
            'groupedReceipts' => $groupedReceipts,
            'chartData' => $chartData,
            'fromDate' => Carbon::parse($fromDate),
            'toDate' => Carbon::parse($toDate),
        ]);
    }
    public function ReceiptByTimePeriod(Request $request)
    {
        // Default to current month if no date range specified
        $fromDate = $request->input('from_date', Carbon::now()->startOfMonth());
        $toDate = $request->input('to_date', Carbon::now()->endOfMonth());

        // Fetch necessary dropdown data
        $branches = Branch::all();
        $treasuries = Treasury::all();
        $accounts = Account::all();
        $employees = Employee::all();
        $receiptsCategory = ReceiptCategory::all();
        $clients = Client::all();

        // Base query for receipts
        $query = Receipt::with(['incomes_category', 'treasury', 'account', 'client', 'employee'])->whereBetween('date', [$fromDate, $toDate]);

        // Apply filters
        if ($request->filled('branch')) {
            $query->where('branch_id', $request->branch);
        }

        if ($request->filled('treasury')) {
            $query->where('treasury_id', $request->treasury);
        }

        if ($request->filled('employee')) {
            $query->where('employee_id', $request->employee);
        }

        if ($request->filled('client')) {
            $query->where('client_id', $request->client);
        }

        if ($request->filled('incomes_category')) {
            $query->where('incomes_category_id', $request->incomes_category);
        }

        $reportPeriod = $request->input('report_period', 'monthly');
        // Fetch receipts
        $receipts = $query->get();

        // Group receipts by client
        $groupedReceipts = $receipts->groupBy('client_id');

        $groupedReceipts = $receipts->groupBy(function ($receipt) use ($reportPeriod) {
            $date = Carbon::parse($receipt->date);

            switch ($reportPeriod) {
                case 'daily':
                    return $date->format('Y-m-d');
                case 'weekly':
                    return $date->year . ' Week ' . $date->weekOfYear;
                case 'monthly':
                    return $date->format('Y-m');
                case 'quarterly':
                    return $date->year . ' Q' . ceil($date->month / 3);
                case 'yearly':
                    return $date->year;
                default:
                    return $date->format('Y-m-d');
            }
        });
        // Prepare chart data
        $chartData = [
            'labels' => $groupedReceipts
                ->keys()
                ->map(function ($clientId) use ($clients) {
                    return $clients->find($clientId)->name ?? 'غير معروف';
                })
                ->toArray(),
            'values' => $groupedReceipts
                ->map(function ($clientReceipts) {
                    return $clientReceipts->sum('amount');
                })
                ->values()
                ->toArray(),
        ];

        return view('reports.general_accounts.receipt_bonds.receipt_time_period', [
            'branches' => $branches,
            'treasuries' => $treasuries,
            'accounts' => $accounts,
            'employees' => $employees,
            'receiptsCategory' => $receiptsCategory,
            'clients' => $clients,
            'receipts' => $receipts,
            'groupedReceipts' => $groupedReceipts,
            'chartData' => $chartData,
            'fromDate' => Carbon::parse($fromDate),
            'toDate' => Carbon::parse($toDate),
            'reportPeriod' => $reportPeriod,
        ]);
    }
    public function trialBalance(Request $request)
    {
        // 1. معالجة نوع التقرير
        $reportType = $request->input('report_type', 'default');

        // 2. تحديد عناوين التقارير
        $reportTitles = [
            'balances_summary' => 'تقرير ميزان المراجعه مجاميع الارصدة',
            'account_review' => 'تقرير حساب المراجعة',
            'default' => 'تقرير ميزان المراجعة'
        ];

        // 3. اختيار العنوان
        $pageTitle = $reportTitles[$reportType] ?? $reportTitles['default'];

        // 4. معالجة نطاق التاريخ
        $dateRange = $request->input('dateRange', 'من أول السنة حتى اليوم');
        $startDate = now()->startOfYear();
        $endDate = now();

        // 5. تحديد نطاق التاريخ بشكل دقيق
        switch ($dateRange) {
            case 'الأسبوع الماضي':
                $startDate = now()->subWeek()->startOfWeek();
                $endDate = now()->subWeek()->endOfWeek();
                break;
            case 'الشهر الأخير':
                $startDate = now()->subMonth()->startOfMonth();
                $endDate = now()->subMonth()->endOfMonth();
                break;
            case 'من أول الشهر حتى اليوم':
                $startDate = now()->startOfMonth();
                $endDate = now();
                break;
            case 'السنة الماضية':
                $startDate = now()->subYear()->startOfYear();
                $endDate = now()->subYear()->endOfYear();
                break;
        }

        // 6. بناء استعلام الحسابات مع الفلترة
        $accountsQuery = Account::with(['parent', 'children']);

        // 7. فلترة نوع الحساب
        $accountType = $request->input('account_type');
        if ($accountType == 'رئيسي') {
            $accountsQuery->whereNull('parent_id');
        } elseif ($accountType == 'فرعي') {
            $accountsQuery->whereNotNull('parent_id');
        }

        // 8. فلترة الفرع
        $branchId = $request->input('branch');
        if ($branchId) {
            $accountsQuery->where('branch_id', $branchId);
        }

        // 9. فلترة المستوى
        $level = $request->input('level');
        if ($level !== null) {
            $accountsQuery->where('level', $level);
        }

        // 10. جلب الحسابات
        $accounts = $accountsQuery->get();

        // 11. حساب الأرصدة للحسابات
        $accountBalances = [];
        $accountDisplay = $request->input('account_display');

        foreach ($accounts as $account) {
            // 12. حساب الرصيد الافتتاحي
            $openingBalanceQuery = JournalEntryDetail::join('journal_entries', 'journal_entry_details.journal_entry_id', '=', 'journal_entries.id')
                ->where('account_id', $account->id)
                ->where('journal_entries.date', '<', $startDate)
                ->where('journal_entries.status', 1);

            $openingDebit = $openingBalanceQuery->sum('debit');
            $openingCredit = $openingBalanceQuery->sum('credit');

            // حساب الرصيد الافتتاحي الإجمالي
            $openingBalance = $openingDebit - $openingCredit;

            // 13. حساب حركات الفترة
            $periodMovementQuery = JournalEntryDetail::join('journal_entries', 'journal_entry_details.journal_entry_id', '=', 'journal_entries.id')
                ->where('account_id', $account->id)
                ->whereBetween('journal_entries.date', [$startDate, $endDate])
                ->where('journal_entries.status', 1);

            $periodDebit = $periodMovementQuery->sum('debit');
            $periodCredit = $periodMovementQuery->sum('credit');

            // 14. تحديد نوع الحساب
            $isDebitAccount = in_array($account->type, ['asset', 'expense', 'contra_liability', 'contra_equity']);

            // 15. فلترة عرض الحسابات
            $skipAccount = false;
            switch ($accountDisplay) {
                case '1': // عرض الحسابات التي عليها معاملات
                    $skipAccount = $periodDebit == 0 && $periodCredit == 0;
                    break;
                case '2': // إخفاء الحسابات الصفرية
                    $skipAccount = $openingBalance == 0 && $periodDebit == 0 && $periodCredit == 0;
                    break;
            }

            // 16. تخطي الحسابات غير المطلوبة
            if ($skipAccount) continue;

            // 17. حساب الأرصدة
            $accountBalanceDetails = $this->calculateAccountBalanceDetails(
                $account,
                $isDebitAccount,
                $openingBalance,
                $periodDebit,
                $periodCredit
            );

            $accountBalances[] = $accountBalanceDetails;
        }

        // 18. بناء شجرة الحسابات
        $accountTree = $this->buildAccountTree($accountBalances);

        // 19. حساب المجاميع
        $totals = [
            'opening_balance_debit' => array_sum(array_column($accountTree, 'opening_balance_debit')),
            'opening_balance_credit' => array_sum(array_column($accountTree, 'opening_balance_credit')),
            'period_debit' => array_sum(array_column($accountTree, 'period_debit')),
            'period_credit' => array_sum(array_column($accountTree, 'period_credit')),
            'closing_balance_debit' => array_sum(array_column($accountTree, 'closing_balance_debit')),
            'closing_balance_credit' => array_sum(array_column($accountTree, 'closing_balance_credit')),
            'total_debit' => array_sum(array_column($accountTree, 'total_debit')),
            'total_credit' => array_sum(array_column($accountTree, 'total_credit'))
        ];

        // 20. جلب البيانات المساعدة
        $branches = Branch::all();
        $costCenters = CostCenter::all();
        $users = User::all();

        // 21. إعداد بيانات العرض
        $viewData = [
            'pageTitle' => $pageTitle,
            'reportType' => $reportType,
            'accountTree' => $accountTree,
            'totals' => $totals,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branches' => $branches,
            'costCenters' => $costCenters,
            'users' => $users,
            'accounts' => Account::all(),
            'selectedDateRange' => $dateRange
        ];

        // 22. إرجاع العرض مع البيانات
        return view('reports.general_accounts.daily_restrictions_reports.trial_balance', $viewData);
    }

    // دالة مساعدة لحساب تفاصيل رصيد الحساب


    // دالة بناء شجرة الحسابات
    protected function buildAccountTree($accounts, $parentId = null, $level = 0)
    {
        $tree = [];

        foreach ($accounts as $account) {
            if ($account['parent_id'] === $parentId) {
                $accountData = $account;
                $accountData['level'] = $level;

                // البحث عن الأطفال
                $children = array_filter($accounts, function($child) use ($account) {
                    return $child['parent_id'] === $account['id'];
                });

                if ($children) {
                    $accountData['children'] = $this->buildAccountTree($accounts, $account['id'], $level + 1);

                    // جمع الأرصدة من الحسابات الفرعية
                    $balanceFields = [
                        'opening_balance_debit', 'opening_balance_credit',
                        'period_debit', 'period_credit',
                        'closing_balance_debit', 'closing_balance_credit',
                        'total_debit', 'total_credit'
                    ];

                    foreach ($balanceFields as $field) {
                        $accountData[$field] =
                            ($accountData[$field] ?? 0) +
                            array_sum(array_column($accountData['children'], $field));
                    }
                }

                $tree[] = $accountData;
            }
        }

        return $tree;
    }
    public function accountBalanceReview(Request $request)
    {
        // 1. معالجة نوع التقرير
        $pageTitle = 'تقرير ميزان مراجعة أرصدة';

        // 2. معالجة نطاق التاريخ
        $dateRange = $request->input('dateRange', 'من أول السنة حتى اليوم');
        $startDate = now()->startOfYear();
        $endDate = now();

        // 3. تحديد نطاق التاريخ بشكل دقيق
        switch ($dateRange) {
            case 'الأسبوع الماضي':
                $startDate = now()->subWeek()->startOfWeek();
                $endDate = now()->subWeek()->endOfWeek();
                break;
            case 'الشهر الأخير':
                $startDate = now()->subMonth()->startOfMonth();
                $endDate = now()->subMonth()->endOfMonth();
                break;
            case 'من أول الشهر حتى اليوم':
                $startDate = now()->startOfMonth();
                $endDate = now();
                break;
            case 'السنة الماضية':
                $startDate = now()->subYear()->startOfYear();
                $endDate = now()->subYear()->endOfYear();
                break;
        }

        // 4. بناء استعلام الحسابات مع الفلترة
        $accountsQuery = Account::with(['parent', 'children']);

        // 5. فلترة نوع الحساب
        $accountType = $request->input('account_type');
        if ($accountType == 'رئيسي') {
            $accountsQuery->whereNull('parent_id');
        } elseif ($accountType == 'فرعي') {
            $accountsQuery->whereNotNull('parent_id');
        }

        // 6. فلترة الفرع
        $branchId = $request->input('branch');
        if ($branchId) {
            $accountsQuery->where('branch_id', $branchId);
        }

        // 7. فلترة المستوى
        $level = $request->input('level');
        if ($level !== null) {
            $accountsQuery->where('level', $level);
        }

        // 8. جلب الحسابات
        $accounts = $accountsQuery->get();

        // 9. حساب الأرصدة للحسابات
        $accountBalances = [];
        $accountDisplay = $request->input('account_display');

        foreach ($accounts as $account) {
            // 10. حساب الرصيد الافتتاحي
            $openingBalanceQuery = JournalEntryDetail::join('journal_entries', 'journal_entry_details.journal_entry_id', '=', 'journal_entries.id')
                ->where('account_id', $account->id)
                ->where('journal_entries.date', '<', $startDate)
                ->where('journal_entries.status', 1);

            $openingDebit = $openingBalanceQuery->sum('debit');
            $openingCredit = $openingBalanceQuery->sum('credit');

            // حساب الرصيد الافتتاحي الإجمالي
            $openingBalance = $openingDebit - $openingCredit;

            // 11. حساب حركات الفترة
            $periodMovementQuery = JournalEntryDetail::join('journal_entries', 'journal_entry_details.journal_entry_id', '=', 'journal_entries.id')
                ->where('account_id', $account->id)
                ->whereBetween('journal_entries.date', [$startDate, $endDate])
                ->where('journal_entries.status', 1);

            $periodDebit = $periodMovementQuery->sum('debit');
            $periodCredit = $periodMovementQuery->sum('credit');

            // 12. تحديد نوع الحساب
            $isDebitAccount = in_array($account->type, ['asset', 'expense', 'contra_liability', 'contra_equity']);

            // 13. فلترة عرض الحسابات
            $skipAccount = false;
            switch ($accountDisplay) {
                case '1': // عرض الحسابات التي عليها معاملات
                    $skipAccount = $periodDebit == 0 && $periodCredit == 0;
                    break;
                case '2': // إخفاء الحسابات الصفرية
                    $skipAccount = $openingBalance == 0 && $periodDebit == 0 && $periodCredit == 0;
                    break;
            }

            // 14. تخطي الحسابات غير المطلوبة
            if ($skipAccount) continue;

            // 15. حساب الأرصدة
            $accountBalanceDetails = $this->calculateAccountBalanceDetails(
                $account,
                $isDebitAccount,
                $openingBalance,
                $periodDebit,
                $periodCredit
            );

            $accountBalances[] = $accountBalanceDetails;
        }

        // 16. بناء شجرة الحسابات
        $accountTree = $this->buildAccountTree($accountBalances);

        // 17. حساب المجاميع
        $totals = [
            'total_debit' => array_sum(array_column($accountBalances, 'total_debit')),
            'total_credit' => array_sum(array_column($accountBalances, 'total_credit')),
        ];

        // 18. جلب البيانات المساعدة
        $branches = Branch::all();
        $costCenters = CostCenter::all();
        $users = User::all();
        $accounts = Account::all();

        // 19. إعداد بيانات العرض
        $viewData = [
            'pageTitle' => $pageTitle,
            'accountTree' => $accountTree,
            'totals' => $totals,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branches' => $branches,
            'costCenters' => $costCenters,
            'users' => $users,
            'accounts' => $accounts,
            'selectedDateRange' => $dateRange
        ];

        // 20. إرجاع العرض مع البيانات
        return view('reports.general_accounts.daily_restrictions_reports.account_blance_review', $viewData);
    }
    protected function calculateAccountBalanceDetails($account, $isDebitAccount, $openingBalance, $periodDebit, $periodCredit)
{
    // تحديد نوع الحساب بشكل أكثر دقة
    $accountType = $account->type;

    // حساب الرصيد الافتتاحي بشكل مفصل
    $openingBalanceDebit = 0;
    $openingBalanceCredit = 0;

    // تحديد اتجاه الحساب بناءً على نوع الحساب
    $isDebitNormalBalance = in_array($accountType, [
        'asset', 'expense', 'contra_liability', 'contra_equity'
    ]);

    // معالجة الرصيد الافتتاحي
    if ($isDebitNormalBalance) {
        // للحسابات المدينة الطبيعية (الأصول، المصروفات)
        if ($openingBalance > 0) {
            $openingBalanceDebit = abs($openingBalance);
        } else {
            $openingBalanceCredit = abs($openingBalance);
        }
    } else {
        // للحسابات الدائنة الطبيعية (الالتزامات، الإيرادات، حقوق الملكية)
        if ($openingBalance > 0) {
            $openingBalanceCredit = abs($openingBalance);
        } else {
            $openingBalanceDebit = abs($openingBalance);
        }
    }

    // حساب الرصيد الختامي
    $closingBalance = $openingBalance + $periodDebit - $periodCredit;
    $closingBalanceDebit = 0;
    $closingBalanceCredit = 0;

    if ($isDebitNormalBalance) {
        // للحسابات المدينة الطبيعية
        if ($closingBalance > 0) {
            $closingBalanceDebit = abs($closingBalance);
        } else {
            $closingBalanceCredit = abs($closingBalance);
        }
    } else {
        // للحسابات الدائنة الطبيعية
        if ($closingBalance > 0) {
            $closingBalanceCredit = abs($closingBalance);
        } else {
            $closingBalanceDebit = abs($closingBalance);
        }
    }

    // حساب الإجماليات
    $totalDebit = $openingBalanceDebit + $periodDebit;
    $totalCredit = $openingBalanceCredit + $periodCredit;

    return [
        'id' => $account->id,
        'name' => $account->name,
        'code' => $account->code,
        'parent_id' => $account->parent_id,
        'account_type' => $accountType,
        'account_category' => $account->category,
        'opening_balance_debit' => $openingBalanceDebit,
        'opening_balance_credit' => $openingBalanceCredit,
        'period_debit' => $periodDebit,
        'period_credit' => $periodCredit,
        'closing_balance_debit' => $closingBalanceDebit,
        'closing_balance_credit' => $closingBalanceCredit,
        'total_debit' => $totalDebit,
        'total_credit' => $totalCredit
    ];
}
public function generalLedger(Request $request)
{
    // استرجاع الحسابات والفروع ومراكز التكلفة والمستخدمين
    $accounts = Account::all();
    $branches = Branch::all();
    $costCenters = CostCenter::all();
    $users = User::all();

    // استرجاع القيود المحاسبية بناءً على الفلتر
    $journalEntries = JournalEntry::query();

    if ($request->has('dateRange')) {
        $journalEntries->whereBetween('date', $this->getDateRange($request->dateRange));
    }

    if ($request->has('account')) {
        $journalEntries->whereHas('details', function ($query) use ($request) {
            $query->where('account_id', $request->account);
        });
    }

    if ($request->has('branch')) {
        $journalEntries->where('branch_id', $request->branch);
    }

    if ($request->has('cost_center')) {
        $journalEntries->where('cost_center_id', $request->cost_center);
    }

    // استرجاع القيود مع التفاصيل والحسابات المرتبطة
    $journalEntries = $journalEntries->with(['details.account', 'employee'])->get();

    // حساب الإجماليات
    $totalDebit = 0;
    $totalCredit = 0;
    $totalBalanceDebit = 0;
    $totalBalanceCredit = 0;

    foreach ($journalEntries as $entry) {
        foreach ($entry->details as $detail) {
            $totalDebit += $detail->debit;
            $totalCredit += $detail->credit;
            $totalBalanceDebit += $detail->account->balance;
            $totalBalanceCredit += $detail->account->balance;
        }
    }

    // استرجاع حساب "المبيعات" من جدول الحسابات
    $salesAccount = Account::where('name', 'المبيعات')->first();

    return view('reports.general_accounts.accountGeneral.general_ledger_account', compact(
        'accounts', 'users', 'branches', 'costCenters', 'journalEntries',
        'totalDebit', 'totalCredit', 'totalBalanceDebit', 'totalBalanceCredit',
        'salesAccount'
    ));
}


private function getDateRange($dateRange)
{
    // دالة لتحويل الفترة المحددة إلى نطاق تاريخي
    switch ($dateRange) {
        case 'الأسبوع الماضي':
            return [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()];
        case 'الشهر الأخير':
            return [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()];
        case 'من أول الشهر حتى اليوم':
            return [now()->startOfMonth(), now()];
        case 'السنة الماضية':
            return [now()->subYear()->startOfYear(), now()->subYear()->endOfYear()];
        case 'من أول السنة حتى اليوم':
            return [now()->startOfYear(), now()];
        default:
            return [now()->subMonth(), now()];
    }
}

public function CostCentersReport(Request $request){
   // فلترة البيانات بناءً على المدخلات
   $query = JournalEntry::query();

   if ($request->filled('dateRange')) {
       $query->where('date', $request->dateRange);
   }

   if ($request->filled('account')) {
       $query->where('account_id', $request->account);
   }

   if ($request->filled('branch')) {
       $query->where('branch_id', $request->branch);
   }

   if ($request->filled('cost_center')) {
       $query->where('cost_center_id', $request->cost_center);
   }

   if ($request->filled('financial_year')) {
       $query->whereIn('financial_year', $request->financial_year);
   }
   $journalEntries = $query->with(['details.account', 'costCenter'])->get();
   // الحصول على البيانات المطلوبة للفلترة
   $accounts = Account::all();
   $costCenters = CostCenter::all();
   $branches = Branch::all();
   $users = User::all();

   return view('reports.general_accounts.daily_restrictions_reports.cost_centers_report', compact('journalEntries', 'accounts', 'costCenters', 'branches', 'users'));

}
public function ReportJournal(Request $request)
{
    // فلترة البيانات بناءً على المدخلات
    $query = JournalEntry::query();

    // فلترة حسب المصدر (نوع القيد)
    if ($request->filled('treasury')) {
        $query->where('entity_type', $request->treasury);
    }

    // فلترة حسب الحساب الفرعي
    if ($request->filled('account')) {
        $query->whereHas('details', function($q) use ($request) {
            $q->where('account_id', $request->account);
        });
    }

    // فلترة حسب الفترة من
    if ($request->filled('from_date')) {
        $query->whereDate('date', '>=', $request->from_date);
    }

    // فلترة حسب الفترة إلى
    if ($request->filled('to_date')) {
        $query->whereDate('date', '<=', $request->to_date);
    }

    // فلترة حسب أمر التوريد
    if ($request->filled('supply')) {
        $query->where('supply_order_id', $request->supply);
    }

    // فلترة حسب الفرع
    if ($request->filled('branch')) {
        $query->where('branch_id', $request->branch);
    }

    // جلب البيانات مع التفاصيل والحسابات المرتبطة
    $journalEntries = $query->with(['details.account', 'branch'])->get();

    // حساب الإجمالي لكل قيد
    $journalEntries->each(function ($entry) {
        $entry->total_debit = $entry->details->sum('debit');
        $entry->total_credit = $entry->details->sum('credit');
    });

    // تحضير البيانات للعرض
    $accounts = Account::all();
    $branches = Branch::all();
    $supplyOrders = SupplyOrder::all();

    // إرجاع العرض مع البيانات
    return view('reports.general_accounts.daily_restrictions_reports.report_journal',
        compact('journalEntries', 'accounts', 'branches', 'supplyOrders')
    );
}
public function ChartOfAccounts(Request $request)
{
    // فلترة البيانات بناءً على المدخلات
    $query = Account::query();

    // فلترة حسب مستوى الحساب
    if ($request->filled('account_level')) {
        if ($request->account_level == 'main') {
            $query->whereNull('parent_id'); // حسابات رئيسية
        } elseif ($request->account_level == 'sub') {
            $query->whereNotNull('parent_id'); // حسابات فرعية
        }
    }

    // فلترة حسب نوع الحساب (مدين/دائن)
    if ($request->filled('account_type')) {
        $query->where('type', $request->account_type);
    }

    // فلترة حسب نوع الحساب (عملاء/موردين)
    if ($request->filled('account_category')) {
        $query->where('category', $request->account_category);
    }

    // فلترة حسب الفرع
    if ($request->filled('branch')) {
        $query->where('branch_id', $request->branch);
    }

    // ترتيب حسب الكود
    if ($request->filled('order_by')) {
        if ($request->order_by == 'asc') {
            $query->orderBy('code', 'asc');
        } elseif ($request->order_by == 'desc') {
            $query->orderBy('code', 'desc');
        }
    }

    // جلب البيانات
    $accounts = $query->with(['branch', 'parent'])->get();

    // تحضير البيانات للعرض
    $branches = Branch::all();

    return view('reports.general_accounts.daily_restrictions_reports.chart_of_account_report',
        compact('accounts', 'branches')
    );
}

}
