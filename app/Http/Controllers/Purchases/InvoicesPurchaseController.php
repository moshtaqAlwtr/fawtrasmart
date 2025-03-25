<?php

namespace App\Http\Controllers\Purchases;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\InvoiceItem;
use App\Models\JournalEntry;
use App\Models\JournalEntryDetail;
use App\Models\Log as ModelsLog;
use App\Models\PaymentsProcess;
use App\Models\Product;
use App\Models\ProductDetails;
use App\Models\PurchaseInvoice;
use App\Models\StoreHouse;
use App\Models\Supplier;
use App\Models\TaxSitting;
use App\Models\TaxInvoice;
use App\Models\AccountSetting;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
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
         $account_setting = AccountSetting::where('user_id', auth()->user()->id)->first();

        return view('Purchases.Invoices_purchase.index', compact('purchaseInvoices', 'suppliers', 'accounts', 'users','account_setting'));
    }


    public function create()
    {
        $suppliers = Supplier::all();
        $items = Product::all();
        $accounts = Account::all();
        $storeHouses = StoreHouse::all(); // إضافة المستودعات
        $taxs = TaxSitting::all();
         $account_setting = AccountSetting::where('user_id', auth()->user()->id)->first();

        return view('Purchases.Invoices_purchase.create', compact('suppliers', 'items','taxs', 'accounts', 'storeHouses','account_setting'));
    }

    public function store(Request $request)
    {
        // try {
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
                    $product = Product::findOrFail($item['product_id']);

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
                        'store_house_id' => $item['store_house_id'] ?? null, // إضافة معرف المستودع
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
          
             foreach ($request->items as $item) {
                $tax_1 = floatval($item['tax_1'] ?? 0); // الضريبة الأولى
                $tax_2 = floatval($item['tax_2'] ?? 0); // الضريبة الثانية

                // حساب الضريبة لكل بند
                $item_total = floatval($item['quantity']) * floatval($item['unit_price']);
                $item_tax = ($item_total * $tax_1) / 100 + ($item_total * $tax_2) / 100;

                // إضافة الضريبة إلى الإجمالي
                $total_tax += $item_tax;
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

            // ** الخطوة الرابعة: إنشاء الفاتورة في قاعدة البيانات **
            $purchaseInvoice = PurchaseInvoice::create([
                'supplier_id' => $request->supplier_id,
                'code' => $code,
                'type' => 2, // نوع الفاتورة: مشتريات
                'date' => $request->date,
                'terms' => $request->terms ?? 0,
                'notes' => $request->notes,
                'status' => 1, // مدفوع بالكامل
                'created_by' => Auth::id(),
                'account_id' => $request->account_id,
                'discount_amount' => $invoice_discount, // تخزين الخصم الإضافي للفاتورة
                'discount_type' => $request->has('discount_type') ? ($request->discount_type === 'percentage' ? 2 : 1) : 1,
                'payment_type' => $request->payment_type ?? 1,
                'shipping_cost' => $shipping_cost,
                'tax_type' => $request->tax_type ?? 1,
                'payment_method' => $request->payment_method,
                'reference_number' => $request->reference_number,
                'received_date' => $request->received_date,
                'is_paid' => true, // مدفوعة بالكامل
                'is_received' => true, // مستلمة
                'subtotal' => $total_amount,
                'total_discount' => $final_total_discount, // تخزين الخصم الإجمالي
                'total_tax' => $total_tax + $shipping_tax, // إضافة ضريبة التوصيل إلى مجموع الضرائب
                'grand_total' => $total_with_tax, // تخزين المبلغ الإجمالي الكامل
                'due_value' => 0, // لا توجد قيمة مستحقة لأن الفاتورة مدفوعة بالكامل
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
                    'invoice_id' => $purchaseInvoice->id,
                    'type' => $tax->type,
                    'rate' => $tax->tax,
                    'value' => $tax_value,
                    'type_invoice' => 'purchase',
                ]);
            }
        }
    }
}

            // ** الخطوة الخامسة: إنشاء سجلات البنود (items) للفاتورة **
            foreach ($items_data as $item) {
                $item['purchase_invoice_id'] = $purchaseInvoice->id; // تعيين purchase_invoice_id
                $invoiceItem = InvoiceItem::create($item); // تخزين البند مع purchase_invoice_id

                // ** الخطوة السادسة: تحديث كميات المنتجات في المستودع **
                // البحث عن المستودع الرئيسي إذا لم يتم تحديده
                $storeHouseId = $item['store_house_id'] ?? null;
                if (!$storeHouseId) {
                    $mainStoreHouse = StoreHouse::where('major', true)->first();
                    $storeHouseId = $mainStoreHouse ? $mainStoreHouse->id : null;
                }

                // إنشاء سجل تفاصيل المنتج لتتبع الحركة
                if ($storeHouseId) {
                    $invoice_purhase =    ProductDetails::create([
                        'product_id' => $item['product_id'],
                        'store_house_id' => $storeHouseId,
                        'quantity' => floatval($item['quantity']),
                        'unit_price' => floatval($item['unit_price']),
                        'date' => $request->date ? Carbon::parse($request->date) : now(),
                        'time' => now()->format('H:i:s'),
                        'type_of_operation' => 1, // إضافة كمية
                        'type' => 1, // إضافة كمية
                        'purchase_invoice_id' => $purchaseInvoice->id,
                        'comments' => 'إضافة كمية من فاتورة شراء رقم ' . $purchaseInvoice->code
                    ]);
                }

                $invoice_purhase->load('product');

                $Supplier = Supplier::find($request->supplier_id);

                // تسجيل اشعار نظام جديد لكل منتج
                ModelsLog::create([
                    'type' => 'purchase_log',
                    'type_id' => $purchaseInvoice->id, // ID النشاط المرتبط
                    'type_log' => 'log', // نوع النشاط
                    'icon'  => 'create',
                    'description' => sprintf(
                        'تم انشاء فاتورة شراء رقم **%s** للمنتج **%s** كمية **%s** بسعر **%s** للمورد **%s**',
                        $purchaseInvoice->code ?? "", // رقم طلب الشراء
                        $invoice_purhase->product->name ?? "", // اسم المنتج
                        $item['quantity'] ?? "", // الكمية
                        $item['unit_price'] ?? "",  // السعر
                        $Supplier->trade_name ?? "" // المورد (يتم استخدام %s للنصوص)
                    ),
                    'created_by' => auth()->id(), // ID المستخدم الحالي
                ]);
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

            // ** الخطوة السابعة: إنشاء عملية دفع تلقائية **
            $paymentData = [
                'purchases_id' => $purchaseInvoice->id,
                'supplier_id' => $request->supplier_id,
                'amount' => $total_with_tax, // المبلغ الكامل للفاتورة
                'payment_date' => $request->date ?? now(),
                'payment_method' => $request->payment_method ?? 1, // طريقة الدفع الافتراضية
                'type' => 'supplier payments', // نوع الدفعة: مدفوعات مورد
                'payment_status' => 1, // مكتمل
                'created_by' => Auth::id(),
                'notes' => 'دفعة تلقائية لفاتورة المشتريات رقم ' . $purchaseInvoice->code
            ];

            // إنشاء سجل الدفع
            $payment = PaymentsProcess::create($paymentData);

             //القيود
             DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
          // إنشاء القيد المحاسبي للفاتورة
          $journalEntry = JournalEntry::create([
            'reference_number' => $purchaseInvoice->code,
            'date' => now(),
            'description' => 'فاتورة شراء رقم ' . $purchaseInvoice->code,
            'status' => 1,
            'currency' => 'SAR',
            'client_id' => $purchaseInvoice->supplier_id,
            // 'invoice_id' => $purchaseInvoice->id,
            'created_by_employee' => Auth::id(),
        ]);

        // # القيد الاول
        $supplieraccounts = Account::where('supplier_id', $purchaseInvoice->supplier_id)->first();
        // إضافة تفاصيل القيد المحاسبي
        // 1. حساب المورد (دائن)
        JournalEntryDetail::create([
            'journal_entry_id' => $journalEntry->id,
            'account_id' => $supplieraccounts->id, // حساب العميل
            'description' => 'فاتورة شراء # ' . $purchaseInvoice->code,
            'debit' => 0,
            'credit' => $total_with_tax,// المبلغ الكلي للفاتورة دائن)
            'is_debit' => false,
        ]);


        $mainstore = Account::where('name','المخزون')->first();
        // 2. حساب المخزون (مدين)
        JournalEntryDetail::create([
            'journal_entry_id' => $journalEntry->id,
            'account_id' => $mainstore->id, // حساب المخزون الرئيسي
            'description' => ' فاتورة شراء # ' . $purchaseInvoice->code,
            'debit' => $total_with_tax, //مدين
            'credit' => 0,
            'is_debit' => true,
        ]);



        $tax_total =   $total_tax + $shipping_tax;

        // $taxaccounts = Account::where('name','القيمة المضافة المدفوعة')->first();
        // // 3. حساب القيمة المضافة المدفوعه (مدين)
        // JournalEntryDetail::create([
        //     'journal_entry_id' => $journalEntry->id,
        //     'account_id' => $taxaccounts->id, // حساب القيمة المضافة المحصلة
        //      'description' => ' القيمه المضافه المدفوعه فاتورة شراء # ' . $purchaseInvoice->code,
        //     'debit' => $tax_total,
        //     'credit' => 0, // قيمة الضريبة ()
        //     'is_debit' => true,
        // ]);

        // # القيد الثاني

        $journalEntry = JournalEntry::create([
            'reference_number' => $purchaseInvoice->code,
            'date' => now(),
            'description' => 'دفع للمورد' . $purchaseInvoice->supplier_id,
            'status' => 1,
            'currency' => 'SAR',
            'client_id' => $purchaseInvoice->supplier_id,
            // 'invoice_id' => $purchaseInvoice->id,
            'created_by_employee' => Auth::id(),
        ]);

        // // # القيد الاول
        $supplieraccounts = Account::where('supplier_id', $purchaseInvoice->supplier_id)->first();
        // إضافة تفاصيل القيد المحاسبي
        // 1. حساب المورد (دائن)
        JournalEntryDetail::create([
            'journal_entry_id' => $journalEntry->id,
            'account_id' => $supplieraccounts->id, // حساب المورد
            'description' => 'دفع للمورد' . $purchaseInvoice->supplier_id,
            'debit' => $total_with_tax, //مدين
            'credit' => 0,
            'is_debit' => true,
        ]);


        $MainTreasury = Account::where('name', 'الخزينة الرئيسية')->first();
        // 2. حساب الخزينة (مدين)
        JournalEntryDetail::create([
            'journal_entry_id' => $journalEntry->id,
            'account_id' => $MainTreasury->id, // حساب المبيعات
           'description' => 'دفع للمورد' . $purchaseInvoice->supplier_id,
            'debit' => 0, //مدين
            'credit' => $total_with_tax,
            'is_debit' => false,
        ]);

        // // الخزينة الرئيسية
        if ($MainTreasury) {
            $amount = $total_with_tax;
            $MainTreasury->balance += $amount;

            $MainTreasury->save();

            // تحديث جميع الحسابات الرئيسية المتصلة به
            //

         }

           // حساب المورد
        if ($supplieraccounts) {
            $amount = $total_with_tax;
            $supplieraccounts->balance += $amount;

            $supplieraccounts->save();

            // تحديث جميع الحسابات الرئيسية المتصلة به
            // $this->updateParentBalanceMainTreasury($MainTreasury->parent_id, $amount);
         }

            // القيمة المضافه المدفوعة
        // if ($taxaccounts) {
        //     $amount = $tax_total;
        //     $taxaccounts->balance += $amount;
        //     $taxaccounts->save();

        //     // تحديث جميع الحسابات الرئيسية المتصلة به
        //     $this->updateParentBalanceMainTreasury($MainTreasury->parent_id, $amount);
        //  }

         // المخزون الرئيسي
         if ($mainstore) {
            $amount = $total_with_tax;
            $mainstore->balance += $amount;
            $mainstore->save();

            // تحديث جميع الحسابات الرئيسية المتصلة به
        //    $this->updateParentBalanceMainTreasury($MainTreasury->parent_id, $amount);
         }

            DB::commit(); // تأكيد التغييرات
            return redirect()->route('invoicePurchases.index')->with('success', 'تم إنشاء فاتورة المشتريات وعملية الدفع بنجاح');
        // } catch (\Exception $e) {
            DB::rollback(); // تراجع عن التغييرات في حالة حدوث خطأ
            Log::error('خطأ في إنشاء فاتورة المشتريات والدفع: ' . $e->getMessage()); // تسجيل الخطأ
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'عذراً، حدث خطأ أثناء حفظ فاتورة المشتريات والدفع: ' . $e->getMessage());
        // }
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
                    $invoice_purhase =   $purchaseInvoice->invoiceItems()->create([
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
                $invoice_purhase->load('product');

                $Supplier = Supplier::find($request->supplier_id);

                // تسجيل اشعار نظام جديد لكل منتج
                ModelsLog::create([
                    'type' => 'purchase_log',
                    'type_id' => $purchaseInvoice->id, // ID النشاط المرتبط
                    'type_log' => 'log', // نوع النشاط
                    'icon'  => 'create',
                    'description' => sprintf(
                        'تم تعديل فاتورة شراء رقم **%s** للمنتج **%s** كمية **%s** بسعر **%s** للمورد **%s**',
                        $purchaseInvoice->code ?? "", // رقم طلب الشراء
                        $invoice_purhase->product->name ?? "", // اسم المنتج
                        $item['quantity'] ?? "", // الكمية
                        $item['unit_price'] ?? "",  // السعر
                        $Supplier->trade_name ?? "" // المورد (يتم استخدام %s للنصوص)
                    ),
                    'created_by' => auth()->id(), // ID المستخدم الحالي
                ]);

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
             ModelsLog::create([
                'type' => 'purchase_log',
                'type_id' => $purchaseOrder->id, // ID النشاط المرتبط
                'type_log' => 'log', // نوع النشاط
                'icon'  => 'delete',
                'description' => sprintf(
                    'تم حذف فاتورة شراء رقم **%s**',
                    $purchaseOrder->code ?? "" ,// رقم طلب الشراء
                ),
                'created_by' => auth()->id(), // ID المستخدم الحالي
            ]);
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
 $TaxsInvoice = TaxInvoice::where('invoice_id', $id)->where('type_invoice', 'purchase')->get();
    return view('Purchases.Invoices_purchase.show', compact('purchaseInvoice','TaxsInvoice'));
}
}
