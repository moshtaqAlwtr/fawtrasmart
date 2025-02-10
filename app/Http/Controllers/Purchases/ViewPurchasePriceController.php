<?php

namespace App\Http\Controllers\Purchases;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseOrder;
use App\Models\PurchaseQuotationView;
use App\Models\Supplier;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ViewPurchasePriceController extends Controller
{
    public function index(Request $request)
    {
        $suppliers = Supplier::all();

        // بناء الاستعلام
        $query = PurchaseQuotationView::query();

        // البحث بالكود
        if ($request->filled('code')) {
            $query->where('code', 'like', '%' . $request->code . '%');
        }

        // البحث بالتاريخ (من)
        if ($request->filled('order_date_from')) {
            $query->whereDate('date', '>=', $request->order_date_from);
        }

        // البحث بالتاريخ (إلى)
        if ($request->filled('order_date_to')) {
            $query->whereDate('date', '<=', $request->order_date_to);
        }

        // البحث بالعملة
        if ($request->filled('currency')) {
            $query->where('currency', $request->currency);
        }

        // البحث بالحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // البحث بالوسم (إذا كان هناك جدول للوسوم)
        if ($request->filled('tag')) {
            $query->where('tag', $request->tag);
        }

        // البحث بالنوع (إذا كان هناك جدول للأنواع)
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // ترتيب النتائج حسب التاريخ من الأحدث للأقدم
        $query->latest('date');

        // تحميل العلاقات المطلوبة
        $query->with(['supplier', 'account', 'items.product']);

        // الحصول على النتائج مع التقسيم إلى صفحات
        $purchaseQuotation = $query->get();

        return view('Purchases.view_purchase_price.index', compact('suppliers', 'purchaseQuotation'));
    }

    public function show($id)
    {
        try {
            // جلب عرض السعر مع العلاقات المرتبطة
            $purchaseQuotation = PurchaseQuotationView::with([
                'supplier',
                'account',
                'items.product',
                'creator'
            ])->findOrFail($id);

            // جلب جميع الموردين
            $suppliers = Supplier::select('id', 'trade_name')->get();

            return view('Purchases.view_purchase_price.show', compact('purchaseQuotation', 'suppliers'));
        } catch (\Exception $e) {
            return redirect()
                ->route('pricesPurchase.index')
                ->with('error', 'حدث خطأ أثناء عرض عرض السعر: ' . $e->getMessage());
        }
    }
    public function create()
    {
        $accounts = Account::all();
        $items = Product::all();
        $suppliers = Supplier::all();

        return view('Purchases.view_purchase_price.create', compact('suppliers', 'items', 'accounts'));
    }
    public function store(Request $request)
    {
        try {
            // توليد الكود تلقائياً إذا لم يتم إرساله
            if (!$request->code) {
                $lastQuotation = PurchaseQuotationView::latest()->first();
                $nextNumber = $lastQuotation ? intval($lastQuotation->code) + 1 : 1; // اجلب الرقم الأخير وزد واحدًا
                $request->merge(['code' => str_pad($nextNumber, 5, '0', STR_PAD_LEFT)]); // أضف الأصفار إلى اليسار
            }
            // التحقق من البيانات
            $rules = [
                'supplier_id' => 'required|exists:suppliers,id',
                'account_id' => 'nullable|exists:accounts,id',
                'code' => 'required|string|unique:purchase_quotations_view,code',
                'date' => 'required|date',
                'valid_days' => 'nullable|integer|min:0',
                'total_discount' => 'nullable|numeric|min:0',
                'status' => 'nullable|integer',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'خطأ في البيانات المدخلة',
                        'errors' => $validator->errors(),
                    ],
                    422,
                );
            }

            $validatedData = $validator->validated();

            DB::beginTransaction();

            // إنشاء عرض السعر
            $quotation = PurchaseQuotationView::create([
                'supplier_id' => $validatedData['supplier_id'],
                'account_id' => $validatedData['account_id'],
                'code' => $validatedData['code'],
                'date' => $validatedData['date'],
                'valid_days' => $validatedData['valid_days'] ?? 0,
                'status' => $validatedData['status'] ?? 1,
                'created_by' => Auth::id(),
            ]);

            $total_amount = 0;
            $total_discount = 0;

            // معالجة عناصر الفاتورة في جدول invoice_items
            if ($request->has('items')) {
                foreach ($request->items as $item) {
                    $product = Product::find($item['product_id']);
                    $item_total = $item['quantity'] * $item['unit_price'];
                    $item_discount = $item['discount'] ?? 0;

                    $total_amount += $item_total;
                    $total_discount += $item_discount;

                    InvoiceItem::create([
                        'quotes_purchase_order_id' => $quotation->id,
                        'product_id' => $item['product_id'],
                        'item' => $product->name ?? 'المنتج ' . $item['product_id'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'discount' => $item_discount,
                        'tax_1' => $item['tax_1'] ?? 0,
                        'tax_2' => $item['tax_2'] ?? 0,
                        'total' => $item_total - $item_discount,
                    ]);
                }
            }

            // تحديث المجموع النهائي والخصم
            $quotation->total_discount = $total_discount;
            $quotation->grand_total = $total_amount - $total_discount;
            $quotation->save();

            DB::commit();

            // التوجيه إلى صفحة index
            return redirect()->route('pricesPurchase.index')->with('success', 'تم إنشاء عرض السعر بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->back()
                ->with('error', 'حدث خطأ أثناء إنشاء عرض السعر: ' . $e->getMessage());
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $quotation = PurchaseQuotationView::findOrFail($id);

            // التحقق من البيانات
            $rules = [
                'supplier_id' => 'required|exists:suppliers,id',
                'account_id' => 'nullable|exists:accounts,id',
                'code' => 'required|string|unique:purchase_quotations_view,code,' . $id,
                'date' => 'required|date',
                'valid_days' => 'nullable|integer|min:0',
                'total_discount' => 'nullable|numeric|min:0',
                'status' => 'nullable|integer',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'خطأ في البيانات المدخلة',
                        'errors' => $validator->errors(),
                    ],
                    422,
                );
            }

            $validatedData = $validator->validated();

            DB::beginTransaction();

            // تحديث عرض السعر
            $quotation->update([
                'supplier_id' => $validatedData['supplier_id'],
                'account_id' => $validatedData['account_id'],
                'code' => $validatedData['code'],
                'date' => $validatedData['date'],
                'valid_days' => $validatedData['valid_days'] ?? 0,
                'status' => $validatedData['status'] ?? 1,
                'updated_by' => Auth::id(),
            ]);

            $total_amount = 0;
            $total_discount = 0;

            // حذف العناصر القديمة
            InvoiceItem::where('quotes_purchase_order_id', $quotation->id)->delete();

            // إضافة العناصر الجديدة
            if ($request->has('items')) {
                foreach ($request->items as $item) {
                    $product = Product::find($item['product_id']);
                    $item_total = $item['quantity'] * $item['unit_price'];
                    $item_discount = $item['discount'] ?? 0;

                    $total_amount += $item_total;
                    $total_discount += $item_discount;

                    InvoiceItem::create([
                        'quotes_purchase_order_id' => $quotation->id,
                        'product_id' => $item['product_id'],
                        'item' => $product->name ?? 'المنتج ' . $item['product_id'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'discount' => $item_discount,
                        'tax_1' => $item['tax_1'] ?? 0,
                        'tax_2' => $item['tax_2'] ?? 0,
                        'total' => $item_total - $item_discount,
                        'description' => $item['description'] ?? null,
                    ]);
                }
            }

            // تحديث المجموع النهائي والخصم
            $quotation->total_discount = $total_discount;
            $quotation->grand_total = $total_amount - $total_discount;
            $quotation->save();

            DB::commit();

            // إضافة سجل النشاط

            return redirect()
                ->route('pricesPurchase.show', $quotation->id)
                ->with('success', 'تم تحديث عرض السعر بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('خطأ في تحديث عرض السعر: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'حدث خطأ أثناء تحديث عرض السعر: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $purchaseQuotation = PurchaseQuotationView::with(['supplier', 'account', 'items.product'])->findOrFail($id);
        $suppliers = Supplier::all();
        $accounts = Account::all();
        $items = Product::all();
        return view('Purchases.view_purchase_price.edit', compact('purchaseQuotation', 'suppliers', 'accounts', 'items'));
    }
    public function destroy($id)
    {
        $quotation = PurchaseQuotationView::findOrFail($id);
        $quotation->delete();
        return redirect()->route('pricesPurchase.index')->with('success', 'تم حذف عرض السعر بنجاح');
    }
    public function updateStatus($id, Request $request)
    {
        try {
            $quotation = PurchaseQuotationView::findOrFail($id);

            // التحقق من الحالة المرسلة
            if (!in_array($request->status, [2, 3])) {
                return back()->with('error', 'حالة غير صالحة');
            }

            // تحديث الحالة
            $quotation->status = $request->status;
            $quotation->save();

            // رسالة نجاح مخصصة حسب الحالة
            $message = $request->status == 2 ? 'تمت الموافقة على عرض السعر بنجاح' : 'تم رفض عرض السعر';

            return redirect()->route('pricesPurchase.show', $id)->with('success', $message);
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ أثناء تحديث الحالة: ' . $e->getMessage());
        }
    }
    public function exportPDF($id)
    {
        try {
            $purchaseQuotation = PurchaseQuotationView::with(['supplier', 'account', 'items.product', 'creator'])->findOrFail($id);

            $pdf = Pdf::loadView('Purchases.view_purchase_price.pdf', compact('purchaseQuotation'));

            return $pdf->download('عرض-سعر-' . $purchaseQuotation->code . '.pdf');
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ أثناء تصدير PDF: ' . $e->getMessage());
        }
    }

    public function convertToPurchaseOrder($id, Request $request)
    {
        try {
            $quotation = PurchaseQuotationView::with(['items'])->findOrFail($id);

            if ($quotation->status != 2) {
                return back()->with('error', 'لا يمكن تحويل عرض السعر غير المعتمد إلى أمر شراء');
            }

            if (!$request->supplier_id) {
                return back()->with('error', 'يرجى اختيار المورد');
            }

            DB::beginTransaction();

            // إنشاء أمر شراء جديد
            $purchaseOrder = PurchaseInvoice::create([
                'supplier_id' => $request->supplier_id,
                'account_id' => $quotation->account_id,
                'quotation_id' => $quotation->id,
                'code' => 'PO-' . date('Ym') . '-' . str_pad(PurchaseInvoice::where('type', 1)->count() + 1, 4, '0', STR_PAD_LEFT),
                'date' => now(),
                'delivery_date' => now()->addDays(7),
                'type' => 1, // نوع أمر شراء
                'status' => 1, // 1 = تحت المراجعة
                'total_discount' => $quotation->total_discount ?? 0,
                'subtotal' => $quotation->subtotal ?? 0,
                'total_tax' => ($quotation->total_tax_1 ?? 0) + ($quotation->total_tax_2 ?? 0),
                'grand_total' => $quotation->grand_total ?? 0,
                'created_by' => Auth::id(),
                'notes' => $quotation->notes,
                'payment_terms' => $quotation->payment_terms ?? '',
                'currency' => $quotation->currency ?? 'SAR'
            ]);

            // نسخ عناصر عرض السعر إلى بنود الفواتير
            $items = $quotation->items()->distinct()->get();
            foreach ($items as $item) {
                DB::table('invoice_items')->insert([
                    'purchase_invoice_id_type' => $purchaseOrder->id,
                    'quotes_purchase_order_id' => $quotation->id,
                    'product_id' => $item->product_id,
                    'item' => $item->item,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'discount' => $item->discount ?? 0,
                    'tax_1' => $item['tax_1'] ?? 0,
                    'tax_2' => $item['tax_2'] ?? 0,
                    'total' => $item->total,
                    'description' => $item->description,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
            // تحديث حالة عرض السعر
            $quotation->update([
                'converted_to_po' => true,
                'status' => 2
            ]);

            DB::commit();

            return back()->with('success', 'تم تحويل عرض السعر إلى أمر شراء بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('خطأ في تحويل عرض السعر: ' . $e->getMessage());
            return back()->with('error', 'حدث خطأ أثناء تحويل عرض السعر: ' . $e->getMessage());
        }
    }
}
