<?php

namespace App\Http\Controllers\Salaries;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\SalaryAdvance;
use App\Models\Employee;
use App\Models\Treasury;
use App\Models\TreasuryEmployee;
use App\Models\Account;
use App\Models\JournalEntry;
use App\Models\JournalEntryDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\InstallmentPayment;
class AncestorController extends Controller
{
    public function index(Request $request)
    {
        $query = SalaryAdvance::query()->with(['employee', 'treasury']);

        // البحث حسب السلفة (رقم السلفة أو المبلغ)
        if ($request->filled('advance_search')) {
            $query->where(function ($q) use ($request) {
                $q->where('id', 'LIKE', "%{$request->advance_search}%")->orWhere('amount', 'LIKE', "%{$request->advance_search}%");
            });
        }

        // البحث حسب فترة القسط
        if ($request->filled('payment_rate')) {
            $query->where('payment_rate', $request->payment_rate);
        }

        // البحث حسب الموظف
        if ($request->filled('employee_search')) {
            $query->whereHas('employee', function ($q) use ($request) {
                $q->where('first_name', 'LIKE', "%{$request->employee_search}%");
            });
        }

        // البحث حسب تاريخ الدفعة القادمة (من)
        if ($request->filled('next_payment_from')) {
            $query->where('installment_start_date', '>=', $request->next_payment_from);
        }

        // البحث حسب تاريخ الدفعة القادمة (إلى)
        if ($request->filled('next_payment_to')) {
            $query->where('installment_start_date', '<=', $request->next_payment_to);
        }

        // البحث حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // البحث المتقدم - الفرع
        if ($request->filled('branch_id')) {
            $query->whereHas('employee', function ($q) use ($request) {
                $q->where('branch_id', $request->branch_id);
            });
        }

        // البحث المتقدم - الوسم
        if ($request->filled('tag')) {
            $query->where('tag', 'LIKE', "%{$request->tag}%");
        }

        $ancestors = $query->latest()->paginate(10);

        // تحضير البيانات للقوائم المنسدلة
        $paymentRates = [
            1 => 'شهري',
            2 => 'اسبوعي',
            3 => 'يومي',
        ];

        $statuses = [
            'active' => 'نشط',
            'completed' => 'مكتمل',
            'cancelled' => 'ملغي',
        ];

        // احضار الفروع والوسوم المتاحة
        $branches = Branch::all();
        $employees = Employee::all();
        $tags = SalaryAdvance::distinct('tag')->whereNotNull('tag')->pluck('tag');

        return view('salaries.ancestor.index', compact('ancestors', 'paymentRates', 'statuses', 'branches', 'tags', 'employees'));
    }

