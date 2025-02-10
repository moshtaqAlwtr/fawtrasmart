<?php

use App\Http\Controllers\CustomerAttendanceController;
use App\Http\Controllers\Reports\WorkflowController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Reports\OrdersController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

require __DIR__ . '/auth.php';

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        Route::prefix('Customer_Attendance')->group(function () {
            Route::get('/', [CustomerAttendanceController::class, 'index'])->name('customer_attendance.index');

        });
    }
);
