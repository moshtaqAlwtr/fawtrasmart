@extends('master')

@section('title')
    مدفوعات العملاء
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">ادارة مدفوعات العملاء</h2>
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
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="content-body">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <!-- زر "فاتورة جديدة" -->
                    <div class="form-group col-outdo">
                        <input class="form-check-input" type="checkbox" id="selectAll">
                    </div>
                    <div class="btn-group">
                        <div class="dropdown">
                            <button class="btn  dropdown-toggle mr-1 mb-1" type="button" id="dropdownMenuButton302"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton302">
                                <a class="dropdown-item" href="#">Option 1</a>
                                <a class="dropdown-item" href="#">Option 2</a>
                                <a class="dropdown-item" href="#">Option 3</a>
                            </div>
                        </div>
                    </div>
                    <div class="btn-group col-md-5">
                        <div class="dropdown">
                            <button class="btn bg-gradient-info dropdown-toggle mr-1 mb-1" type="button"
                                id="dropdownMenuButton303" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                الاجراءات
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton303">
                                <a class="dropdown-item" href="#">Option 1</a>
                                <a class="dropdown-item" href="#">Option 2</a>
                                <a class="dropdown-item" href="#">Option 3</a>
                            </div>
                        </div>
                    </div>
                    <!-- مربع اختيار -->

                    <!-- الجزء الخاص بالتصفح -->
                    <div class="d-flex align-items-center">
                        <!-- زر الصفحة السابقة -->
                        <button class="btn btn-outline-secondary btn-sm" aria-label="الصفحة السابقة">
                            <i class="fa fa-angle-right"></i>
                        </button>

                        <!-- أرقام الصفحات -->
                        <nav class="mx-2">
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item active"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">4</a></li>
                                <li class="page-item"><a class="page-link" href="#">5</a></li>
                            </ul>
                        </nav>

                        <!-- زر الصفحة التالية -->
                        <button class="btn btn-outline-secondary btn-sm" aria-label="الصفحة التالية">
                            <i class="fa fa-angle-left"></i>
                        </button>
                    </div>

                    <!-- قائمة الإجراءات -->


                    <!-- زر "المواعيد" -->


                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <h4 class="card-title">بحث</h4>
                </div>

                <div class="card-body">
                    <form class="form">
                        <div class="form-body row">
                            <div class="form-group col-md-4">
                                <label for="feedback2" class="sr-only">رقم الفاتورة</label>
                                <input type="text" id="feedback2" class="form-control" placeholder="رقم الفاتورة"
                                    name="from_date">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="feedback2" class="sr-only">رقم عملية الدفع</label>
                                <input type="text" id="feedback2" class="form-control" placeholder="رقم عملية الدفع"
                                    name="from_date">
                            </div>
                            <div class="form-group col-md-4">
                                <select name="" class="form-control" id="">
                                    <option value="">اي العميل</option>

                                </select>
                            </div>


                        </div>
                        <div class="collapse" id="advancedSearchForm">

                            <div class="form-body row d-flex align-items-center g-2">
                                <!-- حالة الدفع -->
                                <div class="form-group col-md-4">
                                    <select name="" class="form-control" id="">
                                        <option value="">حالة الدفع</option>
                                        <option value="1">مدفوعة</option>
                                        <option value="0">غير مدفوعة</option>
                                    </select>
                                </div>

                                <!-- تخصيص -->
                                <div class="form-group col-md-1.5">
                                    <select name="" class="form-control" id="">
                                        <option value="">تخصيص</option>
                                        <option value="1">شهريًا</option>
                                        <option value="0">أسبوعيًا</option>
                                        <option value="2">يوميًا</option>
                                    </select>
                                </div>

                                <!-- من (التاريخ) -->
                                <div class="form-group col-md-1.5">
                                    <input type="date" id="feedback1" class="form-control" placeholder="من"
                                        name="from_date">
                                </div>

                                <!-- إلى (التاريخ) -->
                                <div class="form-group col-md-1.5" style="margin-right: 10px">
                                    <input type="date" id="feedback2" class="form-control" placeholder="إلى"
                                        name="to_date">
                                </div>

                                <!-- تخصيص آخر -->
                                <div class="form-group col-md-4">
                                    <input type="text" id="feedback2" class="form-control"
                                        placeholder="رقم التعريفي " name="from_date">
                                </div>

                            </div>

                            <div class="form-body row d-flex align-items-center g-2">
                                <!-- حالة الدفع -->
                                <div class="form-group col-md-4">
                                    <input type="text" id="feedback1" class="form-control"
                                        placeholder="رقم معرف التحويل" name="from_date">
                                </div>
                                <div class="form-body row">
                                    <div class="form-group col-md-6">
                                        <label for="" class="sr-only">Status</label>

                                        <input type="text" id="feedback1" class="form-control"
                                            placeholder="الاجمالي اكبر من " name="name">

                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="" class="sr-only">Status</label>

                                        <input type="text" id="feedback1" class="form-control"
                                            placeholder="الاجمالي اصغر من " name="name">

                                    </div>
                                </div>
                                <!-- تخصيص -->
                                <div class="form-group col-4">
                                    <input type="text" id="feedback1" class="form-control" placeholder="حقل مخصص"
                                        name="from_date">
                                </div>

                                <!-- إلى (التاريخ) -->


                                <!-- تخصيص آخر -->
                            </div>


                            <div class="form-body row d-flex align-items-center g-2">
                                <!-- حالة الدفع -->

                                <div class="form-group col-md-1.5">
                                    <select name="" class="form-control" id="">
                                        <option value="">تخصيص</option>
                                        <option value="1">شهريًا</option>
                                        <option value="0">أسبوعيًا</option>
                                        <option value="2">يوميًا</option>
                                    </select>
                                </div>

                                <!-- من (التاريخ) -->
                                <div class="form-group col-md-1.5">
                                    <input type="date" id="feedback1" class="form-control" placeholder="من"
                                        name="from_date">
                                </div>

                                <!-- إلى (التاريخ) -->
                                <div class="form-group col-md-1.5" style="margin-right: 20px">
                                    <input type="date" id="feedback2" class="form-control" placeholder="إلى"
                                        name="to_date">
                                </div>

                                <div class="form-group col-md-4">
                                    <input type="text" id="feedback1" class="form-control" placeholder="post shift"
                                        name="from_date">
                                </div>

                                <div class="form-group col-md-4">
                                    <select name="" class="form-control" id="">
                                        <option value="">منشى الفاتورة </option>
                                        <option value="1">الكل </option>
                                        <option value="0"></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-body row d-flex align-items-center g-2">
                                <!-- حالة الدفع -->

                                <div class="form-group col-md-4">
                                    <select name="" class="form-control" id="">
                                        <option value="">تم التحصيل بواسطة </option>
                                        <option value="1">الكل </option>
                                        <option value="0"></option>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary mr-1 waves-effect waves-light">بحث</button>

                            <a class="btn btn-outline-secondary ml-2 mr-2" data-toggle="collapse"
                                data-target="#advancedSearchForm">
                                <i class="bi bi-sliders"></i> بحث متقدم
                            </a>
                            <button type="reset"
                                class="btn btn-outline-warning waves-effect waves-light">Cancel</button>
                        </div>
                    </form>

                </div>

            </div>

        </div>


        <div class="card">
            <!-- الترويسة -->
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex gap-2 flex-wrap">
                    <button class="btn btn-sm btn-outline-primary">الكل</button>
                    <button class="btn btn-sm btn-outline-success">متأخر</button>
                    <button class="btn btn-sm btn-outline-danger">مستحقة الدفع</button>
                    <button class="btn btn-sm btn-outline-danger">غير مدفوع</button>
                    <button class="btn btn-sm btn-outline-secondary">مسودة</button>
                    <button class="btn btn-sm btn-outline-success">مدفوع بزيادة</button>
                </div>
            </div>

            <!-- بداية الصف -->
            <div class="card-body">
                @foreach ($payments->where('type', 'client payments') as $payment)
                    <div class="row border-bottom py-2 align-items-center">
                        <div class="col-md-4">
                            <p class="mb-"><strong>#{{ $payment->id }}</strong> </p>
                            <small class="text-muted">#{{ $payment->invoice->invoice_number ?? '' }} ملاحظات:
                                {{ $payment->notes }}</small>
                        </div>
                        <div class="col-md-3">
                            <p class="mb-0"><small>{{ $payment->payment_date }}</small></p>
                            <small class="text-muted">بواسطة: {{ $payment->employee->full_name ?? '' }}</small>
                        </div>
                        <div class="col-md-3 text-center">
                            <h5 class="mb-1 font-weight-bold">
                                {{ number_format($payment->amount, 2) }} ر.س
                            </h5>

                            @php
                                $statusClass = '';
                                $statusText = '';
                                $statusIcon = '';

                                if ($payment->payment_status == 2) {
                                    $statusClass = 'badge-warning';
                                    $statusText = 'غير مكتمل';
                                    $statusIcon = 'fa-clock';
                                } elseif ($payment->payment_status == 1) {
                                    $statusClass = 'badge-success';
                                    $statusText = 'مكتمل';
                                    $statusIcon = 'fa-check-circle';
                                } elseif ($payment->payment_status == 4) {
                                    $statusClass = 'badge-info';
                                    $statusText = 'تحت المراجعة';
                                    $statusIcon = 'fa-sync';
                                } elseif ($payment->payment_status == 5) {
                                    $statusClass = 'badge-danger';
                                    $statusText = 'فاشلة';
                                    $statusIcon = 'fa-times-circle';
                                } elseif ($payment->payment_status == 3) {
                                    $statusClass = 'badge-secondary';
                                    $statusText = 'مسودة';
                                    $statusIcon = 'fa-file-alt';
                                } else {
                                    $statusClass = 'badge-light';
                                    $statusText = 'غير معروف';
                                    $statusIcon = 'fa-question-circle';
                                }
                            @endphp

                            <span class="badge {{ $statusClass }}">
                                <i class="fas {{ $statusIcon }} me-1"></i>
                                {{ $statusText }}
                            </span>
                        </div>
                        <div class="col-md-2 text-end">
                            <div class="btn-group">
                                <div class="dropdown">
                                    <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1" type="button"
                                        id="dropdownMenuButton303" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton303">
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('paymentsClient.show', $payment->id) }}">
                                                <i class="fa fa-eye me-2 text-primary"></i>عرض
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('paymentsClient.edit', $payment->id) }}">
                                                <i class="fa fa-edit me-2 text-success"></i>تعديل
                                            </a>
                                        </li>
                                        <form action="{{ route('paymentsClient.destroy', $payment->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="dropdown-item"
                                                style="border: none; background: none;">
                                                <i class="fa fa-trash me-2 text-danger"></i> حذف
                                            </button>
                                        </form>
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="fa fa-envelope me-2 text-warning"></i>ايصال مدفوعات
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="fa fa-envelope me-2 text-warning"></i>ايصال مدفوعات حراري
                                            </a>
                                        </li>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>










    </div>




@endsection
