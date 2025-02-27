<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Employee;
use App\Models\InvoiceItem;
use App\Models\PaymentsProcess;
use App\Models\Product;
use App\Models\PurchaseInvoice;
use App\Models\Supplier;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PurchasesReportController extends Controller
{
    public function index()
    {
        return view('reports.purchases.index');
    }
    public function bySupplier(Request $request)
    {
        // الحصول على البيانات الأساسية
        $suppliers = Supplier::all();
        $branches = Branch::all();

        // تحديد النطاق الزمني
        $fromDate = $request->input('from_date', now()->startOfMonth());
        $toDate = $request->input('to_date', now()->endOfMonth());

        // تحديد فترة التقرير
        $reportPeriod = $request->input('report_period', 'monthly');

        // بناء الاستعلام
        $query = PurchaseInvoice::with(['supplier', 'creator', 'branch', 'payments_process']);

        // تطبيق الفلتر بناءً على الفترة
        switch ($reportPeriod) {
            case 'daily':
                $fromDate = now()->startOfDay();
                $toDate = now()->endOfDay();
                break;
            case 'weekly':
                $fromDate = now()->startOfWeek();
                $toDate = now()->endOfWeek();
                break;
            case 'monthly':
                $fromDate = now()->startOfMonth();
                $toDate = now()->endOfMonth();
                break;
            case 'yearly':
                $fromDate = now()->startOfYear();
                $toDate = now()->endOfYear();
                break;
        }

        // تطبيق الفلاتر الإضافية
        if ($request->filled('supplier')) {
            $query->where('supplier_id', $request->supplier);
        }

        if ($request->filled('branch')) {
            $query->where('branch_id', $request->branch);
        }

        if ($request->filled('status')) {
            switch ($request->status) {
                case '1': // مدفوعة
                    $query->where('is_paid', 1);
                    break;
                case '0': // غير مدفوعة
                    $query->where('is_paid', 0);
                    break;
                case '5': // مرتجعة
                    $query->where('type', 'return');
                    break;
            }
        }

        // تطبيق النطاق الزمني
        $query->whereBetween('date', [$fromDate, $toDate]);

        // الحصول على النتائج
        $purchaseInvoices = $query->get();

        // تجميع الفواتير حسب المورد
        $groupedPurchaseInvoices = $purchaseInvoices->groupBy('supplier_id');

        // حساب المجاميع
        $totals = [
            'paid_amount' => $purchaseInvoices->sum(function ($invoice) {
                return $invoice->is_paid == 1 ? $invoice->grand_total : $invoice->payments_process->sum('amount');
            }),
            'unpaid_amount' => $purchaseInvoices->sum(function ($invoice) {
                $paidAmount = $invoice->payments_process->sum('amount');
                return $invoice->is_paid == 0 ? max($invoice->grand_total - $paidAmount, 0) : 0;
            }),
            'returned_amount' => $purchaseInvoices->sum(function ($invoice) {
                return in_array($invoice->type, ['return', 'returned']) ? $invoice->grand_total : 0;
            }),
            'total_amount' => $purchaseInvoices->sum('grand_total'),
        ];

        // بيانات المخطط البياني لحالة الدفع
        $paymentStatusChartData = [
            'labels' => ['مدفوع', 'غير مدفوع', 'مرتجع'],
            'values' => [$totals['paid_amount'], $totals['unpaid_amount'], $totals['returned_amount']],
            'colors' => [
                'rgba(75, 192, 192, 0.6)', // أخضر للمدفوع
                'rgba(255, 99, 132, 0.6)', // أحمر للغير مدفوع
                'rgba(255, 206, 86, 0.6)', // أصفر للمرتجع
            ],
        ];

        // بيانات المخطط البياني للموردين
        $supplierChartData = [
            'labels' => [],
            'values' => [],
            'colors' => [],
        ];

        foreach ($groupedPurchaseInvoices as $supplierId => $supplierInvoices) {
            $supplier = $supplierInvoices->first()->supplier;
            $supplierChartData['labels'][] = $supplier->trade_name ?? 'مورد ' . $supplierId;
            $supplierTotal = $supplierInvoices->sum('grand_total');
            $supplierChartData['values'][] = $supplierTotal;

            // توليد ألوان عشوائية لكل مورد
            $supplierChartData['colors'][] = sprintf('rgba(%d, %d, %d, 0.6)', rand(0, 255), rand(0, 255), rand(0, 255));
        }

        return view('reports.purchases.purchaseReport.Purchase_By_Supplier', compact('groupedPurchaseInvoices', 'suppliers', 'branches', 'totals', 'paymentStatusChartData', 'supplierChartData', 'fromDate', 'toDate', 'reportPeriod'));
    }
    public function purchaseByEmployee(Request $request)
{
    // الحصول على البيانات الأساسية
    $employees = User::all(); // الموظفون من جدول users
    $branches = Branch::all();
    $suppliers = Supplier::all();

    // تحديد النطاق الزمني
    $fromDate = $request->input('from_date', now()->startOfMonth());
    $toDate = $request->input('to_date', now()->endOfMonth());

    // تحديد فترة التقرير
    $reportPeriod = $request->input('report_period', 'monthly');

    // بناء الاستعلام
    $query = PurchaseInvoice::with(['creator', 'branch', 'payments_process']); // استخدام user بدلاً من employee

    // تطبيق الفلتر بناءً على الفترة
    switch ($reportPeriod) {
        case 'daily':
            $fromDate = now()->startOfDay();
            $toDate = now()->endOfDay();
            break;
        case 'weekly':
            $fromDate = now()->startOfWeek();
            $toDate = now()->endOfWeek();
            break;
        case 'monthly':
            $fromDate = now()->startOfMonth();
            $toDate = now()->endOfMonth();
            break;
        case 'yearly':
            $fromDate = now()->startOfYear();
            $toDate = now()->endOfYear();
            break;
    }

    // تطبيق الفلاتر الإضافية
    if ($request->filled('employee')) {
        $query->where('user_id', $request->employee); // استخدام user_id بدلاً من employee_id
    }

    if ($request->filled('branch')) {
        $query->where('branch_id', $request->branch);
    }

    if ($request->filled('status')) {
        switch ($request->status) {
            case '1': // مدفوعة
                $query->where('is_paid', 1);
                break;
            case '0': // غير مدفوعة
                $query->where('is_paid', 0);
                break;
            case '5': // مرتجعة
                $query->where('type', 'return');
                break;
        }
    }

    // تطبيق النطاق الزمني
    $query->whereBetween('date', [$fromDate, $toDate]);

    // الحصول على النتائج
    $purchaseInvoices = $query->get();

    // تجميع الفواتير حسب الموظف (user)
    $groupedPurchaseInvoices = $purchaseInvoices->groupBy('created_by');

    // حساب المجاميع
    $totals = [
        'paid_amount' => $purchaseInvoices->sum(function ($invoice) {
            return $invoice->is_paid == 1 ? $invoice->grand_total : $invoice->payments_process->sum('amount');
        }),
        'unpaid_amount' => $purchaseInvoices->sum(function ($invoice) {
            $paidAmount = $invoice->payments_process->sum('amount');
            return $invoice->is_paid == 0 ? max($invoice->grand_total - $paidAmount, 0) : 0;
        }),
        'returned_amount' => $purchaseInvoices->sum(function ($invoice) {
            return in_array($invoice->type, ['return', 'returned']) ? $invoice->grand_total : 0;
        }),
        'total_amount' => $purchaseInvoices->sum('grand_total'),
    ];

    // بيانات المخطط البياني لحالة الدفع
    $paymentStatusChartData = [
        'labels' => ['مدفوع', 'غير مدفوع', 'مرتجع'],
        'values' => [
            $totals['paid_amount'],
            $totals['unpaid_amount'],
            $totals['returned_amount']
        ],
        'colors' => [
            'rgba(75, 192, 192, 0.6)',   // أخضر للمدفوع
            'rgba(255, 99, 132, 0.6)',    // أحمر للغير مدفوع
            'rgba(255, 206, 86, 0.6)'     // أصفر للمرتجع
        ]
    ];

    // بيانات المخطط البياني للموظفين (users)
    $employeeChartData = [
        'labels' => [],
        'values' => [],
        'colors' => []
    ];

    foreach ($groupedPurchaseInvoices as $userId => $userInvoices) {
        $user = $userInvoices->first()->user; // استخدام user بدلاً من employee
        $employeeChartData['labels'][] = $user->name ?? 'موظف ' . $userId; // استخدام name بدلاً من full_name
        $employeeTotal = $userInvoices->sum('grand_total');
        $employeeChartData['values'][] = $employeeTotal;

        // توليد ألوان عشوائية لكل موظف
        $employeeChartData['colors'][] = sprintf(
            'rgba(%d, %d, %d, 0.6)',
            rand(0, 255),
            rand(0, 255),
            rand(0, 255)
        );
    }

    return view('reports.purchases.purchaseReport.Purchase_By_Employee', compact(
        'groupedPurchaseInvoices',
        'employees',
        'branches',
        'suppliers',
        'totals',
        'paymentStatusChartData',
        'employeeChartData',
        'fromDate',
        'toDate',
        'reportPeriod'
    ));
}

public function SuppliersDirectory(Request $request)
{
    $branches = Branch::all();
    $suppliers = Supplier::query();

    // فلترة حسب المدينة
    if ($request->has('city') && $request->city != '') {
        $suppliers->where('city', 'like', '%' . $request->city . '%');
    }

    // فلترة حسب البلد
    if ($request->has('country') && $request->country != '') {
        $suppliers->where('country', 'like', '%' . $request->country . '%');
    }

    // فلترة حسب الفرع
    if ($request->has('branch_id') && $request->branch_id != '') {
        $suppliers->where('branch_id', $request->branch_id);
    }

    // فلترة حسب التجميع
    if ($request->has('group_by') && $request->group_by != '') {
        if ($request->group_by == 'supplier') {
            $suppliers->groupBy('trade_name');
        } elseif ($request->group_by == 'branch') {
            $suppliers->groupBy('branch_id');
        }
    }

    $suppliers = $suppliers->get();

    return view('reports.purchases.purchaseReport.suppliers_directory', compact('branches', 'suppliers'));
}

public function balnceSuppliers(Request $request)
{
    $suppliers = Supplier::query();
    $branches = Branch::all();

    // فلترة حسب المورد
    if ($request->has('supplier_id') && $request->supplier_id != '') {
        $suppliers->where('id', $request->supplier_id);
    }

    // فلترة حسب الفرع
    if ($request->has('branch_id') && $request->branch_id != '') {
        $suppliers->where('branch_id', $request->branch_id);
    }

    // فلترة حسب التاريخ من
    if ($request->has('from_date') && $request->from_date != '') {
        $suppliers->whereDate('created_at', '>=', $request->from_date);
    }

    // فلترة حسب التاريخ إلى
    if ($request->has('to_date') && $request->to_date != '') {
        $suppliers->whereDate('created_at', '<=', $request->to_date);
    }

    // فلترة حسب إخفاء الرصيد الصفري
    if ($request->has('hideZeroBalance') && $request->hideZeroBalance == 'on') {
        $suppliers->where('opening_balance', '!=', 0);
    }

    // التجميع حسب المورد أو الفرع
    if ($request->has('group_by') && $request->group_by != '') {
        if ($request->group_by == 'supplier') {
            $suppliers->groupBy('id');
        } elseif ($request->group_by == 'branch') {
            $suppliers->groupBy('branch_id');
        }
    }

    $suppliers = $suppliers->get();

    return view('reports.purchases.purchaseReport.balance_suppliers', compact('suppliers', 'branches'));
}

public function purchaseSupplier(Request $request)
{
    $suppliers = Supplier::all();
    $branches = Branch::all();

    // جلب فواتير الشراء مع العلاقات
    $purchaseInvoices = PurchaseInvoice::query()
        ->with(['supplier', 'branch'])
        ->when($request->supplier_id, function ($query) use ($request) {
            $query->where('supplier_id', $request->supplier_id);
        })
        ->when($request->branch_id, function ($query) use ($request) {
            $query->where('branch_id', $request->branch_id);
        })
        ->when($request->from_date, function ($query) use ($request) {
            $query->whereDate('date', '>=', $request->from_date);
        })
        ->when($request->to_date, function ($query) use ($request) {
            $query->whereDate('date', '<=', $request->to_date);
        })
        ->orderBy('supplier_id')
        ->orderBy('date', $request->order_by == 'asc' ? 'asc' : 'desc')
        ->get();

    // تجميع الفواتير حسب المورد
    $groupedInvoices = $purchaseInvoices->groupBy('supplier_id');

    // حساب الإجمالي الكلي
    $totalSubtotal = $purchaseInvoices->sum('subtotal');
    $totalDiscount = $purchaseInvoices->sum('total_discount');
    $totalTax = $purchaseInvoices->sum('total_tax');
    $totalGrandTotal = $purchaseInvoices->sum('grand_total');

    // بيانات المخطط الدائري
    $chartData = [
        'labels' => $groupedInvoices->map(function ($invoices) {
            return $invoices->first()->supplier->trade_name;
        }),
        'data' => $groupedInvoices->map(function ($invoices) {
            return $invoices->sum('grand_total');
        }),
    ];

    return view('reports.purchases.purchaseReport.purchaseSupplier', compact('groupedInvoices', 'suppliers', 'branches', 'totalSubtotal', 'totalDiscount', 'totalTax', 'totalGrandTotal', 'chartData'));
}
public function paymentPurchases(Request $request)
{
    $suppliers = Supplier::all();
    $branches = Branch::all();

    // جلب فواتير الشراء مع العلاقات
    $purchaseInvoices = PurchaseInvoice::query()
        ->with(['supplier', 'branch', 'payments_process']) // تحميل العلاقات
        ->when($request->supplier_id, function ($query) use ($request) {
            $query->where('supplier_id', $request->supplier_id);
        })
        ->when($request->branch_id, function ($query) use ($request) {
            $query->where('branch_id', $request->branch_id);
        })
        ->when($request->from_date, function ($query) use ($request) {
            $query->whereDate('date', '>=', $request->from_date);
        })
        ->when($request->to_date, function ($query) use ($request) {
            $query->whereDate('date', '<=', $request->to_date);
        })
        ->whereNotNull('supplier_id') // تصفية الفواتير التي تحتوي على supplier_id
        ->orderBy('date', $request->order_by == 'asc' ? 'asc' : 'desc')
        ->get();

    // تجميع الفواتير حسب المورد
    $groupedInvoices = $purchaseInvoices->groupBy('supplier_id');

    // حساب الإجمالي الكلي
    $totalGrandTotal = $purchaseInvoices->sum('grand_total');
    $totalPaid = $purchaseInvoices->sum(function ($invoice) {
        return $invoice->payments_process->sum('amount');
    });
    $totalRemaining = $totalGrandTotal - $totalPaid;

    // بيانات المخطط البياني
    $chartData = [
        'labels' => $groupedInvoices->map(function ($invoices) {
            return $invoices->first()->supplier->trade_name ?? 'غير معروف'; // استخدام قيمة افتراضية إذا كان supplier غير موجود
        }),
        'data' => $groupedInvoices->map(function ($invoices) {
            return $invoices->sum('grand_total');
        }),
    ];

    return view('reports.purchases.purchaseReport.paymentPurchases', compact('groupedInvoices', 'suppliers', 'branches', 'totalGrandTotal', 'totalPaid', 'totalRemaining', 'chartData'));
}
public function prodectPurchases(Request $request)
{
    // جلب البيانات المطلوبة للفلترة
    $suppliers = Supplier::all();
    $employees = Employee::all();
    $products = Product::all();

    // جلب فواتير المنتجات مع العلاقات
    $productInvoices = InvoiceItem::query()
        ->with(['product', 'invoice', 'purchaseInvoice', 'employee'])
        ->when($request->supplier_id, function ($query) use ($request) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('supplier_id', $request->supplier_id);
            });
        })
        ->when($request->employee_id, function ($query) use ($request) {
            $query->whereHas('invoice', function ($q) use ($request) {
                $q->where('employee_id', $request->employee_id);
            });
        })
        ->when($request->product_id, function ($query) use ($request) {
            $query->where('product_id', $request->product_id);
        })
        ->when($request->from_date, function ($query) use ($request) {
            $query->whereDate('created_at', '>=', $request->from_date);
        })
        ->when($request->to_date, function ($query) use ($request) {
            $query->whereDate('created_at', '<=', $request->to_date);
        })
        ->orderBy('created_at', $request->order_by == 'asc' ? 'asc' : 'desc')
        ->get();

    // تجميع الفواتير حسب المنتج
    $groupedInvoices = $productInvoices->groupBy('product_id');

    // حساب الإجماليات لكل منتج
    $productTotals = [];
    foreach ($groupedInvoices as $productId => $invoices) {
        $productTotals[$productId] = [
            'total_quantity' => $invoices->sum('quantity'),
            'total_tax' => $invoices->sum(function ($invoice) {
                return $invoice->tax_1 + $invoice->tax_2;
            }),
            'total_amount' => $invoices->sum('total'),
        ];
    }

    // حساب الإجماليات الكلية
    $totalQuantity = $productInvoices->sum('quantity');
    $totalTax = $productInvoices->sum(function ($invoice) {
        return $invoice->tax_1 + $invoice->tax_2;
    });
    $totalAmount = $productInvoices->sum('total');

    // بيانات المخطط البياني
    $chartData = [
        'labels' => $groupedInvoices->map(function ($invoices) {
            return $invoices->first()->supplier->trade_name ?? 'غير معروف'; // استخدام قيمة افتراضية إذا كان supplier غير موجود
        }),
        'data' => $groupedInvoices->map(function ($invoices) {
            return $invoices->sum('grand_total');
        }),
    ];

    return view('reports.purchases.prodect.prodect_purchases', compact('groupedInvoices', 'productTotals', 'chartData', 'suppliers', 'employees', 'products', 'totalQuantity', 'totalTax', 'totalAmount'));
}
public function supplierPurchases(Request $request)
{
    // جلب البيانات المطلوبة للفلترة
    $suppliers = Supplier::all();
    $employees = Employee::all();
    $products = Product::all();

    // جلب فواتير المنتجات مع العلاقات
    $productInvoices = InvoiceItem::query()
        ->with(['product', 'invoice', 'purchaseInvoice.supplier', 'purchaseInvoice.creator']) // تحميل العلاقة مع purchaseInvoice.supplier
        ->when($request->supplier_id, function ($query) use ($request) {
            $query->whereHas('purchaseInvoice', function ($q) use ($request) {
                $q->where('supplier_id', $request->supplier_id);
            });
        })
        ->when($request->employee_id, function ($query) use ($request) {
            $query->whereHas('invoice', function ($q) use ($request) {
                $q->where('employee_id', $request->employee_id);
            });
        })
        ->when($request->product_id, function ($query) use ($request) {
            $query->where('product_id', $request->product_id);
        })
        ->when($request->from_date, function ($query) use ($request) {
            $query->whereDate('created_at', '>=', $request->from_date);
        })
        ->when($request->to_date, function ($query) use ($request) {
            $query->whereDate('created_at', '<=', $request->to_date);
        })
        ->orderBy('created_at', $request->order_by == 'asc' ? 'asc' : 'desc')
        ->get();

    // تجميع الفواتير حسب المورد
    $groupedInvoices = $productInvoices->groupBy('purchaseInvoice.supplier_id');

    // حساب الإجماليات لكل مورد
    $supplierTotals = [];
    foreach ($groupedInvoices as $supplierId => $invoices) {
        $supplierTotals[$supplierId] = [
            'total_quantity' => $invoices->sum('quantity'),
            'total_tax' => $invoices->sum(function ($invoice) {
                return $invoice->tax_1 + $invoice->tax_2;
            }),
            'total_amount' => $invoices->sum('total'),
        ];
    }

    // حساب الإجماليات الكلية
    $totalQuantity = $productInvoices->sum('quantity');
    $totalTax = $productInvoices->sum(function ($invoice) {
        return $invoice->tax_1 + $invoice->tax_2;
    });
    $totalAmount = $productInvoices->sum('total');

    // بيانات المخطط البياني
    $chartData = [
        'labels' => $groupedInvoices->map(function ($invoices) {
            return $invoices->first()->purchaseInvoice->supplier->trade_name ?? 'غير معروف'; // استخدام قيمة افتراضية إذا كان supplier غير موجود
        }),
        'data' => $groupedInvoices->map(function ($invoices) {
            return $invoices->sum('total');
        }),
    ];

    return view('reports.purchases.prodect.supplier_purchases', compact('groupedInvoices', 'supplierTotals', 'chartData', 'suppliers', 'employees', 'products', 'totalQuantity', 'totalTax', 'totalAmount'));
}
public function employeePurchases(Request $request)
{
    // جلب البيانات المطلوبة للفلترة
    $suppliers = Supplier::all();
    $employees = Employee::all();
    $products = Product::all();

    // جلب فواتير المنتجات مع العلاقات
    $productInvoices = InvoiceItem::query()
        ->with(['product', 'purchaseInvoice.creator', 'purchaseInvoice.supplier']) // تحميل العلاقة مع invoice.employee
        ->when($request->supplier_id, function ($query) use ($request) {
            $query->whereHas('purchaseInvoice', function ($q) use ($request) {
                $q->where('supplier_id', $request->supplier_id);
            });
        })
        ->when($request->employee_id, function ($query) use ($request) {
            $query->whereHas('invoice', function ($q) use ($request) {
                $q->where('employee_id', $request->employee_id);
            });
        })
        ->when($request->product_id, function ($query) use ($request) {
            $query->where('product_id', $request->product_id);
        })
        ->when($request->from_date, function ($query) use ($request) {
            $query->whereDate('created_at', '>=', $request->from_date);
        })
        ->when($request->to_date, function ($query) use ($request) {
            $query->whereDate('created_at', '<=', $request->to_date);
        })
        ->orderBy('created_at', $request->order_by == 'asc' ? 'asc' : 'desc')
        ->get();

    // تجميع الفواتير حسب الموظف
    $groupedInvoices = $productInvoices->groupBy('invoice.employee_id');

    // حساب الإجماليات لكل موظف
    $employeeTotals = [];
    foreach ($groupedInvoices as $employeeId => $invoices) {
        $employeeTotals[$employeeId] = [
            'total_quantity' => $invoices->sum('quantity'),
            'total_tax' => $invoices->sum(function ($invoice) {
                return $invoice->tax_1 + $invoice->tax_2;
            }),
            'total_amount' => $invoices->sum('total'),
        ];
    }

    // حساب الإجماليات الكلية
    $totalQuantity = $productInvoices->sum('quantity');
    $totalTax = $productInvoices->sum(function ($invoice) {
        return $invoice->tax_1 + $invoice->tax_2;
    });
    $totalAmount = $productInvoices->sum('total');

    // بيانات المخطط البياني
    $chartData = [
        'labels' => $groupedInvoices->map(function ($invoices) {
            return $invoices->first()->invoice->employee->full_name ?? 'غير معروف'; // استخدام قيمة افتراضية إذا كان employee غير موجود
        }),
        'data' => $groupedInvoices->map(function ($invoices) {
            return $invoices->sum('total');
        }),
    ];

    return view('reports.purchases.prodect.employee_purchases', compact('groupedInvoices', 'employeeTotals', 'chartData', 'suppliers', 'employees', 'products', 'totalQuantity', 'totalTax', 'totalAmount'));
}

