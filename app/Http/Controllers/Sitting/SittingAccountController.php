<?php

namespace App\Http\Controllers\Sitting;

use App\Http\Controllers\Controller;
use App\Models\AccountSetting;
use App\Models\Client;
use App\Models\User;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class SittingAccountController extends Controller
{
    public function index()
    {
        
        $client          = Client::where('user_id',auth()->user()->id)->first();
        $user = User::find(auth()->id());
        $account_setting = AccountSetting::where('user_id',auth()->user()->id)->first();
        return view('sitting.sittingAccount.index',compact('client','account_setting','user'));
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'attachments' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // دعم صور JPG و PNG بحد أقصى 2MB
        ]);
    
        // البحث عن الإعدادات الخاصة بالمستخدم الحالي
        $AccountSetting = AccountSetting::where('user_id', auth()->id())->first();
    
        if (!$AccountSetting) {
            // إذا لم يكن هناك سجل للمستخدم، يتم إنشاؤه
            $AccountSetting = new AccountSetting();
            $AccountSetting->user_id = auth()->user()->id();
        }
    
        // تحديث الحقول
        $AccountSetting->currency = $request->currency;
        $AccountSetting->timezone = $request->timezone;
        $AccountSetting->negative_currency_formats = $request->negative_currency_formats;
        $AccountSetting->time_formula = $request->time_formula;
        $AccountSetting->business_type = $request->business_type;
        $AccountSetting->printing_method = $request->printing_method;
        $AccountSetting->language = $request->language;
    
        if ($request->hasFile('attachments')) {
         
           
            // رفع الصورة الجديدة إلى مجلد storage/app/public/attachments
            $logoPath = $request->file('attachments')->store('attachments', 'public');
    
            // تحديث مسار الصورة في قاعدة البيانات
            $AccountSetting->attachments = $logoPath;
        }
    
        $AccountSetting->save();
       
   
        

        $Client = Client::where('user_id', auth()->id())->first();
    
        if (!$Client) {
            // إذا لم يكن هناك سجل للمستخدم، يتم إنشاؤه
            $Client = new Client();
            $Client->user_id = $Client->user_id = auth()->id();

        }
        $Client->employee_id = $request->employee_id;
        $Client->user_id  = auth()->user()->id;
        $Client->category = $request->category;
        $Client->attachments = $request->attachments;
        $Client->notes = $request->notes;
        $Client->client_type = $request->client_type;
        $Client->email = $request->email;
        $Client->currency = $request->currency;
        $Client->code = $request->code;
        $Client->opening_balance_date = $request->opening_balance_date;
        $Client->commercial_registration = $request->commercial_registration;
        $Client->country = $request->country;
        $Client->postal_code = $request->postal_code;
        $Client->street2 = $request->street2;
        $Client->street1 = $request->street1;
        $Client->region = $request->region;
        $Client->city = $request->city;
        $Client->mobile = $request->mobile;
        $Client->phone = $request->phone;
        $Client->last_name = $request->last_name;
        $Client->trade_name = $request->trade_name;
        $Client->tax_number = $request->tax_number;
        $Client->commercial_registration = $request->commercial_registration;
        
        
    
        
        $Client->save();
        
        return redirect()->route('SittingAccount.index')->with('success', 'تم حفظ البيانات بنجاح!');


    }

    //تغيير البريد الالكتروني
    public function Change_email(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore(auth()->id()), // ✅ منع تكرار البريد
            ],
        ], [
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'يجب إدخال بريد إلكتروني صحيح.',
            'email.unique' => 'هذا البريد الإلكتروني مستخدم بالفعل.',
        ]);
    
        $user = User::find(auth()->id());
        $user->email = $request->email;
        $user->save();
    
        return redirect()->route('SittingAccount.index')->with('success', 'تم تغيير البريد الإلكتروني بنجاح!');
        


    }
    // تغيير كلمة المرور
    public function change_password(Request $request)
    {
      
        // التحقق من صحة المدخلات
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed', // تأكد من أن كلمة المرور تتكون من 8 أحرف على الأقل
        ], [
            'password.confirmed' => 'كلمة المرور الجديدة غير متطابقة.',
        ]);
    
        // التحقق من تطابق كلمة المرور القديمة
        $user = User::find(auth()->id());
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'كلمة المرور القديمة غير صحيحة.']);
        }
    
        // تحديث كلمة المرور الجديدة
        $user->password = Hash::make($request->password); // تشفير كلمة المرور
        $user->save();
    
        return redirect()->route('SittingAccount.index')->with('success', 'تم تغيير كلمة السر بنجاح!');
    

    }



    

}

