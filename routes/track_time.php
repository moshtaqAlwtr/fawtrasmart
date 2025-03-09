<?php

use App\Http\Controllers\OrganizationalStructure\DepartmentController;
use App\Http\Controllers\OrganizationalStructure\JobTitleController;
use App\Http\Controllers\OrganizationalStructure\ManagingFunctionalLevelsController;
use App\Http\Controllers\OrganizationalStructure\ManagingJobTypesController;
use App\Http\Controllers\TrackTime\ActivitiesTrackTimeController;
use App\Http\Controllers\TrackTime\AverageHoursTrackTimeController;
use App\Http\Controllers\TrackTime\ProjectTrackTimeController;
use App\Http\Controllers\TrackTime\SittingTrackTimeController;
use App\Http\Controllers\TrackTime\TrackTimeController;
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
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath','check.branch'],
    ],
    function () {
        Route::prefix('TrackTime')
            ->middleware(['auth', 'role:manager'])
            ->group(function () {

                Route::prefix('TrackTime')->group(function () {
                    Route::get('/index', [TrackTimeController::class, 'index'])->name('TrackTime.index');
                    Route::get('/create_invoice_time', [TrackTimeController::class, 'create_invoice_time'])->name('TrackTime.create_invoice_time');
                    Route::get('/show', [TrackTimeController::class, 'show'])->name('TrackTime.show');
                });

                Route::prefix('Sitting')->group(function () {
                    Route::get('/index', [SittingTrackTimeController::class, 'index'])->name('SittingTrackTime.index');
                    Route::get('/create', [SittingTrackTimeController::class, 'create'])->name('SittingTrackTime.create');

                });
                Route::prefix('Project')->group(function () {
                    Route::get('/index', [ProjectTrackTimeController::class, 'index'])->name('ProjectTrackTime.index');
                    Route::get('/create', [ProjectTrackTimeController::class, 'create'])->name('ProjectTrackTime.create');

                });
                Route::prefix('Activities')->group(function () {
                    Route::get('/index', [ActivitiesTrackTimeController::class, 'index'])->name('Activities.index');
                    Route::get('/create', [ActivitiesTrackTimeController::class, 'create'])->name('Activities.create');

                });
                Route::prefix('AverageHours ')->group(function () {
                    Route::get('/index', [AverageHoursTrackTimeController::class, 'index'])->name('AverageHours.index');
                    Route::get('/create', [AverageHoursTrackTimeController::class, 'create'])->name('AverageHours.create');
                    Route::get('/edit', [AverageHoursTrackTimeController::class, 'edit'])->name('AverageHours.edit');

                });
            });
    },
);
