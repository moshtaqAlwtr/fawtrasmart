<?php

use App\Http\Controllers\OrganizationalStructure\DepartmentController;
use App\Http\Controllers\OrganizationalStructure\JobTitleController;
use App\Http\Controllers\OrganizationalStructure\ManagingFunctionalLevelsController;
use App\Http\Controllers\OrganizationalStructure\ManagingJobTypesController;

use Illuminate\Support\Facades\Route;
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

    Route::prefix('OrganizationalStructure')->middleware(['auth', 'role:manager'])->group(function () {

        #questions routes
        Route::prefix('department')->group(function () {
            Route::get('/index',[DepartmentController::class,'index'])->name('department.index');
            Route::get('/create',[DepartmentController::class,'create'])->name('department.create');
            Route::get('/show/{id}',[DepartmentController::class,'show'])->name('department.show');
            Route::get('/edit/{id}',[DepartmentController::class,'edit'])->name('department.edit');
            Route::post('/store',[DepartmentController::class,'store'])->name('department.store');
            Route::post('/update/{id}',[DepartmentController::class,'update'])->name('department.update');
            Route::get('/delete/{id}',[DepartmentController::class,'delete'])->name('department.delete');
            Route::get('/updateStatus/{id}',[DepartmentController::class,'updateStatus'])->name('department.updateStatus');
            Route::get('/export/view',[DepartmentController::class,'export_view'])->name('department.export_view');
            Route::post('/export',[DepartmentController::class,'export'])->name('department.export');
        });

        Route::prefix('JobTitles')->group(function () {
            Route::get('/index',[JobTitleController::class,'index'])->name('JobTitles.index');
            Route::get('/create',[JobTitleController::class,'create'])->name('JobTitles.create');
            Route::get('/show/{id}',[JobTitleController::class,'show'])->name('JobTitles.show');
            Route::get('/edit/{id}',[JobTitleController::class,'edit'])->name('JobTitles.edit');
            Route::post('/store',[JobTitleController::class,'store'])->name('JobTitles.store');
            Route::post('/update/{id}',[JobTitleController::class,'update'])->name('JobTitles.update');
            Route::get('/delete/{id}',[JobTitleController::class,'delete'])->name('JobTitles.delete');
            Route::get('/updateStatus/{id}',[JobTitleController::class,'updateStatus'])->name('JobTitles.updateStatus');
        });

        Route::prefix('ManagingFunctionalLevels')->group(function () {
            Route::get('/index',[ManagingFunctionalLevelsController::class,'index'])->name('ManagingFunctionalLevels.index');
            Route::get('/create',[ManagingFunctionalLevelsController::class,'create'])->name('ManagingFunctionalLevels.create');
            Route::get('/show/{id}',[ManagingFunctionalLevelsController::class,'show'])->name('ManagingFunctionalLevels.show');
            Route::get('/edit/{id}',[ManagingFunctionalLevelsController::class,'edit'])->name('ManagingFunctionalLevels.edit');
            Route::post('/store',[ManagingFunctionalLevelsController::class,'store'])->name('ManagingFunctionalLevels.store');
            Route::post('/update/{id}',[ManagingFunctionalLevelsController::class,'update'])->name('ManagingFunctionalLevels.update');
            Route::get('/delete/{id}',[ManagingFunctionalLevelsController::class,'delete'])->name('ManagingFunctionalLevels.delete');
        });

        Route::prefix('ManagingJobTypes')->group(function () {
            Route::get('/index',[ManagingJobTypesController::class,'index'])->name('ManagingJobTypes.index');
            Route::get('/create',[ManagingJobTypesController::class,'create'])->name('ManagingJobTypes.create');
            Route::get('/show/{id}',[ManagingJobTypesController::class,'show'])->name('ManagingJobTypes.show');
            Route::get('/edit/{id}',[ManagingJobTypesController::class,'edit'])->name('ManagingJobTypes.edit');
            Route::post('/store',[ManagingJobTypesController::class,'store'])->name('ManagingJobTypes.store');
            Route::post('/update/{id}',[ManagingJobTypesController::class,'update'])->name('ManagingJobTypes.update');
            Route::get('/delete/{id}',[ManagingJobTypesController::class,'delete'])->name('ManagingJobTypes.delete');
            Route::get('/updateStatus/{id}',[ManagingJobTypesController::class,'updateStatus'])->name('ManagingJobTypes.updateStatus');
        });



    });

});

