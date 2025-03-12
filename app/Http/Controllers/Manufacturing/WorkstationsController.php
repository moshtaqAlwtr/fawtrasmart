<?php

namespace App\Http\Controllers\Manufacturing;

use App\Http\Controllers\Controller;
use App\Http\Requests\WorkStationRequest;
use App\Models\Account;
use App\Models\Product;
use App\Models\WorkStations;
use App\Models\Log as ModelsLog;
use App\Models\WorkStationsCost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkstationsController extends Controller
{
    public function index()
    {
        $workstations = WorkStations::select()->get();
        return view('Manufacturing.Workstations.index',compact('workstations'));
    }
    public function create(){
        $record_count = DB::table('work_stations')->count();
        $serial_number = str_pad($record_count + 1, 6, '0', STR_PAD_LEFT);
        $accounts = Account::select('id','name')->get();
        return view('Manufacturing.Workstations.create',compact('serial_number','accounts'));
    }

    public function store(WorkStationRequest $request)
    {
        try
        {
            DB::beginTransaction();
            $workStation = WorkStations::create([
                'name'        => $request->input('name'),
                'code'        => $request->input('code'),
                'unit'        => $request->input('unit'),
                'description' => $request->input('description'),
                'total_cost'  => $request->input('total_cost'),
                'cost_wages'  => $request->input('cost_wages'),
                'account_wages' => $request->input('account_wages'),
                'cost_origin' => $request->input('cost_origin'),
                'origin'      => $request->input('origin'),
                'automatic_depreciation' => $request->has('automatic_depreciation') ? 1 : 0,
                'created_by' => auth()->user()->id
            ]);

            if ($request->has('cost_expenses') && is_array($request->cost_expenses)) {
                foreach ($request->cost_expenses as $index => $cost) {
                    WorkStationsCost::create([
                        'work_station_id'  => $workStation->id,
                        'cost_expenses'    => $cost,
                        'account_expenses' => $request->account_expenses[$index] ?? null,
                    ]);
                }
            }
            
            // تسجيل اشعار نظام جديد
            ModelsLog::create([
                'type' => 'bom',
                'type_id' => $workStation->id, // ID النشاط المرتبط
                'type_log' => 'log', // نوع النشاط
                'description' => 'تم اضافة محطة عمل **' . $workStation->name . '**',
                'created_by' => auth()->id(), // ID المستخدم الحالي
            ]);

            DB::commit();
            return redirect()->route('manufacturing.workstations.index')->with(['success' => 'تم إضافة محطة العمل بنجاح.']);
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'حدث خطاء ما يرجى المحاوله لاحقا']);
        }
    }

    public function edit($id)
    {
        $workstation = WorkStations::find($id);
        $accounts = Account::select('id','name')->get();
        return view('manufacturing.workstations.edit',compact('workstation','accounts'));
    }

    public function update(WorkStationRequest $request, $id)
    {
        try
        {
            DB::beginTransaction();
            $workstation = WorkStations::find($id);
            $workstation->update([
                'name'        => $request->input('name'),
                'code'        => $request->input('code'),
                'unit'        => $request->input('unit'),
                'description' => $request->input('description'),
                'total_cost'  => $request->input('total_cost'),
                'cost_wages'  => $request->input('cost_wages'),
                'account_wages' => $request->input('account_wages'),
                'cost_origin' => $request->input('cost_origin'),
                'origin'      => $request->input('origin'),
                'automatic_depreciation' => $request->has('automatic_depreciation') ? 1 : 0,
                'updated_by' => auth()->user()->id
            ]);

            $workstation->stationsCosts()->delete();
            if ($request->has('cost_expenses') && is_array($request->cost_expenses)) {
                foreach ($request->cost_expenses as $index => $cost) {
                    WorkStationsCost::create([
                        'work_station_id'  => $workstation->id,
                        'cost_expenses'    => $cost,
                        'account_expenses' => $request->account_expenses[$index] ?? null,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('manufacturing.workstations.index')->with(['success' => 'تم تعديل محطة العمل بنجاح.']);
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'حدث خطاء ما يرجى المحاوله لاحقا']);
        }
    }

    public function show($id)
    {
        $workstation = WorkStations::find($id);
        return view('manufacturing.workstations.show',compact('workstation'));
    }

    public function destroy($id)
    {
        try
        {
            DB::beginTransaction();

            $workStation = WorkStations::find($id);
            $workStation->stationsCosts()->delete();
            $workStation->delete();

            DB::commit();

            return redirect()->route('manufacturing.workstations.index')->with(['error' => 'تم حذف محطة العمل بنجاح.']);
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'حدث خطأ ما، يرجى المحاولة لاحقًا.']);
        }
    }


}
