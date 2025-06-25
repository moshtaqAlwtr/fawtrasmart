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
    <!-- الزر الذي سيتم النقر عليه لفتح النموذج -->

    <!-- النموذج (Modal) -->
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
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <!-- القسم العلوي: معلومات العميل الأساسية -->
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                    <div>
                        <strong>{{ $client->trade_name }}</strong>
                        <small class="text-muted">#{{ $client->code }}</small>
                        @php
                            // الحصول على آخر ملاحظة فيها الحالة الأصلية لهذا الموظف الحالي
                            $lastNote = $client
                                ->appointmentNotes()
                                ->where('employee_id', auth()->id())
                                ->whereNotNull('employee_view_status')
                                ->latest()
                                ->first();

                            $statusIdToShow = $client->status_id;

                            // إذا كان الموظف هو اللي أبلغ المشرف، نعرض له الحالة الأصلية
                            if (
                                auth()->user()->role === 'employee' &&
                                $lastNote &&
                                $lastNote->process === 'إبلاغ المشرف'
                            ) {
                                $statusIdToShow = $lastNote->employee_view_status;
                            }

                            $status = $statuses->find($statusIdToShow);
                        @endphp

                        <span class="badge" style="background-color: {{ $status->color ?? '#007BFF' }}; color: white;">
                            {{ $status->name ?? 'غير محدد' }}
                        </span>

                        <br>
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
                    </div>

                    <!-- معلومات الرصيد -->
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
                    </div>

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        @php
                            $currentStatus = $client->status;
                        @endphp


                        <form method="POST" action="{{ route('clients.updateStatusClient') }}" class="flex-grow-1"
                            style="min-width: 220px;">
                            @csrf
                            <input type="hidden" name="client_id" value="{{ $client->id }}">
                            <div class="dropdown w-100">
                                <button class="btn w-100 text-start dropdown-toggle" type="button"
                                    id="clientStatusDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                                    style="background-color: {{ $currentStatus->color ?? '#e0f7fa' }}; color: #000; border: 1px solid #ccc; height: 42px;">
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

                    </div>
                </div>

                <!-- القسم الأوسط: معلومات الاتصال والعنوان -->
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                    <div class="text-end">
                        <strong class="text-dark">{{ $client->first_name }}</strong>
                        <br>
                        <span class="text-primary">
                            <i class="fas fa-map-marker-alt"></i> {{ $client->full_address }}
                        </span>
                    </div>

                    @if (auth()->user()->role === 'manager')
                        <div class="row align-items-center">
                            <div id="assignedEmployeesList" class="col-12">
                                @if ($client->employees && $client->employees->count() > 0)
                                    <div class="row g-2">
                                        @foreach ($client->employees as $employee)
                                            <div class="col-auto">
                                                <div class="badge bg-primary d-flex align-items-center">
                                                    <a href="{{ route('employee.show', $employee->id) }}"
                                                        class="text-white text-decoration-none me-2">
                                                        {{ $employee->full_name }}
                                                    </a>
                                                    <form action="{{ route('clients.remove-employee', $client->id) }}"
                                                        method="POST" class="mb-0">
                                                        @csrf
                                                        <input type="hidden" name="employee_id"
                                                            value="{{ $employee->id }}">
                                                        <button type="submit" class="btn btn-sm btn-link text-white p-0">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-muted">{{ __('لا يوجد موظفون مرتبطون') }}</span>
                                @endif
                            </div>
                        </div>
                    @endif

                </div>

                <!-- القسم السفلي: الحالة والموظفين والخيارات -->

            </div>
        </div>


        <div class="card">
            <div class="card-body">
                <!-- أزرار القائمة (تظهر فقط على الشاشات الكبيرة) -->
                <div class="d-grid d-md-flex flex-wrap gap-2 d-none d-md-block">
                    @if (auth()->user()->hasPermissionTo('Edit_Client'))
                        <a href="{{ route('clients.edit', $client->id) }}"
                            class="btn btn-sm btn-outline-info text-dark bg-white">
                            <i class="fas fa-user-edit me-1"></i> تعديل
                        </a>
                    @endif

                    @if (auth()->user()->role === 'manager')
                        <form action="{{ route('clients.force-show', $client) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-warning text-dark bg-white">
                                <i class="fas fa-map-marker-alt"></i> إظهار في الخريطة الآن
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('appointment.notes.create', $client->id) }}"
                        class="btn btn-sm btn-outline-secondary text-dark bg-white">
                        <i class="fas fa-paperclip me-1"></i> إضافة ملاحظة/مرفق
                    </a>

                    <a href="{{ route('incomes.create') }}" class="btn btn-sm btn-outline-success text-dark bg-white">
                        <i class="fas fa-receipt me-1"></i> سند القبض
                    </a>

                    <a href="{{ route('appointments.create') }}"
                        class="btn btn-sm btn-outline-success text-dark bg-white">
                        <i class="fas fa-calendar-plus me-1"></i> ترتيب موعد
                    </a>

                    <a href="{{ route('clients.statement', $client->id) }}"
                        class="btn btn-sm btn-outline-warning text-dark bg-white">
                        <i class="fas fa-file-invoice me-1"></i> كشف حساب
                    </a>

                    <a class="btn btn-sm btn-outline-primary text-dark bg-white" href="#" data-bs-toggle="modal"
                        data-bs-target="#openingBalanceModal">
                        <i class="fas fa-wallet me-2"></i> إضافة رصيد افتتاحي
                    </a>

                    <a class="btn btn-sm btn-outline-primary text-dark bg-white" href="#" data-bs-toggle="modal"
                        data-bs-target="#assignEmployeeModal">
                        <i class="fas fa-user-plus me-2"></i> تعيين موظفين
                    </a>

                    <a href="{{ route('CreditNotes.create') }}" class="btn btn-sm btn-outline-danger text-dark bg-white">
                        <i class="fas fa-file-invoice-dollar me-1"></i> إنشاء إشعار دائن
                    </a>

                    <a href="{{ route('invoices.create', ['client_id' => $client->id]) }}"
                        class="btn btn-sm btn-outline-dark text-dark bg-white">
                        <i class="fas fa-file-invoice me-1"></i> إنشاء فاتورة
                    </a>

                    <a href="{{ route('Reservations.client', $client->id) }}"
                        class="btn btn-sm btn-outline-dark bg-white text-dark">
                        <i class="fas fa-calendar-check me-1"></i> الحجوزات
                    </a>
                </div>

                <!-- زر واحد يحتوي على القائمة المنسدلة (يظهر فقط على الشاشات الصغيرة) -->
                <div class="dropdown d-md-none">
                    <button class="btn btn-primary w-100 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-bars me-1"></i> خيارات
                    </button>
                    <ul class="dropdown-menu w-100">
                        @if (auth()->user()->hasPermissionTo('Edit_Client'))
                            <li>
                                <a class="dropdown-item d-flex align-items-center"
                                    href="{{ route('clients.edit', $client->id) }}">
                                    <i class="fas fa-user-edit me-2 text-info"></i> تعديل
                                </a>
                            </li>
                        @endif

                        @if (auth()->user()->role === 'manager')
                            <li>
                                <form action="{{ route('clients.force-show', $client) }}" method="POST"
                                    class="dropdown-item p-0">
                                    @csrf
                                    <button type="submit" class="btn w-100 text-start d-flex align-items-center">
                                        <i class="fas fa-map-marker-alt me-2 text-warning"></i> إظهار في الخريطة الآن
                                    </button>
                                </form>
                            </li>
                        @endif

                        <li>
                            <a class="dropdown-item d-flex align-items-center"
                                href="{{ route('appointment.notes.create', $client->id) }}">
                                <i class="fas fa-paperclip me-2 text-secondary"></i> إضافة ملاحظة/مرفق
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('appointments.create') }}">
                                <i class="fas fa-calendar-plus me-2 text-success"></i> ترتيب موعد
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('incomes.create') }}">
                                <i class="fas fa-receipt me-2 text-info"></i> سند قبض
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center"
                                href="{{ route('clients.statement', $client->id) }}">
                                <i class="fas fa-file-invoice me-2 text-warning"></i> كشف حساب
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal"
                                data-bs-target="#openingBalanceModal">
                                <i class="fas fa-wallet me-2 text-success"></i> إضافة رصيد افتتاحي
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal"
                                data-bs-target="#assignEmployeeModal">
                                <i class="fas fa-user-plus me-2 text-primary"></i> تعيين موظفين
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('CreditNotes.create') }}">
                                <i class="fas fa-file-invoice-dollar me-2 text-danger"></i> إنشاء إشعار دائن
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center"
                                href="{{ route('invoices.create', ['client_id' => $client->id]) }}">
                                <i class="fas fa-file-invoice me-2 text-dark"></i> إنشاء فاتورة
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center"
                                href="{{ route('Reservations.client', $client->id) }}">
                                <i class="fas fa-calendar-check me-2 text-dark"></i> الحجوزات
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>



        {{-- التبويبات --}}
        <div class="card">
            <div class="card-body p-0">
                <!-- تبويبات العميل -->
                <div class="client-tabs">
                    <!-- شريط التبويبات الأفقي -->
                    <div class="d-flex flex-wrap border-bottom">
                        <button class="tab-btn active" data-target="details-tab">
                            <i class="fas fa-info-circle me-2"></i> التفاصيل
                        </button>
                        <button class="tab-btn" data-target="appointments-tab">
                            <i class="fas fa-calendar-alt me-2"></i> المواعيد
                        </button>
                        <button class="tab-btn" data-target="invoices-tab">
                            <i class="fas fa-file-invoice me-2"></i> الفواتير
                        </button>
                        <button class="tab-btn" data-target="payments-tab">
                            <i class="fas fa-money-bill-wave me-2"></i> المدفوعات
                        </button>
                        <button class="tab-btn" data-target="notes-tab">
                            <i class="fas fa-sticky-note me-2"></i> الملاحظات
                        </button>
                        <button class="tab-btn" data-target="visits-tab">
                            <i class="fas fa-walking me-2"></i> الزيارات
                        </button>
                        <button class="tab-btn" data-target="reservations-tab">
                            <i class="fas fa-calendar-check me-2"></i> الحجوزات
                        </button>
                    </div>

                    <!-- محتوى التبويبات -->
                    <div class="tab-content p-3">
                        <!-- المعلومات الأساسية -->

                        <!-- معلومات سريعة -->


                        <!-- محتوى تبويب التفاصيل -->
                        <div id="details-tab" class="tab-pane active">
                            <div class="card card-body">
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

                        <!-- محتوى تبويب المواعيد -->
                        <div id="appointments-tab" class="tab-pane">
                            <div class="card card-body p-0">
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

                        <!-- محتوى تبويب الفواتير -->
                        <div id="invoices-tab" class="tab-pane">
                            <div class="card card-body">
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

                        <!-- محتوى تبويب المدفوعات -->
                        <div id="payments-tab" class="tab-pane">
                            <div class="card card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="bg-light">
                                            <tr>
                                                <th width="20%">البيانات الأساسية</th>
                                                <th width="15%">العميل</th>
                                                <th width="15%">التاريخ والموظف</th>
                                                <th width="15%" class="text-center">المبلغ</th>
                                                <th width="15%" class="text-center">الحالة</th>
                                                <th width="20%" class="text-end">الإجراءات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($payments->where('type', 'client payments') as $payment)
                                                <tr>
                                                    <td
                                                        style="white-space: normal; word-wrap: break-word; min-width: 200px;">
                                                        <div class="d-flex flex-column">
                                                            <strong>#{{ $payment->id }}</strong>

                                                            <small class="text-muted">
                                                                @if ($payment->invoice)
                                                                    الفاتورة: #{{ $payment->invoice->code ?? '--' }}
                                                                @endif
                                                            </small>

                                                            @if ($payment->notes)
                                                                <small class="text-muted mt-1"
                                                                    style="white-space: normal;">
                                                                    <i class="fas fa-comment-alt"></i>
                                                                    {{ $payment->notes }}
                                                                </small>
                                                            @endif
                                                        </div>
                                                    </td>

                                                    <td>
                                                        @if ($payment->invoice->client)
                                                            <div class="d-flex flex-column">
                                                                <strong>{{ $payment->invoice->client->trade_name ?? '' }}</strong>
                                                                <small class="text-muted">
                                                                    <i class="fas fa-phone"></i>
                                                                    {{ $payment->invoice->client->phone ?? '' }}
                                                                </small>

                                                            </div>
                                                        @else
                                                            <span class="text-danger">لا يوجد عميل</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column">
                                                            <small><i class="fas fa-calendar"></i>
                                                                {{ $payment->payment_date }}</small>
                                                            @if ($payment->employee)
                                                                <small class="text-muted mt-1">
                                                                    <i class="fas fa-user"></i>
                                                                    {{ $payment->employee->name ?? '' }}
                                                                </small>
                                                            @endif
                                                            <small class="text-muted mt-1">
                                                                <i class="fas fa-clock"></i>
                                                                {{ $payment->created_at->format('H:i') }}
                                                            </small>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        @php
                                                            $currency = $account_setting->currency ?? 'SAR';
                                                            $currencySymbol =
                                                                $currency == 'SAR' || empty($currency)
                                                                    ? '<img src="' .
                                                                        asset('assets/images/Saudi_Riyal.svg') .
                                                                        '" alt="ريال سعودي" width="15" style="vertical-align: middle;">'
                                                                    : $currency;
                                                        @endphp
                                                        <h6 class="mb-0 font-weight-bold">
                                                            {{ number_format($payment->amount, 2) }}
                                                            {!! $currencySymbol !!}
                                                        </h6>
                                                        <small class="text-muted">
                                                            {{ $payment->payment_method ?? 'غير محدد' }}
                                                        </small>
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
                                                        <span class="badge {{ $statusClass }} rounded-pill">
                                                            <i class="fas {{ $statusIcon }} me-1"></i>
                                                            {{ $statusText }}
                                                        </span>
                                                        @if ($payment->payment_status == 1)
                                                            <small class="d-block text-muted mt-1">
                                                                <i class="fas fa-check-circle"></i> تم التأكيد
                                                            </small>
                                                        @endif
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="btn-group">
                                                            <div class="dropdown">
                                                                <button
                                                                    class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1 btn-sm"
                                                                    type="button"id="dropdownMenuButton303"
                                                                    data-toggle="dropdown"
                                                                    aria-haspopup="true"aria-expanded="false"></button>
                                                                <div class="dropdown-menu"
                                                                    aria-labelledby="dropdownMenuButton303">
                                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                                        <li>
                                                                            <a class="dropdown-item"
                                                                                href="{{ route('paymentsClient.show', $payment->id) }}">
                                                                                <i
                                                                                    class="fas fa-eye me-2 text-primary"></i>عرض
                                                                                التفاصيل
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a class="dropdown-item"
                                                                                href="{{ route('paymentsClient.edit', $payment->id) }}">
                                                                                <i
                                                                                    class="fas fa-edit me-2 text-success"></i>تعديل
                                                                                الدفع
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <form
                                                                                action="{{ route('paymentsClient.destroy', $payment->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit"
                                                                                    class="dropdown-item text-danger"
                                                                                    onclick="return confirm('هل أنت متأكد من حذف هذه العملية؟')">
                                                                                    <i class="fas fa-trash me-2"></i>حذف
                                                                                    العملية
                                                                                </button>
                                                                            </form>
                                                                        </li>
                                                                        <li>
                                                                            <hr class="dropdown-divider">
                                                                        </li>
                                                                        <li>
                                                                            <a class="dropdown-item"
                                                                                href="{{ route('paymentsClient.rereceipt', ['id' => $payment->id]) }}?type=a4"
                                                                                target="_blank">
                                                                                <i
                                                                                    class="fas fa-file-pdf me-2 text-warning"></i>إيصال
                                                                                (A4)
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a class="dropdown-item"
                                                                                href="{{ route('paymentsClient.rereceipt', ['id' => $payment->id]) }}?type=thermal"
                                                                                target="_blank">
                                                                                <i
                                                                                    class="fas fa-receipt me-2 text-warning"></i>إيصال
                                                                                (حراري)
                                                                            </a>
                                                                        </li>
                                                                        @if ($payment->client)
                                                                            <li>
                                                                                <hr class="dropdown-divider">
                                                                            </li>
                                                                            <li>
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('clients.show', $payment->client->id) }}">
                                                                                    <i
                                                                                        class="fas fa-user me-2 text-info"></i>عرض
                                                                                    بيانات
                                                                                    العميل
                                                                                </a>
                                                                            </li>
                                                                        @endif
                                                                    </ul>
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

                        <!-- محتوى تبويب الملاحظات -->
                        <!-- محتوى تبويب الملاحظات -->
                        <div id="notes-tab" class="tab-pane">
                            <div class="card card-body">
                                <!-- شريط أدوات الملاحظات -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="mb-0">
                                        <i class="fas fa-sticky-note text-primary me-2"></i>
                                        سجل الملاحظات
                                    </h5>

                                </div>

                                <!-- محتوى الملاحظات -->
                                <!-- محتوى الملاحظات -->
