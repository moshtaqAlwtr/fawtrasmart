@extends('master')

@section('title')
    انشاء فاتورة مبيعات
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <style>
    /* تصميم عام للجدول */
    #items-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    #items-table th {
        background-color: #f8f9fa;
        color: #495057;
        font-weight: 600;
        padding: 12px 15px;
        text-align: right;
        border-bottom: 2px solid #dee2e6;
    }
    
    #items-table td {
        padding: 10px 15px;
        border-bottom: 1px solid #e9ecef;
        vertical-align: middle;
    }
    
    #items-table tr:hover td {
        background-color: #f8f9fa;
    }
    
    /* تحسين حقول الإدخال */
    .form-control {
        border-radius: 4px;
        border: 1px solid #ced4da;
        padding: 8px 12px;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    
    .form-control:focus {
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    /* تحسين أزرار الإجراءات */
    .btn {
        border-radius: 4px;
        padding: 8px 12px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    
    .btn-primary:hover {
        background-color: #0069d9;
        border-color: #0062cc;
    }
    
    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }
    
    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }
    
    /* تحسين مجموعة الإدخال */
    .input-group {
        display: flex;
        align-items: center;
    }
    
    .input-group .form-control {
        flex: 1;
        min-width: 70px;
    }
    
    .input-group select.form-control {
        width: auto;
        margin-right: 5px;
    }
    
    /* تصميم تذييل الجدول */
    #items-table tfoot tr:not(:first-child) td {
        font-weight: 500;
    }
    
    #items-table tfoot tr:last-child td {
        font-weight: 600;
        font-size: 1.1em;
        color: #2c3e50;
        border-top: 2px solid #dee2e6;
    }
    
    /* تصميم للشاشات الصغيرة */
    @media (max-width: 767.98px) {
        #items-table {
            display: block;
            overflow-x: auto;
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
            margin-bottom: 1.5rem;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
    
        #items-table td,
        #items-table th {
            border: none;
            padding: 8px 0;
        }
    
        #items-table td {
            text-align: left;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    
        #items-table td::before {
            content: attr(data-label);
            font-weight: bold;
            margin-right: 10px;
            color: #495057;
            flex: 0 0 40%;
        }
    
        #items-table .item-row td {
            width: 100%;
        }
    
        #items-table .item-row td input,
        #items-table .item-row td select {
            width: 55%;
            flex: 0 0 55%;
        }
    
        #items-table tfoot tr {
            display: flex;
            flex-direction: column;
        }
    
        #items-table tfoot td {
            text-align: left;
            display: flex;
            justify-content: space-between;
        }
        
        #items-table tfoot td::before {
            content: attr(data-label);
            font-weight: bold;
            margin-right: 10px;
        }
        
        .input-group {
            flex-direction: column;
            align-items: flex-end;
        }
        
        .input-group .form-control {
            width: 100%;
            margin-bottom: 5px;
        }
        
        .input-group select.form-control {
            width: 100%;
        }
    }
    
    /* تحسينات إضافية */
    .row-total, #subtotal, #total-discount, #grand-total {
        font-weight: 600;
        color: #2c3e50;
    }
    
    #tax-details {
        color: #6c757d;
        font-size: 0.9em;
        line-height: 1.5;
    }
    
    .card {
        border-radius: 8px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        border: none;
    }
    
    .card-body {
        padding: 20px;
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
                            <button type="button" id="saveInvoice" class="btn btn-outline-primary">
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
                                                <select class="form-control select2" id="clientSelect" name="client_id" required>
                                                    <option value="">اختر العميل</option>
                                                    @foreach ($clients as $c)
                                                        <option value="{{ $c->id }}"
                                                            {{ (isset($client_id) && $client_id == $c->id) || (isset($client) && $client->id == $c->id) ? 'selected' : '' }}>
                                                            {{ $c->trade_name }} - الرصيد الافتتاحي: {{ number_format($c->opening_balance, 2) }} ريال {{$c->code ?? ""}}
                                                        </option>
                                                    @endforeach
                                                </select>


                                            </div>
                                            <input type="hidden" id="client_id_hidden" name="client_id" value="">
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
                                <select name="items[0][product_id]" class="form-control product-select" required>
                                    <option value="">اختر المنتج</option>
                                    @foreach ($items as $item)
                                        <option value="{{ $item->id }}"
                                            data-price="{{ $item->sale_price }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td data-label="الوصف">
                                <input type="text" name="items[0][description]"
                                    class="form-control item-description" placeholder="أدخل الوصف">
                            </td>
                            <td data-label="الكمية">
                                <input type="number" name="items[0][quantity]" class="form-control quantity"
                                    value="1" min="1" required>
                            </td>
                            <td data-label="السعر">
                                <input type="number" name="items[0][unit_price]" class="form-control price"
                                    value="" step="0.01" required placeholder="0.00">
                            </td>
                            <td data-label="الخصم">
                                <div class="input-group">
                                    <input type="number" name="items[0][discount]"
                                        class="form-control discount-value" value="0" min="0"
                                        step="0.01" placeholder="0.00">
                                    <select name="items[0][discount_type]" class="form-control discount-type">
                                        <option value="amount">ريال</option>
                                        <option value="percentage">نسبة %</option>
                                    </select>
                                </div>
                            </td>
                            <td data-label="الضريبة 1">
                                <div class="input-group">
                                    <select name="items[0][tax_1]" class="form-control tax-select"
                                        data-target="tax_1" onchange="updateHiddenInput(this)">
                                        <option value="">لا يوجد</option>
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
                                        data-target="tax_2" onchange="updateHiddenInput(this)">
                                        <option value="">لا يوجد</option>
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
                                <img src="{{ asset('assets/images/Saudi_Riyal.svg') }}" alt="ريال سعودي" width="13" style="display: inline-block; margin-left: 5px; vertical-align: middle;">
                            </td>
                            <td data-label="الإجراءات">
                                <button type="button" class="btn btn-danger btn-sm remove-row" title="حذف الصف">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot id="tax-rows">
    <tr>
        <td colspan="9" class="text-left">
            <button type="button" class="btn btn-primary add-row">
                <i class="fa fa-plus"></i> إضافة
            </button>
        </td>
    </tr>

    @php
        $currencySymbol = '<img src="' . asset('assets/images/Saudi_Riyal.svg') . '" alt="ريال سعودي" width="13" style="display: inline-block; margin-left: 5px; vertical-align: middle;">';
    @endphp

    <tr>
        <td colspan="7" class="text-right" data-label="المجموع الفرعي">المجموع الفرعي</td>
        <td>
            <span id="subtotal">0.00</span>
            {!! $currencySymbol !!}
        </td>
        <td></td>
    </tr>
    <tr>
        <td colspan="7" class="text-right" data-label="مجموع الخصومات">مجموع الخصومات</td>
        <td>
            <span id="total-discount">0.00</span>
            <span id="discount-type-label">{!! $currencySymbol !!}</span>
        </td>
        <td></td>
    </tr>
    <tr>
        <td colspan="9">
            <small id="tax-details" class="text-muted"></small>
        </td>
    </tr>
        <tr class="adjustment-row" style="display:none;">
        <td colspan="7" class="text-right">
            <span id="adjustment-label"></span>
        </td>
        <td>
            <span id="adjustment-value">0.00</span> {!! $currencySymbol !!}
        </td>
        <td></td>
    </tr>

    <tr>
        <td colspan="7" class="text-right" data-label="المجموع الكلي">المجموع الكلي</td>
        <td>
            <span id="grand-total">0.00</span>
            {!! $currencySymbol !!}
        </td>
        <td></td>
    </tr>

    <!-- ✅ صف مدفوع بالكامل -->
    <tr>
    <td colspan="9" class="text-end">
        <div class="form-check d-inline-block">
            <input class="form-check-input toggle-check" type="checkbox" name="is_paid" id="is_paid" value="1">
            <label class="form-check-label fw-bold" for="is_paid" style="font-size: 1.1rem;">
                 مدفوع بالكامل
            </label>
        </div>
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
    <ul class="nav nav-tabs card-header-tabs align-items-center">
        
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
                          <div class="col-md-6">
                    <label class="form-label">التسوية</label>
                    <div class="input-group">
                        <input type="text" name="adjustment_label" class="form-control" placeholder="اسم التسوية (مثال: خصم نقدي)">
                        <input type="number" name="adjustment_value" class="form-control" value="0" min="0" step="0.01" placeholder="قيمة التسوية">
                        <select name="adjustment_type" class="form-control">
                            <option value="discount">خصم</option>
                            <option value="addition">إضافة</option>
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
          <div class="card shadow-sm border-0">
    <div class="card-header border-bottom" style="background-color: transparent;">
        <h5 class="mb-0 fw-bold text-dark" style="font-size: 1.2rem;">
            📝 الملاحظات / الشروط
        </h5>
    </div>
    <div class="card-body">
        <textarea id="tinyMCE" name="notes" class="form-control" rows="6" style="font-size: 1.05rem;"></textarea>
    </div>
</div>


           

            <!--<div class="card">-->
            <!--    <div class="card-body">-->
            <!--        <div class="d-flex justify-content-between align-items-center">-->
            <!--            <div class="d-flex align-items-center">-->
            <!--                <a href="#" data-bs-toggle="modal" data-bs-target="#customFieldsModal">-->
            <!--                    <i class="fas fa-cog me-2"></i>-->
            <!--                    <span>إعدادات الحقول المخصصة</span>-->
            <!--                </a>-->
            <!--            </div>-->
            <!--            <div>-->
            <!--                <span>هدايا مجاناً</span>-->
            <!--            </div>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->

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
        document.querySelectorAll('.toggle-check').forEach((checkbox) => {
            checkbox.addEventListener('change', function() {
                const paymentFields = this.closest('.card-body').querySelector('.payment-fields');
                if (this.checked) {
                    paymentFields.style.display = 'block'; // إظهار الحقول
                } else {
                    paymentFields.style.display = 'none'; // إخفاء الحقول
                }
            });
        });
    </script>

    <script>
        function updateHiddenInput(selectElement) {
            // البحث عن أقرب صف يحتوي على العنصر المحدد
            var row = selectElement.closest('.item-row');

            // استخراج نوع الضريبة (tax_1 أو tax_2) من data-target
            var taxType = selectElement.getAttribute('data-target');

            // البحث عن الحقل المخفي داخل نفس الصف المرتبط بهذه الضريبة
            var hiddenInput = row.querySelector('input[name^="items"][name$="[' + taxType + '_id]"]');

            // تحديث قيمة الحقل المخفي بناءً على الضريبة المختارة
            if (hiddenInput) {
                hiddenInput.value = selectElement.options[selectElement.selectedIndex].getAttribute('data-id');
            }
        }
    </script>


    <script>
        $(document).ready(function() {
            // تهيئة الأحداث للصفوف الموجودة مسبقًا
            initializeEvents();

            // إعادة تهيئة الأحداث عند إضافة صف جديد
            $(document).on('click', '.add-row', function() {
                var lastRow = $('.item-row').last(); // الحصول على آخر صف
                var newRow = lastRow.clone(); // استنساخ آخر صف
                var rowIndex = $('.item-row').length; // تحديد رقم الصف الجديد

                // مسح القيم في الصف الجديد
                newRow.find('input, select').val('');
                newRow.find('.row-total').text('0.00');

                // تحديث أسماء الحقول لتكون فريدة (حسب الصف الجديد)
                newRow.find('input, select').each(function() {
                    var name = $(this).attr('name');
                    if (name) {
                        // تحديث الأرقام في أسماء الحقول
                        name = name.replace(/\[\d+\]/, '[' + rowIndex + ']');
                        $(this).attr('name', name);
                    }
                });

                newRow.appendTo('tbody'); // إضافة الصف الجديد إلى الجدول
                initializeEvents(); // إعادة تهيئة الأحداث للصف الجديد
            });



            function initializeEvents() {
    $('.product-select, #price-list-select').off('change').on('change', function() {
        var priceListId = $('#price-list-select').val();
        var productId = $(this).closest('tr').find('.product-select').val();
        var priceInput = $(this).closest('tr').find('.price');
        var currentRow = $(this).closest('tr'); // حفظ المرجع للصف الحالي

        if (priceListId && productId) {
            $.ajax({
                url: '/sales/invoices/get-price',
                method: 'GET',
                data: {
                    price_list_id: priceListId,
                    product_id: productId
                },
                success: function(response) {
                    if (response.price) {
                        priceInput.val(response.price);
                    } else {
                        var productPrice = currentRow.find('.product-select option:selected').data('price');
                        priceInput.val(productPrice);
                    }
                    // حساب المجموع بعد تحديث السعر
                    calculateRowTotal(currentRow);
                    calculateGrandTotal();
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching price:", error);
                }
            });
        } else {
            var productPrice = $(this).closest('tr').find('.product-select option:selected').data('price');
            priceInput.val(productPrice);
            // حساب المجموع بعد تحديث السعر
            calculateRowTotal($(this).closest('tr'));
            calculateGrandTotal();
        }
    });

    // أيضا تأكد من أن تغيير الكمية أو الخصم يحسب المجموع
    $(document).on('change', '.quantity, .discount-value, .discount-type, .tax-select', function() {
        calculateRowTotal($(this).closest('tr'));
        calculateGrandTotal();
    });
}
        });
        $(document).ready(function() {
            $('.product-select').change(function() {
                var selectedOption = $(this).find(':selected'); // الحصول على الخيار المحدد
                var price = selectedOption.data('price'); // استخراج سعر البيع من data-price

                if (price !== undefined) {
                    $(this).closest('tr').find('.price').val(price); // تعيين السعر في الحقل المناسب
                }
            });
        });
    </script>
    <script>
        document.addEventListener('change', function(e) {
            if (e.target && e.target.classList.contains('tax-select')) {
                let row = e.target.closest('tr');

                // الحصول على الضريبة 1
                let tax1Select = row.querySelector('[name^="items"][name$="[tax_1]"]');
                let tax1Name = tax1Select.options[tax1Select.selectedIndex].dataset.name;
                let tax1Value = parseFloat(tax1Select.value);

                // الحصول على الضريبة 2
                let tax2Select = row.querySelector('[name^="items"][name$="[tax_2]"]');
                let tax2Name = tax2Select.options[tax2Select.selectedIndex].dataset.name;
                let tax2Value = parseFloat(tax2Select.value);

                // إعداد النص لعرض الضرائب مع قيمتها
                let taxDetails = [];

                if (tax1Value > 0) {
                    taxDetails.push(`${tax1Name} ${tax1Value}%`);
                }

                if (tax2Value > 0) {
                    taxDetails.push(`${tax2Name} ${tax2Value}%`);
                }

                // إذا لم يتم اختيار أي ضريبة، عرض "الضريبة: 0"
                if (taxDetails.length === 0) {
                    document.getElementById('tax-names-label').innerText = "الضريبة: 0";
                } else {
                    document.getElementById('tax-names-label').innerText = taxDetails.join(" ، ");
                }

                // حساب إجمالي الضرائب بناءً على المجموع الفرعي
                let subtotal = 0;
                document.querySelectorAll(".item-row").forEach(function(row) {
                    let quantity = parseFloat(row.querySelector(".quantity").value) || 0;
                    let unitPrice = parseFloat(row.querySelector(".price").value) || 0;
                    let itemTotal = quantity * unitPrice;
                    subtotal += itemTotal;
                });

                let totalTax = 0;

                // حساب الضريبة 1
                if (tax1Value > 0) {
                    totalTax += (subtotal * tax1Value) / 100;
                }

                // حساب الضريبة 2
                if (tax2Value > 0) {
                    totalTax += (subtotal * tax2Value) / 100;
                }

                // عرض إجمالي الضرائب
                document.getElementById('total-tax').innerText = totalTax.toFixed(2);
            }
        });



        document.addEventListener("DOMContentLoaded", function() {

            function calculateTotals() {
                let subtotal = 0; // المجموع الفرعي (بدون ضريبة)
                let grandTotal = 0; // المجموع الكلي
                let taxDetails = {}; // تفاصيل الضرائب المختارة

                // مسح صفوف الضرائب السابقة
                document.querySelectorAll(".dynamic-tax-row").forEach(row => row.remove());

                document.querySelectorAll(".item-row").forEach(function(row) {
                    let quantity = parseFloat(row.querySelector(".quantity").value) || 0;
                    let unitPrice = parseFloat(row.querySelector(".price").value) || 0;
                    let itemTotal = quantity * unitPrice; // هذا هو المجموع الكلي للعنصر
                    subtotal += itemTotal; // إضافة إلى المجموع الفرعي

                    // حساب الضرائب
                    let tax1Value = parseFloat(row.querySelector("[name^='items'][name$='[tax_1]']")
                        .value) || 0;
                    let tax1Type = row.querySelector("[name^='items'][name$='[tax_1]']").options[row
                        .querySelector("[name^='items'][name$='[tax_1]']").selectedIndex].dataset.type;
                    let tax1Name = row.querySelector("[name^='items'][name$='[tax_1]']").options[row
                        .querySelector("[name^='items'][name$='[tax_1]']").selectedIndex].dataset.name;

                    let tax2Value = parseFloat(row.querySelector("[name^='items'][name$='[tax_2]']")
                        .value) || 0;
                    let tax2Type = row.querySelector("[name^='items'][name$='[tax_2]']").options[row
                        .querySelector("[name^='items'][name$='[tax_2]']").selectedIndex].dataset.type;
                    let tax2Name = row.querySelector("[name^='items'][name$='[tax_2]']").options[row
                        .querySelector("[name^='items'][name$='[tax_2]']").selectedIndex].dataset.name;

                    // حساب الضريبة 1
                    if (tax1Value > 0) {
                        let itemTax = 0;
                        if (tax1Type === 'included') {
                            // الضريبة متضمنة: نستخرجها من المجموع الكلي
                            itemTax = itemTotal - (itemTotal / (1 + (tax1Value / 100)));
                        } else {
                            // الضريبة غير متضمنة: نضيفها إلى المجموع الفرعي
                            itemTax = (itemTotal * tax1Value) / 100;
                        }

                        if (!taxDetails[tax1Name]) {
                            taxDetails[tax1Name] = 0;
                        }
                        taxDetails[tax1Name] += itemTax;
                    }

                    // حساب الضريبة 2
                    if (tax2Value > 0) {
                        let itemTax = 0;
                        if (tax2Type === 'included') {
                            // الضريبة متضمنة: نستخرجها من المجموع الكلي
                            itemTax = itemTotal - (itemTotal / (1 + (tax2Value / 100)));
                        } else {
                            // الضريبة غير متضمنة: نضيفها إلى المجموع الفرعي
                            itemTax = (itemTotal * tax2Value) / 100;
                        }

                        if (!taxDetails[tax2Name]) {
                            taxDetails[tax2Name] = 0;
                        }
                        taxDetails[tax2Name] += itemTax;
                    }
                });

                // إضافة صفوف الضرائب ديناميكيًا
                let taxRowsContainer = document.getElementById("tax-rows");
                for (let taxName in taxDetails) {
                    let taxRow = document.createElement("tr");
                    taxRow.classList.add("dynamic-tax-row");

                    taxRow.innerHTML = `
                <td colspan="7" class="text-right">
                    <span>${taxName}</span>
                </td>
                <td>
                    <span>${taxDetails[taxName].toFixed(2)}</span>{!! $currencySymbol !!}
                </td>
            `;

                    taxRowsContainer.insertBefore(taxRow, document.querySelector("#tax-rows tr:last-child"));
                }

                // تحديث القيم في الواجهة
                document.getElementById("subtotal").innerText = subtotal.toFixed(2);
                document.getElementById("grand-total").innerText = (subtotal + Object.values(taxDetails).reduce((a,
                    b) => a + b, 0)).toFixed(2);

                // إرسال الضرائب إلى الكنترولر
                let taxes = [];
                for (let taxName in taxDetails) {
                    taxes.push({
                        name: taxName,
                        value: taxDetails[taxName],
                    });
                }

                // إضافة الضرائب إلى بيانات الفاتورة
                document.querySelector("form").addEventListener("submit", function(e) {
                    e.preventDefault();
 formData.append("adjustment_label", $('input[name="adjustment_label"]').val());
    formData.append("adjustment_value", $('input[name="adjustment_value"]').val());
    formData.append("adjustment_type", $('select[name="adjustment_type"]').val());
                    let formData = new FormData(this);

                    // إضافة الضرائب إلى FormData
                    let taxes = [];
                    for (let taxName in taxDetails) {
                        taxes.push({
                            name: taxName,
                            value: taxDetails[taxName],
                        });
                    }
                    formData.append("taxes", JSON.stringify(taxes));

                    // إرسال البيانات إلى الكنترولر
                    fetch(this.action, {
                            method: this.method,
                            body: formData,
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute("content"),
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log("تم حفظ البيانات بنجاح:", data);
                        })
                        .catch(error => {
                            console.error("حدث خطأ أثناء حفظ البيانات:", error);
                        });
                });

            }

            // حساب القيم عند تغيير المدخلات
            document.addEventListener("input", function(event) {
                if (event.target.matches(".quantity, .price, .tax-select")) {
                    calculateTotals();
                }
            });

            // حساب القيم عند تحميل الصفحة
            calculateTotals();
            const clientSelect = document.getElementById("clientSelect");
            const clientIdHidden = document.getElementById("client_id_hidden");
            const saveButton = document.getElementById("saveInvoice");
            const invoiceForm = document.getElementById("invoiceForm");

            // 1. تحديث الحقل المخفي عند تغيير العميل
            clientSelect.addEventListener("change", function() {
                clientIdHidden.value = this.value;
                console.log("تم تحديث client_id إلى:", this.value);
            });

            // 2. معالجة زر الحفظ
            saveButton.addEventListener("click", function(event) {
                event.preventDefault(); // منع الإرسال الافتراضي

                const clientId = clientSelect.value;

                console.log("قيمة العميل المختار:", clientId);
                console.log("قيمة الحقل المخفي قبل الإرسال:", clientIdHidden.value);

                if (!clientId) {
                    Swal.fire({
                        icon: "error",
                        title: "خطأ",
                        text: "الرجاء اختيار عميل من القائمة"
                    });
                    return;
                }

                // جلب بيانات العميل
                fetch(`/sales/invoices/get-client/${clientId}`)
                    .then(response => {
                        if (!response.ok) throw new Error("فشل في جلب بيانات العميل");
                        return response.json();
                    })
                    .then(client => {
                        // عرض نافذة التحقق
                        Swal.fire({
                            title: "🔐 التحقق من الهوية",
                            html: `
        <div style="text-align: right; direction: rtl;">
            <p><strong>اسم العميل:</strong> ${client.trade_name}</p>
            <p><strong>رقم الهاتف:</strong> ${client.phone ?? "غير متوفر"}</p>
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
                                if (!value) return "⚠️ يجب إدخال رمز التحقق!";
                                if (value !== "123") return "❌ الرمز غير صحيح!";
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // تنفيذ العملية بعد التحقق
                                clientIdHidden.value = clientId;
                                console.log("تم تحديث client_id_hidden إلى:", clientIdHidden
                                    .value);
                                invoiceForm.submit();
                            }
                        });

                    })
                    .catch(error => {
                        console.error("Error:", error);
                        Swal.fire("خطأ", "تعذر جلب بيانات العميل", "error");
                    });
            });


        });
        document.addEventListener('DOMContentLoaded', function() {
            // إذا كان هناك عميل محدد، قم باختياره في القائمة
            @if (isset($client_id))
                $('#clientSelect').val('{{ $client_id }}').trigger('change');
            @endif

            // أو إذا كان هناك كائن عميل
            @if (isset($client) && $client)
                $('#clientSelect').val('{{ $client->id }}').trigger('change');
            @endif
        });
        // دالة تحديث عرض التسوية
function updateAdjustmentDisplay() {
    const label = $('input[name="adjustment_label"]').val();
    const value = parseFloat($('input[name="adjustment_value"]').val()) || 0;
    const type = $('select[name="adjustment_type"]').val();

    if (value > 0) {
        $('#adjustment-label').text(label || 'التسوية');
        $('#adjustment-value').text(value.toFixed(2));
        $('.adjustment-row').show();
    } else {
        $('#adjustment-label').text('');
        $('#adjustment-value').text('0.00');
        $('.adjustment-row').hide();
    }
}
// أحداث التغيير لحقول التسوية
$(document).on('input change', 'input[name="adjustment_value"], input[name="adjustment_label"], select[name="adjustment_type"]', function() {
    updateAdjustmentDisplay();
    calculateTotals();
});
// دالة حساب الإجمالي الكلي مع التسوية (استبدل الدالة القديمة بهذه)
function calculateGrandTotal() {
    let subtotal = 0;
    
    // حساب المجموع الفرعي
    $('.item-row').each(function() {
        subtotal += calculateRowTotal($(this));
    });
    
    // حساب الضرائب
    let totalTax = 0;
    document.querySelectorAll(".item-row").forEach(function(row) {
        let tax1Value = parseFloat(row.querySelector("[name^='items'][name$='[tax_1]']").value) || 0;
        let tax2Value = parseFloat(row.querySelector("[name^='items'][name$='[tax_2]']").value) || 0;
        
        let quantity = parseFloat(row.querySelector(".quantity").value) || 0;
        let unitPrice = parseFloat(row.querySelector(".price").value) || 0;
        let itemTotal = quantity * unitPrice;
        
        if (tax1Value > 0) {
            totalTax += (itemTotal * tax1Value) / 100;
        }
        if (tax2Value > 0) {
            totalTax += (itemTotal * tax2Value) / 100;
        }
    });

    // حساب الخصومات من العناصر
    let totalItemsDiscount = 0;
    $('.item-row').each(function() {
        let discountValue = parseFloat($(this).find('.discount-value').val()) || 0;
        let discountType = $(this).find('.discount-type').val();
        
        if (discountType === 'percentage') {
            let quantity = parseFloat($(this).find('.quantity').val()) || 0;
            let price = parseFloat($(this).find('.price').val()) || 0;
            discountValue = (quantity * price * discountValue) / 100;
        }
        
        totalItemsDiscount += discountValue;
    });

    // حساب التسوية
    const adjustmentValue = parseFloat($('input[name="adjustment_value"]').val()) || 0;
    const adjustmentType = $('select[name="adjustment_type"]').val();
    
    let grandTotal = subtotal + totalTax - totalItemsDiscount;
    
    // تطبيق التسوية
    if (adjustmentType === 'discount') {
        grandTotal -= adjustmentValue;
    } else {
        grandTotal += adjustmentValue;
    }
    
    // تحديث القيم في الواجهة
    $('#subtotal').text(subtotal.toFixed(2));
    $('#total-tax').text(totalTax.toFixed(2));
    $('#grand-total').text(grandTotal.toFixed(2));
    updateAdjustmentDisplay();
    
    return grandTotal;
}
        // دالة تحديث عرض التسوية
function updateAdjustmentDisplay() {
    const label = $('input[name="adjustment_label"]').val();
    const value = parseFloat($('input[name="adjustment_value"]').val()) || 0;
    const type = $('select[name="adjustment_type"]').val();

    if (label && value > 0) {
        $('#adjustment-label').text(label);
        $('#adjustment-value').text(value.toFixed(2));
        $('.adjustment-row').show();
    } else {
        $('.adjustment-row').hide();
    }
}

// دالة حساب الإجمالي الكلي مع التسوية (استبدل الدالة القديمة بهذه)
function calculateGrandTotal() {
    let subtotal = 0;
    
    // حساب المجموع الفرعي
    $('.item-row').each(function() {
        subtotal += calculateRowTotal($(this));
    });
    
    // حساب الضرائب
    let totalTax = 0;
    document.querySelectorAll(".item-row").forEach(function(row) {
        let tax1Value = parseFloat(row.querySelector("[name^='items'][name$='[tax_1]']").value) || 0;
        let tax2Value = parseFloat(row.querySelector("[name^='items'][name$='[tax_2]']").value) || 0;
        
        let quantity = parseFloat(row.querySelector(".quantity").value) || 0;
        let unitPrice = parseFloat(row.querySelector(".price").value) || 0;
        let itemTotal = quantity * unitPrice;
        
        if (tax1Value > 0) {
            totalTax += (itemTotal * tax1Value) / 100;
        }
        if (tax2Value > 0) {
            totalTax += (itemTotal * tax2Value) / 100;
        }
    });

    // حساب الخصومات من العناصر
    let totalItemsDiscount = 0;
    $('.item-row').each(function() {
        let discountValue = parseFloat($(this).find('.discount-value').val()) || 0;
        let discountType = $(this).find('.discount-type').val();
        
        if (discountType === 'percentage') {
            let quantity = parseFloat($(this).find('.quantity').val()) || 0;
            let price = parseFloat($(this).find('.price').val()) || 0;
            discountValue = (quantity * price * discountValue) / 100;
        }
        
        totalItemsDiscount += discountValue;
    });

    // حساب التسوية
    const adjustmentValue = parseFloat($('input[name="adjustment_value"]').val()) || 0;
    const adjustmentType = $('select[name="adjustment_type"]').val();
    
    let grandTotal = subtotal + totalTax - totalItemsDiscount;
    
    // تطبيق التسوية
    if (adjustmentType === 'discount') {
        grandTotal -= adjustmentValue;
    } else {
        grandTotal += adjustmentValue;
    }
    
    // تحديث القيم في الواجهة
    $('#subtotal').text(subtotal.toFixed(2));
    $('#total-tax').text(totalTax.toFixed(2));
    $('#grand-total').text(grandTotal.toFixed(2));
    updateAdjustmentDisplay();
    
    return grandTotal;
}
    </script>
    <script></script>
    <script>
        $(document).ready(function () {
            $('#clientSelect').select2({
                width: '100%' // يضمن العرض الكامل على الجوال
            });
        });
    </script>
    <script>
// دالة للتحقق من العروض وتطبيق الخصومات
// دالة للتحقق من العروض وتطبيق الخصومات
console.log('✅ تم تحميل applyOffersToInvoice');

function applyOffersToInvoice() {
    const clientId = parseInt($('#clientSelect').val());
    if (!clientId) return; // إذا لم يتم اختيار عميل
    
    const today = new Date().toISOString().split('T')[0];
    
    // مسح الخصومات السابقة
    $('.offer-applied-badge').remove();
    $('.item-row').each(function() {
        $(this).find('.discount-value').val(0);
    });

    $.ajax({
        url: '/clients/offers/active-offers',
        method: 'GET',
        data: { client_id: clientId, date: today },
        success: function(offers) {
            let hasOffers = false;
            
            $('.item-row').each(function() {
                const $row = $(this);
                const productId = parseInt($row.find('.product-select').val());
                const quantity = parseInt($row.find('.quantity').val()) || 1;
                const price = parseFloat($row.find('.price').val()) || 0;
                
                if (!productId) return;
                
                // البحث عن المنتج لمعرفة التصنيف
                const product = productsData.find(p => p.id === productId);
                const categoryId = product ? product.category_id : null;
                
                offers.forEach(offer => {
                    if (checkOfferConditions(offer, clientId, productId, categoryId, quantity)) {
                        applyDiscountToItem($row, offer, price);
                        hasOffers = true;
                    }
                });
            });
            
            if (hasOffers) {
                toastr.success('تم تطبيق العروض التلقائية بنجاح');
                calculateGrandTotal(); // إعادة حساب المجموع الكلي
            }
        },
        error: function() {
            console.error('فشل في جلب العروض');
        }
    });
}
// دالة التحقق من شروط العرض (معدلة)


// في دالة applyOffersToInvoice:

// دالة التحقق من شروط العرض (معدلة)
function checkOfferConditions(offer, clientId, productId, categoryId, quantity) {
    // 1. التحقق من العملاء المطبق عليهم العرض
    if (offer.clients && offer.clients.length > 0) {
        const clientIds = offer.clients.map(c => parseInt(c.id));
        if (!clientIds.includes(clientId)) return false;
    }
    
    // 2. التحقق من نوع الوحدة (منتج/تصنيف/كل المنتجات)
    switch (parseInt(offer.unit_type)) {
        case 1: // كل المنتجات
            break;
        case 2: // تصنيف معين
            if (!offer.categories || !offer.categories.some(c => parseInt(c.id) === categoryId)) 
                return false;
            break;
        case 3: // منتجات محددة
            if (!offer.products || !offer.products.some(p => parseInt(p.id) === productId))
                return false;
            break;
    }
    
    // 3. التحقق من الحد الأدنى للكمية إذا كان العرض من النوع الثاني
    if (parseInt(offer.type) === 2 && quantity < parseInt(offer.quantity)) {
        return false;
    }
    
    return true;
}


// دالة تطبيق الخصم على العنصر
function applyDiscountToItem(row, offer, originalPrice) {
    const discountInput = row.find('.discount-value');
    const discountTypeSelect = row.find('.discount-type');
    const currentDiscount = parseFloat(discountInput.val()) || 0;
    
    let newDiscount = 0;
    if (parseInt(offer.discount_type) === 1) { // مبلغ ثابت
        newDiscount = parseFloat(offer.discount_value);
    } else { // نسبة مئوية
        newDiscount = (originalPrice * parseFloat(offer.discount_value)) / 100;
    }
    
    // تطبيق الخصم
    discountInput.val(currentDiscount + newDiscount);
    discountTypeSelect.val('amount'); // نوع الخصم مبلغ
    
    // إضافة علامة على الخصم التلقائي
    if (!row.find('.offer-applied-badge').length) {
        discountInput.after(`
            <span class="badge bg-success offer-applied-badge" 
                  title="خصم تلقائي من عرض ${offer.name}">
                تلقائي
            </span>
        `);
    }
}

// استدعاء الدالة عند تغيير العميل أو المنتجات أو الكميات
$(document).on('change', '#clientSelect, .product-select, .quantity', function() {
    applyOffersToInvoice();
});

// عند تحميل الصفحة
$(document).ready(function() {
    // جلب بيانات المنتجات مرة واحدة
    productsData = @json($items->map(function($item) {
        
        return [
            'id' => $item->id,
            'category_id' => $item->category_id
        ];
    }));
   

    // تطبيق العروض عند التحميل إذا كان هناك عميل محدد
    if ($('#clientSelect').val()) {
        applyOffersToInvoice();
    }
});

// أحداث التغيير لحقول التسوية
$(document).on('input', 'input[name="adjustment_label"], input[name="adjustment_value"]', function() {
    updateAdjustmentDisplay();
    calculateGrandTotal();
});

$(document).on('change', 'select[name="adjustment_type"]', function() {
    calculateGrandTotal();
});

// عند تحميل الصفحة تطبيق التسوية إذا كانت موجودة
$(document).ready(function() {
    updateAdjustmentDisplay();
});
</script>
@endsection
