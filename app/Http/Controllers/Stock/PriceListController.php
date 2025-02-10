<?php

namespace App\Http\Controllers\Stock;
use App\Http\Controllers\Controller;
use App\Models\PriceList;
use App\Models\PriceListItems;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PriceListController extends Controller
{
    public function index()
    {
        $price_lists = PriceList::orderBy('id', 'DESC')->paginate(10);
        $products = Product::select('id','name')->get();
        return view('stock.price_list.index',data: compact('price_lists','products'));
    }

    public function create()
    {
        return view('stock.price_list.create');
    }
    public function edit($id)
    {
        $price_list = PriceList::findOrFail($id);
        return view('stock.price_list.edit',compact('price_list'));
    }

    public function show($id)
    {
        $products = Product::select('id','name','sale_price')->get();
        $price_list = PriceList::findOrFail($id);
        $list_products = $price_list->price_list_products ;
        return view('stock.price_list.show',compact('list_products','price_list','products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        PriceList::create([
            'name' => $request->name,
            'status' => $request->status
        ]);
        return redirect()->route('price_list.index')->with( ['success'=>'تم اضافه قائمه الاسعار بنجاج !!']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        PriceList::findOrFail($id)->update([
            'name' => $request->name,
            'status' => $request->status
        ]);
        return redirect()->route('price_list.index')->with( ['success'=>'تم اضافه قائمه الاسعار بنجاج !!']);
    }

    public function delete($id)
    {
        PriceList::findOrFail($id)->delete();
        return redirect()->route('price_list.index')->with( ['error'=>'تم حذف قائمه الاسعار بنجاج !!']);
    }

    public function add_product(Request $request ,$id)
    {
        try
        {
            DB::beginTransaction();
            $request->validate([
                'product_id'=>'required'
            ]);

            PriceListItems::create([
                'product_id' => $request->product_id,
                'price_list_id' => $id
            ]);

            Product::findOrFail($request->product_id)->update([
                'sale_price' => $request->sale_price,
            ]);

            DB::commit();
            return redirect()->back()->with( ['success'=>'تم اضافه المنتج الي قائمه الاسعار بنجاج !!']);
        }
        catch(\Exception $exception)
        {
            DB::rollback();
            return redirect()->back()->with(['error'=> $exception])->withInput();
        }

    }

    // public function delete_product($id)
    // {
    //     PriceListItems::findOrFail($id)->delete();
    //     return redirect()->back()->with( ['error'=>'تم حذف المنتج الي قائمه الاسعار بنجاج !!']);
    // }


}
