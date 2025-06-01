<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Client;
use App\Models\Employee;
use App\Models\AccountSetting;
use App\Models\Invoice;
use App\Models\JournalEntry;
use App\Models\JournalEntryDetail;
use App\Models\Receipt;

use App\Models\Log as ModelsLog;
use App\Models\notifications;
use App\Models\PaymentsProcess;
use App\Models\ReceiptCategory;
use App\Models\Supplier;
use App\Models\TaxSitting;
use App\Models\Treasury;
use App\Models\TreasuryEmployee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IncomesController extends Controller
{
public function index(Request $request)
{
    // جلب البيانات مع تطبيق شروط البحث
    $query = Receipt::orderBy('id', 'DESC')
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
        ->when($request->created_by, function ($query, $created_by) {
            return $query->where('created_by', $created_by);
        });

    // إذا كان المستخدم موظفاً، نضيف شرطاً لرؤية سنداته فقط
    if (auth()->user()->role == 'employee') {
        $query->where('created_by', auth()->id());
    }

    $incomes = $query->paginate(20);

    // حساب إجمالي الإيرادات لفترات مختلفة مع مراعاة دور المستخدم
    $totalQuery = Receipt::query();
    $totalLast7DaysQuery = Receipt::where('date', '>=', now()->subDays(7));
    $totalLast30DaysQuery = Receipt::where('date', '>=', now()->subDays(30));
    $totalLast365DaysQuery = Receipt::where('date', '>=', now()->subDays(365));

    if (auth()->user()->role == 'employee') {
        $totalQuery->where('created_by', auth()->id());
        $totalLast7DaysQuery->where('created_by', auth()->id());
        $totalLast30DaysQuery->where('created_by', auth()->id());
        $totalLast365DaysQuery->where('created_by', auth()->id());
    }

    $totalLast7Days = $totalLast7DaysQuery->sum('amount');
    $totalLast30Days = $totalLast30DaysQuery->sum('amount');
    $totalLast365Days = $totalLast365DaysQuery->sum('amount');

    // جلب البيانات المرتبطة (مثل التصنيفات والبائعين)
    $categories = ReceiptCategory::all();
    $suppliers = Supplier::all();
    $Accounts = Account::all();
    $users = User::select('id', 'name')->where('role', 'employee')->get();

    $account_setting = AccountSetting::where('user_id', auth()->user()->id)->first();

    return view('finance.incomes.index', compact(
        'incomes',
        'categories',
        'Accounts',
        'users',
        'account_setting',
        'totalLast7Days',
        'totalLast30Days',
        'totalLast365Days'
    ));
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
        return view('finance.incomes.create', compact('incomes_categories', 'account_storage', 'taxs', 'treas', 'accounts', 'account_setting', 'nextCode', 'MainTreasury'));
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
        $income->account_id = $request->input('account_id');
        $income->treasury_id = $request->input('treasury_id');
        $income->is_recurring = $request->has('is_recurring') ? 1 : 0;
        $income->recurring_frequency = $request->input('recurring_frequency');
        $income->end_date = $request->input('end_date');
        $income->tax1 = $request->input('tax1');
        $income->tax2 = $request->input('tax2');
        $income->created_by = auth()->id();
        $income->tax1_amount = $request->input('tax1_amount');
        $income->tax2_amount = $request->input('tax2_amount');
        $income->cost_centers_enabled = $request->has('cost_centers_enabled') ? 1 : 0;

        // معالجة المرفقات
        if ($request->hasFile('attachments')) {
            $income->attachments = $this->UploadImage('assets/uploads/incomes', $request->file('attachments'));
        }

        // حفظ سند القبض
        $income->save();

        // إشعار إنشاء سند القبض
        $user = auth()->user();
        $income_account_name = Account::find($income->account_id);

        notifications::create([
            'user_id' => $user->id,
            'type' => 'Receipt',
            'title' => $user->name . ' أنشأ سند قبض',
            'description' => 'سند قبض رقم ' . $income->code . ' لـ ' . $income_account_name->name . ' بقيمة ' . number_format($income->amount, 2) . ' ر.س',
        ]);

        // تسجيل النشاط في السجل
        ModelsLog::create([
            'type' => 'finance_log',
            'type_id' => $income->id,
            'type_log' => 'log',
            'description' => sprintf('تم انشاء سند قبض رقم **%s** بقيمة **%d**', $income->code, $income->amount),
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

        // تحديث رصيد الخزينة
        $MainTreasury->balance += $income->amount;
        $MainTreasury->save();

        // البحث عن حساب العميل المرتبط بالحساب
        $clientAccount = Account::find($income->account_id);
        if ($clientAccount && $clientAccount->client_id) {
            // البحث عن أقدم فاتورة غير مدفوعة لهذا العميل
            $unpaidInvoice = Invoice::where('client_id', $clientAccount->client_id)
                ->where('is_paid', false)
                ->orderBy('created_at', 'asc')
                ->first();

            if ($unpaidInvoice) {
                // حساب المبلغ المتبقي على الفاتورة
                $totalPaid = PaymentsProcess::where('invoice_id', $unpaidInvoice->id)
                    ->where('payment_status', '!=', 5) // استثناء المدفوعات الفاشلة
                    ->sum('amount');

                $remainingAmount = $unpaidInvoice->grand_total - $totalPaid;
                $paymentAmount = min($income->amount, $remainingAmount);

                if ($paymentAmount > 0) {
                    // تحديد حالة الدفع
                    $isFullPayment = ($paymentAmount >= $remainingAmount);
                    $paymentStatus = $isFullPayment ? 1 : 2; // 1 مكتمل، 2 غير مكتمل

                    // إنشاء سجل الدفعة
                    $payment = PaymentsProcess::create([
                        'invoice_id' => $unpaidInvoice->id,
                        'amount' => $paymentAmount,
                        'payment_date' => $income->date,
                        'Payment_method' => 'cash',
                        'reference_number' => $income->code,
                        'type' => 'client payments',
                        'payment_status' => $paymentStatus,
                        'employee_id' => auth()->id(),
                        'notes' => 'دفع عبر سند القبض رقم ' . $income->code
                    ]);

                    // تحديث حالة الفاتورة
                    $unpaidInvoice->advance_payment += $paymentAmount;
                    $unpaidInvoice->is_paid = $isFullPayment;
                    $unpaidInvoice->payment_status = $paymentStatus; // تحديث حالة الفاتورة
                    $unpaidInvoice->due_value = max(0, $remainingAmount - $paymentAmount);
                    $unpaidInvoice->save();

                    // إنشاء إشعار بالدفع
                    notifications::create([
                        'user_id' => auth()->id(),
                        'type' => 'invoice_payment',
                        'title' => 'سداد فاتورة',
                        'description' => 'تم سداد مبلغ ' . number_format($paymentAmount, 2) .
                                       ' من فاتورة رقم ' . $unpaidInvoice->code .
                                       ' عبر سند القبض رقم ' . $income->code
                    ]);

                    // تحديث رصيد حساب العميل
                    $clientAccount->balance -= $paymentAmount;
                    $clientAccount->save();
                }
            }
        }

        // إنشاء القيد المحاسبي
        $journalEntry = JournalEntry::create([
            'reference_number' => $income->code,
            'date' => $income->date,
            'description' => 'سند قبض رقم ' . $income->code,
            'status' => 1,
            'currency' => 'SAR',
            'client_id' => $clientAccount->client_id ?? null,
            'created_by_employee' => $user->id,
        ]);

        // إدخال حساب الخزينة (مدين)
        JournalEntryDetail::create([
            'journal_entry_id' => $journalEntry->id,
            'account_id' => $MainTreasury->id,
            'description' => 'استلام مبلغ من سند قبض',
            'debit' => $income->amount,
            'credit' => 0,
            'is_debit' => true,
        ]);

        // إدخال حساب العميل (دائن)
        JournalEntryDetail::create([
            'journal_entry_id' => $journalEntry->id,
            'account_id' => $income->account_id,
            'description' => 'إيرادات من سند قبض',
            'debit' => 0,
            'credit' => $income->amount,
            'is_debit' => false,
        ]);

        DB::commit();

        return redirect()->route('incomes.index')->with('success', 'تم إضافة سند القبض بنجاح وتطبيقه على فاتورة العميل!');

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

        // تعبئة الحقول الأساسية
        $income->code = $request->input('code');
        $income->amount = $request->input('amount');
        $income->description = $request->input('description');
        $income->date = $request->input('date');
        $income->incomes_category_id = $request->input('incomes_category_id');
        $income->seller = $request->input('seller');
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

        // حفظ سند القبض
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

        // التراجع عن التغييرات القديمة في الأرصدة
        $oldAccount = Account::find($oldAccountId);
        if ($oldAccount) {
            $oldAccount->balance += $oldAmount;
            $oldAccount->save();
        }

        $oldTreasury = Account::find($oldTreasuryId);
        if ($oldTreasury) {
            $oldTreasury->balance -= $oldAmount;
            $oldTreasury->save();
        }

        // تطبيق التغييرات الجديدة على الأرصدة
        $MainTreasury->balance += $income->amount;
        $MainTreasury->save();

        $newAccount = Account::find($income->account_id);
        if ($newAccount) {
            $newAccount->balance -= $income->amount;
            $newAccount->save();
        }

        // البحث عن حساب العميل المرتبط بالحساب
        $clientAccount = Account::find($income->account_id);
        if ($clientAccount && $clientAccount->client_id) {
            // البحث عن أقدم فاتورة غير مدفوعة لهذا العميل
            $unpaidInvoice = Invoice::where('client_id', $clientAccount->client_id)
                ->where('is_paid', false)
                ->orderBy('created_at', 'asc')
                ->first();

            // حذف جميع عمليات الدفع القديمة المرتبطة بهذا السند
            PaymentsProcess::where('reference_number', $income->code)->delete();

            if ($unpaidInvoice) {
                // حساب المبلغ المتبقي على الفاتورة
                $totalPaid = PaymentsProcess::where('invoice_id', $unpaidInvoice->id)
                    ->where('payment_status', '!=', 5) // استثناء المدفوعات الفاشلة
                    ->sum('amount');

                $remainingAmount = $unpaidInvoice->grand_total - $totalPaid;
                $paymentAmount = min($income->amount, $remainingAmount);

                if ($paymentAmount > 0) {
                    // تحديد حالة الدفع
                    $isFullPayment = ($paymentAmount >= $remainingAmount);
                    $paymentStatus = $isFullPayment ? 1 : 2; // 1 مكتمل، 2 غير مكتمل

                    // إنشاء سجل الدفعة
                    $payment = PaymentsProcess::create([
                        'invoice_id' => $unpaidInvoice->id,
                        'amount' => $paymentAmount,
                        'payment_date' => $income->date,
                        'Payment_method' => 'cash',
                        'reference_number' => $income->code,
                        'type' => 'client payments',
                        'payment_status' => $paymentStatus,
                        'employee_id' => auth()->id(),
                        'notes' => 'دفع عبر سند القبض رقم ' . $income->code
                    ]);

                    // تحديث حالة الفاتورة
                    $unpaidInvoice->advance_payment = $totalPaid + $paymentAmount;
                    $unpaidInvoice->is_paid = $isFullPayment;
                    $unpaidInvoice->payment_status = $paymentStatus;
                    $unpaidInvoice->due_value = max(0, $remainingAmount - $paymentAmount);
                    $unpaidInvoice->save();

                    // إنشاء إشعار بالدفع
                    notifications::create([
                        'user_id' => auth()->id(),
                        'type' => 'invoice_payment',
                        'title' => 'تحديث سداد فاتورة',
                        'description' => 'تم تحديث سداد مبلغ ' . number_format($paymentAmount, 2) .
                                       ' من فاتورة رقم ' . $unpaidInvoice->code .
                                       ' عبر سند القبض رقم ' . $income->code
                    ]);
                }
            }
        }

        // تحديث القيد المحاسبي
        $journalEntry = JournalEntry::where('reference_number', $income->code)->first();

        if ($journalEntry) {
            $journalEntry->update([
                'date' => $income->date,
                'description' => 'سند قبض رقم ' . $income->code,
                'client_id' => $clientAccount->client_id ?? null,
            ]);

            // حذف التفاصيل القديمة وإضافة الجديدة
            JournalEntryDetail::where('journal_entry_id', $journalEntry->id)->delete();

            // إدخال حساب الخزينة (مدين)
            JournalEntryDetail::create([
                'journal_entry_id' => $journalEntry->id,
                'account_id' => $MainTreasury->id,
                'description' => 'استلام مبلغ من سند قبض',
                'debit' => $income->amount,
                'credit' => 0,
                'is_debit' => true,
            ]);

            // إدخال حساب العميل (دائن)
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

        return redirect()->route('incomes.index')->with('success', 'تم تحديث سند القبض بنجاح وتطبيقه على فاتورة العميل!');

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
    $income = Receipt::findOrFail($id);

    $incomes_categories = ReceiptCategory::select('id', 'name')->get();
    $treas = Treasury::select('id', 'name')->get();
    $accounts = Account::all();
    $account_storage = Account::where('parent_id', 13)->get();
    $taxs = TaxSitting::all();

    $user = Auth::user();
    $MainTreasury = null;

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

    $account_setting = AccountSetting::where('user_id', auth()->user()->id)->first();

    return view('finance.incomes.edit', compact(
        'income',
        'incomes_categories',
        'treas',
        'accounts',
        'account_storage',
        'taxs',
        'account_setting',
        'MainTreasury'
    ));
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
