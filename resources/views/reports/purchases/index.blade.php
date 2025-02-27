@extends('master')

@section('title')
    تقريرالمشتريات
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
        <div class="content-header-left col-md-12">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2 class="content-header-title float-start mb-0">تقارير المشتريات</h2>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper float-start">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                            <li class="breadcrumb-item active">عرض</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <!-- تقارير متابعة المشتريات المقسمة -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="section-title">
                        <i class="fas fa-file-alt ml-2"></i>
                        تقارير متابعة المشتريات المقسمة
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='stock_reprt_a/Inventory_sheet.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon5 ml-2"><i class="fas fa-truck"></i></div>
                                تقرير مشتريات حسب المورد
                            </div>
                            <a href="{{route('ReportsPurchases.bySupplier')}}" class="view-button"><i class="fas fa-eye"></i> عرض</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='stock_reprt_a/Summary_inventory_operations.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon1 ml-2"><i class="fas fa-user"></i></div>
                                تقرير مشتريات حسب الموظف
                            </div>
                            <a href="{{route('ReportsPurchases.purchaseByEmployee')}}" class="view-button"><i class="fas fa-eye"></i> عرض</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- تقارير الموردين -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="section-title">
                        <i class="fas fa-file-alt ml-2"></i>
                        تقارير الموردين
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='Product_tracking/Track_expiry_date.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon1 ml-2"><i class="fas fa-address-book"></i></div>
                                دليل الموردين
                            </div>
                            <a href="{{route('ReportsPurchases.SuppliersDirectory')}}" class="view-button"><i class="fas fa-eye"></i> عرض</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='Product_tracking/Track_serial_num.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon2 ml-2"><i class="fas fa-balance-scale"></i></div>
                                ارصدة الموردين
                            </div>
                            <a href="{{route('ReportsPurchases.balnceSuppliers')}}" class="view-button"><i class="fas fa-eye"></i> عرض</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='Product_tracking/Track_shipment_num.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon3 ml-2"><i class="fas fa-clock"></i></div>
                                اعمار المدين حساب الاستاذ العام
                            </div>
                            <a href="Product_tracking/Track_shipment_num.html" class="view-button"><i class="fas fa-eye"></i> عرض</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='Product_tracking/Track_use_expiry_date.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon4 ml-2"><i class="fas fa-shopping-cart"></i></div>
                                مشتريات الموردين
                            </div>
                            <a href="{{route('ReportsPurchases.purchaseSupplier')}}" class="view-button"><i class="fas fa-eye"></i> عرض</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='Product_tracking/Track_use_expiry_date.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon4 ml-2"><i class="fas fa-money-bill-wave"></i></div>
                                مدفوعات مشتريات الموردين
                            </div>
                            <a href="{{route('ReportsPurchases.paymentPurchases')}}" class="view-button"><i class="fas fa-eye"></i> عرض</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='Product_tracking/Track_use_expiry_date.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon4 ml-2"><i class="fas fa-file-invoice"></i></div>
                                كشف حساب الموردين
                            </div>
                            <a href="Product_tracking/Track_use_expiry_date.html" class="view-button"><i class="fas fa-eye"></i> عرض</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- تقرير مشتريات المنتجات -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="section-title">
                        <i class="fas fa-file-alt ml-2"></i>
                        تقرير مشتريات المنتجات
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='stock_reprt_a/Inventory_sheet.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon5 ml-2"><i class="fas fa-box"></i></div>
                                تقرير مشتريات المنتجات حسب المنتج
                            </div>
                            <a href="{{route('ReportsPurchases.prodectPurchases')}}" class="view-button"><i class="fas fa-eye"></i> عرض</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='stock_reprt_a/Summary_inventory_operations.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon1 ml-2"><i class="fas fa-truck"></i></div>
                                تقرير مشتريات المنتجات حسب المورد
                            </div>
                            <a href="{{route('ReportsPurchases.supplierPurchases')}}" class="view-button"><i class="fas fa-eye"></i> عرض</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='stock_reprt_a/Summary_inventory_operations.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon1 ml-2"><i class="fas fa-user"></i></div>
                                تقرير مشتريات المنتجات حسب الموظف
                            </div>
                            <a href="{{route('ReportsPurchases.employeePurchases')}}" class="view-button"><i class="fas fa-eye"></i> عرض</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- تقارير المدفوعات بالمدة الزمنية -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="section-title">
                        <i class="fas fa-file-alt ml-2"></i>
                        تقارير المدفوعات بالمدة الزمنية
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='Product_tracking/Track_expiry_date.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon1 ml-2"><i class="fas fa-sun"></i></div>
                                المدفوعات اليومية
                            </div>
                            <a href="{{route('ReportsPurchases.supplierPayments', ['report_period' => 'daily'])}}" class="view-button"><i class="fas fa-eye"></i> عرض</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='Product_tracking/Track_serial_num.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon2 ml-2"><i class="fas fa-calendar-week"></i></div>
                                المدفوعات الاسبوعية
                            </div>
                            <a href="{{route('ReportsPurchases.supplierPayments', ['report_period' => 'weekly'])}}" class="view-button"><i class="fas fa-eye"></i> عرض</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='Product_tracking/Track_shipment_num.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon3 ml-2"><i class="fas fa-calendar-alt"></i></div>
                                المدفوعات الشهرية
                            </div>
                            <a href="{{route('ReportsPurchases.supplierPayments', ['report_period' => 'monthly'])}}" class="view-button"><i class="fas fa-eye"></i> عرض</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='Product_tracking/Track_use_expiry_date.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon4 ml-2"><i class="fas fa-calendar-check"></i></div>
                                المدفوعات السنوية
                            </div>
                            <a href="{{route('ReportsPurchases.supplierPayments', ['report_period' => 'yearly'])}}" class="view-button"><i class="fas fa-eye"></i> عرض</a>
                        </li>
                    </ul>
                </div>
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
