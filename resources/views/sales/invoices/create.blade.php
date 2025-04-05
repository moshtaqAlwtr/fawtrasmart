@extends('master')

@section('title')
    انشاء فاتورة مبيعات
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <style>
        @media (max-width: 767.98px) {
            #items-table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }

            #items-table thead,
            #items-table tbody,
            #items-table tfoot,
            #items-table tr,
            #items-table td,
            #items-table th {
                display: block;
            }

            #items-table tr {
                display: flex;
                flex-direction: column;
                margin-bottom: 1rem;
                border: 1px solid #ddd;
                padding: 10px;
            }

            #items-table td,
            #items-table th {
                border: none;
                padding: 0.5rem;
            }

            #items-table td {
                text-align: right;
            }

            #items-table td::before {
                content: attr(data-label);
                float: left;
                font-weight: bold;
            }

            #items-table .item-row {
                display: flex;
                flex-direction: column;
            }

            #items-table .item-row td {
                width: 100%;
            }

            #items-table .item-row td input,
            #items-table .item-row td select {
                width: 100%;
            }

            #items-table tfoot tr {
                display: flex;
                flex-direction: column;
            }

            #items-table tfoot td {
                text-align: right;
            }

            @media (max-width: 767.98px) {
                /* أنماط الجدول للهواتف المحمولة */
            }

            .required-error {
                border-color: #ff3e1d !important;
                background-color: #fff4f2 !important;
                animation: shake 0.5s;
            }

            @keyframes shake {

                0%,
                100% {
                    transform: translateX(0);
                }

                20%,
                60% {
                    transform: translateX(-5px);
                }

                40%,
                80% {
                    transform: translateX(5px);
                }
            }
        }
    </style>
