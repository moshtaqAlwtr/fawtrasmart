<?php
namespace App\Http\Controllers\Branches;

use App\Http\Controllers\Controller;
use App\Models\Branch;
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
    public function settings()
    {
        return view('branches.settings');
    }
    public function updateStatus($id){
        $brabch = Branch::findOrFail($id);
        $status = $brabch->status;
        if($status == 0){
            $brabch->update(['status' => 1]);
        }
        else{
            $brabch->update(['status' => 0]);
        }
        
        return redirect()->route('branches.index')->with('success', 'تم تحديث حالة الفرع بنجاح');
    }
}
