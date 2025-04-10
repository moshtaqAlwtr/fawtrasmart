<?php

use App\Http\Controllers\Dashboard\DashboardSalesController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Neighborhood;
use App\Models\Visit;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require __DIR__ . '/auth.php';

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'check.branch']
    ],
    function () {

        Route::get('', function () {
            $ClientCount = Client::count();
            $Invoice = Invoice::sum('grand_total');
            $Visit = Visit::count();

            // زيارات اليوم
            $today = Carbon::today();
            $TodayVisits = Visit::with(['employee', 'client'])
                ->whereDate('visit_date', $today)
                ->get()
                ->map(function ($visit) {
                    return [
                        'client_name' => $visit->client->name ?? '---',
                        'employee_name' => $visit->employee->name ?? '---',
                        'arrival_time' => $visit->arrival_time ? $visit->arrival_time->format('H:i') : '--',
                        'departure_time' => $visit->departure_time ? $visit->departure_time->format('H:i') : '--',
                        'visit_date' => $visit->visit_date,
                    ];
                });

            // حساب مبيعات الأحياء مع الأقاليم
            $groups = Neighborhood::with('Region')
                ->leftJoin('invoices', 'neighborhoods.client_id', '=', 'invoices.client_id')
                ->select('region_id', DB::raw('COALESCE(SUM(invoices.grand_total), 0) as total_sales'))
                ->groupBy('region_id')
                ->get();

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

$totalSales    = $groups->sum('total_sales');
$totalPayments = $payments->sum('total_payments');
$totalReceipts = $receipts->sum('total_receipts');
            return view('dashboard.sales.index', compact('ClientCount','groupChartData','totalReceipts','totalSales','totalPayments','receipts', 'Invoice', 'groups', 'Visit', 'chartData', 'TodayVisits'));
        })->middleware(['auth']);

        Route::prefix('dashboard')->middleware(['auth'])->group(function () {
            #questions routes
            Route::prefix('sales')->group(function () {
                Route::get('/index', [DashboardSalesController::class, 'index'])->name('dashboard_sales.index');
            });
        });
    }
);
