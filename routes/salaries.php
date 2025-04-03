<?php

use App\Http\Controllers\Salaries\AncestorController;
use App\Http\Controllers\Salaries\ContractsController;
use App\Http\Controllers\Salaries\PayrollProcessController;
use App\Http\Controllers\Salaries\RelatedModelsController;
use App\Http\Controllers\Salaries\SalaryItemsController;
use App\Http\Controllers\Salaries\SalarySittingController;
use App\Http\Controllers\Salaries\SalarySlipController;
use App\Http\Controllers\Salaries\SalaryTemplatesController;
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
        Route::prefix('Salaries')
            ->middleware(['auth', 'role:manager'])
            ->group(function () {
                Route::prefix('Contracts')->group(function () {
                    Route::get('/index', [ContractsController::class, 'index'])->name('Contracts.index');
                    Route::get('/create', [ContractsController::class, 'create'])->name('Contracts.create');
                    Route::post('/store', [ContractsController::class, 'store'])->name('Contracts.store');
                    Route::get('/show/{id}', [ContractsController::class, 'show'])->name('Contracts.show');
                    Route::get('/edit/{id}', [ContractsController::class, 'edit'])->name('Contracts.edit');
                    Route::put('/update/{id}', [ContractsController::class, 'update'])->name('Contracts.update');
                    Route::delete('/destroy/{id}', [ContractsController::class, 'destroy'])->name('Contracts.destroy');
                    Route::get('/contracts/print/{id}', [ContractsController::class, 'printContract'])->name('Contracts.print');
                    Route::get('/contracts/print1/{id}', [ContractsController::class, 'printContract1'])->name('Contracts.print1');
                });
                Route::prefix('PayrollProcess')->group(function () {
                    Route::get('/index', [PayrollProcessController::class, 'index'])->name('PayrollProcess.index');
                    Route::get('/create', [PayrollProcessController::class, 'create'])->name('PayrollProcess.create');
                    Route::post('/store', [PayrollProcessController::class, 'store'])->name('PayrollProcess.store');
                    Route::get('/show', [PayrollProcessController::class, 'show'])->name('PayrollProcess.show');
                    Route::get('/edit/{id}', [PayrollProcessController::class, 'edit'])->name('PayrollProcess.edit');
                    Route::delete('/destroy/{id}', [PayrollProcessController::class, 'destroy'])->name('PayrollProcess.destroy');
                });
                Route::prefix('SalarySlip')->group(function () {
                    Route::get('/index', [SalarySlipController::class, 'index'])->name('salarySlip.index');
                    Route::get('/create', [SalarySlipController::class, 'create'])->name('salarySlip.create');
                    Route::post('/store', [SalarySlipController::class, 'store'])->name('salarySlip.store');
                    Route::get('/show/{id}', [SalarySlipController::class, 'show'])->name('salarySlip.show');
                    Route::get('/salary/{id}/approve', [SalarySlipController::class, 'approve'])->name('salary.approve');
                    Route::get('/salary/{id}/cancel', [SalarySlipController::class, 'cancel'])->name('salary.cancel');

                    Route::get('/edit/{id}', [SalarySlipController::class, 'edit'])->name('salarySlip.edit');
                    Route::put('/update/{id}', [SalarySlipController::class, 'update'])->name('salarySlip.update');
                    Route::delete('/destroy/{id}', [SalarySlipController::class, 'destroy'])->name('salarySlip.destroy');
                    Route::get('salary-slip/{id}/printPayslip1', [SalarySlipController::class, 'printPayslip1'])->name('salarySlip.printPayslip1');
                    Route::get('salary-slip/{id}/printPayslip2', [SalarySlipController::class, 'printPayslip2'])->name('salarySlip.printPayslip2');
                    Route::get('salary-slip/{id}/printPayslip3', [SalarySlipController::class, 'printPayslip3'])->name('salarySlip.printPayslip3');
                    Route::get('salary-slip/{id}/printPayslipAr1', [SalarySlipController::class, 'printPayslipAr1'])->name('salarySlip.printPayslipAr1');
                    Route::get('salary-slip/{id}/printPayslipAr2', [SalarySlipController::class, 'printPayslipAr2'])->name('salarySlip.printPayslipAr2');
                    Route::get('salary-slip/{id}/printPayslipAr3', [SalarySlipController::class, 'printPayslipAr3'])->name('salarySlip.printPayslipAr3');
                });
                Route::prefix('ancestor')->group(function () {
                    Route::get('/index', [AncestorController::class, 'index'])->name('ancestor.index');
                    Route::get('/create', [AncestorController::class, 'create'])->name('ancestor.create');
                    Route::post('/store', [AncestorController::class, 'store'])->name('ancestor.store');
                    Route::get('/show/{id}', [AncestorController::class, 'show'])->name('ancestor.show');
                    Route::get('/edit/{id}', [AncestorController::class, 'edit'])->name('ancestor.edit');
                         Route::get('/pay/{id}', [AncestorController::class, 'pay'])->name('ancestor.pay');
                         Route::get('/salary-advance/{id}/pay', [AncestorController::class, 'pay'])->name('salary-advance.pay');
Route::post('/salary-advance/{id}/pay', [AncestorController::class, 'storePayments'])->name('salary-advance.store-payments');
                    Route::put('/update/{id}', [AncestorController::class, 'update'])->name('ancestor.update');
                    Route::delete('/destroy/{id}', [AncestorController::class, 'destroy'])->name('ancestor.destroy');
                });

                Route::prefix('SalaryItems')->group(function () {
                    Route::get('/index', [SalaryItemsController::class, 'index'])->name('SalaryItems.index');
                    Route::get('/create', [SalaryItemsController::class, 'create'])->name('SalaryItems.create');
                    Route::post('/store', [SalaryItemsController::class, 'store'])->name('SalaryItems.store');
                    Route::get('/show/{id}', [SalaryItemsController::class, 'show'])->name('SalaryItems.show');
                    Route::get('/edit/{id}', [SalaryItemsController::class, 'edit'])->name('SalaryItems.edit');
                    Route::put('/update/{id}', [SalaryItemsController::class, 'update'])->name('SalaryItems.update');
                    Route::delete('/destroy/{id}', [SalaryItemsController::class, 'destroy'])->name('SalaryItems.destroy');
                    Route::put('SalaryItems/{id}/toggle-status', [SalaryItemsController::class, 'toggleStatus'])->name('SalaryItems.toggleStatus');
                });
                Route::prefix('SalaryTemplates')->group(function () {
                    Route::get('/index', [SalaryTemplatesController::class, 'index'])->name('SalaryTemplates.index');
                    Route::get('/create', [SalaryTemplatesController::class, 'create'])->name('SalaryTemplates.create');
                    Route::post('/store', [SalaryTemplatesController::class, 'store'])->name('SalaryTemplates.store');
                    Route::get('/show/{id}', [SalaryTemplatesController::class, 'show'])->name('SalaryTemplates.show');
                    Route::get('/edit/{id}', [SalaryTemplatesController::class, 'edit'])->name('SalaryTemplates.edit');
                    Route::put('/update/{id}', [SalaryTemplatesController::class, 'update'])->name('SalaryTemplates.update');
                    Route::delete('/destroy/{id}', [SalaryTemplatesController::class, 'destroy'])->name('SalaryTemplates.destroy');
                });

                Route::prefix('SalarySittings')->group(function () {
                    Route::get('/index', [SalarySittingController::class, 'index'])->name('SalarySittings.index');
                });

                Route::prefix('RelatedModels')->group(function () {
                    Route::get('/index', [RelatedModelsController::class, 'index'])->name('RelatedModels.index');
                    Route::get('/create', [RelatedModelsController::class, 'create'])->name('RelatedModels.create');
                    Route::get('/show/{id}', [RelatedModelsController::class, 'show'])->name('RelatedModels.show');
                    Route::get('/edit/{id}', [RelatedModelsController::class, 'edit'])->name('RelatedModels.edit');
                });
            });
    },
);
