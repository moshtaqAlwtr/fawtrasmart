<?php

namespace App\Http\Controllers\Manufacturing;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductionMaterialRequest;
use App\Models\Account;
use App\Models\Product;
use App\Models\ProductionMaterials;
use App\Models\ProductionMaterialsItem;
use App\Models\ProductionPath;
use App\Models\ProductionStage;
use App\Models\WorkStations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BOMController extends Controller
{
    public function index()
    {
        $materials = ProductionMaterials::select()->get();
        return view('Manufacturing.BOM.index', compact('materials'));
    }
    public function create()
    {
        $record_count = DB::table('production_materials')->count();
        $serial_number = str_pad($record_count + 1, 6, '0', STR_PAD_LEFT);
        $products = Product::select()->get();
        $accounts = Account::select('id','name')->get();
        $paths = ProductionPath::select('id','name')->get();
        $stages = ProductionStage::select('id','stage_name')->get();
        $workstations = WorkStations::select('id','name','total_cost')->get();
        return view('Manufacturing.BOM.create', compact('products','accounts','paths','serial_number','stages','workstations'));
    }

    public function store(ProductionMaterialRequest $request)
    {
        DB::beginTransaction();
        try {
            if ($request->default == 1) {
                $existingDefault = ProductionMaterials::where('default', 1)->first();

                if ($existingDefault) {
                    $existingDefault->update(['default' => 0]);
                }
            }

            $productionMaterial = ProductionMaterials::create([
                'name' => $request->name,
                'code' => $request->code,
                'product_id' => $request->product_id,
                'account_id' => $request->account_id,
                'production_path_id' => $request->production_path_id,
                'quantity' => $request->quantity,
                'last_total_cost' => $request->last_total_cost ?? 0,
                'status' => $request->status ?? 0,
                'default' => $request->default ?? 0,
                'created_by' => auth()->id(), // إذا كنت تستخدم نظام مصادقة
            ]);

            // حفظ البيانات في جدول production_materials_items
            if ($request->has('raw_product_id')) {
                foreach ($request->raw_product_id as $index => $rawProductId) {
                    ProductionMaterialsItem::create([
                        'production_material_id' => $productionMaterial->id,
                        'raw_product_id' => $rawProductId,
                        'raw_production_stage_id' => $request->raw_production_stage_id[$index],
                        'raw_unit_price' => $request->raw_unit_price[$index],
                        'raw_quantity' => $request->raw_quantity[$index],
                        'raw_total' => $request->raw_total[$index],

                        'expenses_account_id' => $request->expenses_account_id[$index] ?? null,
                        'expenses_cost_type' => $request->expenses_cost_type[$index] ?? null,
                        'expenses_production_stage_id' => $request->expenses_production_stage_id[$index] ?? null,
                        'expenses_price' => $request->expenses_price[$index] ?? null,
                        'expenses_description' => $request->expenses_description[$index] ?? null,
                        'expenses_total' => $request->expenses_total[$index] ?? null,

                        'workstation_id' => $request->workstation_id[$index] ?? null,
                        'operating_time' => $request->operating_time[$index] ?? null,
                        'manu_production_stage_id' => $request->manu_production_stage_id[$index] ?? null,
                        'manu_cost_type' => $request->manu_cost_type[$index] ?? null,
                        'manu_total_cost' => $request->manu_total_cost[$index] ?? null,
                        'manu_description' => $request->manu_description[$index] ?? null,
                        'manu_total' => $request->manu_total[$index] ?? null,

                        'end_life_product_id' => $request->end_life_product_id[$index] ?? null,
                        'end_life_unit_price' => $request->end_life_unit_price[$index] ?? null,
                        'end_life_production_stage_id' => $request->end_life_production_stage_id[$index] ?? null,
                        'end_life_quantity' => $request->end_life_quantity[$index] ?? null,
                        'end_life_total' => $request->end_life_total[$index] ?? null,
                    ]);
                }
            }

            // تأكيد حفظ البيانات
            DB::commit();

            return redirect()->route('BOM.index')->with(['success'=>'تم حفظ البيانات بنجاح.']);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('BOM.index')->with(['error'=>'حدث خطأ ما.']);
        }
    }

    public function edit($id)
    {
        $productionMaterial = ProductionMaterials::find($id);
        $products = Product::select()->get();
        $accounts = Account::select('id','name')->get();
        $paths = ProductionPath::select('id','name')->get();
        $stages = ProductionStage::select('id','stage_name')->get();
        $workstations = WorkStations::select('id','name','total_cost')->get();
        $productionMaterialItems = ProductionMaterialsItem::where('production_material_id', $id)->get();
        return view('Manufacturing.BOM.edit', compact('productionMaterial','products','accounts','paths','stages','workstations','productionMaterialItems'));
    }

    public function update(ProductionMaterialRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            if ($request->default == 1) {
                $existingDefault = ProductionMaterials::where('default', 1)->where('id', '!=', $id)->first();

                if ($existingDefault) {
                    $existingDefault->update(['default' => 0]);
                }
            }

            $productionMaterial = ProductionMaterials::findOrFail($id);
            $productionMaterial->update([
                'name' => $request->name,
                'code' => $request->code,
                'product_id' => $request->product_id,
                'account_id' => $request->account_id,
                'production_path_id' => $request->production_path_id,
                'quantity' => $request->quantity,
                'last_total_cost' => $request->last_total_cost ?? 0,
                'status' => $request->status ?? 0,
                'default' => $request->default ?? 0,
                'updated_by' => auth()->id(),
            ]);

            ProductionMaterialsItem::where('production_material_id', $id)->delete();

            if ($request->has('raw_product_id')) {
                foreach ($request->raw_product_id as $index => $rawProductId) {
                    ProductionMaterialsItem::create([
                        'production_material_id' => $productionMaterial->id,
                        'raw_product_id' => $rawProductId,
                        'raw_production_stage_id' => $request->raw_production_stage_id[$index],
                        'raw_unit_price' => $request->raw_unit_price[$index],
                        'raw_quantity' => $request->raw_quantity[$index],
                        'raw_total' => $request->raw_total[$index],

                        'expenses_account_id' => $request->expenses_account_id[$index] ?? null,
                        'expenses_cost_type' => $request->expenses_cost_type[$index] ?? null,
                        'expenses_production_stage_id' => $request->expenses_production_stage_id[$index] ?? null,
                        'expenses_price' => $request->expenses_price[$index] ?? null,
                        'expenses_description' => $request->expenses_description[$index] ?? null,
                        'expenses_total' => $request->expenses_total[$index] ?? null,

                        'workstation_id' => $request->workstation_id[$index] ?? null,
                        'operating_time' => $request->operating_time[$index] ?? null,
                        'manu_production_stage_id' => $request->manu_production_stage_id[$index] ?? null,
                        'manu_cost_type' => $request->manu_cost_type[$index] ?? null,
                        'manu_total_cost' => $request->manu_total_cost[$index] ?? null,
                        'manu_description' => $request->manu_description[$index] ?? null,
                        'manu_total' => $request->manu_total[$index] ?? null,

                        'end_life_product_id' => $request->end_life_product_id[$index] ?? null,
                        'end_life_unit_price' => $request->end_life_unit_price[$index] ?? null,
                        'end_life_production_stage_id' => $request->end_life_production_stage_id[$index] ?? null,
                        'end_life_quantity' => $request->end_life_quantity[$index] ?? null,
                        'end_life_total' => $request->end_life_total[$index] ?? null,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('BOM.index')->with(['success' => 'تم تحديث البيانات بنجاح.']);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('BOM.index')->with(['error' => 'حدث خطأ ما: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        // استرجاع البيانات الحالية
        $productionMaterial = ProductionMaterials::findOrFail($id);
        $productionMaterialItems = ProductionMaterialsItem::where('production_material_id', $id)->get();

        // استرجاع البيانات الأخرى المطلوبة للنموذج
        $products = Product::all();
        $accounts = Account::all();
        $paths = ProductionPath::all();
        $stages = ProductionStage::all();
        $workstations = WorkStations::all();

        return view('Manufacturing.BOM.show', compact(
            'productionMaterial',
            'productionMaterialItems',
            'products',
            'accounts',
            'paths',
            'stages',
            'workstations'
        ));
    }

    public function destroy($id)
    {
        $productionMaterial = ProductionMaterials::findOrFail($id);
        $productionMaterial->ProductionMaterialsItem()->delete();
        $productionMaterial->delete();
        return redirect()->route('BOM.index')->with(['error' => 'تم حذف البيانات بنجاح.']);
    }

    public function get_cost_total($id)
    {
        $workstation = WorkStations::find($id);

        if (!$workstation) {
            return response()->json(['error' => 'Workstation not found'], 404);
        }
        return response()->json(['total_cost' => $workstation->total_cost]);
    }


}
