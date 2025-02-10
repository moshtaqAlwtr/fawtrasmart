<?php

namespace App\Http\Controllers\Salaries;

use App\Http\Controllers\Controller;
use App\Models\Account;

use App\Models\SalaryItem;
use App\Models\SalaryTemplate;
use Illuminate\Http\Request;

class SalaryItemsController extends Controller
{
    public function index(Request $request)
    {
        $query = SalaryItem::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $salaryItems = $query->paginate(10);
        return view('salaries.salary_items.index', compact('salaryItems'));
    }

    public function create()
    {
        $accounts = Account::all();
        $salaryItems = SalaryItem::all();

        return view('salaries.salary_items.create', compact('accounts', 'salaryItems'));
    }
    public function show($id)
    {
        $salaryItem = SalaryItem::findOrFail($id);
        return view('salaries.salary_items.show', compact('salaryItem'));
    }
    public function edit($id)
    {
        $salaryItem = SalaryItem::findOrFail($id);
        $accounts = Account::all();
        return view('salaries.salary_items.edit', compact('employees', 'salaryItem', 'accounts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:1,2',
            'status' => 'required|in:1,2,3',
            'description' => 'nullable|string',
            'salary_item_value' => 'required|in:1,2',
            'amount' => 'nullable|numeric|required_if:salary_item_value,1',
            'calculation_formula' => 'nullable|string|required_if:salary_item_value,2',
            'condition' => 'nullable|string',
            'account_id' => 'required|exists:accounts,id',
        ]);

        try {
            SalaryItem::create($validated);


            return redirect()->route('SalaryItems.index')->with('success', 'تم إضافة بند الراتب بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء إضافة بند الراتب')->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:1,2',
            'status' => 'required|in:1,2,3',
            'description' => 'nullable|string',
            'salary_item_value' => 'required|in:1,2',
            'amount' => 'nullable|numeric|required_if:salary_item_value,1',
            'calculation_formula' => 'nullable|string|required_if:salary_item_value,2',
            'condition' => 'nullable|string',
            'account_id' => 'required|exists:accounts,id',
        ]);

        try {
            $salaryItem = SalaryItem::findOrFail($id);
            $salaryItem->update($validated);

            return redirect()->route('SalaryItems.index')->with('success', 'تم تحديث بند الراتب بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء تحديث بند الراتب')->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $salaryItem = SalaryItem::findOrFail($id);
            $salaryItem->delete();

            return redirect()->route('SalaryItems.index')->with('success', 'تم حذف بند الراتب بنجاح');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'حدث خطأ أثناء حذف بند الراتب: ' . $e->getMessage());
        }
    }

    public function toggleStatus($id)
    {
        try {
            $salaryTemplates = SalaryTemplate::findOrFail($id);

            // Toggle status between 1 (active) and 0 (inactive)
            $salaryTemplates->status = $salaryTemplates->status == 1 ? 2 : 1;
            $salaryTemplates->save();

            $message = $salaryTemplates->status == 1 ? 'تم تنشيط قالب  الراتب بنجاح' : 'تم تعطيل بند الراتب بنجاح';
            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء تغيير حالة قالب  الراتب');
        }
    }
}
