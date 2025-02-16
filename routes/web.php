<?php

use App\Http\Controllers\Client\ClientController;

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Appointments\AppointmentController;
use App\Http\Controllers\Appointments\AppointmentNoteController;
use App\Http\Controllers\Sales\CreditNotificationController;
use App\Http\Controllers\Sales\InvoicesController;
use App\Http\Controllers\Sales\PeriodicInvoicesController;
use App\Http\Controllers\Sales\QuoteController;
use App\Http\Controllers\Sales\RevolvingInvoicesController;

use App\Http\Controllers\Accounts\AssetsController;
use App\Http\Controllers\Accounts\AccountsChartController;
use App\Http\Controllers\Commission\CommissionController;
use App\Http\Controllers\Sales\OffersController;
use App\Http\Controllers\Sales\PaymentClientController;
use App\Http\Controllers\Sales\PaymentProcessController;
use App\Http\Controllers\Sales\ReturnInvoiceController;
use App\Http\Controllers\Sales\ShippingOptionsController;
use App\Http\Controllers\Sales\SittingInvoiceController;

require __DIR__ . '/auth.php';

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
    ],
    function () {
        Route::prefix('sales')
            ->middleware(['auth'])
            ->group(function () {
                # invoices routes
                Route::prefix('invoices')
                    ->middleware(['auth'])
                    ->group(function () {
                        Route::get('/index', [InvoicesController::class, 'index'])->name('invoices.index');
                        Route::get('/create', [InvoicesController::class, 'create'])->name('invoices.create');
                        Route::get('/show/{id}', [InvoicesController::class, 'show'])->name('invoices.show');
                        Route::get('/edit/{id}', [InvoicesController::class, 'edit'])->name('invoices.edit');
                        Route::post('/store', [InvoicesController::class, 'store'])->name('invoices.store');
                        Route::delete('/delete/{id}', [InvoicesController::class, 'destroy'])->name('invoices.destroy');
                        Route::get('/{id}/generatePdf', [InvoicesController::class, 'generatePdf'])->name('invoices.generatePdf');
                    });

                Route::prefix('ReturnIInvoices')->group(function () {
                    Route::get('/index', [ReturnInvoiceController::class, 'index'])->name('ReturnIInvoices.index');
                    Route::get('/create/{id}', [ReturnInvoiceController::class, 'create'])->name('ReturnIInvoices.create');
                    Route::get('/show/{id}', [ReturnInvoiceController::class, 'show'])->name('ReturnIInvoices.show');
                    Route::get('/edit/{id}', [ReturnInvoiceController::class, 'edit_brand'])->name('ReturnIInvoices.edit');
                    Route::post('/store', [ReturnInvoiceController::class, 'store'])->name('ReturnIInvoices.store');
                    Route::put('/update/{id}', [ReturnInvoiceController::class, 'update'])->name('ReturnIInvoices.update');
                    Route::delete('/destroy/{id}', [ReturnInvoiceController::class, 'destroy'])->name('ReturnIInvoices.destroy');
                });
                Route::prefix('RevolvingInvoices')->group(function () {
                    Route::get('/index', [RevolvingInvoicesController::class, 'index'])->name('revolving_invoices.index');
                    Route::get('/create', [RevolvingInvoicesController::class, 'create'])->name('revolving_invoices.create');
                    Route::get('/show', [RevolvingInvoicesController::class, 'show'])->name('revolving_invoices.show');
                    Route::get('/edit/{id}', [RevolvingInvoicesController::class, 'edit_brand'])->name('revolving_invoices.edit');
                    Route::post('/store', [RevolvingInvoicesController::class, 'store'])->name('revolving_invoices.store');
                    Route::put('/update/{id}', [RevolvingInvoicesController::class, 'update'])->name('revolving_invoices.update');
                    Route::delete('/delete/{id}', [RevolvingInvoicesController::class, 'delete'])->name('revolving_invoices.delete');
                });

                Route::prefix('CreditNotes')->group(function () {
                    Route::get('/index', [CreditNotificationController::class, 'index'])->name('CreditNotes.index');
                    Route::get('/create', [CreditNotificationController::class, 'create'])->name('CreditNotes.create');
                    Route::get('/show/{id}', [CreditNotificationController::class, 'show'])->name('CreditNotes.show');
                    Route::get('/edit/{id}', [CreditNotificationController::class, 'edit'])->name('CreditNotes.edit');
                    Route::post('/store', [CreditNotificationController::class, 'store'])->name('CreditNotes.store');
                    Route::put('/update/{id}', [CreditNotificationController::class, 'update'])->name('CreditNotes.update');
                    Route::delete('/destroy/{id}', [CreditNotificationController::class, 'destroy'])->name('CreditNotes.destroy');
                    Route::get('/print/{id}', [CreditNotificationController::class, 'print'])->name('CreditNotes.print');
                });

                #questions routes
                Route::prefix('questions')->group(function () {
                    Route::get('/index', [QuoteController::class, 'index'])->name('questions.index');
                    Route::get('/create', [QuoteController::class, 'create'])->name('questions.create');
                    Route::get('/show/{id}', [QuoteController::class, 'show'])->name('questions.show');
                    Route::get('/edit/{id}', [QuoteController::class, 'edit'])->name('questions.edit');
                    Route::post('/store', [QuoteController::class, 'store'])->name('questions.store');
                    Route::put('/update/{id}', [QuoteController::class, 'update'])->name('questions.update');
                    Route::post('/convertToInvoice/{id}', [QuoteController::class, 'convertToInvoice'])->name('questions.convertToInvoice');
                    Route::delete('/delete/{id}', [QuoteController::class, 'destroy'])->name('questions.destroy');
                });

                Route::prefix('appointments')->group(function () {
                    Route::get('/index', [AppointmentController::class, 'index'])->name('appointments.index');
                    Route::get('/create', [AppointmentController::class, 'create'])->name('appointments.create');
                    Route::post('/store', [AppointmentController::class, 'store'])->name('appointments.store');
                    Route::get('/show/{id}', [AppointmentController::class, 'show'])->name('appointments.show');
                    Route::get('/{id}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
                    Route::match(['PUT', 'PATCH'], '/{id}', [AppointmentController::class, 'update'])->name('appointments.update');
                    Route::delete('/destroy/{id}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');

                    // Add this route for update-status
                    Route::post('/update-status', [AppointmentController::class, 'updateStatus'])->name('appointments.update.status');

                    Route::delete('/destroy', [AppointmentController::class, 'destroyAppointment'])->name('appointments.destroy');

                    Route::get('/filter', [AppointmentController::class, 'filterAppointments'])->name('appointments.filter');

                    // جلب تفاصيل الموعد الكاملة
                    Route::get('/appointments/{id}/full-details', [AppointmentController::class, 'getFullAppointmentDetails'])->name('appointments.full-details');
                    Route::patch('/appointments/{id}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.update-status');
                });

                // مسارات الملاحظات
                Route::prefix('appointment-notes')->group(function () {
                    Route::get('/', [AppointmentNoteController::class, 'index'])->name('appointment.notes.index');
                    Route::get('/create', [AppointmentNoteController::class, 'create'])->name('appointment.notes.create');
                    Route::post('/', [AppointmentNoteController::class, 'store'])->name('appointment.notes.store');
                    Route::get('/{note}', [AppointmentNoteController::class, 'show'])->name('appointment.notes.show');
                    Route::get('/{note}', [AppointmentNoteController::class, 'edit'])->name('appointment.notes.edit');
                    Route::put('/{note}', [AppointmentNoteController::class, 'update'])->name('appointment.notes.update');
                    Route::delete('/{note}', [AppointmentNoteController::class, 'destroy'])->name('appointment.notes.destroy');
                    Route::get('/{note}/download/{index}', [AppointmentNoteController::class, 'downloadAttachment'])->name('appointment.notes.download');
                });

                Route::prefix('periodic-invoices')->group(function () {
                    Route::get('/index', [PeriodicInvoicesController::class, 'index'])->name('periodic_invoices.index');
                    Route::get('/create', [PeriodicInvoicesController::class, 'create'])->name('periodic_invoices.create');
                    Route::post('/store', [PeriodicInvoicesController::class, 'store'])->name('periodic_invoices.store');
                    Route::get('/show/{id}', [PeriodicInvoicesController::class, 'show'])->name('periodic_invoices.show');

                    Route::get('/edit/{id}', [PeriodicInvoicesController::class, 'edit'])->name('periodic_invoices.edit');
                    Route::put('/update/{id}', [PeriodicInvoicesController::class, 'update'])->name('periodic_invoices.update');

                    Route::delete('/destroy/{id}', [PeriodicInvoicesController::class, 'destroy'])->name('periodic_invoices.destroy');
                });

                Route::prefix('account')
                    ->middleware(['auth'])
                    ->group(function () {
                        Route::resource('Assets', AssetsController::class);
                        Route::get('Assets/{id}/pdf', [AssetsController::class, 'generatePdf'])->name('Assets.generatePdf');
                        Route::get('Assets/{id}/sell', [AssetsController::class, 'showSellForm'])->name('Assets.showSell');
                        Route::post('Assets/{id}/sell', [AssetsController::class, 'sell'])->name('Assets.sell');
                        Route::get('/chart/details/{accountId}', [AccountsChartController::class, 'getAccountDetails'])->name('account.details');
                        Route::post('/set-error', function (Illuminate\Http\Request $request) {
                            session()->flash('error', $request->message);
                            return response()->json(['success' => true]);
                        });
                    });
            });

        Route::prefix('clients')
            ->middleware(['auth'])
            ->group(function () {
                # Client routes
                Route::prefix('clients_management')->group(function () {
                    Route::get('/index', [ClientController::class, 'index'])->name('clients.index');
                    Route::get('/create', [ClientController::class, 'create'])->name('clients.create');
                    Route::get('/mang_client', [ClientController::class, 'mang_client'])->name('clients.mang_client');
                    Route::post('/store', [ClientController::class, 'store'])->name('clients.store');
                    Route::get('/edit/{id}', [ClientController::class, 'edit_question'])->name('clients.edit');
                    Route::get('/show/client/{id}', [ClientController::class, 'show'])->name('clients.show');
                    Route::put('/update/{id}', [ClientController::class, 'update'])->name('clients.update');
                    Route::delete('/{id}', [ClientController::class, 'destroy'])->name('clients.destroy');
                    Route::post('/delete-multiple', [ClientController::class, 'deleteMultiple'])->name('clients.deleteMultiple');
                    Route::get('/contacts', [ClientController::class, 'contacts'])->name('clients.contacts');
                    Route::get('/show-contant/{id}', [ClientController::class, 'show_contant'])->name('clients.show_contant');
                });
                Route::get('/mang_client', [ClientController::class, 'mang_client'])->name('clients.mang_client');
                Route::get('/mang_client/{id}', [ClientController::class, 'mang_client_details'])->name('clients.mang_client_details');
                Route::prefix('paymentsClient')->group(function () {
                    Route::get('/index', [PaymentProcessController::class, 'index'])->name('paymentsClient.index');
                    Route::get('/paymentsClient/create/{id}/{type?}', [PaymentProcessController::class, 'create'])->name('paymentsClient.create');
                    Route::post('/store', [PaymentProcessController::class, 'store'])->name('paymentsClient.store');
                    Route::get('/show/{id}', [PaymentProcessController::class, 'show'])->name('paymentsClient.show');
                    Route::get('/edit/{id}', [PaymentProcessController::class, 'edit'])->name('paymentsClient.edit');
                    Route::delete('/destroy/{id}', [PaymentProcessController::class, 'destroy'])->name('paymentsClient.destroy');

                    Route::put('/update/{id}', [PaymentProcessController::class, 'update'])->name('paymentsClient.update');
                    Route::get('payments/invoice-details/{invoice_id}', [PaymentProcessController::class, 'getInvoiceDetails'])->name('paymentsClient.invoice-details');               });
                Route::prefix('Sitting')->group(function () {
                    Route::get('/index', [SittingInvoiceController::class, 'index'])->name('SittingInvoice.index');
                });
                Route::prefix('offers')->group(function () {
                    Route::get('/index', [OffersController::class, 'index'])->name('Offers.index');
                    Route::get('/create', [OffersController::class, 'create'])->name('Offers.create');
                    Route::post('/store', [OffersController::class, 'store'])->name('Offers.store');
                    Route::get('/show/{id}', [OffersController::class, 'show'])->name('Offers.show');
                    Route::get('/edit/{id}', [OffersController::class, 'edit'])->name('Offers.edit');
                    Route::put('/update/{id}', [OffersController::class, 'update'])->name('Offers.update');
                    Route::delete('/destroy/{id}', [OffersController::class, 'destroy'])->name('Offers.destroy');
                    Route::post('/updateStatus/{id}', [OffersController::class, 'updateStatus'])->name('Offers.updateStatus');
                });
                Route::prefix('shippingOptions')->group(function () {
                    Route::get('/index', [ShippingOptionsController::class, 'index'])->name('shippingOptions.index');
                    Route::get('/create', [ShippingOptionsController::class, 'create'])->name('shippingOptions.create');
                    Route::post('/store', [ShippingOptionsController::class, 'store'])->name('shippingOptions.store');
                    Route::get('/edit/{id}', [ShippingOptionsController::class, 'edit'])->name('shippingOptions.edit');
                    Route::put('/update/{id}', [ShippingOptionsController::class, 'update'])->name('shippingOptions.update');
                    Route::get('/show/{id}', [ShippingOptionsController::class, 'show'])->name('shippingOptions.show');
                    Route::delete('/destroy/{id}', [ShippingOptionsController::class, 'destroy'])->name('shippingOptions.destroy');
                    Route::get('/updateStatus/{id}', [ShippingOptionsController::class, 'updateStatus'])->name('shippingOptions.updateStatus');
                });
            });

        Route::prefix('accounts')
            ->middleware(['auth'])
            ->group(function () {
                Route::get('/tree', [AccountsChartController::class, 'getTree'])->name('accounts.tree');
                Route::get('/showDetails/{id}', [AccountsChartController::class, 'showDetails'])->name('account.showDetails');
                Route::get('/chart/details/{accountId}', [AccountsChartController::class, 'getAccountDetails'])->name('accounts.details');
                Route::get('/{id}/children', [AccountsChartController::class, 'getChildren'])->name('accounts.children');
            });

//العمولة
          Route::prefix('commission')
            ->middleware(['auth'])
            ->group(function () {
                Route::get('/index', [CommissionController::class, 'index'])->name('commission.index');
                Route::get('/create', [CommissionController::class, 'create'])->name('commission.create');
                Route::post('/create', [CommissionController::class, 'store'])->name('commission.store');
                Route::get('/products/search', [CommissionController::class, 'searchProducts'])->name('products.search');
                Route::get('/edit/{id}', [CommissionController::class, 'edit'])->name('commission.edit');
                Route::post('/update/{id}', [CommissionController::class, 'update'])->name('commission.update');
                
            });
    },
);


