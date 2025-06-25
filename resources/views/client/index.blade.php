@extends('master')

@section('title')
    إدارة العملاء
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/indexclient.css') }}">
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
            <!-- زر فتح/إغلاق الخريطة مع تلميح عائم -->
            <button id="toggleMapButton" class="map-toggle-button" data-tooltip="إظهار الخريطة">
                <i class="fas fa-map-marked-alt"></i>
            </button>

            <div id="mapContainer" style="display: none;">
                <!-- باقي العناصر كما هي -->
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
        </div>


        <script>
            const toggleButton = document.getElementById('toggleMapButton');
            const mapContainer = document.getElementById('mapContainer');

            // لا حاجة لتعديل السكريبت فهو يعمل بنفس الطريقة
            toggleButton.addEventListener('click', function() {
                if (mapContainer.style.display === 'none') {
                    mapContainer.style.display = 'block';
                    this.innerHTML = '<i class="fas fa-map"></i>';
                    this.setAttribute('data-tooltip', 'إخفاء الخريطة');
                } else {
                    mapContainer.style.display = 'none';
                    this.innerHTML = '<i class="fas fa-map-marked-alt"></i>';
                    this.setAttribute('data-tooltip', 'إظهار الخريطة');
                }

                if (mapContainer.style.display === 'block') {
                    setTimeout(() => {
                        if (typeof map !== 'undefined') {
                            google.maps.event.trigger(map, 'resize');
                        }
                    }, 300);
                }
            });
        </script>
        <!-- بطاقة الإجراءات -->
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-3">
                <div class="d-flex flex-wrap justify-content-end" style="gap: 10px;">

                    <!-- زر أضف العميل -->

                    <!-- زر تحميل ملف -->
                    <label class="bg-white border d-flex align-items-center justify-content-center"
                        style="width: 44px; height: 44px; cursor: pointer; border-radius: 6px;" title="تحميل ملف">
                        <i class="fas fa-cloud-upload-alt text-primary"></i>
                        <input type="file" name="file" class="d-none">
                    </label>

                    <!-- زر استيراد -->
                    <button type="submit" class="bg-white border d-flex align-items-center justify-content-center"
                        style="width: 44px; height: 44px; border-radius: 6px;" title="استيراد ك Excel">
                        <i class="fas fa-database text-primary"></i>
                    </button>

                    <!-- زر حد ائتماني -->
                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#creditLimitModal"
                        class="bg-white border d-flex align-items-center justify-content-center"
                        style="width: 44px; height: 44px; border-radius: 6px;" title="حد ائتماني">
                        <i class="fas fa-credit-card text-primary"></i>
                    </a>

                    <!-- زر تصدير ك Excel (الجديد) -->
                    <button id="exportExcelBtn" class="bg-white border d-flex align-items-center justify-content-center"
                        style="width: 44px; height: 44px; border-radius: 6px;" title="تصدير ك Excel">
                        <i class="fas fa-file-excel text-primary"></i>
                    </button>

                    <a href="{{ route('clients.create') }}"
                        class="btn btn-success d-flex align-items-center justify-content-center"
                        style="height: 44px; padding: 0 16px; font-weight: bold; border-radius: 6px;">
                        <i class="fas fa-plus ms-2"></i>
                        أضف العميل
                    </a>
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
                            <div class="col-md-4 col-12">
                                <label for="client" class="form-label">العميل</label>
                                <select name="client" id="client" class="form-control select2">
                                    <option value="">اختر العميل</option>
                                    @foreach ($allClients as $client)
                                        <option value="{{ $client->id }}"
                                            {{ request('client') == $client->id ? 'selected' : '' }}>
                                            {{ $client->trade_name }} - {{ $client->code }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- الاسم -->

                            <!-- الحالة -->
                            <div class="col-md-4 col-12">
                                <label for="status" class="form-label">الحالة</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">اختر الحالة</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}"
                                            {{ request('status') == $status->id ? 'selected' : '' }}>
                                            {{ $status->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- المجموعة -->
                            <div class="col-md-4 col-12">
                                <label for="region" class="form-label">المجموعة</label>
                                <select name="region" id="region" class="form-control select2">
                                    <option value="">اختر المجموعة</option>
                                    @foreach ($Region_groups as $Region_group)
                                        <option value="{{ $Region_group->id }}"
                                            {{ request('region') == $Region_group->id ? 'selected' : '' }}>
                                            {{ $Region_group->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- الحي -->
                            <div class="col-md-4 col-12">
                                <label for="neighborhood" class="form-label">الحي</label>
                                <input type="text" name="neighborhood" id="neighborhood" class="form-control"
                                    placeholder="الحي" value="{{ request('neighborhood') }}">
                            </div>

                            <!-- تاريخ من -->
                            <div class="col-md-4 col-12">
                                <label for="date_from" class="form-label">تاريخ من</label>
                                <input type="date" name="date_from" id="date_from" class="form-control"
                                    value="{{ request('date_from') }}">
                            </div>

                            <!-- تاريخ الى -->
                            <div class="col-md-4 col-12">
                                <label for="date_to" class="form-label">تاريخ الى</label>
                                <input type="date" name="date_to" id="date_to" class="form-control"
                                    value="{{ request('date_to') }}">
                            </div>
                        </div>
                    </div>

                    <div class="collapse" id="advancedSearchForm">
                        <div class="row g-3 mt-2">
                            <!-- التصنيف -->
                            <div class="col-md-4 col-12">
                                <label for="classifications" class="form-label">التصنيف</label>
                                <select name="categories" id="classifications" class="form-control">
                                    <option value="">اختر التصنيف</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ request('categories') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- أضيفت بواسطة -->
                            <div class="col-md-4 col-12">
                                <label for="user" class="form-label">أضيفت بواسطة</label>
                                <select name="user" id="user" class="form-control select2">
                                    <option value="">أضيفت بواسطة</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ request('user') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} - {{ $user->id }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- النوع -->


                            <!-- الموظفين المعيين -->
                            <div class="col-md-4 col-12">
                                <label for="employee" class="form-label">الموظفين المعيين</label>
                                <select id="feedback2" class="form-control select2" name="employee[]"
                                    multiple="multiple">
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
        <!-- جدول العملاء -->
        <div class="mb-3">
            <input type="text" id="searchInput" class="form-control" placeholder="ابحث عن عميل...">
        </div>

        @if (isset($clients) && $clients->count() > 0)
            <div id="clients-container">
                <div class="row">
                    @foreach ($clients as $client)
                        @php
                            $clientData = $clientsData[$client->id] ?? null;
                            $due = $clientDueBalances[$client->id] ?? 0;
                            $totalSales = $clientTotalSales[$client->id] ?? 0;
                            $currentMonth = now()->format('m');
                            $monthlyGroup =
                                $clientData['monthly_groups'][$currentMonth]['group'] ?? ($clientData['group'] ?? 'D');
                            $monthlyGroupClass =
                                $clientData['monthly_groups'][$currentMonth]['group_class'] ??
                                ($clientData['group_class'] ?? 'secondary');
                        @endphp

                        <div class="col-md-6 my-3 client-card">
                            <div class="card shadow-sm border border-1 rounded-3 h-100">
                                <!-- محتوى الكارد كما هو -->
                                <div class="card-body d-flex flex-column">
                                    <!-- Card Header -->
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <!-- حالة العميل -->
                                        @php
                                            // نحصل آخر ملاحظة فيها الحالة الأصلية من الموظف الحالي بنوع "إبلاغ المشرف"
                                            $lastNote = $client
                                                ->appointmentNotes()
                                                ->where('employee_id', auth()->id())
                                                ->where('process', 'إبلاغ المشرف')
                                                ->whereNotNull('employee_view_status')
                                                ->latest()
                                                ->first();

                                            // الحالة الأساسية الافتراضية
                                            $statusToShow = $client->status_client;

                                            // لو الموظف هو اللي أبلغ المشرف، نعرض له الحالة الأصلية
                                            if (
                                                auth()->user()->role === 'employee' &&
                                                $lastNote &&
                                                $lastNote->employee_id == auth()->id()
                                            ) {
                                                $statusToShow = $statuses->find($lastNote->employee_view_status);
                                            }
                                        @endphp

                                        <div>
                                            @if ($statusToShow)
                                                <span class="badge rounded-pill"
                                                    style="background-color: {{ $statusToShow->color }}; font-size: 11px;">
                                                    <i class="fas fa-circle me-1"></i>
                                                    {{ $statusToShow->name }}
                                                </span>
                                            @else
                                                <span class="badge rounded-pill bg-secondary" style="font-size: 11px;">
                                                    <i class="fas fa-question-circle me-1"></i>
                                                    غير محدد
                                                </span>
                                            @endif
                                        </div>
                                        <!-- Dropdown -->
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary" type="button"
                                                id="clientActionsDropdown{{ $client->id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false" style="font-size: 11px;">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu"
                                                aria-labelledby="clientActionsDropdown{{ $client->id }}">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('clients.show', $client->id) }}">
                                                        <i class="far fa-eye me-1"></i> عرض
                                                    </a>
                                                </li>
                                                @if (auth()->user()->hasPermissionTo('Edit_Client'))
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('clients.edit', $client->id) }}">
                                                            <i class="fas fa-edit me-1"></i> تعديل
                                                        </a>
                                                    </li>
                                                @endif
                                                @if (auth()->user()->hasPermissionTo('Delete_Client'))
                                                    <li>
                                                        <a class="dropdown-item text-danger"
                                                            href="{{ route('clients.destroy', $client->id) }}">
                                                            <i class="fas fa-trash-alt me-1"></i> حذف
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>


                                    <!-- Client Info -->
                                    <div class="row row-cols-2 g-2 mb-2">
                                        <!-- Column 1 -->
                                        <div class="col">
                                            <h6 class="client-name text-primary mb-2" style="font-size: 15px;">
                                                <i class="fas fa-store me-1"></i>
                                                {{ $client->trade_name }}
                                            </h6>

                                            <div class="mb-1">
                                                <small><i class="fas fa-phone text-secondary me-1"></i>
                                                    {{ $client->phone ?? '-' }}</small>
                                            </div>
                                            s <div class="mb-1">
                                                <small><i class="fas fa-user text-secondary me-1"></i>
                                                    {{ $client->frist_name ?? '-' }}</small>
                                            </div>
                                            <div class="mb-1">
                                                <small>
                                                    <i class="fas fa-map-marker-alt text-secondary me-1"></i>
                                                    <a
                                                        href="https://www.google.com/maps/search/?api=1&query={{ $client->locations->latitude }},{{ $client->locations->longitude }}">
                                                        عرض الموقع
                                                    </a>
                                                </small>
                                            </div>

                                        </div>

                                        <!-- Column 2 -->
                                        <div class="col">
                                            <div class="mb-1">
                                                <h7 class="client-name  mb-2">

                                                    {{ $client->code }}
                                                </h7>

                                            </div>

                                            <div class="mb-1">
                                                <small><i class="fas fa-tags text-secondary me-1"></i>
                                                    {{ optional($client->categoriesClient)->name }}
                                                </small>

                                            </div>
                                            <div class="mb-1">
                                                <small><i class="fas fa-code-branch text-secondary me-1"></i>
                                                    {{ $client->Neighborhood->Region->name ?? '-' }}</small>
                                            </div>
                                            <div class="mb-1">
                                                <small><i class="fas fa-code-branch text-secondary me-1"></i>
                                                    {{ $client->branch->name ?? '-' }}</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Dates and Status -->
                                    <div class="d-flex justify-content-between text-center border rounded p-2 mb-2">
                                        <div>
                                            <i class="fas fa-calendar-plus text-secondary"></i>
                                            <div><small>الإضافة</small></div>
                                            <small>{{ $client->created_at->format('Y-m-d') }}</small>
                                        </div>
                                        <div>
                                            <i class="fas fa-file-invoice-dollar text-secondary"></i>
                                            <div><small>آخر فاتورة</small></div>
                                            <small>{{ $client->invoices->last()->invoice_date ?? '-' }}</small>
                                        </div>

                                        @php
                                            // نحاول نحصل آخر ملاحظة من نوع "إبلاغ المشرف" أنشأها نفس الموظف
                                            $lastNote = $client
                                                ->appointmentNotes()
                                                ->where('employee_id', auth()->id())
                                                ->where('process', 'إبلاغ المشرف')
                                                ->whereNotNull('employee_view_status')
                                                ->latest()
                                                ->first();

                                            // الحالة الأساسية هي الحالة الحالية للعميل
                                            $statusToShow = $client->status_client;

                                            // إذا كان الموظف هو من أبلغ المشرف نعرض له الحالة الأصلية المحفوظة
                                            if (
                                                auth()->user()->role === 'employee' &&
                                                $lastNote &&
                                                $lastNote->employee_id == auth()->id()
                                            ) {
                                                $statusToShow = $statuses->find($lastNote->employee_view_status);
                                            }
                                        @endphp

                                        <div>
                                            <i class="fas fa-check"
                                                style="color: {{ $statusToShow->color ?? '#6c757d' }}"></i>
                                            <div><small>الحالة</small></div>

                                            @if ($statusToShow)
                                                <strong style="color: {{ $statusToShow->color }};">
                                                    {{ $statusToShow->name }}
                                                </strong>
                                            @else
                                                <strong class="text-secondary">غير محدد</strong>
                                            @endif
                                        </div>

                                    </div>

                                    <!-- Stats Section -->
                                    <div class="d-flex justify-content-around text-center border rounded p-2 mb-3">
                                        <div class="px-1">
                                            <i class="fas fa-cash-register text-primary"></i>
                                            <div class="small text-muted">المبيعات</div>
                                            <strong class="text-primary">{{ number_format($totalSales ?? 0) }}</strong>
                                        </div>
                                        <div class="px-1">
                                            <i class="fas fa-money-bill-wave text-success"></i>
                                            <div class="small text-muted">التحصيلات</div>
                                            <strong
                                                class="text-success">{{ number_format($clientsData[$client->id]['total_collected'] ?? 0) }}</strong>
                                        </div>
                                        <div class="px-1">
                                            <i class="fas fa-clock text-warning"></i>
                                            <div class="small text-muted">الآجلة</div>
                                            <strong
                                                class="text-warning">{{ number_format($clientDueBalances[$client->id] ?? 0) }}</strong>
                                        </div>
                                    </div>

                                    <!-- Monthly Classification with Enhanced Details -->
                                    <div class="mb-3">
                                        <h6 class="text-muted mb-2">التصنيف الشهري لعام {{ $currentYear }}</h6>
                                        <div class="d-flex flex-wrap justify-content-start">
                                            @foreach ($months as $monthName => $monthNumber)
                                                @continue($monthNumber > now()->month) <!-- تجاهل الشهور القادمة -->

                                                @php
                                                    $monthData =
                                                        $clientsData[$client->id]['monthly'][$monthName] ?? null;
                                                    $group = $monthData['group'] ?? 'd';
                                                    $groupClass = $monthData['group_class'] ?? 'secondary';
                                                    $collected = $monthData['collected'] ?? 0;
                                                    $percentage = $monthData['percentage'] ?? 0;
                                                    $paymentsTotal = $monthData['payments_total'] ?? 0;
                                                    $receiptsTotal = $monthData['receipts_total'] ?? 0;
                                                    $target = $monthData['target'] ?? 100000;
                                                @endphp

                                                <div class="text-center position-relative" style="margin: 5px;"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="التحصيلات: {{ number_format($collected) }} | المدفوعات: {{ number_format($paymentsTotal) }} | سندات القبض: {{ number_format($receiptsTotal) }} | النسبة: {{ $percentage }}%">

                                                    <!-- Classification Circle -->
                                                    <div class="rounded-circle border-2 border-{{ $groupClass }}
                text-{{ $groupClass }} fw-bold
                d-flex align-items-center justify-content-center"
                                                        style="width:40px; height:40px; cursor: pointer;">
                                                        {{ $group }}
                                                    </div>

                                                    <!-- Month Name -->
                                                    <small class="d-block text-muted mt-1">{{ $monthName }}</small>

                                                    <!-- Amount Collected (if any) -->
                                                    @if ($collected > 0)
                                                        <small class="d-block text-success" style="font-size: 0.7rem;">
                                                            {{ number_format($collected, 0) }}
                                                        </small>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Detailed Monthly Breakdown (Collapsible) -->


                                    <!-- JavaScript for Tooltips -->

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info text-center py-4" role="alert">
                    <i class="fas fa-info-circle fa-2x mb-3"></i>
                    <h5 class="mb-0">لا توجد عملاء مسجلين حالياً</h5>
                </div>
        @endif
        <div class="d-flex justify-content-end align-items-center mb-3">
            <label for="cardsPerPage" class="me-2">أظهر</label>
            <select id="cardsPerPage" class="form-select w-auto" style="min-width: 80px;">
                <option value="10" selected>10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <span class="ms-2">مدخلات</span>
        </div>




        @if ($clients->hasPages())
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
                            <a class="page-link border-0 rounded-pill pagination-link" href="{{ $clients->url(1) }}"
                                aria-label="First" data-page="1">
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
                            <a class="page-link border-0 rounded-pill pagination-link"
                                href="{{ $clients->previousPageUrl() }}" aria-label="Previous"
                                data-page="{{ $clients->currentPage() - 1 }}">
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
                            <a class="page-link border-0 rounded-pill pagination-link"
                                href="{{ $clients->nextPageUrl() }}" aria-label="Next"
                                data-page="{{ $clients->currentPage() + 1 }}">
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
                            <a class="page-link border-0 rounded-pill pagination-link"
                                href="{{ $clients->url($clients->lastPage()) }}" aria-label="Last"
                                data-page="{{ $clients->lastPage() }}">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>


    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initMap"
        async defer></script>

    <script>
        $(document).ready(function() {
            function paginateCards(perPage) {
                const cards = $('.client-card');
                cards.hide(); // أخفِ جميع الكروت أولاً
                cards.slice(0, perPage).show(); // عرض العدد المطلوب فقط
            }

            // أول مرة عرض
            paginateCards($('#cardsPerPage').val());

            // عند تغيير القيمة
            $('#cardsPerPage').on('change', function() {
                const perPage = parseInt($(this).val());
                paginateCards(perPage);
            });
        });
    </script>
    @php
        $statusColor = optional($client->status_client)->color ?? '#CCCCCC';

        if (auth()->user()->role === 'employee') {
            $lastNote = $client
                ->appointmentNotes()
                ->where('employee_id', auth()->id())
                ->whereNotNull('employee_view_status')
                ->latest()
                ->first();

            if ($lastNote && $lastNote->process === 'إبلاغ المشرف') {
                $originalStatus = \App\Models\Statuses::find($lastNote->employee_view_status);
                $statusColor = $originalStatus->color ?? $statusColor;
            }
        }
    @endphp

    <script>
        let map;
        let infoWindow;
        let currentUserMarker;

        function initMap() {
            const mapOptions = {
                zoom: 14,
                center: {
                    lat: 24.7136,
                    lng: 46.6753
                },
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                mapTypeControl: true,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                    position: google.maps.ControlPosition.TOP_RIGHT,
                    mapTypeIds: [
                        google.maps.MapTypeId.ROADMAP,
                        google.maps.MapTypeId.SATELLITE,
                        google.maps.MapTypeId.HYBRID,
                        google.maps.MapTypeId.TERRAIN
                    ]
                },
                zoomControl: true,
                zoomControlOptions: {
                    position: google.maps.ControlPosition.LEFT_CENTER
                },
                streetViewControl: true,
                streetViewControlOptions: {
                    position: google.maps.ControlPosition.LEFT_BOTTOM
                },
                fullscreenControl: true,
                fullscreenControlOptions: {
                    position: google.maps.ControlPosition.RIGHT_TOP
                },
            };

            map = new google.maps.Map(document.getElementById('map'), mapOptions);
            infoWindow = new google.maps.InfoWindow({
                maxWidth: 300
            });

            // تحديث تصميم نافذة المعلومات
            function showClientInfo(markerData) {
                if (infoWindow) {
                    infoWindow.close();
                }

                const contentString = `
        <div class="client-info-window" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; width: 300px; max-height: 400px; overflow-y: auto; box-shadow: 0 4px 12px rgba(0,0,0,0.15); border-radius: 10px; overflow: hidden;">
            <div class="info-header" style="background: linear-gradient(135deg, #3a0ca3 0%, #4361ee 100%); color: white; padding: 16px; text-align: center;">
                <h6 style="margin: 0; font-size: 18px; font-weight: 700;">
                    ${markerData.data.name}
                </h6>
            </div>

            <div class="info-content" style="padding: 16px; background: #f8f9fa;">
                <div style="display: grid; gap: 10px;">
                    <!-- هاتف العميل -->
                    <div class="info-row" style="display: flex; align-items: center; background: white; padding: 10px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                        <i class="fas fa-phone" style="color: #4361ee; width: 20px; text-align: center;"></i>
                        <span class="info-label" style="color: #6c757d; margin-right: 8px; font-size: 13px;">الهاتف:</span>
                        <a href="tel:${markerData.data.phone}" style="color: #4361ee; text-decoration: none; font-weight: 600; font-size: 14px;">
                            ${markerData.data.phone}
                        </a>
                    </div>

                    <!-- موقع العميل -->
                    <div class="info-row" style="display: flex; align-items: center; background: white; padding: 10px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                        <i class="fas fa-map-marker-alt" style="color: #f72585; width: 20px; text-align: center;"></i>
                        <span class="info-label" style="color: #6c757d; margin-right: 8px; font-size: 13px;">الموقع:</span>
                        <span class="info-value" style="color: #343a40; font-weight: 500; font-size: 14px;">
                            ${markerData.data.region}
                        </span>
                    </div>

                    <!-- رصيد العميل -->
                    <div class="info-row" style="display: flex; align-items: center; background: white; padding: 10px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                        <i class="fas fa-wallet" style="color: ${markerData.data.balance < 0 ? '#ef233c' : '#2b9348'}; width: 20px; text-align: center;"></i>
                        <span class="info-label" style="color: #6c757d; margin-right: 8px; font-size: 13px;">الرصيد:</span>
                        <span class="info-value" style="color: ${markerData.data.balance < 0 ? '#ef233c' : '#2b9348'}; font-weight: 700; font-size: 14px;">
                            ${markerData.data.balance} ر.س
                        </span>
                    </div>
                </div>

                <!-- أزرار الإجراءات -->
                <div class="info-actions" style="display: flex; gap: 10px; margin-top: 20px;">
                    <button onclick="window.location.href='{{ route('clients.show', '') }}/${markerData.data.id}'"
                        style="flex: 1; padding: 10px 12px; border: none; border-radius: 8px; background: linear-gradient(135deg, #28a745 0%, #5cb85c 100%); color: white; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; font-weight: 600; font-size: 14px; transition: all 0.2s ease;">
                        <i class="fas fa-info-circle"></i>
                        التفاصيل
                    </button>
                    <button onclick="openMap(${markerData.marker.getPosition().lat()}, ${markerData.marker.getPosition().lng()})"
                            style="flex: 1; padding: 10px 12px; border: 1px solid #4361ee; border-radius: 8px; background: white; color: #4361ee; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; font-weight: 600; font-size: 14px; transition: all 0.2s ease;">
                        <i class="fas fa-map-marked-alt"></i>
                        الخريطة
                    </button>
                </div>
            </div>
        </div>

         `;
                infoWindow = new google.maps.InfoWindow({
                    content: contentString,
                    maxWidth: 300
                });
                infoWindow.open(map, markerData.marker);
            }

            // إضافة علامات العملاء
            // إضافة علامات العملاء
            // إضافة علامات العملاء
            // إضافة علامات العملاء

            let allMarkers = [];

            @foreach ($allClients as $client)
                @if ($client->locations && $client->locations->latitude && $client->locations->longitude)
                    @php
                        $shouldHide = false;
                        $statusColor = optional($client->status_client)->color ?? '#4CAF50';
                        $statusName = optional($client->status_client)->name ?? 'غير محدد';

                        if (auth()->user()->role === 'employee') {
                            //  استخدم orderByDesc للحصول على أحدث ملاحظة فعليًا
                            $lastNote = $client->appointmentNotes()->orderByDesc('created_at')->first();

                            // إذا الموظف هو كاتب آخر ملاحظة → نخفي العميل
                            $shouldHide = $lastNote && $lastNote->employee_id == auth()->id();

                            // force_show = true → نظهر العميل
                            if ($client->force_show) {
                                $shouldHide = false;
                            }

                            // تغيير اللون في حالة "إبلاغ مشرف"
                            $employeeNote = $client
                                ->appointmentNotes()
                                ->where('employee_id', auth()->id())
                                ->whereNotNull('employee_view_status')
                                ->orderByDesc('created_at')
                                ->first();

                            if ($employeeNote && $employeeNote->process === 'إبلاغ المشرف') {
                                $originalStatus = \App\Models\Statuses::find($employeeNote->employee_view_status);
                                if ($originalStatus) {
                                    $statusColor = $originalStatus->color;
                                    $statusName = $originalStatus->name;
                                }
                            }
                        }
                    @endphp


                    @if (!$shouldHide)
                        const marker{{ $client->id }} = new google.maps.Marker({
                            position: {
                                lat: {{ $client->locations->latitude }},
                                lng: {{ $client->locations->longitude }}
                            },
                            map: map,
                            title: "{{ $client->trade_name }}",
                            icon: {
                                url: "data:image/svg+xml;charset=UTF-8," + encodeURIComponent(`
                        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="24" viewBox="0 0 60 24">
                            <rect x="0" y="0" width="60" height="16" rx="8" fill="{{ $statusColor }}" />
                            <path d="M8 16 L12 22 L16 16 Z" fill="{{ $statusColor }}" />
                            <text x="30" y="12" font-family="Arial" font-size="10" font-weight="bold" text-anchor="middle" fill="white">{{ $client->code }}</text>
                        </svg>


                    `),
                                scaledSize: new google.maps.Size(60, 24),
                                anchor: new google.maps.Point(12, 22)
                            },
                            animation: google.maps.Animation.DROP
                        });

                        allMarkers.push({
                            marker: marker{{ $client->id }},
                            clientName: "{{ $client->trade_name }}".toLowerCase(),
                            clientCode: "{{ $client->code }}".toLowerCase(),
                            data: {
                                id: {{ $client->id }},
                                name: "{{ $client->trade_name }}",
                                status: "{{ $statusColor }}",

                                phone: "{{ $client->phone }}",
                                region: "{{ $client->Neighborhoodname->Region->name ?? '' }}",
                                balance: "{{ $client->Balance() }}"
                            }
                        });

                        marker{{ $client->id }}.addListener('click', () => {
                            showClientInfo(allMarkers.find(m => m.marker === marker{{ $client->id }}));
                        });
                    @endif
                @endif
            @endforeach

            // إضافة ماركر موقع المستخدم
            @if (isset($userLocation))
                var userLocation = {
                    lat: parseFloat('{{ $userLocation->latitude }}'),
                    lng: parseFloat('{{ $userLocation->longitude }}')
                };

                // إضافة ماركر موقع المستخدم
                const userMarker = new google.maps.Marker({
                    position: userLocation,
                    map: map,
                    icon: {
                        path: google.maps.SymbolPath.CIRCLE,
                        scale: 10,
                        fillColor: '#2196F3',
                        fillOpacity: 1,
                        strokeColor: '#ffffff',
                        strokeWeight: 2
                    },
                    title: 'موقعك الحالي'
                });

                // إضافة دائرة حول موقع المستخدم
                const userCircle = new google.maps.Circle({
                    strokeColor: '#2196F3',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: '#2196F3',
                    fillOpacity: 0.1,
                    map: map,
                    center: userLocation,
                    radius: 300 // نصف قطر 300 متر
                });
            @endif

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
                map.setCenter({
                    lat: 24.7136,
                    lng: 46.6753
                });
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


    <script>
        $(document).ready(function() {
            $('#searchInput').on('keyup', function() {
                var value = $(this).val().toLowerCase();

                $('.client-card').filter(function() {
                    // تبحث داخل الاسم أو رقم الهاتف أو الاسم الأول
                    var content = $(this).text().toLowerCase();
                    $(this).toggle(content.indexOf(value) > -1);
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // منع السلوك الافتراضي للنقر على روابط التصفح
            document.querySelectorAll('.pagination-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    loadPage(this.href);
                });
            });

            // دالة لجلب المحتوى عبر AJAX
            function loadPage(url) {
                fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        // هنا يمكنك تحديث الجزء المطلوب من الصفحة
                        // مثلاً إذا كان الجدول في div معين:
                        document.getElementById('clients-container').innerHTML = html;

                        // تحديث عنوان URL في المتصفح دون إعادة تحميل الصفحة
                        history.pushState(null, null, url);
                    })
                    .catch(error => console.error('Error:', error));
            }

            // التعامل مع زر الرجوع في المتصفح
            window.addEventListener('popstate', function() {
                loadPage(window.location.href);
            });
        });
    </script>


@stop
