@extends('master')

@section('title')
    ادارة عروض السعر
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">ادارة عروض السعر </h2>
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
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="content-body">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <!-- Checkbox لتحديد الكل -->
                    <div class="form-check me-3">
                        <input class="form-check-input" type="checkbox" id="selectAll" onclick="toggleSelectAll()">
                    </div>

                    <!-- زر عرض سعر جديد -->
                    <a href="{{ route('questions.create') }}" class="btn btn-success btn-sm d-flex align-items-center rounded-pill px-3">
                        <i class="fas fa-plus-circle me-1"></i>عرض سعر جديد
                    </a>

                    <!-- زر المواعيد -->
                    <a href="{{ route('appointments.index') }}" class="btn btn-outline-primary btn-sm d-flex align-items-center rounded-pill px-3">
                        <i class="fas fa-calendar-alt me-1"></i>المواعيد
                    </a>

                    <!-- زر استيراد -->
                    <a href="{{ route('questions.logsaction') }}" class="btn btn-outline-primary btn-sm d-flex align-items-center rounded-pill px-3">
                        <i class="fas fa-cloud-upload-alt me-1"></i>استيراد
                    </a>

                    <!-- جزء التنقل بين الصفحات -->
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm mb-0">
                            <!-- زر الانتقال إلى أول صفحة -->
                            @if ($quotes->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link border-0 rounded-pill" aria-label="First">
                                        <i class="fas fa-angle-double-right"></i>
                                    </span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link border-0 rounded-pill" href="{{ $quotes->url(1) }}" aria-label="First">
                                        <i class="fas fa-angle-double-right"></i>
                                    </a>
                                </li>
                            @endif

                            <!-- زر الانتقال إلى الصفحة السابقة -->
                            @if ($quotes->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link border-0 rounded-pill" aria-label="Previous">
                                        <i class="fas fa-angle-right"></i>
                                    </span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link border-0 rounded-pill" href="{{ $quotes->previousPageUrl() }}" aria-label="Previous">
                                        <i class="fas fa-angle-right"></i>
                                    </a>
                                </li>
                            @endif

                            <!-- عرض رقم الصفحة الحالية -->
                            <li class="page-item">
                                <span class="page-link border-0 bg-light rounded-pill px-3">
                                    صفحة {{ $quotes->currentPage() }} من {{ $quotes->lastPage() }}
                                </span>
                            </li>

                            <!-- زر الانتقال إلى الصفحة التالية -->
                            @if ($quotes->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link border-0 rounded-pill" href="{{ $quotes->nextPageUrl() }}" aria-label="Next">
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
                            @if ($quotes->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link border-0 rounded-pill" href="{{ $quotes->url($quotes->lastPage()) }}" aria-label="Last">
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
                <form id="searchForm" action="{{ route('questions.index') }}" method="GET" class="form">
                    <div class="row g-3">
                        <!-- 1. العميل -->
                        <div class="col-md-4">
                            <label for="clientSelect">العميل</label>
                            <select name="client_id" class="form-control select2" id="clientSelect">
                                <option value="">اي العميل</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                                        {{ $client->trade_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- 2. رقم عرض السعر -->
                        <div class="col-md-4">
                            <label for="feedback2">رقم عرض السعر</label>
                            <input type="text" id="feedback2" class="form-control"
                                placeholder="رقم عرض السعر" name="id" value="{{ request('id') }}">
                        </div>

                        <!-- 3. الحالة -->
                        <div class="col-md-4">
                            <label for="statusSelect">الحالة</label>
                            <select name="status" class="form-control" id="statusSelect">
                                <option value="">الحالة</option>
                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>مفتوح</option>
                                <option value="2" {{ request('status') == '2' ? 'selected' : '' }}> مغلق</option>
                            </select>
                        </div>
                    </div>

                    <!-- البحث المتقدم -->
                    <div class="collapse {{ request()->hasAny(['currency', 'total_from', 'total_to', 'date_type_1', 'date_type_2', 'item_search', 'created_by', 'sales_representative']) ? 'show' : '' }}" id="advancedSearchForm">
                        <div class="row g-3 mt-2">
                            <!-- 4. العملة -->
                            <div class="col-md-4">
                                <label for="currencySelect">العملة</label>
                                <select name="currency" class="form-control" id="currencySelect">
                                    <option value="">العملة</option>
                                    <option value="SAR" {{ request('currency') == 'SAR' ? 'selected' : '' }}>ريال سعودي</option>
                                    <option value="USD" {{ request('currency') == 'USD' ? 'selected' : '' }}>دولار أمريكي</option>
                                </select>
                            </div>

                            <!-- 5. الإجمالي أكبر من -->
                            <div class="col-md-2">
                                <label for="total_from">الإجمالي أكبر من</label>
                                <input type="number" class="form-control" placeholder="الإجمالي أكبر من"
                                    name="total_from" step="0.01" value="{{ request('total_from') }}">
                            </div>

                            <!-- 6. الإجمالي أصغر من -->
                            <div class="col-md-2">
                                <label for="total_to">الإجمالي أصغر من</label>
                                <input type="number" class="form-control" placeholder="الإجمالي أصغر من"
                                    name="total_to" step="0.01" value="{{ request('total_to') }}">
                            </div>

                            <!-- 7. الحالة -->

                        </div>

                        <div class="row g-3 mt-2">
                            <!-- 8. التخصيص -->
                            <div class="col-md-2">
                                <label for="date_type_1">التخصيص</label>
                                <select name="date_type_1" class="form-control">
                                    <option value="">تخصيص</option>
                                    <option value="monthly" {{ request('date_type_1') == 'monthly' ? 'selected' : '' }}>شهرياً</option>
                                    <option value="weekly" {{ request('date_type_1') == 'weekly' ? 'selected' : '' }}>أسبوعياً</option>
                                    <option value="daily" {{ request('date_type_1') == 'daily' ? 'selected' : '' }}>يومياً</option>
                                </select>
                            </div>

                            <!-- 9. التاريخ من -->
                            <div class="col-md-2">
                                <label for="from_date_1">التاريخ من</label>
                                <input type="date" class="form-control" placeholder="من"
                                    name="from_date_1" value="{{ request('from_date_1') }}">
                            </div>

                            <!-- 10. التاريخ إلى -->
                            <div class="col-md-2">
                                <label for="to_date_1">التاريخ إلى</label>
                                <input type="date" class="form-control" placeholder="إلى"
                                    name="to_date_1" value="{{ request('to_date_1') }}">
                            </div>

                            <!-- 11. التخصيص -->
                            <div class="col-md-2">
                                <label for="date_type_2">التخصيص</label>
                                <select name="date_type_2" class="form-control">
                                    <option value="">تخصيص</option>
                                    <option value="monthly" {{ request('date_type_2') == 'monthly' ? 'selected' : '' }}>شهرياً</option>
                                    <option value="weekly" {{ request('date_type_2') == 'weekly' ? 'selected' : '' }}>أسبوعياً</option>
                                    <option value="daily" {{ request('date_type_2') == 'daily' ? 'selected' : '' }}>يومياً</option>
                                </select>
                            </div>

                            <!-- 12. تاريخ الإنشاء من -->
                            <div class="col-md-2">
                                <label for="from_date_2">تاريخ الإنشاء من</label>
                                <input type="date" class="form-control" placeholder="من"
                                    name="from_date_2" value="{{ request('from_date_2') }}">
                            </div>

                            <!-- 13. تاريخ الإنشاء إلى -->
                            <div class="col-md-2">
                                <label for="to_date_2">تاريخ الإنشاء إلى</label>
                                <input type="date" class="form-control" placeholder="إلى"
                                    name="to_date_2" value="{{ request('to_date_2') }}">
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <!-- 14. تحتوي على البند -->
                            <div class="col-md-4">
                                <label for="item_search">تحتوي على البند</label>
                                <input type="text" class="form-control" placeholder="تحتوي على البند"
                                    name="item_search" value="{{ request('item_search') }}">
                            </div>

                            <!-- 15. أضيفت بواسطة -->
                            <div class="col-md-4">
                                <label for="created_by">أضيفت بواسطة</label>
                                <select name="created_by" class="form-control select2">
                                    <option value="">أضيفت بواسطة</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}" {{ request('created_by') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- 16. مسؤول المبيعات -->
                            <div class="col-md-4">
                                <label for="sales_representative">مسؤول المبيعات</label>
                                <select name="sales_representative" class="form-control select2">
                                    <option value="">مسؤول المبيعات</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ request('sales_representative') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>

                    <!-- الأزرار -->
                    <div class="form-actions mt-2">
                        <button type="submit" class="btn btn-primary">بحث</button>
                        <a href="{{ route('questions.index') }}" type="reset" class="btn btn-outline-warning">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th width="25%">العرض</th>
                                <th width="20%">العميل</th>
                                <th width="15%">التاريخ</th>
                                <th width="15%" class="text-center">المبلغ</th>
                                <th width="15%" class="text-center">الحالة</th>
                                <th width="10%" class="text-end">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($quotes as $quote)
                                <tr>
                                    <!-- معلومات العرض -->
                                    <td>
                                        <div class="d-flex flex-column">
                                            <strong>#{{ $quote->id }}</strong>
                                            <small class="text-muted">
                                                <i class="fas fa-user-tie me-1"></i>
                                                {{ $quote->creator->name ?? 'غير محدد' }}
                                            </small>
                                            <small class="text-muted">
                                                <i class="fas fa-mobile-alt me-1"></i> تطبيق الهاتف
                                            </small>
                                        </div>
                                    </td>

                                    <!-- معلومات العميل -->
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span>{{ $quote->client ? ($quote->client->trade_name ?: $quote->client->first_name . ' ' . $quote->client->last_name) : 'عميل غير معروف' }}</span>
                                            @if($quote->client)
                                                <small class="text-muted">
                                                    <i class="fas fa-hashtag me-1"></i>
                                                    {{ $quote->client->tax_number ?? 'لا يوجد' }}
                                                </small>
                                                @if($quote->client->full_address)
                                                    <small class="text-muted">
                                                        <i class="fas fa-map-marker-alt me-1"></i>
                                                        {{ Str::limit($quote->client->full_address, 30) }}
                                                    </small>
                                                @endif
                                            @endif
                                        </div>
                                    </td>

                                    <!-- التاريخ -->
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span>{{ $quote->created_at ? $quote->created_at->format('d/m/Y') : '' }}</span>
                                            <small class="text-muted">
                                                {{ $quote->created_at ? $quote->created_at->format('H:i:s') : '' }}
                                            </small>
                                        </div>
                                    </td>

                                    <!-- المبلغ -->
                                    <td class="text-center">
                                        @php
                                            $currency = $account_setting->currency ?? 'SAR';
                                            $currencySymbol = $currency == 'SAR' || empty($currency) ? '<img src="' . asset('assets/images/Saudi_Riyal.svg') . '" alt="ريال سعودي" width="15" style="vertical-align: middle;">' : $currency;
                                        @endphp
                                        <strong class="text-danger">
                                            {{ number_format($quote->grand_total ?? $quote->total, 2) }}
                                            <small class="currency">{!! $currencySymbol !!}</small>
                                        </strong>
                                    </td>

                                    <!-- الحالة -->
                                    <td class="text-center">
                                        @php
                                            $statusClass = $quote->status == 1 ? 'bg-success' : 'bg-info';
                                            $statusText = $quote->status == 1 ? 'مفتوح' : 'مغلق';
                                        @endphp
                                        <span class="badge {{ $statusClass }} p-2 rounded-pill">
                                            <i class="fas fa-circle me-1"></i> {{ $statusText }}
                                        </span>
                                    </td>

                                    <!-- الإجراءات -->
                                    <td class="text-end">
                                        <div class="dropdown">
                                            <button class="btn btn-sm bg-gradient-info dropdown-toggle" type="button"
                                                    id="dropdownMenuButton{{ $quote->id }}" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton{{ $quote->id }}">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('questions.edit', $quote->id) }}">
                                                        <i class="fas fa-edit me-2 text-success"></i>تعديل
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('questions.show', $quote->id) }}">
                                                        <i class="fas fa-eye me-2 text-primary"></i>عرض
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('questions.create', ['id' => $quote->id]) }}">
                                                        <i class="fas fa-money-bill me-2 text-success"></i>إضافة دفعة
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="fas fa-file-pdf me-2 text-danger"></i>PDF
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="fas fa-print me-2 text-dark"></i>طباعة
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="fas fa-envelope me-2 text-warning"></i>إرسال للعميل
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="fas fa-copy me-2 text-secondary"></i>نسخ
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('questions.destroy', $quote->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="fas fa-trash me-2"></i>حذف
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="alert alert-warning mb-0">
                                            <i class="fas fa-exclamation-circle me-2"></i>لا توجد عروض أسعار
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('scripts')
<script src="{{ asset('assets/js/search.js') }}"></script>
@endsection
