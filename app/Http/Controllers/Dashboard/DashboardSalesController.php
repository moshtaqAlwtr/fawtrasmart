<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Neighborhood;
use App\Models\PaymentsProcess;
use App\Models\Receipt;
use App\Models\Target;
use App\Models\Visit;
use App\Models\User;
use App\Models\ClientEmployee;
use Carbon\Carbon;
use DB;

class DashboardSalesController extends Controller
{
    public function index(Request $request)
    {

        $ClientCount = Client::count();
        $Invoice = Invoice::where('type','normal')->sum('grand_total');
        $Visit = Visit::count();

      



        // 1. جلب بيانات الفواتير والمبيعات
        $groups = Neighborhood::with('Region')
            ->leftJoin('invoices', 'neighborhoods.client_id', '=', 'invoices.client_id')
            ->select('region_id', DB::raw('COALESCE(SUM(invoices.grand_total), 0) as total_sales'))
            ->groupBy('region_id')
            ->get();

        // 2. حساب المدفوعات لكل مجموعة
        $payments = Neighborhood::join('region_groubs', 'neighborhoods.region_id', '=', 'region_groubs.id')
            ->join('clients', 'neighborhoods.client_id', '=', 'clients.id')
            ->join('invoices', 'clients.id', '=', 'invoices.client_id')
            ->join('payments_process', 'invoices.id', '=', 'payments_process.invoice_id')
            ->select('neighborhoods.region_id', DB::raw('COALESCE(SUM(payments_process.amount), 0) as total_payments'))
            ->groupBy('neighborhoods.region_id')
            ->get()
            ->keyBy('region_id');



        // 3. حساب سندات القبض لكل مجموعة
        $receipts = Neighborhood::join('region_groubs', 'neighborhoods.region_id', '=', 'region_groubs.id')
            ->join('clients', 'neighborhoods.client_id', '=', 'clients.id')
            ->join('accounts', 'clients.id', '=', 'accounts.client_id')
            ->join('receipts', 'accounts.id', '=', 'receipts.account_id')
            ->select('neighborhoods.region_id', DB::raw('COALESCE(SUM(receipts.amount), 0) as total_receipts'))
            ->groupBy('neighborhoods.region_id')
            ->get()
            ->keyBy('region_id');


        // 4. دمج البيانات في groupChartData
        $groupChartData = $groups->map(function ($item) use ($payments, $receipts) {
            return [
                'region'    => optional($item->region)->name ?? 'غير معروف',
                'sales'     => (float) $item->total_sales,
                'payments'  => (float) ($payments[$item->region_id]->total_payments ?? 0),
                'receipts'  => (float) ($receipts[$item->region_id]->total_receipts ?? 0),
            ];
        });




        ///
        // حساب إجمالي المبيعات
        $totalSales = Invoice::where('type','normal')->sum('grand_total');

        // الحصول على مبيعات الموظفين
        $employeesSales = Invoice::selectRaw('created_by, COALESCE(SUM(grand_total), 0) as sales')
            ->groupBy('created_by')
            ->get();

       
        // إنشاء البيانات للمخطط البياني
        $chartData = $employeesSales->map(function ($employee) use ($totalSales) {
            $user = User::find($employee->created_by);
            return [
                'name' => $user ? $user->name : 'غير معروف',
                'sales' => $employee->sales,
                'percentage' => ($totalSales > 0) ? round(($employee->sales / $totalSales) * 100, 2) : 0
            ];
        });
      
        $defaultTarget = Target::find(1)->value ?? 35000;
        // الشهر المحدد
    $month = $request->input('month', now()->format('Y-m'));
    [$year, $monthNum] = explode('-', $month);

    // الموظفون الذين لديهم فواتير هذا الشهر (لتحديد من له مدفوعات)
    $invoiceEmployeeIds = Invoice::whereMonth('created_at', $monthNum)
        ->whereYear('created_at', $year)
        ->pluck('created_by')
        ->unique();

    // الموظفون الذين أنشؤوا سندات قبض هذا الشهر
    $receiptEmployeeIds = Receipt::whereMonth('created_at', $monthNum)
        ->whereYear('created_at', $year)
        ->pluck('created_by')
        ->unique();

    // دمج كل من لديه نشاط في هذا الشهر
    $employeeIds = $invoiceEmployeeIds->merge($receiptEmployeeIds)->unique();

    // استخراج بيانات الأداء
$cards = $employeeIds->map(function ($userId) use ($defaultTarget, $monthNum, $year) {
    $user = User::find($userId);
    
    $returnedInvoiceIds = Invoice::whereNotNull('reference_number')
    ->pluck('reference_number')
    ->toArray();

// الفواتير الأصلية التي يجب استبعادها = كل فاتورة تم عمل راجع لها
// بالإضافة إلى الفواتير التي تم تصنيفها صراحةً على أنها راجعة
$excludedInvoiceIds = array_unique(array_merge(
    $returnedInvoiceIds,
    Invoice::where('type', 'returned')->pluck('id')->toArray()
));



   $invoiceIds = Invoice::where('created_by', $userId)->where('type','normal')->whereNotIn('id', $excludedInvoiceIds) // ✅ استبعاد الفواتير التي لها راجع
    ->pluck('id');

    $paymentsTotal = PaymentsProcess::whereIn('invoice_id', $invoiceIds)->whereMonth('created_at', $monthNum)
        ->whereYear('created_at', $year)->sum('amount');

    $receiptsTotal = Receipt::where('created_by', $userId)
        ->whereMonth('created_at', $monthNum)
        ->whereYear('created_at', $year)
        ->sum('amount');

    $totalCollected = $paymentsTotal + $receiptsTotal;

    $target = $user->target?->monthly_target ?? $defaultTarget;
    $percentage = $target > 0 ? round(($totalCollected / $target) * 100, 2) : 0;
    
     $clientCount = ClientEmployee::where('employee_id', $user->employee_id)->count();

    return [
        'name' => $user?->name ?? 'غير معروف',
        'payments' => $paymentsTotal,
        'receipts' => $receiptsTotal,
        'total' => $totalCollected,
        'target' => $target,
        'percentage' => $percentage,
        'clients_count' => $clientCount,
    ];
});

// ✅ الترتيب تنازليًا حسب المبلغ المحصل
$cards = $cards->sortByDesc('total')->values();


    
        $totalSales    = $groups->sum('total_sales');
        $totalPayments = $payments->sum('total_payments');
        $totalReceipts = $receipts->sum('total_receipts');

        return view('dashboard.sales.index', compact('ClientCount','cards','month', 'groupChartData', 'Invoice', 'groups', 'Visit', 'chartData', 'totalSales', 'totalPayments', 'totalReceipts'));
        return view('dashboard.sales.index', compact('ClientCount', 'Invoice'));
    }
}






