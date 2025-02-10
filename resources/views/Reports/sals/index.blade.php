<!-- العنوان -->
@extends('master')

@section('title')
تقارير المبيعات
@stop


@section('content')


<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">تقارير المبيعات</h2>
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

<div class="container mt-5">
    <div class="row">
        <!-- الكارت الأول -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fa-solid fa-chart-line"></i>
                        تقارير متابعة الفواتير المقسمة
                    </h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex align-items-center justify-content-between">
                            <span>
                                <span class="list-icon orange">
                                    <i class="fa-solid fa-user"></i>
                                </span>
                                المبيعات حسب العميل
                            </span>
                            <div>
                                <a href="{{ route('sals_reports.byCustomer') }}" class="text-decoration-none">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="path-to-summary-page" class="text-decoration-none ms-3">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-center justify-content-between">
                            <span>
                                <span class="list-icon red">
                                    <i class="fa-solid fa-user-tie"></i>
                                </span>
                                المبيعات حسب الموظف
                            </span>
                            <div>
                                <a href="{{ route('sals_reports.byEmployee') }}"
                                    class="text-decoration-none">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="path-to-summary-page" class="text-decoration-none ms-3">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-center justify-content-between">
                            <span>
                                <span class="list-icon green">
                                    <i class="fa-solid fa-handshake"></i>
                                </span>
                                المبيعات حسب مندوب المبيعات
                            </span>
                            <div>
                                <a href="{{ route('sals_reports.byRepresentative') }}"
                                    class="text-decoration-none">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="path-to-summary-page" class="text-decoration-none ms-3">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- الكارت الثاني -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fa-solid fa-chart-bar"></i>
                        تقارير مبيعات المنتجات بالمدة الزمنية
                    </h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex align-items-center justify-content-between">
                            <span>
                                <span class="list-icon blue">
                                    <i class="fa-solid fa-calendar-day"></i>
                                </span>
                                المبيعات اليومية للمنتجات
                            </span>
                            <div>
                                <a href="{{ route('reports.sals.by_Product') }}" class="text-decoration-none">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="path-to-summary-page" class="text-decoration-none ms-3">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-center justify-content-between">
                            <span>
                                <span class="list-icon blue">
                                    <i class="fa-solid fa-calendar-week"></i>
                                </span>
                                المبيعات الأسبوعية للمنتجات
                            </span>
                            <div>
                                <a href="{{ route('reports.sals.Weekly_by_Product') }}" class="text-decoration-none">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="path-to-summary-page" class="text-decoration-none ms-3">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-center justify-content-between">
                            <span>
                                <span class="list-icon blue">
                                    <i class="fa-solid fa-calendar-alt"></i>
                                </span>
                                المبيعات الشهرية للمنتجات
                            </span>
                            <div>
                                <a href="{{ route('reports.sals.Monthly_by_Product') }}"
                                    class="text-decoration-none">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="path-to-summary-page" class="text-decoration-none ms-3">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-center justify-content-between">
                            <span>
                                <span class="list-icon blue">
                                    <i class="fa-solid fa-calendar"></i>
                                </span>
                                المبيعات السنوية للمنتجات
                            </span>
                            <div>
                                <a href="{{ route('reports.sals.Annual_by_Product') }}"
                                    class="text-decoration-none">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="path-to-summary-page" class="text-decoration-none ms-3">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container mt-5">
    <div class="row">
        <!-- أول كرت -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fa-solid fa-chart-line"></i>
                        تقارير الفواتير حسب المدة الزمنية
                    </h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <span class="list-icon blue">
                                <i class="fa-solid fa-calendar-day"></i>
                            </span>
                            المبيعات اليومية
                            <div class="ms-auto">
                                <a href="{{ route('reports.sals.D_Sales') }}" class="text-decoration-none">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="path-to-summary-page" class="text-decoration-none ms-3">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon blue">
                                <i class="fa-solid fa-calendar-week"></i>
                            </span>
                            المبيعات الأسبوعية
                            <div class="ms-auto">
                                <a href="{{ route('reports.sals.W_Sales') }}" class="text-decoration-none">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="path-to-summary-page" class="text-decoration-none ms-3">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon blue">
                                <i class="fa-solid fa-calendar-alt"></i>
                            </span>
                            المبيعات الشهرية
                            <div class="ms-auto">
                                <a href="{{ route('reports.sals.M_Sales') }}" class="text-decoration-none">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="path-to-summary-page" class="text-decoration-none ms-3">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon blue">
                                <i class="fa-solid fa-calendar"></i>
                            </span>
                            المبيعات السنوية
                            <div class="ms-auto">
                                <a href="{{ route('reports.sals.A_Sales') }}" class="text-decoration-none">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="path-to-summary-page" class="text-decoration-none ms-3">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- ثاني كرت -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fa-solid fa-chart-bar"></i>
                        تقارير المدفوعات المقسمة
                    </h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <span class="list-icon orange">
                                <i class="fa-solid fa-user"></i>
                            </span>
                            المدفوعات حسب العميل
                            <div class="ms-auto">
                                <a href="{{ route('reports.sals.Payments_by_Customer') }}" class="text-decoration-none">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="path-to-summary-page" class="text-decoration-none ms-3">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon red">
                                <i class="fa-solid fa-user-tie"></i>
                            </span>
                            المدفوعات حسب الموظف
                            <div class="ms-auto">
                                <a href="{{ route('reports.sals.Payments_by_Employee') }}" class="text-decoration-none">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="path-to-summary-page" class="text-decoration-none ms-3">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon teal">
                                <i class="fa-solid fa-cash-register"></i>
                            </span>
                            المدفوعات حسب طريقة الدفع
                            <div class="ms-auto">
                                <a href="{{ route('reports.sals.Payments_by_Payment_Method') }}" class="text-decoration-none">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="path-to-summary-page" class="text-decoration-none ms-3">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="row d-flex justify-content-start">
        <!-- أول كرت -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fa-solid fa-chart-line"></i>
                        تقارير المدفوعات بالمدة الزمنية
                    </h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <span class="list-icon blue">
                                <i class="fa-solid fa-calendar-day"></i>
                            </span>
                            المدفوعات اليومية
                            <div class="ms-auto">
                                <a href="{{ route('reports.sals.Daily_Payments') }}" class="text-decoration-none">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="path-to-summary-page" class="text-decoration-none ms-3">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon blue">
                                <i class="fa-solid fa-calendar-week"></i>
                            </span>
                            المدفوعات الأسبوعية
                            <div class="ms-auto">
                                <a href="{{ route('reports.sals.Weekly_Payments') }}" class="text-decoration-none">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="path-to-summary-page" class="text-decoration-none ms-3">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon blue">
                                <i class="fa-solid fa-calendar-alt"></i>
                            </span>
                            المدفوعات الشهرية
                            <div class="ms-auto">
                                <a href="{{ route('reports.sals.Monthly_Payments') }}" class="text-decoration-none">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="path-to-summary-page" class="text-decoration-none ms-3">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon blue">
                                <i class="fa-solid fa-calendar"></i>
                            </span>
                            المدفوعات السنوية
                            <div class="ms-auto">
                                <a href="{{ route('reports.sals.Annual_Payments') }}" class="text-decoration-none">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="path-to-summary-page" class="text-decoration-none ms-3">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- ثاني كرت -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fa-solid fa-chart-bar"></i>
                        أرباح مبيعات الأصناف
                    </h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <span class="list-icon orange">
                                <i class="fa-solid fa-box"></i>
                            </span>
                            أرباح مبيعات الأصناف - المنتجات
                            <div class="ms-auto">
                                <a href="{{ route('reports.sals.products_profit') }}" class="text-decoration-none">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="path-to-summary-page" class="text-decoration-none ms-3">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon red">
                                <i class="fa-solid fa-user"></i>
                            </span>
                            أرباح مبيعات الأصناف - العميل
                            <div class="ms-auto">
                                <a href="{{ route('reports.sals.Customer_Profit') }}" class="text-decoration-none">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="path-to-summary-page" class="text-decoration-none ms-3">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon green">
                                <i class="fa-solid fa-user-tie"></i>
                            </span>
                            أرباح مبيعات الأصناف - موظف
                            <div class="ms-auto">
                                <a href="{{ route('reports.sals.Employee_Profit') }}" class="text-decoration-none">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="path-to-summary-page" class="text-decoration-none ms-3">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon purple">
                                <i class="fa-solid fa-handshake"></i>
                            </span>
                            أرباح مبيعات الأصناف - مسؤول مبيعات
                            <div class="ms-auto">
                                <a href="{{ route('reports.sals.Manager_Profit') }}" class="text-decoration-none">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="path-to-summary-page" class="text-decoration-none ms-3">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container mt-5">
    <div class="row">
        <!-- أول كرت -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fa-solid fa-chart-line"></i>
                        تقارير الربح حسب الفترة
                    </h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <span class="list-icon gradient-blue">
                                <i class="fa-solid fa-calendar-day"></i>
                            </span>
                            الأرباح اليومية
                            <div class="ms-auto">
                                <a href="{{ route('reports.sals.Daily_Profits') }}" class="text-decoration-none">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="path-to-summary-page" class="text-decoration-none ms-3">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon gradient-blue">
                                <i class="fa-solid fa-calendar-week"></i>
                            </span>
                            الأرباح الأسبوعية
                            <div class="ms-auto">
                                <a href="{{ route('reports.sals.Weekly_Profits') }}" class="text-decoration-none">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="path-to-summary-page" class="text-decoration-none ms-3">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon gradient-blue">
                                <i class="fa-solid fa-calendar"></i>
                            </span>
                            الأرباح السنوية
                            <div class="ms-auto">
                                <a href="{{ route('reports.sals.Annual_Profits') }}" class="text-decoration-none">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="path-to-summary-page" class="text-decoration-none ms-3">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- ثاني كرت -->
        <div class="col-md-6 mb-4">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">
                <i class="fa-solid fa-chart-bar"></i>
                تقارير مبيعات البنود المقسمة
            </h5>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <span class="list-icon gradient-orange">
                        <i class="fa-solid fa-box"></i>
                    </span>
                    مبيعات البنود حسب البند
                    <div class="ms-auto">
                        <a href="{{ route('reports.sals.Sales_By_Item') }}" class="text-decoration-none">
                            <i class="fa-solid fa-file-lines"></i> التفاصيل
                        </a>
                        <a href="{{ route('reports.sals.Sales_By_Item') }}" class="text-decoration-none ms-3">
                            <i class="fa-solid fa-clipboard"></i> الملخص
                        </a>
                    </div>
                </li>
                <li class="list-group-item">
                    <span class="list-icon gradient-red">
                        <i class="fa-solid fa-tags"></i>
                    </span>
                    مبيعات البنود حسب التصنيف
                    <div class="ms-auto">
                        <a href="{{ route('reports.sals.Sales_By_Category') }}" class="text-decoration-none">
                            <i class="fa-solid fa-file-lines"></i> التفاصيل
                        </a>
                        <a href="{{ route('reports.sals.Sales_By_Category') }}" class="text-decoration-none ms-3">
                            <i class="fa-solid fa-clipboard"></i> الملخص
                        </a>
                    </div>
                </li>
                <li class="list-group-item">
                    <span class="list-icon gradient-teal">
                        <i class="fa-solid fa-tag"></i>
                    </span>
                    مبيعات البنود حسب الماركة
                    <div class="ms-auto">
                        <a href="{{ route('reports.sals.Sales_By_Brand') }}" class="text-decoration-none">
                            <i class="fa-solid fa-file-lines"></i> التفاصيل
                        </a>
                        <a href="{{ route('reports.sals.Sales_By_Brand') }}" class="text-decoration-none ms-3">
                            <i class="fa-solid fa-clipboard"></i> الملخص
                        </a>
                    </div>
                </li>
                <li class="list-group-item">
                    <span class="list-icon gradient-purple">
                        <i class="fa-solid fa-user-tie"></i>
                    </span>
                    مبيعات البنود حسب الموظف
                    <div class="ms-auto">
                        <a href="{{ route('reports.sals.Sales_By_Employee') }}" class="text-decoration-none">
                            <i class="fa-solid fa-file-lines"></i> التفاصيل
                        </a>
                        <a href="{{ route('reports.sals.Sales_By_Employee') }}" class="text-decoration-none ms-3">
                            <i class="fa-solid fa-clipboard"></i> الملخص
                        </a>
                    </div>
                </li>
                <li class="list-group-item">
                    <span class="list-icon gradient-green">
                        <i class="fa-solid fa-handshake"></i>
                    </span>
                    مبيعات البنود حسب مندوب المبيعات
                    <div class="ms-auto">
                        <a href="{{ route('reports.sals.Sales_By_SalesRep') }}" class="text-decoration-none">
                            <i class="fa-solid fa-file-lines"></i> التفاصيل
                        </a>
                        <a href="{{ route('reports.sals.Sales_By_SalesRep') }}" class="text-decoration-none ms-3">
                            <i class="fa-solid fa-clipboard"></i> الملخص
                        </a>
                    </div>
                </li>
                <li class="list-group-item">
                    <span class="list-icon gradient-blue">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    مبيعات البنود حسب العميل
                    <div class="ms-auto">
                        <a href="{{ route('reports.sals.Sales_By_Customer') }}" class="text-decoration-none">
                            <i class="fa-solid fa-file-lines"></i> التفاصيل
                        </a>
                        <a href="{{ route('reports.sals.Sales_By_Customer') }}" class="text-decoration-none ms-3">
                            <i class="fa-solid fa-clipboard"></i> الملخص
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