<!-- محتوى الملاحظات -->
<div class="timeline-container">
    <div class="timeline">
        @forelse ($ClientRelations as $note)
            <div class="timeline-item mb-4">
                <div class="timeline-content d-flex flex-column flex-md-row">
                    <!-- نقطة الخط الزمني (للأجهزة الكبيرة) -->
                    <div class="timeline-dot-container d-none d-md-flex align-items-start">
                        <div class="timeline-dot bg-primary"></div>
                    </div>

                    <!-- محتوى الملاحظة الرئيسي -->
                    <div class="note-main-content flex-grow-1">
                        <!-- الحالة -->
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge"
                                style="background-color: {{ $statuses->find($client->status_id)->color ?? '#007BFF' }}; color: white;">
                                {{ $statuses->find($client->status_id)->name ?? '' }}
                            </span>
                            <small class="text-muted d-md-none">
                                <i class="fas fa-clock me-1"></i>
                                {{ $note->created_at->format('d/m/Y H:i') }}
                            </small>
                        </div>

                        <!-- مربع الملاحظة -->
                        <div class="note-box border rounded bg-white shadow-sm p-3">
                            <!-- رأس الملاحظة -->
                            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="mb-1">
                                        <i class="fas fa-user me-1"></i>
                                        {{ $note->employee->name ?? 'غير معروف' }}
                                    </h6>
                                    <small class="text-muted">
                                        <i class="fas fa-tag me-1"></i>
                                        {{ $note->process ?? 'بدون تصنيف' }}
                                    </small>
                                </div>
                                <small class="text-muted d-none d-md-block">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $note->created_at->format('d/m/Y H:i') }}
                                </small>
                            </div>

                            <hr class="my-2">

                            <!-- محتوى الملاحظة -->
                            <div class="note-content mb-3">
                                <p class="mb-2">{{ $note->description ?? 'لا يوجد وصف' }}</p>

                                <!-- البيانات الإضافية -->
                                @if ($note->deposit_count || $note->site_type || $note->competitor_documents)
                                    <div class="additional-data mt-3 p-2 bg-light rounded">
                                        <div class="row">
                                            @if ($note->deposit_count)
                                                <div class="col-12 col-sm-6 col-md-4 mb-2">
                                                    <span class="d-block text-primary">
                                                        <i class="fas fa-boxes me-1"></i> عدد العهدة:
                                                    </span>
                                                    <span class="fw-bold">{{ $note->deposit_count }}</span>
                                                </div>
                                            @endif

                                            @if ($note->site_type)
                                                <div class="col-12 col-sm-6 col-md-4 mb-2">
                                                    <span class="d-block text-primary">
                                                        <i class="fas fa-store me-1"></i> نوع الموقع:
                                                    </span>
                                                    <span class="fw-bold">
                                                        @switch($note->site_type)
                                                            @case('independent_booth')
                                                                بسطة مستقلة
                                                            @break

                                                            @case('grocery')
                                                                بقالة
                                                            @break

                                                            @case('supplies')
                                                                تموينات
                                                            @break

                                                            @case('markets')
                                                                أسواق
                                                            @break

                                                            @case('station')
                                                                محطة
                                                            @break

                                                            @default
                                                                {{ $note->site_type }}
                                                        @endswitch
                                                    </span>
                                                </div>
                                            @endif

                                            @if ($note->competitor_documents)
                                                <div class="col-12 col-sm-6 col-md-4 mb-2">
                                                    <span class="d-block text-primary">
                                                        <i class="fas fa-file-contract me-1"></i>
                                                        استندات المنافسين:
                                                    </span>
                                                    <span class="fw-bold">{{ $note->competitor_documents }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- المرفقات -->
                            @php
                                $files = json_decode($note->attachments, true);
                                $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                            @endphp

                            @if (is_array($files) && count($files))
                                <div class="attachments mt-3">
                                    <h6 class="mb-2">
                                        <i class="fas fa-paperclip me-1"></i>
                                        المرفقات:
                                    </h6>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach ($files as $file)
                                            @php
                                                $ext = pathinfo($file, PATHINFO_EXTENSION);
                                                $fileUrl = asset('assets/uploads/notes/' . $file);
                                            @endphp

                                            @if (in_array(strtolower($ext), $imageExtensions))
                                                <a href="{{ $fileUrl }}"
                                                    data-fancybox="gallery-{{ $note->id }}"
                                                    class="d-inline-block me-2 mb-2">
                                                    <img src="{{ $fileUrl }}"
                                                        alt="مرفق صورة" class="img-thumbnail"
                                                        style="max-width: 100px; max-height: 100px; width: auto; height: auto; object-fit: cover;">
                                                </a>
                                            @else
                                                <a href="{{ $fileUrl }}" target="_blank"
                                                    class="btn btn-sm btn-outline-primary d-inline-flex align-items-center">
                                                    <i class="fas fa-file-alt me-2"></i>
                                                    {{ Str::limit($file, 15) }}
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- أدوات الملاحظة -->
                            <div class="note-actions mt-3 pt-2 border-top d-flex justify-content-end flex-wrap gap-2">
                                <button class="btn btn-sm btn-outline-secondary edit-note"
                                    data-note-id="{{ $note->id }}"
                                    data-process="{{ $note->process }}"
                                    data-description="{{ $note->description }}"
                                    data-deposit-count="{{ $note->deposit_count }}"
                                    data-site-type="{{ $note->site_type }}"
                                    data-competitor-documents="{{ $note->competitor_documents }}">
                                    <i class="fas fa-edit me-1"></i> تعديل
                                </button>
                                <form action="" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('هل أنت متأكد من حذف هذه الملاحظة؟')">
                                        <i class="fas fa-trash me-1"></i> حذف
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info text-center py-4">
                <i class="fas fa-info-circle fa-2x mb-3"></i>
                <h5>لا توجد ملاحظات مسجلة</h5>
                <p class="mb-0">يمكنك إضافة ملاحظة جديدة بالضغط على زر "إضافة ملاحظة"</p>
            </div>
        @endforelse
    </div>
</div>



                                <!-- ستايل إضافي لتبويب الملاحظات -->
                                <style>
                                    .timeline {
                                        position: relative;
                                        padding-left: 30px;
                                    }

                                    .timeline-item {
                                        position: relative;
                                        margin-bottom: 25px;
                                    }

                                    .timeline-dot {
                                        position: absolute;
                                        left: -15px;
                                        top: 15px;
                                        width: 12px;
                                        height: 12px;
                                        border-radius: 50%;
                                        border: 2px solid #0d6efd;
                                    }

                                    .note-box {
                                        transition: all 0.3s ease;
                                        border-left: 3px solid #0d6efd;
                                    }

                                    .note-box:hover {
                                        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
                                    }

                                    .additional-data {
                                        border-right: 2px solid #0d6efd;
                                    }

                                    .note-actions {
                                        opacity: 0;
                                        transition: opacity 0.3s ease;
                                    }

                                    .note-box:hover .note-actions {
                                        opacity: 1;
                                    }

                                    @media (max-width: 768px) {
                                        .timeline {
                                            padding-left: 20px;
                                        }

                                        .timeline-dot {
                                            left: -10px;
                                            width: 10px;
                                            height: 10px;
                                        }
                                    }
                                </style>

                                <div id="visits-tab" class="tab-pane">
                                    <div class="card card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>تاريخ الزيارة</th>
                                                        <th>وقت الانصراف</th>
                                                        <th>الموظف</th>
                                                        <th>ملاحظات</th>
                                                        <th>العهدة للعميل</th>
                                                        <th>الإجراءات</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($visits as $visit)
                                                        <tr>
                                                            <td>{{ $visit->id }}</td>
                                                            <td>{{ $visit->visit_date }}</td>
                                                            <td>{{ $visit->departure_time ?? '--' }}</td>
                                                            <td>{{ $visit->employee->name ?? 'غير محدد' }}</td>

                                                            <td>{{ Str::limit($visit->notes, 30) ?? '--' }}</td>
                                                            {{-- <td>{{ $visit->client->latestStatus->deposit_count }}</td> --}}
                                                            <td>
                                                                <div class="dropdown">
                                                                    <button
                                                                        class="btn btn-sm bg-gradient-info fa fa-ellipsis-v"
                                                                        type="button"
                                                                        id="dropdownMenuButton{{ $visit->id }}"
                                                                        data-toggle="dropdown" aria-haspopup="true"
                                                                        aria-expanded="false"></button>
                                                                    <div class="dropdown-menu dropdown-menu-end"
                                                                        aria-labelledby="dropdownMenuButton">
                                                                        <a class="dropdown-item" href="">
                                                                            <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                                            التفاصيل
                                                                        </a>
                                                                        <a class="dropdown-item" href="">
                                                                            <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                                        </a>
                                                                        <form action="" method="POST" class="d-inline">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="dropdown-item text-danger"
                                                                                onclick="return confirm('هل أنت متأكد من حذف هذه الزيارة؟')">
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
                                        @if ($visits->count() == 0)
                                            <div class="alert alert-info text-center mt-3">
                                                لا توجد زيارات مسجلة لهذا العميل
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- محتوى تبويب الحجوزات -->
                                <div id="reservations-tab" class="tab-pane">
                                    <div class="card card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="mb-0">حجوزات العميل</h5>
                                            <a href="" class="btn btn-primary btn-sm">
                                                <i class="fas fa-plus me-1"></i> إضافة حجز جديد
                                            </a>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th>رقم الحجز</th>
                                                        <th>الخدمة</th>
                                                        <th>التاريخ والوقت</th>
                                                        <th>الحالة</th>
                                                        <th>المبلغ</th>
                                                        <th>الإجراءات</th>
                                                    </tr>
                                                </thead>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- إضافة ستايل إضافي للتبويبات -->
                <style>
                    .client-tabs {
                        font-family: 'Tajawal', sans-serif;
                    }

                    .tab-btn {
                        padding: 12px 20px;
                        background: none;
                        border: none;
                        border-bottom: 3px solid transparent;
                        cursor: pointer;
                        font-weight: 500;
                        color: #6c757d;
                        transition: all 0.3s;
                        position: relative;
                        display: flex;
                        align-items: center;
                    }

                    .tab-btn:hover {
                        color: #0d6efd;
                        background-color: #f8f9fa;
                    }

                    .tab-btn.active {
                        color: #0d6efd;
                        border-bottom-color: #0d6efd;
                        background-color: #f8f9fa;
                    }

                    .tab-pane {
                        display: none;
                    }

                    .tab-pane.active {
                        display: block;
                    }

                    .quick-info {
                        border-right: 3px solid #0d6efd;
                    }

                    .info-item {
                        display: flex;
                        flex-direction: column;
                    }

                    @media (max-width: 768px) {
                        .tab-btn {
                            padding: 10px 15px;
                            font-size: 14px;
                            flex: 1 0 50%;
                        }

                        .quick-info .row>div {
                            margin-bottom: 10px;
                        }
                    }

                    @media (max-width: 576px) {
                        .tab-btn {
                            flex: 1 0 100%;
                            justify-content: center;
                        }
                    }

                    /* تحسينات للجداول على الأجهزة الصغيرة */
                    .table-responsive {
                        overflow-x: auto;
                        -webkit-overflow-scrolling: touch;
                    }

                    /* تحسينات للخط الزمني */
                    .timeline {
                        position: relative;
                        padding-left: 50px;
                    }

                    .timeline-item {
                        position: relative;
                        margin-bottom: 30px;
                    }

                    .timeline-dot {
                        position: absolute;
                        left: -25px;
                        top: 15px;
                        width: 20px;
                        height: 20px;
                        border-radius: 50%;
                    }

                    .note-box {
                        transition: all 0.3s ease;
                    }

                    .note-box:hover {
                        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                    }
                </style>

                <!-- سكريبت لإدارة التبويبات -->
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // تبديل التبويبات
                        const tabButtons = document.querySelectorAll('.tab-btn');

                        tabButtons.forEach(button => {
                            button.addEventListener('click', function() {
                                // إزالة النشاط من جميع الأزرار
                                tabButtons.forEach(btn => btn.classList.remove('active'));

                                // إضافة النشاط للزر المحدد
                                this.classList.add('active');

                                // إخفاء جميع محتويات التبويبات
                                document.querySelectorAll('.tab-pane').forEach(pane => {
                                    pane.classList.remove('active');
                                });

                                // إظهار محتوى التبويب المحدد
                                const targetId = this.getAttribute('data-target');
                                document.getElementById(targetId).classList.add('active');
                            });
                        });

                        // فلترة المواعيد
                        const filterButtons = document.querySelectorAll('.filter-appointments');
                        filterButtons.forEach(button => {
                            button.addEventListener('click', function() {
                                const filter = this.getAttribute('data-filter');
                                const rows = document.querySelectorAll(
                                    '#appointments-container tr[data-appointment-id]');

                                rows.forEach(row => {
                                    if (filter === 'all' || row.getAttribute('data-status') ===
                                        filter) {
                                        row.style.display = '';
                                    } else {
                                        row.style.display = 'none';
                                    }
                                });

                                // تحديث الأزرار النشطة
                                filterButtons.forEach(btn => btn.classList.remove('active'));
                                this.classList.add('active');
                            });
                        });

                        // جعل صفوف الجدول قابلة للنقر
                        document.querySelectorAll('.invoice-row').forEach(row => {
                            row.addEventListener('click', function(e) {
                                // تجنب فتح الرابط إذا تم النقر على عنصر منسدل أو زر
                                if (!e.target.closest('.dropdown') && !e.target.closest(
                                        'input[type="checkbox"]')) {
                                    window.location.href = this.getAttribute('data-href');
                                }
                            });
                        });
                    });
                </script>

                <!-- Modal إضافة الرصيد الافتتاحي -->
                <div class="modal fade" id="openingBalanceModal" tabindex="-1" aria-labelledby="openingBalanceModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="openingBalanceModalLabel">إضافة رصيد افتتاحي</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="openingBalanceForm">
                                    <div class="mb-3">
                                        <label for="openingBalance" class="form-label">الرصيد الافتتاحي</label>
                                        <input type="number" class="form-control" id="openingBalance"
                                            name="opening_balance" value="{{ $client->opening_balance ?? 0 }}"
                                            step="0.01">
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
