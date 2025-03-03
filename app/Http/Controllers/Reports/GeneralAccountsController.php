<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Branch;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\ExpensesCategory;
use App\Models\Invoice;
use App\Models\PurchaseInvoice;
use App\Models\Receipt;
use App\Models\ReceiptCategory;
use App\Models\Treasury;
use Carbon\Carbon;
use Illuminate\Http\Request;
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

        return view('reports.general_accounts.accountGeneral.income_statement', compact('branches'));
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
    $expenses = $query->with([
        'treasury',
        'expenses_category',
        'branch',
        'employee'
    ])->get();

    // Group expenses by time periods
    $groupedExpenses = $expenses->groupBy(function($expense) use ($reportType) {
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
        'yearly' => 'المصروفات السنوية'
    ];
    $periodDisplayName = $periodDisplayNames[$reportType] ?? $reportType;

    // Prepare chart data
    $chartLabels = array_keys($groupedExpenses->toArray());
    $chartData = $groupedExpenses->map(function($group) {
        return $group->sum('amount') + $group->sum('tax1_amount') + $group->sum('tax2_amount');
    })->toArray();

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
        'period' => $periodDisplayName
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
        $query = Receipt::with(['incomes_category', 'treasury', 'account', 'client'])
            ->whereBetween('date', [$fromDate, $toDate]);

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
            'labels' => $groupedReceipts->keys()->map(function ($categoryId) use ($receiptsCategory) {
                return $receiptsCategory->find($categoryId)->name ?? 'غير مصنف';
            })->toArray(),
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
        $query = Receipt::with(['incomes_category', 'treasury', 'account', 'client'])
            ->whereBetween('date', [$fromDate, $toDate]);

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
        $query = Receipt::with(['incomes_category', 'treasury', 'account', 'client', 'employee'])
            ->whereBetween('date', [$fromDate, $toDate]);

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

        // Group receipts by employee
        $groupedReceipts = $receipts->groupBy('employee_id');

        // Prepare chart data
        $chartData = [
            'labels' => $groupedReceipts->keys()->map(function ($employeeId) use ($employees) {
                return $employees->find($employeeId)->full_name ?? 'غير معروف';
            })->toArray(),
            'values' => $groupedReceipts
                ->map(function ($employeeReceipts) {
                    return $employeeReceipts->sum('amount');
                })
                ->values()
                ->toArray(),
        ];

        return view('reports.general_accounts.receipt_bonds.receipt_by_employee', [
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
        Log::error('Error in receipts by employee report', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        // Optionally, return an error view or redirect with a message
        return back()->with('error', 'حدث خطأ أثناء إنشاء التقرير: ' . $e->getMessage());
    }
}
public function ReceiptByClient(Request $request)
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
        $query = Receipt::with(['incomes_category', 'treasury', 'account', 'client', 'employee'])
            ->whereBetween('date', [$fromDate, $toDate]);

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

        // Group receipts by client
        $groupedReceipts = $receipts->groupBy('client_id');

        // Prepare chart data
        $chartData = [
            'labels' => $groupedReceipts->keys()->map(function ($clientId) use ($clients) {
                return $clients->find($clientId)->name ?? 'غير معروف';
            })->toArray(),
            'values' => $groupedReceipts
                ->map(function ($clientReceipts) {
                    return $clientReceipts->sum('amount');
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
    } catch (\Exception $e) {
        // Log the full error
        Log::error('Error in receipts by client report', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        // Optionally, return an error view or redirect with a message
        return back()->with('error', 'حدث خطأ أثناء إنشاء التقرير: ' . $e->getMessage());
    }
}
public function ReceiptByTimePeriod(Request $request)
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

        // Default report period
        $reportPeriod = $request->input('report_period', 'monthly');

        // Base query for receipts
        $query = Receipt::with(['incomes_category', 'treasury', 'account', 'client', 'employee'])
            ->whereBetween('date', [$fromDate, $toDate]);

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

        // Group receipts by time period
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
            'labels' => $groupedReceipts->keys()->toArray(),
            'values' => $groupedReceipts
                ->map(function ($periodReceipts) {
                    return $periodReceipts->sum('amount');
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
    } catch (\Exception $e) {
        // Log the full error
        Log::error('Error in receipts by time period report', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        // Optionally, return an error view or redirect with a message
        return back()->with('error', 'حدث خطأ أثناء إنشاء التقرير: ' . $e->getMessage());
    }
}
}
