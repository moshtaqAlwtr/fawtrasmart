<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\AccountSetting;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\Client; // تأكد من استيراد نموذج Client إذا كنت ستستخدمه
use App\Models\ClientPermission;
use App\Models\ClientType;
use App\Models\Employee;
use App\Models\GeneralClientSetting;
use App\Models\Invoice;
use App\Models\Quote;
use App\Models\Statuses;
use App\Models\SupplyOrder;
use App\Models\User;

class ClientSettingController extends Controller
{
    /**
     * عرض صفحة إعدادات العميل
     */
    public function general()
    {

        
        $settings = GeneralClientSetting::all();
        $selectedType = ClientType::value('type'); // جلب أول قيمة من العمود type

        // إذا لم تكن هناك بيانات، استخدم القيمة الافتراضية "كلاهما"
        $selectedType = $selectedType ?? 'Both';

        return view('client.setting.general', compact('settings','selectedType')); // عرض view مع البيانات
    }

    public function setting()
    {
        return view('client.setting.index');
    }

    public function status()
{
    $statuses = Statuses::all();
    return view('client.setting.status', compact('statuses'));
}
public function storeStatus(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:statuses,name',
    ]);

    Statuses::create([
        'name' => $request->name
    ]);

    return redirect()->back()->with('success', 'تمت إضافة الحالة بنجاح.');
}
public function deleteStatus($id)
{
    $status = Statuses::find($id);

    if (!$status) {
        return redirect()->back()->with('error', 'الحالة غير موجودة.');
    }

    $status->delete();
    return redirect()->back()->with('success', 'تم حذف الحالة بنجاح.');
}


    /**
     * حفظ الإعدادات الجديدة
     */
    public function store(Request $request)
    {
        // حفظ نوع العميل المختار
        $selectedClientType = $request->type;

        // البحث عن السجل بناءً على النوع، إذا وجد يتم تحديثه، وإلا يتم إنشاؤه
        $clientType = ClientType::updateOrCreate(
            ['type' => $selectedClientType], // الشروط للبحث
            ['is_active' => true] // البيانات التي سيتم تحديثها أو إنشاؤها
        );

        // تحديث حالة is_active في GeneralClientSetting
        $settings = GeneralClientSetting::all();
        foreach ($settings as $setting) {
            $setting->update([
                'is_active' => in_array($setting->id, $request->settings ?? []),
            ]);
        }



        // إضافة رسالة نجاح إلى الجلسة
        return redirect()->back()->with('success', 'تم حفظ التغييرات بنجاح.');
    }

    // صلاحيات العميل 
    public function permission()
     {
         $ClientPermissions = ClientPermission::all();
        return view('client.setting.permission', compact('ClientPermissions'));
    }

    public function permission_store(Request $request)
    {
       
    
        // تحديث حالة is_active في GeneralClientSetting
        $settings = ClientPermission::all();
        foreach ($settings as $setting) {
            $setting->update([
                'is_active' => in_array($setting->id, $request->settings ?? []),
            ]);
        }



        // إضافة رسالة نجاح إلى الجلسة
        return redirect()->back()->with('success', 'تم حفظ التغييرات بنجاح.');
    }
    
    public function personal()
    {
        $user = User::find(auth()->user()->id);
        $client = Client::find($user->client_id);
        $invoices =  Invoice::where('client_id',$user->client_id)->get();
        $invoices_count = Invoice::where('client_id',$user->client_id)->count();
        $invoices_due_value = Invoice::where('client_id',$user->client_id)->sum('due_value');
        return view('dashboard.client', ['client' => $client , 'invoices_count' => $invoices_count, 'invoices' => $invoices,'invoices_due_value' => $invoices_due_value]);
                                  
        
    }
  
   
    public function invoice_client(Request $request)
    {
        // بدء بناء الاستعلام
        
        $user = User::find(auth()->user()->id);
        $invoices = Invoice::with(['client', 'createdByUser', 'updatedByUser'])->where('client_id',$user->client_id)->orderBy('created_at', 'desc');


      

        // جلب النتائج مع التقسيم (Pagination)
        $invoices = $invoices->get();

        // البيانات الأخرى المطلوبة للواجهة
        $clients = Client::all();
        $users = User::all();
        $employees = Employee::all();
        $invoice_number = $this->generateInvoiceNumber();

        $account_setting = AccountSetting::where('user_id', auth()->user()->id)->first();
        $client = Client::where('user_id', auth()->user()->id)->first();

        return view('client.setting.invoice_client', compact('invoices', 'account_setting', 'client', 'clients', 'users', 'invoice_number', 'employees'));
    }
     private function generateInvoiceNumber()
    {
        $lastInvoice = Invoice::latest()->first();
        $nextId = $lastInvoice ? $lastInvoice->id + 1 : 1;
        return str_pad($nextId, 6, '0', STR_PAD_LEFT);
    }
    
     public function appointments_client()
     {
        $user = User::find(auth()->user()->id);
        $appointments = Appointment::where('client_id', $user->client_id)
    ->latest()
    ->paginate(10);
        $employees = Employee::all();
        $clients = Client::all();
        // جلب الإجراءات الفريدة
        $actionTypes = Appointment::distinct()->pluck('action_type')->filter()->values();

        return view('client.setting.appointments_client', compact('appointments', 'employees', 'clients', 'actionTypes'));
     }

     //SupplyOrders_client

     public function SupplyOrders_client(Request $request)
     {
        $user = User::find(auth()->user()->id);
         $clients = Client::all();
         $employees = Employee::all();
 
         // Count for each filter
         $totalCount = SupplyOrder::where('client_id',$user->client_id)->count();
         $resultsCount = SupplyOrder::where('client_id',$user->client_id)->orderBy('created_at', 'desc')->count();
         $openCount = SupplyOrder::where('client_id',$user->client_id)->where('status', 1)->count();
         $closedCount = SupplyOrder::where('client_id',$user->client_id)->where('status', 2)->count();
 
         // Start with base query
         $query = SupplyOrder::where('client_id',$user->client_id)->with(['client', 'employee']);
 
      
 
        
 
         // Sorting
         $query->latest();
 
         // Paginate results
         $supplyOrders = SupplyOrder::where('client_id',$user->client_id)->with(['client', 'employee'])->paginate(10);
 
         // Prepare additional data for filtering dropdowns
         $filterClients = Client::whereHas('supplyOrders')->get();
         $filterEmployees = Employee::whereHas('supplyOrders')->get();
 
         // Prepare filter counts for each client and employee
         $clientCounts = Client::withCount('supplyOrders')->get();
         $employeeCounts = Employee::withCount('supplyOrders')->get();
 
         return view('client.setting.SupplyOrders_client', compact('clients', 'employees', 'supplyOrders', 'filterClients', 'filterEmployees', 'clientCounts', 'employeeCounts', 'totalCount', 'resultsCount', 'openCount', 'closedCount'));
     }