@endsection
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0"> انشاء فاتورة مبيعات</h2>
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
        <form id="invoiceForm" action="{{ route('invoices.store') }}" method="post">
            @csrf
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                        </div>

                        <div>
                            <a href="" class="btn btn-outline-danger">
                                <i class="fa fa-ban"></i>الغاء
                            </a>
                            <button type="submit" id="saveInvoice" class="btn btn-outline-primary">
                                <i class="fa fa-save"></i> حفظ
                            </button>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <span>العميل :</span>
                                            </div>
                                            <div class="col-md-6">
                                                <select class="form-control" name="payment">
                                                    <option value="">اختر الطريقة </option>
                                                    <option value="1">ارسال عبر البريد</option>
                                                    <option value="2">طباعة </option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <span>العميل :</span>
                                            </div>
                                            <div class="col-md-6">
                                                <select class="form-control select2" name="client_id" required>
                                                    <option value="">اختر العميل</option>
                                                    @foreach ($clients as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ isset($client) && $client->id == $item->id ? 'selected' : '' }}>
                                                            {{ $item->trade_name }}
                                                        </option>
                                                    @endforeach
                                                </select>


                                            </div>

                                            <div class="col-md-4">
                                                <a href="{{ route('clients.create') }}" type="button"
                                                    class="btn btn-primary mr-1 mb-1 waves-effect waves-light">
                                                    <i class="fa fa-user-plus"></i>جديد
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <span>قوائم الاسعار :</span>
                                            </div>
                                            <div class="col-md-6">
                                                <select class="form-control" id="price-list-select" name="price_list_id">
                                                    <option value="">اختر قائمة اسعار</option>
                                                    @foreach ($price_lists as $price_list)
                                                        <option value="{{ $price_list->id }}">{{ $price_list->name ?? '' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">

                                <div class="row add_item">
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span>رقم الفاتورة :</span>
                                            </div>
                                            <div class="col-md-8">
                                                <label class="form-control">{{ $invoice_number }}</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span>تاريخ الفاتورة :</span>
                                            </div>
                                            <div class="col-md-8">
                                                <input class="form-control" type="date" name="invoice_date"
                                                    value="{{ old('invoice_date', date('Y-m-d')) }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span>مسئول المبيعات :</span>
                                            </div>
                                            <div class="col-md-9">
                                                <select name="employee_id" class="form-control select2 " id="">
                                                    @foreach ($employees as $employee)
                                                        <option value="{{ $employee->id }}">{{ $employee->full_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span>تاريخ الاصدار :</span>
                                            </div>
                                            <div class="col-md-8">
                                                <input class="form-control" type="date" name="issue_date"
                                                    value="{{ old('issue_date', date('Y-m-d')) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span>شروط الدفع :</span>
                                            </div>
                                            <div class="col-md-6">
                                                <input class="form-control" type="text" name="terms">
                                            </div>
                                            <div class="col-md-2">
                                                <span class="form-control-plaintext">أيام</span>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <input class="form-control" type="text" placeholder="عنوان إضافي">
                                            </div>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <input class="form-control" type="text"
                                                        placeholder="بيانات إضافية">
                                                    <div class="input-group-append">
                                                        <button type="button"
                                                            class="btn btn-outline-success waves-effect waves-light addeventmore">
                                                            <i class="fa fa-plus-circle"></i>
                                                        </button>
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
            </div>

            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <input type="hidden" id="products-data" value="{{ json_encode($items) }}">
                        <div class="table-responsive">
                            <table class="table" id="items-table">
                                <thead>
                                    <tr>
                                        <th>المنتج</th>
                                        <th>الوصف</th>
                                        <th>الكمية</th>
                                        <th>السعر</th>
                                        <th>الخصم</th>
                                        <th>الضريبة 1</th>
                                        <th>الضريبة 2</th>
                                        <th>المجموع</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="item-row">
                                        <td style="width:18%" data-label="المنتج">
                                            <select name="items[0][product_id]" class="form-control product-select"
                                                required>
                                                <option value="">اختر المنتج</option>
                                                @foreach ($items as $item)
                                                    <option value="{{ $item->id }}"
                                                        data-price="{{ $item->sale_price }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td data-label="الوصف">
                                            <input type="text" name="items[0][description]"
                                                class="form-control item-description">
                                        </td>
                                        <td data-label="الكمية">
                                            <input type="number" name="items[0][quantity]" class="form-control quantity"
                                                value="1" min="1" required>
                                        </td>
                                        <td data-label="السعر">
                                            <input type="number" name="items[0][unit_price]" class="form-control price"
                                                value="" step="0.01" required>
                                        </td>
                                        <td data-label="الخصم">
                                            <div class="input-group">
                                                <input type="number" name="items[0][discount]"
                                                    class="form-control discount-value" value="0" min="0"
                                                    step="0.01">
                                                <select name="items[0][discount_type]" class="form-control discount-type">
                                                    <option value="amount">ريال</option>
                                                    <option value="percentage">نسبة %</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td data-label="الضريبة 1">
                                            <div class="input-group">
                                                <select name="items[0][tax_1]" class="form-control tax-select"
                                                    data-target="tax_1" style="width: 150px;"
                                                    onchange="updateHiddenInput(this)">
                                                    <option value=""></option>
                                                    @foreach ($taxs as $tax)
                                                        <option value="{{ $tax->tax }}"
                                                            data-id="{{ $tax->id }}"
                                                            data-name="{{ $tax->name }}"
                                                            data-type="{{ $tax->type }}">
                                                            {{ $tax->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="items[0][tax_1_id]">
                                            </div>
                                        </td>
                                        <td data-label="الضريبة 2">
                                            <div class="input-group">
                                                <select name="items[0][tax_2]" class="form-control tax-select"
                                                    data-target="tax_2" style="width: 150px;"
                                                    onchange="updateHiddenInput(this)">
                                                    <option value=""></option>
                                                    @foreach ($taxs as $tax)
                                                        <option value="{{ $tax->tax }}"
                                                            data-id="{{ $tax->id }}"
                                                            data-name="{{ $tax->name }}"
                                                            data-type="{{ $tax->type }}">
                                                            {{ $tax->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="items[0][tax_2_id]">
                                            </div>
                                        </td>
                                        <input type="hidden" name="items[0][store_house_id]" value="">
                                        <td data-label="المجموع">
                                            <span class="row-total">0.00</span>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm remove-row">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>


                                <tfoot id="tax-rows">
                                    <tr>
                                        <td colspan="9" class="text-left">
                                            <button type="button" class="btn btn-primary add-row"> <i
                                                    class="fa fa-prmary"></i>إضافة </button>
                                        </td>
                                    </tr>
                                    @php
                                        $currencySymbol =
                                            '<img src="' .
                                            asset('assets/images/Saudi_Riyal.svg') .
                                            '" alt="ريال سعودي" width="13" style="display: inline-block; margin-left: 5px; vertical-align: middle;">';
                                    @endphp
                                    <!-- Other rows -->
                                    <tr>
                                        <td colspan="7" class="text-right">المجموع الفرعي</td>
                                        <td><span id="subtotal">0.00</span>{!! $currencySymbol !!}</td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td colspan="7" class="text-right">مجموع الخصومات</td>
                                        <td>
                                            <span id="total-discount">0.00</span>
                                            <span id="discount-type-label">{!! $currencySymbol !!}</span>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>

                                        <td>

                                            <small id="tax-details"></small> <!-- مكان عرض تفاصيل الضرائب -->
                                        </td>

                                    </tr>
                                    <tr>
                                        <td colspan="7" class="text-right">المجموع الكلي</td>
                                        <td>
                                            <span id="grand-total">0.00</span>{!! $currencySymbol !!}
                                        </td>
                                    </tr>



                                </tfoot>

                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-white">
                    <!-- التبويبات الرئيسية -->
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" id="tab-discount" href="#">الخصم والتسوية</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-deposit" href="#">إيداع</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-shipping" href="#"> التوصيل </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-documents" href="#">إرفاق المستندات</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <!-- القسم الأول: الخصم والتسوية -->
                    <div id="section-discount" class="tab-section">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">قيمة الخصم</label>
                                <div class="input-group">
                                    <input type="number" name="discount_amount" class="form-control" value="0"
                                        min="0" step="0.01">
                                    <select name="discount_type" class="form-control">
                                        <option value="amount">ريال</option>
                                        <option value="percentage">نسبة مئوية</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- القسم الثاني: الإيداع -->
                    <div id="section-deposit" class="tab-section d-none">
                        <div class="row">
                            <div class="col-md-3 text-end">
                                <div class="input-group">
                                    <input type="number" id="advanced-payment" class="form-control" value="0"
                                        name="advance_payment" step="0.01" min="0"
                                        placeholder="الدفعة المقدمة">
                                    <select name="amount" id="amount" class="form-control">
                                        <option value="1">ريال</option>
                                        <option value="2">نسبة مئوية</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- القسم الثالث:      التوصيل -->
                    <div id="section-shipping" class="tab-section d-none">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">نوع الضريبة</label>
                                <select class="form-control" id="methodSelect" name="tax_type">
                                    <option value="1">القيمة المضافة (15%)</option>
                                    <option value="2">صفرية</option>
                                    <option value="3">معفاة</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">تكلفة الشحن</label>
                                <input type="number" class="form-control" name="shipping_cost" id="shipping"
                                    value="0" min="0" step="0.01">
                            </div>
                        </div>
                    </div>

                    <!-- القسم الرابع: إرفاق المستندات -->
                    <div id="section-documents" class="tab-section d-none">
                        <!-- التبويبات الداخلية -->
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" id="tab-new-document" href="#">رفع مستند جديد</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-uploaded-documents" href="#">بحث في الملفات</a>
                            </li>
                        </ul>

                        <!-- محتوى التبويبات -->
                        <div class="tab-content mt-3">
                            <!-- رفع مستند جديد -->
                            <div id="content-new-document" class="tab-pane active">
                                <div class="col-12 mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-file-upload text-primary me-2"></i>
                                        رفع مستند جديد:
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white">
                                            <i class="fas fa-upload"></i>
                                        </span>
                                        <input type="file" class="form-control" id="uploadFile"
                                            aria-describedby="uploadButton">
                                        <button class="btn btn-primary" id="uploadButton">
                                            <i class="fas fa-cloud-upload-alt me-1"></i>
                                            رفع
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- بحث في الملفات -->
                            <div id="content-uploaded-documents" class="tab-pane d-none">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center gap-2" style="width: 80%;">
                                                <label class="form-label mb-0"
                                                    style="white-space: nowrap;">المستند:</label>
                                                <select class="form-select">
                                                    <option selected>Select Document</option>
                                                    <option value="1">مستند 1</option>
                                                    <option value="2">مستند 2</option>
                                                    <option value="3">مستند 3</option>
                                                </select>
                                                <button type="button" class="btn btn-success">
                                                    أرفق
                                                </button>
                                            </div>
                                            <button type="button" class="btn btn-primary">
                                                <i class="fas fa-search me-1"></i>
                                                بحث متقدم
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card">
                <div class="card-header bg-white">
                    <h6 class="mb-0">الملاحظات/الشروط</h6>
                </div>
                <div class="card-body">
                    <textarea id="tinyMCE" name="notes"></textarea>
                </div>
            </div>
            <div class="card">
                <div class="card-body py-2 align-items-right">
                    <div class="d-flex justify-content-start" style="direction: rtl;">
                        <div class="form-check">
                            <input class="form-check-input toggle-check" type="checkbox" name="is_paid" value="1">
                            <label class="form-check-label">
                                مدفوع ب الفعل
                            </label>
                        </div>
                    </div>

                    <!-- حقول الدفع (مخفية بشكل افتراضي) -->
                    <div class="payment-fields mt-3" style="display: none;">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="payment_method">الخزينة </label>
                                <select class="form-control" name="">
                                    @foreach ($treasury as $treasur)
                                        <option value="{{ $treasur->id }}">{{ $treasur->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="payment_method">وسيلة الدفع</label>
                                <select class="form-control" name="payment_method">
                                    <option value="1">اختر وسيلة الدفع</option>
                                    <option value="2">نقداً</option>
                                    <option value="3">بطاقة ائتمان</option>
                                    <option value="4">تحويل بنكي</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">رقم المعرف</label>
                                <input type="text" class="form-control" name="reference_number">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#customFieldsModal">
                                <i class="fas fa-cog me-2"></i>
                                <span>إعدادات الحقول المخصصة</span>
                            </a>
                        </div>
                        <div>
                            <span>هدايا مجاناً</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="customFieldsModal" tabindex="-1" aria-labelledby="customFieldsModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="form-group ">
                            <label class="form-label">الوقت</label>
                            <input type="time" class="form-control" name="time">
                        </div>
                        <div class="modal-header border-0">
                            <h5 class="modal-title" id="customFieldsModalLabel">إعدادات الحقول المخصصة</h5>
                            <button type="button" class="btn-close" data-bs-toggle="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="alert alert-info" role="alert">
                                You will be redirected to edit the custom fields page
                            </div>
                        </div>
                        <div class="modal-footer justify-content-start border-0">
                            <button type="button" class="btn btn-success">
                                <i class="fas fa-check me-1"></i>
                                حفظ
                            </button>
                            <button type="button" class="btn btn-danger">
                                عدم الحفظ
                            </button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                إلغاء
                            </button>
                        </div>
                    </div>
                </div>
            </div>


        </form>
    </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/js/invoice.js') }}"></script>
    <script>
document.addEventListener("DOMContentLoaded", function() {
    // =============== المتغيرات العامة ===============
    const currencySymbol = ' ر.س';
    let rowCounter = 1;
    const invoiceForm = document.getElementById('invoiceForm');
    const saveButton = document.getElementById('saveInvoice');
    const itemsTable = document.getElementById('items-table');
    const clientSelect = document.querySelector('select[name="client_id"]');
    const clientIdHidden = document.getElementById('client_id_hidden');
    const priceListSelect = document.getElementById('price-list-select');

    // =============== تهيئة الأحداث ===============
    function initializeEvents() {
        // حدث إضافة صف جديد
        document.querySelector('.add-row').addEventListener('click', addNewRow);

        // حدث حذف صف (باستخدام تفويض الأحداث)
        itemsTable.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-row') || e.target.closest('.remove-row')) {
                const row = e.target.closest('tr');
                row.remove();
                calculateTotals();
                renumberRows();
            }
        });

        // حدث تغيير المنتج
        itemsTable.addEventListener('change', function(e) {
            if (e.target.classList.contains('product-select')) {
                handleProductChange(e.target);
            }
        });

        // حدث تغيير الكمية أو السعر أو الخصم
        itemsTable.addEventListener('input', function(e) {
            if (e.target.classList.contains('quantity') ||
                e.target.classList.contains('price') ||
                e.target.classList.contains('discount-value')) {
                calculateRowTotal(e.target.closest('tr'));
                calculateTotals();
            }
        });

        // حدث تغيير نوع الخصم
        itemsTable.addEventListener('change', function(e) {
            if (e.target.classList.contains('discount-type')) {
                calculateRowTotal(e.target.closest('tr'));
                calculateTotals();
            }
        });

        // حدث تغيير الضريبة
        itemsTable.addEventListener('change', function(e) {
            if (e.target.classList.contains('tax-select')) {
                updateHiddenTaxInput(e.target);
                calculateTotals();
            }
        });

        // حدث حفظ الفاتورة
        saveButton.addEventListener('click', handleSaveInvoice);

        // حدث تغيير قائمة الأسعار
        if (priceListSelect) {
            priceListSelect.addEventListener('change', function() {
                updatePricesBasedOnPriceList();
            });
        }

        // حدث لعرض/إخفاء حقول الدفع
        document.querySelector('.toggle-check').addEventListener('change', function(e) {
            document.querySelector('.payment-fields').style.display = e.target.checked ? 'block' : 'none';
        });
    }

    // =============== إدارة الصفوف ===============
    function addNewRow() {
        const tbody = itemsTable.querySelector('tbody');
        const firstRow = tbody.querySelector('.item-row');
        const newRow = firstRow.cloneNode(true);

        // تنظيف قيم الصف الجديد
        newRow.querySelectorAll('input').forEach(input => {
            if (input.type !== 'hidden') input.value = '';
            if (input.classList.contains('quantity')) input.value = '1';
            if (input.classList.contains('discount-value')) input.value = '0';
        });

        newRow.querySelectorAll('select').forEach(select => {
            select.selectedIndex = 0;
        });

        newRow.querySelector('.row-total').textContent = '0.00';

        // تحديث أسماء الحقول
        newRow.querySelectorAll('[name]').forEach(element => {
            const name = element.getAttribute('name').replace(/\[0\]/, `[${rowCounter}]`);
            element.setAttribute('name', name);
        });

        tbody.appendChild(newRow);
        rowCounter++;
    }

    // =============== العمليات الحسابية ===============
    function calculateRowTotal(row) {
        const qty = parseFloat(row.querySelector('.quantity').value) || 0;
        const price = parseFloat(row.querySelector('.price').value) || 0;
        const discountValue = parseFloat(row.querySelector('.discount-value').value) || 0;
        const discountType = row.querySelector('.discount-type').value;

        let rowTotal = qty * price;
        let discount = discountType === "percentage" ?
            rowTotal * (discountValue / 100) : discountValue;

        rowTotal -= discount;

        // حساب الضرائب
        const tax1 = parseFloat(row.querySelector('[name*="[tax_1]"]').value) || 0;
        const tax2 = parseFloat(row.querySelector('[name*="[tax_2]"]').value) || 0;
        const taxAmount = (rowTotal * (tax1 + tax2) / 100);
        rowTotal += taxAmount;

        row.querySelector('.row-total').textContent = rowTotal.toFixed(2);
    }

    function calculateTotals() {
        let subtotal = 0, totalDiscount = 0, totalTax = 0, grandTotal = 0;
        const taxDetails = {};

        document.querySelectorAll('.item-row').forEach(row => {
            const qty = parseFloat(row.querySelector('.quantity').value) || 0;
            const price = parseFloat(row.querySelector('.price').value) || 0;
            const discountValue = parseFloat(row.querySelector('.discount-value').value) || 0;
            const discountType = row.querySelector('.discount-type').value;

            // حساب الصف
            let rowSubtotal = qty * price;
            let discount = discountType === "percentage" ?
                rowSubtotal * (discountValue / 100) : discountValue;

            subtotal += rowSubtotal;
            totalDiscount += discount;

            // حساب الضرائب
            const tax1Select = row.querySelector('[name*="[tax_1]"]');
            const tax2Select = row.querySelector('[name*="[tax_2]"]');
            const tax1 = tax1Select ? parseFloat(tax1Select.value) || 0 : 0;
            const tax2 = tax2Select ? parseFloat(tax2Select.value) || 0 : 0;

            const tax1Name = tax1Select ? tax1Select.options[tax1Select.selectedIndex].text : '';
            const tax2Name = tax2Select ? tax2Select.options[tax2Select.selectedIndex].text : '';

            const taxableAmount = rowSubtotal - discount;
            const taxAmount = taxableAmount * (tax1 + tax2) / 100;
            totalTax += taxAmount;

            // تحديث تفاصيل الضرائب
            if (tax1 > 0) updateTaxDetails(taxDetails, tax1Name, tax1, taxableAmount);
            if (tax2 > 0) updateTaxDetails(taxDetails, tax2Name, tax2, taxableAmount);
        });

        // حساب الشحن
        const shipping = parseFloat(document.querySelector('[name="shipping_cost"]').value) || 0;

        grandTotal = subtotal - totalDiscount + totalTax + shipping;

        // تحديث الواجهة
        document.getElementById('subtotal').textContent = subtotal.toFixed(2);
        document.getElementById('total-discount').textContent = totalDiscount.toFixed(2);
        document.getElementById('grand-total').textContent = grandTotal.toFixed(2);

        // عرض تفاصيل الضرائب
        updateTaxRows(taxDetails);
    }

    function updateTaxDetails(taxDetails, taxName, taxRate, amount) {
        if (!taxDetails[taxName]) {
            taxDetails[taxName] = { rate: taxRate, amount: 0 };
        }
        taxDetails[taxName].amount += (amount * taxRate / 100);
    }

    function updateTaxRows(taxDetails) {
        // إزالة صفوف الضرائب القديمة
        document.querySelectorAll('.dynamic-tax-row').forEach(row => row.remove());

        const taxRowsContainer = document.getElementById('tax-rows');

        // إضافة صفوف الضرائب الجديدة
        for (const [taxName, taxInfo] of Object.entries(taxDetails)) {
            const taxRow = document.createElement('tr');
            taxRow.className = 'dynamic-tax-row';
            taxRow.innerHTML = `
                <td colspan="7" class="text-right">${taxName} (${taxInfo.rate}%)</td>
                <td>${taxInfo.amount.toFixed(2)} ${currencySymbol}</td>
            `;

            // إدراج قبل الصف الأخير
            const lastRow = taxRowsContainer.querySelector('tr:last-child');
            taxRowsContainer.insertBefore(taxRow, lastRow);
        }
    }

    // =============== إدارة المنتجات ===============
    function handleProductChange(selectElement) {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const price = selectedOption.dataset.price || 0;
        const row = selectElement.closest('tr');
        row.querySelector('.price').value = price;
        calculateTotals();
    }

    function updatePricesBasedOnPriceList() {
        const priceListId = priceListSelect.value;
        if (!priceListId) return;

        // هنا يمكنك إضافة AJAX لجلب الأسعار حسب قائمة الأسعار
        fetch(`/api/price-lists/${priceListId}/prices`)
            .then(response => response.json())
            .then(prices => {
                document.querySelectorAll('.item-row').forEach(row => {
                    const productSelect = row.querySelector('.product-select');
                    const productId = productSelect.value;
                    const priceInput = row.querySelector('.price');

                    if (productId && prices[productId]) {
                        priceInput.value = prices[productId];
                        calculateRowTotal(row);
                    }
                });
                calculateTotals();
            })
            .catch(error => {
                console.error('Error fetching prices:', error);
            });
    }

    // =============== إدارة الضرائب ===============
    function updateHiddenTaxInput(selectElement) {
        const row = selectElement.closest('tr');
        const namePrefix = selectElement.getAttribute('name').split('[')[0];
        const taxType = selectElement.dataset.target;
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const taxId = selectedOption ? selectedOption.dataset.id : '';

        const hiddenInput = row.querySelector(`input[name="${namePrefix}[${taxType}_id]"]`);
        if (hiddenInput) {
            hiddenInput.value = taxId;
        }
    }

    // =============== إدارة الحفظ ===============
    function handleSaveInvoice(e) {
        e.preventDefault();

        if (validateForm()) {
            verifyClientBeforeSubmit();
        }
    }

    function validateForm() {
        let isValid = true;
        clearErrorStyles();

        // التحقق من العميل
        if (!clientSelect.value) {
            markFieldAsError(clientSelect);
            showError('الرجاء اختيار عميل من القائمة');
            isValid = false;
        }

        // التحقق من المنتجات
        let hasValidItems = false;
        document.querySelectorAll('.item-row').forEach(row => {
            const product = row.querySelector('.product-select').value;
            const quantity = row.querySelector('.quantity').value;
            const price = row.querySelector('.price').value;

            if (product) {
                if (!quantity || quantity <= 0) {
                    markFieldAsError(row.querySelector('.quantity'));
                    isValid = false;
                }
                if (!price || price <= 0) {
                    markFieldAsError(row.querySelector('.price'));
                    isValid = false;
                }
                hasValidItems = true;
            }
        });

        if (!hasValidItems) {
            showError('يجب إضافة منتج واحد على الأقل');
            isValid = false;
        }

        return isValid;
    }

    function verifyClientBeforeSubmit() {
        const clientId = clientSelect.value;
        const clientName = clientSelect.options[clientSelect.selectedIndex].text;

        // بيانات العميل الافتراضية (في الواقع يجب جلبها من السيرفر)
        const clientData = {
            trade_name: clientName,
            phone: "05XXXXXXXX"
        };

        showVerificationDialog(clientData, clientId);
    }

    function showVerificationDialog(client, clientId) {
        Swal.fire({
            title: "🔐 التحقق من الهوية",
            html: `
                <div style="text-align: right; direction: rtl;">
                    <p><strong>اسم العميل:</strong> ${client.trade_name}</p>
                    <p><strong>رقم الهاتف:</strong> ${client.phone || "غير متوفر"}</p>
                    <p>يرجى إدخال رمز التحقق لإكمال العملية.</p>
                </div>
            `,
            input: "text",
            inputPlaceholder: "أدخل الرمز المرسل (123)",
            showCancelButton: true,
            confirmButtonText: "✅ تحقق",
            cancelButtonText: "❌ إلغاء",
            icon: "info",
            inputValidator: (value) => {
                if (!value) return "يجب إدخال رمز التحقق!";
                if (value !== "123") return "الرمز غير صحيح!";
            }
        }).then((result) => {
            if (result.isConfirmed) {
                clientIdHidden.value = clientId;
                invoiceForm.submit();
            }
        });
    }

    function submitForm() {
        invoiceForm.submit();
    }

    // =============== أدوات مساعدة ===============
    function renumberRows() {
        document.querySelectorAll('.item-row').forEach((row, index) => {
            row.querySelectorAll('[name]').forEach(element => {
                const name = element.getAttribute('name').replace(/\[\d+\]/, `[${index}]`);
                element.setAttribute('name', name);
            });
        });
        rowCounter = document.querySelectorAll('.item-row').length;
    }

    function markFieldAsError(field) {
        field.classList.add('required-error');
        field.focus();
    }

    function clearErrorStyles() {
        document.querySelectorAll('.required-error').forEach(el => {
            el.classList.remove('required-error');
        });
    }

    function showError(message) {
        Swal.fire({
            icon: 'error',
            title: 'خطأ',
            text: message,
            confirmButtonText: 'حسناً'
        });
    }

    // =============== تهيئة أولية ===============
    initializeEvents();
    calculateTotals();

    // اختبار أن العناصر موجودة
    console.log('invoiceForm:', invoiceForm);
    console.log('clientSelect:', clientSelect);
    console.log('saveButton:', saveButton);
});
    </script>
@endsection