    public function create()
    {
        $employees = Employee::all();
        $treasuries = Treasury::all();
        return view('salaries.ancestor.create', compact('employees', 'treasuries'));
    }
    
// public function storePayments(Request $request, $id)
// {
//     $validated = $request->validate([
//         'payments' => 'required|array|min:1',
//         'payments.*.installment_number' => 'required|integer',
//         'payments.*.amount' => 'required|numeric|min:0.01',
//         'payments.*.payment_date' => 'required|date',
//         'account_id' => 'required|exists:accounts,id'
//     ]);
    
//     DB::beginTransaction();
    
//     try {
//         $salaryAdvance = SalaryAdvance::findOrFail($id);
        
//         foreach ($request->payments as $payment) {
//             $salaryAdvance->payments()->create([
//                 'installment_number' => $payment['installment_number'],
//                 'amount' => $payment['amount'],
//                 'payment_date' => $payment['payment_date'],
//                 'account_id' => $request->account_id,
//                 'status' => 'paid',
//                 'created_by' => auth()->id()
//             ]);
//         }
        
//         DB::commit();
        
//         return redirect()->back()->with('success', 'تم حفظ المدفوعات بنجاح');
        
//     } catch (\Exception $e) {
//         DB::rollBack();
//         return redirect()->back()->with('error', 'حدث خطأ: ' . $e->getMessage());
//     }
// }



protected function calculateInstallments($salaryAdvance)
{
    $installments = [];
    $installmentAmount = $salaryAdvance->installment_amount;
    $totalInstallments = $salaryAdvance->total_installments;
    $startDate = Carbon::parse($salaryAdvance->installment_start_date);
    
    for ($i = 1; $i <= $totalInstallments; $i++) {
        $dueDate = clone $startDate;
        
        switch ($salaryAdvance->payment_rate) {
            case 1: $dueDate->addMonths($i - 1); break; // شهري
            case 2: $dueDate->addWeeks($i - 1); break;  // أسبوعي
            case 3: $dueDate->addMonths(($i - 1) * 3); break; // ربع سنوي
        }
        
        $installments[] = [
            'number' => $i,
            'amount' => $installmentAmount,
            'due_date' => $dueDate->format('Y-m-d')
        ];
    }
    
    return $installments;
}



//
public function pay($id)
{
    $salaryAdvance = SalaryAdvance::with(['payments'])->findOrFail($id);
    $accounts = Account::where('is_active', true)->get();
    
    // حساب الأقساط الغير مدفوعة فقط
    $unpaidInstallments = $this->getUnpaidInstallments($salaryAdvance);
    
    return view('salaries.ancestor.pay', compact('salaryAdvance', 'accounts', 'unpaidInstallments'));
}

protected function getUnpaidInstallments($salaryAdvance)
{
    // الأقساط المدفوعة (من جدول installment_payments)
    $paidInstallments = $salaryAdvance->payments->pluck('installment_number')->toArray();
    
    // جميع الأقساط المفترضة
    $allInstallments = $this->calculateInstallments($salaryAdvance);
    
    // تصفية الأقساط الغير مدفوعة
    return array_filter($allInstallments, function($installment) use ($paidInstallments) {
        return !in_array($installment['number'], $paidInstallments);
    });
}

public function storePayments(Request $request, $id)
{
    
    // dd($request->all());
    // $validated = $request->validate([
    //     'amount' => 'required|numeric|min:0.01',
    //     'payment_date' => 'required|date',
    //     'account_id' => 'required|exists:accounts,id',
    //     'installment_number' => 'required|integer'
    // ]);

    DB::beginTransaction();
    
    try {
       $salaryAdvance = SalaryAdvance::findOrFail($id);

// تسجيل الدفعة في جدول installment_payments
$payment = InstallmentPayment::create([
    'salary_advance_id' => $salaryAdvance->id,
    'installment_number' => $request->installment_number,
    'amount' => $request->amount,
    'payment_date' => $request->payment_date,
    'account_id' => $request->account_id,
    'status' => 'paid',
    'created_by' => auth()->id()
]);

// لا داعي لاستدعاء $payment->save(); لأن create() يقوم بالحفظ تلقائيًا

        
        DB::commit();
        
        return redirect()->back()->with('success', 'تم حفظ الدفعة بنجاح');
        
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'فشل في حفظ الدفعة: ' . $e->getMessage());
    }
}

