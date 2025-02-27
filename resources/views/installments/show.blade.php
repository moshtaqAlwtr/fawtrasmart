@extends('master')

@section('title')
    عرض تفاصيل القسط
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">عرض تفاصيل القسط</h2>
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
                        <span class="avatar-content fs-4">ق</span>
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center gap-2">
                                <h5 class="mb-0 fw-bolder">{{ $installment->invoice->client->trade_name }}</h5>
                                <small class="text-muted"># {{ $installment->id }}</small>
                            </div>
                            <div class="vr mx-2"></div>
                            <div class="d-flex align-items-center">
                                <small class="text-success">
                                    @if ($installment->status == 1)
                                        <span class="badge badge-success">مكتمل</span>
                                    @elseif ($installment->status == 2)
                                        <span class="badge badge-danger">غير مكتمل</span>
                                    @elseif ($installment->status == 3)
                                        <span class="badge badge-warning">متأخر</span>
                                    @endif
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
                <div class="mt-3">
                    <a href="{{ route('invoices.show', $installment->invoice_id) }}" class="btn btn-outline-primary">
                        عرض الفاتورة <i class="fa fa-eye ms-1"></i>
                    </a>
                </div>
            </div>

            <!-- زر عرض الفاتورة -->

        </div>
    </div>
    <div class="card">
        <div class="card-title p-2 d-flex align-items-center gap-2">
            <div class="vr"></div>

            <a href="{{ route('installments.edit', $installment->id) }}"
                class="btn btn-outline-warning btn-sm d-inline-flex align-items-center justify-content-center px-3"
                style="min-width: 90px;">
                تعديل <i class="fa fa-edit ms-1"></i>
            </a>

            @if ($installment)
                <a href="{{ route('invoices.show', $installment->invoice_id) }}"
                    class="btn btn-outline-warning btn-sm d-inline-flex align-items-center justify-content-center px-3"
                    style="min-width: 90px;">
                    عرض الفاتورة <i class="fa fa-edit ms-1"></i>
                </a>
            @else
                <span class="text-muted">لا توجد فاتورة مرتبطة بهذا القسط.</span>
            @endif
            <a href="#"
                class="btn btn-outline-danger btn-sm d-inline-flex align-items-center justify-content-center px-3"
                style="min-width: 90px;" data-toggle="modal" data-target="#modal_DELETE{{ $installment->id }}">
                حذف <i class="fa fa-trash ms-1"></i>
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
                    <div class="row g-0">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-4 d-flex align-items-center">
                                    @if ($installment->invoice && $installment->invoice->client)
                                        @php
                                            $tradeName = $installment->invoice->client->trade_name;
                                            $firstLetter = !empty($tradeName) ? strtoupper(substr($tradeName, 0, 1)) : '?';
                                        @endphp

                                        <span class="badge bg-purple" style="font-size: 1.5em;">
                                            {{ $firstLetter }}
                                        </span>
                                        <a href="#">{{ $tradeName }}</a>
                                        <a href="#">{{ $installment->invoice->client->id }}</a>
                                    @else
                                        <span class="text-muted">لا يوجد عميل مرتبط بهذا القسط.</span>
                                    @endif
                                </div>

                                <div class="col-4 text-center">
                                    <h6>ر.س {{ $installment->invoice->grand_total }}</h6>
                                    <small>مبلغ اتفاقية التقسيط</small>
                                </div>
                                <div class="col-4 text-start">
                                    <h6><a href="{{ route('invoices.show', $installment->invoice->id) }}">#{{ $installment->invoice->code }}</a></h6>
                                    <small>رقم الفاتورة</small>
                                </div>
                            </div>

                            <div class="row mt-3">

                                <div class="col-3 text-end">
                                    @if ($installment->invoice && $installment->invoice->client)
                                        <a href="{{ route('clients.show', $installment->invoice->client->id) }}" class="btn btn-light">
                                            <i class="fa fa-user"></i> عرض الصفحة الشخصية
                                        </a>
                                    @else
                                        <span class="text-muted">لا يوجد عميل مرتبط بهذا القسط.</span>
                                    @endif
                                </div>

                                <div class="col-3 text-center">
                                    <h6>ر.س {{ $installment->amount }} /
                                        @if ($installment->payment_rate == 1)
                                            شهري
                                        @elseif ($installment->payment_rate == 2)
                                            يومي
                                        @elseif ($installment->payment_rate == 3)
                                            اسبوعي
                                        @endif
                                    </h6>
                                    <small>مبلغ القسط</small>
                                </div>

                                <div class="col-3 text-end">
                                    <h6><strong>ر.س {{ $installment->invoice->due_value }}</strong></h6>
                                    <small>إجمالي المبلغ</small>
                                </div>
                                <div class="col-3 text-end">
                                    <p><strong>ر.س {{ $installment->invoice->due_value }}</strong> إجمالي المبلغ
                                    </p>
                                    <p><strong>ر.س {{ $installment->payment ? $installment->payment->amount : 0 }}</strong> المبلغ المدفوع</p>
                                </div>



                            </div>

                            <hr>

                        </div>
                    </div>
                    <div class="row g-0">
                        <div class="col-12">
                            <div style="background-color: #f8f9fa;" class="p-2 rounded mb-2">
                                <h6 class="mb-0">معلومات القسط</h6>
                            </div>
                            @if (isset($installments) && !empty($installments) && count($installments) > 0)
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>المعرف</th>
                                                    <th>بيانات العميل</th>
                                                    <th>بيانات الدفع</th>

                                                    <th>تاريخ الاستحقاق </th>
                                                    <th style="width: 10%">الإجراءات</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($installments as $installment)
                                                    @php
                                                        $installmentCount = $installment->installment_number; // عدد الأقساط
                                                        $installmentAmount = $installment->amount; // مبلغ كل قسط
                                                    @endphp
                                                    @for ($i = 1; $i <= $installmentCount; $i++)
                                                        <tr>
                                                            <td>{{ $installment->id }}</td>
                                                            <td>{{ $installment->invoice->client->trade_name }}</td>
                                                            <td>{{ number_format($installmentAmount, 2) }} ر.س</td>
                                                            <td>
                                                                {{ $installment->due_date }}
                                                                <br>
                                                                <span class="text-info">
                                                                    @if ($installment->status == 1)
                                                                        <span class="badge badge-success">غير مكتمل</span>
                                                                    @elseif($installment->status == 2)
                                                                        <span class="badge badge-warning">مكتمل</span>
                                                                    @endif
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <div class="btn-group">
                                                                    <div class="dropdown">
                                                                        <button
                                                                            class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1 btn-sm"
                                                                            type="button" id="dropdownMenuButton303"
                                                                            data-toggle="dropdown" aria-haspopup="true"
                                                                            aria-expanded="false"></button>
                                                                        <div class="dropdown-menu"
                                                                            aria-labelledby="dropdownMenuButton303">
                                                                            <li>
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('installments.show', $installment->id) }}">
                                                                                    <i
                                                                                        class="fa fa-eye me-2 text-primary"></i>عرض
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('installments.edit_amount', $installment->id) }}">
                                                                                    <i
                                                                                        class="fa fa-edit me-2 text-success"></i>تعديل
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('paymentsClient.create', ['id' => $installment->id, 'type' => 'installment']) }}">
                                                                                    <i
                                                                                        class="fa fa-edit me-2 text-success"></i>قم
                                                                                    بالدفع
                                                                                </a>
                                                                            </li>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endfor
                                                @endforeach
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-danger text-xl-center" role="alert">
                                    <p class="mb-0">لا توجد اقساط حتى الان !!</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- تبويب سجل النشاطات -->
                <div class="tab-pane" id="activity" role="tabpanel">
                    <div class="timeline p-4">
                        <p class="text-muted text-center">لا توجد نشاطات حتى الآن</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
