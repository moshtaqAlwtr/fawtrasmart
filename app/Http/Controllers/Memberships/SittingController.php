<?php

namespace App\Http\Controllers\Memberships;

use App\Http\Controllers\Controller;
use App\Models\MembershipsSetthing;
use Illuminate\Http\Request;

class SittingController extends Controller
{
  public function index() {
<<<<<<< HEAD
    
    return view('Memberships_subscriptions.sitting_memberships.index');
  }
  public function sitting()
  {
    // $setting = MembershipsSetthing::all();
    return view('Memberships_subscriptions.sitting_memberships.sitting');
=======
    return view('Memberships.sitting_memberships.index');
  }
  public function sitting()
  {
    return view('Memberships.sitting_memberships.sitting');
>>>>>>> aa09ee3ca79613782193d543daa9551e2b01e331
  }

  public function store(Request $request)
  {
      // البحث عن السجل الأول، وإذا لم يكن موجودًا يتم إنشاؤه
      $setting = MembershipsSetthing::firstOrNew();
  
      // تحديث القيم
      $setting->days_allowed   = $request->days_allowed;
      $setting->active_clients = $request->active_clients;
      $setting->save(); // الحفظ سواء كان تحديثًا أو إدخالاً جديدًا
  
      return back()->with('success', 'تم التعديل بنجاح');
  }
  
}
