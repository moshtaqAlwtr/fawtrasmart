@extends('master')

@section('title')
    العملاء
@stop

@section('content')
    @if (session('toast_message'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                toastr.{{ session('toast_type', 'success') }}('{{ session('toast_message') }}', '', {
                    positionClass: 'toast-bottom-left',
                    closeButton: true,
                    progressBar: true,
                    timeOut: 5000
                });
            });
        </script>
    @endif
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">ادارة العملاء </h2>
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
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <strong>{{ $client->trade_name }}</strong> | <small>#{{ $client->code }}</small>
                        @if ($client->status)
                            <span class="badge badge-pill badge-success">نشط</span>
                        @else
                            <span class="badge badge-pill badge-warning">غير نشط</span>
                        @endif
                    </div>


                </div>
            </div>
        </div>

        <div class="card">

            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center">
                            <i class="far fa-file-alt me-1"></i> كشف حساب
                        </a>
                        <a href="{{ route('CreditNotes.create') }}"
                            class="btn btn-sm btn-outline-success d-inline-flex align-items-center">
                            <i class="far fa-sticky-note me-1"></i> إنشاء إشعار دائن
                        </a>
                        <a href="{{ route('questions.create') }}"
                            class="btn btn-sm btn-outline-info d-inline-flex align-items-center">
                            <i class="fas fa-file-invoice me-1"></i> إنشاء عرض سعر
                        </a>
                        <a href="{{ route('invoices.create') }}"
                            class="btn btn-sm btn-outline-warning d-inline-flex align-items-center">
                            <i class="fas fa-file-invoice me-1"></i> إنشاء فاتورة
                        </a>
                        <a href="{{ route('Reservations.client', $client->id) }}"
                            class="btn btn-sm btn-outline-warning d-inline-flex align-items-center">
                            <i class="fas fa-file-invoice me-1"></i>الحجوزات
                        </a>
                        <a href="#" class="btn btn-sm btn-outline-danger d-inline-flex align-items-center">
                            <i class="far fa-comment-alt me-1"></i> أرسل SMS
                        </a>
                        <a href="{{ route('appointments.create') }}"
                            class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center">
                            <i class="far fa-calendar-alt me-1"></i> ترتيب موعد
                        </a>
                        <a href="{{ route('appointment.notes.create') }}"
                            class="btn btn-sm btn-outline-dark d-inline-flex align-items-center">
                            <i class="fas fa-paperclip me-1"></i> إضافة ملاحظة/مرفق
                        </a>
                        <a href="{{ route('clients.edit', $client->id) }}"
                            class="btn btn-sm btn-outline-primary d-inline-flex align-items-center">
                            <i class="fas fa-edit me-1"></i> تعديل
                        </a>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="dropdown">
                            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                خيارات أخرى
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <i class="fas fa-plus me-2"></i>
                                        أضف رصيد مدفوعات
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details"
                            aria-controls="details" role="tab" aria-selected="true">
                            <span class="badge badge-pill badge-primary">{{ $client->count() }}</span> التفاصيل</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="appointments-tab" data-toggle="tab" href="#appointments"
                            aria-controls="appointments" role="tab" aria-selected="false">
                            المواعيد <span
                                class="badge badge-pill badge-primary">{{ $client->appointments()->count() }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="invoices-tab" data-toggle="tab" href="#invoices" aria-controls="invoices"
                            role="tab" aria-selected="false">
                            الفواتير <span class="badge badge-pill badge-primary">{{ $client->invoices->count() }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="account-movement-tab" data-toggle="tab" href="#account-movement"
                            aria-controls="account-movement" role="tab" aria-selected="false">
                            حركة الحساب <span
                                class="badge badge-pill badge-info">{{ $client->transactions->count() }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="balance-summary-tab" data-toggle="tab" href="#balance-summary"
                            aria-controls="balance-summary" role="tab" aria-selected="false">ملخص الرصيد</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="membership-tab" data-toggle="tab" href="#membership"
                            aria-controls="membership" role="tab" aria-selected="false">العضوية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="timeline-tab" data-toggle="tab" href="#timeline"
                            aria-controls="timeline" role="tab" aria-selected="false">الجدول الزمني</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="service-tab" data-toggle="tab" href="#service" aria-controls="timeline"
                            role="tab" aria-selected="false">الخدمات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="memberrtab" data-toggle="tab" href="#memberr" aria-controls="timeline"
                            role="tab" aria-selected="false">العضويات</a>
                    </li>

                </ul>

                <div class="tab-content">
                    <!-- تبويب التفاصيل -->
                    <div class="tab-pane active" id="details" aria-labelledby="details-tab" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <strong>التفاصيل :</strong>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>الاسم التجاري:</strong> {{ $client->trade_name }}</p>
                                        <p><strong>الاسم الأول:</strong> {{ $client->first_name }}</p>
                                        <p><strong>الاسم الأخير:</strong> {{ $client->last_name }}</p>
                                        <p><strong>رقم الهاتف:</strong> {{ $client->phone }}</p>
                                        <p><strong>الجوال:</strong> {{ $client->mobile }}</p>
                                        <p><strong>البريد الإلكتروني:</strong> {{ $client->email }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>العنوان:</strong> {{ $client->street1 }} {{ $client->street2 }}</p>
                                        <p><strong>المدينة:</strong> {{ $client->city }}</p>
                                        <p><strong>المنطقة:</strong> {{ $client->region }}</p>
                                        <p><strong>الرمز البريدي:</strong> {{ $client->postal_code }}</p>
                                        <p><strong>الدولة:</strong> {{ $client->country }}</p>
                                        <p><strong>الرقم الضريبي:</strong> {{ $client->tax_number }}</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>السجل التجاري:</strong> {{ $client->commercial_registration }}</p>
                                        <p><strong>حد الائتمان:</strong> {{ $client->credit_limit }}</p>
                                        <p><strong>فترة الائتمان:</strong> {{ $client->credit_period }} يوم</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>طريقة الطباعة:</strong>
                                            @if ($client->printing_method == 1)
                                                طباعة عادية
                                            @elseif($client->printing_method == 2)
                                                طباعة حرارية
                                            @else
                                                غير محدد
                                            @endif
                                        </p>
                                        <p><strong>نوع العميل:</strong>
                                            @if ($client->client_type == 1)
                                                فرد
                                            @elseif($client->client_type == 2)
                                                شركة
                                            @else
                                                غير محدد
                                            @endif
                                        </p>
                                        <p><strong>الرصيد الافتتاحي:</strong> {{ $client->opening_balance }}</p>
                                        <p><strong>تاريخ الرصيد الافتتاحي:</strong> {{ $client->opening_balance_date }}</p>
                                    </div>
                                </div>
                                @if ($client->notes)
                                    <hr>
                                    <div class="row">
                                        <div class="col-12">
                                            <p><strong>ملاحظات:</strong></p>
                                            <p>{{ $client->notes }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>


                    </div>
                    {{-- تبويبة المواعيد  --}}
                    <div class="tab-pane" id="appointments" aria-labelledby="appointments-tab" role="tabpanel">
                        @php
                            $completedAppointments = $client->appointments->where(
                                'status',
                                App\Models\Appointment::STATUS_COMPLETED,
                            );
                            $ignoredAppointments = $client->appointments->where(
                                'status',
                                App\Models\Appointment::STATUS_IGNORED,
                            );
                            $pendingAppointments = $client->appointments->where(
                                'status',
                                App\Models\Appointment::STATUS_PENDING,
                            );
                            $rescheduledAppointments = $client->appointments->where(
                                'status',
                                App\Models\Appointment::STATUS_RESCHEDULED,
                            );
                        @endphp

                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div class="d-flex gap-2 flex-wrap">
                                    <button class="btn btn-sm btn-outline-primary filter-appointments" data-filter="all">
                                        الكل
                                        <span class="badge badge-light">{{ $client->appointments->count() }}</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-success filter-appointments"
                                        data-filter="{{ App\Models\Appointment::STATUS_COMPLETED }}">
                                        تم
                                        <span class="badge badge-light">{{ $completedAppointments->count() }}</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-warning filter-appointments"
                                        data-filter="{{ App\Models\Appointment::STATUS_IGNORED }}">
                                        تم صرف النظر عنه
                                        <span class="badge badge-light">{{ $ignoredAppointments->count() }}</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger filter-appointments"
                                        data-filter="{{ App\Models\Appointment::STATUS_PENDING }}">
                                        تم جدولته
                                        <span class="badge badge-light">{{ $pendingAppointments->count() }}</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-info filter-appointments"
                                        data-filter="{{ App\Models\Appointment::STATUS_RESCHEDULED }}">
                                        تم جدولته مجددا
                                        <span class="badge badge-light">{{ $rescheduledAppointments->count() }}</span>
                                    </button>
                                </div>
                            </div>

                            <div class="card-body">
                                <div id="appointments-container">
                                    @if ($client->appointments->count() > 0)
                                        @foreach ($client->appointments as $appointment)
                                            <div class="card mb-2 appointment-item"
                                                data-appointment-id="{{ $appointment->id }}"
                                                data-status="{{ $appointment->status }}"
                                                data-date="{{ $appointment->created_at->format('Y-m-d') }}">
                                                <div class="card-body">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-4">
                                                            <strong>#{{ $appointment->id }}</strong>
                                                            <p class="mb-0">{{ $appointment->title }}</p>
                                                            <small
                                                                class="text-muted">{{ $appointment->description }}</small>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <p class="mb-0">
                                                                <small>{{ $appointment->created_at->format('Y-m-d H:i') }}</small>
                                                            </p>
                                                            <small class="text-muted">
                                                                بواسطة:
                                                                {{ $appointment->employee->name ?? 'غير محدد' }}
                                                            </small>
                                                        </div>
                                                        <div class="col-md-3 text-center">
                                                            <span
                                                                class="badge status-badge {{ $appointment->status_color }}">
                                                                {{ $appointment->status_text }}
                                                            </span>
                                                        </div>
                                                        <div class="col-md-2 text-end">
                                                            <div class="btn-group">
                                                                <div class="dropdown">
                                                                    <button
                                                                        class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1"
                                                                        type="button"id="dropdownMenuButton303"
                                                                        data-toggle="dropdown"
                                                                        aria-haspopup="true"aria-expanded="false"></button>
                                                                    <div class="dropdown-menu dropdown-menu-end"
                                                                        aria-labelledby="dropdownMenuButton{{ $appointment->id }}">
                                                                        <form
                                                                            action="{{ route('appointments.update-status', $appointment->id) }}"
                                                                            method="POST" class="d-inline">
                                                                            @csrf
                                                                            @method('PATCH')
                                                                            <input type="hidden" name="status"
                                                                                value="1">
                                                                            <button type="submit" class="dropdown-item">
                                                                                <i
                                                                                    class="fa fa-clock me-2 text-warning"></i>تم
                                                                                جدولته
                                                                            </button>
                                                                        </form>

                                                                        <form
                                                                            action="{{ route('appointments.update-status', $appointment->id) }}"
                                                                            method="POST" class="d-inline">
                                                                            @csrf
                                                                            @method('PATCH')
                                                                            <input type="hidden" name="status"
                                                                                value="2">
                                                                            <input type="hidden" name="auto_delete"
                                                                                value="1">
                                                                            <button type="submit" class="dropdown-item">
                                                                                <i
                                                                                    class="fa fa-check me-2 text-success"></i>تم
                                                                            </button>
                                                                        </form>

                                                                        <!-- For ignored status -->
                                                                        <form
                                                                            action="{{ route('appointments.update-status', $appointment->id) }}"
                                                                            method="POST" class="d-inline">
                                                                            @csrf
                                                                            @method('PATCH')
                                                                            <input type="hidden" name="status"
                                                                                value="3">
                                                                            <button type="submit" class="dropdown-item">
                                                                                <i
                                                                                    class="fa fa-times me-2 text-danger"></i>صرف
                                                                                النظر عنه
                                                                            </button>
                                                                        </form>
                                                                        <form
                                                                            action="{{ route('appointments.update-status', $appointment->id) }}"
                                                                            method="POST" class="d-inline">
                                                                            @csrf
                                                                            @method('PATCH')
                                                                            <input type="hidden" name="status"
                                                                                value="4">
                                                                            <button type="submit" class="dropdown-item">
                                                                                <i class="fa fa-redo me-2 text-info"></i>تم
                                                                                جدولته مجددا
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- معلومات إضافية للموعد -->
                                                    <div class="row mt-3">
                                                        <div class="col-md-6">
                                                            <small class="text-muted">
                                                                <strong>نوع الإجراء:</strong>
                                                                {{ $appointment->action_type ?? 'غير محدد' }}
                                                            </small>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <small class="text-muted">
                                                                <strong>مدة الموعد:</strong>
                                                                {{ $appointment->duration ?? 'غير محدد' }}
                                                            </small>
                                                        </div>
                                                        @if ($appointment->notes)
                                                            <div class="col-12 mt-2">
                                                                <small class="text-muted">
                                                                    <strong>ملاحظات:</strong>
                                                                    {{ $appointment->notes }}
                                                                </small>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal for Adding Notes -->
                                            <div class="modal fade" id="noteModal{{ $appointment->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="noteModalLabel{{ $appointment->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="noteModalLabel{{ $appointment->id }}">إضافة
                                                                ملاحظات
                                                                للموعد</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form id="noteForm{{ $appointment->id }}" method="POST">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <input type="hidden" name="status"
                                                                    value="{{ App\Models\Appointment::STATUS_COMPLETED }}">
                                                                <div class="form-group">
                                                                    <label
                                                                        for="notes{{ $appointment->id }}">الملاحظات</label>
                                                                    <textarea class="form-control" id="notes{{ $appointment->id }}" name="notes" rows="3"
                                                                        placeholder="أدخل ملاحظاتك هنا"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">إلغاء</button>
                                                                <button type="button" class="btn btn-primary"
                                                                    onclick="submitCompletedAppointment({{ $appointment->id }})">حفظ
                                                                    الملاحظات</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="alert alert-info text-center">
                                            لا توجد مواعيد
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- تبويب الفواتير -->
                    <div class="tab-pane" id="invoices" aria-labelledby="invoices-tab" role="tabpanel">
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
                                <tbody id="invoiceTableBody">
                                    @foreach ($invoices as $invoice)
                                        <tr class="align-middle invoice-row"
                                            onclick="window.location.href='{{ route('invoices.show', $invoice->id) }}'"
                                            style="cursor: pointer;" data-status="{{ $invoice->payment_status }}">
                                            <!-- أضفنا سمة data-status -->
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
                                                            <span
                                                                class="text-muted small">{{ $invoice->client->full_address }}</span>
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
                                                    <span class="text-muted small">بواسطة:
                                                        {{ $invoice->createdByUser->name ?? 'غير محدد' }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column gap-2">
                                                    @php
                                                        $payments = \App\Models\PaymentsProcess::where(
                                                            'invoice_id',
                                                            $invoice->id,
                                                        )
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
                                                        <small
                                                            class="currency">{{ $account_setting->currency ?? 'SAR' }}</small>
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
                                                    $statusClass = match ($invoice->payment_status) {
                                                        1 => 'success',
                                                        2 => 'info',
                                                        3 => 'danger',
                                                        4 => 'secondary',
                                                        default => 'dark',
                                                    };
                                                    $statusText = match ($invoice->payment_status) {
                                                        1 => 'مدفوعة بالكامل',
                                                        2 => 'مدفوعة جزئياً',
                                                        3 => 'غير مدفوعة',
                                                        4 => 'مستلمة',
                                                        default => 'غير معروفة',
                                                    };
                                                @endphp
                                                <div class="text-center">
                                                    <span
                                                        class="badge bg-{{ $statusClass }}-subtle text-{{ $statusClass }} status-badge">
                                                        {{ $statusText }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="dropdown" onclick="event.stopPropagation()">
                                                    <button class="btn btn-sm bg-gradient-info fa fa-ellipsis-v"
                                                        type="button" id="dropdownMenuButton{{ $invoice->id }}"
                                                        data-bs-toggle="dropdown" data-bs-boundary="viewport"
                                                        aria-haspopup="true" aria-expanded="false">
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <!-- عناصر القائمة المنسدلة -->
                                                        <a class="dropdown-item"
                                                            href="{{ route('invoices.edit', $invoice->id) }}">
                                                            <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                        </a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('invoices.show', $invoice->id) }}">
                                                            <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                        </a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('invoices.generatePdf', $invoice->id) }}">
                                                            <i class="fa fa-file-pdf me-2 text-danger"></i>PDF
                                                        </a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('invoices.generatePdf', $invoice->id) }}">
                                                            <i class="fa fa-print me-2 text-dark"></i>طباعة
                                                        </a>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="fa fa-envelope me-2 text-warning"></i>إرسال إلى
                                                            العميل
                                                        </a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('paymentsClient.create', ['id' => $invoice->id]) }}">
                                                            <i class="fa fa-credit-card me-2 text-info"></i>إضافة عملية دفع
                                                        </a>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="fa fa-copy me-2 text-secondary"></i>نسخ
                                                        </a>
                                                        <form action="{{ route('invoices.destroy', $invoice->id) }}"
                                                            method="POST" class="d-inline">
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

                    </div>

                    <!-- تبويب حركة الحساب -->
                    <div class="tab-pane" id="account-movement" aria-labelledby="account-movement-tab" role="tabpanel">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-7">
                                    <a href="#" class="btn btn-sm btn-info text-white">
                                        <i class="fas fa-file-export"></i> خيارات التصدير
                                    </a>
                                    <a href="#" class="btn btn-sm btn-light">
                                        <i class="fas fa-print"></i> طباعة
                                    </a>
                                    <a href="#" class="btn btn-sm btn-light">
                                        <i class="fas fa-cog"></i> تخصيص
                                    </a>
                                </div>
                                <div class="col-md-5 text-end">
                                    <div class="d-inline-block me-3">
                                        <div class="form-check form-switch d-inline-block">
                                            <input class="form-check-input" type="checkbox" id="showDetails">
                                            <label class="form-check-label" for="showDetails">اعرض التفاصيل</label>
                                        </div>
                                    </div>
                                    <div class="d-inline-block">
                                        <div class="input-group input-group-sm" style="width: 200px;">
                                            <input type="date" class="form-control" placeholder="الفترة من / إلى">


                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body p-4">
                                <div class="row">
                                    <div class="col-6 text-start">
                                        <div>{{ $client->trade_name }}</div>
                                        <div>{{ $client->city }}</div>
                                        <div>{{ $client->region }}، {{ $client->city }}</div>
                                        <div class="mt-2">Date: {{ date('d/m/Y') }}</div>
                                    </div>
                                    <div class="col-6 text-end">
                                        <h4>كشف حساب</h4>
                                        <div>{{ $client->trade_name }}</div>
                                        <div>{{ $client->region }} - {{ $client->city }}</div>
                                        <div>{{ $client->country }}</div>
                                        <div class="mt-2">حركة الحساب حتى {{ date('d/m/Y') }}</div>
                                    </div>
                                </div>

                                <div class="table-responsive mt-4">
                                    <table class="table table-bordered mb-0">
                                        <thead>
                                            <tr class="bg-dark text-white">
                                                <th class="text-end" style="width: 12%;">التاريخ</th>
                                                <th class="text-end" style="width: 30%;">العملية</th>
                                                <th class="text-start" style="width: 20%;">المبلغ</th>
                                                <th class="text-start" style="width: 20%;">المبلغ المستحق</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="3" class="text-end pe-3">رصيد بداية المدة</td>
                                                <td class="text-start">
                                                    {{ number_format($client->opening_balance ?? 0.0, 2) }} ر.س</td>
                                            </tr>
                                            @php
                                                $balance = $client->opening_balance ?? 0;
                                            @endphp
                                            @foreach ($client->invoices as $invoice)
                                                @php
                                                    if ($invoice->type == 'invoice') {
                                                        $balance += $invoice->total;
                                                    } else {
                                                        $balance -= $invoice->total;
                                                    }
                                                @endphp
                                                <tr>
                                                    <td class="text-end">{{ $invoice->invoice_date->format('d/m/Y') }}
                                                    </td>
                                                    <td class="text-end">
                                                        @if ($invoice->type == 'invoice')
                                                            فاتورة #{{ $invoice->invoice_number }}
                                                        @else
                                                            فاتورة مرجعة #{{ $invoice->invoice_number }}
                                                        @endif
                                                    </td>
                                                    <td class="text-start">
                                                        @if ($invoice->type == 'return')
                                                            {{ number_format(-$invoice->total, 2) }}
                                                        @else
                                                            {{ number_format($invoice->total, 2) }}
                                                        @endif
                                                        <span class="text-muted">SAR</span> ر.س
                                                    </td>
                                                    <td class="text-start">{{ number_format($balance, 2) }} ر.س</td>
                                                </tr>
                                            @endforeach
                                            <tr class="bg-dark text-white">
                                                <td colspan="3" class="text-end pe-3">رصيد نهاية المدة</td>
                                                <td class="text-start">{{ number_format($balance, 2) }} ر.س</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- تبويبة -->

                    <div class="tab-pane" id="balance-summary" aria-labelledby="balance-summary-tab" role="tabpanel">
                        <div class="d-flex justify-content-end gap-2 mb-3">
                            <a href="#" class="btn btn-info text-white">
                                <i class="fas fa-plus"></i>
                                أضف شحن الرصيد
                            </a>
                            <a href="#" class="btn btn-secondary">
                                <i class="fas fa-history"></i>
                                عرض السجل
                            </a>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="text-center py-5">
                                    <div class="text-muted">
                                        لا يوجد انواع الرصيد اضيفت حتى الآن
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endsection
            @section('scripts')
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <script src="{{ asset('assets/js/applmintion.js') }}"></script>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
                <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            @endsection
