<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\CategoriesClient;
use App\Models\Category;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\PaymentsProcess;
use App\Models\Product;
use App\Models\Status;
use App\Models\StoreHouse;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpParser\Builder\Function_;

class SalesReportsController extends Controller
{
    // تقارير المبيعات
    public function index()
    {
        return view('reports.sals.index');
    }
    public function byCustomer(Request $request)
    {
        // 1. التحقق من صحة البيانات المدخلة
        $validatedData = $request->validate([
            'category' => 'nullable|exists:categories_clients,id',
            'client' => 'nullable|exists:clients,id',
            'branch' => 'nullable|exists:branches,id',
            'status' => 'nullable|in:0,1,5',
            'order_origin' => 'nullable|exists:employees,id',
            'added_by' => 'nullable|exists:users,id',
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date|after_or_equal:from_date',
            'report_type' => 'nullable|in:daily,weekly,monthly,yearly,sales_manager,employee,returns',
        ]);

        // 2. الحصول على البيانات الأساسية للقوائم المنسدلة
        $employees = Employee::all();
        $branches = Branch::all();
        $categories = CategoriesClient::all();
        $clients = Client::with('branch')->get();
        $users = User::where('role', 'employee')->get();

        // 3. بناء استعلام الفواتير مع العلاقات
        $invoices = Invoice::with(['client.branch', 'createdByUser', 'employee']);

        // 4. تطبيق الفلاتر بنفس طريقة تقرير الموظفين
        if ($request->filled('category')) {
            $invoices->whereHas('client', function ($query) use ($request) {
                $query->where('category_id', $request->category);
            });
        }

        if ($request->filled('client')) {
            $invoices->where('client_id', $request->client);
        }

        if ($request->filled('branch')) {
            $invoices->whereHas('client', function ($query) use ($request) {
                $query->where('branch_id', $request->branch);
            });
        }

        if ($request->filled('status')) {
            $invoices->where('payment_status', $request->status);
        }

        if ($request->filled('order_origin')) {
            $invoices->where(function ($query) use ($request) {
                $query->where('employee_id', $request->order_origin)->orWhere('created_by', $request->order_origin);
            });
        }

        if ($request->filled('added_by')) {
            $invoices->where('created_by', $request->added_by);
        }

        // فلتر نطاق التاريخ
        $fromDate = $request->input('from_date') ? Carbon::parse($request->input('from_date')) : now()->startOfMonth();
        $toDate = $request->input('to_date') ? Carbon::parse($request->input('to_date')) : now()->endOfMonth();
        $reportPeriod = $request->input('report_period', 'monthly');

        // Adjust dates based on report period if not manually set

        $invoices->whereBetween('invoice_date', [$fromDate, $toDate]);

        // فلتر نوع التقرير
        if ($request->filled('report_type')) {
            switch ($request->report_type) {
                case 'yearly':
                    $invoices->whereYear('invoice_date', $toDate->year);
                    break;
                case 'monthly':
                    $invoices->whereMonth('invoice_date', $toDate->month);
                    break;
                case 'weekly':
                    $invoices->whereBetween('invoice_date', [$toDate->copy()->startOfWeek(), $toDate->copy()->endOfWeek()]);
                    break;
                case 'daily':
                    $invoices->whereDate('invoice_date', $toDate->toDateString());
                    break;
                case 'sales_manager':
                    $invoices->whereHas('createdByUser', function ($query) {
                        $query->whereHas('roles', function ($q) {
                            $q->where('name', 'sales_manager');
                        });
                    });
                    break;
                case 'employee':
                    $invoices->whereHas('createdByUser', function ($query) {
                        $query->whereHas('roles', function ($q) {
                            $q->where('name', 'employee');
                        });
                    });
                    break;
                case 'returns':
                    $invoices->whereIn('type', ['return', 'returned']);
                    break;
            }
        }
        if (!$request->filled('from_date') && !$request->filled('to_date')) {
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
        }

        // 5. الحصول على النتائج
        $invoices = $invoices->get();

        // 6. معالجة البيانات - التغيير الأساسي هنا للتجميع حسب العميل بدلاً من الموظف
        $groupedInvoices = collect();
        $customerTotals = collect();
        $chartData = ['labels' => [], 'values' => []];

        $totals = [
            'paid_amount' => 0,
            'unpaid_amount' => 0,
            'returned_amount' => 0,
            'total_amount' => 0,
            'total_sales' => 0,
            'total_returns' => 0,
        ];

        if ($invoices->isNotEmpty()) {
            // تجميع الفواتير حسب العميل بدلاً من الموظف
            $groupedInvoices = $invoices->groupBy('client_id');

            // حساب الإجماليات لكل عميل
            $customerTotals = $groupedInvoices->map(function ($customerInvoices, $clientId) {
                $client = $customerInvoices->first()->client;
                $clientName = $client ? $client->trade_name : 'عميل غير معروف';

                $paidAmount = $customerInvoices->where('type', '!=', ['return', 'returned'])->sum(function ($invoice) {
                    return $invoice->payment_status == 1 ? $invoice->grand_total : $invoice->paid_amount;
                });

                $unpaidAmount = $customerInvoices->where('type', '!=', ['return', 'returned'])->sum(function ($invoice) {
                    return $invoice->payment_status == 1 ? 0 : $invoice->due_value;
                });

                $returnedAmount = $customerInvoices->whereIn('type', ['return', 'returned'])->sum('grand_total');

                $totalAmount = $paidAmount + $unpaidAmount + $returnedAmount;

                return [
                    'client_id' => $clientId,
                    'client_name' => $clientName,
                    'paid_amount' => $paidAmount,
                    'unpaid_amount' => $unpaidAmount,
                    'returned_amount' => $returnedAmount,
                    'total_amount' => $totalAmount,
                    'branch_name' => $customerInvoices->first()->client->branch->name ?? 'N/A',
                ];
            });

            // إعداد بيانات الرسم البياني
            $chartData = [
                'labels' => $customerTotals->pluck('client_name'),
                'values' => $customerTotals->pluck('total_amount'),
            ];

            // حساب الإجماليات العامة
            $totals = [
                'paid_amount' => $invoices->where('type', '!=', ['return', 'returned'])->sum(function ($invoice) {
                    return $invoice->payment_status == 1 ? $invoice->grand_total : $invoice->paid_amount;
                }),
                'unpaid_amount' => $invoices->where('type', '!=', ['return', 'returned'])->sum(function ($invoice) {
                    return $invoice->payment_status == 1 ? 0 : $invoice->due_value;
                }),
                'returned_amount' => $invoices->whereIn('type', ['return', 'returned'])->sum('grand_total'),
                'total_amount' => $invoices->sum('grand_total'),
                'total_sales' => $invoices->where('type', '!=', ['return', 'returned'])->sum('grand_total'),
                'total_returns' => $invoices->whereIn('type', ['return', 'returned'])->sum('grand_total'),
            ];
        }

        // 7. إرجاع النتائج للعرض بنفس هيكل تقرير الموظفين
        return view('reports.sals.salesRport.Sales_By_Customer', compact('groupedInvoices', 'employees', 'clients', 'categories', 'branches', 'totals', 'chartData', 'fromDate', 'toDate', 'customerTotals', 'users', 'reportPeriod'));
    }
    public function byEmployee(Request $request)
    {
        // 1. التحقق من صحة البيانات المدخلة
        $validatedData = $request->validate([
            'category' => 'nullable|exists:categories_clients,id',
            'client' => 'nullable|exists:clients,id',
            'branch' => 'nullable|exists:branches,id',
            'status' => 'nullable|in:0,1,5',
            'order_origin' => 'nullable|exists:employees,id',
            'added_by' => 'nullable|exists:users,id',
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date|after_or_equal:from_date',
            'report_type' => 'nullable|in:daily,weekly,monthly,yearly,sales_manager,employee,returns',
        ]);

        // 2. الحصول على البيانات الأساسية للقوائم المنسدلة
        $employees = Employee::all();
        $branches = Branch::all();
        $categories = CategoriesClient::all();
        $clients = Client::with('branch')->get();
        $users = User::where('role', 'employee')->get();

        // 3. بناء استعلام الفواتير مع العلاقات
        $invoices = Invoice::with(['client.branch', 'createdByUser', 'employee']);

        // 4. تطبيق الفلاتر
        // فلتر فئة العميل
        if ($request->filled('category')) {
            $invoices->whereHas('client', function ($query) use ($request) {
                $query->where('category_id', $request->category);
            });
        }

        // فلتر العميل
        if ($request->filled('client')) {
            $invoices->where('client_id', $request->client);
        }

        // فلتر الفرع
        if ($request->filled('branch')) {
            $invoices->whereHas('client', function ($query) use ($request) {
                $query->where('branch_id', $request->branch);
            });
        }

        // فلتر حالة الدفع
        if ($request->filled('status')) {
            $invoices->where('payment_status', $request->status);
        }

        // فلتر الموظف
        if ($request->filled('order_origin')) {
            $invoices->where(function ($query) use ($request) {
                $query->where('employee_id', $request->order_origin)->orWhere('created_by', $request->order_origin);
            });
        }

        // فلتر المضيف بواسطة
        if ($request->filled('added_by')) {
            $invoices->where('created_by', $request->added_by);
        }

        // فلتر نطاق التاريخ
        $fromDate = $request->input('from_date') ? Carbon::parse($request->input('from_date')) : now()->subMonth();
        $toDate = $request->input('to_date') ? Carbon::parse($request->input('to_date')) : now();
        $invoices->whereBetween('invoice_date', [$fromDate, $toDate]);

        // فلتر نوع التقرير
        if ($request->filled('report_type')) {
            switch ($request->report_type) {
                case 'yearly':
                    $invoices->whereYear('invoice_date', $toDate->year);
                    break;
                case 'monthly':
                    $invoices->whereMonth('invoice_date', $toDate->month);
                    break;
                case 'weekly':
                    $invoices->whereBetween('invoice_date', [$toDate->copy()->startOfWeek(), $toDate->copy()->endOfWeek()]);
                    break;
                case 'daily':
                    $invoices->whereDate('invoice_date', $toDate->toDateString());
                    break;
                case 'sales_manager':
                    $invoices->whereHas('createdByUser', function ($query) {
                        $query->whereHas('roles', function ($q) {
                            $q->where('name', 'sales_manager');
                        });
                    });
                    break;
                case 'employee':
                    $invoices->whereHas('createdByUser', function ($query) {
                        $query->whereHas('roles', function ($q) {
                            $q->where('name', 'employee');
                        });
                    });
                    break;
                case 'returns':
                    $invoices->whereIn('type', ['return', 'returned']);
                    break;
            }
        }

        // 5. الحصول على النتائج
        $invoices = $invoices->get();

        // 6. معالجة البيانات
        $groupedInvoices = collect();
        $employeeTotals = collect();
        $chartData = ['labels' => [], 'values' => []];

        $totals = [
            'paid_amount' => 0,
            'unpaid_amount' => 0,
            'returned_amount' => 0,
            'total_amount' => 0,
            'total_sales' => 0, // تمت إضافتها لحل المشكلة
        ];

        if ($invoices->isNotEmpty()) {
            // تجميع الفواتير حسب الموظف
            $groupedInvoices = $invoices->groupBy(function ($invoice) {
                return $invoice->employee_id ?? $invoice->created_by;
            });

            // حساب الإجماليات لكل موظف
            $employeeTotals = $groupedInvoices->map(function ($employeeInvoices, $employeeId) {
                $employee = $employeeInvoices->first()->employee ?? $employeeInvoices->first()->createdByUser;
                $employeeName = $employee ? $employee->name : 'موظف غير معروف';

                $paidAmount = $employeeInvoices->where('type', '!=', ['return', 'returned'])->sum(function ($invoice) {
                    return $invoice->payment_status == 1 ? $invoice->grand_total : $invoice->paid_amount;
                });

                $unpaidAmount = $employeeInvoices->where('type', '!=', ['return', 'returned'])->sum(function ($invoice) {
                    return $invoice->payment_status == 1 ? 0 : $invoice->due_value;
                });

                $returnedAmount = $employeeInvoices->whereIn('type', ['return', 'returned'])->sum('grand_total');

                $totalAmount = $paidAmount + $unpaidAmount + $returnedAmount;

                return [
                    'employee_id' => $employeeId,
                    'employee_name' => $employeeName,
                    'paid_amount' => $paidAmount,
                    'unpaid_amount' => $unpaidAmount,
                    'returned_amount' => $returnedAmount,
                    'total_amount' => $totalAmount,
                    'branch_name' => $employeeInvoices->first()->client->branch->name ?? 'N/A',
                ];
            });

            // إعداد بيانات الرسم البياني
            $chartData = [
                'labels' => $employeeTotals->pluck('employee_name'),
                'values' => $employeeTotals->pluck('total_amount'),
            ];

            // حساب الإجماليات العامة
            $totals = [
                'paid_amount' => $invoices->where('type', '!=', ['return', 'returned'])->sum(function ($invoice) {
                    return $invoice->payment_status == 1 ? $invoice->grand_total : $invoice->paid_amount;
                }),
                'unpaid_amount' => $invoices->where('type', '!=', ['return', 'returned'])->sum(function ($invoice) {
                    return $invoice->payment_status == 1 ? 0 : $invoice->due_value;
                }),
                'returned_amount' => $invoices->whereIn('type', ['return', 'returned'])->sum('grand_total'),
                'total_amount' => $invoices->sum('grand_total'),
                'total_sales' => $invoices->where('type', '!=', ['return', 'returned'])->sum('grand_total'),
                'total_returns' => $invoices
                    ->whereIn('type', ['return', 'returned']) // أضف هذا السطر
                    ->sum('grand_total'),
            ];
        }

        // 7. إرجاع النتائج للعرض
        return view('reports.sals.salesRport.Sales_By_Employee', compact('groupedInvoices', 'employees', 'clients', 'categories', 'branches', 'totals', 'chartData', 'fromDate', 'toDate', 'employeeTotals', 'users'));
    }
    private function prepareChartData($invoices)
    {
        // Group invoices by type for charts
        $typeGroups = $invoices->groupBy('type');

        $labels = [
            'sale' => 'فاتورة',
            'return' => 'مرتجع',
            'debit_note' => 'اشعار مدين',
            'credit_note' => 'اشعار دائن',
        ];

        $chartData = [
            'labels' => [],
            'quantities' => [],
            'amounts' => [],
        ];

        foreach ($labels as $type => $label) {
            $typeInvoices = $typeGroups->get($type, collect());

            $chartData['labels'][] = $label;
            $chartData['quantities'][] = $typeInvoices->sum('items_count');
            $chartData['amounts'][] = $typeInvoices->sum('total_amount');
        }

        return $chartData;
    }

