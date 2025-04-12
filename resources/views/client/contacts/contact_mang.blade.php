@extends('master')

@section('title')
    أدارة قائمة جهات الاتصال
@stop

@section('head')
    <!-- تضمين ملفات Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
@endsection

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
                    <h2 class="content-header-title float-left mb-0">ادارة قائمة جهات الاتصال </h2>
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
        <div class="card shadow-lg border-0 rounded-lg mb-4">
            <div class="card-header bg-white py-3">
                <div class="row justify-content-between align-items-center mx-2">
                    <!-- القسم الأيسر: زر إضافة عميل -->
                    <div class="col-auto">
                        <a href="{{ route('clients.create') }}" class="btn btn-success px-4">
                            <i class="fas fa-plus-circle me-2"></i>
                            إضافة عميل
                        </a>
                    </div>

                    <!-- القسم الأوسط: التنقل بين الصفحات -->
                    <div class="col-auto">
                        <nav aria-label="Page navigation">
                            <ul class="pagination mb-0 pagination-sm">
                                <!-- زر الانتقال إلى الصفحة الأولى -->
                                <li class="page-item">
                                    <a class="page-link border-0 rounded-start" href="#" aria-label="First">
                                        <i class="fas fa-angle-double-right"></i>
                                    </a>
                                </li>

                                <!-- زر الانتقال إلى الصفحة السابقة -->
                                <li class="page-item">
                                    <a class="page-link border-0" href="#" aria-label="Previous">
                                        <i class="fas fa-angle-right"></i>
                                    </a>
                                </li>

                                <!-- عرض رقم الصفحة الحالية -->
                                <li class="page-item">
                                    <span class="page-link border-0 bg-light rounded-pill px-3">
                                        صفحة {{ $clients->currentPage() }} من {{ $clients->lastPage() }}
                                    </span>
                                </li>

                                <!-- زر الانتقال إلى الصفحة التالية -->
                                @if ($clients->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link border-0 rounded-pill" href="{{ $clients->nextPageUrl() }}"
                                            aria-label="Next">
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

                                <!-- زر الانتقال إلى الصفحة الأخيرة -->
                                <li class="page-item">
                                    <a class="page-link border-0 rounded-end" href="#" aria-label="Last">
                                        <i class="fas fa-angle-double-left"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                    <!-- القسم الأيمن: زر تصدير إلى Excel -->
                    {{-- <div class="col-auto">
                        <a href="" class="btn btn-primary px-4">
                            <i class="fas fa-file-excel me-2"></i>
                            تصدير إلى Excel
                        </a>
                    </div> --}}
                </div>
            </div>

            <!-- محتوى الجدول -->
            <div class="card-body">
                <!-- محتوى الجدول هنا -->
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-content">

            <div class="card-body">
                <form class="form" method="GET" action="{{ route('clients.contacts') }}">
                    <!-- البحث الأساسي -->
                    <div class="form-body row">
                        <div class="form-group col-md-12">
                            <label for="search">بحث سريع (بالاسم، الكود، الهاتف، البريد، الموظف، الحالة)</label>
                            <input type="text" id="search" class="form-control"
                                   placeholder="ابحث بأي حقل رئيسي" name="search"
                                   value="{{ request('search') }}">
                        </div>
                    </div>

                    <!-- البحث المتقدم -->
                    <div class="collapse" id="advancedSearchForm">
                        <div class="form-body row">
                            <div class="form-group col-md-4">
                                <label for="phone">رقم الهاتف</label>
                                <input type="text" id="phone" class="form-control"
                                       placeholder="ابحث برقم الهاتف" name="phone"
                                       value="{{ request('phone') }}">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="mobile">رقم الجوال</label>
                                <input type="text" id="mobile" class="form-control"
                                       placeholder="ابحث برقم الجوال" name="mobile"
                                       value="{{ request('mobile') }}">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="email">البريد الإلكتروني</label>
                                <input type="text" id="email" class="form-control"
                                       placeholder="ابحث بالبريد الإلكتروني" name="email"
                                       value="{{ request('email') }}">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="employee_id">الموظف المسؤول</label>
                                <select class="form-control" id="employee_id" name="employee_id">
                                    <option value="">اختر الموظف...</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="status_id">حالة العميل</label>
                                <select class="form-control" id="status_id" name="status_id">
                                    <option value="">اختر الحالة...</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status->id }}" {{ request('status_id') == $status->id ? 'selected' : '' }}>
                                            {{ $status->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="city">المدينة</label>
                                <input type="text" id="city" class="form-control"
                                       placeholder="ابحث بالمدينة" name="city"
                                       value="{{ request('city') }}">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="region">المنطقة</label>
                                <input type="text" id="region" class="form-control"
                                       placeholder="ابحث بالمنطقة" name="region"
                                       value="{{ request('region') }}">
                            </div>
                        </div>
                    </div>

                    <!-- أزرار البحث -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary mr-1 waves-effect waves-light">
                            <i class="fas fa-search"></i> بحث
                        </button>

                        <a class="btn btn-outline-secondary ml-2 mr-2" data-toggle="collapse" href="#advancedSearchForm"
                           aria-expanded="false" aria-controls="advancedSearchForm">
                            <i class="fas fa-sliders-h"></i> بحث متقدم
                        </a>

                        <a href="{{ route('clients.contacts') }}" class="btn btn-outline-warning">
                            <i class="fas fa-times"></i> إلغاء
                        </a>
                    </div>
                </form>
            </div>
            @if (@isset($clients) && !@empty($clients) && count($clients) > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="5%" class="text-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                </div>
                            </th>
                            <th width="20%">الكود</th>
                            <th width="25%">الاسم التجاري</th>
                            <th width="20%" class="text-center">الهاتف</th>
                            <th width="15%" class="text-end">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clients as $client)
                            <tr>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="{{ $client->id }}">
                                    </div>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $client->code }}</small>
                                </td>
                                <td>
                                    <h5 class="mb-0">{{ $client->trade_name }}</h5>
                                </td>
                                <td class="text-center">
                                    <strong class="text-primary">
                                        <i class="fas fa-phone me-2"></i>{{ $client->phone }}
                                    </strong>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <div class="dropdown">
                                            <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1"
                                                type="button" id="dropdownMenuButton{{ $client->id }}" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false"></button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $client->id }}">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('clients.show_contant', $client->id) }}">
                                                        <i class="fa fa-eye me-2 text-primary"></i>عرض العميل
                                                    </a>
                                                </li>
                                                <div class="dropdown-divider"></div>
                                                <form id="delete-client-{{ $client->id }}"
                                                    action="{{ route('clients.destroy', $client->id) }}" method="POST"
                                                    style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger delete-client"
                                                        data-id="{{ $client->id }}"
                                                        onclick="return confirm('هل أنت متأكد من حذف هذا العميل؟')">
                                                        <i class="fas fa-trash me-2"></i>حذف
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-danger" role="alert">
                <p class="mb-0">
                    لا توجد عملاء
                </p>
            </div>
        @endif
        </div>
    </div>
    </div>
@endsection


@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const advancedSearchButton = document.querySelector('[data-toggle="collapse"]');
            const advancedSearchForm = document.getElementById('advancedSearchForm');

            advancedSearchButton.addEventListener('click', function() {

            });
        });
    </script>
@endsection
