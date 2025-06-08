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
        $Accounts = Account::whereNotNull('client_id')->get();

        $users = User::select('id', 'name')->where('role', 'employee')->get();

        $account_setting = AccountSetting::where('user_id', auth()->user()->id)->first();

        return view('finance.incomes.index', compact('incomes', 'categories', 'Accounts', 'users', 'account_setting', 'totalLast7Days', 'totalLast30Days', 'totalLast365Days'));
    }
    public function create()
    {
        $incomes_categories = ReceiptCategory::select('id', 'name')->get();
        $treas = Treasury::select('id', 'name')->get();
        $accounts = Account::whereNotNull('client_id')->get();
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

        // تعبئة الحقول
        $income->code = $request->input('code');
        $income->amount = $request->input('amount');
        $income->description = $request->input('description');
        $income->date = $request->input('date');
        $income->incomes_category_id = $request->input('incomes_category_id');
        $income->seller = $request->input('seller');
        $income->account_id = $request->input('account_id');
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

        // تحديد الخزينة المناسبة
        $MainTreasury = $this->determineTreasury();
        $income->treasury_id = $MainTreasury->id;

        // حفظ سند القبض
        $income->save();

        // إشعار الإنشاء
        $income_account_name = Account::find($income->account_id);
        $user = Auth::user();

        notifications::create([
            'user_id' => $user->id,
            'type' => 'Receipt',
            'title' => $user->name . ' أنشأ سند قبض',
            'description' => 'سند قبض رقم ' . $income->code . ' لـ ' . $income_account_name->name . ' بقيمة ' . number_format($income->amount, 2) . ' ر.س',
        ]);

        // تسجيل النشاط
        ModelsLog::create([
            'type' => 'finance_log',
            'type_id' => $income->id,
            'type_log' => 'log',
            'description' => sprintf('تم انشاء سند قبض رقم **%s** بقيمة **%d**', $income->code, $income->amount),
            'created_by' => auth()->id(),
        ]);

        // تحديث رصيد الخزينة
        $MainTreasury->balance += $income->amount;
        $MainTreasury->save();

        // تحديث رصيد حساب العميل
        $clientAccount = Account::find($income->account_id);
        if ($clientAccount) {
            $clientAccount->balance -= $income->amount;
            $clientAccount->save();
        }

        // تطبيق السداد على الفواتير (المنطق المعدل)
        $this->applyPaymentToInvoices($income, $user);

        // إنشاء القيد المحاسبي
        $this->createJournalEntry($income, $user, $clientAccount, $MainTreasury);

        DB::commit();

        return redirect()->route('incomes.index')->with('success', 'تم إضافة سند القبض بنجاح وتحديث رصيد العميل!');
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

        // التحقق من صحة البيانات
        $request->validate([
            'code' => 'required',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'account_id' => 'required',
            'incomes_category_id' => 'required',
        ]);

        // الحصول على سند القبض المطلوب
        $income = Receipt::findOrFail($id);

        // حفظ القيم القديمة
        $oldAmount = $income->amount;
        $oldAccountId = $income->account_id;
        $oldTreasuryId = $income->treasury_id;

        // تحديث بيانات سند القبض
        $this->updateReceiptData($income, $request);

        // تحديد الخزينة الجديدة
        $newTreasury = $this->determineTreasury();
        $income->treasury_id = $newTreasury->id;
        $income->save();

        // تحديث أرصدة الحسابات والخزينة
        $this->updateAccountBalances($income, $oldAmount, $oldAccountId, $oldTreasuryId);

        // تحديث القيد المحاسبي
        $this->updateJournalEntry($income);

        // تحديث المدفوعات والفواتير المرتبطة (المنطق المعدل)
        $this->updateRelatedPaymentsAndInvoices($income, $oldAmount);

        DB::commit();

        return redirect()->route('incomes.index')->with('success', 'تم تعديل سند القبض بنجاح');
    } catch (\Exception $e) {
        DB::rollback();
        Log::error('خطأ في تعديل سند قبض: ' . $e->getMessage());
        return back()->with('error', 'حدث خطأ أثناء التعديل: ' . $e->getMessage())->withInput();
    }
}

