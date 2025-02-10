<?php

namespace App\Http\Controllers\Attendance\Settings;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Holiday;
use App\Models\HolidayList;
use App\Models\HolyDayListCustomize;
use App\Models\JopTitle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HolidayController extends Controller
{
    public function index()
    {
        $holiday_lists = HolidayList::select()->orderBy( 'id','DESC')->get();
        return view('attendance.settings.holiday.index',compact('holiday_lists'));
    }
    public function create()
    {
        return view('attendance.settings.holiday.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'holiday_date' => 'required|array',
            'holiday_date.*' => 'required|date',
            'named' => 'required|array',
            'named.*' => 'required|string|max:255',
        ]);

        // Create Holiday List
        $holidayList = HolidayList::create([
            'name' => $request->input('name'),
        ]);

        // Create Associated Holidays
        foreach ($request->holiday_date as $index => $date) {
            Holiday::create([
                'holiday_list_id' => $holidayList->id,
                'holiday_date' => $date,
                'named' => $request->named[$index],
            ]);
        }

        // Redirect or Return Response
        return redirect()->route('holiday_lists.index')->with(['success'=>'تمت إضافة قائمة العطلات بنجاح']);
    }

    public function show($id)
    {
        $holiday_list = HolidayList::findOrFail($id);
        return view('attendance.settings.holiday.show',compact('holiday_list'));
    }

    public function edit($id)
    {
        $holiday_list = HolidayList::findOrFail($id);
        return view('attendance.settings.holiday.edit',compact('holiday_list'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'holiday_date' => 'required|array',
            'holiday_date.*' => 'required|date',
            'named' => 'required|array',
            'named.*' => 'required|string|max:255',
        ]);

        // Create Holiday List
        $holidayList = HolidayList::findOrFail($id)->update([
            'name' => $request->input('name'),
        ]);

        Holiday::where('holiday_list_id', $id)->delete();

        // Create Associated Holidays
        foreach ($request->holiday_date as $index => $date) {
            Holiday::where('holiday_list_id', $id)->create([
                'holiday_list_id' => $id,
                'holiday_date' => $date,
                'named' => $request->named[$index],
            ]);
        }

        // Redirect or Return Response
        return redirect()->route('holiday_lists.index')->with(['success'=>'تمت تحديث قائمة العطلات بنجاح']);
    }

    public function holyday_employees($id)
    {
        $holiday_list = HolidayList::findOrFail($id);
        $employees = Employee::select('id',  'first_name','middle_name')->get();
        $branches = Branch::select('id','name')->get();
        $departments = Department::select('id','name')->get();
        $job_titles = JopTitle::select('id','name')->get();
        return view('attendance.settings.holiday.holyday_employees',compact('holiday_list','employees','branches','departments','job_titles'));
    }

    public function add_holyday_employees(Request $request,$id)
    {
        try {
            DB::beginTransaction();
            if ($request['use_rules'] === 'employees') {
                $holiday_list_customize = HolyDayListCustomize::updateOrCreate([
                    'holiday_list_id' => $id,
                    'use_rules' => 2,
                ]);

            } elseif ($request['use_rules'] === 'rules') {
                $holiday_list_customize = HolyDayListCustomize::updateOrCreate([
                    'holiday_list_id' => $id,
                    'branch_id' => $request['branch_id'],
                    'department_id' => $request['department_id'],
                    'job_title_id' => $request['job_title_id'],
                    'use_rules' => 1,
                ]);
            }

            $holiday_list_customize->employees()->sync($request['employee_id']);
            DB::commit();

            return redirect()->route('holiday_lists.show',$id)->with(['success'=>'تمت اضافة الموظفين لقايمة العطلات بنجاح']);

        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with(['error' => $exception->getMessage()]);
        }
    }


}
