@extends('master')

@section('title')
    الموردين
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2"></i>
                <strong>{{ session('success') }}</strong>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0"> ادارة الموردين</h2>
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


        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                    </div>

                    <div class="d-flex align-items-center gap-3"> <!-- زيادة gap من 2 إلى 3 لمسافة أكبر -->
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item {{ $suppliers->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="btn btn-sm btn-outline-secondary px-2"
                                        href="{{ $suppliers->previousPageUrl() }}" aria-label="Previous">
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </li>
                                <li class="page-item mx-2">
                                    <span class="text-muted">صفحة {{ $suppliers->currentPage() }} من
                                        {{ $suppliers->lastPage() }}</span>
                                </li>
                                <li class="page-item {{ !$suppliers->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="btn btn-sm btn-outline-secondary px-2" href="{{ $suppliers->nextPageUrl() }}"
                                        aria-label="Next">
                                        <i class="fa fa-angle-left"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>

                        <span class="text-muted mx-3"> <!-- زيادة margin من 2 إلى 3 -->
                            {{ $suppliers->firstItem() ?? 0 }}-{{ $suppliers->lastItem() ?? 0 }} من
                            {{ $suppliers->total() }}
                        </span>

                        <div class="d-flex align-items-center ms-3"> <!-- إضافة margin-start -->
                            <button class="btn btn-light">
                                <i class="fa fa-cloud"></i>
                            </button>
                        </div>

                        <a href="{{ route('SupplierManagement.create') }}" class="btn btn-success ms-3">
                            <!-- إضافة margin-start -->
                            <i class="fa fa-plus me-1"></i>
                            أضف المورد
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center p-2">
                <div class="d-flex gap-2">

                    <span class="hide-button-text">

                        بحث وتصفية
                    </span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-outline-secondary btn-sm" onclick="toggleSearchFields(this)">
                        <i class="fa fa-times"></i>
                        <span class="hide-button-text">اخفاء</span>
                    </button>
                    <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="collapse"
                        data-bs-target="#advancedSearchForm" onclick="toggleSearchText(this)">
                        <i class="fa fa-filter"></i>
                        <span class="button-text">متقدم</span>
                    </button>
                </div>

            </div>
            <div class="card-body">
                <form class="form" id="searchForm" method="GET" action="{{ route('SupplierManagement.index') }}">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <select name="employee_search" class="form-control">
                                <option value="">البحث بواسطة إسم المورد أو الرقم التعريفي</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ request('employee_search') == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->trade_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="number" name="supplier_number" class="form-control" placeholder="رقم المورد"
                                   value="{{ request('supplier_number') }}">
                        </div>
                        <div class="col-md-4">
                            <input type="email" name="email" class="form-control" placeholder="البريد الإلكتروني"
                                   value="{{ request('email') }}">
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="mobile" class="form-control" placeholder="رقم الجوال"
                                   value="{{ request('mobile') }}">
                        </div>
                        <div class="col-md-4 advanced-field" style="display: none;">
                            <input type="text" name="phone" class="form-control" placeholder="الهاتف"
                                   value="{{ request('phone') }}">
                        </div>
                        <div class="col-md-4 advanced-field" style="display: none;">
                            <input type="text" name="address" class="form-control" placeholder="العنوان"
                                   value="{{ request('address') }}">
                        </div>
                    </div>

                    <div class="collapse" id="advancedSearchForm">
                        <div class="row g-3 mt-2">
                            <div class="col-md-4">
                                <input type="text" name="postal_code" class="form-control" placeholder="الرمز البريدي"
                                       value="{{ request('postal_code') }}">
                            </div>

                            <div class="col-md-4">
                                <select name="currency" class="form-control">
                                    <option value="">اختر العملة</option>
                                    <option value="SAR" {{ request('currency') == 'SAR' ? 'selected' : '' }}>SAR</option>
                                    <!-- يمكن إضافة المزيد من العملات هنا -->
                                </select>
                            </div>

                            <div class="col-md-4">
                                <select name="status" class="form-control">
                                    <option value="">اختر الحالة</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>نشط</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>موقوف</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <select name="tag" class="form-control">
                                    <option value="">إختر الوسم</option>
                                    <!-- يمكن إضافة الوسوم هنا -->
                                </select>
                            </div>

                            <div class="col-md-4">
                                <input type="text" name="tax_number" class="form-control" placeholder="الرقم الضريبي"
                                       value="{{ request('tax_number') }}">
                            </div>

                            <div class="col-md-4">
                                <input type="text" name="commercial_registration" class="form-control" placeholder="السجل التجاري"
                                       value="{{ request('commercial_registration') }}">
                            </div>

                            <div class="col-md-4">
                                <select name="created_by" class="form-control">
                                    <option value="">أضيفت بواسطة</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ request('created_by') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions mt-2">
                        <button type="submit" class="btn btn-primary">بحث</button>
                        <a href="{{ route('SupplierManagement.index') }}" class="btn btn-outline-warning">إلغاء</a>
                    </div>
                </form>

            </div>
        </div>

        <div class="card">
            <div class="card-body">
                @if ($suppliers->count() > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 5%">
                                    <input type="checkbox" class="form-check-input" id="selectAll">
                                </th>
                                <th>الاسم</th>
                                <th>الموقع</th>
                                <th>رقم المورد</th>
                                <th>رقم الجوال</th>
                                <th>البريد الإلكتروني</th>
                                <th>الحالة</th>
                                <th style="width: 10%">خيارات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($suppliers as $supplier)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input supplier-checkbox" value="{{ $supplier->id }}">
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar me-2" style="background-color: #6B4423">
                                                <span class="avatar-content">{{ substr($supplier->trade_name, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                {{ $supplier->trade_name }}
                                                <div class="text-muted small">#{{ $supplier->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($supplier->full_address)
                                            <i class="fa fa-map-marker text-muted me-1"></i>
                                            {{ $supplier->full_address }}
                                        @endif
                                    </td>
                                    <td>{{ $supplier->number_suply }}</td>
                                    <td>{{ $supplier->mobile }}</td>
                                    <td>{{ $supplier->email }}</td>
                                    <td>
                                        @if ($supplier->status == 'active')
                                            <span class="badge bg-success">نشط</span>
                                        @else
                                            <span class="badge bg-danger">موقوف</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <div class="dropdown">
                                                <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1 btn-sm" type="button"
                                                        id="dropdownMenuButton{{ $supplier->id }}"
                                                        data-bs-toggle="dropdown" aria-expanded="false">

                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end"
                                                     aria-labelledby="dropdownMenuButton{{ $supplier->id }}">
                                                    <a class="dropdown-item" href="{{ route('SupplierManagement.show', $supplier->id) }}">
                                                        <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                    </a>
                                                    <a class="dropdown-item" href="{{ route('SupplierManagement.edit', $supplier->id) }}">
                                                        <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                    </a>
                                                    <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal"
                                                       data-bs-target="#deleteModal{{ $supplier->id }}">
                                                        <i class="fa fa-trash me-2"></i>حذف
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal delete -->
                                        <div class="modal fade" id="deleteModal{{ $supplier->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title">حذف المورد</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>هل أنت متأكد من حذف المورد "{{ $supplier->trade_name }}"؟</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                                                        <form action="{{ route('SupplierManagement.destroy', $supplier->id) }}"
                                                              method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">حذف</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-info text-center" role="alert">
                        <p class="mb-0">لا يوجد موردين مضافين حتى الآن</p>
                    </div>
                @endif
            </div>
        </div>








    @endsection

    @section('css')
        <style>
            .col-md-1-5 {
                flex: 0 0 12.5%;
                max-width: 12.5%;
                padding-right: 15px;
                padding-left: 15px;
            }

            .form-control {
                margin-bottom: 10px;
            }
        </style>
    @endsection
    @section('scripts')
        <script>
            function toggleSearchText(button) {
                const buttonText = button.querySelector('.button-text');
                const advancedFields = document.querySelectorAll('.advanced-field');

                if (buttonText.textContent.trim() === 'متقدم') {
                    buttonText.textContent = 'بحث بسيط';
                    advancedFields.forEach(field => field.style.display = 'block');
                } else {
                    buttonText.textContent = 'متقدم';
                    advancedFields.forEach(field => field.style.display = 'none');
                }
            }

            function toggleSearchFields(button) {
                const searchForm = document.getElementById('searchForm');
                const buttonText = button.querySelector('.hide-button-text');
                const icon = button.querySelector('i');

                if (buttonText.textContent === 'اخفاء') {
                    searchForm.style.display = 'none';
                    buttonText.textContent = 'اظهار';
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-eye');
                } else {
                    searchForm.style.display = 'block';
                    buttonText.textContent = 'اخفاء';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-times');
                }
            }
        </script>
    @endsection
