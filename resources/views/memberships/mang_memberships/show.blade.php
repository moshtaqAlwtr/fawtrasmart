@extends('master')



@section('title')
    عرض العضوية
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">عرض معلومات العضوية </h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                            <li class="breadcrumb-item active">عرض </li>
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
                    <div class="avatar avatar-md bg-light-primary">
                        <span class="avatar-content fs-4">ت</span>
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center gap-2">
                                <h5 class="mb-0 fw-bolder">مباني </h5>
                                <small class="text-muted">#1</small>
                            </div>
                            <div class="vr mx-2"></div>
                            <div class="d-flex align-items-center">
                                <small class="text-success">
                                    <i class="fa fa-circle me-1" style="font-size: 8px;"></i>
                                    غير نشط
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">

                    <button class="btn btn-success">
                        <i class="fa fa-refresh"></i> تجديد
                    </button>
                    <div class="vr mx-1"></div>
                    <button class="btn btn-icon btn-outline-primary">
                        <i class="fa fa-chevron-up"></i>
                    </button>
                    <div class="vr mx-1"></div>
                    <button class="btn btn-icon btn-outline-primary">
                        <i class="fa fa-chevron-down"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-title p-2 d-flex align-items-center gap-2">
            <!-- زر تعديل -->
            <a href="{{ route('MangRechargeBalances.edit', 1) }}"
                class="btn btn-outline-info btn-sm d-inline-flex align-items-center justify-content-center px-3"
                style="min-width: 90px;">
                <i class="fa fa-edit ms-1 text-info"></i> تعديل
            </a>

            <!-- زر حذف -->
            <a href="#"
                class="btn btn-outline-danger btn-sm d-inline-flex align-items-center justify-content-center px-3"
                style="min-width: 90px;" data-toggle="modal" data-target="#modal_DELETE1">
                <i class="fa fa-trash ms-1 text-danger"></i> حذف
            </a>

            <!-- زر تجديد -->
            <a href="#"
                class="btn btn-outline-primary btn-sm d-inline-flex align-items-center justify-content-center px-3"
                style="min-width: 90px;" data-toggle="modal" data-target="#modal_RENEW1">
                <i class="fa fa-refresh ms-1 text-primary"></i> تجديد
            </a>

            <!-- زر إلغاء الإيقاف -->
            <a href="#"
                class="btn btn-outline-warning btn-sm d-inline-flex align-items-center justify-content-center px-3"
                style="min-width: 90px;" data-toggle="modal" data-target="#modal_CANCEL1">
                <i class="fa fa-ban ms-1 text-warning"></i> إلغاء الإيقاف
            </a>

            <!-- زر إضافة فترة توقف -->
            <a href="#"
                class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center justify-content-center px-3"
                style="min-width: 90px;" data-toggle="modal" data-target="#modal_STOP1">
                <i class="fa fa-clock ms-1 text-secondary"></i> أضف فترة توقف
            </a>
        </div>


        <div class="card-body">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#info" role="tab">
                        <span>معلومات العضوية </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#usage" role="tab">
                        <span> التجديدات </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#activity" role="tab">
                        <span>سجل النشاطات</span>
                    </a>
                </li>
            </ul>

            <div class="tab-content p-3">
                <!-- تبويب معلومات العضوية -->
                <div class="tab-pane active" id="info" role="tabpanel">
                    <div class="">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="pb-2 h-100">
                                    <div class="card h-100" style="background-color: #f8f9fa;">
                                        <div class="d-flex align-items-center gap-2 p-3">
                                            <div class="bg-brown rounded-circle d-flex align-items-center justify-content-center"
                                                style="width: 50px; height: 50px;">
                                                <span class="text-white fs-4">ا</span>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="fw-bold fs-5">اسواق ابو مدهش</span>
                                                    <a href="" class="text-decoration-underline text-muted"
                                                        style="font-size: 0.9rem;">#123136</a>
                                                </div>
                                                <div class="mt-2">
                                                    <a href=""
                                                        class="btn btn-light btn-sm d-flex align-items-center gap-1 px-3">
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
                                            <div class="col-12">
                                                <p class="text-muted mb-1">الباقة الحالية:</p>
                                                <p class="lh-1">
                                                    <span class="d-block fs-20 font-weight-bold">الاصول الثابتة</span>
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
                                                <p class="text-muted mb-1">تاريخ الالتحاق:</p>
                                                <p class="lh-1">
                                                    <span class="d-block fs-20 font-weight-bold">02/01/2025</span>
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="text-muted mb-1">تاريخ الانتهاء:</p>
                                                <p class="lh-1">
                                                    <span class="d-block fs-20 font-weight-bold">02/01/2025</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="py-2 h-100">
                                    <div class="card h-100 p-3 d-block" style="background-color: #f8f9fa;">
                                        <p class="text-muted mb-1">الوصف:</p>
                                        <p class="pre mb-0">تتمت</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- تبويب استخدام الرصيد -->
                <div class="tab-pane" id="usage" role="tabpanel">
                    <p class="text-muted text-center">لا يوجد اشتراكات عضوية اضيفت حتى الان </p>
                </div>

                <!-- تبويب سجل النشاطات -->
                <div class="tab-pane" id="activity" role="tabpanel">
                    <p class="text-muted text-center">لا توجد نشاطات حتى الآن</p>
                </div>
            </div>
        </div>
    </div>
@endsection
