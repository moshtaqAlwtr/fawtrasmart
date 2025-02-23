<?php

namespace App\Http\Controllers\Manufacturing;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndirectCostsRequest;
use App\Models\Account;
use App\Models\IndirectCost;
use App\Models\IndirectCostItem;
use App\Models\ManufacturOrders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndirectCostsController extends Controller
{
    public function index()
    {
        $indirectCosts = IndirectCost::with('indirectCostItems')->get();
        return view('manufacturing.indirectcosts.index', compact('indirectCosts'));
    }
    public function create()
    {
        $accounts = Account::select('id', 'name')->get();
        $manufacturing_orders = ManufacturOrders::select('id', 'name')->get();
        return view('manufacturing.indirectcosts.create', compact( 'accounts','manufacturing_orders'));
    }

    public function store(IndirectCostsRequest $request)
    {
        DB::beginTransaction();
        try {
            $indirectCost = IndirectCost::create([
                'account_id' => $request->account_id,
                'from_date' => $request->from_date,
                'to_date' => $request->to_date,
                'based_on' => $request->based_on, # 1: تكلفه , 2:  كميه
                'total' => $request->total
            ]);

            foreach ($request->restriction_id as $index => $restriction_id) {
                IndirectCostItem::create([
                    'indirect_costs_id' => $indirectCost->id,
                    'restriction_id' => $restriction_id,
                    'restriction_total' => $request->restriction_total[$index],
                    'manufacturing_order_id' => $request->manufacturing_order_id[$index],
                    'manufacturing_price' => $request->manufacturing_price[$index],
                ]);
            }

            DB::commit();
            return redirect()->route('manufacturing.indirectcosts.index')->with(['success' => 'تمت إضافة التكاليف غير المباشرة بنجاح.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with(['error' => 'حدث خطأ أثناء الحفظ: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $indirectCost = IndirectCost::with('indirectCostItems')->findOrFail($id);
        $accounts = Account::select('id', 'name')->get();
        $manufacturing_orders = ManufacturOrders::select('id', 'name')->get();
        return view('manufacturing.indirectcosts.edit', compact('indirectCost', 'accounts', 'manufacturing_orders'));
    }

    public function update(IndirectCostsRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $indirectCost = IndirectCost::findOrFail($id);

            $indirectCost->update([
                'account_id' => $request->account_id,
                'from_date' => $request->from_date,
                'to_date' => $request->to_date,
                'based_on' => $request->based_on, # 1: تكلفه , 2:  كميه
                'total' => $request->total
            ]);

            $indirectCost->indirectCostItems()->delete();

            foreach ($request->restriction_id as $index => $restriction_id) {
                IndirectCostItem::create([
                    'indirect_costs_id' => $indirectCost->id,
                    'restriction_id' => $restriction_id,
                    'restriction_total' => $request->restriction_total[$index],
                    'manufacturing_order_id' => $request->manufacturing_order_id[$index],
                    'manufacturing_price' => $request->manufacturing_price[$index],
                ]);
            }

            DB::commit();
            return redirect()->route('manufacturing.indirectcosts.index')->with(['success' => 'تم التحديث بنجاح.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with(['error' => 'حدث خطاء في التحديث: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $indirectCost = IndirectCost::with('indirectCostItems')->findOrFail($id);
        return view('manufacturing.indirectcosts.show', compact('indirectCost'));
    }

    public function destroy($id)
    {
        $indirectCost = IndirectCost::findOrFail($id);
        $indirectCost->indirectCostItems()->delete();
        $indirectCost->delete();
        return redirect()->route('manufacturing.indirectcosts.index')->with(['error' => 'تم حذف التكاليف بنجاح.']);
    }

}
