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
use App\Models\TreasuryEmployee;
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

        // Calculate total expenses for different periods
        $totalLast7Days = Expense::where('date', '>=', now()->subDays(7))->sum('amount');
        $totalLast30Days = Expense::where('date', '>=', now()->subDays(30))->sum('amount');
        $totalLast365Days = Expense::where('date', '>=', now()->subDays(365))->sum('amount');

        $expenses = Expense::orderBy('id', 'DESC')
            ->when($request->keywords, function ($query, $keywords) {
                return $query->where('code', 'like', '%' . $keywords . '%')
                             ->orWhere('description', 'like', '%' . $keywords . '%');
            })
            ->when($request->from_date, function ($query, $from_date) {
                return $query->where('date', '>=', $from_date);
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
                return $query->where('employee_id', $added_by);
            })
            ->paginate(10);

        return view('finance.expenses.index', compact('expenses', 'categories', 'totalLast7Days', 'totalLast30Days', 'totalLast365Days'));
    }
    public function create()
    {
        $accounts = Account::all();
        $treasury = Treasury::all();
        $suppliers = Supplier::all();
        $expenses_categories = ExpensesCategory::select('id', 'name')->get();

        // توليد الرقم المتسلسل
        $code = Expense::generateCode();

        return view('finance.expenses.create', compact('expenses_categories', 'treasury', 'accounts', 'suppliers', 'code'));
    }


    public function store(Request $request)
{
    // try {
    // dd($request->supplier_id);
        DB::beginTransaction();

        // إنشاء سند الصرف
        $expense = new Expense();

        // تعبئة الحقول الأساسية
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

        // حفظ سند الصرف
        $expense->save();

        // تسجيل النشاط في السجل
        ModelsLog::create([
            'type' => 'finance_log',
            'type_id' => $expense->id,
            'type_log' => 'log',
            'description' => sprintf('تم انشاء سند صرف رقم **%s** بقيمة **%d**', $expense->code, $expense->amount),
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

        // إنشاء قيد محاسبي لسند الصرف
        $journalEntry = JournalEntry::create([
            'reference_number' => $expense->code,
            'date' => $expense->date,
            'description' => 'سند صرف رقم ' . $expense->code,
            'status' => 1,
            'currency' => 'SAR',
            'vendor_id' => $expense->supplier_id, // استخدام supplier_id بدلاً من vendor_id
            // 'created_by_employee' => Auth::id(),
        ]);

        // إضافة تفاصيل القيد المحاسبي لسند الصرف
        // 1. حساب الخزينة المستهدفة (دائن)
        JournalEntryDetail::create([
            'journal_entry_id' => $journalEntry->id,
            'account_id' => $MainTreasury->id,
            'description' => 'صرف مبلغ من الخزينة',
            'debit' => 0,
            'credit' => $expense->amount,
            'is_debit' => false,
        ]);

        $Supplier = Supplier::find($expense->supplier_id);
        $MainTreasury = Account::where('name', 'الخزينة الرئيسية')->first();
        // 2. حساب المصروفات (مدين)
        JournalEntryDetail::create([
            'journal_entry_id' => $journalEntry->id,
            'account_id' => $expense->account_id, // استخدام account_id بدلاً من sup_account
            'description' => 'صرف مبلغ لمصروفات',
            'debit' => $expense->amount,
            'credit' => 0,
            'is_debit' => true,
        ]);

        DB::commit();

        return redirect()->route('expenses.index')->with('success', 'تم إضافة سند صرف بنجاح!');
    // } catch (\Exception $e) {
        DB::rollback();
        Log::error('خطأ في إضافة سند صرف: ' . $e->getMessage());
        return back()
            ->with('error', 'حدث خطأ أثناء إضافة سند الصرف: ' . $e->getMessage())
            ->withInput();
    // }
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
