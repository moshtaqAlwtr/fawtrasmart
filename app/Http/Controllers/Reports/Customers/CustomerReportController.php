<?php

namespace App\Http\Controllers\Reports\Customers;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\CategoriesClient;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\PaymentsProcess;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerReportController extends Controller
{
    public function index()
    {
        return view('reports.customers.index');
    }
    // عرض تقرير أعمار الديون (الفواتير)

    // Fetch additional data for filters
    public function debtReconstructionInv(Request $request)
    {
        // إعداد استعلام الفواتير مع العلاقات اللازمة
        $query = Invoice::with(['client', 'payments']);

        // تطبيق الفلاتر بناءً على معلمات الطلب
        if ($request->filled('branch')) {
            $query->where('branch_id', $request->branch);
        }

        if ($request->filled('customer_type')) {
            $query->whereHas('client', function ($q) use ($request) {
                $q->where('type', $request->customer_type);
            });
        }

        if ($request->filled('customer')) {
            $query->where('client_id', $request->customer);
        }

        if ($request->filled('sales_manager')) {
            $query->where('sales_manager_id', $request->sales_manager);
        }

        // الحصول على الفواتير المفلترة
        $invoices = $query->get();

        // إعداد البيانات للتقرير
        $reportData = $invoices->map(function ($invoice) {
            $remainingAmount = $invoice->calculateRemainingAmount(); // المبلغ المتبقي
            $invoiceDate = $invoice->invoice_date; // تاريخ الفاتورة
            $today = now()->startOfDay(); // تاريخ اليوم بدون وقت

            // حساب عدد الأيام المتأخرة
            $daysLate = $invoiceDate->diffInDays($today);

            // تهيئة جميع الفئات بـ 0
            $todayAmount = 0;
            $days1to30 = 0;
            $days31to60 = 0;
            $days61to90 = 0;
            $days91to120 = 0;
            $daysOver120 = 0;

            // تعيين المبلغ فقط للفئة المناسبة
            if ($daysLate == 0) {
                $todayAmount = $remainingAmount;
            } elseif ($daysLate >= 1 && $daysLate <= 30) {
                $days1to30 = $remainingAmount;
            } elseif ($daysLate >= 31 && $daysLate <= 60) {
                $days31to60 = $remainingAmount;
            } elseif ($daysLate >= 61 && $daysLate <= 90) {
                $days61to90 = $remainingAmount;
            } elseif ($daysLate >= 91 && $daysLate <= 120) {
                $days91to120 = $remainingAmount;
            } elseif ($daysLate > 120) {
                $daysOver120 = $remainingAmount;
            }

            return [
                'client_code' => $invoice->client ? $invoice->client->code : 'غير محدد',
                'account_number' => $invoice->client && $invoice->client->account ? $invoice->client->account->code : 'غير محدد',
                'client_name' => $invoice->client ? $invoice->client->trade_name : 'غير محدد',
                'branch' => $invoice->branch ? $invoice->branch->name : 'غير محدد',
                'today' => $todayAmount, // إذا كانت الفاتورة اليوم
                'days1to30' => $days1to30, // الفواتير بين 1 و 30 يوم
                'days31to60' => $days31to60, // الفواتير بين 31 و 60 يوم
                'days61to90' => $days61to90, // الفواتير بين 61 و 90 يوم
                'days91to120' => $days91to120, // الفواتير بين 91 و 120 يوم
                'daysOver120' => $daysOver120, // الفواتير التي تجاوزت 120 يوم
                'total_due' => $remainingAmount, // إجمالي المبلغ المتبقي
            ];
        });

        // حساب الإجماليات
        $totals = [
            'client_name' => 'الإجمالي',
            'today' => $reportData->sum('today'),
            'days1to30' => $reportData->sum('days1to30'),
            'days31to60' => $reportData->sum('days31to60'),
            'days61to90' => $reportData->sum('days61to90'),
            'days91to120' => $reportData->sum('days91to120'),
            'daysOver120' => $reportData->sum('daysOver120'),
            'total_due' => $reportData->sum('total_due'),
        ];

        // إضافة صف الإجمالي إلى البيانات
        $reportData->push($totals);

        // Fetch additional data for filters
        $branches = Branch::all(); // Assuming you have a Branch model
        $customers = Client::all(); // Assuming you have a Client model
        $salesManagers = Employee::all(); // Assuming you have an Employee model
        $categories = CategoriesClient::all();

        // Pass the data to the view
        return view('reports.customers.CustomerReport.debt_reconstruction_inv', [
            'reportData' => $reportData,
            'branches' => $branches,
            'customers' => $customers,
            'salesManagers' => $salesManagers,
            'categories' => $categories,
        ]);
    }
    // عرض تقرير أعمار الديون (حساب الأستاذ)
    public function debtAgingGeneralLedger(Request $request)
    {
        // إعداد استعلام الفواتير مع العلاقات اللازمة
        $query = Invoice::with(['client', 'payments', 'branch']);

        // تطبيق الفلاتر بناءً على معلمات الطلب
        if ($request->filled('branch')) {
            $query->where('branch_id', $request->branch);
        }

        if ($request->filled('customer_type')) {
            $query->whereHas('client', function ($q) use ($request) {
                $q->where('type', $request->customer_type);
            });
        }

        if ($request->filled('customer')) {
            $query->where('client_id', $request->customer);
        }

        if ($request->filled('sales_manager')) {
            $query->where('sales_manager_id', $request->sales_manager);
        }

        // إضافة فلترة السنة المالية
        if ($request->filled('financial_year')) {
            if (in_array('current', $request->financial_year)) {
                $query->whereYear('invoice_date', date('Y')); // السنة المفتوحة
            }
            if (in_array('all', $request->financial_year)) {
                // لا حاجة لإضافة شرط، سنقوم بجلب جميع السنوات
            } else {
                // إذا تم اختيار سنوات معينة
                $query->whereIn(DB::raw('YEAR(invoice_date)'), $request->financial_year);
            }
        }

        // إضافة فلترة الفترة (أيام)
        if ($request->filled('days')) {
            $today = now()->startOfDay();
            $dateLimit = $today->subDays($request->days);
            $query->where('invoice_date', '<=', $dateLimit);
        }

        // الحصول على الفواتير المفلترة
        $invoices = $query->get();

        // إعداد البيانات للتقرير
        $reportData = $invoices->map(function ($invoice) {
            $remainingAmount = $invoice->calculateRemainingAmount(); // المبلغ المتبقي
            $invoiceDate = $invoice->invoice_date; // تاريخ الفاتورة
            $today = now()->startOfDay(); // تاريخ اليوم بدون وقت

            // حساب عدد الأيام المتأخرة
            $daysLate = $invoiceDate->diffInDays($today);

            // تهيئة جميع الفئات بـ 0
            $todayAmount = 0;
            $days1to30 = 0;
            $days31to60 = 0;
            $days61to90 = 0;
            $days91to120 = 0;
            $daysOver120 = 0;

            // تعيين المبلغ فقط للفئة المناسبة
            if ($daysLate == 0) {
                $todayAmount = $remainingAmount;
            } elseif ($daysLate >= 1 && $daysLate <= 30) {
                $days1to30 = $remainingAmount;
            } elseif ($daysLate >= 31 && $daysLate <= 60) {
                $days31to60 = $remainingAmount;
            } elseif ($daysLate >= 61 && $daysLate <= 90) {
                $days61to90 = $remainingAmount;
            } elseif ($daysLate >= 91 && $daysLate <= 120) {
                $days91to120 = $remainingAmount;
            } elseif ($daysLate > 120) {
                $daysOver120 = $remainingAmount;
            }

            return [
                'client_code' => $invoice->client ? $invoice->client->code : 'غير محدد',
                'account_number' => $invoice->client && $invoice->client->account ? $invoice->client->account->code : 'غير محدد',
                'client_name' => $invoice->client ? $invoice->client->trade_name : 'غير محدد',
                'branch' => $invoice->branch ? $invoice->branch->name : 'غير محدد',
                'today' => $todayAmount, // إذا كانت الفاتورة اليوم
                'days1to30' => $days1to30, // الفواتير بين 1 و 30 يوم
                'days31to60' => $days31to60, // الفواتير بين 31 و 60 يوم
                'days61to90' => $days61to90, // الفواتير بين 61 و 90 يوم
                'days91to120' => $days91to120, // الفواتير بين 91 و 120 يوم
                'daysOver120' => $daysOver120, // الفواتير التي تجاوزت 120 يوم
                'total_due' => $remainingAmount, // إجمالي المبلغ المتبقي
            ];
        });

        // حساب الإجماليات
        $totals = [
            'client_code' => 'الإجمالي',
            'account_number' => '',
            'client_name' => '',
            'branch' => '',
            'today' => $reportData->sum('today'),
            'days1to30' => $reportData->sum('days1to30'),
            'days31to60' => $reportData->sum('days31to60'),
            'days61to90' => $reportData->sum('days61to90'),
            'days91to120' => $reportData->sum('days91to120'),
            'daysOver120' => $reportData->sum('daysOver120'),
            'total_due' => $reportData->sum('total_due'),
        ];

        // إضافة صف الإجمالي إلى البيانات
        $reportData->push($totals);

        // Fetch additional data for filters
        $branches = Branch::all();
        $customers = Client::all();
        $salesManagers = Employee::all();
        $categories = CategoriesClient::all();

        return view('reports.customers.CustomerReport.Debt_aging_general', [
            'reportData' => $reportData,
            'branches' => $branches,
            'customers' => $customers,
            'salesManagers' => $salesManagers,
            'categories' => $categories,
        ]);
    }
    // عرض دليل العملاء
    public function customerGuide(Request $request)
    {
        $query = Client::query();

        // تطبيق الفلاتر إذا كانت موجودة
        if ($request->has('region') && $request->region !== 'الكل') {
            $query->where('region', $request->region);
        }

        if ($request->has('city') && $request->city !== 'الكل') {
            $query->where('city', $request->city);
        }

        if ($request->has('classification') && $request->classification !== 'الكل') {
            $query->where('category', $request->classification);
        }

        if ($request->has('branch') && $request->branch !== 'الكل') {
            $query->where('branch', $request->branch);
        }

        $clients = $query->get();
        $categories = CategoriesClient::all();
        $branch = Branch::all();

        return view('reports.customers.CustomerReport.gustomer_guide', compact('clients', 'categories', 'branch'));
    }
    // عرض أرصدة العملاء
    public function customerBalances(Request $request)
    {
        $employees = Employee::all();
        $branches = Branch::all();
        $clients = Client::all();

        // تطبيق الفلترة
        $filteredClients = Client::query();

        if ($request->filled('date_from')) {
            $filteredClients->whereHas('invoices', function ($query) use ($request) {
                $query->where('invoice_date', '>=', $request->date_from);
            });
        }

        if ($request->filled('date_to')) {
            $filteredClients->whereHas('invoices', function ($query) use ($request) {
                $query->where('invoice_date', '<=', $request->date_to);
            });
        }

        if ($request->filled('client_category')) {
            $filteredClients->where('category', $request->client_category);
        }

        if ($request->filled('client')) {
            $filteredClients->where('id', $request->client);
        }

        if ($request->filled('employee')) {
            $filteredClients->where('employee_id', $request->employee);
        }

        if ($request->filled('branch')) {
            $filteredClients->whereHas('employee.branch', function ($query) use ($request) {
                $query->where('id', $request->branch);
            });
        }

        // جلب البيانات مع العلاقات
        $filteredClients = $filteredClients->with(['invoices', 'payments', 'employee.branch'])->get();

        // تجهيز البيانات للعرض
        $clientBalances = [];
        $totalSales = 0;
        $totalPayments = 0;
        $totalBalance = 0;

        foreach ($filteredClients as $client) {
            // حساب المبيعات والمدفوعات
            $totalInvoices = $client->invoices->where('type', 'normal')->sum('grand_total');
            $totalReturns = $client->invoices->where('type', 'returned')->sum('grand_total');
            $clientPayments = $client->payments->sum('amount');
            $netSales = $totalInvoices - $totalReturns;
            $balance = $netSales - $clientPayments;

            // تحديث الإجماليات
            $totalSales += $netSales;
            $totalPayments += $clientPayments;
            $totalBalance += $balance;

            // إضافة للمصفوفة فقط إذا كان الرصيد غير صفري (عند تفعيل الخيار)
            if (!$request->hide_zero || $balance != 0) {
                $clientBalances[] = [
                    'code' => $client->code,
                    'account_number' => $client->account_id,
                    'name' => $client->trade_name ?? $client->first_name . ' ' . $client->last_name,
                    'branch' => $client->employee->branch->name ?? 'غير محدد',
                    'currency_status' => $client->currency,
                    'employee' => $client->employee->full_name ?? 'غير محدد',
                    'balance_before' => $client->opening_balance ?? 0,
                    'total_sales' => $totalInvoices,
                    'total_returns' => $totalReturns,
                    'net_sales' => $netSales,
                    'total_payments' => $clientPayments,
                    'adjustments' => 0, // يمكن إضافة حساب التسويات لاحقاً
                    'balance' => $balance
                ];
            }
        }

        // ترتيب النتائج حسب الرصيد تنازلياً
        usort($clientBalances, function($a, $b) {
            return $b['balance'] <=> $a['balance'];
        });

        return view('reports.customers.CustomerReport.customer_blances', compact(
            'clientBalances',
            'employees',
            'branches',
            'clients',
            'totalSales',
            'totalPayments',
            'totalBalance'
        ))->with('totalClients', count($clientBalances));
    }
        // تمرير البيانات إلى العرض

