@extends('master')

@section('title')
الأذون المخزنية
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">الأذون المخزنية</h2>
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

        @include('layouts.alerts.error')
        @include('layouts.alerts.success')

        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="card-title">

                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>بحث</div>
                            <div>
                                <div class="btn-group dropdown mr-1">
                                    <button type="button" class="btn btn-outline-primary dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="feather icon-plus"></i> اضافة
                                    </button>
                                    <div class="dropdown-menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, -193px, 0px);">
                                        <a class="dropdown-item" href="{{ route('store_permits_management.create') }}">إضافة يدوي</a>
                                        <a class="dropdown-item" href="{{ route('store_permits_management.manual_disbursement') }}">صرف يدوي</a>
                                        <a class="dropdown-item" href="{{ route('store_permits_management.manual_conversion') }}">تحويل يدوي</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form class="form" method="GET" action="">
                        <div class="form-body row">

                            <div class="form-group col-md-4">
                                <label for="">فرع</label>
                                <select name="category" class="form-control" id="">
                                    <option value=""> جميع الفروع</option>
                                    <option value="1">فرع 1</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="">الاذن المخزني</label>
                                <input type="text" class="form-control" placeholder="ادخل الإسم او الكود"name="keywords">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="">مصدر الاذن</label>
                                <select name="brand" class="form-control" id="">
                                    <option value="">الكل</option>
                                    <option value="nike"></option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="">الرقم المعرف</label>
                                <input type="text" class="form-control" placeholder="ادخل الإسم او الكود"name="keywords">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="">المستودع</label>
                                <select name="brand" class="form-control" id="">
                                    <option value="">الكل</option>
                                    <option value="nike"></option>
                                </select>
                            </div>

                        </div>
                        <!-- Hidden Div -->
                        <div class="collapse" id="advancedSearchForm">
                            <div class="form-body row">

                                <div class="form-group col-md-4">
                                    <label for="">الحاله</label>
                                    <select class="form-control" name="status">
                                        <option value="">الكل</option>
                                        <option value="1">نشط</option>
                                        <option value="2">متوقف</option>
                                        <option value="3">غير نشط</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="">اضيفت بواسطة</label>
                                    <select class="form-control" name="track_inventory">
                                        <option value="">اي موظف</option>
                                        <option value="0">موظف 1</option>
                                        <option value="1">موظف 2</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="">المنتجات</label>
                                    <select class="form-control select2" name="track_inventory">
                                        <option value="">اي موظف</option>
                                        <option value="0">منتج 1</option>
                                        <option value="1">منتج 2</option>
                                    </select>
                                </div>

                                <div class="form-group col-4">
                                    <label for="">من تاريخ</label>
                                    <input type="date" class="form-control" name="from_date">
                                </div>

                                <div class="form-group col-4">
                                    <label for="">الي تاريخ</label>
                                    <input type="date" class="form-control"  name="to_date">
                                </div>

                            </div>

                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary mr-1 waves-effect waves-light">بحث</button>

                            <a class="btn btn-outline-secondary ml-2 mr-2" data-toggle="collapse"
                                data-target="#advancedSearchForm">
                                <i class="bi bi-sliders"></i> بحث متقدم
                            </a>
                            <a href="" class="btn btn-outline-danger waves-effect waves-light">الغاء الفلترة</a>
                        </div>
                    </form>

                </div>

            </div>

        </div>

        @if (@isset($wareHousePermits) && !@empty($wareHousePermits) && count($wareHousePermits) > 0)
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        @foreach ($wareHousePermits as $item)
                            <tbody>
                                <tr>
                                    <td>
                                        <p>#{{ $item->number }} - {{ $item->created_at }}</p>
                                        <p><strong class="mr-1">مؤسسة اعمال خاصة</strong> <small class="text-muted">فاتوره شراء #2</small></p>
                                        <span class="mr-1"> <i class="fa fa-arrow-down"></i> @if($item->permission_type	 == 1) إذن إضافة مخزن @elseif($item->permission_type == 2) إذن صرف مخزن @else تحويل يدوي @endif : <strong> @if($item->permission_type == 3) {{ $item->fromStoreHouse->name }} - {{ $item->toStoreHouse->name }} @else {{ $item->storeHouse->name }} @endif </strong></span> <span> <i class="fa fa-user"></i> بواسطة : <strong>{{ $item->user->name }}</strong></span>
                                    </td>
                                    <td>
                                        <p><strong>أنشأت</strong></p>
                                        <p><span class="mr-1"><i class="fa fa-calendar"></i> {{ $item->permission_date }}</span> <span><i class="fa fa-building"></i> Main Branch</span></p>
                                        <small class="text-muted">{{ Str::limit($item->details, 80) }}</small>
                                    </td>
                                    <td style="width: 20%">
                                        <span class="badge badge badge-success badge-pill float-right" style="margin-left: 10rem">تمت الموافقة</span>
                                    </td>
                                    <td style="width: 10%">
                                        <div class="btn-group mt-1">
                                            <div class="dropdown">
                                                <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1 btn-sm"
                                                    type="button"id="dropdownMenuButton303" data-toggle="dropdown"
                                                    aria-haspopup="true"aria-expanded="false"></button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton303">
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="#">
                                                            <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('store_permits_management.edit', $item->id) }}">
                                                            <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#modal_DELETE{{ $item->id }}">
                                                            <i class="fa fa-trash me-2"></i>حذف
                                                        </a>
                                                    </li>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Modal delete -->
                                    <div class="modal fade text-left" id="modal_DELETE{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background-color: #EA5455 !important;">
                                                    <h4 class="modal-title" id="myModalLabel1" style="color: #FFFFFF">حذف أذن مخزني</h4>
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
                                                    <a href="{{ route('store_permits_management.delete', $item->id) }}" class="btn btn-danger waves-effect waves-light">تأكيد</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end delete-->
                                </tr>
                            </tbody>
                        @endforeach
                    </table>

                </div>
            </div>
        @else
            <div class="alert alert-danger text-xl-center" role="alert">
                <p class="mb-0">
                    لا توجد أذون مخزنية مضافه حتى الان !!
                </p>
            </div>
        @endif
        {{-- {{ $shifts->links('pagination::bootstrap-5') }} --}}
    </div>

@endsection


@section('scripts')



@endsection
