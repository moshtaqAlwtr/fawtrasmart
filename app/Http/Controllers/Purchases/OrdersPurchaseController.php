<?php

namespace App\Http\Controllers\Purchases;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Log as ModelsLog;
use App\Models\Product;
use App\Models\ProductDetails;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrdersPurchaseController extends Controller
{
    public function index(Request $request)
    {
        $employees = Employee::all();

        // بناء الاستعلام
        $query = PurchaseOrder::query()->withCount('productDetails');

        // البحث حسب حالة المتابعة
        if ($request->filled('follow_status')) {
            $query->where('follow_status', $request->follow_status);
        }

        // البحث حسب الموظف
        if ($request->filled('employee_id')) {
            $query->where('created_by', $request->employee_id);
        }

        // البحث حسب الكود
        if ($request->filled('code')) {
            $query->where('code', 'LIKE', '%' . $request->code . '%');
        }

        // البحث حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // البحث حسب تاريخ الطلب (من)
        if ($request->filled('order_date_from')) {
            $query->whereDate('order_date', '>=', $request->order_date_from);
        }

        // البحث حسب تاريخ الطلب (إلى)
        if ($request->filled('order_date_to')) {
            $query->whereDate('order_date', '<=', $request->order_date_to);
        }

        // البحث حسب تاريخ الاستحقاق (من)
        if ($request->filled('due_date_from')) {
            $query->whereDate('due_date', '>=', $request->due_date_from);
        }

        // البحث حسب تاريخ الاستحقاق (إلى)
        if ($request->filled('due_date_to')) {
            $query->whereDate('due_date', '<=', $request->due_date_to);
        }

        // تنفيذ الاستعلام وترتيب النتائج
        $purchaseOrders = $query->latest()->paginate(10);

        return view('Purchases.ordersPurchase.index', compact('employees', 'purchaseOrders'));
    }
    public function show($id)
    {
        $productDetails = ProductDetails::all();
        $purchaseOrder = PurchaseOrder::findOrFail($id);
        return view('Purchases.ordersPurchase.show', compact('purchaseOrder', 'productDetails'));
    }

    public function create()
    {
        $products = Product::all();
        $employees = Employee::all();
        return view('Purchases.ordersPurchase.create', compact('employees', 'products'));
    }
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'code' => 'required|string|unique:purchase_orders,code',
            'order_date' => 'required|date',
            'due_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'attachments' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'status' => 'nullable|integer',
            'product_details' => 'required|array',
            'product_details.*.product_id' => 'required|exists:products,id',
            'product_details.*.quantity' => 'required|integer|min:1',
        ]);

        $purchaseOrder = PurchaseOrder::create([
            'title' => $validatedData['title'],
            'code' => $validatedData['code'],
            'order_date' => $validatedData['order_date'],
            'due_date' => $validatedData['due_date'] ?? null,
            'notes' => $validatedData['notes'] ?? null,
            'created_by' => auth()->id(),
        ]);

        if ($request->hasFile('attachments')) {
            $file = $request->file('attachments');
            if ($file->isValid()) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('assets/uploads/purchase_orders'), $filename);
                $purchaseOrder->attachments = $filename;
                $purchaseOrder->save();
            }
        }

        // فحص البيانات المرسلة في product_details

        foreach ($validatedData['product_details'] as $detail) {
            if (empty($purchaseOrder->id)) {
                // إضافة فحص في حال كانت قيمة purchase_order_id غير موجودة
                dd('Invalid purchase_order_id');
            }

            $productDetail =  ProductDetails::create([
                'purchase_order_id' => $purchaseOrder->id,
                'product_id' => $detail['product_id'],
                'quantity' => $detail['quantity'],
            ]);
            // تحميل العلاقة مع المنتج
            $productDetail->load('product');

            // تسجيل اشعار نظام جديد لكل منتج
            ModelsLog::create([
                'type' => 'purchase_log',
                'type_id' => $purchaseOrder->id, // ID النشاط المرتبط
                'type_log' => 'log', // نوع النشاط
                'description' => sprintf(
                    'تم طلب شراء رقم **%s** للمنتج **%s** كمية **%d**',
                    $purchaseOrder->code, // رقم طلب الشراء
                    $productDetail->product->name, // اسم المنتج
                    $detail['quantity'] // الكمية
                ),
                'created_by' => auth()->id(), // ID المستخدم الحالي
            ]);
        }

        return redirect()->route('OrdersPurchases.index')->with('success', 'تم إنشاء طلب الشراء بنجاح!');
    }
    public function edit($id)
    {
        $purchaseOrder = PurchaseOrder::with('productDetails')->findOrFail($id);
        $products = Product::all();
        $employees = Employee::all();
        return view('Purchases.ordersPurchase.edit', compact('purchaseOrder', 'products', 'employees'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'code' => 'required|string|unique:purchase_orders,code,' . $id,
            'order_date' => 'required|date',
            'due_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'attachments' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'status' => 'nullable|integer',
            'product_details' => 'nullable|array', // تغيير من nullable إلى required
            'product_details.*.product_id' => 'nullable|exists:products,id', // تغيير من nullable إلى required
            'product_details.*.quantity' => 'nullable|integer|min:1', // تغيير من nullable إلى required
        ]);

        DB::beginTransaction();
        try {
            $purchaseOrder = PurchaseOrder::findOrFail($id);

            // تحديث بيانات طلب الشراء
            $updateData = [
                'title' => $validatedData['title'],
                'code' => $validatedData['code'],
                'order_date' => $validatedData['order_date'],
                'due_date' => $validatedData['due_date'] ?? null,
                'notes' => $validatedData['notes'] ?? null,

                'updated_by' => auth()->id(),
            ];

            $purchaseOrder->update($updateData);

            // معالجة الملف المرفق
            if ($request->hasFile('attachments')) {
                $file = $request->file('attachments');
                if ($file->isValid()) {
                    // حذف الملف القديم إذا وجد
                    if ($purchaseOrder->attachments) {
                        $oldFilePath = public_path('assets/uploads/purchase_orders/' . $purchaseOrder->attachments);
                        if (file_exists($oldFilePath)) {
                            unlink($oldFilePath);
                        }
                    }

                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('assets/uploads/purchase_orders'), $filename);
                    $purchaseOrder->attachments = $filename;
                    $purchaseOrder->save();
                }
            }

            // حذف تفاصيل المنتجات القديمة
            if (isset($validatedData['product_details']) && is_array($validatedData['product_details'])) {
                $purchaseOrder->productDetails()->delete();

                // إنشاء تفاصيل المنتجات الجديدة
                foreach ($validatedData['product_details'] as $detail) {
                    if (isset($detail['product_id']) && isset($detail['quantity'])) {
                        $purchaseOrder->productDetails()->create([
                            'product_id' => $detail['product_id'],
                            'quantity' => $detail['quantity'],
                        ]);
                    }
                }
            }
            ModelsLog::create([
                'type' => 'product_log',
                'type_id' =>  $purchaseOrder->id, // ID النشاط المرتبط
                'type_log' => 'log', // نوع النشاط

                'description' => 'تم حذف طلب شراء **' .  $validatedData['code'] . '**', // النص المنسق
                'created_by' => auth()->id(), // ID المستخدم الحالي
            ]);
            DB::commit();
            return redirect()->route('OrdersPurchases.index')
                ->with('success', 'تم تحديث طلب الشراء بنجاح!');
        } catch (\Exception $e) {
            DB::rollback();
            // تسجيل الخطأ للتحقق
            Log::error('خطأ في تحديث طلب الشراء: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء تحديث طلب الشراء: ' . $e->getMessage())
                ->withInput();
        }
    }
    public function destroy($id)
    {
        $purchaseOrder = PurchaseOrder::findOrFail($id);
        // تسجيل اشعار نظام جديد
        ModelsLog::create([
            'type' => 'product_log',
            'type_id' =>  $purchaseOrder->id, // ID النشاط المرتبط
            'type_log' => 'log', // نوع النشاط
            'description' => 'تم حذف طلب شراء **' .  $purchaseOrder->title . '**', // النص المنسق
            'created_by' => auth()->id(), // ID المستخدم الحالي
        ]);
        $purchaseOrder->productDetails()->delete();
        $purchaseOrder->delete();
        return redirect()->route('OrdersPurchases.index')->with('success', 'تم حذف طلب الشراء بنجاح!');
    }
    public function approve(Request $request, $id)
    {
        $purchaseOrder = PurchaseOrder::findOrFail($id);

        DB::beginTransaction();
        try {
            $purchaseOrder->update([
                'status' => 2, // حالة الموافقة
                'approved_by' => auth()->id(),
                'approved_at' => now(),
                'approval_note' => $request->note
            ]);

            DB::commit();
            // العودة لنفس الصفحة
            return redirect()->back()
                ->with('success', 'تمت الموافقة على الطلب بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء الموافقة على الطلب');
        }
    }

    public function reject(Request $request, $id)
    {
        $purchaseOrder = PurchaseOrder::findOrFail($id);

        DB::beginTransaction();
        try {
            $purchaseOrder->update([
                'status' => 3, // حالة الرفض
                'rejected_by' => auth()->id(),
                'rejected_at' => now()
            ]);

            DB::commit();
            return redirect()->back()
                ->with('success', 'تم رفض الطلب بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء رفض الطلب');
        }
    }
    // تعديل دالة index لتجلب البيانات المحدثة

}
