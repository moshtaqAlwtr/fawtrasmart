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

        // تحديد الخزينة المستهدفة بناءً على الموظف
        $MainTreasury = null;
        $user = Auth::user();

        if ($user && $user->employee_id) {
            // البحث عن الخزينة المرتبطة بالموظف
            $TreasuryEmployee = TreasuryEmployee::where('employee_id', $user->employee_id)->first();

            if ($TreasuryEmployee && $TreasuryEmployee->treasury_id) {
                // إذا كان الموظف لديه خزينة مرتبطة
                $MainTreasury = Treasury::where('id', $TreasuryEmployee->treasury_id)->first();
            } else {
                // إذا لم يكن لدى الموظف خزينة مرتبطة، استخدم الخزينة الرئيسية
                $MainTreasury = Treasury::where('name', 'الخزينة الرئيسية')->first();
            }
        } else {
            // إذا لم يكن المستخدم موجودًا أو لم يكن لديه employee_id، استخدم الخزينة الرئيسية
            $MainTreasury = Treasury::where('name', 'الخزينة الرئيسية')->first();
        }

        // إذا لم يتم العثور على خزينة، توقف العملية وأظهر خطأ


        // تعيين الخزينة المستهدفة لسند القبض
        $income->treasury_id = $MainTreasury->id;

        // معالجة المرفقات
        if ($request->hasFile(key: 'attachments')) {
            $income->attachments = $this->UploadImage('assets/uploads/incomes', $request->attachments);
        }

        if ($request->has('is_recurring')) {
            $income->is_recurring = 1;
        }

        if ($request->has('cost_centers_enabled')) {
            $income->cost_centers_enabled = 1;
        }

        // حفظ سند القبض
        $income->save();

        // تحديث رصيد الخزينة
        $MainTreasury->balance += $income->amount; // إضافة المبلغ إلى الخزينة
        $MainTreasury->save();

        // إنشاء قيد محاسبي
        $journalEntry = JournalEntry::create([
            'reference_number' => $income->code,
            'date' => $income->date,
            'description' => 'سند قبض رقم ' . $income->code,
            'status' => 1, // حالة القيد (مثلاً: 1 يعني نشط)
            'currency' => 'SAR',
            'created_by_employee' => Auth::id(),
        ]);

        // إضافة تفاصيل القيد المحاسبي
        // 1. حساب الخزينة (مدين)
        JournalEntryDetail::create([
            'journal_entry_id' => $journalEntry->id,
            'account_id' => $MainTreasury->account_id, // حساب الخزينة
            'description' => 'استلام مبلغ من العميل',
            'debit' => $income->amount,
            'credit' => 0,
            'is_debit' => true,
        ]);

        // 2. حساب العميل (دائن)
        JournalEntryDetail::create([
            'journal_entry_id' => $journalEntry->id,
            'account_id' => $income->sup_account, // حساب العميل
            'description' => 'دفعة من العميل',
            'debit' => 0,
            'credit' => $income->amount,
            'is_debit' => false,
        ]);

        // تسجيل النشاط في السجل
        ModelsLog::create([
            'type' => 'finance_log',
            'type_id' => $income->id, // ID النشاط المرتبط
            'type_log' => 'log', // نوع النشاط
            'description' => sprintf(
                'تم انشاء سند قبض رقم **%s** بقيمة **%d**',
                $income->code, // رقم سند القبض
                $income->amount, // المبلغ
            ),
            'created_by' => auth()->id(), // ID المستخدم الحالي
        ]);

        DB::commit();

        // التحقق من أن البيانات تم حفظها
        if ($income->exists && $journalEntry->exists) {
            return redirect()
                ->route('incomes.index')
                ->with(['success' => 'تم إضافة سند قبض بنجاح وإضافة المبلغ إلى الخزينة.']);
        } else {
            throw new \Exception('حدث خطأ أثناء حفظ البيانات.');
        }

    } catch (\Exception $e) {
        DB::rollBack();
        return back()
            ->withErrors(['error' => 'حدث خطأ: ' . $e->getMessage()])
            ->withInput();
    }
}

    public function update(Request $request, $id)
    {
        $income = Receipt::findOrFail($id);

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

        ModelsLog::create([
            'type' => 'finance_log',
            'type_id' => $income->id, // ID النشاط المرتبط
            'type_log' => 'log', // نوع النشاط
            'description' => sprintf(
                'تم تعديل سند قبض رقم **%s** بقيمة **%d**',
                $income->code, // رقم طلب الشراء
                $income->amount, // اسم المنتج
            ),
            'created_by' => auth()->id(), // ID المستخدم الحالي
        ]);
        if ($request->hasFile(key: 'attachments')) {
            $income->attachments = $this->UploadImage('assets/uploads/incomes', $request->attachments);
        }

        if ($request->has('is_recurring')) {
            $income->is_recurring = 1;
        }

        if ($request->has('cost_centers_enabled')) {
            $income->cost_centers_enabled = 1;
        }

        $income->update();

        return redirect()
            ->route('incomes.show', $id)
            ->with(['success' => 'تم تحديث سند قبض بنجاج !!']);
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
