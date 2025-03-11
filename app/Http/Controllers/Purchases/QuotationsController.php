<?php

namespace App\Http\Controllers\Purchases;

use App\Exports\QuotationsExport;
use App\Http\Controllers\Controller;
use App\Models\Log as ModelsLog;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\PurchaseQuotation;
use App\Models\ProductDetails;
use App\Models\PurchaseQuotationSupplier;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class QuotationsController extends Controller
{
    public function index(Request $request)
    {
        $query = PurchaseQuotation::query();

        // البحث بالكود
        if ($request->has('code') && $request->code != '') {
            $query->where('code', 'like', '%' . $request->code . '%');
        }

        // البحث بالمورد
        if ($request->has('supplier_id') && $request->supplier_id != '') {
            $query->whereHas('suppliers', function ($q) use ($request) {
                $q->where('supplier_id', $request->supplier_id);
            });
        }

        // البحث بتاريخ الطلب
        if ($request->has('order_date_from') && $request->order_date_from != '') {
            $query->whereDate('order_date', '>=', $request->order_date_from);
        }
        if ($request->has('order_date_to') && $request->order_date_to != '') {
            $query->whereDate('order_date', '<=', $request->order_date_to);
        }

        // البحث بتاريخ الاستحقاق
        if ($request->has('due_date_from') && $request->due_date_from != '') {
            $query->whereDate('due_date', '>=', $request->due_date_from);
        }
        if ($request->has('due_date_to') && $request->due_date_to != '') {
            $query->whereDate('due_date', '<=', $request->due_date_to);
        }

        // البحث بالحالة
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // البحث بحالة المتابعة
        if ($request->has('follow_status') && $request->follow_status != '') {
            $query->where('follow_status', $request->follow_status);
        }

        $purchaseQuotation = $query->latest()->paginate(10);
        $suppliers = Supplier::all();

        return view('purchases.Quotations.index', compact('suppliers', 'purchaseQuotation'));
    }
    public function show($id)
    {
        try {
            // تحميل طلب عرض السعر مع العلاقات
            $purchaseQuotation = PurchaseQuotation::with(['suppliers', 'creator', 'updater'])->findOrFail($id);
            $suppliers = Supplier::all();
            // تحميل تفاصيل المنتجات
            $productDetails = ProductDetails::where('purchase_quotation_id', $id)->get();

            return view('purchases.Quotations.show', compact('purchaseQuotation', 'productDetails', 'suppliers'));
        } catch (\Exception $e) {
            return redirect()
                ->route('Quotations.index')
                ->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }
    public function create()
    {
        $products = Product::all();
        $suppliers = Supplier::all();
        return view('purchases.Quotations.create', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        try {
            // التحقق من البيانات
            $validatedData = $request->validate(
                [
                    'order_date' => 'required|date',
                    'due_date' => 'nullable|date',
                    'supplier_id' => 'required|array|min:1',
                    'supplier_id.*' => 'exists:suppliers,id',
                    'notes' => 'nullable|string',
                    'attachments' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
                    'product_details' => 'required|array|min:1',
                    'product_details.*.product_id' => 'required|exists:products,id',
                    'product_details.*.quantity' => 'required|integer|min:1',
                ],
                [
                    'supplier_id.required' => 'يجب اختيار مورد واحد على الأقل',
                    'supplier_id.min' => 'يجب اختيار مورد واحد على الأقل',
                    'supplier_id.*.exists' => 'أحد الموردين المحددين غير موجود',
                    'product_details.required' => 'يجب إضافة منتج واحد على الأقل',
                    'product_details.*.product_id.required' => 'يجب اختيار المنتج',
                    'product_details.*.quantity.required' => 'يجب تحديد الكمية',
                ],
            );

            DB::beginTransaction();

            try {
                // إنشاء الكود تلقائياً
                $lastQuotation = PurchaseQuotation::latest()->first();
                $nextId = $lastQuotation ? $lastQuotation->id + 1 : 1;
                $code = 'QUO-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);

                // إنشاء عرض السعر
                $purchaseQuotation = PurchaseQuotation::create([
                    'code' => $code,
                    'order_date' => $validatedData['order_date'],
                    'due_date' => $validatedData['due_date'] ?? null,
                    'notes' => $validatedData['notes'] ?? null,
                    'status' => 1,
                    'created_by' => Auth::id(),
                ]);

                // معالجة المرفقات
                if ($request->hasFile('attachments')) {
                    $path = $request->file('attachments')->store('purchase_quotations', 'public');
                    $purchaseQuotation->attachments = $path;
                    $purchaseQuotation->save();
                }

                // إنشاء علاقات الموردين
                foreach ($validatedData['supplier_id'] as $supplierId) {
                    PurchaseQuotationSupplier::create([
                        'purchase_quotation_id' => $purchaseQuotation->id,
                        'supplier_id' => $supplierId,
                        'created_by' => Auth::id(),
                    ]);
                }

                // إضافة تفاصيل المنتجات
                foreach ($validatedData['product_details'] as $detail) {
                    $productDetail =    ProductDetails::create([
                        'purchase_quotation_id' => $purchaseQuotation->id,
                        'product_id' => $detail['product_id'],
                        'quantity' => $detail['quantity'],
                        'type' => 1,
                        'type_of_operation' => 1,
                    ]);
                    $productDetail->load('product');
                    ModelsLog::create([
                        'type' => 'purchase_log',
                        'type_id' => $purchaseQuotation->id, // ID النشاط المرتبط
                        'type_log' => 'log', // نوع النشاط
                        'description' => sprintf(
                            '  تم اضافة عرض سعر رقم **%s** للمنتج **%s** كمية **%d**',
                            $purchaseQuotation->code, // رقم طلب الشراء
                            $productDetail->product->name, // اسم المنتج
                            $detail['quantity'] // الكمية
                        ),
                        'created_by' => auth()->id(), // ID المستخدم الحالي
                    ]);
                }

                DB::commit();
                return redirect()->route('Quotations.index')->with('success', 'تم إنشاء طلب عرض السعر بنجاح');
            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'حدث خطأ غير متوقع: ' . $e->getMessage());
        }
    }
    public function update(Request $request, $id)
    {
        try {
            // التحقق من البيانات بشكل مرن
            $validatedData = $request->validate([
                'order_date' => 'nullable|date',
                'due_date' => 'nullable|date',
                'supplier_id' => 'nullable|array',
                'supplier_id.*' => 'exists:suppliers,id',
                'notes' => 'nullable|string',
                'attachments' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
                'product_details' => 'nullable|array',
                'product_details.*.product_id' => 'nullable|exists:products,id',
                'product_details.*.quantity' => 'nullable|integer|min:1',
            ]);

            DB::beginTransaction();

            try {
                $purchaseQuotation = PurchaseQuotation::findOrFail($id);

                // تحديث البيانات الأساسية
                $purchaseQuotation->update([
                    'order_date' => $request->order_date ?? $purchaseQuotation->order_date,
                    'due_date' => $request->due_date ?? $purchaseQuotation->due_date,
                    'notes' => $request->notes ?? $purchaseQuotation->notes,
                    'updated_by' => Auth::id(),
                ]);
                // معالجة المرفقات
                if ($request->hasFile('attachments')) {
                    if ($purchaseQuotation->attachments) {
                        Storage::disk('public')->delete($purchaseQuotation->attachments);
                    }
                    $path = $request->file('attachments')->store('purchase_quotations', 'public');
                    $purchaseQuotation->attachments = $path;
                    $purchaseQuotation->save();
                }

                // تحديث الموردين إذا تم تقديمهم
                if (isset($validatedData['supplier_id'])) {
                    PurchaseQuotationSupplier::where('purchase_quotation_id', $id)->delete();
                    foreach ($validatedData['supplier_id'] as $supplierId) {
                        PurchaseQuotationSupplier::create([
                            'purchase_quotation_id' => $purchaseQuotation->id,
                            'supplier_id' => $supplierId,
                            'created_by' => Auth::id(),
                        ]);
                    }
                }

                // تحديث تفاصيل المنتجات إذا تم تقديمها
                if (isset($validatedData['product_details'])) {
                    ProductDetails::where('purchase_quotation_id', $id)->where('type', 1)->delete();

                    foreach ($validatedData['product_details'] as $detail) {
                        if (!empty($detail['product_id']) && !empty($detail['quantity'])) {
                            ProductDetails::create([
                                'purchase_quotation_id' => $purchaseQuotation->id,
                                'product_id' => $detail['product_id'],
                                'quantity' => $detail['quantity'],
                                'type' => 1,
                                'type_of_operation' => 1,
                            ]);
                        }
                    }
                }

                DB::commit();
                return redirect()->route('Quotations.index')->with('success', 'تم تحديث عرض السعر بنجاح');
            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'حدث خطأ غير متوقع: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $purchaseQuotation = PurchaseQuotation::findOrFail($id);

        // جلب الموردين المرتبطين

        // جلب قوائم البيانات المطلوبة
        $suppliers = Supplier::all();
        $products = Product::all();

        return view('Purchases.Quotations.edit', compact('purchaseQuotation', 'products', 'suppliers'));
    }
    public function destroy($id)
    {
        $purchaseQuotation = PurchaseQuotation::findOrFail($id);
        ModelsLog::create([
            'type' => 'product_log',
            'type_id' =>  $purchaseQuotation->id, // ID النشاط المرتبط
            'type_log' => 'log', // نوع النشاط
            'description' => 'تم حذف  عرض سعر رقم **' .  $purchaseQuotation->code . '**', // النص المنسق
            'created_by' => auth()->id(), // ID المستخدم الحالي
        ]);
        $purchaseQuotation->items()->delete();
        $purchaseQuotation->delete();
        return redirect()->route('Quotations.index')->with('success', 'تم حذف عرض السعر بنجاح!');
    }
    public function approve(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $purchaseQuotation = PurchaseQuotation::findOrFail($id);

            // تحديث حالة الطلب
            $purchaseQuotation->update([
                'status' => 2, // موافق عليه
                'updated_by' => Auth::id(),
            ]);

            // إضافة ملاحظة الموافقة إذا وجدت
            if ($request->has('note')) {
                $purchaseQuotation->activities()->create([
                    'description' => 'تمت الموافقة على الطلب. ملاحظة: ' . $request->note,
                    'created_by' => Auth::id(),
                ]);
            } else {
                $purchaseQuotation->activities()->create([
                    'description' => 'تمت الموافقة على الطلب',
                    'created_by' => Auth::id(),
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'تمت الموافقة على طلب عرض السعر بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->back()
                ->with('error', 'حدث خطأ أثناء الموافقة على الطلب: ' . $e->getMessage());
        }
    }

    /**
     * رفض طلب عرض السعر
     */
    public function reject(Request $request, $id)
    {
        try {
            $request->validate(
                [
                    'note' => 'required|string|max:500',
                ],
                [
                    'note.required' => 'يجب إدخال سبب الرفض',
                ],
            );

            DB::beginTransaction();

            $purchaseQuotation = PurchaseQuotation::findOrFail($id);

            // تحديث حالة الطلب
            $purchaseQuotation->update([
                'status' => 3, // مرفوض
                'updated_by' => Auth::id(),
            ]);

            // إضافة سبب الرفض
            $purchaseQuotation->activities()->create([
                'description' => 'تم رفض الطلب. السبب: ' . $request->note,
                'created_by' => Auth::id(),
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'تم رفض طلب عرض السعر بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->back()
                ->with('error', 'حدث خطأ أثناء رفض الطلب: ' . $e->getMessage());
        }
    }

    /**
     * نسخ طلب عرض السعر
     */
    public function duplicate($id)
    {
        try {
            DB::beginTransaction();

            $originalQuotation = PurchaseQuotation::with(['items', 'suppliers'])->findOrFail($id);

            // إنشاء نسخة جديدة
            $newQuotation = $originalQuotation->replicate();
            $newQuotation->code = $this->generateQuotationCode();
            $newQuotation->status = 1; // تحت المراجعة
            $newQuotation->created_by = Auth::id();
            $newQuotation->updated_by = null;
            $newQuotation->save();

            // نسخ المنتجات
            foreach ($originalQuotation->items as $item) {
                $newItem = $item->replicate();
                $newItem->purchase_quotation_id = $newQuotation->id;
                $newItem->save();
            }

            // نسخ الموردين
            $newQuotation->suppliers()->attach($originalQuotation->suppliers->pluck('id')->toArray());

            DB::commit();
            return redirect()
                ->route('Quotations.edit', $newQuotation->id)
                ->with('success', 'تم نسخ طلب عرض السعر بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->back()
                ->with('error', 'حدث خطأ أثناء نسخ الطلب: ' . $e->getMessage());
        }
    }

    /**
     * تصدير طلب عرض السعر بصيغة PDF
     */
    // public function exportPDF($id)
    // {
    //     try {
    //         $purchaseQuotation = PurchaseQuotation::with(['suppliers', 'items.product', 'items.unit', 'creator'])->findOrFail($id);

    //         $pdf = Pdf::loadView('purchases.Quotations.pdf', compact('purchaseQuotation'));
    //         return $pdf->download('quotation-' . $purchaseQuotation->code . '.pdf');
    //     } catch (\Exception $e) {
    //         return redirect()
    //             ->back()
    //             ->with('error', 'حدث خطأ أثناء تصدير الملف: ' . $e->getMessage());
    //     }
    // }

    // /**
    //  * تصدير طلب عرض السعر بصيغة Excel
    //  */
    // public function exportExcel($id)
    // {
    //     try {
    //         $purchaseQuotation = PurchaseQuotation::with(['suppliers', 'items.product', 'items.unit'])->findOrFail($id);

    //         return Excel::download(new QuotationsExport($purchaseQuotation), 'quotation-' . $purchaseQuotation->code . '.xlsx');
    //     } catch (\Exception $e) {
    //         return redirect()
    //             ->back()
    //             ->with('error', 'حدث خطأ أثناء تصدير الملف: ' . $e->getMessage());
    //     }
    // }
}
