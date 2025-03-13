<?php

namespace App\Http\Controllers\Client;

use App\Models\Client;
use App\Models\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Imports\ClientsImport;
use App\Models\Account;
use App\Models\Appointment;
use App\Models\Log as ModelsLog;
use Illuminate\Http\Request;
use App\Models\AppointmentNote;
use App\Models\Booking;
use App\Models\Branch;
use App\Models\CategoriesClient;
use App\Models\Installment;
use App\Models\Memberships;
use App\Models\Package;
use App\Models\SerialSetting;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        // الحصول على المستخدم الحالي
        $user = auth()->user();

        // بدء بناء الاستعلام
        $query = Client::query();

        // التحقق مما إذا كان للمستخدم فرع أم لا
        if ($user->branch) {
            $branch = $user->branch;

            // التحقق من صلاحية "مشاركة بيانات العملاء"
            $shareCustomersStatus = $branch->settings()->where('key', 'share_customers')->first();

            // إذا كانت الصلاحية غير مفعلة، عرض العملاء الخاصين بالفرع فقط
            if ($shareCustomersStatus && $shareCustomersStatus->pivot->status == 0) {
                $query->whereHas('employee', function ($query) use ($branch) {
                    $query->where('branch_id', $branch->id);
                });
            }
        }

        // تطبيق شروط البحث بناءً على الحقول المحددة
        if ($request->has('client') && $request->client != '') {
            $query->where('id', $request->client);
        }

        if ($request->has('name') && $request->name != '') {
            $query->where('trade_name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('classifications') && $request->classifications != '') {
            $query->where('category', $request->classifications);
        }

        if ($request->has('end_date_to') && $request->end_date_to != '') {
            $query->whereDate('created_at', '<=', $request->end_date_to);
        }

        if ($request->has('address') && $request->address != '') {
            $query->where('street1', 'like', '%' . $request->address . '%')->orWhere('street2', 'like', '%' . $request->address . '%');
        }

        if ($request->has('postal_code') && $request->postal_code != '') {
            $query->where('postal_code', $request->postal_code);
        }

        if ($request->has('country') && $request->country != '') {
            $query->where('country', $request->country);
        }

        if ($request->has('tage') && $request->tage != '') {
            $query->where('tags', 'like', '%' . $request->tage . '%');
        }

        if ($request->has('user') && $request->user != '') {
            $query->where('employee_id', $request->user);
        }

        if ($request->has('type') && $request->type != '') {
            $query->where('client_type', $request->type);
        }

        if ($request->has('full_name') && $request->full_name != '') {
            $query->whereHas('employee', function ($query) use ($request) {
                $query->where('id', $request->full_name);
            });
        }

        // تنفيذ الاستعلام مع التقسيم (Pagination)
        $clients = $query->with('employee')->orderBy('created_at', 'desc')->paginate(25);

        // جلب جميع المستخدمين والموظفين (إذا كان مطلوبًا)
        $users = User::all();
        $employees = Employee::all();

        return view('client.index', compact('clients', 'users', 'employees'));
    }
    public function create()
    {
        $employees = Employee::all();
        $categories = CategoriesClient::all();

        $lastClient = Client::orderBy('code', 'desc')->first();
        $newCode = $lastClient ? $lastClient->code + 1 : 1;

        return view('client.create', compact('employees', 'newCode', 'categories'));
    }

    public function store(ClientRequest $request)
    {
        $data_request = $request->except('_token');

        // إنشاء العميل
        $client = new Client();

        // الحصول على الرقم الحالي لقسم العملاء من جدول serial_settings
        $serialSetting = SerialSetting::where('section', 'customer')->first();

        // إذا لم يتم العثور على إعدادات، نستخدم 1 كقيمة افتراضية
        $currentNumber = $serialSetting ? $serialSetting->current_number : 1;

        // تعيين id للعميل الجديد باستخدام الرقم الحالي
        $client->id = $currentNumber;

        // تعيين الكود للعميل الجديد (إذا كان الكود مطلوبًا أيضًا)
        $client->code = $currentNumber;

        // تعبئة البيانات الأخرى
        $client->fill($data_request);

        // معالجة الصورة
        if ($request->hasFile('attachments')) {
            $file = $request->file('attachments');
            if ($file->isValid()) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('assets/uploads/'), $filename);
                $client->attachments = $filename;
            }
        }

        // حفظ العميل
        $client->save();
        
           // تسجيل اشعار نظام جديد
            ModelsLog::create([
                'type' => 'client',
                'type_id' => $client->id, // ID النشاط المرتبط
                'type_log' => 'log', // نوع النشاط
                'description' => 'تم اضافة  عميل **' . $client->trade_name. '**',
                'created_by' => auth()->id(), // ID المستخدم الحالي
            ]);

        // زيادة الرقم الحالي بمقدار 1
        if ($serialSetting) {
            $serialSetting->update(['current_number' => $currentNumber + 1]);
        }

        // إنشاء حساب فرعي باستخدام trade_name
        $customers = Account::where('name', 'العملاء')->first(); // الحصول على حساب العملاء الرئيسي
        if ($customers) {
            $customerAccount = new Account();
            $customerAccount->name = $client->trade_name; // استخدام trade_name كاسم الحساب
            $customerAccount->client_id = $client->id;

            // تعيين كود الحساب الفرعي بناءً على كود الحسابات
            $lastChild = Account::where('parent_id', $customers->id)->orderBy('code', 'desc')->first();
            $newCode = $lastChild ? $this->generateNextCode($lastChild->code) : $customers->code . '1'; // استخدام نفس منطق توليد الكود
            $customerAccount->code = $newCode; // تعيين الكود الجديد للحساب الفرعي

            $customerAccount->balance_type = 'debit'; // أو 'credit' حسب الحاجة
            $customerAccount->parent_id = $customers->id; // ربط الحساب الفرعي بحساب العملاء
            $customerAccount->is_active = false;
            $customerAccount->save();
        }

        // حفظ جهات الاتصال المرتبطة بالعميل
        if ($request->has('contacts') && is_array($request->contacts)) {
            foreach ($request->contacts as $contact) {
                $client->contacts()->create($contact);
            }
        }

        return redirect()->route('clients.index')->with('success', '✨ تم إضافة العميل بنجاح!');
    }
    public function testcient()
    {
        $clients = Client::all();

        foreach ($clients as $client) {
            $customers = Account::where('name', 'العملاء')->first(); // الحصول على حساب العملاء الرئيسي
            if ($customers) {
                $customerAccount = new Account();
                $customerAccount->name = $client->trade_name; // استخدام trade_name كاسم الحساب
                $customerAccount->client_id = $client->id;

                // تعيين كود الحساب الفرعي بناءً على كود الحسابات
                $lastChild = Account::where('parent_id', $customers->id)->orderBy('code', 'desc')->first();
                $newCode = $lastChild ? $this->generateNextCode($lastChild->code) : $customers->code . '1'; // استخدام نفس منطق توليد الكود
                $customerAccount->code = $newCode; // تعيين الكود الجديد للحساب الفرعي

                $customerAccount->balance_type = 'debit'; // أو 'credit' حسب الحاجة
                $customerAccount->parent_id = $customers->id; // ربط الحساب الفرعي بحساب العملاء
                $customerAccount->is_active = false;
                $customerAccount->save();
            }
        }
    }
    // إضافة هذه الدالة في نفس وحدة التحكم
    private function generateNextCode(string $lastChildCode): string
    {
        // استخراج الرقم الأخير من الكود
        $lastNumber = intval(substr($lastChildCode, -1));
        // زيادة الرقم الأخير بمقدار 1
        $newNumber = $lastNumber + 1;
        // إعادة بناء الكود مع الرقم الجديد
        return substr($lastChildCode, 0, -1) . $newNumber;
    }

    public function update(ClientRequest $request, $id)
    {
        // استدعاء التحقق من البيانات باستخدام ClientRequest
        $data_request = $request->except('_token');

        // العثور على العميل باستخدام الـ ID
        $client = Client::findOrFail($id);

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

        return redirect()->route('clients.index')->with('success', '✨ تم تحديث العميل بنجاح!');
    }

    public function edit_question($id)
    {
        $client = Client::findOrFail($id);
        $employees = Employee::all();
        return view('client.edit', compact('client', 'employees'));
    }
    public function destroy($id)
    {
        $client = Client::findOrFail($id);

        // التحقق من وجود فواتير مرتبطة بالعميل
        if ($client->invoices()->exists()) {
            return redirect()->back()->with('error', 'لا يمكن حذف العميل لأنه يحتوي على فواتير مرتبطة.');
        }

        // حذف المدفوعات المرتبطة
        if ($client->payments()->exists()) {
            $client->payments()->delete();
        }

        // حذف إشعارات الائتمان المرتبطة
        if ($client->creditNotifications()->exists()) {
            $client->creditNotifications()->delete();
        }

        // حذف مدخلات المجلة المرتبطة
        if ($client->journalEntries()->exists()) {
            $client->journalEntries()->delete();
        }

        // حذف المرفقات إذا وجدت
        if ($client->attachments) {
            $attachments = explode(',', $client->attachments);
            foreach ($attachments as $attachment) {
                $path = public_path('uploads/clients/' . trim($attachment));
                if (file_exists($path)) {
                    unlink($path);
                }
            }
        }

        // حذف العميل
        $client->delete();

        return redirect()->back()->with('success', 'تم حذف العميل وجميع البيانات المرتبطة به بنجاح');
    }
    public function show($id)
    {
        // تحميل البيانات المطلوبة
        $installment = Installment::with('invoice.client')->get();
        $employees = Employee::all();
        $account = Account::all();

        // تحميل العميل مع الفواتير والمدفوعات والملاحظات المرتبطة بها
        $client = Client::with([
            'invoices' => function ($query) {
                $query->orderBy('invoice_date', 'desc');
            },
            'invoices.payments', // تحميل المدفوعات المرتبطة بكل فاتورة
            'appointments' => function ($query) {
                $query->orderBy('appointment_date', 'desc');
            },
            'employee',
            'account',
            'payments' => function ($query) {
                $query->orderBy('payment_date', 'desc'); // تحميل جميع المدفوعات المرتبطة بالعميل
            },
            'appointmentNotes' => function ($query) { // تحميل الملاحظات المرتبطة بالعميل
                $query->orderBy('created_at', 'desc');
            },
        ])->findOrFail($id);

        // تحقق من بيانات العميل مع العلاقات

        $bookings = Booking::where('client_id', $id)->get();
        $packages = Package::all();
        $memberships = Memberships::where('client_id', $id)->get();

        // تحميل الفواتير المرتبطة بالعميل
        $invoices = $client->invoices;

        // تحميل جميع المدفوعات المرتبطة بالعميل
        $payments = $client->payments;

        // تحميل الملاحظات المرتبطة بالعميل
        $appointmentNotes = $client->appointmentNotes;

        // تحقق من الملاحظات


        return view('client.show', compact('client', 'account', 'installment', 'employees', 'bookings', 'packages', 'memberships', 'invoices', 'payments', 'appointmentNotes'));
    }
    public function contact()
    {
        $clients = Client::all();

        return view('client.contacts.contact_mang', compact('clients'));
    }

    public function contacts(Request $request)
    {
        $query = Client::with('employee')
            ->select('id', 'trade_name', 'first_name', 'last_name', 'phone', 'city', 'region', 'street1', 'street2', 'code', 'employee_id')
            ->orderBy('created_at', 'desc');
    
        // البحث الأساسي (بالاسم أو الكود)
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('trade_name', 'like', '%' . $search . '%')
                  ->orWhere('code', 'like', '%' . $search . '%')
                  ->orWhere('first_name', 'like', '%' . $search . '%')
                  ->orWhere('last_name', 'like', '%' . $search . '%');
            });
        }
    
        // البحث المتقدم (بالبريد الإلكتروني أو رقم الهاتف أو رقم الجوال)
        if ($request->has('advanced_search')) {
            $advancedSearch = $request->input('advanced_search');
            $query->where(function ($q) use ($advancedSearch) {
                $q->where('email', 'like', '%' . $advancedSearch . '%')
                  ->orWhere('phone', 'like', '%' . $advancedSearch . '%')
                  ->orWhere('mobile', 'like', '%' . $advancedSearch . '%');
            });
        }
    
        $clients = $query->paginate(25);
    
        return view('client.contacts.contact_mang', compact('clients'));
    }

    public function show_contant($id)
    {
        $client = Client::with(['appointments.notes', 'appointments.client'])->findOrFail($id);
        $notes = AppointmentNote::with(['appointment', 'user'])
            ->whereHas('appointment', function ($query) use ($id) {
                $query->where('client_id', $id);
            })
            ->latest()
            ->get();

        return view('client.contacts.show_contant', compact('client', 'notes'));
    }
    public function mang_client()
    {
        $clients = Client::orderBy('created_at', 'desc')->get();
        $notes = AppointmentNote::with(['user'])
            ->latest()
            ->get();
        $appointments = Appointment::all();
        $employees = Employee::all();

        // Get the first client by default
        $client = $clients->first();

        return view('client.relestion_mang_client', compact('clients', 'employees', 'notes', 'appointments', 'client'));
    }

    public function mang_client_details($id)
    {
        try {
            // Find the client
            $client = Client::with(['employee'])->findOrFail($id);

            // Get all clients for the sidebar
            $clients = Client::orderBy('created_at', 'desc')->get();

            // Get notes and appointments
            $notes = AppointmentNote::with(['user'])
                ->latest()
                ->get();
            $appointments = Appointment::all();
            $employees = Employee::all();

            // Get previous and next client IDs
            $previousClient = Client::where('id', '<', $id)->orderBy('id', 'desc')->first();
            $nextClient = Client::where('id', '>', $id)->orderBy('id', 'asc')->first();

            // If it's an AJAX request, return JSON
            if (request()->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'client' => $client,
                        'trade_name' => $client->trade_name,
                        'phone' => $client->phone,
                        'email' => $client->email,
                        'status' => $client->status,
                        'employee' => $client->employee
                            ? [
                                'name' => $client->employee->name,
                                'department' => $client->employee->department,
                                'role' => $client->employee->role,
                            ]
                            : null,
                    ],
                ]);
            }

            // For regular requests, return the view
            return view('client.relestion_mang_client', compact('clients', 'client', 'employees', 'notes', 'appointments', 'previousClient', 'nextClient'));
        } catch (\Exception $e) {
            // If it's an AJAX request, return error response
            if (request()->ajax()) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'حدث خطأ أثناء تحميل بيانات العميل',
                    ],
                    422,
                );
            }

            // For regular requests, redirect with error
            return redirect()->route('clients.mang_client')->with('error', 'حدث خطأ أثناء تحميل بيانات العميل');
        }
    }
    public function assignEmployees(Request $request)
    {
        // التحقق من صحة البيانات
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'employee_id' => 'required|array',
            'employee_id.*' => 'exists:employees,id',
        ]);

        try {
            // البحث عن العميل
            $client = Client::findOrFail($request->client_id);

            // بدء المعاملة
            DB::beginTransaction();

            // مزامنة الموظفين (إضافة وإزالة)
            $client->employees()->sync($request->employee_id);

            // إنهاء المعاملة
            DB::commit();

            // إعادة التوجيه مع رسالة نجاح
            return redirect()->back()->with('success', 'تم تعيين الموظفين بنجاح');
        } catch (\Exception $e) {
            // إلغاء المعاملة في حالة الخطأ
            DB::rollBack();

            // تسجيل الخطأ
            Log::error('خطأ في تعيين الموظفين: ' . $e->getMessage());

            // إعادة التوجيه مع رسالة خطأ
            return redirect()->back()->with('error', 'حدث خطأ أثناء تعيين الموظفين');
        }
    }

    /**
     * إزالة موظف محدد من عميل
     */
    public function removeEmployee(Request $request, $clientId)
    {
        // التحقق من صحة البيانات
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|exists:employees,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'خطأ في البيانات المدخلة');
        }

        try {
            // البحث عن العميل
            $client = Client::findOrFail($clientId);

            // إزالة الموظف
            $client->employees()->detach($request->employee_id);

            // تسجيل عملية الإزالة
            Log::info('تمت إزالة الموظف', [
                'client_id' => $clientId,
                'employee_id' => $request->employee_id,
            ]);

            // إعادة التوجيه مع رسالة نجاح
            return redirect()->back()->with('success', 'تم إزالة الموظف بنجاح');
        } catch (\Exception $e) {
            // تسجيل الخطأ
            Log::error('خطأ في إزالة الموظف', [
                'message' => $e->getMessage(),
                'client_id' => $clientId,
                'employee_id' => $request->employee_id,
            ]);

            // إعادة التوجيه مع رسالة خطأ
            return redirect()
                ->back()
                ->with('error', 'حدث خطأ أثناء إزالة الموظف: ' . $e->getMessage());
        }
    }

    /**
     * جلب الموظفين المعينين لعميل
     */
    public function getAssignedEmployees($clientId)
    {
        try {
            // البحث عن العميل مع الموظفين المرتبطين
            $client = Client::with('employees')->findOrFail($clientId);

            // إرجاع استجابة JSON
            return response()->json([
                'success' => true,
                'employees' => $client->employees->map(function ($employee) {
                    return [
                        'id' => $employee->id,
                        'name' => $employee->full_name,
                        'department' => $employee->department,
                        'role' => $employee->role,
                    ];
                }),
            ]);
        } catch (\Exception $e) {
            // تسجيل الخطأ
            Log::error('خطأ في جلب الموظفين المعينين: ' . $e->getMessage());

            // إرجاع استجابة خطأ
            return response()->json(
                [
                    'success' => false,
                    'message' => 'حدث خطأ أثناء جلب الموظفين',
                ],
                500,
            );
        }
    }
    public function import(Request $request)
    {
        set_time_limit(500);
        $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);

        Excel::import(new ClientsImport(), $request->file('file'));

        return redirect()->back()->with('success', 'تم استيراد العملاء بنجاح!');
    }
}
