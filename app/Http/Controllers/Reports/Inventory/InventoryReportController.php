<?php

namespace App\Http\Controllers\Reports\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\StoreHouse;
use Illuminate\Http\Request;

class InventoryReportController extends Controller
{
    // عرض الصفحة الرئيسية لتقارير المخزون
    public function index()
    {
        return view('reports.inventory.index');
    }

    // تقرير المخزون بالمخازن
    public function inventorySheet( Request $request)
    {

 // جلب جميع التصنيفات والعلامات التجارية والمستودعات للفلترة
 $categories = Category::all();
 $brands = Product::distinct('brand')->pluck('brand');
 $warehouses = StoreHouse::all();

 // جلب البيانات مع الفلترة
 $products = Product::query()
     ->with(['category', 'product_details'])
     ->when($request->category, function ($query, $category) {
         return $query->where('category_id', $category);
     })
     ->when($request->brand, function ($query, $brand) {
         return $query->where('brand', $brand);
     })
     ->when($request->warehouse, function ($query, $warehouse) {
         return $query->whereHas('product_details', function ($q) use ($warehouse) {
             $q->where('store_house_id', $warehouse);
         });
     })
     ->get();


        return view('reports.inventory.stock_report.inventory_sheet', compact('products', 'categories', 'brands', 'warehouses'));
    }



}
