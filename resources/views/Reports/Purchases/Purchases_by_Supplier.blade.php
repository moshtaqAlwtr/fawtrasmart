@extends('master')

@section('title')
تقرير المشتريات حسب المورد
@stop


@section('content')


<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">تقرير المشتريات حسب المورد</h2>
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

<div class="container mt-4">
    <div class="card shadow">
        <!-- عنوان الكرت -->
        <div class="card-header bg-primary text-white">
            <h5 class="mb-1">بحث حسب المورد </h5>
        </div>

        <!-- محتوى الكرت -->
        <div class="card-body">
            <form>
                <!-- السطر الأول -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="from-date" class="form-label">التاريخ من</label>
                        <input type="date" class="form-control" id="from-date">
                    </div>
                    <div class="col-md-4">
                        <label for="to-date" class="form-label">التاريخ إلى</label>
                        <input type="date" class="form-control" id="to-date">
                    </div>
                    <div class="col-md-4">
                        <label for="supplier">المورد:</label>
                        <select class="form-control" id="supplier">
                            <option>اختر مورد</option>
                        </select>
                    </div>
                </div>

                <!-- السطر الثاني -->
                <div class="row mb-3">
                <div class="col-md-4">
                        <label for="employee">موظف:</label>
                        <select class="form-control" id="employee">
                            <option>الكل</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="product">المنتج</label>
                        <select class="form-control" id="product">
                            <option>الكل</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="total">تجميع حسب:</label>
                        <select class="form-control" id="total">
                            <option>الكل</option>
                        </select>
                    </div>
                </div>

                <!-- السطر الثالث -->
                <div class="row mb-3">
                <div class="col-md-4">
                        <label for="trteb">ترتيب حسب:</label>
                        <select class="form-control" id="trteb">
                            <option>الكل</option>
                        </select>
                    </div>
                </div>

                <!-- أزرار البحث والإلغاء -->
                <div class="form-actions">
                        <button type="submit" class="btn btn-primary mr-1 waves-effect waves-light">بحث</button>
                        <button type="reset" class="btn btn-outline-warning waves-effect waves-light">ألغاء</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- رسالة عدم وجود بيانات -->
        <div class="card-footer bg-light border-0">
            <div class="alert alert-warning mb-0 text-center" role="alert">
                لا توجد بيانات توافق معطيات البحث.
            </div>
        </div>
    </div>
</div>

    @endsection