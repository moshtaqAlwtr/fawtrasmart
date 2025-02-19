<?php

use App\Http\Controllers\InsuranceAgents\InsuranceAgentsClassController;
use App\Http\Controllers\InsuranceAgents\InsuranceAgentsController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

require __DIR__ . '/auth.php';

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],

    function () {
        Route::prefix('Insurance_Agents')->middleware(['auth', 'role:manager'])->group(function () {
            // صفحة الفهرس
            Route::get('/index', [InsuranceAgentsController::class, 'index'])->name('Insurance_Agents.index');
            Route::get('create', [InsuranceAgentsController::class,    'create'])->name('Insurance_Agents.create');
            Route::post('/store', [InsuranceAgentsController::class,'store'])->name('Insurance_Agents.store');
            Route::get('/show/{id}', [InsuranceAgentsController::class, 'show'])->name('Insurance_Agents.show');
            Route::get('/edit/{id}', [InsuranceAgentsController::class, 'edit'])->name('Insurance_Agents.edit');
            Route::put('/update/{id}', [InsuranceAgentsController::class, 'update'])->name('Insurance_Agents.update');
            Route::delete('/destroy/{id}', [InsuranceAgentsController::class, 'destroy'])->name('Insurance_Agents.destroy');
            Route::get('/updateStatus/{id}', [InsuranceAgentsController::class, 'updateStatus'])->name('Insurance_Agents.updateStatus');
        });
        Route::prefix('InsuranceAgentsClass')->middleware(['auth', 'role:manager'])->group(function () {
            // صفحة الفهرس
            Route::get('/create/{insurance_agent_id}', [InsuranceAgentsClassController::class, 'create'])->name('InsuranceAgentsClass.create');
            Route::post('/store', [InsuranceAgentsClassController::class,'store'])->name('InsuranceAgentsClass.store');
            Route::get('/show/{id}', [InsuranceAgentsClassController::class, 'show'])->name('InsuranceAgentsClass.show');
            Route::put('/update/{id}', [InsuranceAgentsClassController::class, 'update'])->name('InsuranceAgentsClass.update');
            Route::get('edit/{id}', [InsuranceAgentsClassController::class, 'edit'])->name('InsuranceAgentsClass.edit');
            Route::delete('/destroy/{id}', [InsuranceAgentsClassController::class, 'destroy'])->name('InsuranceAgentsClass.destroy');
        });
    }
);