    public function byProduct(Request $request)
{
    // التحقق من صحة المدخلات
    $validated = $request->validate([
        'product' => 'nullable|exists:products,id',
        'category' => 'nullable|exists:categories,id',
        'branch' => 'nullable|exists:branches,id',
        'client' => 'nullable|exists:clients,id',
        'client_category' => 'nullable|exists:categories_clients,id',
        'employee' => 'nullable|exists:users,id',
        'invoice_type' => 'nullable|in:normal,return,debit_note,credit_note',
        'storehouse' => 'nullable|exists:store_houses,id',
        'from_date' => 'nullable|date',
        'to_date' => 'nullable|date|after_or_equal:from_date',
        'report_period' => 'nullable|in:daily,weekly,monthly,yearly,custom',
        'include_drafts' => 'nullable|boolean',
    ]);

    // جلب البيانات للقوائم المنسدلة
    $products = Product::orderBy('name')->get();
    $categories = Category::orderBy('name')->get();
    $employees = User::where('role', 'employee')->get();
    $branches = Branch::orderBy('name')->get();
    $storehouses = StoreHouse::all();
    $clients = Client::orderBy('trade_name')->get();
    $client_categories = CategoriesClient::orderBy('name')->get();

    // بناء الاستعلام الأساسي مع العلاقات
    $query = InvoiceItem::with([
        'product.category',
        'invoice' => function ($q) {
            $q->with(['client', 'branch', 'createdByUser']);
        },
         // إضافة علاقة المخزن من عنصر الفاتورة
    ]);

    // تطبيق الفلاتر الأساسية
    if ($request->filled('product')) {
        $query->where('product_id', $request->product);
    }

    if ($request->filled('category')) {
        $query->whereHas('product', function ($q) use ($request) {
            $q->where('category_id', $request->category);
        });
    }

    // فلترة حسب الفرع (من العميل أو من الفاتورة مباشرة)
    if ($request->filled('branch')) {
        $query->where(function($q) use ($request) {
            $q->whereHas('invoice.client', function($q) use ($request) {
                $q->where('branch_id', $request->branch);
            })->orWhereHas('invoice', function($q) use ($request) {
                $q->where('branch_id', $request->branch);
            });
        });
    }

    if ($request->filled('client')) {
        $query->whereHas('invoice.client', function ($q) use ($request) {
            $q->where('id', $request->client);
        });
    }

    if ($request->filled('client_category')) {
        $query->whereHas('invoice.client.category', function ($q) use ($request) {
            $q->where('id', $request->client_category);
        });
    }

    if ($request->filled('employee')) {
        $query->whereHas('invoice.createdByUser', function ($q) use ($request) {
            $q->where('id', $request->employee);
        });
    }

    if ($request->filled('invoice_type')) {
        $query->whereHas('invoice', function ($q) use ($request) {
            $q->where('type', $request->invoice_type);
        });
    }

    // فلترة حسب المخزن (من عنصر الفاتورة أو من الفاتورة نفسها)
    if ($request->filled('storehouse')) {
        $query->where(function($q) use ($request) {
            $q->where('store_house_id', $request->storehouse)
              ->orWhereHas('invoice', function($q) use ($request) {
                  $q->where('storehouse_id', $request->storehouse);
              });
        });
    }

    // فلترة حسب الفترة الزمنية
    $fromDate = $request->input('from_date') ? Carbon::parse($request->input('from_date')) : now()->subMonth();
    $toDate = $request->input('to_date') ? Carbon::parse($request->input('to_date')) : now();

    if ($request->filled('report_period') && $request->report_period != 'custom') {
        switch ($request->report_period) {
            case 'daily':
                $fromDate = Carbon::today();
                $toDate = Carbon::today();
                break;
            case 'weekly':
                $fromDate = Carbon::now()->startOfWeek();
                $toDate = Carbon::now()->endOfWeek();
                break;
            case 'monthly':
                $fromDate = Carbon::now()->startOfMonth();
                $toDate = Carbon::now()->endOfMonth();
                break;
            case 'yearly':
                $fromDate = Carbon::now()->startOfYear();
                $toDate = Carbon::now()->endOfYear();
                break;
        }
    }

    $query->whereHas('invoice', function ($q) use ($fromDate, $toDate) {
        $q->whereBetween('invoice_date', [$fromDate, $toDate]);
    });

    // تضمين المسودات إذا طلب المستخدم
    if (!$request->boolean('include_drafts')) {
        $query->whereHas('invoice', function ($q) {
            $q->where('payment_status', '!=', 'draft');
        });
    }

    // جلب البيانات مع التجميع
    $productSales = $query->get();

    // حساب الإحصائيات العامة
    $totalQuantity = $productSales->sum('quantity');
    $totalAmount = $productSales->sum(function ($item) {
        return $item->quantity * $item->unit_price;
    });
    $totalDiscount = $productSales->sum('discount_amount');
    $totalInvoices = $productSales->groupBy('invoice_id')->count();

    // حساب الإحصائيات حسب نوع الفاتورة
    $statsByInvoiceType = [
        'normal' => [
            'quantity' => $productSales->where('invoice.type', 'normal')->sum('quantity'),
            'amount' => $productSales->where('invoice.type', 'normal')->sum(function ($item) {
                return $item->quantity * $item->unit_price;
            }),
        ],
        'return' => [
            'quantity' => $productSales->where('invoice.type', 'return')->sum('quantity'),
            'amount' => $productSales->where('invoice.type', 'return')->sum(function ($item) {
                return $item->quantity * $item->unit_price;
            }),
        ],
        'debit_note' => [
            'quantity' => $productSales->where('invoice.type', 'debit_note')->sum('quantity'),
            'amount' => $productSales->where('invoice.type', 'debit_note')->sum(function ($item) {
                return $item->quantity * $item->unit_price;
            }),
        ],
        'credit_note' => [
            'quantity' => $productSales->where('invoice.type', 'credit_note')->sum('quantity'),
            'amount' => $productSales->where('invoice.type', 'credit_note')->sum(function ($item) {
                return $item->quantity * $item->unit_price;
            }),
        ],
    ];

    // تجميع البيانات حسب المنتج مع تضمين معلومات المخزن والفرع
    $productSummary = $productSales
        ->groupBy('product_id')
        ->map(function ($items, $productId) {
            $firstItem = $items->first();

            // تجميع المخازن المستخدمة لهذا المنتج
            $storehouses = $items->groupBy('store_house_id')->map(function ($storeItems) {
                $firstStoreItem = $storeItems->first();
                return [
                    'id' => $firstStoreItem->store_house_id,
                    'name' => optional($firstStoreItem->storeHouse)->name,
                    'quantity' => $storeItems->sum('quantity')
                ];
            })->values();

            // تجميع الفروع المستخدمة لهذا المنتج
            $branches = $items->groupBy('invoice.branch_id')->map(function ($branchItems) {
                $firstBranchItem = $branchItems->first();
                return [
                    'id' => $firstBranchItem->invoice->branch_id,
                    'name' => optional($firstBranchItem->invoice->branch)->name,
                    'quantity' => $branchItems->sum('quantity')
                ];
            })->values();

            return (object) [
                'id' => $productId,
                'name' => $firstItem->product->name,
                'code' => $firstItem->product->code,
                'category' => $firstItem->product->category,
                'total_quantity' => $items->sum('quantity'),
                'total_amount' => $items->sum(function ($item) {
                    return $item->quantity * $item->unit_price;
                }),
                'total_discount' => $items->sum('discount_amount'),
                'invoices_count' => $items->groupBy('invoice_id')->count(),
                'storehouses' => $storehouses,
                'branches' => $branches,
            ];
        })
        ->sortByDesc('total_amount');

    // إعداد بيانات الرسوم البيانية
    $chartData = [
        'labels' => $productSummary->pluck('name')->toArray(),
        'quantities' => $productSummary->pluck('total_quantity')->toArray(),
        'amounts' => $productSummary->pluck('total_amount')->toArray(),
    ];

    return view('reports.sals.salesRport.by_Product', compact(
        'products', 'categories', 'employees', 'branches', 'clients',
        'client_categories', 'storehouses', 'productSales', 'productSummary',
        'totalQuantity', 'totalAmount', 'totalDiscount', 'totalInvoices',
        'statsByInvoiceType', 'chartData', 'fromDate', 'toDate'
    ))->with('reportPeriod', $request->input('report_period', 'daily'));
}
public function clientPaymentReport(Request $request)
{
    // 1. التحقق من صحة البيانات المدخلة
    $validatedData = $request->validate([
        'client' => 'nullable|exists:clients,id',
        'branch' => 'nullable|exists:branches,id',
        'customer_category' => 'nullable|exists:categories_clients,id',
        'payment_method' => 'nullable|in:1,2,3,4',
        'collector' => 'nullable|exists:users,id',
        'from_date' => 'nullable|date',
        'to_date' => 'nullable|date|after_or_equal:from_date',
    ]);

    // 2. جلب البيانات الأساسية للقوائم المنسدلة
    $clients = Client::orderBy('trade_name')->get();
    $branches = Branch::orderBy('name')->get();
    $customerCategories = CategoriesClient::orderBy('name')->get();
    $employees = User::where('role','employee')->get();
    $paymentMethods = [
        ['id' => 1, 'name' => 'نقدي'],
        ['id' => 2, 'name' => 'شيك'],
        ['id' => 3, 'name' => 'تحويل بنكي'],
        ['id' => 4, 'name' => 'بطاقة ائتمان']
    ];

    // 3. تحديد نطاق التاريخ
    $fromDate = $request->input('from_date', now()->startOfMonth()->format('Y-m-d'));
    $toDate = $request->input('to_date', now()->endOfMonth()->format('Y-m-d'));

    $fromDate = Carbon::parse($fromDate)->startOfDay();
    $toDate = Carbon::parse($toDate)->endOfDay();

    // 4. بناء الاستعلام الأساسي
    $query = PaymentsProcess::with(['client', 'employee', 'invoice'])
                ->whereBetween('payment_date', [$fromDate, $toDate]);

    // 5. تطبيق الفلاتر
    if ($request->filled('customer_category')) {
        $query->whereHas('client', function($q) use ($request) {
            $q->where('category_id', $request->customer_category);
        });
    }

    if ($request->filled('client')) {
        $query->where('client_id', $request->client);
    }

    if ($request->filled('branch')) {
        $query->whereHas('invoice.client', function($q) use ($request) {
            $q->where('branch_id', $request->branch);


        });
    }

    if ($request->filled('payment_method')) {
        $query->where('payment_method', $request->payment_method);
    }

    if ($request->filled('collector')) {
        $query->whereHas('invoice', function($q) use ($request) {
            $q->where('created_by', $request->collector);
        });

    }

    // 6. جلب النتائج
    $payments = $query->orderBy('payment_date', 'desc')->get();

    // 7. إعداد بيانات الرسم البياني
    $groupedForChart = $payments->groupBy(function($item) {
        return $item->client->trade_name ?? 'غير محدد';
    });

    $chartLabels = [];
    $chartValues = [];

    foreach ($groupedForChart as $client => $clientPayments) {
        $chartLabels[] = $client;
        $chartValues[] = $clientPayments->sum('amount');
    }

    $chartData = [
        'labels' => $chartLabels,
        'values' => $chartValues
    ];

    // 8. حساب الإجماليات
    $summaryTotals = [
        'total_paid' => $payments->sum('amount'),
        'total_unpaid' => $payments->sum(function($payment) {
            return $payment->invoice ? $payment->invoice->due_value : 0;
        }),
    ];

    // 9. إرجاع النتائج للعرض
    return view('reports.sals.payments.client_report', [
        'payments' => $payments,
        'clients' => $clients,
        'branches' => $branches,
        'customerCategories' => $customerCategories,
        'employees' => $employees,
        'paymentMethods' => $paymentMethods,
        'chartData' => $chartData,
        'summaryTotals' => $summaryTotals,
        'fromDate' => $fromDate,
        'toDate' => $toDate,
        'filters' => $request->all() // لحفظ حالة الفلاتر
    ]);
}

