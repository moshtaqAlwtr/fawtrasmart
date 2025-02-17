<?php

namespace App\Http\Controllers\InsuranceAgents;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\InsuranceAgentCategory;
use Illuminate\Http\Request;

class InsuranceAgentsClassController extends Controller
{
    public function create($insurance_agent_id)
    {
        $categories = Category::all(); // جلب جميع الفئات
        return view('insurance_agents.insurance_agent_classes.create', compact('categories', 'insurance_agent_id'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'insurance_agent_id' => 'required|exists:insurance_agents,id',
            'discount' => 'nullable|numeric',
            'company_copayment' => 'nullable|numeric',
            'client_copayment' => 'nullable|numeric',
            'max_copayment' => 'nullable|numeric',
            'status' => 'nullable|integer',
            'type' => 'nullable|integer',
        ]);

        InsuranceAgentCategory::create([
            'category_id' => $request->category_id,
            'insurance_agent_id' => $request->insurance_agent_id,
            'discount' => $request->discount,
            'company_copayment' => $request->company_copayment,
            'client_copayment' => $request->client_copayment,
            'max_copayment' => $request->max_copayment,
            'status' => $request->status,
            'type' => $request->type,
        ]);

        return redirect()->route('Insurance_Agents.index')->with('success', 'تم إضافة الفئة بنجاح!');
    }

    public function update(Request $request, $id)
    {
        // التحقق من البيانات المدخلة
        $request->validate([
            'category_id' => 'nullable|exists:categories,id', // التحقق من وجود التصنيف
            'insurance_agent_id' => 'nullable|exists:insurance_agents,id', // التحقق من وجود وكيل التأمين
            'discount' => 'nullable|numeric',
            'company_copayment' => 'nullable|numeric',
            'client_copayment' => 'nullable|numeric',
            'max_copayment' => 'nullable|numeric',
            'status' => 'nullable|integer',
            'type' => 'nullable|integer',
        ]);

        // العثور على الفئة وتحديثها
        $insuranceAgentCategory = InsuranceAgentCategory::findOrFail($id);
        $insuranceAgentCategory->update($request->all());

        // إعادة توجيه مع رسالة نجاح
        return redirect()->route('Insurance_Agents.index')->with('success', 'تم تحديث الفئة بنجاح!');
    }
}
