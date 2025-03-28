@extends('master')

@section('title')
    العملاء
@stop
@section('head')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
@endsection
@section('css')

    <style>
        /* إصلاح أزرار Accordion */
        .accordion-button {
            background-color: var(--bs-primary) !important;
            color: rgb(127, 4, 250) !important;
            border: none !important;
        }

        .accordion-button:not(.collapsed) {
            background-color: var(--bs-primary) !important;
            color: rgb(66, 4, 253) !important;
        }

        /* إصلاح أزرار التبويبات */
        .nav-tabs .nav-link {
            color: var(--bs-primary);
            border-color: var(--bs-primary);
        }

        .nav-tabs .nav-link.active {
            background-color: var(--bs-primary) !important;
            color: white !important;
            border-color: var(--bs-primary) !important;
        }

        /* إصلاح الأزرار العادية */
        .btn-primary {
            background-color: var(--bs-primary) !important;
            border-color: var(--bs-primary) !important;
            color: white !important;
        }

        .btn-outline-primary {
            color: var(--bs-primary) !important;
            border-color: var(--bs-primary) !important;
        }

        .btn-outline-primary:hover {
            background-color: var(--bs-primary) !important;
            color: white !important;
        }

        /* إزالة الظلال عند التركيز */
        .accordion-button:focus,
        .btn:focus {
            box-shadow: none !important;
        }

        /* إزالة الخلفية من الأرقام في الأزرار */
        .btn .badge {
            background-color: transparent !important;
            color: var(--bs-primary) !important;
            padding: 0 !important;
            margin-left: 4px;
        }

        /* التأكد من أن اللون الأساسي مضبوط */
        :root {
            --bs-primary: #f9fafc;
        }

        /* تنسيق الأزرار الأساسية */
        .btn-primary {
            background-color: var(--bs-primary);
            border-color: var(--bs-primary);
            color: black;
        }
    </style>
