@extends('master')

@section('title')
    سجل حضور العملاء
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">سجل حضور العملاء</h2>
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
    
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-rtl flex-wrap">
                    <div></div>
                    <div>
                        <a href="{{ route('rental_management.units.create') }}" class="btn btn-outline-success">
                            <i class="fa fa-plus me-2"></i>تسجيل حضور العميل
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
    <div class="card-content">
        <div class="card-body">
            <form class="form" method="GET" action="#">
                <div class="form-body row">
                    <div class="form-group col-md-6">
                        <label for="customer_search">البحث بواسطة اسم العميل أو الرقم التعريفي</label>
                        <select id="customer_search" name="employee" class="form-control">
                            <option value="">اختر</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="employee_search">البحث بواسطة اسم الموظف أو الرقم التعريفي</label>
                        <select id="employee_search" name="employee" class="form-control">
                            <option value="">اختر</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="from_date">التاريخ (من)</label>
                        <input type="date" id="from_date" class="form-control" name="from_date">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="to_date">التاريخ (إلى)</label>
                        <input type="date" id="to_date" class="form-control" name="to_date">
                    </div>
                </div>

                <div class="form-actions mt-3">
                    <button type="submit" class="btn btn-primary mr-1 waves-effect waves-light">بحث</button>
                    <a href="#" class="btn btn-outline-danger waves-effect waves-light">إلغاء الفلترة</a>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="card mt-5">
   
   
    <table class="table table-bordered table-hover">
        <thead class="table-light">
        <tr>
            <th>المعرف</th>
            <th>بيانات العميل</th>
            <th>التاريخ و التوقيت</th>
            <th>أضيفت بواسطة</th>
            <th>ترتيب بواسطة</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>1</td>
            <td>
                أسواق النهدي<br>
                <small>أرجوان السعودية - شارع الطائف</small><br>
                <small class="text-muted">#-123150</small>
            </td>
            <td>04/01/2025<br><small class="text-muted">16:22</small></td>
            <td>المالك</td>
            <td>
            <div class="btn-group">
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
                                                            <a class="dropdown-item text-danger" href="#" >
                                                                <i class="fa fa-trash me-2"></i>حذف
                                                            </a>
                                                        </li>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
        </tr>
        <!-- يمكنك إضافة المزيد من الصفوف هنا -->
        </tbody>
    </table>
</div>
        @endsection