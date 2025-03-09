<?php

use App\Http\Controllers\Cheques\CheckBooksController;
use App\Http\Controllers\Cheques\PayableChequesController;
use App\Http\Controllers\Cheques\ReceivedChequesController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

require __DIR__ . '/auth.php';

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath','check.branch']
    ],
    function () {
        Route::prefix('cheques')->middleware(['auth'])->group(function () {
            #Payable Cheques
            Route::prefix('payable_cheques')->group(function () {
                Route::get('/index',[PayableChequesController::class,'index'])->name('payable_cheques.index');
                Route::get('/create',[PayableChequesController::class,'create'])->name('payable_cheques.create');
                Route::get('/show/{id}',[PayableChequesController::class,'show'])->name('payable_cheques.show');
                Route::get('/edit/{id}',[PayableChequesController::class,'edit'])->name('payable_cheques.edit');
                Route::post('/store',[PayableChequesController::class,'store'])->name('payable_cheques.store');
                Route::post('/update/{id}',[PayableChequesController::class,'update'])->name('payable_cheques.update');
                Route::get('/search', [PayableChequesController::class, 'search'])->name('payable_cheques.search');
                Route::get('/get-checkbooks/{bankId}', [PayableChequesController::class, 'getCheckbooks'])->name('get.checkbooks');
            });

            #Received Cheques
            Route::prefix('received_cheques')->group(function () {
                Route::get('/index',[ReceivedChequesController::class,'index'])->name('received_cheques.index');
                Route::get('/create',[ReceivedChequesController::class,'create'])->name('received_cheques.create');
                Route::get('/show/{id}',[ReceivedChequesController::class,'show'])->name('received_cheques.show');
                Route::get('/edit/{id}',[ReceivedChequesController::class,'edit'])->name('received_cheques.edit');
                Route::post('/store',[ReceivedChequesController::class,'store'])->name('received_cheques.store');
                Route::post('/update/{id}',[ReceivedChequesController::class,'update'])->name('received_cheques.update');
                Route::get('/search', [ReceivedChequesController::class, 'search'])->name('received_cheques.search');
                Route::get('/get-checkbooks/{bankId}', [ReceivedChequesController::class, 'getCheckbooks'])->name('get.checkbooks');
            });

            #Check books
            Route::prefix('check_books')->group(function () {
                Route::get('/index',[CheckBooksController::class,'index'])->name('check_books.index');
                Route::get('/create',[CheckBooksController::class,'create'])->name('check_books.create');
                Route::get('/show/{id}',[CheckBooksController::class,'show'])->name('check_books.show');
                Route::get('/edit/{id}',[CheckBooksController::class,'edit'])->name('check_books.edit');
                Route::post('/store',[CheckBooksController::class,'store'])->name('check_books.store');
                Route::post('/update/{id}',[CheckBooksController::class,'update'])->name('check_books.update');
                Route::get('/delete/{id}',[CheckBooksController::class,'delete'])->name('check_books.delete');
                Route::get('/search', [CheckBooksController::class, 'search'])->name('check_books.search');
            });


        });
    });
