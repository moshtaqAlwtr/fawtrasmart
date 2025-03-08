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
                            <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="file">تحميل ملف Excel أو CSV</label>
                                    <input type="file" name="file" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary">استيراد المنتجات</button>
                            </form>

                            <div class="d-flex justify-content-start align-items-center gap-2">
                                <button class="btn btn-outline-primary">
                                    <i class="fa fa-calendar-alt me-2"></i> مجموعة المنتجات
                                </button>


                                <!-- زر الإضافة مع مسافة صغيرة -->
                                <div class="btn-group px-1">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        إضافة
                                    </button>
                                    <div class="dropdown-menu">
                                        @if (optional($account_setting)->business_type == 'products')
                                            <a class="dropdown-item" href="{{ route('products.create') }}">منتج جديد</a>
                                        @elseif(optional($account_setting)->business_type == 'services')
                                            <a class="dropdown-item" href="{{ route('products.create_services') }}">خدمة جديدة</a>

                                        @elseif(optional($account_setting)->business_type == 'both')
                                            <a class="dropdown-item" href="{{ route('products.create') }}">منتج جديد</a>
                                            <a class="dropdown-item" href="{{ route('products.create_services') }}">خدمة جديدة</a>
                                        @else
                                            <a class="dropdown-item" href="{{ route('products.create') }}">منتج جديد</a>
                                        @endif
                                         {{-- رابط منتج تجميعي --}}
                                         @unless ($role === false)
                                         <a class="dropdown-item" href="{{ route('products.compiled') }}">منتج تجميعي</a>
                                     @endunless
                                    </div>
                                </div>
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
                                <input type="text" id="feedback2" class="form-control"
                                    placeholder="باركود"name="barcode">
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
                                    <input type="date" class="form-control" name="to_date">
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
                            <a href="{{ route('products.index') }}"
                                class="btn btn-outline-danger waves-effect waves-light">الغاء الفلترة</a>
                        </div>
                    </form>

                </div>

            </div>

        </div>

        @if (isset($products) && !empty($products) && count($products) > 0)
            @foreach ($products as $product)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row border-bottom py-2 align-items-center">
                            <!-- اسم المنتج -->
                            <div class="col-md-3">
                                <p class="mb-0">{{ $product->name }}</p>
                                <small class="text-muted">#{{ $product->serial_number }}</small>
                            </div>

                            <!-- تاريخ الإنشاء والمستخدم -->
                            <div class="col-md-3">
                                <p class="mb-0"><small>{{ $product->created_at }}</small></p>
                                <small class="text-muted">بواسطة: {{ $product->user->name ?? '' }}</small>
                            </div>

                            <!-- حالة المنتج -->
                            <div class="col-md-2 text-center">
                                @if($product->type == "products" || $product->type == "compiled")
                                    @if ($product->totalQuantity() > 0)
                                        <span class="badge badge-success">في المخزن</span>
                                        <br>
                                        <small><i class="fa fa-cubes"></i> {{ number_format($product->totalQuantity()) }}
                                            متاح</small>
                                    @else
                                        <span class="badge badge-danger">مخزون نفد</span>
                                        <br>
                                        <small><i class="fa fa-cubes"></i> {{ number_format($product->totalQuantity()) }}
                                            متاح</small>
                                    @endif
                                @else
                                    <span
                                        class="badge
                                    {{ $product->status == 0 ? 'badge-primary' : ($product->status == 1 ? 'badge-danger' : 'badge-secondary') }}">
                                        {{ $product->status == 0 ? 'نشط' : ($product->status == 1 ? 'موقوف' : 'غير نشط') }}
                                    </span>
                                @endif
                            </div>

                            <!-- الأسعار -->
                            <div class="col-md-2 d-flex flex-column text-center">
                                @if ($product->purchase_price)
                                    <p class="mb-0"><i class="fa fa-shopping-cart"></i>
                                        <small>{{ $product->purchase_price }}</small></p>
                                @endif
                                @if ($product->sale_price)
                                    <p class="mb-0"><i class="fa fa-car"></i> <small>{{ $product->sale_price }}</small>
                                    </p>
                                @endif
                            </div>

                            <!-- الإجراءات -->
                            <div class="col-md-2 text-end">
                                <div class="btn-group">
                                    <div class="dropdown">
                                        <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1 btn-sm"
                                            type="button" id="dropdownMenuButton303" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false"></button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton303">
                                            <li><a class="dropdown-item"
                                                    href="{{ route('products.show', $product->id) }}">
                                                    <i class="fa fa-eye me-2 text-primary"></i>عرض</a></li>
                                            <li><a class="dropdown-item"
                                                    href="{{ route('products.edit', $product->id) }}">
                                                    <i class="fa fa-edit me-2 text-success"></i>تعديل</a></li>
                                            <li><a class="dropdown-item text-danger" href="#" data-toggle="modal"
                                                    data-target="#modal_DELETE{{ $product->id }}">
                                                    <i class="fa fa-trash me-2"></i>حذف</a></li>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal delete -->
                <div class="modal fade text-left" id="modal_DELETE{{ $product->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-danger text-white">
                                <h4 class="modal-title" id="myModalLabel1">حذف {{ $product->name }}</h4>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <strong>هل انت متأكد من أنك تريد الحذف؟</strong>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal">إلغاء</button>
                                <a href="{{ route('products.delete', $product->id) }}" class="btn btn-danger">تأكيد</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End delete -->
            @endforeach
        @else
            <p class="text-center text-muted">لا توجد منتجات متاحة.</p>
        @endif

        {{ $products->links('pagination::bootstrap-5') }}
    </div>

@endsection


@section('scripts')



@endsection
