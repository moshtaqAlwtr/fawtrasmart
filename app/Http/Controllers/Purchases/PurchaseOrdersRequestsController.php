<?php

namespace App\Http\Controllers\Purchases;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PurchaseOrdersRequestsController extends Controller
{
    public function index(Request $request)
    {
        $query = PurchaseInvoice::query()
            ->with(['supplier', 'creator', 'items'])
            ->where('type', 1); // مرتجع المشتريات

        // البحث بواسطة المورد
        if ($request->filled('employee_search')) {
            $query->where('supplier_id', $request->employee_search);
        }

        // البحث برقم الفاتورة
        if ($request->filled('number_invoice')) {
            $query->where('code', 'LIKE', '%' . $request->number_invoice . '%');
        }

        // البحث بالحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // البحث بحالة الدفع
        if ($request->filled('payment_status')) {
            switch ($request->payment_status) {
                case 'paid':
                    $query->where('is_paid', 1);
                    break;
                case 'partial':
                    $query->where('is_paid', 0)->whereColumn('advance_payment', '<', 'grand_total')->where('advance_payment', '>', 0);
                    break;
                case 'unpaid':
                    $query->where('is_paid', 0)->where('advance_payment', 0);
                    break;
                case 'returned':
                    $query->where('type', 3);
                    break;
                case 'overpaid':
                    $query->whereColumn('advance_payment', '>', 'grand_total');
                    break;
                case 'draft':
                    $query->where('status', 0);
                    break;
            }
        }

        // البحث بواسطة المنشئ
        if ($request->filled('created_by')) {
            $query->where('created_by', $request->created_by);
        }

        // البحث بواسطة الوسم
        if ($request->filled('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('tags.id', $request->tag);
            });
        }

        // البحث في الحقل المخصص
        if ($request->filled('contract')) {
            $query->where('reference_number', 'LIKE', '%' . $request->contract . '%');
        }

        // البحث في وصف البنود
        if ($request->filled('description')) {
            $query->whereHas('items', function ($q) use ($request) {
                $q->where('description', 'LIKE', '%' . $request->description . '%');
            });
        }

        // البحث بنوع المصدر
        if ($request->filled('source')) {
            if ($request->source === 'return') {
                $query->where('type', 1);
            } else {
                $query->where('type', 1);
            }
        }

        // البحث بحالة التسليم
        if ($request->filled('delivery_status')) {
            $query->where('delivery_status', $request->delivery_status);
        }

        // البحث بالتاريخ
        if ($request->filled('start_date_from')) {
            $query->whereDate('date', '>=', $request->start_date_from);
        }
        if ($request->filled('start_date_to')) {
            $query->whereDate('date', '<=', $request->start_date_to);
        }

        // البحث بتاريخ الإنشاء
        if ($request->filled('created_at_from')) {
            $query->whereDate('created_at', '>=', $request->created_at_from);
        }
        if ($request->filled('created_at_to')) {
            $query->whereDate('created_at', '<=', $request->created_at_to);
        }

        // ترتيب النتائج
        $query->orderBy('created_at', 'desc');

        // تجهيز البيانات للعرض
        $purchaseOrdersRequests = $query->paginate(10);
        $suppliers = Supplier::all();
        $users = User::all();