    // Helper method to prepare chart data
    protected function prepareChartData1($payments)
    {
        // Group payments by client
        $groupedPayments = $payments->groupBy('clients_id');

        $chartLabels = [];
        $chartValues = [];

        foreach ($groupedPayments as $clientId => $clientPayments) {
            $client = Client::find($clientId);
            $chartLabels[] = $client ? $client->trade_name : "عميل $clientId";
            $chartValues[] = $clientPayments->sum('amount');
        }

        return [
            'labels' => $chartLabels,
            'values' => $chartValues,
        ];
    }
    public function employeePaymentReport(Request $request)
    {
        // 1. التحقق من صحة البيانات المدخلة
        $validatedData = $request->validate([
            'employee' => 'nullable|exists:users,id',
            'branch' => 'nullable|exists:branches,id',
            'payment_method' => 'nullable|in:1,2,3,4',
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date|after_or_equal:from_date',
        ]);

        // 2. جلب البيانات الأساسية للقوائم المنسدلة
        $employees = User::where('role', 'employee')->orderBy('name')->get();
$clients=Client::all();
        $branches = Branch::orderBy('name')->get();
        $paymentMethods = [
            ['id' => 1, 'name' => 'نقدي'],
            ['id' => 2, 'name' => 'شيك'],
            ['id' => 3, 'name' => 'تحويل بنكي'],
            ['id' => 4, 'name' => 'بطاقة ائتمان']
        ];

        // 3. تحديد نطاق التاريخ
        $fromDate = $request->input('from_date', now()->startOfMonth()->format('Y-m-d'));
        $toDate = $request->input('to_date', now()->endOfMonth()->format('Y-m-d'));

        $fromDate = Carbon::parse($fromDate)->startOfDay();
        $toDate = Carbon::parse($toDate)->endOfDay();

        // 4. بناء الاستعلام الأساسي
        $query = PaymentsProcess::with(['employee', 'invoice'])
                    ->whereBetween('payment_date', [$fromDate, $toDate]);

        // 5. تطبيق الفلاتر
        if ($request->filled('collector')) {
            $query->whereHas('invoice', function($q) use ($request) {
                $q->where('created_by', $request->collector);
            });

        }

        if ($request->filled('client')) {
            $query->where('client_id', $request->client);
        }
        if ($request->filled('branch')) {
            $query->whereHas('invoice.client', function($q) use ($request) {
                $q->where('branch_id', $request->branch);


            });
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // 6. جلب النتائج
        $payments = $query->orderBy('payment_date', 'desc')->get();

        // 7. إعداد بيانات الرسم البياني للموظفين
        $groupedForChart = $payments->groupBy(function($item) {
            return $item->employee->name ?? 'غير محدد';
        });

        $chartLabels = [];
        $chartValues = [];

        foreach ($groupedForChart as $employee => $employeePayments) {
            $chartLabels[] = $employee;
            $chartValues[] = $employeePayments->sum('amount');
        }

        $chartData = [
            'labels' => $chartLabels,
            'values' => $chartValues
        ];

        // 8. حساب الإجماليات
        $summaryTotals = [
            'total_paid' => $payments->sum('amount'),
            'total_payments' => $payments->count(),
            'average_payment' => $payments->avg('amount'),
            'total_unpaid' => $payments->sum(function($payment) {
            return $payment->invoice ? $payment->invoice->due_value : 0;
        }),
        ];

        // 9. إرجاع النتائج للعرض
        return view('reports.sals.payments.employee_report', [
            'payments' => $payments,
            'employees' => $employees,
            'branches' => $branches,
            'paymentMethods' => $paymentMethods,
            'chartData' => $chartData,
            'summaryTotals' => $summaryTotals,
            'fromDate' => $fromDate,
            'toDate' => $toDate,
            'clients'=>$clients,
            'filters' => $request->all() // لحفظ حالة الفلاتر
        ]);
    }

    // Helper method to prepare chart data for employees
    protected function prepareEmployeeChartData($payments)
    {
        // Group payments by employee
        $groupedPayments = $payments->groupBy('employee_id');

        $chartLabels = [];
        $chartValues = [];

        foreach ($groupedPayments as $employeeId => $employeePayments) {
            $employee = User::find($employeeId);
            $chartLabels[] = $employee ? $employee->name : "موظف $employeeId";
            $chartValues[] = $employeePayments->sum('amount');
        }

        return [
            'labels' => $chartLabels,
            'values' => $chartValues,
        ];
    }

    public function paymentMethodReport(Request $request)
{
    // 1. التحقق من صحة البيانات المدخلة
    $validatedData = $request->validate([
        'client' => 'nullable|exists:clients,id',
        'branch' => 'nullable|exists:branches,id',
        'collector' => 'nullable|exists:employees,id',
        'payment_method' => 'nullable|in:1,2,3,4',
        'customer_category' => 'nullable|exists:customer_categories,id',
        'from_date' => 'nullable|date',
        'to_date' => 'nullable|date|after_or_equal:from_date',
    ]);

    // 2. جلب البيانات الأساسية للقوائم المنسدلة
    $clients = Client::all();
    $branches = Branch::orderBy('name')->get();
    $employees = User::where('role','employee')->get();


    $paymentMethods = [
        ['id' => 1, 'name' => 'نقدي'],
        ['id' => 2, 'name' => 'شيك'],
        ['id' => 3, 'name' => 'تحويل بنكي'],
        ['id' => 4, 'name' => 'بطاقة ائتمان']
    ];

    // 3. تحديد نطاق التاريخ
    $fromDate = $request->input('from_date', now()->startOfMonth()->format('Y-m-d'));
    $toDate = $request->input('to_date', now()->endOfMonth()->format('Y-m-d'));

    $fromDate = Carbon::parse($fromDate)->startOfDay();
    $toDate = Carbon::parse($toDate)->endOfDay();

    // 4. بناء الاستعلام الأساسي مع العلاقات
    $query = PaymentsProcess::with([

        'invoice.employee',
        'invoice.branch'
    ])->whereBetween('payment_date', [$fromDate, $toDate]);

    // 5. تطبيق الفلاتر
    if ($request->filled('client')) {
        $query->whereHas('invoice', function($q) use ($request) {
            $q->where('client_id', $request->client);
        });
    }

    if ($request->filled('collector')) {
        $query->whereHas('invoice', function($q) use ($request) {
            $q->where('created_by', $request->collector);
        });
    }

    if ($request->filled('payment_method')) {
        $query->where('payment_method', $request->payment_method);
    }

    if ($request->filled('branch')) {
        $query->whereHas('invoice.client', function($q) use ($request) {
            $q->where('branch_id', $request->branch);
        });
    }

    if ($request->filled('customer_category')) {
        $query->whereHas('invoice.client', function($q) use ($request) {
            $q->where('customer_category_id', $request->customer_category);
        });
    }

    // 6. جلب النتائج مع الترحيم
    $payments = $query->orderBy('payment_date', 'desc')->get();

    // 7. إعداد بيانات الرسم البياني لطرق الدفع
    $groupedForChart = $payments->groupBy('payment_method');

    $chartLabels = [];
    $chartValues = [];

    foreach ($paymentMethods as $method) {
        $total = $groupedForChart->has($method['id']) ? $groupedForChart->get($method['id'])->sum('amount') : 0;
        $chartLabels[] = $method['name'];
        $chartValues[] = $total;
    }

    $chartData = [
        'labels' => $chartLabels,
        'values' => $chartValues
    ];

    // 8. حساب الإجماليات
    $summaryTotals = [
        'total_paid' => $payments->sum('amount'),
        'total_unpaid' => $payments->sum(function($payment) {
            return $payment->invoice ? $payment->invoice->due_value : 0;
        }),
        'total_payments' => $payments->count(),
        'average_payment' => $payments->avg('amount')
    ];

    // 9. إرجاع النتائج للعرض
    return view('reports.sals.payments.payment_method_report', [
        'payments' => $payments,
        'clients' => $clients,
        'branches' => $branches,
        'employees' => $employees,

        'paymentMethods' => $paymentMethods,
        'chartData' => $chartData,
        'summaryTotals' => $summaryTotals,
        'fromDate' => $fromDate,
        'toDate' => $toDate,
        'filters' => $request->all() // لحفظ حالة الفلاتر
    ]);
}

    // Helper method to prepare chart data for payment methods
    protected function preparePaymentMethodChartData($payments, $paymentMethodsConfig)
    {
        // Group payments by payment method
        $groupedPayments = $payments->groupBy('payment_method');

        $chartLabels = [];
        $chartValues = [];

        foreach ($paymentMethodsConfig as $method) {
            $methodPayments = $groupedPayments->get($method['id'], collect());
            $totalAmount = $methodPayments->sum('amount');

            $chartLabels[] = $method['name'];
            $chartValues[] = $totalAmount;
        }

        return [
            'labels' => $chartLabels,
            'values' => $chartValues,
        ];
    }
    public function patyment(Request $request)
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
            $query = PaymentsProcess::with(['client'])->whereBetween('payment_date', [$fromDate, $toDate]);

            // Apply filters
            if ($request->filled('client')) {
                $query->where('client_id', $request->input('client'));
            }

            if ($request->filled('payment_method')) {
                $query->where('payment_method', $request->input('payment_method'));
            }

            if ($request->filled('payment_status')) {
                $query->where('payment_status', $request->input('payment_status'));
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
                'paymentStatuses' => [
                    $payments->where('payment_status', 1)->count(), // Paid
                    $payments->where('payment_status', 2)->count(), // Unpaid
                ],
            ];

            // Fetch clients for filter dropdown
            $clients = Client::all();

            return view('reports.sals.payments.payment', [
                'payments' => $payments,
                'groupedPayments' => $groupedPayments,
                'chartData' => $chartData,
                'clients' => $clients,
                'fromDate' => Carbon::parse($fromDate),
                'toDate' => Carbon::parse($toDate),
                'reportPeriod' => $reportPeriod,
                'employees' => $employees,
                'branches' => $branches,
            ]);
        } catch (\Exception $e) {
            // Log the full error
            Log::error('Error in payments report', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Optionally, return an error view or redirect with a message
            return back()->with('error', 'حدث خطأ أثناء إنشاء التقرير: ' . $e->getMessage());
        }
    }
    public function profits(Request $request)
    {
        try {
            // نطاق التاريخ الافتراضي (الشهر الحالي)
            $fromDate = $request->input('from_date', Carbon::now()->startOfMonth());
            $toDate = $request->input('to_date', Carbon::now()->endOfMonth());

            // إعداد الاستعلام الأساسي
            $query = InvoiceItem::select('products.id', 'products.name', 'products.purchase_price', 'products.sale_price', 'products.brand', 'categories.name as category_name', DB::raw('SUM(invoice_items.quantity) as total_quantity'), DB::raw('SUM(invoice_items.total) as total_value'), DB::raw('AVG(invoice_items.unit_price) as avg_selling_price'))
                ->join('products', 'invoice_items.product_id', '=', 'products.id')
                ->join('invoices', 'invoice_items.invoice_id', '=', 'invoices.id')
                ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
                ->whereBetween('invoices.invoice_date', [$fromDate, $toDate]);

            // تطبيق الفلاتر
            $query = $this->applyFilters($query, $request, 'products');

            // تنفيذ الاستعلام
            $profitsReport = $query
                ->groupBy('products.id', 'products.name', 'products.purchase_price', 'products.sale_price', 'products.brand', 'categories.name')
                ->get()
                ->map(function ($product) {
                    // حساب التكلفة والربح
                    $totalCost = $product->total_quantity * $product->purchase_price;
                    $profit = $product->total_value - $totalCost;
                    $profitPercentage = $product->total_value > 0 ? ($profit / $product->total_value) * 100 : 0;
                    $markup = $product->purchase_price > 0 ? (($product->avg_selling_price - $product->purchase_price) / $product->purchase_price) * 100 : 0;

                    return [
                        'name' => $product->name,
                        'category_name' => $product->category_name,
                        'brand' => $product->brand,
                        'total_quantity' => $product->total_quantity,
                        'total_value' => $product->total_value,
                        'purchase_price' => $product->purchase_price,
                        'sale_price' => $product->sale_price,
                        'avg_selling_price' => $product->avg_selling_price,
                        'total_cost' => $totalCost,
                        'profit' => $profit,
                        'profit_percentage' => $profitPercentage,
                        'markup_percentage' => $markup,
                    ];
                })
                ->filter(function ($product) {
                    return $product['total_quantity'] > 0; // تصفية العناصر ذات الكمية الصفرية
                })
                ->sortByDesc('profit'); // ترتيب حسب الربح

            // حساب الإحصائيات
            $insights = $this->calculateInsights($profitsReport);

            // جلب البيانات للفلاتر
            $filterData = $this->getFilterData();

            return view('reports.sals.proudect_proifd.proudect_proifd', [
                'profitsReport' => $profitsReport,
                'insights' => $insights,
                'fromDate' => $fromDate,
                'toDate' => $toDate,
                'products' => $filterData['products'],
                'categories' => $filterData['categories'],
                'brands' => $filterData['brands'],
                'branches' => $filterData['branches'],
            ]);
        } catch (\Exception $e) {
            Log::error('Error in profits report: ' . $e->getMessage());
            return redirect()->back()->with('error', 'حدث خطأ أثناء جلب التقرير.');
        }
    }

