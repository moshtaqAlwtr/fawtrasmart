@extends('master')


@section('title')
    عرض معلومات الباقة
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">عرض معلومات الباقة </h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                            <li class="breadcrumb-item active"> عرض</li>
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
                                    غير نشط
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
                class="btn btn-outline-danger btn-sm d-inline-flex align-items-center justify-content-center px-3"
                style="min-width: 90px;" data-toggle="modal" data-target="#modal_DELETE1">
                <i class="fa fa-trash ms-1 text-danger"></i> حذف
            </a>
            <a href="#"
    class="btn btn-outline-success btn-sm d-inline-flex align-items-center justify-content-center px-3"
    style="min-width: 90px;" data-toggle="modal" data-target="#modal_ACTIVATE1">
    <i class="fa fa-check-circle ms-1 text-success"></i> تنشيط
</a>


        </div>

        <div class="card-body">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#info" role="tab">
                        <span>التفاصيل</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#activity" role="tab">
                        <span>سجل النشاطات</span>
                    </a>
                </li>
            </ul>

            <div class="tab-content p-3">
                <!-- تبويب التفاصيل -->
                <div class="tab-pane active" id="info" role="tabpanel">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="p-1" style="background-color: #F8F9FA;">
                                <h6 class="mb-0 fs-5">معلومات باقة</h6>
                            </div>

                            <div class="row p-3">
                                <div class="col-6 text-end">
                                    <div class="mb-4">
                                        <span class="text-muted fs-5">:الاسم</span>
                                        <div class="fs-5">مجاني</div>
                                    </div>
                                    <div class="mb-4">
                                        <span class="text-muted fs-5">:الحالة</span>
                                        <div class="fs-5">غير نشط</div>
                                    </div>
                                    <div>
                                        <span class="text-muted fs-5">:السعر</span>
                                        <div class="fs-5">100</div>
                                    </div>
                                </div>
                                <div class="col-6 text-end">
                                    <div class="mb-4">
                                        <span class="text-muted fs-5">:النوع</span>
                                        <div class="fs-5">العضوية</div>
                                    </div>
                                    <div class="mb-4">
                                        <span class="text-muted fs-5">:الفترة</span>
                                        <div class="fs-5">10 شهر</div>
                                    </div>
                                    <div>
                                        <span class="text-muted fs-5">:الوصف</span>
                                        <div class="fs-5">ثمن</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-end fs-5" style="background-color: #F8F9FA;">نوع الرصيد</th>
                                            <th class="text-center fs-5" style="background-color: #F8F9FA;">المبلغ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-end fs-5">نقاط الولاء</td>
                                            <td class="text-center fs-5">155</td>
                                        </tr>
                                    </tbody>
                                </table>
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
