<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Offer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OffersController extends Controller
{
    public function index()
    {
        $offers = Offer::all();
        return view('sales.sitting.offers.index', compact('offers'));
    }

    public function create()
    {
        $product = Product::all();
        $category = Category::all();
        $clients = Client::all();
        return view('sales.sitting.offers.create', compact('clients', 'product', 'category'));
    }
    public function store(Request $request)
    {
        // التحقق من صحة البيانات
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'valid_from' => 'nullable|date',
            'valid_to' => 'nullable|date|after:valid_from',
            'type' => 'required|integer|in:1,2', // يجب أن تكون القيمة 1 أو 2
            'quantity' => 'nullable|numeric|min:0',
            'discount_type' => 'nullable|integer|in:1,2', // يجب أن تكون القيمة 1 أو 2
            'discount_value' => 'nullable|numeric|min:0',
            'category' => 'nullable|string',
            'client_id' => 'nullable|exists:clients,id',
            'unit_type' => 'nullable|integer|in:1,2,3', // يجب أن تكون القيمة 1 أو 2 أو 3
            'product_id' => 'required_if:unit_type,3|nullable|exists:products,id',
            'category_id' => 'required_if:unit_type,2|nullable|exists:categories,id',
            'is_active' => 'boolean',
        ]);

        try {
            // إضافة القيمة الافتراضية لـ is_active إذا لم يتم إرسالها
            $validated['is_active'] = $request->has('is_active') ? true : false;

            // إنشاء العرض باستخدام البيانات المصدقة
            $offer = Offer::create([
                'name' => $validated['name'],
                'valid_from' => $validated['valid_from'],
                'valid_to' => $validated['valid_to'],
                'type' => $validated['type'],
                'quantity' => $validated['quantity'],
                'discount_type' => $validated['discount_type'],
                'discount_value' => $validated['discount_value'],
                'category' => $validated['category'] ?? null,
                'client_id' => $validated['client_id'] ?? null,
                'unit_type' => $validated['unit_type'],
                'product_id' => $validated['product_id'] ?? null,
                'category_id' => $validated['category_id'] ?? null,
                'is_active' => $validated['is_active'],
            ]);

            return redirect()->route('Offers.index')->with('success', 'تم إضافة العرض بنجاح');
        } catch (\Exception $e) {
            // تسجيل الخطأ في الـ log
            Log::error('Error in store method: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'حدث خطأ أثناء إضافة العرض: ' . $e->getMessage());
        }
    }
    public function edit($id)
    {
        $offers = Offer::findOrFail($id);
        $products = Product::all();
        $categories = Category::all();
        $clients = Client::all();

        return view('sales.sitting.offers.edit', compact('offers', 'products', 'categories', 'clients'));
    }

    public function update(Request $request, $id)
    {
        $offer = Offer::findOrFail($id);

        // التحقق من صحة البيانات
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'valid_from' => 'nullable|date',
            'valid_to' => 'nullable|date|after:valid_from',
            'type' => 'required|integer|in:1,2', // يجب أن تكون القيمة 1 أو 2
            'quantity' => 'nullable|numeric|min:0',
            'discount_type' => 'nullable|integer|in:1,2', // يجب أن تكون القيمة 1 أو 2
            'discount_value' => 'nullable|numeric|min:0',
            'category' => 'nullable|string',
            'client_id' => 'nullable|exists:clients,id',
            'unit_type' => 'nullable|integer|in:1,2,3', // يجب أن تكون القيمة 1 أو 2 أو 3
            'product_id' => 'required_if:unit_type,3|nullable|exists:products,id',
            'category_id' => 'required_if:unit_type,2|nullable|exists:categories,id',
            'is_active' => 'boolean',
        ]);

        try {
            // تحديث حالة is_active
            $validated['is_active'] = $request->has('is_active') ? true : false;

            // تحديث العرض باستخدام البيانات المصدقة
            $offer->update([
                'name' => $validated['name'],
                'valid_from' => $validated['valid_from'],
                'valid_to' => $validated['valid_to'],
                'type' => $validated['type'],
                'quantity' => $validated['quantity'],
                'discount_type' => $validated['discount_type'],
                'discount_value' => $validated['discount_value'],
                'category' => $validated['category'] ?? null,
                'client_id' => $validated['client_id'] ?? null,
                'unit_type' => $validated['unit_type'],
                'product_id' => $validated['product_id'] ?? null,
                'category_id' => $validated['category_id'] ?? null,
                'is_active' => $validated['is_active'],
            ]);

            return redirect()->route('Offers.index')->with('success', 'تم تحديث العرض بنجاح');
        } catch (\Exception $e) {
            // تسجيل الخطأ في الـ log
            Log::error('Error in update method: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'حدث خطأ أثناء تحديث العرض: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $offer = Offer::findOrFail($id);
            $offer->delete();

            return redirect()->route('offers.index')->with('success', 'تم حذف العرض بنجاح');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'حدث خطأ أثناء حذف العرض: ' . $e->getMessage());
        }
    }
    public function show($id)
    {
        $offer = Offer::with(['client', 'product', 'category'])->findOrFail($id);
        return view('sales.sitting.offers.show', compact('offer'));
    }
    public function updateStatus($id)
    {
        $offer = Offer::find($id);

        if (!$offer) {
            return redirect()->route('offer.show',$id)->with(['error' => ' العرض  غير موجود!']);
        }

        $offer->update(['status' => !$offer->status]);

        return redirect()->route('offer.show',$id)->with(['success' => 'تم تحديث حالة العرض بنجاح!']);
    }
}
