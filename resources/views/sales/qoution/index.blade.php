@extends('master')

@section('title')
    ادارة عروض السعر
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">ادارة عروض السعر </h2>
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

                    <a href="{{ route('questions.create') }}" class="btn btn-success btn-sm d-flex align-items-center ">
                        <i class="fa fa-plus me-2"></i> عرض سعر جديد
                    </a>

                    <!-- زر "المواعيد" -->
                    <a href="{{ route('appointments.index') }}"
                        class="btn btn-outline-primary btn-sm d-flex align-items-center">
                        <i class="fa fa-calendar-alt me-2"></i>المواعيد
                    </a>

                </div>
            </div>
        </div>



        <form action="{{ route('questions.index') }}" method="GET" class="form" >
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <h4 class="card-title">بحث</h4>
                    </div>

                    <div class="card-body">
                        <div class="form-body row">
                            <div class="form-group col-md-4">
                                <label for="feedback1" class="">العميل</label>
                                <select name="client_id" class="form-control select2" id="clientSelect">
                                    <option value="">اي العميل</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                                            {{ $client->trade_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="feedback2" class="">رقم عرض السعر</label>
                                <input type="text" id="feedback2" class="form-control"
                                    placeholder="رقم عرض السعر" name="id" value="{{ request('id') }}">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="feedback3" class="">الحالة</label>
                                <select name="status" class="form-control" id="statusSelect">
                                    <option value="">الحالة</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>موافق عليه</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>مرفوض</option>
                                </select>
                            </div>
                        </div>

                        <div class="collapse {{ request()->hasAny(['currency', 'total_from', 'total_to', 'date_type_1', 'date_type_2', 'item_search', 'created_by', 'sales_representative']) ? 'show' : '' }}" id="advancedSearchForm">
                            <div class="form-body row d-flex align-items-center g-0">
                                <div class="form-group col-md-4">
                                    <label for="" class="">العملة</label>
                                    <select name="currency" class="form-control" id="currencySelect">
                                        <option value="">العملة</option>
                                        <option value="SAR" {{ request('currency') == 'SAR' ? 'selected' : '' }}>ريال سعودي</option>
                                        <option value="USD" {{ request('currency') == 'USD' ? 'selected' : '' }}>دولار أمريكي</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="" class="">الاجمالي اكبر من</label>
                                    <input type="number" class="form-control" placeholder="الاجمالي اكبر من"
                                        name="total_from" step="0.01" value="{{ request('total_from') }}">
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="" class="">الاجمالي اصغر من</label>
                                    <input type="number" class="form-control" placeholder="الاجمالي اصغر من"
                                        name="total_to" step="0.01" value="{{ request('total_to') }}">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="" class="">الحالة</label>
                                    <select name="status" class="form-control" id="statusSelect">
                                        <option value="">الحالة</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>موافق عليه</option>
                                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>مرفوض</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-body row d-flex align-items-center g-2">
                                <div class="form-group col-md-2">
                                    <label for="feedback1" class="">التخصيص</label>
                                    <select name="date_type_1" class="form-control">
                                        <option value="">تخصيص</option>
                                        <option value="monthly" {{ request('date_type_1') == 'monthly' ? 'selected' : '' }}>شهرياً</option>
                                        <option value="weekly" {{ request('date_type_1') == 'weekly' ? 'selected' : '' }}>أسبوعياً</option>
                                        <option value="daily" {{ request('date_type_1') == 'daily' ? 'selected' : '' }}>يومياً</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="feedback3" class="">التاريخ من</label>
                                    <input type="date" class="form-control" placeholder="من"
                                        name="from_date_1" value="{{ request('from_date_1') }}">
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="feedback3" class="">التاريخ الى</label>
                                    <input type="date" class="form-control" placeholder="إلى"
                                        name="to_date_1" value="{{ request('to_date_1') }}">
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="feedback1" class="">التخصيص</label>
                                    <select name="date_type_2" class="form-control">
                                        <option value="">تخصيص</option>
                                        <option value="monthly" {{ request('date_type_2') == 'monthly' ? 'selected' : '' }}>شهرياً</option>
                                        <option value="weekly" {{ request('date_type_2') == 'weekly' ? 'selected' : '' }}>أسبوعياً</option>
                                        <option value="daily" {{ request('date_type_2') == 'daily' ? 'selected' : '' }}>يومياً</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="feedback3" class="">تاريخ الانشاء من</label>
                                    <input type="date" class="form-control" placeholder="من"
                                        name="from_date_2" value="{{ request('from_date_2') }}">
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="feedback4" class="">تاريخ الانشاء الى</label>
                                    <input type="date" class="form-control" placeholder="إلى"
                                        name="to_date_2" value="{{ request('to_date_2') }}">
                                </div>
                            </div>

                            <div class="form-body row d-flex align-items-center g-2">
                                <div class="form-group col-md-4">
                                    <label for="feedback1" class="">تحتوي على البند</label>
                                    <input type="text" class="form-control" placeholder="تحتوي على البند"
                                        name="item_search" value="{{ request('item_search') }}">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="feedback1" class="">اضيفت بواسطة</label>
                                    <select name="created_by" class="form-control select2">
                                        <option value="">اضيفت بواسطة</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}" {{ request('created_by') == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->first_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="feedback1" class="">مسؤل مبيعات</label>
                                    <select name="sales_representative" class="form-control select2">
                                        <option value="">مسؤل مبيعات</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" {{ request('sales_representative') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="" class="">الحالة</label>
                                    <select name="status_2" class="form-control" id="statusSelect2">
                                        <option value="">الحالة</option>
                                        <option value="pending" {{ request('status_2') == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                        <option value="approved" {{ request('status_2') == 'approved' ? 'selected' : '' }}>موافق عليه</option>
                                        <option value="rejected" {{ request('status_2') == 'rejected' ? 'selected' : '' }}>مرفوض</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary mr-1 waves-effect waves-light">بحث</button>

                            <a class="btn btn-outline-secondary ml-2 mr-2" data-toggle="collapse"
                                href="#advancedSearchForm" role="button">
                                <i class="bi bi-sliders"></i> بحث متقدم
                            </a>

                            <a href="{{ route('questions.index') }}" type="reset" class="btn btn-outline-warning waves-effect waves-light">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="card">


            <!-- قائمة الفواتير -->
            @foreach ($quotes as $quote)
                <div class="card-body">
                    <div class="row border-bottom py-2 align-items-center">
                        <!-- معلومات الفاتورة -->
                        <div class="col-md-4">
                            <p class="mb-0">
                                <strong>#{{ $quote->id }}</strong>
                            </p>
                            <small class="text-muted">
                                <i class="fas fa-user me-1"></i>
                                {{ $quote->client ? ($quote->client->trade_name ?: $quote->client->first_name . ' ' . $quote->client->last_name) : 'عميل غير معروف' }}

                                الرقم الضريبي
                                @if ($quote->client && $quote->client->tax_number)
                                    <i class="fas fa- me-1"></i>{{ $quote->client->tax_number }}
                                @endif
                            </small>
                            <small class="d-block">
                                @if ($quote->client && $quote->client->full_address)
                                    <i class="fas fa-map-marker-alt me-1"></i>{{ $quote->client->full_address }}
                                @endif
                            </small>
                            <small class="text-muted">
                                <i class="fas fa-user-tie me-1"></i> بواسطة:
                                {{ $quote->creator->name ?? 'غير محدد' }}
                            </small>
                            <p class="mb-0 text-muted">
                                <i class="fas fa-mobile-alt me-1"></i> المصدر: تطبيق الهاتف المحمول
                            </p>
                        </div>

                        <!-- تاريخ الفاتورة -->
                        <div class="col-md-3">
                            <p class="mb-0">
                                <i class="fas fa-calendar-alt me-1"></i>
                                {{ $quote->created_at ? $quote->created_at->format('H:i:s d/m/Y') : '' }}
                            </p>
                            <small class="text-muted">
                                <i class="fas fa-user me-1"></i> بواسطة:
                                {{ $quote->creator->name ?? 'غير محدد' }}
                            </small>
                        </div>

                        <!-- المبلغ وحالة الدفع -->
                        <div class="col-md-3 text-center">
                            <!-- عرض المبلغ الإجمالي -->
                            <div class="mb-2">
                                <strong class="text-danger fs-2 d-block">
                                    {{ number_format($quote->grand_total ?? $quote->total, 2) }}
                                    {{ $quote->currency ?? 'SAR' }}
                                </strong>

                                <!-- عرض حالة الدفع مع تغيير اللون بناءً على الحالة -->
                                @php
                                    $statusClass = '';
                                    $statusText = '';

                                    if ($quote->status == 1) {
                                        $statusClass = 'bg-success';
                                        $statusText = 'مفتوح';
                                    } else {
                                        $statusClass = 'bg-info';
                                        $statusText = 'مغلق ';
                                    }
                                @endphp

                                <!-- عرض حالة الدفع -->
                                <span class="badge {{ $statusClass }} d-inline-block mt-2 p-1 rounded small"
                                    style="font-size: 0.8rem;">
                                    <i class="fas fa-circle me-1"></i> {{ $statusText }}
                                </span>
                            </div>
                        </div>

                        <!-- الأزرار -->
                        <div class="col-md-2 text-end">
                            <div class="btn-group">
                                <div class="dropdown">
                                    <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1" type="button"
                                        id="dropdownMenuButton{{ $quote->id }}" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $quote->id }}">
                                        <a class="dropdown-item" href="{{ route('questions.edit', $quote->id) }}">
                                            <i class="fa fa-edit me-2 text-success"></i>تعديل
                                        </a>
                                        <a class="dropdown-item" href="{{ route('questions.show', $quote->id) }}">
                                            <i class="fa fa-eye me-2 text-primary"></i>عرض
                                        </a>
                                        <a class="dropdown-item"
                                            href="{{ route('questions.create', ['id' => $quote->id]) }}">
                                            <i class="fa fa-money-bill me-2 text-success"></i>إضافة دفعة
                                        </a>
                                        <a class="dropdown-item" href="">
                                            <i class="fa fa-file-pdf me-2 text-danger"></i>PDF
                                        </a>
                                        <a class="dropdown-item" href="">
                                            <i class="fa fa-print me-2 text-dark"></i>طباعة
                                        </a>
                                        <a class="dropdown-item" href="">
                                            <i class="fa fa-envelope me-2 text-warning"></i>إرسال إلى العميل
                                        </a>

                                        <a class="dropdown-item" href="">
                                            <i class="fa fa-copy me-2 text-secondary"></i>نسخ
                                        </a>
                                        <form action="{{ route('questions.destroy', $quote->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fa fa-trash me-2"></i>حذف
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <!-- إذا لم تكن هناك فواتير -->
            @if ($quotes->isEmpty())
                <div class="alert alert-warning" role="alert">
                    <p class="mb-0"><i class="fas fa-exclamation-circle me-2"></i>لا توجد عروض اسعار </p>
                </div>
            @endif
        </div>





    </div>




@endsection
