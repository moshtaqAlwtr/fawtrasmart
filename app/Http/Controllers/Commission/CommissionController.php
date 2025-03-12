<?php

namespace App\Http\Controllers\Commission;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\Log as ModelsLog;
use App\Models\Commission_Products;
use App\Models\CommissionUsers;
use App\Models\Employee;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    public function index()
    {
        $commissions = Commission::all();
        return view('target_sales.commission_rules.index','commissions');
       
    }

    public function create()
    {
         $employees  = User::select('id', 'name')->get();
         $products   = Product::select('id','name')->get();
         return view('commission.create', compact('employees','products'));
    }

   

    public function searchProducts(Request $request)
{
    $search = $request->search;

    $products = Product::where('name', 'LIKE', "%{$search}%")
                        ->select('id', 'name')
                        ->take(10) // حد النتائج
                        ->get();

    return response()->json($products);
}
    public function store(Request $request)
    {

       
             $Commission = new Commission();
             $Commission->name = $request->name;
             $Commission->period = $request->period;
             $Commission->status = $request->status;
             $Commission->commission_calculation = $request->commission_calculation;
             $Commission->currency = $request->currency;
             $Commission->notes = $request->notes;
             $Commission->target_type = $request->target_type;
             $Commission->value = $request->value;
             $Commission->save();

             foreach ($request->employee_id  as $employee_id) {
                CommissionUsers::create([
                    'commission_id' => $Commission->id,
                    'employee_id' => $employee_id,
                ]);
            }

            // dd($request->items);
            foreach ($request->items as $item) {
                // تأكد من أن المنتج ونسبة العمولة غير فارغين
                if (!empty($item['product_id']) && !empty($item['commission_percentage'])) {
                    Commission_Products::create([
                        'commission_id' => $Commission->id,
                        'product_id' => $item['product_id'], // استخدم المنتج من البيانات المرسلة
                        'commission_percentage' => $item['commission_percentage'], // استخدم نسبة العمولة من البيانات المرسلة
                    ]);
                }
            }
                 ModelsLog::create([
    'type' => 'Commission',
    'type_id' => $Commission->id, // ID النشاط المرتبط
    'type_log' => 'log', // نوع النشاط
    'description' => 'تم اضافة قاعدة عمولة  **' . $request->name . '**',
    'created_by' => auth()->id(), // ID المستخدم الحالي
]);

            
            return redirect()->route('CommissionRules.show', $Commission->id)->with('success', 'تمت الإضافة بنجاح');

            // return Commission_Products::all();
             
    }

    public function edit($id)
    {
        // $employees = User::select('id', 'name')->get();
        $Commission_Products = Commission_Products::where('commission_id', $id)->get();
        $products = Product::all();
        $CommissionUsers = CommissionUsers::where('commission_id', $id)->pluck('employee_id')->toArray();
        $employees = User::all(); // أو اجلب الموظفين حسب الحاجة
        $Commission = Commission::find($id);

        return view('commission.edit', compact('employees','products','Commission_Products','CommissionUsers','Commission'));
    }

    public function update(Request $request, $id)
    {
        // تحديث بيانات الـ Commission بناءً على الـ ID
        $Commission = Commission::findOrFail($id);
        $Commission->name = $request->name;
        $Commission->period = $request->period;
        $Commission->status = $request->status;
        $Commission->commission_calculation = $request->commission_calculation;
        $Commission->currency = $request->currency;
        $Commission->notes = $request->notes;
        $Commission->target_type = $request->target_type;
        $Commission->value = $request->value;
        $Commission->save();
    
        // تحديث الموظفين المرتبطين بـ Commission
        // أولاً حذف الموظفين الحاليين المرتبطين بـ Commission
        CommissionUsers::where('commission_id', $id)->delete();
    
        // ثم إضافة الموظفين الجدد
        foreach ($request->employee_id as $employee_id) {
            CommissionUsers::create([
                'commission_id' => $Commission->id,
                'employee_id' => $employee_id,
            ]);
        }
    
        // تحديث المنتجات المرتبطة بالـ Commission
        // أولاً حذف المنتجات الحالية المرتبطة بـ Commission
        Commission_Products::where('commission_id', $id)->delete();
    
        // ثم إضافة المنتجات الجديدة
        foreach ($request->items as $item) {
            // تأكد من أن المنتج ونسبة العمولة غير فارغين
            if (!empty($item['product_id']) && !empty($item['commission_percentage'])) {
                Commission_Products::create([
                    'commission_id' => $Commission->id,
                    'product_id' => $item['product_id'],
                    'commission_percentage' => $item['commission_percentage'],
                ]);
            }
        }
        
        return redirect()->route('CommissionRules.index')->with('success', 'تم التعديل بنجاح');
    }
    
    public function show($id)
    {

    }
   
    public function delete($id)
    {

    }
}
