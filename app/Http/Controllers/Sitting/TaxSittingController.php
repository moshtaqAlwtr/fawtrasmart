<?php

namespace App\Http\Controllers\Sitting;

use App\Http\Controllers\Controller;
use App\Models\TaxSitting;
use Illuminate\Http\Request;

class TaxSittingController extends Controller
{
    public function index()
    {
        $tax = TaxSitting::first();
        return view('sitting.tax_sitting.index',compact('tax'));
    }

    public function update(Request $request)
    {
        // التحقق من البيانات المدخلة
        $request->validate([
            'name' => 'required|string|max:255',
            'tax' => 'required|numeric|min:0',
            'type' => 'required|in:included,excluded',
        ]);
    
        // البحث عن أي سجل موجود
        $tax = TaxSitting::first(); // يجلب أول سجل في الجدول
    
        if ($tax) {
            // إذا كان هناك سجل، يتم تحديثه
            $tax->update([
                'name' => $request->name,
                'tax' => $request->tax,
                'type' => $request->type,
            ]);
    
            return redirect()->back()->with('success', 'تم تحديث الضريبة بنجاح.');
        } else {
            // إذا لم يكن هناك سجل، يتم إضافته
            TaxSitting::create([
                'name' => $request->name,
                'tax' => $request->tax,
                'type' => $request->type,
            ]);
    
            return redirect()->back()->with('success', 'تمت إضافة الضريبة بنجاح.');
        }
    }
    
}
