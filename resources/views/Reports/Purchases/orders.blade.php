@extends('master')

@section('title')
تقارير المشتريات
@stop


@section('content')


<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">تقارير المشتريات</h2>
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
        <!-- كرت تقرير الموردين -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title text-primary"><i class="fas fa-book"></i> تقارير الموردين</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-book text-success"></i> دليل الموردين
                            <a href="{{route('reports.purchases.supplier_directory')}}" class="btn btn-link p-0">عرض</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-money-bill-alt text-info"></i> أرصدة الموردين
                            <a href="{{route('reports.purchases.balances')}}" class="btn btn-link p-0">التفاصيل</a> | 
                            <a href="#" class="btn btn-link p-0">الملخص</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-chart-line text-warning"></i> أعمار المدين (حساب الأستاذ)
                            <a href="{{route('reports.purchases.aged')}}" class="btn btn-link p-0">عرض</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-shopping-cart text-danger"></i> مشتريات الموردين
                            <a href="{{route('reports.purchases.suppliers_purchases')}}" class="btn btn-link p-0">عرض</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-file-invoice-dollar text-primary"></i> مدفوعات فواتير الشراء
                            <a href="{{route('reports.purchases.payments')}}" class="btn btn-link p-0">عرض</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-receipt text-secondary"></i> كشف حساب الموردين
                            <a href="{{route('reports.purchases.supplier_statement')}}" class="btn btn-link p-0">عرض</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- كرت تقرير المشتريات المقسمة -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title text-primary"><i class="fas fa-user-tie"></i> تقارير متابعة المشتريات المقسمة</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-user-tie text-danger"></i> المشتريات حسب المورد
                            <a href="{{route('reports.purchases.by_supplier')}}" class="btn btn-link p-0">التفاصيل</a> | 
                            <a href="#" class="btn btn-link p-0">الملخص</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-user text-success"></i> المشتريات حسب الموظف
                            <a href="{{route('reports.purchases.by_employee')}}" class="btn btn-link p-0">التفاصيل</a> | 
                            <a href="#" class="btn btn-link p-0">الملخص</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- كرت تقارير المدفوعات -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title text-primary"><i class="fas fa-calendar-alt"></i> تقارير المدفوعات بالمدة الزمنية</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-calendar-day text-info"></i> المدفوعات اليومية
                            <a href="{{route('reports.purchases.daily_payments')}}" class="btn btn-link p-0">التفاصيل</a> | 
                            <a href="#" class="btn btn-link p-0">الملخص</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-calendar-week text-warning"></i> المدفوعات الأسبوعية
                            <a href="{{route('reports.purchases.weekly_payments')}}" class="btn btn-link p-0">التفاصيل</a> | 
                            <a href="#" class="btn btn-link p-0">الملخص</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-calendar-alt text-primary"></i> المدفوعات الشهرية
                            <a href="{{route('reports.purchases.monthly_payments')}}" class="btn btn-link p-0">التفاصيل</a> | 
                            <a href="#" class="btn btn-link p-0">الملخص</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-calendar-alt text-primary"></i> المدفوعات السنوية
                            <a href="{{route('reports.purchases.annual_payments')}}" class="btn btn-link p-0">التفاصيل</a> | 
                            <a href="#" class="btn btn-link p-0">الملخص</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- كرت تقارير مشتريات المنتجات -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title text-primary"><i class="fas fa-box"></i> تقارير مشتريات المنتجات</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-box text-secondary"></i> تقرير حسب المنتج
                            <a href="{{route('reports.purchases.by_product')}}" class="btn btn-link p-0">التفاصيل</a> | 
                            <a href="#" class="btn btn-link p-0">الملخص</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-truck text-danger"></i> تقرير حسب المورد
                            <a href="{{route('reports.purchases.by_supplier')}}" class="btn btn-link p-0">التفاصيل</a> | 
                            <a href="#" class="btn btn-link p-0">الملخص</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-user text-success"></i> تقرير حسب الموظف
                            <a href="{{route('reports.purchases.products_by_employee')}}" class="btn btn-link p-0">التفاصيل</a> | 
                            <a href="#" class="btn btn-link p-0">الملخص</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection