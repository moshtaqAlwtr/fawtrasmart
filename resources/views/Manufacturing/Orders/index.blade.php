@extends('master')

@section('title')
أوامر التصنيع
@stop

@section('content')

    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">أوامر التصنيع</h2>
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

    <div class="content-body">

        <!-- بطاقة البحث -->
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="card-title">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>بحث </div>
                            <div>
                                <a href="{{ route('manufacturing.orders.create') }}" class="btn btn-outline-success">
                                    <i class="fa fa-plus me-2"></i>أضف أمر تصنيع
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- كرت البحث -->
        <div class="card mt-3">
            <div class="card-body">
                <h4 class="card-title">بحث وتصنيف</h4>
                <div class="row mb-3">
                    <!-- السطر الأول من الحقول -->
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="البحث بواسطة الاسم أو الكود">
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" aria-label="فرز بواسطة المنتج">
                            <option selected>فرز بواسطة المنتج</option>
                            <option value="1">منتج 1</option>
                            <option value="2">منتج 2</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" aria-label="فرز بواسطة قائمة المواد">
                            <option selected>فرز بواسطة قائمة المواد</option>
                            <option value="1">قائمة 1</option>
                            <option value="2">قائمة 2</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <!-- السطر الثاني من الحقول -->
                    <div class="col-md-4">
                        <select class="form-control" aria-label="إختر الحالة">
                            <option selected>إختر الحالة</option>
                            <option value="1">نشط</option>
                            <option value="2">قيد التنفيذ</option>
                            <option value="3">منتهي</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" aria-label="إختر العميل">
                            <option selected>إختر عميل</option>
                            <option value="1">عميل 1</option>
                            <option value="2">عميل 2</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" aria-label="إختر المرحلة الإنتاجية">
                            <option selected>إختر المرحلة الإنتاجية</option>
                            <option value="1">مرحلة 1</option>
                            <option value="2">مرحلة 2</option>
                            <option value="3">مرحلة 3</option>
                        </select>
                    </div>
                </div>

                <!-- الأزرار في سطر مستقل -->
                <div class="row mt-3">
                    <div class="col-12 text-right">
                        <button class="btn btn-primary me-2">بحث</button>
                        <button class="btn btn-secondary">إعادة تعيين</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- كرت الجدول -->
        <div class="card mt-4">
            <div class="card-body">
                <h4 class="card-title">نتائج البحث</h4>
                <table class="table table-striped table-hover text-right">
                    <thead class="thead-light">
                        <tr>
                            <th>الاسم</th>
                            <th>المنتج الرئيسي</th>
                            <th>الكمية</th>
                            <th>التاريخ</th>
                            <th>التكلفة الإجمالية</th>
                            <th>العميل</th>
                            <th>الحالة</th>
                            <th>ترتيب</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>أمر تصنيع 1</td>
                            <td>عطر 50 ملي</td>
                            <td>3600</td>
                            <td>
                                <div>يبدأ: 13/01/2025</div>
                                <div>ينتهي: 15/01/2025</div>
                            </td>
                            <td>19,592 ر.س</td>
                            <td>
                                <div>POS Client</div>
                                <div>#000002</div>
                            </td>
                            <td><span class="badge badge-primary">قيد التنفيذ</span></td>
                            <td>
                                <div class="btn-group">
                                    <div class="dropdown">
                                        <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1" type="button" id="dropdownMenuButton303" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
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
                        <!-- أضف المزيد من الصفوف حسب الحاجة -->
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection
