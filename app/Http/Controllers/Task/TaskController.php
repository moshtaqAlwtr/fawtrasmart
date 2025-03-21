<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $employees = Employee::all(); // جلب جميع الموظفين
        return view('task.index', compact('employees'));
    }
}
// تاتي هذه الدالة لتعرض جميع الموظفين في الصفحة الرئيسية للوحة التحكم
