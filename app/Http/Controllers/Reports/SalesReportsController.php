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
        // Get base data for dropdowns
        $clients = Client::all();
        $branches = Branch::all();

        // Default date range
        $fromDate = $request->input('from_date', now()->startOfMonth());
        $toDate = $request->input('to_date', now()->endOfMonth());

        // Determine report period
        $reportPeriod = $request->input('report_period', 'monthly');

        // Build the invoice query with relationships
        $query = Invoice::with(['client', 'createdByUser', 'branch']);

        // Apply date filtering based on report period
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

        // Apply additional filters
        if ($request->filled('customer')) {
            $query->where('client_id', $request->customer);
        }

        if ($request->filled('branch')) {
            $query->where('branch_id', $request->branch);
        }

        if ($request->filled('status')) {
            switch ($request->status) {
                case '1': // Paid
                    $query->where('payment_status', 1);
                    break;
                case '0': // Unpaid
                    $query->where('payment_status', 0);
                    break;
                case '5': // Returned
                    $query->where('type', 'return');
                    break;
            }
        }

        // Apply date range filter
        $query->whereBetween('invoice_date', [$fromDate, $toDate]);

        // Get results
        $invoices = $query->get();

        // Group invoices by client
        $groupedInvoices = $invoices->groupBy('client_id');

        // Calculate totals
        $totals = [
            'paid_amount' => $invoices->sum(function ($invoice) {
                return $invoice->payment_status == 1 ? $invoice->grand_total : $invoice->paid_amount;
            }),
            'unpaid_amount' => $invoices->sum(function ($invoice) {
                return $invoice->payment_status == 0 ? $invoice->due_value : 0;
            }),
            'returned_amount' => $invoices->sum(function ($invoice) {
                return $invoice->type == 'return' ? $invoice->grand_total : 0;
            }),
            'total_amount' => $invoices->sum('grand_total'),
        ];

        // Prepare chart data
        $chartData = [
            'labels' => [],
            'values' => [],
        ];

        foreach ($groupedInvoices as $clientId => $clientInvoices) {
            $client = $clientInvoices->first()->client;
            $chartData['labels'][] = $client->trade_name ?? 'عميل ' . $clientId;
            $chartData['values'][] = $clientInvoices->sum('grand_total');
        }

        return view('reports.sals.salesRport.Sales_By_Customer', compact('groupedInvoices', 'clients', 'branches', 'totals', 'chartData', 'fromDate', 'toDate', 'reportPeriod'));
    }
    public function byEmployee(Request $request)
    {
        // Get base data for dropdowns
        $employees = Employee::all();
        $branches = Branch::all();
        $categories = CategoriesClient::all();
        $clients = Client::all();

        // Build the invoice query with relationships
        $invoices = Invoice::with(['client', 'createdByUser', 'branch']);

        // Apply filters systematically

        // Client Category Filter
        if ($request->filled('category')) {
            $invoices->whereHas('client', function ($query) use ($request) {
                $query->where('category_id', $request->category);
            });
        }

        // Client Filter
        if ($request->filled('client')) {
            $invoices->where('client_id', $request->client);
        }

        // Branch Filter
        if ($request->filled('branch')) {
            $invoices->where('branch_id', $request->branch);
        }

        // Payment Status Filter
        if ($request->filled('status')) {
            $invoices->where('payment_status', $request->status);
        }

        // Order Origin (Employee) Filter
        if ($request->filled('order_origin')) {
            $invoices->where('employee_id', $request->order_origin);
        }

        // Date range filter with Carbon parsing
        $fromDate = $request->input('from_date') ? Carbon::parse($request->input('from_date')) : now()->subMonth();
        $toDate = $request->input('to_date') ? Carbon::parse($request->input('to_date')) : now();

        $invoices->whereBetween('invoice_date', [$fromDate, $toDate]);

        // Report Type Filter
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
                        $query->where('is_sales_manager', true);
                    });
                    break;
                case 'employee':
                    $invoices->whereHas('createdByUser', function ($query) {
                        $query->where('is_sales_manager', false);
                    });
                    break;
                case 'returns':
                    $invoices->whereIn('type', ['return', 'returned']);
                    break;
            }
        }

        // Get results and handle empty result set
        $invoices = $invoices->get();

        // Prepare default empty data structures
        $groupedInvoices = collect();
        $employeeTotals = collect();
        $chartData = [
            'labels' => [],
            'values' => [],
        ];
        $totals = [
            'paid_amount' => 0,
            'unpaid_amount' => 0,
            'returned_amount' => 0,
            'total_amount' => 0,
        ];

        // Process invoices if not empty
        if ($invoices->isNotEmpty()) {
            // Group invoices by employee
            $groupedInvoices = $invoices->groupBy('created_by');

            // Calculate totals for each employee group
            $employeeTotals = $groupedInvoices->map(function ($employeeInvoices, $employeeId) {
                // Find the employee name
                $employee = $employeeInvoices->first()->createdByUser;
                $employeeName = $employee ? $employee->name : 'موظف ' . $employeeId;

                // Calculate different types of amounts
                $paidAmount = $employeeInvoices->where('type', '!=', ['return', 'returned'])->sum(function ($invoice) {
                    return $invoice->payment_status == 1 ? $invoice->grand_total : $invoice->paid_amount;
                });

                $unpaidAmount = $employeeInvoices->where('type', '!=', ['return', 'returned'])->sum(function ($invoice) {
                    return $invoice->payment_status == 1 ? 0 : $invoice->due_value;
                });

                $returnedAmount = $employeeInvoices->whereIn('type', ['return', 'returned'])->sum('grand_total');

                $totalAmount = $paidAmount + $unpaidAmount + $returnedAmount;

                return [
                    'employee_name' => $employeeName,
                    'paid_amount' => $paidAmount,
                    'unpaid_amount' => $unpaidAmount,
                    'returned_amount' => $returnedAmount,
                    'total_amount' => $totalAmount,
                ];
            });

            // Prepare data for charts
            $chartData = [
                'labels' => $employeeTotals->pluck('employee_name'),
                'values' => $employeeTotals->pluck('total_amount'),
            ];

            // Calculate overall totals
            $totals = [
                'paid_amount' => $invoices->where('type', '!=', ['return', 'returned'])->sum(function ($invoice) {
                    return $invoice->payment_status == 1 ? $invoice->grand_total : $invoice->paid_amount;
                }),
                'unpaid_amount' => $invoices->where('type', '!=', ['return', 'returned'])->sum(function ($invoice) {
                    return $invoice->payment_status == 1 ? 0 : $invoice->due_value;
                }),
                'returned_amount' => $invoices->whereIn('type', ['return', 'returned'])->sum('grand_total'),
                'total_amount' => $invoices->where('type', '!=', ['return', 'returned'])->sum('grand_total') + $invoices->whereIn('type', ['return', 'returned'])->sum('grand_total'),
            ];
        }

        // Log if no invoices found
        if ($invoices->isEmpty()) {
            Log::info('No invoices found for the selected criteria', [
                'filters' => $request->all(),
            ]);
        }

        return view('reports.sals.salesRport.Sales_By_Employee', compact('groupedInvoices', 'employees', 'clients', 'categories', 'branches', 'totals', 'chartData', 'fromDate', 'toDate', 'employeeTotals'));
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
        // Validate input parameters
        $validatedData = $request->validate([
            'product' => 'nullable|exists:products,id',
            'branch' => 'nullable|exists:branches,id',
            'client' => 'nullable|exists:clients,id',
            'employee' => 'nullable|exists:users,id',
            'invoice_type' => 'nullable|in:1,2,3',
            'status' => 'nullable|exists:categories,id',
            'storehouse' => 'nullable|exists:store_houses,id',
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date|after_or_equal:from_date',
            'report_period' => 'nullable|in:daily,weekly,monthly,yearly',
            'add_draft' => 'nullable|boolean',
        ]);

        // Fetch necessary data for dropdowns
        $products = Product::all();
        $categories = Category::all();
        $employees = User::all();
        $branches = Branch::all();
        $storehouses = StoreHouse::all();
        $clients = Client::all();
        $client_categories = CategoriesClient::all();

        // Initialize query
        $productSales = InvoiceItem::with(['invoice', 'product', 'invoice.client', 'invoice.createdByUser']);

        // Apply product filter
        if ($request->filled('product')) {
            $productSales->where('product_id', $request->product);
        }

        // Apply branch filter
        if ($request->filled('branch')) {
            $productSales->whereHas('invoice', function ($query) use ($request) {
                $query->where('branch_id', $request->branch);
            });
        }

        // Apply client filter
        if ($request->filled('client')) {
            $productSales->whereHas('invoice', function ($query) use ($request) {
                $query->where('client_id', $request->client);
            });
        }

        // Apply employee filter
        if ($request->filled('employee')) {
            $productSales->whereHas('invoice', function ($query) use ($request) {
                $query->where('created_by', $request->employee);
            });
        }

        // Apply invoice type filter
        if ($request->filled('invoice_type')) {
            $productSales->whereHas('invoice', function ($query) use ($request) {
                switch ($request->invoice_type) {
                    case '1': // Return Invoice
                        $query->where('type', 'return');
                        break;
                    case '2': // Debit Note
                        $query->where('type', 'debit_note');
                        break;
                    case '3': // Credit Note
                        $query->where('type', 'credit_note');
                        break;
                }
            });
        }

        // Apply category filter
        if ($request->filled('status')) {
            $productSales->whereHas('product', function ($query) use ($request) {
                $query->where('category_id', $request->status);
            });
        }

        // Apply storehouse filter
        if ($request->filled('storehouse')) {
            $productSales->whereHas('invoice', function ($query) use ($request) {
                $query->where('storehouse_id', $request->storehouse);
            });
        }

        // Determine date range
        $fromDate = $request->input('from_date') ? Carbon::parse($request->input('from_date')) : now()->subMonth();
        $toDate = $request->input('to_date') ? Carbon::parse($request->input('to_date')) : now();

        // Apply period-based filtering
        $reportPeriod = $request->input('report_period', 'daily');
        $productSales->whereHas('invoice', function ($query) use ($fromDate, $toDate, $reportPeriod) {
            switch ($reportPeriod) {
                case 'daily':
                    $query->whereBetween('invoice_date', [$fromDate, $toDate]);
                    break;
                case 'weekly':
                    $query->whereBetween('invoice_date', [$fromDate->copy()->startOfWeek(), $toDate->copy()->endOfWeek()]);
                    break;
                case 'monthly':
                    $query->whereBetween('invoice_date', [$fromDate->copy()->startOfMonth(), $toDate->copy()->endOfMonth()]);
                    break;
                case 'yearly':
                    $query->whereBetween('invoice_date', [$fromDate->copy()->startOfYear(), $toDate->copy()->endOfYear()]);
                    break;
            }
        });

        // Optional: Include draft items
        if ($request->has('add_draft')) {
            $productSales->whereHas('invoice', function ($query) {
                $query->orWhere('status', 'draft');
            });
        }

        // Fetch and process product sales
        $productSales = $productSales->get();

        // Adjust quantities for return invoices
        $adjustedProductSales = $productSales->map(function ($sale) {
            // If it's a return invoice, make quantity negative
            if ($sale->invoice->type === 'return') {
                $sale->quantity = -abs($sale->quantity);
            }
            return $sale;
        });

        // Group product sales
        $groupedProductSales = $adjustedProductSales->groupBy('product_id');

        // Calculate totals
        $productTotals = [];
        foreach ($groupedProductSales as $productId => $sales) {
            $productTotals[$productId] = [
                'total_quantity' => $sales->sum('quantity'),
                'total_amount' => $sales->sum(function ($item) {
                    return $item->quantity * $item->unit_price;
                }),
                'total_discount' => $sales->sum('discount_amount'),
            ];
        }

        // Prepare chart data
        $chartData = [
            'labels' => [],
            'quantities' => [],
            'amounts' => [],
        ];

        foreach ($groupedProductSales as $productId => $sales) {
            $product = $sales->first()->product;
            $chartData['labels'][] = $product->name;
            $chartData['quantities'][] = $productTotals[$productId]['total_quantity'];
            $chartData['amounts'][] = $productTotals[$productId]['total_amount'];
        }

        // Return view with all necessary data
        return view('reports.sals.salesRport.by_Product', array_merge(compact('products', 'employees', 'branches', 'clients', 'productSales', 'groupedProductSales', 'productTotals', 'chartData', 'categories', 'fromDate', 'storehouses', 'client_categories', 'toDate'), ['reportPeriod' => $request->input('report_period', 'daily')]));
    }

    public function clientPaymentReport(Request $request)
    {
        // Fetch dropdown data
        $clients = Client::all();
        $branches = Branch::all();
        $customerCategories = CategoriesClient::all();
        $employees = User::all();
        $paymentMethods = [['id' => 1, 'name' => 'نقدي'], ['id' => 2, 'name' => 'شيك'], ['id' => 3, 'name' => 'تحويل بنكي'], ['id' => 4, 'name' => 'بطاقة ائتمان']];

        // Default date range with Carbon conversion
        $fromDate = $request->input('from_date') ? Carbon::parse($request->input('from_date')) : now()->startOfMonth();
        $toDate = $request->input('to_date') ? Carbon::parse($request->input('to_date')) : now()->endOfMonth();

        // Build the query with all necessary relationships
        $query = PaymentsProcess::with(['client', 'employee', 'invoice']);

        // Apply filters based on request parameters
        if ($request->filled('customer_category')) {
            $query->whereHas('client', function ($q) use ($request) {
                $q->where('category_id', $request->input('customer_category'));
            });
        }

        if ($request->filled('client')) {
            $query->where('client_id', $request->input('client'));
        }

        if ($request->filled('branch')) {
            $query->whereHas('invoice', function ($q) use ($request) {
                $q->where('branch_id', $request->input('branch'));
            });
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->input('payment_method'));
        }

        if ($request->filled('collector')) {
            $query->where('employee_id', $request->input('collector'));
        }

        // Date range filter
        $query->whereBetween('payment_date', [$fromDate, $toDate]);

        // Fetch payments
        $payments = $query->get();

        // Prepare chart data
        $chartData = $this->prepareChartData1($payments);

        // Calculate summary totals
        $summaryTotals = [
            'total_paid' => $payments->sum('amount'),
            'total_unpaid' => $payments->sum(function ($payment) {
                return $payment->invoice ? $payment->invoice->due_value : 0;
            }),
            'total_reference' => $payments->sum(function ($payment) {
                return $payment->reference_number ? $payment->amount : 0;
            }),
        ];

        return view('reports.sals.payments.client_report', compact('payments', 'clients', 'branches', 'customerCategories', 'employees', 'paymentMethods', 'chartData', 'summaryTotals', 'fromDate', 'toDate'));
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
        // Fetch dropdown data
        $clients = Client::all();
        $branches = Branch::all();
        $customerCategories = CategoriesClient::all();
        $employees = User::all();
        $paymentMethods = [['id' => 1, 'name' => 'نقدي'], ['id' => 2, 'name' => 'شيك'], ['id' => 3, 'name' => 'تحويل بنكي'], ['id' => 4, 'name' => 'بطاقة ائتمان']];

        // Default date range with Carbon conversion
        $fromDate = $request->input('from_date') ? Carbon::parse($request->input('from_date')) : now()->startOfMonth();
        $toDate = $request->input('to_date') ? Carbon::parse($request->input('to_date')) : now()->endOfMonth();

        // Build the query with all necessary relationships
        $query = PaymentsProcess::with(['client', 'employee', 'invoice']);

        // Apply filters based on request parameters
        if ($request->filled('customer_category')) {
            $query->whereHas('client', function ($q) use ($request) {
                $q->where('category_id', $request->input('customer_category'));
            });
        }

        if ($request->filled('client')) {
            $query->where('client_id', $request->input('client'));
        }

        if ($request->filled('branch')) {
            $query->whereHas('invoice', function ($q) use ($request) {
                $q->where('branch_id', $request->input('branch'));
            });
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->input('payment_method'));
        }

        if ($request->filled('collector')) {
            $query->where('employee_id', $request->input('collector'));
        }

        // Date range filter
        $query->whereBetween('payment_date', [$fromDate, $toDate]);

        // Fetch payments
        $payments = $query->get();

        // Prepare chart data for employees
        $chartData = $this->prepareEmployeeChartData($payments);

        // Calculate summary totals
        $summaryTotals = [
            'total_paid' => $payments->sum('amount'),
            'total_payments_count' => $payments->count(),
            'average_payment' => $payments->avg('amount'),
        ];

        return view('reports.sals.payments.employee_report', compact('payments', 'clients', 'branches', 'customerCategories', 'employees', 'paymentMethods', 'chartData', 'summaryTotals', 'fromDate', 'toDate'));
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
        // Fetch dropdown data
        $clients = Client::all();
        $branches = Branch::all();
        $employees = Employee::all();
        $paymentMethods = [['id' => 1, 'name' => 'نقدي'], ['id' => 2, 'name' => 'شيك'], ['id' => 3, 'name' => 'تحويل بنكي'], ['id' => 4, 'name' => 'بطاقة ائتمان']];

        // Default date range with Carbon conversion
        $fromDate = $request->input('from_date') ? Carbon::parse($request->input('from_date')) : now()->startOfMonth();
        $toDate = $request->input('to_date') ? Carbon::parse($request->input('to_date')) : now()->endOfMonth();

        // Build the query with all necessary relationships
        $query = PaymentsProcess::with(['client', 'invoice', 'invoice.employee']);

        // Apply filters based on request parameters
        if ($request->filled('client')) {
            $query->where('client_id', $request->input('client'));
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->input('payment_method'));
        }

        // Date range filter
        $query->whereBetween('payment_date', [$fromDate, $toDate]);

        // Fetch payments
        $payments = $query->get();

        // Prepare chart data for payment methods
        $chartData = $this->preparePaymentMethodChartData($payments, $paymentMethods);

        // Calculate summary totals
        $summaryTotals = [
            'total_paid' => $payments->sum('amount'),
            'total_payments_count' => $payments->count(),
            'average_payment' => $payments->avg('amount'),
        ];

        return view('reports.sals.payments.payment_method_report', compact('payments', 'clients', 'branches', 'paymentMethods', 'chartData', 'employees', 'summaryTotals', 'fromDate', 'toDate'));
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
            $query = InvoiceItem::select(
                'products.id',
                'products.name',
                'products.purchase_price',
                'products.sale_price',
                'products.brand',
                'categories.name as category_name',
                DB::raw('SUM(invoice_items.quantity) as total_quantity'),
                DB::raw('SUM(invoice_items.total) as total_value'),
                DB::raw('AVG(invoice_items.unit_price) as avg_selling_price')
            )
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
            $query = InvoiceItem::select(
                'users.id as employee_id',
                'users.name as employee_name',
                DB::raw('SUM(invoice_items.quantity) as total_quantity'),
                DB::raw('SUM(invoice_items.total) as total_value'),
                DB::raw('AVG(invoice_items.unit_price) as avg_selling_price')
            )
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
        $query = Invoice::with(['client', 'employee', 'items.product'])
            ->whereBetween('invoice_date', [$fromDate, $toDate]);

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
                $totalSellingPrice = ($item->product->sale_price * $item->quantity) - $item->discount; // إجمالي سعر البيع
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
    }   }