//questions_client

public function questions_client(Request $request)
{
    $user = User::find(auth()->user()->id);
    $query = Quote::where('client_id',$user->client_id)->with(['client', 'creator', 'items']);

  

    // ترتيب النتائج حسب تاريخ الإنشاء تنازلياً
    $quotes = Quote::where('client_id',$user->client_id)->with(['client', 'creator', 'items'])->orderBy('created_at', 'desc')->paginate(10); // استبدل get() بـ paginate()

    // جلب البيانات الأخرى المطلوبة للصفحة
    $quotes_number = $this->generateInvoiceNumber();
    $clients = Client::all();
    $users = User::all();
    $employees = Employee::all();

    // إرجاع البيانات مع المتغيرات المطلوبة للعرض
    return view('client.setting.questions_client', compact('quotes', 'quotes_number', 'clients', 'users', 'employees'))
        ->with('search_params', $request->all()); // إرجاع معاملات البحث للحفاظ على حالة النموذج
}


public function profile()
{
       $user = User::find(auth()->user()->id);
        $client = Client::findOrFail($user->client_id);
        $employees = Employee::all();

    return view('client.setting.profile', compact('client','employees'));
   
     
}
public function Client_store(Request $request)
{
    // استدعاء التحقق من البيانات باستخدام ClientRequest
    $data_request = $request->except('_token');

    // العثور على العميل باستخدام الـ ID
    $user = User::find(auth()->user()->id);
    $client = Client::findOrFail($user->client_id);

    // حفظ نسخة من البيانات القديمة لتحديد التعديلات

    // معالجة الصورة إذا تم تحميلها
    if ($request->hasFile('attachments')) {
        $file = $request->file('attachments');
        if ($file->isValid()) {
            // حذف الملف القديم إذا وجد
            if ($client->attachments) {
                $oldFile = public_path('uploads/clients/') . $client->attachments;
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }

            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/clients'), $filename);
            $data_request['attachments'] = $filename;
        }
    }

    // تحديث بيانات العميل
    $client->update($data_request);

    // تحديد الحقول التي تم تعديلها

    // معالجة جهات الاتصال
    if ($request->has('contacts') && is_array($request->contacts)) {
        $existingContactIds = $client->contacts->pluck('id')->toArray();

        foreach ($request->contacts as $contactData) {
            if (isset($contactData['id']) && in_array($contactData['id'], $existingContactIds)) {
                // تحديث جهة الاتصال الموجودة
                $contact = $client->contacts()->find($contactData['id']);
                $contact->update($contactData);
            } else {
                // إضافة جهة اتصال جديدة
                $newContact = $client->contacts()->create($contactData);
            }
        }

        // حذف جهات الاتصال غير المدرجة في الطلب
        $newContactIds = array_column($request->contacts, 'id');
        $contactsToDelete = array_diff($existingContactIds, $newContactIds);
        $client->contacts()->whereIn('id', $contactsToDelete)->delete();
    }

    return redirect()->route('clients.personal')->with('success', '✨ تم تحديث العميل بنجاح!');
}
    /**
     * تحديث الإعدادات
     */
    public function update(Request $request, $id)
    {
        // التحقق من البيانات المرسلة
        $request->validate([
            'setting_name' => 'required|string|max:255',
            'setting_value' => 'required|string',
        ]);

        // تحديث الإعدادات في قاعدة البيانات (مثال)
        $setting = ClientSetting::findOrFail($id); // افترض أن لديك نموذج ClientSetting
        $setting->name = $request->setting_name;
        $setting->value = $request->setting_value;
        $setting->save();

        return redirect()->route('clients.settings')->with('success', 'تم تحديث الإعدادات بنجاح.');
    }

    /**
     * حذف الإعدادات
     */
    public function destroy($id)
    {
        // حذف الإعدادات من قاعدة البيانات (مثال)
        $setting = ClientSetting::findOrFail($id); // افترض أن لديك نموذج ClientSetting
        $setting->delete();

        return redirect()->route('clients.settings')->with('success', 'تم حذف الإعدادات بنجاح.');
    }
}
