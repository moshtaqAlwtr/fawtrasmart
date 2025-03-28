<?php

// routes/web.php

use App\Http\Controllers\Attendance\AttendanceRecordsController;
use App\Http\Controllers\Attendance\AttendanceDaysController;
use App\Http\Controllers\Attendance\AttendanceSheetsController;
use App\Http\Controllers\Attendance\LeavePermissionsController;
use App\Http\Controllers\Attendance\LeaveRequestsController;
use App\Http\Controllers\Attendance\Settings\BasicController;
use App\Http\Controllers\Attendance\Settings\FlagsController;
use App\Http\Controllers\Attendance\Settings\HolidayController;
use App\Http\Controllers\Attendance\Settings\LeavePoliciesController;
use App\Http\Controllers\Attendance\Settings\LeaveTypesController;
use App\Http\Controllers\Attendance\Settings\MachinesController;
use App\Http\Controllers\Attendance\Settings\PrintableTemplatesController;
use App\Http\Controllers\Attendance\Settings\AttendanceDeterminantsController;
use App\Http\Controllers\Attendance\CustomShiftsController;
use App\Http\Controllers\Attendance\AttendanceSessionsRecordController;
use App\Http\Controllers\Attendance\SettingsController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


require __DIR__ . '/auth.php';

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(), // يجب استخدام setLocale بطريقة أخرى
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath','check.branch']
    ],
    function () {

        Route::prefix('presence')->middleware(['auth'])->group(function () {

            Route::prefix('attendance-records')->group(function () {
                Route::get('/index', [AttendanceRecordsController::class, 'index'])->name('attendance_records.index');
                Route::get('create', [AttendanceRecordsController::class, 'create'])->name('Attendance.attendance-records.create');
            });

            Route::prefix('attendance-sheets')->group(function () {
                Route::get('/index', [AttendanceSheetsController::class, 'index'])->name('attendance_sheets.index');
                Route::get('/create', [AttendanceSheetsController::class, 'create'])->name('attendance_sheets.create');
                Route::get('/edit/{id}', [AttendanceSheetsController::class, 'edit'])->name('attendance_sheets.edit');
                Route::get('/show/{id}', [AttendanceSheetsController::class, 'show'])->name('attendance_sheets.show');
                Route::post('/store', [AttendanceSheetsController::class, 'store'])->name('attendance_sheets.store');
                Route::post('/update/{id}', [AttendanceSheetsController::class, 'update'])->name('attendance_sheets.update');
                Route::get('/delete/{id}', [AttendanceSheetsController::class, 'delete'])->name('attendance_sheets.delete');
            });

            Route::prefix('attendanceDays')->group(function () {
                Route::get('/index', [AttendanceDaysController::class, 'index'])->name('attendanceDays.index');
                Route::get('/create', [AttendanceDaysController::class, 'create'])->name('attendanceDays.create');
                Route::get('/edit/{id}', [AttendanceDaysController::class, 'edit'])->name('attendanceDays.edit');
                Route::get('/show/{id}', [AttendanceDaysController::class, 'show'])->name('attendanceDays.show');
                Route::post('/store', [AttendanceDaysController::class, 'store'])->name('attendanceDays.store');
                Route::post('/update/{id}', [AttendanceDaysController::class, 'update'])->name('attendanceDays.update');
                Route::get('/calculation', [AttendanceDaysController::class, 'calculation'])->name('attendanceDays.calculation');
                Route::get('/delete/{id}', [AttendanceDaysController::class, 'delete'])->name('attendanceDays.delete');
                Route::post('/calculateAttendance', [AttendanceDaysController::class, 'calculateAttendance'])->name('calculateAttendance');
            });

            Route::prefix('leave-permissions')->group(function () {
                Route::get('/index', [LeavePermissionsController::class, 'index'])->name('leave_permissions.index');
                Route::get('/create', [LeavePermissionsController::class, 'create'])->name('leave_permissions.create');
                Route::post('/store', [LeavePermissionsController::class, 'store'])->name('leave_permissions.store');
                Route::get('/show/{id}', [LeavePermissionsController::class, 'show'])->name('leave_permissions.show');
                Route::get('/edit/{id}', [LeavePermissionsController::class, 'edit'])->name('leave_permissions.edit');
                Route::post('/update/{id}', [LeavePermissionsController::class, 'update'])->name('leave_permissions.update');
                Route::get('/delete/{id}', [LeavePermissionsController::class, 'delete'])->name('leave_permissions.delete');
            });

            Route::prefix('leave_requests')->group(function () {
                Route::get('/index', [LeaveRequestsController::class, 'index'])->name('attendance.leave_requests.index');
                Route::get('create', [LeaveRequestsController::class,'create'])->name('attendance.leave_requests.create');
            });

            Route::prefix('custom-shifts')->group(function () {
                Route::get('/index', [CustomShiftsController::class,'index'])->name('custom_shifts.index');
                Route::get('/create', [CustomShiftsController::class,'create'])->name('custom_shifts.create');
                Route::post('/store', [CustomShiftsController::class,'store'])->name('custom_shifts.store');
                Route::get('/show/{id}', [CustomShiftsController::class,'show'])->name('custom_shifts.show');
                Route::get('/edit/{id}', [CustomShiftsController::class,'edit'])->name('custom_shifts.edit');
                Route::post('/update/{id}', [CustomShiftsController::class,'update'])->name('custom_shifts.update');
                Route::get('/delete/{id}', [CustomShiftsController::class,'delete'])->name('custom_shifts.delete');
            });

            Route::prefix('attendance-sessions-record')->group(function () {
                Route::get('/index', [AttendanceSessionsRecordController::class, 'index'])->name('Attendance.attendance-sessions-record.index');
            });

            Route::prefix('settings')->group(function () {
                Route::get('/index', [SettingsController::class, 'index'])->name('attendance.settings.index');
                # Holiday lists
                Route::prefix('holiday-lists')->group(function () {
                    Route::get('/index', [HolidayController::class,'index'])->name('holiday_lists.index');
                    Route::get('/create', [HolidayController::class,'create'])->name('holiday_lists.create');
                    Route::post('/store', [HolidayController::class,'store'])->name('holiday_lists.store');
                    Route::get('/show/{id}', [HolidayController::class,'show'])->name('holiday_lists.show');
                    Route::get('/edit/{id}', [HolidayController::class,'edit'])->name('holiday_lists.edit');
                    Route::post('/update/{id}', [HolidayController::class,'update'])->name('holiday_lists.update');
                    Route::get('/delete/{id}', [HolidayController::class,'delete'])->name('holiday_lists.delete');
                    Route::get('/holyday_employees/{id}', [HolidayController::class,'holyday_employees'])->name('holiday_lists.holyday_employees');
                    Route::post('/holyday_employees/add/{id}', [HolidayController::class,'add_holyday_employees'])->name('holiday_lists.add_holyday_employees');
                });
                # Leave Types
                Route::prefix('leave-types')->group(function () {
                    Route::get('/index', [LeaveTypesController::class,'index'])->name('leave_types.index');
                    Route::get('/create', [LeaveTypesController::class,'create'])->name('leave_types.create');
                    Route::post('/store', [LeaveTypesController::class,'store'])->name('leave_types.store');
                    Route::get('/show/{id}', [LeaveTypesController::class,'show'])->name('leave_types.show');
                    Route::get('/edit/{id}', [LeaveTypesController::class,'edit'])->name('leave_types.edit');
                    Route::post('/update/{id}', [LeaveTypesController::class,'update'])->name('leave_types.update');
                    Route::get('/delete/{id}', [LeaveTypesController::class,'delete'])->name('leave_types.delete');
                });
                # Leave Policy
                Route::prefix('leave-policies')->group(function () {
                    Route::get('/index', [LeavePoliciesController::class, 'index'])->name('leave_policy.index');
                    Route::get('create', [LeavePoliciesController::class, 'create'])->name('leave_policy.create');
                    Route::post('store', [LeavePoliciesController::class, 'store'])->name('leave_policy.store');
                    Route::get('show/{id}', [LeavePoliciesController::class, 'show'])->name('leave_policy.show');
                    Route::get('edit/{id}', [LeavePoliciesController::class, 'edit'])->name('leave_policy.edit');
                    Route::post('update/{id}', [LeavePoliciesController::class, 'update'])->name('leave_policy.update');
                    Route::get('delete/{id}', [LeavePoliciesController::class, 'delete'])->name('leave_policy.delete');
                    Route::get('updateStatus/{id}', [LeavePoliciesController::class, 'updateStatus'])->name('leave_policy.updateStatus');
                    Route::get('leave_policy_employees/{id}', [LeavePoliciesController::class, 'leave_policy_employees'])->name('leave_policy.leave_policy_employees');
                    Route::post('/leave_policy_employees/add/{id}', [LeavePoliciesController::class,'add_leave_policy_employees'])->name('leave_policy.add_leave_policy_employees');
                });
                # Basic settings
                Route::prefix('basic-settings')->group(function () {
                    Route::get('/index', [BasicController::class, 'index'])->name('settings_basic.index');
                    Route::post('/update', [BasicController::class, 'update'])->name('settings_basic.update');
                });
                # Attendance Determinants
                Route::prefix('attendance_determinants')->group(function () {
                    Route::get('/index', [AttendanceDeterminantsController::class, 'index'])->name('attendance_determinants.index');
                    Route::get('/create', [AttendanceDeterminantsController::class, 'create'])->name('attendance_determinants.create');
                    Route::post('/store', [AttendanceDeterminantsController::class, 'store'])->name('attendance_determinants.store');
                    Route::get('/show/{id}', [AttendanceDeterminantsController::class, 'show'])->name('attendance_determinants.show');
                    Route::get('/edit/{id}', [AttendanceDeterminantsController::class, 'edit'])->name('attendance_determinants.edit');
                    Route::post('/update/{id}', [AttendanceDeterminantsController::class, 'update'])->name('attendance_determinants.update');
                    Route::get('/delete/{id}', [AttendanceDeterminantsController::class, 'delete'])->name('attendance_determinants.delete');
                    Route::get('updateStatus/{id}', [AttendanceDeterminantsController::class, 'updateStatus'])->name('attendance_determinants.updateStatus');
                });

            });

            Route::prefix('attendance.Settings.flags')->group(function () {
                Route::get('/index', [FlagsController::class, 'index'])->name('attendance.settings.flags.index');
                Route::get('create', [FlagsController::class, 'create'])->name('attendance.settings.flags.create');
            });

            Route::prefix('attendance.Settings.machines')->group(function () {
                Route::get('/index', [MachinesController::class, 'index'])->name('attendance.settings.machines.index');
                Route::get('create', [MachinesController::class, 'create'])->name('attendance.settings.machines.create');
                Route::post('store', [MachinesController::class, 'store'])->name('attendance.settings.machines.store');
                Route::get('show/{id}', [MachinesController::class, 'show'])->name('attendance.settings.machines.show');
                Route::get('edit/{id}', [MachinesController::class, 'edit'])->name('attendance.settings.machines.edit');
                Route::put('update/{id}', [MachinesController::class, 'update'])->name('attendance.settings.machines.update');
                Route::delete('destroy/{id}', [MachinesController::class, 'destroy'])->name('attendance.settings.machines.destroy');
            });

            Route::prefix('attendance.Settings.printable-templates')->group(function () {
                Route::get('/index', [PrintableTemplatesController::class, 'index'])->name('attendance.settings.printable-templates.index');
                Route::get('create', [PrintableTemplatesController::class, 'create'])->name('attendance.settings.printable-templates.create');
            });

        });

    });
