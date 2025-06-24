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
use Illuminate\Http\Request;
use App\Http\Controllers\Accounts\AssetsController;
use App\Http\Controllers\Accounts\AccountsChartController;
use App\Http\Controllers\Client\ClientSettingController;
use App\Http\Controllers\Client\GroupsController;
use App\Http\Controllers\Client\VisitController;
use App\Http\Controllers\Commission\CommissionController;
use App\Http\Controllers\EmployeeTargetController;
use App\Http\Controllers\Logs\LogController;
use App\Http\Controllers\Sales\OffersController;
use App\Http\Controllers\Sales\PaymentClientController;
use App\Http\Controllers\Sales\PaymentProcessController;
use App\Http\Controllers\Sales\ReturnInvoiceController;
use App\Http\Controllers\Sales\ShippingOptionsController;
use App\Http\Controllers\Sales\SittingInvoiceController;
use App\Http\Controllers\StatisticsController;
use App\Models\Client;
use App\Models\Offer;
use Illuminate\Support\Facades\Http;

Route::get('/test/send', [ClientSettingController::class, 'test'])->name('clients.test_send');
Route::get('/print/questions/{id}', [QuoteController::class, 'print'])->name('questions.print');
Route::get('/send-daily-report', [VisitController::class, 'sendDailyReport']);
Route::get('/send-weekly-report', [VisitController::class, 'sendWeeklyReport']);
Route::get('/send-monthly-report', [VisitController::class, 'sendMonthlyReport']);

require __DIR__ . '/auth.php';

