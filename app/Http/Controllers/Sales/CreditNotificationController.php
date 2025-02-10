<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sales\StoreCreditNotificationRequest;
use App\Models\Client;
use App\Models\CreditNotification;
use App\Models\Employee;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Dompdf\Dompdf;
use Dompdf\Options;

class CreditNotificationController extends Controller
{
    public function index(Request $request)
    {
        $query = CreditNotification::with(['client', 'createdBy']);

        // البحث حسب العميل
        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        // البحث حسب رقم الإشعار
        if ($request->filled('invoice_number')) {
            $query->where('credit_number', 'LIKE', '%' . $request->invoice_number . '%');
        }

        // البحث في البنود
        if ($request->filled('item_search')) {
            $query->whereHas('items', function ($q) use ($request) {
                $q->where('item', 'LIKE', '%' . $request->item_search . '%')
                  ->orWhere('description', 'LIKE', '%' . $request->item_search . '%');
            });
        }

        // البحث حسب العملة
        if ($request->filled('currency')) {
            $query->where('currency', $request->currency);
        }

        // البحث حسب المبلغ
        if ($request->filled('total_from')) {
            $query->where('total', '>=', $request->total_from);
        }
        if ($request->filled('total_to')) {
            $query->where('total', '<=', $request->total_to);
        }

        // البحث حسب تاريخ الإنشاء
        if ($request->filled('date_type_1')) {
            switch($request->date_type_1) {
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
                    if ($request->filled('from_date_1') && $request->filled('to_date_1')) {
                        $query->whereBetween('created_at', [$request->from_date_1, $request->to_date_1]);
                    }
            }
        }

        // البحث حسب تاريخ الاستحقاق
        if ($request->filled('date_type_2')) {
            switch($request->date_type_2) {
                case 'monthly':
                    $query->whereMonth('due_date', now()->month);
                    break;
                case 'weekly':
                    $query->whereBetween('due_date', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'daily':
                    $query->whereDate('due_date', now());
                    break;
                default:
                    if ($request->filled('from_date_2') && $request->filled('to_date_2')) {
                        $query->whereBetween('due_date', [$request->from_date_2, $request->to_date_2]);
                    }
            }
        }

        // البحث حسب المصدر
        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        // البحث في الحقل المخصص
        if ($request->filled('custom_field')) {
            $query->where('custom_field', 'LIKE', '%' . $request->custom_field . '%');
        }

        // البحث حسب من أضاف
        if ($request->filled('created_by')) {
            $query->where('created_by', $request->created_by);
        }

        // البحث حسب خيارات الشحن
        if ($request->filled('shipping_option')) {
            $query->where('shipping_option', $request->shipping_option);
        }

        // البحث حسب post shift
        if ($request->filled('post_shift')) {
            $query->where('post_shift', 'LIKE', '%' . $request->post_shift . '%');
        }

        // البحث حسب مصدر الطلب
        if ($request->filled('order_source')) {
            $query->where('order_source', $request->order_source);
        }

        // ترتيب النتائج حسب تاريخ الإنشاء تنازلياً
        $credits = $query->orderBy('created_at', 'desc')->get();

        // جلب البيانات الأخرى المطلوبة للصفحة
        $Credits_number = $this->generateInvoiceNumber();
        $clients = Client::all();
        $users = User::all();

        return view('sales.creted_note.index', compact(
            'credits',
            'users',
            'Credits_number',
            'clients'
        ))->with('search_params', $request->all()); // إرجاع معاملات البحث للحفاظ على حالة النموذج
    }




    private function generateInvoiceNumber()
    {
        $lastCredit = CreditNotification::latest()->first();
        return $lastCredit ? $lastCredit->id + 1 : 1;
    }

    public function create()
    {
        $items = Product::all();
        $Credits_number = $this->generateInvoiceNumber();
        $clients = Client::all();
        $users = User::all();
        return view('sales.creted_note.create', compact('clients', 'users', 'Credits_number', 'items'));
    }
    public function show($id)
    {
        $credit = CreditNotification::with(['client', 'createdBy', 'items'])->findOrFail($id);

        return view('sales.creted_note.show', compact('credit'));
    }
    public function edit($id)
    {
        return redirect()
            ->back()
            ->with('error', 'لا يمكنك تعديل الفاتورة رقم ' . $id . '. طبقاً لتعليمات هيئة الزكاة والدخل يمنع حذف أو تعديل الفاتورة بعد إصدارها وفقاً لمتطلبات الفاتورة الإلكترونية.');
    }


    public function destroy($id)
    {
        return redirect()->route('CreditNotes.index')->with('error', 'لا يمكنك حذف الفاتورة. طبقاً لتعليمات هيئة الزكاة والدخل يمنع حذف أو تعديل الفاتورة بعد إصدارها وفقاً لمتطلبات الفاتورة الإلكترونية.');
    }

    public function store(Request $request)
    {
        // التحقق من صحة البيانات باستخدام helper function
        $validated = validator($request->all(), [
            'client_id' => 'required|exists:clients,id',
            'credit_date' => 'required|date_format:Y-m-d',
            'release_date' => 'required|date_format:Y-m-d',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id', // إضافة التحقق من المستودع
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
            // ** الخطوة الأولى: إنشاء كود للعرض **
            $credit_number = $request->input('credit_number');
            if (!$credit_number) {
                $lastOrder = CreditNotification::orderBy('id', 'desc')->first();
                $nextNumber = $lastOrder ? intval($lastOrder->credit_number) + 1 : 1;
                $credit_number = str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
            } else {
                $existingCode = CreditNotification::where('credit_number', $credit_number)->exists();
                if ($existingCode) {
                    return redirect()->back()->withInput()->with('error', 'رقم العرض موجود مسبقاً، الرجاء استخدام رقم آخر');
                }
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
                    'credit_note_id' => null, // سيتم تعيينه لاحقًا بعد إنشاء العرض
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

            // ** حساب الضرائب **
            $tax_total = 0;
            $tax_type = $tax_type_map[$validated['tax_type']];
            if ($tax_type === 'vat') {
                // حساب الضريبة على المبلغ بعد الخصم
                $tax_total = $amount_after_discount * 0.15; // نسبة الضريبة 15%
            }

            // ** إضافة تكلفة الشحن (إذا وجدت) **
            $shipping_cost = floatval($validated['shipping_cost'] ?? 0);

            // ** حساب ضريبة الشحن (إذا كانت الضريبة مفعلة) **
            $shipping_tax = 0;
            if ($tax_type === 'vat') {
                $shipping_tax = $shipping_cost * 0.15; // ضريبة الشحن 15%
            }

            // ** إضافة ضريبة الشحن إلى tax_total **
            $tax_total += $shipping_tax;

            // ** الحساب النهائي للمجموع الكلي **
            $total_with_tax = $amount_after_discount + $tax_total + $shipping_cost;

            // ** الخطوة الرابعة: إنشاء العرض في قاعدة البيانات **
            $creditNot = CreditNotification::create([
                'client_id' => $validated['client_id'],
                'credit_number' => $credit_number,
                'release_date' => $validated['release_date'],
                'credit_date' => $validated['credit_date'],
                'notes' => $validated['notes'] ?? null,
                'created_by' => Auth::id(),
                'discount_amount' => $quote_discount,
                'discount_type' => $discountType === 'percentage' ? 2 : 1,
                'shipping_cost' => $shipping_cost,
                'shipping_tax' => $shipping_tax,
                'tax_type' => $validated['tax_type'], // نحفظ الرقم في قاعدة البيانات
                'subtotal' => $total_amount,
                'total_discount' => $final_total_discount,
                'tax_total' => $tax_total,
                'grand_total' => $total_with_tax,
                'status' => 1, // حالة العرض (1: Draft)
            ]);

            // ** الخطوة الخامسة: إنشاء سجلات البنود (items) للعرض **
            foreach ($items_data as $item) {
                $item['credit_note_id'] = $creditNot->id;
                InvoiceItem::create($item);
            }

            DB::commit();
            return redirect()->route('CreditNotes.index')->with('success', 'تم إنشاء اشعار دائن  بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('حدث خطأ في دالة store: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'عذراً، حدث خطأ أثناء حفظ  اشعار دائن: ' . $e->getMessage());
        }
    }

    public function print($id)
    {
        try {
            $credit = CreditNotification::with(['client', 'createdBy'])->findOrFail($id);

            // تكوين خيارات PDF
            $config = new Options();
            $config->set('defaultFont', 'DejaVu Sans');
            $config->set('isRemoteEnabled', true);
            $config->set('isHtml5ParserEnabled', true);
            $config->set('isFontSubsettingEnabled', true);
            $config->set('isPhpEnabled', true);
            $config->set('chroot', [
                public_path(),
                base_path('vendor/dompdf/dompdf/lib/fonts/'),
                storage_path('fonts/')
            ]);
            
            // إنشاء كائن Dompdf
            $dompdf = new Dompdf($config);
            
            // تحميل محتوى HTML مع ترميز UTF-8
            $data = [
                'credit' => $credit,
                'company_data' => [
                    'company_name' => 'اسم شركتك',
                    'company_address' => 'عنوان الشركة',
                    'company_phone' => 'رقم الهاتف',
                    'company_email' => 'email@company.com',
                    'company_logo' => asset('path/to/your/logo.png'),
                    'tax_number' => 'الرقم الضريبي للشركة'
                ]
            ];
            $html = view('sales.creted_note.pdf', $data)->render();
            $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
            
            // تحميل HTML
            $dompdf->loadHtml($html);
            
            // تعيين حجم الصفحة
            $dompdf->setPaper('A4', 'portrait');
            
            // تنفيذ PDF
            $dompdf->render();

            // إرجاع الملف للتحميل
            return $dompdf->stream('credit_note_' . $credit->credit_number . '.pdf', [
                'Attachment' => false
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء إنشاء PDF: ' . $e->getMessage());
        }
    }


    private function convertNumberToArabicWords($number)
    {
        $digit1 = ['', 'واحد', 'اثنان', 'ثلاثة', 'أربعة', 'خمسة', 'ستة', 'سبعة', 'ثمانية', 'تسعة'];
        $digit2 = ['', 'عشر', 'عشرون', 'ثلاثون', 'أربعون', 'خمسون', 'ستون', 'سبعون', 'ثمانون', 'تسعون'];
        $digit3 = ['', 'مائة', 'مئتان', 'ثلاثمائة', 'أربعمائة', 'خمسمائة', 'ستمائة', 'سبعمائة', 'ثمانمائة', 'تسعمائة'];

        // تنفيذ المنطق الخاص بتحويل الرقم إلى كلمات
        // يمكنك استخدام مكتبة جاهزة مثل khaled.alshamaa/ar-php

        return ""; // قم بتنفيذ المنطق المناسب هنا
    }

    }
