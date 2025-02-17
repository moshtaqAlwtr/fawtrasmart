<?php

namespace App\Http\Controllers\InsuranceAgents;

use App\Http\Controllers\Controller;
use App\Models\InsuranceAgent;
use App\Models\InsuranceAgentCategory;
use Illuminate\Http\Request;

class InsuranceAgentsController extends Controller
{
    public function index(Request $request)
{
    // جلب وكلاء التأمين من قاعدة البيانات مع تطبيق البحث
    $query = InsuranceAgent::query();

    // تحقق مما إذا كان هناك اسم وكيل للبحث
    if ($request->filled('agent-name')) {
        $query->where('name', 'like', '%' . $request->input('agent-name') . '%');
    }

    // تحقق مما إذا كانت هناك حالة للبحث
    if ($request->filled('status')) {
        $status = $request->input('status') == 'active' ? 1 : 2; // تحويل الحالة إلى قيمة صحيحة
        $query->where('status', $status);
    }

    $insuranceAgents = $query->get(); // تنفيذ الاستعلام

    return view('Insurance_Agents.index', compact('insuranceAgents'));
}
    public function create()
    {
        $categories = InsuranceAgentCategory::all(); // جلب جميع الفئات
        return view('Insurance_Agents.create', compact('categories'));
    }
    public function store(Request $request)
    {
        // التحقق من البيانات المدخلة
        $request->validate([
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'location' => 'nullable|string|max:255',
            'status' => 'nullable|integer',
            'attachments' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // قيود المرفقات
            'categories' => 'array', // تأكد من أن الفئات عبارة عن مصفوفة
        ]);

        // تخزين البيانات في قاعدة البيانات
        $insuranceAgent = InsuranceAgent::create($request->except('attachments', 'categories')); // استبعاد المرفقات والفئات من التخزين المباشر

        // معالجة المرفقات
        if ($request->hasFile('attachments')) {
            $file = $request->file('attachments');
            if ($file->isValid()) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('assets/uploads/insuranceAgents'), $filename);
                $insuranceAgent->attachments = $filename;
                $insuranceAgent->save(); // حفظ المرفقات في قاعدة البيانات
            }
        }

        // تخزين الفئات المرتبطة
        if ($request->filled('categories')) {
            foreach ($request->categories as $categoryId) {
                // تأكد من أن لديك علاقة بين InsuranceAgent و InsuranceAgentCategory
                $insuranceAgent->categories()->attach($categoryId);
            }
        }

        // إعادة توجيه مع رسالة نجاح
        return redirect()->route('InsuranceAgentsClass.create', ['insurance_agent_id' => $insuranceAgent->id])->with('success', 'تم إضافة وكيل التأمين بنجاح!');
    }
    public function edit($id)
    {
        // ��لب وكيل التأمين بوا��طة ال�� id
        $insuranceAgent = InsuranceAgent::findOrFail($id);

        // ��رجا�� ��لب تعريف الوكيل التأمين
        return view('Insurance_Agents.edit', compact('insuranceAgent'));
    }

    // دالة لتحديث البيانات
    public function update(Request $request, $id)
    {
        // التحقق من البيانات المدخلة
        $request->validate([
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'location' => 'nullable|string|max:255',
            'status' => 'nullable|integer',
            'attachments' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', // مثال على قيود المرفقات
        ]);

        // العثور على وكيل التأمين وتحديثه
        $insuranceAgent = InsuranceAgent::findOrFail($id);
        $insuranceAgent->update($request->all());

        // إعادة توجيه مع رسالة نجاح
        return redirect()->route('InsuranceAgentsClass.index')->with('success', 'تم تحديث وكيل التأمين بنجاح!');
    }

    // دالة لحذف الوكيل التأمين
    public function destroy($id)
    {
        $insuranceAgent = InsuranceAgent::findOrFail($id);
        $insuranceAgent->delete();

        return redirect()->route('Insurance_Agents.index')->with('success', 'تم حذف وكيل التأمين بنجاح!');
    }
}
