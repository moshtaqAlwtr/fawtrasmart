@extends('master')

@section('title')
وكلاء التأمين
@stop

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">وكلاء التأمين</h2>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                        <li class="breadcrumb-item active">عرض</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-rtl flex-wrap">
                    <div></div>
                    <div>
                        <a href="{{ route('Insurance_Agents.create') }}" class="btn btn-outline-success">
                            <i class="fa fa-plus me-2"></i>أضف شركة تأمين
                        </a>
                    </div>
                </div>
            </div>
        </div>
<div class="card">
    <div class="card-body">
        <form>
            <!-- الحقلين في السطر الأول -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="agent-name">اسم الوكيل</label>
                    <input type="text" id="agent-name" class="form-control" placeholder="اسم الشركة">
                </div>
                <div class="col-md-6">
                    <label for="status">الحالة</label>
                    <div class="d-flex align-items-center">
                        <select id="status" class="form-control">
                            <option value="">أي</option>
                            <option value="active">نشط</option>
                            <option value="inactive">غير نشط</option>
                        </select>
                    </div>
                </div>

            </div>
            <!-- الأزرار في السطر الثاني -->
            <div class="row">
                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-primary mr-2">بحث</button>
                    <button type="reset" class="btn btn-outline-warning">إلغاء</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- جدول النتائج -->
<div class="card p-3">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>أسم الشركة</th>
                <th>الموقع</th>
                <th>عدد الفئات</th>
                <th>الحالة</th>
                <th>الترتيب</th>
            </tr>
        </thead>
        <tbody>
            <!-- أمثلة للبيانات -->
            <tr>
                <td>التعاونية</td>
                <td>الرياض</td>
                <td>10</td>
                <td>نشط</td>
                <td>
                    <div class="btn-group">
                        <div class="dropdown">
                            <button class="btn btn-sm bg-gradient-info fa fa-ellipsis-v mr-1 mb-1" type="button"
                                id="dropdownMenuButton303" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false"></button>
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
                <td>التعاونية</td>
                <td>الرياض</td>
                <td>10</td>
                <td>نشط</td>
                <td>
                    <div class="btn-group">
                        <div class="dropdown">
                            <button class="btn btn-sm bg-gradient-info fa fa-ellipsis-v mr-1 mb-1" type="button"
                                id="dropdownMenuButton303" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false"></button>
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

@endsection