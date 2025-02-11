@extends('master')


@section('title')
    عرض معلومات الاستهلاك والارصدة
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">عرض معلومات الاستهلاك والارصدة</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
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
            <a href="{{ route('ManagingBalanceConsumption.edit', 1) }}"
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
                        <span>معلومات الاستهلاك</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#activity" role="tab">
                        <span>سجل النشاطات</span>
                    </a>
                </li>
            </ul>

            <div class="tab-content p-3">
                <!-- تبويب معلومات الاستهلاك -->
                <div class="tab-pane active" id="info" role="tabpanel">
                    <div class="">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="pb-2 h-100">
                                    <div class="card h-100" style="background-color: #f8f9fa;">
                                        <div class="d-flex align-items-center gap-2 p-3">
                                            <div class="bg-danger rounded-circle d-flex align-items-center justify-content-center"
                                                style="width: 50px; height: 50px;">
                                                <span class="text-white fs-4">ا</span>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="fw-bold fs-5">اسواق السلطان</span>
                                                    <a href="" class="text-decoration-underline text-muted"
                                                        style="font-size: 0.9rem;">#123234</a>
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
                                                <p class="text-muted mb-1">الرصيد المستخدم:</p>
                                                <p class="lh-1">
                                                    <span class="d-block fs-22 font-weight-bold">10</span>
                                                    <span class="fs-12">نقطة</span>
                                                </p>
                                            </div>
                                            <div class="col-12">
                                                <p class="text-muted mb-1">نوع الرصيد:</p>
                                                <p class="lh-16 mb-0 fs-14 font-weight-bold">
                                                    نقاط الولاء
                                                    <a href=""
                                                        class="font-weight-normal fs-12 text-decoration-underline ml-2"
                                                        target="_blank">#1</a>
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
                                            <div class="col-12">
                                                <p class="text-muted mb-1">تاريخ الاستهلاك:</p>
                                                <p class="lh-1">
                                                    <span class="d-block fs-20 font-weight-bold">02/01/2025</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mt-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- الجزء الأول: الجدول -->
                                            <div class="col-md-6">
                                                <table class="table table-bordered text-center">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>شحن الرصيد</th>
                                                            <th>مستهلك</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex justify-content-center align-items-center">
                                                                    <span>نقطة</span>
                                                                    <a href="#" class="text-primary text-decoration-underline fw-bold me-2">#1</a>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span>10 نقطة</span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <!-- الجزء الثاني: الوصف -->
                                            <div class="col-md-6">

                                                <div class="p-3" style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 5px;">
                                                    <p class="mb-0" style="font-size: 1.1rem;">
                                                        هذا النص هو مثال لوصف يمكن أن يُضاف هنا. يمكن تخصيص الوصف حسب الحاجة.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- تبويب سجل النشاطات -->
                <div class="tab-pane" id="activity" role="tabpanel">
                    <p class="text-muted text-center">لا توجد نشاطات حتى الآن</p>
                </div>
            </div>
        </div>
    </div>
@endsection
