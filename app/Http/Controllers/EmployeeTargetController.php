<?php

namespace App\Http\Controllers;

use App\Models\CreditLimit;
use App\Models\Employee;
use App\Models\EmployeeGroup;
use App\Models\User;
use App\Models\Target;
use App\Models\EmployeeTarget;
use App\Models\Location;
use App\Models\Client;
use App\Models\Neighborhood;
use App\Models\Region_groub;
use App\Models\Statuses;
use Illuminate\Http\Request;
use App\Models\PaymentsProcess;
use App\Models\Invoice;
use App\Models\Receipt;
use Carbon\Carbon;



class EmployeeTargetController extends Controller
{
    public function index()
    {
        $employees = User::where('role', 'employee')->get(); // يمكنك تخصيصهم حسب النوع إذا أردت
        return view('employee_targets.index', compact('employees'));
    }
    public function showGeneralTarget()
    {
        // جلب الهدف الأول أو إنشائه إذا لم يكن موجوداً
        $target = Target::firstOrCreate(
            ['id' => 1],
            ['value' => 30000]
        );

        return view('employee_targets.general', compact('target'));
    }

    public function client_target_create()
    {
        // جلب الهدف الأول أو إنشائه إذا لم يكن موجوداً
        $target = Target::firstOrCreate(
            ['id' => 2],
            ['value' => 648]
        );

        return view('client_target.index', compact('target'));
    }
    public function client_target_store(Request $request)
    {
        $request->validate([
            'value' => 'required|numeric',

        ]);

        $target = Target::updateOrCreate(
            ['id' => 2],
            $request->only(['value'])
        );

        return redirect()->back()->with('success', 'تم تحديث الهدف بنجاح');
    }
    public function client_target(Request $request)
    {
        $user = auth()->user();

        $baseQuery = Client::with([
            'employee',
            'status:id,name,color',
            'locations',
            'Neighborhoodname.Region',
            'branch:id,name'
        ]);

        $noClients = false;

        // تحديد الصلاحيات حسب الدور
        if ($user->role === 'employee') {
            // الموظف يرى فقط العملاء المرتبطين بالمجموعات الخاصة به
            $employeeGroupIds = EmployeeGroup::where('employee_id', $user->employee_id)
                ->pluck('group_id');

            if ($employeeGroupIds->isNotEmpty()) {
                $baseQuery->whereHas('Neighborhoodname.Region', function ($q) use ($employeeGroupIds) {
                    $q->whereIn('id', $employeeGroupIds);
                });
            } else {
                // لا توجد مجموعات → لا توجد عملاء
                $noClients = true;
            }
        } elseif ($user->role === 'manager') {
            // المدير يرى جميع العملاء → لا فلترة
        }

        // فلترة البحث حسب الطلب
        if ($request->filled('client')) {
            $baseQuery->where('id', $request->client);
        }

        if ($request->filled('name')) {
            $baseQuery->where('trade_name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('status')) {
            $baseQuery->where('status_id', $request->status);
        }

        if ($request->filled('region')) {
            $baseQuery->whereHas('Neighborhoodname.Region', function ($q) use ($request) {
                $q->where('id', $request->region);
            });
        }

        if ($request->filled('neighborhood')) {
            $baseQuery->whereHas('Neighborhoodname', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->neighborhood . '%')
                    ->orWhere('id', $request->neighborhood);
            });
        }

        // استعلام الخريطة
        $mapQuery = clone $baseQuery;
        $allClients = $noClients ? collect() : $mapQuery->with([
            'status_client:id,name,color',
            'locations:id,client_id,latitude,longitude',
            'Neighborhoodname.Region',
            'branch:id,name'
        ])->get();

        // موقع الموظف
        $userLocation = Location::where('employee_id', $user->employee_id)->latest()->first();

        // تنفيذ الاستعلام مع التقسيم



        $target = Target::find(2)->value ?? 648; // الهدف العام لتحصيل كل عميل

        // الحصول على الشهر (أو NULL في البداية لجلب كل الشهور)
        $month = $request->input('month');
        $year  = null;
        $monthNum = null;

        if ($month) {
            [$year, $monthNum] = explode('-', $month);
        }

