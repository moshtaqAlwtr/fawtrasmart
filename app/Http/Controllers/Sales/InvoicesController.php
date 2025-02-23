<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sales\InvoiceRequest;
use App\Models\Account;
use App\Models\AccountSetting;
use App\Models\Client;
use App\Models\Commission;
use App\Models\Commission_Products;
use App\Models\CommissionUsers;
use App\Models\DefaultWarehouses;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\JournalEntry;
use App\Models\JournalEntryDetail;
use App\Models\PaymentsProcess;
use App\Models\Product;
use App\Models\ProductDetails;
use App\Models\SalesCommission;
use App\Models\StoreHouse;
use App\Models\Treasury;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use TCPDF;
use App\Services\Accounts\JournalEntryService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class InvoicesController extends Controller
{
    protected $journalEntryService;

    public function __construct(JournalEntryService $journalEntryService)
    {
        $this->journalEntryService = $journalEntryService;
    }

    /**
     * Display a listing of invoices.
     */
    public function index(Request $request)
    {
        // بدء بناء الاستعلام
        $invoices = Invoice::with(['client', 'createdByUser', 'updatedByUser'])->orderBy('created_at', 'desc');

        // 1. البحث حسب العميل
        if ($request->has('client_id') && $request->client_id) {
            $invoices->where('client_id', $request->client_id);
        }

        // 2. البحث حسب رقم الفاتورة
        if ($request->has('invoice_number') && $request->invoice_number) {
            $invoices->where('id', 'like', '%' . $request->invoice_number . '%');
        }

        // 3. البحث حسب حالة الفاتورة
        if ($request->has('payment_status') && $request->payment_status) {
            $invoices->where('payment_status', $request->payment_status);
        }

        // 4. البحث حسب البند
        if ($request->has('item') && $request->item) {
            $invoices->whereHas('items', function ($query) use ($request) {
                $query->where('item', 'like', '%' . $request->item . '%');
            });
        }

        // 5. البحث حسب العملة
        if ($request->has('currency') && $request->currency) {
            $invoices->where('currency', $request->currency);
        }

        // 6. البحث حسب الإجمالي (من)
        if ($request->has('total_from') && $request->total_from) {
            $invoices->where('grand_total', '>=', $request->total_from);
        }

        // 7. البحث حسب الإجمالي (إلى)
        if ($request->has('total_to') && $request->total_to) {
            $invoices->where('grand_total', '<=', $request->total_to);
        }

        // 8. البحث حسب حالة الدفع
        if ($request->has('payment_status') && $request->payment_status) {
            $invoices->where('payment_status', $request->payment_status);
        }

        // 9. البحث حسب التاريخ (من)
        if ($request->has('from_date') && $request->from_date) {
            $invoices->whereDate('created_at', '>=', $request->from_date);
        }

        // 10. البحث حسب التاريخ (إلى)
        if ($request->has('to_date') && $request->to_date) {
            $invoices->whereDate('created_at', '<=', $request->to_date);
        }

        // 11. البحث حسب تاريخ الاستحقاق (من)
        if ($request->has('due_date_from') && $request->due_date_from) {
            $invoices->whereDate('due_date', '>=', $request->due_date_from);
        }

        // 12. البحث حسب تاريخ الاستحقاق (إلى)
        if ($request->has('due_date_to') && $request->due_date_to) {
            $invoices->whereDate('due_date', '<=', $request->due_date_to);
        }

        // 13. البحث حسب المصدر
        if ($request->has('source') && $request->source) {
            $invoices->where('source', $request->source);
        }

        // 14. البحث حسب الحقل المخصص
        if ($request->has('custom_field') && $request->custom_field) {
            $invoices->where('custom_field', 'like', '%' . $request->custom_field . '%');
        }

        // 15. البحث حسب تاريخ الإنشاء (من)
        if ($request->has('created_at_from') && $request->created_at_from) {
            $invoices->whereDate('created_at', '>=', $request->created_at_from);
        }

        // 16. البحث حسب تاريخ الإنشاء (إلى)
        if ($request->has('created_at_to') && $request->created_at_to) {
            $invoices->whereDate('created_at', '<=', $request->created_at_to);
        }

        // 17. البحث حسب حالة التسليم
        if ($request->has('delivery_status') && $request->delivery_status) {
            $invoices->where('delivery_status', $request->delivery_status);
        }

        // 18. البحث حسب "أضيفت بواسطة"
        if ($request->has('added_by') && $request->added_by) {
            $invoices->where('created_by', $request->added_by);
        }

        // 19. البحث حسب مسؤول المبيعات
        if ($request->has('sales_person') && $request->sales_person) {
            $invoices->where('sales_person_id', $request->sales_person);
        }

        // 20. البحث حسب خيارات الشحن
        if ($request->has('shipping_option') && $request->shipping_option) {
            $invoices->where('shipping_option', $request->shipping_option);
        }

        // 21. البحث حسب مصدر الطلب
        if ($request->has('order_source') && $request->order_source) {
            $invoices->where('order_source', $request->order_source);
        }

        // 22. البحث حسب التخصيص (شهريًا، أسبوعيًا، يوميًا)
        if ($request->has('custom_period') && $request->custom_period) {
            if ($request->custom_period == 'monthly') {
                $invoices->whereMonth('created_at', now()->month);
            } elseif ($request->custom_period == 'weekly') {
                $invoices->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
            } elseif ($request->custom_period == 'daily') {
                $invoices->whereDate('created_at', now()->toDateString());
            }
        }

        // 23. البحث حسب حالة التسليم
        if ($request->has('delivery_status') && $request->delivery_status) {
            $invoices->where('delivery_status', $request->delivery_status);
        }

        // 24. البحث حسب "أضيفت بواسطة" (الموظفين)
        if ($request->has('added_by_employee') && $request->added_by_employee) {
            $invoices->where('created_by', $request->added_by_employee);
        }

        // 25. البحث حسب مسؤول المبيعات (المستخدمين)
        if ($request->has('sales_person_user') && $request->sales_person_user) {
            $invoices->where('sales_person_id', $request->sales_person_user);
        }

        // جلب النتائج
        $invoices = $invoices->get();

        // البيانات الأخرى المطلوبة للواجهة
        $clients = Client::all();
        $users = User::all();
        $employees = Employee::all();
        $invoice_number = $this->generateInvoiceNumber();

        $account_setting = AccountSetting::where('user_id',auth()->user()->id)->first();
        $client   = Client::where('user_id',auth()->user()->id)->first();

        return view('sales.invoices.index', compact('invoices','account_setting','client', 'clients', 'users', 'invoice_number', 'employees'));
    }

    public function create()
    {
        $invoice_number = $this->generateInvoiceNumber();
        $items = Product::all();
        $clients = Client::all();
        $users = User::all();
        $treasury = Treasury::all();
        $employees = Employee::all();

        $invoiceType = 'normal'; // نوع الفاتورة عادي

        return view('sales.invoices.create', compact('clients', 'treasury', 'users', 'items', 'invoice_number', 'invoiceType', 'employees'));
    }

    public function store(Request $request)
    {
        try {
            // $telegramApiUrl = env('TELEGRAM_BOT_TOKEN');

            // // تحقق من قيمة المتغير
            // if (is_null($telegramApiUrl)) {
            //     throw new \Exception('عنوان API الخاص ببوت Telegram غير معرف في ملف .env');
            // }

            // ** الخطوة الأولى: إنشاء كود للفاتورة **
            $code = $request->code;
            if (!$code) {
                $lastOrder = Invoice::orderBy('id', 'desc')->first();
                $nextNumber = $lastOrder ? intval($lastOrder->code) + 1 : 1;
                // التحقق من أن الرقم فريد
                while (Invoice::where('code', str_pad($nextNumber, 5, '0', STR_PAD_LEFT))->exists()) {
                    $nextNumber++;
                }
                $code = str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
            } else {
                $existingCode = Invoice::where('code', $request->code)->exists();
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
                    // الحصول على المستخدم الحالي
           $user = Auth::user(); 

         // التحقق مما إذا كان للمستخدم employee_id
         // الحصول على المستخدم الحالي
        $user = Auth::user();

// التحقق مما إذا كان للمستخدم employee_id والبحث عن المستودع الافتراضي
          if ($user && $user->employee_id) {
    $defaultWarehouse = DefaultWarehouses::where('employee_id', $user->employee_id)->first();
    
    // التحقق مما إذا كان هناك مستودع افتراضي واستخدام storehouse_id إذا وجد
             if ($defaultWarehouse && $defaultWarehouse->storehouse_id) {
              $storeHouse = StoreHouse::find($defaultWarehouse->storehouse_id);
             } else {
              $storeHouse = StoreHouse::where('major', 1)->first();
            }
         } else {
    // إذا لم يكن لديه employee_id، يتم تعيين storehouse الافتراضي
      $storeHouse = StoreHouse::where('major', 1)->first();
           }

// التأكد من أن storeHouse ليس فارغًا قبل محاولة الوصول إلى ID
    $store_house_id = $storeHouse ? $storeHouse->id : null;



         // إرجاع store_id
        // return $storeId;

                   
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
                'type' => 'normal',
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

   

            // ** تحديث رصيد حساب أبناء العميل **

            // إضافة المبلغ الإجمالي للفاتورة إلى رصيد أبناء العميل

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
                 $proudect = Product::where('id', $item['product_id'])->first();
                        
                 if ($proudect->type !== "services") {
                    if ((int) $item['quantity'] > (int) $productDetails->quantity) {
                        throw new \Exception('الكمية المطلوبة (' . $item['quantity'] . ') غير متاحة في المخزون. الكمية المتاحة: ' . $productDetails->quantity);
                    }
                }

                $productDetails->decrement('quantity', $item['quantity']);
            }
         
           // جلب بيانات الموظف والمستخدم
           $employee_name = Employee::where('id', $invoice->employee_id)->first();
           $user_name = User::where('id', $invoice->created_by)->first();
            $client_name = Client::find($invoice->client_id);
           // جلب جميع المنتجات المرتبطة بالفاتورة
           $invoiceItems = InvoiceItem::where('invoice_id', $invoice->id)->get();
           
           // تجهيز قائمة المنتجات
           $productsList = "";
           foreach ($invoiceItems as $item) {
               $product = Product::find($item->product_id);
               $productName = $product ? $product->name : "منتج غير معروف";
               $productsList .= "▫️ *{$productName}* - الكمية: {$item->quantity}, السعر: {$item->unit_price} \n";
           }
           
           // رابط API التلقرام
           $telegramApiUrl = 'https://api.telegram.org/bot7642508596:AAHQ8sST762ErqUpX3Ni0f1WTeGZxiQWyXU/sendMessage';
           
           // تجهيز الرسالة
           $message = "📜 *فاتورة جديدة* 📜\n";
           $message .= "━━━━━━━━━━━━━━━━━━━━\n";
           $message .= "🆔 *رقم الفاتورة:* `$code`\n";
           $message .= "👤 *مسؤول البيع:* " . ($employee_name->first_name ?? 'لا يوجد') . "\n";
           $message .= "🏢 *العميل:* " . ($client_name->trade_name ?? 'لا يوجد') . "\n";
           $message .= "✍🏻 *أنشئت بواسطة:* " . ($user_name->name ?? 'لا يوجد') . "\n";
           $message .= "━━━━━━━━━━━━━━━━━━━━\n";
           $message .= "💰 *المجموع:* `" . number_format($invoice->grand_total, 2) . "` ريال\n";
           $message .= "🧾 *الضريبة:* `" . number_format($invoice->tax_total, 2) . "` ريال\n";
           $message .= "📌 *الإجمالي:* `" . number_format(($invoice->tax_total + $invoice->grand_total), 2) . "` ريال\n";
           $message .= "━━━━━━━━━━━━━━━━━━━━\n";
           $message .= "📦 *المنتجات:* \n" . $productsList;
           $message .= "━━━━━━━━━━━━━━━━━━━━\n";
           $message .= "📅 *التاريخ:* `" . date('Y-m-d H:i') . "`\n";
           
           
           // إرسال الرسالة إلى التلقرام
           $response = Http::post($telegramApiUrl, [
               'chat_id' => '@Salesfatrasmart',  // تأكد من أن لديك صلاحية الإرسال للقناة
               'text' => $message,
               'parse_mode' => 'Markdown',
               'timeout' => 30,
           ]);
           
            // التحقق مما إذا كان للمستخدم قاعدة عمولة
            // التحقق مما إذا كان للمستخدم قاعدة عمولة
            $userHasCommission = CommissionUsers::where('employee_id', auth()->user()->id)->exists();

            //  if (!$userHasCommission) {
            //      return "no000"; // المستخدم لا يملك قاعدة عمولة
            //   }

            if ($userHasCommission) {
                // جلب جميع commission_id الخاصة بالمستخدم
                $commissionIds = CommissionUsers::where('employee_id', auth()->user()->id)->pluck('commission_id');

                // التحقق مما إذا كانت هناك أي عمولة نشطة في جدول Commission
                $activeCommission = Commission::whereIn('id', $commissionIds)->where('status', 'active')->first();

                //   if (!$activeCommission) {
                //    return "not active"; // لا توجد عمولة نشطة، توقف هنا
                //    }

                if ($activeCommission) {
                    //    // ✅ التحقق مما إذا كانت حالة الدفع في `invoice` تتطابق مع حساب العمولة في `commission`
                    //    if (
                    //  ($invoice->payment_status == 1 && $activeCommission->commission_calculation != "fully_paid") ||
                    //  ($invoice->payment_status == 2 && $activeCommission->commission_calculation != "partially_paid")
                    //  )   {
                    //  return "payment mismatch"; // حالتا الدفع لا تتطابقان
                    //   }

                    // البحث في جدول commission__products باستخدام هذه commission_id
                    $commissionProducts = Commission_Products::whereIn('commission_id', $commissionIds)->get();

                    // التحقق من وجود أي product_id = 0
                    if ($commissionProducts->contains('product_id', 0)) {
                        return 'yesall';
                    }

                    // جلب جميع product_id الخاصة بالفاتورة
                    $invoiceProductIds = InvoiceItem::where('invoice_id', $invoice->id)->pluck('product_id');

                    // التحقق مما إذا كان أي من product_id في جدول commission__products يساوي أي من المنتجات في الفاتورة
                    if ($commissionProducts->whereIn('product_id', $invoiceProductIds)->isNotEmpty()) {
                        // جلب بيانات العمولة المرتبطة بالفاتورة
                        $inAmount = Commission::whereIn('id', $commissionIds)->first();
                        $commissionProduct = Commission_Products::whereIn('commission_id', $commissionIds)->first();
                        if ($inAmount) {
                            if ($inAmount->target_type == 'amount') {
                                $invoiceTotal = InvoiceItem::where('invoice_id', $invoice->id)->sum('total');
                                $invoiceQyt = InvoiceItem::where('invoice_id', $invoice->id)->first();
                                // تحقق من أن قيمة العمولة تساوي أو أكبر من `total`
                                if ((float) $inAmount->value <= (float) $invoiceTotal) {
                                    $salesInvoice = new SalesCommission();
                                    $salesInvoice->invoice_number = $invoice->id; // تعيين رقم الفاتورة الصحيح
                                    $salesInvoice->employee_id = auth()->user()->id; // اسم الموظف
                                    $salesInvoice->sales_amount = $invoiceTotal; // إجمالي المبيعات
                                    $salesInvoice->sales_quantity = $invoiceQyt->quantity;
                                    $salesInvoice->commission_id = $inAmount->id;
                                    $salesInvoice->ratio = $commissionProduct->commission_percentage ?? 0;
                                    $salesInvoice->product_id = $commissionProduct->product_id ?? 0; // رقم معرف العمولة
                                    $salesInvoice->save(); // حفظ السجل في قاعدة البيانات
                                }
                            } elseif ($inAmount->target_type == 'quantity') {
                                // تحقق من أن قيمة العمولة تساوي أو أكبر من `quantity`
                                $invoiceQuantity = InvoiceItem::where('invoice_id', $invoice->id)->sum('quantity');

                                if ((float) $inAmount->value <= (float) $invoiceQuantity) {
                                    $salesInvoice = new SalesCommission();
                                    $salesInvoice->invoice_number = $invoice->id; // تعيين رقم الفاتورة الصحيح
                                    $salesInvoice->employee_id = auth()->user()->id; // اسم الموظف
                                    $salesInvoice->sales_amount = $invoiceTotal; // إجمالي المبيعات
                                    $salesInvoice->sales_quantity = $invoiceQyt->quantity;
                                    $salesInvoice->commission_id = $inAmount->id; // رقم معرف العمولة
                                    $salesInvoice->ratio = $commissionProduct->commission_percentage ?? 0;
                                    $salesInvoice->product_id = $commissionProduct->product_id ?? 0;
                                    $salesInvoice->save(); // حفظ السجل في قاعدة البيانات
                                }
                            }
                        }
                    }
                }
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

            // استرجاع حساب القيمة المضافة المحصلة
            $vatAccount = Account::where('name', 'القيمة المضافة المحصلة')->first();
            if (!$vatAccount) {
                throw new \Exception('حساب القيمة المضافة المحصلة غير موجود');
            }
            $salesAccount = Account::where('name', 'المبيعات')->first();
            if (!$salesAccount) {
                throw new \Exception('حساب المبيعات غير موجود');
            }

            // إنشاء القيد المحاسبي للفاتورة
            $journalEntry = JournalEntry::create([
                'reference_number' => $invoice->code,
                'date' => now(),
                'description' => 'فاتورة مبيعات رقم ' . $invoice->code,
                'status' => 1,
                'currency' => 'SAR',
                'client_id' => $invoice->client_id,
                'invoice_id' => $invoice->id,
                // 'created_by_employee' => Auth::id(),
            ]);

            // إضافة تفاصيل القيد المحاسبي
            // 1. حساب العميل (مدين)
            JournalEntryDetail::create([
                'journal_entry_id' => $journalEntry->id,
                'account_id' => $invoice->client->id, // حساب العميل
                'description' => 'فاتورة مبيعات',
                'debit' => $total_with_tax, // المبلغ الكلي للفاتورة (مدين)
                'credit' => 0,
                'is_debit' => true,
            ]);

            // 2. حساب المبيعات (دائن)
            JournalEntryDetail::create([
                'journal_entry_id' => $journalEntry->id,
                'account_id' => $salesAccount->id, // حساب المبيعات
                'description' => 'إيرادات مبيعات',
                'debit' => 0,
                'credit' => $amount_after_discount, // المبلغ بعد الخصم (دائن)
                'is_debit' => false,
            ]);

            // 3. حساب القيمة المضافة المحصلة (دائن)
            JournalEntryDetail::create([
                'journal_entry_id' => $journalEntry->id,
                'account_id' => $vatAccount->id, // حساب القيمة المضافة المحصلة
                'description' => 'ضريبة القيمة المضافة',
                'debit' => 0,
                'credit' => $tax_total, // قيمة الضريبة (دائن)
                'is_debit' => false,
            ]);

            // ** تحديث رصيد حساب المبيعات (إيرادات) **
            if ($salesAccount) {
                $salesAccount->balance += $amount_after_discount; // إضافة المبلغ بعد الخصم
                $salesAccount->save();
            }

            // تحديث رصيد حساب الإيرادات (المبيعات + الضريبة)
            $revenueAccount = Account::where('name', 'الإيرادات')->first();
            if ($revenueAccount) {
                $revenueAccount->balance += $amount_after_discount; // المبلغ بعد الخصم (بدون الضريبة)
                $revenueAccount->save();
            }

            // تحديث رصيد حساب القيمة المضافة (الخصوم)
            $vatAccount->balance += $tax_total; // قيمة الضريبة
            $vatAccount->save();

            // تحديث رصيد حساب الأصول (المبيعات + الضريبة)
            $assetsAccount = Account::where('name', 'الأصول')->first();
            if ($assetsAccount) {
                $assetsAccount->balance += $total_with_tax; // المبلغ الكلي (المبيعات + الضريبة)
                $assetsAccount->save();
            }

            // ** الخطوة السابعة: إنشاء سجل الدفع إذا كان هناك دفعة مقدمة أو دفع كامل **
            if ($advance_payment > 0 || $is_paid) {
                $payment_amount = $is_paid ? $total_with_tax : $advance_payment;

                // البحث عن حساب الخزينة الرئيسية
                // $mainTreasuryAccount = Account::whereHas('parent.parent', function ($query) {
                //     $query->where('name', 'الأصول')->whereHas('children', function ($subQuery) {
                //         $subQuery->where('name', 'الأصول المتداولة');
                //     });
                // })
                //     ->where('name', 'الخزينة الرئيسية')
                //     ->first();

                // // التأكد من وجود حساب الخزينة الرئيسية
                // if (!$mainTreasuryAccount) {
                //     throw new \Exception('لم يتم العثور على حساب الخزينة الرئيسية');
                // }

                // البحث عن حساب العميل الفرعي
                $clientAccount = Account::where('name', $invoice->client->trade_name)
                    ->whereHas('parent', function ($query) {
                        $query->where('name', 'العملاء');
                    })
                    ->first();

                // التأكد من وجود حساب العميل
                if (!$clientAccount) {
                    throw new \Exception('لم يتم العثور على حساب العميل');
                }

                // إنشاء سجل الدفع
                $payment = PaymentsProcess::create([
                    'invoice_id' => $invoice->id,
                    'amount' => $payment_amount,
                    'payment_date' => now(),
                    'payment_method' => $request->payment_method,
                    'reference_number' => $request->reference_number,
                    'notes' => 'تم إنشاء الدفعة تلقائياً عند إنشاء الفاتورة',
                    'type' => 'client payments',
                    'payment_status' => $payment_status,
                    'created_by' => Auth::id(),
                ]);

                // إنشاء قيد محاسبي للدفعة
                $paymentJournalEntry = JournalEntry::create([
                    'reference_number' => $payment->reference_number ?? $invoice->code,
                    'date' => now(),
                    'description' => 'دفعة للفاتورة رقم ' . $invoice->code,
                    'status' => 1,
                    'currency' => 'SAR',
                    'client_id' => $invoice->client_id,
                    'invoice_id' => $invoice->id,
                    // 'created_by_employee' => Auth::id(),
                ]);

                // 1. حساب الخزينة الرئيسية (مدين)
                $treasuryDetail = JournalEntryDetail::create([
                    'journal_entry_id' => $paymentJournalEntry->id,
                    // 'account_id' => ,
                    'description' => 'استلام دفعة نقدية',
                    'debit' => $payment_amount,
                    'credit' => 0,
                    'is_debit' => true,
                    // 'treasury_account_id' => $mainTreasuryAccount->id, // تخزين معرف حساب الخزينة
                    'client_account_id' => $clientAccount->id, // تخزين معرف حساب العميل
                ]);

                // 2. حساب العميل (دائن)
                $clientDetail = JournalEntryDetail::create([
                    'journal_entry_id' => $paymentJournalEntry->id,
                    'account_id' => $clientAccount->id,
                    'description' => 'دفعة من العميل',
                    'debit' => 0,
                    'credit' => $payment_amount,
                    'is_debit' => false,
                    // 'treasury_account_id' => $mainTreasuryAccount->id, // تخزين معرف حساب الخزينة
                    'client_account_id' => $clientAccount->id, // تخزين معرف حساب العميل
                ]);
            }

            DB::commit();

            // إعداد رسالة النجاح
            // $response = Http::post($telegramApiUrl, [
            //     'chat_id' => '@Salesfatrasmart',  // تأكد من أن لديك صلاحية الإرسال للقناة
            //     'text' => sprintf("تم إنشاء فاتورة جديدة بنجاح. رقم الفاتورة: %s", $invoice->code),
            //     'parse_mode' => 'Markdown',
            // ]);

            // if ($response->failed()) {
            //     Log::error('خطاء في الارسال للقناة: ' . $response->body());
            // }

            return redirect()
                ->route('invoices.show', $invoice->id)
                ->with('success', sprintf('تم إنشاء فاتورة المبيعات بنجاح. رقم الفاتورة: %s', $invoice->code));
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('خطأ في إنشاء فاتورة المبيعات: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'عذراً، حدث خطأ أثناء حفظ فاتورة المبيعات: ' . $e->getMessage());
        }
    }
    private function getSalesAccount()
    {
        // البحث عن حساب المبيعات باسمه
        $salesAccount = Account::where('name', 'المبيعات')->orWhere('name', 'إيرادات المبيعات')->first();

        if (!$salesAccount) {
            throw new \Exception('لم يتم العثور على حساب المبيعات في دليل الحسابات');
        }

        return $salesAccount->id;
    }

    public function show($id)
    {
        $clients = Client::all();
        $employees = Employee::all();
        $invoice = Invoice::find($id);
        $account_setting = AccountSetting::where('user_id',auth()->user()->id)->first();
        $client   = Client::where('user_id',auth()->user()->id)->first();

        $invoice_number = $this->generateInvoiceNumber();

        // إنشاء رقم الباركود من رقم الفاتورة
        $barcodeNumber = str_pad($invoice->id, 13, '0', STR_PAD_LEFT); // تنسيق الرقم إلى 13 خانة

        // إنشاء رابط الباركود باستخدام خدمة Barcode Generator
        $barcodeImage = 'https://barcodeapi.org/api/128/' . $barcodeNumber;

        // تغيير اسم المتغير من qrCodeImage إلى barcodeImage
        return view('sales.invoices.show', compact('invoice_number','account_setting','client', 'clients', 'employees', 'invoice', 'barcodeImage'));
    }
    public function edit($id)
    {
        return redirect()
            ->back()
            ->with('error', 'لا يمكنك تعديل الفاتورة رقم ' . $id . '. طبقا لتعليمات هيئة الزكاة والدخل يمنع حذف أو تعديل الفاتورة بعد إصدارها وفقا لمتطلبات الفاتورة الإلكترونية، ولكن يمكن إصدار فاتورة مرتجعة أو إشعار دائن لإلغائها أو تعديلها.');
    }

    public function destroy($id)
    {
        return redirect()->route('invoices.index')->with('error', 'لا يمكنك حذف الفاتورة. طبقا لتعليمات هيئة الزكاة والدخل يمنع حذف أو تعديل الفاتورة بعد إصدارها وفقا لمتطلبات الفاتورة الإلكترونية، ولكن يمكن إصدار فاتورة مرتجعة أو إشعار دائن لإلغائها أو تعديلها.');
    }
    public function update(Request $request, $id)
    {
        return redirect()->route('invoices.index')->with('error', 'لا يمكنك تعديل الفاتورة. طبقا لتعليمات هيئة الزكاة والدخل يمنع حذف أو تعديل الفاتورة بعد إصدارها وفقا لمتطلبات الفاتورة الإلكترونية، ولكن يمكن إصدار فاتورة مرتجعة أو إشعار دائن لإلغائها أو تعديلها.');
    }

    private function generateInvoiceNumber()
    {
        $lastInvoice = Invoice::latest()->first();
        $nextId = $lastInvoice ? $lastInvoice->id + 1 : 1;
        return str_pad($nextId, 6, '0', STR_PAD_LEFT);
    }

    protected function getAccountId($type)
    {
        $account = Account::where('code', $type)->first();

        if (!$account) {
            throw new \Exception("لم يتم العثور على الحساب من نوع: {$type}. الرجاء التأكد من وجود الحساب في دليل الحسابات.");
        }

        return $account->id;
    }

    public function generatePdf($id)
    {
        $invoice = Invoice::with(['client', 'items', 'createdByUser'])->findOrFail($id);

        // إنشاء بيانات QR Code
        $qrData = 'رقم الفاتورة: ' . $invoice->id . "\n";
        $qrData .= 'التاريخ: ' . $invoice->created_at->format('Y/m/d') . "\n";
        $qrData .= 'العميل: ' . ($invoice->client->trade_name ?? $invoice->client->first_name . ' ' . $invoice->client->last_name) . "\n";
        $qrData .= 'الإجمالي: ' . number_format($invoice->grand_total, 2) . ' ر.س';

        // إنشاء QR Code
        $qrOptions = new \chillerlan\QRCode\QROptions([
            'outputType' => \chillerlan\QRCode\QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel' => \chillerlan\QRCode\QRCode::ECC_L,
            'scale' => 5,
            'imageBase64' => true,
        ]);
        // composer require chillerlan/php-qrcode

        $qrCode = new \chillerlan\QRCode\QRCode($qrOptions);
        $barcodeImage = $qrCode->render($qrData);

        // Create new PDF document
        $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Set document information
        $pdf->SetCreator('Fawtra');
        $pdf->SetAuthor('Fawtra System');
        $pdf->SetTitle('فاتورة رقم ' . $invoice->code);

        // Set margins
        $pdf->SetMargins(15, 15, 15);
        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(0);

        // Disable header and footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // Add new page
        $pdf->AddPage();

        // Set RTL direction
        $pdf->setRTL(true);

        // Set font
        $pdf->SetFont('aealarabiya', '', 14);

        // Pass QR code image to view
        $barcodeImage = $qrCode->render($qrData);

        // Generate content
        $html = view('sales.invoices.pdf', compact('invoice', 'barcodeImage'))->render();

        // Add content to PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Output file
        return $pdf->Output('invoice-' . $invoice->code . '.pdf', 'I');
    }
}
