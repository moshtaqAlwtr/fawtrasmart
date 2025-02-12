<?php


use App\Http\Controllers\Reservations\ReservationsController;
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


Route::group(

    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath',]
    ],
    function () {

        Route::prefix('Reservations')->middleware(['auth'])->group(function () {




            Route::prefix('Reservations')->group(function () {
                Route::get('/index', [ReservationsController::class, 'index'])->name('Reservations.index');
                Route::get('/create', [ReservationsController::class, 'create'])->name('Reservations.create');
                Route::get('Booking_Settings', [ReservationsController::class,  'BookingSettings'])->name('Reservations.Booking_Settings');
                Route::post('/store', [ReservationsController::class, 'store'])->name('Reservations.store');
                Route::get('/edit/{id}', [ReservationsController::class, 'edit'])->name('Reservations.edit');
                Route::post('/update/{id}', [ReservationsController::class, 'update'])->name('Reservations.update');
                Route::get('/delete/{id}', [ReservationsController::class, 'delete'])->name('Reservations.delete');
            });
        }
        );
    }
);