    /**
     * تقرير أرباح الموظفين
     */
    public function employeeProfits(Request $request)
    {
        try {
            // نطاق التاريخ الافتراضي (الشهر الحالي)
            $fromDate = $request->input('from_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
            $toDate = $request->input('to_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

            // إعداد الاستعلام الأساسي
            $query = InvoiceItem::select('users.id as employee_id', 'users.name as employee_name', DB::raw('SUM(invoice_items.quantity) as total_quantity'), DB::raw('SUM(invoice_items.total) as total_value'), DB::raw('AVG(invoice_items.unit_price) as avg_selling_price'))
                ->join('invoices', 'invoice_items.invoice_id', '=', 'invoices.id')
                ->join('users', 'invoices.created_by', '=', 'users.id')
                ->whereBetween('invoices.invoice_date', [$fromDate, $toDate]);

            // تطبيق الفلاتر
            $query = $this->applyFilters($query, $request, 'employees');

            // تنفيذ الاستعلام
            $employeeProfitsReport = $query
                ->groupBy('users.id', 'users.name')
                ->get()
                ->map(function ($employee) {
                    // حساب التكلفة والربح
                    $totalCost = $employee->total_value / 1.3; // افتراض نسبة ربح 30%
                    $profit = $employee->total_value - $totalCost;
                    $profitPercentage = $employee->total_value > 0 ? ($profit / $employee->total_value) * 100 : 0;

                    return [
                        'employee_id' => $employee->employee_id,
                        'name' => $employee->employee_name,
                        'total_quantity' => $employee->total_quantity,
                        'total_value' => $employee->total_value,
                        'avg_selling_price' => $employee->avg_selling_price,
                        'total_cost' => $totalCost,
                        'profit' => $profit,
                        'profit_percentage' => $profitPercentage,
                    ];
                })
                ->filter(function ($employee) {
                    return $employee['total_quantity'] > 0; // تصفية الموظفين بدون مبيعات
                })
                ->sortByDesc('profit'); // ترتيب حسب الربح

            // حساب الإحصائيات
            $insights = $this->calculateInsights($employeeProfitsReport);

            // جلب البيانات للفلاتر
            $filterData = $this->getFilterData();

            return view('reports.sals.proudect_proifd.employee_profits', [
                'employeeProfitsReport' => $employeeProfitsReport,
                'insights' => $insights,
                'fromDate' => $fromDate,
                'toDate' => $toDate,
                'employees' => User::select('id', 'name')->get(),
                'products' => $filterData['products'],
                'categories' => $filterData['categories'],
                'brands' => $filterData['brands'],
                'branches' => $filterData['branches'],
            ]);
        } catch (\Exception $e) {
            Log::error('Error in employee profits report: ' . $e->getMessage());
            return redirect()->back()->with('error', 'حدث خطأ أثناء جلب التقرير.');
        }
    }

    /**
     * تطبيق الفلاتر على الاستعلام
     */
    private function applyFilters($query, $request, $type)
    {
        if ($type === 'products') {
            if ($request->has('products') && !empty($request->input('products'))) {
                $query->whereIn('products.id', $request->input('products'));
            }
            if ($request->has('categories') && !empty($request->input('categories'))) {
                $query->whereIn('products.category_id', $request->input('categories'));
            }
            if ($request->has('brands') && !empty($request->input('brands'))) {
                $query->whereIn('products.brand', $request->input('brands'));
            }
            if ($request->has('branches') && !empty($request->input('branches'))) {
                $query->whereIn('invoices.branch_id', $request->input('branches'));
            }
        } elseif ($type === 'employees') {
            if ($request->has('employees') && !empty($request->input('employees'))) {
                $query->whereIn('users.id', $request->input('employees'));
            }
        }

        return $query;
    }

    /**
     * حساب الإحصائيات
     */
    private function calculateInsights($report)
    {
        return [
            'total_items' => $report->count(),
            'total_quantity_sold' => $report->sum('total_quantity'),
            'total_revenue' => $report->sum('total_value'),
            'total_cost' => $report->sum('total_cost'),
            'total_profit' => $report->sum('profit'),
            'avg_profit_margin' => $report->sum('total_value') > 0 ? ($report->sum('profit') / $report->sum('total_value')) * 100 : 0,
            'top_item' => $report->first(),
            'lowest_item' => $report->last(),
        ];
    }

    /**
     * جلب بيانات الفلاتر
     */
    private function getFilterData()
    {
        return [
            'products' => Product::select('id', 'name')->get(),
            'categories' => Category::select('id', 'name')->get(),
            'brands' => Product::distinct()->pluck('brand'),
            'branches' => Branch::select('id', 'name')->get(),
        ];
    }

    public function customerProfits(Request $request)
    {
        // الحصول على الفترة الزمنية
        $reportPeriod = $request->input('report_period', 'monthly'); // الافتراضي هو شهري

        // إعداد نطاق التاريخ بناءً على الفترة الزمنية
        if ($reportPeriod == 'daily') {
            $fromDate = Carbon::now()->startOfDay()->format('Y-m-d');
            $toDate = Carbon::now()->endOfDay()->format('Y-m-d');
        } elseif ($reportPeriod == 'weekly') {
            $fromDate = Carbon::now()->startOfWeek()->format('Y-m-d');
            $toDate = Carbon::now()->endOfWeek()->format('Y-m-d');
        } elseif ($reportPeriod == 'yearly') {
            $fromDate = Carbon::now()->startOfYear()->format('Y-m-d');
            $toDate = Carbon::now()->endOfYear()->format('Y-m-d');
        } else {
            $fromDate = Carbon::now()->startOfMonth()->format('Y-m-d');
            $toDate = Carbon::now()->endOfMonth()->format('Y-m-d');
        }

        // Fetch filter options
        $products = Product::select('id', 'name')->get();
        $categories = Category::select('id', 'name')->get();
        $branches = Branch::select('id', 'name')->get();
        $brands = Product::distinct()->pluck('brand');

        // Prepare the base query for invoice items with client details
        $query = InvoiceItem::select('clients.id as client_id', 'clients.trade_name as client_name', DB::raw('SUM(invoice_items.quantity) as total_quantity'), DB::raw('SUM(invoice_items.total) as total_value'), DB::raw('AVG(invoice_items.unit_price) as avg_selling_price'))
            ->join('invoices', 'invoice_items.invoice_id', '=', 'invoices.id')
            ->join('clients', 'invoices.client_id', '=', 'clients.id')
            ->whereBetween('invoices.invoice_date', [$fromDate, $toDate]);

        // Apply filters
        if ($request->has('clients') && is_array($request->input('clients')) && !empty($request->input('clients'))) {
            $query->whereIn('clients.id', $request->input('clients'));
        }

        // Apply product filter
        if ($request->has('products') && is_array($request->input('products')) && !empty($request->input('products'))) {
            $query->whereIn('invoice_items.product_id', $request->input('products'));
        }

        // Apply category filter
        if ($request->has('categories') && is_array($request->input('categories')) && !empty($request->input('categories'))) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->whereIn('category_id', $request->input('categories'));
            });
        }

