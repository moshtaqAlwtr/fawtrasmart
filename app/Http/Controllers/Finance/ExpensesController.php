<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpenseRequest;
use App\Models\Expense;
use App\Models\Log as ModelsLog;
use App\Models\ExpensesCategory;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    public function index()
    {
        $expenses = Expense::orderBy('id','DESC')->paginate(5);
        return view('finance.expenses.index',compact('expenses'));
    }

    public function create()
    {
        $expenses_categories = ExpensesCategory::select('id','name')->get();
        return view('finance.expenses.create',compact('expenses_categories'));
    }

    public function store(Request $request)
    {
        $expense = new Expense();

        $expense->code = $request->code;
        $expense->amount = $request->amount;
        $expense->description = $request->description;
        $expense->date = $request->date;
        $expense->unit_id = $request->unit_id;
        $expense->expenses_category_id = $request->expenses_category_id;
        $expense->vendor_id = $request->vendor_id;
        $expense->seller = $request->seller;
        $expense->store_id = $request->store_id;
        $expense->sup_account = $request->sup_account;
        $expense->recurring_frequency = $request->recurring_frequency;
        $expense->end_date = $request->end_date;
        $expense->tax1 = $request->tax1;
        $expense->tax2 = $request->tax2;
        $expense->tax1_amount = $request->tax1_amount;
        $expense->tax2_amount = $request->tax2_amount;

                ModelsLog::create([
                'type' => 'finance_log',
                'type_id' =>  $expense->id, // ID النشاط المرتبط
                'type_log' => 'log', // نوع النشاط
                'description' => sprintf(
                    'تم انشاء سند صرف رقم **%s** بقيمة **%d**',
                    $request->id, // رقم طلب الشراء
                  $expense->amount , // اسم المنتج
              
                ),
                'created_by' => auth()->id(), // ID المستخدم الحالي
            ]);


        if($request->hasFile(key: 'attachments')){
            $expense->attachments = $this->UploadImage('assets/uploads/expenses',$request->attachments);
        }

        if($request->has('is_recurring')){
            $expense->is_recurring = 1;
        }

        if($request->has('cost_centers_enabled')){
            $expense->cost_centers_enabled = 1;
        }

        $expense->save();

        return redirect()->route('expenses.index')->with( ['success'=>'تم اضافه سند صرف بنجاج !!']);

    }

    public function update(Request $request ,$id)
    {
        $expense = Expense::findOrFail($id);

        $expense->code = $request->code;
        $expense->amount = $request->amount;
        $expense->description = $request->description;
        $expense->date = $request->date;
        $expense->unit_id = $request->unit_id;
        $expense->expenses_category_id = $request->expenses_category_id;
        $expense->vendor_id = $request->vendor_id;
        $expense->seller = $request->seller;
        $expense->store_id = $request->store_id;
        $expense->sup_account = $request->sup_account;
        $expense->recurring_frequency = $request->recurring_frequency;
        $expense->end_date = $request->end_date;
        $expense->tax1 = $request->tax1;
        $expense->tax2 = $request->tax2;
        $expense->tax1_amount = $request->tax1_amount;
        $expense->tax2_amount = $request->tax2_amount;

  ModelsLog::create([
                'type' => 'finance_log',
                'type_id' =>  $expense->id, // ID النشاط المرتبط
                'type_log' => 'log', // نوع النشاط
                'description' => sprintf(
                    'تم تعديل سند صرف رقم **%s** بقيمة **%d**',
                    $request->id, // رقم طلب الشراء
                  $expense->amount , // اسم المنتج
              
                ),
                'created_by' => auth()->id(), // ID المستخدم الحالي
            ]);
        if($request->hasFile(key: 'attachments')){
            $expense->attachments = $this->UploadImage('assets/uploads/expenses',$request->attachments);
        }

        if($request->has('is_recurring')){
            $expense->is_recurring = 1;
        }

        if($request->has('cost_centers_enabled')){
            $expense->cost_centers_enabled = 1;
        }

        $expense->update();

        return redirect()->route('expenses.show',$id)->with( ['success'=>'تم تحديث سند صرف بنجاج !!']);

    }


    public function show($id)
    {
        $expense = Expense::findOrFail($id);
        return view('finance.expenses.show',compact('expense'));
    }

    public function edit($id)
    {
        $expenses_categories = ExpensesCategory::select('id','name')->get();
        $expense = Expense::findOrFail($id);
        return view('finance.expenses.edit',compact('expense','expenses_categories'));
    }

    public function delete($id)
    {
        $expense = Expense::findOrFail($id);
        ModelsLog::create([
                        'type' => 'finance_log',
                      'type_id' =>  $id, // ID النشاط المرتبط
                      'type_log' => 'log', // نوع النشاط
                      'description' => 'تم  حذف سند صرف رقم  **' . $id . '**',
                      'created_by' => auth()->id(), // ID المستخدم الحالي
                  ]);


        $expense->delete();
        return redirect()->route('expenses.index')->with( ['error'=>'تم حذف سند صرف بنجاج !!']);
    }

    function uploadImage($folder,$image)
    {
        $fileExtension = $image->getClientOriginalExtension();
        $fileName = time().rand(1,99).'.'.$fileExtension;
        $image->move($folder,$fileName);

        return $fileName;
    }//end of uploadImage


}
