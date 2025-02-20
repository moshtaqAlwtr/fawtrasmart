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
use App\Models\StoreHouse;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        return view('Reports.sals.index');
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

        return view('reports.sals.Sales_By_Customer', compact(
            'groupedInvoices',
            'clients',
            'branches',
            'totals',
            'chartData',
            'fromDate',
            'toDate',
            'reportPeriod'
        ));
    }
    public function byEmployee(Request $request)
    {
        // Get base data for dropdowns
        $employees = User::all();
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
            $invoices->where('created_by', $request->order_origin);
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

        return view('reports.sals.Sales_By_Employee', compact('groupedInvoices', 'employees', 'clients', 'categories', 'branches', 'totals', 'chartData', 'fromDate', 'toDate', 'employeeTotals'));
    }
    public function byInvoice(Request $request)
    {
        // Default date range (current month)
        $fromDate = $request->input('from_date', Carbon::now()->startOfMonth());
        $toDate = $request->input('to_date', Carbon::now()->endOfMonth());

        // Validate and parse dates
        $fromDate = Carbon::parse($fromDate);
        $toDate = Carbon::parse($toDate);

        // Default report period
        $branches = Branch::all();
        $reportPeriod = $request->input('report_period', 'monthly');
        $invoices=Invoice::all();
        // Query for invoices with desسtailed filtering
        $query = Invoice::with([
            'client' => function ($query) {
                $query->withDefault(['trade_name' => 'غير محدد']);
            },
            'createdByUser' => function ($query) {
                $query->withDefault(['name' => 'غير محدد']);
            },
        ])->whereBetween('invoice_date', [$fromDate, $toDate]);

        // Apply filters
        if ($request->filled('invoice_type')) {
            $typeMap = [
                '1' => 'return',
                '2' => 'debit_note',
                '3' => 'credit_note',
            ];
            $query->where('type', $typeMap[$request->input('invoice_type')]);
        }

        // Apply client filter
        if ($request->filled('client')) {
            $query->where('client_id', $request->input('client'));
        }

        // Apply employee filter
        if ($request->filled('employee')) {
            $query->where('created_by', $request->input('employee'));
        }

        // Fetch invoices
        $invoices = $query->get();

        // Group invoices by period
        $groupedInvoices = $invoices->groupBy(function ($invoice) use ($reportPeriod) {
            switch ($reportPeriod) {
                case 'daily':
                    return $invoice->invoice_date->format('Y-m-d');
                case 'weekly':
                    return $invoice->invoice_date->format('Y-W');
                case 'monthly':
                    return $invoice->invoice_date->format('Y-m');
                case 'yearly':
                    return $invoice->invoice_date->format('Y');
                default:
                    return $invoice->invoice_date->format('Y-m-d');
            }
        });

        // Prepare chart data
        $chartData = $this->prepareChartData($invoices);

        // Fetch dropdowns data
        $clients = Client::all();
        $employees = User::all();

        return view('reports.sals.by_invoice', compact('groupedInvoices','invoices', 'clients','branches', 'employees', 'fromDate', 'toDate', 'reportPeriod', 'chartData'));
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

    public function exportByEmployeeToExcel(Request $request)
    {
        // Reuse the same filtering logic from byEmployee method
        $employees = User::all();
        $branches = Branch::all();
        $categories = CategoriesClient::all();
        $clients = Client::all();

        // Build the invoice query with relationships
        $invoices = Invoice::with(['client', 'createdByUser', 'branch']);

        // Apply the same filters as in byEmployee method
        // (Copy the filtering logic from the byEmployee method)
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
            $invoices->where('created_by', $request->order_origin);
        }

        // Date range filter with Carbon parsing
        $fromDate = $request->input('from_date') ? Carbon::parse($request->input('from_date')) : now()->subMonth();
        $toDate = $request->input('to_date') ? Carbon::parse($request->input('to_date')) : now();

        $invoices->whereBetween('invoice_date', [$fromDate, $toDate]);

        // Get results
        $invoices = $invoices->get();
        $groupedInvoices = $invoices->groupBy('created_by');

        // Create new Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set document properties
        $spreadsheet
            ->getProperties()
            ->setCreator(auth()->user()->name)
            ->setTitle('تقرير مبيعات الموظفين')
            ->setSubject('تقرير المبيعات')
            ->setDescription('تقرير مبيعات الموظفين من ' . $fromDate->format('d/m/Y') . ' إلى ' . $toDate->format('d/m/Y'));

        // Set column headers
        $columns = [
            'A' => 'الموظف',
            'B' => 'رقم الفاتورة',
            'C' => 'التاريخ',
            'D' => 'العميل',
            'E' => 'مدفوعة (SAR)',
            'F' => 'غير مدفوعة (SAR)',
            'G' => 'مرتجع (SAR)',
            'H' => 'الإجمالي (SAR)',
        ];

        // Set headers
        $col = 'A';
        foreach ($columns as $header) {
            $sheet->setCellValue($col . '1', $header);
            $col++;
        }

        // Style for headers
        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFE5E5E5'],
            ],
        ];
        $sheet->getStyle('A1:H1')->applyFromArray($headerStyle);

        // Populate data
        $row = 2;
        foreach ($groupedInvoices as $employeeId => $invoices) {
            $employeeName = $invoices->first()->createdByUser->name ?? 'موظف ' . $employeeId;

            foreach ($invoices as $invoice) {
                $sheet->setCellValue('A' . $row, $employeeName);
                $sheet->setCellValue('B' . $row, str_pad($invoice->code, 5, '0', STR_PAD_LEFT));
                $sheet->setCellValue('C' . $row, Carbon::parse($invoice->invoice_date)->format('d/m/Y'));
                $sheet->setCellValue('D' . $row, $invoice->client->trade_name ?? 'غير محدد');

                if (in_array($invoice->type, ['return', 'returned'])) {
                    $sheet->setCellValue('E' . $row, '-');
                    $sheet->setCellValue('F' . $row, '-');
                    $sheet->setCellValue('G' . $row, number_format($invoice->grand_total, 2));
                    $sheet->setCellValue('H' . $row, number_format($invoice->grand_total, 2));
                } else {
                    $sheet->setCellValue('E' . $row, number_format($invoice->payment_status == 1 ? $invoice->grand_total : $invoice->paid_amount, 2));
                    $sheet->setCellValue('F' . $row, number_format($invoice->payment_status == 1 ? 0 : $invoice->due_value, 2));
                    $sheet->setCellValue('G' . $row, '-');
                    $sheet->setCellValue('H' . $row, number_format($invoice->grand_total, 2));
                }
                $row++;
            }

            // Add subtotal row for each employee
            $sheet->setCellValue('A' . $row, 'المجموع');
            $sheet->getStyle('A' . $row . ':H' . $row)->applyFromArray([
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFF0F0F0'],
                ],
            ]);
            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'H') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Prepare file
        $filename = 'تقرير_مبيعات_الموظفين_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

        // Redirect output to a client's web browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }


    public function exportByCustomerToExcel(Request $request)
    {
        // Reuse the same filtering logic from byCustomer method
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

        // Date range filter with Carbon parsing
        $fromDate = $request->input('from_date') ? Carbon::parse($request->input('from_date')) : now()->subMonth();
        $toDate = $request->input('to_date') ? Carbon::parse($request->input('to_date')) : now();

        $invoices->whereBetween('invoice_date', [$fromDate, $toDate]);

        // Get results
        $invoices = $invoices->get();
        $groupedInvoices = $invoices->groupBy('client_id');

        // Create new Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set document properties
        $spreadsheet
            ->getProperties()
            ->setCreator(auth()->user()->name)
            ->setTitle('تقرير مبيعات العملاء')
            ->setSubject('تقرير المبيعات')
            ->setDescription('تقرير مبيعات العملاء من ' . $fromDate->format('d/m/Y') . ' إلى ' . $toDate->format('d/m/Y'));

        // Set column headers
        $columns = [
            'A' => 'العميل',
            'B' => 'رقم الفاتورة',
            'C' => 'التاريخ',
            'D' => 'الفرع',
            'E' => 'مدفوعة (SAR)',
            'F' => 'غير مدفوعة (SAR)',
            'G' => 'مرتجع (SAR)',
            'H' => 'الإجمالي (SAR)',
        ];

        // Set headers
        $col = 'A';
        foreach ($columns as $header) {
            $sheet->setCellValue($col . '1', $header);
            $col++;
        }

        // Style for headers
        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFE5E5E5'],
            ],
        ];
        $sheet->getStyle('A1:H1')->applyFromArray($headerStyle);

        // Populate data
        $row = 2;
        foreach ($groupedInvoices as $clientId => $invoices) {
            $clientName = $invoices->first()->client->trade_name ?? 'عميل ' . $clientId;

            foreach ($invoices as $invoice) {
                $sheet->setCellValue('A' . $row, $clientName);
                $sheet->setCellValue('B' . $row, str_pad($invoice->code, 5, '0', STR_PAD_LEFT));
                $sheet->setCellValue('C' . $row, Carbon::parse($invoice->invoice_date)->format('d/m/Y'));
                $sheet->setCellValue('D' . $row, $invoice->branch->name ?? 'غير محدد');

                if (in_array($invoice->type, ['return', 'returned'])) {
                    $sheet->setCellValue('E' . $row, '-');
                    $sheet->setCellValue('F' . $row, '-');
                    $sheet->setCellValue('G' . $row, number_format($invoice->grand_total, 2));
                    $sheet->setCellValue('H' . $row, number_format($invoice->grand_total, 2));
                } else {
                    $sheet->setCellValue('E' . $row, number_format($invoice->payment_status == 1 ? $invoice->grand_total : $invoice->paid_amount, 2));
                    $sheet->setCellValue('F' . $row, number_format($invoice->payment_status == 1 ? 0 : $invoice->due_value, 2));
                    $sheet->setCellValue('G' . $row, '-');
                    $sheet->setCellValue('H' . $row, number_format($invoice->grand_total, 2));
                }
                $row++;
            }

            // Add subtotal row for each client
            $sheet->setCellValue('A' . $row, 'مجموع العميل');
            $sheet->getStyle('A' . $row . ':H' . $row)->applyFromArray([
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFF0F0F0'],
                ],
            ]);
            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'H') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Prepare file
        $filename = 'تقرير_مبيعات_العملاء_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

        // Redirect output to a client's web browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
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
        return view('reports.sals.p', array_merge(compact('products', 'employees', 'branches', 'clients', 'productSales', 'groupedProductSales', 'productTotals', 'chartData', 'categories', 'fromDate', 'storehouses', 'client_categories', 'toDate'), ['reportPeriod' => $request->input('report_period', 'daily')]));
    }


    public function exportByProductToExcel(Request $request)
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
        $productSales = InvoiceItem::with(['invoice', 'product', 'invoice.client', 'invoice.createdByUser']);

        // Apply filters based on request (similar to byProduct method)
        if ($request->filled('product')) {
            $productSales->where('product_id', $request->product);
        }

        // Branch filter
        if ($request->filled('branch')) {
            $productSales->whereHas('invoice', function ($query) use ($request) {
                $query->where('branch_id', $request->branch);
            });
        }

        // Client filter
        if ($request->filled('client')) {
            $productSales->whereHas('invoice', function ($query) use ($request) {
                $query->where('client_id', $request->client);
            });
        }

        // Employee (Created By) filter
        if ($request->filled('employee')) {
            $productSales->whereHas('invoice', function ($query) use ($request) {
                $query->where('created_by', $request->employee);
            });
        }

        // Invoice Type filter
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

        // Category filter
        if ($request->filled('status')) {
            $productSales->whereHas('product', function ($query) use ($request) {
                $query->where('category_id', $request->status);
            });
        }

        // Storehouse filter
        if ($request->filled('storehouse')) {
            $productSales->whereHas('invoice', function ($query) use ($request) {
                $query->where('storehouse_id', $request->storehouse);
            });
        }

        // Date range filter
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

        // Fetch product sales
        $productSales = $productSales->get();

        // Create new Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set document properties
        $spreadsheet
            ->getProperties()
            ->setCreator(auth()->user()->name)
            ->setTitle('تقرير مبيعات المنتجات')
            ->setSubject('تقرير المبيعات')
            ->setDescription('تقرير مبيعات المنتجات من ' . $fromDate->format('d/m/Y') . ' إلى ' . $toDate->format('d/m/Y'));

        // Set column headers
        $columns = [
            'A' => 'التاريخ',
            'B' => 'رقم الفاتورة',
            'C' => 'نوع الفاتورة',
            'D' => 'المنتج',
            'E' => 'كود المنتج',
            'F' => 'العميل',
            'G' => 'سعر الوحدة',
            'H' => 'الكمية',
            'I' => 'الخصم',
            'J' => 'الإجمالي',
        ];

        // Set headers
        $col = 'A';
        foreach ($columns as $header) {
            $sheet->setCellValue($col . '1', $header);
            $col++;
        }

        // Style for headers
        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFE5E5E5'],
            ],
        ];
        $sheet->getStyle('A1:J1')->applyFromArray($headerStyle);

        // Populate data
        $row = 2;
        foreach ($productSales as $sale) {
            // Determine invoice type display
            $invoiceTypeDisplay = match ($sale->invoice->type) {
                'sale' => 'فاتورة',
                'return' => 'مرتجع',
                'debit_note' => 'اشعار مدين',
                'credit_note' => 'اشعار دائن',
                default => $sale->invoice->type,
            };

            // Adjust quantity for return invoices
            $quantity = $sale->invoice->type === 'return' ? -abs($sale->quantity) : $sale->quantity;
            $totalAmount = $quantity * $sale->unit_price;

            $sheet->setCellValue('A' . $row, $sale->invoice->invoice_date->format('d/m/Y'));
            $sheet->setCellValue('B' . $row, $sale->invoice->code);
            $sheet->setCellValue('C' . $row, $invoiceTypeDisplay);
            $sheet->setCellValue('D' . $row, $sale->product->name);
            $sheet->setCellValue('E' . $row, $sale->product->code);
            $sheet->setCellValue('F' . $row, $sale->invoice->client->trade_name);
            $sheet->setCellValue('G' . $row, number_format($sale->unit_price, 2));
            $sheet->setCellValue('H' . $row, number_format($quantity, 2));
            $sheet->setCellValue('I' . $row, number_format($sale->discount_amount ?? 0, 2));
            $sheet->setCellValue('J' . $row, number_format($totalAmount, 2));

            $row++;
        }

        // Calculate and add totals row
        $sheet->setCellValue('G' . $row, 'المجموع');
        $sheet->setCellValue('H' . $row, number_format($productSales->sum('quantity'), 2));
        $sheet->setCellValue('I' . $row, number_format($productSales->sum('discount_amount'), 2));
        $sheet->setCellValue(
            'J' . $row,
            number_format(
                $productSales->sum(function ($sale) {
                    $quantity = $sale->invoice->type === 'return' ? -abs($sale->quantity) : $sale->quantity;
                    return $quantity * $sale->unit_price;
                }),
                2,
            ),
        );

        // Style for totals row
        $sheet->getStyle('G' . $row . ':J' . $row)->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFF0F0F0'],
            ],
        ]);

        // Auto-size columns
        foreach (range('A', 'J') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Prepare file
        $filename = 'تقرير_مبيعات_المنتجات_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

        // Redirect output to a client's web browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

    public function clientPaymentReport(Request $request)
{
    // الفلاتر الأساسية
    $clients = Client::all();
    $branches = Branch::all();

    // تحديد نطاق التاريخ الافتراضي
    $fromDate = $request->input('from_date', now()->startOfMonth());
    $toDate = $request->input('to_date', now()->endOfMonth());

    // تحديد فترة التقرير
    $reportPeriod = $request->input('report_period', 'monthly');

    // بناء الاستعلام
    $query = PaymentsProcess::with(['client'])
        ->whereBetween('payment_date', [$fromDate, $toDate]);

    // تطبيق الفلاتر
    if ($request->filled('client')) {
        $query->where('clients_id', $request->client);
    }

    // تجميع المدفوعات
    $payments = $query->get();

    // تجهيز بيانات الرسم البياني
    $chartData = $this->prepareChartData($payments);

    return view('reports.sals.payments.client_report', compact(
        'payments',
        'clients',
        'branches',
        'chartData',
        'fromDate',
        'toDate',
        'reportPeriod'
    ));
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
