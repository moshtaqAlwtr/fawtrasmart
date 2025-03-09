<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Reports\EmployeesController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

require __DIR__ . '/auth.php';

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath','check.branch']
    ],
    function () {
        Route::prefix('reports_Employees')->middleware(['auth'])->group(function () {
            // صفحة الفهرس
            Route::get('/index', [EmployeesController::class, 'index'])->name('reports.employees.index');

            // صفحة الشيكات المسلمة
            Route::get('/Residences', [EmployeesController::class, 'Residences'])->name('reports.employees.Residences');

            // صفحة الشيكات المستلمة
            Route::get('/attendance', [EmployeesController::class, 'attendance'])->name('reports.employees.attendance');

            Route::get('/attendance_multiple', [EmployeesController::class, 'attendancemultiple'])->name('reports.employees.attendance_multiple');

            Route::get('/Leaves', [EmployeesController::class, 'Leaves'])->name('reports.employees.Leaves');

            Route::get('/shift', [EmployeesController::class, 'shift'])->name('reports.employees.shift');

            Route::get('/Attendance-by-Day', [EmployeesController::class, 'AttendancebyDay'])->name('reports.employees.Attendance-by-Day');

            Route::get('/attendance-by-week', [EmployeesController::class, 'AttendancebyWeek'])->name('reports.employees.attendance-by-week');

            Route::get('/attendance-by-month', [EmployeesController::class, 'AttendancebyMonth'])->name('reports.employees.attendance-by-month');

            Route::get('/attendance-by-year', [EmployeesController::class, 'AttendancebyYear'])->name('reports.employees.attendance-by-year');

            Route::get('/attendance-by-department', [EmployeesController::class, 'AttendancebyDepartment'])->name('reports.employees.attendance-by-department');

            Route::get('/Attendance_by_Employee', [EmployeesController::class, 'AttendancebyEmployee'])->name('reports.employees.Attendance_by_Employee');

            Route::get('/Salaries_by_Branch', [EmployeesController::class, 'byBranch'])->name('reports.employees.Salaries_by_Branch');

            Route::get('/Advances', [EmployeesController::class, 'Advances'])->name('reports.employees.Advances');

            Route::get('/Contracts', [EmployeesController::class, 'Contracts'])->name('reports.employees.Contracts');

        });
    }
);
