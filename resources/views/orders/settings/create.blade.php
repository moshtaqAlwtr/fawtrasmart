@extends('master')

@section('title')
    أنواع الطلبات
@stop

@section('content')

    <div class="card">

    </div>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0"> أنواع الطلبات</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a>
                            </li>
                            <li class="breadcrumb-item active">أضافة
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                    </div>

                    <div>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-danger">
                            <i class="fa fa-ban"></i>الغاء
                        </a>
                        <button type="submit" form="products_form" class="btn btn-outline-primary">
                            <i class="fa fa-save"></i>حفظ
                        </button>
                    </div>

                </div>
            </div>
        </div>
<div class="card p-4">
    <h5 class="mb-3">معلومات عامة</h5>

    <form action="#" method="POST">
        @csrf

        <div class="row">
            <!-- الاسم -->
            <div class="col-md-6">
                <label class="form-label">الاسم <span class="text-danger">*</span></label>
                <input type="text" class="form-control" required>
            </div>

            <!-- الحالة -->
            <div class="col-md-6">
                <label class="form-label">الحالة</label>
                <select class="form-control">
                    <option selected>نشط</option>
                    <option>غير نشط</option>
                </select>
            </div>
        </div>

        <div class="form-check form-switch my-3">
            <input class="form-check-input" type="checkbox">
            <label class="form-check-label">Notify Approvers by Email</label>
        </div>

        <div class="form-check form-switch my-3">
            <input class="form-check-input" type="checkbox">
            <label class="form-check-label">السماح بالموافقة أو رفض طلبي</label>
        </div>

        <!-- اختيار القالب الافتراضي -->
        <div class="mb-3">
            <label class="form-label">Default Request Email Template</label>
            <select class="form-control">
                <option selected>من فضلك اختر</option>
                <option>Template 1</option>
                <option>Template 2</option>
            </select>
        </div>
<p>  الصلاحيات</p>
        <!-- الصلاحيات -->
        <div class="mb-3">
            <label class="form-label">أضافة طلب جديد</label>
            <select class="form-control">
                <option selected>الكل</option>
               
                <option>تعديل الطلبات</option>
            </select>
        </div>

        <!-- الموافقة ورفض الطلبات -->
        <div class="mb-3">
            <label class="form-label">موافقة / رفض الطلبات</label>
            <select class="form-control">
                <option selected>الكل</option>
            </select>
        </div>

        <!-- عرض الطلبات -->
        <div class="mb-3">
            <label class="form-label">عرض الطلبات</label>
            <select class="form-control">
                <option selected>الكل</option>
            </select>
        </div>

        <!-- إدارة الطلبات للآخرين -->
        <div class="mb-3">
            <label class="form-label">إدارة الطلبات للآخرين</label>
            <select class="form-control">
                <option selected>الكل</option>
            </select>
        </div>

    

    </form>
</div>
@endsection