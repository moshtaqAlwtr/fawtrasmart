<?php

use App\Http\Controllers\LoyaltyPoints\LoyaltyPointsController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
    ], function () {

        Route::prefix('Loyalty_Points')->middleware(['auth'])->group(function () {


            # نقاط الولاء
            Route::prefix('Loyalty_Points')->group(function () {
                Route::get('/index', [LoyaltyPointsController::class, 'index'])->name('loyalty_points.index');
                Route::get('/create', [LoyaltyPointsController::class, 'create'])->name('loyalty_points.create');
                Route::get('/Settings', [LoyaltyPointsController::class, 'Settings'])->name('loyalty_points.settings');
                Route::post('/store', [LoyaltyPointsController::class, 'store'])->name('loyalty_points.store');
                Route::get('/edit/{id}', [LoyaltyPointsController::class, 'edit'])->name('loyalty_points.edit');
                Route::post('/update/{id}', [LoyaltyPointsController::class, 'update'])->name('loyalty_points.update');
                Route::get('/delete/{id}', [LoyaltyPointsController::class, 'delete'])->name('loyalty_points.delete');
            });




        });
    });
