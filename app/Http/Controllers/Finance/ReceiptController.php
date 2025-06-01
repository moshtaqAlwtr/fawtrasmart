<?php
namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Receipt;
use App\Models\PaymentVoucherDetail;
use App\Models\Employee;
use App\Models\Transaction;
use App\Models\ChartOfAccount;
use App\Models\Treasury;
use App\Models\JournalEntry;
use Carbon\Carbon;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class ReceiptController extends Controller
{
    /**
     * عرض جميع السندات
     */
    public function index(Request $request)
    {
        // بداية الاستعلام
        $query = Receipt::query();

        // تحقق إذا كان هناك قيمة مرفقة بـ 'id' في الطلب
        if ($request->has('payment_id') && $request->input('payment_id') != '') {
            $query->where('payment_id', $request->input('payment_id'));  // تعديل هنا
        }

        // أضف شروط أخرى إذا كنت ترغب
        if ($request->has('category') && $request->input('category') != '') {
            $query->where('category', $request->input('category'));
        }

        if ($request->has('status') && $request->input('status') != '') {
            $query->where('status', $request->input('status'));
        }

        if ($request->has('date') && $request->input('date') != '') {
            $query->whereDate('date', $request->input('date'));
        }

        // تنفيذ الاستعلام وجلب النتائج
        $recentReceipts = $query->with(['treasury', 'employee', 'account', 'details'])->get();

        // بيانات أخرى
        $accounts = ChartOfAccount::all();
        $clients = Client::all();
        $employees = Employee::all();
        $stats = [
            'total_receipts' => Receipt::sum('amount'), // المجموع الإجمالي لجميع السندات
            'last_7_days' => Receipt::where('date', '>=', now()->subDays(7))->sum('amount'),
            'last_30_days' => Receipt::where('date', '>=', now()->subDays(30))->sum('amount'),
            'last_365_days' => Receipt::where('date', '>=', now()->subDays(365))->sum('amount'),
        ];

        // تحقق من البيانات


        // تجهيز محتوى الصفحة
        $content = view('layouts.nav-slider-route', [
            'recentReceipts' => $recentReceipts,
            'accounts' => $accounts,
            'employees' => $employees,
            'stats' => $stats
        ])->render();

        // إرجاع العرض مع البيانات
        return view('layouts.nav-slider-route', [
            'page' => 'actions_page',

        ]);
    }


    /**
     * عرض نموذج إنشاء سند جديد
     */
    public function create()
    {
        $employees = Employee::all();
        $treasuries = Treasury::all();
        $accounts = ChartOfAccount::all();
        $clients = Client::all();

        return view('layouts.nav-slider-route', [
            'page' => 'add_receipt',

                'employees' => $employees,
                'treasuries' => $treasuries,
                'accounts' => $accounts,
                'clients' => $clients

        ]);
    }

    /**
     * حفظ السند الجديد
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validatedData = $request->validate([
                'code' => 'required|string|unique:receipts,code',
                'amount' => 'required|numeric|min:0',
                'currency' => 'required|string|in:SAR,USD,EUR',
                'date' => 'required|date',
                'treasury_id' => 'required|exists:treasuries,id',
                'client_id' => 'required|exists:clients,id',
                'employee_id' => 'required|exists:employees,employee_id',
                'account_id' => 'required|exists:chart_of_accounts,id'
            ]);

            $conversionRates = ['USD' => 3.75, 'EUR' => 4.12, 'SAR' => 1];
            $amountInSAR = $validatedData['amount'] * $conversionRates[$validatedData['currency']];

            Receipt::create([
                'code' => $validatedData['code'],
                'amount' => $amountInSAR,
                'currency' => $validatedData['currency'],
                'date' => $validatedData['date'],
                'treasury_id' => $validatedData['treasury_id'],
                'client_id' => $validatedData['client_id'],
                'employee_id' => $validatedData['employee_id'],
                'account_id' => $validatedData['account_id'],
                'status' => 'draft'
            ]);

            DB::commit();
            return redirect()->route('actions_page')->with('success', 'تم إنشاء السند بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'حدث خطأ: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * عرض تفاصيل السند
     */
    public function show($id)
    {
        $receipt = Receipt::findOrFail($id);
        $employee = $receipt->employee;
        $treasury = $receipt->treasury;
        $account = $receipt->account;
        $client = $receipt->client;

        return view('layouts.nav-slider-route', [
            'page' => 'show_receipt',
            'content' => view('fawtra.14-Finance_Module.show_receipt')->with([
                'receipt' => $receipt,
                'employee' => $employee,
                'treasury' => $treasury,
                'account' => $account,
                'client' => $client
            ])->render()
        ]);
    }

    /**
     * عرض نموذج تعديل السند
     */
    public function edit($id)
    {
        $receipt = Receipt::findOrFail($id);
        $paymentVoucherDetails = PaymentVoucherDetail::all();
        $employees = Employee::all();
        $treasuries = Treasury::all();
        $accounts = ChartOfAccount::all();
        $clients = Client::all();

        return view('layouts.nav-slider-route', [
            'page' => 'edit_receipt',
            'content' => view('fawtra.14-Finance_Module.edit_receipt')->with([
                'receipt' => $receipt,
                'paymentVoucherDetails' => $paymentVoucherDetails,
                'employees' => $employees,
                'treasuries' => $treasuries,
                'accounts' => $accounts,
                'clients' => $clients
            ])->render()
        ]);
    }

    /**
     * تحديث السند
     */
    public function update(Request $request, $id)
{
    try {
        DB::beginTransaction();

        // التحقق من البيانات المدخلة
        $validatedData = $request->validate([
            'code' => 'required|string|unique:receipts,code,'.$id,
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'incomes_category_id' => 'required|exists:incomes_categories,id',
            'account_id' => 'required|exists:accounts,id',
            'treasury_id' => 'required|exists:accounts,id',
            'description' => 'nullable|string',
            'seller' => 'nullable|string',
            'tax1' => 'nullable|numeric|min:0|max:100',
            'tax2' => 'nullable|numeric|min:0|max:100',
            'tax1_amount' => 'nullable|numeric|min:0',
            'tax2_amount' => 'nullable|numeric|min:0',
            'is_recurring' => 'nullable|boolean',
            'recurring_frequency' => 'nullable|string',
            'end_date' => 'nullable|date',
            'cost_centers_enabled' => 'nullable|boolean',
            'attachments' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // البحث عن سند القبض المطلوب تحديثه
        $income = Receipt::findOrFail($id);

        // حفظ القيم القديمة للقيود المحاسبية
        $oldAmount = $income->amount;
        $oldAccountId = $income->account_id;
        $oldTreasuryId = $income->treasury_id;

        // تحديث الحقول الأساسية
        $income->code = $validatedData['code'];
        $income->amount = $validatedData['amount'];
        $income->description = $validatedData['description'] ?? '';
        $income->date = $validatedData['date'];
        $income->incomes_category_id = $validatedData['incomes_category_id'];
        $income->seller = $validatedData['seller'] ?? '';
        $income->account_id = $validatedData['account_id'];
        $income->treasury_id = $validatedData['treasury_id'];
        $income->is_recurring = $validatedData['is_recurring'] ?? 0;
        $income->recurring_frequency = $validatedData['recurring_frequency'] ?? null;
        $income->end_date = $validatedData['end_date'] ?? null;
        $income->tax1 = $validatedData['tax1'] ?? 0;
        $income->tax2 = $validatedData['tax2'] ?? 0;
        $income->tax1_amount = $validatedData['tax1_amount'] ?? 0;
        $income->tax2_amount = $validatedData['tax2_amount'] ?? 0;
        $income->cost_centers_enabled = $validatedData['cost_centers_enabled'] ?? 0;

        // معالجة المرفقات إذا تم تحميل ملف جديد
        if ($request->hasFile('attachments')) {
            // حذف المرفق القديم إذا كان موجوداً
            if ($income->attachments) {
                Storage::delete('assets/uploads/incomes/' . $income->attachments);
            }
            $income->attachments = $this->UploadImage('assets/uploads/incomes', $request->file('attachments'));
        }

        // حفظ التحديثات
        $income->save();

        // تحديث أرصدة الحسابات (التراجع عن القيود القديمة)
        $oldAccount = Account::find($oldAccountId);
        $oldTreasury = Account::find($oldTreasuryId);

        if ($oldAccount) {
            $oldAccount->balance += $oldAmount; // التراجع عن الخصم القديم
            $oldAccount->save();
        }

        if ($oldTreasury) {
            $oldTreasury->balance -= $oldAmount; // التراجع عن الإضافة القديمة
            $oldTreasury->save();
        }

        // تحديث أرصدة الحسابات الجديدة
        $newAccount = Account::find($income->account_id);
        $newTreasury = Account::find($income->treasury_id);

        if ($newAccount) {
            $newAccount->balance -= $income->amount; // خصم المبلغ الجديد
            $newAccount->save();
        }

        if ($newTreasury) {
            $newTreasury->balance += $income->amount; // إضافة المبلغ الجديد
            $newTreasury->save();
        }

        // البحث عن القيود المحاسبية القديمة وتحديثها
        $journalEntry = JournalEntry::where('reference_number', $income->code)->first();

        if ($journalEntry) {
            // تحديث معلومات القيد الأساسي
            $journalEntry->update([
                'date' => $income->date,
                'description' => 'سند قبض رقم ' . $income->code,
            ]);

            // تحديث تفاصيل القيد (حساب الخزينة)
            JournalEntryDetail::where('journal_entry_id', $journalEntry->id)
                ->where('is_debit', true)
                ->update([
                    'account_id' => $income->treasury_id,
                    'debit' => $income->amount,
                    'description' => 'استلام مبلغ من سند قبض'
                ]);

            // تحديث تفاصيل القيد (حساب العميل)
            JournalEntryDetail::where('journal_entry_id', $journalEntry->id)
                ->where('is_debit', false)
                ->update([
                    'account_id' => $income->account_id,
                    'credit' => $income->amount,
                    'description' => 'إيرادات من سند قبض'
                ]);
        }

        // إرسال إشعار بالتحديث
        $user = auth()->user();
        notifications::create([
            'user_id' => $user->id,
            'type' => 'Receipt',
            'title' => $user->name . ' قام بتحديث سند قبض',
            'description' => 'تم تحديث سند قبض رقم ' . $income->code . ' بقيمة ' . number_format($income->amount, 2) . ' ر.س',
        ]);

        // تسجيل النشاط في السجل
        ModelsLog::create([
            'type' => 'finance_log',
            'type_id' => $income->id,
            'type_log' => 'log',
            'description' => sprintf('تم تحديث سند قبض رقم %s بقيمة %s', $income->code, number_format($income->amount, 2)),
            'created_by' => auth()->id(),
        ]);

        DB::commit();

        return redirect()->route('incomes.index')->with('success', 'تم تحديث سند القبض بنجاح!');

    } catch (\Exception $e) {
        DB::rollback();
        Log::error('خطأ في تحديث سند قبض: ' . $e->getMessage());
        return back()
            ->with('error', 'حدث خطأ أثناء تحديث سند القبض: ' . $e->getMessage())
            ->withInput();
    }
}

    /**
     * حذف السند
     */
    public function destroy($id)
    {
        $receipt = Receipt::findOrFail($id);
        $receipt->delete();

        return redirect()->route('receipts.index')->with('success', 'تم حذف السند بنجاح!');
    }

    // --- إضافة دوال مالية جديدة --- //

    /**

     * عرض المدفوعات المالية
     */
    public function showPayments()
    {
        $payments = Transaction::where('type', 'payment')->get();
        return view('fawtra.14fcdcdc.account.payments.index', compact('payments'));
    }

    /**
     * إضافة معاملة دفع جديدة
     */
    public function addPayment(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric',
            'payment_method' => 'required|string',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $payment = new Transaction();
        $payment->amount = $request->amount;
        $payment->payment_method = $request->payment_method;
        $payment->date = $request->date;
        $payment->description = $request->description;
        $payment->type = 'payment';
        $payment->save();

        return redirect()->route('payments.index')->with('success', 'تم إضافة الدفع بنجاح!');
    }

    /**
     * عرض المعاملات المالية
     */
    public function showTransactions()
    {
        $transactions = Transaction::all();
        return view('fawtra.14fcdcdc.account.transactions.index', compact('transactions'));
    }

    /**
     * إنشاء تحويل مالي
     */
    public function createTransfer(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric',
            'from_account' => 'required|string',
            'to_account' => 'required|string',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $transaction = new Transaction();
        $transaction->amount = $request->amount;
        $transaction->from_account = $request->from_account;
        $transaction->to_account = $request->to_account;
        $transaction->date = $request->date;
        $transaction->description = $request->description;
        $transaction->type = 'transfer';
        $transaction->save();

        return redirect()->route('transactions.index')->with('success', 'تم إجراء التحويل المالي بنجاح!');
    }

    /**
     * عرض تقرير التدقيق المالي
     */
    public function showFinancialAudit()
    {
        $transactions = Transaction::all();
        $payments = Transaction::where('type', 'payment')->get();
        $receipts = Receipt::all();

        return view('fawtra.14fcdcdc.account.audit.index', compact('transactions', 'payments', 'receipts'));
    }
    public function getStatistics()
    {
        // حساب التواريخ
        $last7Days = Carbon::now()->subDays(7);
        $last30Days = Carbon::now()->subDays(30);
        $last365Days = Carbon::now()->subDays(365);

        // جلب البيانات من جدول سندات الصرف
        $stats = [
            'last_7_days' => Receipt::where('date', '>=', $last7Days)->sum('amount'),
            'last_30_days' => Receipt::where('date', '>=', $last30Days)->sum('amount'),
            'last_365_days' => Receipt::where('date', '>=', $last365Days)->sum('amount'),
        ];

        // إعادة البيانات إلى الواجهة
        return view('layouts.nav-slider-route')
            ->with('page', 'actions_page') // الصفحة التي سيتم عرض البيانات فيها
            ->with('stats', $stats);
    }

}
