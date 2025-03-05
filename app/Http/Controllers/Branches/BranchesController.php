<?php

namespace App\Http\Controllers\Branches;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\BranchSetting;
use App\Models\BranchSettingBranch;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;

class BranchesController extends Controller
{
    // عرض جميع الفروع
    public function index()
    {
        // استرجاع جميع الفروع
        $branches = Branch::all();

        // عرض صفحة الفروع مع البيانات
        return view('branches.index', compact('branches'));
    }

    // عرض نموذج إضافة فرع جديد
    public function create()
    {
        // عرض صفحة إضافة فرع
        return view('branches.create');
    }
    public function switchBranch($branchId)
    {
        $user = auth()->user();

        // التحقق مما إذا كان المستخدم ليس موظفًا ويمكنه تغيير الفرع
        if ($user->role !== 'employee') {
            // تحديث branch_id في جدول المستخدم
            $user->update(['branch_id' => $branchId]);

            // حفظ الفرع في الجلسة (لضمان بقاء المستخدم في الفرع المحدد)
            session(['current_branch_id' => $branchId]);
        }

        return redirect()->back(); // إعادة التوجيه إلى الصفحة السابقة
    }


    // تخزين بيانات الفرع
    public function store(Request $request)
    {
        // التحقق من صحة البيانات المدخلة
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string',
            'mobile' => 'nullable|string',
            'address1' => 'required|string|max:255',
            'address2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'region' => 'nullable|string|max:255',
            'country' => 'required|string|max:255',
            'work_hours' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'location' => 'nullable|string|max:255',
        ]);

        // توليد الكود تلقائيًا
        $lastBranch = Branch::latest('id')->first();
        $newCode = $lastBranch ? str_pad($lastBranch->id + 1, 5, '0', STR_PAD_LEFT) : '00001';

        // دمج الكود مع باقي البيانات
        $branchData = $request->all();
        $branchData['code'] = $newCode;

        // إنشاء الفرع
        Branch::create($branchData);

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('branches.index')->with('success', 'تم إضافة الفرع بنجاح');
    }

    // عرض تفاصيل الفرع
    public function show($id)
    {
        // استرجاع الفرع بواسطة الـ id
        $branch = Branch::findOrFail($id);

        // عرض صفحة التفاصيل
        return view('branches.show', compact('branch'));
    }

    // عرض نموذج تعديل الفرع
    public function edit($id)
    {
        // استرجاع الفرع بواسطة الـ id
        $branch = Branch::findOrFail($id);

        // عرض صفحة التعديل
        return view('branches.edit', compact('branch'));
    }

    // تحديث بيانات الفرع
    public function update(Request $request, $id)
    {
        // التحقق من صحة البيانات المدخلة
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:branches,code,' . $id,
            'phone' => 'nullable|string',
            'mobile' => 'nullable|string',
            'address1' => 'required|string|max:255',
            'address2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'region' => 'nullable|string|max:255',
            'country' => 'required|string|max:255',
            'work_hours' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'location' => 'nullable|string|max:255',
        ]);

        // استرجاع الفرع بواسطة الـ id
        $branch = Branch::findOrFail($id);

        // تحديث البيانات
        $branch->update($request->all());

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('branches.index')->with('success', 'تم تحديث بيانات الفرع بنجاح');
    }

    // حذف الفرع
    public function destroy($id)
    {
        // حذف الفرع بواسطة الـ id
        Branch::destroy($id);

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('branches.index')->with('success', 'تم حذف الفرع بنجاح');
    }

    // عرض صفحة الإعدادات (اختياري)
    public function settings(Request $request)
    {
        // الحصول على جميع الفروع
        $branchs = Branch::all();
    
        // إذا كان هناك فرع مختار من الطلب، نستخدمه
        // إذا لم يكن هناك فرع مختار، نستخدم أول فرع في قاعدة البيانات
        $selectedBranchId = $request->input('branch_id', $branchs->first()->id ?? null);
    
        $settings = []; // تعيين مصفوفة فارغة للصلاحيات
    
        if ($selectedBranchId) {
            // جلب الفرع المحدد مع الصلاحيات المرتبطة به وحالة التفعيل
            $branch = Branch::with('settings')->find($selectedBranchId);
    
            if ($branch) {
                // تحويل الصلاحيات إلى تنسيق مناسب للعرض مع حالتها
                foreach ($branch->settings as $setting) {
                    $settings[$setting->key] = $setting->pivot->status; // استخدام الـ pivot للحصول على حالة الصلاحية
                }
            }
        }
    
        // تمرير البيانات إلى الـ view
        return view('branches.settings', compact('branchs', 'settings', 'selectedBranchId'));
    }
    
    
    
    

    public function settings_store(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
        ]);
    
        // جلب ID الفرع
        $branch_id = $request->branch_id;
    
        // الصلاحيات المتاحة
        $permissions = [
            'share_cost_center',
            'share_customers',
            'share_products',
            'share_suppliers',
            'account_tree'
        ];
    
        foreach ($permissions as $permission) {
            // التحقق من حالة الصلاحية: إذا كانت مفعلّة أو غير مفعلّة
            $status = $request->has($permission) ? 1 : 0;
    
            // تحديث أو إضافة الصلاحية في الجدول الوسيط
            BranchSettingBranch::updateOrCreate(
                [
                    'branch_id' => $branch_id,
                    'branch_setting_id' => BranchSetting::where('key', $permission)->value('id')
                ],
                ['status' => $status]
            );
        }
              return back();
        // إرجاع رسالة نجاح
        // return response()->json(['message' => 'تم تحديث الصلاحيات بنجاح']);
    }
    
    public function getSettings(Request $request)
    {
        $selectedBranchId = $request->input('branch_id');
        $settings = [];
    
        if ($selectedBranchId) {
            // جلب الفرع المحدد مع الصلاحيات المرتبطة به
            $branch = Branch::with('settings')->find($selectedBranchId);
    
            if ($branch) {
                foreach ($branch->settings as $setting) {
                    $settings[] = [
                        'key' => $setting->key,
                        'name' => $setting->name,
                        'status' => $setting->pivot->status,
                    ];
                }
            }
        }
    
        return response()->json(['settings' => $settings]);
    }
    
    


    public function updateStatus($id)
    {
        $brabch = Branch::findOrFail($id);
        $status = $brabch->status;
        if ($status == 0) {
            $brabch->update(['status' => 1]);
        } else {
            $brabch->update(['status' => 0]);
        }

        return redirect()->route('branches.index')->with('success', 'تم تحديث حالة الفرع بنجاح');
    }
}
