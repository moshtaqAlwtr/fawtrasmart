<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Client;
use App\Models\Employee;
use App\Models\AccountSetting;
use App\Models\JournalEntry;
use App\Models\JournalEntryDetail;
use App\Models\Receipt;

use App\Models\Log as ModelsLog;
use App\Models\ReceiptCategory;
use App\Models\Supplier;
use App\Models\TaxSitting;
use App\Models\Treasury;
use App\Models\TreasuryEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IncomesController extends Controller
{
    public function index(Request $request)
    {
        // جلب البيانات مع تطبيق شروط البحث
        $incomes = Receipt::orderBy('id', 'DESC')
            ->when($request->keywords, function ($query, $keywords) {
                return $query->where('code', 'like', '%' . $keywords . '%')->orWhere('description', 'like', '%' . $keywords . '%');
            })
            ->when($request->from_date, function ($query, $from_date) {
                return $query->where('date', '>=', $from_date);
            })
            ->when($request->to_date, function ($query, $to_date) {
                return $query->where('date', '<=', $to_date);
            })
            ->when($request->category, function ($query, $category) {
                return $query->where('receipt_category_id', $category);
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
                return $query->where('added_by', $added_by);
            })
            ->paginate(2000);

        // حساب إجمالي الإيرادات لفترات مختلفة
        $totalLast7Days = Receipt::where('date', '>=', now()->subDays(7))->sum('amount');
        $totalLast30Days = Receipt::where('date', '>=', now()->subDays(30))->sum('amount');
        $totalLast365Days = Receipt::where('date', '>=', now()->subDays(365))->sum('amount');

        // جلب البيانات المرتبطة (مثل التصنيفات والبائعين)
        $categories = ReceiptCategory::all(); // جلب جميع التصنيفات
        $suppliers = Supplier::all(); // جلب جميع البائعين
        $Accounts = Account::all(); // جلب جميع الحسابات الفرعية
        $employees = Employee::all(); // جلب جميع الموظفين

        $account_setting = AccountSetting::where('user_id', auth()->user()->id)->first();
        return view('finance.incomes.index', compact('incomes', 'categories', 'Accounts', 'employees', 'account_setting', 'totalLast7Days', 'totalLast30Days', 'totalLast365Days'));
    }

    public function create()
    {
        $incomes_categories = ReceiptCategory::select('id', 'name')->get();
        $treas = Treasury::select('id', 'name')->get();
        $accounts = Account::all();
        $account_storage = Account::where('parent_id', 13)->get();

    // حساب الرقم التلقائي
    $nextCode = Receipt::max('code') ?? 0;

// نحاول تكرار البحث حتى نحصل على كود غير مكرر
while (Receipt::where('code', $nextCode)->exists()) {
    $nextCode++;
}
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
         $taxs = TaxSitting::all();

$account_setting = AccountSetting::where('user_id', auth()->user()->id)->first();
    return view('finance.incomes.create', compact('incomes_categories','account_storage','taxs', 'treas', 'accounts','account_setting', 'nextCode','MainTreasury'));
}
public function store(Request $request)
{
    try {
        DB::beginTransaction();

        // إنشاء سند القبض
        $income = new Receipt();


        // تعبئة الحقول الأساسية
        $income->code = $request->input('code');
        $income->amount = $request->input('amount');
        $income->description = $request->input('description');
        $income->date = $request->input('date');
        $income->incomes_category_id = $request->input('incomes_category_id');
        $income->seller = $request->input('seller');
        // $income->client_id = $request->input('client_id');
        $income->account_id = $request->input('account_id');
        $income->treasury_id = $request->input('treasury_id');
        $income->is_recurring = $request->has('is_recurring') ? 1 : 0;
        $income->recurring_frequency = $request->input('recurring_frequency');
        $income->end_date = $request->input('end_date');
        $income->tax1 = $request->input('tax1');
        $income->tax2 = $request->input('tax2');
        $income->created_by  = auth()->id();
        $income->tax1_amount = $request->input('tax1_amount');
        $income->tax2_amount = $request->input('tax2_amount');
        $income->cost_centers_enabled = $request->has('cost_centers_enabled') ? 1 : 0;

        // معالجة المرفقات
        if ($request->hasFile('attachments')) {
            $income->attachments = $this->UploadImage('assets/uploads/incomes', $request->file('attachments'));
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
            // $MainTreasury->balance += $income->amount;
            // $MainTreasury->save();

            // إنشاء قيد محاسبي لسند القبض
            $journalEntry = JournalEntry::create([
                'reference_number' => $income->code,
                'date' => $income->date,
                'description' => 'سند قبض رقم ' . $income->code,
                'status' => 1,
                'currency' => 'SAR',
                'client_id' => $income->client_id, // استخدام client_id بدلاً من seller
                // 'created_by_employee' => Auth::id(),
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
                'account_id' => $income->account_id, // استخدام account_id بدلاً من sup_account
                'description' => 'إيرادات من سند قبض',
                'debit' => 0,
                'credit' => $income->amount,
                'is_debit' => false,
            ]);
            $income_account = Account::find($income->account_id);

            if ($income_account) {
                $income_account->balance -= $income->amount; // المبلغ الكلي (المبيعات + الضريبة)
                $income_account->save();
            }

            if ($MainTreasury) {
                $MainTreasury->balance += $income->amount; // المبلغ الكلي (المبيعات + الضريبة)
                $MainTreasury->save();
            }
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

    public function update(Request $request, $id)
{
    try {
        DB::beginTransaction();

        // البحث عن سند القبض المطلوب
        $income = Receipt::findOrFail($id);

        // حفظ القيم القديمة للمقارنة
        $oldAmount = $income->amount;
        $oldAccountId = $income->account_id;
        $oldTreasuryId = $income->treasury_id;

        // تحديث بيانات سند القبض
        $income->code = $request->input('code');
        $income->amount = $request->input('amount');
        $income->description = $request->input('description');
        $income->date = $request->input('date');
        $income->incomes_category_id = $request->input('incomes_category_id');
        $income->seller = $request->input('seller');
        $income->client_id = $request->input('client_id');
        $income->account_id = $request->input('account_id');
        $income->treasury_id = $request->input('treasury_id');
        $income->is_recurring = $request->has('is_recurring') ? 1 : 0;
        $income->recurring_frequency = $request->input('recurring_frequency');
        $income->end_date = $request->input('end_date');
        $income->tax1 = $request->input('tax1');
        $income->tax2 = $request->input('tax2');
        $income->tax1_amount = $request->input('tax1_amount');
        $income->tax2_amount = $request->input('tax2_amount');
        $income->cost_centers_enabled = $request->has('cost_centers_enabled') ? 1 : 0;

        // معالجة المرفقات
        if ($request->hasFile('attachments')) {
            $income->attachments = $this->UploadImage('assets/uploads/incomes', $request->file('attachments'));
        }

        // حفظ التحديثات
        $income->save();

        // تسجيل النشاط في السجل
        ModelsLog::create([
            'type' => 'finance_log',
            'type_id' => $income->id,
            'type_log' => 'log',
            'description' => sprintf('تم تعديل سند قبض رقم **%s** بقيمة **%d**', $income->code, $income->amount),
            'created_by' => auth()->id(),
        ]);

        // تحديد الخزينة المستهدفة بناءً على الموظف
        $MainTreasury = null;
        $user = Auth::user();

        if ($user && $user->employee_id) {
            $TreasuryEmployee = TreasuryEmployee::where('employee_id', $user->employee_id)->first();
            if ($TreasuryEmployee && $TreasuryEmployee->treasury_id) {
                $MainTreasury = Account::where('id', $TreasuryEmployee->treasury_id)->first();
            } else {
                $MainTreasury = Account::where('name', 'الخزينة الرئيسية')->first();
            }
        } else {
            $MainTreasury = Account::where('name', 'الخزينة الرئيسية')->first();
        }

        if (!$MainTreasury) {
            throw new \Exception('لا توجد خزينة متاحة. يرجى التحقق من إعدادات الخزينة.');
        }

        // تحديث أرصدة الحسابات القديمة (التراجع عن التغييرات السابقة)
        $oldAccount = Account::find($oldAccountId);
        if ($oldAccount) {
            $oldAccount->balance += $oldAmount; // إعادة المبلغ القديم للحساب القديم
            $oldAccount->save();
        }

        $oldTreasury = Account::find($oldTreasuryId);
        if ($oldTreasury) {
            $oldTreasury->balance -= $oldAmount; // خصم المبلغ القديم من الخزينة القديمة
            $oldTreasury->save();
        }

        // تحديث أرصدة الحسابات الجديدة (تطبيق التغييرات الجديدة)
        $newAccount = Account::find($income->account_id);
        if ($newAccount) {
            $newAccount->balance -= $income->amount; // خصم المبلغ الجديد من الحساب الجديد
            $newAccount->save();
        }

        $MainTreasury->balance += $income->amount; // إضافة المبلغ الجديد للخزينة
        $MainTreasury->save();

        // البحث عن القيد المحاسبي المرتبط بسند القبض
        $journalEntry = JournalEntry::where('reference_number', $income->code)->first();

        if ($journalEntry) {
            // تحديث معلومات القيد الأساسية
            $journalEntry->update([
                'date' => $income->date,
                'description' => 'سند قبض رقم ' . $income->code,
                'client_id' => $income->client_id,
            ]);

            // حذف التفاصيل القديمة للقيد
            JournalEntryDetail::where('journal_entry_id', $journalEntry->id)->delete();

            // إضافة تفاصيل جديدة للقيد (بنفس طريقة الـ store)
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
                'account_id' => $income->account_id,
                'description' => 'إيرادات من سند قبض',
                'debit' => 0,
                'credit' => $income->amount,
                'is_debit' => false,
            ]);
        }

        DB::commit();

        return redirect()->route('incomes.show', $id)->with('success', 'تم تحديث سند قبض بنجاح!');
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
    public function print($id, $type = 'normal')
    {
        $income = Receipt::findOrFail($id);

        if ($type == 'thermal') {
            // عرض نسخة حرارية
            return view('finance.incomes.print_thermal', compact('income'));
        } else {
            // عرض نسخة عادية
            return view('finance.incomes.print_normal', compact('income'));
        }
    }
}
