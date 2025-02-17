<?php

use App\Http\Controllers\LoyaltyPoints\LoyaltyPointsController;
use App\Http\Controllers\LoyaltyPoints\LoyaltyPointsSittingController;
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
                Route::get('/show/{id}', [LoyaltyPointsController::class, 'show'])->name('loyalty_points.show');
                Route::post('/store', [LoyaltyPointsController::class, 'store'])->name('loyalty_points.store');
                Route::get('/edit/{id}', [LoyaltyPointsController::class, 'edit'])->name('loyalty_points.edit');
                Route::put('/update/{id}', [LoyaltyPointsController::class, 'update'])->name('loyalty_points.update');
                Route::delete('/destroy/{id}', [LoyaltyPointsController::class, 'destroy'])->name('loyalty_points.destroy');

                Route::get('/updateStatus/{id}', [LoyaltyPointsController::class,'updateStatus'])->name('loyalty_points.updateStatus');
            });

            Route::prefix('sittingLoyalty')->group(function () {
                Route::get('/create', [LoyaltyPointsSittingController::class, 'create'])->name('sittingLoyalty.sitting');
                Route::post('/store', [LoyaltyPointsSittingController::class,'store'])->name('sittingLoyalty.store');

            });


            Route::prefix('CourseOfWork')->group(function () {
                Route::get('/create', [LoyaltyPointsSittingController::class, 'create'])->name('CourseOfWork.sitting');
                Route::post('/store', [LoyaltyPointsSittingController::class,'store'])->name('CourseOfWork.store');

            });





        });
    });
