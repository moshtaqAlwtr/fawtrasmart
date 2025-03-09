<?php




use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Reports\ActivityController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

require __DIR__ . '/auth.php';

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath','check.branch']
    ],
    function () {
        Route::prefix('reports.Activity')->middleware(['auth', 'role:manager'])->group(function () {
            // صفحة الفهرس
            Route::get('/index', [ActivityController::class, 'index'])->name('reports.Activity.index');

          
        });
    }
);

