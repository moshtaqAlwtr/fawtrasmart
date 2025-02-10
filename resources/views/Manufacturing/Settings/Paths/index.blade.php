@extends('master')

@section('title')
مسارات الأنتاج
@stop

@section('content')

<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">مسارات الأنتاج</h2>
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

<!-- زر إضافة مسار الإنتاج -->
<div class="card">
    <div class="card-content">
        <div class="card-body">
            <div class="card-title">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <a href="{{ route('Manufacturing.settings.Paths.create') }}" class="btn btn-outline-success">
                            <i class="fa fa-plus me-2"></i>أضف مسار الأنتاج
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- كرت البحث -->
<div class="card mt-4">
    <div class="card-header">
        <strong>بحث وتصنيف</strong>
    </div>
    <div class="card-body">
        <form class="row g-3">
            <div class="col-md-6">
                <label for="searchInput" class="form-label">البحث بواسطة الاسم أو الكود</label>
                <input type="text" class="form-control" id="searchInput" placeholder="بحث...">
            </div>
            <div class="col-md-6">
                <label for="productionStage" class="form-label">اسم المرحلة الإنتاجية</label>
                <select class="form-control" id="productionStage">
                    <option selected>اختر مرحلة</option>
                    <option value="1">مرحلة 1</option>
                    <option value="2">مرحلة 2</option>
                    <option value="3">مرحلة 3</option>
                </select>
            </div>
        </form>
        <div class="d-flex justify-content-end mt-3">
            <button type="button" class="btn btn-primary me-2">بحث</button>
            <button type="reset" class="btn btn-secondary">إعادة تعيين</button>
        </div>
    </div>
</div>

<!-- كرت الجدول -->
<div class="card mt-4">
    <div class="card-header">
        <strong>نتائج البحث</strong>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th style="width: 70%;">الاسم والكود</th>
                    <th style="width: 30%;">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div>تصنيع عطر</div>
                        <small class="text-muted">#000001</small>
                    </td>
                    <td class="text-center">
                        <div class="btn-group">
                            <div class="dropdown">
                                <button class="btn bg-gradient-info fa fa-ellipsis-v" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
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
                <!-- المزيد من الصفوف -->
            </tbody>
        </table>
    </div>
</div>
@endsection
