<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpenseRequest;
use App\Models\Account;
use App\Models\Expense;
use App\Models\Log as ModelsLog;
use App\Models\ExpensesCategory;
use App\Models\JournalEntry;
use App\Models\JournalEntryDetail;
use App\Models\Supplier;
use App\Models\Treasury;
use App\Models\TaxSitting;
use App\Models\AccountSetting;
use App\Models\TreasuryEmployee;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExpensesController extends Controller
{
    public function index(Request $request)
{
    // استرداد التصنيفات من قاعدة البيانات
    $categories = ExpensesCategory::all();

    // إنشاء الاستعلام الأساسي مع الترتيب
    $query = Expense::orderBy('id', 'DESC')
        ->when($request->keywords, function ($query, $keywords) {
            return $query->where('code', 'like', '%' . $keywords . '%')
                         ->orWhere('description', 'like', '%' . $keywords . '%');
        })
        ->when($request->from_date, function ($query, $from_date) {
            return $query->where('date', '>=', $from_date);
        })->when($request->added_by, function ($query, $added_by) {
    return $query->where('created_by', $added_by); // أو employee_id إذا كانت هي الحقل الصحيح
})
        ->when($request->to_date, function ($query, $to_date) {
            return $query->where('date', '<=', $to_date);
        })
        ->when($request->category, function ($query, $category) {
            return $query->where('expenses_category_id', $category);
        })
        ->when($request->status, function ($query, $status) {
            return $query->where('status', $status);
        })
        ->when($request->description, function ($query, $description) {
            return $query->where('description', 'like', '%' . $description . '%');
        })
        ->when($request->vendor, function ($query, $vendor) {
            return $query->where('supplier_id', $vendor);
        })
        ->when($request->amount_from, function ($query, $amount_from) {
            return $query->where('amount', '>=', $amount_from);
        })
        ->when($request->amount_to, function ($query, $amount_to) {
            return $query->where('amount', '<=', $amount_to);
        })
        ->when($request->created_at_from, function ($query, $created_at_from) {
            return $query->where('created_at', '>=', $created_at_from);
        })
        ->when($request->created_at_to, function ($query, $created_at_to) {
            return $query->where('created_at', '<=', $created_at_to);
        })
        ->when($request->sub_account, function ($query, $sub_account) {
            return $query->where('account_id', $sub_account);
        })
        ->when($request->added_by, function ($query, $added_by) {
            return $query->where('created_by', $added_by);
        });

    // إذا كان المستخدم موظفاً، نضيف شرطاً لرؤية سنداته فقط
    if (auth()->user()->role == 'employee') {
        $query->where('created_by', auth()->id());
    }

    $expenses = $query->paginate(10);

    // حساب إجمالي المصروفات لفترات مختلفة مع مراعاة دور المستخدم
    $totalLast7DaysQuery = Expense::where('date', '>=', now()->subDays(7));
    $totalLast30DaysQuery = Expense::where('date', '>=', now()->subDays(30));
    $totalLast365DaysQuery = Expense::where('date', '>=', now()->subDays(365));

    if (auth()->user()->role == 'employee') {
        $totalLast7DaysQuery->where('created_by', auth()->id());
        $totalLast30DaysQuery->where('created_by', auth()->id());
        $totalLast365DaysQuery->where('created_by', auth()->id());
    }

    $totalLast7Days = $totalLast7DaysQuery->sum('amount');
    $totalLast30Days = $totalLast30DaysQuery->sum('amount');
    $totalLast365Days = $totalLast365DaysQuery->sum('amount');
$employees=User::where('role','employee')->get();

    $account_setting = AccountSetting::where('user_id', auth()->user()->id)->first();

    return view('finance.expenses.index', compact(
        'expenses',
        'categories',
'employees',
        'account_setting',
        'totalLast7Days',
        'totalLast30Days',
        'totalLast365Days'
    ));
}
    public function create()
    {
        $accounts = Account::all();
        $treasuries = Treasury::all();
        $suppliers = Supplier::all();
        $expenses_categories = ExpensesCategory::select('id', 'name')->get();
        $code = Expense::generateCode();

        $MainTreasury = null;
        $user = Auth::user();

        if ($user && $user->employee_id) {
            $TreasuryEmployee = TreasuryEmployee::where('employee_id', $user->employee_id)->first();
            $MainTreasury = $TreasuryEmployee && $TreasuryEmployee->treasury_id
                ? Account::where('id', $TreasuryEmployee->treasury_id)->first()
                : Account::where('name', 'الخزينة الرئيسية')->first();
        } else {
            $MainTreasury = Account::where('name', 'الخزينة الرئيسية')->first();
        }

        $taxs = TaxSitting::all();
        $account_setting = AccountSetting::where('user_id', auth()->id())->first();

        return view('finance.expenses.create', compact(
            'expenses_categories', 'taxs', 'treasuries',
            'accounts', 'suppliers', 'code', 'MainTreasury', 'account_setting'
        ));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // إنشاء سند الصرف الجديد
            $expense = new Expense();
            $expense->code = $request->input('code');
            $expense->created_by = auth()->id();
            $expense->amount = $request->input('amount', 0);
            $expense->description = $request->input('description');
            $expense->date = $request->input('date');
            $expense->unit_id = $request->input('unit_id');
            $expense->expenses_category_id = $request->input('expenses_category_id');
            $expense->supplier_id = $request->input('supplier_id');
            $expense->seller = $request->input('seller');
            $expense->treasury_id = $request->input('treasury_id');
            $expense->account_id = $request->input('account_id');
            $expense->is_recurring = $request->boolean('is_recurring', false);
            $expense->recurring_frequency = $request->input('recurring_frequency');
            $expense->end_date = $request->input('end_date');
            $expense->tax1 = $request->input('tax1', 0);
            $expense->tax2 = $request->input('tax2', 0);
            $expense->tax1_amount = $request->input('tax1_amount', 0);
            $expense->tax2_amount = $request->input('tax2_amount', 0);
            $expense->cost_centers_enabled = $request->boolean('cost_centers_enabled', false);

            // رفع المرفقات إذا وجدت
            if ($request->hasFile('attachments')) {
                $expense->attachments = $this->uploadImage('assets/uploads/expenses', $request->file('attachments'));
            }

            // حفظ سند الصرف
            $expense->save();

            // تسجيل العملية في السجلات
            ModelsLog::create([
                'type' => 'finance_log',
                'type_id' => $expense->id,
                'type_log' => 'log',
                'description' => sprintf('تم انشاء سند صرف رقم **%s** بقيمة **%s**',
                    $expense->code,
                    number_format($expense->amount, 2)
                ),
                'created_by' => auth()->id(),
            ]);

            // الحصول على الخزينة المناسبة
            $user = Auth::user();
            $MainTreasury = null;

            if ($user && $user->employee_id) {
                $TreasuryEmployee = TreasuryEmployee::where('employee_id', $user->employee_id)->first();
                $MainTreasury = $TreasuryEmployee && $TreasuryEmployee->treasury_id
                    ? Account::where('id', $TreasuryEmployee->treasury_id)->first()
                    : Account::where('name', 'الخزينة الرئيسية')->first();
            } else {
                $MainTreasury = Account::where('name', 'الخزينة الرئيسية')->first();
            }

            // التحقق من وجود الخزينة
            if (!$MainTreasury) {
                throw new \Exception('لا توجد خزينة متاحة. يرجى التحقق من إعدادات الخزينة.');
            }

            // التحقق من رصيد الخزينة
            if ($MainTreasury->balance < $expense->amount) {
                throw new \Exception('رصيد الخزينة غير كافٍ لتنفيذ عملية الصرف.');
            }

            // تحديث رصيد الخزينة
            $MainTreasury->balance -= $expense->amount;
            $MainTreasury->save();

            // إنشاء قيد يومية
            $journalEntry = JournalEntry::create([
                'reference_number' => $expense->code,
                'date' => $expense->date,
                'description' => 'سند صرف رقم ' . $expense->code,
                'status' => 1,
                'currency' => 'SAR',
                'created_by_employee' => $user->id,
            ]);

            // تفاصيل القيد اليومي (من الخزينة)
            JournalEntryDetail::create([
                'journal_entry_id' => $journalEntry->id,
                'account_id' => $MainTreasury->id,
                'description' => 'صرف مبلغ من الخزينة',
                'debit' => 0,
                'credit' => $expense->amount,
                'is_debit' => false,
            ]);

            // تفاصيل القيد اليومي (إلى المصروفات)
            JournalEntryDetail::create([
                'journal_entry_id' => $journalEntry->id,
                'account_id' => $expense->account_id,
                'description' => 'صرف مبلغ لمصروفات',
                'debit' => $expense->amount,
                'credit' => 0,
                'is_debit' => true,
            ]);

            // تحديث رصيد حساب المصروفات
            $expense_account = Account::find($expense->account_id);
            if ($expense_account) {
                $expense_account->balance += $expense->amount;
                $expense_account->save();
            }

            DB::commit();

            return redirect()
                ->route('expenses.index')
                ->with('success', 'تم إضافة سند صرف بنجاح!');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('خطأ في إضافة سند صرف: ' . $e->getMessage());

            return back()
                ->with('error', 'حدث خطأ أثناء إضافة سند الصرف: ' . $e->getMessage())
                ->withInput();
        }
    }
