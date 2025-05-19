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
use App\Models\ClientRelation;
use App\Models\GeneralClientSetting;
use App\Models\Installment;
use App\Models\Invoice;
use App\Models\Memberships;
use App\Models\Neighborhood;
use App\Models\AccountSetting;
use App\Models\Region_groub;
use App\Models\Package;
use App\Models\PaymentsProcess;
use App\Models\SerialSetting;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use App\Mail\SendPasswordEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\notifications;
use App\Mail\TestMail;
use App\Models\ClientEmployee;
use App\Models\Statuses;
use App\Models\CreditLimit;
use App\Models\Expense;
use App\Models\JournalEntry;
use App\Models\JournalEntryDetail;
use App\Models\Location;
use App\Models\Revenue;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // بناء الاستعلام الأساسي للعملاء
        $baseQuery = Client::query();

        // تطبيق فلتر الفرع
        if ($user->branch_id) {
            // إذا كان المستخدم مدير والفرع هو الفرع الرئيسي
            if ($user->role === 'manager' && $user->branch && $user->branch->name === 'الرئيسي') {
                // لا نطبق أي فلتر - سيظهر جميع العملاء
            } else {
                // للموظفين العاديين أو المدراء في الفروع الأخرى
                $baseQuery->where('branch_id', $user->branch_id);
            }
        }

        // تطبيق فلترات البحث على الاستعلام الأساسي
        if ($request->filled('client')) {
            $baseQuery->where('id', $request->client);
        }

        if ($request->filled('name')) {
            $baseQuery->where('trade_name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('status')) {
            $baseQuery->where('status_id', $request->status);
        }

        if ($request->filled('region')) {
            $baseQuery->whereHas('Neighborhoodname.Region', function ($q) use ($request) {
                $q->where('id', $request->region);
            });
        }

        if ($request->filled('neighborhood')) {
            $baseQuery->whereHas('Neighborhoodname', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->neighborhood . '%')
                  ->orWhere('id', $request->neighborhood);
            });
        }

        // نسخ الاستعلام المفلتر للخريطة
        $mapQuery = clone $baseQuery;

        // الحصول على العملاء للخريطة مع البيانات الأساسية
        $allClients = $mapQuery->with([
            'status_client:id,name,color',
            'locations:id,client_id,latitude,longitude',
            'Neighborhoodname.Region',
            'branch:id,name'
        ])->get();

        // الحصول على موقع المستخدم الحالي
        $userLocation = Location::where('employee_id', $user->employee_id)
                              ->latest()
                              ->first();

        // تحميل العلاقات للعرض في الجدول
        $baseQuery->with([
            'employee',
            'status:id,name,color',
            'locations',
            'Neighborhoodname.Region',
            'branch:id,name'
        ]);

        // الحصول على النتائج المقسمة للجدول
        $clients = $baseQuery->orderBy('created_at', 'desc')
                            ->paginate(20)
                            ->appends($request->except('page'));

        // الحصول على البيانات الإضافية للقوائم المنسدلة
        $users = User::all();
        $employees = Employee::all();
        $statuses = Statuses::select('id', 'name', 'color')->get();
        $creditLimit = CreditLimit::first();
        $Region_groups = Region_groub::all();
        $Neighborhoods = Neighborhood::all();

        return view('client.index', compact(
            'clients',
            'allClients',
            'Neighborhoods',
            'users',
            'employees',
            'creditLimit',
            'statuses',
            'Region_groups',
            'userLocation'
        ));
    }
    public function updateCreditLimit(Request $request)
    {
        $request->validate([
            'value' => 'required|numeric|min:0',
        ]);

        // تحديث أو إنشاء الحد الائتماني إذا لم يكن موجودًا
        $creditLimit = CreditLimit::first(); // يجلب أول حد ائتماني
        if ($creditLimit) {
            $creditLimit->value = $request->value;
            $creditLimit->save();
        } else {
            CreditLimit::create([
                'value' => $request->value,
            ]);
        }

        return redirect()->back()->with('success', 'تم تحديث الحد الائتماني بنجاح!');
    }

    public function group_client()
    {
        $Regions_groub = Region_groub::all();
        return view('client.group_client', compact('Regions_groub'));
    }

    public function group_client_create()
    {
        return view('client.group_client_create');
    }

    public function group_client_store(Request $request)
    {
        // تحقق من صحة البيانات المدخلة
        $request->validate([
            'name' => 'required|string|unique:region_groubs,name',
        ]);

        // إنشاء مجموعة المنطقة الجديدة
        $regionGroup = new Region_groub();
        $regionGroup->name = $request->name;
        $regionGroup->save();

        // إرجاع البيانات المحفوظة أو رسالة نجاح
        return redirect()->route('clients.group_client')->with('success', 'تم إنشاء المجموعة بنجاح');
    }
    public function create()
    {
        $employees = Employee::all();
        $categories = CategoriesClient::all();
        $Regions_groub = Region_groub::all();
        $branches = Branch::all();
        $lastClient = Client::orderBy('code', 'desc')->first();

        $newCode = $lastClient ? $lastClient->code + 1 : 3000;

        $GeneralClientSettings = GeneralClientSetting::all();
        // إذا كان الجدول فارغًا، قم بإنشاء قيم افتراضية (مفعلة بالكامل)
        if ($GeneralClientSettings->isEmpty()) {
            $defaultSettings = [['key' => 'image', 'name' => 'صورة', 'is_active' => true], ['key' => 'type', 'name' => 'النوع', 'is_active' => true], ['key' => 'birth_date', 'name' => 'تاريخ الميلاد', 'is_active' => true], ['key' => 'location', 'name' => 'الموقع على الخريطة', 'is_active' => true], ['key' => 'opening_balance', 'name' => 'الرصيد الافتتاحي', 'is_active' => true], ['key' => 'credit_limit', 'name' => 'الحد الائتماني', 'is_active' => true], ['key' => 'credit_duration', 'name' => 'المدة الائتمانية', 'is_active' => true], ['key' => 'national_id', 'name' => 'رقم الهوية الوطنية', 'is_active' => true], ['key' => 'addresses', 'name' => 'عناوين متعددة', 'is_active' => true], ['key' => 'link', 'name' => 'الرابط', 'is_active' => true]];

            // تحويل المصفوفة إلى مجموعة (Collection)
            $GeneralClientSettings = collect($defaultSettings)->map(function ($item) {
                return (object) $item; // تحويل المصفوفة إلى كائن
            });
        }
        return view('client.create', compact('employees', 'branches', 'newCode', 'categories', 'GeneralClientSettings', 'Regions_groub'));
    }
    private function getNeighborhoodFromGoogle($latitude, $longitude)
    {
        $apiKey = env('GOOGLE_MAPS_API_KEY'); // احصل على API Key من .env
        $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$latitude,$longitude&key=$apiKey&language=ar";

        $response = file_get_contents($url);
        $data = json_decode($response, true);

        if (!empty($data['results'])) {
            foreach ($data['results'][0]['address_components'] as $component) {
                if (in_array('sublocality', $component['types']) || in_array('neighborhood', $component['types'])) {
                    return $component['long_name']; // اسم الحي
                }
            }
        }
        return 'لم يتم العثور على الحي';
    }
    public function store(ClientRequest $request)
{
    $data_request = $request->except('_token');
    $rules = [
        'region_id' => ['required'],
    ];

    $messages = [
        'region_id.required' => 'حقل المجموعة مطلوب.',
    ];

    $request->validate($rules, $messages);

    if ($request->has('latitude') && $request->has('longitude')) {
        $latitude = $request->latitude;
        $longitude = $request->longitude;
    } else {
        return redirect()->back()->with('error', 'الإحداثيات غير موجودة');
    }

    $client = new Client();

    // الحصول على الرقم الحالي لقسم العملاء من جدول serial_settings
    $serialSetting = SerialSetting::where('section', 'customer')->first();
    $currentNumber = $serialSetting ? $serialSetting->current_number : 1;

    // تعيين id للعميل الجديد
    $client->code = $currentNumber;
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

    // حفظ العميل أولاً
    $client->save();

    // حفظ جهات الاتصال الأساسية (الاسم التجاري والهاتف والجوال)
    $mainContact = [
        'first_name' => $client->trade_name,
        'phone' => $client->phone,
        'mobile' => $client->mobile,
        'email' => $client->email,
        'is_primary' => true, // إضافة حقل لتحديد الاتصال الأساسي
    ];

    $client->contacts()->create($mainContact);

    // حفظ الموظفين المرتبطين
    if (auth()->user()->role === 'manager') {
        if ($request->has('employee_client_id')) {
            foreach ($request->employee_client_id as $employee_id) {
                $client_employee = new ClientEmployee();
                $client_employee->client_id = $client->id;
                $client_employee->employee_id = $employee_id;
                $client_employee->save();
            }
        }
    } elseif (auth()->user()->role === 'employee') {
        ClientEmployee::create([
            'client_id' => $client->id,
            'employee_id' => auth()->user()->employee_id,
        ]);
    }

    // تسجيل الإحداثيات
    $client->locations()->create([
        'latitude' => $latitude,
        'longitude' => $longitude,
    ]);

    $neighborhoodName = $this->getNeighborhoodFromGoogle($latitude, $longitude);
    $Neighborhood = new Neighborhood();
    $Neighborhood->name = $neighborhoodName ?? 'غير محدد';
    $Neighborhood->region_id = $request->region_id;
    $Neighborhood->client_id = $client->id;
    $Neighborhood->save();

    // إنشاء مستخدم جديد إذا تم توفير البريد الإلكتروني
    $password = Str::random(10);
    $full_name = $client->trade_name . ' ' . $client->first_name . ' ' . $client->last_name;
    if ($request->email != null) {
        User::create([
            'name' => $full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => 'client',
            'client_id' => $client->id,
            'password' => Hash::make($password),
        ]);
    }

    // تسجيل إشعار نظام جديد
    ModelsLog::create([
        'type' => 'client',
        'type_id' => $client->id,
        'type_log' => 'log',
        'description' => 'تم إضافة عميل **' . $client->trade_name . '**',
        'created_by' => auth()->id(),
    ]);

    // زيادة الرقم الحالي بمقدار 1
    if ($serialSetting) {
        $serialSetting->update(['current_number' => $currentNumber + 1]);
    }

    // إنشاء حساب فرعي باستخدام trade_name
    $customers = Account::where('name', 'العملاء')->first();
    if ($customers) {
        $customerAccount = new Account();
        $customerAccount->name = $client->trade_name;
        $customerAccount->client_id = $client->id;
        $customerAccount->balance += $client->opening_balance ?? 0;

        $lastChild = Account::where('parent_id', $customers->id)->orderBy('code', 'desc')->first();
        $newCode = $lastChild ? $this->generateNextCode($lastChild->code) : $customers->code . '1';

        while (\App\Models\Account::where('code', $newCode)->exists()) {
            $newCode = $this->generateNextCode($newCode);
        }

        $customerAccount->code = $newCode;
        $customerAccount->balance_type = 'debit';
        $customerAccount->parent_id = $customers->id;
        $customerAccount->is_active = false;
        $customerAccount->save();

        if ($client->opening_balance > 0) {
            $journalEntry = JournalEntry::create([
                'reference_number' => $client->code,
                'date' => now(),
                'description' => 'رصيد افتتاحي للعميل : ' . $client->trade_name,
                'status' => 1,
                'currency' => 'SAR',
                'client_id' => $client->id,
            ]);

            JournalEntryDetail::create([
                'journal_entry_id' => $journalEntry->id,
                'account_id' => $customerAccount->id,
                'description' => 'رصيد افتتاحي للعميل : ' . $client->trade_name,
                'debit' => $client->opening_balance ?? 0,
                'credit' => 0,
                'is_debit' => true,
            ]);
        }
    }

    // حفظ جهات الاتصال الإضافية المرتبطة بالعميل
    if ($request->has('contacts') && is_array($request->contacts)) {
        foreach ($request->contacts as $contact) {
            $client->contacts()->create($contact);
        }
    }

    return redirect()->route('clients.index')->with('success', '✨ تم إضافة العميل بنجاح!');
}
    public function send_email($id)
    {
        $employee = User::where('client_id', $id)->first();

        if (!$employee || empty($employee->email)) {
            return redirect()->back()->with('error', 'العميل لا يمتلك بريدًا إلكترونيًا للدخول.');
        }

        // توليد كلمة مرور جديدة عشوائية
        $newPassword = $this->generateRandomPassword();

        // تحديث كلمة المرور في قاعدة البيانات بعد تشفيرها
        $employee->password = Hash::make($newPassword);
        $employee->save();

        // إعداد بيانات البريد
        $details = [
            'name' => $employee->name,
            'email' => $employee->email,
            'password' => $newPassword, // إرسال كلمة المرور الجديدة مباشرة
        ];

        // إرسال البريد
        Mail::to($employee->email)->send(new TestMail($details));
        ModelsLog::create([
            'type' => 'hr_log',
            'type_id' => $employee->id, // ID النشاط المرتبط
            'type_log' => 'log', // نوع النشاط
            'description' => 'تم ارسال بيانات الدخول **' . $employee->name . '**',
            'created_by' => auth()->id(), // ID المستخدم الحالي
        ]);

        // return back()->with('message', 'تم إرسال البريد بنجاح!');
        return redirect()
            ->back()
            ->with(['success' => 'تم  ارسال البريد بنجاح .']);
    }
    private function generateRandomPassword($length = 10)
    {
        return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, $length);
    }

    protected function generateUniqueAccountCode($parentId, $parentCode)
    {
        $lastChild = Account::where('parent_id', $parentId)->orderBy('code', 'desc')->first();

        $baseCode = $lastChild ? (int) $lastChild->code + 1 : $parentCode . '001';

        $counter = 1;
        $newCode = $baseCode;

        while (Account::where('code', $newCode)->exists()) {
            $newCode = $baseCode . '_' . $counter;
            $counter++;

            if ($counter > 100) {
                throw new \RuntimeException('فشل توليد كود فريد');
            }
        }

        return $newCode;
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
        $rules = [
            'region_id' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ];

        $messages = [
            'region_id.required' => 'حقل المجموعة مطلوب.',
            'latitude.required' => 'العميل ليس لديه موقع مسجل الرجاء تحديد الموقع على الخريطة',
            'longitude.required' => 'العميل ليس لديه موقع مسجل الرجاء تحديد الموقع على الخريطة',
        ];

        $validated = $request->validate($rules, $messages);
        // بدء المعاملة لضمان سلامة البيانات
        DB::beginTransaction();

        try {
            $data_request = $request->except('_token', 'contacts');
            $client = Client::findOrFail($id);
            $oldData = $client->getOriginal();

            $latitude = $request->latitude ?? $client->latitude;
            $longitude = $request->longitude ?? $client->longitude;

            $data_request = $request->except('_token', 'contacts', 'latitude', 'longitude');
            $client->update($data_request);

            // حذف الموظفين السابقين فقط إذا كان المستخدم مدير
            if (auth()->user()->role === 'manager') {
                ClientEmployee::where('client_id', $client->id)->delete();

                if ($request->has('employee_client_id')) {
                    foreach ($request->employee_client_id as $employee_id) {
                        ClientEmployee::create([
                            'client_id' => $client->id,
                            'employee_id' => $employee_id,
                        ]);
                    }
                }
            } elseif (auth()->user()->role === 'employee') {
                $employee_id = auth()->user()->employee_id;

                // التحقق إذا هو أصلاً مسؤول
                $alreadyExists = ClientEmployee::where('client_id', $client->id)->where('employee_id', $employee_id)->exists();

                if (!$alreadyExists) {
                    ClientEmployee::create([
                        'client_id' => $client->id,
                        'employee_id' => $employee_id,
                    ]);
                }
            }

            // 1. معالجة المرفقات
            if ($request->hasFile('attachments')) {
                $file = $request->file('attachments');
                if ($file->isValid()) {
                    // حذف الملف القديم إن وجد
                    if ($client->attachments) {
                        $oldFilePath = public_path('assets/uploads/') . $client->attachments;
                        if (File::exists($oldFilePath)) {
                            File::delete($oldFilePath);
                        }
                    }

                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('assets/uploads/'), $filename);
                    $data_request['attachments'] = $filename;
                }
            }

            // 2. تحديث بيانات العميل الأساسية
            $client->update($data_request);

            // 3. معالجة الإحداثيات - الطريقة المؤكدة
            $client->locations()->delete(); // حذف جميع المواقع القديمة

            $client->locations()->create([
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'client_id' => $client->id,
            ]);

            $neighborhoodName = $this->getNeighborhoodFromGoogle($request->latitude, $request->longitude);

            // البحث عن الحي الحالي للعميل
            $Neighborhood = Neighborhood::where('client_id', $client->id)->first();

            if ($Neighborhood) {
                // إذا كان لديه حي، قم بتحديثه
                $Neighborhood->name = $neighborhoodName ?? 'غير محدد';
                $Neighborhood->region_id = $request->region_id;
                $Neighborhood->save();
            } else {
                // إذا لم يكن لديه حي، أضف حيًا جديدًا
                $Neighborhood = new Neighborhood();
                $Neighborhood->name = $neighborhoodName ?? 'غير محدد';
                $Neighborhood->region_id = $request->region_id;
                $Neighborhood->client_id = $client->id;
                $Neighborhood->save();
            }
            // 4. تحديث بيانات المستخدم
            if ($request->email) {
                $full_name = implode(' ', array_filter([$client->trade_name, $client->first_name, $client->last_name]));

                $userData = [
                    'name' => $full_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                ];

                $user = User::where('client_id', $client->id)->first();

                if ($user) {
                    $user->update($userData);
                } else {
                    $userData['password'] = Hash::make(Str::random(10));
                    $userData['role'] = 'client';
                    $userData['client_id'] = $client->id;
                    User::create($userData);
                }
            }

            // 6. معالجة جهات الاتصال
            if ($request->has('contacts')) {
                $existingContacts = $client->contacts->keyBy('id');
                $newContacts = collect($request->contacts);

                // الحذف
                $contactsToDelete = $existingContacts->diffKeys($newContacts->whereNotNull('id')->keyBy('id'));
                $client->contacts()->whereIn('id', $contactsToDelete->keys())->delete();

                // التحديث والإضافة
                foreach ($request->contacts as $contact) {
                    if (isset($contact['id']) && $existingContacts->has($contact['id'])) {
                        $existingContacts[$contact['id']]->update($contact);
                    } else {
                        $client->contacts()->create($contact);
                    }
                }
            }

            // 7. تسجيل العملية في السجل
            ModelsLog::create([
                'type' => 'client',
                'type_id' => $client->id,
                'type_log' => 'update',
                'description' => 'تم تحديث بيانات العميل: ' . $client->trade_name,
                'created_by' => auth()->id(),
                'old_data' => json_encode($oldData),
                'new_data' => json_encode($client->getAttributes()),
            ]);

            DB::commit();

            return redirect()->route('clients.index')->with('success', 'تم تحديث بيانات العميل بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', 'حدث خطأ أثناء التحديث: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit_question($id)
    {
        $client = Client::findOrFail($id);
        $employees = Employee::all();
        $branches = Branch::all();
        $location = Location::where('client_id', $id)->first();

        // جلب جميع المجموعات المتاحة
        $Regions_groub = Region_groub::all();

        return view('client.edit', compact('client', 'branches', 'employees', 'Regions_groub', 'location'));
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
        // تحميل العميل المحدد مع جميع العلاقات الضرورية
        $client = Client::with([
            'invoices' => function ($query) {
                $query->orderBy('invoice_date', 'desc');
            },
            'invoices.payments',
            'appointments' => function ($query) {
                $query->orderBy('appointment_date', 'desc');
            },
            'employee',
            'account',
            'payments' => function ($query) {
                $query->orderBy('payment_date', 'desc');
            },
            'appointmentNotes' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
            'visits.employee' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
        ])->findOrFail($id);

        // تحميل البيانات الإضافية
        $installment = Installment::with('invoice.client')->get();
        $employees = Employee::all();
        $account = Account::all();
        $statuses = Statuses::all();

        // تحميل الحجوزات والعضويات
        $bookings = Booking::where('client_id', $id)->get();
        $packages = Package::all();
        $memberships = Memberships::where('client_id', $id)->get();

        // تحميل الفواتير والمدفوعات
        $invoices = $client->invoices;
        $invoice_due = Invoice::where('client_id', $id)->sum('due_value');
        $due = Account::where('client_id', $id)->sum('balance');

        $payments = $client->payments()->orderBy('payment_date', 'desc')->get();

        // تحميل الملاحظات
        $appointmentNotes = $client->appointmentNotes;

        // تحميل الفئات والعلاقات الأخرى
        $categories = CategoriesClient::all();
        $ClientRelations = ClientRelation::where('client_id', $id)->get();
        $visits = $client->visits()->orderBy('created_at', 'desc')->get();

        // إنشاء كود جديد للعميل (إن وجد)
        do {
            $lastClient = Client::orderBy('code', 'desc')->first();
            $newCode = $lastClient ? $lastClient->code + 1 : 1;
        } while (Client::where('code', $newCode)->exists());

        $account_setting = AccountSetting::where('user_id', auth()->user()->id)->first();

        $account = Account::where('client_id', $id)->first();

        if (!$account) {
            return redirect()->back()->with('error', 'لا يوجد حساب مرتبط بهذا العميل.');
        }

        $accountId = $account->id;
        // جلب بيانات الخزينة
        $treasury = $this->getTreasury($accountId);
        $branches = $this->getBranches();

        // جلب العمليات المالية
        $transactions = $this->getTransactions($accountId);
        $transfers = $this->getTransfers($accountId);
        $expenses = $this->getExpenses($accountId);
        $revenues = $this->getRevenues($accountId);

        // معالجة العمليات وحساب الرصيد
        $allOperations = $this->processOperations($transactions, $transfers, $expenses, $revenues, $treasury);

        // ترتيب العمليات حسب التاريخ
        usort($allOperations, function ($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });

        // تقسيم العمليات إلى صفحات
        $operationsPaginator = $this->paginateOperations($allOperations);

        // إرسال البيانات إلى الواجهة

        return view('client.show', compact('client', 'treasury', 'account', 'operationsPaginator', 'branches', 'ClientRelations', 'visits', 'due', 'invoice_due', 'statuses', 'account', 'installment', 'employees', 'bookings', 'packages', 'memberships', 'invoices', 'payments', 'appointmentNotes', 'account_setting'));
    }
    public function updateStatus(Request $request, $id)
    {
        $client = Client::findOrFail($id);
        $client->notes = $request->notes; // تحديث الملاحظات بالحالة الجديدة
        $client->save();

        return response()->json(['success' => true]);
    }

    public function contact()
    {
        $clients = Client::all();

        return view('client.contacts.contact_mang', compact('clients'));
    }

    public function contacts(Request $request)
{
    $query = Client::query()->with(['employee', 'status']);

    // البحث الأساسي (يشمل جميع الحقول المهمة)
    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where(function ($q) use ($search) {
            $q->where('trade_name', 'like', '%' . $search . '%')
              ->orWhere('code', 'like', '%' . $search . '%')
              ->orWhere('first_name', 'like', '%' . $search . '%')
              ->orWhere('last_name', 'like', '%' . $search . '%')
              ->orWhere('phone', 'like', '%' . $search . '%')
              ->orWhere('mobile', 'like', '%' . $search . '%')
              ->orWhere('email', 'like', '%' . $search . '%')
              ->orWhereHas('employee', function($q) use ($search) {
                  $q->where('trade_name', 'like', '%' . $search . '%');
              })
              ->orWhereHas('status', function($q) use ($search) {
                  $q->where('name', 'like', '%' . $search . '%');
              });
        });
    }

    // البحث المتقدم (حسب الحقول المحددة)
    if ($request->filled('phone')) {
        $query->where('phone', 'like', '%' . $request->input('phone') . '%');
    }

    if ($request->filled('mobile')) {
        $query->where('mobile', 'like', '%' . $request->input('mobile') . '%');
    }

    if ($request->filled('email')) {
        $query->where('email', 'like', '%' . $request->input('email') . '%');
    }

    if ($request->filled('employee_id')) {
        $query->where('employee_id', $request->input('employee_id'));
    }

    if ($request->filled('status_id')) {
        $query->where('status_id', $request->input('status_id'));
    }

    if ($request->filled('city')) {
        $query->where('city', 'like', '%' . $request->input('city') . '%');
    }

    if ($request->filled('region')) {
        $query->where('region', 'like', '%' . $request->input('region') . '%');
    }

    $clients = $query->paginate(25)->withQueryString();

    $employees = Employee::all(); // لاستخدامها في dropdown الموظفين
    $statuses = Statuses::all(); // لاستخدامها في dropdown الحالات

    return view('client.contacts.contact_mang', compact('clients', 'employees', 'statuses'));
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
    public function mang_client(Request $request)
    {
        $clients = Client::with('latestStatus')->orderBy('created_at', 'desc')->get();
        $notes = AppointmentNote::with(['user'])
            ->latest()
            ->get();
        $appointments = Appointment::all();
        $employees = Employee::all();

        // Get the first client by default
        $client = $clients->first();

        $categories = CategoriesClient::all();
        $ClientRelations = ClientRelation::where('client_id', $request->client_id)->get();

        do {
            $lastClient = Client::orderBy('code', 'desc')->first();
            $newCode = $lastClient ? $lastClient->code + 1 : 1;
        } while (Client::where('code', $newCode)->exists());

        return view('client.relestion_mang_client', compact('clients', 'ClientRelations', 'categories', 'lastClient', 'newCode', 'employees', 'notes', 'appointments', 'client'));
    }
    public function getAllClients()
    {
        $clients = Client::with('latestStatus')->orderBy('created_at', 'desc')->get();
        return response()->json($clients);
    }
    public function getClientNotes($client_id)
    {
        try {
            $ClientRelations = ClientRelation::where('client_id', $client_id)->get();

            // التحقق من وجود ملاحظات
            if ($ClientRelations->isEmpty()) {
                return response()->json(['message' => 'لا توجد ملاحظات لهذا العميل.'], 200);
            }

            return response()->json($ClientRelations, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء جلب البيانات', 'details' => $e->getMessage()], 500);
        }
    }
    public function getNextClient(Request $request)
    {
        $currentClientId = $request->query('currentClientId');
        $nextClient = Client::where('id', '>', $currentClientId)->orderBy('id', 'asc')->first();

        if ($nextClient) {
            $nextClient->load('notes'); // تحميل الملاحظات المرتبطة
            return response()->json(['client' => $nextClient]);
        }

        return response()->json(['client' => null]);
    }
    public function updateOpeningBalance(Request $request, $id)
    {
        $client = Client::findOrFail($id);
        $client->opening_balance = $request->opening_balance;
        $client->save();

        $Account = Account::where('client_id', $id)->first();
        if ($Account) {
            $Account->balance += $client->opening_balance;
            $Account->save(); // حفظ التعديل في قاعدة البيانات
        }
        if ($client->opening_balance > 0) {
            $journalEntry = JournalEntry::create([
                'reference_number' => $client->code,
                'date' => now(),
                'description' => 'رصيد افتتاحي للعميل : ' . $client->trade_name,
                'status' => 1,
                'currency' => 'SAR',
                'client_id' => $client->id,
                // 'invoice_id' => $$client->id,
                // 'created_by_employee' => Auth::id(),
            ]);

            // // 1. حساب العميل (مدين)
            JournalEntryDetail::create([
                'journal_entry_id' => $journalEntry->id,
                'account_id' => $Account->id, // حساب العميل
                'description' => 'رصيد افتتاحي للعميل : ' . $client->trade_name,
                'debit' => $client->opening_balance ?? 0, // المبلغ الكلي للفاتورة (مدين)
                'credit' => 0,
                'is_debit' => true,
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function getPreviousClient(Request $request)
    {
        $currentClientId = $request->query('currentClientId');
        $previousClient = Client::where('id', '<', $currentClientId)->orderBy('id', 'desc')->first();

        if ($previousClient) {
            $previousClient->load('notes'); // تحميل الملاحظات المرتبطة
            return response()->json(['client' => $previousClient]);
        }

        return response()->json(['client' => null]);
    }
    public function getFirstClient()
    {
        $firstClient = Client::orderBy('id', 'asc')->first();
        if ($firstClient) {
            $firstClient->load('notes');
            return response()->json(['client' => $firstClient]);
        }
        return response()->json(['client' => null]);
    }

    public function mang_client_store(ClientRequest $request)
    {
        $data_request = $request->except('_token');

        // إنشاء العميل
        $client = new Client();

        // الحصول على الرقم الحالي لقسم العملاء من جدول serial_settings
        $serialSetting = SerialSetting::where('section', 'customer')->first();

        // إذا لم يتم العثور على إعدادات، نستخدم 1 كقيمة افتراضية
        $currentNumber = $serialSetting ? $serialSetting->current_number : 1;

        // تعيين id للعميل الجديد باستخدام الرقم الحالي
        // $client->id = $currentNumber;

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
            'description' => 'تم اضافة  عميل **' . $client->trade_name . '**',
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

        return redirect()->route('clients.mang_client')->with('success', '✨ تم إضافة العميل بنجاح!');
    }

    public function addnotes(Request $request)
{
    // التحقق من صحة البيانات
    $validated = $request->validate([
        'client_id' => 'required|exists:clients,id',
        'process' => 'required|string|max:255',
        'description' => 'required|string',
        'attachments' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
    ]);

    DB::beginTransaction();

    try {
        // الحصول على أحدث موقع للموظف
        $employeeLocation = Location::where('employee_id', auth()->id())
                                  ->latest()
                                  ->firstOrFail();

        // الحصول على موقع العميل
        $clientLocation = Location::where('client_id', $request->client_id)
                                ->latest()
                                ->firstOrFail();

        // حساب المسافة بين الموظف والعميل
        $lat1 = deg2rad($employeeLocation->latitude);
        $lon1 = deg2rad($employeeLocation->longitude);
        $lat2 = deg2rad($clientLocation->latitude);
        $lon2 = deg2rad($clientLocation->longitude);

        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;

        $a = sin($dlat / 2) ** 2 + cos($lat1) * cos($lat2) * sin($dlon / 2) ** 2;
        $c = 2 * asin(sqrt($a));
        $distance = (6371000 * $c) / 1000; // المسافة بالكيلومتر

        // التحقق من أن الموظف ضمن النطاق المسموح (0.3 كم)
        if ($distance > 0.3) {
            throw new \Exception('يجب أن تكون ضمن نطاق 0.3 كيلومتر من العميل! المسافة الحالية: ' . round($distance, 2) . ' كم');
        }

        // إنشاء الملاحظة
        $clientRelation = ClientRelation::create([
            'employee_id' => auth()->id(),
            'client_id' => $request->client_id,
            'status' => $request->status ?? 'pending',
            'process' => $request->process,
            'description' => $request->description,
            'location_id' => $employeeLocation->id
        ]);

        // معالجة المرفقات إن وجدت
        if ($request->hasFile('attachments')) {
            $file = $request->file('attachments');
            if ($file->isValid()) {
                $filename = time() . '_' . preg_replace('/[^a-z0-9\.]/i', '_', $file->getClientOriginalName());
                $file->move(public_path('assets/uploads/notes'), $filename);
                $clientRelation->attachments = $filename;
                $clientRelation->save();
            }
        }

        // ربط الموقع بالملاحظة
        $employeeLocation->update([
            'client_relation_id' => $clientRelation->id,
            'client_id' => $request->client_id
        ]);

        // تسجيل اشعار نظام
        ModelsLog::create([
            'type' => 'notes',
            'type_log' => 'log',
            'description' => 'تم اضافة ملاحظة **' . $request->description . '**',
            'created_by' => auth()->id(),
        ]);

        // إرسال الإشعارات
        $clientName = Client::findOrFail($request->client_id)->trade_name ?? 'عميل غير معروف';
        $userName = auth()->user()->name;

        notifications::create([
            'user_id' => auth()->id(),
            'type' => 'notes',
            'title' => $userName . ' أضاف ملاحظة لعميل',
            'description' => 'ملاحظة للعميل ' . $clientName . ' - ' . $request->description,

        ]);

        DB::commit();

        return redirect()
            ->route('clients.show', $request->client_id)
            ->with('success', 'تم إضافة الملاحظة بنجاح!');

    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()
            ->back()
            ->withErrors($e->validator)
            ->withInput();

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        DB::rollBack();
        return redirect()
            ->route('clients.show', $request->client_id ?? 0)
            ->with('error', 'لم يتم العثور على الموقع المطلوب!');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('فشل إضافة ملاحظة: ' . $e->getMessage() . "\n" . $e->getTraceAsString());

        return redirect()
            ->route('clients.show', $request->client_id ?? 0)
            ->with('error', 'حدث خطأ أثناء إضافة الملاحظة: ' . $e->getMessage());
    }
}
        /**
     * حساب المسافة باستخدام Haversine formula
     */
    private function calculateHaversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // نصف قطر الأرض بالمتر

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(
            pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)
        ));

        return $angle * $earthRadius;
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
    public function updateStatusClient(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'status_id' => 'required|exists:statuses,id',
        ]);

        // البحث عن العميل وتحديث حالته مباشرة
        $client = Client::findOrFail($request->client_id);
        $client->status_id = $request->status_id;
        $client->save();

        return redirect()->back()->with('success', 'تم تغيير حالة العميل بنجاح.');
    }

    public function statement($id)
    {
        $client = Client::find($id);

        $account = Account::where('client_id', $id)->first();

        if (!$account) {
            return redirect()->back()->with('error', 'لا يوجد حساب مرتبط بهذا العميل.');
        }

        $accountId = $account->id;
        // جلب بيانات الخزينة
        $treasury = $this->getTreasury($accountId);
        $branches = $this->getBranches();

        // جلب العمليات المالية
        $transactions = $this->getTransactions($accountId);
        $transfers = $this->getTransfers($accountId);
        $expenses = $this->getExpenses($accountId);
        $revenues = $this->getRevenues($accountId);

        // معالجة العمليات وحساب الرصيد
        $allOperations = $this->processOperations($transactions, $transfers, $expenses, $revenues, $treasury);

        // ترتيب العمليات حسب التاريخ
        usort($allOperations, function ($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });

        // تقسيم العمليات إلى صفحات
        $operationsPaginator = $this->paginateOperations($allOperations);

        // إرسال البيانات إلى الواجهة
        return view('client.statement', compact('treasury', 'account', 'operationsPaginator', 'branches', 'client'));
    }
    private function getTreasury($id)
    {
        return Account::findOrFail($id);
    }

    private function getBranches()
    {
        return Branch::all();
    }

    private function getTransactions($id)
    {
        return JournalEntryDetail::where('account_id', $id)
            ->with([
                'journalEntry' => function ($query) {
                    $query->with('invoice', 'client');
                },
            ])
            ->orderBy('created_at', 'asc')
            ->get();
    }

    private function getTransfers($id)
    {
        return JournalEntry::whereHas('details', function ($query) use ($id) {
            $query->where('account_id', $id);
        })
            ->with(['details.account'])
            ->where('description', 'تحويل المالية')
            ->orderBy('created_at', 'asc')
            ->get();
    }

    private function getExpenses($id)
    {
        return Expense::where('treasury_id', $id)
            ->with(['expenses_category', 'vendor', 'employee', 'branch', 'client'])
            ->orderBy('created_at', 'asc')
            ->get();
    }

    private function getRevenues($id)
    {
        return Revenue::where('treasury_id', $id)
            ->with(['account', 'paymentVoucher', 'treasury', 'bankAccount', 'journalEntry'])
            ->orderBy('created_at', 'asc')
            ->get();
    }

    private function processOperations($transactions, $transfers, $expenses, $revenues, $treasury)
    {
        $currentBalance = 0;
        $allOperations = [];

        // معالجة المدفوعات
        foreach ($transactions as $transaction) {
            $amount = $transaction->debit > 0 ? $transaction->debit : $transaction->credit;
            $type = $transaction->debit > 0 ? 'إيداع' : 'سحب';

            $currentBalance = $this->updateBalance($currentBalance, $amount, $type);

            $allOperations[] = [
                'operation' => $transaction->description,
                'deposit' => $type === 'إيداع' ? $amount : 0,
                'withdraw' => $type === 'سحب' ? $amount : 0,
                'balance_after' => $currentBalance,

                'journalEntry' => $transaction->journalEntry->id,
                'date' => $transaction->journalEntry->date,
                'invoice' => $transaction->journalEntry->invoice,
                'client' => $transaction->journalEntry->client,
                'type' => 'transaction',
            ];
        }

        // معالجة التحويلات
        // foreach ($transfers as $transfer) {
        //     $amount = $transfer->details->sum('debit');
        //     $fromAccount = $transfer->details->firstWhere('is_debit', true)->account;
        //     $toAccount = $transfer->details->firstWhere('is_debit', false)->account;

        //     if ($fromAccount->id == $treasury->id) {
        //         $currentBalance -= $amount;
        //         $operationText = 'تحويل مالي إلى ' . $toAccount->name;
        //     } else {
        //         $currentBalance += $amount;
        //         $operationText = 'تحويل مالي من ' . $fromAccount->name;
        //     }

        //     $allOperations[] = [
        //         'operation' => $operationText,
        //         'deposit' => $fromAccount->id != $treasury->id ? $amount : 0,
        //         'withdraw' => $fromAccount->id == $treasury->id ? $amount : 0,
        //         'balance_after' => $currentBalance,
        //         'date' => $transfer->date,
        //         'invoice' => null,
        //         'client' => null,
        //         'type' => 'transfer',
        //     ];
        // }

        // معالجة سندات الصرف
        foreach ($expenses as $expense) {
            $currentBalance -= $expense->amount;

            $allOperations[] = [
                'operation' => 'سند صرف: ' . $expense->description,
                'deposit' => 0,
                'withdraw' => $expense->amount,
                'balance_after' => $currentBalance,
                'date' => $expense->date,
                'invoice' => null,
                'client' => $expense->client,
                'type' => 'expense',
            ];
        }

        // معالجة سندات القبض
        foreach ($revenues as $revenue) {
            $currentBalance += $revenue->amount;

            $allOperations[] = [
                'operation' => 'سند قبض: ' . $revenue->description,
                'deposit' => $revenue->amount,
                'withdraw' => 0,
                'balance_after' => $currentBalance,
                'date' => $revenue->date,
                'invoice' => null,
                'client' => null,
                'type' => 'revenue',
            ];
        }

        return $allOperations;
    }

    private function updateBalance($currentBalance, $amount, $type)
    {
        return $type === 'إيداع' ? $currentBalance + $amount : $currentBalance - $amount;
    }

    private function paginateOperations($allOperations)
    {
        $perPage = 15;
        $currentPage = request()->get('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $paginatedOperations = array_slice($allOperations, $offset, $perPage);

        return new \Illuminate\Pagination\LengthAwarePaginator($paginatedOperations, count($allOperations), $perPage, $currentPage, [
            'path' => request()->url(),
            'query' => request()->query(),
        ]);
    }
}