// الدوال المساعدة الجديدة والمعدلة

private function applyPaymentToInvoices(Receipt $income, $user)
{
    $clientAccount = Account::find($income->account_id);
    if (!$clientAccount || !$clientAccount->client_id) {
        return;
    }

    // الحصول على الفواتير غير المدفوعة مرتبة حسب الأقدمية
    $unpaidInvoices = Invoice::where('client_id', $clientAccount->client_id)
                            ->where('is_paid', false)
                            ->orderBy('created_at', 'asc')
                            ->get();

    $remainingAmount = $income->amount;

    foreach ($unpaidInvoices as $invoice) {
        if ($remainingAmount <= 0) break;

        // حساب المبلغ المدفوع سابقاً لهذه الفاتورة (باستثناء المدفوعات الملغاة)
        $paidAmount = PaymentsProcess::where('invoice_id', $invoice->id)
                                    ->where('payment_status', '!=', 5)
                                    ->sum('amount');

        // حساب المبلغ المتبقي للفاتورة
        $invoiceRemaining = $invoice->grand_total - $paidAmount;

        // المبلغ الذي سنطبقه على هذه الفاتورة
        $paymentAmount = min($remainingAmount, $invoiceRemaining);

        if ($paymentAmount > 0) {
            $isFullPayment = ($paidAmount + $paymentAmount) >= $invoice->grand_total;

            // إنشاء سجل الدفع الجديد
            PaymentsProcess::create([
                'invoice_id' => $invoice->id,
                'amount' => $paymentAmount,
                'payment_date' => $income->date,
                'Payment_method' => 'cash',
                'reference_number' => $income->code,
                'type' => 'client payments',
                'payment_status' => $isFullPayment ? 1 : 2,
                'employee_id' => $user->id,
                'notes' => 'دفع عبر سند القبض رقم ' . $income->code,
            ]);

            // تحديث حالة الفاتورة والمبلغ المتبقي
            $newPaidAmount = $paidAmount + $paymentAmount;
            $newDueValue = max(0, $invoice->grand_total - $newPaidAmount);

            $invoice->update([
                'advance_payment' => $newPaidAmount,
                'is_paid' => $isFullPayment,
                'payment_status' => $isFullPayment ? 1 : 2,
                'due_value' => $newDueValue
            ]);

            // إرسال إشعار بالسداد
            notifications::create([
                'user_id' => $user->id,
                'type' => 'invoice_payment',
                'title' => 'سداد فاتورة',
                'description' => 'تم سداد مبلغ ' . number_format($paymentAmount, 2) .
                                ' من فاتورة رقم ' . $invoice->code .
                                ' (المتبقي: ' . number_format($newDueValue, 2) . ')' .
                                ' عبر سند القبض رقم ' . $income->code,
            ]);

            // تخفيض المبلغ المتبقي للتوزيع
            $remainingAmount -= $paymentAmount;
        }
    }

    // إذا بقي مبلغ ولم تكفيه الفواتير
    if ($remainingAmount > 0) {
        notifications::create([
            'user_id' => $user->id,
            'type' => 'excess_payment',
            'title' => 'فائض في السداد',
            'description' => 'بقي مبلغ ' . number_format($remainingAmount, 2) .
                            ' من سند القبض رقم ' . $income->code .
                            ' لم يتم تطبيقه على أي فاتورة',
        ]);
    }
}
public function cancel($id)
{
    try {
        DB::beginTransaction();

        $user = Auth::user();
        $income = Receipt::findOrFail($id);

        // 1. استعادة رصيد الخزينة
        $treasury = Account::find($income->treasury_id);
        if ($treasury) {
            $treasury->balance -= $income->amount;
            $treasury->save();
        }

        // 2. استعادة رصيد العميل
        $clientAccount = Account::find($income->account_id);
        if ($clientAccount) {
            $clientAccount->balance += $income->amount;
            $clientAccount->save();
        }

        // 3. حذف المدفوعات المرتبطة بهذا السند
        $payments = PaymentsProcess::where('reference_number', $income->code)->get();
        foreach ($payments as $payment) {
            // استعادة حالة الفاتورة
            $invoice = Invoice::find($payment->invoice_id);
            if ($invoice) {
                $invoice->advance_payment -= $payment->amount;
                $invoice->due_value += $payment->amount;

                // إذا كانت الفاتورة أصبحت مدفوعة بالكامل بسبب هذا السند
                if ($invoice->is_paid && $invoice->advance_payment < $invoice->grand_total) {
                    $invoice->is_paid = false;
                    $invoice->payment_status = $invoice->advance_payment > 0 ? 2 : 0; // جزئي أو غير مدفوع
                }

                $invoice->save();
            }

            // حذف سجل الدفع
            $payment->delete();
        }

        // 4. حذف القيد المحاسبي
        $journalEntry = JournalEntry::where('reference_number', $income->code)->first();
        if ($journalEntry) {
            JournalEntryDetail::where('journal_entry_id', $journalEntry->id)->delete();
            $journalEntry->delete();
        }

        // 5. حذف الإشعارات المرتبطة
        notifications::where('description', 'like', '%سند قبض رقم ' . $income->code . '%')->delete();

        // 6. تسجيل النشاط
        ModelsLog::create([
            'type' => 'finance_log',
            'type_id' => $income->id,
            'type_log' => 'log',
            'description' => sprintf('تم إلغاء سند قبض رقم **%s** بقيمة **%d**', $income->code, $income->amount),
            'created_by' => auth()->id(),
        ]);

        // 7. حذف سند القبض
        $income->delete();

        DB::commit();

        return redirect()->route('incomes.index')->with('success', 'تم إلغاء سند القبض بنجاح واستعادة جميع الأرصدة!');
    } catch (\Exception $e) {
        DB::rollback();
        Log::error('خطأ في إلغاء سند قبض: ' . $e->getMessage());
        return back()->with('error', 'حدث خطأ أثناء الإلغاء: ' . $e->getMessage());
    }
}

