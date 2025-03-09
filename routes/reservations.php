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
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath','check.branch']
    ],
    function () {

        Route::prefix('Reservations')->middleware(['auth'])->group(function () {




            Route::prefix('Reservations')->group(function () {
                Route::get('/index', [ReservationsController::class, 'index'])->name('Reservations.index');
                Route::get('/create', [ReservationsController::class, 'create'])->name('Reservations.create');
                Route::get('Booking_Settings', [ReservationsController::class,  'BookingSettings'])->name('Reservations.Booking_Settings');
                Route::post('Booking_Setting', [ReservationsController::class, 'setting'])->name('Reservations.setting');
                Route::get('/show/{id}', [ReservationsController::class, 'show'])->name('Reservations.show');
                Route::post('/filter', [ReservationsController::class, 'filter'])->name('Reservations.filter');
                Route::put('/reservations/update-status/{id}', [ReservationsController::class, 'updateStatus'])->name('reservations.updateStatus');
                Route::get('/show/client/booking/{id}', [ReservationsController::class, 'client'])->name('Reservations.client');
                Route::post('/store', [ReservationsController::class, 'store'])->name('Reservations.store');
                Route::get('/edit/{id}', [ReservationsController::class, 'edit'])->name('Reservations.edit');
                Route::put('/update/{id}', [ReservationsController::class, 'update'])->name('Reservations.update');
                Route::get('/delete/{id}', [ReservationsController::class, 'delete'])->name('Reservations.delete');
            });
        }
        );
    }
);
