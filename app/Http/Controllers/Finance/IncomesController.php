<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\JournalEntry;
use App\Models\JournalEntryDetail;
use App\Models\Receipt;
use App\Models\Log as ModelsLog;
use App\Models\ReceiptCategory;
use App\Models\Treasury;
use App\Models\TreasuryEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IncomesController extends Controller
{
    public function index()
    {
        $incomes = Receipt::orderBy('id', 'DESC')->paginate(5);
        return view('finance.incomes.index', compact('incomes'));
    }

    public function create()
{
    $incomes_categories = ReceiptCategory::select('id', 'name')->get();
    $treas = Treasury::select('id', 'name')->get();
    $accounts = Account::all();

    // حساب الرقم التلقائي
    $lastCode = Receipt::max('code'); // نفترض أن الحقل في الجدول يسمى 'code'
    $nextCode = $lastCode ? $lastCode + 1 : 1; // إذا لم يكن هناك أي سجلات، نبدأ من 1

    return view('finance.incomes.create', compact('incomes_categories', 'treas', 'accounts', 'nextCode'));
}
public function store(Request $request)
{
    try {
        DB::beginTransaction();

        // إنشاء سند القبض
        $income = new Receipt();

        $income->code = $request->code;
        $income->amount = $request->amount;
        $income->description = $request->description;
        $income->date = $request->date;
        $income->incomes_category_id = $request->incomes_category_id;
        $income->seller = $request->seller;
        $income->store_id = $request->store_id;
        $income->sup_account = $request->sup_account;
        $income->recurring_frequency = $request->recurring_frequency;
        $income->end_date = $request->end_date;
        $income->tax1 = $request->tax1;
        $income->tax2 = $request->tax2;
        $income->tax1_amount = $request->tax1_amount;
        $income->tax2_amount = $request->tax2_amount;

        // معالجة المرفقات
        if ($request->hasFile('attachments')) {
            $income->attachments = $this->UploadImage('assets/uploads/incomes', $request->attachments);
        }

        // التحقق من الحقول الاختيارية
        if ($request->has('is_recurring')) {
            $income->is_recurring = 1;
        }

        if ($request->has('cost_centers_enabled')) {
            $income->cost_centers_enabled = 1;
        }

        // حفظ سند القبض
        $income->save();

        // تسجيل النشاط في السجل
        ModelsLog::create([
            'type' => 'finance_log',
            'type_id' => $income->id,
            'type_log' => 'log',
            'description' => sprintf(
                'تم انشاء سند قبض رقم **%s** بقيمة **%d**',
                $income->code,
                $income->amount
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

        // تحديث رصيد الخزينة
        $MainTreasury->balance += $income->amount;
        $MainTreasury->save();

        // إنشاء قيد محاسبي لسند القبض
        $journalEntry = JournalEntry::create([
            'reference_number' => $income->code,
            'date' => $income->date,
            'description' => 'سند قبض رقم ' . $income->code,
            'status' => 1,
            'currency' => 'SAR',
            'client_id' => $income->seller, // يمكن تعديل هذا الحقل حسب الحاجة
            'created_by_employee' => Auth::id(),
        ]);

        // إضافة تفاصيل القيد المحاسبي لسند القبض
        // 1. حساب الخزينة المستهدفة (مدين)
        JournalEntryDetail::create([
            'journal_entry_id' => $journalEntry->id,
            'account_id' => $MainTreasury->id,
            'description' => 'استلام مبلغ من سند قبض',
            'debit' => $income->amount,
            'credit' => 0,
            'is_debit' => true,
        ]);

        // 2. حساب الإيرادات (دائن)
        JournalEntryDetail::create([
            'journal_entry_id' => $journalEntry->id,
            'account_id' => $income->sup_account, // حساب الإيرادات المرتبط بسند القبض
            'description' => 'إيرادات من سند قبض',
            'debit' => 0,
            'credit' => $income->amount,
            'is_debit' => false,
        ]);

        DB::commit();

        return redirect()->route('incomes.index')->with('success', 'تم إضافة سند قبض بنجاح!');

    } catch (\Exception $e) {
        DB::rollback();
        Log::error('خطأ في إضافة سند قبض: ' . $e->getMessage());
        return back()
            ->with('error', 'حدث خطأ أثناء إضافة سند القبض: ' . $e->getMessage())
            ->withInput();
    }
}

/**
 * تحديد الخزينة المستهدفة بناءً على الموظف.
 */
private function getMainTreasury()
{
    $user = Auth::user();

    if ($user && $user->employee_id) {
        // البحث عن الخزينة المرتبطة بالموظف
        $TreasuryEmployee = TreasuryEmployee::where('employee_id', $user->employee_id)->first();

        if ($TreasuryEmployee && $TreasuryEmployee->treasury_id) {
            // إذا كان الموظف لديه خزينة مرتبطة
            return Treasury::where('id', $TreasuryEmployee->treasury_id)->first();
        }
    }

    // إذا لم يكن لدى الموظف خزينة مرتبطة، استخدم الخزينة الرئيسية
    return Treasury::where('name', 'الخزينة الرئيسية')->first();
}

public function update(Request $request, $id)
{
    try {
        DB::beginTransaction();

        // البحث عن سند القبض المطلوب
        $income = Receipt::findOrFail($id);

        // حفظ القيم القديمة للمقارنة
        $oldAmount = $income->amount;
        $oldSupAccount = $income->sup_account;

        // تحديث بيانات سند القبض
        $income->code = $request->code;
        $income->amount = $request->amount;
        $income->description = $request->description;
        $income->date = $request->date;
        $income->incomes_category_id = $request->incomes_category_id;
        $income->seller = $request->seller;
        $income->store_id = $request->store_id;
        $income->sup_account = $request->sup_account;
        $income->recurring_frequency = $request->recurring_frequency;
        $income->end_date = $request->end_date;
        $income->tax1 = $request->tax1;
        $income->tax2 = $request->tax2;
        $income->tax1_amount = $request->tax1_amount;
        $income->tax2_amount = $request->tax2_amount;

        // معالجة المرفقات
        if ($request->hasFile('attachments')) {
            $income->attachments = $this->UploadImage('assets/uploads/incomes', $request->attachments);
        }

        // التحقق من الحقول الاختيارية
        if ($request->has('is_recurring')) {
            $income->is_recurring = 1;
        } else {
            $income->is_recurring = 0;
        }

        if ($request->has('cost_centers_enabled')) {
            $income->cost_centers_enabled = 1;
        } else {
            $income->cost_centers_enabled = 0;
        }

        // حفظ التحديثات
        $income->update();

        // تسجيل النشاط في السجل
        ModelsLog::create([
            'type' => 'finance_log',
            'type_id' => $income->id,
            'type_log' => 'log',
            'description' => sprintf(
                'تم تعديل سند قبض رقم **%s** بقيمة **%d**',
                $income->code,
                $income->amount
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

        // تحديث رصيد الخزينة بناءً على الفرق بين المبلغ القديم والجديد
        $amountDifference = $income->amount - $oldAmount;
        $MainTreasury->balance += $amountDifference;
        $MainTreasury->save();

        // البحث عن القيد المحاسبي المرتبط بسند القبض
        $journalEntry = JournalEntry::where('reference_number', $income->code)->first();

        if ($journalEntry) {
            // تحديث تفاصيل القيد المحاسبي
            // 1. تحديث حساب الخزينة المستهدفة (مدين)
            $treasuryDetail = JournalEntryDetail::where('journal_entry_id', $journalEntry->id)
                ->where('account_id', $MainTreasury->id)
                ->first();

            if ($treasuryDetail) {
                $treasuryDetail->debit += $amountDifference;
                $treasuryDetail->save();
            }

            // 2. تحديث حساب الإيرادات (دائن)
            $incomeDetail = JournalEntryDetail::where('journal_entry_id', $journalEntry->id)
                ->where('account_id', $oldSupAccount)
                ->first();

            if ($incomeDetail) {
                $incomeDetail->credit += $amountDifference;
                $incomeDetail->account_id = $income->sup_account; // تحديث حساب الإيرادات إذا تغير
                $incomeDetail->save();
            }
        }

        DB::commit();

        return redirect()
            ->route('incomes.show', $id)
            ->with('success', 'تم تحديث سند قبض بنجاح!');

    } catch (\Exception $e) {
        DB::rollback();
        Log::error('خطأ في تحديث سند قبض: ' . $e->getMessage());
        return back()
            ->with('error', 'حدث خطأ أثناء تحديث سند القبض: ' . $e->getMessage())
            ->withInput();
    }
}

    public function show($id)
    {
        $income = Receipt::findOrFail($id);
        return view('finance.incomes.show', compact('income'));
    }

    public function edit($id)
    {
        $incomes_categories = ReceiptCategory::select('id', 'name')->get();
        $income = Receipt::findOrFail($id);
        return view('finance.incomes.edit', compact('income', 'incomes_categories'));
    }

    public function delete($id)
    {
        $incomes = Receipt::findOrFail($id);
        ModelsLog::create([
            'type' => 'finance_log',
            'type_id' => $id, // ID النشاط المرتبط
            'type_log' => 'log', // نوع النشاط
            'description' => 'تم  حذف سند قبض رقم  **' . $id . '**',
            'created_by' => auth()->id(), // ID المستخدم الحالي
        ]);
        $incomes->delete();
        return redirect()
            ->route('incomes.index')
            ->with(['error' => 'تم حذف سند قبض بنجاج !!']);
    }

    function uploadImage($folder, $image)
    {
        $fileExtension = $image->getClientOriginalExtension();
        $fileName = time() . rand(1, 99) . '.' . $fileExtension;
        $image->move($folder, $fileName);

        return $fileName;
    } //end of uploadImage
}