Route::get('/{id}/print', [InvoicesController::class, 'print'])->name('invoices.print');
Route::get('/text/editor', function () {
    return view('text_editor');
});
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'check.branch'],
    ],

    function () {
        Route::middleware(['auth', 'client.access'])->group(function () {
            Route::get('/personal', [ClientSettingController::class, 'personal'])->name('clients.personal');
            Route::get('/invoice/client', [ClientSettingController::class, 'invoice_client'])->name('clients.invoice_client'); // الفواتير
            Route::get('/appointments/client', [ClientSettingController::class, 'appointments_client'])->name('clients.appointments_client'); // المواعيد
            Route::get('/SupplyOrders/client', [ClientSettingController::class, 'SupplyOrders_client'])->name('clients.SupplyOrders_client'); // أوامر الشغل
            Route::get('/questions/client', [ClientSettingController::class, 'questions_client'])->name('clients.questions_client'); // عروض الأسعار
            Route::get('/edit/profile', [ClientSettingController::class, 'profile'])->name('clients.profile');
            Route::get('/employee-targets', [EmployeeTargetController::class, 'index'])->name('employee_targets.index');
            Route::post('/employee-targets', [EmployeeTargetController::class, 'storeOrUpdate'])->name('employee_targets.store');
            Route::get('/general-target', [EmployeeTargetController::class, 'showGeneralTarget'])->name('target.show');
            Route::post('/general-target', [EmployeeTargetController::class, 'updateGeneralTarget'])->name('target.update');
            Route::get('/client-target', [EmployeeTargetController::class, 'client_target'])->name('target.client');
            Route::get('/client-target-create', [EmployeeTargetController::class, 'client_target_create'])->name('target.client.create');
            Route::post('/client-target-create', [EmployeeTargetController::class, 'client_target_store'])->name('target.client.update');
            Route::put('/Client/store', [ClientSettingController::class, 'Client_store'])->name('clients.Client_store');
            // التحصيل اليومي
            Route::get('/daily_closing_entry', [EmployeeTargetController::class, 'daily_closing_entry'])->name('daily_closing_entry');

            // احصائيات الزيارات 
             Route::get('/visitTarget', [EmployeeTargetController::class, 'visitTarget'])->name('visitTarget');
             Route::post('/visitTarget', [EmployeeTargetController::class, 'updatevisitTarget'])->name('target.visitTarget');
            //احصائيات الفروع

            Route::get('/statistics_branch', [StatisticsController::class, 'StatisticsGroup'])->name('statistics.group');

            //احصائيات المجموعات

            Route::get('/statistics_group', [StatisticsController::class, 'Group'])->name('statistics.groupall');

            // احصائيات الاحياء

            Route::get('/statistics_neighborhood', [StatisticsController::class, 'neighborhood'])->name('statistics.neighborhood');
        });
        Route::prefix('sales')
            ->middleware(['auth', 'check.branch'])
            ->group(function () {
                # invoices routes
                Route::prefix('invoices')
                    ->middleware(['auth'])
                    ->group(function () {
                        Route::get('/index', [InvoicesController::class, 'index'])->name('invoices.index');
                        Route::get('/ajax/invoices', [InvoicesController::class, 'ajaxInvoices'])->name('invoices.ajax');
                        Route::get('/create', [InvoicesController::class, 'create'])->name('invoices.create');
                        Route::post('/verify/code', [InvoicesController::class, 'verify_code'])->name('invoice.verify_code');
                        Route::get('/get-client/{id}', function ($id) {
                            $client = Client::find($id);
                            return response()->json($client);
                        });

                        Route::post('/send/verification', [InvoicesController::class, 'sendVerificationCode']);
                        
                        Route::get('/send/invoice/{id}', [InvoicesController::class, 'send_invoice'])->name('invoices.send');
                        Route::post('/verify-code', [InvoicesController::class, 'verifyCode']);
                        Route::get('/invoices/{id}/label', [InvoicesController::class, 'label'])->name('invoices.label');
                        Route::get('/invoices/{id}/picklist', [InvoicesController::class, 'picklist'])->name('invoices.picklist');
                        Route::get('/invoices/{id}/shipping_label', [InvoicesController::class, 'shipping_label'])->name('invoices.shipping_label');
                        Route::get('/show/{id}', [InvoicesController::class, 'show'])->name('invoices.show');
                        Route::post('/invoices/import', [InvoicesController::class, 'import'])->name('invoices.import');
                        Route::get('/edit/{id}', [InvoicesController::class, 'edit'])->name('invoices.edit');
                        Route::post('/store', [InvoicesController::class, 'store'])->name('invoices.store');
                        Route::delete('/delete/{id}', [InvoicesController::class, 'destroy'])->name('invoices.destroy');
                        Route::get('/{id}/generatePdf', [InvoicesController::class, 'generatePdf'])->name('invoices.generatePdf');

                        Route::get('/get-price', [InvoicesController::class, 'getPrice'])->name('get-price');
                        Route::get('/notifications/unread', [InvoicesController::class, 'getUnreadNotifications'])->name('notifications.unread');
                        Route::post('/notifications/mark', [InvoicesController::class, 'markAsRead'])->name('notifications.markAsRead');

                        Route::get('/notifications/mark/show/{id}', [InvoicesController::class, 'markAsReadid'])->name('notifications.markAsReadid');
                        Route::get('/notifications', [InvoicesController::class, 'notifications'])->name('notifications.index');
                        Route::post('/invoices/{invoice}/signatures', [InvoicesController::class, 'storeSignatures'])
    ->name('invoices.signatures.store');
                    });

                Route::prefix('ReturnIInvoices')->group(function () {
                    Route::get('/index', [ReturnInvoiceController::class, 'index'])->name('ReturnIInvoices.index');
                    Route::get('/create/{id}', [ReturnInvoiceController::class, 'create'])->name('ReturnIInvoices.create');
                    Route::get('/show/{id}', [ReturnInvoiceController::class, 'show'])->name('ReturnIInvoices.show');
                    Route::get('/{id}/print', [ReturnInvoiceController::class, 'print'])->name('return.print');
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
                    Route::get('/logsaction', [QuoteController::class, 'logsaction'])->name('questions.logsaction');
                    Route::post('/store', [QuoteController::class, 'store'])->name('questions.store');
                    Route::put('/update/{id}', [QuoteController::class, 'update'])->name('questions.update');
                    Route::post('/convertToInvoice/{id}', [QuoteController::class, 'convertToInvoice'])->name('questions.convertToInvoice');
                    Route::delete('/delete/{id}', [QuoteController::class, 'destroy'])->name('questions.destroy');
                    Route::get('/quotes/{id}/pdf', [QuoteController::class, 'downloadPdf'])->name('quotes.pdf');
                    Route::get('quotes/{quote}/edit-template', [QuoteController::class, 'editTemplate'])->name('quotes.template.edit');
                    Route::put('quotes/{quote}/update-template', [QuoteController::class, 'updateTemplate'])->name('quotes.template.update');
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
                    Route::get('/create/{id}', [AppointmentNoteController::class, 'create'])->name('appointment.notes.create');
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
                    Route::post('clients/update-credit-limit', [ClientController::class, 'updateCreditLimit'])->name('clients.update_credit_limit');

                    Route::get('/testcient', [ClientController::class, 'testcient'])->name('clients.testcient');
                    Route::get('/notes/clients', [ClientController::class, 'notes'])->name('clients.notes');
                    Route::post('/clients/{id}/update-status', [ClientController::class, 'updateStatus']);

                    Route::get('/send_info/{id}', [ClientController::class, 'send_email'])->name('clients.send_info');
                    // اعدادات العميل
                    Route::get('/setting', [ClientSettingController::class, 'setting'])->name('clients.setting');
                    Route::get('/general/settings', [ClientSettingController::class, 'general'])->name('clients.general');
                    Route::post('/general/settings', [ClientSettingController::class, 'store'])->name('clients.store_general');
                    Route::get('/status/clients', [ClientSettingController::class, 'status'])->name('clients.status');
                    Route::post('/status/store', [ClientSettingController::class, 'storeStatus'])->name('clients.status.store');


                    Route::post('/update-client-status', [ClientController::class, 'updateStatusClient'])->name('clients.updateStatusClient');

                    Route::delete('/status/delete/{id}', [ClientSettingController::class, 'deleteStatus'])->name('clients.status.delete');
                    // صلاحيات العميل
                    Route::get('/permission/settings', [ClientSettingController::class, 'permission'])->name('clients.permission');
                    Route::post('/permission/settings', [ClientSettingController::class, 'permission_store'])->name('clients.store_permission');

                    Route::get('/create', [ClientController::class, 'create'])->name('clients.create');
                    Route::post('/clients/import', [ClientController::class, 'import'])->name('clients.import');
                    Route::get('/mang_client', [ClientController::class, 'mang_client'])->name('clients.mang_client');
                    Route::post('/mang_client', [ClientController::class, 'mang_client_store'])->name('clients.mang_client_store');

                    Route::post('/addnotes', [ClientController::class, 'addnotes'])->name('clients.addnotes');
                    Route::post('/store', [ClientController::class, 'store'])->name('clients.store');
                    Route::get('/clients/{client_id}/notes', [ClientController::class, 'getClientNotes']);
                    Route::get('/edit/{id}', [ClientController::class, 'edit_question'])->name('clients.edit');
                    Route::get('/show/client/{id}', [ClientController::class, 'show'])->name('clients.show');
                    Route::get('/statement/{id}', [ClientController::class, 'statement'])->name('clients.statement');
                    Route::put('/update/{id}', [ClientController::class, 'update'])->name('clients.update');
                    Route::delete('/{id}', [ClientController::class, 'destroy'])->name('clients.destroy');
                    Route::post('/delete-multiple', [ClientController::class, 'deleteMultiple'])->name('clients.deleteMultiple');
                    Route::get('/contacts', [ClientController::class, 'contacts'])->name('clients.contacts');
                    Route::get('/first', [ClientController::class, 'getFirstClient'])->name('clients.first');
                    Route::get('/next', [ClientController::class, 'getNextClient'])->name('clients.next');
                    Route::get('/previous', [ClientController::class, 'getPreviousClient'])->name('clients.previous');
                    Route::post('/{id}/update-opening-balance', [ClientController::class, 'updateOpeningBalance']);

                    Route::post('/clients/{client}/assign-employees', [ClientController::class, 'assignEmployees'])->name('clients.assign-employees');
                    Route::post('/clients/{client}/remove-employee', [ClientController::class, 'removeEmployee'])->name('clients.remove-employee');
                    Route::get('/clients/{client}/assigned-employees', [ClientController::class, 'getAssignedEmployees'])->name('clients.get-assigned-employees');
                    Route::get('/clients_management/clients/all', [ClientController::class, 'getAllClients'])->name('clients.all');
                    Route::get('/show-contant/{id}', [ClientController::class, 'show_contant'])->name('clients.show_contant');
                    Route::get('/clients/search', function (Request $request) {
                        $query = $request->query('query');

                        $clients = Client::with('latestStatus')
                            ->where('trade_name', 'LIKE', "%{$query}%")
                            ->orWhere('first_name', 'LIKE', "%{$query}%")
                            ->orWhere('last_name', 'LIKE', "%{$query}%")
                            ->orWhere('phone', 'LIKE', "%{$query}%")
                            ->orWhere('mobile', 'LIKE', "%{$query}%")
                            ->orWhere('city', 'LIKE', "%{$query}%")
                            ->orWhere('region', 'LIKE', "%{$query}%")
                            ->orWhere('email', 'LIKE', "%{$query}%")
                            ->limit(10)
                            ->get();

                        return response()->json($clients);
                    });
                });
                Route::prefix('group')->group(function () {
  Route::get('/group', [GroupsController::class, 'group_client'])->name('groups.group_client');
                    Route::get('/group/create', [GroupsController::class, 'group_client_create'])->name('groups.group_client_create');
                    Route::post('/group/store', [GroupsController::class, 'group_client_store'])->name('groups.group_client_store');
                    Route::get('/group/edit/{id}', [GroupsController::class, 'group_client_edit'])->name('groups.group_client_edit');
                    Route::put('/group/update/{id}', [GroupsController::class, 'group_client_update'])->name('groups.group_client_update');
                    Route::delete('/group/delete/{id}', [GroupsController::class, 'group_client_destroy'])->name('groups.group_client_destroy');

                });

                Route::get('/mang_client', [ClientController::class, 'mang_client'])->name('clients.mang_client');
                Route::get('/mang_client/{id}', [ClientController::class, 'mang_client_details'])->name('clients.mang_client_details');
                Route::prefix('paymentsClient')->group(function () {
                    Route::get('/index', [PaymentProcessController::class, 'index'])->name('paymentsClient.index');
                    Route::get('/paymentsClient/create/{id}/{type?}', [PaymentProcessController::class, 'create'])->name('paymentsClient.create');
                    Route::post('/store', [PaymentProcessController::class, 'store'])->name('paymentsClient.store');
                    Route::get('/show/{id}', [PaymentProcessController::class, 'show'])->name('paymentsClient.show');
                    Route::get('/edit/{id}', [PaymentProcessController::class, 'edit'])->name('paymentsClient.edit');
                    Route::post('/clients/{client}/force-show', [ClientController::class, 'forceShow'])
    ->name('clients.force-show');

                    Route::get('/rereceipt/{id}', [PaymentProcessController::class, 'rereceipt'])->name('paymentsClient.rereceipt');
                    Route::get('/receipt/pdf/{id}', [PaymentProcessController::class, 'pdfReceipt'])->name('paymentsClient.pdf');

                    Route::delete('/destroy/{id}', [PaymentProcessController::class, 'destroy'])->name('paymentsClient.destroy');

                    Route::put('/update/{id}', [PaymentProcessController::class, 'update'])->name('paymentsClient.update');
                    Route::get('payments/invoice-details/{invoice_id}', [PaymentProcessController::class, 'getInvoiceDetails'])->name('paymentsClient.invoice-details');
                });
                Route::prefix('Sitting')->group(function () {
                    Route::get('/index', [SittingInvoiceController::class, 'index'])->name('SittingInvoice.index');

                    Route::get('/', [SittingInvoiceController::class, 'bill_designs'])->name('SittingInvoice.bill_designs');
                    Route::get('/create', [SittingInvoiceController::class, 'create'])->name('templates.create');
                    Route::post('/', [SittingInvoiceController::class, 'store'])->name('templates.store');
                    Route::get('/{template}/edit', [SittingInvoiceController::class, 'edit'])->name('templates.edit');
                    Route::put('/{template}', [SittingInvoiceController::class, 'update'])->name('templates.update');
                    Route::post('/template/preview', [SittingInvoiceController::class, 'preview'])->name('template.preview');
                    Route::post('/{template}/reset', [SittingInvoiceController::class, 'reset'])->name('templates.reset');
                    Route::delete('/{template}', [SittingInvoiceController::class, 'destroy'])->name('templates.destroy');

                    Route::get('/invoice', [SittingInvoiceController::class, 'invoice'])->name('SittingInvoice.invoice');

                    Route::get('/test_print', [SittingInvoiceController::class, 'test_print'])->name('templates.test_print');
                    Route::get('/test_print/{id}', [SittingInvoiceController::class, 'print'])->name('templates.print');
                });
                Route::prefix('offers')->group(function () {
                    Route::get('/index', [OffersController::class, 'index'])->name('Offers.index');
                    Route::get('/create', [OffersController::class, 'create'])->name('Offers.create');
                    Route::post('/store', [OffersController::class, 'store'])->name('Offers.store');
                    Route::get('/show/{id}', [OffersController::class, 'show'])->name('Offers.show');
                    Route::get('/edit/{id}', [OffersController::class, 'edit'])->name('Offers.edit');
                    Route::put('/update/{id}', [OffersController::class, 'update'])->name('Offers.update');
                    Route::get('/active-offers', function (Request $request) {
                        $today = now()->format('Y-m-d');
                        $clientId = $request->client_id;

                        $offers = Offer::with(['clients', 'products', 'categories'])
                            ->where('is_active', true)
                            ->whereDate('valid_from', '<=', $today)
                            ->whereDate('valid_to', '>=', $today)
                            ->get()
                            ->map(function ($offer) {
                                return [
                                    'id' => $offer->id,
                                    'name' => $offer->name,
                                    'type' => $offer->type,
                                    'unit_type' => $offer->unit_type,
                                    'quantity' => $offer->quantity,
                                    'discount_type' => $offer->discount_type,
                                    'discount_value' => $offer->discount_value,
                                    'valid_from' => $offer->valid_from,
                                    'valid_to' => $offer->valid_to,
                                    'clients' => $offer->clients->map(fn($c) => ['id' => $c->id]),
                                    'products' => $offer->products->map(fn($p) => ['id' => $p->id]),
                                    'categories' => $offer->categories->map(fn($cat) => ['id' => $cat->id])
                                ];
                            });



                        return response()->json($offers);
                    });
                    Route::get('/destroy/{id}', [OffersController::class, 'destroy'])->name('Offers.destroy');
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
        Route::prefix('visits')
            ->middleware(['auth'])
            ->group(function () {
                Route::post('/visits', [VisitController::class, 'storeEmployeeLocation'])->name('visits.storeEmployeeLocation');
                Route::get('/visits/today', [VisitController::class, 'getTodayVisits'])
                    ->middleware('auth')
                    ->name('visits.today');


    
                Route::get('/traffic-analysis', [VisitController::class, 'tracktaff'])->name('traffic.analysis');
                Route::post('/get-weeks-data', [VisitController::class, 'getWeeksData'])->name('get.weeks.data');
                Route::post('/get-traffic-data', [VisitController::class, 'getTrafficData'])->name('get.traffic.data');


                Route::post('/visits/location-enhanced', [VisitController::class, 'storeLocationEnhanced'])
                    ->name('visits.storeLocationEnhanced');


                Route::post('/visits/location-enhanced', [VisitController::class, 'storeLocationEnhanced'])->name('visits.storeLocationEnhanced');

                Route::get('/tracktaff', [VisitController::class, 'tracktaff'])->name('visits.tracktaff');

                // إضافة هذا المسار للانصراف التلقائي
                Route::get('/process-auto-departures', [VisitController::class, 'checkAndProcessAutoDepartures'])
                    ->name('visits.processAutoDepartures');
                Route::get('/send-daily-report', [VisitController::class, 'sendDailyReport']);
                // إضافة مسار للانصراف اليدوي
                Route::post('/manual-departure/{visitId}', [VisitController::class, 'manualDeparture'])
                    ->name('visits.manualDeparture');
            });
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
        Route::prefix('logs')
            ->middleware(['auth'])
            ->group(function () {
                Route::get('/index', [LogController::class, 'index'])->name('logs.index');
            });
    },




);