        // Apply brand filter
        if ($request->has('brands') && is_array($request->input('brands')) && !empty($request->input('brands'))) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->whereIn('brand', $request->input('brands'));
            });
        }

        // Apply branch filter
        if ($request->has('branches') && is_array($request->input('branches')) && !empty($request->input('branches'))) {
            $query->whereIn('invoices.branch_id', $request->input('branches'));
        }

        // Group the results by client
        $clientProfitsReport = $query
            ->groupBy('clients.id', 'clients.trade_name')
            ->get()
            ->map(function ($client) {
                // Calculate total cost (assuming a standard markup or using product purchase prices)
                $totalCost = $client->total_value / 1.3; // Assuming 30% markup as an example
                $profit = $client->total_value - $totalCost;

                // Calculate profit percentages
                $profitPercentage = $client->total_value > 0 ? ($profit / $client->total_value) * 100 : 0;

                return [
                    'client_id' => $client->client_id,
                    'name' => $client->client_name,
                    'total_quantity' => $client->total_quantity,
                    'total_value' => $client->total_value,
                    'avg_selling_price' => $client->avg_selling_price,
                    'total_cost' => $totalCost,
                    'profit' => $profit,
                    'profit_percentage' => $profitPercentage,
                ];
            })
            // Filter out clients with zero sales
            ->filter(function ($client) {
                return $client['total_quantity'] > 0;
            })
            // Sort by profit in descending order
            ->sortByDesc('profit');

        // Calculate additional insights
        $insights = [
            'total_clients' => $clientProfitsReport->count(),
            'total_quantity_sold' => $clientProfitsReport->sum('total_quantity'),
            'total_revenue' => $clientProfitsReport->sum('total_value'),
            'total_cost' => $clientProfitsReport->sum('total_cost'),
            'total_profit' => $clientProfitsReport->sum('profit'),
            'avg_profit_margin' => $clientProfitsReport->sum('total_value') > 0 ? ($clientProfitsReport->sum('profit') / $clientProfitsReport->sum('total_value')) * 100 : 0,
            'top_performing_client' => $clientProfitsReport->first() ?: null,
            'lowest_performing_client' => $clientProfitsReport->last() ?: null,
        ];

        // Fetch additional data for filters
        $clients = Client::select('id', 'trade_name as name')->get();

        return view('reports.sals.proudect_proifd.customer_profit', [
            'clientProfitsReport' => $clientProfitsReport,
            'insights' => $insights,
            'fromDate' => $fromDate,
            'toDate' => $toDate,
            'clients' => $clients,
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'branches' => $branches,
        ]);
    }
    public function ProfitReportTime(Request $request)
    {
        // إعداد نطاق التاريخ
        $fromDate = $request->input('from_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $toDate = $request->input('to_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // إعداد الاستعلام الأساسي لجلب بيانات الفواتير
        $query = Invoice::with(['client', 'employee', 'items.product'])->whereBetween('invoice_date', [$fromDate, $toDate]);

        // تطبيق الفلاتر
        if ($request->has('customer_category') && $request->input('customer_category') != 'all') {
            $query->whereHas('client', function ($q) use ($request) {
                $q->where('category_id', $request->input('customer_category'));
            });
        }

        if ($request->has('customer') && $request->input('customer') != 'all') {
            $query->where('client_id', $request->input('customer'));
        }

        if ($request->has('branch') && $request->input('branch') != 'none') {
            $query->where('branch_id', $request->input('branch'));
        }

        if ($request->has('status') && $request->input('status') != 'all') {
            $query->where('status', $request->input('status'));
        }

        if ($request->has('order_origin') && $request->input('order_origin') != 'all') {
            $query->where('employee_id', $request->input('order_origin'));
        }

        if ($request->has('clients') && is_array($request->input('clients')) && !empty($request->input('clients'))) {
            $query->whereIn('client_id', $request->input('clients'));
        }

        if ($request->has('products') && is_array($request->input('products')) && !empty($request->input('products'))) {
            $query->whereHas('items', function ($q) use ($request) {
                $q->whereIn('product_id', $request->input('products'));
            });
        }

        if ($request->has('categories') && is_array($request->input('categories')) && !empty($request->input('categories'))) {
            $query->whereHas('items.product', function ($q) use ($request) {
                $q->whereIn('category_id', $request->input('categories'));
            });
        }

        if ($request->has('brands') && is_array($request->input('brands')) && !empty($request->input('brands'))) {
            $query->whereHas('items.product', function ($q) use ($request) {
                $q->whereIn('brand', $request->input('brands'));
            });
        }

        if ($request->has('branches') && is_array($request->input('branches')) && !empty($request->input('branches'))) {
            $query->whereIn('branch_id', $request->input('branches'));
        }

        // تنفيذ الاستعلام
        $invoices = $query->get();

        // تجهيز البيانات للتقرير
        $clientProfitsReport = [];
        foreach ($invoices as $invoice) {
            $invoiceTotalPurchasePrice = 0; // مجموع سعر الشراء للفاتورة
            $invoiceTotalSellingPrice = 0; // مجموع سعر البيع للفاتورة

            foreach ($invoice->items as $item) {
                $totalSellingPrice = $item->product->sale_price * $item->quantity - $item->discount; // إجمالي سعر البيع
                $totalCost = $item->product->purchase_price * $item->quantity; // إجمالي تكلفة الشراء
                $profit = $totalSellingPrice - $totalCost; // الربح

                // تحديث المجاميع للفاتورة
                $invoiceTotalPurchasePrice += $totalCost;
                $invoiceTotalSellingPrice += $totalSellingPrice;

                $clientProfitsReport[] = [
                    'client_id' => $invoice->client->id,
                    'invoice_number' => $invoice->code,
                    'name' => $invoice->client->trade_name,
                    'employee' => $invoice->employee->full_name,
                    'product_name' => $item->product->name,
                    'total_quantity' => $item->quantity,
                    'purchase_price' => $item->product->purchase_price,
                    'selling_price' => $item->product->sale_price,
                    'discount' => $item->discount,
                    'profit' => $profit,
                    'invoice_date' => $invoice->invoice_date, // تاريخ الفاتورة
                    'invoice_total_purchase' => $invoiceTotalPurchasePrice, // مجموع سعر الشراء للفاتورة
                    'invoice_total_selling' => $invoiceTotalSellingPrice, // مجموع سعر البيع للفاتورة
                ];
            }
        }

        // جلب بيانات العملاء
        $clients = Client::select('id', 'trade_name as name')->get();

        return view('reports.sals.proudect_proifd.profit_timeline', [
            'clientProfitsReport' => $clientProfitsReport,
            'fromDate' => $fromDate,
            'toDate' => $toDate,
            'clients' => $clients,
            'customerCategories' => CategoriesClient::pluck('name', 'id'),
            'customers' => Client::pluck('trade_name', 'id'),
            'branches' => Branch::pluck('name', 'id'),
            'reportPeriod' => $request->input('report_period', 'monthly'), // تمرير المتغير إلى العرض
            'employees' => Employee::all(),
        ]);
    }
    public function byItem(Request $request)
    {
        // استرداد جميع البيانات المطلوبة للتصفية
        $clients = Client::all();
        $employees = Employee::all();
        $products = Product::all();
        $branches = Branch::all();
        $categories = Category::all();
        $storehouses = Storehouse::all();
        // $brands = Brand::all();
        $salesManagers = User::all();

        // استرداد البيانات المصفاة بناءً على الطلب
        $invoices = Invoice::query()
            ->with(['items', 'client', 'employee', 'branch'])
            ->when($request->filled('item'), function ($query) use ($request) {
                $query->whereHas('items', function ($q) use ($request) {
                    $q->where('item', $request->item);
                });
            })
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->whereHas('items.product', function ($q) use ($request) {
                    $q->where('category_id', $request->category);
                });
            })
            ->when($request->filled('brand'), function ($query) use ($request) {
                $query->whereHas('items.product', function ($q) use ($request) {
                    $q->where('brand_id', $request->brand);
                });
            })
            ->when($request->filled('employee'), function ($query) use ($request) {
                $query->where('employee_id', $request->employee);
            })
            ->when($request->filled('sales_manager'), function ($query) use ($request) {
                $query->where('sales_manager_id', $request->sales_manager);
            })
            ->when($request->filled('client'), function ($query) use ($request) {
                $query->where('client_id', $request->client);
            })
            ->when($request->filled('period'), function ($query) use ($request) {
                $now = Carbon::now();
                switch ($request->period) {
                    case 'daily':
                        $query->whereDate('invoice_date', $now->toDateString());
                        break;
                    case 'weekly':
                        $query->whereBetween('invoice_date', [$now->startOfWeek()->toDateString(), $now->endOfWeek()->toDateString()]);
                        break;
                    case 'monthly':
                        $query->whereMonth('invoice_date', $now->month);
                        break;
                    case 'yearly':
                        $query->whereYear('invoice_date', $now->year);
                        break;
                }
            })
            ->when($request->filled('from_date') && $request->filled('to_date'), function ($query) use ($request) {
                $startDate = Carbon::parse($request->from_date)->startOfDay();
                $endDate = Carbon::parse($request->to_date)->endOfDay();
                $query->whereBetween('invoice_date', [$startDate, $endDate]);
            })
            ->get();

        // تجميع البيانات لعرضها في الجدول
        $reportData = [];
        foreach ($invoices as $invoice) {
            foreach ($invoice->items as $item) {
                $reportData[] = [
                    'id' => $item->id,
                    'name' => $item->item,
                    'product_code' => $item->product ? $item->product->code : 'N/A',
                    'date' => $invoice->invoice_date->format('Y-m-d'),
                    'employee' => $invoice->employee ? $invoice->employee->full_name : 'N/A',
                    'invoice' => $invoice->code,
                    'client' => $invoice->client ? $invoice->client->trade_name : 'N/A',
                    'unit_price' => $item->unit_price,
                    'quantity' => $item->quantity,
                    'discount' => $item->discount,
                    'total' => $item->total,
                ];
            }
        }

        // تمرير البيانات إلى العرض
        return view('reports.sals.salesRport.itemReport', [
            'reportData' => $reportData,
            'clients' => $clients,
            'employees' => $employees,
            'products' => $products,
            'branches' => $branches,
            'categories' => $categories,
            'storehouses' => $storehouses,
            // 'brands' => $brands,
            'salesManagers' => $salesManagers,
        ]);
    }
}
