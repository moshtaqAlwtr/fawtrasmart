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
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath','check.branch']
    ], function(){


        Route::get('', function () {
             $ClientCount = Client::count();
    $Invoice = Invoice::sum('grand_total');
    $Visit = Visit::count();

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
            return view('dashboard.sales.index',compact('ClientCount','Invoice','groups','Visit','chartData'));
        })->middleware(['auth']);

        Route::prefix('dashboard')->middleware(['auth'])->group(function () {

            #questions routes
            Route::prefix('sales')->group(function () {
                Route::get('/index',[DashboardSalesController::class,'index'])->name('dashboard_sales.index');
            });

        });

});


