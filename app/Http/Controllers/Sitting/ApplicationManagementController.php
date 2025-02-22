<?php


namespace App\Http\Controllers\Sitting;

use App\Http\Controllers\Controller;
use App\Models\ApplicationSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
class ApplicationManagementController extends Controller
{
    /**
     * عرض قائمة المواعيد.
     */
    public function index()
{
    // جلب الإعدادات المحفوظة من قاعدة البيانات
    $settings = ApplicationSetting::pluck('status', 'key')->toArray();

    return view('sitting.Application.index', compact('settings'));
}


   
public function update(Request $request)
{
   
    // dd($request->all());
    // استخراج القيم من الطلب
    $settings = [
        'sales' => $request->input('sales', 'inactive'),
        'pos' => $request->input('pos', 'inactive'),
        'target_sales_commissions' => $request->input('target_sales_commissions', 'inactive'),
        'installments_management' => $request->input('installments_management', 'inactive'),
        'offers' => $request->input('offers', 'inactive'),
        'insurance' => $request->input('insurance', 'inactive'),
        'customer_loyalty_points' => $request->input('customer_loyalty_points', 'inactive'),
        'inventory_management' => $request->input('inventory_management', 'inactive'),
        'manufacturing' => $request->input('manufacturing', 'inactive'),
        'purchase_cycle' => $request->input('purchase_cycle', 'inactive'),
        'finance' =>       $request->input('finance', 'inactive'),
        'general_accounts_journal_entries' => $request->input('general_accounts_journal_entries', 'inactive'),
        'cheque_cycle' => $request->input('cheque_cycle', 'inactive'),
        'work_orders' => $request->input('work_orders', 'inactive'),
        'rental_management' => $request->input('rental_management', 'inactive'),
        'booking_management' => $request->input('booking_management', 'inactive'),
        'time_tracking' => $request->input('time_tracking', 'inactive'),
        'workflow' => $request->input('workflow', 'inactive'),
        'customers' => $request->input('customers', 'inactive'),
        'customer_followup' => $request->input('customer_followup', 'inactive'),
        'points_balances' => $request->input('points_balances', 'inactive'),
        'membership' => $request->input('membership', 'inactive'),
        'customer_attendance' => $request->input('customer_attendance', 'inactive'),
        'employees' => $request->input('employees', 'inactive'),
        'organizational_structure' => $request->input('organizational_structure', 'inactive'),
        'employee_attendance' => $request->input('employee_attendance', 'inactive'),
        'salaries' => $request->input('salaries', 'inactive'),
        'orders' => $request->input('orders', 'inactive'),
        'sms' => $request->input('sms', 'inactive'),
        'ecommerce' => $request->input('ecommerce', 'inactive'),
         'branches' => $request->input('branches', 'inactive'),
        // إضافة باقي الخيارات هنا...
    ];
 

    // تحديث القيم في قاعدة البيانات
    foreach ($settings as $key => $status) {
        ApplicationSetting::updateOrCreate(
            ['key' => $key],  // البحث عن الإعداد حسب المفتاح
            ['status' => $status] // تحديث أو إنشاء القيمة الجديدة
        );
    }

    return redirect()->back()->with('success', 'تم تحديث الإعدادات بنجاح.');
}

    
    
}
    



  

