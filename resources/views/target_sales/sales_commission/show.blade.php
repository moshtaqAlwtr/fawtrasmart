@extends('master')

@section('title')
    عرض قواعد العمولة
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">عرض قواعد العمولة </h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a></li>
                            <li class="breadcrumb-item active">عرض</li>
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
                                <h5 class="mb-0 fw-bolder">عمولة المبيعات </h5>
                                <small class="text-muted">#1</small>
                            </div>
                            <div class="vr mx-2"></div>
                            <div class="d-flex align-items-center">
                                <small class="text-success">
                                    <i class="fa fa-circle me-1" style="font-size: 8px;"></i>
                                    نشط
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">

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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="d-flex align-items-center gap-3 mb-4">
                                                <div class="avatar avatar-md bg-secondary"
                                                    style="width: 42px; height: 42px;">
                                                    <span class="avatar-content" style="font-size: 1rem;">م</span>
                                                </div>
                                                <div>
                                                    <h4 class="mb-0" style="font-size: 1.1rem;">محمد الادريسي <span
                                                            class="text-muted" style="font-size: 0.9rem;">#5</span></h4>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 mb-4">
                                                    <h6 class="text-muted mb-2">تاريخ العملية التجارية</h6>
                                                    <p class="h5">08/07/2024</p>
                                                </div>
                                                <div class="col-md-4 mb-4">
                                                    <h6 class="text-muted mb-2">فاتورة</h6>
                                                    <p class="h5">
                                                        <a href="#" class="text-primary">07859#</a>
                                                        <br>
                                                        <small class="text-muted">شركة خدماتك للوقود 3 1118#</small>
                                                    </p>
                                                </div>
                                                <div class="col-md-4 mb-4">
                                                    <h6 class="text-muted mb-2">مبلغ المبيعات</h6>
                                                    <p class="h5">270.00 ر.س</p>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 mb-4">
                                                    <h6 class="text-muted mb-2">كمية المبيعات</h6>
                                                    <p class="h5">15 عناصر</p>
                                                </div>
                                                <div class="col-md-4 mb-4">
                                                    <h6 class="text-muted mb-2">إجمالي العمولة</h6>
                                                    <p class="h5 text-success">8.10 ر.س</p>
                                                </div>
                                            </div>



                                            <div class="mt-4">
                                                <h6 class="text-muted mb-3">قواعد العمولة:</h6>
                                                <div class="d-flex align-items-center gap-2">
                                                    <a href="#" class="text-primary">عمولة مبيعات 1#</a>
                                                </div>
                                            </div>

                                            <div class="mt-4">
                                                <h6 class="text-muted mb-3">قائمة العناصر</h6>
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>البند</th>
                                                                <th>السعر</th>
                                                                <th>الكمية</th>
                                                                <th>المجموع</th>
                                                                <th>عمولة</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <a href="#" class="text-primary">عطر 50 ملي
                                                                        #3961</a>
                                                                </td>
                                                                <td>18.00 ر.س</td>
                                                                <td>15</td>
                                                                <td>270.00 ر.س</td>
                                                                <td>8.10 ر.س (3%)</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3" class="text-end">الإجمالي</td>
                                                                <td>270.00 ر.س</td>
                                                                <td>8.10 ر.س</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
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
                    <div class="timeline p-4">
                        <!-- يمكن إضافة سجل النشاطات هنا -->
                        <p class="text-muted text-center">لا توجد نشاطات حتى الآن</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
