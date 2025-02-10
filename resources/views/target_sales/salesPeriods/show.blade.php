@extends('master')

@section('title')
    عرض فترة المبيعات
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">عرض فترة المبيعات</h2>
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
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center" style="gap: 10px;">
                    <h4 class="mb-0">فترة المبيعات #1</h4>
                    <div class="d-flex align-items-center" style="gap: 10px;">
                        <span class="bg-secondary rounded-circle me-2" style="width: 8px; height: 8px;"></span>
                        <span>مفتوح</span>
                    </div>
                </div>
                <div class="d-flex gap-2" style="gap: 10px;">
                    <button class="btn btn-success d-flex align-items-center gap-2" style="gap: 10px;">
                        <i class="fa fa-check"></i>
                        <span>موافقة</span>
                    </button>
                    <button class="btn btn-danger d-flex align-items-center gap-2" style="gap: 10px;">
                        <i class="fa fa-times"></i>
                        <span>رفض</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-title p-2 d-flex align-items-center gap-2">

            <a href="#"
                class="btn btn-outline-danger btn-sm d-inline-flex align-items-center justify-content-center px-3"
                style="min-width: 90px;" data-toggle="modal" data-target="#modal_DELETE1">
                حذف <i class="fa fa-trash ms-1"></i>
            </a>
            <div class="vr"></div>


        </div>

        <div class="card-body">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#details" role="tab">
                        <span>التفاصيل</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#commission" role="tab">
                        <span>عمولات مبيعات </span>
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
                    <div class="px-3 pt-6">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-6 lh-1">
                                    <div class="d-flex align-items-center">

                                        <div class="ml-2">
                                            <h5 class="font-weight-bold fs-20 lh-1 mb-1">محمد الادريسي</h5>
                                            <a href="" target="_blank"
                                                class="text-inactive font-weight-medium fs-12 text-decoration-underline">#5</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-6 lh-1">
                                    <p class="fs-20 font-weight-bold mb-1">01/12/2024</p>
                                    <p class="fs-14 font-weight-medium mb-0 text-inactive">من</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-6 lh-1">
                                    <p class="fs-20 font-weight-bold mb-1">02/01/2025</p>
                                    <p class="fs-14 font-weight-medium mb-0 text-inactive">إلي</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-6">
                                    <p class="text-inactive font-weight-medium mb-1">الهدف:</p>
                                    <p class="font-weight-bold fs-18 text-dark-blue mb-0">3000</p>
                                    <p class="font-weight-medium fs-14 text-danger mb-0"><i
                                            class="fas fa-exclamation mr-1"></i>الهدف لم يتحقق</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-6">
                                    <p class="text-inactive font-weight-semibold mb-1">المبيعات / الهدف:</p>
                                    <div>
                                        <div class="d-flex justify-content-between" style="margin-bottom: 2px;">
                                            <span class="fs-5">3,000/0</span>
                                        </div>
                                        <div class="progress" style="height: 4px; margin: 2px 0;">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 0%;"
                                                aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="d-flex justify-content-between" style="margin-top: 2px;">
                                            <span class="fs-5">0.00 ر.س</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-6">
                                    <div class="w-100 p-3 text-center bg-danger text-white">
                                        <p class="fs-14 fs-16-lg font-weight-semibold mb-0 opacity-75">إجمالي العمولة</p>
                                        <p class="fs-16 fs-24-lg font-weight-bold mb-0">0.00 ر.س</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="spacer">
                    <div class="px-3">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-6">
                                    <p class="text-inactive font-weight-semibold mb-1">قواعد العمولة:</p>
                                    <p class="font-weight-medium">عموله مبيعات <a href=""
                                            class="text-decoration-underline" target="_blank">#1</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- تبويب عمولات المبيعات -->
                <div class="tab-pane" id="commission" role="tabpanel">
                    <div class="card">
                        <div class="card-body">

                            <table class="table fs-5">
                                <thead>
                                    <tr>
                                        <th class="fs-5">المعرف</th>
                                        <th class="fs-5">موظف</th>
                                        <th class="fs-5">العملية</th>
                                        <th class="fs-5">مبلغ المبيعات</th>
                                        <th class="fs-5">كمية المبيعات</th>
                                        <th class="fs-5">عمولة</th>
                                        <th class="fs-5">ترتيب بواسطة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="fs-5">3010</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center me-2"
                                                    style="width: 35px; height: 35px;">
                                                    <span class="text-white fs-5">م</span>
                                                </div>
                                                <div>
                                                    <span class="fs-5">محمد الادريسي</span>
                                                    <small class="text-muted d-block fs-6">#5</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="fs-5">فاتورة مرتجعة</span>
                                                <small class="text-muted d-block fs-6">#00805</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fs-5">-216.00 ر.س</span>
                                        </td>
                                        <td>
                                            <span class="fs-5">-12 عناصر</span>
                                        </td>
                                        <td>
                                            <span class="fs-5">-6.48 ر.س</span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <div class="dropdown">
                                                    <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1 btn-sm"
                                                        type="button" id="dropdownMenuButton303" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false"></button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton303">
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('SalesPeriods.show', 1) }}">
                                                                <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a class="dropdown-item text-danger" href="#"
                                                                data-toggle="modal" data-target="#modal_DELETE">
                                                                <i class="fa fa-trash me-2"></i>حذف
                                                            </a>
                                                        </li>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            {{-- @else
                                    <div class="alert alert-danger text-xl-center" role="alert">
                                        <p class="mb-0">
                                            لا توجد مسميات وظيفية مضافة حتى الان !!
                                        </p>
                                    </div>
                                @endif --}}
                            {{-- {{ $shifts->links('pagination::bootstrap-5') }} --}}
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
