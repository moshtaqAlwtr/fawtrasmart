<?php

namespace App\Http\Controllers\Attendance\Settings;

use App\Http\Controllers\Controller;
use App\Models\Machine;
use Illuminate\Http\Request;

class MachinesController extends Controller
{
    public function index(Request $request)
{
    $query = Machine::query();

    // البحث باسم الماكينة أو الرقم التسلسلي
    if ($request->has('search') && $request->search != '') {
        $query->where(function($q) use ($request) {
            $q->where('name', 'like', '%'.$request->search.'%')
              ->orWhere('serial_number', 'like', '%'.$request->search.'%');
        });
    }

    // البحث بالحالة
    if ($request->has('status') && $request->status != '') {
        $query->where('status', $request->status);
    }

    // البحث بنوع الماكينة
    if ($request->has('machine_type') && $request->machine_type != '') {
        $query->where('machine_type', 'like', '%'.$request->machine_type.'%');
    }

    $machines = $query->latest()->paginate(10);

    return view('attendance.settings.machines.index', compact('machines'));
}

    public function create()
    {
        return view('attendance.settings.machines.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'serial_number' => 'nullable|string|max:255',
            'host_name' => 'required|string|max:255',
            'port_number' => 'nullable|integer',
            'connection_key' => 'nullable|string|max:255',
            'machine_type' => 'nullable|string|max:255',
        ]);

        Machine::create($validated);

        return redirect()->route('attendance.settings.machines.index')
            ->with('success', 'تم إضافة الماكينة بنجاح');
    }

    public function edit($id)
    {
        $machine = Machine::findOrFail($id);
        return view('attendance.settings.machines.edit', compact('machine'));
    }

    public function update(Request $request, $id)
    {
        $machine = Machine::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'serial_number' => 'nullable|string|max:255',
            'host_name' => 'required|string|max:255',
            'port_number' => 'nullable|integer',
            'connection_key' => 'nullable|string|max:255',
            'machine_type' => 'nullable|string|max:255',
        ]);

        $machine->update($validated);

        return redirect()->route('attendance.settings.machines.index')
            ->with('success', 'تم تحديث بيانات الماكينة بنجاح');
    }

    public function destroy($id)
    {
        $machine = Machine::findOrFail($id);
        $machine->delete();

        return redirect()->route('attendance.settings.machines.index')
            ->with('success', 'تم حذف الماكينة بنجاح');
    }
}
