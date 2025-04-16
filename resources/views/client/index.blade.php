@extends('master')

@section('title')
    إدارة العملاء
@stop

@section('css')
    <style>
        #map {
            height: 85vh;
            width: 100%;
            position: relative;
        }

        /* تصميم صندوق البحث على غرار جوجل مابس */
        .pac-card {
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            width: 400px;
            font-family: Roboto, Arial, sans-serif;
        }

        .search-container {
            padding: 0;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            height: 48px;
            display: flex;
            align-items: center;
        }

        .search-box {
            width: 100%;
            height: 100%;
            border: none;
            padding: 0 16px 0 48px;
            font-size: 15px;
            border-radius: 8px;
            direction: rtl;
        }

        .search-box:focus {
            outline: none;
        }

        .search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
            font-size: 18px;
        }

        /* تصميم لوحة التحكم على غرار جوجل مابس */
        .map-controls {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 1000;
        }

        .map-control-group {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            margin-bottom: 10px;
            overflow: hidden;
        }

        .map-control-button {
            width: 40px;
            height: 40px;
            background: #fff;
            border: none;
            border-bottom: 1px solid #e6e6e6;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.2s;
        }

        .map-control-button:last-child {
            border-bottom: none;
        }

        .map-control-button:hover {
            background-color: #f1f1f1;
        }

        .map-control-button i {
            color: #666;
            font-size: 18px;
        }

        /* تصميم نافذة المعلومات على غرار جوجل مابس */
        .gm-style .gm-style-iw-c {
            padding: 0 !important;
            border-radius: 8px !important;
            max-width: 300px !important;
        }

        .gm-style .gm-style-iw-d {
            overflow: hidden !important;
            padding: 0 !important;
        }

        .client-info-window {
            font-family: Roboto, Arial, sans-serif;
        }

        .info-header {
            padding: 12px 16px;
            border-bottom: 1px solid #e6e6e6;
        }

        .info-content {
            padding: 16px;
        }

        .info-row {
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }

        .info-label {
            color: #666;
            margin-left: 8px;
            font-size: 13px;
        }

        .info-value {
            color: #333;
            font-size: 13px;
        }

        .info-actions {
            display: flex;
            gap: 8px;
            margin-top: 16px;
        }

        .info-button {
            flex: 1;
            padding: 8px;
            border: none;
            border-radius: 4px;
            font-size: 13px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            transition: background-color 0.2s;
        }

        .info-button.primary {
            background: #1a73e8;
            color: white;
        }

        .info-button.secondary {
            background: #fff;
            color: #1a73e8;
            border: 1px solid #1a73e8;
        }

        .info-button:hover {
            opacity: 0.9;
        }

        .hover-effect:hover {
            background-color: #f8f9fa;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .btn-indigo {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            border: none;
        }

        .btn-violet {
            background: linear-gradient(135deg, #9c27b0 0%, #e91e63 100%);
            color: white;
            border: none;
        }

        .btn-orange {
            background: linear-gradient(135deg, #ff7b00 0%, #ff9a00 100%);
            color: white;
            border: none;
        }

        /* تأثيرات عند المرور */
        .btn-hover-shine:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            opacity: 0.92;
            transition: all 0.2s ease;
        }

        /* تأثير إضاءة خفيف */
        .btn-hover-shine:after {
            content: "";
            position: absolute;
            top: -50%;
            left: -60%;
            width: 200%;
            height: 200%;
            background: rgba(255, 255, 255, 0.15);
            transform: rotate(30deg);
            transition: all 0.3s ease;
        }

        .btn-hover-shine:hover:after {
            left: 100%;
        }

        /* تكيف مع الشاشات الصغيرة */
        @media (max-width: 768px) {
            .card-body {
                padding: 0.75rem;
            }

            .btn-sm {
                height: 32px !important;
                font-size: 0.8rem;
            }

            .fs-6 {
                font-size: 0.8rem !important;
            }
        }

        #clientSearch {
            transition: all 0.3s ease;
            border: 1px solid #ddd;
        }

        #clientSearch:focus {
            outline: none;
            border-color: #80bdff;
        }

        .input-group-text {
            color: #6c757d;
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
        <div class="position-relative">
            <div id="map"></div>
            <div class="pac-card">
                <div class="search-container">
                    <input type="text" id="clientSearch" class="search-box" placeholder="ابحث عن عميل...">
                    <i class="fas fa-search search-icon"></i>
                </div>
            </div>
            <div class="map-controls">
                <div class="map-control-group">
                    <button class="map-control-button" onclick="map.setZoom(map.getZoom() + 1)" title="تكبير">
                        <i class="fas fa-plus"></i>
                    </button>
                    <button class="map-control-button" onclick="map.setZoom(map.getZoom() - 1)" title="تصغير">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
                <div class="map-control-group">
                    <button class="map-control-button" onclick="getCurrentLocation()" title="موقعي الحالي">
                        <i class="fas fa-location-arrow"></i>
                    </button>
                    <button class="map-control-button" onclick="resetMapView()" title="إعادة ضبط الخريطة">
                        <i class="fas fa-redo-alt"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- بطاقة الإجراءات -->
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-3">
                <div class="row align-items-center gy-2">
                    <!-- زر إضافة عميل -->
                    <div class="col-12 col-md-6 col-lg-3">
                        <a href="{{ route('clients.create') }}"
                            class="btn btn-hover-shine btn-success btn-sm rounded-pill px-3 w-100 d-flex align-items-center justify-content-center"
                            style="height: 36px;">
                            <i class="fas fa-user-plus me-2 fs-6"></i>
                            <span class="fw-medium">إضافة عميل</span>
                        </a>
                    </div>

                    <!-- زر تحميل ملف Excel -->
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="d-flex flex-column flex-md-row gap-2">
                            <label
                                class="btn btn-hover-shine btn-indigo btn-sm rounded-pill px-2 w-100 d-flex align-items-center justify-content-center"
                                style="height: 36px;">
                                <i class="fas fa-cloud-upload-alt me-2 fs-6"></i>
                                <span class="fw-medium">تحميل</span>
                                <input type="file" name="file" class="d-none" required>
                            </label>
                            <button type="submit"
                                class="btn btn-hover-shine btn-primary btn-sm rounded-pill px-2 w-100 d-flex align-items-center justify-content-center"
                                style="height: 36px;">
                                <i class="fas fa-database me-2 fs-6"></i>
                                <span class="fw-medium">استيراد</span>
                            </button>
                        </div>
                    </div>

                    <!-- زر إضافة حد ائتماني -->
                    <div class="col-12 col-md-6 col-lg-3">
                        <a href="javascript:void(0);"
                            class="btn btn-hover-shine btn-violet btn-sm rounded-pill px-3 w-100 d-flex align-items-center justify-content-center"
                            style="height: 36px;" data-bs-toggle="modal" data-bs-target="#creditLimitModal">
                            <i class="fas fa-credit-card me-2 fs-6"></i>
                            <span class="fw-medium">حد ائتماني</span>
                        </a>
                    </div>

                    <!-- زر التقارير -->
                    <div class="col-12 col-md-6 col-lg-3">
                        <a href="#"
                            class="btn btn-hover-shine btn-orange btn-sm rounded-pill px-3 w-100 d-flex align-items-center justify-content-center"
                            style="height: 36px;">
                            <i class="fas fa-chart-pie me-2 fs-6"></i>
                            <span class="fw-medium">تقارير</span>
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
                    <div class="card p-3 mb-4">
                        <div class="row g-3 align-items-end">
                            <!-- اسم العميل -->
                            <div class="col-md-3 col-12">
                                <label for="client" class="form-label">العميل</label>
                                <select name="client" id="client" class="form-control select2">
                                    <option value="">اختر العميل</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}" {{ request('client') == $client->id ? 'selected' : '' }}>
                                            {{ $client->trade_name }} - {{ $client->code }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- الاسم -->
                            <div class="col-md-3 col-12">
                                <label for="name" class="form-label">الاسم</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="الاسم" value="{{ request('name') }}">
                            </div>

                            <!-- الحالة -->
                            <div class="col-md-3 col-12">
                                <label for="status" class="form-label">الحالة</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">اختر الحالة</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}" {{ request('status') == $status->id ? 'selected' : '' }}>
                                            {{ $status->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- المجموعة -->
                            <div class="col-md-3 col-12">
                                <label for="region" class="form-label">المجموعة</label>
                                <select name="region" id="region" class="form-control select2">
                                    <option value="">اختر المجموعة</option>
                                    @foreach ($Region_groups as $Region_group)
                                        <option value="{{ $Region_group->id }}" {{ request('region') == $Region_group->id ? 'selected' : '' }}>
                                            {{ $Region_group->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- الحي -->
                            <div class="col-md-12 col-12">
                                <label for="neighborhood" class="form-label">الحي</label>
                                <input type="text" name="neighborhood" id="neighborhood" class="form-control"
                                    placeholder="الحي" value="{{ request('neighborhood') }}">
                            </div>
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
                                    <th>المجموعة</th>
                                    <th>الحي</th>
                                     <th>الفرع</th>
                                     <th>نوع الزيارة</th>
                                     <th>الحالة</th>
                                    <th>الكود</th>
                                    <th>رقم الهاتف</th>
                                    <th style="width: 10%">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clients as $client)
                                    <tr onclick="handleRowClick(event, '{{ route('clients.show', $client->id) }}')"
                                        style="cursor: pointer;" class="hover-effect">
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
                                                    onclick="openMap({{ $client->locations->latitude ?? 0 }}, {{ $client->locations->longitude ?? 0 }}, '{{ $client->trade_name }}')"></i>
                                                {{ $client->city }}, {{ $client->region }}
                                            </p>
                                        </td>
                                        <td>{{ $client->Neighborhoodname->Region->name ?? '' }}</td>
                                        <td>{{ $client->Neighborhoodname->name ?? '' }}</td>


                                           <td>{{ $client->branch->name ?? '' }}</td>
                                           <td>
                                            @if($client->visit_type == "am")
                                                <span class="badge badge-success">
                                                    ☀️ صباحية
                                                </span>
                                            @else
                                                <span class="badge badge-primary">
                                                    🌙 مسائية
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($client->status_client)
                                                <span style="background-color: {{ $client->status_client->color }}; color: #fff; padding: 2px 8px; font-size: 12px; border-radius: 4px; display: inline-block;">
                                                    {{ $client->status_client->name }}
                                                </span>
                                            @else
                                                <span style="background-color: #6c757d; color: #fff; padding: 2px 8px; font-size: 12px; border-radius: 4px; display: inline-block;">
                                                    غير محدد
                                                </span>
                                            @endif
                                        </td>


                                        <td>{{ $client->code ?? '' }}</td>
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
                                                                href="{{ route('clients.statement', $client->id) }}">
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
                                                            <p>هل أنت متأكد من الحذف "{{ $client->trade_name }}"؟</p>
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
        {{-- @if ($clients->hasPages())
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm mb-0">
                    <!-- زر الانتقال إلى أول صفحة -->
                    @if ($clients->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link border-0 rounded-pill" aria-label="First">
                                <i class="fas fa-angle-double-right"></i>
                            </span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link border-0 rounded-pill" href="{{ $clients->url(1) }}" aria-label="First">
                                <i class="fas fa-angle-double-right"></i>
                            </a>
                        </li>
                    @endif

                    <!-- زر الانتقال إلى الصفحة السابقة -->
                    @if ($clients->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link border-0 rounded-pill" aria-label="Previous">
                                <i class="fas fa-angle-right"></i>
                            </span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link border-0 rounded-pill" href="{{ $clients->previousPageUrl() }}"
                                aria-label="Previous">
                                <i class="fas fa-angle-right"></i>
                            </a>
                        </li>
                    @endif

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

                    <!-- زر الانتقال إلى آخر صفحة -->
                    @if ($clients->hasMorePages())
                        <li class="page-item">
                            <a class="page-link border-0 rounded-pill" href="{{ $clients->url($clients->lastPage()) }}"
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
        @endif --}}

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
        let map;
        let infoWindow;
        let currentUserMarker;

        function initMap() {
            const mapOptions = {
                zoom: 14,
                center: { lat: 24.7136, lng: 46.6753 },
                mapTypeControl: true,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                    position: google.maps.ControlPosition.TOP_RIGHT
                },
                zoomControl: false,
                streetViewControl: true,
                streetViewControlOptions: {
                    position: google.maps.ControlPosition.LEFT_BOTTOM
                },
                fullscreenControl: true,
                fullscreenControlOptions: {
                    position: google.maps.ControlPosition.RIGHT_TOP
                },
                styles: [
                    {
                        "featureType": "poi",
                        "stylers": [
                            { "visibility": "off" }
                        ]
                    },
                    {
                        "featureType": "transit",
                        "elementType": "labels.icon",
                        "stylers": [
                            { "visibility": "off" }
                        ]
                    }
                ]
            };

            map = new google.maps.Map(document.getElementById('map'), mapOptions);
            infoWindow = new google.maps.InfoWindow({
                maxWidth: 300
            });

            // تحديث تصميم نافذة المعلومات
            function showClientInfo(markerData) {
                const contentString = `
                    <div class="client-info-window">
                        <div class="info-header">
                            <h6 style="margin: 0; font-size: 15px; font-weight: 500;">
                                ${markerData.data.name}
                            </h6>
                        </div>
                        <div class="info-content">
                            <div class="info-row">
                                <span class="info-label">الكود:</span>
                                <span class="info-value">${markerData.data.code}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">الهاتف:</span>
                                <span class="info-value">
                                    <a href="tel:${markerData.data.phone}" style="color: #1a73e8; text-decoration: none;">
                                        ${markerData.data.phone}
                                    </a>
                                </span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">الموقع:</span>
                                <span class="info-value">${markerData.data.city}, ${markerData.data.region}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">الرصيد:</span>
                                <span class="info-value" style="color: ${markerData.data.balance < 0 ? '#d93025' : '#188038'}">
                                    ${markerData.data.balance} ر.س
                                </span>
                            </div>
                            <div class="info-actions">
                                <button onclick="window.location.href=''" class="info-button primary">
                                    <i class="fas fa-info-circle"></i>
                                    التفاصيل
                                </button>
                                <button onclick="openMap(${markerData.marker.getPosition().lat()}, ${markerData.marker.getPosition().lng()})"
                                        class="info-button secondary">
                                    <i class="fas fa-map-marked-alt"></i>
                                    فتح
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                infoWindow.setContent(contentString);
                infoWindow.open(map, markerData.marker);
            }

            // إضافة علامات العملاء
            let allMarkers = [];

            @foreach ($clients as $client)
                @if ($client->locations && $client->locations->latitude && $client->locations->longitude)
                    const marker{{ $client->id }} = new google.maps.Marker({
                        position: {
                            lat: {{ $client->locations->latitude }},
                            lng: {{ $client->locations->longitude }}
                        },
                        map: map,
                        title: "{{ $client->trade_name }}",
                        icon: {
                            url: "data:image/svg+xml;charset=UTF-8," + encodeURIComponent(`
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40">
                                    <circle cx="20" cy="20" r="18" fill="{{ optional(\App\Models\Statuses::find($client->status_id))->color ?? '#CCCCCC' }}" stroke="#FFFFFF" stroke-width="2"/>
                                    <path fill="#FFFFFF" d="M20 10a8 8 0 0 1 8 8c0 5-8 14-8 14s-8-9-8-14a8 8 0 0 1 8-8zm0 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8z"/>
                                    <text x="20" y="32" font-family="Arial" font-size="12" font-weight="bold" text-anchor="middle" fill="#FFFFFF">{{ $client->code }}</text>
                                </svg>
                            `),
                            scaledSize: new google.maps.Size(40, 40),
                            anchor: new google.maps.Point(20, 40)
                        },
                        animation: google.maps.Animation.DROP
                    });

                    // إضافة الماركر للمصفوفة
                    allMarkers.push({
                        marker: marker{{ $client->id }},
                        clientName: "{{ $client->trade_name }}".toLowerCase(),
                        clientCode: "{{ $client->code }}".toLowerCase(),
                        data: {
                            id: {{ $client->id }},
                            name: "{{ $client->trade_name }}",
                            code: "{{ $client->code }}",
                            status: "{{ optional(\App\Models\Statuses::find($client->status_id))->color ?? '#CCCCCC' }}",
                            phone: "{{ $client->phone }}",
                            city: "{{ $client->city }}",
                            region: "{{ $client->region }}",
                            balance: "{{ $client->Balance() }}"
                        }
                    });

                    // إضافة مستمع حدث النقر
                    marker{{ $client->id }}.addListener('click', () => {
                        showClientInfo(allMarkers.find(m => m.marker === marker{{ $client->id }}));
                    });
                @endif
            @endforeach

            // تفعيل البحث
            const searchInput = document.getElementById('clientSearch');
            searchInput.addEventListener('input', function() {
                const searchValue = this.value.toLowerCase().trim();
                filterMarkers(searchValue, allMarkers);
            });
        }

        function filterMarkers(searchValue, markers) {
            markers.forEach(item => {
                const isVisible = item.clientName.includes(searchValue) ||
                                item.clientCode.includes(searchValue);
                item.marker.setVisible(isVisible);

                if (searchValue && (item.clientName === searchValue || item.clientCode === searchValue)) {
                    showClientInfo(item);
                    map.panTo(item.marker.getPosition());
                    map.setZoom(15);
                }
            });
        }

        function getCurrentLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const pos = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };

                        if (currentUserMarker) {
                            currentUserMarker.setPosition(pos);
                        } else {
                            currentUserMarker = new google.maps.Marker({
                                position: pos,
                                map: map,
                                icon: {
                                    url: "https://maps.google.com/mapfiles/ms/icons/blue-dot.png",
                                    scaledSize: new google.maps.Size(40, 40)
                                },
                                title: "موقعك الحالي",
                                animation: google.maps.Animation.DROP
                            });
                        }

                        map.setCenter(pos);
                        map.setZoom(14);
                    },
                    () => {
                        console.error("فشل في الحصول على الموقع");
                    }
                );
            }
        }

        function resetMapView() {
            if (currentUserMarker) {
                map.setCenter(currentUserMarker.getPosition());
                map.setZoom(14);
            } else {
                map.setCenter({ lat: 24.7136, lng: 46.6753 });
                map.setZoom(10);
            }
            infoWindow.close();
        }

        function openMap(lat, lng, title = '') {
            if (lat === 0 || lng === 0) {
                alert('لا يوجد إحداثيات متاحة لهذا العميل');
                return;
            }

            window.location.href = `https://www.google.com/maps?q=${lat},${lng}&z=17`;
        }

        function handleRowClick(event, url) {
            let target = event.target;

            // السماح بالنقر على العناصر التالية بدون تحويل
            if (target.tagName.toLowerCase() === 'a' ||
                target.closest('.dropdown-menu') ||
                target.closest('.btn') ||
                target.closest('.form-check-input')) {
                return;
            }

            // تحويل المستخدم لصفحة العميل عند الضغط على الصف
            window.location = url;
        }

        // إصلاح مشكلة عدم فتح الدروب داون
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".dropdown-toggle").forEach(function(dropdown) {
                dropdown.addEventListener("click", function(event) {
                    event.preventDefault();
                    event.stopImmediatePropagation();
                    let menu = this.nextElementSibling;
                    if (menu) {
                        menu.classList.toggle("show");
                    }
                });
            });

            // إغلاق الدروب داون عند النقر خارجها
            document.addEventListener("click", function(event) {
                document.querySelectorAll(".dropdown-menu").forEach(function(menu) {
                    if (!menu.parentElement.contains(event.target)) {
                        menu.classList.remove("show");
                    }
                });
            });
        });
    </script>
@stop