protected function updateAdvanceStatus($salaryAdvance)
{
    $totalPaid = $salaryAdvance->payments()->sum('amount');
    $totalAmount = $salaryAdvance->total_amount;
    
    if ($totalPaid >= $totalAmount) {
        $salaryAdvance->update(['status' => 'paid']);
    }
}
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // التحقق من البيانات
            $validated = $request->validate(
                [
                    'employee_id' => 'required',
                    'submission_date' => 'required|date',
                    'amount' => 'required|numeric|min:0.01',
                    'installment_amount' => 'required|numeric|min:0.01|lte:amount',
                    'currency' => 'required|integer',
                    'payment_rate' => 'required|in:monthly,weekly,daily',
                    'installment_start_date' => 'required|date',
                    'treasury_id' => 'required|integer',
                    'tag' => 'nullable|string',
                    'note' => 'nullable|string',
                ],
                [
                    'employee_id.required' => 'يرجى اختيار الموظف',
                    'submission_date.required' => 'يرجى تحديد تاريخ التقديم',
                    'amount.required' => 'يرجى إدخال مبلغ السلفة',
                    'amount.numeric' => 'مبلغ السلفة يجب أن يكون رقماً',
                    'amount.min' => 'مبلغ السلفة يجب أن يكون أكبر من صفر',
                    'installment_amount.required' => 'يرجى إدخال مبلغ القسط',
                    'installment_amount.numeric' => 'مبلغ القسط يجب أن يكون رقماً',
                    'installment_amount.min' => 'مبلغ القسط يجب أن يكون أكبر من صفر',
                    'installment_amount.lte' => 'قيمة القسط يجب أن تكون أقل من أو تساوي قيمة السلفة',
                    'payment_rate.required' => 'يرجى اختيار معدل الدفع',
                    'payment_rate.in' => 'معدل الدفع المحدد غير صالح',
                ],
            );

            // تحضير البيانات
            $data = $request->all();

            // حساب عدد الأقساط الكلي
            $amount = (float) $request->amount;
            $installmentAmount = (float) $request->installment_amount;

            if ($installmentAmount > 0) {
                $totalInstallments = ceil($amount / $installmentAmount);

                // حساب الأقساط المدفوعة (مثال: افتراض أن المدفوع = 0 عند الإنشاء)
                $paidInstallments = 0; // يمكنك تغيير هذه القاعدة حسب احتياجاتك

                // حساب المبلغ المدفوع
                $paidAmount = $paidInstallments * $installmentAmount;
            } else {
                $totalInstallments = 0;
                $paidInstallments = 0;
                $paidAmount = 0.0;
            }

            // تخزين القيم المحسوبة
            $data['total_installments'] = $totalInstallments;
            $data['paid_installments'] = $paidInstallments;
            $data['paid_amount'] = $paidAmount;
            $data['pay_from_salary'] = $request->has('pay_from_salary') ? 1 : 0;

            // تحويل payment_rate إلى رقم
            $paymentRateMap = [
                'monthly' => 1,
                'weekly' => 2,
                'daily' => 3,
            ];
            $data['payment_rate'] = $paymentRateMap[$data['payment_rate']] ?? 1;

            // تنسيق التواريخ
            $data['submission_date'] = date('Y-m-d', strtotime($data['submission_date']));
            $data['installment_start_date'] = date('Y-m-d', strtotime($data['installment_start_date']));

        $MainTreasury = null;
        $user = Auth::user();
            // إنشاء السلفة
            $advance = SalaryAdvance::create($data);
            if ($user && $user->employee_id) {
            // البحث عن الخزينة المرتبطة بالموظف
            $TreasuryEmployee = TreasuryEmployee::where('employee_id', $user->employee_id)->first();

            if ($TreasuryEmployee && $TreasuryEmployee->treasury_id) {
                // إذا كان الموظف لديه خزينة مرتبطة
                $MainTreasury = Account::where('id', $TreasuryEmployee->treasury_id)->first();
            } else {
                // إذا لم يكن لدى الموظف خزينة مرتبطة، استخدم الخزينة الرئيسية
                $MainTreasury = Account::where('name', 'الخزينة الرئيسية')->first();
            }
        } else {
            // إذا لم يكن المستخدم موجودًا أو لم يكن لديه employee_id، استخدم الخزينة الرئيسية
            $MainTreasury = Account::where('name', 'الخزينة الرئيسية')->first();
        }

        // إذا لم يتم العثور على خزينة، توقف العملية وأظهر خطأ
        if (!$MainTreasury) {
            throw new \Exception('لا توجد خزينة متاحة. يرجى التحقق من إعدادات الخزينة.');
        }
           $salaryadvanc = Account::where('name', 'السلف')->first();
            if (!$salaryadvanc) {
            throw new \Exception('لا يوجد حساب سلف يرجى التحقق من شجرة الحسابات   .');
        }
        // تحديث رصيد الخزينة
        $MainTreasury->balance -= $advance->amount;
        $MainTreasury->save();
        
        $salaryadvanc->balance += $advance->amount;
        $salaryadvanc->save();

        // إنشاء قيد محاسبي لسند القبض
        $journalEntry = JournalEntry::create([
            'reference_number' => $advance->id,
            'date' => $advance->created_at,
            'description' => '  سلفية رقم ' . $advance->id,
            'status' => 1,
            'currency' => 'SAR',
            'employee_id' => $advance->employee_id, // استخدام client_id بدلاً من seller
            'created_by_employee' => Auth::id(),
        ]);

        // إضافة تفاصيل القيد المحاسبي لسند القبض
        // 1. حساب الخزينة المستهدفة (مدين)
        JournalEntryDetail::create([
            'journal_entry_id' => $journalEntry->id,
            'account_id' => $MainTreasury->id,
            'description' => '  سلفة من الخزينة  ',
            'debit' => 0,
            'credit' => $advance->amount,
            'is_debit' => true,
        ]);

        // 2. حساب الإيرادات (دائن)
        JournalEntryDetail::create([
            'journal_entry_id' => $journalEntry->id,
            'account_id' => $salaryadvanc->id, // استخدام account_id بدلاً من sup_account
            'description' => ' سلفة  ',
            'debit' => $advance->amount,
            'credit' => 0,
            'is_debit' => false,
        ]);

            DB::commit();
            return redirect()->route('ancestor.index')->with('success', 'تم إضافة السلفة بنجاح');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('خطأ في إضافة السلفة: ' . $e->getMessage());
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $ancestor = SalaryAdvance::with(['employee', 'treasury'])->findOrFail($id);
            return view('salaries.ancestor.show', compact('ancestor'));
        } catch (\Exception $e) {
            return redirect()->route('ancestor.index')->with('error', 'السلفة غير موجودة');
        }
    }

    public function edit($id)
    {
        try {
            $ancestor = SalaryAdvance::findOrFail($id);
            $employees = Employee::all();
            $treasuries = Treasury::all();

            return view('salaries.ancestor.edit', compact('ancestor', 'employees', 'treasuries'));
        } catch (\Exception $e) {
            return redirect()->route('ancestor.index')->with('error', 'السلفة غير موجودة');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $ancestor = SalaryAdvance::findOrFail($id);

            // التحقق من البيانات
            $request->validate([
                'employee_id' => 'nullable|exists:employees,id',
                'submission_date' => 'nullable|date',
                'amount' => 'nullable|numeric|min:0.01',
                'installment_amount' => 'nullable|numeric|min:0.01',
                'currency' => 'nullable|integer',
                'payment_rate' => 'nullable|in:monthly,weekly,daily',
                'installment_start_date' => 'nullable|date',
                'treasury_id' => 'nullable|integer',
                'tag' => 'nullable|string',
                'note' => 'nullable|string',
            ]);

            // نجمع البيانات المرسلة في الطلب
            $data = [];

            // معالجة الحقول الأساسية
            $fields = ['employee_id', 'currency', 'treasury_id', 'tag', 'note'];
            foreach ($fields as $field) {
                if ($request->filled($field)) {
                    $data[$field] = $request->input($field);
                }
            }

            // معالجة التواريخ
            if ($request->filled('submission_date')) {
                $data['submission_date'] = date('Y-m-d', strtotime($request->submission_date));
            }
            if ($request->filled('installment_start_date')) {
                $data['installment_start_date'] = date('Y-m-d', strtotime($request->installment_start_date));
            }

            // معالجة المبلغ والأقساط
            if ($request->filled('amount')) {
                $data['amount'] = $request->amount;
            }
            if ($request->filled('installment_amount')) {
                if ($request->installment_amount > ($data['amount'] ?? $ancestor->amount)) {
                    return back()
                        ->withInput()
                        ->withErrors(['installment_amount' => 'مبلغ القسط يجب أن يكون أقل من أو يساوي المبلغ الإجمالي']);
                }
                $data['installment_amount'] = $request->installment_amount;
            }

            // حساب عدد الأقساط إذا تم تحديث المبلغ أو قيمة القسط
            if (isset($data['amount']) || isset($data['installment_amount'])) {
                $amount = $data['amount'] ?? $ancestor->amount;
                $installmentAmount = $data['installment_amount'] ?? $ancestor->installment_amount;

                if ($installmentAmount > 0) {
                    $data['total_installments'] = ceil($amount / $installmentAmount);
                }
            }

            // معالجة payment_rate
            if ($request->filled('payment_rate')) {
                $paymentRateMap = [
                    'monthly' => 1,
                    'weekly' => 2,
                    'daily' => 3,
                ];
                $data['payment_rate'] = $paymentRateMap[$request->payment_rate] ?? 1;
            }

            // معالجة pay_from_salary
            $data['pay_from_salary'] = $request->has('pay_from_salary') ? 1 : 0;

            // تحديث فقط إذا كانت هناك بيانات للتحديث
            if (!empty($data)) {
                $ancestor->update($data);
                DB::commit();
                return redirect()->route('ancestor.index')->with('success', 'تم تحديث السلفة بنجاح');
            }

            return redirect()->route('ancestor.index')->with('info', 'لم يتم إجراء أي تغييرات');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating advance:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => 'حدث خطأ أثناء تحديث السلفة: ' . $e->getMessage()]);
        }
        }
    public function destroy($id)
    {
        try {
            $ancestor = SalaryAdvance::findOrFail($id);
            $ancestor->delete();

            return redirect()->route('ancestor.index')->with('success', 'تم حذف السلفة بنجاح');
        } catch (\Exception $e) {
            return redirect()->route('ancestor.index')->with('error', 'حدث خطأ أثناء حذف السلفة');
        }
    }

    public function copy($id)
    {
        try {
            $original = SalaryAdvance::findOrFail($id);
            $copy = $original->replicate();
            $copy->save();

            return redirect()->route('ancestor.index')->with('success', 'تم نسخ السلفة بنجاح');
        } catch (\Exception $e) {
            return redirect()->route('ancestor.index')->with('error', 'حدث خطأ أثناء نسخ السلفة');
        }
    }
}
