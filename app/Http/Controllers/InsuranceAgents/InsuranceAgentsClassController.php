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
        $validatedData = $request->validate([
            'insurance_agent_id' => 'required|exists:insurance_agents,id',
            'name' => 'required|string|max:255',
            'category_id.*' => 'required|exists:categories,id',
            'discount.*' => 'required|numeric',
            'company_copayment.*' => 'required|numeric',
            'client_copayment.*' => 'required|numeric',
            'max_copayment.*' => 'required|numeric',
            'type.*' => 'required|in:1,2',
        ]);

        // Loop through each row of data and save it
        for ($i = 0; $i < count($request->category_id); $i++) {
            // Create a new entry based on the validated data
            InsuranceAgentCategory::create([
                'insurance_agent_id' => $validatedData['insurance_agent_id'],
                'name' => $validatedData['name'],
                'category_id' => $validatedData['category_id'][$i],
                'discount' => $validatedData['discount'][$i],
                'company_copayment' => $validatedData['company_copayment'][$i],
                'client_copayment' => $validatedData['client_copayment'][$i],
                'max_copayment' => $validatedData['max_copayment'][$i],
                'type' => $validatedData['type'][$i],
            ]);
        }

        return redirect()->route('Insurance_Agents.index')->with('success', 'Data saved successfully!');
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
