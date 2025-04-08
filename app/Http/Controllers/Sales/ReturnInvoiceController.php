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
use App\Models\TaxSitting;
use App\Models\TaxInvoice;
use App\Models\AccountSetting;
use App\Models\TreasuryEmployee;
use App\Models\WarehousePermits;
use App\Models\WarehousePermitsProducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReturnInvoiceController extends Controller
{
    public function index(Request $request)
    {
        // بدء بناء الاستعلام
        $query = Invoice::with(['client', 'createdByUser', 'updatedByUser'])->orderBy('created_at', 'desc');

        // 1. البحث حسب العميل
        if ($request->has('client_id') && $request->client_id) {
            $query->where('client_id', $request->client_id);
        }

        // 2. البحث حسب رقم الفاتورة
        if ($request->has('invoice_number') && $request->invoice_number) {
            $query->where('id', 'like', '%' . $request->invoice_number . '%');
        }

        // 3. البحث حسب حالة الفاتورة
        if ($request->has('payment_status') && $request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }

        // 4. البحث حسب البند
        if ($request->has('item') && $request->item) {
            $query->whereHas('items', function ($q) use ($request) {
                $q->where('item', 'like', '%' . $request->item . '%');
            });
        }

        // 5. البحث حسب العملة
        if ($request->has('currency') && $request->currency) {
            $query->where('currency', $request->currency);
        }

        // 6. البحث حسب الإجمالي (من)
        if ($request->has('total_from') && $request->total_from) {
            $query->where('grand_total', '>=', $request->total_from);
        }

        // 7. البحث حسب الإجمالي (إلى)
        if ($request->has('total_to') && $request->total_to) {
            $query->where('grand_total', '<=', $request->total_to);
        }

        // 8. البحث حسب حالة الدفع
        if ($request->has('payment_status') && $request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }

        // 9. البحث حسب التاريخ (من)
        if ($request->has('from_date') && $request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        // 10. البحث حسب التاريخ (إلى)
        if ($request->has('to_date') && $request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // 11. البحث حسب تاريخ الاستحقاق (من)
        if ($request->has('due_date_from') && $request->due_date_from) {
            $query->whereDate('due_date', '>=', $request->due_date_from);
        }

        // 12. البحث حسب تاريخ الاستحقاق (إلى)
        if ($request->has('due_date_to') && $request->due_date_to) {
            $query->whereDate('due_date', '<=', $request->due_date_to);
        }

        // 13. البحث حسب المصدر
        if ($request->has('source') && $request->source) {
            $query->where('source', $request->source);
        }

        // 14. البحث حسب الحقل المخصص
        if ($request->has('custom_field') && $request->custom_field) {
            $query->where('custom_field', 'like', '%' . $request->custom_field . '%');
        }

        // 15. البحث حسب تاريخ الإنشاء (من)
        if ($request->has('created_at_from') && $request->created_at_from) {
            $query->whereDate('created_at', '>=', $request->created_at_from);
        }

        // 16. البحث حسب تاريخ الإنشاء (إلى)
        if ($request->has('created_at_to') && $request->created_at_to) {
            $query->whereDate('created_at', '<=', $request->created_at_to);
        }

        // 17. البحث حسب حالة التسليم
        if ($request->has('delivery_status') && $request->delivery_status) {
            $query->where('delivery_status', $request->delivery_status);
        }

        // 18. البحث حسب "أضيفت بواسطة"
        if ($request->has('added_by') && $request->added_by) {
            $query->where('created_by', $request->added_by);
        }

        // 19. البحث حسب مسؤول المبيعات
        if ($request->has('sales_person') && $request->sales_person) {
            $query->where('sales_person_id', $request->sales_person);
        }

        // 20. البحث حسب خيارات الشحن
        if ($request->has('shipping_option') && $request->shipping_option) {
            $query->where('shipping_option', $request->shipping_option);
        }

        // 21. البحث حسب مصدر الطلب
        if ($request->has('order_source') && $request->order_source) {
            $query->where('order_source', $request->order_source);
        }

        // 22. البحث حسب التخصيص (شهريًا، أسبوعيًا، يوميًا)
        if ($request->has('custom_period') && $request->custom_period) {
            if ($request->custom_period == 'monthly') {
                $query->whereMonth('created_at', now()->month);
            } elseif ($request->custom_period == 'weekly') {
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
            } elseif ($request->custom_period == 'daily') {
                $query->whereDate('created_at', now()->toDateString());
            }
        }

        // 23. البحث حسب حالة التسليم
        if ($request->has('delivery_status') && $request->delivery_status) {
            $query->where('delivery_status', $request->delivery_status);
        }

        // 24. البحث حسب "أضيفت بواسطة" (الموظفين)
        if ($request->has('added_by_employee') && $request->added_by_employee) {
            $query->where('created_by', $request->added_by_employee);
        }

        // 25. البحث حسب مسؤول المبيعات (المستخدمين)
        if ($request->has('sales_person_user') && $request->sales_person_user) {
            $query->where('sales_person_id', $request->sales_person_user);
        }

        // جلب النتائج مع التقسيم
        $return = $query->paginate(25); // استبدل get() بـ paginate()

        // البيانات الأخرى المطلوبة للواجهة
        $clients = Client::all();
        $users = User::all();
        $employees = Employee::all();
        $account_setting = AccountSetting::where('user_id', auth()->user()->id)->first();

        return view('sales.retend_invoice.index', compact('return', 'account_setting', 'clients', 'users', 'employees'));
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
        $taxs = TaxSitting::all();
        $account_setting = AccountSetting::where('user_id', auth()->user()->id)->first();
        // تمرير البيانات إلى العرض
        return view('sales.retend_invoice.create', compact('clients', 'account_setting', 'taxs', 'items', 'treasury', 'users', 'invoice'));
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
            // التحقق مما إذا كانت فاتورة مرتجع
            $isReturn = $request->has('is_return') && $request->is_return;

            if ($isReturn) {
                // التحقق من وجود فاتورة أصلية للمرتجع
                if (!$request->has('original_invoice_id')) {
                    return redirect()->back()->withInput()->with('error', 'يجب تحديد الفاتورة الأصلية للمرتجع');
                }

                $originalInvoice = Invoice::findOrFail($request->original_invoice_id);

                // التحقق من أن الفاتورة الأصلية ليست مرتجعًا
                if ($originalInvoice->type == 'return') {
                    return redirect()->back()->withInput()->with('error', 'لا يمكن عمل مرتجع لفاتورة مرتجع');
                }

                // التحقق من أن المبلغ المرتجع لا يتجاوز المبلغ الأصلي
                $originalTotal = $originalInvoice->grand_total;
                $returnedAmount = Invoice::where('original_invoice_id', $originalInvoice->id)
                                        ->where('type', 'return')
                                        ->sum('grand_total');
                $remainingAmount = $originalTotal - $returnedAmount;

                if ($request->grand_total > $remainingAmount) {
                    return redirect()->back()->withInput()->with('error', 'المبلغ المرتجع يتجاوز المبلغ المتبقي من الفاتورة الأصلية');
                }
            }

            // إنشاء كود الفاتورة
            $code = $request->code;
            if (!$code) {
                $lastOrder = Invoice::orderBy('id', 'desc')->first();
                $nextNumber = $lastOrder ? intval($lastOrder->code) + 1 : 1;
                while (Invoice::where('code', str_pad($nextNumber, 5, '0', STR_PAD_LEFT))->exists()) {
                    $nextNumber++;
                }
                $code = str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
            } else {
                if (Invoice::where('code', $request->code)->exists()) {
                    return redirect()->back()->withInput()->with('error', 'رقم الفاتورة موجود مسبقاً');
                }
            }

            DB::beginTransaction();

            // تجهيز المتغيرات الرئيسية
            $total_amount = 0;
            $total_discount = 0;
            $items_data = [];

            // معالجة البنود
            if ($request->has('items') && count($request->items)) {
                foreach ($request->items as $item) {
                    if (!isset($item['product_id'])) {
                        throw new \Exception('معرف المنتج مطلوب لكل بند');
                    }

                    $product = Product::find($item['product_id']);
                    if (!$product) {
                        throw new \Exception('المنتج غير موجود');
                    }

                    // تحديد المستودع للمرتجع (نفس مستودع الفاتورة الأصلية)
                    $storeHouse = null;
                    if ($isReturn) {
                        $originalItem = InvoiceItem::where('invoice_id', $originalInvoice->id)
                                                ->where('product_id', $item['product_id'])
                                                ->first();

                        if ($originalItem) {
                            $storeHouse = StoreHouse::find($originalItem->store_house_id);
                        }
                    }

                    // إذا لم يكن مرتجع أو لم يتم العثور على المستودع الأصلي
                    if (!$storeHouse) {
                        $storeHouse = StoreHouse::where('major', 1)->first();
                        if (!$storeHouse) {
                            throw new \Exception('لا يوجد مستودع رئيسي متاح');
                        }
                    }

                    // حساب الكمية والسعر
                    $quantity = floatval($item['quantity']);
                    $unit_price = floatval($item['unit_price']);
                    $item_total = $quantity * $unit_price;

                    // حساب الخصم
                    $item_discount = 0;
                    if (isset($item['discount']) && $item['discount'] > 0) {
                        if (isset($item['discount_type']) && $item['discount_type'] === 'percentage') {
                            $item_discount = ($item_total * floatval($item['discount'])) / 100;
                        } else {
                            $item_discount = floatval($item['discount']);
                        }
                    }

                    $total_amount += $item_total;
                    $total_discount += $item_discount;

                    $items_data[] = [
                        'invoice_id' => null,
                        'product_id' => $item['product_id'],
                        'store_house_id' => $storeHouse->id,
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

            // حساب الخصم الإضافي للفاتورة
            $invoice_discount = 0;
            if ($request->has('discount_amount') && $request->discount_amount > 0) {
                if ($request->has('discount_type') && $request->discount_type === 'percentage') {
                    $invoice_discount = ($total_amount * floatval($request->discount_amount)) / 100;
                } else {
                    $invoice_discount = floatval($request->discount_amount);
                }
            }

            $final_total_discount = $total_discount + $invoice_discount;
            $amount_after_discount = $total_amount - $final_total_discount;

            // حساب الضرائب
            $tax_total = 0;
            if ($request->tax_type == 1) {
                foreach ($request->items as $item) {
                    $tax_1 = floatval($item['tax_1'] ?? 0);
                    $tax_2 = floatval($item['tax_2'] ?? 0);
                    $item_total = floatval($item['quantity']) * floatval($item['unit_price']);
                    $item_tax = ($item_total * $tax_1) / 100 + ($item_total * $tax_2) / 100;
                    $tax_total += $item_tax;
                }
            }

            // تكلفة الشحن
            $shipping_cost = floatval($request->shipping_cost ?? 0);
            $shipping_tax = 0;
            if ($request->tax_type == 1) {
                $shipping_tax = $shipping_cost * 0.15;
            }
            $tax_total += $shipping_tax;

            // الحساب النهائي
            $total_with_tax = $amount_after_discount + $tax_total + $shipping_cost;

            // تحديد حالة الدفع
            $payment_status = 3; // مسودة
            $is_paid = false;
            $advance_payment = floatval($request->advance_payment ?? 0);
            $due_value = $total_with_tax - $advance_payment;

            if ($isReturn) {
                // للمرتجع، نعكس حالة الدفع
                if ($request->has('is_paid') && $request->is_paid) {
                    $payment_status = 1; // مكتمل
                    $is_paid = true;
                    $advance_payment = $total_with_tax;
                    $due_value = 0;
                } else {
                    $payment_status = 2; // غير مكتمل
                }
            } else {
                // للفاتورة العادية
                if ($advance_payment > 0 || $request->has('is_paid')) {
                    if ($request->has('is_paid') && $request->is_paid) {
                        $payment_status = 1;
                        $is_paid = true;
                        $advance_payment = $total_with_tax;
                        $due_value = 0;
                    } else {
                        $payment_status = 2;
                    }
                }
            }

            // إنشاء الفاتورة
            $invoiceData = [
                'client_id' => $request->client_id,
                'employee_id' => $request->employee_id,
                'due_value' => $due_value,
                'code' => $code,
                'type' => $isReturn ? 'return' : 'normal',
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
            ];

            if ($isReturn) {
                $invoiceData['original_invoice_id'] = $originalInvoice->id;
            }

            $invoice = Invoice::create($invoiceData);
            $invoice->qrcode = $this->generateTlvContent($invoice->created_at, $invoice->grand_total, $invoice->tax_total);
            $invoice->save();

            // معالجة بنود الفاتورة
            foreach ($items_data as $item) {
                $item['invoice_id'] = $invoice->id;
                $item_invoice = InvoiceItem::create($item);

                // تحديث المخزون
                $productDetails = ProductDetails::where('store_house_id', $item['store_house_id'])
                                            ->where('product_id', $item['product_id'])
                                            ->first();

                if (!$productDetails) {
                    $productDetails = ProductDetails::create([
                        'store_house_id' => $item['store_house_id'],
                        'product_id' => $item['product_id'],
                        'quantity' => 0,
                    ]);
                }

                $product = Product::find($item['product_id']);

                if ($isReturn) {
                    // للمرتجع: إضافة الكمية إلى المخزون
                    $productDetails->increment('quantity', $item['quantity']);

                    // تسجيل حركة المخزون
                    $wareHousePermits = new WarehousePermits();
                    $wareHousePermits->permission_type = 1; // إضافة للمخزون
                    $wareHousePermits->permission_date = $invoice->created_at;
                    $wareHousePermits->number = $invoice->id;
                    $wareHousePermits->grand_total = $invoice->grand_total;
                    $wareHousePermits->store_houses_id = $storeHouse->id;
                    $wareHousePermits->created_by = auth()->user()->id;
                    $wareHousePermits->save();

                    WarehousePermitsProducts::create([
                        'quantity' => $item['quantity'],
                        'total' => $item['total'],
                        'unit_price' => $item['unit_price'],
                        'product_id' => $item['product_id'],
                        'stock_before' => $productDetails->quantity - $item['quantity'],
                        'stock_after' => $productDetails->quantity,
                        'warehouse_permits_id' => $wareHousePermits->id,
                    ]);
                } else {
                    // للفاتورة العادية: خصم الكمية من المخزون
                    if ($product->type == 'products' || ($product->type == 'compiled' && $product->compile_type !== 'Instant')) {
                        if ($item['quantity'] > $productDetails->quantity) {
                            throw new \Exception('الكمية المطلوبة غير متاحة في المخزون');
                        }
                    }

                    if ($product->type == 'products') {
                        $productDetails->decrement('quantity', $item['quantity']);

                        $wareHousePermits = new WarehousePermits();
                        $wareHousePermits->permission_type = 10; // خصم من الفاتورة
                        $wareHousePermits->permission_date = $invoice->created_at;
                        $wareHousePermits->number = $invoice->id;
                        $wareHousePermits->grand_total = $invoice->grand_total;
                        $wareHousePermits->store_houses_id = $storeHouse->id;
                        $wareHousePermits->created_by = auth()->user()->id;
                        $wareHousePermits->save();

                        WarehousePermitsProducts::create([
                            'quantity' => $item['quantity'],
                            'total' => $item['total'],
                            'unit_price' => $item['unit_price'],
                            'product_id' => $item['product_id'],
                            'stock_before' => $productDetails->quantity + $item['quantity'],
                            'stock_after' => $productDetails->quantity,
                            'warehouse_permits_id' => $wareHousePermits->id,
                        ]);
                    }
                }
            }

            // معالجة الدفعات
            if ($advance_payment > 0 || $is_paid) {
                $payment_amount = $is_paid ? $total_with_tax : $advance_payment;

                // تحديد الخزينة بناءً على الموظف
                $user = Auth::user();
                $MainTreasury = null;

                if ($user && $user->employee_id) {
                    $TreasuryEmployee = TreasuryEmployee::where('employee_id', $user->employee_id)->first();
                    if ($TreasuryEmployee && $TreasuryEmployee->treasury_id) {
                        $MainTreasury = Account::where('id', $TreasuryEmployee->treasury_id)->first();
                    }
                }

                if (!$MainTreasury) {
                    $MainTreasury = Account::where('name', 'الخزينة الرئيسية')->first();
                }

                if (!$MainTreasury) {
                    throw new \Exception('لا توجد خزينة متاحة');
                }

                // إنشاء سجل الدفع
                $paymentData = [
                    'invoice_id' => $invoice->id,
                    'amount' => $isReturn ? -abs($payment_amount) : $payment_amount, // سالب للمرتجع
                    'payment_date' => now(),
                    'payment_method' => $request->payment_method,
                    'reference_number' => $request->reference_number,
                    'notes' => $isReturn ? 'مرتجع فاتورة' : 'دفعة للفاتورة',
                    'type' => 'client payments',
                    'payment_status' => $payment_status,
                    'created_by' => Auth::id(),
                ];

                $payment = PaymentsProcess::create($paymentData);

                // تحديث رصيد الخزينة
                if ($isReturn) {
                    // للمرتجع: خصم المبلغ من الخزينة (لأننا نرد المال للعميل)
                    $MainTreasury->balance -= abs($payment_amount);
                } else {
                    // للفاتورة العادية: إضافة المبلغ إلى الخزينة
                    $MainTreasury->balance += $payment_amount;
                }
                $MainTreasury->save();

                // إنشاء القيود المحاسبية
                $clientAccount = Account::where('client_id', $invoice->client_id)->first();
                $vatAccount = Account::where('name', 'القيمة المضافة المحصلة')->first();
                $salesAccount = Account::where('name', 'المبيعات')->first();

                if (!$clientAccount || !$vatAccount || !$salesAccount) {
                    throw new \Exception('حساب مفقود في النظام');
                }

                // قيد الفاتورة
                $journalEntry = JournalEntry::create([
                    'reference_number' => $invoice->code,
                    'date' => now(),
                    'description' => $isReturn ? 'مرتجع فاتورة رقم ' . $invoice->code : 'فاتورة مبيعات رقم ' . $invoice->code,
                    'status' => 1,
                    'currency' => 'SAR',
                    'client_id' => $invoice->client_id,
                    'invoice_id' => $invoice->id,
                ]);

                if ($isReturn) {
                    // قيود مرتجع الفاتورة (معكوسة)
                    JournalEntryDetail::create([
                        'journal_entry_id' => $journalEntry->id,
                        'account_id' => $clientAccount->id,
                        'description' => 'مرتجع فاتورة رقم ' . $invoice->code,
                        'debit' => 0,
                        'credit' => $total_with_tax,
                        'is_debit' => false,
                    ]);

                    JournalEntryDetail::create([
                        'journal_entry_id' => $journalEntry->id,
                        'account_id' => $salesAccount->id,
                        'description' => 'مرتجع مبيعات',
                        'debit' => $amount_after_discount,
                        'credit' => 0,
                        'is_debit' => true,
                    ]);

                    JournalEntryDetail::create([
                        'journal_entry_id' => $journalEntry->id,
                        'account_id' => $vatAccount->id,
                        'description' => 'مرتجع ضريبة',
                        'debit' => $tax_total,
                        'credit' => 0,
                        'is_debit' => true,
                    ]);
                } else {
                    // قيود الفاتورة العادية
                    JournalEntryDetail::create([
                        'journal_entry_id' => $journalEntry->id,
                        'account_id' => $clientAccount->id,
                        'description' => 'فاتورة مبيعات رقم ' . $invoice->code,
                        'debit' => $total_with_tax,
                        'credit' => 0,
                        'is_debit' => true,
                    ]);

                    JournalEntryDetail::create([
                        'journal_entry_id' => $journalEntry->id,
                        'account_id' => $salesAccount->id,
                        'description' => 'إيرادات مبيعات',
                        'debit' => 0,
                        'credit' => $amount_after_discount,
                        'is_debit' => false,
                    ]);

                    JournalEntryDetail::create([
                        'journal_entry_id' => $journalEntry->id,
                        'account_id' => $vatAccount->id,
                        'description' => 'ضريبة القيمة المضافة',
                        'debit' => 0,
                        'credit' => $tax_total,
                        'is_debit' => false,
                    ]);
                }

                // قيد الدفعة
                $paymentJournalEntry = JournalEntry::create([
                    'reference_number' => $payment->reference_number ?? $invoice->code,
                    'date' => now(),
                    'description' => $isReturn ? 'دفعة مرتجع فاتورة رقم ' . $invoice->code : 'دفعة فاتورة رقم ' . $invoice->code,
                    'status' => 1,
                    'currency' => 'SAR',
                    'client_id' => $invoice->client_id,
                    'invoice_id' => $invoice->id,
                ]);

                if ($isReturn) {
                    // قيود دفع المرتجع (معكوسة)
                    JournalEntryDetail::create([
                        'journal_entry_id' => $paymentJournalEntry->id,
                        'account_id' => $MainTreasury->id,
                        'description' => 'سحب من الخزينة لمرتجع فاتورة',
                        'debit' => 0,
                        'credit' => abs($payment_amount),
                        'is_debit' => false,
                    ]);

                    JournalEntryDetail::create([
                        'journal_entry_id' => $paymentJournalEntry->id,
                        'account_id' => $clientAccount->id,
                        'description' => 'استرداد مبلغ للعميل',
                        'debit' => abs($payment_amount),
                        'credit' => 0,
                        'is_debit' => true,
                    ]);
                } else {
                    // قيود دفع الفاتورة العادية
                    JournalEntryDetail::create([
                        'journal_entry_id' => $paymentJournalEntry->id,
                        'account_id' => $MainTreasury->id,
                        'description' => 'إضافة إلى الخزينة',
                        'debit' => $payment_amount,
                        'credit' => 0,
                        'is_debit' => true,
                    ]);

                    JournalEntryDetail::create([
                        'journal_entry_id' => $paymentJournalEntry->id,
                        'account_id' => $clientAccount->id,
                        'description' => 'دفعة من العميل',
                        'debit' => 0,
                        'credit' => $payment_amount,
                        'is_debit' => false,
                    ]);
                }

                // تحديث أرصدة الحسابات
                if ($isReturn) {
                    $clientAccount->balance += abs($payment_amount);
                    $salesAccount->balance -= $amount_after_discount;
                    $vatAccount->balance -= $tax_total;
                } else {
                    $clientAccount->balance += $total_with_tax;
                    $salesAccount->balance += $amount_after_discount;
                    $vatAccount->balance += $tax_total;
                }

                $clientAccount->save();
                $salesAccount->save();
                $vatAccount->save();
            }

            DB::commit();

            return redirect()
                ->route('invoices.show', $invoice->id)
                ->with('success', sprintf('تم إنشاء %s بنجاح. الرقم: %s', $isReturn ? 'مرتجع الفاتورة' : 'فاتورة المبيعات', $invoice->code));

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('خطأ في إنشاء الفاتورة: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'حدث خطأ: ' . $e->getMessage());
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
    private function generateTlvContent($timestamp, $totalAmount, $vatAmount)
    {
        $tlvContent = $this->getTlv(1, 'مؤسسة اعمال خاصة للتجارة') . $this->getTlv(2, '000000000000000') . $this->getTlv(3, $timestamp) . $this->getTlv(4, number_format($totalAmount, 2, '.', '')) . $this->getTlv(5, number_format($vatAmount, 2, '.', ''));

        return base64_encode($tlvContent);
    }
    private function getTlv($tag, $value)
    {
        $value = (string) $value;
        return pack('C', $tag) . pack('C', strlen($value)) . $value;
    }
    public function show($id)
    {
        $clients = Client::all();
        $employees = Employee::all();
        $return_invoice = Invoice::find($id);
        $TaxsInvoice = TaxInvoice::where('invoice_id', $id)->get();
        $account_setting = AccountSetting::where('user_id', auth()->user()->id)->first();
        // $invoice_number = $this->generateInvoiceNumber();
        return view('sales.retend_invoice.show', compact('clients', 'TaxsInvoice', 'employees', 'account_setting', 'return_invoice'));
    }
}
