<?php

namespace App\Http\Controllers\Purchases;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierRequest;
use App\Models\Account;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Log as ModelsLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SupplierManagementController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();
        $query = Supplier::query();

        // جلب المستخدم الحالي
        $user = auth()->user();

        // التحقق مما إذا كان للمستخدم فرع أم لا
        if ($user->branch) {
            $branch = $user->branch;

            // التحقق من صلاحية "مشاركة الموردين"
            $shareSuppliersStatus = $branch->settings()->where('key', 'share_suppliers')->first();

            // إذا كانت الصلاحية موقوفة، عرض الموردين الذين أضافهم المستخدمون من نفس الفرع فقط
            if ($shareSuppliersStatus && $shareSuppliersStatus->pivot->status == 0) {
                $query->whereHas('creator', function ($q) use ($branch) {
                    $q->where('branch_id', $branch->id);
                });
            }
        }

        // البحث بواسطة اسم المورد أو الرقم التعريفي
        if ($request->filled('employee_search')) {
            $query->where('id', $request->employee_search)
                ->orWhere('trade_name', 'LIKE', '%' . $request->employee_search . '%');
        }

        // البحث برقم المورد
        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }

        // البحث بالبريد الإلكتروني
        if ($request->filled('email')) {
            $query->where('email', 'LIKE', '%' . $request->email . '%');
        }

        // البحث برقم الجوال
        if ($request->filled('end_date_from')) {
            $query->where('mobile', 'LIKE', '%' . $request->end_date_from . '%');
        }

        // البحث برقم الهاتف
        if ($request->filled('end_date_to')) {
            $query->where('phone', 'LIKE', '%' . $request->end_date_to . '%');
        }

        // البحث بالرمز البريدي
        if ($request->filled('postal_code')) {
            $query->where('postal_code', 'LIKE', '%' . $request->postal_code . '%');
        }

        // البحث بالعملة
        if ($request->filled('currency')) {
            $query->where('currency', $request->currency);
        }

        // البحث بالحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // البحث بالرقم الضريبي
        if ($request->filled('tax_number')) {
            $query->where('tax_number', 'LIKE', '%' . $request->tax_number . '%');
        }

        // البحث بالسجل التجاري
        if ($request->filled('commercial_registration')) {
            $query->where('commercial_registration', 'LIKE', '%' . $request->commercial_registration . '%');
        }

        // البحث بواسطة المستخدم الذي أضاف
        if ($request->filled('created_by')) {
            $query->where('created_by', $request->created_by);
        }

        // جلب الموردين مع الترتيب والتصفية
        $suppliers = $query->latest()->paginate(10);

        // للحفاظ على parameters البحث في روابط الترقيم
        $suppliers->appends($request->all());

        return view('purchases.supplier_management.index', compact('suppliers', 'users'));
    }


    public function create()
    {
        $lastSupplier = Supplier::orderBy('id', 'desc')->first();
        $nextNumber = $lastSupplier ? $lastSupplier->id + 1 : 1;

        return view('purchases.supplier_management.create', compact('nextNumber'));
    }

    public function store(SupplierRequest $request)
    {
        try {
            DB::beginTransaction();

            // التحقق من البيانات
            $validated = $request->validated();
            $nextNumber = Supplier::max('id') + 1;

            // إنشاء المورد
            $supplier = Supplier::create(
                array_merge($validated, [
                    'number_suply' => $nextNumber,
                    'created_by' => auth()->id(),
                ]),
            );

            $suppliers = Account::where('name', 'الموردون')->first(); // الحصول على حساب العملاء الرئيسي
    if ($suppliers) {
        $customerAccount = new Account();
        $customerAccount->name = $supplier->trade_name; // استخدام trade_name كاسم الحساب
        $customerAccount->supplier_id = $supplier->id;

        // تعيين كود الحساب الفرعي بناءً على كود الحسابات
        $lastChild = Account::where('parent_id', $suppliers->id)->orderBy('code', 'desc')->first();
        $newCode = $lastChild ? $this->generateNextCode($lastChild->code) : $suppliers->code . '1'; // استخدام نفس منطق توليد الكود
        $customerAccount->code = $newCode; // تعيين الكود الجديد للحساب الفرعي

        $customerAccount->balance_type = 'credit'; // أو 'credit' حسب الحاجة
        $customerAccount->parent_id = $suppliers->id; // ربط الحساب الفرعي بحساب العملاء
        $customerAccount->is_active = false;
        $customerAccount->save();
    }
            // معالجة المرفقات
            $this->handleAttachment($request, $supplier);

            // إضافة جهات الاتصال
            $this->addContacts($request, $supplier);

 // تسجيل اشعار نظام جديد
                ModelsLog::create([
                        'type' => 'purchase_log',
                      'type_id' =>  $supplier->id, // ID النشاط المرتبط
                      'type_log' => 'log', // نوع النشاط
                      'description' => 'تم اضافة مورد جديد **' . $supplier->trade_name . '**',
                      'created_by' => auth()->id(), // ID المستخدم الحالي
                  ]);
            DB::commit();

            return redirect()->route('SupplierManagement.index')->with('success', 'تم إضافة المورد بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }
    private function generateNextCode(string $lastChildCode): string
{
    // استخراج الرقم الأخير من الكود
    $lastNumber = intval(substr($lastChildCode, -1));
    // زيادة الرقم الأخير بمقدار 1
    $newNumber = $lastNumber + 1;
    // إعادة بناء الكود مع الرقم الجديد
    return substr($lastChildCode, 0, -1) . $newNumber;
}

    public function show($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('purchases.supplier_management.show', compact('supplier'));
    }
    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);

        $nextNumber = Supplier::max('id');
        return view('purchases.supplier_management.edit', compact('supplier', 'nextNumber'));
    }
    public function update(SupplierRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $supplier = Supplier::findOrFail($id);
            $validated = $request->validated();

            // معالجة الحقول التي لا تقبل NULL
            $validated['opening_balance'] = $validated['opening_balance'] ?? 0;
            $validated['currency'] = $validated['currency'] ?? 'SAR'; // القيمة الافتراضية للعملة
            $validated['updated_by'] = auth()->id();

            // الاحتفاظ بالقيم القديمة إذا كانت الجديدة فارغة
            foreach ($validated as $key => $value) {
                if (is_null($value) && $supplier->$key) {
                    $validated[$key] = $supplier->$key;
                }
            }

            // تحديث البيانات
            $supplier->fill($validated);
            $supplier->save();

            // معالجة المرفقات
            if ($request->hasFile('attachments')) {
                $this->handleAttachment($request, $supplier);
            }

            // تحديث جهات الاتصال
            if ($request->has('contacts')) {
                $supplier->contacts()->delete();
                $this->addContacts($request, $supplier);
            }
             ModelsLog::create([
                        'type' => 'purchase_log',
                      'type_id' =>  $supplier->id, // ID النشاط المرتبط
                      'type_log' => 'log', // نوع النشاط
                      'description' => 'تم اضافة مورد جديد **' . $supplier->name . '**',
                      'created_by' => auth()->id(), // ID المستخدم الحالي
                  ]);

            DB::commit();
            return redirect()->route('SupplierManagement.index')->with('success', 'تم تحديث المورد بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Supplier Update Error: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * معالجة المرفقات للمورد
     */

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
           ModelsLog::create([
                        'type' => 'purchase_log',
                      'type_id' =>  $supplier->id, // ID النشاط المرتبط
                      'type_log' => 'log', // نوع النشاط
                      'description' => 'تم حذف المورد  **' . $supplier->trade_name . '**',
                      'created_by' => auth()->id(), // ID المستخدم الحالي
                  ]);
        $supplier->delete();
        return redirect()->route('SupplierManagement.index')->with('success', 'تم حذف المورد بنجاح');
    }

    private function handleAttachment(Request $request, Supplier $supplier)
    {
        if ($request->hasFile('attachments')) {
            $file = $request->file('attachments');
            if ($file->isValid()) {
                // حذف الملف القديم إذا كان موجودًا
                if ($supplier->attachments && file_exists(public_path('assets/uploads/suppliers/' . $supplier->attachments))) {
                    unlink(public_path('assets/uploads/suppliers/' . $supplier->attachments));
                }

                // رفع الملف الجديد
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('assets/uploads/suppliers'), $filename);
                $supplier->attachments = $filename;
                $supplier->save();
            }
        }
    }

    /**
     * إضافة جهات الاتصال للمورد
     */
    private function addContacts(Request $request, Supplier $supplier)
    {
        if ($request->has('contacts') && is_array($request->contacts)) {
            foreach ($request->contacts as $contact) {
                if (!empty($contact['first_name'])) {
                    $supplier->contacts()->create([
                        'first_name' => $contact['first_name'],
                        'last_name' => $contact['last_name'] ?? null,
                        'phone' => $contact['phone'] ?? null,
                        'mobile' => $contact['mobile'] ?? null,
                        'email' => $contact['email'] ?? null,
                    ]);
                }
            }
        }
    }
}
