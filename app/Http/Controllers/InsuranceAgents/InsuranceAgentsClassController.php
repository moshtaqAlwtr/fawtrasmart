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
    public function edit($id)
{
    // Fetch the insurance agent category by ID
    $insuranceAgentCategory = InsuranceAgentCategory::findOrFail($id);

    // Fetch all categories
    $categories = Category::all(); // جلب جميع الفئات

    // Fetch the insurance agent ID from the insurance agent category
    $insurance_agent_id = $insuranceAgentCategory->insurance_agent_id; // Assuming you have this field

    // Pass both the insurance agent category, categories, and insurance agent ID to the view
    return view('insurance_agents.insurance_agent_classes.edit', compact('insuranceAgentCategory', 'categories', 'insurance_agent_id'));
}
    public function update(Request $request, $id)
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

        // Loop through each row of data and update it
        for ($i = 0; $i < count($request->category_id); $i++) {
            // Check if the entry already exists
            $insuranceAgentCategory = InsuranceAgentCategory::where('insurance_agent_id', $validatedData['insurance_agent_id'])->where('category_id', $validatedData['category_id'][$i])->first();

            if ($insuranceAgentCategory) {
                // Update the existing entry
                $insuranceAgentCategory->update([
                    'name' => $validatedData['name'],
                    'discount' => $validatedData['discount'][$i],
                    'company_copayment' => $validatedData['company_copayment'][$i],
                    'client_copayment' => $validatedData['client_copayment'][$i],
                    'max_copayment' => $validatedData['max_copayment'][$i],
                    'type' => $validatedData['type'][$i],
                ]);
            } else {
                // Create a new entry if it doesn't exist
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
        }

        return redirect()->route('Insurance_Agents.show', $validatedData['insurance_agent_id'])->with('success', 'Data updated successfully!');
    }
    public function show($id)
    {
        // Fetch the insurance agent category by ID
        $insuranceAgentCategory = InsuranceAgentCategory::findOrFail($id);

        // Fetch the associated insurance agent
        $insuranceAgent = $insuranceAgentCategory->insuranceAgent; // Assuming you have a relationship defined

        // Fetch all categories related to the insurance agent
        $categories = InsuranceAgentCategory::where('insurance_agent_id', $insuranceAgent->id)->get();

        // Pass both variables to the view
        return view('insurance_agents.insurance_agent_classes.show', compact('insuranceAgentCategory', 'insuranceAgent', 'categories'));
    }

    public function destroy($id)
    {
        $insuranceAgentCategory = InsuranceAgentCategory::findOrFail($id);
        $insuranceAgentCategory->delete();

        return redirect()->route('Insurance_Agents.show', $insuranceAgentCategory->insurance_agent_id)->with('success', 'Data deleted successfully!');
    }
}
