<?php

namespace App\Http\Controllers\Reports\Customers;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Appointment;
use App\Models\BalanceCharge;
use App\Models\BalanceType;
use App\Models\Branch;
use App\Models\CategoriesClient;
use App\Models\Client;
use App\Models\CostCenter;
use App\Models\Employee;
use App\Models\Installment;
use App\Models\Invoice;
use App\Models\JournalEntry;
use App\Models\Log;
use App\Models\PaymentsProcess;
use App\Models\User;
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
            $query->whereHas('client', function ($query) use ($request) {
                $query->where('branch_id', $request->branch);
            });
        }

        if ($request->filled('customer_type')) {
            $query->whereHas('client', function ($q) use ($request) {
                $q->where('type', $request->customer_type);
            });
        }

        if ($request->filled('customer')) {
            $query->where('client_id', $request->customer);
        }

        if ($request->filled('added_by')) {
            $query->where('created_by', $request->added_by);
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
                'branch' => $invoice->employee ? $invoice->employee->branch->name : 'غير محدد',
                'today' => $todayAmount, // إذا كانت الفاتورة اليوم
                'days1to30' => $days1to30, // الفواتير بين 1 و 30 يوم
                'days31to60' => $days31to60, // الفواتير بين 31 و 60 يوم
                'days61to90' => $days61to90, // الفواتير بين 61 و 90 يوم
                'days91to120' => $days91to120, // الفواتير بين 91 و 120 يوم
                'daysOver120' => $daysOver120, // الفواتير التي تجاوزت 120 يوم
                'total_due' => $remainingAmount, // إجمالي المبلغ المتبقي
            ];
        });
        // Fetch additional data for filters
        $branches = Branch::all(); // Assuming you have a Branch model
        $customers = Client::all(); // Assuming you have a Client model
        $salesManagers = User::where('role', 'employee')->get(); // Assuming you have an Employee model
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
        // إعداد استعلام الحسابات مع العلاقات اللازمة
        $query = Account::with(['client', 'branch'])
            ->whereNotNull('client_id') // نريد فقط حسابات العملاء
            ->where('balance', '>', 0); // نريد فقط الحسابات التي عليها مديونية

        // تطبيق الفلاتر
        if ($request->filled('branch')) {
            $query->whereHas('client', function ($q) use ($request) {
                $q->where('branch_id', $request->branch);
            });
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
            $query->whereHas('client.clientEmployees', function ($q) use ($request) {
                $q->where('employee_id', $request->sales_manager);
            });
        }

        // الحصول على الحسابات المفلترة
        $accounts = $query->get();

        // إعداد البيانات للتقرير
        $reportData = $accounts->map(function ($account) {
            $today = now()->startOfDay();

            // تهيئة المتغيرات
            $todayAmount = 0;
            $days1to30 = 0;
            $days31to60 = 0;
            $days61to90 = 0;
            $days91to120 = 0;
            $daysOver120 = 0;

            // الحصول على الرصيد الحالي
            $currentBalance = $account->balance;

            // تصنيف الرصيد حسب تاريخ آخر تحديث للحساب
            if ($currentBalance > 0) {
                $lastUpdateDate = $account->updated_at->startOfDay();
                $daysLate = $lastUpdateDate->diffInDays($today);

                // تصنيف المبلغ حسب عمر الدين
                if ($daysLate == 0) {
                    $todayAmount = $currentBalance;
                } elseif ($daysLate >= 1 && $daysLate <= 30) {
                    $days1to30 = $currentBalance;
                } elseif ($daysLate >= 31 && $daysLate <= 60) {
                    $days31to60 = $currentBalance;
                } elseif ($daysLate >= 61 && $daysLate <= 90) {
                    $days61to90 = $currentBalance;
                } elseif ($daysLate >= 91 && $daysLate <= 120) {
                    $days91to120 = $currentBalance;
                } else {
                    $daysOver120 = $currentBalance;
                }
            }

            // إعداد بيانات الصف
            return [
                'client_code' => $account->client->code ?? 'غير محدد',
                'account_number' => $account->code ?? 'غير محدد',
                'client_name' => $account->client->trade_name ?? 'غير محدد',
                'branch' => $account->client->branch->name ?? 'غير محدد',
                'today' => round($todayAmount, 2),
                'days1to30' => round($days1to30, 2),
                'days31to60' => round($days31to60, 2),
                'days61to90' => round($days61to90, 2),
                'days91to120' => round($days91to120, 2),
                'daysOver120' => round($daysOver120, 2),
                'total_due' => round($currentBalance, 2),
                'credit_limit' => round($account->credit_limit ?? 0, 2),
                'available_credit' => round($account->credit_limit - $currentBalance ?? 0, 2),
                'last_update' => $account->updated_at->format('Y-m-d'),
            ];
        });

        // حساب الإجماليات
        $totals = [
            'today' => $reportData->sum('today'),
            'days1to30' => $reportData->sum('days1to30'),
            'days31to60' => $reportData->sum('days31to60'),
            'days61to90' => $reportData->sum('days61to90'),
            'days91to120' => $reportData->sum('days91to120'),
            'daysOver120' => $reportData->sum('daysOver120'),
            'total_due' => $reportData->sum('total_due'),
        ];

        // إضافة صف الإجماليات إلى نهاية التقرير
        $reportData->push([
            'client_code' => 'الإجمالي',
            'account_number' => '',
            'client_name' => '',
            'branch' => '',
            'today' => round($totals['today'], 2),
            'days1to30' => round($totals['days1to30'], 2),
            'days31to60' => round($totals['days31to60'], 2),
            'days61to90' => round($totals['days61to90'], 2),
            'days91to120' => round($totals['days91to120'], 2),
            'daysOver120' => round($totals['daysOver120'], 2),
            'total_due' => round($totals['total_due'], 2),
            'credit_limit' => '',
            'available_credit' => '',
            'last_update' => '',
        ]);

        // جلب البيانات الإضافية للفلاتر
        $branches = Branch::all();
        $customers = Client::all();
        $salesManagers = User::where('role', 'employee')->get();
        $categories = CategoriesClient::all();

        // عرض الصفحة مع البيانات
        return view('reports.customers.CustomerReport.Debt_aging_general', [
            'reportData' => $reportData,
            'branches' => $branches,
            'customers' => $customers,
            'salesManagers' => $salesManagers,
            'categories' => $categories,
        ]);
    } // عرض دليل العملاء
    public function customerGuide(Request $request)
    {
        $query = Client::query()->with(['locations']);

        // تطبيق الفلاتر
        if ($request->filled('region') && $request->region !== 'الكل') {
            $query->where('region', $request->region);
        }

        if ($request->filled('city') && $request->city !== 'الكل') {
            $query->where('city', $request->city);
        }

        if ($request->filled('country')) {
            $query->where('country', 'like', '%' . $request->country . '%');
        }

        if ($request->filled('classification') && $request->classification !== 'الكل') {
            $query->where('category_id', $request->classification);
        }

        if ($request->filled('branch') && $request->branch !== 'الكل') {
            $query->where('branch_id', $request->branch);
        }

        // جلب فقط العملاء الذين لديهم مواقع إذا تم اختيار مشاهدة التفاصيل
        if ($request->boolean('view_details')) {
            $query->whereHas('locations');
        }

        $clients = $query->get();
        $categories = CategoriesClient::all();
        $branch = Branch::all();

        return view('reports.customers.CustomerReport.gustomer_guide', compact('clients', 'categories', 'branch'));
    }
    // عرض أرصدة العملاء
    public function customerBalances(Request $request)
    {
        $employees = User::where('role', 'employee')->get();
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
            $filteredClients->whereHas('branch', function ($query) use ($request) {
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

            // حساب المبلغ المستحق (due_value)
            $dueValue = $netSales - $clientPayments;

            // حساب الرصيد بعد (الرصيد الافتتاحي + due_value)
            $balance = ($client->opening_balance ?? 0) + $dueValue;

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
                    'balance_before' => $client->opening_balance ?? 0, // الرصيد الافتتاحي
                    'total_sales' => $totalInvoices,
                    'total_returns' => $totalReturns,
                    'net_sales' => $netSales,
                    'total_payments' => $clientPayments,
                    'due_value' => $dueValue, // المبلغ المستحق
                    'adjustments' => 0, // يمكن إضافة حساب التسويات لاحقاً
                    'balance' => $balance, // الرصيد بعد (الرصيد الافتتاحي + due_value)
                ];
            }
        }

        // ترتيب النتائج حسب الرصيد تنازلياً
        usort($clientBalances, function ($a, $b) {
            return $b['balance'] <=> $a['balance'];
        });

        return view('reports.customers.CustomerReport.customer_blances', compact('clientBalances', 'employees', 'branches', 'clients', 'totalSales', 'totalPayments', 'totalBalance'))->with('totalClients', count($clientBalances));
    }

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
        if ($request->filled('added_by')) {
            $query->where('created_by', $request->added_by);
        }

        if ($request->filled('client_category')) {
            $query->whereHas('client', function ($q) use ($request) {
                $q->where('category', $request->client_category);
            });
        }
        if ($request->filled('branch')) {
            $query->whereHas('client', function ($q) use ($request) {
                $q->where('branch_id', $request->branch);
            });
        }
        if ($request->filled('client')) {
            $query->where('client_id', $request->client);
        }

        // الحصول على الفواتير وتجميعها حسب العميل
        $invoices = $query->get();

        // تجميع الفواتير حسب العميل
        $groupedInvoices = $invoices
            ->groupBy(function ($invoice) {
                return $invoice->client->trade_name ?? ($invoice->client->name ?? 'عميل غير معروف');
            })
            ->map(function ($clientInvoices) {
                return $clientInvoices->map(function ($invoice) {
                    $valueBeforeTax = $invoice->grand_total - $invoice->tax_total; // حساب القيمة قبل الضريبة

                    return (object) [
                        'date' => Carbon::parse($invoice->invoice_date)->format('d/m/Y'),
                        'type' => 'فاتورة',
                        'client_name' => $invoice->client->trade_name ?? ($invoice->client->name ?? ''),
                        'document_number' => $invoice->document_number,
                        'branch' => $invoice->employee->branch->name ?? 'Main Branch',
                        'shipping_cost' => $invoice->shipping_cost ?? 0,
                        'value' => $valueBeforeTax, // القيمة قبل الضريبة
                        'taxes' => $invoice->tax_total ?? 0,
                        'groups' => $invoice->groups ?? 0,
                        'total' => $invoice->grand_total ?? 0, // المجموع النهائي بعد الضرائب
                    ];
                });
            });

        // الحصول على قائمة العملاء للفلتر
        $clients = Client::all();
        $branches = Branch::all();
        $employees = User::where('role', 'employee')->get();

        // حساب الإجماليات الكلية
        $grandTotals = [
            'value' => $invoices->sum('value'),
            'taxes' => $invoices->sum('taxes'),
            'groups' => $invoices->sum('groups'),
            'total' => $invoices->sum('total'),
        ];

        return view('reports.customers.CustomerReport.customer_sales', compact('groupedInvoices', 'grandTotals', 'clients', 'branches', 'employees'))->with('totalInvoices', $invoices->count());
    }
    // عرض مدفوعات العملاء
    public function customerPayments(Request $request)
    {
        $query = PaymentsProcess::with([
                'client',
                'employee',
                'branch',
                'payment_type',
                'invoice' => function($q) {
                    $q->with(['createdByUser', 'client.branch']);
                }
            ])
            ->orderBy('payment_date', 'desc');

        // فلترة حسب التاريخ
        $query->when($request->filled('date_from'), function ($q) use ($request) {
            $q->whereDate('payment_date', '>=', $request->date_from);
        })
        ->when($request->filled('date_to'), function ($q) use ($request) {
            $q->whereDate('payment_date', '<=', $request->date_to);
        });

        // فلترة حسب العميل
        $query->when($request->filled('client_id'), function ($q) use ($request) {
            $q->where('client_id', $request->client_id);
        });

        // فلترة حسب الموظف (الآن من الفواتير)
        $query->when($request->filled('employee_id'), function ($q) use ($request) {
            $q->whereHas('invoice', function ($invoiceQuery) use ($request) {
                $invoiceQuery->where('created_by', $request->employee_id);
            });
        });

        // فلترة حسب تصنيف العميل
        $query->when($request->filled('client_category_id'), function ($q) use ($request) {
            $q->whereHas('client', function ($clientQuery) use ($request) {
                $clientQuery->where('category_id', $request->client_category_id);
            });
        });

        // فلترة حسب وسيلة الدفع
        $query->when($request->filled('payment_method'), function ($q) use ($request) {
            $q->where('payment_method', $request->payment_method);
        });

        // فلترة حسب الفرع (الآن من الفواتير عبر العملاء)
        $query->when($request->filled('branch'), function ($q) use ($request) {
            $q->whereHas('invoice.client', function ($clientQuery) use ($request) {
                $clientQuery->where('branch_id', $request->branch);
            });
        });

        // فلترة حسب حالة الضريبة
        $query->when($request->filled('tax_status'), function ($q) use ($request) {
            $q->where('tax_status', $request->tax_status == 'with_tax' ? 1 : 0);
        });

        $payments = $query->get();

        // إحصاءات وسائل الدفع
        $paymentLabels = ['نقدي', 'بطاقة ائتمان', 'تحويل بنكي'];
        $paymentData = [
            $payments->where('payment_method', 'cash')->count(),
            $payments->where('payment_method', 'credit_card')->count(),
            $payments->where('payment_method', 'bank_transfer')->count()
        ];

        return view('reports.customers.CustomerReport.customer_payments', [
            'payments' => $payments,
            'clients' => Client::all(),
            'employees' => User::where('role', 'employee')->get(),
            'clientCategories' => CategoriesClient::all(),
            'branches' => Branch::all(),
            'paymentLabels' => $paymentLabels,
            'paymentData' => $paymentData,
        ]);
    }
    // عرض كشف حساب العملاء
    public function customerAccountStatement(Request $request)
    {
        // إعداد الاستعلام الأساسي لجلب كشف حساب العملاء
        $query = Account::query()
            ->with(['customer', 'branch', 'journalEntries.journalEntry'])
            ->orderBy('created_at', 'desc');

        // تطبيق الفلاتر
        if ($request->filled('branch')) {
            $query->where('branch_id', $request->branch);
        }

        if ($request->filled('account')) {
            $query->where('id', $request->account);
        }

        if ($request->filled('days')) {
            $query->where('created_at', '>=', now()->subDays($request->days));
        }

        if ($request->filled('financial_year')) {
            if (in_array('current', $request->financial_year)) {
                $query->whereYear('created_at', date('Y'));
            }
            if (!in_array('all', $request->financial_year)) {
                $query->whereIn(DB::raw('YEAR(created_at)'), $request->financial_year);
            }
        }

        if ($request->filled('customer_type')) {
            $query->whereHas('customer', function($q) use ($request) {
                $q->where('category_id', $request->customer_type);
            });
        }

        if ($request->filled('customer')) {
            $query->where('customer_id', $request->customer);
        }

        if ($request->filled('cost_center')) {
            $query->whereHas('journalEntries.journalEntry', function($q) use ($request) {
                $q->where('cost_center_id', $request->cost_center);
            });
        }

        if ($request->filled('sales_manager')) {
            $query->whereHas('journalEntries.journalEntry', function($q) use ($request) {
                $q->where('employee_id', $request->sales_manager);
            });
        }

        // جلب البيانات
        $accountStatements = $query->get();

        // جلب القيود المحاسبية مع تطبيق نفس الفلاتر
        $journalEntriesQuery = JournalEntry::with(['details', 'client', 'employee', 'costCenter'])
            ->orderBy('date', 'desc');

        // تطبيق نفس الفلاتر على القيود المحاسبية
        if ($request->filled('branch')) {
            $journalEntriesQuery->whereHas('details.account', function($q) use ($request) {
                $q->where('branch_id', $request->branch);
            });
        }

        if ($request->filled('account')) {
            $journalEntriesQuery->whereHas('details', function($q) use ($request) {
                $q->where('account_id', $request->account);
            });
        }

        if ($request->filled('days')) {
            $journalEntriesQuery->where('date', '>=', now()->subDays($request->days));
        }

        if ($request->filled('financial_year')) {
            if (in_array('current', $request->financial_year)) {
                $journalEntriesQuery->whereYear('date', date('Y'));
            }
            if (!in_array('all', $request->financial_year)) {
                $journalEntriesQuery->whereIn(DB::raw('YEAR(date)'), $request->financial_year);
            }
        }

        if ($request->filled('customer_type')) {
            $journalEntriesQuery->whereHas('client', function($q) use ($request) {
                $q->where('category_id', $request->customer_type);
            });
        }

        if ($request->filled('customer')) {
            $journalEntriesQuery->where('client_id', $request->customer);
        }

        if ($request->filled('cost_center')) {
            $journalEntriesQuery->where('cost_center_id', $request->cost_center);
        }

        if ($request->filled('sales_manager')) {
            $journalEntriesQuery->where('employee_id', $request->sales_manager);
        }

        $journalEntries = $journalEntriesQuery->get();

        // الحصول على قائمة الفروع، العملاء، ومديري المبيعات للفلتر
        $branches = Branch::all();
        $customers = Client::all();
        $salesManagers = Employee::all();
        $categories = CategoriesClient::all();
        $accounts = Account::all();
        $costCenters = CostCenter::all();

        return view('reports.customers.CustomerReport.customer_account_statement',
            compact('accountStatements', 'journalEntries', 'costCenters', 'accounts',
                    'branches', 'customers', 'salesManagers', 'categories'));
    }
    // عرض مواعيد العملاء

    public function customerAppointments(Request $request)
    {
        // جلب جميع العملاء والموظفين للفلترة
        $clients = Client::all();
        $employees = Employee::all();

        // بدء بناء الاستعلام
        $query = Appointment::with(['client', 'employee', 'notes']);

        // تطبيق الفلترة بناءً على القيم المدخلة
        if ($request->has('client') && $request->client != '') {
            $query->where('client_id', $request->client);
        }

        if ($request->has('employee') && $request->employee != '') {
            $query->where('employee_id', $request->employee);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('created_by') && $request->created_by != '') {
            $query->whereHas('notes', function ($q) use ($request) {
                $q->where('user_id', $request->created_by);
            });
        }

        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('appointment_date', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('appointment_date', '<=', $request->date_to);
        }

        if ($request->has('view_details') && $request->view_details == 'on') {
            $query->with('notes');
        }

        // جلب البيانات المفلترة
        $appointments = $query->orderBy('appointment_date', 'desc')->get();

        // عرض الواجهة مع البيانات
        return view('reports.customers.CustomerReport.customer_apptilmition', compact('appointments', 'clients', 'employees'));
    }

    // عرض أقساط العملاء
    public function customerInstallments(Request $request)
    {
        // جلب جميع الفواتير مع الأقساط المرتبطة بها
        $installments = Installment::query();

        // تطبيق الفلاتر بناءً على المدخلات
        if ($request->has('client') && $request->client != '') {
            $installments->where('client_id', $request->client);
        }

        if ($request->has('category') && $request->category != '') {
            $installments->where('category_id', $request->category);
        }

        if ($request->has('from_date') && $request->from_date != '') {
            $installments->where('date', '>=', $request->from_date);
        }

        if ($request->has('to_date') && $request->to_date != '') {
            $installments->where('date', '<=', $request->to_date);
        }

        if ($request->has('status') && $request->status != '') {
            $installments->where('status', $request->status);
        }

        if ($request->has('branch') && $request->branch != '') {
            $installments->where('branch_id', $request->branch);
        }

        // جلب البيانات المفلترة
        $installments = $installments->get();

        // جلب البيانات الأخرى
        $clients = Client::all();
        $employees = Employee::all();
        $branches = Branch::all();
        $categories = CategoriesClient::all();

        // عرض الواجهة مع البيانات
        return view('reports.customers.CustomerReport.customer_installment', compact('installments', 'clients', 'employees', 'branches', 'categories'));
    }
    public function getInvoicesByMonth($month)
    {
        $monthNumber = array_search($month, ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر']) + 1;

        // Fetch invoices and group by employee
        $invoices = Invoice::whereMonth('invoice_date', $monthNumber)
            ->with('employee') // Assuming you have a relationship set up
            ->get()
            ->groupBy('employee_id'); // Group by employee ID

        // Prepare data for response
        $responseData = [];
        foreach ($invoices as $employeeId => $employeeInvoices) {
            $responseData[] = [
                'employee_name' => $employeeInvoices->first()->employee->full_name, // Adjust as necessary
                'invoice_count' => $employeeInvoices->count(),
            ];
        }

        return response()->json($responseData);
    }



public function BalancesClient(Request $request)
{
return view('reports.balances.index');
}
    public function rechargeBalancesReport(Request $request)
{
    try {
        // بناء الاستعلام الأساسي مع العلاقات
        $query = BalanceCharge::with([
            'client' => function($query) {
                $query->with('branch');
            },
            'balanceType'
        ]);

        // تطبيق فلتر العميل
        $query->when($request->filled('customer'), function($q) use ($request) {
            $q->where('client_id', $request->customer);
        });

        // تطبيق فلتر نوع الرصيد
        $query->when($request->filled('income_type'), function($q) use ($request) {
            $q->where('balance_type_id', $request->income_type);
        });

        // تطبيق فلتر التاريخ من
        $query->when($request->filled('date_from'), function($q) use ($request) {
            $q->whereDate('start_date', '>=', $request->date_from);
        });

        // تطبيق فلتر التاريخ إلى
        $query->when($request->filled('date_to'), function($q) use ($request) {
            $q->whereDate('end_date', '<=', $request->date_to);
        });

        // تطبيق فلتر الفرع
        $query->when($request->filled('branch'), function($q) use ($request) {
            $q->whereHas('client', function($clientQuery) use ($request) {
                $clientQuery->where('branch_id', $request->branch);
            });
        });

        // الحصول على النتائج مع الترتيب
        $charges = $query->orderBy('created_at', 'desc')->get();

        // حساب الإجمالي
        $totalAmount = $charges->sum('value');

        // بيانات الفلاتر
        $filterData = [
            'clients' => Client::orderBy('trade_name')->get(),
            'types' => BalanceType::orderBy('name')->get(),
            'branches' => Branch::orderBy('name')->get()
        ];

        return view('reports.balances.rechargeBalancesReport', array_merge([
            'charges' => $charges,
            'totalAmount' => $totalAmount,
            'request' => $request
        ], $filterData));

    } catch (\Exception $e) {
        Log::error('Error in recharge report: '.$e->getMessage());
        return back()->with('error', 'حدث خطأ: '.$e->getMessage());
    }
}
}