@endsection
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
    @include('layouts.alerts.error')
    @include('layouts.alerts.success')
    <div class="modal fade" id="assignEmployeeModal" tabindex="-1" aria-labelledby="assignEmployeeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assignEmployeeModalLabel">تعيين موظفين للعميل</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('clients.assign-employees', $client->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="client_id" value="{{ $client->id }}">
                        <select name="employee_id[]" multiple class="form-control select2">
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}" @if ($client->employees && $client->employees->contains('id', $employee->id)) selected @endif>
                                    {{ $employee->full_name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary mt-2">تعيين الموظفين</button>
                    </form>


                    <!-- Current Assigned Employees -->

                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <strong>{{ $client->trade_name }}</strong>
                        <small class="text-muted">#{{ $client->id }}</small>
                        <span class="badge"
                            style="background-color: {{ $statuses->find($client->status_id)->color ?? '#007BFF' }}; color: white;">
                            {{ $statuses->find($client->status_id)->name ?? 'غير محدد' }}
                        </span>
                        <br>
                        <small class="text-muted">
                            حساب الأستاذ:
                            @if ($client->account)
                                <a href="#">{{ $client->account->name }} #{{ $client->account->code }}</a>
                            @else
                                <span>No account associated</span>
                            @endif
                        </small>
                    </div>
                    @php
                        $currency = $account_setting->currency ?? 'SAR';
                        $currencySymbol =
                            $currency == 'SAR' || empty($currency)
                                ? '<img src="' .
                                    asset('assets/images/Saudi_Riyal.svg') .
                                    '" alt="ريال سعودي" width="15" style="vertical-align: middle;">'
                                : $currency;
                    @endphp
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div class="text-muted">
                            <strong class="text-dark">{{ $invoice_due ?? 0 }}</strong> <span
                                class="text-muted">{!! $currencySymbol !!}</span>
                            <span class="d-block text-danger">المطلوب دفعة</span>
                        </div>
                        @if ($invoices->isNotEmpty())
                            <div class="text-muted">
                                <strong class="text-dark">{{ $invoice_due ?? 0 }}</strong> <span class="text-muted"></span>
                                <span class="d-block text-warning">مفتوح</span>
                            </div>
                        @endif
                    </div>
                    <div class="mt-4">
                        <h6>!</h6>
                        <div class="d-flex flex-wrap gap-2" id="assignedEmployeesList">
                            @if ($client->employees && $client->employees->count() > 0)
                                @foreach ($client->employees as $employee)
                                    <span class="badge bg-primary d-flex align-items-center">
                                        {{ $employee->full_name }}

                                        <form action="{{ route('clients.remove-employee', $client->id) }}" method="POST"
                                            class="ms-2">
                                            @csrf
                                            <input type="hidden" name="employee_id" value="{{ $employee->id }}">

                                            <button type="submit" class="btn btn-sm btn-link text-white p-0">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </span>
                                @endforeach
                            @else
                                <span class="text-muted">{{ __('لا يوجد موظفون مرتبطون بهذا العميل') }}</span>
                            @endif
                        </div>
                    </div>
                    @php
                        // جلب الحالة الحالية للعميل من العلاقة
                        $currentStatus = $client->status;
                    @endphp


                    <form method="POST" action="{{ route('clients.updateStatusClient') }}">
                        @csrf
                        <input type="hidden" name="client_id" value="{{ $client->id }}">

                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle text-start" type="button"
                                id="clientStatusDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                                style="background-color: {{ $currentStatus->color ?? '#ffffff' }};
                               color: #000;
                               border: 1px solid #ccc;
                               min-width: 150px;
                               max-width: max-content;
                               white-space: nowrap;">
                                {{ $currentStatus->name ?? 'اختر الحالة' }}
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="clientStatusDropdown"
                                style="min-width: 150px; width: auto; max-width: max-content; white-space: nowrap; border-radius: 8px;">
                                @foreach ($statuses as $status)
                                    <li>
                                        <button type="submit"
                                            class="dropdown-item text-white d-flex align-items-center justify-content-between"
                                            name="status_id" value="{{ $status->id }}"
                                            style="background-color: {{ $status->color }};">
                                            <span><i class="fas fa-thumbtack me-1"></i> {{ $status->name }}</span>
                                        </button>
                                    </li>
                                @endforeach

                                <li>
                                    <a href="{{ route('SupplyOrders.edit_status') }}"
                                        class="dropdown-item text-muted d-flex align-items-center justify-content-center"
                                        style="border-top: 1px solid #ddd; padding: 8px;">
                                        <i class="fas fa-cog me-2"></i> تعديل قائمة الحالات - العميل
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card border-0">
            <div class="card-body d-flex justify-content-between align-items-center">
                <!-- القسم الأيمن (الاسم والموقع) -->
                <div class="text-end">
                    <strong class="text-dark">{{ $client->first_name }}</strong>
                    <br>
                    <span class="text-primary">
                        <i class="fas fa-map-marker-alt"></i>{{ $client->full_address }}
                    </span>
                </div>

                <!-- القسم الأيسر (رقم الهاتف) -->
                <div class="d-flex align-items-center">
                    <button class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-copy"></i>
                    </button>
                    <span class="mx-2 text-dark">{{ $client->phone }}</span>
                    <button class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-mobile-alt"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                    <!-- زر الخيارات الإضافية -->

                    <!-- الأزرار الرئيسية -->


                    <!-- الأزرار الرئيسية للأجهزة الكبيرة -->
                    <div class="d-flex flex-column flex-md-row flex-wrap mb-4" style="gap: 10px">
                        <!-- تعديل العميل -->
                        <a href="{{ route('clients.edit', $client->id) }}"
                            class="btn btn-sm btn-info text-start text-md-center">
                            <i class="fas fa-user-edit me-1"></i> تعديل
                        </a>

                        <!-- إضافة ملاحظة/مرفق -->
                        <a href="{{ route('appointment.notes.create', $client->id) }}"
                            class="btn btn-sm btn-secondary text-start text-md-center">
                            <i class="fas fa-paperclip me-1"></i> إضافة ملاحظة/مرفق
                        </a>

                        <!-- ترتيب موعد -->
                        <a href="{{ route('appointments.create') }}"
                            class="btn btn-sm btn-success text-start text-md-center">
                            <i class="fas fa-calendar-plus me-1"></i> ترتيب موعد
                        </a>

                        <!-- كشف حساب -->
                        <a href="#" class="btn btn-sm btn-warning text-start text-md-center">
                            <i class="fas fa-file-invoice me-1"></i> كشف حساب
                        </a>

                        <!-- إنشاء عرض سعر -->
                        <a href="{{ route('questions.create') }}"
                            class="btn btn-sm btn-warning text-start text-md-center">
                            <i class="fas fa-file-signature me-1"></i> إنشاء عرض سعر
                        </a>

                        <!-- إنشاء إشعار دائن -->
                        <a href="{{ route('CreditNotes.create') }}"
                            class="btn btn-sm btn-danger text-start text-md-center">
                            <i class="fas fa-file-invoice-dollar me-1"></i> إنشاء إشعار دائن
                        </a>

                        <!-- إنشاء فاتورة -->
                        <a href="{{ route('invoices.create') }}"
                            class="btn btn-sm btn-dark text-start text-md-center">
                            <i class="fas fa-file-invoice me-1"></i> إنشاء فاتورة
                        </a>

                        <!-- الحجوزات -->
                        <a href="{{ route('Reservations.client', $client->id) }}"
                            class="btn btn-sm btn-light text-start text-md-center text-dark">
                            <i class="fas fa-calendar-check me-1"></i> الحجوزات
                        </a>

                        <!-- خيارات أخرى -->
                        <div class="dropdown">
                            <a href="#" class="btn btn-sm btn-outline-dark dropdown-toggle text-start text-md-center"
                               role="button" data-bs-toggle="dropdown"
                               style="padding: 0.25rem 0.5rem; height: 31.6px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-ellipsis-v me-1"></i>
                                خيارات أخرى
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal"
                                        data-bs-target="#openingBalanceModal">
                                        <i class="fas fa-wallet me-2 text-success"></i> إضافة رصيد افتتاحي
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center"
                                        href="{{ route('SupplyOrders.create') }}">
                                        <i class="fas fa-truck me-2 text-info"></i> إضافة أمر توريد
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <i class="fas fa-user me-2 text-primary"></i> الدخول كعميل
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <i class="fas fa-ban me-2 text-warning"></i> موقوف
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center text-danger"
                                        href="{{ route('clients.destroy', $client->id) }}">
                                        <i class="fas fa-trash-alt me-2"></i> حذف عميل
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal"
                                        data-bs-target="#assignEmployeeModal">
                                        <i class="fas fa-user-tie me-2 text-secondary"></i> تعيين إلى موظف
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <i class="fas fa-copy me-2 text-dark"></i> نسخ
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       <div class="card">
            <div class="card-body">
                <div class="accordion" id="clientAccordion">
                    <div class="card">
                        <div class="card-body">
                            <!-- الأزرار - تظهر عمودياً في الجوال وأفقياً في الكمبيوتر -->


                            <div class="accordion" id="clientAccordion">
                                <!-- تبويب التفاصيل -->
                                <div class="accordion-item">
                                    <h3 class="accordion-header d-flex justify-content-center">
                                        <button class="accordion-button collapsed text-center" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#details" aria-expanded="false"
                                            aria-controls="details" style="background-color: #0d6efd; color: white;">
                                            <i class="fas fa-info-circle me-2"></i> التفاصيل
                                            <span class="badge bg-transparent text-black ms-2 border border-black">{{ $client->appointments()->count() }}</span>
                                        </button>
                                    </h3>
                                    <div id="details" class="accordion-collapse collapse" aria-labelledby="details"
                                        data-bs-parent="#clientAccordion">
                                        <div class="accordion-body">
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
                                                    <p><strong>العنوان:</strong> {{ $client->street1 }}
                                                        {{ $client->street2 }}</p>
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
                                                    <p><strong>السجل التجاري:</strong>
                                                        {{ $client->commercial_registration }}</p>
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
                                                    <p><strong>الرصيد الافتتاحي:</strong> {{ $client->opening_balance }}
                                                    </p>
                                                    <p><strong>تاريخ الرصيد الافتتاحي:</strong>
                                                        {{ $client->opening_balance_date }}</p>
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

                                <!-- تبويب المواعيد -->
                                <div class="accordion-item">
                                    <h3 class="accordion-header d-flex justify-content-center">
                                        <button class="accordion-button collapsed text-center" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#appointments"
                                            aria-expanded="false" aria-controls="appointments" style="background-color: #0d6efd; color: white;">
                                            <i class="fas fa-calendar-alt me-2"></i> المواعيد
                                            <span class="badge bg-transparent text-black ms-2 border border-white">{{ $client->appointments()->count() }}</span>
                                        </button>
                                    </h3>
                                    <div id="appointments" class="accordion-collapse collapse"
                                        aria-labelledby="appointments" data-bs-parent="#clientAccordion">
                                        <div class="accordion-body">
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
                                                    <div class="dropdown d-block d-md-none">
                                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle"
                                                            type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                            تصفية المواعيد
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <button class="dropdown-item filter-appointments"
                                                                data-filter="all">
                                                                الكل <span
                                                                    class="badge badge-light">{{ $client->appointments->count() }}</span>
                                                            </button>
                                                            <button class="dropdown-item filter-appointments"
                                                                data-filter="{{ App\Models\Appointment::STATUS_COMPLETED }}">
                                                                تم <span
                                                                    class="badge badge-light">{{ $completedAppointments->count() }}</span>
                                                            </button>
                                                            <button class="dropdown-item filter-appointments"
                                                                data-filter="{{ App\Models\Appointment::STATUS_IGNORED }}">
                                                                تم صرف النظر عنه <span
                                                                    class="badge badge-light">{{ $ignoredAppointments->count() }}</span>
                                                            </button>
                                                            <button class="dropdown-item filter-appointments"
                                                                data-filter="{{ App\Models\Appointment::STATUS_PENDING }}">
                                                                تم جدولته <span
                                                                    class="badge badge-light">{{ $pendingAppointments->count() }}</span>
                                                            </button>
                                                            <button class="dropdown-item filter-appointments"
                                                                data-filter="{{ App\Models\Appointment::STATUS_RESCHEDULED }}">
                                                                تم جدولته مجددا <span
                                                                    class="badge badge-light">{{ $rescheduledAppointments->count() }}</span>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <div class="d-none d-md-flex gap-2 flex-wrap">
                                                        <button class="btn btn-sm btn-outline-primary filter-appointments"
                                                            data-filter="all">
                                                            الكل <span
                                                                class="badge badge-light">{{ $client->appointments->count() }}</span>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-success filter-appointments"
                                                            data-filter="{{ App\Models\Appointment::STATUS_COMPLETED }}">
                                                            تم <span
                                                                class="badge badge-light">{{ $completedAppointments->count() }}</span>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-warning filter-appointments"
                                                            data-filter="{{ App\Models\Appointment::STATUS_IGNORED }}">
                                                            تم صرف النظر عنه <span
                                                                class="badge badge-light">{{ $ignoredAppointments->count() }}</span>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-danger filter-appointments"
                                                            data-filter="{{ App\Models\Appointment::STATUS_PENDING }}">
                                                            تم جدولته <span
                                                                class="badge badge-light">{{ $pendingAppointments->count() }}</span>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-info filter-appointments"
                                                            data-filter="{{ App\Models\Appointment::STATUS_RESCHEDULED }}">
                                                            تم جدولته مجددا <span
                                                                class="badge badge-light">{{ $rescheduledAppointments->count() }}</span>
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="card-body">
                                                    <div id="appointments-container">
                                                        @if ($client->appointments->count() > 0)
                                                            <div class="table-responsive">
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>العنوان</th>
                                                                            <th>الوصف</th>
                                                                            <th>التاريخ</th>
                                                                            <th>بواسطة</th>
                                                                            <th>الحالة</th>
                                                                            <th>الإجراءات</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($client->appointments as $appointment)
                                                                            <tr data-appointment-id="{{ $appointment->id }}"
                                                                                data-status="{{ $appointment->status }}"
                                                                                data-date="{{ $appointment->created_at->format('Y-m-d') }}">
                                                                                <td>{{ $appointment->id }}</td>
                                                                                <td>{{ $appointment->title }}</td>
                                                                                <td>{{ $appointment->description }}</td>
                                                                                <td>{{ $appointment->created_at->format('Y-m-d H:i') }}
                                                                                </td>
                                                                                <td>{{ $appointment->employee->name ?? 'غير محدد' }}
                                                                                </td>
                                                                                <td>
                                                                                    <span
                                                                                        class="badge status-badge {{ $appointment->status_color }}">
                                                                                        {{ $appointment->status_text }}
                                                                                    </span>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="dropdown">
                                                                                        <button
                                                                                            class="btn btn-sm bg-gradient-info fa fa-ellipsis-v"
                                                                                            type="button"
                                                                                            id="dropdownMenuButton{{ $appointment->id }}"
                                                                                            data-toggle="dropdown"
                                                                                            aria-haspopup="true"
                                                                                            aria-expanded="false"></button>
                                                                                        <div class="dropdown-menu dropdown-menu-end"
                                                                                            aria-labelledby="dropdownMenuButton{{ $appointment->id }}">
                                                                                            <form
                                                                                                action="{{ route('appointments.update-status', $appointment->id) }}"
                                                                                                method="POST"
                                                                                                class="d-inline">
                                                                                                @csrf
                                                                                                @method('PATCH')
                                                                                                <input type="hidden"
                                                                                                    name="status"
                                                                                                    value="1">
                                                                                                <button type="submit"
                                                                                                    class="dropdown-item">
                                                                                                    <i
                                                                                                        class="fa fa-clock me-2 text-warning"></i>تم
                                                                                                    جدولته
                                                                                                </button>
                                                                                            </form>
                                                                                            <form
                                                                                                action="{{ route('appointments.update-status', $appointment->id) }}"
                                                                                                method="POST"
                                                                                                class="d-inline">
                                                                                                @csrf
                                                                                                @method('PATCH')
                                                                                                <input type="hidden"
                                                                                                    name="status"
                                                                                                    value="2">
                                                                                                <input type="hidden"
                                                                                                    name="auto_delete"
                                                                                                    value="1">
                                                                                                <button type="submit"
                                                                                                    class="dropdown-item">
                                                                                                    <i
                                                                                                        class="fa fa-check me-2 text-success"></i>تم
                                                                                                </button>
                                                                                            </form>
                                                                                            <form
                                                                                                action="{{ route('appointments.update-status', $appointment->id) }}"
                                                                                                method="POST"
                                                                                                class="d-inline">
                                                                                                @csrf
                                                                                                @method('PATCH')
                                                                                                <input type="hidden"
                                                                                                    name="status"
                                                                                                    value="3">
                                                                                                <button type="submit"
                                                                                                    class="dropdown-item">
                                                                                                    <i
                                                                                                        class="fa fa-times me-2 text-danger"></i>صرف
                                                                                                    النظر عنه
                                                                                                </button>
                                                                                            </form>
                                                                                            <form
                                                                                                action="{{ route('appointments.update-status', $appointment->id) }}"
                                                                                                method="POST"
                                                                                                class="d-inline">
                                                                                                @csrf
                                                                                                @method('PATCH')
                                                                                                <input type="hidden"
                                                                                                    name="status"
                                                                                                    value="4">
                                                                                                <button type="submit"
                                                                                                    class="dropdown-item">
                                                                                                    <i
                                                                                                        class="fa fa-redo me-2 text-info"></i>تم
                                                                                                    جدولته مجددا
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
                                                        @else
                                                            <div class="alert alert-info text-center">
                                                                لا توجد مواعيد
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- تبويب الفواتير -->
                                <div class="accordion-item">
                                    <h3 class="accordion-header d-flex justify-content-center">
                                        <button class="accordion-button collapsed text-center" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#invoices"
                                            aria-expanded="false" aria-controls="invoices" style="background-color: #0d6efd; color: white;">
                                            <i class="fas fa-file-invoice me-2"></i> الفواتير
                                            <span class="badge bg-transparent text-black ms-2 border border-white">{{ $client->invoices()->count() }}</span>
                                        </button>
                                    </h3>
                                    <div id="invoices" class="accordion-collapse collapse"
                                        aria-labelledby="invoices" data-bs-parent="#clientAccordion">
                                        <div class="accordion-body">
                                            <div class="table-responsive">
                                                <table class="table table-hover custom-table" id="fawtra">
                                                    <thead>
                                                        <tr class="bg-gradient-light text-center">
                                                            <th></th>
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
                                                            <tr class="align-middle invoice-row" onclick="window.location.href='{{ route('invoices.show', $invoice->id) }}'" style="cursor: pointer;" data-status="{{ $invoice->payment_status }}">
                                                                <td onclick="event.stopPropagation()">
                                                                    <input type="checkbox" class="invoice-checkbox" name="invoices[]" value="{{ $invoice->id }}">
                                                                </td>
                                                                <td class="text-center border-start"><span class="invoice-number">#{{ $invoice->id }}</span></td>
                                                                <td>
                                                                    <div class="client-info">
                                                                        <div class="client-name mb-2">
                                                                            <i class="fas fa-user text-primary me-1"></i>
                                                                            <strong>{{ $invoice->client ? ($invoice->client->trade_name ?: $invoice->client->first_name . ' ' . $invoice->client->last_name) : 'عميل غير معروف' }}</strong>
                                                                        </div>
                                                                        @if ($invoice->client && $invoice->client->tax_number)
                                                                            <div class="tax-info mb-1">
                                                                                <i class="fas fa-hashtag text-muted me-1"></i>
                                                                                <span class="text-muted small">الرقم الضريبي: {{ $invoice->client->tax_number }}</span>
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
                                                                    <div class="d-flex flex-column gap-2" style="margin-bottom: 60px">
                                                                        @php
                                                                            $payments = \App\Models\PaymentsProcess::where('invoice_id', $invoice->id)
                                                                                ->where('type', 'client payments')
                                                                                ->orderBy('created_at', 'desc')
                                                                                ->get();
                                                                        @endphp

                                                                        @if ($invoice->type == 'returned')
                                                                            <span class="badge bg-danger text-white"><i class="fas fa-undo me-1"></i>مرتجع</span>
                                                                        @elseif ($invoice->type == 'normal' && $payments->count() == 0)
                                                                            <span class="badge bg-secondary text-white"><i class="fas fa-file-invoice me-1"></i>أنشئت فاتورة</span>
                                                                        @endif

                                                                        @if ($payments->count() > 0)
                                                                            <span class="badge bg-success text-white"><i class="fas fa-check-circle me-1"></i>أضيفت عملية دفع</span>
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                                <td>
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
                                                                        <span class="badge bg-{{ $statusClass }} text-white status-badge">{{ $statusText }}</span>
                                                                    </div>
                                                                    @php
                                                                        $currency = $account_setting->currency ?? 'SAR';
                                                                        $currencySymbol = $currency == '' || empty($currency)
                                                                            ? '<img src="' . asset('assets/images/Saudi_Riyal.svg') . '" alt="ريال سعودي" width="15" style="vertical-align: middle;">'
                                                                            : $currency;
                                                                    @endphp
                                                                    <div class="amount-info text-center mb-2">
                                                                        <h6 class="amount mb-1">
                                                                            {{ number_format($invoice->grand_total ?? $invoice->total, 2) }}
                                                                            <small class="currency">{!! $currencySymbol !!}</small>
                                                                        </h6>
                                                                        @if ($invoice->due_value > 0)
                                                                            <div class="due-amount">
                                                                                <small class="text-danger">المبلغ المستحق: {{ number_format($invoice->due_value, 2) }} {!! $currencySymbol !!}</small>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="dropdown" onclick="event.stopPropagation()">
                                                                        <button class="btn btn-sm bg-gradient-info fa fa-ellipsis-v" type="button" id="dropdownMenuButton{{ $invoice->id }}" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false"></button>
                                                                        <div class="dropdown-menu">
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
                                        </div>
                                    </div>
                                </div>

                                <!-- تبويب الملاحظات -->
                                <div class="accordion-item">
                                    <h3 class="accordion-header d-flex justify-content-center">
                                        <button class="accordion-button collapsed text-center" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#notes-tab"
                                            aria-expanded="false" aria-controls="notes-tab" style="background-color: #0d6efd; color: white;">
                                            <i class="fas fa-sticky-note me-2"></i> الملاحظات
                                            <span class="badge bg-transparent text-black ms-2 border border-white">{{ $ClientRelations->count() }}</span>
                                        </button>
                                    </h3>
                                    <div id="notes-tab" class="accordion-collapse collapse"
                                        aria-labelledby="notes-tab" data-bs-parent="#clientAccordion">
                                        <div class="accordion-body">
                                            <div class="timeline">
                                                @foreach ($ClientRelations as $note)
                                                    <div class="timeline-item">
                                                        <div class="timeline-content d-flex align-items-start">
                                                            <span class="badge" style="background-color: {{ $statuses->find($client->status_id)->color?? '#007BFF' }}; color: white;">
                                                                {{ $statuses->find($client->status_id)->name ?? '' }}
                                                            </span>
                                                            <div class="note-box border rounded bg-white shadow-sm p-3 ms-3 flex-grow-1">
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <h6 class="mb-0"><i class="fas fa-user"></i> {{ $note->created_by ?? ""}}</h6>
                                                                    <small class="text-muted">
                                                                        <i class="fas fa-clock"></i>
                                                                        {{ $note->created_at->format('H:i d/m/Y') }} - <span class="text-primary">{{ $note->status?? '' }}</span>
                                                                    </small>
                                                                </div>
                                                                <hr> <i class="far fa-user me-1"></i>
                                                                <p class="mb-2">{{ $note->process ?? '' }}</p>
                                                                <small class="text-muted">{{ $note->description ?? '' }}</small>
                                                            </div>
                                                            <div class="timeline-dot bg-danger"></div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- تبويب المدفوعات -->
                                <div class="accordion-item">
                                    <h3 class="accordion-header d-flex justify-content-center">
                                        <button class="accordion-button collapsed text-center" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#payments"
                                            aria-expanded="false" aria-controls="payments" style="background-color: #0d6efd; color: white;">
                                            <i class="fas fa-money-bill-wave me-2"></i> المدفوعات
                                            <span class="badge bg-transparent text-black ms-2 border border-white">{{ $client->payments->count() }}</span>
                                        </button>
                                    </h3>
                                    <div id="payments" class="accordion-collapse collapse"
                                        aria-labelledby="payments" data-bs-parent="#clientAccordion">
                                        <div class="accordion-body">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>رقم الفاتورة</th>
                                                                <th>ملاحظات</th>
                                                                <th>تاريخ الدفع</th>
                                                                <th>بواسطة</th>
                                                                <th>المبلغ</th>
                                                                <th>الحالة</th>
                                                                <th>الإجراءات</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($client->payments as $payment)
                                                                <tr>
                                                                    <td>{{ $payment->id }}</td>
                                                                    <td>{{ $payment->invoice->code ?? 'غير محدد' }}</td>
                                                                    <td>{{ $payment->notes }}</td>
                                                                    <td>{{ $payment->payment_date }}</td>
                                                                    <td>{{ $payment->employee->full_name ?? 'غير محدد' }}</td>
                                                                    <td class="text-end">{{ number_format($payment->amount, 2) }} ر.س</td>
                                                                    <td class="text-center">
                                                                        @php
                                                                            $statusClass = '';
                                                                            $statusText = '';
                                                                            $statusIcon = '';

                                                                            if ($payment->payment_status == 2) {
                                                                                $statusClass = 'badge-warning';
                                                                                $statusText = 'غير مكتمل';
                                                                                $statusIcon = 'fa-clock';
                                                                            } elseif ($payment->payment_status == 1) {
                                                                                $statusClass = 'badge-success';
                                                                                $statusText = 'مكتمل';
                                                                                $statusIcon = 'fa-check-circle';
                                                                            } elseif ($payment->payment_status == 4) {
                                                                                $statusClass = 'badge-info';
                                                                                $statusText = 'تحت المراجعة';
                                                                                $statusIcon = 'fa-sync';
                                                                            } elseif ($payment->payment_status == 5) {
                                                                                $statusClass = 'badge-danger';
                                                                                $statusText = 'فاشلة';
                                                                                $statusIcon = 'fa-times-circle';
                                                                            } elseif ($payment->payment_status == 3) {
                                                                                $statusClass = 'badge-secondary';
                                                                                $statusText = 'مسودة';
                                                                                $statusIcon = 'fa-file-alt';
                                                                            } else {
                                                                                $statusClass = 'badge-light';
                                                                                $statusText = 'غير معروف';
                                                                                $statusIcon = 'fa-question-circle';
                                                                            }
                                                                        @endphp
                                                                        <span class="badge {{ $statusClass }}">
                                                                            <i class="fas {{ $statusIcon }} me-1"></i>
                                                                            {{ $statusText }}
                                                                        </span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="btn-group">
                                                                            <div class="dropdown">
                                                                                <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1" type="button" id="dropdownMenuButton303" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton303">
                                                                                    <li>
                                                                                        <a class="dropdown-item" href="{{ route('paymentsClient.show', $payment->id) }}">
                                                                                            <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                                                        </a>
                                                                                    </li>
                                                                                    <li>
                                                                                        <a class="dropdown-item" href="{{ route('paymentsClient.edit', $payment->id) }}">
                                                                                            <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                                                        </a>
                                                                                    </li>
                                                                                    <form action="{{ route('paymentsClient.destroy', $payment->id) }}" method="POST">
                                                                                        @csrf
                                                                                        @method('DELETE')
                                                                                        <button type="submit" class="dropdown-item" style="border: none; background: none;">
                                                                                            <i class="fa fa-trash me-2 text-danger"></i>
                                                                                            حذف
                                                                                        </button>
                                                                                    </form>
                                                                                    <li>
                                                                                        <a class="dropdown-item" href="#">
                                                                                            <i class="fa fa-envelope me-2 text-warning"></i>ايصال مدفوعات
                                                                                        </a>
                                                                                    </li>
                                                                                    <li>
                                                                                        <a class="dropdown-item" href="#">
                                                                                            <i class="fa fa-envelope me-2 text-warning"></i>ايصال مدفوعات حراري
                                                                                        </a>
                                                                                    </li>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- تبويب حركة الحساب -->
                                <div class="accordion-item">
                                    <h3 class="accordion-header d-flex justify-content-center">
                                        <button class="accordion-button collapsed text-center" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#account-movement"
                                            aria-expanded="false" aria-controls="account-movement" style="background-color: #0d6efd; color: white;">
                                            <i class="fas fa-exchange-alt me-2"></i> حركة الحساب
                                            <span class="badge bg-transparent text-black ms-2 border border-white">{{ $client->transactions->count() }}</span>
                                        </button>
                                    </h3>
                                    <div id="account-movement" class="accordion-collapse collapse"
                                        aria-labelledby="account-movement" data-bs-parent="#clientAccordion">
                                        <div class="accordion-body">
                                            <div class="mb-3">
                                                <div class="row">
                                                    <div class="col-12 d-block d-md-none mb-3">
                                                        <div class="d-flex flex-column gap-2">
                                                            <a href="#" class="btn btn-sm btn-info text-white">
                                                                <i class="fas fa-file-export me-1"></i> خيارات التصدير
                                                            </a>
                                                            <a href="#" class="btn btn-sm btn-light">
                                                                <i class="fas fa-print me-1"></i> طباعة
                                                            </a>
                                                            <a href="#" class="btn btn-sm btn-light">
                                                                <i class="fas fa-cog me-1"></i> تخصيص
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-7 d-none d-md-block">
                                                        <div class="d-flex flex-wrap gap-2">
                                                            <a href="#" class="btn btn-sm btn-info text-white">
                                                                <i class="fas fa-file-export me-1"></i> خيارات التصدير
                                                            </a>
                                                            <a href="#" class="btn btn-sm btn-light">
                                                                <i class="fas fa-print me-1"></i> طباعة
                                                            </a>
                                                            <a href="#" class="btn btn-sm btn-light">
                                                                <i class="fas fa-cog me-1"></i> تخصيص
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-5">
                                                        <div class="d-flex flex-column flex-md-row align-items-center justify-content-end gap-2">
                                                            <div class="form-check form-switch d-flex align-items-center w-100 w-md-auto">
                                                                <input class="form-check-input" type="checkbox" id="showDetails">
                                                                <label class="form-check-label ms-2 w-100 d-flex align-items-center justify-content-between" for="showDetails">
                                                                    <span><i class="fas fa-eye me-2"></i> اعرض التفاصيل</span>
                                                                </label>
                                                            </div>

                                                            <div class="input-group input-group-sm" style="width: 200px;">
                                                                <input type="date" class="form-control" placeholder="الفترة من / إلى">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card">
                                                <div class="card-body p-4">
                                                    <div class="row mb-4">
                                                        <div class="col-md-6 text-start">
                                                            <h5 class="mb-2">{{ $client->trade_name }}</h5>
                                                            <p class="mb-1">{{ $client->city }}</p>
                                                            <p class="mb-1">{{ $client->region }}، {{ $client->city }}</p>
                                                            <p class="mb-0"><strong>التاريخ:</strong> {{ date('d/m/Y') }}</p>
                                                        </div>
                                                        <div class="col-md-6 text-end">
                                                            <h4 class="mb-2">كشف حساب</h4>
                                                            <p class="mb-1">{{ $client->trade_name }}</p>
                                                            <p class="mb-1">{{ $client->region }} - {{ $client->city }}</p>
                                                            <p class="mb-0">{{ $client->country }}</p>
                                                            <p class="mt-2"><strong>حركة الحساب حتى:</strong> {{ date('d/m/Y') }}</p>
                                                        </div>
                                                    </div>

                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-hover mb-0">
                                                            <thead class="bg-dark text-white">
                                                                <tr>
                                                                    <th class="text-end" style="width: 20%;">التاريخ</th>
                                                                    <th class="text-end" style="width: 40%;">العملية</th>
                                                                    <th class="text-start" style="width: 20%;">المبلغ</th>
                                                                    <th class="text-start" style="width: 20%;">المبلغ المتبقي</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $total_amount = 0;
                                                                    $total_due = 0;
                                                                @endphp

                                                                @foreach ($invoices as $invoice)
                                                                    <tr>
                                                                        <td class="text-end">{{ $invoice->invoice_date }}</td>
                                                                        <td class="text-end">
                                                                            @if ($invoice->type == 'returned')
                                                                                مرتجع لفاتورة رقم {{ $invoice->code }}
                                                                            @else
                                                                                فاتورة {{ $invoice->code }}
                                                                            @endif
                                                                        </td>
                                                                        <td class="text-start">{{ number_format($invoice->grand_total, 2) }}</td>
                                                                        <td class="text-start">{{ number_format($invoice->due_value, 2) }}</td>
                                                                    </tr>

                                                                    @php
                                                                        $total_amount += $invoice->grand_total;
                                                                        $total_due += $invoice->due_value;
                                                                    @endphp

                                                                    @foreach ($invoice->payments as $payment)
                                                                        <tr>
                                                                            <td class="text-end">{{ $payment->payment_date }}</td>
                                                                            <td class="text-end">عملية دفع
                                                                                (@if ($payment->Payment_method == 1)
                                                                                    نقدي
                                                                                @elseif ($payment->Payment_method == 2)
                                                                                    شيك
                                                                                @else
                                                                                    بطاقة ائتمان
                                                                                @endif)
                                                                            </td>
                                                                            <td class="text-start">
                                                                                @if ($invoice->advance_payment > 0)
                                                                                    -{{ number_format($invoice->advance_payment, 2) }}
                                                                                @else
                                                                                    {{ number_format($invoice->advance_payment, 2) }}
                                                                                @endif
                                                                            </td>
                                                                            <td class="text-start">{{ number_format($invoice->due_value, 2) }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endforeach
                                                            </tbody>
                                                            <tfoot class="bg-light">
                                                                <tr>
                                                                    <th class="text-end" colspan="2">المجموع الكلي</th>
                                                                    <th class="text-start">{{ number_format($total_amount, 2) }}</th>
                                                                    <th class="text-start">{{ number_format($total_due, 2) }}</th>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- تبويب زيارات العميل -->
                                <div class="accordion-item">
                                    <h3 class="accordion-header d-flex justify-content-center">
                                        <button class="accordion-button collapsed text-center" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#visits-tab"
                                            aria-expanded="false" aria-controls="visits-tab" style="background-color: #0d6efd; color: white;">
                                            <i class="fas fa-walking me-2"></i> زيارات العميل
                                            <span class="badge bg-transparent text-black ms-2 border border-white">{{ $client->visits->count() }}</span>
                                        </button>
                                    </h3>
                                    <div id="visits-tab" class="accordion-collapse collapse"
                                        aria-labelledby="visits-tab" data-bs-parent="#clientAccordion">
                                        <div class="accordion-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>تاريخ الزيارة</th>
                                                            <th>الموظف</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($visits as $visit)
                                                            <tr>
                                                                <td>{{ $visit->id }}</td>
                                                                <td>{{ $visit->visit_date }}</td>
                                                                <td>{{ $visit->employee->name }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- تبويب ملخص الرصيد -->
                                <div class="accordion-item">
                                    <h3 class="accordion-header d-flex justify-content-center">
                                        <button class="accordion-button collapsed text-center" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#balance-summary"
                                            aria-expanded="false" aria-controls="balance-summary" style="background-color: #0d6efd; color: white;">
                                            <i class="fas fa-chart-pie me-2"></i> ملخص الرصيد
                                        </button>
                                    </h3>
                                    <div id="balance-summary" class="accordion-collapse collapse"
                                        aria-labelledby="balance-summary" data-bs-parent="#clientAccordion">
                                        <div class="accordion-body">
                                            <div class="d-flex justify-content-end gap-2 mb-3">
                                                <a href="#" class="btn btn-info text-white">
                                                    <i class="fas fa-plus"></i> أضف شحن الرصيد
                                                </a>
                                                <a href="#" class="btn btn-secondary">
                                                    <i class="fas fa-history"></i> عرض السجل
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
                                </div>

                                <!-- تبويب العضوية -->
                                <div class="accordion-item">
                                    <h3 class="accordion-header d-flex justify-content-center">
                                        <button class="accordion-button collapsed text-center" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#membership"
                                            aria-expanded="false" aria-controls="membership" style="background-color: #0d6efd; color: white;">
                                            <i class="fas fa-id-card me-2"></i> العضوية
                                            <span class="badge bg-transparent text-white ms-2 border border-white">{{ $memberships->count() }}</span>
                                        </button>
                                    </h3>
                                    <div id="membership" class="accordion-collapse collapse"
                                        aria-labelledby="membership" data-bs-parent="#clientAccordion">
                                        <div class="accordion-body">
                                            <div class="card">
                                                <div class="card-body">
                                                    <table class="table" style="font-size: 1.1rem;">
                                                        <thead>
                                                            <tr>
                                                                <th>المعرف</th>
                                                                <th>بيانات العميل</th>
                                                                <th>الباقة الحالية</th>
                                                                <th>تاريخ الانتهاء</th>
                                                                <th>الحالة</th>
                                                                <th>ترتيب بواسطة</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($memberships as $membership)
                                                                <tr>
                                                                    <td>#{{ $membership->id }}</td>
                                                                    <td>
                                                                        <div class="d-flex align-items-center gap-2">
                                                                            <div class="avatar avatar-sm bg-danger">
                                                                                <span class="avatar-content">أ</span>
                                                                            </div>
                                                                            <div>
                                                                                {{ $membership->client->first_name ?? '' }}
                                                                                <br>
                                                                                <small class="text-muted"></small>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td><br><small class="text-muted">{{ $membership->packege->commission_name ?? '' }}</small></td>
                                                                    <td><small class="text-muted">{{ $membership->end_date ?? '' }}</small></td>
                                                                    <td>
                                                                        <div class="d-flex align-items-center gap-2">
                                                                            <div class="rounded-circle bg-info" style="width: 8px; height: 8px;"></div>
                                                                            <span class="text-muted">
                                                                                @if ($membership->status == 'active')
                                                                                    نشط
                                                                                @else
                                                                                    غير نشط
                                                                                @endif
                                                                            </span>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="btn-group">
                                                                            <div class="dropdown">
                                                                                <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1 btn-sm" type="button" id="dropdownMenuButton303" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton303">
                                                                                    <li>
                                                                                        <a class="dropdown-item" href="{{ route('Memberships.show', $membership->id) }}">
                                                                                            <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                                                        </a>
                                                                                    </li>
                                                                                    <li>
                                                                                        <a class="dropdown-item" href="{{ route('Memberships.edit', $membership->id) }}">
                                                                                            <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                                                        </a>
                                                                                    </li>
                                                                                    <li>
                                                                                        <a class="dropdown-item text-danger" href="{{ route('Memberships.delete', $membership->id) }}">
                                                                                            <i class="fa fa-trash me-2"></i>حذف
                                                                                        </a>
                                                                                    </li>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- تبويب الحجوزات -->
                                <div class="accordion-item">
                                    <h3 class="accordion-header d-flex justify-content-center">
                                        <button class="accordion-button collapsed text-center" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#reservations"
                                            aria-expanded="false" aria-controls="reservations" style="background-color: #0d6efd; color: white;">
                                            <i class="fas fa-bookmark me-2"></i> الحجوزات
                                            <span class="badge bg-transparent text-white ms-2 border border-white">{{ $bookings->count() }}</span>
                                        </button>
                                    </h3>
                                    <div id="reservations" class="accordion-collapse collapse"
                                        aria-labelledby="reservations" data-bs-parent="#clientAccordion">
                                        <div class="accordion-body">
                                            <div class="card">
                                                <div class="card-body">
                                                    @foreach ($bookings as $booking)
                                                        <div class="row">
                                                            <div class="col-auto">
                                                                <div style="width: 50px; height: 50px; background-color: #f0f0f0; border-radius: 5px;"></div>
                                                            </div>
                                                            <div class="col">
                                                                <h6>بيانات العميل</h6>
                                                                <p class="mb-1">{{ $booking->client->first_name ?? '' }}</p>
                                                                <p class="mb-1">الخدمة: {{ $booking->product->name ?? '' }}</p>
                                                            </div>
                                                            <div class="col-auto text-end">
                                                                <p class="mb-1">الوقت من {{ $booking->start_time ?? 0 }} الى {{ $booking->end_time ?? 0 }}</p>
                                                                <p class="text-muted small mb-0">16:45:00</p>

                                                                @if ($booking->status == 'confirm')
                                                                    <span class="badge bg-warning text-dark">مؤكد</span>
                                                                @elseif ($booking->status == 'review')
                                                                    <span class="badge bg-warning text-dark">تحت المراجعة</span>
                                                                @elseif ($booking->status == 'bill')
                                                                    <span class="badge bg-warning text-dark">حولت للفاتورة</span>
                                                                @elseif ($booking->status == 'cancel')
                                                                    <span class="badge bg-warning text-dark">تم الالغاء</span>
                                                                @else
                                                                    <span class="badge bg-warning text-dark">تم</span>
                                                                @endif

                                                                <a href="{{ route('Reservations.show', $booking->id) }}" class="badge bg-danger text-dark">عرض</a>
                                                                <a href="{{ route('Reservations.edit', $booking->id) }}" class="btn btn-sm btn-primary">
                                                                    <i class="fa fa-edit"></i> تعديل
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- تبويب الخدمات -->
                                <div class="accordion-item">
                                    <h3 class="accordion-header d-flex justify-content-center">
                                        <button class="accordion-button collapsed text-center" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#services"
                                            aria-expanded="false" aria-controls="services" style="background-color: #0d6efd; color: white;">
                                            <i class="fas fa-tools me-2"></i> الخدمات
                                        </button>
                                    </h3>
                                    <div id="services" class="accordion-collapse collapse"
                                        aria-labelledby="services" data-bs-parent="#clientAccordion">
                                        <div class="accordion-body">
                                            <p class="text-muted">خدمات العميل</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 

        <!-- Modal إضافة الرصيد الافتتاحي -->
        <div class="modal fade" id="openingBalanceModal" tabindex="-1" aria-labelledby="openingBalanceModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="openingBalanceModalLabel">إضافة رصيد افتتاحي</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="openingBalanceForm">
                            <div class="mb-3">
                                <label for="openingBalance" class="form-label">الرصيد الافتتاحي</label>
                                <input type="number" class="form-control" id="openingBalance" name="opening_balance"
                                    value="{{ $client->opening_balance ?? 0 }}" step="0.01">
                            </div>
                            <input type="hidden" id="clientId" value="{{ $client->id }}">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                        <button type="button" class="btn btn-primary" onclick="saveOpeningBalance()">حفظ</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection
@section('scripts')

    <script>
        $(document).ready(function() {
            // تأكيد حذف الموظف
            $('.btn-remove-employee').on('click', function(e) {
                if (!confirm('هل أنت متأكد من إزالة هذا الموظف؟')) {
                    e.preventDefault();
                }
            });
        });
    </script>
    <script>
        function updateClientStatus(selectElement) {
            var status = selectElement.value; // الحصول على القيمة المحددة
            var clientId = "{{ $client->id }}"; // تأكد من أن لديك معرف العميل في الصفحة

            fetch(`/clients/clients_management/clients/${clientId}/update-status`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        notes: status
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("تم تحديث الحالة بنجاح!");
                    } else {
                        alert("حدث خطأ أثناء تحديث الحالة.");
                    }
                })
                .catch(error => console.error("Error:", error));
        }
    </script>
    <script>
        function saveOpeningBalance() {
            let clientId = document.getElementById('clientId').value;
            let openingBalance = document.getElementById('openingBalance').value;

            fetch(`/clients/clients_management/${clientId}/update-opening-balance`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        opening_balance: openingBalance
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('تم تحديث الرصيد الافتتاحي بنجاح!');
                        location.reload();
                    } else {
                        alert('حدث خطأ أثناء التحديث، يرجى المحاولة مجدداً.');
                    }
                })
                .catch(error => console.error('❌ خطأ:', error));
        }

        function selectStatus(name, color) {
            document.getElementById("clientStatusDropdown").innerHTML =
                `<span class="status-color" style="background-color: ${color};"></span> ${name}`;
        }
    </script>


    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('assets/js/applmintion.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection
