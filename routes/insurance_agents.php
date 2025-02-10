<?php




use App\Http\Controllers\InsuranceAgentsController;
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

          
        });
    }
);

