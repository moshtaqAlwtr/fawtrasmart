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
use App\Models\Visit;
use App\Models\User;
use DB;

class DashboardSalesController extends Controller
{
    public function index()
    {

        $ClientCount = Client::count();
        $Invoice = Invoice::sum('grand_total');
        $Visit = Visit::count();

        // حساب مبيعات الأحياء مع الأقاليم
        // $groups = DB::table('neighborhoods')
        // ->leftJoin('clients', 'neighborhoods.client_id', '=', 'clients.id')
        // ->leftJoin('invoices', 'clients.id', '=', 'invoices.client_id')
        // ->leftJoin('payments_process', 'invoices.id', '=', 'payments_process.invoice_id')
        // ->leftJoin('region_groubs', 'neighborhoods.region_id', '=', 'region_groubs.id')
        // ->select(
        //     'neighborhoods.region_id',
        //     'region_groubs.name as region_name',
        //     DB::raw('COALESCE(SUM(DISTINCT invoices.grand_total), 0) as total_sales'),
        //     DB::raw('COALESCE(SUM(DISTINCT payments_process.amount), 0) as total_payments')
        // )
        // ->groupBy('neighborhoods.region_id', 'region_groubs.name')
        // ->get();




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
        $totalSales = Invoice::sum('grand_total');

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
        // $groupChartData = $groups->map(function ($group) {
        //     return [
        //         'region' => $group->region_name ?? 'غير معروف',
        //         'sales' => (float) $group->total_sales,
        //         'payments' => (float) $group->total_payments,
        //     ];
        // });
        $totalSales    = $groups->sum('total_sales');
        $totalPayments = $payments->sum('total_payments');
        $totalReceipts = $receipts->sum('total_receipts');

        return view('dashboard.sales.index', compact('ClientCount', 'groupChartData', 'Invoice', 'groups', 'Visit', 'chartData', 'totalSales', 'totalPayments', 'totalReceipts'));
        return view('dashboard.sales.index', compact('ClientCount', 'Invoice'));
    }
}
