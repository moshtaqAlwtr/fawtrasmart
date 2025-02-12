<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Product;
use Illuminate\Http\Request;

class SalesStartController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $clients = Client::all();
        return view('pos.sales_start.index',compact('products','clients'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $results = Product::where('name', 'like', "%$query%")->get();

        return response()->json($results);
    }

    // public function search(Request $request)
    // {
    //     $query = $request->input('query', '');

    //     // إذا لم يتم إدخال نص البحث، أرجع نتائج فارغة
    //     if (!$query) {
    //         return response()->json([
    //             'products' => [],
    //             'clients' => []
    //         ]);
    //     }

    //     $products = Product::where('name', 'like', '%' . $query . '%')
    //         ->get();

    //     $clients = Client::where('trade_name', 'like', '%' . $query . '%')
    //         ->orWhere('phone', 'like', '%' . $query . '%')
    //         ->get();

    //     return response()->json([
    //         'products' => $products,
    //         'clients' => $clients
    //     ]);
    // }


}
