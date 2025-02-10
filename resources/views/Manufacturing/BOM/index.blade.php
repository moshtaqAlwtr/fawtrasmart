@extends('master')

@section('title')
قوائم مواد الأنتاج
@stop

@section('content')

<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">قوائم مواد الأنتاج</h2>
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

<div class="content-body">

    <!-- بطاقة البحث -->
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <div class="card-title">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>بحث</div>
                        <div>
                            <a href="{{ route('BOM.create') }}" class="btn btn-outline-success">
                                <i class="fa fa-plus me-2"></i>أضف قائمة مواد الأنتاج
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row mb-3 mt-3">
                    <div class="col">
                        <input type="text" class="form-control" placeholder="البحث بواسطة الاسم أو الكود">
                    </div>
                    <div class="col">
                        <select class="form-control" aria-label="فرز بواسطة المنتج">
                            <option selected>فرز بواسطة المنتج</option>
                            <option value="1">منتج 1</option>
                            <option value="2">منتج 2</option>
                        </select>
                    </div>
                    <div class="col">
                        <select class="form-control" aria-label="إختر الحالة">
                            <option selected>إختر الحالة</option>
                            <option value="1">نشط</option>
                            <option value="2">غير نشط</option>
                        </select>
                    </div>
                    <div class="col">
                        <select class="form-control" aria-label="Filter by Production Operation">
                            <option selected>Filter by Production Operation</option>
                            <option value="1">Operation 1</option>
                            <option value="2">Operation 2</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary">بحث</button>
                        <button class="btn btn-secondary">إعادة تعيين</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- بطاقة الجدول -->
    <div class="card mt-4">
        <div class="card-body">
            <table class="table table-striped table-hover text-right">
                <thead class="thead-light">
                    <tr>
                        <th>الاسم</th>
                        <th>المنتج الرئيسي</th>
                        <th>كمية الإنتاج</th>
                        <th>إجمالي التكلفة</th>
                        <th>الحالة</th>
                        <th>الافتراضي</th>
                        <th>ترتيب</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>تصنيع عطر</td>
                        <td>عطر 50 ملي</td>
                        <td>3600</td>
                        <td>19,592 ر.س</td>
                        <td><span class="text-success">نشط</span></td>
                        <td>افتراضي</td>
                        <td>
                            <div class="btn-group">
                                <div class="dropdown">
                                    <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1" type="button"id="dropdownMenuButton303" data-toggle="dropdown" aria-haspopup="true"aria-expanded="false"></button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton303">
                                        <li>
                                            <a class="dropdown-item" href="">
                                                <i class="fa fa-eye me-2 text-primary"></i>عرض
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="">
                                                <i class="fa fa-edit me-2 text-success"></i>تعديل
                                            </a>
                                        </li>

                                        <li>
                                            <a class="dropdown-item text-danger" href="#">
                                                <i class="fa fa-trash me-2"></i>حذف
                                            </a>
                                        </li>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>تصنيع شامبو</td>
                        <td>شامبو 100 ملي</td>
                        <td>2500</td>
                        <td>10,000 ر.س</td>
                        <td><span class="text-danger">غير نشط</span></td>
                        <td>افتراضي</td>
                        <td>
                            <div class="btn-group">
                                <div class="dropdown">
                                    <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1" type="button"id="dropdownMenuButton303" data-toggle="dropdown" aria-haspopup="true"aria-expanded="false"></button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton303">
                                        <li>
                                            <a class="dropdown-item" href="">
                                                <i class="fa fa-eye me-2 text-primary"></i>عرض
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="">
                                                <i class="fa fa-edit me-2 text-success"></i>تعديل
                                            </a>
                                        </li>

                                        <li>
                                            <a class="dropdown-item text-danger" href="#">
                                                <i class="fa fa-trash me-2"></i>حذف
                                            </a>
                                        </li>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