    // عرض مبيعات العملاء

    public function customerSales(Request $request)
    {
        // الاستعلام الأساسي مع العلاقات
        $query = Invoice::query()
            ->with(['client', 'branch'])
            ->orderBy('invoice_date', 'desc');

        // تطبيق الفلترة
        if ($request->filled('date_from')) {
            $query->whereDate('invoice_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('invoice_date', '<=', $request->date_to);
        }

        if ($request->filled('client_category')) {
            $query->whereHas('client', function($q) use ($request) {
                $q->where('category', $request->client_category);
            });
        }

        if ($request->filled('branch')) {
            $query->where('branch_id', $request->branch);
        }

        if ($request->filled('client')) {
            $query->where('client_id', $request->client);
        }

        // الحصول على الفواتير وتجميعها حسب العميل
        $invoices = $query->get();

        // تجميع الفواتير حسب العميل
        $groupedInvoices = $invoices->groupBy(function($invoice) {
            return $invoice->client->trade_name ?? $invoice->client->name ?? 'عميل غير معروف';
        })->map(function($clientInvoices) {
            return $clientInvoices->map(function($invoice) {
                $valueBeforeTax = $invoice->grand_total - $invoice->tax_total; // حساب القيمة قبل الضريبة

                return (object) [
                    'date' => Carbon::parse($invoice->invoice_date)->format('d/m/Y'),
                    'type' => 'فاتورة',
                    'client_name' => $invoice->client->trade_name ?? $invoice->client->name ?? '',
                    'document_number' => $invoice->document_number,
                    'branch' => $invoice->employee->branch->name ?? 'Main Branch',
                    'shipping_cost' => $invoice->shipping_cost ?? 0,
                    'value' => $valueBeforeTax, // القيمة قبل الضريبة
                    'taxes' => $invoice->tax_total ?? 0,
                    'groups' => $invoice->groups ?? 0,
                    'total' => $invoice->grand_total ?? 0 // المجموع النهائي بعد الضرائب
                ];
            });
        });

        // الحصول على قائمة العملاء للفلتر
        $clients = Client::all();

        // حساب الإجماليات الكلية
        $grandTotals = [
            'value' => $invoices->sum('value'),
            'taxes' => $invoices->sum('taxes'),
            'groups' => $invoices->sum('groups'),
            'total' => $invoices->sum('total')
        ];

        return view('reports.customers.CustomerReport.customer_sales', compact(
            'groupedInvoices',
            'grandTotals',
            'clients'
        ));
    }
    // عرض مدفوعات العملاء
    public function customerPayments(Request $request)
    {
        // الاستعلام الأساسي لجلب المدفوعات
        $query = PaymentsProcess::query()
            ->with(['client', 'employee', 'branch'])
            ->orderBy('payment_date', 'desc');

        // تطبيق الفلترة
        if ($request->filled('date_from')) {
            $query->whereDate('payment_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('payment_date', '<=', $request->date_to);
        }

        if ($request->filled('employee')) {
            $query->where('employee_id', $request->employee);
        }

        if ($request->filled('client_category')) {
            $query->whereHas('client', function($q) use ($request) {
                $q->where('category', $request->client_category);
            });
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // جلب البيانات
        $payments = $query->get();

        // تحقق من وجود بيانات
        if ($payments->isEmpty()) {
            return redirect()->back()->with('error', 'لا توجد بيانات مطابقة للمعايير المحددة.');
        }

        // الحصول على قائمة العملاء للفلتر
        $clients = Client::all();

        return view('reports.customers.CustomerReport.customer_payments', compact('payments', 'clients'));
    }
    // عرض كشف حساب العملاء
    public function customerStatements()
    {
        return view('reports.customers.customer-statements');
    }

    // عرض مواعيد العملاء
    public function customerAppointments()
    {
        return view('reports.customers.customer-appointments');
    }

    // عرض أقساط العملاء
    public function customerInstallments()
    {
        return view('reports.customers.customer-installments');
    }
    // تأكد من استيراد نموذج Sale
}
