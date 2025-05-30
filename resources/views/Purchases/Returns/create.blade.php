@extends('master')

@section('title')
    انشاء مرتجع مشتريات
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0"> انشاء مرتجع مشتريات</h2>
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
        <form id="invoice-form" action="{{ route('ReturnsInvoice.store') }}" method="post">
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
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="fa fa-save"></i>حفظ
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

                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <span>المورد :</span>
                                            </div>
                                            <div class="col-md-6">
                                                <select class="form-control select2" id="clientSelect" name="supplier_id" required>
                                                    <option value="">اختر المورد</option>
                                                    @foreach ($suppliers as $supplier)
                                                        <option value="{{ $supplier->id }}">{{ $supplier->trade_name }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <a href="{{ route('SupplierManagement.create') }}" type="button"
                                                    class="btn btn-primary mr-1 mb-1 waves-effect waves-light">
                                                    <i class="fa fa-user-plus"></i>جديد
                                                </a>
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
                                                <span>رقم المرتجع :</span>
                                            </div>
                                            <div class="col-md-8">
                                                <label class="form-control"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span>تاريخ الارتجاع :</span>
                                            </div>
                                            <div class="col-md-8">
                                                <input class="form-control" type="date" name="date">
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
                                                    <input class="form-control" type="text" placeholder="بيانات إضافية">
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
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="item-row">
                                        <td style="width:18%">
                                            <select name="items[0][product_id]"
                                                class="form-control product-select select2">
                                                <option value="">اختر المنتج</option>
                                                @foreach ($items as $item)
                                                    <option value="{{ $item->id }}" data-price="{{ $item->price }}">
                                                        {{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="items[0][description]"
                                                class="form-control item-description">
                                        </td>
                                        <td>
                                            <input type="number" name="items[0][quantity]" class="form-control quantity"
                                                value="1" min="1" required>
                                        </td>
                                        <td>
                                            <input type="number" name="items[0][unit_price]" class="form-control price"
                                                step="0.01" required>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="number"  name="items[0][discount]"  class="form-control discount-value" value="0" min="0" step="0.01">
                                                <select name="items[0][discount_type]" class="form-control discount-type">
                                                    <option value="amount">ريال</option>
                                                    <option value="percentage">نسبة %</option>
                                                </select>
                                            </div>
                                        </td>
                                        
                                                                              <td data-label="الضريبة 1">
    <div class="input-group">
        <select name="items[0][tax_1]" class="form-control tax-select" data-target="tax_1"
            style="width: 150px;" onchange="updateHiddenInput(this)">
            <option value=""></option>
            @foreach ($taxs as $tax)
                <option value="{{ $tax->tax }}" data-id="{{ $tax->id }}" data-name="{{ $tax->name }}"
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
        <select name="items[0][tax_2]" class="form-control tax-select" data-target="tax_2"
            style="width: 150px;" onchange="updateHiddenInput(this)">
            <option value=""></option>
            @foreach ($taxs as $tax)
                <option value="{{ $tax->tax }}" data-id="{{ $tax->id }}" data-name="{{ $tax->name }}"
                    data-type="{{ $tax->type }}">
                    {{ $tax->name }}
                </option>
            @endforeach
        </select>
        <input type="hidden" name="items[0][tax_2_id]">
    </div>
</td>
                                        
                                        <td>
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
                                        <td colspan="9" class="text-right">
                                            <button type="button" id="add-row" class="btn btn-success">
                                                <i class="fa fa-plus"></i> إضافة صف
                                            </button>
                                        </td>
                                    </tr>
                                      @php
                                            $currency = $account_setting->currency ?? 'SAR';
                                            $currencySymbol = $currency == 'SAR' || empty($currency) ? '<img src="' . asset('assets/images/Saudi_Riyal.svg') . '" alt="ريال سعودي" width="15" style="vertical-align: middle;">' : $currency;
                                        @endphp
                                    <tr>
                                        <td colspan="7" class="text-right">المجموع الفرعي</td>
                                        <td><span id="subtotal">0.00</span> {!! $currencySymbol !!}</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" class="text-right">مجموع الخصومات</td>
                                        <td>
                                            <span id="total-discount">0.00</span>{!! $currencySymbol !!}
                                            <span id="discount-type-label"></span>
                                        </td>
                                        <td></td>
                                    </tr>
                                     <tr>
                                        <small id="tax-details"></small> <!-- مكان عرض تفاصيل الضرائب -->
                                    </tr>
                                    <tr>
                                        <td colspan="7" class="text-right">تكلفة الشحن</td>
                                        <td><span id="shipping-cost">0.00</span> {!! $currencySymbol !!}</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" class="text-right">الدفعة القادمة</td>
                                        <td><span id="next-payment">0.00</span> {!! $currencySymbol !!}</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" class="text-right">المجموع الكلي</td>
                                        <td><span id="grand-total">0.00</span> {!! $currencySymbol !!}</td>
                                        <td></td>
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
                                    <input type="number" name="discount_amount" class="form-control" value="0" min="0" step="0.01">
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
                        <div class="card mt-3">
                            <div class="card-body py-2 align-items-right">
                                <div class="d-flex justify-content-start" style="direction: rtl;">
                                    <div class="form-check">
                                        <input class="form-check-input toggle-check" type="checkbox" name="is_paid" value="1">
                                        <label class="form-check-label">
                                            مدفوع بالفعل
                                        </label>
                                    </div>
                                </div>

                                <!-- حقول الدفع (مخفية بشكل افتراضي) -->
                                <div class="payment-fields mt-3" style="display: none;">
                                    <div class="row">
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
                                <input type="number" class="form-control" name="shipping_cost" id="shipping" value="0" min="0"
                                    step="0.01">
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
                                تم الدفع ب الفعل الى المورد؟
                            </label>
                        </div>
                    </div>

                    <!-- حقول الدفع (مخفية بشكل افتراضي) -->
                    <div class="payment-fields mt-3" style="display: none;">
                        <div class="row">
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
                <div class="card-body py-2 align-items-right">
                    <div class="d-flex justify-content-start" style="direction: rtl;">
                        <div class="form-check">
                            <input class="form-check-input toggle-check" type="checkbox">
                            <label class="form-check-label">
                                مستلم
                            </label>
                        </div>
                    </div>

                    <!-- حقول الدفع (مخفية بشكل افتراضي) -->
                    <div class="payment-fields mt-3" style="display: none;">
                        <div class="row">

                            <div class="col-md-4">
                                <label class="form-label">تاريخ الاستلام</label>
                                <input type="date" class="form-control" name="received_date">
                            </div>
                        </div>
                    </div>
                </div>
            </div>




        </form>
    </div>
    </div>
    </div>

    <!------------------------->


    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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



document.addEventListener('change', function (e) {
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
        document.querySelectorAll(".item-row").forEach(function (row) {
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



document.addEventListener("DOMContentLoaded", function () {
    function calculateTotals() {
        let subtotal = 0; // المجموع الفرعي (بدون ضريبة)
        let grandTotal = 0; // المجموع الكلي
        let taxDetails = {}; // تفاصيل الضرائب المختارة

        // مسح صفوف الضرائب السابقة
        document.querySelectorAll(".dynamic-tax-row").forEach(row => row.remove());

        document.querySelectorAll(".item-row").forEach(function (row) {
            let quantity = parseFloat(row.querySelector(".quantity").value) || 0;
            let unitPrice = parseFloat(row.querySelector(".price").value) || 0;
            let itemTotal = quantity * unitPrice; // هذا هو المجموع الكلي للعنصر
            subtotal += itemTotal; // إضافة إلى المجموع الفرعي

            // حساب الضرائب
            let tax1Value = parseFloat(row.querySelector("[name^='items'][name$='[tax_1]']").value) || 0;
            let tax1Type = row.querySelector("[name^='items'][name$='[tax_1]']").options[row.querySelector("[name^='items'][name$='[tax_1]']").selectedIndex].dataset.type;
            let tax1Name = row.querySelector("[name^='items'][name$='[tax_1]']").options[row.querySelector("[name^='items'][name$='[tax_1]']").selectedIndex].dataset.name;

            let tax2Value = parseFloat(row.querySelector("[name^='items'][name$='[tax_2]']").value) || 0;
            let tax2Type = row.querySelector("[name^='items'][name$='[tax_2]']").options[row.querySelector("[name^='items'][name$='[tax_2]']").selectedIndex].dataset.type;
            let tax2Name = row.querySelector("[name^='items'][name$='[tax_2]']").options[row.querySelector("[name^='items'][name$='[tax_2]']").selectedIndex].dataset.name;

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
        document.getElementById("grand-total").innerText = (subtotal + Object.values(taxDetails).reduce((a, b) => a + b, 0)).toFixed(2);

        // إرسال الضرائب إلى الكنترولر
        let taxes = [];
        for (let taxName in taxDetails) {
            taxes.push({
                name: taxName,
                value: taxDetails[taxName],
            });
        }

        // إضافة الضرائب إلى بيانات الفاتورة
     document.querySelector("form").addEventListener("submit", function (e) {
    e.preventDefault();

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
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
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
    document.addEventListener("input", function (event) {
        if (event.target.matches(".quantity, .price, .tax-select")) {
            calculateTotals();
        }
    });

    // حساب القيم عند تحميل الصفحة
    calculateTotals();
});


    </script>
@endsection
