<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sales\QuoteRequest;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\Quote;
use App\Models\SerialSetting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function index(Request $request)
    {
        $query = Quote::with(['client', 'creator', 'items']);

        // البحث حسب العميل
        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        // البحث حسب رقم عرض السعر
        if ($request->filled('id')) {
            $query->where('quotes_number', 'LIKE', '%' . $request->id . '%');
        }

        // البحث حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // البحث حسب العملة
        if ($request->filled('currency')) {
            $query->where('currency', $request->currency);
        }

        // البحث حسب المبلغ الإجمالي
        if ($request->filled('total_from')) {
            $query->where('grand_total', '>=', $request->total_from);
        }
        if ($request->filled('total_to')) {
            $query->where('grand_total', '<=', $request->total_to);
        }

        // البحث حسب التاريخ الأول (تاريخ العرض)
        if ($request->filled('date_type_1')) {
            switch ($request->date_type_1) {
                case 'monthly':
                    $query->whereMonth('quote_date', now()->month);
                    break;
                case 'weekly':
                    $query->whereBetween('quote_date', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'daily':
                    $query->whereDate('quote_date', now());
                    break;
                default:
                    if ($request->filled('from_date_1') && $request->filled('to_date_1')) {
                        $query->whereBetween('quote_date', [$request->from_date_1, $request->to_date_1]);
                    }
            }
        }

        // البحث حسب تاريخ الإنشاء
        if ($request->filled('date_type_2')) {
            switch ($request->date_type_2) {
                case 'monthly':
                    $query->whereMonth('created_at', now()->month);
                    break;
                case 'weekly':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'daily':
                    $query->whereDate('created_at', now());
                    break;
                default:
                    if ($request->filled('from_date_2') && $request->filled('to_date_2')) {
                        $query->whereBetween('created_at', [$request->from_date_2, $request->to_date_2]);
                    }
            }
        }

        // البحث في البنود
        if ($request->filled('item_search')) {
            $query->whereHas('items', function ($q) use ($request) {
                $q->where('item', 'LIKE', '%' . $request->item_search . '%')
                  ->orWhere('description', 'LIKE', '%' . $request->item_search . '%');
            });
        }

        // البحث حسب من أضاف عرض السعر
        if ($request->filled('created_by')) {
            $query->where('created_by', $request->created_by);
        }

        // البحث حسب مسؤول المبيعات
        if ($request->filled('sales_representative')) {
            $query->where('sales_representative_id', $request->sales_representative);
        }

        // البحث حسب حالة الدفع
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // ترتيب النتائج حسب تاريخ الإنشاء تنازلياً
        $quotes = $query->orderBy('created_at', 'desc')->paginate(10); // استبدل get() بـ paginate()

        // جلب البيانات الأخرى المطلوبة للصفحة
        $quotes_number = $this->generateInvoiceNumber();
        $clients = Client::all();
        $users = User::all();
        $employees = Employee::all();

        // إرجاع البيانات مع المتغيرات المطلوبة للعرض
        return view('sales.qoution.index', compact('quotes', 'quotes_number', 'clients', 'users', 'employees'))
            ->with('search_params', $request->all()); // إرجاع معاملات البحث للحفاظ على حالة النموذج
    }
    private function generateInvoiceNumber()
    {
        $lastQuote = Quote::latest()->first();
        return $lastQuote ? $lastQuote->id + 1 : 1;
    }

    public function create()
    {
        $quotes_number = $this->generateInvoiceNumber();
        $items = Product::all();
        $clients = Client::all();
        $users = User::all();

        return view('sales.qoution.create', compact('clients', 'users', 'items', 'quotes_number'));
    }

    public function store(Request $request)
    {
        // التحقق من صحة البيانات باستخدام helper function
        $validated = validator($request->all(), [
            'client_id' => 'required|exists:clients,id',
            'quote_date' => 'required|date_format:Y-m-d',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0',
            'items.*.discount_type' => 'nullable|in:amount,percentage',
            'items.*.tax_1' => 'nullable|numeric|min:0',
            'items.*.tax_2' => 'nullable|numeric|min:0',
            'shipping_cost' => 'nullable|numeric|min:0',
            'discount_type' => 'nullable|in:amount,percentage',
            'discount_amount' => 'nullable|numeric|min:0',
            'tax_type' => 'required|in:1,2,3', // 1=vat, 2=zero, 3=exempt
            'tax_rate' => 'nullable|numeric|min:0', // نسبة الضريبة التي يدخلها المستخدم
            'notes' => 'nullable|string',
        ])->validate();

        // بدء العملية داخل ترانزاكشن
        DB::beginTransaction();

        try {
            // ** الخطوة الأولى: إنشاء كود للعرض باستخدام الرقم التسلسلي الحالي **
            $serialSetting = SerialSetting::where('section', 'quotation')->first(); // الحصول على الرقم التسلسلي الحالي
            $currentNumber = $serialSetting ? $serialSetting->current_number : 1; // إذا لم يتم العثور على إعدادات، نستخدم 1 كقيمة افتراضية

            // التحقق من أن الرقم فريد
            while (Quote::where('id', $currentNumber)->exists()) {
                $currentNumber++;
            }

            // تعيين الرقم التسلسلي
            $quotes_number = $currentNumber;

            // زيادة الرقم التسلسلي في جدول serial_settings
            if ($serialSetting) {
                $serialSetting->update(['current_number' => $currentNumber + 1]);
            } else {
                // إذا لم يتم العثور على إعدادات، يتم إنشاء سجل جديد
                SerialSetting::create([
                    'section' => 'quotation',
                    'current_number' => $currentNumber + 1,
                ]);
            }

            // ** تجهيز المتغيرات الرئيسية لحساب العرض **
            $total_amount = 0; // إجمالي المبلغ قبل الخصومات
            $total_discount = 0; // إجمالي الخصومات على البنود
            $items_data = []; // تجميع بيانات البنود

            // ** الخطوة الثانية: معالجة البنود (items) **
            foreach ($validated['items'] as $item) {
                // جلب المنتج
                $product = Product::findOrFail($item['product_id']);

                // حساب تفاصيل الكمية والأسعار
                $quantity = floatval($item['quantity']);
                $unit_price = floatval($item['unit_price']);
                $item_total = $quantity * $unit_price;

                // حساب الخصم للبند
                $item_discount = 0; // قيمة الخصم المبدئية
                if (isset($item['discount']) && $item['discount'] > 0) {
                    $discountType = $item['discount_type'] ?? 'amount';
                    if ($discountType === 'percentage') {
                        $item_discount = ($item_total * floatval($item['discount'])) / 100;
                    } else {
                        $item_discount = floatval($item['discount']);
                    }
                }

                // تحديث الإجماليات
                $total_amount += $item_total;
                $total_discount += $item_discount;

                // تجهيز بيانات البند
                $items_data[] = [
                    'quotation_id' => null, // سيتم تعيينه لاحقًا بعد إنشاء العرض
                    'product_id' => $item['product_id'],
                    'item' => $product->name,
                    'description' => $item['description'] ?? null,
                    'quantity' => $quantity,
                    'unit_price' => $unit_price,
                    'discount' => $item_discount,
                    'discount_type' => isset($item['discount_type']) && $item['discount_type'] === 'percentage' ? 2 : 1,
                    'tax_1' => floatval($item['tax_1'] ?? 0),
                    'tax_2' => floatval($item['tax_2'] ?? 0),
                    'total' => $item_total - $item_discount,
                ];
            }

            // ** الخطوة الثالثة: حساب الخصم الإضافي للعرض ككل **
            $quote_discount = floatval($validated['discount_amount'] ?? 0);
            $discountType = $validated['discount_type'] ?? 'amount';
            if ($discountType === 'percentage') {
                $quote_discount = ($total_amount * $quote_discount) / 100;
            }

            // الخصومات الإجمالية
            $final_total_discount = $total_discount + $quote_discount;

            // حساب المبلغ بعد الخصم
            $amount_after_discount = $total_amount - $final_total_discount;

            // ** حساب الضرائب بناءً على القيمة التي يدخلها المستخدم **
            $tax_total = 0;
            $tax_type = $validated['tax_type'];
            if ($tax_type == 1) { // إذا كانت الضريبة مفعلة
                $tax_rate = $validated['tax_rate'] ?? 0; // نسبة الضريبة التي يدخلها المستخدم (افتراضيًا 0 إذا لم يتم تقديمها)
                $tax_total = ($amount_after_discount * $tax_rate) / 100; // حساب الضريبة
            }

            // ** إضافة تكلفة الشحن (إذا وجدت) **
            $shipping_cost = floatval($validated['shipping_cost'] ?? 0);

            // ** حساب ضريبة الشحن (إذا كانت الضريبة مفعلة) **
            $shipping_tax = 0;
            if ($tax_type == 1) { // إذا كانت الضريبة مفعلة
                $tax_rate = $validated['tax_rate'] ?? 0; // نسبة الضريبة التي يدخلها المستخدم (افتراضيًا 0 إذا لم يتم تقديمها)
                $shipping_tax = ($shipping_cost * $tax_rate) / 100; // ضريبة الشحن بناءً على نسبة الضريبة
            }

            // ** إضافة ضريبة الشحن إلى tax_total **
            $tax_total += $shipping_tax;

            // ** الحساب النهائي للمجموع الكلي **
            $total_with_tax = $amount_after_discount + $tax_total + $shipping_cost;

            // ** الخطوة الرابعة: إنشاء عرض السعر **
            $quote = Quote::create([
                'id' => $quotes_number, // استخدام الرقم التسلسلي كـ id
                'client_id' => $validated['client_id'],
                'quotes_number' => $quotes_number,
                'quote_date' => $validated['quote_date'],
                'notes' => $validated['notes'] ?? null,
                'created_by' => Auth::id(),
                'discount_amount' => $quote_discount,
                'discount_type' => $discountType === 'percentage' ? 2 : 1,
                'shipping_cost' => $shipping_cost,
                'shipping_tax' => $shipping_tax,
                'tax_type' => $tax_type, // نحفظ الرقم في قاعدة البيانات
                'tax_rate' => $tax_type == 1 ? ($validated['tax_rate'] ?? 0) : null, // نحفظ نسبة الضريبة إذا كانت مفعلة
                'subtotal' => $total_amount,
                'total_discount' => $final_total_discount,
                'tax_total' => $tax_total,
                'grand_total' => $total_with_tax,
                'status' => 1, // حالة العرض (1: Draft)
            ]);

            // ** الخطوة الخامسة: إنشاء سجلات البنود (items) للعرض **
            foreach ($items_data as $item) {
                $item['quotation_id'] = $quote->id;
                InvoiceItem::create($item);
            }

            DB::commit();
            return redirect()->route('questions.index')->with('success', 'تم إنشاء عرض السعر بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('حدث خطأ في دالة store: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'عذراً، حدث خطأ أثناء حفظ عرض السعر: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $quote = Quote::with(['client', 'employee', 'items'])->findOrFail($id);
        return view('sales.qoution.show', compact('quote'));
    }

    public function edit($id)
    {
        $quote = Quote::with(['client', 'employee', 'items'])->findOrFail($id);
        $items = Product::all();
        $clients = Client::all();
        $quotes_number = $this->generateInvoiceNumber();
        $users = User::all();

        return view('sales.qoution.edit', compact('quote', 'clients', 'users', 'items', 'quotes_number'));
    }

    public function update(Request $request, $id)
    {
        // التحقق من صحة البيانات باستخدام helper function
        $validated = validator($request->all(), [
            'client_id' => 'nullable|exists:clients,id',
            'quote_date' => 'nullable|date_format:Y-m-d',
            'items' => 'nullable|array|min:1',
            'items.*.product_id' => 'nullable|exists:products,id', // إضافة التحقق من المستودع
            'items.*.quantity' => 'nullable|numeric|min:1',
            'items.*.unit_price' => 'nullable|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0',
            'items.*.discount_type' => 'nullable|in:amount,percentage',
            'items.*.tax_1' => 'nullable|numeric|min:0',
            'items.*.tax_2' => 'nullable|numeric|min:0',
            'shipping_cost' => 'nullable|numeric|min:0',
            'discount_type' => 'nullable|in:amount,percentage',
            'discount_amount' => 'nullable|numeric|min:0',
            'tax_type' => 'nullable|in:1,2,3', // 1=vat, 2=zero, 3=exempt
            'notes' => 'nullable|string',
        ])->validate();

        // تحويل tax_type إلى النص المناسب
        $tax_type_map = [
            '1' => 'vat',
            '2' => 'zero',
            '3' => 'exempt',
        ];

        // بدء العملية داخل ترانزاكشن
        DB::beginTransaction();

        try {
            // البحث عن العرض الموجود
            $quote = Quote::findOrFail($id);

            // ** تجهيز المتغيرات الرئيسية لحساب العرض **
            $total_amount = 0; // إجمالي المبلغ قبل الخصومات
            $total_discount = 0; // إجمالي الخصومات على البنود
            $items_data = []; // تجميع بيانات البنود

            // ** الخطوة الثانية: معالجة البنود (items) **
            if (isset($validated['items'])) {
                foreach ($validated['items'] as $item) {
                    // جلب المنتج مع التحقق من وجوده
                    $product = Product::find($item['product_id']); // استخدم find بدلاً من findOrFail

                    // إذا لم يتم العثور على المنتج، نستمر إلى العنصر التالي
                    if (!$product) {
                        continue; // أو يمكنك إرجاع رسالة خطأ هنا
                    }

                    // حساب تفاصيل الكمية والأسعار
                    $quantity = floatval($item['quantity']);
                    $unit_price = floatval($item['unit_price']);
                    $item_total = $quantity * $unit_price;

                    // حساب الخصم للبند
                    $item_discount = 0; // قيمة الخصم المبدئية
                    if (isset($item['discount']) && $item['discount'] > 0) {
                        $discountType = $item['discount_type'] ?? 'amount';
                        if ($discountType === 'percentage') {
                            $item_discount = ($item_total * floatval($item['discount'])) / 100;
                        } else {
                            $item_discount = floatval($item['discount']);
                        }
                    }

                    // تحديث الإجماليات
                    $total_amount += $item_total;
                    $total_discount += $item_discount;

                    // تجهيز بيانات البند
                    $items_data[] = [
                        'quotation_id' => $quote->id, // سيتم تعيينه لاحقًا بعد إنشاء العرض
                        'product_id' => $item['product_id'],
                        'item' => $product->name,
                        'description' => $item['description'] ?? null,
                        'quantity' => $quantity,
                        'unit_price' => $unit_price,
                        'discount' => $item_discount,
                        'discount_type' => isset($item['discount_type']) && $item['discount_type'] === 'percentage' ? 2 : 1,
                        'tax_1' => floatval($item['tax_1'] ?? 0),
                        'tax_2' => floatval($item['tax_2'] ?? 0),
                        'total' => $item_total - $item_discount,
                    ];
                }
            }

            // ** الخطوة الثالثة: حساب الخصم الإضافي للعرض ككل **
            $quote_discount = floatval($validated['discount_amount'] ?? 0);
            $discountType = $validated['discount_type'] ?? 'amount';
            if ($discountType === 'percentage') {
                $quote_discount = ($total_amount * $quote_discount) / 100;
            }

            // الخصومات الإجمالية
            $final_total_discount = $total_discount + $quote_discount;

            // حساب المبلغ بعد الخصم
            $amount_after_discount = $total_amount - $final_total_discount;

            // ** حساب الضرائب **
            $tax_total = 0;
            $tax_type = $tax_type_map[$validated['tax_type'] ?? $quote->tax_type]; // استخدام القيمة القديمة إذا لم يتم تقديم قيمة جديدة
            if ($tax_type === 'vat') {
                // حساب الضريبة على المبلغ بعد الخصم
                $tax_total = $amount_after_discount * 0.15; // نسبة الضريبة 15%
            }

            // ** إضافة تكلفة الشحن (إذا وجدت) **
            $shipping_cost = floatval($validated['shipping_cost'] ?? $quote->shipping_cost); // استخدام القيمة القديمة إذا لم يتم تقديم قيمة جديدة

            // ** حساب ضريبة الشحن (إذا كانت الضريبة مفعلة) **
            $shipping_tax = 0;
            if ($tax_type === 'vat') {
                $shipping_tax = $shipping_cost * 0.15; // ضريبة الشحن 15%
            }

            // ** إضافة ضريبة الشحن إلى tax_total **
            $tax_total += $shipping_tax;

            // ** الحساب النهائي للمجموع الكلي **
            $total_with_tax = $amount_after_discount + $tax_total + $shipping_cost;

            // ** الخطوة الرابعة: تحديث العرض في قاعدة البيانات **
            $quote->update([
                'client_id' => $validated['client_id'] ?? $quote->client_id, // استخدام القيمة القديمة إذا لم يتم تقديم قيمة جديدة
                'quote_date' => $validated['quote_date'] ?? $quote->quote_date, // استخدام القيمة القديمة إذا لم يتم تقديم قيمة جديدة
                'notes' => $validated['notes'] ?? $quote->notes, // استخدام القيمة القديمة إذا لم يتم تقديم قيمة جديدة
                'discount_amount' => $quote_discount,
                'discount_type' => $discountType === 'percentage' ? 2 : 1,
                'shipping_cost' => $shipping_cost,
                'shipping_tax' => $shipping_tax,
                'tax_type' => $validated['tax_type'] ?? $quote->tax_type, // استخدام القيمة القديمة إذا لم يتم تقديم قيمة جديدة
                'subtotal' => $total_amount,
                'total_discount' => $final_total_discount,
                'tax_total' => $tax_total,
                'grand_total' => $total_with_tax,
                'status' => 1, // حالة العرض (1: Draft)
            ]);

            // ** الخطوة الخامسة: حذف البنود القديمة وإنشاء سجلات البنود (items) الجديدة للعرض **
            if (isset($validated['items'])) {
                $quote->items()->delete(); // حذف البنود القديمة
                foreach ($items_data as $item) {
                    $quote->items()->create($item);
                }
            }

            DB::commit();
            return redirect()->route('questions.index')->with('success', 'تم تحديث عرض السعر بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('حدث خطأ في دالة update: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'عذراً، حدث خطأ أثناء تحديث عرض السعر: ' . $e->getMessage());
        }
    }
    public function destroy($id)
    {
        $quote = Quote::findOrFail($id);
        $quote->delete();
        return redirect()->route('questions.index')->with('success', 'تم حذف عرض السعر بنجاح');
    }

    public function convertToInvoice($id)
    {
        DB::beginTransaction();

        try {
            // جلب عرض الأسعار مع العلاقات
            $quote = Quote::with(['client', 'items'])->findOrFail($id);

            // إنشاء الفاتورة يدويًا
            $invoice = Invoice::create([
                'client_id' => $quote->client_id,
                'invoice_date' => now(),
                'type' => 'normal',
                'notes' => $quote->notes,
                'discount_amount' => $quote->discount_amount,
                'discount_type' => $quote->discount_type,
                'shipping_cost' => $quote->shipping_cost,
                'shipping_tax' => $quote->shipping_tax,
                'tax_type' => $quote->tax_type,
                'subtotal' => $quote->subtotal,
                'total_discount' => $quote->total_discount,
                'tax_total' => $quote->tax_total,
                'grand_total' => $quote->grand_total,
            ]);

            // إضافة عناصر الفاتورة
            foreach ($quote->items as $item) {
                $invoice->items()->create([
                    'product_id' => $item->product_id,
                    'item' => $item->item,
                    'description' => $item->description,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'discount' => $item->discount,
                    'discount_type' => $item->discount_type,
                    'tax_1' => $item->tax_1,
                    'tax_2' => $item->tax_2,
                    'total' => $item->total,
                ]);
            }

            // تحديث حالة عرض الأسعار إلى "تم التحويل"
            $quote->update(['status' => 4]); // 4: تم التحويل إلى فاتورة

            DB::commit();

            // توجيه المستخدم إلى صفحة الفاتورة مع رسالة نجاح
            return redirect()
                ->route('invoices.show', $invoice->id)
                ->with('success', 'تم تحويل عرض الأسعار إلى فاتورة بنجاح.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('حدث خطأ أثناء تحويل عرض الأسعار إلى فاتورة: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'حدث خطأ أثناء التحويل: ' . $e->getMessage());
        }
    }
}
