@extends('master')


@section('title')
    الفواتير
@stop

@section('css')


<link rel="stylesheet" href="{{ asset('assets/css/invoice.css') }}">
@endsection
    @section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-start mb-0">الفواتير</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                            <li class="breadcrumb-item active">الفواتير</li>
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



                        </div>

                        <!-- الجزء الخاص بالتصفح -->
                        <div class="d-flex align-items-center">
                            <!-- زر الصفحة السابقة -->
                            <button class="btn btn-outline-secondary btn-sm" aria-label="الصفحة السابقة">
                                <i class="fa fa-angle-right"></i>
                            </button>


                            <!-- زر الصفحة التالية -->
                            <button class="btn btn-outline-secondary btn-sm" aria-label="الصفحة التالية">
                                <i class="fa fa-angle-left"></i>
                            </button>
                        </div>

                        <!-- الأزرار الإضافية -->
                        <a href="{{ route('invoices.create') }}" class="btn btn-success btn-sm d-flex align-items-center">
                            <i class="fa fa-plus me-2"></i>فاتورة جديدة
                        </a>

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
                        <button
                            class="btn btn-sm btn-outline-secondary {{ request()->status == 'draft' ? 'active' : '' }}"
                            onclick="filterInvoices('draft')">
                            <i class="fas fa-file-alt me-1"></i> مسودة
                        </button>
                        <button
                            class="btn btn-sm btn-outline-success {{ request()->status == 'overpaid' ? 'active' : '' }}"
                            onclick="filterInvoices('overpaid')">
                            <i class="fas fa-check-double me-1"></i> مدفوع بزيادة
                        </button>
                    </div>
                </div>

                <!-- قائمة الفواتير -->
                <div class="table-responsive">
                    <table class="table table-hover custom-table">
                        <thead>
                            <tr class="bg-gradient-light">
                                <th class="border-start">رقم الفاتورة</th>
                                <th>معلومات العميل</th>
                                <th>تاريخ الفاتورة</th>
                                <th>المصدر والعملية</th>
                                <th>المبلغ والحالة</th>
                                <th style="width: 100px;">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                                <tr class="align-middle invoice-row">
                                    <td class="text-center border-start">
                                        <span class="invoice-number">#{{ $invoice->id }}</span>
                                    </td>
                                    <td>
                                        <div class="client-info">
                                            <div class="client-name mb-2">
                                                <i class="fas fa-user text-primary me-1"></i>
                                                <strong>{{ $invoice->client ? ($invoice->client->trade_name ?: $invoice->client->first_name . ' ' . $invoice->client->last_name) : 'عميل غير معروف' }}</strong>
                                            </div>
                                            @if ($invoice->client && $invoice->client->tax_number)
                                                <div class="tax-info mb-1">
                                                    <i class="fas fa-hashtag text-muted me-1"></i>
                                                    <span class="text-muted small">الرقم الضريبي:
                                                    {{ $invoice->client->tax_number }}</span>
                                                </div>
                                            @endif
                                            @if ($invoice->client && $invoice->client->full_address)
                                                <div class="address-info">
                                                    <i class="fas fa-map-marker-alt text-muted me-1"></i>
                                                    <span class="text-muted small">{{ $invoice->client->full_address }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="date-info mb-2">
                                            <i class="fas fa-calendar text-info me-1"></i>
                                            {{ $invoice->created_at ? $invoice->created_at->format($account_setting->time_formula ?? 'H:i:s d/m/Y') : '' }}
                                        </div>
                                        <div class="creator-info">
                                            <i class="fas fa-user text-muted me-1"></i>
                                            <span class="text-muted small">بواسطة: {{ $invoice->createdByUser->name ?? 'غير محدد' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column gap-2">
                                            @php
                                                $payments = \App\Models\PaymentsProcess::where('invoice_id', $invoice->id)
                                                    ->where('type', 'client payments')
                                                    ->orderBy('created_at', 'desc')
                                                    ->get();
                                            @endphp

                                            @if ($payments->count() > 0)
                                                <span class="badge bg-success-subtle text-success">
                                                    <i class="fas fa-check-circle me-1"></i>
                                                    أضيفت عملية دفع
                                                </span>
                                            @else
                                                <span class="badge bg-primary-subtle text-primary">
                                                    <i class="fas fa-file-invoice me-1"></i>
                                                    أنشئت فاتورة
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="amount-info text-center mb-2">
                                            <h6 class="amount mb-1">
                                                {{ number_format($invoice->grand_total ?? $invoice->total, 2) }}
                                                <small class="currency">{{ $account_setting->currency ?? 'SAR' }}</small>
                                            </h6>
                                            @if ($invoice->due_value > 0)
                                                <div class="due-amount">
                                                    <small class="text-danger">
                                                        المبلغ المستحق: {{ number_format($invoice->due_value, 2) }}
                                                        {{ $account_setting->currency ?? 'SAR' }}
                                                    </small>
                                                </div>
                                            @endif
                                        </div>

                                        @php
                                            $statusClass = match($invoice->payment_status) {
                                                1 => 'success',
                                                2 => 'info',
                                                3 => 'danger',
                                                4 => 'secondary',
                                                default => 'dark'
                                            };
                                            $statusText = match($invoice->payment_status) {
                                                1 => 'مدفوعة بالكامل',
                                                2 => 'مدفوعة جزئياً',
                                                3 => 'غير مدفوعة',
                                                4 => 'مستلمة',
                                                default => 'غير معروفة'
                                            };
                                        @endphp
                                        <div class="text-center">
                                            <span class="badge bg-{{ $statusClass }}-subtle text-{{ $statusClass }} status-badge">
                                                {{ $statusText }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="dropdown">
    <button class="btn btn-sm bg-gradient-info fa fa-ellipsis-v" type="button"
        id="dropdownMenuButton{{ $invoice->id }}" data-bs-toggle="dropdown"
        data-bs-boundary="viewport" aria-haspopup="true" aria-expanded="false">
    </button>
    <div class="dropdown-menu dropdown-menu-end">
        <!-- عناصر القائمة المنسدلة -->
        <a class="dropdown-item" href="{{ route('invoices.edit', $invoice->id) }}">
            <i class="fa fa-edit me-2 text-success"></i>تعديل
        </a>
        <a class="dropdown-item" href="{{ route('invoices.show', $invoice->id) }}">
            <i class="fa fa-eye me-2 text-primary"></i>عرض
        </a>
        <a class="dropdown-item" href="{{ route('invoices.generatePdf', $invoice->id) }}">
            <i class="fa fa-file-pdf me-2 text-danger"></i>PDF
        </a>
        <a class="dropdown-item" href="{{ route('invoices.generatePdf', $invoice->id) }}">
            <i class="fa fa-print me-2 text-dark"></i>طباعة
        </a>
        <a class="dropdown-item" href="#">
            <i class="fa fa-envelope me-2 text-warning"></i>إرسال إلى العميل
        </a>
        <a class="dropdown-item" href="{{ route('paymentsClient.create', ['id' => $invoice->id]) }}">
            <i class="fa fa-credit-card me-2 text-info"></i>إضافة عملية دفع
        </a>
        <a class="dropdown-item" href="#">
            <i class="fa fa-copy me-2 text-secondary"></i>نسخ
        </a>
        <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="dropdown-item text-danger">
                <i class="fa fa-trash me-2"></i>حذف
            </button>
        </form>
    </div>
</div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


                @if ($invoices->isEmpty())
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

        function filterInvoices(status) {
            window.location.href = "{{ route('invoices.index') }}" + (status ? "?status=" + status : "");
        }

    </script>
@endsection

