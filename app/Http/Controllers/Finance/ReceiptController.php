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
        $validatedData = $request->validate([
            'amount' => 'required|numeric',
            'description' => 'required|string',
            'code' => 'required|string|unique:receipts,code,' . $id,
            'account_id' => 'required|exists:chart_of_accounts,id',
            'treasury_id' => 'required|exists:treasuries,id',
            'employee_id' => 'required|exists:employees,employee_id',
            'client_id' => 'required|exists:clients,id',
            'date' => 'required|date',
            'currency' => 'required|string',
            'status' => 'required|in:draft,approved,cancelled',
            'notes' => 'nullable|string',
            'reference' => 'nullable|string',
        ]);

        $receipt = Receipt::findOrFail($id);
        $receipt->update($validatedData);

        return redirect()->route('receipts.index')->with('success', 'تم تحديث السند بنجاح');
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
