@extends('master')

@section('title')
التكاليف غير المباشرة
@stop

@section('content')

    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">التكاليف غير المباشرة</h2>
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

    <!-- بطاقة البحث -->
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <div class="card-title">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div></div>
                        <div>
                            <a href="{{ route('manufacturing.indirectcosts.create') }}" class="btn btn-outline-success">
                                <i class="feather icon-plus"></i>أضف تكاليف غير مباشرة
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- كرت البحث -->
<div class="card">
    <div class="card-body">

        <div class="row g-3">
            <div class="col-md-4">
                <label for="account" class="form-label">الحساب</label>
                <input type="text" class="form-control" placeholder="الحساب">
            </div>
            <div class="col-md-4">
                <label for="account" class="form-label">المنتجات</label>
                <select class="form-control" aria-label="اختيار المنتجات">
                    <option selected>المنتجات</option>
                    <option value="1">منتج 1</option>
                    <option value="2">منتج 2</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="account" class="form-label">طلب التصنيع</label>
                <select class="form-control" aria-label="طلب التصنيع">
                    <option selected>طلب التصنيع</option>
                    <option value="1">طلب 1</option>
                    <option value="2">طلب 2</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="dateFrom" class="form-label">التاريخ من</label>
                <input type="date" class="form-control" placeholder="تاريخ من (من)">
            </div>
            <div class="col-md-2">
                <label for="dateFrom" class="form-label">التاريخ ألى</label>
                <input type="date" class="form-control" placeholder="تاريخ إلى (من)">
            </div>
            <div class="col-md-2">
                <label for="dateFrom" class="form-label">التاريخ من</label>
                <input type="date" class="form-control" placeholder="تاريخ من (إلى)">
            </div>
            <div class="col-md-2">
                <label for="dateFrom" class="form-label">التاريخ ألى</label>
                <input type="date" class="form-control" placeholder="تاريخ إلى (إلى)">
            </div>
        </div>
        <div class="d-flex justify-content-start mt-4">
            <button class="btn btn-primary me-2">بحث</button>
            <button class="btn btn-secondary">إعادة تعيين</button>
        </div>
    </div>
</div>

<!-- كرت الجدول -->
<div class="card mt-4">
    <div class="card-body">
        @if(isset($indirectCosts) && !empty($indirectCosts) && count($indirectCosts) > 0)
            <table class="table table-striped">
                <thead class="table-light">
                    <tr>
                        <th>الحساب</th>
                        <th>إجمالي التكلفة</th>
                        <th style="width: 10%">اجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($indirectCosts as $indirectCost)
                        <tr>
                            <td>
                                <p><strong>{{ $indirectCost->account->name }}</strong></p>
                                <small class="text-muted">#{{ $indirectCost->account->code }}</small>
                            </td>
                            <td><strong>{{ $indirectCost->total }} ر.س</strong></td>
                            <td>
                                <div class="btn-group">
                                    <div class="dropdown">
                                        <button class="btn bg-gradient-info fa fa-ellipsis-v btn-sm" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('manufacturing.indirectcosts.show', $indirectCost->id) }}">
                                                    <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('manufacturing.indirectcosts.edit', $indirectCost->id) }}">
                                                    <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#modal_DELETE{{ $indirectCost->id }}">
                                                    <i class="fa fa-trash me-2"></i>حذف
                                                </a>
                                            </li>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Modal delete -->
                            <div class="modal fade text-left" id="modal_DELETE{{ $indirectCost->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color: #EA5455 !important;">
                                            <h4 class="modal-title" id="myModalLabel1" style="color: #FFFFFF">حذف التكاليف غير المباشرة</h4>
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
                                            <a href="{{ route('manufacturing.indirectcosts.delete', $indirectCost->id) }}" class="btn btn-danger waves-effect waves-light">تأكيد</a>
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
                    لا يوجد تكاليف غير مباشره مضافه حتى الان !!
                </p>
            </div>
        @endif

    </div>
</div>

@endsection
