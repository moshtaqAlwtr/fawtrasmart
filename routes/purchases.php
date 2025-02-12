<?php

use App\Http\Controllers\Purchases\CityNoticesController;
use App\Http\Controllers\Purchases\CreditMemosController;

use App\Http\Controllers\Purchases\InvoiceSettingsController;
use App\Http\Controllers\Purchases\InvoicesPurchaseController;
use App\Http\Controllers\Purchases\OrdersPurchaseController;
use App\Http\Controllers\Purchases\PurchaseOrdersRequestsController;
use App\Http\Controllers\Purchases\QuotationsController;

use App\Http\Controllers\Purchases\ReturnsInvoiceController;
use App\Http\Controllers\Purchases\SupplierManagementController;
use App\Http\Controllers\Purchases\SupplierPaymentsController;
use App\Http\Controllers\Purchases\SupplierSettingsController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Purchases\ViewPurchasePriceController;
use App\Http\Controllers\Sales\PaymentProcessController;
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
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
    ],
    function () {
        Route::prefix('Purchases')
            ->middleware(['auth'])
            ->group(function () {
                //طلبات الشراء
                Route::prefix('Orders')->group(function () {
                    Route::get('/index', [OrdersPurchaseController::class, 'index'])->name('OrdersPurchases.index');
                    Route::get('/create', [OrdersPurchaseController::class, 'create'])->name('OrdersPurchases.create');
                    Route::post('/store', [OrdersPurchaseController::class, 'store'])->name('OrdersPurchases.store');
                    Route::get('edit/{id}', [OrdersPurchaseController::class, 'edit'])->name('OrdersPurchases.edit');
                    Route::put('update/{id}', [OrdersPurchaseController::class, 'update'])->name('OrdersPurchases.update');
                    Route::get('/show/{id}', [OrdersPurchaseController::class, 'show'])->name('OrdersPurchases.show');

                    Route::post('OrdersPurchases/{id}/approve', [OrdersPurchaseController::class, 'approve'])->name('OrdersPurchases.approve');
                    Route::post('OrdersPurchases/{id}/reject', [OrdersPurchaseController::class, 'reject'])->name('OrdersPurchases.reject');
                    Route::delete('/destroy/{id}', [OrdersPurchaseController::class, 'destroy'])->name('OrdersPurchases.destroy');
                });

                //طلبات عروض الأسعار
                Route::prefix('Quotations')->group(function () {
                    Route::get('/index', [QuotationsController::class, 'index'])->name('Quotations.index');
                    Route::get('/create', [QuotationsController::class, 'create'])->name('Quotations.create');
                    Route::post('/store', [QuotationsController::class, 'store'])->name('Quotations.store');
                    Route::get('/edit/{id}', [QuotationsController::class, 'edit'])->name('Quotations.edit');
                    Route::put('/update/{id}', [QuotationsController::class, 'update'])->name('Quotations.update');
                    Route::post('  Quotations/{id}/approve', [QuotationsController::class, 'approve'])->name('Quotations.approve');
                    Route::post('Quotations/{id}/reject', [QuotationsController::class, 'reject'])->name('Quotations.reject');
                    Route::delete('/destroy/{id}', [QuotationsController::class, 'destroy'])->name('Quotations.destroy');
                    Route::get('/show/{id}', [QuotationsController::class, 'show'])->name('Quotations.show');
                    Route::get('/duplicate/{id}', [QuotationsController::class, 'duplicate'])->name('Quotations.duplicate');
                });

                # عروض أسعار المشتريات
                Route::prefix('pricesPurchase')->group(function () {
                    Route::get('/index', [ViewPurchasePriceController::class, 'index'])->name('pricesPurchase.index');
                    Route::get('/create', [ViewPurchasePriceController::class, 'create'])->name('pricesPurchase.create');
                    Route::post('/store', [ViewPurchasePriceController::class, 'store'])->name('pricesPurchase.store');
                    Route::get('/edit/{id}', [ViewPurchasePriceController::class, 'edit'])->name('pricesPurchase.edit');
                    Route::put('/update/{id}', [ViewPurchasePriceController::class, 'update'])->name('pricesPurchase.update');
                    Route::delete('/destroy/{id}', [ViewPurchasePriceController::class, 'destroy'])->name('pricesPurchase.destroy');
                    Route::get('/show/{id}', [ViewPurchasePriceController::class, 'show'])->name('pricesPurchase.show');
                    Route::get('pricesPurchase/{id}/pdf', [ViewPurchasePriceController::class, 'exportPDF'])->name('pricesPurchase.pdf');
                    Route::post('pricesPurchase/{id}/convert-to-po', [ViewPurchasePriceController::class, 'convertToPurchaseOrder'])->name('pricesPurchase.convertToPurchaseOrder');
                    Route::put('pricesPurchase/{id}/status', [ViewPurchasePriceController::class, 'updateStatus'])->name('pricesPurchase.updateStatus');
                });

                //  أوامر الشراء
                Route::prefix('OrdersRequest')->group(function () {
                    Route::get('/index', [PurchaseOrdersRequestsController::class, 'index'])->name('OrdersRequests.index');
                    Route::get('/create', [PurchaseOrdersRequestsController::class, 'create'])->name('OrdersRequests.create');
                    Route::post('/store', [PurchaseOrdersRequestsController::class, 'store'])->name('OrdersRequests.store');
                    Route::get('/edit/{id}', [PurchaseOrdersRequestsController::class, 'edit'])->name('OrdersRequests.edit');
                    Route::put('/update/{id}', [PurchaseOrdersRequestsController::class, 'update'])->name('OrdersRequests.update');
                    Route::delete('/destroy/{id}', [PurchaseOrdersRequestsController::class, 'destroy'])->name('OrdersRequests.destroy');
                    Route::put('orders-requests/{id}/update-status', [PurchaseOrdersRequestsController::class, 'updateStatus'])->name('OrdersRequests.updateStatus');
                    Route::get('/show/{id}', [PurchaseOrdersRequestsController::class, 'show'])->name('OrdersRequests.show');
                });
                //  فواتير الشراء
                Route::prefix('invoicePurchases.index')->group(function () {
                    Route::get('/index', [InvoicesPurchaseController::class, 'index'])->name('invoicePurchases.index');
                    Route::get('/create', [InvoicesPurchaseController::class, 'create'])->name('invoicePurchases.create');
                    Route::post('/store', [InvoicesPurchaseController::class, 'store'])->name('invoicePurchases.store');
                    Route::get('/edit/{id}', [InvoicesPurchaseController::class, 'edit'])->name('invoicePurchases.edit');
                    Route::put('/update/{id}', [InvoicesPurchaseController::class, 'update'])->name('invoicePurchases.update');
                    Route::delete('/destroy/{id}', [InvoicesPurchaseController::class, 'destroy'])->name('invoicePurchases.destroy');
                    Route::get('/show/{id}', [InvoicesPurchaseController::class, 'show'])->name('invoicePurchases.show');
                    Route::get('invoicePurchases/{id}/pdf', [InvoicesPurchaseController::class, 'exportPDF'])->name('invoicePurchases.pdf');
                    Route::post('invoicePurchases/{id}/convert-to-credit-memo', [InvoicesPurchaseController::class, 'convertToCreditMemo'])->name('invoicePurchases.convertToCreditMemo');
                });
                //  مرتجعات المشتريات
                Route::prefix('ReturnsInvoice')->group(function () {
                    Route::get('/index', [ReturnsInvoiceController::class, 'index'])->name('ReturnsInvoice.index');
                    Route::get('/create', [ReturnsInvoiceController::class, 'create'])->name('ReturnsInvoice.create');
                    Route::post('/store', [ReturnsInvoiceController::class, 'store'])->name('ReturnsInvoice.store');
                    Route::get('/edit/{id}', [ReturnsInvoiceController::class, 'edit'])->name('ReturnsInvoice.edit');
                    Route::put('/update/{id}', [ReturnsInvoiceController::class, 'update'])->name('ReturnsInvoice.update');
                    Route::delete('/destroy/{id}', [ReturnsInvoiceController::class, 'destroy'])->name('ReturnsInvoice.destroy');
                    Route::get('/show/{id}', [ReturnsInvoiceController::class, 'show'])->name('ReturnsInvoice.show');
                });
                //  الأشعارات المدينة
                Route::prefix('CityNotices')->group(function () {
                    Route::get('/index', [CityNoticesController::class, 'index'])->name('CityNotices.index');
                    Route::get('/create', [CityNoticesController::class, 'create'])->name('CityNotices.create');
                    Route::post('/store', [CityNoticesController::class, 'store'])->name('CityNotices.store');
                    Route::get('/edit/{id}', [CityNoticesController::class, 'edit'])->name('CityNotices.edit');
                    Route::put('/update/{id}', [CityNoticesController::class, 'update'])->name('CityNotices.update');
                    Route::delete('/destroy/{id}', [CityNoticesController::class, 'destroy'])->name('CityNotices.destroy');
                    Route::get('/show/{id}', [CityNoticesController::class, 'show'])->name('CityNotices.show');
                });
                //  أدارة الموردين
                Route::prefix('SupplierManagement')->group(function () {
                    Route::get('/index', [SupplierManagementController::class, 'index'])->name('SupplierManagement.index');
                    Route::get('/create', [SupplierManagementController::class, 'create'])->name('SupplierManagement.create');
                    Route::post('/store', [SupplierManagementController::class, 'store'])->name('SupplierManagement.store');
                    Route::get('/edit/{id}', [SupplierManagementController::class, 'edit'])->name('SupplierManagement.edit');
                    Route::put('/update/{id}', [SupplierManagementController::class, 'update'])->name('SupplierManagement.update');
                    Route::delete('/destroy/{id}', [SupplierManagementController::class, 'destroy'])->name('SupplierManagement.destroy');
                    Route::get('/show/{id}', [SupplierManagementController::class, 'show'])->name('SupplierManagement.show');
                });
                //  مدفوعات الموردين
                // Route::prefix('Supplier_Payments')->group(function () {
                //     Route::get('/index', [SupplierPaymentsController::class, 'index'])->name('purchases.supplier_payments.index');
                //     Route::get('/create', [SupplierPaymentsController::class, 'create'])->name('purchases.supplier_payments.create');
                // });
                //  أعدادات فواتير الشراء
                Route::prefix('invoice_settings')->group(function () {
                    Route::get('/index', [InvoiceSettingsController::class, 'index'])->name('purchases.invoice_settings.index');
                    Route::get('/create', [InvoiceSettingsController::class, 'create'])->name('purchases.invoice_settings.create');
                });
                //  أعدادات الموردين
                Route::prefix('Supplier_Settings')->group(function () {
                    Route::get('/index', [SupplierSettingsController::class, 'index'])->name('purchases.supplier_settings.index');
                    Route::get('/create', [SupplierSettingsController::class, 'create'])->name('purchases.supplier_settings.create');
                });
                Route::prefix('PaymentSupplier')->group(function () {
                    Route::get('/indexPurchase', [PaymentProcessController::class, 'indexPurchase'])->name('PaymentSupplier.indexPurchase');
                    Route::get('/createPurchase/{id}', [PaymentProcessController::class, 'createPurchase'])->name('PaymentSupplier.createPurchase');
                    Route::post('/storePurchase', [PaymentProcessController::class, 'storePurchase'])->name('PaymentSupplier.storePurchase');
                    Route::get('/showSupplierPayment/{id}', [PaymentProcessController::class, 'showSupplierPayment'])->name('PaymentSupplier.showSupplierPayment');
                    Route::get('/editSupplierPayment/{id}', [PaymentProcessController::class, 'editSupplierPayment'])->name('PaymentSupplier.editSupplierPayment');
                    Route::put('/updateSupplierPayment/{id}', [PaymentProcessController::class, 'updateSupplierPayment'])->name('PaymentSupplier.updateSupplierPayment');
                });
            });
    },
);
