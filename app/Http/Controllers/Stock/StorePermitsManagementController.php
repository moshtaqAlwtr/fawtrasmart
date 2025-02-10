<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Http\Requests\WarehousePermitsRequest;
use App\Models\Product;
use App\Models\ProductDetails;
use App\Models\StoreHouse;
use App\Models\WarehousePermits;
use App\Models\WarehousePermitsProducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StorePermitsManagementController extends Controller
{
    public function index()
    {
        $wareHousePermits = WarehousePermits::select()->orderBy('id', direction: 'DESC')->get();
        return view('stock.store_permits_management.index',compact('wareHousePermits'));
    }

    public function create()
    {
        $storeHouses = StoreHouse::where('status',0)->select('id','name')->get();
        $products = Product::select()->get();

        $record_count = DB::table('warehouse_permits')->count();
        $serial_number = str_pad($record_count + 1, 6, '0', STR_PAD_LEFT);

        return view('stock.store_permits_management.create',compact('storeHouses','products','serial_number'));
    }
    public function manual_disbursement()
    {
        $storeHouses = StoreHouse::where('status',0)->select('id','name')->get();
        $products = Product::select()->get();

        $record_count = DB::table('warehouse_permits')->count();

        $serial_number = str_pad($record_count + 1, 6, '0', STR_PAD_LEFT);

        return view('stock.store_permits_management.manual_disbursement',compact('storeHouses','products','serial_number'));
    }
    public function manual_conversion()
    {
        $storeHouses = StoreHouse::where('status',0)->select('id','name')->get();
        $products = Product::select()->get();

        $record_count = DB::table('warehouse_permits')->count();

        $serial_number = str_pad($record_count + 1, 6, '0', STR_PAD_LEFT);

        return view('stock.store_permits_management.manual_conversion',compact('storeHouses','products','serial_number'));
    }

    public function store(WarehousePermitsRequest $request)
    {
        DB::beginTransaction();
        try {

            $wareHousePermits = new WarehousePermits();

            if($request->hasFile('attachments')){
                $wareHousePermits->attachments = $this->UploadImage('assets/uploads/warehouse',$request->attachments);
            }

            if ($request->permission_type == 3) {
                $wareHousePermits->store_houses_id = $request->from_store_houses_id;
            } else {
                $wareHousePermits->store_houses_id = $request->store_houses_id;
            }

            $wareHousePermits->permission_type = $request->permission_type;
            $wareHousePermits->permission_date = $request->permission_date;
            $wareHousePermits->sub_account = $request->sub_account;
            $wareHousePermits->number = $request->number;
            $wareHousePermits->details = $request->details;
            $wareHousePermits->grand_total = $request->grand_total;
            $wareHousePermits->from_store_houses_id = $request->from_store_houses_id;
            $wareHousePermits->to_store_houses_id = $request->to_store_houses_id;
            $wareHousePermits->created_by = auth()->user()->id;

            $wareHousePermits->save();

            $products = new WarehousePermitsProducts();

            foreach ($request['quantity'] as $index => $quantity) {
                $products->create([
                    'quantity' => $quantity,
                    'total' => $request['total'][$index],
                    'unit_price' => $request['unit_price'][$index],
                    'product_id' => $request['product_id'][$index],
                    'stock_before' => $request['stock_before'][$index],
                    'stock_after' => $request['stock_after'][$index],
                    'warehouse_permits_id' => $wareHousePermits->id,
                ]);

                // التعامل مع المخزون بناءً على نوع الإذن
                if ($request->permission_type == 1) {
                    // 🟢 إذن إضافة للمخزن
                    ProductDetails::updateOrCreate(
                        ['store_house_id' => $request->store_houses_id, 'product_id' => $request['product_id'][$index] ],
                        ['quantity' => DB::raw("quantity + $quantity")]
                    );

                } elseif ($request->permission_type == 2) {
                    // 🔴 إذن صرف من المخزن
                    $stock = ProductDetails::where('store_house_id', $request->store_houses_id)
                        ->where('product_id', $request['product_id'][$index])
                        ->first();

                    if (!$stock || $stock->quantity < $quantity) {
                        DB::rollBack();
                        return back()->with('error', 'الكمية غير متوفرة في المخزن')->withInput();
                    }

                    $stock->decrement('quantity', $quantity);

                }

                elseif ($request->permission_type == 3) {
                    // 🔄 إذن تحويل من مخزن إلى مخزن آخر
                    $sourceStock = ProductDetails::where('store_house_id', $request->from_store_houses_id)
                        ->where('product_id', $request['product_id'][$index])
                        ->first();

                    // التحقق من وجود الكمية المطلوبة في المخزن المصدر
                    if (!$sourceStock || $sourceStock->quantity < $quantity) {
                        DB::rollBack();
                        return back()->with('error', 'الكمية غير متوفرة في المخزن المصدر')->withInput();
                    }

                    // خصم الكمية من المخزن المصدر
                    $sourceStock->decrement('quantity', $quantity);

                    // إضافة الكمية إلى المخزن الهدف
                    ProductDetails::updateOrCreate(
                        ['store_house_id' => $request->to_store_houses_id, 'product_id' => $request['product_id'][$index]],
                        ['quantity' => DB::raw("quantity + $quantity")]
                    );
                }

            } #End foreach

            DB::commit();
            return redirect()->route('store_permits_management.index')->with(['success'=>'تم انشاء اذن المخزن بنجاح']);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('store_permits_management.index')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }


    public function edit($id)
    {
        $permit = WarehousePermits::findOrFail($id);
        $products = Product::select()->get();
        $storeHouses = StoreHouse::where('status',0)->select('id','name')->get();

        if($permit->permission_type == 1){
            return view('stock.store_permits_management.edit',compact('permit','storeHouses','products'));
        }

        if($permit->permission_type == 2){
            return view('stock.store_permits_management.manual_disbursement_edit',compact('permit','storeHouses','products'));
        }

        if($permit->permission_type == 3){
            return view('stock.store_permits_management.manual_conversion_edit',compact('permit','storeHouses','products'));
        }
    }


    public function update(WarehousePermitsRequest $request, $id)
    {
        $wareHousePermits = WarehousePermits::findOrFail($id);

        if ($request->hasFile('attachments')) {
            $wareHousePermits->attachments = $this->UploadImage('assets/uploads/warehouse', $request->attachments);
        }

        if ($request->permission_type == 3) {
            $wareHousePermits->store_houses_id = $request->from_store_houses_id;
        } else {
            $wareHousePermits->store_houses_id = $request->store_houses_id;
        }

        $wareHousePermits->permission_type = $request->permission_type;
        $wareHousePermits->permission_date = $request->permission_date;
        $wareHousePermits->sub_account = $request->sub_account;
        $wareHousePermits->number = $request->number;
        $wareHousePermits->details = $request->details;
        $wareHousePermits->grand_total = $request->grand_total;
        $wareHousePermits->from_store_houses_id = $request->from_store_houses_id;
        $wareHousePermits->to_store_houses_id = $request->to_store_houses_id;
        $wareHousePermits->created_by = auth()->user()->id;

        $wareHousePermits->save();

        // حذف المنتجات القديمة المرتبطة بالإذن
        WarehousePermitsProducts::where('warehouse_permits_id', $id)->delete();

        foreach ($request['quantity'] as $index => $quantity) {
            WarehousePermitsProducts::create([
                'quantity' => $quantity,
                'total' => $request['total'][$index],
                'unit_price' => $request['unit_price'][$index],
                'product_id' => $request['product_id'][$index],
                'warehouse_permits_id' => $wareHousePermits->id,
            ]);
        }

        return redirect()->route('store_permits_management.index')->with(['success' => 'تم تحديث إذن المخزن بنجاح']);
    }

    public function delete($id)
    {
        $wareHousePermits = WarehousePermits::findOrFail($id);
        WarehousePermitsProducts::where('warehouse_permits_id', $id)->delete();
        $wareHousePermits->delete();
        return redirect()->route('store_permits_management.index')->with(['error' => 'تم حذف أذن المخزن بنجاح']);
    }

    // public function getProductsByStore($storeId)
    // {
    //     $products = DB::table('product_details')
    //         ->join('products', 'product_details.product_id', '=', 'products.id')
    //         ->where('product_details.store_house_id', $storeId)
    //         ->select('products.id', 'products.name', 'products.sale_price', 'product_details.quantity')
    //         ->get();

    //     return response()->json($products);
    // }

    public function getProductStock($storeId, $productId)
    {
        $stock = DB::table('product_details')
            ->where('store_house_id', $storeId)
            ->where('product_id', $productId)
            ->value('quantity'); // جلب رصيد المخزون

        return response()->json(['stock' => $stock]);
    }





    # Helper Function
    function uploadImage($folder,$image)
    {
        $fileExtension = $image->getClientOriginalExtension();
        $fileName = time().rand(1,99).'.'.$fileExtension;
        $image->move($folder,$fileName);

        return $fileName;
    }

}
