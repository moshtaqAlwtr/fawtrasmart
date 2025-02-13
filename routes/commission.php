use App\Http\Controllers\Commission\CommissionController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {  // يجب إضافة function () هنا
        Route::prefix('commission')->middleware(['auth'])->group(function () {
            Route::get('/index', [CommissionController::class, 'index']);
        });
    }
);