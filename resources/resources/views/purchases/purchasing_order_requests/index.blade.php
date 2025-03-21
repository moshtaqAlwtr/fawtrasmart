@extends('master')

@section('title')
    ادارة اوامر الشراء
@stop

@section('content')

    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">ادارة اوامر الشراء</h2>
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

        @include('layouts.alerts.error')
        @include('layouts.alerts.success')
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">

                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item">
                                    <button class="btn btn-sm btn-outline-secondary px-2" aria-label="Previous">
                                        <i class="fa fa-angle-right"></i>
                                    </button>
                                </li>
                                <li class="page-item mx-2">
                                    <span class="text-muted">صفحة 1 من 1</span>
                                </li>
                                <li class="page-item">
                                    <button class="btn btn-sm btn-outline-secondary px-2" aria-label="Next">
                                        <i class="fa fa-angle-left"></i>
                                    </button>
                                </li>
                            </ul>
                        </nav>

                        <span class="text-muted mx-2">1-1 من 1</span>

                        <a href="{{ route('OrdersRequests.create') }}" class="btn btn-success">
                            <i class="fa fa-plus me-1"></i>
                            اضف امر شراء
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center p-2">
                <div class="d-flex gap-2">
                    <span class="hide-button-text">
                        بحث وتصفية
                    </span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-outline-secondary btn-sm" onclick="toggleSearchFields(this)">
                        <i class="fa fa-times"></i>
                        <span class="hide-button-text">اخفاء</span>
                    </button>
                    <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="collapse"
                        data-bs-target="#advancedSearchForm" onclick="toggleSearchText(this)">
                        <i class="fa fa-filter"></i>
                        <span class="button-text">متقدم</span>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form class="form" id="searchForm" method="GET" action="{{ route('OrdersRequests.index') }}">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <input type="text" name="code" class="form-control" placeholder="الكود"
                                value="{{ request('code') }}">
                        </div>
                        <div class="col-md-3">
                            <input type="date" name="start_date_from" class="form-control" placeholder="التاريخ من"
                                value="{{ request('start_date_from') }}">
                        </div>
                        <div class="col-md-3">
                            <input type="date" name="start_date_to" class="form-control" placeholder="التاريخ إلى"
                                value="{{ request('start_date_to') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="currency" class="form-control">
                                <option value="">اختر العملة</option>
                                <option value="SAR" {{ request('currency') == 'SAR' ? 'selected' : '' }}>ريال سعودي
                                </option>
                                <option value="USD" {{ request('currency') == 'USD' ? 'selected' : '' }}>دولار أمريكي
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-3">
                            <select name="status" class="form-control">
                                <option value="">الحالة</option>
                                <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>تحت
                                    المراجعة</option>
                                <option value="canceled" {{ request('status') == 'canceled' ? 'selected' : '' }}>تم الإلغاء
                                </option>
                                <option value="converted" {{ request('status') == 'converted' ? 'selected' : '' }}>حوّلت
                                    إلى فاتورة</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="tag" class="form-control" placeholder="الوسم"
                                value="{{ request('tag') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="supplier_id" class="form-control">
                                <option value="">البحث بواسطة اسم المورد أو الرقم التعريفي</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}"
                                        {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->trade_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 advanced-field" style="display: none;">
                            <select name="type" class="form-control">
                                <option value="">النوع</option>
                                <option value="1" {{ request('type') == '1' ? 'selected' : '' }}>نوع 1</option>
                                <option value="2" {{ request('type') == '2' ? 'selected' : '' }}>نوع 2</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-3 advanced-field" style="display: none;">
                            <select name="follow_status" class="form-control">
                                <option value="">حالة المتابعة</option>
                                <option value="1" {{ request('follow_status') == '1' ? 'selected' : '' }}>قيد
                                    المتابعة</option>
                                <option value="2" {{ request('follow_status') == '2' ? 'selected' : '' }}>تمت
                                    المتابعة</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <div class="form-actions mt-2">
                            <button type="submit" class="btn btn-primary">بحث</button>
                            <a href="{{ route('OrdersRequests.index') }}" class="btn btn-outline-warning">إلغاء</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                @if ($purchaseOrdersRequests->count() > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>رقم الأمر</th>
                                <th>المورد</th>
                                <th>التاريخ</th>

                                <th>صافي الدخل </th>
                                <th>الحالة</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchaseOrdersRequests as $key => $order)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $order->code }}</td>
                                    <td>{{ $order->supplier->trade_name ?? 'غير محدد' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($order->date)->format('d/m/Y') }}</td>

                                    <td>{{ number_format($order->grand_total, 2) }}</td>
                                    <td>
                                        @if ($order->status == 1)
                                            <span class="badge bg-primary">تحت المراجعة </span>
                                        @elseif($order->status == 2)
                                            <span class="badge bg-success">محولة الى فاتورة </span>
                                        @else
                                            <span class="badge bg-danger">ملغي</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <div class="dropdown">
                                                <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1 btn-sm"
                                                    type="button" id="dropdownMenuButton{{ $order->id }}"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                </button>
                                                <div class="dropdown-menu"
                                                    aria-labelledby="dropdownMenuButton{{ $order->id }}">
                                                    <a class="dropdown-item"
                                                        href="{{ route('OrdersRequests.show', $order->id) }}">
                                                        <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                    </a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('OrdersRequests.edit', $order->id) }}">
                                                        <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                    </a>
                                                    <a class="dropdown-item text-danger" href="#"
                                                        data-toggle="modal"
                                                        data-target="#modal_DELETE{{ $order->id }}">
                                                        <i class="fa fa-trash me-2"></i>حذف
                                                    </a>
                                                    <a class="dropdown-item text-primary" href="#"
                                                        data-toggle="modal"
                                                        data-target="#modal_PRINT{{ $order->id }}">
                                                        <i class="fa fa-print me-2"></i>طباعة
                                                    </a>
                                                    <a class="dropdown-item text-warning" href="#"
                                                        data-toggle="modal" data-target="#modal_PDF{{ $order->id }}">
                                                        <i class="fa fa-file-pdf me-2"></i>PDF
                                                    </a>
                                                    <a class="dropdown-item text-success" href="#"
                                                        data-toggle="modal" data-target="#modal_SEND{{ $order->id }}">
                                                        <i class="fa fa-paper-plane me-2"></i>ارسال الى المورد
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal delete -->
                                        <div class="modal fade text-left" id="modal_DELETE{{ $order->id }}"
                                            tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger">
                                                        <h4 class="modal-title text-white" id="myModalLabel1">
                                                            حذف أمر الشراء
                                                        </h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h5>هل أنت متأكد من حذف أمر الشراء رقم {{ $order->code }}؟</h5>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light waves-effect"
                                                            data-dismiss="modal">إلغاء</button>
                                                        <form action="{{ route('OrdersRequests.destroy', $order->id) }}"
                                                            method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-danger waves-effect waves-light">حذف</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-info text-center">
                        لا توجد أوامر شراء حتى الآن
                    </div>
                @endif
            </div>
        </div>








    @endsection

    @section('css')
        <style>
            .col-md-1-5 {
                flex: 0 0 12.5%;
                max-width: 12.5%;
                padding-right: 15px;
                padding-left: 15px;
            }

            .form-control {
                margin-bottom: 10px;
            }
        </style>
    @endsection
    @section('scripts')
        <script>
            function toggleSearchText(button) {
                const buttonText = button.querySelector('.button-text');
                const advancedFields = document.querySelectorAll('.advanced-field');

                if (buttonText.textContent.trim() === 'متقدم') {
                    buttonText.textContent = 'بحث بسيط';
                    advancedFields.forEach(field => field.style.display = 'block');
                } else {
                    buttonText.textContent = 'متقدم';
                    advancedFields.forEach(field => field.style.display = 'none');
                }
            }

            function toggleSearchFields(button) {
                const searchForm = document.getElementById('searchForm');
                const buttonText = button.querySelector('.hide-button-text');
                const icon = button.querySelector('i');

                if (buttonText.textContent === 'اخفاء') {
                    searchForm.style.display = 'none';
                    buttonText.textContent = 'اظهار';
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-eye');
                } else {
                    searchForm.style.display = 'block';
                    buttonText.textContent = 'اخفاء';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-times');
                }
            }
        </script>
    @endsection
