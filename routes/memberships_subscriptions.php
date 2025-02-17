<?php

use App\Http\Controllers\Memberships\MembershipsController;
use App\Http\Controllers\Memberships\SittingController;
use App\Http\Controllers\Memberships\SubscriptionController;
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
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
    ],
    function () {
        Route::prefix('Memberships')
            ->middleware(['auth', 'role:manager'])
            ->group(function () {
                Route::prefix('Memberships')->group(function () {
                    Route::get('/index', [MembershipsController::class, 'index'])->name('Memberships.index');
                    Route::get('/create', [MembershipsController::class, 'create'])->name('Memberships.create');
                    Route::get('/show/{id}', [MembershipsController::class, 'show'])->name('Memberships.show');
                    Route::get('/edit/{id}', [MembershipsController::class, 'edit'])->name('Memberships.edit');
                });
                Route::prefix('SittingMemberships')->group(function () {
                    Route::get('/index', [SittingController::class, 'index'])->name('SittingMemberships.index');
                    Route::get('/sitting', [SittingController::class, 'sitting'])->name('SittingMemberships.sitting');

                });
                Route::prefix('Subscription')->group(function () {
                    Route::get('/index', [SubscriptionController::class, 'index'])->name('Memberships.subscriptions.index');
                    Route::get('/sitting', [SubscriptionController::class, 'sitting'])->name('Memberships.subscriptions.create');

                });
            });
    },
);
