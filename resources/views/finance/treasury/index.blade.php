@extends('master')

@section('title')
خزائن وحسابات بنكية
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">خزائن وحسابات بنكية</h2>
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
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div></div>

                    <div>
                        <a href="{{ route('treasury.create_account_bank') }}" class="btn btn-outline-success">
                            <i class="fa fa-bank"></i> إضافة حساب بنكي
                        </a>
                        <a href="{{ route('treasury.create') }}" class="btn btn-outline-primary">
                            <i class="fa fa-archive"></i> إضافة خزينة
                        </a>
                    </div>

                </div>
            </div>
        </div>

        @include('layouts.alerts.error')
        @include('layouts.alerts.success')

        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="card-title">

                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>بحث</div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form class="form" method="GET" action="">
                        <div class="form-body row">
                            <div class="form-group col-md-3">
                                <label for="">البحث بكلمة مفتاحية</label>
                                <input type="text" class="form-control" placeholder="ادخل الإسم او الكود" name="keywords">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="">النوع</label>
                                <select name="category" class="form-control" id="">
                                    <option value="">كل الانواع</option>
                                    <option value="1">حساب</option>
                                    <option value="2">خزينة</option>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="">الحالة</label>
                                <select class="form-control" name="status">
                                    <option value="">كل الحالات</option>
                                    <option value="1">نشط</option>
                                    <option value="2">غير نشط</option>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="">العمله</label>
                                <select class="form-control" name="status">
                                    <option value="">كل العملات</option>
                                    <option value="1">ريال</option>
                                    <option value="2">جنيه</option>
                                </select>
                            </div>

                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary mr-1 waves-effect waves-light">بحث</button>
                            <a href="{{ route('treasury.index') }}" class="btn btn-outline-danger waves-effect waves-light">الغاء الفلترة</a>
                        </div>
                    </form>

                </div>

            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-body">
                    @if (@isset($treasuries) && !@empty($treasuries) && count($treasuries) > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>الاسم</th>
                                    <th>الوصف</th>
                                    <th>المبلغ</th>
                                    <th>الحاله</th>
                                    <th style="width: 10%">اجراء</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($treasuries as $treasury)
                                    <tr>
                                        <td>
                                            <p><strong>@if($treasury->type == 0) <i class="fa fa-archive"></i> @else <i class="fa fa-bank"></i> @endif {{ $treasury->name }}</strong></p>
                                            <small>@if($treasury->type == 0) خزينة @else حساب بنكي @endif</small>
                                        </td>
                                        <td>{{ $treasury->description }}</td>
                                        <td>0.00</td>
                                        <td>
                                            @if ($treasury->status == 0)
                                                <span class="badge badge-pill badge badge-success">نشط</span>
                                            @else
                                                <span class="badge badge-pill badge badge-danger">غير نشط</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <div class="dropdown">
                                                    <button class="btn btn-sm bg-gradient-info fa fa-ellipsis-v mr-1 mb-1" type="button"id="dropdownMenuButton303" data-toggle="dropdown" aria-haspopup="true"aria-expanded="false"></button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton303">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('treasury.show',$treasury->id) }}">
                                                                <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                            </a>
                                                        </li>
                                                        <li>
                                                            @if($treasury->type == 0)
                                                                <a class="dropdown-item" href="{{ route('treasury.edit',$treasury->id) }}">
                                                                    <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                                </a>
                                                            @else
                                                                <a class="dropdown-item" href="{{ route('treasury.edit_account_bank',$treasury->id) }}">
                                                                    <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                                </a>
                                                            @endif
                                                        </li>

                                                        <li>
                                                            {{-- <a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#modal_DELETE{{ $product->id }}">
                                                                <i class="fa fa-trash me-2"></i>حذف
                                                            </a> --}}
                                                        </li>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $treasuries->links('pagination::bootstrap-5') }}
                    @else
                        <div class="alert alert-danger text-xl-center" role="alert">
                            <p class="mb-0">
                                لا توجد خزائن مضافه حتى الان
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>


    </div>

@endsection

@section('scripts')

@endsection
