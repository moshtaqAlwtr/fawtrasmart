<?php

namespace App\Http\Controllers\Commission;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\Commission_Products;
use App\Models\CommissionUsers;
use App\Models\Employee;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    public function index()
    {
         return "test1";
    }

    public function create()
    {
         $employees = Employee::select('id', 'first_name')->get();
         return view('commission.create', compact('employees'));
    }

    public function store(Request $request)
    {

       
             $Commission = new Commission();
             $Commission->name = $request->name;
             $Commission->period = $request->period;
             $Commission->status = $request->status;
             $Commission->commission_calculation = $request->commission_calculation;
             $Commission->currency = $request->currency;
             $Commission->notes = $request->notes;
             $Commission->target_type = $request->target_type;
             $Commission->value = $request->value;
             $Commission->save();

             foreach ($request->employee_id  as $employee_id) {
                CommissionUsers::create([
                    'commission_id' => $Commission->id,
                    'employee_id' => $employee_id,
                ]);
            }

            foreach ($request->items as $item) {
                Commission_Products::create([
                    'commission_id' => $Commission->id,
                    'product_id' => 1,
                    'commission_percentage' => 2,
                ]);
            }

            return CommissionUsers::all();
             
    }

    public function update(Request $request ,$id)
    {

    }
    public function show($id)
    {

    }
    public function edit($id)
    {

    }
    public function delete($id)
    {

    }
}
