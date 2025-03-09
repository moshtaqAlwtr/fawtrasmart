<?php




use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Installments\InstallmentsController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

require __DIR__ . '/auth.php';

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath','check.branch']
    ],
    function () {
        Route::prefix('Installments')->middleware(['auth', 'role:manager'])->group(function () {
            // صفحة الفهرس
            Route::get('/index', [InstallmentsController::class, 'index'])->name('installments.index');
            Route::get('/create', [InstallmentsController::class, 'create'])->name('installments.create');
            Route::post('/store', [InstallmentsController::class, 'store'])->name('installments.store');
            Route::get('/edit/{id}', [InstallmentsController::class, 'edit'])->name('installments.edit');
            Route::get('/edit_amount/{id}', [InstallmentsController::class, 'edit_amount'])->name('installments.edit_amount');
            Route::get('/show_amount/{id}', [InstallmentsController::class, 'show_amount'])->name('installments.show_amount');
            Route::put('/update/{id}', [InstallmentsController::class, 'update'])->name('installments.update');
            Route::delete('/destroy/{id}', [InstallmentsController::class, 'destroy'])->name('installments.destroy');
            Route::get('/show/{id}', [InstallmentsController::class, 'show'])->name('installments.show');
            Route::get('agreement_installments', [InstallmentsController::class,    'agreement'])->name('installments.agreement_installments');


        });
    }
);

