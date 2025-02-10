@extends('master')

@section('title')
تقارير العملاء
@stop

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">تقارير العملاء</h2>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">الرئيسية</a></li>
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
                        <i class="bi bi-graph-up"></i> تقارير العملاء
                    </h5>
                    <ul class="list-unstyled">
                        <li class="mb-3 d-flex justify-content-between align-items-center">
                            <span>
                                <i class="bi bi-diagram-3-fill text-danger"></i> أعمار الديون (الفواتير)
                            </span>
                            <div>
                                <a href="{{ route('reports.customers.agingInvoices') }}" class="btn btn-link">عرض</a>
                            </div>
                        </li>
                        <li class="mb-3 d-flex justify-content-between align-items-center">
                            <span>
                                <i class="bi bi-tree-fill text-info"></i> أعمار الديون (حساب الأستاذ)
                            </span>
                            <div>
                                <a href="{{ route('reports.customers.agingLedger') }}" class="btn btn-link">عرض</a>
                            </div>
                        </li>
                        <li class="mb-3 d-flex justify-content-between align-items-center">
                            <span>
                                <i class="bi bi-person-lines-fill text-primary"></i> دليل العملاء
                            </span>
                            <div>
                                <a href="{{ route('reports.customers.customerDirectory') }}" class="btn btn-link">عرض</a>
                            </div>
                        </li>
                        <li class="mb-3 d-flex justify-content-between align-items-center">
                            <span>
                                <i class="bi bi-wallet2 text-primary"></i> أرصدة العملاء
                            </span>
                            <div>
                                <a href="{{ route('reports.customers.customerBalances') }}" class="btn btn-link">عرض</a>
                            </div>
                        </li>
                        <li class="mb-3 d-flex justify-content-between align-items-center">
                            <span>
                                <i class="bi bi-cart4 text-info"></i> مبيعات العملاء
                            </span>
                            <div>
                                <a href="{{ route('reports.customers.customerSales') }}" class="btn btn-link">عرض</a>
                            </div>
                        </li>
                        <li class="mb-3 d-flex justify-content-between align-items-center">
                            <span>
                                <i class="bi bi-credit-card text-primary"></i> مدفوعات العملاء
                            </span>
                            <div>
                                <a href="{{ route('reports.customers.customerPayments') }}" class="btn btn-link">عرض</a>
                            </div>
                        </li>
                        <li class="mb-3 d-flex justify-content-between align-items-center">
                            <span>
                                <i class="bi bi-journal text-primary"></i> كشف حساب العملاء
                            </span>
                            <div>
                                <a href="{{ route('reports.customers.customerStatements') }}" class="btn btn-link">عرض</a>
                            </div>
                        </li>
                        <li class="mb-3 d-flex justify-content-between align-items-center">
                            <span>
                                <i class="bi bi-calendar-day text-primary"></i> مواعيد العملاء
                            </span>
                            <div>
                                <a href="{{ route('reports.customers.customerAppointments') }}" class="btn btn-link">عرض</a>
                            </div>
                        </li>
                        <li class="mb-3 d-flex justify-content-between align-items-center">
                            <span>
                                <i class="bi bi-calendar-check text-info"></i> أقساط العملاء
                            </span>
                            <div>
                                <a href="{{ route('reports.customers.customerInstallments') }}" class="btn btn-link">عرض</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
