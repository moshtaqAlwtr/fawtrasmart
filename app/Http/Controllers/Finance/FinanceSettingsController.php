<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\ExpensesCategory;
use App\Models\ReceiptCategory;
use Illuminate\Http\Request;

class FinanceSettingsController extends Controller
{
    public function index()
    {
        return view('finance.finance_settings.index');
    }

    public function expenses_category()
    {
        $expenses_categories = ExpensesCategory::orderBy('id', 'DESC')->get();
        return view('finance.finance_settings.expenses_category',compact('expenses_categories'));
    }

    public function expenses_category_store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $data = new ExpensesCategory();

        if($request->has('status')){
            $data->status = 1;
        }
        $data->name = $request->name;
        $data->description = $request->description;
        $data->save();
        return redirect()->back()->with( ['success'=>'تم اضافه تصنيف منصرفات بنجاج !!']);
    }

    public function expenses_category_update(Request $request,$id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $data = ExpensesCategory::findOrFail($id);

        if($request->has('status')){
            $data->status = 1;
        }
        else{
            $data->status = 0;
        }
        $data->name = $request->name;
        $data->description = $request->description;
        $data->update();

        return redirect()->back()->with( ['success'=>'تم تحديث تصنيف منصرفات بنجاج !!']);
    }

    public function expenses_category_delete($id)
    {
        ExpensesCategory::findOrFail($id)->delete();
        return redirect()->back()->with( ['error'=>'تم حذف تصنيف منصرفات بنجاج !!']);
    }


    public function receipt_category()
    {
        $receipt_categories = ReceiptCategory::orderBy('id', 'DESC')->get();
        return view('finance.finance_settings.receipt_category',compact('receipt_categories'));
    }

    public function receipt_category_store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $data = new ReceiptCategory();

        if($request->has('status')){
            $data->status = 1;
        }
        $data->name = $request->name;
        $data->description = $request->description;
        $data->save();
        return redirect()->back()->with( ['success'=>'تم اضافه تصنيف ايرادات بنجاج !!']);
    }

    public function receipt_category_update(Request $request,$id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $data = ReceiptCategory::findOrFail($id);

        if($request->has('status')){
            $data->status = 1;
        }
        else{
            $data->status = 0;
        }
        $data->name = $request->name;
        $data->description = $request->description;
        $data->update();

        return redirect()->back()->with( ['success'=>'تم تحديث تصنيف ايرادات بنجاج !!']);
    }

    public function receipt_category_delete($id)
    {
        ReceiptCategory::findOrFail($id)->delete();
        return redirect()->back()->with( ['error'=>'تم حذف تصنيف ايرادات بنجاج !!']);
    }


}
