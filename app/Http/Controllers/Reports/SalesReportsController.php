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
use App\Models\Product;
use App\Models\StoreHouse;
use App\Models\User;
use Illuminate\Http\Request;
use PhpParser\Builder\Function_;

class SalesReportsController extends Controller
{
    // تقارير المبيعات
    public function index()
    {
        return view('Reports.sals.index');
    }
    public function byCustomer(Request $request)
    {
        // Get base data for dropdowns
        $clients = Client::all();
        $branches = Branch::all();

        // Build the invoice query with relationships
        $invoices = Invoice::with(['client', 'createdByUser', 'branch']);

        // Apply filters
        if ($request->filled('customer')) {
            $invoices->where('client_id', $request->customer);
        }

        if ($request->filled('branch')) {
            $invoices->where('branch_id', $request->branch);
        }

        if ($request->filled('status')) {
            $invoices->where('payment_status', $request->status);
        }

        if ($request->filled('order_origin')) {
            $invoices->where('type', $request->order_origin);
        }

        // Date filter with default values if not provided
        $fromDate = $request->input('from_date', now()->subMonth());
        $toDate = $request->input('to_date', now());

        $invoices->whereBetween('invoice_date', [$fromDate, $toDate]);

        // Apply report type filter
        if ($request->filled('report_type')) {
            switch ($request->report_type) {
                case 'yearly':
                    $invoices->whereYear('invoice_date', now()->year);
                    break;
                case 'monthly':
                    $invoices->whereMonth('invoice_date', now()->month);
                    break;
                case 'weekly':
                    $invoices->whereBetween('invoice_date', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'daily':
                    $invoices->whereDate('invoice_date', now()->toDateString());
                    break;
                case 'sales_manager':
                    // Assuming you have a sales_manager_id field in your invoices table
                    $invoices->whereNotNull('sales_manager_id');
                    break;
                case 'employee':
                    // Assuming you have an employee_id field in your invoices table
                    $invoices->whereNotNull('employee_id');
                    break;
            }
        }

        // Get results grouped by client
        $invoices = $invoices->get();
        $groupedInvoices = $invoices->groupBy('client_id');

        // Calculate totals for each client group
        $clientTotals = [];
        foreach ($groupedInvoices as $clientId => $clientInvoices) {
            $clientTotals[$clientId] = [
                'paid_amount' => $clientInvoices->sum(function ($invoice) {
                    return $invoice->payment_status == 1 ? $invoice->grand_total : $invoice->paid_amount;
                }),
                'unpaid_amount' => $clientInvoices->sum(function ($invoice) {
                    return $invoice->payment_status == 1 ? 0 : $invoice->due_value;
                }),
                'returned_amount' => $clientInvoices->sum(function ($invoice) {
                    return $invoice->payment_status == 5 ? $invoice->grand_total : 0;
                }),
                'total_amount' => $clientInvoices->sum('grand_total'),
            ];
        }

        // Prepare data for charts
        $chartData = [
            'labels' => [],
            'values' => [],
        ];

        foreach ($groupedInvoices as $clientId => $clientInvoices) {
            $client = $clientInvoices->first()->client;
            $chartData['labels'][] = $client->trade_name ?? 'عميل ' . $clientId;
            $chartData['values'][] = $clientInvoices->sum('grand_total');
        }

        // Calculate overall totals
        $totals = [
            'paid_amount' => $invoices->sum(function ($invoice) {
                return $invoice->payment_status == 1 ? $invoice->grand_total : $invoice->paid_amount;
            }),
            'unpaid_amount' => $invoices->sum(function ($invoice) {
                return $invoice->payment_status == 1 ? 0 : $invoice->due_value;
            }),
            'returned_amount' => $invoices->sum(function ($invoice) {
                return $invoice->payment_status == 5 ? $invoice->grand_total : 0;
            }),
            'total_amount' => $invoices->sum('grand_total'),
        ];

        return view('reports.sals.Sales_By_Customer', compact('groupedInvoices', 'clients', 'branches', 'totals', 'chartData', 'fromDate', 'toDate', 'clientTotals'));
    }
    public function byEmployee(Request $request)
    {
        // Get base data for dropdowns
        $employees = User::all(); // Assuming you want to list all users
        $branches = Branch::all();

        // Build the invoice query with relationships
        $invoices = Invoice::with(['client', 'createdByUser', 'branch']);

        // Apply filters
        if ($request->filled('employee')) {
            $invoices->where('created_by', $request->employee);
        }

        if ($request->filled('branch')) {
            $invoices->where('branch_id', $request->branch);
        }

        if ($request->filled('status')) {
            $invoices->where('payment_status', $request->status);
        }

        if ($request->filled('order_origin')) {
            $invoices->where('type', $request->order_origin);
        }

        // Date filter with default values if not provided
        $fromDate = $request->input('from_date', now()->subMonth());
        $toDate = $request->input('to_date', now());

        $invoices->whereBetween('invoice_date', [$fromDate, $toDate]);

        // Apply report type filter
        if ($request->filled('report_type')) {
            switch ($request->report_type) {
                case 'yearly':
                    $invoices->whereYear('invoice_date', now()->year);
                    break;
                case 'monthly':
                    $invoices->whereMonth('invoice_date', now()->month);
                    break;
                case 'weekly':
                    $invoices->whereBetween('invoice_date', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'daily':
                    $invoices->whereDate('invoice_date', now()->toDateString());
                    break;
                case 'sales_manager':
                    $invoices->whereHas('createdByUser', function ($query) {
                        $query->where('is_sales_manager', true); // Assuming you have a way to identify sales managers
                    });
                    break;
                case 'employee':
                    $invoices->whereHas('createdByUser', function ($query) {
                        $query->where('is_sales_manager', false); // Assuming you have a way to identify regular employees
                    });
                    break;
            }
        }

        // Get results grouped by employee
        $invoices = $invoices->get();
        $groupedInvoices = $invoices->groupBy('created_by');

        // Calculate totals for each employee group
        $employeeTotals = [];
        foreach ($groupedInvoices as $employeeId => $employeeInvoices) {
            $employeeTotals[$employeeId] = [
                'paid_amount' => $employeeInvoices->sum(function ($invoice) {
                    return $invoice->payment_status == 1 ? $invoice->grand_total : $invoice->paid_amount;
                }),
                'unpaid_amount' => $employeeInvoices->sum(function ($invoice) {
                    return $invoice->payment_status == 1 ? 0 : $invoice->due_value;
                }),
                'returned_amount' => $employeeInvoices->sum(function ($invoice) {
                    return $invoice->payment_status == 5 ? $invoice->grand_total : 0;
                }),
                'total_amount' => $employeeInvoices->sum('grand_total'),
            ];
        }

        // Prepare data for charts
        $chartData = [
            'labels' => [],
            'values' => [],
        ];

        foreach ($groupedInvoices as $employeeId => $employeeInvoices) {
            $employee = $employeeInvoices->first()->createdByUser;
            $chartData['labels'][] = $employee->name ?? 'موظف ' . $employeeId;
            $chartData['values'][] = $employeeInvoices->sum('grand_total');
        }

        // Calculate overall totals
        $totals = [
            'paid_amount' => $invoices->sum(function ($invoice) {
                return $invoice->payment_status == 1 ? $invoice->grand_total : $invoice->paid_amount;
            }),
            'unpaid_amount' => $invoices->sum(function ($invoice) {
                return $invoice->payment_status == 1 ? 0 : $invoice->due_value;
            }),
            'returned_amount' => $invoices->sum(function ($invoice) {
                return $invoice->payment_status == 5 ? $invoice->grand_total : 0;
            }),
            'total_amount' => $invoices->sum('grand_total'),
        ];

        return view('reports.sals.Sales_By_Employee', compact('groupedInvoices', 'employees', 'branches', 'totals', 'chartData', 'fromDate', 'toDate', 'employeeTotals'));
    }


    public function salaryRep(Request $request)
    {
        // Get base data for dropdowns
        $employees = User::all(); // Assuming you want to list all users
        $branches = Branch::all();

        // Build the invoice query with relationships
        $invoices = Invoice::with(['client', 'createdByUser', 'branch']);

        // Apply filters
        if ($request->filled('employee')) {
            $invoices->where('created_by', $request->employee);
        }

        if ($request->filled('branch')) {
            $invoices->where('branch_id', $request->branch);
        }

        if ($request->filled('status')) {
            $invoices->where('payment_status', $request->status);
        }

        if ($request->filled('order_origin')) {
            $invoices->where('type', $request->order_origin);
        }

        // Date filter with default values if not provided
        $fromDate = $request->input('from_date', now()->subMonth());
        $toDate = $request->input('to_date', now());

        $invoices->whereBetween('invoice_date', [$fromDate, $toDate]);

        // Apply report type filter
        if ($request->filled('report_type')) {
            switch ($request->report_type) {
                case 'yearly':
                    $invoices->whereYear('invoice_date', now()->year);
                    break;
                case 'monthly':
                    $invoices->whereMonth('invoice_date', now()->month);
                    break;
                case 'weekly':
                    $invoices->whereBetween('invoice_date', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'daily':
                    $invoices->whereDate('invoice_date', now()->toDateString());
                    break;
                case 'sales_manager':
                    $invoices->whereHas('createdByUser', function ($query) {
                        $query->where('is_sales_manager', true); // Assuming you have a way to identify sales managers
                    });
                    break;
                case 'employee':
                    $invoices->whereHas('createdByUser', function ($query) {
                        $query->where('is_sales_manager', false); // Assuming you have a way to identify regular employees
                    });
                    break;
            }
        }

        // Get results grouped by employee
        $invoices = $invoices->get();
        $groupedInvoices = $invoices->groupBy('created_by');

        // Calculate totals for each employee group
        $employeeTotals = [];
        foreach ($groupedInvoices as $employeeId => $employeeInvoices) {
            $employeeTotals[$employeeId] = [
                'paid_amount' => $employeeInvoices->sum(function ($invoice) {
                    return $invoice->payment_status == 1 ? $invoice->grand_total : $invoice->paid_amount;
                }),
                'unpaid_amount' => $employeeInvoices->sum(function ($invoice) {
                    return $invoice->payment_status == 1 ? 0 : $invoice->due_value;
                }),
                'returned_amount' => $employeeInvoices->sum(function ($invoice) {
                    return $invoice->payment_status == 5 ? $invoice->grand_total : 0;
                }),
                'total_amount' => $employeeInvoices->sum('grand_total'),
            ];
        }

        // Prepare data for charts
        $chartData = [
            'labels' => [],
            'values' => [],
        ];

        foreach ($groupedInvoices as $employeeId => $employeeInvoices) {
            $employee = $employeeInvoices->first()->createdByUser;
            $chartData['labels'][] = $employee->name ?? 'موظف ' . $employeeId;
            $chartData['values'][] = $employeeInvoices->sum('grand_total');
        }

        // Calculate overall totals
        $totals = [
            'paid_amount' => $invoices->sum(function ($invoice) {
                return $invoice->payment_status == 1 ? $invoice->grand_total : $invoice->paid_amount;
            }),
            'unpaid_amount' => $invoices->sum(function ($invoice) {
                return $invoice->payment_status == 1 ? 0 : $invoice->due_value;
            }),
            'returned_amount' => $invoices->sum(function ($invoice) {
                return $invoice->payment_status == 5 ? $invoice->grand_total : 0;
            }),
            'total_amount' => $invoices->sum('grand_total'),
        ];

        return view('reports.sals.Sales_By_SalesRep', compact('groupedInvoices', 'employees', 'branches', 'totals', 'chartData', 'fromDate', 'toDate', 'employeeTotals'));
    }
    public function byProduct(Request $request)
    {
        // Fetch necessary data for dropdowns and filtering
        $products = Product::all();
        $categories = Category::all();
        $employees = User::all();
        $branches = Branch::all();
$storehouses = StoreHouse::all();
        $clients = Client::all();
        $client_categories = CategoriesClient::all();

        // Build the product sales query
        $productSales = InvoiceItem::with([
            'invoice',
            'product',
            'invoice.client',
            'invoice.createdByUser'
        ]);

        // Apply filters based on request
        if ($request->filled('product')) {
            $productSales->where('product_id', $request->product);
        }

        if ($request->filled('employee')) {
            $productSales->whereHas('invoice', function($query) use ($request) {
                $query->where('created_by', $request->employee);
            });
        }

        if ($request->filled('branch')) {
            $productSales->whereHas('invoice', function($query) use ($request) {
                $query->where('branch_id', $request->branch);
            });
        }

        if ($request->filled('client')) {
            $productSales->whereHas('invoice', function($query) use ($request) {
                $query->where('client_id', $request->client);
            });
        }

        // Date range filter
        $fromDate = $request->input('from_date', now()->subMonth());
        $toDate = $request->input('to_date', now());
        $productSales->whereHas('invoice', function($query) use ($fromDate, $toDate) {
            $query->whereBetween('invoice_date', [$fromDate, $toDate]);
        });

        // Fetch and group product sales
        $productSales = $productSales->get();
        $groupedProductSales = $productSales->groupBy('product_id');

        // Calculate totals
        $productTotals = [];
        foreach ($groupedProductSales as $productId => $sales) {
            $productTotals[$productId] = [
                'total_quantity' => $sales->sum('quantity'),
                'total_amount' => $sales->sum(function($item) {
                    return $item->quantity * $item->unit_price;
                }),
                'total_discount' => $sales->sum('discount_amount')
            ];
        }

        // Prepare chart data
        $chartData = [
            'labels' => [],
            'quantities' => [],
            'amounts' => []
        ];

        foreach ($groupedProductSales as $productId => $sales) {
            $product = $sales->first()->product;
            $chartData['labels'][] = $product->name;
            $chartData['quantities'][] = $productTotals[$productId]['total_quantity'];
            $chartData['amounts'][] = $productTotals[$productId]['total_amount'];
        }

        return view('reports.sals.by_Product', compact(
            'products',
            'employees',
            'branches',
            'clients',
            'productSales',
            'groupedProductSales',
            'productTotals',
            'chartData',
            'categories',
            'fromDate',
            'storehouses',
            'client_categories',
            'toDate'
        ));
    }
    public function WeeklybyProduct()
    {
        return view('reports.sals.Weekly_by_Product');
    }
    public function monthlybyProduct()
    {
        return view('reports.sals.Monthly_by_Product');
    }
    public function AnnualbyProduct()
    {
        return view('reports.sals.Annual_by_Product');
    }
    public function Dsales()
    {
        return view('reports.sals.D_Sales');
    }
    public function Wsales()
    {
        return view('reports.sals.W_Sales');
    }
    public function Msales()
    {
        return view('reports.sals.M_Sales');
    }
    public function Asales()
    {
        return view('reports.sals.A_Sales');
    }
    public function byCust()
    {
        return view('reports.sals.Payments_by_Customer');
    }
    public function byembl()
    {
        return view('reports.sals.Payments_by_Employee');
    }
    public function bypay()
    {
        return view('reports.sals.Payments_by_Payment_Method');
    }
    public function DailyPayments()
    {
        return view('reports.sals.Daily_Payments');
    }
    public function WeeklyPayments()
    {
        return view('reports.sals.Weekly_Payments');
    }
    public function MonthlyPayments()
    {
        return view('reports.sals.Monthly_Payments');
    }
    public function productsprofit()
    {
        return view('reports.sals.products_profit');
    }
    public function CustomerProfit()
    {
        return view('reports.sals.Customer_Profit');
    }
    public function EmployeeProfit()
    {
        return view('reports.sals.Employee_Profit');
    }
    public function ManagerProfit()
    {
        return view('reports.sals.Manager_Profit');
    }
    public function DailyProfits()
    {
        return view('reports.sals.Daily_Profits');
    }
    public function WeeklyProfits()
    {
        return view('reports.sals.Weekly_Profits');
    }
    public function AnnualProfits()
    {
        return view('reports.sals.Annual_Profits');
    }
    public function ItemSalesByItem()
    {
        return view('reports.sals.Sales_By_Item');
    }

    public function ItemSalesByCategory()
    {
        return view('reports.sals.Sales_By_Category');
    }

    public function ItemSalesByBrand()
    {
        return view('reports.sals.Sales_By_Brand');
    }

    public function ItemSalesByEmployee()
    {
        return view('reports.sals.Sales_By_Employee');
    }

    public function ItemSalesBySalesRep()
    {
        return view('reports.sals.Sales_By_SalesRep');
    }

    public function ItemSalesByCustomer()
    {
        return view('reports.sals.Sales_By_Customer');
    }
}
