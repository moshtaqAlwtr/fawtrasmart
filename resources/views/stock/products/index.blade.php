@extends('master')

@section('title')
المخزون
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">ادارة المنتجات</h2>
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
                            <div>بحث في المنتجات</div>
                            <div>
                                <a href="{{ route('products.create') }}" class="btn btn-outline-success">
                                    <i class="fa fa-plus me-2"></i>منتج جديدة
                                </a>

                                <button class="btn btn-outline-primary">
                                    <i class="fa fa-calendar-alt me-2"></i>مجموعه المنتجات
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form class="form" method="GET" action="{{ route('products.search') }}">
                        <div class="form-body row">
                            <div class="form-group col-md-4">
                                <label for="">البحث بكلمة مفتاحية</label>
                                <input type="text" class="form-control" placeholder="ادخل الإسم او الكود"name="keywords">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="">التصنيف</label>
                                <select name="category" class="form-control" id="">
                                    <option value=""> جميع التصنيفات</option>
                                    <option value="1">منتج</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="">الماركة</label>
                                <select name="brand" class="form-control" id="">
                                    <option value="">جميع الماركات</option>
                                    <option value="nike"></option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <select class="form-control" name="status">
                                    <option value="">الحالة</option>
                                    <option value="1">نشط</option>
                                    <option value="2">متوقف</option>
                                    <option value="3">غير نشط</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <select class="form-control" name="track_inventory">
                                    <option value="">جميع انواع التتبع</option>
                                    <option value="0">الرقم التسلسلي</option>
                                    <option value="1">رقم الشحنة</option>
                                    <option value="2">تاريخ الانتهاء</option>
                                    <option value="3">رقم الشحنة وتاريخ الانتهاء</option>
                                    <option value="4">الكمية فقط</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="feedback2" class="sr-only">باركود</label>
                                <input type="text" id="feedback2" class="form-control" placeholder="باركود"name="barcode">
                            </div>
                        </div>
                        <!-- Hidden Div -->
                        <div class="collapse" id="advancedSearchForm">
                            <div class="form-body row">

                                <div class="form-group col-4">
                                    <label for="">من تاريخ</label>
                                    <input type="date" class="form-control" name="from_date">
                                </div>

                                <div class="form-group col-4">
                                    <label for="">الي تاريخ</label>
                                    <input type="date" class="form-control"  name="to_date">
                                </div>

                                <div class="form-group col-4">
                                    <label for="">كود المنتج</label>
                                    <input type="text" class="form-control" name="product_code">
                                </div>

                            </div>

                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary mr-1 waves-effect waves-light">بحث</button>

                            <a class="btn btn-outline-secondary ml-2 mr-2" data-toggle="collapse"
                                data-target="#advancedSearchForm">
                                <i class="bi bi-sliders"></i> بحث متقدم
                            </a>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-danger waves-effect waves-light">الغاء الفلترة</a>
                        </div>
                    </form>

                </div>

            </div>

        </div>

        @if (@isset($products) && !@empty($products) && count($products) > 0)
            @foreach ($products as $product)
                <div class="card">
                    <div class="card-body">
                        <div class="row border-bottom py-2 align-items-center">

                            <div class="col-md-3">
                                <p class="mb-">{{ $product->name }}</p>
                                <small class="text-muted">#{{ $product->serial_number }}</small>
                            </div>

                            <div class="col-md-3">
                                <p class="mb-0"><small>{{ $product->created_at }}</small></p>
                                <small class="text-muted">بواسطة: {{ $product->user->name }}</small>
                            </div>

                            @if ($product->totalQuantity() > 0)
                                <div class="col-md-2 text-center">
                                    <span class="badge badge-pill badge badge-success">في المخزن</span>
                                    <br>
                                    <small><i class="fa fa-cubes"></i> {{ number_format($product->totalQuantity()) }} متاح</small>
                                </div>
                            @else
                                <div class="col-md-2 text-center">
                                    <span class="badge badge-pill badge badge-danger">مخزون نفد</span>
                                    <br>
                                    <small><i class="fa fa-cubes"></i> {{ number_format($product->totalQuantity()) }} متاح</small>
                                </div>
                            @endif

                            <div class="col-md-2">
                                @if ($product->purchase_price)
                                    <p class="mb-0"><i class="fa fa-shopping-cart"></i> <small>{{ $product->purchase_price }}</small></p>
                                @endif
                                @if ($product->sale_price)
                                    <i class="fa fa-car"></i> <small>{{ $product->sale_price }}</small>
                                @endif
                            </div>

                            <div class="col-md-2 text-end">
                                <div class="btn-group">
                                    <div class="dropdown">
                                        <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1 btn-sm" type="button"id="dropdownMenuButton303" data-toggle="dropdown" aria-haspopup="true"aria-expanded="false"></button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton303">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('products.show',$product->id) }}">
                                                    <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('products.edit',$product->id) }}">
                                                    <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                </a>
                                            </li>

                                            <li>
                                                <a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#modal_DELETE{{ $product->id }}">
                                                    <i class="fa fa-trash me-2"></i>حذف
                                                </a>
                                            </li>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Modal delete -->
                <div class="modal fade text-left" id="modal_DELETE{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #EA5455 !important;">
                                <h4 class="modal-title" id="myModalLabel1" style="color: #FFFFFF">حذف {{ $product->name }}</h4>
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
                                <a href="{{ route('products.delete',$product->id) }}" class="btn btn-danger waves-effect waves-light">تأكيد</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end delete-->

            @endforeach
        @else
            <div class="alert alert-danger text-xl-center" role="alert">
                <p class="mb-0">
                    لا توجد منتجات مضافه حتى الان
                </p>
            </div>
        @endif
        {{ $products->links('pagination::bootstrap-5') }}
    </div>

@endsection


@section('scripts')



@endsection
