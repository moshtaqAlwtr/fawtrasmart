<?php

use App\Http\Controllers\Accounts\AccountsChartController;
use App\Http\Controllers\Accounts\AccountsSettingsController;
use App\Http\Controllers\Accounts\AssetsController;
use App\Http\Controllers\Accounts\CostCentersController;
use App\Http\Controllers\Accounts\JournalEntryController;
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

// Route::get('/', function () {
//     return view('master');
// });

require __DIR__ . '/auth.php';

Route::get('/accounts/tree', [AccountsChartController::class, 'getTree']);
Route::get('/accounts/{id}/children', [AccountsChartController::class, 'getChildren']);
Route::get('/accounts/parents', [AccountsChartController::class, 'getParents']);
Route::get('/accounts/{parent}/next-code', [AccountsChartController::class, 'getNextCode']);
Route::post('/set-error', function (Illuminate\Http\Request $request) {
    session()->flash('error', $request->message);
    return response()->json(['success' => true]);
});

Route::delete('/accounts/{parentId}/delete', [AccountsChartController::class, 'destroy']);
Route::post('/accounts/store_account', [AccountsChartController::class, 'store_account']);
Route::get('/accounts/{id}/edit', [AccountsChartController::class, 'edit']);
Route::put('/accounts/{id}/update', [AccountsChartController::class, 'update']);

Route::get('/cost_centers/tree', [CostCentersController::class, 'getTree']);
Route::get('/cost_centers/parents', [CostCentersController::class, 'getParents']);
Route::get('/cost_centers/{id}/children', [CostCentersController::class, 'getChildren']);
Route::get('/cost_centers/{parent}/next-code', [CostCentersController::class, 'getNextCode']);
Route::get('/cost_centers/{parentId}/details', [CostCentersController::class, 'getAccountDetails']);
Route::delete('/cost_centers/{parentId}/delete', [CostCentersController::class, 'destroy']);
Route::post('/cost_centers/store_account', [CostCentersController::class, 'store_account']);
Route::get('/cost_centers/{id}/edit', [CostCentersController::class, 'edit']);
Route::put('/cost_centers/{id}/update', [CostCentersController::class, 'update']);

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath','check.branch'],
    ],
    function () {
        Route::prefix('Accounts')
            ->middleware(['auth'])
            ->group(function () {
                Route::prefix('journal')->group(function () {
                    Route::get('/index', [JournalEntryController::class, 'index'])->name('journal.index');
                    Route::get('/create', [JournalEntryController::class, 'create'])->name('journal.create');
                    Route::post('/store', [JournalEntryController::class, 'store'])->name('journal.store');
                    Route::get('/show/{id}', [JournalEntryController::class, 'show'])->name('journal.show');
                    Route::get('/edit/{id}', [JournalEntryController::class, 'edit'])->name('journal.edit');
                    Route::put('/update/{id}', [JournalEntryController::class, 'update'])->name('journal.update');
                    Route::delete('/destroy/{id}', [JournalEntryController::class, 'destroy'])->name('journal.destroy');
                });

                Route::prefix('cost_centers')->group(function () {
                    Route::get('/index', [CostCentersController::class, 'index'])->name('cost_centers.index');
                });

                Route::prefix('accounts_chart')->group(function () {
                    Route::get('/index', [AccountsChartController::class, 'index'])->name('accounts_chart.index');
                    Route::get('/testone/{accountId}', [AccountsChartController::class, 'testone'])->name('accounts_chart.testone');
                    Route::get('/getJournalEntries/{accountId}/journal-entries', [AccountsChartController::class, 'getJournalEntries'])->name('accounts_chart.getJournalEntries');
                    Route::get('/accounts/{accountId}/balance', [AccountsChartController::class, 'getAccountWithBalance']);
                    Route::get('/accounts/search', [AccountsChartController::class, 'search'])->name('accounts_chart.search');
                    Route::delete('/destroy/{id}', [AccountsChartController::class, 'destroy'])->name('accounts_chart.destroy');
                    Route::get('/showDetails/{id}', [AccountsChartController::class, 'showDetails'])->name('accounts_chart.showDetails');
                                        Route::get('/chart/details/{accountId}', [AccountsChartController::class, 'getAccountDetails'])->name('accounts_chart.details');
                    Route::post('/store', [AccountsChartController::class, 'store_account'])->name('accounts_chart.store_account');
                });

                Route::prefix('Assets')->group(function () {
                    Route::get('/index', [AssetsController::class, 'index'])->name('Assets.index');
                    Route::get('/create', [AssetsController::class, 'create'])->name('Assets.create');
                    Route::post('/store', [AssetsController::class, 'store'])->name('Assets.store');
                    Route::get('/show/{id}', [AssetsController::class, 'show'])->name('Assets.show');
                    Route::get('/edit/{id}', [AssetsController::class, 'edit'])->name('Assets.edit');
                    Route::put('/update/{id}', [AssetsController::class, 'update'])->name('Assets.update');
                    Route::delete('/destroy/{id}', [AssetsController::class, 'destroy'])->name('Assets.destroy');
                    Route::get('Assets/pdf/{id}', [AssetsController::class, 'generatePdf'])->name('assets.generatePdf');
                });

                Route::prefix('accounts_settings')->group(function () {
                    Route::get('/index', [AccountsSettingsController::class, 'index'])->name('accounts_settings.index'); //AccountsChartController::class,
                });
            });
    },
);
