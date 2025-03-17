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
use App\Models\Treasury;
use App\Models\TreasuryEmployee;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExpensesController extends Controller
{
    public function index()
    {
        $expenses = Expense::orderBy('id', 'DESC')->paginate(5);
        return view('finance.expenses.index', compact('expenses'));
    }

    public function create()
    {
        $accounts = Account::all();
        $treasury = Treasury::all();
        $expenses_categories = ExpensesCategory::select('id', 'name')->get();
        return view('finance.expenses.create', compact('expenses_categories', 'treasury', 'accounts'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // إنشاء سند الصرف
            $expense = new Expense();

            $expense->code = $request->code;
            $expense->amount = $request->amount;
            $expense->description = $request->description;
            $expense->date = $request->date;
            $expense->unit_id = $request->unit_id;
            $expense->expenses_category_id = $request->expenses_category_id;
            $expense->vendor_id = $request->vendor_id;
            $expense->seller = $request->seller;
            $expense->store_id = $request->store_id;
            $expense->sup_account = $request->sup_account;
            $expense->recurring_frequency = $request->recurring_frequency;
            $expense->end_date = $request->end_date;
            $expense->tax1 = $request->tax1;
            $expense->tax2 = $request->tax2;
            $expense->tax1_amount = $request->tax1_amount;
            $expense->tax2_amount = $request->tax2_amount;

            // معالجة المرفقات
            if ($request->hasFile('attachments')) {
                $expense->attachments = $this->UploadImage('assets/uploads/expenses', $request->attachments);
            }

            // التحقق من الحقول الاختيارية
            if ($request->has('is_recurring')) {
                $expense->is_recurring = 1;
            }

            if ($request->has('cost_centers_enabled')) {
                $expense->cost_centers_enabled = 1;
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
                'vendor_id' => $expense->vendor_id, // يمكن تعديل هذا الحقل حسب الحاجة
                'created_by_employee' => Auth::id(),
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

            // 2. حساب المصروفات (مدين)
            JournalEntryDetail::create([
                'journal_entry_id' => $journalEntry->id,
                'account_id' => $expense->sup_account, // حساب المصروفات المرتبط بسند الصرف
                'description' => 'صرف مبلغ لمصروفات',
                'debit' => $expense->amount,
                'credit' => 0,
                'is_debit' => true,
            ]);

            DB::commit();

            return redirect()->route('expenses.index')->with('success', 'تم إضافة سند صرف بنجاح!');
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
        $expense = Expense::findOrFail($id);

        $expense->code = $request->code;
        $expense->amount = $request->amount;
        $expense->description = $request->description;
        $expense->date = $request->date;
        $expense->unit_id = $request->unit_id;
        $expense->expenses_category_id = $request->expenses_category_id;
        $expense->vendor_id = $request->vendor_id;
        $expense->seller = $request->seller;
        $expense->store_id = $request->store_id;
        $expense->sup_account = $request->sup_account;
        $expense->recurring_frequency = $request->recurring_frequency;
        $expense->end_date = $request->end_date;
        $expense->tax1 = $request->tax1;
        $expense->tax2 = $request->tax2;
        $expense->tax1_amount = $request->tax1_amount;
        $expense->tax2_amount = $request->tax2_amount;

        ModelsLog::create([
            'type' => 'finance_log',
            'type_id' => $expense->id, // ID النشاط المرتبط
            'type_log' => 'log', // نوع النشاط
            'description' => sprintf(
                'تم تعديل سند صرف رقم **%s** بقيمة **%d**',
                $request->id, // رقم طلب الشراء
                $expense->amount, // اسم المنتج
            ),
            'created_by' => auth()->id(), // ID المستخدم الحالي
        ]);
        if ($request->hasFile(key: 'attachments')) {
            $expense->attachments = $this->UploadImage('assets/uploads/expenses', $request->attachments);
        }

        if ($request->has('is_recurring')) {
            $expense->is_recurring = 1;
        }

        if ($request->has('cost_centers_enabled')) {
            $expense->cost_centers_enabled = 1;
        }

        $expense->update();

        return redirect()
            ->route('expenses.show', $id)
            ->with(['success' => 'تم تحديث سند صرف بنجاج !!']);
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
}
