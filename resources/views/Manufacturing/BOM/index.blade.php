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

@include('layouts.alerts.success')
@include('layouts.alerts.error')

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
            @if(isset($materials) && !empty($materials) && count($materials) > 0)
                <table class="table table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>الاسم</th>
                            <th>المنتج الرئيسي</th>
                            <th>كمية الإنتاج</th>
                            <th>إجمالي التكلفة</th>
                            <th>الحالة</th>
                            <th>الافتراضي</th>
                            <th>اجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($materials as $material)
                            <tr>
                                <td>{{ $material->name }}</td>
                                <td>{{ $material->product->name }}</td>
                                <td>{{ $material->quantity }}</td>
                                <td>{{ $material->last_total_cost }} ر.س</td>
                                <td>
                                    @if($material->status == 1)
                                        <span class="text-success">نشط</span>
                                    @else
                                        <span class="text-danger">غير نشط</span>
                                    @endif
                                </td>
                                <td>
                                    @if($material->default == 1)
                                        <i class="fa fa-flag text-info"></i> افتراضي
                                    @endif
                                </td>
                                <td style="width: 10%">
                                    <div class="btn-group">
                                        <div class="dropdown">
                                            <button class="btn btn-sm bg-gradient-info fa fa-ellipsis-v mr-1 mb-1" type="button"id="dropdownMenuButton303" data-toggle="dropdown" aria-haspopup="true"aria-expanded="false"></button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton303">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('Bom.show', $material->id) }}">
                                                        <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('Bom.edit', $material->id) }}">
                                                        <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                    </a>
                                                </li>

                                                <li>
                                                    <a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#modal_DELETE{{ $material->id }}">
                                                        <i class="fa fa-trash me-2"></i>حذف
                                                    </a>
                                                </li>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Modal delete -->
                                <div class="modal fade text-left" id="modal_DELETE{{ $material->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: #EA5455 !important;">
                                                <h4 class="modal-title" id="myModalLabel1" style="color: #FFFFFF">حذف {{ $material->name }}</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true" style="color: #DC3545">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <strong>
                                                    هل انت متاكد من انك تريد الحذف ؟
                                                </strong>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light waves-effect waves-light" data-dismiss="modal">الغاء</button>
                                                <a href="{{ route('Bom.delete', $material->id) }}" class="btn btn-danger waves-effect waves-light">تأكيد</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end delete-->

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-danger text-xl-center" role="alert">
                    <p class="mb-0">
                        لا يوجد قوائم مواد الأنتاج
                    </p>
                </div>
            @endif
        </div>
    </div>

</div>

@endsection
