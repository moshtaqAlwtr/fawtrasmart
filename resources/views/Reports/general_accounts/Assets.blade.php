@extends('master')

@section('title')
الأصول
@stop

@section('content')

<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">الأصول</h2>
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
    <div class="card">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">البحث</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="">
                <div class="row">
                    <!-- موظف -->
                    <div class="col-md-3 mb-3">
                        <label for="employee" class="form-label">موظف</label>
                        <select id="employee" class="form-control">
                            <option>الكل</option>
                            <!-- يمكنك إضافة أسماء الموظفين هنا -->
                        </select>
                    </div>

                    <!-- تاريخ الشراء من -->
                    <div class="col-md-3 mb-3">
                        <label for="purchase_from" class="form-label">تاريخ الشراء من</label>
                        <input type="date" id="purchase_from" class="form-control">
                    </div>

                    <!-- تاريخ الشراء إلى -->
                    <div class="col-md-3 mb-3">
                        <label for="purchase_to" class="form-label">تاريخ الشراء إلى</label>
                        <input type="date" id="purchase_to" class="form-control">
                    </div>

                    <!-- تاريخ الإهلاك من -->
                    <div class="col-md-3 mb-3">
                        <label for="depreciation_from" class="form-label">تاريخ الإهلاك من</label>
                        <input type="date" id="depreciation_from" class="form-control">
                    </div>

                    <!-- تاريخ الإهلاك إلى -->
                    <div class="col-md-3 mb-3">
                        <label for="depreciation_to" class="form-label">تاريخ الإهلاك إلى</label>
                        <input type="date" id="depreciation_to" class="form-control">
                    </div>

                    <!-- الحالة -->
                    <div class="col-md-3 mb-3">
                        <label for="status" class="form-label">الحالة</label>
                        <select id="status" class="form-control">
                            <option>الكل</option>
                            <!-- أضف خيارات للحالة هنا -->
                        </select>
                    </div>

                    <!-- فرع -->
                    <div class="col-md-3 mb-3">
                        <label for="branch" class="form-label">فرع</label>
                        <select id="branch" class="form-control">
                            <option>الكل</option>
                            <!-- أضف أسماء الفروع هنا -->
                        </select>
                    </div>

                    <!-- تجميع حسب -->
                    <div class="col-md-3 mb-3">
                        <label for="group_by" class="form-label">تجميع حسب</label>
                        <select id="group_by" class="form-control">
                            <option>الكل</option>
                            <!-- أضف خيارات التجميع هنا -->
                        </select>
                    </div>
                </div>

                <!-- أزرار البحث والإلغاء -->
                <div class="form-actions text-right mt-3">
                    <button type="submit" class="btn btn-primary mr-2 waves-effect waves-light">بحث</button>
                    <button type="reset" class="btn btn-outline-warning waves-effect waves-light">إلغاء</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
