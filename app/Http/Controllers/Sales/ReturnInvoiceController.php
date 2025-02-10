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
        $invoice = Invoice::findOrFail($id);
        $invoice_number = $this->generateInvoiceNumber();
        $items = Product::all();
        $clients = Client::all();
        $treasury = Treasury::all();
        $invoiceType = 'returned'; // نوع الفاتورة مرتجعة
        $users = User::all();

        return view('sales.retend_invoice.create', compact('clients', 'items', 'treasury', 'invoice_number', 'users', 'invoiceType', 'invoice'));
    }
    private function generateInvoiceNumber()
    {
        $lastInvoice = Invoice::latest()->first();
        $nextId = $lastInvoice ? $lastInvoice->id + 1 : 1;
        return str_pad($nextId, 6, '0', STR_PAD_LEFT);
    }

    public function store(Request $request)
    {
        try {
            // تحقق مما إذا كانت هناك فاتورة مرتجعة موجودة بالفعل لنفس الفاتورة الأصلية
            $existingReturnInvoice = Invoice::where('code', $request->code)->where('type', 'returned')->first();

            if ($existingReturnInvoice) {
                return redirect()->back()->withInput()->with('error', 'تم إنشاء مرتجع مسبقاً لهذه الفاتورة. لا يمكن إنشاء مرتجع آخر.');
            }

            // ** الخطوة الأولى: إنشاء كود للفاتورة **
            $code = $request->code;
            if (!$code) {
                do {
                    $lastOrder = Invoice::where('type', 'returned')->orderBy('id', 'desc')->first();
                    $nextNumber = $lastOrder ? intval(substr($lastOrder->code, 4)) + 1 : 1; // Extract number from code
                    $code = 'RET-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
                } while (Invoice::where('code', $code)->exists());
            } else {
                $existingCode = Invoice::where('code', $code)->exists();
                if ($existingCode) {
                    return redirect()->back()->withInput()->with('error', 'رقم المرتجع موجود مسبقاً، الرجاء استخدام رقم آخر');
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
                    // التحقق من وجود product_id في البند
                    if (!isset($item['product_id'])) {
                        throw new \Exception('معرف المنتج (product_id) مطلوب لكل بند.');
                    }

                    // جلب المنتج
                    $product = Product::find($item['product_id']);
                    if (!$product) {
                        throw new \Exception('المنتج غير موجود: ' . $item['product_id']);
                    }

                    // التحقق من وجود store_house_id في جدول store_houses
                    $store_house_id = $item['store_house_id'] ?? null;

                    // البحث عن المستودع
                    $storeHouse = null;
                    if ($store_house_id) {
                        // البحث عن المستودع المحدد
                        $storeHouse = StoreHouse::find($store_house_id);
                    }

                    if (!$storeHouse) {
                        // إذا لم يتم العثور على المستودع المحدد، ابحث عن أول مستودع متاح
                        $storeHouse = StoreHouse::first();
                        if (!$storeHouse) {
                            throw new \Exception('لا يوجد أي مستودع في النظام. الرجاء إضافة مستودع واحد على الأقل.');
                        }
                        $store_house_id = $storeHouse->id;
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
                        'invoice_id' => null, // سيتم تعيينه لاحقًا بعد إنشاء الفاتورة
                        'product_id' => $item['product_id'],
                        'store_house_id' => $store_house_id,
                        'item' => $product->name ?? 'المنتج ' . $item['product_id'],
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
            $tax_total = 0;
            if ($request->tax_type == 1) {
                // حساب الضريبة على المبلغ بعد الخصم
                $tax_total = $amount_after_discount * 0.15; // نسبة الضريبة 15%
            }

            // ** إضافة تكلفة الشحن (إذا وجدت) **
            $shipping_cost = floatval($request->shipping_cost ?? 0);

            // ** حساب ضريبة الشحن (إذا كانت الضريبة مفعلة) **
            $shipping_tax = 0;
            if ($request->tax_type == 1) {
                $shipping_tax = $shipping_cost * 0.15; // ضريبة الشحن 15%
            }

            // ** إضافة ضريبة الشحن إلى tax_total **
            $tax_total += $shipping_tax;

            // ** الحساب النهائي للمجموع الكلي **
            $total_with_tax = $amount_after_discount + $tax_total + $shipping_cost;

            // ** حساب المبلغ المستحق (due_value) بعد خصم الدفعة المقدمة **
            $advance_payment = floatval($request->advance_payment ?? 0);
            $due_value = $total_with_tax - $advance_payment;

            // ** تحديد حالة الفاتورة بناءً على المدفوعات **
            $payment_status = 3; // الحالة الافتراضية (مسودة)
            $is_paid = false;

            if ($advance_payment > 0 || $request->has('is_paid')) {
                // حساب إجمالي المدفوعات
                $total_payments = $advance_payment;

                if ($request->has('is_paid') && $request->is_paid) {
                    $total_payments = $total_with_tax;
                    $advance_payment = $total_with_tax;
                    $due_value = 0;
                    $payment_status = 1; // مكتمل
                    $is_paid = true;
                } else {
                    // إذا كان هناك دفعة مقدمة لكن لم يتم اكتمال المبلغ
                    $payment_status = 2; // غير مكتمل
                    $is_paid = false;
                }
            }

            // إذا تم تحديد حالة دفع معينة في الطلب
            if ($request->has('payment_status')) {
                switch ($request->payment_status) {
                    case 4: // تحت المراجعة
                        $payment_status = 4;
                        $is_paid = false;
                        break;
                    case 5: // فاشلة
                        $payment_status = 5;
                        $is_paid = false;
                        break;
                }
            }

            // ** الخطوة الرابعة: إنشاء الفاتورة في قاعدة البيانات **
            $invoice = Invoice::create([
                'client_id' => $request->client_id,
                'employee_id' => $request->employee_id,
                'due_value' => $due_value,
                'code' => $code,
                'type' => 'returned', // Set type to 'returned'
                'invoice_date' => $request->invoice_date,
                'issue_date' => $request->issue_date,
                'terms' => $request->terms ?? 0,
                'notes' => $request->notes,
                'payment_status' => $payment_status,
                'is_paid' => $is_paid,
                'created_by' => Auth::id(),
                'account_id' => $request->account_id,
                'discount_amount' => $invoice_discount,
                'discount_type' => $request->has('discount_type') ? ($request->discount_type === 'percentage' ? 2 : 1) : 1,
                'advance_payment' => $advance_payment,
                'payment_type' => $request->payment_type ?? 1,
                'shipping_cost' => $shipping_cost,
                'shipping_tax' => $shipping_tax,
                'tax_type' => $request->tax_type ?? 1,
                'payment_method' => $request->payment_method,
                'reference_number' => $request->reference_number,
                'received_date' => $request->received_date,
                'subtotal' => $total_amount,
                'total_discount' => $final_total_discount,
                'tax_total' => $tax_total,
                'grand_total' => $total_with_tax,
                'paid_amount' => $advance_payment,
            ]);

            // ** الخطوة الخامسة: إنشاء سجلات البنود (items) للفاتورة **
            foreach ($items_data as $item) {
                $item['invoice_id'] = $invoice->id;
                InvoiceItem::create($item);

                // ** تحديث المخزون بناءً على store_house_id المحدد في البند **
                $productDetails = ProductDetails::where('store_house_id', $item['store_house_id'])->where('product_id', $item['product_id'])->first();

                if (!$productDetails) {
                    $productDetails = ProductDetails::create([
                        'store_house_id' => $item['store_house_id'],
                        'product_id' => $item['product_id'],
                        'quantity' => 0,
                    ]);
                }

                // زيادة الكمية في المخزون للمرتجعات
                $productDetails->increment('quantity', $item['quantity']);
            }

            // ** معالجة المرفقات (attachments) إذا وجدت **
            if ($request->hasFile('attachments')) {
                $file = $request->file('attachments');
                if ($file->isValid()) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('assets/uploads/'), $filename);
                    $invoice->attachments = $filename;
                    $invoice->save();
                }
            }

            $vatAccount = Account::where('name', 'القيمة المضافة المحصلة')->first();
            if (!$vatAccount) {
                throw new \Exception('حساب القيمة المضافة المحصلة غير موجود');
            }

            // استرجاع حساب الأصول
            $assetsAccount = Account::where('name', 'الأصول')->first();
            if (!$assetsAccount) {
                throw new \Exception('حساب الأصول غير موجود');
            }
            $returnsAccount = Account::where('name', 'مردودات المبيعات')->first();
            if (!$returnsAccount) {
                throw new \Exception('حساب مردودات المبيعات غير موجود');
            }

            // إنشاء القيد المحاسبي للفاتورة
            $journalEntry = JournalEntry::create([
                'reference_number' => $invoice->code,
                'date' => now(),
                'description' => 'فاتورة مرتجع مبيعات رقم ' . $invoice->code,
                'status' => 1,
                'currency' => 'SAR',
                'client_id' => $invoice->client_id,
                'invoice_id' => $invoice->id,
                'created_by_employee' => Auth::id(),
            ]);

            // إضافة تفاصيل القيد المحاسبي
            // 1. حساب مردود المبيعات (مدين)
            JournalEntryDetail::create([
                'journal_entry_id' => $journalEntry->id,
                'account_id' => $returnsAccount->id, // حساب مردود المبيعات
                'description' => 'مرتجع مبيعات',
                'debit' => $total_with_tax, // المبلغ الكلي للمرتجع (مدين)
                'credit' => 0,
                'is_debit' => true,
            ]);

            // 2. حساب الإيرادات (دائن)
            $revenueAccount = Account::where('name', 'الإيرادات')->first();
            if ($revenueAccount) {
                JournalEntryDetail::create([
                    'journal_entry_id' => $journalEntry->id,
                    'account_id' => $revenueAccount->id, // حساب الإيرادات
                    'description' => 'مرتجع مبيعات',
                    'debit' => 0,
                    'credit' => $total_with_tax, // المبلغ الكلي للمرتجع (دائن)
                    'is_debit' => false,
                ]);
            }

            // ** تحديث رصيد حساب مردود المبيعات (خصم) **
            if ($returnsAccount) {
                $returnsAccount->balance += $total_with_tax; // إضافة المبلغ الكلي للمرتجع
                $returnsAccount->save();
            }

            // ** تحديث رصيد حساب الإيرادات (خصم) **
            if ($revenueAccount) {
                $revenueAccount->balance -= $total_with_tax; // خصم المبلغ الكلي للمرتجع
                $revenueAccount->save();
            }

            // ** تحديث رصيد حساب القيمة المضافة (خصم) **
            if ($vatAccount) {
                $vatAccount->balance -= $tax_total; // خصم قيمة الضريبة
                $vatAccount->save();
            }

            // ** تحديث رصيد حساب الأصول (خصم) **
            if ($assetsAccount) {
                $assetsAccount->balance -= $total_with_tax; // خصم المبلغ الكلي (المبيعات + الضريبة)
                $assetsAccount->save();
            }
                        if ($advance_payment > 0 || $is_paid) {
                $payment_amount = $is_paid ? $total_with_tax : $advance_payment;

                // إنشاء سجل الدفع
                $payment = PaymentsProcess::create([
                    'invoice_id' => $invoice->id,
                    'amount' => $payment_amount,
                    'payment_date' => now(),
                    'payment_method' => $request->payment_method,
                    'reference_number' => $request->reference_number,
                    'notes' => 'تم إنشاء الدفعة تلقائياً عند إنشاء الفاتورة المرتجعة',
                    'type' => 'client payments',
                    'payment_status' => $payment_status,
                    'created_by' => Auth::id(),
                ]);

                // إنشاء قيد محاسبي للدفعة
                $paymentJournalEntry = JournalEntry::create([
                    'reference_number' => $payment->reference_number ?? $invoice->code,
                    'date' => now(),
                    'description' => 'دفعة للفاتورة المرتجعة رقم ' . $invoice->code,
                    'status' => 1,
                    'currency' => 'SAR',
                    'client_id' => $invoice->client_id,
                    'invoice_id' => $invoice->id,
                    'created_by_employee' => Auth::id(),
                ]);

                // إضافة تفاصيل القيد المحاسبي للدفعة
                // 1. حساب الصندوق/البنك (مدين)
                JournalEntryDetail::create([
                    'journal_entry_id' => $paymentJournalEntry->id,
                    'account_id' => $request->payment_account_id, // حساب الصندوق/البنك
                    'description' => 'استلام دفعة نقدية مرتجعة',
                    'debit' => $payment_amount, // المبلغ المستلم (مدين)
                    'credit' => 0,
                    'is_debit' => true,
                ]);

                // 2. حساب العميل (دائن)
                JournalEntryDetail::create([
                    'journal_entry_id' => $paymentJournalEntry->id,
                    'account_id' => $invoice->client->account_id, // حساب العميل
                    'description' => 'دفعة مرتجعة من العميل',
                    'debit' => 0,
                    'credit' => $payment_amount, // المبلغ المستلم (دائن)
                    'is_debit' => false,
                ]);
            }

            DB::commit();

            // إعداد رسالة النجاح
            $paymentStatusText = match ($payment_status) {
                1 => 'مكتمل',
                2 => 'غير مكتمل',
                3 => 'مسودة',
                4 => 'تحت المراجعة',
                5 => 'فاشلة',
                default => 'غير معروف',
            };

            return redirect()
                ->route('ReturnIInvoices.show', $invoice->id)
                ->with('success', sprintf('تم إنشاء فاتورة المرتجع بنجاح. رقم المرتجع: %s - حالة الدفع: %s', $invoice->code, $paymentStatusText));
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('خطأ في إنشاء فاتورة المرتجعة: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'عذراً، حدث خطأ أثناء حفظ فاتورة المرتجعة: ' . $e->getMessage());
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
        $invoice_number = $this->generateInvoiceNumber();
        return view('sales.retend_invoice.show', compact('invoice_number', 'clients', 'employees', 'return_invoice'));
    }
}