        return view('Purchases.Purchasing_order_requests.index', compact('purchaseOrdersRequests', 'suppliers', 'users'));
    }

    public function Show($id)
    {
        $purchaseOrdersRequests = PurchaseInvoice::with([
            'invoiceItems' => function ($query) use ($id) {
                $query->where('purchase_invoice_id', $id);
            },
            'invoiceItems.product',
            'supplier',
        ])->findOrFail($id);

        return view('Purchases.Purchasing_order_requests.show', compact('purchaseOrdersRequests'));
    }
    public function create()
    {
        $suppliers = Supplier::all();
        $items = Product::all();
        $accounts = Account::all();
        $users = User::all();
        return view('Purchases.Purchasing_order_requests.create', compact('suppliers', 'accounts', 'users', 'items'));
    }

    public function store(Request $request)
    {
        try {
            // ** الخطوة الأولى: إنشاء كود للفاتورة **
            $code = $request->code;
            if (!$code) {
                $lastOrder = PurchaseInvoice::orderBy('id', 'desc')->first();
                $nextNumber = $lastOrder ? intval($lastOrder->code) + 1 : 1;
                $code = str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
            } else {
                $existingCode = PurchaseInvoice::where('code', $request->code)->exists();
                if ($existingCode) {
                    return redirect()->back()->withInput()->with('error', 'رقم الفاتورة موجود مسبقاً، الرجاء استخدام رقم آخر');
                }
            }

            DB::beginTransaction(); // بدء المعاملة

            // ** تجهيز المتغيرات الرئيسية لحساب الفاتورة **
            $total_amount = 0; // إجمالي المبلغ قبل الخصومات
            $total_discount = 0; // إجمالي الخصومات على البنود
            $items_data = []; // تجميع بيانات البنود

            // ** الخطوة الثانية: معالجة البنود (items) **
            if ($request->has('items') && count($request->items)) {
                foreach ($request->items as $item) {
                    // جلب المنتج
                    $product = Product::find($item['product_id']);
                    if (!$product) {
                        throw new \Exception('المنتج غير موجود: ' . $item['product_id']);
                    }

                    // حساب تفاصيل الكمية والأسعار
                    $quantity = floatval($item['quantity']);
                    $unit_price = floatval($item['unit_price']);
                    $item_total = $quantity * $unit_price;

                    // حساب الخصم للبند
                    $item_discount = 0; // قيمة الخصم المبدئية
                    if (isset($item['discount']) && $item['discount'] > 0) {
                        if (isset($item['discount_type']) && $item['discount_type'] === 'percentage') {
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
                        'purchase_invoice_id' => null, // سيتم تعيينه لاحقًا بعد إنشاء الفاتورة
                        'product_id' => $item['product_id'],
                        'item' => $product->name ?? 'المنتج ' . $item['product_id'],
                        'description' => $item['description'] ?? null,
                        'quantity' => $quantity,
                        'unit_price' => $unit_price,
                        'discount' => $item_discount, // تخزين الخصم للبند
                        'discount_type' => isset($item['discount_type']) && $item['discount_type'] === 'percentage' ? 2 : 1,
                        'tax_1' => floatval($item['tax_1'] ?? 0),
                        'tax_2' => floatval($item['tax_2'] ?? 0),
                        'total' => $item_total - $item_discount,
                    ];
                }
            }

            // ** الخطوة الثالثة: حساب الخصم الإضافي للفاتورة ككل **
            $invoice_discount = 0;
            if ($request->has('discount_amount') && $request->discount_amount > 0) {
                if ($request->has('discount_type') && $request->discount_type === 'percentage') {
                    $invoice_discount = ($total_amount * floatval($request->discount_amount)) / 100;
                } else {
                    $invoice_discount = floatval($request->discount_amount);
                }
            }

            // الخصومات الإجمالية
            $final_total_discount = $total_discount + $invoice_discount;

            // حساب المبلغ بعد الخصم
            $amount_after_discount = $total_amount - $final_total_discount;

            // ** حساب الضرائب **
            $total_tax = 0;
            if ($request->tax_type == 1) {
                $total_tax = $amount_after_discount * 0.15; // نسبة الضريبة 15%
            }

            // ** إضافة تكلفة الشحن (إذا وجدت) **
            $shipping_cost = floatval($request->shipping_cost ?? 0);

            // ** حساب ضريبة التوصيل (إذا كانت الضريبة مفعلة) **
            $shipping_tax = 0;
            if ($request->tax_type == 1) {
                $shipping_tax = $shipping_cost * 0.15; // ضريبة التوصيل 15%
            }

            // ** الحساب النهائي للمجموع الكلي **
            $total_with_tax = $amount_after_discount + $total_tax + $shipping_cost + $shipping_tax;

            // ** حساب المبلغ المتبقي بعد الدفعة المقدمة (إن وجدت) **
            $advance_payment = floatval($request->advance_payment ?? 0);
            $grand_total = $total_with_tax - $advance_payment;

            // ** حالة الفاتورة بناءً على المدفوعات والاستلام **
            $status = 1; // الحالة الافتراضية (مدفوع بالكامل)
            if ($advance_payment > 0) {
                if ($advance_payment < $total_with_tax) {
                    $status = 2; // مدفوع جزئيًا
                } else {
                    $status = 1; // مدفوع بالكامل
                    $grand_total = 0;
                }
            } elseif ($request->has('is_paid') && $request->has('is_received')) {
                $status = 4; // مدفوع ومستلم
                $grand_total = 0;
            } elseif ($request->has('is_paid')) {
                $status = 5; // مدفوع (غير مستلم)
                $grand_total = 0;
            } elseif ($request->has('is_received')) {
                $status = 3; // مستلم (غير مدفوع)
            }

            // ** الخطوة الرابعة: إنشاء الفاتورة في قاعدة البيانات **
            $purchaseOrderRequest = PurchaseInvoice::create([
                'supplier_id' => $request->supplier_id,
                'code' => $code,
                'type' => 1,
                'date' => $request->date,
                'terms' => $request->terms ?? 0,
                'notes' => $request->notes,
                'status' => $status,
                'created_by' => Auth::id(),
                'account_id' => $request->account_id,
                'discount_amount' => $invoice_discount, // تخزين الخصم الإضافي للفاتورة
                'discount_type' => $request->has('discount_type') ? ($request->discount_type === 'percentage' ? 2 : 1) : 1,
                'advance_payment' => $advance_payment,
                'payment_type' => $request->payment_type ?? 1,
                'shipping_cost' => $shipping_cost,
                'tax_type' => $request->tax_type ?? 1,
                'payment_method' => $request->payment_method,
                'reference_number' => $request->reference_number,
                'received_date' => $request->received_date,
                'is_paid' => $status == 2 || $status == 4,
                'is_received' => $request->has('is_received'),
                'subtotal' => $total_amount,
                'total_discount' => $final_total_discount, // تخزين الخصم الإجمالي
                'total_tax' => $total_tax + $shipping_tax, // إضافة ضريبة التوصيل إلى مجموع الضرائب
                'grand_total' => $grand_total,
            ]);

            // ** الخطوة الخامسة: إنشاء سجلات البنود (items) للفاتورة **
            foreach ($items_data as $item) {
                $item['purchase_invoice_id'] = $purchaseOrderRequest->id; // تعيين purchase_invoice_id
                InvoiceItem::create($item); // تخزين البند مع purchase_invoice_id
            }

            // ** معالجة المرفقات (attachments) إذا وجدت **
            if ($request->hasFile('attachments')) {
                $file = $request->file('attachments');
                if ($file->isValid()) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('assets/uploads/'), $filename);
                    $purchaseOrderRequest->attachments = $filename;
                    $purchaseOrderRequest->save();
                }
            }

            DB::commit(); // تأكيد التغييرات
            return redirect()->route('OrdersRequests.index')->with('success', 'تم إنشاء امر شراء  بنجاح');
        } catch (\Exception $e) {
            DB::rollback(); // تراجع عن التغييرات في حالة حدوث خطأ
            Log::error('خطأ في إنشاء   امر شراء   ' . $e->getMessage()); // تسجيل الخطأ
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'عذراً، حدث خطأ أثناء حفظ امر شراء   : ' . $e->getMessage());
        }
    }
    public function edit($id)
    {
        $purchaseOrdersRequests = PurchaseInvoice::findOrFail($id);
        $suppliers = Supplier::all();
        $items = Product::all();
        $accounts = Account::all();
        $users = User::all();
        return view('Purchases.Purchasing_order_requests.edit', compact('purchaseOrdersRequests', 'suppliers', 'accounts', 'users', 'items'));
    }
    public function update(Request $request, $id)
    {
        try {
            // تحويل نوع الخصم إلى رقم
            $discountType = $request->discount_type === 'percentage' ? 2 : 1; // 1 = ريال، 2 = نسبة مئوية

            DB::beginTransaction();

            $purchaseOrdersRequests = PurchaseInvoice::findOrFail($id);

            // تحديد حالة الفاتورة بناءً على الدفع والاستلام
            $status = 1; // الحالة الافتراضية: قيد المراجعة

            if ($request->has('is_paid') && $request->has('is_received')) {
                $status = 4; // مكتملة
            } elseif ($request->has('is_paid')) {
                $status = 2; // مدفوعة
            } elseif ($request->has('is_received')) {
                $status = 3; // مستلمة
            }

            // تحديث فاتورة الشراء
            $updateData = [
                'supplier_id' => $request->supplier_id ?? $purchaseOrdersRequests->supplier_id,
                'date' => $request->date ?? $purchaseOrdersRequests->date,
                'terms' => $request->terms ?? ($purchaseOrdersRequests->terms ?? 0),
                'notes' => $request->notes ?? $purchaseOrdersRequests->notes,
                'status' => $status,
                'account_id' => $request->account_id ?? $purchaseOrdersRequests->account_id,
                'discount_amount' => $request->discount_value ?? ($purchaseOrdersRequests->discount_amount ?? 0),
                'discount_type' => $discountType,
                'advance_payment' => $request->advance_payment ?? ($purchaseOrdersRequests->advance_payment ?? 0),
                'payment_type' => $request->amount ?? ($purchaseOrdersRequests->payment_type ?? 1),
                'shipping_cost' => $request->shipping_cost ?? ($purchaseInvoice->shipping_cost ?? 0),
                'tax_type' => $request->tax_type ?? ($purchaseInvoice->tax_type ?? 1),
                'payment_method' => $request->payment_method ?? $purchaseOrdersRequests->payment_method,

                'reference_number' => $request->reference_number ?? $purchaseOrdersRequests->reference_number,
                'received_date' => $request->received_date ?? $purchaseOrdersRequests->received_date,
                'is_paid' => $request->has('is_paid') ? true : $purchaseOrdersRequests->is_paid,
                'is_received' => $request->has('is_received') ? true : $purchaseOrdersRequests->is_received,
                'updated_at' => now(),
            ];

            $purchaseOrdersRequests->update($updateData);

            $total_amount = 0;
            $total_discount = 0;
            $total_tax = 0;

            // تحديث العناصر فقط إذا تم إرسالها
            if ($request->has('items')) {
                // حذف العناصر القديمة
                $purchaseOrdersRequests->invoiceItems()->delete();

                foreach ($request->items as $item) {
                    $product = Product::find($item['product_id'] ?? null);

                    // حساب المجموع للصف
                    $quantity = floatval($item['quantity'] ?? 0);
                    $unit_price = floatval($item['unit_price'] ?? 0);
                    $item_total = $quantity * $unit_price;

                    // حساب الخصم
                    $item_discount = 0;
                    $item_discount_type = isset($item['discount_type']) ? ($item['discount_type'] === 'percentage' ? 2 : 1) : 1;
                    $discount_amount = floatval($item['discount_amount'] ?? 0);

                    if ($item_discount_type == 2) {
                        $item_discount = ($item_total * $discount_amount) / 100;
                    } else {
                        $item_discount = $discount_amount;
                    }

                    // حساب الضرائب بعد الخصم
                    $amount_after_discount = $item_total - $item_discount;
                    $tax1 = floatval($item['tax_1'] ?? 0);
                    $tax2 = floatval($item['tax_2'] ?? 0);

                    $tax1_amount = $amount_after_discount * ($tax1 / 100);
                    $tax2_amount = $amount_after_discount * ($tax2 / 100);

                    $total_amount += $item_total;
                    $total_discount += $item_discount;
                    $total_tax += $tax1_amount + $tax2_amount;

                    // إنشاء عنصر الفاتورة
                    $purchaseOrdersRequests->invoiceItems()->create([
                        'purchase_invoice_id' => $purchaseOrdersRequests->id,
                        'purchase_invoice_id_type' => 2,
                        'product_id' => $item['product_id'],
                        'item' => $product->name ?? 'المنتج ' . $item['product_id'],
                        'description' => $item['description'] ?? null,
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'discount' => $item_discount,
                        'discount_type' => $item_discount_type,
                        'tax_1' => $item['tax_1'] ?? 0,
                        'tax_2' => $item['tax_2'] ?? 0,
                        'total' => $amount_after_discount + $tax1_amount + $tax2_amount,
                    ]);
                }
            }

            // معالجة المرفقات
            if ($request->hasFile('attachments')) {
                if ($purchaseOrdersRequests->attachments) {
                    $oldFile = public_path('assets/uploads/') . $purchaseOrdersRequests->attachments;
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }

                $file = $request->file('attachments');
                if ($file->isValid()) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('assets/uploads/'), $filename);
                    $purchaseOrdersRequests->attachments = $filename;
                    $purchaseOrdersRequests->save();
                }
            }

            // حساب الخصم الإضافي
            $additionalDiscount = 0;
            if ($discountType == 2) {
                $additionalDiscount = ($total_amount * ($request->discount_amount ?? 0)) / 100;
            } else {
                $additionalDiscount = $request->discount_amount ?? 0;
            }

            // حساب تكلفة الشحن والضريبة
            $shippingCost = $request->shipping_cost ?? ($purchaseInvoice->shipping_cost ?? 0);
            $shippingTax = 0;
            if (($request->tax_type ?? $purchaseOrdersRequests->tax_type) == 1) {
                $shippingTax = $shippingCost * 0.15;
            }

            // المبلغ بعد كل الخصومات
            $amount_after_all_discounts = $total_amount - $total_discount - $additionalDiscount;

            // حساب المبلغ النهائي
            $total_with_tax = $amount_after_all_discounts + $total_tax + $shippingCost + $shippingTax;

            // حساب المبلغ المتبقي بعد الدفعة المقدمة
            $advance_payment = floatval($request->advance_payment ?? 0);
            $grand_total = $total_with_tax - $advance_payment;

            // تحديث المجموع النهائي والخصم والضرائب
            $purchaseOrdersRequests->update([
                'subtotal' => $total_amount,
                'total_discount' => $total_discount + $additionalDiscount,
                'total_tax' => $total_tax + $shippingTax,
                'grand_total' => $grand_total,
            ]);

            DB::commit();

            return redirect()->route('purchaseOrders.index')->with('success', 'تم تحديث امر شراء بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('خطأ في تحديث امر شراء   : ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'عذراً، حدث خطأ أثناء تحديث امر شراء  : ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $purchaseOrdersRequests = PurchaseInvoice::findOrFail($id);
            $purchaseOrdersRequests->delete();
            return redirect()->route('OrdersRequests.index')->with('success', 'تم حذف أمر الشراء بنجاح');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'حدث خطاء في حذف أمر الشراء: ' . $e->getMessage());
        }
    }
    public function convertToInvoice($id)
    {
        try {
            $purchaseOrder = PurchaseInvoice::findOrFail($id);

            // تحديث النوع إلى فاتورة
            $purchaseOrder->type = 2;
            $purchaseOrder->save();

            return redirect()->back()->with('success', 'تم تحويل أمر الشراء إلى فاتورة بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء تحويل أمر الشراء');
        }
    }

    public function cancel($id)
    {
        try {
            $purchaseOrder = PurchaseInvoice::findOrFail($id);

            // إلغاء أمر الشراء
            $purchaseOrder->type = 3; // يمكنك تغيير هذا الرقم حسب حاجتك
            $purchaseOrder->save();

            return redirect()->back()->with('success', 'تم إلغاء أمر الشراء بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء إلغاء أمر الشراء');
        }
    }
    public function updateStatus(Request $request, $id)
{
    try {
        // البحث عن أمر الشراء
        $purchaseOrder = PurchaseInvoice::findOrFail($id);

        // تحديث النوع
        $purchaseOrder->type = $request->type;

        // إذا تم التحويل إلى فاتورة
        if ($request->type == 2) {
            // هنا يمكنك إضافة أي منطق إضافي عند التحويل إلى فاتورة
            // مثل إنشاء فاتورة جديدة أو تحديث المخزون
            $message = 'تم تحويل أمر الشراء إلى فاتورة بنجاح';
        }
        // إذا تم الإلغاء
        else if ($request->type == 3) {
            // هنا يمكنك إضافة أي منطق إضافي عند الإلغاء
            $message = 'تم إلغاء أمر الشراء بنجاح';
        }

        $purchaseOrder->save();

        return redirect()->back()->with('success', $message);
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'حدث خطأ أثناء تحديث أمر الشراء');
    }
}
}
