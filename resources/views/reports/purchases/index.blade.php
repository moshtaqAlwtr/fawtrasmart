@extends('master')

@section('title')
    تقارير المشتريات
@stop

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="{{ asset('assets/css/report.css') }}">
<style>
    /* أنماط مخصصة لتنسيق التقارير */
    .report-link {
        display: inline-flex;
        align-items: center;
        padding: 5px 10px;
        border-radius: 4px;
        background-color: #f8f9fa;
        color: #333;
        transition: all 0.3s ease;
        border: 1px solid #dee2e6;
        margin-left: 8px;
        font-size: 13px;
    }

    .report-link:hover {
        background-color: #e9ecef;
        text-decoration: none;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .report-link i {
        margin-right: 5px;
        font-size: 12px;
    }

    .report-link.details {
        background-color: #f0f7ff;
        border-color: #cce5ff;
        color: #0062cc;
    }

    .report-link.summary {
        background-color: #f0fff4;
        border-color: #c3e6cb;
        color: #155724;
    }

    .report-link.view {
        background-color: #fff5f5;
        border-color: #f5c6cb;
        color: #721c24;
    }

    .list-group-item {
        display: flex;
        align-items: center;
        padding: 12px 15px;
    }

    .list-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        margin-left: 10px;
        color: white;
        font-size: 14px;
    }

    /* ألوان أيقونات القوائم */
    .orange { background-color: #fd7e14; }
    .red { background-color: #dc3545; }
    .green { background-color: #28a745; }
    .blue { background-color: #007bff; }
    .teal { background-color: #20c997; }
    .purple { background-color: #6f42c1; }
    .gradient-blue { background: linear-gradient(135deg, #007bff, #00b4ff); }
    .gradient-orange { background: linear-gradient(135deg, #fd7e14, #ff9d2e); }
    .gradient-red { background: linear-gradient(135deg, #dc3545, #ff6b6b); }
    .gradient-teal { background: linear-gradient(135deg, #20c997, #3dd5f3); }
    .gradient-purple { background: linear-gradient(135deg, #6f42c1, #9c42f5); }
    .gradient-green { background: linear-gradient(135deg, #28a745, #5cb85c); }

    .card-title i {
        margin-left: 8px;
        color: #5a5a5a;
    }

    .card {
        margin-bottom: 20px;
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .card-body {
        padding: 1.25rem;
    }

    .content-header-title {
        font-weight: 600;
    }
</style>
@endsection

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">تقارير المشتريات</h2>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">الرئيسيه</a></li>
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
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fa-solid fa-chart-line"></i>
                        تقارير متابعة المشتريات المقسمة
                    </h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <span class="list-icon orange">
                                <i class="fa-solid fa-truck"></i>
                            </span>
                            <span class="flex-grow-1">المشتريات حسب المورد</span>
                            <div class="d-flex">
                                <a href="{{route('ReportsPurchases.bySupplier')}}" class="report-link details">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="{{route('ReportsPurchases.bySupplier')}}" class="report-link summary">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon red">
                                <i class="fa-solid fa-user-tie"></i>
                            </span>
                            <span class="flex-grow-1">المشتريات حسب الموظف</span>
                            <div class="d-flex">
                                <a href="{{route('ReportsPurchases.purchaseByEmployee')}}" class="report-link details">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="{{route('ReportsPurchases.purchaseByEmployee')}}" class="report-link summary">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- تقارير الموردين -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fa-solid fa-chart-bar"></i>
                        تقارير الموردين
                    </h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <span class="list-icon blue">
                                <i class="fa-solid fa-address-book"></i>
                            </span>
                            <span class="flex-grow-1">دليل الموردين</span>
                            <div class="d-flex">
                                <a href="{{route('ReportsPurchases.SuppliersDirectory')}}" class="report-link view">
                                    <i class="fa-solid fa-eye"></i> عرض
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon teal">
                                <i class="fa-solid fa-balance-scale"></i>
                            </span>
                            <span class="flex-grow-1">أرصدة الموردين</span>
                            <div class="d-flex">
                                <a href="{{route('ReportsPurchases.balnceSuppliers')}}" class="report-link view">
                                    <i class="fa-solid fa-eye"></i> عرض
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon purple">
                                <i class="fa-solid fa-clock"></i>
                            </span>
                            <span class="flex-grow-1">أعمار المدين حساب الاستاذ العام</span>
                            <div class="d-flex">
                                <a href="#" class="report-link view">
                                    <i class="fa-solid fa-eye"></i> عرض
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon green">
                                <i class="fa-solid fa-shopping-cart"></i>
                            </span>
                            <span class="flex-grow-1">مشتريات الموردين</span>
                            <div class="d-flex">
                                <a href="{{route('ReportsPurchases.purchaseSupplier')}}" class="report-link view">
                                    <i class="fa-solid fa-eye"></i> عرض
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- تقرير مشتريات المنتجات -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fa-solid fa-chart-line"></i>
                        تقرير مشتريات المنتجات
                    </h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <span class="list-icon gradient-orange">
                                <i class="fa-solid fa-box"></i>
                            </span>
                            <span class="flex-grow-1">مشتريات المنتجات حسب المنتج</span>
                            <div class="d-flex">
                                <a href="{{route('ReportsPurchases.prodectPurchases')}}" class="report-link details">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="{{route('ReportsPurchases.prodectPurchases')}}" class="report-link summary">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon gradient-red">
                                <i class="fa-solid fa-truck"></i>
                            </span>
                            <span class="flex-grow-1">مشتريات المنتجات حسب المورد</span>
                            <div class="d-flex">
                                <a href="{{route('ReportsPurchases.supplierPurchases')}}" class="report-link details">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="{{route('ReportsPurchases.supplierPurchases')}}" class="report-link summary">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon gradient-teal">
                                <i class="fa-solid fa-user-tie"></i>
                            </span>
                            <span class="flex-grow-1">مشتريات المنتجات حسب الموظف</span>
                            <div class="d-flex">
                                <a href="{{route('ReportsPurchases.employeePurchases')}}" class="report-link details">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="{{route('ReportsPurchases.employeePurchases')}}" class="report-link summary">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- تقارير المدفوعات بالمدة الزمنية -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fa-solid fa-chart-bar"></i>
                        تقارير المدفوعات بالمدة الزمنية
                    </h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <span class="list-icon gradient-blue">
                                <i class="fa-solid fa-sun"></i>
                            </span>
                            <span class="flex-grow-1">المدفوعات اليومية</span>
                            <div class="d-flex">
                                <a href="{{route('ReportsPurchases.supplierPayments', ['report_period' => 'daily'])}}" class="report-link view">
                                    <i class="fa-solid fa-eye"></i> عرض
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon gradient-blue">
                                <i class="fa-solid fa-calendar-week"></i>
                            </span>
                            <span class="flex-grow-1">المدفوعات الأسبوعية</span>
                            <div class="d-flex">
                                <a href="{{route('ReportsPurchases.supplierPayments', ['report_period' => 'weekly'])}}" class="report-link view">
                                    <i class="fa-solid fa-eye"></i> عرض
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon gradient-blue">
                                <i class="fa-solid fa-calendar-alt"></i>
                            </span>
                            <span class="flex-grow-1">المدفوعات الشهرية</span>
                            <div class="d-flex">
                                <a href="{{route('ReportsPurchases.supplierPayments', ['report_period' => 'monthly'])}}" class="report-link view">
                                    <i class="fa-solid fa-eye"></i> عرض
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon gradient-blue">
                                <i class="fa-solid fa-calendar"></i>
                            </span>
                            <span class="flex-grow-1">المدفوعات السنوية</span>
                            <div class="d-flex">
                                <a href="{{route('ReportsPurchases.supplierPayments', ['report_period' => 'yearly'])}}" class="report-link view">
                                    <i class="fa-solid fa-eye"></i> عرض
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- تقارير مدفوعات المشتريات -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fa-solid fa-money-bill-wave"></i>
                        تقارير مدفوعات المشتريات
                    </h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <span class="list-icon gradient-purple">
                                <i class="fa-solid fa-money-bill"></i>
                            </span>
                            <span class="flex-grow-1">مدفوعات مشتريات الموردين</span>
                            <div class="d-flex">
                                <a href="{{route('ReportsPurchases.paymentPurchases')}}" class="report-link view">
                                    <i class="fa-solid fa-eye"></i> عرض
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon gradient-green">
                                <i class="fa-solid fa-file-invoice"></i>
                            </span>
                            <span class="flex-grow-1">كشف حساب الموردين</span>
                            <div class="d-flex">
                                <a href="#" class="report-link view">
                                    <i class="fa-solid fa-eye"></i> عرض
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection
