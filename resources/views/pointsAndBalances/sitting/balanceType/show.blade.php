@extends('master')

@section('page-header')
@endsection
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
                <a class="nav-link active" data-bs-toggle="tab" href="#details" role="tab">
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
            <div class="tab-pane active" id="details" role="tabpanel">
                <div class="">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="text-muted mb-2">الاسم:</label>
                                                <h5 class="mb-0">نقاط الولاء</h5>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="text-muted mb-2">الحالة:</label>
                                                <h5 class="mb-0">نشط</h5>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="text-muted mb-2">الوحدة:</label>
                                                <h5 class="mb-0">نقطة</h5>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="text-muted mb-2">الوصف:</label>
                                                <h5 class="mb-0">--</h5>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="decimal" disabled>
                                                    <label class="form-check-label" for="decimal">
                                                        إتاحة الأرقام العشرية
                                                    </label>
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

            <!-- تبويب سجل النشاطات -->
            <div class="tab-pane" id="activity" role="tabpanel">
                <p class="text-muted text-center">لا توجد نشاطات حتى الآن</p>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $(document).ready(function() {
        // تفعيل التبويبات
        $('a[data-bs-toggle="tab"]').on('click', function (e) {
            e.preventDefault();
            $(this).tab('show');
        });
    });
</script>
@endsection
