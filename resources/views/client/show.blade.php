@extends('master')

@section('title')
    العملاء
@stop

@section('content')
@if(session('toast_message'))
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
                        <a href="#" class="btn btn-sm btn-outline-success d-inline-flex align-items-center">
                            <i class="far fa-sticky-note me-1"></i> إنشاء إشعار دائن
                        </a>
                        <a href="#" class="btn btn-sm btn-outline-info d-inline-flex align-items-center">
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
                        <a href="{{route('appointments.create')}}" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center">
                            <i class="far fa-calendar-alt me-1"></i> ترتيب موعد
                        </a>
                        <a href="#" class="btn btn-sm btn-outline-dark d-inline-flex align-items-center">
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
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false">
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
                        <a class="nav-link" id="appointments-tab" data-toggle="tab" href="#appointments" aria-controls="appointments"
                            role="tab" aria-selected="false">
                            المواعيد <span class="badge badge-pill badge-primary">{{ $client->appointments()->count() }}</span>
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
                        <a class="nav-link" id="timeline-tab" data-toggle="tab" href="#timeline" aria-controls="timeline"
                            role="tab" aria-selected="false">الجدول الزمني</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="serice_m" data-toggle="tab" href="#timeline" aria-controls="timeline"
                            role="tab" aria-selected="false">الخدمات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="member" data-toggle="tab" href="#timeline" aria-controls="timeline"
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
                            $completedAppointments = $client->appointments->where('status', App\Models\Appointment::STATUS_COMPLETED);
                            $ignoredAppointments = $client->appointments->where('status', App\Models\Appointment::STATUS_IGNORED);
                            $pendingAppointments = $client->appointments->where('status', App\Models\Appointment::STATUS_PENDING);
                            $rescheduledAppointments = $client->appointments->where('status', App\Models\Appointment::STATUS_RESCHEDULED);
                        @endphp

                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div class="d-flex gap-2 flex-wrap">
                                    <button class="btn btn-sm btn-outline-primary filter-appointments" data-filter="all">
                                        الكل
                                        <span class="badge badge-light">{{ $client->appointments->count() }}</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-success filter-appointments" data-filter="{{ App\Models\Appointment::STATUS_COMPLETED }}">
                                        تم
                                        <span class="badge badge-light">{{ $completedAppointments->count() }}</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-warning filter-appointments" data-filter="{{ App\Models\Appointment::STATUS_IGNORED }}">
                                        تم صرف النظر عنه
                                        <span class="badge badge-light">{{ $ignoredAppointments->count() }}</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger filter-appointments" data-filter="{{ App\Models\Appointment::STATUS_PENDING }}">
                                        تم جدولته
                                        <span class="badge badge-light">{{ $pendingAppointments->count() }}</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-info filter-appointments" data-filter="{{ App\Models\Appointment::STATUS_RESCHEDULED }}">
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
                                                            <small class="text-muted">{{ $appointment->description }}</small>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <p class="mb-0">
                                                                <small>{{ $appointment->created_at->format('Y-m-d H:i') }}</small>
                                                            </p>
                                                            <small class="text-muted">
                                                                بواسطة: {{ $appointment->employee->name ?? 'غير محدد' }}
                                                            </small>
                                                        </div>
                                                        <div class="col-md-3 text-center">
                                                            <span class="badge status-badge {{ $appointment->status_color }}">
                                                                {{ $appointment->status_text }}
                                                            </span>
                                                        </div>
                                                        <div class="col-md-2 text-end">
                                                            <div class="btn-group">
                                                                <div class="dropdown">
                                                                    <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1" type="button"id="dropdownMenuButton303" data-toggle="dropdown" aria-haspopup="true"aria-expanded="false"></button>
                                                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton{{ $appointment->id }}">
                                                                        <form action="{{ route('appointments.update-status', $appointment->id) }}" method="POST" class="d-inline">
                                                                            @csrf
                                                                            @method('PATCH')
                                                                            <input type="hidden" name="status" value="1">
                                                                            <button type="submit" class="dropdown-item">
                                                                                <i class="fa fa-clock me-2 text-warning"></i>تم جدولته
                                                                            </button>
                                                                        </form>

                                                                        <form action="{{ route('appointments.update-status', $appointment->id) }}" method="POST" class="d-inline">
                                                                            @csrf
                                                                            @method('PATCH')
                                                                            <input type="hidden" name="status" value="2">
                                                                            <input type="hidden" name="auto_delete" value="1">
                                                                            <button type="submit" class="dropdown-item">
                                                                                <i class="fa fa-check me-2 text-success"></i>تم
                                                                            </button>
                                                                        </form>

                                                                        <!-- For ignored status -->
                                                                        <form action="{{ route('appointments.update-status', $appointment->id) }}" method="POST" class="d-inline">
                                                                            @csrf
                                                                            @method('PATCH')
                                                                            <input type="hidden" name="status" value="3">
                                                                            <button type="submit" class="dropdown-item">
                                                                                <i class="fa fa-times me-2 text-danger"></i>صرف النظر عنه
                                                                            </button>
                                                                        </form>
                                                                        <form action="{{ route('appointments.update-status', $appointment->id) }}" method="POST" class="d-inline">
                                                                            @csrf
                                                                            @method('PATCH')
                                                                            <input type="hidden" name="status" value="4">
                                                                            <button type="submit" class="dropdown-item">
                                                                                <i class="fa fa-redo me-2 text-info"></i>تم جدولته مجددا
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
                                                        @if($appointment->notes)
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
                                            <div class="modal fade" id="noteModal{{ $appointment->id }}" tabindex="-1" role="dialog" aria-labelledby="noteModalLabel{{ $appointment->id }}" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="noteModalLabel{{ $appointment->id }}">إضافة ملاحظات للموعد</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form id="noteForm{{ $appointment->id }}" method="POST">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <input type="hidden" name="status" value="{{ App\Models\Appointment::STATUS_COMPLETED }}">
                                                                <div class="form-group">
                                                                    <label for="notes{{ $appointment->id }}">الملاحظات</label>
                                                                    <textarea class="form-control" id="notes{{ $appointment->id }}" name="notes" rows="3" placeholder="أدخل ملاحظاتك هنا"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                                                <button type="button" class="btn btn-primary" onclick="submitCompletedAppointment({{ $appointment->id }})">حفظ الملاحظات</button>
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

                        @if (@isset($invoices) && !@empty($invoices) && count($invoices) > 0)
                            @foreach ($invoices as $invoice)
                                <div class="card">
                                    <!-- الترويسة -->
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <div class="d-flex gap-2 flex-wrap">
                                            <button class="btn btn-sm btn-outline-primary">الكل</button>
                                            <button class="btn btn-sm btn-outline-success">متأخر</button>
                                            <button class="btn btn-sm btn-outline-danger">مستحقة الدفع</button>
                                            <button class="btn btn-sm btn-outline-danger">غير مدفوع</button>
                                            <button class="btn btn-sm btn-outline-secondary">مسودة</button>
                                            <button class="btn btn-sm btn-outline-success">مدفوع بزيادة</button>
                                        </div>
                                    </div>

                                    <!-- بداية الصف -->
                                    <div class="card-body">
                                        <div class="row border-bottom py-2 align-items-center">
                                            <div class="col-md-4">
                                                <p class="mb-"><strong>#{{ $invoice->invoice_id }}</strong>
                                                    {{ $invoice->client->trade_name }}</p>
                                                <small class="text-muted">#532 ملاحظات: الدمام - الزهرة</small>
                                            </div>
                                            <div class="col-md-3">
                                                <p class="mb-0"><small>{{ $invoice->created_at }}</small></p>
                                                <small class="text-muted">
                                                    بواسطة: {{ $invoice->employee_id }}</small>
                                            </div>
                                            <div class="col-md-3 text-center">
                                                <strong class="text-danger">216.00 رس</strong>
                                                <span class="badge bg-warning text-dark d-block mt-1">غير مدفوعة</span>
                                            </div>
                                            <div class="col-md-2 text-end">

                                                <div class="btn-group">
                                                    <div class="dropdown">
                                                        <button type="button" class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1"
                                                            type="button" id="dropdownMenuButton303"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">

                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <a class="dropdown-item" href="#">
                                                                    <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="#">
                                                                    <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="#">
                                                                    <i class="fa fa-file-pdf me-2 text-danger"></i>PDF
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="#">
                                                                    <i class="fa fa-print me-2 text-dark"></i>طباعة
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="#">
                                                                    <i class="fa fa-envelope me-2 text-warning"></i>إرسال
                                                                    إلى
                                                                    العميل
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="#">
                                                                    <i class="fa fa-credit-card me-2 text-info"></i>إضافة
                                                                    عملية
                                                                    دفع
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item text-danger" href="#">
                                                                    <i class="fa fa-trash me-2"></i>حذف
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="#">
                                                                    <i class="fa fa-copy me-2 text-secondary"></i>نسخ
                                                                </a>
                                                            </li>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- تكرار الصف حسب الحاجة -->
                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-danger" role="alert">
                                <p class="mb-0">
                                    لا توجد فواتير
                                </p>
                            </div>
                        @endif
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

                    <div class="tab-pane" id="membership" aria-labelledby="membership-tab" role="tabpanel">
                        <div class="d-flex justify-content-end gap-2 mb-3">
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addMembershipModal">
                                <i class="fas fa-plus"></i>
                                أضف عضوية جديدة
                            </button>
                            <button type="button" class="btn btn-secondary">
                                <i class="fas fa-history"></i>
                                سجل العضويات
                            </button>
                        </div>

                        <!-- معلومات العضوية الحالية -->
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="card border-0 bg-light h-100">
                                            <div class="card-body">
                                                <h6 class="card-title mb-3">معلومات العضوية الأساسية</h6>
                                                <p class="mb-2"><strong>رقم العضوية:</strong> {{ $client->code }}</p>
                                                <p class="mb-2"><strong>تاريخ التسجيل:</strong> {{ $client->created_at->format('Y-m-d') }}</p>
                                                <p class="mb-2"><strong>نوع العضوية:</strong>
                                                    @if ($client->client_type == 1)
                                                        <span class="badge bg-primary">فرد</span>
                                                    @elseif($client->client_type == 2)
                                                        <span class="badge bg-info">شركة</span>
                                                    @else
                                                        <span class="badge bg-secondary">غير محدد</span>
                                                    @endif
                                                </p>
                                                <p class="mb-0"><strong>حالة العضوية:</strong>
                                                    @if ($client->status)
                                                        <span class="badge bg-success">نشط</span>
                                                    @else
                                                        <span class="badge bg-warning">غير نشط</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card border-0 bg-light h-100">
                                            <div class="card-body">
                                                <h6 class="card-title mb-3">معلومات الائتمان</h6>
                                                <p class="mb-2"><strong>حد الائتمان:</strong>
                                                    <span class="text-success">{{ number_format($client->credit_limit, 2) }} ر.س</span>
                                                </p>
                                                <p class="mb-2"><strong>فترة الائتمان:</strong>
                                                    <span class="text-primary">{{ $client->credit_period }} يوم</span>
                                                </p>
                                                <div class="mt-3">
                                                    <div class="progress" style="height: 8px;">
                                                        <div class="progress-bar bg-success" role="progressbar" style="width: 65%"></div>
                                                    </div>
                                                    <small class="text-muted">نسبة استخدام حد الائتمان: 65%</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- قائمة العضويات -->
                        <div class="card">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">سجل العضويات</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>نوع العضوية</th>
                                                <th>تاريخ البدء</th>
                                                <th>تاريخ الانتهاء</th>
                                                <th>المبلغ</th>
                                                <th>الحالة</th>
                                                <th>الإجراءات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>العضوية الذهبية</td>
                                                <td>2024-01-01</td>
                                                <td>2024-12-31</td>
                                                <td>1,500.00 ر.س</td>
                                                <td><span class="badge bg-success">نشط</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-light" title="عرض التفاصيل">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-light" title="تجديد العضوية">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- نموذج إضافة عضوية جديدة -->
                        <div class="modal fade" id="addMembershipModal" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">إضافة عضوية جديدة</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="membershipForm">
                                            <div class="mb-3">
                                                <label class="form-label">نوع العضوية</label>
                                                <select class="form-select">
                                                    <option value="gold">العضوية الذهبية</option>
                                                    <option value="silver">العضوية الفضية</option>
                                                    <option value="bronze">العضوية البرونزية</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">تاريخ البدء</label>
                                                <input type="date" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">مدة العضوية (بالأشهر)</label>
                                                <input type="number" class="form-control" min="1">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">المبلغ</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control">
                                                    <span class="input-group-text">ر.س</span>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">ملاحظات</label>
                                                <textarea class="form-control" rows="3"></textarea>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                                        <button type="button" class="btn btn-success">حفظ العضوية</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- تبويب الجدول الزمني -->
                    <div class="tab-pane" id="serice_m" aria-labelledby="timeline-tab" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <div class="timeline">
                                    @foreach ($client->transactions->sortByDesc('date')->take(10) as $transaction)
                                        <div class="timeline-item">
                                            <div class="timeline-point-wrapper">
                                                <div class="timeline-point"></div>
                                            </div>
                                            <div class="timeline-event">
                                                <div class="d-flex justify-content-between">
                                                    <span class="timeline-event-time">{{ $transaction['date'] }}</span>
                                                    {{-- <span class="badge badge-{{ $transaction['status_color'] }}">
                                                        {{ $transaction['status_text'] }} --}}
                                                    </span>
                                                </div>
                                                <h6 class="timeline-event-header">{{ $transaction['type'] }} -
                                                    {{ $transaction['number'] }}</h6>
                                                <p class="timeline-event-description">
                                                    المبلغ: {{ $transaction['amount'] }} | الرصيد:
                                                    {{ $transaction['balance'] }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                   <!-- تبويب  الخدمات --> 
                   <div class="tab-pane" id="timeline" aria-labelledby="timeline-tab" role="tabpanel">
                    <div class="card">
                        <div class="card-body">



                            <div class="content-header row">
                                <div class="content-header-left col-md-9 col-12 mb-2">
                                    <div class="row breadcrumbs-top">
                                        <div class="col-12">
                                            <h2 class="content-header-title float-left mb-0">حجوزات العميل : {{$Client->first_name ?? ""}} </h2>
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
                            <div class="content-body">
                        
                              
                                <div class="card">
                           
                        </div>
                        
                        
                            <div class="card my-5">
                                <div class="card-body">
                                <!-- شريط الترتيب -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <ul class="nav nav-tabs" id="sortTabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="true">الكل</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="today-tab" data-bs-toggle="tab" data-bs-target="#today" type="button" role="tab" aria-controls="today" aria-selected="false">اليوم</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="week-tab" data-bs-toggle="tab" data-bs-target="#week" type="button" role="tab" aria-controls="week" aria-selected="false">الأسبوع</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="month-tab" data-bs-toggle="tab" data-bs-target="#month" type="button" role="tab" aria-controls="month" aria-selected="false">الشهر</button>
                                        </li>
                                    </ul>
                        
                                    <!-- أزرار العرض -->
                                    <div class="btn-group" role="group" aria-label="View Toggle">
                                        <button type="button" class="btn btn-light">
                                            <i class="bi bi-grid-3x3-gap-fill"></i> <!-- رمز الشبكة -->
                                        </button>
                                        <button type="button" class="btn btn-primary">
                                            <i class="bi bi-list-ul"></i> <!-- رمز القائمة -->
                                        </button>
                                    </div>
                                </div>
                        
                                <!-- بطاقة بيانات -->
                                <div class="card">
                                    <div class="card-body">
                                        @foreach ($bookings as $booking)
                                        <div class="row">
                                            <div class="col-auto">
                                                <!-- صورة افتراضية -->
                                                <div style="width: 50px; height: 50px; background-color: #f0f0f0; border-radius: 5px;"></div>
                                            </div>
                                            <div class="col">
                                                <h6>بيانات العميل</h6>
                                                <p class="mb-1">{{$booking->client->first_name ?? ""}}</p>
                                                <p class="mb-1">الخدمة :{{$booking->product->name ?? ""}}</p>
                                            </div>
                                            <div class="col-auto text-end">
                                                <p class="mb-1">الوقت من {{$booking->start_time ?? 0}} الى {{$booking->end_time ?? 0 }}</p>
                                                <p class="text-muted small mb-0">16:45:00</p>
                                                
                                                @if($booking->status == "confirm")
                                                    <span class="badge bg-warning text-dark">مؤكد</span>
                                                @elseif ($booking->status == "review")
                                                    <span class="badge bg-warning text-dark">تحت المراجعة</span>
                                                @elseif ($booking->status == "bill")
                                                    <span class="badge bg-warning text-dark">حولت للفاتورة</span>
                                                @elseif ($booking->status == "cancel")
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
                                       
                                        <!-- Horizontal line after each customer's data -->
                                        <hr>
                                    @endforeach
                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                            <!-- Bootstrap JS -->
                            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
                            <!-- Bootstrap Icons -->
                            <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
                        
                        


                        </div>
                    </div>
                   </div>
                   <!-- تبويب  العضويات -->

                   <div class="tab-pane" id="member" aria-labelledby="timeline-tab" role="tabpanel">
                    <div class="card">
                        <div class="card-body">

                            
                
                                    <table class="table" style="font-size: 1.1rem;">
                                        <thead>
                                            <tr>
                                                <th>المعرف</th>
                                                <th>بيانات العميل</th>
                
                                                <th>الباقة الحالية </th>
                                                <th>تاريخ الانتهاء</th>
                
                                                <th>الحالة</th>
                                                <th>ترتيب بواسطة</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($memberships as $membership)
                                                
                                            
                                            <tr>
                                                <td>#1</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="avatar avatar-sm bg-danger">
                                                            <span class="avatar-content">أ</span>
                                                        </div>
                                                        <div>
                                                            {{$membership->client->first_name ?? ""}}
                                                            <br>
                                                            <small class="text-muted"></small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><br><small class="text-muted">{{$membership->packege->commission_name ?? ""}}</small></td>
                
                                                <td><small class="text-muted">{{$membership->end_date ?? ""}}</small></td>
                
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="rounded-circle bg-info" style="width: 8px; height: 8px;"></div>
                                                        <span class="text-muted">
                                                          @if($membership->status == "active")
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
                                                            <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1 btn-sm"
                                                                type="button"id="dropdownMenuButton303" data-toggle="dropdown"
                                                                aria-haspopup="true"aria-expanded="false"></button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton303">
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('Memberships.show', 1) }}">
                                                                        <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('Memberships.edit', 1) }}">
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
