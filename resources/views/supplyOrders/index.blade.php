@extends('master')

@section('title')
    ادراة اوامر التوريد
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">ادراة اوامر التوريد</h2>
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




    <div class="content-body">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <!-- مربع اختيار الكل -->


                        <!-- المجموعة الأفقية: Combobox و Dropdown -->
                        <div class="d-flex align-items-center">



                        </div>

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

                        <!-- الأزرار الإضافية -->
                        <a href="{{ route('SupplyOrders.create') }}"
                            class="btn btn-success btn-sm d-flex align-items-center">
                            <i class="fa fa-plus me-2"></i>اضافة امر توريد
                        </a>


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
                                    <label for="feedback2" class="sr-only"> رقم</label>
                                    <input type="email" id="feedback2" class="form-control" placeholder=" رقم  "
                                        name="email">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="feedback2" class="sr-only"> رقم</label>
                                    <input type="email" id="feedback2" class="form-control" placeholder=" مسمى  "
                                        name="email">
                                </div>


                                <div class="form-group col-md-4">
                                    <select id="feedback2" class="form-control">
                                        <option value="">العميل </option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->trade_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-body row">


                                <div class="form-group col-md-4">
                                    <select id="feedback2" class="form-control">
                                        <option value="">اختر الموضف </option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->full_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="collapse" id="advancedSearchForm">
                                <div class="form-body row d-flex align-items-center g-0">

                                    <div class="form-group col-md-4">
                                        <select name="currency" class="form-control" id="currencySelect">
                                            <option value="">تعين الى </option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}">{{ $employee->full_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <select name="status" class="form-control" id="statusSelect">
                                            <option value="">الحالة</option>
                                            <option value="pending">قيد الانتظار</option>
                                            <option value="approved">موافق عليه</option>
                                            <option value="rejected">مرفوض</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-1">
                                        <select name="date_type_1" class="form-control" id="">
                                            <option value="">تاريخ البدء</option>
                                            <option value="monthly">شهريًا</option>
                                            <option value="weekly">أسبوعيًا</option>
                                            <option value="daily">يوميًا</option>
                                        </select>
                                    </div>

                                    <!-- من (التاريخ) -->
                                    <div class="form-group col-md-1.5">
                                        <input type="date" id="feedback3" class="form-control" placeholder="من"
                                            name="from_date_1">
                                    </div>

                                    <!-- إلى (التاريخ) -->
                                    <div class="form-group col-md-1.5" style="margin-right: 20px">
                                        <input type="date" id="feedback4" class="form-control" placeholder="إلى"
                                            name="to_date_1">
                                    </div>

                                </div>
                                <div class="form-body row d-flex align-items-center g-2">
                                    <!-- حالة الدفع -->


                                    <!-- تخصيص آخر -->
                                    <div class="form-group col-md-2" style="margin-right: 20px">
                                        <select name="date_type_2" class="form-control" id="">
                                            <option value="">تاريخ الاستلام </option>
                                            <option value="monthly">شهريًا</option>
                                            <option value="weekly">أسبوعيًا</option>
                                            <option value="daily">يوميًا</option>
                                        </select>
                                    </div>

                                    <!-- من (التاريخ) -->
                                    <div class="form-group col-md-2">
                                        <input type="date" id="feedback3" class="form-control" placeholder="من"
                                            name="from_date_2">
                                    </div>

                                    <!-- إلى (التاريخ) -->
                                    <div class="form-group col-md-2" style="margin-right: 20px">
                                        <label for="feedback4" class="sr-only"></label>
                                        <input type="date" id="feedback4" class="form-control" placeholder="إلى"
                                            name="to_date_2">
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
                        <button class="btn btn-sm btn-outline-success">
                            <i class="fas fa-chart-line me-1"></i> النتائج
                        </button>

                        <button class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-list me-1"></i> الكل
                        </button>

                        <button class="btn btn-sm btn-outline-success">
                            <i class="fas fa-unlock me-1"></i> مفتوح
                        </button>

                        <button class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-lock me-1"></i> مغلق
                        </button>

                    </div>
                </div>


                        <div class="card-body">
                            <div class="row border-bottom py-2 align-items-center">
                                <div class="col-md-4">
                                    <p class="mb-0">
                                        <strong>#2226</strong>
                                    </p>
                                    <small class="text-muted">

                                    </small>
                                </div>
                                <div class="col-md-3">
                                    <p class="mb-0">وكمةة</p>
                                    <small class="text-muted">
                                        بواسطة:
                                    </small>
                                </div>
                                <div class="col-md-3 text-center">
                                    <strong class="text-danger">نىمننم</strong>
                                    <span class="badge  d-block mt-1">

                                    </span>
                                </div>
                                <div class="col-md-2 text-end">
                                    <div class="btn-group">
                                        <div class="dropdown">
                                            <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="" >
                                                    <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                </a>
                                                <a class="dropdown-item" href="{{route('SupplyOrders.show', 1)}}">
                                                    <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                </a>


                                                <a class="dropdown-item" href="">
                                                    <i class="fa fa-copy me-2 text-secondary"></i>نسخ
                                                </a>
{{--
                                                <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" class="d-inline" >
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="fa fa-trash me-2"></i>حذف
                                                    </button>
                                                </form> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
{{--

                @if($invoices->isEmpty())
                    <div class="alert alert-warning" role="alert">
                        <p class="mb-0">لا توجد فواتير</p>
                    </div>
                @endif --}}
            </div>



        </div>
    </div>
    </div>
@endsection
