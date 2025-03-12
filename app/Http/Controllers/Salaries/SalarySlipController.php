<?php

namespace App\Http\Controllers\Salaries;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Log as ModelsLog;
use App\Models\JopTitle;
use App\Models\SalaryAdvance;
use App\Models\SalaryItem;
use App\Models\SalarySlip;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SalarySlipController extends Controller
{
    public function index(Request $request)
    {
        $query = SalarySlip::query();

        // البحث حسب اسم الموظف
        if ($request->filled('employee_name')) {
            $searchTerm = $request->employee_name;
            $query->whereHas('employee', function ($q) use ($searchTerm) {
                $q->where('first_name', 'like', '%' . $searchTerm . '%')->orWhere('middle_name', 'like', '%' . $searchTerm . '%');
            });
        }

        // البحث حسب PayRun
        if ($request->filled('payrun')) {
            $query->where('id', 'like', '%' . $request->payrun . '%');
        }

        // البحث حسب القسم
        if ($request->filled('department')) {
            $query->whereHas('employee', function ($q) use ($request) {
                $q->where('department_id', $request->department);
            });
        }

        // البحث حسب العملة
        if ($request->filled('currency')) {
            $query->where('currency', $request->currency);
        }

        // البحث حسب الفترة
        if ($request->filled('period_from')) {
            $query->where('from_date', '>=', $request->period_from);
        }
        if ($request->filled('period_to')) {
            $query->where('to_date', '<=', $request->period_to);
        }

        // البحث حسب المسمى الوظيفي
        if ($request->filled('job_title')) {
            $query->whereHas('employee', function ($q) use ($request) {
                $q->where('job_title_id', $request->job_title);
            });
        }

        // البحث حسب تاريخ التسجيل
        if ($request->filled('registration_from')) {
            $query->whereDate('registration_date', '>=', $request->registration_from);
        }
        if ($request->filled('registration_to')) {
            $query->whereDate('registration_date', '<=', $request->registration_to);
        }

        // البحث حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // البحث حسب تاريخ الإنشاء
        if ($request->filled('created_from')) {
            $query->whereDate('created_at', '>=', $request->created_from);
        }
        if ($request->filled('created_to')) {
            $query->whereDate('created_at', '<=', $request->created_to);
        }

        // البحث حسب Overlap
        if ($request->filled('overlap_start')) {
            $query->where('overlap_start', '>=', $request->overlap_start);
        }
        if ($request->filled('overlap_end')) {
            $query->where('overlap_end', '<=', $request->overlap_end);
        }

        // البحث حسب الفرع
        if ($request->filled('branch')) {
            $query->whereHas('employee', function ($q) use ($request) {
                $q->where('branch_id', $request->branch);
            });
        }

        // تنفيذ الاستعلام وترتيب النتائج
        $salarySlip = $query->orderBy('created_at', 'desc')->get();

        // جلب البيانات للقوائم المنسدلة
        $departments = Department::all();
        $jobTitles = JopTitle::all();
        $branches = Branch::all();

        return view('salaries.salary_slip.index', compact('salarySlip', 'departments', 'jobTitles', 'branches'));
    }
    public function create()
    {
        $employees = Employee::all();

        $additionItems = SalaryItem::where('type', 1)->select('id', 'name', 'calculation_formula', 'amount')->get();
        $deductionItems = SalaryItem::where('type', 2)->select('id', 'name', 'calculation_formula', 'amount')->get();

        return view('salaries.salary_slip.create', compact('employees', 'additionItems', 'deductionItems'));
    }
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // إنشاء قسيمة الراتب
            $salarySlip = SalarySlip::create([
                'employee_id' => $request->employee_id,
                'slip_date' => $request->slip_date,
                'from_date' => $request->from_date,
                'to_date' => $request->to_date,
                'currency' => $request->currency,
                'total_salary' => 0,
                'total_deductions' => 0,
                'net_salary' => 0,
                'notes' => $request->note,
            ]);

            // معالجة المرفقات إذا وجدت
            if ($request->hasFile('attachments')) {
                $file = $request->file('attachments');
                if ($file->isValid()) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('assets/uploads/salarySlip'), $filename);
                    $salarySlip->attachments = $filename;
                }
            }

            $totalSalary = 0;
            $totalDeductions = 0;

            // جمع الراتب الأساسي مع المستحقات
            $basicAmount = $this->cleanNumber($request->basic_amount ?? 0);
            $additionAmount = 0;

            if (!empty($request->addition_amount)) {
                foreach ($request->addition_amount as $amount) {
                    if (!empty($amount)) {
                        $additionAmount += $this->cleanNumber($amount);
                    }
                }
            }

            // المجموع الكلي للمستحقات (الراتب الأساسي + المستحقات)
            $totalAdditions = $basicAmount + $additionAmount;
            $totalSalary = $totalAdditions;

            // تحديث البند الأول بالمجموع الكلي
            if (!empty($request->addition_type)) {
                $firstAdditionType = $request->addition_type[0];
                if (!empty($firstAdditionType)) {
                    SalaryItem::where('id', $firstAdditionType)->update([
                        'salary_slips_id' => $salarySlip->id,
                        'amount' => $totalAdditions,
                    ]);
                }
            }

            // معالجة المستقطعات
            if (!empty($request->deduction_type)) {
                foreach ($request->deduction_type as $key => $type) {
                    if (!empty($type) && !empty($request->deduction_amount[$key])) {
                        SalaryItem::where('id', $type)->update([
                            'salary_slips_id' => $salarySlip->id,
                            'amount' => $this->cleanNumber($request->deduction_amount[$key]),
                        ]);
                        $totalDeductions += $this->cleanNumber($request->deduction_amount[$key]);
                    }
                }
            }

            // تحديث المجاميع في قسيمة الراتب
            $salarySlip->update([
                'total_salary' => $totalSalary,
                'total_deductions' => $totalDeductions,
                'net_salary' => $totalSalary - $totalDeductions,
            ]);
            
                                     ModelsLog::create([
    'type' => 'salary_log',
    'type_id' => $payroll->id, // ID النشاط المرتبط
    'type_log' => 'log', // نوع النشاط
     'description' => 'تم  اضافة قسيمة رواتب',
    'created_by' => auth()->id(), // ID المستخدم الحالي
]);

            DB::commit();

            return redirect()->route('salarySlip.index')->with('success', 'تم إضافة قسيمة الراتب بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'حدث خطأ أثناء إضافة قسيمة الراتب: ' . $e->getMessage());
        }
    }
    public function edit($id)
    {
        $salarySlip = SalarySlip::findOrFail($id);

        $employees = Employee::all();
        $additionItems = SalaryItem::where('type', 1)->select('id', 'name', 'calculation_formula', 'amount')->get();
        $deductionItems = SalaryItem::where('type', 2)->select('id', 'name', 'calculation_formula', 'amount')->get();
        return view('salaries.salary_slip.edit', compact('employees', 'additionItems', 'deductionItems', 'salarySlip'));
    }
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $salarySlip = SalarySlip::findOrFail($id);

            // تحديث البيانات الأساسية
            $updateData = [
                'employee_id' => $request->employee_id ?? $salarySlip->employee_id,
                'slip_date' => $request->slip_date ?? $salarySlip->slip_date,
                'from_date' => $request->from_date ?? $salarySlip->from_date,
                'to_date' => $request->to_date ?? $salarySlip->to_date,
                'currency' => $request->currency ?? $salarySlip->currency,
                'notes' => $request->note ?? $salarySlip->notes,
            ];

            // تحديث البيانات الأساسية
            $salarySlip->update($updateData);

            // معالجة المرفقات إذا وجدت
            if ($request->hasFile('attachments')) {
                $file = $request->file('attachments');
                if ($file->isValid()) {
                    // حذف الملف القديم إذا وجد
                    if ($salarySlip->attachments) {
                        $oldFile = public_path('uploads/salarySlip/') . $salarySlip->attachments;
                        if (file_exists($oldFile)) {
                            unlink($oldFile);
                        }
                    }

                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('uploads/salarySlip'), $filename);
                    $salarySlip->update(['attachments' => $filename]);
                }
            }

            // معالجة المستحقات والمستقطعات
            $totalSalary = $salarySlip->total_salary;
            $totalDeductions = $salarySlip->total_deductions;

            if ($request->has('addition_type') || $request->has('addition_amount')) {
                // إعادة تعيين المستحقات
                SalaryItem::where('salary_slips_id', $id)
                    ->where('type', 1)
                    ->update(['salary_slips_id' => null]);

                $basicAmount = $this->cleanNumber($request->basic_amount ?? 0);
                $additionAmount = 0;

                if (!empty($request->addition_amount)) {
                    foreach ($request->addition_amount as $amount) {
                        if (!empty($amount)) {
                            $additionAmount += $this->cleanNumber($amount);
                        }
                    }
                }

                $totalSalary = $basicAmount + $additionAmount;

                // تحديث البند الأول للمستحقات إذا وجد
                if (!empty($request->addition_type[0])) {
                    SalaryItem::where('id', $request->addition_type[0])->update([
                        'salary_slips_id' => $salarySlip->id,
                        'amount' => $totalSalary,
                    ]);
                }
            }

            if ($request->has('deduction_type') || $request->has('deduction_amount')) {
                // إعادة تعيين المستقطعات
                SalaryItem::where('salary_slips_id', $id)
                    ->where('type', 2)
                    ->update(['salary_slips_id' => null]);

                $totalDeductions = 0;

                if (!empty($request->deduction_type)) {
                    foreach ($request->deduction_type as $key => $type) {
                        if (!empty($type) && !empty($request->deduction_amount[$key])) {
                            $amount = $this->cleanNumber($request->deduction_amount[$key]);
                            SalaryItem::where('id', $type)->update([
                                'salary_slips_id' => $salarySlip->id,
                                'amount' => $amount,
                            ]);
                            $totalDeductions += $amount;
                        }
                    }
                }
            }

            // تحديث المجاميع إذا تغيرت
            if ($totalSalary != $salarySlip->total_salary || $totalDeductions != $salarySlip->total_deductions) {
                $salarySlip->update([
                    'total_salary' => $totalSalary,
                    'total_deductions' => $totalDeductions,
                    'net_salary' => $totalSalary - $totalDeductions,
                ]);
            }

            DB::commit();

            return redirect()->route('salarySlip.index')->with('success', 'تم تحديث قسيمة الراتب بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'حدث خطأ أثناء تحديث قسيمة الراتب: ' . $e->getMessage());
        }
    }
    private function cleanNumber($number)
    {
        if (empty($number)) {
            return 0;
        }
        return floatval(str_replace(',', '', $number));
    }

    // دالة مساعدة لتنظيف الأرقام من الفواصل وتحويلها لصيغة قابلة للتخزين

    // دالة للحصول على اسم البند من الجدول الرئيسي
    private function getItemName($id)
    {
        // يمكنك استبدال هذا بالمنطق المناسب للحصول على اسم البند
        $item = DB::table('salary_template_items')->find($id);
        return $item ? $item->name : '';
    }

    public function show($id)
    {
        $salarySlip = SalarySlip::findOrFail($id);

        $additionItems = SalaryItem::where('type', 1)->select('id', 'name', 'calculation_formula', 'amount')->get();
        $deductionItems = SalaryItem::where('type', 2)->select('id', 'name', 'calculation_formula', 'amount')->get();
        return view('salaries.salary_slip.show', compact('salarySlip', 'additionItems', 'deductionItems'));
    }
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            // البحث عن قسيمة الراتب
            $salarySlip = SalarySlip::findOrFail($id);

            // حذف المرفق إذا وجد
            if ($salarySlip->attachments) {
                $filePath = storage_path('app/public/' . $salarySlip->attachments);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            // إعادة تعيين salary_slips_id إلى null في جدول البنود
            SalaryItem::where('salary_slips_id', $id)->update(['salary_slips_id' => null]);

            // حذف قسيمة الراتب
            $salarySlip->delete();

            DB::commit();

            return redirect()->route('salarySlip.index')->with('success', 'تم حذف قسيمة الراتب بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->back()
                ->with('error', 'حدث خطأ أثناء حذف قسيمة الراتب: ' . $e->getMessage());
        }
    }
    public function printPayslip1($id)
    {
        $salarySlip = SalarySlip::findOrFail($id);
        $additionItems = SalaryItem::where('type', 1)
            ->where('salary_slips_id', $id)
            ->select('id', 'name', 'calculation_formula', 'amount')
            ->get();
        $deductionItems = SalaryItem::where('type', 2)
            ->where('salary_slips_id', $id)
            ->select('id', 'name', 'calculation_formula', 'amount')
            ->get();

        return view('salaries.salary_slip.payslip.payslip1', compact('salarySlip', 'additionItems', 'deductionItems'));
    }
    public function printPayslip2($id)
    {
        $salarySlip = SalarySlip::findOrFail($id);
        $additionItems = SalaryItem::where('type', 1)
            ->where('salary_slips_id', $id)
            ->select('id', 'name', 'calculation_formula', 'amount')
            ->get();
        $deductionItems = SalaryItem::where('type', 2)
            ->where('salary_slips_id', $id)
            ->select('id', 'name', 'calculation_formula', 'amount')
            ->get();

        return view('salaries.salary_slip.payslip.payslip2', compact('salarySlip', 'additionItems', 'deductionItems'));
    }
    public function printPayslip3($id)
    {
        $salarySlip = SalarySlip::findOrFail($id);
        $additionItems = SalaryItem::where('type', 1)
            ->where('salary_slips_id', $id)
            ->select('id', 'name', 'calculation_formula', 'amount')
            ->get();
        $deductionItems = SalaryItem::where('type', 2)
            ->where('salary_slips_id', $id)
            ->select('id', 'name', 'calculation_formula', 'amount')
            ->get();

        return view('salaries.salary_slip.payslip.payslip3', compact('salarySlip', 'additionItems', 'deductionItems'));
    }
    public function printPayslipAr1($id)
    {
        $salarySlip = SalarySlip::findOrFail($id);
        $additionItems = SalaryItem::where('type', 1)
            ->where('salary_slips_id', $id)
            ->select('id', 'name', 'calculation_formula', 'amount')
            ->get();
        $deductionItems = SalaryItem::where('type', 2)
            ->where('salary_slips_id', $id)
            ->select('id', 'name', 'calculation_formula', 'amount')
            ->get();

        return view('salaries.salary_slip.payslip.payslipAr1', compact('salarySlip', 'additionItems', 'deductionItems'));
    }
    public function printPayslipAr2($id)
    {
        $salarySlip = SalarySlip::findOrFail($id);
        $additionItems = SalaryItem::where('type', 1)
            ->where('salary_slips_id', $id)
            ->select('id', 'name', 'calculation_formula', 'amount')
            ->get();
        $deductionItems = SalaryItem::where('type', 2)
            ->where('salary_slips_id', $id)
            ->select('id', 'name', 'calculation_formula', 'amount')
            ->get();

        return view('salaries.salary_slip.payslip.payslipAr2', compact('salarySlip', 'additionItems', 'deductionItems'));
    }
    public function printPayslipAr3($id)
    {
        $salarySlip = SalarySlip::findOrFail($id);
        $additionItems = SalaryItem::where('type', 1)
            ->where('salary_slips_id', $id)
            ->select('id', 'name', 'calculation_formula', 'amount')
            ->get();
        $deductionItems = SalaryItem::where('type', 2)
            ->where('salary_slips_id', $id)
            ->select('id', 'name', 'calculation_formula', 'amount')
            ->get();

        return view('salaries.salary_slip.payslip.payslipAr1', compact('salarySlip', 'additionItems', 'deductionItems'));
    }

}
