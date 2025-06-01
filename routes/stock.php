<?php

use App\Http\Controllers\Stock\CategoryController;
use App\Http\Controllers\Stock\InventoryManagementController;
use App\Http\Controllers\Stock\InventorySettingsController;
use App\Http\Controllers\Stock\PriceListController;
use App\Http\Controllers\Stock\ProductsController;
use App\Http\Controllers\Stock\ProductsSettingsController;
use App\Http\Controllers\Stock\StorehouseController;
use App\Http\Controllers\Stock\StorePermitsManagementController;
use App\Http\Controllers\Stock\TemplateUnitController;
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

require __DIR__ . '/auth.php';

Route::get('/get-product-stock/{storeId}/{productId}', [StorePermitsManagementController::class, 'getProductStock']);



Route::group(

    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'check.branch']
    ],
    function () {

        Route::prefix('stock')->middleware(['auth'])->group(function () {

            #questions routes
            Route::prefix('products')->group(function () {
                Route::get('/index', [ProductsController::class, 'index'])->name('products.index')->middleware('permission:products_view_all_products');
                Route::get('/traking/products', [ProductsController::class, 'traking'])->name('products.traking');
                Route::get('/create', [ProductsController::class, 'create'])->name('products.create')->middleware('permission:products_add_product');
                Route::get('/get-sub-units', [ProductsController::class, 'getSubUnits'])->name('products.getSubUnits');
                Route::get('/compiled', [ProductsController::class, 'compiled'])->name('products.compiled'); // عرض اضاقة منتج تجميعي
                Route::post('/compiled', [ProductsController::class, 'compiled_store'])->name('products.compiled_store'); // اضافة منتج تجميعي
                Route::get('/create/services', [ProductsController::class, 'create_services'])->name('products.create_services')->middleware('permission:products_add_product'); // عرض صفحة اضافة خدمة
                Route::get('/show/{id}', [ProductsController::class, 'show'])->name('products.show')->middleware('permission:products_view_all_products');
                Route::get('/edit/{id}', [ProductsController::class, 'edit'])->name('products.edit')->middleware('permission:products_edit_delete_all_products');
                Route::get('/manual_stock_adjust/{id}', [ProductsController::class, 'manual_stock_adjust'])->name('products.manual_stock_adjust');
                Route::post('/store', [ProductsController::class, 'store'])->name('products.store')->middleware('permission:products_add_product');
                Route::post('/add/manual_stock_adjust/{id}', [ProductsController::class, 'add_manual_stock_adjust'])->name('products.add_manual_stock_adjust');
                Route::post('/update/{id}', [ProductsController::class, 'update'])->name('products.update')->middleware('permission:products_edit_delete_all_products');
                Route::get('/delete/{id}', [ProductsController::class, 'delete'])->name('products.delete')->middleware('permission:products_edit_delete_all_products');
                Route::get('/search', [ProductsController::class, 'search'])->name('products.search');
                Route::post('/import', [ProductsController::class, 'import'])->name('products.import');
                Route::get('/getcategories', [ProductsController::class, 'categories'])->name('get-categories');
            });

            #category routes
            Route::prefix('category')->group(function () {
                Route::get('/create', [CategoryController::class, 'create'])->name('category.create');
                Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
                Route::post('/store', [CategoryController::class, 'store'])->name('category.store');
                Route::post('/update/{id}', [CategoryController::class, 'update'])->name('category.update');
                Route::get('/delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');
            });

            #storehouse routes
            Route::prefix('storehouse')->group(function () {
                Route::get('/index', [StorehouseController::class, 'index'])->name('storehouse.index');
                Route::get('/create', [StorehouseController::class, 'create'])->name('storehouse.create');
                Route::get('/show/{id}', [StorehouseController::class, 'show'])->name('storehouse.show');
                Route::get('/edit/{id}', [StorehouseController::class, 'edit'])->name('storehouse.edit');
                Route::post('/store', [StorehouseController::class, 'store'])->name('storehouse.store');
                Route::post('/update/{id}', [StorehouseController::class, 'update'])->name('storehouse.update');
                Route::get('/delete/{id}', [StorehouseController::class, 'delete'])->name('storehouse.delete');
                Route::get('/summary/inventory_operations/{id}', [StorehouseController::class, 'summary_inventory_operations'])->name('storehouse.summary_inventory_operations');
                Route::get('/inventory_value/{id}', [StorehouseController::class, 'inventory_value'])->name('storehouse.inventory_value');
                Route::get('/inventory_sheet/{id}', [StorehouseController::class, 'inventory_sheet'])->name('storehouse.inventory_sheet');
            });

            #price lists routes
            Route::prefix('price_list')->group(function () {
                Route::get('/index', [PriceListController::class, 'index'])->name('price_list.index')->middleware('permission:products_view_price_groups');
                Route::get('/create', [PriceListController::class, 'create'])->name('price_list.create')->middleware('permission:products_add_edit_price_groups');
                Route::get('/show/{id}', [PriceListController::class, 'show'])->name('price_list.show')->middleware('permission:products_add_edit_price_groups');
                Route::get('/edit/{id}', [PriceListController::class, 'edit'])->name('price_list.edit')->middleware('permission:products_add_edit_price_groups');
                Route::post('/store', [PriceListController::class, 'store'])->name('price_list.store')->middleware('permission:products_add_edit_price_groups');
                Route::post('/update/{id}', [PriceListController::class, 'update'])->name('price_list.update')->middleware('permission:products_add_edit_price_groups');;
                Route::get('/delete/{id}', [PriceListController::class, 'delete'])->name('price_list.delete')->middleware('permission:products_delete_price_groups');
                Route::get('/delete_product/{id}', [PriceListController::class, 'delete_product'])->name('price_list.delete_product')->middleware('permission:products_delete_price_groups');
                Route::post('/add_product/{id}', [PriceListController::class, 'add_product'])->name('price_list.add_product')->middleware('permission:products_add_product');
            });

            #price inventory settings routes
            Route::prefix('inventory_settings')->group(function () {
                Route::get('/index', [InventorySettingsController::class, 'index'])->name('inventory_settings.index');
                Route::get('/general', [InventorySettingsController::class, 'general'])->name('inventory_settings.general');
                Route::post('/store', [InventorySettingsController::class, 'store'])->name('inventory_settings.store');
                Route::get('/employee_default_warehouse', [InventorySettingsController::class, 'employee_default_warehouse'])->name('inventory_settings.employee_default_warehouse');
                Route::get('/employee_default_warehouse_create', [InventorySettingsController::class, 'employee_default_warehouse_create'])->name('inventory_settings.employee_default_warehouse_create');
                Route::post('/employee_default_warehouse_store', [InventorySettingsController::class, 'employee_default_warehouse_store'])->name('inventory_settings.employee_default_warehouse_store');
                Route::get('/employee_default_warehouse_delete/{id}', [InventorySettingsController::class, 'employee_default_warehouse_delete'])->name('inventory_settings.employee_default_warehouse_delete');
                Route::get('/employee_default_warehouse_show/{id}', [InventorySettingsController::class, 'employee_default_warehouse_show'])->name('inventory_settings.employee_default_warehouse_show');
                Route::get('/employee_default_warehouse_edit/{id}', [InventorySettingsController::class, 'employee_default_warehouse_edit'])->name('inventory_settings.employee_default_warehouse_edit');
                Route::post('/employee_default_warehouse_update/{id}', [InventorySettingsController::class, 'employee_default_warehouse_update'])->name('inventory_settings.employee_default_warehouse_update');
            });

            #price product settings routes
            Route::prefix('product_settings')->group(function () {
                Route::get('/index', [ProductsSettingsController::class, 'index'])->name('product_settings.index');
                Route::get('/category', [ProductsSettingsController::class, 'category'])->name('product_settings.category');
                Route::get('/default-taxes', [ProductsSettingsController::class, 'default_taxes'])->name('product_settings.default_taxes');
                Route::get('/barcode-settings', [ProductsSettingsController::class, 'barcode_settings'])->name('product_settings.barcode_settings');
            });

            #template unit
            Route::prefix('template_unit')->group(function () {
                Route::get('/index', [TemplateUnitController::class, 'index'])->name('template_unit.index');
                Route::get('/create', [TemplateUnitController::class, 'create'])->name('template_unit.create');
                Route::post('/store', [TemplateUnitController::class, 'store'])->name('template_unit.store');
                Route::get('/edit/{id}', [TemplateUnitController::class, 'edit'])->name('template_unit.edit');
                Route::post('/update/{id}', [TemplateUnitController::class, 'update'])->name('template_unit.update');
                Route::get('/delete/{id}', [TemplateUnitController::class, 'delete'])->name('template_unit.delete');
                Route::get('/show/{id}', [TemplateUnitController::class, 'show'])->name('template_unit.show');
                Route::get('/updateStatus/{id}', [TemplateUnitController::class, 'updateStatus'])->name('template_unit.updateStatus');
            });

            #price inventory Management routes
            Route::prefix('inventory_management')->group(function () {
                Route::get('/index', [InventoryManagementController::class, 'index'])->name('inventory_management.index');
                Route::get('/create', [InventoryManagementController::class, 'create'])->name('inventory_management.create');
                Route::get('/inventory/do/{id}', [InventoryManagementController::class, 'doStock'])->name('inventory.do_stock');
                Route::post('/inventory/store', [InventoryManagementController::class, 'store'])->name('inventory.store');
                Route::post('/inventory/save/{id}', [InventoryManagementController::class, 'saveFinal'])->name('inventory.save_final');
                Route::get('/inventory/show/{id}', [InventoryManagementController::class, 'show'])->name('inventory.show');
                Route::get('/inventory/adjustment/{id}', [InventoryManagementController::class, 'adjustment'])->name('inventory.adjustment');
                Route::get('/inventory/cancel/adjustment/{id}', [InventoryManagementController::class, 'Canceladjustment'])->name('inventory.Canceladjustment');
            });

            #price Store permits Management routes
            Route::prefix('store_permits_management')->group(function () {
                Route::get('/index', [StorePermitsManagementController::class, 'index'])->name('store_permits_management.index');
                Route::get('/create', [StorePermitsManagementController::class, 'create'])->name('store_permits_management.create');
                Route::get('/manual_disbursement', [StorePermitsManagementController::class, 'manual_disbursement'])->name('store_permits_management.manual_disbursement');
                Route::get('/manual_conversion', [StorePermitsManagementController::class, 'manual_conversion'])->name('store_permits_management.manual_conversion');
                Route::post('/store', [StorePermitsManagementController::class, 'store'])->name('store_permits_management.store');
                Route::get('/show/{id}', [StorePermitsManagementController::class, 'show'])->name('store_permits_management.show');
                Route::get('/edit/{id}', [StorePermitsManagementController::class, 'edit'])->name('store_permits_management.edit');
                Route::post('/update/{id}', [StorePermitsManagementController::class, 'update'])->name('store_permits_management.update');
                Route::get('/delete/{id}', [StorePermitsManagementController::class, 'delete'])->name('store_permits_management.delete');
                Route::get('/go', [StorePermitsManagementController::class, 'go'])->name('store_permits_management.go');
            });
        });
    }
);

Route::fallback(function () {
    return view('errors.404');
});
