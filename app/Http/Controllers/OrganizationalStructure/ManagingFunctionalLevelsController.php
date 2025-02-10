<?php

namespace App\Http\Controllers\OrganizationalStructure;

use App\Http\Controllers\Controller;
use App\Models\FunctionalLevels;
use Illuminate\Http\Request;

class ManagingFunctionalLevelsController extends Controller
{
    public function index()
    {
        $functionalLevels = FunctionalLevels::select()->orderBy('id','desc')->get();
        return view('organizational_structure.ManagingFunctionalLevels.index',compact('functionalLevels'));
    }

    public function  create()
    {
        return view('organizational_structure.ManagingFunctionalLevels.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        FunctionalLevels::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status
        ]);

        return redirect()->route('ManagingFunctionalLevels.index')->with('success','تم اضافة مستوى وظيفي بنجاح');
    }

    public function show($id)
    {
        $level = FunctionalLevels::find($id);
        return view('organizational_structure.ManagingFunctionalLevels.show',compact('level'));
    }

    public function edit($id)
    {
        $functionalLevel = FunctionalLevels::find($id);
        return view('organizational_structure.ManagingFunctionalLevels.edit',compact('functionalLevel'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        FunctionalLevels::find($id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status
        ]);

        return redirect()->route('ManagingFunctionalLevels.index')->with('success','تم تعديل مستوى وظيفي بنجاح');
    }

    public function delete($id)
    {
        FunctionalLevels::find($id)->delete();
        return redirect()->route('ManagingFunctionalLevels.index')->with('error','تم حذف مستوى وظيفي بنجاح');
    }

}
