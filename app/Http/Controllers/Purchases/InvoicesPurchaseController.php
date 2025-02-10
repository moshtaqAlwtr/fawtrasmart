<?php

namespace App\Http\Controllers\Purchases;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\PurchaseInvoice;
use App\Models\Supplier;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InvoicesPurchaseController extends Controller
{
    public function index(Request $request)
    {
        $query = PurchaseInvoice::query();

        // البحث حسب المورد
        if ($request->filled('employee_search')) {
            $query->where('supplier_id', $request->employee_search);
        }

        // البحث برقم الفاتورة
        if ($request->filled('number_invoice')) {
            $query->where('code', 'LIKE', '%' . $request->number_invoice . '%');
        }

        // البحث حسب حالة الدفع
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // البحث حسب المستخدم الذي أضاف الفاتورة
        if ($request->filled('created_by')) {
            $query->where('created_by', $request->created_by);
        }

        // البحث حسب الوسم
        if ($request->filled('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('tag_id', $request->tag);
            });
        }

        // البحث في البنود
        if ($request->filled('description')) {
            $query->whereHas('items', function ($q) use ($request) {
                $q->where('description', 'LIKE', '%' . $request->description . '%');
            });
        }

        // البحث حسب المصدر
        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        // البحث حسب حالة التسليم
        if ($request->filled('delivery_status')) {
            $query->where('delivery_status', $request->delivery_status);
        }

        // البحث حسب التاريخ
        if ($request->filled('start_date_from')) {
            $query->whereDate('date', '>=', $request->start_date_from);
        }
        if ($request->filled('start_date_to')) {
            $query->whereDate('date', '<=', $request->start_date_to);
        }

        // البحث حسب تاريخ الإنشاء
        if ($request->filled('created_at_from')) {
            $query->whereDate('created_at', '>=', $request->created_at_from);
        }
        if ($request->filled('created_at_to')) {
            $query->whereDate('created_at', '<=', $request->created_at_to);
        }

        // تحميل العلاقات
        $purchaseInvoices = $query->latest()->get();
        // تحميل البيانات الأخرى المطلوبة
        $suppliers = Supplier::all();
        $accounts = Account::all();
        $users = User::all();

        return view('Purchases.Invoices_purchase.index', compact('purchaseInvoices', 'suppliers', 'accounts', 'users'));
    }


    public function create()
    {
        $suppliers = Supplier::all();
        $items = Product::all();
        $accounts = Account::all();

        return view('Purchases.Invoices_purchase.create', compact('suppliers', 'items', 'accounts'));
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
            $purchaseInvoice = PurchaseInvoice::create([
                'supplier_id' => $request->supplier_id,
                'code' => $code,
                'type' => 2,
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
                $item['purchase_invoice_id'] = $purchaseInvoice->id; // تعيين purchase_invoice_id
                InvoiceItem::create($item); // تخزين البند مع purchase_invoice_id
            }

            // ** معالجة المرفقات (attachments) إذا وجدت **
            if ($request->hasFile('attachments')) {
                $file = $request->file('attachments');
                if ($file->isValid()) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('assets/uploads/'), $filename);
                    $purchaseInvoice->attachments = $filename;
                    $purchaseInvoice->save();
                }
            }

            DB::commit(); // تأكيد التغييرات
            return redirect()->route('invoicePurchases.index')->with('success', 'تم إنشاء فاتورة المشتريات بنجاح');
        } catch (\Exception $e) {
            DB::rollback(); // تراجع عن التغييرات في حالة حدوث خطأ
            Log::error('خطأ في إنشاء فاتورة المشتريات: ' . $e->getMessage()); // تسجيل الخطأ
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'عذراً، حدث خطأ أثناء حفظ فاتورة المشتريات: ' . $e->getMessage());
        }
    }
    public function edit($id)
    {
        $purchaseRentalInvoice = PurchaseInvoice::findOrFail($id);
        $suppliers = Supplier::all();
        $items = Product::all();
        $accounts = Account::all();

        return view('Purchases.Invoices_purchase.edit', compact('purchaseRentalInvoice', 'suppliers', 'items', 'accounts'));
    }

    public function update(Request $request, $id)
    {
        try {
            // تحويل نوع الخصم إلى رقم
            $discountType = $request->discount_type === 'percentage' ? 2 : 1; // 1 = ريال، 2 = نسبة مئوية

            DB::beginTransaction();

            $purchaseInvoice = PurchaseInvoice::findOrFail($id);

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
                'supplier_id' => $request->supplier_id ?? $purchaseInvoice->supplier_id,
                'date' => $request->date ?? $purchaseInvoice->date,
                'terms' => $request->terms ?? ($purchaseInvoice->terms ?? 0),
                'notes' => $request->notes ?? $purchaseInvoice->notes,
                'status' => $status,
                'account_id' => $request->account_id ?? $purchaseInvoice->account_id,
                'discount_amount' => $request->discount_value ?? ($purchaseInvoice->discount_amount ?? 0),
                'discount_type' => $discountType,
                'advance_payment' => $request->advance_payment ?? ($purchaseInvoice->advance_payment ?? 0),
                'payment_type' => $request->amount ?? ($purchaseInvoice->payment_type ?? 1),
                'shipping_cost' => $request->shipping_cost ?? ($purchaseInvoice->shipping_cost ?? 0),
                'tax_type' => $request->tax_type ?? ($purchaseInvoice->tax_type ?? 1),
                'payment_method' => $request->payment_method ?? $purchaseInvoice->payment_method,
                'reference_number' => $request->reference_number ?? $purchaseInvoice->reference_number,
                'received_date' => $request->received_date ?? $purchaseInvoice->received_date,
                'is_paid' => $request->has('is_paid') ? true : $purchaseInvoice->is_paid,
                'is_received' => $request->has('is_received') ? true : $purchaseInvoice->is_received,
                'updated_at' => now(),
            ];

            $purchaseInvoice->update($updateData);

            $total_amount = 0;
            $total_discount = 0;
            $total_tax = 0;

            // تحديث العناصر فقط إذا تم إرسالها
            if ($request->has('items')) {
                // حذف العناصر القديمة
                $purchaseInvoice->invoiceItems()->delete();

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
                    $purchaseInvoice->invoiceItems()->create([
                        'purchase_invoice_id' => $purchaseInvoice->id,
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
                if ($purchaseInvoice->attachments) {
                    $oldFile = public_path('assets/uploads/') . $purchaseInvoice->attachments;
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }

                $file = $request->file('attachments');
                if ($file->isValid()) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('assets/uploads/'), $filename);
                    $purchaseInvoice->attachments = $filename;
                    $purchaseInvoice->save();
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
            if (($request->tax_type ?? $purchaseInvoice->tax_type) == 1) {
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
            $purchaseInvoice->update([
                'subtotal' => $total_amount,
                'total_discount' => $total_discount + $additionalDiscount,
                'total_tax' => $total_tax + $shippingTax,
                'grand_total' => $grand_total,
            ]);

            DB::commit();

            return redirect()->route('invoicePurchases.index')->with('success', 'تم تحديث فاتورة المشتريات بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('خطأ في تحديث فاتورة المشتريات: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'عذراً، حدث خطأ أثناء تحديث فاتورة المشتريات: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $purchaseOrder = PurchaseInvoice::findOrFail($id);
            $purchaseOrder->delete();
            return redirect()->route('invoicePurchases.index')->with('success', 'تم حذف فاتورة المشتريات بنجاح');
        } catch (\Exception $e) {
            Log::error('خطأ في حذف فاتورة المشتريات: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'عذراً، حدث خطأ أثناء حذف فاتورة المشتريات: ' . $e->getMessage());
        }
    }
    public function exportPDF($id)
    {
        try {
            $purchaseOrder = PurchaseInvoice::with(['supplier', 'account', 'items.product', 'creator'])->findOrFail($id);

            $pdf = Pdf::loadView('Purchases.view_purchase_price.pdf', compact('purchaseOrder'));

            return $pdf->download('عرض- فاتورة شراء -' . $purchaseOrder->code . '.pdf');
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ أثناء تصدير PDF: ' . $e->getMessage());
        }
    }

    public function convertToCreditMemo($id)
    {
        $purchaseOrder = PurchaseInvoice::findOrFail($id);
        $purchaseOrder->update([
            'type' => 3,
        ]);
        return redirect()->route('invoicePurchases.index')->with('success', 'تم تحويل فاتورة المشتريات الى مرتجع مدفوعة بنجاح');
    }
    public function Show($id)
{
    $purchaseInvoice = PurchaseInvoice::with([
        'invoiceItems' => function ($query) {
            $query->where('purchase_invoice_id');
        },
        'invoiceItems.product',
        'supplier',
    ])->findOrFail($id);

    return view('Purchases.Invoices_purchase.show', compact('purchaseInvoice'));
}
}
