<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sales\ClientPaymentRequest;
use App\Models\Account;
use App\Models\Employee;
use App\Models\Installment;
use App\Models\Invoice;
use App\Models\JournalEntry;
use App\Models\JournalEntryDetail;
use App\Models\PaymentMethod;
use App\Models\PaymentsProcess;
use App\Models\PurchaseInvoice;
use App\Models\Treasury;
use App\Models\User;

use App\Models\TreasuryEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentProcessController extends Controller
{
    public function index(Request $request)
    {
        // استعلام أساسي لجميع البيانات
        $query = PaymentsProcess::with(['invoice', 'employee', 'client', 'purchase', 'treasury']);

        // البحث الأساسي
        if ($request->has('invoice_number') && $request->invoice_number != '') {
            $query->whereHas('invoice', function($q) use ($request) {
                $q->where('code', 'like', '%' . $request->invoice_number . '%');
            });
        }

        if ($request->has('payment_number') && $request->payment_number != '') {
            $query->where('payment_number', 'like', '%' . $request->payment_number . '%');
        }

        if ($request->has('customer') && $request->customer != '') {
            $query->where('employee_id', $request->customer);
        }

        // البحث المتقدم
        if ($request->has('payment_status') && $request->payment_status != '') {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->has('from_date') && $request->from_date != '') {
            $query->where('payment_date', '>=', $request->from_date);
        }

        if ($request->has('to_date') && $request->to_date != '') {
            $query->where('payment_date', '<=', $request->to_date);
        }

        if ($request->has('identifier') && $request->identifier != '') {
            $query->where('reference_number', 'like', '%' . $request->identifier . '%');
        }

        if ($request->has('transfer_id') && $request->transfer_id != '') {
            $query->where('reference_number', 'like', '%' . $request->transfer_id . '%');
        }

        if ($request->has('total_greater_than') && $request->total_greater_than != '') {
            $query->where('amount', '>', $request->total_greater_than);
        }

        if ($request->has('total_less_than') && $request->total_less_than != '') {
            $query->where('amount', '<', $request->total_less_than);
        }

        if ($request->has('custom_field') && $request->custom_field != '') {
            $query->where('notes', 'like', '%' . $request->custom_field . '%');
        }

        if ($request->has('invoice_origin') && $request->invoice_origin != '') {
            $query->whereHas('invoice', function($q) use ($request) {
                $q->where('origin', $request->invoice_origin);
            });
        }

        if ($request->has('collected_by') && $request->collected_by != '') {
            $query->where('employee_id', $request->collected_by);
        }

        // تنفيذ الاستعلام مع Pagination لعرض 25 عنصر في الصفحة
        $payments = $query->paginate(25);
        $employees = Employee::all();

        return view('sales.payment.index', compact('payments', 'employees'));
    }
    public function indexPurchase(Request $request)
    {
        $employees = Employee::all();

        $query = PaymentsProcess::with(['purchase', 'employee']);

        // رقم الفاتورة
        if ($request->filled('invoice_number')) {
            $query->whereHas('purchase', function($q) use ($request) {
                $q->where('code', 'like', '%' . $request->invoice_number . '%');
            });
        }

        // رقم عملية الدفع
        if ($request->filled('payment_number')) {
            $query->where('payment_number', 'like', '%' . $request->payment_number . '%');
        }

        // العميل
        if ($request->filled('customer_id')) {
            $query->whereHas('purchase', function($q) use ($request) {
                $q->where('supplier_id', $request->customer_id);
            });
        }

        // وسيلة دفع
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // تخصيص التاريخ
        if ($request->filled('date_type')) {
            switch($request->date_type) {
                case '1': // شهرياً
                    $query->whereMonth('date', now()->month);
                    break;
                case '0': // أسبوعياً
                    $query->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case '2': // يومياً
                    $query->whereDate('date', now());
                    break;
            }
        }

        // من تاريخ - إلى تاريخ
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('date', [$request->from_date, $request->to_date]);
        }

        // الاجمالي اكبر من
        if ($request->filled('total_min')) {
            $query->where('amount', '>=', $request->total_min);
        }

        // الاجمالي اصغر من
        if ($request->filled('total_max')) {
            $query->where('amount', '<=', $request->total_max);
        }

        // حالة الدفع
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // تاريخ الانشاء - تخصيص
        if ($request->filled('creation_date_type')) {
            switch($request->creation_date_type) {
                case '1': // شهرياً
                    $query->whereMonth('created_at', now()->month);
                    break;
                case '0': // أسبوعياً
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case '2': // يومياً
                    $query->whereDate('created_at', now());
                    break;
            }
        }

        // تاريخ الانشاء - من تاريخ إلى تاريخ
        if ($request->filled('creation_from_date') && $request->filled('creation_to_date')) {
            $query->whereBetween('created_at', [$request->creation_from_date, $request->creation_to_date]);
        }

        // منشئ الفاتورة
        if ($request->filled('created_by')) {
            $query->where('created_by', $request->created_by);
        }

        $payments = $query->paginate(25);


        return view('purchases.supplier_payments.index', compact('payments', 'employees'));
    }
    public function create($id, $type = 'invoice') // $type يحدد إذا كان الدفع لفاتورة أو قسط
    {
        if ($type === 'installment') {
            // إذا كانت العملية لقسط، احصل على تفاصيل القسط
            $installment = Installment::with('invoice')->findOrFail($id);
            $amount = $installment->amount; // مبلغ القسط
            $invoiceId = $installment->invoice->id; // معرف الفاتورة
        } else {
            // إذا كانت العملية لفاتورة، احصل على تفاصيل الفاتورة
            $invoice = Invoice::findOrFail($id);
            $amount = $invoice->grand_total; // قيمة الفاتورة
            $invoiceId = $invoice->id; // معرف الفاتورة
        }

        // احصل على البيانات الأخرى اللازمة مثل الخزائن والموظفين
        $treasury = Treasury::all();
        $employees = Employee::all();
        $payments = PaymentMethod::where('type','normal')->where('status','active')->get();
        
          $mainTreasuryAccount = null;
        $user = Auth::user();

        if ($user && $user->employee_id) {
            // البحث عن الخزينة المرتبطة بالموظف
            $treasuryEmployee = TreasuryEmployee::where('employee_id', $user->employee_id)->first();

            if ($treasuryEmployee && $treasuryEmployee->treasury_id) {
                // إذا كان الموظف لديه خزينة مرتبطة
                $mainTreasuryAccount = Account::where('id', $treasuryEmployee->treasury_id)->first();
            } else {
                // إذا لم يكن لدى الموظف خزينة مرتبطة، استخدم الخزينة الرئيسية
                $mainTreasuryAccount = Account::where('name', 'الخزينة الرئيسية')->first();
            }
        } else {
            // إذا لم يكن المستخدم موجودًا أو لم يكن لديه employee_id، استخدم الخزينة الرئيسية
            $mainTreasuryAccount = Account::where('name', 'الخزينة الرئيسية')->first();
        }

          $user = User::find(auth()->user()->id);
        return view('sales.payment.create', compact('invoiceId', 'payments', 'amount', 'treasury', 'employees', 'type','mainTreasuryAccount','user'));
    }
