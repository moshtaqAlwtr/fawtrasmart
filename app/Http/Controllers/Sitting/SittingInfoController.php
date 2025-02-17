<?php

namespace App\Http\Controllers\Sitting;

use App\Http\Controllers\Controller;
use App\Models\AccountSetting;
use App\Models\BusinessData;
use Illuminate\Http\Request;

class SittingInfoController extends Controller
{
    public function index()
    {
        return view('sitting.accountInfo.index');
    }
    public function create()
    {
        return view('sitting.accountInfo.create');
    }

    public function store(Request $request)
    {
     
         
        // التحقق من المدخلات
        // $request->validate([
        //     'business_email' => 'required|email',
        //     'first_name' => 'required|string|max:255',
        //     'last_name' => 'required|string|max:255',
        //     'phone' => 'required|string|max:15',
        //     'mobile' => 'required|string|max:15',
        //     'street_address1' => 'required|string|max:255',
        //     'street_address2' => 'nullable|string|max:255',
        //     'city' => 'required|string|max:100',
        //     'postal_code' => 'required|string|max:10',
        //     'country' => 'required|string|max:100',

        //     'currency' => 'required|string|max:3',  // العملة
        //     'timezone' => 'required|string',  // المنطقة الزمنية
        //     'account_type' => 'required|string|in:product,service,product_service',  // نوع الحساب
        // ]);

        // تحقق من وجود بيانات في جدول بيانات العمل وتحديثها أو إدخالها
        $workData = BusinessData::first();  // نحاول جلب أول سجل من جدول بيانات العمل
        if ($workData) {
            // إذا كانت البيانات موجودة نقوم بتحديثها
            $workData->update($request->only([
                'business_name', 'first_name', 'last_name', 'phone','mobile',
                'street_address1', 'street_address2', 'city', 'postal_code', 'country'
            ]));
        } else {
            // إذا لم تكن البيانات موجودة نقوم بإدخالها
            BusinessData::create($request->only([
                'business_name', 'first_name', 'last_name', 'phone','mobile',
                'street_address1', 'street_address2', 'city', 'postal_code', 'country'
            ]));
        }
       
        // تحقق من وجود بيانات في جدول إعدادات الحساب وتحديثها أو إدخالها
        $accountSettings = AccountSetting::first();  // نحاول جلب أول سجل من جدول إعدادات الحساب
        if ($accountSettings) {
            // إذا كانت البيانات موجودة نقوم بتحديثها
            $accountSettings->update($request->only([
                'currency', 'timezone', 'business_type'
            ]));
        } else {
            // إذا لم تكن البيانات موجودة نقوم بإدخالها
            AccountSetting::create($request->only([
                'currency', 'timezone', 'business_type'
            ]));
        }

        // إرجاع إلى صفحة النجاح مع رسالة
        return redirect()->route('sitting.create')->with('success', 'تم حفظ البيانات بنجاح!');
    }
}
