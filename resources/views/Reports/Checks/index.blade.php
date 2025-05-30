@extends('master')

@section('title')
تقارير شحن الارصدة
@stop

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0"> تقارير شحن الارصدة</h2>
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

<div class="container mt-4">
    <div class="row">
        <!-- كرت تقرير الشيكات -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title text-primary">
                        <i class="bi bi-cash-stack"></i> تقارير
                    </h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="bi bi-arrow-up-right-circle text-success"></i> تقرير شحن الارصدة
                            <a href="{{ route('ClientReport.rechargeBalancesReport') }}" class="btn btn-link p-0">عرض</a>
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-arrow-up-right-circle text-success"></i> تقرير  استهلاك الارصدة
                            <a href="{{ route('ClientReport.rechargeBalancesReport') }}" class="btn btn-link p-0">عرض</a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
