@extends('master')

@section('title')
الأيرادات والمصروفات حسب نوع الوحدة الأكبر  
@stop

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">الأيرادات والمصروفات حسب نوع الوحدة الأكبر
                    
                </h2>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">الرئيسية</a>
                        </li>
                        <li class="breadcrumb-item active">عرض
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">نموذج البحث</h5>
    </div>
    <div class="card-body">
        <form method="GET">
            <div class="row g-4">
                <!-- الموظف -->
               

                <!-- الفترة من -->
                <div class="col-md-4">
                    <label for="date_from" class="form-label">تاريخ البدء من:</label>
                    <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" class="form-control">
                </div>

                <!-- الفترة إلى -->
                <div class="col-md-4">
                    <label for="date_to" class="form-label">تاريخ البدء إلى:</label>
                    <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" class="form-control">
                </div>
            </div>
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="group_by" class="form-label">فرع :</label>
                    <select class="form-control" id="group_by" name="group_by">
                        <option>الكل</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="group_by" class="form-label">تجميع حسب :</label>
                    <select class="form-control" id="group_by" name="group_by">
                        <option>شهري</option>
                        <option>باقة</option>
                        <option>يومي</option>
                        <option>سنوي</option>
                        <option>اسبوعي</option>
                        <option>فرع</option>
                    </select>
                </div>
                <div class="col-md-4 mb-4">
                        <label for="currency" class="form-label">العملة</label>
                        <select id="currency" class="form-control">
                            <option>الكل</option>
                        </select>
                    </div>
            </div>
            <div class="d-flex justify-content-start mt-3">
                <!-- زر البحث -->
                <button type="submit" class="btn btn-primary me-2 waves-effect waves-light">بحث</button>

                <!-- زر الإلغاء -->
                <button type="reset" class="btn btn-outline-warning waves-effect waves-light">إلغاء</button>
            </div>
        </form>
    </div>
</div>
@endsection