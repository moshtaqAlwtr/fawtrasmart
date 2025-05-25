@extends('master')

@section('title')
    العملاء
@stop
@section('head')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
@endsection
@section('css')
    <style>
        /* Responsive CSS */
        @media (max-width: 768px) {
            .mobile-stack {
                flex-direction: column !important;
            }

            .mobile-full-width {
                width: 100% !important;
            }

            .mobile-text-center {
                text-align: center !important;
            }

            .mobile-mt-2 {
                margin-top: 1rem !important;
            }

            .mobile-hide {
                display: none !important;
            }

            .table-responsive {
                font-size: 0.875rem;
            }

            .card-body {
                padding: 1rem;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            .tablet-stack {
                flex-direction: column !important;
            }

            .tablet-text-center {
                text-align: center !important;
            }
        }

        /* Card Styles */
        .card {
            transition: all 0.3s ease;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
        }

        .card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Button & Badge Styles */
        .btn {
            border-radius: 0.25rem;
            transition: all 0.2s ease;
        }

        .badge {
            padding: 0.5em 0.75em;
            border-radius: 0.25rem;
        }

        /* Section Styles */
        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .info-group {
            margin-bottom: 0.5rem;
        }

        .info-label {
            font-weight: 600;
            color: #6c757d;
        }

        /* Timeline Styles */
        .timeline {
            position: relative;
            padding: 1rem 0;
        }

        .timeline-item {
            padding: 1rem;
            border-left: 2px solid #e9ecef;
            margin-left: 1rem;
            position: relative;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -0.5rem;
            top: 1.5rem;
            width: 1rem;
            height: 1rem;
            border-radius: 50%;
            background: #fff;
            border: 2px solid #007bff;
        }

        /* Table Styles */
        .custom-table {
            width: 100%;
        }

        .custom-table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .custom-table td,
        .custom-table th {
            padding: 0.75rem;
            vertical-align: middle;
        }

        /* Status Colors */
        .status-badge {
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 600;
            border-radius: 0.25rem;
        }

        .status-success {
            background-color: #d1e7dd;
            color: #0f5132;
        }

        .status-warning {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-danger {
            background-color: #f8d7da;
            color: #842029;
        }

        .status-info {
            background-color: #cff4fc;
            color: #055160;
        }

        /* Dropdown Menu */
        .dropdown-menu {
            border-radius: 0.25rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
        }

        .dropdown-item i {
            margin-right: 0.5rem;
            width: 1.25rem;
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
                        <small class="text-muted">#{{ $client->code }}</small>
                        <span class="badge"
                            style="background-color: {{ $statuses->find($client->status_id)->color ?? '#007BFF' }}; color: white;">
                            {{ $statuses->find($client->status_id)->name ?? 'غير محدد' }}
                        </span>
                        <br>
                        <small class="text-muted">
                            حساب الأستاذ:
                            <small class="text-muted">
                                حساب الأستاذ:
                                @if ($client->account_client && $client->account_client->client_id == $client->id)
                                    <a
                                        href="{{ route('journal.generalLedger', ['account_id' => $client->account_client->id]) }}">
                                        {{ $client->account_client->name ?? '' }}
                                        #{{ $client->account_client->code ?? '' }}
                                    </a>
                                @else
                                    <span>لا يوجد حساب مرتبط</span>
                                @endif
                            </small>

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
                            <strong class="text-dark">{{ $due ?? 0 }}</strong> <span
                                class="text-muted">{!! $currencySymbol !!}</span>
                            <span class="d-block text-danger">المطلوب دفعة</span>
                        </div>
                        {{-- @if ($invoices->isNotEmpty())
                            <div class="text-muted">
                                <strong class="text-dark">{{ $invoice_due ?? 0 }}</strong> <span class="text-muted"></span>
                                <span class="d-block text-warning">مفتوح</span>
                            </div>
                        @endif --}}
                    </div>
                    @if (auth()->user()->role === 'manager')
                        <div class="mt-4">
                            <h6>!</h6>
                            <div class="d-flex flex-wrap gap-2" id="assignedEmployeesList">
                                @if ($client->employees && $client->employees->count() > 0)
                                    @foreach ($client->employees as $employee)
                                        <span class="badge bg-primary d-flex align-items-center">
                                            {{ $employee->full_name }}

                                            <form action="{{ route('clients.remove-employee', $client->id) }}"
                                                method="POST" class="ms-2">
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
                    @endif
                    @php
                        // جلب الحالة الحالية للعميل من العلاقة
                        $currentStatus = $client->status;
                    @endphp


                    <div class="d-flex flex-wrap gap-2">
                        <div class="d-flex flex-wrap gap-2">
                            <!-- قائمة تغيير الحالة -->
                            <form method="POST" action="{{ route('clients.updateStatusClient') }}" class="flex-grow-1"
                                style="min-width: 220px;">
                                @csrf
                                <input type="hidden" name="client_id" value="{{ $client->id }}">
                                <div class="dropdown w-100">
                                    <button class="btn w-100 text-start dropdown-toggle" type="button"
                                        id="clientStatusDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                                        style="background-color: {{ $currentStatus->color ?? '#e0f7fa' }};
                           color: #000;
                           border: 1px solid #ccc;
                           height: 42px;">
                                        {{ $currentStatus->name ?? 'اختر الحالة' }}
                                    </button>

                                    <ul class="dropdown-menu w-100" aria-labelledby="clientStatusDropdown"
                                        style="border-radius: 8px;">
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

                            <!-- قائمة خيارات أخرى -->
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <div class="card border-0">
            <div class="card-body d-flex justify-content-between align-items-center">
                <!-- القسم الأيمن (الاسم والموقع) - يظهر فقط في الشاشات الكبيرة -->
                <div class="text-end d-none d-md-block">
                    <strong class="text-dark">{{ $client->first_name }}</strong>
                    <br>
                    <span class="text-primary">
                        <i class="fas fa-map-marker-alt"></i> {{ $client->full_address }}
                    </span>
                </div>

                <!-- القسم الأيسر (رقم الهاتف) - يظهر فقط في الشاشات الكبيرة -->
                <div class="d-flex align-items-center d-none d-md-flex">
                    <button class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-copy"></i>
                    </button>
                    <span class="mx-2 text-dark">{{ $client->phone }}</span>
                    <button class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-mobile-alt"></i>
                    </button>
                </div>



                <!-- القائمة الأصلية (تظهر فقط في الشاشات الكبيرة) -->
                <div class="dropdown col-12 col-md-auto d-none d-md-block">
                    <a href="#" class="btn btn-sm btn-outline-dark dropdown-toggle w-100 text-start text-md-center"
                        role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-ellipsis-v me-1"></i> خيارات أخرى
                    </a>
                    <ul class="dropdown-menu w-100">
                        <li><a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal"
                                data-bs-target="#openingBalanceModal">
                                <i class="fas fa-wallet me-2 text-success"></i> إضافة رصيد افتتاحي
                            </a></li>
                        <li><a class="dropdown-item d-flex align-items-center" href="{{ route('SupplyOrders.create') }}">
                                <i class="fas fa-truck me-2 text-info"></i> إضافة أمر توريد
                            </a></li>
                        <li><a class="dropdown-item d-flex align-items-center" href="#">
                                <i class="fas fa-user me-2 text-primary"></i> الدخول كعميل
                            </a></li>
                        <li><a class="dropdown-item d-flex align-items-center text-danger"
                                href="{{ route('clients.destroy', $client->id) }}">
                                <i class="fas fa-trash-alt me-2"></i> حذف عميل
                            </a></li>
                    </ul>
                </div>
            </div>
        </div>



        <div class="card">
            <div class="card-body">
                <!-- أزرار القائمة (تظهر فقط على الشاشات الكبيرة) -->
                <div class="d-grid d-md-flex flex-wrap gap-2 d-none d-md-block">
                    <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-sm btn-info col-md-auto">
                        <i class="fas fa-user-edit me-1"></i> تعديل
                    </a>
                    <a href="{{ route('appointment.notes.create', $client->id) }}"
                        class="btn btn-sm btn-secondary col-md-auto">
                        <i class="fas fa-paperclip me-1"></i> إضافة ملاحظة/مرفق
                    </a>
                    <a href="{{ route('appointments.create') }}" class="btn btn-sm btn-success col-md-auto">
                        <i class="fas fa-calendar-plus me-1"></i> ترتيب موعد
                    </a>
                    <a href="{{ route('clients.statement', $client->id) }}" class="btn btn-sm btn-warning col-md-auto">
                        <i class="fas fa-file-invoice me-1"></i> كشف حساب
                    </a>
                    <a href="{{ route('questions.create') }}" class="btn btn-sm btn-warning col-md-auto">
                        <i class="fas fa-file-signature me-1"></i> إنشاء عرض سعر
                    </a>
                    <a href="{{ route('CreditNotes.create') }}" class="btn btn-sm btn-danger col-md-auto">
                        <i class="fas fa-file-invoice-dollar me-1"></i> إنشاء إشعار دائن
                    </a>

                    <a href="{{ route('invoices.create') }}?client_id={{ $client->id }}"
                        class="btn btn-sm btn-dark col-md-auto">

                        <a href="{{ route('invoices.create', ['client_id' => $client->id]) }}"
                            class="btn btn-sm btn-dark col-md-auto">

                            <i class="fas fa-file-invoice me-1"></i> إنشاء فاتورة
                        </a>
                        <a href="{{ route('Reservations.client', $client->id) }}"
                            class="btn btn-sm btn-light text-dark col-md-auto">
                            <i class="fas fa-calendar-check me-1"></i> الحجوزات
                        </a>
                </div>

                <!-- زر واحد يحتوي على القائمة المنسدلة (يظهر فقط على الشاشات الصغيرة) -->
                <div class="dropdown d-md-none">
                    <button class="btn btn-primary w-100 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-bars me-1"></i> خيارات
                    </button>
                    <ul class="dropdown-menu w-100">
                        <li><a class="dropdown-item d-flex align-items-center"
                                href="{{ route('clients.edit', $client->id) }}">
                                <i class="fas fa-user-edit me-2 text-info"></i> تعديل
                            </a></li>
                        <li><a class="dropdown-item d-flex align-items-center"
                                href="{{ route('appointment.notes.create', $client->id) }}">
                                <i class="fas fa-paperclip me-2 text-secondary"></i> إضافة ملاحظة/مرفق
                            </a></li>
                        <li><a class="dropdown-item d-flex align-items-center" href="{{ route('appointments.create') }}">
                                <i class="fas fa-calendar-plus me-2 text-success"></i> ترتيب موعد
                            </a></li>
                        <li><a class="dropdown-item d-flex align-items-center"
                                href="{{ route('clients.statement', $client->id) }}">
                                <i class="fas fa-file-invoice me-2 text-warning"></i> كشف حساب
                            </a></li>
                        <li><a class="dropdown-item d-flex align-items-center" href="{{ route('questions.create') }}">
                                <i class="fas fa-file-signature me-2 text-warning"></i> إنشاء عرض سعر
                            </a></li>
                        <li><a class="dropdown-item d-flex align-items-center" href="{{ route('CreditNotes.create') }}">
                                <i class="fas fa-file-invoice-dollar me-2 text-danger"></i> إنشاء إشعار دائن
                            </a></li>
                        <li><a class="dropdown-item d-flex align-items-center" href="{{ route('invoices.create') }}">
                                <i class="fas fa-file-invoice me-2 text-dark"></i> إنشاء فاتورة
                            </a></li>
                        <li><a class="dropdown-item d-flex align-items-center"
                                href="{{ route('Reservations.client', $client->id) }}">
                                <i class="fas fa-calendar-check me-2 text-dark"></i> الحجوزات
                            </a></li>
                    </ul>
                </div>
            </div>
        </div>



        {{-- التبويبات --}}
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-wrap justify-content-start gap-2 w-100">
                    <!-- زر التفاصيل -->
                    <div class="col-lg-12 col-md-12 col-12 mb-2">
                        <button class="btn btn-outline-primary w-100" type="button" data-bs-toggle="collapse"
                            data-bs-target="#details">
                            <i class="fas fa-info-circle me-2"></i> التفاصيل
                        </button>
                        <!-- محتوى التفاصيل -->
                        <div id="details" class="collapse mt-2">
                            <div class="card card-body">
                                <!-- محتوى التفاصيل هنا -->
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <p class="mb-2"><strong>الاسم التجاري:</strong> {{ $client->trade_name }}</p>
                                        <p class="mb-2"><strong>الاسم الأول:</strong> {{ $client->first_name }}</p>
                                        <p class="mb-2"><strong>الاسم الأخير:</strong> {{ $client->last_name }}</p>
                                        <p class="mb-2"><strong>رقم الهاتف:</strong> {{ $client->phone }}</p>
                                        <p class="mb-2"><strong>الجوال:</strong> {{ $client->mobile }}</p>
                                        <p class="mb-2 text-break"><strong>البريد الإلكتروني:</strong>
                                            {{ $client->email }}</p>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <p class="mb-2"><strong>العنوان:</strong> {{ $client->street1 }}
                                            {{ $client->street2 }}</p>
                                        <p class="mb-2"><strong>المدينة:</strong> {{ $client->city }}</p>
                                        <p class="mb-2"><strong>المنطقة:</strong> {{ $client->region }}</p>
                                        <p class="mb-2"><strong>الرمز البريدي:</strong> {{ $client->postal_code }}</p>
                                        <p class="mb-2"><strong>الدولة:</strong> {{ $client->country }}</p>
                                        <p class="mb-2"><strong>الرقم الضريبي:</strong> {{ $client->tax_number }}</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <p class="mb-2"><strong>السجل التجاري:</strong>
                                            {{ $client->commercial_registration }}</p>
                                        <p class="mb-2"><strong>حد الائتمان:</strong> {{ $client->credit_limit }}</p>
                                        <p class="mb-2"><strong>فترة الائتمان:</strong> {{ $client->credit_period }} يوم
                                        </p>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <p class="mb-2"><strong>طريقة الطباعة:</strong>
                                            @if ($client->printing_method == 1)
                                                طباعة عادية
                                            @elseif($client->printing_method == 2)
                                                طباعة حرارية
                                            @else
                                                غير محدد
                                            @endif
                                        </p>
                                        <p class="mb-2"><strong>نوع العميل:</strong>
                                            @if ($client->client_type == 1)
                                                فرد
                                            @elseif($client->client_type == 2)
                                                شركة
                                            @else
                                                غير محدد
                                            @endif
                                        </p>
                                        <p class="mb-2"><strong>الرصيد الافتتاحي:</strong>
                                            {{ $client->opening_balance }}</p>
                                        <p class="mb-2"><strong>تاريخ الرصيد الافتتاحي:</strong>
                                            {{ $client->opening_balance_date }}</p>
                                    </div>
                                </div>

                                @if ($client->notes)
                                    <hr>
                                    <div class="row">
                                        <div class="col-12">
                                            <p><strong>ملاحظات:</strong></p>
                                            <p class="text-break">{{ $client->notes }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- زر المواعيد -->
                    <div class="col-lg-12 col-md-12 col-12 mb-2">
                        <!-- زر التفعيل - باق كما هو -->
                        <button class="btn btn-outline-primary w-100" type="button" data-bs-toggle="collapse"
                            data-bs-target="#appointments">
                            <i class="fas fa-calendar-alt me-2"></i> المواعيد
                        </button>

                        <!-- محتوى المواعيد - تحسينات للتوافق مع الأجهزة -->
                        <div id="appointments" class="collapse mt-2">
                            <div class="card card-body p-0"> <!-- إضافة p-0 لإزالة الباد الداخلي -->
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

                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <button class="btn btn-sm btn-outline-primary filter-appointments" data-filter="all">
                                        الكل <span class="badge badge-light">{{ $client->appointments->count() }}</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-success filter-appointments"
                                        data-filter="{{ App\Models\Appointment::STATUS_COMPLETED }}">
                                        تم <span class="badge badge-light">{{ $completedAppointments->count() }}</span>
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
                                                            <td>{{ $appointment->created_at->format('Y-m-d H:i') }}</td>
                                                            <td>{{ $appointment->employee->name ?? 'غير محدد' }}</td>
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
                                                                        data-toggle="dropdown" aria-haspopup="true"
                                                                        aria-expanded="false"></button>
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
                                                                            <button type="submit" class="dropdown-item">
                                                                                <i
                                                                                    class="fa fa-check me-2 text-success"></i>تم
                                                                            </button>
                                                                        </form>
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

                    <!-- زر الفواتير -->
                    <div class="col-lg-12 col-md-12 col-12 mb-2">
                        <button class="btn btn-outline-primary w-100" type="button" data-bs-toggle="collapse"
                            data-bs-target="#invoices">
                            <i class="fas fa-file-invoice me-2"></i> الفواتير
                        </button>
                        <!-- محتوى الفواتير -->
                        <div id="invoices" class="collapse mt-2">
                            <div class="card card-body">
                                <!-- محتوى الفواتير هنا -->
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
                                                <tr class="align-middle invoice-row"
                                                    onclick="window.location.href='{{ route('invoices.show', $invoice->id) }}'"
                                                    style="cursor: pointer;"
                                                    data-status="{{ $invoice->payment_status }}">
                                                    <td onclick="event.stopPropagation()">
                                                        <input type="checkbox" class="invoice-checkbox" name="invoices[]"
                                                            value="{{ $invoice->id }}">
                                                    </td>
                                                    <td class="text-center border-start"><span
                                                            class="invoice-number">#{{ $invoice->id }}</span></td>
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
                                                        <div class="d-flex flex-column gap-2" style="margin-bottom: 60px">
                                                            @php
                                                                $payments = \App\Models\PaymentsProcess::where(
                                                                    'invoice_id',
                                                                    $invoice->id,
                                                                )
                                                                    ->where('type', 'client payments')
                                                                    ->orderBy('created_at', 'desc')
                                                                    ->get();
                                                            @endphp

                                                            @if ($invoice->type == 'returned')
                                                                <span class="badge bg-danger text-white"><i
                                                                        class="fas fa-undo me-1"></i>مرتجع</span>
                                                            @elseif ($invoice->type == 'normal' && $payments->count() == 0)
                                                                <span class="badge bg-secondary text-white"><i
                                                                        class="fas fa-file-invoice me-1"></i>أنشئت
                                                                    فاتورة</span>
                                                            @endif

                                                            @if ($payments->count() > 0)
                                                                <span class="badge bg-success text-white"><i
                                                                        class="fas fa-check-circle me-1"></i>أضيفت عملية
                                                                    دفع</span>
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
                                                            <span
                                                                class="badge bg-{{ $statusClass }} text-white status-badge">{{ $statusText }}</span>
                                                        </div>
                                                        @php
                                                            $currency = $account_setting->currency ?? 'SAR';
                                                            $currencySymbol =
                                                                $currency == '' || empty($currency)
                                                                    ? '<img src="' .
                                                                        asset('assets/images/Saudi_Riyal.svg') .
                                                                        '" alt="ريال سعودي" width="15" style="vertical-align: middle;">'
                                                                    : $currency;
                                                        @endphp
                                                        <div class="amount-info text-center mb-2">
                                                            <h6 class="amount mb-1">
                                                                {{ number_format($invoice->grand_total ?? $invoice->total, 2) }}
                                                                <small class="currency">{!! $currencySymbol !!}</small>
                                                            </h6>
                                                            @if ($invoice->due_value > 0)
                                                                <div class="due-amount">
                                                                    <small class="text-danger">المبلغ المستحق:
                                                                        {{ number_format($invoice->due_value, 2) }}
                                                                        {!! $currencySymbol !!}</small>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="dropdown" onclick="event.stopPropagation()">
                                                            <button class="btn btn-sm bg-gradient-info fa fa-ellipsis-v"
                                                                type="button"
                                                                id="dropdownMenuButton{{ $invoice->id }}"
                                                                data-bs-toggle="dropdown" data-bs-auto-close="outside"
                                                                aria-haspopup="true" aria-expanded="false"></button>
                                                            <div class="dropdown-menu">
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
                                                                    <i class="fa fa-envelope me-2 text-warning"></i>إرسال
                                                                    إلى العميل
                                                                </a>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('paymentsClient.create', ['id' => $invoice->id]) }}">
                                                                    <i class="fa fa-credit-card me-2 text-info"></i>إضافة
                                                                    عملية دفع
                                                                </a>
                                                                <a class="dropdown-item" href="#">
                                                                    <i class="fa fa-copy me-2 text-secondary"></i>نسخ
                                                                </a>
                                                                <form
                                                                    action="{{ route('invoices.destroy', $invoice->id) }}"
                                                                    method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="dropdown-item text-danger">
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

                    <!-- زر الملاحظات -->
                    <div class="col-lg-12 col-md-12 col-12 mb-2">
                        <button class="btn btn-outline-primary w-100" type="button" data-bs-toggle="collapse"
                            data-bs-target="#notes">
                            <i class="fas fa-sticky-note me-2"></i> الملاحظات
                        </button>
                        <!-- محتوى الملاحظات -->
                        <div id="notes" class="collapse mt-2">
    <div class="card card-body">
        <!-- الملاحظات -->
        <div class="timeline">
            @foreach ($ClientRelations as $note)
                <div class="timeline-item mb-4">
                    <div class="timeline-content d-flex align-items-start flex-wrap flex-md-nowrap">
                        <!-- الحالة -->
                        <span class="badge mb-2 mb-md-0"
                            style="background-color: {{ $statuses->find($client->status_id)->color ?? '#007BFF' }}; color: white;">
                            {{ $statuses->find($client->status_id)->name ?? '' }}
                        </span>

                        <!-- مربع الملاحظة -->
                        <div class="note-box border rounded bg-white shadow-sm p-3 ms-md-3 mt-2 mt-md-0 flex-grow-1 w-100">
                            <!-- الرأس -->
                            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center">
                                <h6 class="mb-2 mb-sm-0">
                                    <i class="fas fa-user me-1"></i> {{ $note->employee->name ?? '' }}
                                </h6>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $note->created_at->format('H:i d/m/Y') }} -
                                    <span class="text-primary">{{ $note->status ?? '' }}</span>
                                </small>
                            </div>

                            <hr class="my-2">

                            <!-- النص -->
                            <p class="mb-2">
                                <i class="far fa-user me-1"></i> {{ $note->process ?? '' }}
                            </p>
                            <small class="text-muted d-block mb-2">{{ $note->description ?? '' }}</small>

                            <!-- عرض المرفقات -->
                            @php
                                $files = json_decode($note->attachments, true);
                                $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                            @endphp

                            @if (is_array($files) && count($files))
                                <div class="attachment mt-3 d-flex flex-wrap gap-2">
                                    @foreach ($files as $file)
                                        @php
                                            $ext = pathinfo($file, PATHINFO_EXTENSION);
                                            $fileUrl = asset('assets/uploads/notes/' . $file);
                                        @endphp

                                        @if (in_array(strtolower($ext), $imageExtensions))
                                            <a href="{{ $fileUrl }}" target="_blank" class="d-block">
                                                <img src="{{ $fileUrl }}"
                                                    alt="مرفق صورة"
                                                    class="img-fluid rounded border"
                                                    style="max-width: 180px; height: auto;">
                                            </a>
                                        @else
                                            <a href="{{ $fileUrl }}" target="_blank"
                                                class="btn btn-sm btn-outline-primary d-flex align-items-center">
                                                <i class="fas fa-file-alt me-2"></i> عرض الملف: {{ $file }}
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- نقطة الخط الزمني -->
                        <div class="timeline-dot bg-danger d-none d-md-block ms-3 mt-2"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

                    </div>

                    <!-- زر المدفوعات -->
                    <div class="col-lg-12 col-md-12 col-12 mb-2">
                        <button class="btn btn-outline-primary w-100" type="button" data-bs-toggle="collapse"
                            data-bs-target="#payments">
                            <i class="fas fa-money-bill-wave me-2"></i> المدفوعات
                        </button>
                        <!-- محتوى المدفوعات -->
                        <div id="payments" class="collapse mt-2">
                            <div class="card card-body">
                                <!-- محتوى المدفوعات هنا -->
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
                                                    <td class="text-end">{{ number_format($payment->amount, 2) }} ر.س
                                                    </td>
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
                                                                <button
                                                                    class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1"
                                                                    type="button" id="dropdownMenuButton303"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false"></button>
                                                                <div class="dropdown-menu"
                                                                    aria-labelledby="dropdownMenuButton303">
                                                                    <li>
                                                                        <a class="dropdown-item"
                                                                            href="{{ route('paymentsClient.show', $payment->id) }}">
                                                                            <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item"
                                                                            href="{{ route('paymentsClient.edit', $payment->id) }}">
                                                                            <i
                                                                                class="fa fa-edit me-2 text-success"></i>تعديل
                                                                        </a>
                                                                    </li>
                                                                    <form
                                                                        action="{{ route('paymentsClient.destroy', $payment->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="dropdown-item"
                                                                            style="border: none; background: none;">
                                                                            <i class="fa fa-trash me-2 text-danger"></i>
                                                                            حذف
                                                                        </button>
                                                                    </form>
                                                                    <li>
                                                                        <a class="dropdown-item" href="#">
                                                                            <i
                                                                                class="fa fa-envelope me-2 text-warning"></i>ايصال
                                                                            مدفوعات
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item" href="#">
                                                                            <i
                                                                                class="fa fa-envelope me-2 text-warning"></i>ايصال
                                                                            مدفوعات حراري
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

                    <!-- زر حركة الحساب -->
                    <div class="col-lg-12 col-md-12 col-12 mb-2">
                        <button class="btn btn-outline-primary w-100" type="button" data-bs-toggle="collapse"
                            data-bs-target="#account">
                            <i class="fas fa-exchange-alt me-2"></i> حركة الحساب
                        </button>
                        <!-- محتوى حركة الحساب -->
                        <div id="account" class="collapse mt-3">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body p-3">


                                    <!-- جدول حركة الحساب -->
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-header bg-white border-bottom py-3">
                                            <h5 class="mb-0"><i class="fas fa-exchange-alt me-2 text-primary"></i> حركة
                                                الحساب</h5>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-hover mb-0">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th class="text-end" style="width: 15%;">التاريخ</th>
                                                            <th class="text-end" style="width: 40%;">الوصف</th>
                                                            <th class="text-center" style="width: 20%;">القيمة</th>
                                                            <th class="text-center" style="width: 25%;">الرصيد بعد العملية
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($operationsPaginator as $operation)
                                                            <tr>
                                                                <td class="text-end">
                                                                    {{ \Carbon\Carbon::parse($operation['date'])->format('d/m/Y') }}
                                                                </td>
                                                                <td class="text-end">{{ $operation['operation'] }}</td>
                                                                <td
                                                                    class="text-center {{ $operation['deposit'] ? 'text-success' : 'text-danger' }}">
                                                                    @if ($operation['deposit'])
                                                                        +{{ number_format($operation['deposit'], 2) }}
                                                                    @elseif($operation['withdraw'])
                                                                        -{{ number_format($operation['withdraw'], 2) }}
                                                                    @else
                                                                        0.00
                                                                    @endif
                                                                </td>
                                                                <td
                                                                    class="text-center {{ $operation['balance_after'] < 0 ? 'text-danger' : 'text-success' }}">
                                                                    {{ number_format($operation['balance_after'], 2) }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot class="table-light">
                                                        <tr>
                                                            <th colspan="2" class="text-end">الرصيد النهائي</th>
                                                            <th
                                                                class="text-center {{ ($account->balance ?? 0) < 0 ? 'text-danger' : 'text-success' }}">
                                                                {{ number_format($account->balance ?? 0, 2) }}
                                                            </th>
                                                            <th></th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-white py-3">
                                            <!-- هنا يمكنك إضافة الترقيم إذا كنت تستخدم pagination -->
                                            {{ $operationsPaginator->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- زر زيارات العميل -->
                    <div class="col-lg-12 col-md-12 col-12 mb-2">
                        <button class="btn btn-outline-primary w-100" type="button" data-bs-toggle="collapse"
                            data-bs-target="#visits">
                            <i class="fas fa-walking me-2"></i> زيارات العميل
                        </button>
                        <!-- محتوى زيارات العميل -->
                        <div id="visits" class="collapse mt-2">
                            <div class="card card-body">
                                <!-- محتوى زيارات العميل هنا -->
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>تاريخ الزيارة</th>
                                                <th>وقت الانصراف</th>
                                                <th>الموظف</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($visits as $visit)
                                                <tr>
                                                    <td>{{ $visit->id }}</td>
                                                    <td>{{ $visit->visit_date }}</td>
                                                    <td>{{ $visit->departure_time }}</td>
                                                    <td>{{ $visit->employee->name ?? 'غير محدد' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- زر ملخص الرصيد -->
                    <div class="col-lg-12 col-md-12 col-12 mb-2">
                        <button class="btn btn-outline-primary w-100" type="button" data-bs-toggle="collapse"
                            data-bs-target="#balance">
                            <i class="fas fa-chart-pie me-2"></i> ملخص الرصيد
                        </button>
                        <!-- محتوى ملخص الرصيد -->
                        <div id="balance" class="collapse mt-2">
                            <div class="card card-body">
                                <!-- محتوى ملخص الرصيد هنا -->
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

                    <!-- زر العضوية -->
                    <div class="col-lg-12 col-md-12 col-12 mb-2">
                        <button class="btn btn-outline-primary w-100" type="button" data-bs-toggle="collapse"
                            data-bs-target="#membership">
                            <i class="fas fa-id-card me-2"></i> العضوية
                        </button>
                        <!-- محتوى العضوية -->
                        <div id="membership" class="collapse mt-2">
                            <div class="card card-body">
                                <!-- محتوى العضوية هنا -->
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
                                                        <td><br><small
                                                                class="text-muted">{{ $membership->packege->commission_name ?? '' }}</small>
                                                        </td>
                                                        <td><small
                                                                class="text-muted">{{ $membership->end_date ?? '' }}</small>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center gap-2">
                                                                <div class="rounded-circle bg-info"
                                                                    style="width: 8px; height: 8px;"></div>
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
                                                                    <button
                                                                        class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1 btn-sm"
                                                                        type="button" id="dropdownMenuButton303"
                                                                        data-toggle="dropdown" aria-haspopup="true"
                                                                        aria-expanded="false"></button>
                                                                    <div class="dropdown-menu"
                                                                        aria-labelledby="dropdownMenuButton303">
                                                                        <li>
                                                                            <a class="dropdown-item"
                                                                                href="{{ route('Memberships.show', $membership->id) }}">
                                                                                <i
                                                                                    class="fa fa-eye me-2 text-primary"></i>عرض
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a class="dropdown-item"
                                                                                href="{{ route('Memberships.edit', $membership->id) }}">
                                                                                <i
                                                                                    class="fa fa-edit me-2 text-success"></i>تعديل
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a class="dropdown-item text-danger"
                                                                                href="{{ route('Memberships.delete', $membership->id) }}">
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

                    <!-- زر الحجوزات -->
                    <div class="col-lg-12 col-md-12 col-12 mb-2">
                        <button class="btn btn-outline-primary w-100" type="button" data-bs-toggle="collapse"
                            data-bs-target="#reservations">
                            <i class="fas fa-bookmark me-2"></i> الحجوزات
                        </button>
                        <!-- محتوى الحجوزات -->
                        <div id="reservations" class="collapse mt-2">
                            <div class="card card-body">
                                <!-- محتوى الحجوزات هنا -->
                                <div class="card">
                                    <div class="card-body">
                                        @foreach ($bookings as $booking)
                                            <div class="row">
                                                <div class="col-auto">
                                                    <div
                                                        style="width: 50px; height: 50px; background-color: #f0f0f0; border-radius: 5px;">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <h6>بيانات العميل</h6>
                                                    <p class="mb-1">{{ $booking->client->first_name ?? '' }}</p>
                                                    <p class="mb-1">الخدمة: {{ $booking->product->name ?? '' }}</p>
                                                </div>
                                                <div class="col-auto text-end">
                                                    <p class="mb-1">الوقت من {{ $booking->start_time ?? 0 }} الى
                                                        {{ $booking->end_time ?? 0 }}</p>
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

                                                    <a href="{{ route('Reservations.show', $booking->id) }}"
                                                        class="badge bg-danger text-dark">عرض</a>
                                                    <a href="{{ route('Reservations.edit', $booking->id) }}"
                                                        class="btn btn-sm btn-primary">
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

                    <!-- زر الخدمات -->
                    <div class="col-lg-12 col-md-12 col-12 mb-2">
                        <button class="btn btn-outline-primary w-100" type="button" data-bs-toggle="collapse"
                            data-bs-target="#services">
                            <i class="fas fa-tools me-2"></i> الخدمات
                        </button>
                        <!-- محتوى الخدمات -->
                        <div id="services" class="collapse mt-2">
                            <div class="card card-body">
                                <p class="text-muted">خدمات العميل</p>
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
                        alert('تم تحديث الرصيد الافتتاحي بنجاح');
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let mediaRecorder;
            let audioChunks = [];

            document.getElementById("startRecording").addEventListener("click", async function() {
                let stream = await navigator.mediaDevices.getUserMedia({
                    audio: true
                });
                mediaRecorder = new MediaRecorder(stream);
                mediaRecorder.start();
                audioChunks = [];

                mediaRecorder.ondataavailable = event => audioChunks.push(event.data);
                mediaRecorder.onstop = async () => {
                    let audioBlob = new Blob(audioChunks, {
                        type: "audio/wav"
                    });
                    let audioUrl = URL.createObjectURL(audioBlob);
                    document.getElementById("audioPreview").src = audioUrl;
                    document.getElementById("audioPreview").classList.remove("d-none");

                    let reader = new FileReader();
                    reader.readAsDataURL(audioBlob);
                    reader.onloadend = function() {
                        document.getElementById("recordedAudio").value = reader.result;
                    };
                };

                document.getElementById("stopRecording").classList.remove("d-none");
                document.getElementById("startRecording").classList.add("d-none");
            });

            document.getElementById("stopRecording").addEventListener("click", function() {
                mediaRecorder.stop();
                document.getElementById("stopRecording").classList.add("d-none");
                document.getElementById("startRecording").classList.remove("d-none");
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            // إذا كان هناك عميل محدد، قم باختياره في القائمة
            @if (isset($client_id))
                $('#clientSelect').val('{{ $client_id }}').trigger('change');
            @endif

            // أو إذا كان هناك كائن عميل
            @if (isset($client) && $client)
                $('#clientSelect').val('{{ $client->id }}').trigger('change');
            @endif
        });
    </script>


    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <!--<script src="{{ asset('assets/js/applmintion.js') }}"></script>--> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection
