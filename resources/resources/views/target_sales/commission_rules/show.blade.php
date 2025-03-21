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
                                <h5 class="mb-0 fw-bolder">مباني  </h5>
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
            <a href="{{ route('commission.edit', $commission->id) }}"
                class="btn btn-outline-primary btn-sm d-inline-flex align-items-center justify-content-center px-3"
                style="min-width: 90px;">
                تعديل <i class="fa fa-edit ms-1"></i>
            </a>
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
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="details" role="tabpanel"
                                            style="font-size: 1.1rem;">
                                            <!-- معلومات قواعد العمولة -->
                                            <div style="background-color: #f8f9fa;"
                                                class="d-flex justify-content-between align-items-center p-2 rounded mb-3">
                                                <h5 class="mb-0">معلومات قواعد العمولة</h5>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tbody class="text-end">
                                                        <tr>
                                                            <td class="text-muted" style="width: 50%;">الاسم:</td>
                                                            <td>{{$commission->name ?? "" }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-muted">الفترة:</td>
                                                            <td> @if($commission->commission_calculation == "monthly")
                                                                {{$commission->name ?? ""}}
                                                                <strong>شهري</strong>
                                                                @elseif($commission->commission_calculation == "yearly")
                                                                <strong>سنوي</strong>
                                                                @else
                                                                <strong>ربع سنوي </strong>
                                                                @endif</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-muted">نوع الهدف:</td>
                                                            <td><span class="text-muted">{{$commission->value}}</span> <span
                                                                    class="text-muted">
                                                                    @if($commission->target_type == "amount")
                                                                    <span>(مبلغ)</span>
                                                                    @else
                                                                    <span>(كمية)</span>
                                                                    @endif
                                                                
                                                                </span></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-muted">حساب العمولة:</td>
                                                            <td>
                                                                @if($commission->commission_calculation == "fully_paid")
                                                                <span> فواتير مدفوعة بالكامل </span>
                                                                @else
                                                                <span>  فواتير مدفوعة جزئيا </span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-muted">العملة:</td>
                                                            <td>{{$commission->currency ?? "" }}</td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="mt-4">
                                                <h6 class="text-muted mb-3">قائمة الموظفين</h6>
                                                <div class="table-responsive">
                                                    <table class="table table-borderless">
                                                        <tbody>
                                                            @foreach ($commissionUsers as $index => $user)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td> <!-- رقم التسلسل -->
                                                                <td>
                                                                    <div class="w-100 text-end">
                                                                        <span>{{ $user->employee->name }}</span>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        
                                                        
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <!-- تطبق على البنود التالية -->
                                            <div class="mt-4">
                                                <h6 class="mb-3">تطبق على البنود التالية</h6>
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr class="text-end">
                                                                <th>البند</th>
                                                                <th>نوع الوحدة</th>
                                                                <th>نسبة العمولة</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($CommissionProducts as $Commission)
                                                            <tr class="text-end">
                                                                <td>-</td>
                                                                <td>
                                                                    {{$Commission->products->name}}
                                                                </td>
                                                                <td><span class="text-muted">{{$Commission->commission_percentage}} %</span></td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <!-- الملاحظات -->
                                            <div class="mt-4">
                                                <h6 class="mb-3">الملاحظات:</h6>
                                                <div class="p-3  rounded">
                                                    <p class="text-muted mb-0">{{$commission->notes ?? "لا توجد ملاحظات"}}</p>
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