public function supplierPayments(Request $request)
{
    try {
        // Default to current month if no date range specified
        $fromDate = $request->input('from_date', Carbon::now()->startOfMonth());
        $toDate = $request->input('to_date', Carbon::now()->endOfMonth());

        $employees = Employee::all();
        $branches = Branch::all();

        // Default report period
        $reportPeriod = $request->input('report_period', 'monthly');

        // Base query for payments
        $query = PaymentsProcess::with(['supplier', 'purchase', 'employee','purchase.creator'])
            ->whereNotNull('purchases_id')
            ->whereBetween('payment_date', [$fromDate, $toDate]);

        // Apply filters
        if ($request->filled('supplier')) {
            $query->where('supplier_id', $request->input('supplier'));
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->input('payment_method'));
        }

        if ($request->filled('employee')) {
            $query->where('employee_id', $request->input('employee'));
        }

        if ($request->filled('branch')) {
            $query->where('branch_id', $request->input('branch'));
        }

        // Fetch payments
        $payments = $query->get();

        // Group payments based on report period
        $groupedPayments = $payments->groupBy(function ($payment) use ($reportPeriod) {
            switch ($reportPeriod) {
                case 'daily':
                    return $payment->payment_date->format('Y-m-d');
                case 'weekly':
                    return $payment->payment_date->format('Y-W');
                case 'monthly':
                    return $payment->payment_date->format('Y-m');
                case 'yearly':
                    return $payment->payment_date->format('Y');
                default:
                    return $payment->payment_date->format('Y-m-d');
            }
        });

        // Prepare chart data
        $chartData = [
            'labels' => $groupedPayments->keys()->toArray(),
            'values' => $groupedPayments
                ->map(function ($periodPayments) {
                    return $periodPayments->sum('amount');
                })
                ->values()
                ->toArray(),
            'paymentMethods' => [
                $payments->where('payment_method', 1)->count(), // Cash
                $payments->where('payment_method', 2)->count(), // Check
                $payments->where('payment_method', 3)->count(), // Bank Transfer
            ],
        ];

        // Fetch suppliers for filter dropdown
        $suppliers = Supplier::all();

        return view('reports.purchases.purchaseReport.supplier_payments', [
            'payments' => $payments,
            'groupedPayments' => $groupedPayments,
            'chartData' => $chartData,
            'suppliers' => $suppliers,
            'fromDate' => Carbon::parse($fromDate),
            'toDate' => Carbon::parse($toDate),
            'reportPeriod' => $reportPeriod,
            'employees' => $employees,
            'branches' => $branches,
        ]);
    } catch (\Exception $e) {
        // Log the full error
        Log::error('Error in supplier payments report', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        // Return an error view or redirect with a message
        return back()->with('error', 'حدث خطأ أثناء إنشاء التقرير: ' . $e->getMessage());
    }
}

}

