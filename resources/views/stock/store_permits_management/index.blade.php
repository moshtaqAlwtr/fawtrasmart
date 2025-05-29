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
                            <nav aria-label="Page navigation">
                                <ul class="pagination pagination-sm mb-0">
                                    <!-- زر الانتقال إلى أول صفحة -->
                                    @if ($wareHousePermits->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link border-0 rounded-pill" aria-label="First">
                                                <i class="fas fa-angle-double-right"></i>
                                            </span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link border-0 rounded-pill"
                                                href="{{ $wareHousePermits->url(1) }}" aria-label="First">
                                                <i class="fas fa-angle-double-right"></i>
                                            </a>
                                        </li>
                                    @endif

                                    <!-- زر الانتقال إلى الصفحة السابقة -->
                                    @if ($wareHousePermits->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link border-0 rounded-pill" aria-label="Previous">
                                                <i class="fas fa-angle-right"></i>
                                            </span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link border-0 rounded-pill"
                                                href="{{ $wareHousePermits->previousPageUrl() }}" aria-label="Previous">
                                                <i class="fas fa-angle-right"></i>
                                            </a>
                                        </li>
                                    @endif

                                    <!-- عرض رقم الصفحة الحالية -->
                                    <li class="page-item">
                                        <span class="page-link border-0 bg-light rounded-pill px-3">
                                            صفحة {{ $wareHousePermits->currentPage() }} من
                                            {{ $wareHousePermits->lastPage() }}
                                        </span>
                                    </li>

                                    <!-- زر الانتقال إلى الصفحة التالية -->
                                    @if ($wareHousePermits->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link border-0 rounded-pill"
                                                href="{{ $wareHousePermits->nextPageUrl() }}" aria-label="Next">
                                                <i class="fas fa-angle-left"></i>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link border-0 rounded-pill" aria-label="Next">
                                                <i class="fas fa-angle-left"></i>
                                            </span>
                                        </li>
                                    @endif

                                    <!-- زر الانتقال إلى آخر صفحة -->
                                    @if ($wareHousePermits->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link border-0 rounded-pill"
                                                href="{{ $wareHousePermits->url($wareHousePermits->lastPage()) }}"
                                                aria-label="Last">
                                                <i class="fas fa-angle-double-left"></i>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link border-0 rounded-pill" aria-label="Last">
                                                <i class="fas fa-angle-double-left"></i>
                                            </span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>

                            <div>

                                <div class="btn-group dropdown mr-1">
                                    <button type="button"
                                        class="btn btn-outline-primary dropdown-toggle waves-effect waves-light"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="feather icon-plus"></i> اضافة
                                    </button>
                                    <div class="dropdown-menu" x-placement="top-start"
                                        style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, -193px, 0px);">
                                        <a class="dropdown-item" href="{{ route('store_permits_management.create') }}">إضافة
                                            يدوي</a>
                                        <a class="dropdown-item"
                                            href="{{ route('store_permits_management.manual_disbursement') }}">صرف يدوي</a>
                                        <a class="dropdown-item"
                                            href="{{ route('store_permits_management.manual_conversion') }}">تحويل يدوي</a>
                                    </div>





                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form class="form" method="GET" action="{{ route('store_permits_management.index') }}">
                        <div class="form-body row">
                            <div class="form-group col-md-4">
                                <label for="">فرع</label>
                                <select name="branch" class="form-control select2">
                                    <option value="">جميع الفروع</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}"
                                            {{ request('branch') == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="">الاذن المخزني</label>
                                <input type="text" class="form-control" placeholder="ادخل الإسم او الكود" name="keywords"
                                    value="{{ request('keywords') }}">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="">مصدر الاذن</label>
                                <select name="permission_type" class="form-control select2">
                                    <option value="">الكل</option>
                                    @foreach ($permissionSources as $source)
                                        <option value="{{ $source->id }}"
                                            {{ request('permission_type') == $source->id ? 'selected' : '' }}>
                                            {{ $source->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">الرقم المعرف</label>
                                <input type="text" class="form-control" placeholder="ادخل الرقم المعرف" name="id"
                                    value="{{ request('id') }}">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="">المستودع</label>
                                <select name="store_house" class="form-control select2">
                                    <option value="">جميع المستودعات</option>
                                    @foreach ($storeHouses as $storeHouse)
                                        <option value="{{ $storeHouse->id }}"
                                            {{ request('store_house') == $storeHouse->id ? 'selected' : '' }}>
                                            {{ $storeHouse->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="">العميل</label>
                                <select name="client" class="form-control select2">
                                    <option value="">اختر العميل</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}"
                                            {{ request('client') == $client->id ? 'selected' : '' }}>
                                            {{ $client->trade_name }}{{ $client->code ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="">الموردين</label>
                                <select name="supplier" class="form-control select2">
                                    <option value="">اختر المورد</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}"
                                            {{ request('supplier') == $supplier->id ? 'selected' : '' }}>
                                            {{ $supplier->trade_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Advanced Search -->
                        <div class="collapse" id="advancedSearchForm">
                            <div class="form-body row">
                                <div class="form-group col-md-4">
                                    <label for="">الحاله</label>
                                    <select class="form-control" name="status">
                                        <option value="">الكل</option>
                                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>نشط
                                        </option>
                                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>غير نشط
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="">اضيفت بواسطة</label>
                                    <select class="form-control select2" name="created_by">
                                        <option value="">اي موظف</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ request('created_by') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="">المنتجات</label>
                                    <select class="form-control select2" name="product">
                                        <option value="">اختر المنتج</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}"
                                                {{ request('product') == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-4">
                                    <label for="">من تاريخ</label>
                                    <input type="date" class="form-control" name="from_date"
                                        value="{{ request('from_date') }}">
                                </div>

                                <div class="form-group col-4">
                                    <label for="">الي تاريخ</label>
                                    <input type="date" class="form-control" name="to_date"
                                        value="{{ request('to_date') }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary mr-1 waves-effect waves-light">بحث</button>
                            <a class="btn btn-outline-secondary ml-2 mr-2" data-toggle="collapse"
                                data-target="#advancedSearchForm">
                                <i class="bi bi-sliders"></i> بحث متقدم
                            </a>
                            <a href="{{ route('store_permits_management.index') }}"
                                class="btn btn-outline-danger waves-effect waves-light">الغاء الفلترة</a>
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
                                        <p><strong class="mr-1">مؤسسة اعمال خاصة</strong> <small
                                                class="text-muted">{{ $item->permissionSource->name ?? '' }}</small></p>
                                        <span class="mr-1"> <i class="fa fa-arrow-down"></i>
                                            @if ($item->permission_type == 1)
                                                إذن إضافة مخزن
                                            @elseif($item->permission_type == 2)
                                                إذن صرف مخزن
                                            @else
                                                تحويل يدوي
                                            @endif : <strong>
                                                @if ($item->permission_type == 3)
                                                    {{ $item->fromStoreHouse->name }} - {{ $item->toStoreHouse->name }}
                                                @else
                                                    {{ $item->storeHouse->name }}
                                                @endif
                                            </strong>
                                        </span> <span> <i class="fa fa-user"></i> بواسطة :
                                            <strong>{{ $item->user->name }}</strong></span>
                                    </td>
                                    <td>
                                        <p><strong>أنشأت</strong></p>
                                        <p><span class="mr-1"><i class="fa fa-calendar"></i>
                                                {{ $item->permission_date }}</span> <span><i class="fa fa-building"></i>
                                                {{ $item->user->branch->name ?? '' }}</span></p>
                                        <small class="text-muted">{{ Str::limit($item->details, 80) }}</small>
                                    </td>
                                    <td style="width: 20%">
                                        <span class="badge badge badge-success badge-pill float-right"
                                            style="margin-left: 10rem">تمت الموافقة</span>
                                    </td>
                                    <td style="width: 10%">
                                        <div class="btn-group mt-1">
                                            <div class="dropdown">
                                                <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1 btn-sm"
                                                    type="button"id="dropdownMenuButton303" data-toggle="dropdown"
                                                    aria-haspopup="true"aria-expanded="false"></button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton303">
                                                    <li>
                                                        <a class="dropdown-item" href="#">
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
                                                        <a class="dropdown-item text-danger" href="#"
                                                            data-toggle="modal"
                                                            data-target="#modal_DELETE{{ $item->id }}">
                                                            <i class="fa fa-trash me-2"></i>حذف
                                                        </a>
                                                    </li>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Modal delete -->
                                    <div class="modal fade text-left" id="modal_DELETE{{ $item->id }}"
                                        tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background-color: #EA5455 !important;">
                                                    <h4 class="modal-title" id="myModalLabel1" style="color: #FFFFFF">حذف
                                                        أذن مخزني</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true" style="color: #DC3545">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <strong>
                                                        هل انت متاكد من انك تريد الحذف ؟
                                                    </strong>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light waves-effect waves-light"
                                                        data-dismiss="modal">الغاء</button>
                                                    <a href="{{ route('store_permits_management.delete', $item->id) }}"
                                                        class="btn btn-danger waves-effect waves-light">تأكيد</a>
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
