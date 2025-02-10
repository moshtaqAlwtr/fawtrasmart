<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShiftRequest;
use App\Models\Shift;
use App\Models\ShiftDay;
use Illuminate\Http\Request;

class ShiftManagementController extends Controller
{

    public function index()
    {
        $shifts = Shift::select()->orderBy('id','DESC')->get();
        return view('hr.shift_management.index',compact('shifts'));
    }

    public function create()
    {
        return view('hr.shift_management.create');
    }

    public function store(ShiftRequest $request)
    {
        $shift = new Shift();
        $shift->name = $request->name;
        $shift->type = $request->type == 'advanced' ? 2 : 1;
        $shift->save();

        $daysData = $request->input('days', []);

        foreach ($daysData as $dayKey => $dayData) {
            $shiftDayData = [
                'shift_id' => $shift->id,
                'day' => $dayKey,
                'working_day' => $dayData['working_day'] ?? 0,
            ];

            if ($request->type == 'basic') {
                $shiftDayData['start_time'] = $request->input('start_time');
                $shiftDayData['end_time'] = $request->input('end_time');
                $shiftDayData['login_start_time'] = $request->input('login_start_time');
                $shiftDayData['login_end_time'] = $request->input('login_end_time');
                $shiftDayData['logout_start_time'] = $request->input('logout_start_time');
                $shiftDayData['logout_end_time'] = $request->input('logout_end_time');
                $shiftDayData['grace_period'] = $request->input('grace_period', 0);
                $shiftDayData['delay_calculation'] = $request->input('delay_calculation', 15);
            } else {
                $shiftDayData['start_time'] = $dayData['working_day'] ? $dayData['start_time'] : null;
                $shiftDayData['end_time'] = $dayData['working_day'] ? $dayData['end_time'] : null;
                $shiftDayData['login_start_time'] = $dayData['working_day'] ? $dayData['login_start_time'] : null;
                $shiftDayData['login_end_time'] = $dayData['working_day'] ? $dayData['login_end_time'] : null;
                $shiftDayData['logout_start_time'] = $dayData['working_day'] ? $dayData['logout_start_time'] : null;
                $shiftDayData['logout_end_time'] = $dayData['working_day'] ? $dayData['logout_end_time'] : null;
                $shiftDayData['grace_period'] = $dayData['grace_period'] ?? 0;
                $shiftDayData['delay_calculation'] = $dayData['delay_calculation'] ?? 15;
            }

            ShiftDay::create($shiftDayData);
        }

        return redirect()->route('shift_management.index')->with(['success' => 'تم إضافة وردية جديدة بنجاح!']);
    }


    public function edit($id)
    {
        $shift = Shift::findOrFail($id);
        return view('hr.shift_management.edit',compact('shift'));
    }

    public function update(ShiftRequest $request, $id)
    {
        $shift = Shift::findOrFail($id);
        $shift->name = $request->name;
        $shift->type = $request->type == 'advanced' ? 2 : 1;

        $shift->update();

        ShiftDay::where('shift_id', $shift->id)->delete();

        $daysData = $request->input('days', []);

        foreach ($daysData as $dayKey => $dayData) {
            $shiftDayData = [
                'shift_id' => $shift->id,
                'day' => $dayKey,
                'working_day' => $dayData['working_day'] ?? 0,
            ];

            if ($request->type == 'basic') {
                $shiftDayData['start_time'] = $request->input('start_time');
                $shiftDayData['end_time'] = $request->input('end_time');
                $shiftDayData['login_start_time'] = $request->input('login_start_time');
                $shiftDayData['login_end_time'] = $request->input('login_end_time');
                $shiftDayData['logout_start_time'] = $request->input('logout_start_time');
                $shiftDayData['logout_end_time'] = $request->input('logout_end_time');
                $shiftDayData['grace_period'] = $request->input('grace_period', 0);
                $shiftDayData['delay_calculation'] = $request->input('delay_calculation', 15);
            } else {
                $shiftDayData['start_time'] = $dayData['working_day'] ? $dayData['start_time'] : null;
                $shiftDayData['end_time'] = $dayData['working_day'] ? $dayData['end_time'] : null;
                $shiftDayData['login_start_time'] = $dayData['working_day'] ? $dayData['login_start_time'] : null;
                $shiftDayData['login_end_time'] = $dayData['working_day'] ? $dayData['login_end_time'] : null;
                $shiftDayData['logout_start_time'] = $dayData['working_day'] ? $dayData['logout_start_time'] : null;
                $shiftDayData['logout_end_time'] = $dayData['working_day'] ? $dayData['logout_end_time'] : null;
                $shiftDayData['grace_period'] = $dayData['grace_period'] ?? 0;
                $shiftDayData['delay_calculation'] = $dayData['delay_calculation'] ?? 15;
            }

            ShiftDay::create($shiftDayData);
        }

        return redirect()->route('shift_management.index')->with(['success' => 'تم تحديث الوردية بنجاح!']);
    }

    public function delete($id)
    {
        $shift = Shift::findOrFail($id);
        $shift->delete();
        return redirect()->back()->with( ['error'=>'تم حذف وردية بنجاج !!']);
    }

    public function show($id)
    {
        $shift = Shift::findOrFail($id);
        return view('hr.shift_management.show',compact('shift'));
    }

}
