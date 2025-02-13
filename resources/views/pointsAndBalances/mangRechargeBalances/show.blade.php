@extends('master')

@section('css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/progressbar.js/1.1.0/progressbar.min.js"></script>
    <style>
        .progress-circle {
            width: 200px;
            height: 200px;
            margin: 0 auto;
            position: relative;
        }
        .progress-circle-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            width: 100%;
        }
        .progress-circle svg path:first-child {
            stroke: #eee !important;
        }
        .progress-circle svg path:last-child {
            stroke: #4E5381 !important;
        }
    </style>
@endsection

@section('title')
    عرض معلومات الشحن
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">عرض معلومات الشحن</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                            <li class="breadcrumb-item active">عرض معلومات الشحن</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="avatar avatar-md bg-danger">
                        <span class="avatar-content fs-4">أ</span>
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center gap-2">
                                <h5 class="mb-0 fw-bolder">أسواق السلطان</h5>
                                <small class="text-muted">#123234</small>
                            </div>
                            <div class="vr mx-2"></div>
                            <div class="d-flex align-items-center">
                                <small class="text-muted">
                                    <i class="fa fa-circle me-1" style="font-size: 8px;"></i>
                                    موقوف
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-title p-2 d-flex align-items-center gap-2">
            <a href="{{ route('MangRechargeBalances.edit', 1) }}"
                class="btn btn-outline-info btn-sm d-inline-flex align-items-center justify-content-center px-3"
                style="min-width: 90px;">
                <i class="fa fa-edit ms-1 text-info"></i> تعديل
            </a>

            <a href="#"
                class="btn btn-outline-warning btn-sm d-inline-flex align-items-center justify-content-center px-3"
                style="min-width: 90px;" data-toggle="modal" data-target="#modal_CANCEL1">
                <i class="fa fa-ban ms-1 text-warning"></i> الغاء الايقاف
            </a>

            <a href="#"
                class="btn btn-outline-danger btn-sm d-inline-flex align-items-center justify-content-center px-3"
                style="min-width: 90px;" data-toggle="modal" data-target="#modal_DELETE1">
                <i class="fa fa-trash ms-1 text-danger"></i> حذف
            </a>
        </div>

        <div class="card-body">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#info" role="tab">
                        <span>معلومات الشحن</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#usage" role="tab">
                        <span>استخدام الرصيد</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#activity" role="tab">
                        <span>سجل النشاطات</span>
                    </a>
                </li>
            </ul>

            <div class="tab-content p-3">
                <!-- تبويب معلومات الشحن -->
                <div class="tab-pane active" id="info" role="tabpanel">
                    <div class="">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="pb-2 h-100">
                                    <div class="card h-100" style="background-color: #f8f9fa;">
                                        <div class="d-flex align-items-center gap-2 p-3">
                                            <div class="bg-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                <span class="text-white fs-4">ا</span>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="fw-bold fs-5">اسواق السلطان</span>
                                                    <a href="" class="text-decoration-underline text-muted" style="font-size: 0.9rem;">#123234</a>
                                                </div>
                                                <div class="mt-2">
                                                    <a href="" class="btn btn-light btn-sm d-flex align-items-center gap-1 px-3">
                                                        <i class="fa fa-user"></i>
                                                        عرض الصفحة الشخصية
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="pb-2 h-100">
                                    <div class="card h-100 p-3 d-block" style="background-color: #f8f9fa;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="text-muted mb-1">الرصيد المستخدم:</p>
                                                <p class="lh-1">
                                                    <span class="d-block fs-22 font-weight-bold">0</span>
                                                    <span class="fs-12">نقطة</span>
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="text-muted mb-1">نوع الرصيد:</p>
                                                <p class="lh-16 mb-0 fs-14 font-weight-bold">
                                                    نقاط الولاء
                                                    <a href="" class="font-weight-normal fs-12 text-decoration-underline ml-2" target="_blank">#1</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="pb-2 h-100">
                                    <div class="card h-100 p-3 d-block" style="background-color: #f8f9fa;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="text-muted mb-1">تاريخ البدء:</p>
                                                <p class="lh-1">
                                                    <span class="d-block fs-20 font-weight-bold">01/01/2025</span>
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="text-muted mb-1">تاريخ الانتهاء:</p>
                                                <p class="lh-1">
                                                    <span class="d-block fs-20 font-weight-bold">01/01/2025</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="py-2 h-100">
                                    <div class="card h-100 d-flex align-items-center justify-content-center" style="background-color: #f8f9fa;">
                                        <div class="text-center">
                                            <div id="progress-circle" class="progress-circle">
                                                <div class="progress-circle-text">
                                                    <strong style="font-size: 24px; display: block;">1</strong>
                                                    <span style="font-size: 12px; display: block;">من 1</span>
                                                    <span style="font-size: 12px; display: block;">نقطة متبقية</span>
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <p class="mb-0">0 نقطة <strong style="color: #4E5381">مستهلك</strong></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="py-2 h-100">
                                    <div class="card h-100 p-3 d-block" style="background-color: #f8f9fa;">
                                        <p class="text-muted mb-1">الوصف:</p>
                                        <p class="pre mb-0">تاتنم</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- تبويب استخدام الرصيد -->
                <div class="tab-pane" id="usage" role="tabpanel">
                    <p class="text-muted text-center">لا يوجد استخدام للرصيد حتى الآن</p>
                </div>

                <!-- تبويب سجل النشاطات -->
                <div class="tab-pane" id="activity" role="tabpanel">
                    <p class="text-muted text-center">لا توجد نشاطات حتى الآن</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var circle = new ProgressBar.Circle('#progress-circle', {
                color: '#4E5381',
                strokeWidth: 4,
                trailWidth: 4,
                duration: 1400,
                easing: 'easeInOut',
                trailColor: '#eee',
            });

            // تعيين قيمة التقدم (1 من أصل 1 = 100%)
            circle.animate(1.0);
        });
    </script>
@endsection