public function update(Request $request, $id)
{
    try {
        DB::beginTransaction();

        // البحث عن سند الصرف المطلوب
        $expense = Expense::findOrFail($id);

        // تحديث الحقول الأساسية
        $expense->code = $request->input('code');
        $expense->amount = $request->input('amount');
        $expense->description = $request->input('description');
        $expense->date = $request->input('date');
        $expense->unit_id = $request->input('unit_id');
        $expense->expenses_category_id = $request->input('expenses_category_id');
        $expense->supplier_id = $request->input('supplier_id');
        $expense->seller = $request->input('seller');
        $expense->treasury_id = $request->input('treasury_id');
        $expense->account_id = $request->input('account_id');
        $expense->is_recurring = $request->has('is_recurring') ? 1 : 0;
        $expense->recurring_frequency = $request->input('recurring_frequency');
        $expense->end_date = $request->input('end_date');
        $expense->tax1 = $request->input('tax1');
        $expense->tax2 = $request->input('tax2');
        $expense->tax1_amount = $request->input('tax1_amount');
        $expense->tax2_amount = $request->input('tax2_amount');
        $expense->cost_centers_enabled = $request->has('cost_centers_enabled') ? 1 : 0;

        // معالجة المرفقات
        if ($request->hasFile('attachments')) {
            $expense->attachments = $this->UploadImage('assets/uploads/expenses', $request->file('attachments'));
        }

        // حفظ التحديثات
        $expense->update();

        // تسجيل النشاط في السجل
        ModelsLog::create([
            'type' => 'finance_log',
            'type_id' => $expense->id,
            'type_log' => 'log',
            'description' => sprintf(
                'تم تعديل سند صرف رقم **%s** بقيمة **%d**',
                $expense->code,
                $expense->amount
            ),
            'created_by' => auth()->id(),
        ]);

        // تحديد الخزينة المستهدفة بناءً على الموظف
        $MainTreasury = null;
        $user = Auth::user();

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

        // التحقق من أن رصيد الخزينة كافٍ
        if ($MainTreasury->balance < $expense->amount) {
            throw new \Exception('رصيد الخزينة غير كافٍ لتنفيذ عملية الصرف.');
        }

        // سحب المبلغ من الخزينة
        $MainTreasury->balance -= $expense->amount;
        $MainTreasury->save();

        // تحديث القيد المحاسبي لسند الصرف
        $journalEntry = JournalEntry::where('reference_number', $expense->code)->first();

        if ($journalEntry) {
            $journalEntry->update([
                'date' => $expense->date,
                'description' => 'سند صرف رقم ' . $expense->code,
                'vendor_id' => $expense->supplier_id, // استخدام supplier_id بدلاً من vendor_id
            ]);

            // تحديث تفاصيل القيد المحاسبي لسند الصرف
            // 1. حساب الخزينة المستهدفة (دائن)
            JournalEntryDetail::where('journal_entry_id', $journalEntry->id)
                ->where('account_id', $MainTreasury->id)
                ->update([
                    'credit' => $expense->amount,
                ]);

            // 2. حساب المصروفات (مدين)
            JournalEntryDetail::where('journal_entry_id', $journalEntry->id)
                ->where('account_id', $expense->account_id) // استخدام account_id بدلاً من sup_account
                ->update([
                    'debit' => $expense->amount,
                ]);
        }

        DB::commit();

        return redirect()
            ->route('expenses.show', $id)
            ->with('success', 'تم تحديث سند صرف بنجاح!');
    } catch (\Exception $e) {
        DB::rollback();
        Log::error('خطأ في تحديث سند صرف: ' . $e->getMessage());
        return back()
            ->with('error', 'حدث خطأ أثناء تحديث سند الصرف: ' . $e->getMessage())
            ->withInput();
    }
}
    public function show($id)
    {
        $expense = Expense::findOrFail($id);
        return view('finance.expenses.show', compact('expense'));
    }

    public function edit($id)
    {
        $expenses_categories = ExpensesCategory::select('id', 'name')->get();
        $expense = Expense::findOrFail($id);
        return view('finance.expenses.edit', compact('expense', 'expenses_categories'));
    }

    public function delete($id)
    {
        $expense = Expense::findOrFail($id);
        ModelsLog::create([
            'type' => 'finance_log',
            'type_id' => $id, // ID النشاط المرتبط
            'type_log' => 'log', // نوع النشاط
            'description' => 'تم  حذف سند صرف رقم  **' . $id . '**',
            'created_by' => auth()->id(), // ID المستخدم الحالي
        ]);

        $expense->delete();
        return redirect()
            ->route('expenses.index')
            ->with(['error' => 'تم حذف سند صرف بنجاج !!']);
    }

    function uploadImage($folder, $image)
    {
        $fileExtension = $image->getClientOriginalExtension();
        $fileName = time() . rand(1, 99) . '.' . $fileExtension;
        $image->move($folder, $fileName);

        return $fileName;
    } //end of uploadImage
    public function print($id)
    {
        $expense = Expense::findOrFail($id);

        // إنشاء PDF
        $pdf = Pdf::loadView('finance.expenses.pdf', compact('expense'));

        // عرض PDF في المتصفح
        return $pdf->stream('expense' . $expense->id . '.pdf');
    }
}