private function createJournalEntry(Receipt $income, $user, $clientAccount, $treasury)
{
    $journalEntry = JournalEntry::create([
        'reference_number' => $income->code,
        'date' => $income->date,
        'description' => 'سند قبض رقم ' . $income->code,
        'status' => 1,
        'currency' => 'SAR',
        'client_id' => $clientAccount->client_id ?? null,
        'created_by_employee' => $user->id,
    ]);

    JournalEntryDetail::create([
        'journal_entry_id' => $journalEntry->id,
        'account_id' => $treasury->id,
        'description' => 'استلام مبلغ من سند قبض',
        'debit' => $income->amount,
        'credit' => 0,
        'is_debit' => true,
    ]);

    JournalEntryDetail::create([
        'journal_entry_id' => $journalEntry->id,
        'account_id' => $income->account_id,
        'description' => 'إيرادات من سند قبض',
        'debit' => 0,
        'credit' => $income->amount,
        'is_debit' => false,
    ]);
}

private function determineTreasury()
{
    $user = Auth::user();
    $treasury = null;

    if ($user && $user->employee_id) {
        $treasuryEmployee = TreasuryEmployee::where('employee_id', $user->employee_id)->first();
        if ($treasuryEmployee && $treasuryEmployee->treasury_id) {
            $treasury = Account::find($treasuryEmployee->treasury_id);
        }
    }

    if (!$treasury) {
        $treasury = Account::where('name', 'الخزينة الرئيسية')->first();
    }

    if (!$treasury) {
        throw new \Exception('لم يتم العثور على خزينة صالحة');
    }

    return $treasury;
}

