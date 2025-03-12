@extends('master')

@section('title')
    أدارة العملاء
@stop

@section('content')

    @include('layouts.alerts.success')
    @include('layouts.alerts.error')


    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">أدارة العملاء</h2>
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
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-body">
                <div class="row justify-content-between align-items-center g-3">
                    <!-- القسم الأيمن -->
                    <div class="col-auto d-flex align-items-center flex-wrap gap-2">
                        <!-- زر إضافة عميل -->
                        <a href="{{ route('clients.create') }}" class="btn btn-success btn-sm rounded-pill px-4">
                            <i class="fas fa-plus-circle me-1"></i>
                            إضافة عميل
                        </a>

                        <!-- زر استيراد -->
                        <form action="{{ route('clients.import') }}" method="POST" enctype="multipart/form-data" class="d-inline-flex align-items-center gap-2">
                            @csrf
                            <div class="form-group mb-0">
                                <label class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                    <i class="fas fa-upload"></i> تحميل ملف Excel
                                    <input type="file" name="file" class="d-none" required>
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm rounded-pill px-3">استيراد</button>
                        </form>
                    </div>

                    <!-- القسم الأيسر -->
                    <div class="col-auto d-flex align-items-center flex-wrap gap-2">
                        <!-- التنقل بين الصفحات -->
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item">
                                    <a class="page-link border-0 rounded-pill" href="#" aria-label="First">
                                        <i class="fas fa-angle-double-right"></i>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link border-0 rounded-pill" href="#" aria-label="Previous">
                                        <i class="fas fa-angle-right"></i>
                                    </a>
                                </li>
                                @if ($clients->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link border-0 rounded-pill" aria-label="Previous">
                    <i class="fas fa-angle-left"></i>
                </span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link border-0 rounded-pill" href="{{ $clients->previousPageUrl() }}" aria-label="Previous">
                    <i class="fas fa-angle-left"></i>
                </a>
            </li>
        @endif

        {{-- عرض رقم الصفحة الحالية --}}
        <li class="page-item">
            <span class="page-link border-0 bg-light rounded-pill px-3">
                صفحة {{ $clients->currentPage() }} من {{ $clients->lastPage() }}
            </span>
        </li>
{{-- moshtaq wtr --}}
        {{-- زر الانتقال للصفحة التالية --}}
        @if ($clients->hasMorePages())
            <li class="page-item">
                <a class="page-link border-0 rounded-pill" href="{{ $clients->nextPageUrl() }}" aria-label="Next">
                    <i class="fas fa-angle-right"></i>
                </a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link border-0 rounded-pill" aria-label="Next">
                    <i class="fas fa-angle-right"></i>
                </span>
            </li>
        @endif
                            </ul>
                        </nav>

                        <!-- زر الإعدادات -->
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm rounded-pill px-3" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="fas fa-cog me-1"></i> إعدادات
                            </button>
                            <ul class="dropdown-menu shadow-sm">
                                <li><a class="dropdown-item py-2" href="#">إعدادات 1</a></li>
                                <li><a class="dropdown-item py-2" href="#">إعدادات 2</a></li>
                            </ul>
                        </div>
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
                <form class="form" id="searchForm" method="GET" action="{{ route('clients.index') }}">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <select name="client" class="form-control select2">
                                <option value="">اختر العميل </option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}"
                                        {{ request('client') == $client->id ? 'selected' : '' }}>
                                        {{ $client->trade_name }} - {{ $client->id }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="name" class="form-control" placeholder="الاسم "
                                value="{{ request('end_date_to') }}">
                        </div>
                        <div class="col-md-4">
                            <select name="status" class="form-control">
                                <option value="">إختر الحالة</option>
                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>مديون</option>
                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>دائن </option>
                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>مميز </option>
                            </select>
                        </div>

                    </div>

                    <div class="collapse" id="advancedSearchForm">
                        <div class="row g-3 mt-2">
                            <div class="col-md-4">
                                <select name="classifications" class="form-control">
                                    <option value="">إختر التصنيف </option>
                                    <option value="1" {{ request('classifications') == '1' ? 'selected' : '' }}>
                                    </option>
                                    <option value="0" {{ request('classifications') == '0' ? 'selected' : '' }}>
                                    </option>
                                    <option value="0" {{ request('classifications') == '0' ? 'selected' : '' }}>
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="date" name="end_date_to" class="form-control"
                                    placeholder="تاريخ الانتهاء (من)" value="{{ request('end_date_to') }}">
                            </div>

                            <div class="col-md-4">
                                <input type="date" name="end_date_to" class="form-control"
                                    placeholder="تاريخ الانتهاء (الى)" value="{{ request('end_date_to') }}">
                            </div>


                            <div class="form-group col-md-4">
                                <input type="text" name="address" class="form-control" placeholder="العنوان"
                                    value="{{ request('address') }}">
                            </div>

                            <div class="form-group col-md-4">
                                <input type="text" name="postal_code" class="form-control"
                                    placeholder="الرمز البريدي" value="{{ request('postal_code') }}">
                            </div>

                            <div class="col-md-4">
                                <select name="country" class="form-control">
                                    <option value="">إختر البلد</option>
                                    <option value="1" {{ request('country') == '1' ? 'selected' : '' }}>السعودية
                                    </option>
                                    <option value="0" {{ request('country') == '0' ? 'selected' : '' }}>مصر </option>
                                    <option value="0" {{ request('country') == '0' ? 'selected' : '' }}>اليمن
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select name="tage" class="form-control">
                                    <option value="">إختر الوسم</option>
                                    <option value="1" {{ request('tage') == '1' ? 'selected' : '' }}> </option>
                                    <option value="0" {{ request('tage') == '0' ? 'selected' : '' }}> </option>
                                    <option value="0" {{ request('tage') == '0' ? 'selected' : '' }}> </option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select name="user" class="form-control">
                                    <option value="">اضيفت بواسطة </option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ request('user') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} - {{ $user->id }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select name="type" class="form-control">
                                    <option value="">إختر النوع</option>
                                    <option value="1" {{ request('type') == '1' ? 'selected' : '' }}> </option>
                                    <option value="0" {{ request('type') == '0' ? 'selected' : '' }}> </option>
                                    <option value="0" {{ request('type') == '0' ? 'selected' : '' }}> </option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select name="full_name" class="form-control">
                                    <option value="">اختر الموظفين المعيين </option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ request('employee') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->full_name }} - {{ $employee->id }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions mt-2">
                        <button type="submit" class="btn btn-primary">بحث</button>
                        <a href="{{ route('clients.index') }}" type="reset" class="btn btn-outline-warning">إلغاء</a>
                    </div>
                </form>

            </div>
        </div>

        @if (isset($clients) && $clients->count() > 0)


            <div class="card">
                <div class="card-body">

                    <table class="table">

                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th>معلومات العميل</th>
                                <th>العنوان</th>
                                <th>رقم الهاتف</th>
                                <th style="width: 10%">الإجراءات</th>
                            </tr>
                        </thead>
                        @foreach ($clients as $client)
                            <tbody>

                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{ $client->id }}">
                                        </div>
                                    </td>
                                    <td>
                                        <h6 class="mb-0">{{ $client->trade_name }}</h6>
                                        <small class="text-muted">{{ $client->code }}</small>
                                        <p class="text-muted mb-0">
                                            <i class="fas fa-user me-1"></i>
                                            {{ $client->first_name }} {{ $client->last_name }}
                                        </p>
                                        @if ($client->employee)
                                            <p class="text-muted mb-0">
                                                <i class="fas fa-user-tie me-1"></i>
                                                {{ $client->employee->first_name }} {{ $client->employee->last_name }}
                                            </p>
                                        @endif
                                    </td>
                                    <td>
                                        <p class="mb-0">
                                            <i class="fas fa-map-marker-alt text-muted me-2"></i>
                                            {{ $client->city }}, {{ $client->region }}
                                        </p>
                                    </td>
                                    <td>
                                        <strong class="text-primary">
                                            <i class="fas fa-phone me-2"></i>{{ $client->phone }}
                                        </strong>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <div class="dropdown">
                                                <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1 btn-sm"
                                                    type="button"id="dropdownMenuButton303" data-toggle="dropdown"
                                                    aria-haspopup="true"aria-expanded="false"></button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton303">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('clients.show', $client->id) }}">
                                                                <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('clients.edit', $client->id) }}">
                                                                <i class="fa fa-pencil-alt me-2 text-success"></i>تعديل
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('clients.edit', $client->id) }}">
                                                                <i class="fa fa-copy me-2 text-info"></i>نسخ
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#modal_DELETE{{ $client->id }}">
                                                                <i class="fa fa-trash-alt me-2"></i>حذف
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('clients.edit', $client->id) }}">
                                                                <i class="fa fa-file-invoice me-2 text-warning"></i>كشف حساب
                                                            </a>
                                                        </li>
                                                    </div>
                                            </div>
                                        </div>
                                    </td>


                                    <!-- Modal Delete -->
                                    <div class="modal fade" id="modal_DELETE{{ $client->id }}" tabindex="-1"
                                        role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger">
                                                    <h5 class="modal-title text-white">تأكيد الحذف</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('clients.destroy', $client->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-body">
                                                        <p>هل أنت متأكد من الحذف
                                                            "{{ $client->trade_name }}"؟</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">إلغاء</button>
                                                        <button type="submit" class="btn btn-danger">تأكيد
                                                            الحذف</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </tr>

                            </tbody>
                        @endforeach
                    </table>
                @else
                    <div class="alert alert-danger text-xl-center" role="alert">
                        <p class="mb-0">
                            لا توجد عملاء !!
                        </p>
                    </div>
        @endif
    </div>

    </div>
    </div>




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
