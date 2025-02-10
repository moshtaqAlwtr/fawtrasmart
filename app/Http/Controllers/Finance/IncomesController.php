<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Receipt;
use App\Models\ReceiptCategory;
use Illuminate\Http\Request;

class IncomesController extends Controller
{
    public function index()
    {
        $incomes = Receipt::orderBy('id','DESC')->paginate(5);
        return view('finance.incomes.index',compact('incomes'));
    }

    public function create()
    {
        $incomes_categories = ReceiptCategory::select('id','name')->get();
        return view('finance.incomes.create',compact('incomes_categories'));
    }

    public function store(Request $request)
    {
        $income = new Receipt();

        $income->code = $request->code;
        $income->amount = $request->amount;
        $income->description = $request->description;
        $income->date = $request->date;
        $income->incomes_category_id = $request->incomes_category_id;
        $income->seller = $request->seller;
        $income->store_id = $request->store_id;
        $income->sup_account = $request->sup_account;
        $income->recurring_frequency = $request->recurring_frequency;
        $income->end_date = $request->end_date;
        $income->tax1 = $request->tax1;
        $income->tax2 = $request->tax2;
        $income->tax1_amount = $request->tax1_amount;
        $income->tax2_amount = $request->tax2_amount;

        if($request->hasFile(key: 'attachments')){
            $income->attachments = $this->UploadImage('assets/uploads/incomes',$request->attachments);
        }

        if($request->has('is_recurring')){
            $income->is_recurring = 1;
        }

        if($request->has('cost_centers_enabled')){
            $income->cost_centers_enabled = 1;
        }

        $income->save();

        return redirect()->route('incomes.index')->with( ['success'=>'تم اضافه سند قبض بنجاج !!']);

    }

    public function update(Request $request ,$id)
    {
        $income = Receipt::findOrFail($id);

        $income->code = $request->code;
        $income->amount = $request->amount;
        $income->description = $request->description;
        $income->date = $request->date;
        $income->incomes_category_id = $request->incomes_category_id;
        $income->seller = $request->seller;
        $income->store_id = $request->store_id;
        $income->sup_account = $request->sup_account;
        $income->recurring_frequency = $request->recurring_frequency;
        $income->end_date = $request->end_date;
        $income->tax1 = $request->tax1;
        $income->tax2 = $request->tax2;
        $income->tax1_amount = $request->tax1_amount;
        $income->tax2_amount = $request->tax2_amount;

        if($request->hasFile(key: 'attachments')){
            $income->attachments = $this->UploadImage('assets/uploads/incomes',$request->attachments);
        }

        if($request->has('is_recurring')){
            $income->is_recurring = 1;
        }

        if($request->has('cost_centers_enabled')){
            $income->cost_centers_enabled = 1;
        }

        $income->update();

        return redirect()->route('incomes.show',$id)->with( ['success'=>'تم تحديث سند قبض بنجاج !!']);

    }

    public function show($id)
    {
        $income = Receipt::findOrFail($id);
        return view('finance.incomes.show',compact('income'));
    }

    public function edit($id)
    {
        $incomes_categories = ReceiptCategory::select('id','name')->get();
        $income = Receipt::findOrFail($id);
        return view('finance.incomes.edit',compact('income','incomes_categories'));
    }

    public function delete($id)
    {
        $incomes = Receipt::findOrFail($id);
        $incomes->delete();
        return redirect()->route('incomes.index')->with( ['error'=>'تم حذف سند قبض بنجاج !!']);
    }

    function uploadImage($folder,$image)
    {
        $fileExtension = $image->getClientOriginalExtension();
        $fileName = time().rand(1,99).'.'.$fileExtension;
        $image->move($folder,$fileName);

        return $fileName;
    }//end of uploadImage

}
