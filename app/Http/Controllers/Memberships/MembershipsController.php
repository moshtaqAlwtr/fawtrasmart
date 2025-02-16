<?php

namespace App\Http\Controllers\Memberships;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Memberships;
use App\Models\Package;
use Illuminate\Http\Request;

class MembershipsController extends Controller
{
    public function index()
    {
        $packages	= Package::all();
        $memberships = Memberships::all();
        return view('Memberships_subscriptions.mang_memberships.index',compact('memberships'));
    }
    public function create()
    {
        $clients = Client::all();
        $packages	= Package::all();
        return view('Memberships_subscriptions.mang_memberships.create',compact('clients','packages'));
    }
    public function store(Request $request)
    {
        // تعريف القواعد والرسائل
        $rules = [
            'client_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    // تحقق إذا كان العميل مسجلاً بالفعل في عضوية أخرى
                    if (Memberships::where('client_id', $value)->exists()) {
                        $fail('هذا العميل مسجل بالفعل في عضوية أخرى.');
                    }
                }
            ],
            'package_id' => 'required',
            'join_date' => 'required|date',
            'invoice_date' => 'required|date',
            'description' => 'nullable|string',
        ];
    
        $messages = [
            'client_id.required' => 'حقل العميل مطلوب.',
            'package_id.required' => 'حقل الباقة مطلوب.',
            'join_date.required' => 'حقل تاريخ الالتحاق مطلوب.',
            'join_date.date' => 'تاريخ الالتحاق يجب أن يكون تاريخًا صالحًا.',
            'invoice_date.required' => 'حقل تاريخ الفاتورة مطلوب.',
            'invoice_date.date' => 'تاريخ الفاتورة يجب أن يكون تاريخًا صالحًا.',
            'description.string' => 'الوصف يجب أن يكون نصًا.',
        ];
    
        // تنفيذ الفاليديشن
        $validatedData = $request->validate($rules, $messages);
    
        // إنشاء العضوية
        Memberships::create($validatedData);
    
        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('Memberships.index')->with('success', 'تم إنشاء العضوية بنجاح.');
    }
    
    public function show()
    {
        return view('Memberships_subscriptions.mang_memberships.show');
    }
    public function edit()
    {
        return view('Memberships_subscriptions.mang_memberships.edit');
    }
}
