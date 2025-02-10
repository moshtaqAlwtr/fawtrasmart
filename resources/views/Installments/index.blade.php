@extends('master')

@section('title')
    أتفاقات التقسيط
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">أتفاقات التقسيط</h2>
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

    <div class="card my-4">
    <!-- الفلاتر -->
    <div class="card mb-4">
        <div class="card-body">
            <form class="row g-3">
                <div class="col-md-4">
                    <label for="status" class="form-label">اختر الحالة</label>
                    <select id="status" class="form-control">
                        <option selected>الكل</option>
                        <option value="1">مكتمل</option>
                        <option value="2">غير مكتمل</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="identifier" class="form-label">بحث بواسطة معرف القسط</label>
                    <input type="text" id="identifier" class="form-control" placeholder="بحث بواسطة معرف القسط">
                </div>
                <div class="col-md-4">
                    <label for="client" class="form-label">بحث باسم العميل أو الرقم التعريفي</label>
                    <input type="text" id="client" class="form-control" placeholder="بحث باسم العميل">
                </div>
                <div class="col-md-4">
                    <label for="period" class="form-label">اختر الفترة</label>
                    <select id="period" class="form-control">
                        <option selected>اختر الفترة</option>
                        <option value="1">أسبوع</option>
                        <option value="2">شهر</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="fromDate" class="form-label">تاريخ استحقاق القسط من</label>
                    <input type="date" id="fromDate" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="toDate" class="form-label">تاريخ استحقاق القسط الى</label>
                    <input type="date" id="toDate" class="form-control">
                </div>
                <!-- الأزرار في سطر منفصل -->
                <div class="col-12 text-right mt-3">
                    <button type="submit" class="btn btn-primary me-2">بحث</button>
                    <a href="#" class="btn btn-outline-danger">إلغاء الفلاتر</a>
                </div>
            </form>
        </div>
    </div>
</div>


        <!-- الجدول -->
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>المعرف</th>
                        <th>بيانات العميل</th>
                        <th>بيانات الدفع</th>
                        <th>مبلغ القسط</th>
                        <th>تاريخ الاستحقاق</th>
                        <th>ترتيب بواسطة</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>
                            <span class="badge bg-primary">عميل نقدي</span><br>
                            <small>#4</small>
                        </td>
                        <td>
                            <small>فاتورة 09236</small><br>
                            <strong>SAR 0/18,000</strong>
                        </td>
                        <td>1000<br><small>شهري</small></td>
                        <td>02/01/2025<br><span class="badge bg-warning text-dark">غير مكتمل</span></td>
                        <td>        <div class="btn-group">
                                                <div class="dropdown">
                                                    <button class="btn btn-sm bg-gradient-info fa fa-ellipsis-v mr-1 mb-1" type="button"id="dropdownMenuButton303" data-toggle="dropdown" aria-haspopup="true"aria-expanded="false"></button>
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

@endsection