        // جلب جميع العملاء
        //  $clientsRaw = $noClients ? collect() : $baseQuery->get();
        $clients = Client::with(['employee', 'Neighborhoodname.Region', 'branch', 'locations'])->get();
        $clients = $clients->map(function ($client) use ($target, $monthNum, $year) {
            // مجموع المدفوعات
          
                $returnedInvoiceIds = Invoice::whereNotNull('reference_number')
    ->pluck('reference_number')
    ->toArray();

// الفواتير الأصلية التي يجب استبعادها = كل فاتورة تم عمل راجع لها
// بالإضافة إلى الفواتير التي تم تصنيفها صراحةً على أنها راجعة
$excludedInvoiceIds = array_unique(array_merge(
    $returnedInvoiceIds,
    Invoice::where('type', 'returned')->pluck('id')->toArray()
));

            
            
            
            $invoiceIds = Invoice::where('client_id', $client->id)->where('type','normal')
                ->whereNotIn('id', $excludedInvoiceIds)
                ->pluck('id');

            $paymentsQuery = PaymentsProcess::whereIn('invoice_id', $invoiceIds);

            if ($monthNum && $year) {
                $paymentsQuery->whereMonth('created_at', $monthNum)
                    ->whereYear('created_at', $year);
            }

            $paymentsTotal = $paymentsQuery->sum('amount');

            // مجموع سندات القبض
            $receiptsTotal = Receipt::whereHas('account', function ($query) use ($client) {
                $query->where('client_id', $client->id);
            })
                ->when($monthNum && $year, function ($query) use ($monthNum, $year) {
                    $query->whereMonth('created_at', $monthNum)
                        ->whereYear('created_at', $year);
                })
                ->sum('amount');
                
                

            $collected = $paymentsTotal + $receiptsTotal;
            $percentage = $target > 0 ? round(($collected / $target) * 100, 2) : 0;

            // تحديد المجموعة
            if ($percentage < 30) {
                $group = 'C';
                $group_class = 'danger';
            } elseif ($percentage >= 30 && $percentage < 50) {
                $group = 'B';
                $group_class = 'warning';
            } else {
                $group = 'A';
                $group_class = 'success';
            }

            // إضافة الخصائص للعميل
            $client->collected = $collected;
            $client->percentage = $percentage;
            $client->payments = $paymentsTotal;
            $client->receipts = $receiptsTotal;
            $client->group = $group;
            $client->group_class = $group_class;


            return $client;
        })->sortByDesc('collected')->values(); // ✅ الترتيب من الأعلى للأقل





        // بيانات إضافية للعرض
        return view('employee_targets.client', [
            'clients' => $clients, // يحتوي بالفعل على جميع الخصائص المطلوبة
            'allClients' => $allClients,
            'month' => $month,
            'target' => $target,
            'Neighborhoods' => Neighborhood::all(),
            'users' => User::all(),
            'employees' => Employee::all(),
            'creditLimit' => CreditLimit::first(),
            'statuses' => Statuses::select('id', 'name', 'color')->get(),
            'Region_groups' => Region_groub::all(),
            'userLocation' => $userLocation
            // تم إزالة: 'percentage'، 'group'، 'group_class'، 'collected'
        ]);
    }
    public function updateGeneralTarget(Request $request)
    {
        $request->validate([
            'value' => 'required|numeric',

        ]);

        $target = Target::updateOrCreate(
            ['id' => 1],
            $request->only(['value'])
        );

        return redirect()->back()->with('success', 'تم تحديث الهدف بنجاح');
    }
    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'targets' => 'required|array',
            'targets.*.user_id' => 'required|exists:users,id',
            'targets.*.monthly_target' => 'nullable|numeric|min:0'
        ]);

        foreach ($request->targets as $targetData) {
            // تجاهل الحقول الفارغة
            if (!is_numeric($targetData['monthly_target'])) {
                continue;
            }

            EmployeeTarget::updateOrCreate(
                ['user_id' => $targetData['user_id']],
                ['monthly_target' => $targetData['monthly_target']]
            );
        }

        return redirect()->route('employee_targets.index')->with('success', 'تم تحديث التارقت بنجاح!');
    }
}
