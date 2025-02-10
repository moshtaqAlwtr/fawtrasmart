<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Models\DefaultWarehouses;
use App\Models\Employee;
use App\Models\GeneralSettings;
use App\Models\PriceList;
use App\Models\StoreHouse;
use Illuminate\Http\Request;

class InventorySettingsController extends Controller
{
    public function index()
    {
        return view('stock.inventory_settings.index');
    }

    public function general()
    {
        $general_settings = GeneralSettings::select()->first();
        $price_lists = PriceList::select('id','name')->get();
        $storehouses = StoreHouse::select('id','name')->get();
        return view('stock.products_settings.general',compact('price_lists','storehouses','general_settings'));
    }

    public function store(Request $request)
    {
        $generalSettings = GeneralSettings::select()->first();

        if (!$generalSettings) {

            $generalSettings = new GeneralSettings();
        }

        $generalSettings->sub_account = $request->sub_account;
        $generalSettings->storehouse_id = $request->storehouse_id;
        $generalSettings->price_list_id = $request->price_list_id;
        $generalSettings->enable_negative_stock = $request->has('enable_negative_stock') ? 1 : 0;
        $generalSettings->advanced_pricing_options = $request->has('advanced_pricing_options') ? 1 : 0;
        $generalSettings->enable_stock_requests = $request->has('enable_stock_requests') ? 1 : 0;
        $generalSettings->enable_sales_stock_authorization = $request->has('enable_sales_stock_authorization') ? 1 : 0;
        $generalSettings->enable_purchase_stock_authorization = $request->has('enable_purchase_stock_authorization') ? 1 : 0;
        $generalSettings->track_products_by_serial_or_batch = $request->has('track_products_by_serial_or_batch') ? 1 : 0;
        $generalSettings->allow_negative_tracking_elements = $request->has('allow_negative_tracking_elements') ? 1 : 0;
        $generalSettings->enable_multi_units_system = $request->has('enable_multi_units_system') ? 1 : 0;
        $generalSettings->inventory_quantity_by_date = $request->has('inventory_quantity_by_date') ? 1 : 0;
        $generalSettings->enable_assembly_and_compound_units = $request->has('enable_assembly_and_compound_units') ? 1 : 0;
        $generalSettings->show_available_quantity_in_warehouse = $request->has('show_available_quantity_in_warehouse') ? 1 : 0;

        $generalSettings->save();

        return redirect()->back()->with([ 'success'=>'تم التعديل بنجاح']);
    }

    public function employee_default_warehouse()
    {
        $warehouses = StoreHouse::select('id','name')->get();
        $employees = Employee::select('id','first_name','middle_name')->get();
        $default_warehouses = DefaultWarehouses::select()->orderBy('id','DESC')->get();
        return view('stock.products_settings.employee_default_warehouse',compact('employees','warehouses','default_warehouses'));
    }

    public function employee_default_warehouse_create()
    {
        $warehouses = StoreHouse::select('id','name')->get();
        $employees = Employee::select('id','first_name','middle_name')->get();
        return view('stock.products_settings.employee_default_warehouse_create',compact('employees','warehouses'));
    }

    public function employee_default_warehouse_store(Request $request)
    {
        $default_warehouse = new DefaultWarehouses();

        $default_warehouse->storehouse_id = $request->storehouse_id;
        $default_warehouse->employee_id = $request->employee_id;

        $default_warehouse->save();

        return redirect()->route('inventory_settings.employee_default_warehouse')->with([ 'success'=>'تم حفظ المستودع الافتراضي للموظف بنجاح']);
    }

    public function employee_default_warehouse_delete($id)
    {
        $default_warehouse = DefaultWarehouses::find($id);
        $default_warehouse->delete();
        return redirect()->route('inventory_settings.employee_default_warehouse')->with([ 'error'=>'تم حذف المستودع الافتراضي للموظف بنجاح']);
    }

    public function employee_default_warehouse_show($id)
    {
        $default_warehouse = DefaultWarehouses::find($id);
        return view('stock.products_settings.employee_default_warehouse_show',compact('default_warehouse'));
    }

    public function employee_default_warehouse_edit($id)
    {
        $default_warehouse = DefaultWarehouses::find($id);
        $warehouses = StoreHouse::select('id','name')->get();
        $employees = Employee::select('id','first_name','middle_name')->get();
        return view('stock.products_settings.employee_default_warehouse_edit',compact('default_warehouse','employees','warehouses'));
    }

    public function employee_default_warehouse_update(Request $request,$id)
    {
        $default_warehouse = DefaultWarehouses::find($id);

        $default_warehouse->storehouse_id = $request->storehouse_id;
        $default_warehouse->employee_id = $request->employee_id;

        $default_warehouse->update();

        return redirect()->route('inventory_settings.employee_default_warehouse')->with([ 'success'=>'تم تعديل المستودع الافتراضي للموظف بنجاح']);
    }


}
