@extends('master')

@section('title')
    ادارة الفواتير المرتجعة
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-start mb-0">الفواتير المرتجعة</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                            <li class="breadcrumb-item active">عرض</li>
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
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <!-- مربع اختيار الكل -->


                        <!-- المجموعة الأفقية: Combobox و Dropdown -->
                        <div class="d-flex align-items-center">


                            <!-- Dropdown -->
                            <div class="dropdown">
                                <button class="btn bg-gradient-info dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    الإجراءات
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" href="#">خيار 1</a></li>
                                    <li><a class="dropdown-item" href="#">خيار 2</a></li>
                                    <li><a class="dropdown-item" href="#">خيار 3</a></li>
                                </ul>
                            </div>
                        </div>

                        <!-- الجزء الخاص بالتصفح -->
                        <div class="d-flex align-items-center">
                            <!-- زر الصفحة السابقة -->
                            <button class="btn btn-outline-secondary btn-sm" aria-label="الصفحة السابقة">
                                <i class="fa fa-angle-right"></i>
                            </button>

                            <!-- أرقام الصفحات -->
                            <nav class="mx-2">
                                <ul class="pagination pagination-sm mb-0">
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item active"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                                    <li class="page-item"><a class="page-link" href="#">5</a></li>
                                </ul>
                            </nav>

                            <!-- زر الصفحة التالية -->
                            <button class="btn btn-outline-secondary btn-sm" aria-label="الصفحة التالية">
                                <i class="fa fa-angle-left"></i>
                            </button>
                        </div>

                        <!-- الأزرار الإضافية -->


                        <a href="{{ route('appointments.index') }}"
                            class="btn btn-outline-primary btn-sm d-flex align-items-center">
                            <i class="fa fa-calendar-alt me-2"></i>المواعيد
                        </a>
                    </div>
                </div>

            </div>

            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <h4 class="card-title">بحث</h4>
                    </div>

                    <div class="card-body">
                        <form class="form" method="GET" action="{{ route('invoices.index') }}">
                            <div class="form-body row">
                                <!-- 1. العميل -->
                                <div class="form-group col-md-4">
                                    <label for="client_id">أي العميل</label>
                                    <select name="client_id" class="form-control" id="client_id">
                                        <option value="">أي العميل</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}"
                                                {{ request('client_id') == $client->id ? 'selected' : '' }}>
                                                {{ $client->first_name }} {{ $client->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- 2. رقم الفاتورة -->
                                <div class="form-group col-md-4">
                                    <label for="invoice_number">رقم الفاتورة</label>
                                    <input type="text" id="invoice_number" class="form-control"
                                        placeholder="رقم الفاتورة" name="invoice_number"
                                        value="{{ request('invoice_number') }}">
                                </div>

                                <!-- 3. حالة الفاتورة -->
                                <div class="form-group col-md-4">
                                    <label for="status">حالة الفاتورة</label>
                                    <select name="status" class="form-control" id="status">
                                        <option value="">الحالة</option>
                                        <option value="1" {{ request('status') == 1 ? 'selected' : '' }}>غير مدفوعة
                                        </option>
                                        <option value="2" {{ request('status') == 2 ? 'selected' : '' }}>مدفوعة جزئيًا
                                        </option>
                                        <option value="3" {{ request('status') == 3 ? 'selected' : '' }}>مدفوعة
                                            بالكامل</option>
                                        <option value="4" {{ request('status') == 4 ? 'selected' : '' }}>مرتجع
                                        </option>
                                        <option value="5" {{ request('status') == 5 ? 'selected' : '' }}>مرتجع جزئي
                                        </option>
                                        <option value="6" {{ request('status') == 6 ? 'selected' : '' }}>مدفوع بزيادة
                                        </option>
                                        <option value="7" {{ request('status') == 7 ? 'selected' : '' }}>مستحقة الدفع
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <!-- البحث المتقدم -->
                            <div class="collapse" id="advancedSearchForm">

                                <div class="form-body row d-flex align-items-center g-0">
                                    <!-- 4. البند -->
                                    <div class="form-group col-md-4">
                                        <label for="item">البند</label>
                                        <input type="text" id="item" class="form-control"
                                            placeholder="تحتوي على البند" name="item" value="{{ request('item') }}">
                                    </div>

                                    <!-- 5. العملة -->
                                    <div class="form-group col-md-4">
                                        <label for="currency">العملة</label>
                                        <select name="currency" class="form-control" id="currency">
                                            <option value="">العملة</option>
                                            <option value="SAR" {{ request('currency') == 'SAR' ? 'selected' : '' }}>
                                                SAR</option>
                                            <option value="USD" {{ request('currency') == 'USD' ? 'selected' : '' }}>
                                                USD</option>
                                        </select>
                                    </div>

                                    <!-- 6. الإجمالي (من) -->
                                    <div class="form-group col-md-2">
                                        <label for="total_from">الإجمالي أكبر من</label>
                                        <input type="text" id="total_from" class="form-control"
                                            placeholder="الإجمالي أكبر من" name="total_from"
                                            value="{{ request('total_from') }}">
                                    </div>

                                    <!-- 7. الإجمالي (إلى) -->
                                    <div class="form-group col-md-2">
                                        <label for="total_to">الإجمالي أصغر من</label>
                                        <input type="text" id="total_to" class="form-control"
                                            placeholder="الإجمالي أصغر من" name="total_to"
                                            value="{{ request('total_to') }}">
                                    </div>
                                </div>

                                <!-- 8. حالة الدفع -->
                                <div class="form-body row d-flex align-items-center g-0">
                                    <div class="form-group col-md-4">
                                        <label for="payment_status">حالة الدفع</label>
                                        <select name="payment_status" class="form-control" id="payment_status">
                                            <option value="">حالة الدفع</option>
                                            <option value="1" {{ request('payment_status') == 1 ? 'selected' : '' }}>
                                                غير مدفوعة</option>
                                            <option value="2" {{ request('payment_status') == 2 ? 'selected' : '' }}>
                                                مدفوعة جزئيًا</option>
                                            <option value="3" {{ request('payment_status') == 3 ? 'selected' : '' }}>
                                                مدفوعة بالكامل</option>
                                        </select>
                                    </div>

                                    <!-- 9. التخصيص (شهريًا، أسبوعيًا، يوميًا) -->
                                    <div class="form-group col-md-2">
                                        <label for="custom_period">التخصيص</label>
                                        <select name="custom_period" class="form-control" id="custom_period">
                                            <option value="">التخصيص</option>
                                            <option value="monthly"
                                                {{ request('custom_period') == 'monthly' ? 'selected' : '' }}>شهريًا
                                            </option>
                                            <option value="weekly"
                                                {{ request('custom_period') == 'weekly' ? 'selected' : '' }}>أسبوعيًا
                                            </option>
                                            <option value="daily"
                                                {{ request('custom_period') == 'daily' ? 'selected' : '' }}>يوميًا</option>
                                        </select>
                                    </div>

                                    <!-- 10. التاريخ (من) -->
                                    <div class="form-group col-md-3">
                                        <label for="from_date">التاريخ من</label>
                                        <input type="date" id="from_date" class="form-control" name="from_date"
                                            value="{{ request('from_date') }}">
                                    </div>

                                    <!-- 11. التاريخ (إلى) -->
                                    <div class="form-group col-md-3">
                                        <label for="to_date">التاريخ إلى</label>
                                        <input type="date" id="to_date" class="form-control" name="to_date"
                                            value="{{ request('to_date') }}">
                                    </div>
                                </div>
                                <!-- 12. تخصيص آخر -->
                                <div class="form-body row d-flex align-items-center g-0">
                                    <div class="form-group col-md-2">
                                        <label for="custom_period_2">التخصيص</label>
                                        <select name="custom_period_2" class="form-control" id="custom_period_2">
                                            <option value="">التخصيص</option>
                                            <option value="monthly"
                                                {{ request('custom_period_2') == 'monthly' ? 'selected' : '' }}>شهريًا
                                            </option>
                                            <option value="weekly"
                                                {{ request('custom_period_2') == 'weekly' ? 'selected' : '' }}>أسبوعيًا
                                            </option>
                                            <option value="daily"
                                                {{ request('custom_period_2') == 'daily' ? 'selected' : '' }}>يوميًا
                                            </option>
                                        </select>
                                    </div>

                                    <!-- 13. تاريخ الاستحقاق (من) -->
                                    <div class="form-group col-md-3">
                                        <label for="due_date_from">تاريخ الاستحقاق (من)</label>
                                        <input type="date" id="due_date_from" class="form-control"
                                            name="due_date_from" value="{{ request('due_date_from') }}">
                                    </div>

                                    <!-- 14. تاريخ الاستحقاق (إلى) -->
                                    <div class="form-group col-md-3">
                                        <label for="due_date_to">تاريخ الاستحقاق (إلى)</label>
                                        <input type="date" id="due_date_to" class="form-control" name="due_date_to"
                                            value="{{ request('due_date_to') }}">
                                    </div>

                                    <!-- 15. المصدر -->
                                    <div class="form-group col-md-4">
                                        <label for="source">المصدر</label>
                                        <select name="source" class="form-control" id="source">
                                            <option value="">المصدر</option>
                                            <option value="mobile" {{ request('source') == 'mobile' ? 'selected' : '' }}>
                                                تطبيق الهاتف</option>
                                            <option value="web" {{ request('source') == 'web' ? 'selected' : '' }}>
                                                الويب</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- 16. الحقل المخصص -->
                                <div class="form-body row d-flex align-items-center g-0">
                                    <div class="form-group col-4">
                                        <label for="custom_field">حقل مخصص</label>
                                        <input type="text" id="custom_field" class="form-control"
                                            placeholder="حقل مخصص" name="custom_field"
                                            value="{{ request('custom_field') }}">
                                    </div>

                                    <!-- 17. تخصيص آخر -->
                                    <div class="form-group col-md-2">
                                        <label for="custom_period_3">التخصيص</label>
                                        <select name="custom_period_3" class="form-control" id="custom_period_3">
                                            <option value="">التخصيص</option>
                                            <option value="monthly"
                                                {{ request('custom_period_3') == 'monthly' ? 'selected' : '' }}>شهريًا
                                            </option>
                                            <option value="weekly"
                                                {{ request('custom_period_3') == 'weekly' ? 'selected' : '' }}>أسبوعيًا
                                            </option>
                                            <option value="daily"
                                                {{ request('custom_period_3') == 'daily' ? 'selected' : '' }}>يوميًا
                                            </option>
                                        </select>
                                    </div>

                                    <!-- 18. تاريخ الإنشاء (من) -->
                                    <div class="form-group col-3">
                                        <label for="created_at_from">تاريخ الإنشاء (من)</label>
                                        <input type="date" id="created_at_from" class="form-control"
                                            name="created_at_from" value="{{ request('created_at_from') }}">
                                    </div>

                                    <!-- 19. تاريخ الإنشاء (إلى) -->
                                    <div class="form-group col-3">
                                        <label for="created_at_to">تاريخ الإنشاء (إلى)</label>
                                        <input type="date" id="created_at_to" class="form-control"
                                            name="created_at_to" value="{{ request('created_at_to') }}">
                                    </div>
                                </div>
                                <div class="form-body row d-flex align-items-center g-0">
                                    <!-- 20. حالة التسليم -->
                                    <div class="form-group col-md-4">
                                        <label for="delivery_status">حالة التسليم</label>
                                        <select name="delivery_status" class="form-control" id="delivery_status">
                                            <option value="">حالة التسليم</option>
                                            <option value="delivered"
                                                {{ request('delivery_status') == 'delivered' ? 'selected' : '' }}>تم
                                                التسليم</option>
                                            <option value="pending"
                                                {{ request('delivery_status') == 'pending' ? 'selected' : '' }}>قيد
                                                الانتظار</option>
                                        </select>
                                    </div>

                                    <!-- 21. أضيفت بواسطة (الموظفين) -->
                                    <div class="form-group col-md-4">
                                        <label for="added_by_employee">أضيفت بواسطة (الموظفين)</label>
                                        <select name="added_by_employee" class="form-control" id="added_by_employee">
                                            <option value="">أضيفت بواسطة</option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}"
                                                    {{ request('added_by_employee') == $employee->id ? 'selected' : '' }}>
                                                    {{ $employee->full_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- 22. مسؤول المبيعات (المستخدمين) -->
                                    <div class="form-group col-md-4">
                                        <label for="sales_person_user">مسؤول المبيعات (المستخدمين)</label>
                                        <select name="sales_person_user" class="form-control" id="sales_person_user">
                                            <option value="">مسؤول المبيعات</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}"
                                                    {{ request('sales_person_user') == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-body row d-flex align-items-center g-0">
                                    <!-- 23. Post Shift -->
                                    <div class="form-group col-md-4">
                                        <label for="post_shift">Post Shift</label>
                                        <input type="text" id="post_shift" class="form-control"
                                            placeholder="Post Shift" name="post_shift"
                                            value="{{ request('post_shift') }}">
                                    </div>

                                    <!-- 24. خيارات الشحن -->
                                    <div class="form-group col-md-4">
                                        <label for="shipping_option">خيارات الشحن</label>
                                        <select name="shipping_option" class="form-control" id="shipping_option">
                                            <option value="">خيارات الشحن</option>
                                            <option value="standard"
                                                {{ request('shipping_option') == 'standard' ? 'selected' : '' }}>عادي
                                            </option>
                                            <option value="express"
                                                {{ request('shipping_option') == 'express' ? 'selected' : '' }}>سريع
                                            </option>
                                        </select>
                                    </div>

                                    <!-- 25. مصدر الطلب -->
                                    <div class="form-group col-md-4">
                                        <label for="order_source">مصدر الطلب</label>
                                        <select name="order_source" class="form-control" id="order_source">
                                            <option value="">مصدر الطلب</option>
                                            <option value="website"
                                                {{ request('order_source') == 'website' ? 'selected' : '' }}>الموقع
                                            </option>
                                            <option value="mobile_app"
                                                {{ request('order_source') == 'mobile_app' ? 'selected' : '' }}>تطبيق
                                                الهاتف</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- الأزرار -->
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary mr-1 waves-effect waves-light">بحث</button>
                                <a class="btn btn-outline-secondary ml-2 mr-2" data-toggle="collapse"
                                    data-target="#advancedSearchForm">
                                    <i class="bi bi-sliders"></i> بحث متقدم
                                </a>
                                <button type="reset"
                                    class="btn btn-outline-warning waves-effect waves-light">إلغاء</button>
                            </div>
                        </form>

                    </div>

                </div>

            </div>
            <div class="card">
                <!-- الترويسة -->
                <div class="card-header d-flex justify-content-between align-items-center p-3">
                    <div class="d-flex gap-2 flex-wrap">
                        <button class="btn btn-sm btn-outline-primary {{ request()->status == null ? 'active' : '' }}"
                            onclick="filterInvoices('')">
                            <i class="fas fa-list me-1"></i> الكل
                        </button>
                        <button class="btn btn-sm btn-outline-warning {{ request()->status == 'late' ? 'active' : '' }}"
                            onclick="filterInvoices('late')">
                            <i class="fas fa-clock me-1"></i> متأخر
                        </button>
                        <button class="btn btn-sm btn-outline-info {{ request()->status == 'due' ? 'active' : '' }}"
                            onclick="filterInvoices('due')">
                            <i class="fas fa-calendar-day me-1"></i> مستحقة الدفع
                        </button>
                        <button class="btn btn-sm btn-outline-danger {{ request()->status == 'unpaid' ? 'active' : '' }}"
                            onclick="filterInvoices('unpaid')">
                            <i class="fas fa-times-circle me-1"></i> غير مدفوع
                        </button>
                        <button class="btn btn-sm btn-outline-secondary {{ request()->status == 'draft' ? 'active' : '' }}"
                            onclick="filterInvoices('draft')">
                            <i class="fas fa-file-alt me-1"></i> مسودة
                        </button>
                        <button class="btn btn-sm btn-outline-success {{ request()->status == 'overpaid' ? 'active' : '' }}"
                            onclick="filterInvoices('overpaid')">
                            <i class="fas fa-check-double me-1"></i> مدفوع بزيادة
                        </button>
                    </div>
                </div>

                <!-- قائمة الفواتير -->
                @foreach ($return as $retur)
                @if ($retur->type == 'returned')
                        <div class="card-body invoice-card">
                            <div class="row border-bottom py-2 align-items-center">
                                <!-- معلومات الفاتورة -->
                                <div class="col-md-4">
                                    <p class="mb-0">
                                        <strong>#{{ $retur->code }}</strong>
                                    </p>
                                    <small class="text-muted">
                                        <i class="fas fa-user me-1"></i>
                                        {{ $retur->client ? ($retur->client->trade_name ?: $retur->client->first_name . ' ' . $retur->client->last_name) : 'عميل غير معروف' }}
                                        @if ($retur->client && $retur->client->tax_number)
                                            <br><i class="fas fa-hashtag me-1"></i>الرقم الضريبي: {{ $retur->client->tax_number }}
                                        @endif
                                    </small>
                                    @if ($retur->client && $retur->client->full_address)
                                        <small class="d-block">
                                            <i class="fas fa-map-marker-alt me-1"></i>{{ $retur->client->full_address }}
                                        </small>
                                    @endif
                                </div>

                                <!-- تاريخ الفاتورة -->
                                <div class="col-md-3">
                                    <p class="mb-0">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        {{ $retur->created_at ? $retur->created_at->format('H:i:s d/m/Y') : '' }}
                                    </p>
                                    <small class="text-muted">
                                        <i class="fas fa-user me-1"></i> بواسطة:
                                        {{ $retur->createdByUser->name ?? 'غير محدد' }}
                                    </small>
                                    <small class="d-block text-muted">
                                        <i class="fas fa-mobile-alt me-1"></i> المصدر: تطبيق الهاتف المحمول
                                    </small>
                                </div>

                                <!-- المبلغ وحالة الدفع -->
                                <div class="col-md-3 text-center">
                                    <h5 class="mb-1 font-weight-bold">
                                        {{ number_format($retur->grand_total ?? $retur->total, 2) }}
                                        {{ $retur->currency ?? 'SAR' }}
                                    </h5>

                                    @if($retur->due_value > 0)
                                        <small class="d-block mb-2 text-danger">
                                            المبلغ المستحق: {{ number_format($retur->due_value, 2) }} {{ $retur->currency ?? 'SAR' }}
                                        </small>
                                    @endif

                                    @php
                                        $statusClass = '';
                                        $statusText = '';

                                        if ($retur->payment_status == 1) {
                                            $statusClass = 'badge-success';
                                            $statusText = 'مدفوعة بالكامل';
                                        } elseif ($retur->payment_status == 2) {
                                            $statusClass = 'badge-info';
                                            $statusText = 'مدفوعة جزئياً';
                                        } elseif ($retur->payment_status == 3) {
                                            $statusClass = 'badge-danger';
                                            $statusText = 'غير مدفوعة';
                                        } elseif ($retur->payment_status == 4) {
                                            $statusClass = 'badge-secondary';
                                            $statusText = 'مستلمة';
                                        } else {
                                            $statusClass = 'badge-dark';
                                            $statusText = 'غير معروفة';
                                        }
                                    @endphp

                                    <span class="badge {{ $statusClass }}">{{ $statusText }}</span>
                                </div>

                                <!-- الأزرار -->
                                <div class="col-md-2 text-end">
                                    <div class="btn-group">
                                        <div class="dropdown">
                                            <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1" type="button"
                                                id="dropdownMenuButton{{ $retur->id }}" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="dropdownMenuButton{{ $retur->id }}">
                                                <a class="dropdown-item" href="{{ route('invoices.edit', $retur->id) }}">
                                                    <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                </a>
                                                <a class="dropdown-item" href="{{ route('invoices.show', $retur->id) }}">
                                                    <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                </a>
                                                <a class="dropdown-item" href="{{ route('invoices.generatePdf', $retur->id) }}">
                                                    <i class="fa fa-file-pdf me-2 text-danger"></i>PDF
                                                </a>
                                                <a class="dropdown-item" href="{{ route('invoices.generatePdf', $retur->id) }}">
                                                    <i class="fa fa-print me-2 text-dark"></i>طباعة
                                                </a>
                                                <a class="dropdown-item" href="#">
                                                    <i class="fa fa-envelope me-2 text-warning"></i>إرسال إلى العميل
                                                </a>
                                                <a class="dropdown-item"
                                                    href="{{ route('paymentsClient.create', ['id' => $retur->id]) }}">
                                                    <i class="fa fa-credit-card me-2 text-info"></i>إضافة عملية دفع
                                                </a>
                                                <a class="dropdown-item" href="#">
                                                    <i class="fa fa-copy me-2 text-secondary"></i>نسخ
                                                </a>
                                                <form action="{{ route('invoices.destroy', $retur->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="fa fa-trash me-2"></i>حذف
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- عمليات الدفع -->
                            @php
                                $payments = \App\Models\PaymentsProcess::where('invoice_id', $retur->id)
                                    ->where('type', 'client payments')
                                    ->orderBy('created_at', 'desc')
                                    ->get();
                            @endphp

                            @if($payments->count() > 0)
                                <div class="payment-history mt-2">
                                    <div class="ps-4">
                                        <small class="text-muted mb-2 d-block">
                                            <i class="fas fa-money-bill-wave me-1"></i> عمليات الدفع:
                                        </small>
                                        @foreach($payments as $payment)
                                            <div class="d-flex align-items-center gap-3 mb-1 payment-item ps-3">
                                                <div class="payment-info">
                                                    <small class="text-muted">
                                                        <i class="fas fa-calendar-alt me-1"></i>
                                                        {{ $payment->created_at->format('H:i:s d/m/Y') }}
                                                    </small>
                                                    <span class="mx-2 text-success">

                                                        {{ number_format($payment->amount, 2) }} {{ $retur->currency ?? 'SAR' }}
                                                    </span>
                                                    @if($payment->attachments)
                                                        <i class="fas fa-paperclip text-muted"></i>
                                                    @endif
                                                    <small class="text-muted">
                                                        <i class="fas fa-user me-1"></i>
                                                        بواسطة:   {{ $retur->createdByUser->name ?? 'غير محدد' }}
                                                    </small>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                @endforeach

                <!-- إذا لم تكن هناك فواتير -->
                @if ($return->isEmpty())
                    <div class="alert alert-warning m-3" role="alert">
                        <p class="mb-0"><i class="fas fa-exclamation-circle me-2"></i>لا توجد فواتير</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        function filterInvoices(status) {
            const currentUrl = new URL(window.location.href);
            if (status) {
                currentUrl.searchParams.set('status', status);
            } else {
                currentUrl.searchParams.delete('status');
            }
            window.location.href = currentUrl.toString();
        }
    </script>
@endsection