private function updateReceiptData(Receipt $income, Request $request)
{
    $income->code = $request->input('code');
    $income->amount = $request->input('amount');
    $income->description = $request->input('description');
    $income->date = $request->input('date');
    $income->incomes_category_id = $request->input('incomes_category_id');
    $income->seller = $request->input('seller');
    $income->account_id = $request->input('account_id');
    $income->is_recurring = $request->has('is_recurring') ? 1 : 0;
    $income->recurring_frequency = $request->input('recurring_frequency');
    $income->end_date = $request->input('end_date');
    $income->tax1 = $request->input('tax1');
    $income->tax2 = $request->input('tax2');
    $income->tax1_amount = $request->input('tax1_amount');
    $income->tax2_amount = $request->input('tax2_amount');
    $income->cost_centers_enabled = $request->has('cost_centers_enabled') ? 1 : 0;

    if ($request->hasFile('attachments')) {
        $income->attachments = $this->UploadImage('assets/uploads/incomes', $request->file('attachments'));
    }
}

private function updateAccountBalances(Receipt $income, $oldAmount, $oldAccountId, $oldTreasuryId)
{
    $amountDifference = $income->amount - $oldAmount;

    // تحديث رصيد الحساب (العميل)
    if ($oldAccountId == $income->account_id) {
        $account = Account::find($income->account_id);
        if ($account) {
            $account->balance -= $amountDifference;
            $account->save();
        }
    } else {
        $oldAccount = Account::find($oldAccountId);
        if ($oldAccount) {
            $oldAccount->balance += $oldAmount;
            $oldAccount->save();
        }

        $newAccount = Account::find($income->account_id);
        if ($newAccount) {
            $newAccount->balance -= $income->amount;
            $newAccount->save();
        }
    }

    // تحديث الخزينة
    if ($oldTreasuryId == $income->treasury_id) {
        $treasury = Account::find($income->treasury_id);
        if ($treasury) {
            $treasury->balance += $amountDifference;
            $treasury->save();
        }
    } else {
        $oldTreasury = Account::find($oldTreasuryId);
        if ($oldTreasury) {
            $oldTreasury->balance -= $oldAmount;
            $oldTreasury->save();
        }

        $newTreasury = Account::find($income->treasury_id);
        if ($newTreasury) {
            $newTreasury->balance += $income->amount;
            $newTreasury->save();
        }
    }
}

private function updateJournalEntry(Receipt $income)
{
    $journalEntry = JournalEntry::where('reference_number', $income->code)->first();

    if ($journalEntry) {
        $journalEntry->date = $income->date;
        $journalEntry->description = 'تحديث سند قبض رقم ' . $income->code;
        $journalEntry->save();

        JournalEntryDetail::where('journal_entry_id', $journalEntry->id)->delete();

        JournalEntryDetail::create([
            'journal_entry_id' => $journalEntry->id,
            'account_id' => $income->treasury_id,
            'description' => 'استلام مبلغ من سند قبض (تعديل)',
            'debit' => $income->amount,
            'credit' => 0,
            'is_debit' => true,
        ]);

        JournalEntryDetail::create([
            'journal_entry_id' => $journalEntry->id,
            'account_id' => $income->account_id,
            'description' => 'إيرادات من سند قبض (تعديل)',
            'debit' => 0,
            'credit' => $income->amount,
            'is_debit' => false,
        ]);
    }
}

