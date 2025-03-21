@extends('master')

@section('title')
اعدادات المخزون
@stop

@section('content')
    <div class="content-body">

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div></div>

                    <div>
                        <a href="" class="btn btn-sm btn-outline-danger waves-effect waves-light">
                            <i class="fa fa-ban"></i>الغاء
                        </a>
                        <button type="submit" form="general_form" class="btn btn-sm btn-outline-primary waves-effect waves-light">
                            <i class="fa fa-floppy-o"></i>حفظ
                        </button>
                    </div>

                </div>
            </div>
        </div>

        @include('layouts.alerts.error')
        @include('layouts.alerts.success')

        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <form action="{{ route('inventory_settings.store') }}" id="general_form" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <fieldset>
                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                        <input type="checkbox" name="enable_negative_stock" value="1" {{ isset($general_settings->enable_negative_stock) && $general_settings->enable_negative_stock == 1 ? 'checked' : '' }}>
                                        <span class="vs-checkbox">
                                            <span class="vs-checkbox--check">
                                                <i class="vs-icon feather icon-check"></i>
                                            </span>
                                        </span>
                                        <span class="">إتاحة المخزون السالب</span>
                                    </div>
                                </fieldset>
                                <br>
                                <fieldset>
                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                        <input type="checkbox" name="advanced_pricing_options" value="1" {{ isset($general_settings->advanced_pricing_options) && $general_settings->advanced_pricing_options == 1 ? 'checked' : '' }}>
                                        <span class="vs-checkbox">
                                            <span class="vs-checkbox--check">
                                                <i class="vs-icon feather icon-check"></i>
                                            </span>
                                        </span>
                                        <span class="">خيارات التسعير المتقدمة</span>
                                    </div>
                                </fieldset>
                                <br>
                                <fieldset>
                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                        <input type="checkbox" name="enable_stock_requests" value="1" {{ isset($general_settings->enable_stock_requests) && $general_settings->enable_stock_requests == 1 ? 'checked' : '' }}>
                                        <span class="vs-checkbox">
                                            <span class="vs-checkbox--check">
                                                <i class="vs-icon feather icon-check"></i>
                                            </span>
                                        </span>
                                        <span class="">تفعيل الطلبات المخزنية</span>
                                    </div>
                                </fieldset>
                                <br>
                                <fieldset>
                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                        <input type="checkbox" name="enable_sales_stock_authorization" value="1" {{ isset($general_settings->enable_sales_stock_authorization) && $general_settings->enable_sales_stock_authorization == 1 ? 'checked' : '' }}>
                                        <span class="vs-checkbox">
                                            <span class="vs-checkbox--check">
                                                <i class="vs-icon feather icon-check"></i>
                                            </span>
                                        </span>
                                        <span class="">تفعيل الأذون المخزنية لفواتير المبيعات</span>
                                    </div>
                                </fieldset>
                                <br>
                                <fieldset>
                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                        <input type="checkbox" name="enable_purchase_stock_authorization" value="1" {{ isset($general_settings->enable_purchase_stock_authorization) && $general_settings->enable_purchase_stock_authorization == 1 ? 'checked' : '' }}>
                                        <span class="vs-checkbox">
                                            <span class="vs-checkbox--check">
                                                <i class="vs-icon feather icon-check"></i>
                                            </span>
                                        </span>
                                        <span class="">تفعيل الاذون المخزنية لفواتير الشراء</span>
                                    </div>
                                </fieldset>
                                <br>
                                <fieldset>
                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                        <input type="checkbox" name="track_products_by_serial_or_batch" value="1" {{ isset($general_settings->track_products_by_serial_or_batch) && $general_settings->track_products_by_serial_or_batch == 1 ? 'checked' : '' }}>
                                        <span class="vs-checkbox">
                                            <span class="vs-checkbox--check">
                                                <i class="vs-icon feather icon-check"></i>
                                            </span>
                                        </span>
                                        <span class="">تتبع المنتجات بواسطة الرقم المسلسل, رقم الشحنة أو تاريخ الإنتهاء</span>
                                    </div>
                                </fieldset>
                                <br>
                                <fieldset>
                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                        <input type="checkbox" name="allow_negative_tracking_elements" value="1" {{ isset($general_settings->allow_negative_tracking_elements) && $general_settings->allow_negative_tracking_elements == 1 ? 'checked' : '' }}>
                                        <span class="vs-checkbox">
                                            <span class="vs-checkbox--check">
                                                <i class="vs-icon feather icon-check"></i>
                                            </span>
                                        </span>
                                        <span class="">السماح بعناصر التتبع السالبة</span>
                                    </div>
                                </fieldset>
                                <br>
                                <fieldset>
                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                        <input type="checkbox" name="enable_multi_units_system" value="1" {{ isset($general_settings->enable_multi_units_system) && $general_settings->enable_multi_units_system == 1 ? 'checked' : '' }}>
                                        <span class="vs-checkbox">
                                            <span class="vs-checkbox--check">
                                                <i class="vs-icon feather icon-check"></i>
                                            </span>
                                        </span>
                                        <span class="">إتاحة نظام الوحدات المتعددة </span>
                                    </div>
                                </fieldset>
                                <br>
                                <fieldset>
                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                        <input type="checkbox" name="inventory_quantity_by_date" value="1" {{ isset($general_settings->inventory_quantity_by_date) && $general_settings->inventory_quantity_by_date == 1 ? 'checked' : '' }}>
                                        <span class="vs-checkbox">
                                            <span class="vs-checkbox--check">
                                                <i class="vs-icon feather icon-check"></i>
                                            </span>
                                        </span>
                                        <span class="">حساب كمية الجرد حسب تاريخ الجرد</span>
                                    </div>
                                </fieldset>
                                <br>
                                <fieldset>
                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                        <input type="checkbox" name="enable_assembly_and_compound_units" value="1" {{ isset($general_settings->enable_assembly_and_compound_units) && $general_settings->enable_assembly_and_compound_units == 1 ? 'checked' : '' }}>
                                        <span class="vs-checkbox">
                                            <span class="vs-checkbox--check">
                                                <i class="vs-icon feather icon-check"></i>
                                            </span>
                                        </span>
                                        <span class="">إتاحة نظام التجميعات و الوحدات المركبة</span>
                                    </div>
                                </fieldset>
                                <br>
                                <fieldset>
                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                        <input type="checkbox" name="show_available_quantity_in_warehouse" value="1" {{ isset($general_settings->show_available_quantity_in_warehouse) && $general_settings->show_available_quantity_in_warehouse == 1 ? 'checked' : '' }}>
                                        <span class="vs-checkbox">
                                            <span class="vs-checkbox--check">
                                                <i class="vs-icon feather icon-check"></i>
                                            </span>
                                        </span>
                                        <span class="">إظهار الكمية اﻹجمالية و المتوفرة في المخزن للمنتجات</span>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="col-6">

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email-id-vertical">الحساب الفرعي</label>
                                        <select class="form-control" name="sub_account">
                                            <option value="" selected disabled>-- اختر الحساب الفرعي --</option>
                                            <option value="0">الحساب 1</option>
                                            <option value="1">الحساب 2</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email-id-vertical">المستودع الافتراضي</label>
                                        <select class="form-control" name="storehouse_id">
                                            <option value="" selected disabled>-- اختر المستودع --</option>
                                            @foreach ($storehouses as $storehouse)
                                                <option value="{{ $storehouse->id }}" {{ isset($general_settings) && old('storehouse_id', $general_settings->storehouse_id ?? null) == $storehouse->id ? 'selected' : '' }}>
                                                    {{ $storehouse->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email-id-vertical">قائمة الاسعار الافتراضية</label>
                                        <select class="form-control" name="price_list_id">
                                            <option value="" selected disabled>-- اختر قائمة الاسعار --</option>
                                            @foreach ($price_lists as $price_list)
                                                <option value="{{ $price_list->id }}" {{ isset($general_settings) && old('price_list_id', $general_settings->price_list_id ?? null) == $price_list->id ? 'selected' : '' }}>
                                                    {{ $price_list->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>

@endsection


@section('scripts')



@endsection
