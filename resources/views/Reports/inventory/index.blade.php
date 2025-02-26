@extends('master')

@section('title')
    تقرير المخزن
@stop

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f9fc;
            direction: rtl;
            text-align: right;
        }

        .card {
            border: none;
            background-color: #edf2f7;
        }

        .section-title {
            background-color: #d8e3e8;
            font-weight: bold;
            padding: 15px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            font-size: 16px;
        }

        .icon-box {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }

        .icon1 {
            background: linear-gradient(45deg, #ff7e5f, #feb47b);
        }

        .icon2 {
            background: linear-gradient(45deg, #86a8e7, #91eae4);
        }

        .icon3 {
            background: linear-gradient(45deg, #00c6ff, #0072ff);
        }

        .icon4 {
            background: linear-gradient(45deg, #00f260, #0575e6);
        }

        .icon5 {
            background: linear-gradient(45deg, #f7971e, #ffd200);
        }

        .view-button {
            color: #6c757d;
            font-size: 14px;
            display: flex;
            align-items: center;
        }

        .view-button i {
            margin-left: 5px;
        }

        .list-group-item {
            padding: 15px 20px;
            background-color: #f7f9fc;
            border: none;
            border-bottom: 1px solid #ddd;
        }

        .list-group-item:last-child {
            border-bottom: none;
        }
    </style>
@endsection

@section('content')
<div class="content-header row mb-3">
    <div class="content-header-left col-md-9 col-12">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">تقارير المخزون </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                        <li class="breadcrumb-item active">عرض </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5">

    <div class="row">

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="section-title">
                    <i class="fas fa-file-alt ml-2"></i> المخزون
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center"
                        onclick="window.location.href='stock_reprt_a/Inventory_sheet.html'">
                        <div class="d-flex align-items-center">
                            <div class="icon-box icon5 ml-2"><i class="fas fa-clipboard"></i></div>
                            ورقة الجرد
                        </div>
                        <a href="{{ route('StorHouseReport.inventorySheet') }}" class="view-button"><i class="fas fa-eye"></i>
                            عرض</a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center"
                        onclick="window.location.href='stock_reprt_a/Summary_inventory_operations.html'">
                        <div class="d-flex align-items-center">
                            <div class="icon-box icon1 ml-2"><i class="fas fa-book"></i></div>
                            ملخص عمليات المخزون
                        </div>
                        <a href="{{ route('StorHouseReport.summaryInventory') }}" class="view-button"><i
                                class="fas fa-eye"></i> عرض</a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center"
                        onclick="window.location.href='stock_reprt_a/Detailed_movement_inventory.html'">
                        <div class="d-flex align-items-center">
                            <div class="icon-box icon2 ml-2"><i class="fas fa-exchange-alt"></i></div>
                            الحركة التفصيلية للمخزون
                        </div>
                        <a href="{{ route('StorHouseReport.detailedMovementInventory') }}" class="view-button"><i
                                class="fas fa-eye"></i> عرض</a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center"
                        onclick="window.location.href='stock_reprt_a/Value_fo _inventory.html'">
                        <div class="d-flex align-items-center">
                            <div class="icon-box icon3 ml-2"><i class="fas fa-dollar-sign"></i></div>
                            قيمة المخزون
                        </div>
                        <a href="{{route('StorHouseReport.valueInventory')}}" class="view-button"><i class="fas fa-eye"></i>
                            عرض</a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center"
                        onclick="window.location.href='stock_reprt_a/Inventory_balance_summary.html'">
                        <div class="d-flex align-items-center">
                            <div class="icon-box icon4 ml-2"><i class="fas fa-truck"></i></div>
                            ملخص رصيد المخازن
                        </div>
                        <a href="{{route('StorHouseReport.inventoryBlance')}}" class="view-button"><i
                                class="fas fa-eye"></i> عرض</a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center"
                        onclick="window.location.href='stock_reprt_a/Inventory_trial_balance.html'">
                        <div class="d-flex align-items-center">
                            <div class="icon-box icon3 ml-2"><i class="fas fa-balance-scale"></i></div>
                            ميزان مراجعة المنتجات
                        </div>
                        <a href="{{route('StorHouseReport.trialBalance')}}" class="view-button"><i
                                class="fas fa-eye"></i> عرض</a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center"
                        onclick="window.location.href='stock_reprt_a/Details_inventory_transactions.html'">
                        <div class="d-flex align-items-center">
                            <div class="icon-box icon4 ml-2"><i class="fas fa-box-open"></i></div>
                            تفاصيل حركة المخزون لكل منتج
                        </div>
                        <a href="{{route('StorHouseReport.Inventory_mov_det_product')}}" class="view-button"><i
                                class="fas fa-eye"></i> عرض</a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center"
                    onclick="window.location.href='stock_reprt_a/Details_inventory_transactions.html'">
                    <div class="d-flex align-items-center">
                        <div class="icon-box icon4 ml-2"><i class="fas fa-box-open"></i></div>
                        صرف المخزون لفواتير الشراء و المرتجعات
                    </div>
                    <a href="{{route('StorHouseReport.Inventory_mov_det_product')}}" class="view-button"><i
                            class="fas fa-eye"></i> عرض</a>
                </li>

                </ul>
            </div>

        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="section-title">
                    <i class="fas fa-file-alt ml-2"></i> تتبع المنتجات بواسطة الرقم المسلسل، رقم الشحنة أو تاريخ
                    الإنتهاء
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center"
                        onclick="window.location.href='Product_tracking/Track_expiry_date.html'">
                        <div class="d-flex align-items-center">
                            <div class="icon-box icon1 ml-2"><i class="fas fa-calendar-alt"></i></div>
                            تتبع المنتجات برقم الشحنة و تاريخ الإنتهاء
                        </div>
                        <a href="Product_tracking/Track_expiry_date.html" class="view-button"><i class="fas fa-eye"></i>
                            عرض</a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center"
                        onclick="window.location.href='Product_tracking/Track_serial_num.html'">
                        <div class="d-flex align-items-center">
                            <div class="icon-box icon2 ml-2"><i class="fas fa-barcode"></i></div>
                            تتبع المنتجات بالرقم المتسلسل
                        </div>
                        <a href="Product_tracking/Track_serial_num.html" class="view-button"><i class="fas fa-eye"></i>
                            عرض</a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center"
                        onclick="window.location.href='Product_tracking/Track_shipment_num.html'">
                        <div class="d-flex align-items-center">
                            <div class="icon-box icon3 ml-2"><i class="fas fa-truck-loading"></i></div>
                            تتبع المنتجات برقم الشحنة
                        </div>
                        <a href="Product_tracking/Track_shipment_num.html" class="view-button"><i
                                class="fas fa-eye"></i> عرض</a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center"
                        onclick="window.location.href='Product_tracking/Track_use_expiry_date.html'">
                        <div class="d-flex align-items-center">
                            <div class="icon-box icon4 ml-2"><i class="fas fa-calendar-times"></i></div>
                            تتبع المنتجات باستخدام تاريخ الانتهاء
                        </div>
                        <a href="Product_tracking/Track_use_expiry_date.html" class="view-button"><i
                                class="fas fa-eye"></i> عرض</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
