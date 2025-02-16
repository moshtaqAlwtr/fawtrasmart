<?php

namespace App\Http\Controllers\Client;
use App\Models\Client;
use App\Models\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Models\Account;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\AppointmentNote;
use App\Models\Booking;
use App\Models\Installment;
use App\Models\Memberships;
use App\Models\Package;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::with('employee')->select()->orderBy('created_at', 'desc')->paginate(10);
        $users = User::all();
        $employees = Employee::all();
        return view('client.index', compact('clients', 'users','employees'));
    }

    public function create()
    {
        $employees = Employee::all();

        $lastClient = Client::orderBy('code', 'desc')->first();
        $newCode = $lastClient ? $lastClient->code + 1 : 1;

        return view('client.create', compact('employees', 'newCode'));
    }

    public function store(ClientRequest $request)
{
    $data_request = $request->except('_token');

    // إنشاء العميل
    $client = new Client();

    // إضافة الكود تلقائيًا
    $lastClient = Client::orderBy('code', 'desc')->first();
    $client->code = $lastClient ? $lastClient->code + 1 : 1;

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

    // إنشاء حساب فرعي باستخدام trade_name
    $customers = Account::where('name', 'العملاء')->first(); // الحصول على حساب العملاء الرئيسي
    if ($customers) {
        $customerAccount = new Account();
        $customerAccount->name = $client->trade_name; // استخدام trade_name كاسم الحساب

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

        // حذف السجلات المرتبطة أولاً
        // $client->invoices()->delete();
        // $client->receipts()->delete();
        // $client->payments()->delete();
        // $client->cheques()->delete();
        // $client->creditNotifications()->delete();
        // $client->journalEntries()->delete();

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
       
       
        $installment = Installment::with('invoice.client')->findOrFail($id);
        $client = Client::with([
            'invoices' => function ($query) {
                $query->orderBy('invoice_date', 'desc');
            },
            'appointments' => function ($query) {
                $query->orderByAppointmentDate();
            },
            'employee',
        ])->findOrFail($id);

        $bookings  = Booking::where('client_id',$id)->get();
        $Client    = Client::find($id);
        $packages	= Package::all();
        $memberships = Memberships::all();

        return view('client.show', compact('client','installment','bookings','Client','packages','memberships'));
    }

    public function contact()
    {
        $clients = Client::all();

        return view('client.contacts.contact_mang', compact('clients'));
    }

    public function contacts()
    {
        $clients = Client::with('employee')->select('id', 'trade_name', 'first_name', 'last_name', 'phone', 'city', 'region', 'street1', 'street2', 'code', 'employee_id')->orderBy('created_at', 'desc')->paginate(10);

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
                        'employee' => $client->employee ? [
                            'name' => $client->employee->name,
                            'department' => $client->employee->department,
                            'role' => $client->employee->role,
                        ] : null,
                    ]
                ]);
            }

            // For regular requests, return the view
            return view('client.relestion_mang_client', compact(
                'clients',
                'client',
                'employees',
                'notes',
                'appointments',
                'previousClient',
                'nextClient'
            ));
        } catch (\Exception $e) {
            // If it's an AJAX request, return error response
            if (request()->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'حدث خطأ أثناء تحميل بيانات العميل'
                ], 422);
            }

            // For regular requests, redirect with error
            return redirect()->route('clients.mang_client')
                ->with('error', 'حدث خطأ أثناء تحميل بيانات العميل');
        }
    }
}
