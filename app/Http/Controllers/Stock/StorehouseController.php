<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorehouseRequest;
use App\Models\Branch;
use App\Models\Employee;
use App\Models\JobRole;
use App\Models\Log;
use App\Models\Product;
use App\Models\ProductDetails;
use App\Models\StoreHouse;
use App\Models\WarehousePermits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StorehouseController extends Controller
{
    public function index()
    {
        $storehouses = StoreHouse::orderBy('id', 'DESC')->get();
        return view('stock.storehouse.index',compact('storehouses'));
    }

    public function create()
    {
        $branches = Branch::select('id','name')->get();
        $employees = Employee::select()->get();
        $job_roles = JobRole::select('id','role_name')->get();
        return view('stock.storehouse.crate',compact('employees','branches','job_roles'));
    }

    public function store(StorehouseRequest $request)
    {
        try
        {
            $storehouse = new StoreHouse();

            $storehouse->name = $request->name;
            $storehouse->shipping_address = $request->shipping_address;
            $storehouse->status = $request->status;
            $storehouse->view_permissions = $request->view_permissions;
            $storehouse->crate_invoices_permissions = $request->crate_invoices_permissions;
            $storehouse->edit_stock_permissions = $request->edit_stock_permissions;

            if ($request->has('major')) {
                Storehouse::where('major', 1)->update(['major' => 0]);
                $storehouse->major = 1;
            } else {
                $storehouse->major = 0;
            }


            #permissions-----------------------------------

            # view employee
            if(($request->view_permissions == 1)){
                $storehouse->value_of_view_permissions = $request->v_employee_id;
            }
            # view functional_role
            elseif(($request->view_permissions == 2)){
                $storehouse->value_of_view_permissions = $request->v_functional_role_id	;
            }
            # view branch
            else{
                $storehouse->value_of_view_permissions = $request->v_branch_id	;
            }


            # view employee
            if(($request->crate_invoices_permissions == 1)){
                $storehouse->value_of_crate_invoices_permissions = $request->c_employee_id;
            }
            # view functional_role
            elseif(($request->crate_invoices_permissions == 2)){
                $storehouse->value_of_crate_invoices_permissions = $request->c_functional_role_id	;
            }
            # view branch
            else{
                $storehouse->value_of_crate_invoices_permissions = $request->c_branch_id	;
            }


            # view employee
            if(($request->edit_stock_permissions == 1)){
                $storehouse->value_of_edit_stock_permissions = $request->e_employee_id;
            }
            # view functional_role
            elseif(($request->edit_stock_permissions == 2)){
                $storehouse->value_of_edit_stock_permissions = $request->e_functional_role_id	;
            }
            # view branch
            else{
                $storehouse->value_of_edit_stock_permissions = $request->e_branch_id	;
            }

            $storehouse->save();

            // تسجيل اشعار نظام جديد
          Log::create([
            'type' => 'product_log',
            'type_id' =>   $storehouse->id, // ID النشاط المرتبط
            'type_log' => 'log', // نوع النشاط
            'description' => 'تم  اضافة المستودع :  :  **' .  $storehouse->name . '**', // النص المنسق
            'created_by' => auth()->id(), // ID المستخدم الحالي
        ]);
            return redirect()->route('storehouse.index')->with(key: ['success'=>'تم اضافه المستودع بنجاج !!']);

        }
        catch(\Exception $e){
            return redirect()->route('storehouse.index')->with(key: ['error'=>$e]);
        }
    }

    public function edit($id)
    {
        $storehouse = StoreHouse::findOrFail($id);
        $branches = Branch::select('id','name')->get();
        $employees = Employee::select()->get();
        $job_roles = JobRole::select('id','role_name')->get();
        return view('stock.storehouse.edit',compact('storehouse','employees','branches','job_roles'));
    }

    public function show($id)
    {
        $storehouse = StoreHouse::findOrFail($id);
        return view('stock.storehouse.show',compact('storehouse'));
    }

    public function update(StorehouseRequest $request, $id)
    {
        try
        {
            $storehouse = StoreHouse::findOrFail($id);
            $oldName = $storehouse->name;
            $storehouse->name = $request->name;
            $storehouse->shipping_address = $request->shipping_address;
            $storehouse->status = $request->status;
            $storehouse->view_permissions = $request->view_permissions;
            $storehouse->crate_invoices_permissions = $request->crate_invoices_permissions;
            $storehouse->edit_stock_permissions = $request->edit_stock_permissions;

            if ($request->has('major')) {
                Storehouse::where('major', 1)->update(['major' => 0]);
                $storehouse->major = 1;
            } else {
                $storehouse->major = 0;
            }

            #permissions-----------------------------------

            # view employee
            if(($request->view_permissions == 1)){
                $storehouse->value_of_view_permissions = $request->v_employee_id;
            }
            # view functional_role
            elseif(($request->view_permissions == 2)){
                $storehouse->value_of_view_permissions = $request->v_functional_role_id	;
            }
            # view branch
            else{
                $storehouse->value_of_view_permissions = $request->v_branch_id	;
            }


            # view employee
            if(($request->crate_invoices_permissions == 1)){
                $storehouse->value_of_crate_invoices_permissions = $request->c_employee_id;
            }
            # view functional_role
            elseif(($request->crate_invoices_permissions == 2)){
                $storehouse->value_of_crate_invoices_permissions = $request->c_functional_role_id	;
            }
            # view branch
            else{
                $storehouse->value_of_crate_invoices_permissions = $request->c_branch_id	;
            }


            # view employee
            if(($request->edit_stock_permissions == 1)){
                $storehouse->value_of_edit_stock_permissions = $request->e_employee_id;
            }
            # view functional_role
            elseif(($request->edit_stock_permissions == 2)){
                $storehouse->value_of_edit_stock_permissions = $request->e_functional_role_id	;
            }
            # view branch
            else{
                $storehouse->value_of_edit_stock_permissions = $request->e_branch_id	;
            }

            $storehouse->update();

               // تسجيل اشعار نظام جديد
               Log::create([
                'type' => 'product_log',
                'type_id' => $storehouse->id, // ID النشاط المرتبط
                'type_log' => 'log', // نوع النشاط
                'description' => sprintf(
                    'تم تعديل المستودع من **%s** إلى **%s**',
                    $oldName, // الاسم القديم
                    $storehouse->name // الاسم الجديد
                ),
                'created_by' => auth()->id(), // ID المستخدم الحالي
            ]);
            return redirect()->route('storehouse.index')->with(key: ['success'=>'تم تحديث بيانات المستودع بنجاج !!']);

        }
        catch(\Exception $e){
            return redirect()->route('storehouse.index')->with(key: ['error'=>$e]);
        }
    }

    public function delete($id)
    {
        $storehouse = StoreHouse::findOrFail($id);
        Log::create([
            'type' => 'product_log',
            'type_id' =>   $storehouse->id, // ID النشاط المرتبط
            'type_log' => 'log', // نوع النشاط
            'description' => 'تم  حذف المستودع :  :  **' .  $storehouse->name . '**', // النص المنسق
            'created_by' => auth()->id(), // ID المستخدم الحالي
        ]);
        // التحقق مما إذا كان المستودع يحتوي على أصناف
        if ($storehouse->productDetails()->count() > 0) {
            return back()->with('error', 'هذا المستودع لديه معاملات، يمكنك إلغاء تفعيله فقط لا حذفه');
        }

        // التحقق مما إذا كان المستودع مستخدمًا في عمليات تحويل
        if ($storehouse->transfersFrom()->count() > 0 || $storehouse->transfersTo()->count() > 0) {
            return back()->with('error', 'هذا المستودع لديه معاملات، يمكنك إلغاء تفعيله فقط لا حذفه');
        }

        $storehouse->delete();
        return redirect()->route('storehouse.index')->with(key: ['error'=>'تم حذف المستودع بنجاج !!']);
    }

    // public function summary_inventory_operations($id)
    // {
    //     $storehouse = StoreHouse::findOrFail($id);
    //     $warehousePermits = WarehousePermits::where('store_houses_id', $id)->with('warehousePermitsProducts')->get();

    //     $allProducts = collect();

    //     foreach ($warehousePermits as $storePermit) {
    //         foreach ($storePermit['products'] as $product) {
    //             $allProducts->push($product);
    //         }
    //     }

    //     $uniqueProducts = $allProducts->unique('id');

    //     $uniqueProductsArray = $uniqueProducts->values()->all();
    //     return $warehousePermits;

    //     return view('stock.storehouse.summary_inventory_operations', [
    //         'warehousePermits' => $warehousePermits,
    //         'storehouse' => $storehouse,
    //     ]);
    // }


    public function summary_inventory_operations($id)
    {
        $storehouse = StoreHouse::findOrFail($id);
    
        // جلب جميع التصاريح الخاصة بالمستودع
        $warehousePermits = WarehousePermits::where('store_houses_id', $id)
            ->orWhere('from_store_houses_id', $id)
            ->orWhere('to_store_houses_id', $id)
            ->with('warehousePermitsProducts')
            ->get();
    
        $productsData = [];
    
        foreach ($warehousePermits as $permit) {
            foreach ($permit->warehousePermitsProducts as $product) {
                $productId = $product->product_id;
    
                if (!isset($productsData[$productId])) {
                    $productsData[$productId] = [
                        'name' => Product::find($productId)->name,
                        'id' => $productId,
                        'incoming_manual' => 0,
                        'incoming_transfer' => 0,
                        'outgoing_manual' => 0,
                        'outgoing_transfer' => 0,
                        'incoming_total' => 0,
                        'outgoing_total' => 0,
                        'movement_total' => 0,
                        'sold_quantity' => 0, // إضافة حقل لعدد المنتجات المباعة
                    ];
                }
    
                $quantity = $product->quantity;
    
                // حساب القيم بناءً على نوع الإذن
                switch ($permit->permission_type) {
                    case 1: // إضافة (يدوي - وارد)
                        $productsData[$productId]['incoming_manual'] += $quantity;
                        break;
                    case 2: // صرف (يدوي - منصرف)
                        $productsData[$productId]['outgoing_manual'] += $quantity;
                        break;
                    case 3: // تحويل
                        if ($permit->to_store_houses_id == $id) {
                            $productsData[$productId]['incoming_transfer'] += $quantity;
                        }
                        if ($permit->from_store_houses_id == $id) {
                            $productsData[$productId]['outgoing_transfer'] += $quantity;
                        }
                        break;
                }
    
                // حساب الإجماليات
                $productsData[$productId]['incoming_total'] =
                    $productsData[$productId]['incoming_manual'] +
                    $productsData[$productId]['incoming_transfer'];
    
                $productsData[$productId]['outgoing_total'] =
                    $productsData[$productId]['outgoing_manual'] +
                    $productsData[$productId]['outgoing_transfer'];
    
                $productsData[$productId]['movement_total'] =
                    $productsData[$productId]['incoming_total'] - $productsData[$productId]['outgoing_total'];
    
                // جلب عدد المنتجات المباعة من دالة totalSold
                $productsData[$productId]['sold_quantity'] = Product::find($productId)->totalSold();
            }
        }
    
        return view('stock.storehouse.summary_inventory_operations', [
            'products' => $productsData,
            'storehouse' => $storehouse,
        ]);
    }
    
    public function inventory_value($id)
    {
        $products = ProductDetails::where('store_house_id', $id)
                    ->select('product_id', DB::raw('SUM(quantity) as quantity'))
                    ->with('product')
                    ->groupBy('product_id')
                    ->get();

        $storehouse = StoreHouse::findOrFail($id);

        return view('stock.storehouse.inventory_value', compact('products', 'storehouse'));
    }

    public function inventory_sheet($id)
    {
        $products = ProductDetails::where('store_house_id', $id)->get();

        $storehouse = StoreHouse::findOrFail($id);

        return view('stock.storehouse.inventory_sheet', compact('products', 'storehouse'));
    }




}# End of Controller