private function updateRelatedPaymentsAndInvoices(Receipt $income, $oldAmount)
{
    $clientAccount = Account::find($income->account_id);
    if (!$clientAccount || !$clientAccount->client_id) {
        return;
    }

    DB::beginTransaction();
    try {
        // 1. حذف المدفوعات القديمة المرتبطة بهذا السند فقط
        PaymentsProcess::where('reference_number', $income->code)->delete();

        // 2. إعادة حساب جميع المدفوعات للعميل (من الأحدث للأقدم)
        $allInvoices = Invoice::where('client_id', $clientAccount->client_id)
                             ->orderBy('created_at', 'desc') // ترتيب عكسي
                             ->get();

        // 3. إعادة تعيين جميع الفواتير
        foreach ($allInvoices as $invoice) {
            $invoice->update([
                'advance_payment' => 0,
                'is_paid' => false,
                'payment_status' => 0,
                'due_value' => $invoice->grand_total
            ]);
        }

        // 4. إعادة تطبيق جميع سندات القبض حسب الأقدمية (من الأقدم للأحدث)
        $allReceipts = Receipt::where('account_id', $income->account_id)
                            ->orderBy('created_at', 'asc')
                            ->get();

        foreach ($allReceipts as $receipt) {
            $this->applySingleReceiptToInvoices($receipt, true); // true للتطبيق من الأحدث
        }

        DB::commit();
    } catch (\Exception $e) {
        DB::rollback();
        Log::error('Error updating invoices: '.$e->getMessage());
        throw $e;
    }
}
public function edit($id)
{
    $user = Auth::user();

    // التحقق من أن المستخدم ليس موظف فقط
    if ($user->role == 'employee') {
        return abort(403, 'ليس لديك صلاحية الوصول إلى هذه الصفحة.');
    }

    $income = Receipt::findOrFail($id);

    $incomes_categories = ReceiptCategory::select('id', 'name')->get();
    $treas = Treasury::select('id', 'name')->get();
    $accounts = Account::all();
    $account_storage = Account::where('parent_id', 13)->get();
    $taxs = TaxSitting::all();

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


private function applySingleReceiptToInvoices(Receipt $receipt, $reverseOrder = false)
{
    $clientAccount = Account::find($receipt->account_id);
    $unpaidInvoices = Invoice::where('client_id', $clientAccount->client_id)
                           ->where('is_paid', false)
                           ->orderBy('created_at', $reverseOrder ? 'desc' : 'asc') // ترتيب حسب الطلب
                           ->get();

    $remainingAmount = $receipt->amount;
    $user = Auth::user();

    foreach ($unpaidInvoices as $invoice) {
        if ($remainingAmount <= 0) break;

        $paidAmount = PaymentsProcess::where('invoice_id', $invoice->id)
                                    ->where('payment_status', '!=', 5)
                                    ->sum('amount');

        $invoiceRemaining = $invoice->grand_total - $paidAmount;
        $paymentAmount = min($remainingAmount, $invoiceRemaining);

        if ($paymentAmount > 0) {
            $isFullPayment = ($paidAmount + $paymentAmount) >= $invoice->grand_total;

            PaymentsProcess::updateOrCreate(
                [
                    'invoice_id' => $invoice->id,
                    'reference_number' => $receipt->code
                ],
                [
                    'amount' => $paymentAmount,
                    'payment_date' => $receipt->date,
                    'Payment_method' => 'cash',
                    'type' => 'client payments',
                    'payment_status' => $isFullPayment ? 1 : 2,
                    'employee_id' => $user->id,
                    'notes' => 'دفع عبر سند القبض رقم '.$receipt->code
                ]
            );

            $newPaidAmount = $paidAmount + $paymentAmount;
            $newDueValue = $invoice->grand_total - $newPaidAmount;

            $invoice->update([
                'advance_payment' => $newPaidAmount,
                'is_paid' => $isFullPayment,
                'payment_status' => $isFullPayment ? 1 : 2,
                'due_value' => max(0, $newDueValue)
            ]);

            $remainingAmount -= $paymentAmount;
        }
    }
}

    public function show($id)
    {
        $income = Receipt::findOrFail($id);
        return view('finance.incomes.show', compact('income'));
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
