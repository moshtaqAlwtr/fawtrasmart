@extends('master')

@section('title')
تقارير المخزون
@stop

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">">

<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">تقارير المخزون</h2>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">الرئيسية</li>
                        <li class="breadcrumb-item active">عرض</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title text-primary mb-4">
                        <i class="bi bi-box"></i> تقارير المخزون
                    </h5>
                    <ul class="list-unstyled">
                        <li class="mb-3 d-flex justify-content-between align-items-center">
                            <span>
                                <i class="bi bi-file-earmark-check text-danger"></i> ورقة الجرد
                            </span>
                            <div>
                                <a href="{{ route('reports.inventory.inventoryCount') }}" class="btn btn-link">عرض</a>
                            </div>
                        </li>
                        <li class="mb-3 d-flex justify-content-between align-items-center">
                            <span>
                                <i class="bi bi-file-earmark-text text-info"></i> ملخص عمليات المخزون
                            </span>
                            <div>
                                <a href="{{ route('reports.inventory.inventorySummary') }}" class="btn btn-link">عرض</a>
                            </div>
                        </li>
                        <li class="mb-3 d-flex justify-content-between align-items-center">
                            <span>
                                <i class="bi bi-file-earmark-list text-primary"></i> الحركة التفصيلية للمخزون
                            </span>
                            <div>
                                <a href="{{ route('reports.inventory.inventoryMovement') }}" class="btn btn-link">عرض</a>
                            </div>
                        </li>
                        <li class="mb-3 d-flex justify-content-between align-items-center">
                            <span>
                                <i class="bi bi-currency-dollar text-primary"></i> قيمة المخزون
                            </span>
                            <div>
                                <a href="{{ route('reports.inventory.inventoryValue') }}" class="btn btn-link">عرض</a>
                            </div>
                        </li>
                        <li class="mb-3 d-flex justify-content-between align-items-center">
                            <span>
                                <i class="bi bi-piggy-bank text-primary"></i> ملخص رصيد المخازن
                            </span>
                            <div>
                                <a href="{{ route('reports.inventory.inventoryBalanceSummary') }}" class="btn btn-link">عرض</a>
                            </div>
                        </li>
                        <li class="mb-3 d-flex justify-content-between align-items-center">
                            <span>
                                <i class="bi bi-bar-chart text-primary"></i> ميزان مراجعة المنتجات
                            </span>
                            <div>
                                <a href="{{ route('reports.inventory.productTrialBalance') }}" class="btn btn-link">عرض</a>
                            </div>
                        </li>
                        <li class="mb-3 d-flex justify-content-between align-items-center">
                            <span>
                                <i class="bi bi-boxes text-primary"></i> تفاصيل حركات المخزون لكل منتج
                            </span>
                            <div>
                                <a href="{{ route('reports.inventory.productMovementDetails') }}" class="btn btn-link">عرض</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title text-primary mb-4">
                        <i class="bi bi-truck"></i> تتبع المنتجات
                    </h5>
                    <ul class="list-unstyled">
                        <li class="mb-3 d-flex justify-content-between align-items-center">
                            <span>
                                <i class="bi bi-truck text-primary"></i> تتبع المنتجات برقم الشحنة و تاريخ الانتهاء
                            </span>
                            <div>
                                <a href="{{ route('reports.inventory.trackProductsByBatchAndExpiry') }}" class="btn btn-link">عرض</a>
                            </div>
                        </li>
                        <li class="mb-3 d-flex justify-content-between align-items-center">
                            <span>
                                <i class="bi bi-barcode text-primary"></i> تتبع المنتجات بالرقم المتسلسل
                            </span>
                            <div>
                                <a href="{{ route('reports.inventory.trackProductsBySerialNumber') }}" class="btn btn-link">عرض</a>
                            </div>
                        </li>
                        <li class="mb-3 d-flex justify-content-between align-items-center">
                            <span>
                                <i class="bi bi-hdd text-primary"></i> تتبع المنتجات برقم الشحنة
                            </span>
                            <div>
                                <a href="{{ route('reports.inventory.trackProductsByBatch') }}" class="btn btn-link">عرض</a>
                            </div>
                        </li>
                        <li class="mb-3 d-flex justify-content-between align-items-center">
                            <span>
                                <i class="bi bi-calendar text-primary"></i> تتبع المنتجات باستخدام تاريخ الانتهاء
                            </span>
                            <div>
                                <a href="{{ route('reports.inventory.trackProductsByExpiry') }}" class="btn btn-link">عرض</a>
                            </div>
                        </li>
                    
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
