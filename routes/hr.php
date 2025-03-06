<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Hr\EmployeeController;
use App\Http\Controllers\Hr\ManagingEmployeeRolesController;
use App\Http\Controllers\Hr\ShiftManagementController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require __DIR__ . '/auth.php';


Route::group(

    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath',]
    ], function(){

        Route::prefix('hr')->middleware(['auth'])->group(function () {

            # employee routes
            Route::prefix('employee')->group(function () {
                Route::get('/index',[EmployeeController::class,'index'])->name('employee.index');
                Route::get('/create',[EmployeeController::class,'create'])->name('employee.create');
                Route::get('/edit/{id}',[EmployeeController::class,'edit'])->name('employee.edit');
                Route::get('/show/{id}',[EmployeeController::class,'show'])->name('employee.show');
                Route::get('/updateStatus/{id}',[EmployeeController::class,'updateStatus'])->name('employee.updateStatus');
                Route::post('/store',[EmployeeController::class,'store'])->name('employee.store');
                Route::post('/update/{id}',[EmployeeController::class,'update'])->name('employee.update');
                Route::post('/updatePassword/{id}',[EmployeeController::class,'updatePassword'])->name('employee.updatePassword');
                Route::get('/delete/{id}',[EmployeeController::class,'delete'])->name('employee.delete');
                Route::get('/login/to/{id}', [EmployeeController::class, 'login_to'])->name('employee.login_to');
                Route::get('/export/view',[EmployeeController::class,'export_view'])->name('employee.export_view');
                Route::post('/export',[EmployeeController::class,'export'])->name('employee.export');

                Route::get('/send_email/{id}',[EmployeeController::class,'send_email'])->name('employee.send_email');

            });

            # employee managing employee roles
            Route::prefix('managing_employee_roles')->group(function () {
                Route::get('/index',[ManagingEmployeeRolesController::class,'index'])->name('managing_employee_roles.index');
                Route::get('/create_test',[ManagingEmployeeRolesController::class,'create_test'])->name('managing_employee_roles.create_test');
                Route::get('/create',[ManagingEmployeeRolesController::class,'create'])->name('managing_employee_roles.create');
                Route::post('/store',[ManagingEmployeeRolesController::class,'store'])->name('managing_employee_roles.store');
                Route::get('/edit/{id}',[ManagingEmployeeRolesController::class,'edit'])->name('managing_employee_roles.edit');
                Route::post('/update/{id}',[ManagingEmployeeRolesController::class,'update'])->name('managing_employee_roles.update');
                Route::get('/delete/{id}',[ManagingEmployeeRolesController::class,'delete'])->name('managing_employee_roles.delete');
            });

            # employee shift management
            Route::prefix('shift_management')->group(function () {
                Route::get('/index',[ShiftManagementController::class,'index'])->name('shift_management.index');
                Route::get('/create',[ShiftManagementController::class,'create'])->name('shift_management.create');
                Route::post('/store',[ShiftManagementController::class,'store'])->name('shift_management.store');
                Route::get('/edit/{id}',[ShiftManagementController::class,'edit'])->name('shift_management.edit');
                Route::post('/update/{id}',[ShiftManagementController::class,'update'])->name('shift_management.update');
                Route::get('/delete/{id}',[ShiftManagementController::class,'delete'])->name('shift_management.delete');
                Route::get('/show/{id}',[ShiftManagementController::class,'show'])->name('shift_management.show');
            });



            # employee routes
            Route::prefix('employee')->group(function () {
                Route::get('/employee_role_management',[EmployeeController::class,'employee_management'])->name('employee.employee_role_management');
                Route::get('/manage_shifts',[EmployeeController::class,'manage_shifts'])->name('employee.shifts');
                Route::get('/add_shift',[EmployeeController::class,'add_shift'])->name('add_shift');
                Route::get('/employee_role_management/add_new_role',[EmployeeController::class,'add_new_role'])->name('employee.employee_role_management.add_new_role');
            });

        });



});
