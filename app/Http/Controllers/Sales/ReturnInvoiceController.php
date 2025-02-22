<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Inventory;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\JournalEntry;
use App\Models\JournalEntryDetail;
use App\Models\PaymentsProcess;
use App\Models\Product;
use App\Models\ProductDetails;
use App\Models\StoreHouse;
use App\Models\Treasury;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReturnInvoiceController extends Controller
{
    public function index(Request $request)
    {
        // بدء بناء الاستعلام
        $return = Invoice::with(['client', 'createdByUser', 'updatedByUser'])->orderBy('created_at', 'desc');

        // 1. البحث حسب العميل
        if ($request->has('client_id') && $request->client_id) {
            $return->where('client_id', $request->client_id);
        }

        // 2. البحث حسب رقم الفاتورة
        if ($request->has('invoice_number') && $request->invoice_number) {
            $return->where('id', 'like', '%' . $request->invoice_number . '%');
        }

        // 3. البحث حسب حالة الفاتورة
        if ($request->has('payment_status') && $request->payment_status) {
            $return->where('payment_status', $request->payment_status);
        }

        // 4. البحث حسب البند
        if ($request->has('item') && $request->item) {
            $return->whereHas('items', function ($query) use ($request) {
                $query->where('item', 'like', '%' . $request->item . '%');
            });
        }

        // 5. البحث حسب العملة
        if ($request->has('currency') && $request->currency) {
            $return->where('currency', $request->currency);
        }

        // 6. البحث حسب الإجمالي (من)
        if ($request->has('total_from') && $request->total_from) {
            $return->where('grand_total', '>=', $request->total_from);
        }

        // 7. البحث حسب الإجمالي (إلى)
        if ($request->has('total_to') && $request->total_to) {
            $return->where('grand_total', '<=', $request->total_to);
        }

        // 8. البحث حسب حالة الدفع
        if ($request->has('payment_status') && $request->payment_status) {
            $return->where('payment_status', $request->payment_status);
        }

        // 9. البحث حسب التاريخ (من)
        if ($request->has('from_date') && $request->from_date) {
            $return->whereDate('created_at', '>=', $request->from_date);
        }

        // 10. البحث حسب التاريخ (إلى)
        if ($request->has('to_date') && $request->to_date) {
            $return->whereDate('created_at', '<=', $request->to_date);
        }

        // 11. البحث حسب تاريخ الاستحقاق (من)
        if ($request->has('due_date_from') && $request->due_date_from) {
            $return->whereDate('due_date', '>=', $request->due_date_from);
        }

        // 12. البحث حسب تاريخ الاستحقاق (إلى)
        if ($request->has('due_date_to') && $request->due_date_to) {
            $return->whereDate('due_date', '<=', $request->due_date_to);
        }

        // 13. البحث حسب المصدر
        if ($request->has('source') && $request->source) {
            $return->where('source', $request->source);
        }

        // 14. البحث حسب الحقل المخصص
        if ($request->has('custom_field') && $request->custom_field) {
            $return->where('custom_field', 'like', '%' . $request->custom_field . '%');
        }

        // 15. البحث حسب تاريخ الإنشاء (من)
        if ($request->has('created_at_from') && $request->created_at_from) {
            $return->whereDate('created_at', '>=', $request->created_at_from);
        }

        // 16. البحث حسب تاريخ الإنشاء (إلى)
        if ($request->has('created_at_to') && $request->created_at_to) {
            $return->whereDate('created_at', '<=', $request->created_at_to);
        }

        // 17. البحث حسب حالة التسليم
        if ($request->has('delivery_status') && $request->delivery_status) {
            $return->where('delivery_status', $request->delivery_status);
        }

        // 18. البحث حسب "أضيفت بواسطة"
        if ($request->has('added_by') && $request->added_by) {
            $return->where('created_by', $request->added_by);
        }

        // 19. البحث حسب مسؤول المبيعات
        if ($request->has('sales_person') && $request->sales_person) {
            $return->where('sales_person_id', $request->sales_person);
        }

        // 20. البحث حسب خيارات الشحن
        if ($request->has('shipping_option') && $request->shipping_option) {
            $return->where('shipping_option', $request->shipping_option);
        }

        // 21. البحث حسب مصدر الطلب
        if ($request->has('order_source') && $request->order_source) {
            $return->where('order_source', $request->order_source);
        }

        // 22. البحث حسب التخصيص (شهريًا، أسبوعيًا، يوميًا)
        if ($request->has('custom_period') && $request->custom_period) {
            if ($request->custom_period == 'monthly') {
                $return->whereMonth('created_at', now()->month);
            } elseif ($request->custom_period == 'weekly') {
                $return->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
            } elseif ($request->custom_period == 'daily') {
                $return->whereDate('created_at', now()->toDateString());
            }
        }

        // 23. البحث حسب حالة التسليم
        if ($request->has('delivery_status') && $request->delivery_status) {
            $return->where('delivery_status', $request->delivery_status);
        }

        // 24. البحث حسب "أضيفت بواسطة" (الموظفين)
        if ($request->has('added_by_employee') && $request->added_by_employee) {
            $return->where('created_by', $request->added_by_employee);
        }

        // 25. البحث حسب مسؤول المبيعات (المستخدمين)
        if ($request->has('sales_person_user') && $request->sales_person_user) {
            $return->where('sales_person_id', $request->sales_person_user);
        }

        // جلب النتائج
        $return = $return->get();

        // البيانات الأخرى المطلوبة للواجهة
        $clients = Client::all();
        $users = User::all();
        $employees = Employee::all();
        $invoice_number = $this->generateInvoiceNumber();

        return view('sales.retend_invoice.index', compact('return', 'clients', 'users', 'invoice_number', 'employees'));
    }
    public function create($id)
    {
        // العثور على الفاتورة
        $invoice = Invoice::findOrFail($id);

        // تحديث نوع الفاتورة إلى مرتجع
        $invoice->type = 'مرتجع'; // أو 'returned' حسب ما تحتاج
        $invoice->save(); // حفظ التغييرات في قاعدة البيانات

        // توليد رقم الفاتورة
        // $invoice_number = $this->generateInvoiceNumber();
        $items = Product::all();
        $clients = Client::all();
        $treasury = Treasury::all();
        $users = User::all();

        // تمرير البيانات إلى العرض
        return view('sales.retend_invoice.create', compact('clients', 'items', 'treasury',  'users', 'invoice'));
    }
    // private function generateInvoiceNumber()
    // {
    //     $lastInvoice = Invoice::latest()->first();
    //     $nextId = $lastInvoice ? $lastInvoice->id + 1 : 1;
    //     return str_pad($nextId, 6, '0', STR_PAD_LEFT);
    // }

    public function store(Request $request)
    {
        try {
            // تحقق مما إذا كانت قيمة invoice_id موجودة
            if (empty($request->invoice_id) || !is_numeric($request->invoice_id)) {
                return redirect()->back()->withInput()->with('error', 'رقم الفاتورة غير صالح.');
            }

            // تحقق مما إذا كانت الفاتورة الأصلية موجودة
            $invoice = Invoice::find($request->invoice_id);

            if (!$invoice) {
                return redirect()->back()->withInput()->with('error', 'الفاتورة غير موجودة.');
            }

            // تحديث نوع الفاتورة إلى "مرتجع"
            $invoice->type = 'returned'; // أو 'مرتجع' حسب الحاجة
            $invoice->save(); // حفظ التغييرات

            return redirect()
                ->route('ReturnIInvoices.show', $invoice->id)
                ->with('success', 'تم تغيير نوع الفاتورة إلى مرتجع بنجاح.');
        } catch (\Exception $e) {
            Log::error('خطأ في تغيير نوع الفاتورة: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'عذراً، حدث خطأ أثناء تغيير نوع الفاتورة: ' . $e->getMessage());
        }
    }
    public function edit($id)
    {
        return redirect()
            ->back()
            ->with('error', 'لا يمكنك تعديل الفاتورة رقم ' . $id . '. طبقا لتعليمات هيئة الزكاة والدخل يمنع حذف أو تعديل الفاتورة بعد إصدارها وفقا لمتطلبات الفاتورة الإلكترونية، ولكن يمكن إصدار فاتورة مرتجعة أو إشعار دائن لإلغائها أو تعديلها.');
    }

    /**
     * Remove the specified invoice from storage.
     */
    public function destroy($id)
    {
        return redirect()->route('ReturnIInvoices.index')->with('error', 'لا يمكنك حذف الفاتورة. طبقا لتعليمات هيئة الزكاة والدخل يمنع حذف أو تعديل الفاتورة بعد إصدارها وفقا لمتطلبات الفاتورة الإلكترونية، ولكن يمكن إصدار فاتورة مرتجعة أو إشعار دائن لإلغائها أو تعديلها.');
    }

    /**
     * Update the specified invoice in storage.
     */
    public function update(Request $request, $id)
    {
        return redirect()->route('ReturnIInvoices.index')->with('error', 'لا يمكنك تعديل الفاتورة. طبقا لتعليمات هيئة الزكاة والدخل يمنع حذف أو تعديل الفاتورة بعد إصدارها وفقا لمتطلبات الفاتورة الإلكترونية، ولكن يمكن إصدار فاتورة مرتجعة أو إشعار دائن لإلغائها أو تعديلها.');
    }

    public function show($id)
    {
        $clients = Client::all();
        $employees = Employee::all();
        $return_invoice = Invoice::find($id);
        // $invoice_number = $this->generateInvoiceNumber();
        return view('sales.retend_invoice.show', compact( 'clients', 'employees', 'return_invoice'));
    }
}
