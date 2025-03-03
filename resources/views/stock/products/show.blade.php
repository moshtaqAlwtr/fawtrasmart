
@extends('master')

@section('title')
المنتجات
@stop

@section('css')
<style>
    .user-avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: #007bff; /* لون الخلفية */
        color: #fff; /* لون النص */
        font-weight: bold;
        font-size: 14px;
    }
</style>
@endsection

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">ادارة المنتجات</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a>
                            </li>
                            <li class="breadcrumb-item active">عرض
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.alerts.success')
    @include('layouts.alerts.error')

    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <strong>{{ $product->name }} </strong> | <small>{{ $product->serial_number }}#</small> | <span class="badge badge-pill badge badge-success">في المخزن</span>
                    </div>

                    <div>
                        <a href="{{ route('products.edit',$product->id) }}" class="btn btn-outline-primary">
                            <i class="fa fa-edit"></i>تعديل
                        </a>
                    </div>

                </div>
            </div>
        </div>

        <div class="container" style="max-width: 1200px">
            <div class="card">
                <div class="card-title p-2">
                    <a href="{{ route('products.edit',$product->id) }}" class="btn btn-outline-primary btn-sm">تعديل <i class="fa fa-edit"></i></a>
                    <a href="#" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#modal_DELETE{{ $product->id }}">حذف <i class="fa fa-trash"></i></a>
                    @if($product->type == "products" || $product->type == "compiled")
                    <a href="{{ route('store_permits_management.manual_conversion') }}" class="btn btn-outline-success btn-sm">نقل <i class="fa fa-reply-all"></i></a>
                    <a href="{{ route('store_permits_management.create') }}" class="btn btn-outline-info btn-sm">اضف عمليه <i class="fa fa-plus"></i></a>
                    <a href="{{ route('store_permits_management.manual_disbursement') }}" class="btn btn-outline-warning btn-sm">عمليه صرف <i class="fa fa-minus"></i></a>
                    @endif
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" aria-controls="home" role="tab" aria-selected="false">معلومات</a>
                        </li>
                        @if($product->type == "products" || $product->type == "compiled")
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" aria-controls="profile" role="tab" aria-selected="false">حركة المخزون</a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" id="about-tab" data-toggle="tab" href="#about" aria-controls="about" role="tab" aria-selected="true">الجدول الزمني</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="activate-tab" data-toggle="tab" href="#activate" aria-controls="about" role="tab" aria-selected="true">سجل النشاطات</a>
                        </li>

                    </ul>

                    <div class="tab-content">

                        <div class="tab-pane active" id="home" aria-labelledby="home-tab" role="tabpanel">
                            <div class="row">

                                <table class="table">
                                    <thead class="table-light">
                                        <tr>@if($product->type == "products" || $product->type == "compiled")
                                            <th class="text-center"><i class="feather icon-package text-info font-medium-5 mr-1"></i>اجمالي المخزون</th>
                                            @endif
                                            <th class="text-center"><i class="feather icon-shopping-cart text-warning font-medium-5 mr-1"></i>اجمالي القطع المباعه</th>
                                            <th class="text-center"><i class="feather icon-calendar text-danger font-medium-5 mr-1"></i>آخر 28 أيام</th>
                                            <th class="text-center"><i class="feather icon-calendar text-primary font-medium-5 mr-1"></i>آخر 7 أيام</th>
                                            <th class="text-center"><i class="feather icon-bar-chart-2 text-success font-medium-5 mr-1"></i>متوسط سعر التكلفة</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            @if($product->type == "products" || $product->type == "compiled")
                                            <td class="text-center">
                                                <h4 class="text-bold-700">{{ $total_quantity ? number_format($total_quantity) : 'غير متوفر' }} {{$firstTemplateUnit ?? ""}}</h4>
                                                <br>

                                                @if ($storeQuantities->isNotEmpty())
                                                    @foreach ($storeQuantities as $storeQuantity)
                                                        @if (!empty($storeQuantity->storeHouse))
                                                            <p>
                                                                <span>{{ $storeQuantity->storeHouse->name }} :</span>
                                                                <strong>{{ number_format($storeQuantity->total_quantity) }}</strong>
                                                            </p>
                                                        @endif
                                                    @endforeach
                                                @endif

                                                <a href="{{ route('products.manual_stock_adjust',$product->id) }}" class="btn btn-outline-info">اضف عميله على المخزون</a>
                                            </td>
                                            @endif
                                            <td class="text-center">
                                                <h4 class="text-bold-700">{{ $total_sold ? number_format($total_sold) : 0 }}<small>قطع</small></h4>
                                            </td>
                                            <td class="text-center">
                                                <h4 class="text-bold-700">{{ $sold_last_28_days ? number_format($sold_last_28_days) : 0 }}<small>قطع</small></h4>
                                            </td>
                                            <td class="text-center">
                                                <h4 class="text-bold-700">{{ $sold_last_7_days ? number_format($sold_last_7_days) : 0 }}<small>قطع</small></h4>
                                            </td>
                                            <td class="text-center">
                                                <h4 class="text-bold-700">{{ $average_cost ? number_format($average_cost, 2) . ' ر.س' : 'غير متوفر' }}</h4>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <strong>التفاصيل :</strong>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <table class="table">
                                            <tr>
                                                <td>
                                                    @if ($product->images)
                                                        <img src="{{ asset('assets/uploads/product/'.$product->images) }}" alt="img" width="150">
                                                    @else
                                                        <img src="{{ asset('assets/uploads/no_image.jpg') }}" alt="img" width="150">
                                                    @endif
                                                </td>
                                                <td>
                                                    <strong>كود المنتج </strong>: {{ $product->serial_number }}#
                                                </td>
                                                <td>
                                                    <strong>نوع التتبع</strong><br>
                                                    <small>
                                                        @if ($product->inventory_type == 0)
                                                        الرقم التسلسلي
                                                        @elseif ($product->inventory_type == 1)
                                                        رقم الشحنة
                                                        @elseif ($product->inventory_type == 2)
                                                        تاريخ الانتهاء
                                                        @elseif ($product->inventory_type == 3)
                                                        رقم الشحنة وتاريخ الانتهاء
                                                        @else
                                                        الكمية فقط
                                                        @endif
                                                    <small>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <strong>منتجات التجميعة :</strong>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <table class="table">
                                            <tr>
                                             @foreach ($CompiledProducts as $CompiledProduct)
                                             <td>
                                                <b>{{$CompiledProduct->Product->name ?? ""}}</b>  : {{$CompiledProduct->qyt ?? ""}}
                                             </td>
                                             @endforeach   
                                             
                                               
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="profile" aria-labelledby="profile-tab" role="tabpanel">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        @if(isset($stock_movements) && !empty($stock_movements) && count($stock_movements) > 0)
                                            <table class="table">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th style="width: 40%">العملية</th>
                                                        <th>حركة</th>
                                                        <th>المخزون بعد</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach ($stock_movements as $stock_movement)
                                                        @if($stock_movement->warehousePermits->permission_type == 3)
                                                            {{-- صف المخزن المصدر (سحب الكمية) --}}
                                                            <tr>
                                                                <td>
                                                                    <strong>{{ $stock_movement->warehousePermits->permission_date }} (#{{ $stock_movement->warehousePermits->id }})</strong><br>
                                                                    <span>تحويل مخزني ({{ $stock_movement->warehousePermits->number }}#)</span><br>
                                                                    <span>🔻 من: {{ $stock_movement->warehousePermits->fromStoreHouse->name }}</span>
                                                                </td>
                                                                <td>
                                                                    <strong>{{ number_format($stock_movement->quantity) }}</strong>
                                                                    <i class="feather icon-minus text-danger"></i>
                                                                    <br>
                                                                    <small><abbr class="initialism" title="سعر الوحدة">{{ $product->sale_price ?? 0.00 }}&nbsp;ر.س</abbr></small>
                                                                </td>
                                                                <td>
                                                                    <strong>{{ number_format($stock_movement->stock_after) }}</strong><br>
                                                                    <small><abbr title="سعر الوحدة">{{ $product->sale_price }} ر.س</abbr></small>
                                                                </td>
                                                            </tr>

                                                            {{-- صف المخزن المستقبل (إضافة الكمية) --}}
                                                            <tr>
                                                                <td>
                                                                    <strong>{{ $stock_movement->warehousePermits->permission_date }} (#{{ $stock_movement->warehousePermits->id }})</strong><br>
                                                                    <span>تحويل مخزني ({{ $stock_movement->warehousePermits->number }}#)</span><br>
                                                                    <span>🔺 إلى: {{ $stock_movement->warehousePermits->toStoreHouse->name }}</span>
                                                                </td>
                                                                <td>
                                                                    <strong>{{ number_format($stock_movement->quantity) }}</strong>
                                                                    <i class="feather icon-plus text-success"></i>
                                                                    <br>
                                                                    <small><abbr class="initialism" title="سعر الوحدة">{{ $product->sale_price ?? 0.00 }}&nbsp;ر.س</abbr></small>
                                                                </td>
                                                                <td>
                                                                    @php
                                                                        $stockBeforeTo = \App\Models\ProductDetails::where('product_id', $product->id)
                                                                            ->where('store_house_id', $stock_movement->warehousePermits->to_store_house_id)
                                                                            ->sum('quantity');
                                                                        $stockAfterTo = $stockBeforeTo + $stock_movement->quantity;
                                                                    @endphp
                                                                    <strong>{{ number_format($stockAfterTo) }}</strong><br>
                                                                    <small><abbr title="سعر الوحدة">{{ $product->sale_price }} ر.س</abbr></small>
                                                                </td>
                                                            </tr>

                                                       
                                                        @elseif($stock_movement->warehousePermits->permission_type != 10)
                                                            {{-- العمليات العادية (إضافة أو صرف) --}}
                                                            <tr>
                                                                <td>
                                                                    <strong>{{ $stock_movement->warehousePermits->permission_date }} (#{{ $stock_movement->warehousePermits->id }})</strong><br>
                                                                    <span>
                                                                        @if($stock_movement->warehousePermits->permission_type == 1)
                                                                            إضافة مخزن
                                                                        @elseif($stock_movement->warehousePermits->permission_type == 2)
                                                                            صرف مخزن
                                                                        @endif
                                                                        ({{ $stock_movement->warehousePermits->number }}#)
                                                                    </span><br>
                                                                    <span>{{ $stock_movement->warehousePermits->storeHouse->name }}</span>
                                                                </td>
                                                                <td>
                                                                    <strong>
                                                                        {{ number_format($stock_movement->quantity) }}
                                                                        @if($stock_movement->warehousePermits->permission_type == 1)
                                                                            <i class="feather icon-plus text-success"></i>
                                                                        @elseif($stock_movement->warehousePermits->permission_type == 2)
                                                                            <i class="feather icon-minus text-danger"></i>
                                                                        @endif
                                                                    </strong>
                                                                    <br>
                                                                    <small><abbr class="initialism" title="سعر الوحدة">{{ $product->sale_price ?? 0.00 }}&nbsp;ر.س</abbr></small>
                                                                </td>
                                                                <td>
                                                                    <strong>{{ number_format($stock_movement->stock_after) }}</strong><br>
                                                                    <small><abbr title="سعر الوحدة">{{ $product->sale_price }} ر.س</abbr></small>
                                                                </td>

                                                            </tr>
                                                                      
                                                        @endif
                                                        @if ($stock_movement->warehousePermits->permission_type == 10)     
                                                        {{--   حساب مبيعات الفواتير--}}
                                                        <tr>
                                                           <td>
                                                               <strong>{{ $stock_movement->warehousePermits->permission_date }} (#{{ $stock_movement->warehousePermits->id }})</strong><br>
                                                               <span> فاتورة رقم ({{ $stock_movement->warehousePermits->number }}#)</span><br>
                                                             
                                                           </td>
                                                           <td>
                                                               <strong>{{ number_format($stock_movement->quantity) }}</strong>
                                                               <i class="feather icon-minus text-danger"></i>
                                                               <br>
                                                               <small><abbr class="initialism" title="سعر الوحدة">{{ $product->sale_price ?? 0.00 }}&nbsp;ر.س</abbr></small>
                                                           </td>
                                                           <td>
                                                               <strong>{{ number_format($stock_movement->stock_after) }}</strong><br>
                                                               <small><abbr title="سعر الوحدة">{{ $product->sale_price }} ر.س</abbr></small>
                                                           </td>
                                                       </tr> 
                                                       @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <div class="alert alert-danger text-xl-center" role="alert">
                                                <p class="mb-0">
                                                    لا توجد عمليات مضافه حتى الان !!
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="about" aria-labelledby="about-tab" role="tabpanel">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        @if(isset($stock_movements) && !empty($stock_movements) && count($stock_movements) > 0)
                                            <ul class="activity-timeline timeline-left list-unstyled">
                                                @foreach($stock_movements as $movement)
                                                    <li>
                                                        <div class="timeline-icon bg-success">
                                                            <i class="feather icon-package font-medium-2"></i>
                                                        </div>
                                                        <div class="timeline-info">
                                                            <p>
                                                                @if($movement->warehousePermits->permission_type == 2)
                                                                    أنقص <strong>{{ $movement->warehousePermits->user->name }}</strong> <strong>{{ $movement->quantity }}</strong> وحدة من مخزون <strong><a href="{{ route('products.show', $product->id) }}" target="_blank">#{{ $product->serial_number }} ({{ $product->name }})</a></strong> يدويا (رقم العملية: <strong>#{{ $movement->warehousePermits->number }}</strong>)، وسعر الوحدة: <strong>{{ $movement->unit_price }}&nbsp;ر.س</strong>، وأصبح المخزون الباقي من المنتج: <strong>{{ $movement->stock_after }}</strong> وأصبح المخزون <strong>{{ $movement->warehousePermits->storeHouse->name }}</strong> رصيده <strong>{{ $movement->stock_after }}</strong> , متوسط السعر: <strong>{{ $average_cost }}&nbsp;ر.س</strong>
                                                                @else
                                                                    أضاف <strong>{{ $movement->warehousePermits->user->name }}</strong> <strong>{{ $movement->quantity }}</strong> وحدة إلى مخزون <strong><a href="{{ route('products.show', $product->id) }}" target="_blank">#{{ $product->serial_number }} ({{ $product->name }})</a></strong> يدويا (رقم العملية: <strong>#{{ $movement->warehousePermits->number }}</strong>)، وسعر الوحدة: <strong>{{ $movement->unit_price }}&nbsp;ر.س</strong>، وأصبح المخزون الباقي من المنتج: <strong>{{ $movement->stock_after }}</strong> وأصبح المخزون <strong>{{ $movement->warehousePermits->storeHouse->name }}</strong> رصيده <strong>{{ $movement->stock_after }}</strong> , متوسط السعر: <strong>{{ $average_cost }}&nbsp;ر.س</strong>
                                                                @endif
                                                            </p>
                                                            <br>
                                                            <span>
                                                                <i class="fa fa-clock-o"></i> {{ $movement->warehousePermits->permission_date }} - <span class="tip observed tooltipstered" data-title="{{ $movement->warehousePermits->user->ip_address }}"> <i class="fa fa-user"></i> {{ $movement->warehousePermits->user->name }}</span> - <i class="fa fa-building"></i> {{ $movement->warehousePermits->storeHouse->name }}
                                                            </span>
                                                        </div>
                                                    </li>
                                                    <hr>
                                                @endforeach
                                            </ul>
                                        @else
                                            <div class="alert alert-danger text-xl-center" role="alert">
                                                <p class="mb-0">
                                                    لا توجد عمليات مضافه حتى الان !!
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="activate" aria-labelledby="activate-tab" role="tabpanel">
                            <p>activate records</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal delete -->
        <div class="modal fade text-left" id="modal_DELETE{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #EA5455 !important;">
                        <h4 class="modal-title" id="myModalLabel1" style="color: #FFFFFF">حذف {{ $product->name }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: #DC3545">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <strong>
                            هل انت متاكد من انك تريد الحذف ؟
                        </strong>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light waves-effect waves-light" data-dismiss="modal">الغاء</button>
                        <a href="{{ route('products.delete',$product->id) }}" class="btn btn-danger waves-effect waves-light">تأكيد</a>
                    </div>
                </div>
            </div>
        </div>
        <!--end delete-->

    </div>

@endsection

@section('scripts')

<script>
    function remove_disabled() {
        if (document.getElementById("ProductTrackStock").checked) {
            disableForm(false);
        }
        if (!document.getElementById("ProductTrackStock").checked) {
            disableForm(true);
        }
    }

    function disableForm(flag) {
        var elements = document.getElementsByClassName("ProductTrackingInput");
        for (var i = 0, len = elements.length; i < len; ++i) {
            elements[i].readOnly = flag;
            elements[i].disabled = flag;
        }
    }
</script>
<!----------------------------------------------->
<script>
    function remove_disabled_ckeckbox() {
        if(document.getElementById("available_online").checked)
            document.getElementById("featured_product").disabled = false;
        else
        document.getElementById("featured_product").disabled = true;
    }
</script>

@endsection
