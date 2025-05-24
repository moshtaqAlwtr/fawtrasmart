<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Employee;
use App\Models\Treasury;
use App\Models\Log as ModelsLog;
use App\Models\TreasuryEmployee;
use Illuminate\Http\Request;

class TreasuryEmployeeController extends Controller
{
    public function index()
    {
        $treasury_employees = TreasuryEmployee::orderBy('id', 'DESC')->paginate(10);
        $employees = Employee::select('id', 'first_name', 'middle_name', 'nickname')->get();
        // $treasuries = Treasury::select('id','name')->get();
        $treasuries = Account::whereIn('parent_id', [13, 15])
            ->orderBy('id', 'DESC')
            ->paginate(10);
        return view('finance.treasury_employee.index', compact('treasury_employees', 'treasuries', 'employees'));
    }
    public function create()
    {
        $employees = Employee::select('id', 'first_name', 'middle_name', 'nickname')->get();
        $treasuries = Account::whereIn('parent_id', [13, 15])
            ->orderBy('id', 'DESC')
            ->paginate(10);
        return view('finance.treasury_employee.create', compact('treasuries', 'employees'));
    }

    public function store(Request $request)
    {
        // إنشاء سجل جديد في TreasuryEmployee
        $default = TreasuryEmployee::create([
            'treasury_id' => $request->treasury_id,
            'employee_id' => $request->employee_id,
        ]);

        // تسجيل النشاط في ModelsLog
        ModelsLog::create([
            'type' => 'product_log',
            'type_id' => $default->id, // استخدام $default بدلاً من $default_warehouse
            'type_log' => 'log', // نوع النشاط
            'description' => sprintf(
                'تم تعيين الخزينة **%s** كخزينة افتراضية للموظف **%s %s %s**',
                $default->treasury->name, // اسم الخزينة
                $default->employee->first_name, // الاسم الأول للموظف
                $default->employee->middle_name, // الاسم الأوسط للموظف
                $default->employee->nickname // اللقب
            ),
            'created_by' => auth()->id(), // ID المستخدم الحالي
        ]);

        // إعادة التوجيه مع رسالة نجاح
        return redirect()
            ->route('finance_settings.treasury_employee')
            ->with(['success' => 'تم إضافة خزينة الموظف بنجاح !!']);
    }

    public function edit($id)
    {
        $treasury_employee = TreasuryEmployee::findOrFail($id);
        $employees = Employee::select('id', 'first_name', 'middle_name')->get();
        $treasuries = Account::whereIn('parent_id', [13, 15])
            ->orderBy('id', 'DESC')
            ->paginate(10);
        return view('finance.treasury_employee.edit', compact('treasury_employee', 'treasuries', 'employees'));
    }

    public function update(Request $request, $id)
{
    // الحصول على السجل الحالي مع العلاقات
    $default = TreasuryEmployee::with('employee', 'treasury')->findOrFail($id);

    // حفظ القيم القديمة قبل التحديث
    $oldTreasury = $default->treasury;
    $oldEmployee = $default->employee;

    // تحديث السجل
    $default->update([
        'treasury_id' => $request->treasury_id,
        'employee_id' => $request->employee_id,
    ]);

    // تحميل السجل المحدث مع العلاقات
    $default->refresh()->load('employee', 'treasury');

    // تحميل الخزينة الجديد والموظف الجديد من العلاقات
    $newTreasury = $default->treasury;
    $newEmployee = $default->employee;

    // بناء النص بناءً على التغييرات
    $description = '';

    if ($oldTreasury->id != $request->treasury_id && $oldEmployee->id != $request->employee_id) {
        // تم تغيير الخزينة والموظف
        $description = sprintf(
            'تم تغيير الخزينة الافتراضية والموظف من **%s** (الموظف: **%s %s %s**) إلى **%s** (الموظف: **%s %s %s**)',
            $oldTreasury->name,
            $oldEmployee->first_name,
            $oldEmployee->middle_name,
            $oldEmployee->nickname,
            $newTreasury->name,
            $newEmployee->first_name,
            $newEmployee->middle_name,
            $newEmployee->nickname
        );
    } elseif ($oldTreasury->id != $request->treasury_id) {
        // تم تغيير الخزينة فقط
        $description = sprintf(
            'تم تغيير الخزينة الافتراضية من **%s** إلى **%s** للموظف **%s %s %s**',
            $oldTreasury->name,
            $newTreasury->name,
            $newEmployee->first_name,
            $newEmployee->middle_name,
            $newEmployee->nickname
        );
    } elseif ($oldEmployee->id != $request->employee_id) {
        // تم تغيير الموظف فقط
        $description = sprintf(
            'تم تغيير الموظف للخزينة الافتراضية **%s** من **%s %s %s** إلى **%s %s %s**',
            $newTreasury->name,
            $oldEmployee->first_name,
            $oldEmployee->middle_name,
            $oldEmployee->nickname,
            $newEmployee->first_name,
            $newEmployee->middle_name,
            $newEmployee->nickname
        );
    } else {
        // لم يتم تغيير شيء
        $description = 'لم يتم تغيير أي شيء.';
    }

    // تسجيل اشعار نظام جديد باستخدام ModelsLog مثل دالة store
    ModelsLog::create([
        'type' => 'product_log',
        'type_id' => $default->id,
        'type_log' => 'log',
        'description' => $description,
        'created_by' => auth()->id(),
    ]);

    return redirect()
        ->route('finance_settings.treasury_employee')
        ->with(['success' => 'تم تحديث خزينة الموظف بنجاح !!']);
}

    public function delete($id)
    {
        TreasuryEmployee::findOrFail($id)->delete();
        return redirect()
            ->route('finance_settings.treasury_employee')
            ->with(['error' => 'تم حذف خزينة الموظف بنجاج !!']);
    }
}
