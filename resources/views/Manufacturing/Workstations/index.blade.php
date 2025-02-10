@extends('master')

@section('title')
محطات العمل 
@stop

@section('content')

<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">محطات العمل </h2>
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
    <!-- بطاقة البحث -->
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <div class="card-title">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                   
                        <div>
                            <a href="{{ route('manufacturing.workstations.create') }}" class="btn btn-outline-success">
                                <i class="fa fa-plus me-2"></i>أضف محطة عمل  
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
        <div class="d-flex justify-content-between align-items-center mb-3">
            <input type="text" class="form-control me-2" placeholder="البحث بواسطة الاسم أو الكود" style="width: 70%;">
            <div>
                <button class="btn btn-primary me-2">بحث</button>
                <button class="btn btn-secondary">إعادة تعيين</button>
            </div>
        </div>
    </div>
</div>



<!-- كرت الجدول -->
<div class="card mt-4">
    <div class="card-body">
        
        <table class="table table-striped table-hover text-right">
            <thead class="table-light">
                <tr>
                    <th>الأسم</th>
                    <th>الوصف<th>
                    <th>إجمالي التكلفة</th>
                    <th>ترتيب</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>تصنيع شامبو 100 مل #56</td>
                    <td> <td>
                    <td>12,000 ر.س</td>
                    <td>
                        <div class="btn-group">
                            <div class="dropdown">
                                <button class="btn bg-gradient-info fa fa-ellipsis-v" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
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
                    <td>تصنيع شامبو 100 مل #56</td>
                    <td> <td>
                    <td>12,000 ر.س</td>
                    <td>
                        <div class="btn-group">
                            <div class="dropdown">
                                <button class="btn bg-gradient-info fa fa-ellipsis-v" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
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
