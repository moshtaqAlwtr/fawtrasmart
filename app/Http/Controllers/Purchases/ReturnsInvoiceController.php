<?php

namespace App\Http\Controllers\Purchases;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\InvoiceItem;
use App\Models\JournalEntry;
use App\Models\JournalEntryDetail;
use App\Models\Product;
use App\Models\PurchaseInvoice;
use App\Models\Supplier;
use App\Models\TaxSitting;
use App\Models\TaxInvoice;
use App\Models\AccountSetting;

use App\Models\Log as ModelsLog;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Commands\Show;

class ReturnsInvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = PurchaseInvoice::query()
            ->with(['supplier', 'creator', 'items'])
            ->where('type', 3); // مرتجع المشتريات

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
                $query->where('type', 3);
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
        $invoices = $query->paginate(10);
        $suppliers = Supplier::all();
        $users = User::all();
          $account_setting = AccountSetting::where('user_id', auth()->user()->id)->first();

        return view('Purchases.Returns.index', compact('invoices','account_setting', 'suppliers', 'users'));
    }
    public function create()
    {
        $suppliers = Supplier::all();
        $items = Product::all();
        $taxs = TaxSitting::all();
       $account_setting = AccountSetting::where('user_id', auth()->user()->id)->first();

        return view('Purchases.Returns.create', compact('suppliers','taxs','account_setting', 'items'));
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
 $total_tax = 0;
          
             foreach ($request->items as $item) {
                $tax_1 = floatval($item['tax_1'] ?? 0); // الضريبة الأولى
                $tax_2 = floatval($item['tax_2'] ?? 0); // الضريبة الثانية

                // حساب الضريبة لكل بند
                $item_total = floatval($item['quantity']) * floatval($item['unit_price']);
                $item_tax = ($item_total * $tax_1) / 100 + ($item_total * $tax_2) / 100;

                // إضافة الضريبة إلى الإجمالي
                $total_tax += $item_tax;
            }
            
            // الخصومات الإجمالية
            $final_total_discount = $total_discount + $invoice_discount;

            // حساب المبلغ بعد الخصم
            $amount_after_discount = $total_amount - $final_total_discount;

            // ** حساب الضرائب **
            // $total_tax = 0;
            // if ($request->tax_type == 1) {
            //     $total_tax = $amount_after_discount * 0.15; // نسبة الضريبة 15%
            // }

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
            $purchaseInvoiceReturn = PurchaseInvoice::create([
                'supplier_id' => $request->supplier_id,
                'code' => $code,
                'type' => 3,
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

 foreach ($request->items as $item) {
    // حساب الإجمالي لكل منتج (السعر × الكمية)
    $item_subtotal = $item['unit_price'] * $item['quantity']; 

    // حساب الضرائب بناءً على البيانات القادمة من `request`
    $tax_ids = ['tax_1_id', 'tax_2_id']; 
    foreach ($tax_ids as $tax_id) {
        if (!empty($item[$tax_id])) { // التحقق مما إذا كان هناك ضريبة
            $tax = TaxSitting::find($item[$tax_id]); 
            
            if ($tax) {
                $tax_value = ($tax->tax / 100) * $item_subtotal; // حساب قيمة الضريبة

                // حفظ الضريبة في جدول TaxInvoice
                TaxInvoice::create([
                    'name' => $tax->name,
                    'invoice_id' => $purchaseInvoiceReturn->id,
                    'type' => $tax->type,
                    'rate' => $tax->tax,
                    'value' => $tax_value,
                    'type_invoice' => 'InvoiceReturn_purchase',
                ]);
            }
        }
    }
}
            // ** الخطوة الخامسة: إنشاء سجلات البنود (items) للفاتورة **
            foreach ($items_data as $item) {
                $item['purchase_invoice_id'] = $purchaseInvoiceReturn->id; // تعيين purchase_invoice_id
                $invoice_purhase =  InvoiceItem::create($item); // تخزين البند مع purchase_invoice_id

                $invoice_purhase->load('product');

                $Supplier = Supplier::find($request->supplier_id);

                // تسجيل اشعار نظام جديد لكل منتج
                ModelsLog::create([
                    'type' => 'purchase_log',
                    'type_id' => $purchaseInvoiceReturn->id, // ID النشاط المرتبط
                    'type_log' => 'log', // نوع النشاط
                    'icon'  => 'create',
                    'description' => sprintf(
                        'تم انشاء مرتجع شراء رقم **%s** للمنتج **%s** كمية **%s** بسعر **%s** للمورد **%s** لفاتورة رقم **%s**',
                        $purchaseInvoiceReturn->code ?? "", // رقم مرتجع الشراء
                        $invoice_purhase->product->name ?? "", // اسم المنتج
                        $item['quantity'] ?? "", // الكمية
                        $item['unit_price'] ?? "",  // السعر
                        $Supplier->trade_name ?? "", // المورد
                        $request->reference_number ?? "" // رقم الفاتورة المرجعية
                    ),
                    'created_by' => auth()->id(), // ID المستخدم الحالي
                ]);
            }
            
            $supplieraccounts = Account::where('supplier_id', $purchaseInvoiceReturn->supplier_id)->first();
            $journalEntry = JournalEntry::create([
                'reference_number' => $purchaseInvoiceReturn->id,
                'date' => now(),
                'description' => 'مرتجع مشتريات رقم' . $purchaseInvoiceReturn->id,
                'status' => 1,
                'currency' => 'SAR',
               
                //  'invoice_id' => $purchaseInvoiceReturn->id,
                'created_by_employee' => Auth::id(),
            ]);


                  // // 2. حساب المورد (مدين)
                  JournalEntryDetail::create([
                    'journal_entry_id' => $journalEntry->id,
                    'account_id' => $supplieraccounts->id, // حساب المبيعات
                    'description' => 'مرتجع مشتريات',
                    'debit' => $purchaseInvoiceReturn->grand_total, // المبلغ بعد الخصم (مدين)
                    'credit' => 0, 
                    'is_debit' => false,
                ]);
    
                $mainstore = Account::where('name','المخزون')->first();
                   // // 2. حساب المخزون (دائن)
                   JournalEntryDetail::create([
                    'journal_entry_id' => $journalEntry->id,
                    'account_id' => $mainstore->id, // حساب المبيعات
                    'description' => 'مرتجع مشتريات',
                    'debit' => 0,
                    'credit' => $purchaseInvoiceReturn->grand_total, // المبلغ بعد الخصم (دائن)
                    'is_debit' => false,
                ]);

                 if ($mainstore) {
                $amount = $purchaseInvoiceReturn->grand_total; 
                $mainstore->balance -= $amount;
         
                        $mainstore->save();
                 }

                 if ($supplieraccounts) {
                    $amount = $supplieraccounts->grand_total; 
                    $mainstore->balance += $amount;
             
                            $supplieraccounts->save();
                     }
            // ** معالجة المرفقات (attachments) إذا وجدت **
            if ($request->hasFile('attachments')) {
                $file = $request->file('attachments');
                if ($file->isValid()) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('assets/uploads/'), $filename);
                    $purchaseInvoiceReturn->attachments = $filename;
                    $purchaseInvoiceReturn->save();
                }
            }

            DB::commit(); // تأكيد التغييرات
            return redirect()->route('ReturnsInvoice.index')->with('success', 'تم إنشاء فاتورة المشتريات بنجاح');
        } catch (\Exception $e) {
            DB::rollback(); // تراجع عن التغييرات في حالة حدوث خطأ
            Log::error('خطأ في إنشاء مرتجع المشتريات: ' . $e->getMessage()); // تسجيل الخطأ
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'عذراً، حدث خطأ أثناء حفظ مرتجع المشتريات: ' . $e->getMessage());
        }
    }
    public function edit($id)
    {
        $purchaseRentalInvoice = purchaseInvoice::findOrFail($id);
        $suppliers = Supplier::all();
        $items = Product::all();

        return view('Purchases.Returns.edit', compact('purchaseRentalInvoice', 'suppliers', 'items'));
    }
    public function update(Request $request, $id)
    {
        try {
            // تحويل نوع الخصم إلى رقم
            $discountType = $request->discount_type === 'percentage' ? 2 : 1; // 1 = ريال، 2 = نسبة مئوية

            DB::beginTransaction();

            $purchaseInvoiceReturn = PurchaseInvoice::findOrFail($id);

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
                'supplier_id' => $request->supplier_id ?? $purchaseInvoiceReturn->supplier_id,
                'date' => $request->date ?? $purchaseInvoiceReturn->date,
                'terms' => $request->terms ?? ($purchaseInvoiceReturn->terms ?? 0),
                'notes' => $request->notes ?? $purchaseInvoiceReturn->notes,
                'status' => $status,
                'account_id' => $request->account_id ?? $purchaseInvoiceReturn->account_id,
                'discount_amount' => $request->discount_value ?? ($purchaseInvoiceReturn->discount_amount ?? 0),
                'discount_type' => $discountType,
                'advance_payment' => $request->advance_payment ?? ($purchaseInvoiceReturn->advance_payment ?? 0),
                'payment_type' => $request->amount ?? ($purchaseInvoiceReturn->payment_type ?? 1),
                'shipping_cost' => $request->shipping_cost ?? ($purchaseInvoice->shipping_cost ?? 0),
                'tax_type' => $request->tax_type ?? ($purchaseInvoice->tax_type ?? 1),
                'payment_method' => $request->payment_method ?? $purchaseInvoiceReturn->payment_method,

                'reference_number' => $request->reference_number ?? $purchaseInvoiceReturn->reference_number,
                'received_date' => $request->received_date ?? $purchaseInvoiceReturn->received_date,
                'is_paid' => $request->has('is_paid') ? true : $purchaseInvoiceReturn->is_paid,
                'is_received' => $request->has('is_received') ? true : $purchaseInvoiceReturn->is_received,
                'updated_at' => now(),
            ];

            $purchaseInvoiceReturn->update($updateData);

            $total_amount = 0;
            $total_discount = 0;
            $total_tax = 0;

            // تحديث العناصر فقط إذا تم إرسالها
            if ($request->has('items')) {
                // حذف العناصر القديمة
                $purchaseInvoiceReturn->invoiceItems()->delete();

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
                    $invoice_purhase =        $purchaseInvoiceReturn->invoiceItems()->create([
                        'purchase_invoice_id' => $purchaseInvoiceReturn->id,
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
                $invoice_purhase->load('product');

                $Supplier = Supplier::find($request->supplier_id);

                // تسجيل اشعار نظام جديد لكل منتج
                ModelsLog::create([
                    'type' => 'purchase_log',
                    'type_id' => $purchaseInvoiceReturn->id, // ID النشاط المرتبط
                    'type_log' => 'log', // نوع النشاط
                    'icon'  => 'create',
                    'description' => sprintf(
                        'تم تعديل مرتجع شراء رقم **%s** للمنتج **%s** كمية **%s** بسعر **%s** للمورد **%s** لفاتورة رقم **%s**',
                        $purchaseInvoiceReturn->code ?? "", // رقم مرتجع الشراء
                        $invoice_purhase->product->name ?? "", // اسم المنتج
                        $item['quantity'] ?? "", // الكمية
                        $item['unit_price'] ?? "",  // السعر
                        $Supplier->trade_name ?? "", // المورد
                        $request->reference_number ?? "" // رقم الفاتورة المرجعية
                    ),
                    'created_by' => auth()->id(), // ID المستخدم الحالي
                ]);
            }

            // معالجة المرفقات
            if ($request->hasFile('attachments')) {
                if ($purchaseInvoiceReturn->attachments) {
                    $oldFile = public_path('assets/uploads/') . $purchaseInvoiceReturn->attachments;
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }

                $file = $request->file('attachments');
                if ($file->isValid()) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('assets/uploads/'), $filename);
                    $purchaseInvoiceReturn->attachments = $filename;
                    $purchaseInvoiceReturn->save();
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
            if (($request->tax_type ?? $purchaseInvoiceReturn->tax_type) == 1) {
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
            $purchaseInvoiceReturn->update([
                'subtotal' => $total_amount,
                'total_discount' => $total_discount + $additionalDiscount,
                'total_tax' => $total_tax + $shippingTax,
                'grand_total' => $grand_total,
            ]);

            DB::commit();

            return redirect()->route('ReturnsInvoice.index')->with('success', 'تم تحديث فاتورة المشتريات بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('خطأ في تحديث مرتجع  المشتريات: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'عذراً، حدث خطأ أثناء تحديث مرتجع  المشتريات: ' . $e->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $purchaseOrder = PurchaseInvoice::findOrFail($id);
            ModelsLog::create([
                'type' => 'purchase_log',
                'type_id' => $purchaseOrder->id, // ID النشاط المرتبط
                'type_log' => 'log', // نوع النشاط
                'icon'  => 'delete',
                'description' => sprintf(
                    'تم حذف مرتجع شراء رقم **%s**',
                    $purchaseOrder->code ?? "", // رقم طلب الشراء
                ),
                'created_by' => auth()->id(), // ID المستخدم الحالي
            ]);
            $purchaseOrder->delete();
            return redirect()->route('ReturnsInvoice.index')->with('success', 'تم حذف مرتجع المشتريات بنجاح');
        } catch (\Exception $e) {
            Log::error('خطأ في حذف مرتجع المشتريات: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'عذراً، حدث خطأ أثناء حذف مرتجع المشتريات: ' . $e->getMessage());
        }
    }
    public function Show($id)
    {
        $purchaseInvoiceReturn = PurchaseInvoice::with([
            'invoiceItems' => function ($query) use ($id) {
                $query->where('purchase_invoice_id', $id);
            },
            'invoiceItems.product',
            'supplier',
        ])->findOrFail($id);

        return view('Purchases.Returns.show', compact('purchaseInvoiceReturn'));
    }
    public function pdf($id)
    {
        $purchaseRentalInvoice = PurchaseInvoice::with(['items.product'])->findOrFail($id);
        $pdf = Pdf::loadView('Purchases.Returns.pdf', compact('purchaseRentalInvoice'));
        return $pdf->download('مرتجع_مشتريات.pdf');
    }
}
