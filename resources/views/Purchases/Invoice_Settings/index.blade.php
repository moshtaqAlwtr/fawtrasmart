@extends('master')

@section('title')
    أعدادات فواتير الشراء
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">أعدادات فواتير الشراء</h2>
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



    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">

    <div class="container my-5">
        <div class="row g-4">
            <!-- البطاقة الأولى -->
            <div class="col-md-3 col-sm-6">
                <div class="card text-center border-0 shadow-lg p-4" style="height: 250px;">
                    <div class="card-body">
                        <i class="bi bi-receipt" style="font-size: 4rem;"></i>
                        <h5 class="mt-4 fw-bold">قوالب للطباعة</h5>
                    </div>
                </div>
            </div>

            <!-- البطاقة الثانية -->
            <div class="col-md-3 col-sm-6">
                <div class="card text-center border-0 shadow-lg p-4" style="height: 250px;">
                    <div class="card-body">
                        <i class="bi bi-pencil-square" style="font-size: 4rem;"></i>
                        <h5 class="mt-4 fw-bold">تصاميم فواتير الشراء / مرتجعات المشتريات</h5>
                    </div>
                </div>
            </div>

            <!-- البطاقة الثالثة -->
            <div class="col-md-3 col-sm-6">
    <a href="{{ route('purchases.invoice_settings.create') }}" style="display: block; text-decoration: none;">
        <div class="card text-center border-0 shadow-lg p-4" style="height: 250px;">
            <div class="card-body">
                <i class="bi bi-file-text" style="font-size: 4rem;"></i>
                <h5 class="mt-4 fw-bold">فاتورة شراء</h5>
            </div>
        </div>
    </a>
</div>



            <!-- البطاقة الرابعة -->
            <div class="col-md-3 col-sm-6">
                <div class="card text-center border-0 shadow-lg p-4" style="height: 250px;">
                    <div class="card-body">
                        <i class="bi bi-credit-card" style="font-size: 4rem;"></i>
                        <h5 class="mt-4 fw-bold">حقول إضافية</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection