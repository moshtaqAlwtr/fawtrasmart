<?php




use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstallmentsController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

require __DIR__ . '/auth.php';

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        Route::prefix('Installments')->middleware(['auth', 'role:manager'])->group(function () {
            // صفحة الفهرس
            Route::get('/index', [InstallmentsController::class, 'index'])->name('installments.index');
            Route::get('agreement_installments', [InstallmentsController::class,    'agreement'])->name('installments.agreement_installments');

          
        });
    }
);

