<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ClientGiftOffer;
use App\Models\GiftOffer;
use App\Models\Product;
use Illuminate\Http\Request;

class GiftOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offers = GiftOffer::all();
        return view('sales.gift_offers.index', compact('offers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
          $products = Product::all();
          $clients = Client::all();

        return view('sales.gift_offers.create',compact('products','clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $request->validate([
        'name' => 'nullable|string|max:255',
        'target_product_id' => 'nullable|exists:products,id',
        'min_quantity' => 'required|integer|min:1',
        'gift_product_id' => 'nullable|exists:products,id',
        'gift_quantity' => 'required|integer|min:1',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'is_for_all_clients' => 'required|boolean',
        'clients' => 'array', // في حالة عدم تطبيقه على كل العملاء
        'clients.*' => 'exists:clients,id',
    ]);

    // ✅ إنشاء عرض الهدية
    $giftOffer = GiftOffer::create([
        'name' => $request->name,
        'target_product_id' => $request->target_product_id,
        'min_quantity' => $request->min_quantity,
        'gift_product_id' => $request->gift_product_id,
        'gift_quantity' => $request->gift_quantity,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'is_for_all_clients' => $request->is_for_all_clients,
    ]);

    // ✅ ربط العملاء المخصصين إذا لم يكن العرض لجميع العملاء
    if (!$request->is_for_all_clients && $request->has('clients')) {
        foreach ($request->clients as $clientId) {
            ClientGiftOffer::create([
                'gift_offer_id' => $giftOffer->id,
                'client_id' => $clientId,
            ]);
        }
    }

    return redirect()->route('gift-offers.index')->with('success', 'تم إنشاء عرض الهدية بنجاح');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
      public function edit(GiftOffer $giftOffer)
    {
       
          $products = Product::all();
          $clients = Client::all();

        return view('sales.gift_offers.create',compact('products','clients','giftOffer'));
    }
    
    


    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'nullable|string|max:255',
        'target_product_id' => 'nullable|exists:products,id',
        'min_quantity' => 'required|integer|min:1',
        'gift_product_id' => 'nullable|exists:products,id',
        'gift_quantity' => 'required|integer|min:1',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'is_for_all_clients' => 'required|boolean',
        'clients' => 'array',
        'clients.*' => 'exists:clients,id',
    ]);

    $giftOffer = GiftOffer::findOrFail($id);

    // ✅ تحديث بيانات العرض
    $giftOffer->update([
        'name' => $request->name,
        'target_product_id' => $request->target_product_id,
        'min_quantity' => $request->min_quantity,
        'gift_product_id' => $request->gift_product_id,
        'gift_quantity' => $request->gift_quantity,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'is_for_all_clients' => $request->is_for_all_clients,
    ]);

    // ✅ تحديث العملاء المرتبطين بالعرض
    if (!$request->is_for_all_clients && $request->has('clients')) {
        // حذف العملاء الحاليين المرتبطين بالعرض
        $giftOffer->clients()->sync($request->clients);
    } else {
        // إذا كان العرض لكل العملاء، نحذف كل الربط السابق
        $giftOffer->clients()->detach();
    }

    return redirect()->route('gift-offers.index')->with('success', 'تم تحديث عرض الهدية بنجاح');
}

    /**
     * Remove the specified resource from storage.
     */
      public function destroy(GiftOffer $giftOffer)
    {
        $giftOffer->delete();
        return redirect()->route('gift-offers.index')->with('success', 'تم حذف العرض');
    }
}