public function store(ClientPaymentRequest $request)
{
    try {
        DB::beginTransaction();

        // استرجاع البيانات المصادق عليها
        $data = $request->validated();

        // التحقق من وجود الفاتورة وجلب تفاصيلها
        $invoice = Invoice::findOrFail($data['invoice_id']);

        // حساب إجمالي المدفوعات السابقة
        $totalPreviousPayments = PaymentsProcess::where('invoice_id', $invoice->id)
            ->where('type', 'client payments')
            ->where('payment_status', '!=', 5) // استثناء المدفوعات الفاشلة
            ->sum('amount');

        // حساب المبلغ المتبقي للدفع
        $remainingAmount = $invoice->grand_total - $totalPreviousPayments;

        // التحقق من أن مبلغ الدفع لا يتجاوز المبلغ المتبقي
        if ($data['amount'] > $remainingAmount) {
            return back()
                ->with('error', 'مبلغ الدفع يتجاوز المبلغ المتبقي للفاتورة. المبلغ المتبقي هو: ' . number_format($remainingAmount, 2))
                ->withInput();
        }

        // تعيين حالة الدفع الافتراضية كمسودة
        $payment_status = 3; // مسودة

        // تحديد حالة الدفع بناءً على المبلغ المدفوع والمبلغ المتبقي
        $newTotalPayments = $totalPreviousPayments + $data['amount'];

        if ($newTotalPayments >= $invoice->grand_total) {
            $payment_status = 1; // مكتمل
            $invoice->is_paid = true;
            $invoice->due_value = 0;
        } else {
            $payment_status = 2; // غير مكتمل
            $invoice->is_paid = false;
            $invoice->due_value = $invoice->grand_total - $newTotalPayments;
        }
      
        // إذا تم تحديد حالة دفع معينة في الطلب
        if ($request->has('payment_status')) {
            switch ($request->payment_status) {
                case 4: // تحت المراجعة
                    $payment_status = 4;
                    $invoice->is_paid = false;
                    break;
                case 5: // فاشلة
                    $payment_status = 5;
                    $invoice->is_paid = false;
                    // إعادة حساب المبلغ المتبقي بدون احتساب هذه الدفعة
                    $invoice->due_value = $invoice->grand_total - $totalPreviousPayments;
                    break;
            }
        }

        // إضافة البيانات الإضافية للدفعة
        $data['type'] = 'client payments';
        $data['created_by'] = Auth::id();
        $data['payment_status'] = $payment_status;

        // معالجة المرفقات
        if ($request->hasFile('attachments')) {
            $file = $request->file('attachments');
            if ($file->isValid()) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('assets/uploads/'), $filename);
                $data['attachments'] = $filename;
            }
        }

        // تحديد الخزينة المستهدفة بناءً على الموظف
        $mainTreasuryAccount = null;
        $user = Auth::user();

        if ($user && $user->employee_id) {
            // البحث عن الخزينة المرتبطة بالموظف
            $treasuryEmployee = TreasuryEmployee::where('employee_id', $user->employee_id)->first();

            if ($treasuryEmployee && $treasuryEmployee->treasury_id) {
                // إذا كان الموظف لديه خزينة مرتبطة
                $mainTreasuryAccount = Account::where('id', $treasuryEmployee->treasury_id)->first();
            } else {
                // إذا لم يكن لدى الموظف خزينة مرتبطة، استخدم الخزينة الرئيسية
                $mainTreasuryAccount = Account::where('name', 'الخزينة الرئيسية')->first();
            }
        } else {
            // إذا لم يكن المستخدم موجودًا أو لم يكن لديه employee_id، استخدم الخزينة الرئيسية
            $mainTreasuryAccount = Account::where('name', 'الخزينة الرئيسية')->first();
        }

        // إذا لم يتم العثور على خزينة، توقف العملية وأظهر خطأ
        if (!$mainTreasuryAccount) {
            throw new \Exception('لا توجد خزينة متاحة. يرجى التحقق من إعدادات الخزينة.');
        }

        // إنشاء سجل الدفع
        $payment = PaymentsProcess::create($data);

        // تحديث رصيد الخزينة
        $mainTreasuryAccount->balance += $data['amount'];
        $mainTreasuryAccount->save();

        // تحديث المبلغ المدفوع في الفاتورة
        $invoice->advance_payment = $newTotalPayments;
        $invoice->payment_status = $payment_status;
        $invoice->save();

        // إنشاء قيد محاسبي للدفعة
        $journalEntry = JournalEntry::create([
            'reference_number' => $payment->reference_number ?? $invoice->code,
            'date' => $data['payment_date'] ?? now(),
            'description' => 'دفعة للفاتورة رقم ' . $invoice->code,
            'status' => 1,
            'currency' => 'SAR',
            'client_id' => $invoice->client_id,
            'invoice_id' => $invoice->id,
            'created_by_employee' => Auth::id(),
        ]);

        // إضافة تفاصيل القيد المحاسبي للدفعة
        // 1. حساب الصندوق/البنك (مدين)
        JournalEntryDetail::create([
            'journal_entry_id' => $journalEntry->id,
            'account_id' => $mainTreasuryAccount->id,
            'description' => 'استلام دفعة نقدية',
            'debit' => $data['amount'],
            'credit' => 0,
            'is_debit' => true,
        ]);

        // 2. حساب العميل (دائن)
        $clientaccounts = Account::where('client_id', $invoice->client_id)->first();
        JournalEntryDetail::create([
            'journal_entry_id' => $journalEntry->id,
            'account_id' => $clientaccounts->id,
            'description' => 'دفعة من العميل',
            'debit' => 0,
            'credit' => $data['amount'],
            'is_debit' => false,
        ]);

        if ($clientaccounts) {
            $clientaccounts->balance -= $newTotalPayments; // المبلغ الكلي (المبيعات + الضريبة)
            $clientaccounts->save();
        }
        DB::commit();

        // إعداد رسالة النجاح مع حالة الدفع
        $paymentStatusText = match($payment_status) {
            1 => 'مكتمل',
            2 => 'غير مكتمل',
            3 => 'مسودة',
            4 => 'تحت المراجعة',
            5 => 'فاشلة',
            default => 'غير معروف'
        };

        $successMessage = sprintf(
            'تم تسجيل عملية الدفع بنجاح. المبلغ المدفوع: %s، المبلغ المتبقي: %s - حالة الدفع: %s',
            number_format($data['amount'], 2),
            number_format($invoice->due_value, 2),
            $paymentStatusText
        );

        return redirect()->route('paymentsClient.index')->with('success', $successMessage);

    } catch (\Exception $e) {
        DB::rollback();
        Log::error('خطأ في تسجيل عملية الدفع: ' . $e->getMessage());
        return back()
            ->with('error', 'حدث خطأ أثناء تسجيل عملية الدفع: ' . $e->getMessage())
            ->withInput();
    }
}

    // دالة مساعدة لإنشاء القيد المحاسبي للدفعة
    private function createPaymentJournalEntry($invoice, $amount)
    {
        // إنشاء قيد محاسبي للدفعة
        $journalEntry = JournalEntry::create([
            'reference_number' => 'PAY-' . time(),
            'date' => now(),
            'description' => 'دفعة للفاتورة رقم ' . $invoice->code,
            'status' => 1,
            'currency' => 'SAR',
            'client_id' => $invoice->client_id,
            'invoice_id' => $invoice->id,
            'created_by_employee' => Auth::id(),
        ]);

        // إضافة تفاصيل القيد
        // مدين - حساب النقدية
        JournalEntryDetail::create([
            'journal_entry_id' => $journalEntry->id,
            'account_id' => $invoice->account_id, // حساب الصندوق أو البنك
            'description' => 'دفعة نقدية',
            'debit' => $amount,
            'credit' => 0,
            'is_debit' => true,
        ]);

        // دائن - حساب العميل
        JournalEntryDetail::create([
            'journal_entry_id' => $journalEntry->id,
            'account_id' => $invoice->client->account_id,
            'description' => 'تسديد دفعة',
            'debit' => 0,
            'credit' => $amount,
            'is_debit' => false,
        ]);
    }
    public function getInvoiceDetails($invoice_id)
{
    try {
        $invoice = PurchaseInvoice::findOrFail($invoice_id);

        // حساب المبلغ المدفوع والمتبقي
        $totalPayments = PaymentsProcess::where('invoice_id', $invoice->id)
            ->where('type', 'client payments')
            ->sum('amount');

        $remainingAmount = $invoice->grand_total - $totalPayments;

        return response()->json([
            'success' => true,
            'data' => [
                'invoice' => $invoice,
                'total_paid' => $totalPayments,
                'remaining_amount' => $remainingAmount,
                'client_name' => $invoice->client->name ?? 'غير محدد',
                'invoice_date' => $invoice->invoice_date,
                'grand_total' => $invoice->grand_total,
                'payment_status' => $invoice->payment_status
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'حدث خطأ أثناء جلب تفاصيل الفاتورة: ' . $e->getMessage()
        ], 500);
    }
}


public function storePurchase(ClientPaymentRequest $request)
{
    try {
        DB::beginTransaction();

        // استرجاع البيانات المصادق عليها
        $data = $request->validated();

        // التحقق من وجود الفاتورة وجلب تفاصيلها
        $invoice = PurchaseInvoice::findOrFail($data['invoice_id']);

        // ** التحقق المسبق من حالة الفاتورة **
        if ($invoice->is_paid) {
            return back()
                ->with('error', 'لا يمكن إضافة دفعة. الفاتورة مدفوعة بالكامل بالفعل.')
                ->withInput();
        }

        // حساب إجمالي المدفوعات السابقة
        $totalPreviousPayments = PaymentsProcess::where('invoice_id', $invoice->id)
            ->where('type', 'purchase payments')
            ->where('payment_status', '!=', 5) // استثناء المدفوعات الفاشلة
            ->sum('amount');

        // حساب المبلغ المتبقي للدفع
        $remainingAmount = $invoice->grand_total - $totalPreviousPayments;

        // التحقق من أن مبلغ الدفع لا يتجاوز المبلغ المتبقي
        if ($data['amount'] > $remainingAmount) {
            return back()
                ->with('error', 'مبلغ الدفع يتجاوز المبلغ المتبقي للفاتورة. المبلغ المتبقي هو: ' . number_format($remainingAmount, 2))
                ->withInput();
        }

        // تعيين حالة الدفع الافتراضية كمسودة
        $payment_status = 3; // مسودة

        // تحديد حالة الدفع بناءً على المبلغ المدفوع والمبلغ المتبقي
        $newTotalPayments = $totalPreviousPayments + $data['amount'];

        if ($newTotalPayments >= $invoice->grand_total) {
            $payment_status = 1; // مكتمل
            $invoice->is_paid = true;
            $invoice->due_value = 0;
        } else {
            $payment_status = 2; // غير مكتمل
            $invoice->is_paid = false;
            $invoice->due_value = $invoice->grand_total - $newTotalPayments;
        }

        // إضافة البيانات الإضافية للدفعة
        $data['type'] = 'purchase payments';
        $data['created_by'] = Auth::id();
        $data['payment_status'] = $payment_status;

        // معالجة المرفقات
        if ($request->hasFile('attachments')) {
            $file = $request->file('attachments');
            if ($file->isValid()) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('assets/uploads/'), $filename);
                $data['attachments'] = $filename;
            }
        }

        // إنشاء سجل الدفع
        $payment = PaymentsProcess::create($data);

        // تحديث المبلغ المدفوع في الفاتورة
        $invoice->advance_payment = $newTotalPayments;
        $invoice->payment_status = $payment_status;
        $invoice->save();

        // إنشاء قيد محاسبي للدفعة
        $this->createPaymentJournalEntry($invoice, $data['amount']);

        DB::commit();

        // إعداد رسالة النجاح مع حالة الدفع
        $paymentStatusText = match($payment_status) {
            1 => 'مكتمل',
            2 => 'غير مكتمل',
            3 => 'مسودة',
            4 => 'تحت المراجعة',
            5 => 'فاشلة',
            default => 'غير معروف'
        };

        $successMessage = sprintf(
            'تم تسجيل عملية الدفع بنجاح. المبلغ المدفوع: %s، المبلغ المتبقي: %s - حالة الدفع: %s',
            number_format($data['amount'], 2),
            number_format($invoice->due_value, 2),
            $paymentStatusText
        );

        return redirect()->route('paymentsPurchase.index')->with('success', $successMessage);

    } catch (\Exception $e) {
        DB::rollback();
        Log::error('خطأ في تسجيل عملية الدفع: ' . $e->getMessage());
        return back()
            ->with('error', 'حدث خطأ أثناء تسجيل عملية الدفع: ' . $e->getMessage())
            ->withInput();
    }
}

