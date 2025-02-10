@extends('master')

@section('title')
    عرض امر تشغيل
@stop

@section('content')
    {{-- @if (session('toast_message'))
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
@endif --}}
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">عرض امر توريد </h2>
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

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-end">
                        <span>العميل: السواق أعمدة السلطان #203</span>
                    </div>
                    <div class="d-flex gap-2">

                        <div class="dropdown">
                            <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                اختر الحالة
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#"><span class="badge bg-info">جاري الشحن</span></a></li>
                                <li><a class="dropdown-item" href="#"><span class="badge bg-warning">تحت التجهيز</span></a></li>
                                <li><a class="dropdown-item" href="#"><span class="badge bg-success">تم التسليم</span></a></li>
                                <li><a class="dropdown-item" href="#"><span class="badge bg-danger">تم الدفع</span></a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="{{ route('SupplyOrders.edit_status') }}"><i class="fas fa-cog"></i> تعديل قائمة الحالات</a></li>
                            </ul>
                        </div>

                        <div class="dropdown">
                            <button class="btn btn-success btn-sm dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-plus me-2"></i>اضافة
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('invoices.create') }}">فاتورة جديدة</a></li>
                                <li><a class="dropdown-item" href="{{ route('CreditNotes.create') }}">إنشاء إشعار دائن</a></li>
                                <li><a class="dropdown-item" href="{{route('questions.create')}}">عرض سعر جديد</a></li>
                                <li><a class="dropdown-item" href="#">أضف رصيد مدفوعات</a></li>
                                <li><a class="dropdown-item" href="#">إضافة مصروف</a></li>
                                <li><a class="dropdown-item" href="#">إضافة إيراد</a></li>
                                <li><a class="dropdown-item" href="#">فاتورة شراء جديد</a></li>
                                <li><a class="dropdown-item" href="#">إذن إضافة مخزن</a></li>
                                <li><a class="dropdown-item" href="#">إذن صرف مخزن</a></li>
                                <li><a class="dropdown-item" href="#">إضافة معاملة موجودة</a></li>
                                <li><a class="dropdown-item" href="#">إضافة وقت</a></li>
                                <li><a class="dropdown-item" href="{{route('journal.create')}}">إضافة قيد</a></
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">

        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex gap-2">
                    <a href="" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center">
                        <i class="fas fa-edit me-1"></i> تعديل
                    </a>
                    <a href="#" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center">
                        <i class="fas fa-print me-1"></i> طباعة
                    </a>
                    <a href="#" class="btn btn-sm btn-outline-danger d-inline-flex align-items-center">
                        <i class="fas fa-file-pdf me-1"></i> PDF
                    </a>
                    <a href="#" class="btn btn-sm btn-outline-warning d-inline-flex align-items-center">
                        <i class="fas fa-paperclip me-1"></i> إضافة ملاحظة/مرفق
                    </a>
                    <a href="" class="btn btn-sm btn-outline-info d-inline-flex align-items-center">
                        <i class="fas fa-calendar-alt me-1"></i> ترتيب موعد
                    </a>
                    <a href="#" class="btn btn-sm btn-outline-success d-inline-flex align-items-center">
                        <i class="fas fa-exchange-alt me-1"></i> تعيين معاملة
                    </a>
                    <a href="" class="btn btn-sm btn-outline-dark d-inline-flex align-items-center">
                        <i class="fas fa-copy me-1"></i> نسخ
                    </a>
                    <a href="#" class="btn btn-sm btn-outline-danger d-inline-flex align-items-center">
                        <i class="fas fa-trash-alt me-1"></i> حذف
                    </a>




                </div>

            </div>

            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details" aria-controls="details"
                        role="tab" aria-selected="true">
                        <span class="badge badge-pill badge-primary"></span> التفاصيل</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="invoices-tab" data-toggle="tab" href="#invoices" aria-controls="invoices"
                        role="tab" aria-selected="false">
                        امر التوريد <span class="badge badge-pill badge-primary"></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="appointments-tab" data-toggle="tab" href="#appointments"
                        aria-controls="appointments" role="tab" aria-selected="false">
                        المواعيد <span class="badge badge-pill badge-primary"></span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="account-movement-tab" data-toggle="tab" href="#account-movement"
                        aria-controls="account-movement" role="tab" aria-selected="false">
                        سجل النشاطات <span class="badge badge-pill badge-info"></span>
                    </a>
                </li>


            </ul>
            <div class="tab-content">
                <!-- تبويب التفاصيل -->
                <div class="tab-pane active" id="details" aria-labelledby="details-tab" role="tabpanel">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <!-- عنوان القسم -->
                            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                                <h6 class="text-primary fw-bold">معلومات عامة</h6>
                                <span class="badge bg-primary fs-6">تفاصيل</span>
                            </div>

                            <!-- معلومات عامة -->
                            <div class="mb-4">
                                <div class="d-flex align-items-center">
                                    <h5 class="text-dark fw-bold mb-0">أسواق أغذية السلطان</h5>
                                    <span class="badge bg-info ms-3">#870</span>
                                    <span class="badge bg-success ms-2">1</span>
                                </div>
                            </div>

                            <!-- جدول المعلومات -->
                            <div class="row gy-3">
                                <div class="col-md-2 text-secondary fw-bold">مسمى:</div>
                                <div class="col-md-4">وظيفي</div>
                                <div class="col-md-2 text-secondary fw-bold">رقم الأمر:</div>
                                <div class="col-md-4">#1</div>

                                <div class="col-md-2 text-secondary fw-bold">تاريخ الانتهاء:</div>
                                <div class="col-md-4">25/12/2024</div>
                                <div class="col-md-2 text-secondary fw-bold">تاريخ البدء:</div>
                                <div class="col-md-4">25/12/2024</div>

                                <div class="col-md-2 text-secondary fw-bold">الحالة:</div>
                                <div class="col-md-4">-</div>
                                <div class="col-md-2 text-secondary fw-bold">الميزانية:</div>
                                <div class="col-md-4">-</div>

                                <div class="col-md-2 text-secondary fw-bold">وسوم:</div>
                                <div class="col-md-10">-</div>

                                <div class="col-md-2 text-secondary fw-bold">الوصف:</div>
                                <div class="col-md-10">اومر توريد</div>
                            </div>

                            <!-- معلومات الموظفين -->
                            <div class="mt-5">
                                <h6 class="text-primary fw-bold border-bottom pb-2">معلومات الموظفين المعنيين</h6>
                                <p class="text-muted mt-2">-</p>
                            </div>

                            <!-- بيانات الشحنة -->
                            <div class="mt-5">
                                <h6 class="text-primary fw-bold border-bottom pb-2">بيانات الشحنة</h6>
                                <div class="row gy-3 mt-3">
                                    <div class="col-md-2 text-secondary fw-bold">بيانات المنتجات:</div>
                                    <div class="col-md-10">عطورات</div>

                                    <div class="col-md-2 text-secondary fw-bold">عنوان الشحن:</div>
                                    <div class="col-md-10">الدمام</div>

                                    <div class="col-md-2 text-secondary fw-bold">رقم التتبع:</div>
                                    <div class="col-md-10">12</div>

                                    <div class="col-md-2 text-secondary fw-bold">بوليصة الشحن:</div>
                                    <div class="col-md-10">
                                        <img src="{{ asset('path/to/shipping/image.jpg') }}" alt="بوليصة الشحن"
                                            class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- تبويبة امر توريد   --}}
                <div class="tab-pane" id="invoices" aria-labelledby="invoices-tab" role="tabpanel">


                    <div class="col-md-12">
                        <div class="card">
                            <div class="tab-pane fade show active"
                                style="background: lightslategray; min-height: 100vh; padding: 20px;">
                                <div class="card shadow" style="max-width: 600px; margin: 20px auto;">
                                    <div class="card-body bg-white p-4" style="min-height: 400px; overflow: auto;">
                                        {{-- <div style="transform: scale(0.8); transform-origin: top center;">
                                            @include('Accounts.asol.pdf', ['asset' => $asset])
                                        </div> --}}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                {{-- تبويبة المواعيد  --}}

                <div class="tab-pane" id="appointments" aria-labelledby="appointments-tab" role="tabpanel">

                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="d-flex gap-2 flex-wrap">
                                <button class="btn btn-sm btn-outline-primary filter-appointments" data-filter="all">
                                    الكل
                                    <span class="badge badge-light"></span>
                                </button>
                                <button class="btn btn-sm btn-outline-success filter-appointments" data-filter="">
                                    تم
                                    <span class="badge badge-light"></span>
                                </button>
                                <button class="btn btn-sm btn-outline-warning filter-appointments" data-filter="">
                                    تم صرف النظر عنه
                                    <span class="badge badge-light"></span>
                                </button>
                                <button class="btn btn-sm btn-outline-danger filter-appointments" data-filter="">
                                    تم جدولته
                                    <span class="badge badge-light"></span>
                                </button>
                                <button class="btn btn-sm btn-outline-info filter-appointments" data-filter="">
                                    تم جدولته مجددا
                                    <span class="badge badge-light"></span>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div id="appointments-container">

                                <div class="card mb-2 appointment-item" data-appointment-id="" data-status=""
                                    data-date="">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-md-4">
                                                <strong>#</strong>
                                                <p class="mb-0"></p>
                                                <small class="text-muted"></small>
                                            </div>
                                            <div class="col-md-3">
                                                <p class="mb-0">
                                                    <small></small>
                                                </p>
                                                <small class="text-muted">
                                                    بواسطة:
                                                </small>
                                            </div>
                                            <div class="col-md-3 text-center">
                                                <span class="badge status-badge">

                                                </span>
                                            </div>
                                            <div class="col-md-2 text-end">

                                            </div>
                                        </div>

                                        <!-- معلومات إضافية للموعد -->
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <small class="text-muted">
                                                    <strong>نوع الإجراء:</strong>

                                                </small>
                                            </div>
                                            <div class="col-md-6">
                                                <small class="text-muted">
                                                    <strong>مدة الموعد:</strong>

                                                </small>
                                            </div>

                                            <div class="col-12 mt-2">
                                                <small class="text-muted">
                                                    <strong>ملاحظات:</strong>

                                                </small>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- Modal for Adding Notes -->
                                <div class="modal fade" id="noteModal" tabindex="-1" role="dialog"
                                    aria-labelledby="noteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="noteModalLabel">إضافة ملاحظات للموعد</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form id="noteForm" method="POST">

                                                <div class="modal-body">
                                                    <input type="hidden" name="status" value="">
                                                    <div class="form-group">
                                                        <label for="notes">الملاحظات</label>
                                                        <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="أدخل ملاحظاتك هنا"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">إلغاء</button>
                                                    <button type="button" class="btn btn-primary"
                                                        onclick="submitCompletedAppointment()">حفظ الملاحظات</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-info text-center">
                                    لا توجد مواعيد
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- تبويب سجل النشاطات  -->
                <div class="tab-pane" id="account-movement" aria-labelledby="account-movement-tab" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-3">



                    </div>
                    <div class="position-relative">
                        <div class="position-absolute end-0 me-4">
                            <button class="btn btn-light btn-sm rounded-pill shadow-sm">امس</button>
                        </div>
                        <div class="car" style="background: #4aa4fe">
                            <div class="activity-list p-4">
                                <div class="card-content">
                                    <div class="card border-0">
                                        <ul class="activity-timeline timeline-left list-unstyled">
                                            <li class="d-flex position-relative mb-4">
                                                <div class="timeline-icon position-absolute" style="left: -43px; top: 0;">
                                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center"
                                                        style="width: 35px; height: 35px;">
                                                        <i class="fas fa-plus text-white"></i>
                                                    </div>
                                                </div>
                                                <div class="timeline-info position-relative"
                                                    style="padding-left: 20px; border-left: 2px solid #e9ecef;">
                                                    <div class="d-flex align-items-center mb-1">
                                                        <span class="badge bg-purple me-2">محمد العتيبي</span>
                                                        <span class="text-dark">قام بإضافة المسمى الوظيفي moshtaq
                                                            #1</span>
                                                    </div>
                                                    <div class="d-flex align-items-center mt-2">
                                                        <small class="text-muted me-3">
                                                            <i class="fas fa-building me-1"></i>
                                                            Main Branch
                                                        </small>
                                                        <small class="text-muted">
                                                            <i class="far fa-clock me-1"></i>
                                                            14:45:53
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="ms-auto">
                                                    <a href="#" class="text-muted">
                                                        <i class="fas fa-external-link-alt"></i>
                                                    </a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    </div>

@endsection
@section('scripts')
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}

    <script src="{{ asset('assets/js/applmintion.js') }}"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection
