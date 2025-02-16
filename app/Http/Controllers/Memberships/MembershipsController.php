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
            'end_date' => 'required|date',
            'description' => 'nullable|string',
        ];
    
        $messages = [
            'client_id.required' => 'حقل العميل مطلوب.',
            'package_id.required' => 'حقل الباقة مطلوب.',
            'join_date.required' => 'حقل تاريخ الالتحاق مطلوب.',
            'join_date.date' => 'تاريخ الالتحاق يجب أن يكون تاريخًا صالحًا.',
            'end_date.required' => 'حقل تاريخ الفاتورة مطلوب.',
            'end_date.date' => 'تاريخ الفاتورة يجب أن يكون تاريخًا صالحًا.',
            'description.string' => 'الوصف يجب أن يكون نصًا.',
        ];
    
        // تنفيذ الفاليديشن
        $validatedData = $request->validate($rules, $messages);
    
        // إنشاء العضوية
        Memberships::create($validatedData);
    
        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('Memberships.index')->with('success', 'تم إنشاء العضوية بنجاح.');
    }
    
    public function show($id)
    {
        $membership = Memberships::findOrFail($id);
        $client     = Client::findOrFail($membership->client_id);
        return view('Memberships_subscriptions.mang_memberships.show',compact('membership','client'));
    }
    public function edit($id)
    {
        $membership = Memberships::findOrFail($id);
        $clients = Client::all();
        $packages = Package::all();
        return view('Memberships_subscriptions.mang_memberships.edit',compact('membership','clients','packages'));
    }

    public function renew($id)
    {
        $membership = Memberships::findOrFail($id);
        $clients = Client::all();
        $packages = Package::all();
        return view('Memberships_subscriptions.mang_memberships.renewa',compact('membership','clients','packages'));
    }

    public function renew_update(Request $request, $id)
    {
        $membership = Memberships::findOrFail($id);
        $membership->package_id = $request->package_id ?? $membership->package_id;
        $membership->end_date   = $request->end_date   ?? $membership->end_date;
        $membership->save();

        return redirect()->route('Memberships.index')->with('success', 'تم تجديد العضوية بنجاح.');
    }
   
   public function update(Request $request, $id)
    {
    // تعريف القواعد والرسائل
    $rules = [
        'client_id' => [
            'required',
            function ($attribute, $value, $fail) use ($id) {
                // تحقق إذا كان العميل مسجلاً بالفعل في عضوية أخرى باستثناء العضوية الحالية
                if (Memberships::where('client_id', $value)->where('id', '!=', $id)->exists()) {
                    $fail('هذا العميل مسجل بالفعل في عضوية أخرى.');
                }
            }
        ],
        'package_id' => 'required',
        'join_date' => 'required|date',
        'end_date' => 'required|date',
        'description' => 'nullable|string',
    ];

    $messages = [
        'client_id.required' => 'حقل العميل مطلوب.',
        'package_id.required' => 'حقل الباقة مطلوب.',
        'join_date.required' => 'حقل تاريخ الالتحاق مطلوب.',
        'join_date.date' => 'تاريخ الالتحاق يجب أن يكون تاريخًا صالحًا.',
        'end_date.required' => 'حقل تاريخ الفاتورة مطلوب.',
        'end_date.date' => 'تاريخ الفاتورة يجب أن يكون تاريخًا صالحًا.',
        'description.string' => 'الوصف يجب أن يكون نصًا.',
    ];

    // تنفيذ الفاليديشن
    $validatedData = $request->validate($rules, $messages);

    // تحديث بيانات العضوية
    $membership = Memberships::findOrFail($id);
    $membership->update($validatedData);

    // إعادة التوجيه مع رسالة نجاح
    return redirect()->route('Memberships.index')->with('success', 'تم تعديل العضوية بنجاح.');
}

public function delete($id)
{
   
    $membership = Memberships::findOrFail($id);
    $membership->delete();

    return back()->with('success', 'تم الحذف بنجاح');
}


}