public function createPurchase($id)
{
    // التحقق من وجود الفاتورة وعدم دفعها بالكامل
    $invoice = PurchaseInvoice::findOrFail($id);

    if ($invoice->is_paid) {
        return redirect()->route('invoicePurchases.index')
            ->with('error', 'لا يمكن إضافة دفعة. الفاتورة مدفوعة بالكامل بالفعل.');
    }

    $payments = PaymentsProcess::where('invoice_id', $id)->get();
    $employees = Employee::all();

    return view('purchases.supplier_payments.create', compact('payments', 'employees', 'id', 'invoice'));
}
    public function show($id)
    {
        $payment = PaymentsProcess::with(['invoice.client', 'invoice.payments_process', 'employee'])->findOrFail($id);
        $employees = Employee::all();

        return view('sales.payment.show', compact('payment', 'employees'));
    }
    public function showSupplierPayment($id)
    {
        try {
            $payment = PaymentsProcess::with([
                'purchase.supplier',
                'purchase',
                'employee'
            ])->where('type', 'supplier payments')
              ->findOrFail($id);

            $employees = Employee::all();

            return view('purchases.supplier_payments.show', compact('payment', 'employees'));
        } catch (\Exception $e) {
            return redirect()->route('PaymentSupplier.indexPurchase')
                ->with('error', 'حدث خطأ أثناء عرض تفاصيل الدفع: ' . $e->getMessage());
        }
    }
    public function edit($id)
    {
        $payment = PaymentsProcess::with(['invoice', 'employee'])->findOrFail($id);
        $employees = Employee::all();
        return view('sales.payment.edit', compact('payment', 'employees', 'id'));
    }
    public function editSupplierPayment($id)
    {
        $payment = PaymentsProcess::with(['purchase', 'employee'])->findOrFail($id);
        $employees = Employee::all();
        return view('Purchases.Supplier_Payments.edit', compact('payment', 'employees', 'id'));
    }
    public function update(ClientPaymentRequest $request, PaymentsProcess $payment)
{
    try {
        DB::beginTransaction();

        // استرجاع البيانات المصادق عليها
        $data = $request->validated();

        // التحقق من وجود الفاتورة وجلب تفاصيلها
        $invoice = Invoice::findOrFail($data['invoice_id']);

        // حساب إجمالي المدفوعات السابقة (باستثناء الدفعة الحالية)
        $totalPreviousPayments = PaymentsProcess::where('invoice_id', $invoice->id)
            ->where('type', 'client payments')
            ->where('payment_status', '!=', 5) // استثناء المدفوعات الفاشلة
            ->where('id', '!=', $payment->id) // استثناء الدفعة الحالية
            ->sum('amount');

        // حساب المبلغ المتبقي للدفع
        $remainingAmount = $invoice->grand_total - $totalPreviousPayments;

        // التحقق من أن مبلغ الدفع لا يتجاوز المبلغ المتبقي
        if ($data['amount'] > $remainingAmount) {
            return back()
                ->with('error', 'مبلغ الدفع يتجاوز المبلغ المتبقي للفاتورة. المبلغ المتبقي هو: ' . number_format($remainingAmount, 2))
                ->withInput();
        }

        // تعيين حالة الدفع الافتراضية كمسودة
        $payment_status = 3; // مسودة

        // تحديد حالة الدفع بناءً على المبلغ المدفوع والمبلغ المتبقي
        $newTotalPayments = $totalPreviousPayments + $data['amount'];

        if ($newTotalPayments >= $invoice->grand_total) {
            $payment_status = 1; // مكتمل
            $invoice->is_paid = true;
            $invoice->due_value = 0;
        } else {
            $payment_status = 2; // غير مكتمل
            $invoice->is_paid = false;
            $invoice->due_value = $invoice->grand_total - $newTotalPayments;
        }

        // إذا تم تحديد حالة دفع معينة في الطلب
        if ($request->has('payment_status')) {
            switch ($request->payment_status) {
                case 4: // تحت المراجعة
                    $payment_status = 4;
                    $invoice->is_paid = false;
                    break;
                case 5: // فاشلة
                    $payment_status = 5;
                    $invoice->is_paid = false;
                    // إعادة حساب المبلغ المتبقي بدون احتساب هذه الدفعة
                    $invoice->due_value = $invoice->grand_total - $totalPreviousPayments;
                    break;
            }
        }

        // إضافة البيانات الإضافية للدفعة
        $data['type'] = 'client payments';
        $data['created_by'] = Auth::id();
        $data['payment_status'] = $payment_status;

        // معالجة المرفقات
        if ($request->hasFile('attachments')) {
            $file = $request->file('attachments');
            if ($file->isValid()) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('assets/uploads/'), $filename);
                $data['attachments'] = $filename;
            }
        }

        // تحديث سجل الدفع
        $payment->update($data);

        // تحديث المبلغ المدفوع في الفاتورة
        $invoice->advance_payment = $newTotalPayments;
        $invoice->payment_status = $payment_status;
        $invoice->save();

        // تحديث القيد المحاسبي للدفعة
        $journalEntry = JournalEntry::where('invoice_id', $invoice->id)
            ->where('reference_number', $payment->reference_number ?? $invoice->code)
            ->first();

        if ($journalEntry) {
            $journalEntry->update([
                'date' => $data['payment_date'] ?? now(),
                'description' => 'تحديث دفعة للفاتورة رقم ' . $invoice->code,
            ]);

            // تحديث تفاصيل القيد المحاسبي للدفعة
            // 1. حساب الصندوق/البنك (مدين)
            JournalEntryDetail::where('journal_entry_id', $journalEntry->id)
                ->where('is_debit', true)
                ->update([
                    'account_id' => $data['payment_account_id'] ?? $this->getAccountId('cash'),
                    'description' => 'تحديث استلام دفعة نقدية',
                    'debit' => $data['amount'],
                    'credit' => 0,
                ]);

            // 2. حساب العميل (دائن)
            JournalEntryDetail::where('journal_entry_id', $journalEntry->id)
                ->where('is_debit', false)
                ->update([
                    'account_id' => $invoice->client->account_id,
                    'description' => 'تحديث دفعة من العميل',
                    'debit' => 0,
                    'credit' => $data['amount'],
                ]);
        }

        DB::commit();

        // إعداد رسالة النجاح مع حالة الدفع
        $paymentStatusText = match($payment_status) {
            1 => 'مكتمل',
            2 => 'غير مكتمل',
            3 => 'مسودة',
            4 => 'تحت المراجعة',
            5 => 'فاشلة',
            default => 'غير معروف'
        };

        $successMessage = sprintf(
            'تم تحديث عملية الدفع بنجاح. المبلغ المدفوع: %s، المبلغ المتبقي: %s - حالة الدفع: %s',
            number_format($data['amount'], 2),
            number_format($invoice->due_value, 2),
            $paymentStatusText
        );

        return redirect()->route('paymentsClient.index')->with('success', $successMessage);

    } catch (\Exception $e) {
        DB::rollback();
        Log::error('خطأ في تحديث عملية الدفع: ' . $e->getMessage());
        return back()
            ->with('error', 'حدث خطأ أثناء تحديث عملية الدفع: ' . $e->getMessage())
            ->withInput();
    }
}
    public function updateSupplierPayment(ClientPaymentRequest $request, PaymentsProcess $payment)
    {
        try {
            // استرجاع البيانات المصادق عليها
            $data = $request->validated();

            // معالجة المرفقات
            if ($request->hasFile('attachments')) {
                $data['attachments'] = $request->file('attachments')->store('payment_attachments', 'public');
            }

            // تحديث السجل
            $payment->update($data);

            return redirect()->route('paymentsClient.index')->with('success', 'تم تحديث عملية الدفع بنجاح');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'حدث خطأ أثناء تحديث عملية الدفع: ' . $e->getMessage())
                ->withInput();
        }
    }


    public function destroy($id)
    {
        PaymentsProcess::destroy($id);
        return redirect()->route('paymentsClient.index')->with('success', 'تم حذف عملية الدفع بنجاح');
    }
}

