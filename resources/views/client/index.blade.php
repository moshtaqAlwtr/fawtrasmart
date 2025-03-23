@extends('master')

@section('title')
    إدارة العملاء
@stop

@section('css')
    <style>
        #map {
            height: 500px;
            width: 100%;
            margin-bottom: 20px;
        }
    </style>
@stop

@section('content')
    @include('layouts.alerts.success')
    @include('layouts.alerts.error')

    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">إدارة العملاء</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                            <li class="breadcrumb-item active">عرض</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">
        <!-- الخريطة -->
        <div id="map"></div>

        <!-- بطاقة الإجراءات -->
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-body">
                <div class="row align-items-center gy-3">
                    <!-- القسم الأيمن -->
                    <div
                        class="col-md-6 d-flex flex-wrap align-items-center gap-2 justify-content-center justify-content-md-start">
                        <!-- زر إضافة عميل -->
                        <a href="{{ route('clients.create') }}"
                            class="btn btn-success btn-sm rounded-pill px-4 text-center">
                            <i class="fas fa-plus-circle me-1"></i>
                            إضافة عميل
                        </a>

                        <!-- زر استيراد -->
                        <form action="{{ route('clients.import') }}" method="POST" enctype="multipart/form-data"
                            class="d-inline-flex align-items-center gap-2">
                            @csrf
                            <label class="btn btn-outline-primary btn-sm rounded-pill px-3 mb-0 text-center">
                                <i class="fas fa-upload"></i> تحميل ملف Excel
                                <input type="file" name="file" class="d-none" required>
                            </label>
                            <button type="submit"
                                class="btn btn-primary btn-sm rounded-pill px-3 text-center">استيراد</button>
                        </form>
                    </div>

                    <!-- القسم الأيسر -->
                    <div class="col-md-6 d-flex justify-content-center justify-content-md-end gap-2">
                        <!-- زر إضافة حد ائتماني -->
                        <a href="javascript:void(0);" class="btn btn-success btn-sm rounded-pill px-4 text-center"
                            data-bs-toggle="modal" data-bs-target="#creditLimitModal">
                            <i class="fas fa-plus-circle me-1"></i> إضافة حد ائتماني
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- بطاقة البحث -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center p-2">
                <div class="d-flex gap-2">
                    <span class="hide-button-text">بحث وتصفية</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-outline-secondary btn-sm" onclick="toggleSearchFields(this)">
                        <i class="fa fa-times"></i>
                        <span class="hide-button-text">إخفاء</span>
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
                        <div class="col-md-4 col-12">
                            <select name="client" class="form-control select2">
                                <option value="">اختر العميل</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}"
                                        {{ request('client') == $client->id ? 'selected' : '' }}>
                                        {{ $client->trade_name }} - {{ $client->id }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 col-12">
                            <input type="text" name="name" class="form-control" placeholder="الاسم"
                                value="{{ request('end_date_to') }}">
                        </div>
                        <div class="col-md-4 col-12">
                            <select name="status" class="form-control">
                                <option value="">اختر الحالة</option>
                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>مديون</option>
                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>دائن</option>
                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>مميز</option>
                            </select>
                        </div>
                    </div>

                    <div class="collapse" id="advancedSearchForm">
                        <div class="row g-3 mt-2">
                            <div class="col-md-4 col-12">
                                <select name="classifications" class="form-control">
                                    <option value="">اختر التصنيف</option>
                                    <option value="1" {{ request('classifications') == '1' ? 'selected' : '' }}>
                                    </option>
                                    <option value="0" {{ request('classifications') == '0' ? 'selected' : '' }}>
                                    </option>
                                    <option value="0" {{ request('classifications') == '0' ? 'selected' : '' }}>
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-4 col-12">
                                <input type="date" name="end_date_to" class="form-control"
                                    placeholder="تاريخ الانتهاء (من)" value="{{ request('end_date_to') }}">
                            </div>
                            <div class="col-md-4 col-12">
                                <input type="date" name="end_date_to" class="form-control"
                                    placeholder="تاريخ الانتهاء (الى)" value="{{ request('end_date_to') }}">
                            </div>
                            <div class="form-group col-md-4 col-12">
                                <input type="text" name="address" class="form-control" placeholder="العنوان"
                                    value="{{ request('address') }}">
                            </div>
                            <div class="form-group col-md-4 col-12">
                                <input type="text" name="postal_code" class="form-control"
                                    placeholder="الرمز البريدي" value="{{ request('postal_code') }}">
                            </div>
                            <div class="col-md-4 col-12">
                                <select name="country" class="form-control">
                                    <option value="">اختر البلد</option>
                                    <option value="1" {{ request('country') == '1' ? 'selected' : '' }}>السعودية
                                    </option>
                                    <option value="0" {{ request('country') == '0' ? 'selected' : '' }}>مصر</option>
                                    <option value="0" {{ request('country') == '0' ? 'selected' : '' }}>اليمن
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-4 col-12">
                                <select name="tage" class="form-control">
                                    <option value="">اختر الوسم</option>
                                    <option value="1" {{ request('tage') == '1' ? 'selected' : '' }}></option>
                                    <option value="0" {{ request('tage') == '0' ? 'selected' : '' }}></option>
                                    <option value="0" {{ request('tage') == '0' ? 'selected' : '' }}></option>
                                </select>
                            </div>
                            <div class="col-md-4 col-12">
                                <select name="user" class="form-control">
                                    <option value="">أضيفت بواسطة</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ request('user') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} - {{ $user->id }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 col-12">
                                <select name="type" class="form-control">
                                    <option value="">اختر النوع</option>
                                    <option value="1" {{ request('type') == '1' ? 'selected' : '' }}></option>
                                    <option value="0" {{ request('type') == '0' ? 'selected' : '' }}></option>
                                    <option value="0" {{ request('type') == '0' ? 'selected' : '' }}></option>
                                </select>
                            </div>
                            <div class="col-md-4 col-12">
                                <select name="full_name" class="form-control">
                                    <option value="">اختر الموظفين المعيين</option>
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

        <!-- جدول العملاء -->
        @if (isset($clients) && $clients->count() > 0)
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="fawtra">
                            <thead>
                                <tr>
                                    <th width="50">#</th>
                                    <th>معلومات العميل</th>
                                    <th>العنوان</th>
                                    <th>رقم الهاتف</th>
                                    <th style="width: 10%">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clients as $client)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    value="{{ $client->id }}">
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
                                                <i class="fas fa-map-marker-alt text-primary me-2"
                                                    style="cursor: pointer;"
                                                    onclick="openMap({{ $client->locations->latitude ?? 0 }}, {{ $client->locations->longitude ?? 0 }})"></i>
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
                                                        type="button" id="dropdownMenuButton303" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false"></button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton303">
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('clients.show', $client->id) }}">
                                                                <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                            </a>
                                                        </li>
                                                        @if (auth()->user()->hasPermissionTo('Edit_Client'))
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('clients.edit', $client->id) }}">
                                                                    <i class="fa fa-pencil-alt me-2 text-success"></i>تعديل
                                                                </a>
                                                            </li>
                                                        @endif

                                                        <a class="dropdown-item"
                                                            href="{{ route('clients.send_info', $client->id) }}">
                                                            <i class="fa fa-pencil-alt me-2 text-success"></i> إرسال بيانات
                                                            الدخول
                                                        </a>


                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('clients.edit', $client->id) }}">
                                                                <i class="fa fa-copy me-2 text-info"></i>نسخ
                                                            </a>
                                                        </li>
                                                        @if (auth()->user()->hasPermissionTo('Delete_Client'))
                                                            <li>
                                                                <a class="dropdown-item text-danger" href="#"
                                                                    data-toggle="modal"
                                                                    data-target="#modal_DELETE{{ $client->id }}">
                                                                    <i class="fa fa-trash-alt me-2"></i>حذف
                                                                </a>
                                                            </li>
                                                        @endif
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('clients.edit', $client->id) }}">
                                                                <i class="fa fa-file-invoice me-2 text-warning"></i>كشف
                                                                حساب
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-danger text-xl-center" role="alert">
                <p class="mb-0">
                    لا توجد عملاء !!
                </p>
            </div>
        @endif
    </div>

    <!-- Modal إضافة حد ائتماني -->
    <div class="modal fade" id="creditLimitModal" tabindex="-1" aria-labelledby="creditLimitModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="creditLimitModalLabel">تعديل الحد الائتماني</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('clients.update_credit_limit') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="credit_limit" class="form-label">
                                الحد الائتماني الحالي: <span
                                    id="current_credit_limit">{{ $creditLimit->value ?? 'غير محدد' }}</span>
                            </label>
                            <input type="number" class="form-control" id="credit_limit" name="value"
                                value="{{ $creditLimit->value ?? '' }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initMap"
        async defer></script>
    <script>
        function initMap() {
            const map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: 24.68737261,
                    lng: 46.65221190
                }, // مركز الخريطة (الرياض)
                zoom: 6 // مستوى التكبير
            });

            const infoWindow = new google.maps.InfoWindow();

            @foreach ($clients as $client)
                @if ($client->locations && $client->locations->latitude && $client->locations->longitude)
                    const marker{{ $client->id }} = new google.maps.Marker({
                        position: {
                            lat: {{ $client->locations->latitude }},
                            lng: {{ $client->locations->longitude }}
                        },
                        map: map,
                        title: "{{ $client->trade_name }}",
                        label: "{{ $client->code }}"
                    });

                    const contentString{{ $client->id }} = `
                    <div style="color: #333; font-family: Arial, sans-serif;">
                        <h4 style="margin: 0; font-size: 16px; color: #007BFF;">{{ $client->trade_name }}</h4>
                        <p style="margin: 5px 0; font-size: 14px;">
                            <strong>الكود:</strong> {{ $client->code }}
                        </p>
                        <p style="margin: 5px 0; font-size: 14px;">
                            <strong>الاسم:</strong> {{ $client->first_name }} {{ $client->last_name }}
                        </p>
                        <p style="margin: 5px 0; font-size: 14px;">
                            <strong>الهاتف:</strong> {{ $client->phone }}
                        </p>
                        <p style="margin: 5px 0; font-size: 14px;">
                            <strong>العنوان:</strong> {{ $client->city }}, {{ $client->region }}
                        </p>
                        <p style="margin: 5px 0; font-size: 14px;">
                            <strong>الرمز البريدي:</strong> {{ $client->postal_code }}
                        </p>
 <p style="margin: 5px 0; font-size: 14px;">
                            <strong>الرصيد:</strong> {{ $client->Balance }}
                        </p>
                        <a href="{{ route('clients.show', $client->id) }}" target="_blank" style="color: #007BFF; text-decoration: none; font-size: 14px;">
                            عرض التفاصيل
                        </a>
                    </div>
                `;

                    marker{{ $client->id }}.addListener('click', () => {
                        infoWindow.setContent(contentString{{ $client->id }});
                        infoWindow.open(map, marker{{ $client->id }});
                    });
                @endif
            @endforeach
        }

        function openMap(latitude, longitude) {
            const mapUrl = `https://www.google.com/maps?q=${latitude},${longitude}`;
            window.open(mapUrl, '_blank');
        }

        $('#creditLimitModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // الزر الذي فتح الـ Modal
            var clientId = button.data('client-id');
            var currentCredit = button.data('current-credit');

            var modal = $(this);
            modal.find('.modal-body #credit_limit').val(currentCredit); // تعيين الحد الائتماني الحالي
            modal.find('.modal-body #current_credit_limit').text(currentCredit); // عرض الحد الائتماني الحالي
        });
    </script>
@stop
