<?php $__env->startSection('title'); ?>
    انشاء فاتورة مبيعات
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <style>
        @media (max-width: 767.98px) {
            #items-table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }

            #clientSelect option[selected] {
                font-weight: bold;
                background-color: #f8f9fa;
            }

            select.form-control {
                -webkit-appearance: menulist;
                -moz-appearance: menulist;
                appearance: menulist;
                height: auto;
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

        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
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
        <form id="invoiceForm" action="<?php echo e(route('invoices.store')); ?>" method="post">
            <?php echo csrf_field(); ?>
            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="alert alert-danger">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

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
                                                <select class="form-control select2" id="clientSelect" name="client_id" required>
                                                    <option value="">اختر العميل</option>
                                                    <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($c->id); ?>"
                                                            <?php echo e((isset($client_id) && $client_id == $c->id) || (isset($client) && $client->id == $c->id) ? 'selected' : ''); ?>>
                                                            <?php echo e($c->trade_name); ?> - الرصيد الافتتاحي: <?php echo e(number_format($c->opening_balance, 2)); ?> ريال <?php echo e($c->code ?? ""); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>


                                            </div>
                                            <input type="hidden" id="client_id_hidden" name="client_id" value="">
                                            <div class="col-md-4">
                                                <a href="<?php echo e(route('clients.create')); ?>" type="button"
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
                                                    <?php $__currentLoopData = $price_lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $price_list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($price_list->id); ?>"><?php echo e($price_list->name ?? ''); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                                <label class="form-control"><?php echo e($invoice_number); ?></label>
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
                                                    value="<?php echo e(old('invoice_date', date('Y-m-d'))); ?>">
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
                                                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($employee->id); ?>"><?php echo e($employee->full_name); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                                    value="<?php echo e(old('issue_date', date('Y-m-d'))); ?>">
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
                        <input type="hidden" id="products-data" value="<?php echo e(json_encode($items)); ?>">
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
                                                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($item->id); ?>"
                                                        data-price="<?php echo e($item->sale_price); ?>"><?php echo e($item->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                                    <?php $__currentLoopData = $taxs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($tax->tax); ?>"
                                                            data-id="<?php echo e($tax->id); ?>"
                                                            data-name="<?php echo e($tax->name); ?>"
                                                            data-type="<?php echo e($tax->type); ?>">
                                                            <?php echo e($tax->name); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                                    <?php $__currentLoopData = $taxs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($tax->tax); ?>"
                                                            data-id="<?php echo e($tax->id); ?>"
                                                            data-name="<?php echo e($tax->name); ?>"
                                                            data-type="<?php echo e($tax->type); ?>">
                                                            <?php echo e($tax->name); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                    <?php
                                        $currencySymbol =
                                            '<img src="' .
                                            asset('assets/images/Saudi_Riyal.svg') .
                                            '" alt="ريال سعودي" width="13" style="display: inline-block; margin-left: 5px; vertical-align: middle;">';
                                    ?>
                                    <!-- Other rows -->
                                    <tr>
                                        <td colspan="7" class="text-right">المجموع الفرعي</td>
                                        <td><span id="subtotal">0.00</span><?php echo $currencySymbol; ?></td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td colspan="7" class="text-right">مجموع الخصومات</td>
                                        <td>
                                            <span id="total-discount">0.00</span>
                                            <span id="discount-type-label"><?php echo $currencySymbol; ?></span>
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
                                            <span id="grand-total">0.00</span><?php echo $currencySymbol; ?>

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
                                    <?php $__currentLoopData = $treasury; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $treasur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($treasur->id); ?>"><?php echo e($treasur->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="<?php echo e(asset('assets/js/invoice.js')); ?>"></script>
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
                    <span>${taxDetails[taxName].toFixed(2)}</span><?php echo $currencySymbol; ?>

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
            <?php if(isset($client_id)): ?>
                $('#clientSelect').val('<?php echo e($client_id); ?>').trigger('change');
            <?php endif; ?>

            // أو إذا كان هناك كائن عميل
            <?php if(isset($client) && $client): ?>
                $('#clientSelect').val('<?php echo e($client->id); ?>').trigger('change');
            <?php endif; ?>
        });
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
function applyOffersToInvoice() {
    const clientId = parseInt($('#clientSelect').val());
    const today = new Date().toISOString().split('T')[0];
    let hasOffers = false;

    // مسح الخصومات السابقة من العروض
    $('.offer-applied-badge').remove();
    $('.item-row').each(function() {
        $(this).find('.discount-value').val(0).trigger('change');
    });

    // جلب العروض النشطة من السيرفر
    $.ajax({
        url: '/clients/offers/active-offers',
        method: 'GET',
        data: {
            client_id: clientId,
            date: today
        },
      success: function(offers) {
    // تحويل clientId إلى رقم لضمان المقارنة الصحيحة
    const clientId = parseInt($('#clientSelect').val());
    
    $('.item-row').each(function() {
        const productId = parseInt($(this).find('.product-select').val());
        const quantity = parseInt($(this).find('.quantity').val());
        const price = parseFloat($(this).find('.price').val()) || 0;

        if (!productId) return;

        // جلب معلومات المنتج (التصنيف)
        const product = productsData.find(p => p.id == productId);
        const categoryId = product ? parseInt(product.category_id) : null;

        offers.forEach(offer => {
            // تحسين معالجة بيانات العرض
            const convertedOffer = {
                ...offer,
                // معالجة خاصة للعملاء - تحويل جميع الحالات إلى أرقام
                clients: Array.isArray(offer.clients) 
                    ? offer.clients.map(c => {
                        if (c === null || c === undefined) return null;
                        return typeof c === 'object' ? parseInt(c.id) : parseInt(c);
                    }).filter(id => !isNaN(id)) // إزالة أي قيم غير رقمية
                    : [],
                
                // نفس المعالجة للمنتجات والتصنيفات
                products: Array.isArray(offer.products) 
                    ? offer.products.map(p => typeof p === 'object' ? parseInt(p.id) : parseInt(p))
                    : [],
                categories: Array.isArray(offer.categories) 
                    ? offer.categories.map(cat => typeof cat === 'object' ? parseInt(cat.id) : parseInt(cat))
                    : []
            };

            // إضافة console.log للتصحيح
            console.log('Checking offer:', {
                offer: convertedOffer,
                clientId: clientId,
                productId: productId,
                categoryId: categoryId,
                quantity: quantity
            });

            if (checkOfferConditions(convertedOffer, clientId, productId, categoryId, quantity)) {
                applyDiscountToItem($(this), convertedOffer, price);
                hasOffers = true;
            }
        });
    });

    if (hasOffers) {
        toastr.success('تم تطبيق العروض التلقائية بنجاح');
    }
}
    });
}
// دالة التحقق من شروط العرض (معدلة)


// في دالة applyOffersToInvoice:

// دالة التحقق من شروط العرض (معدلة)
function checkOfferConditions(offer, clientId, productId, categoryId, quantity) {
    // تحويل جميع IDs إلى أرقام لضمان المقارنة الصحيحة
    clientId = parseInt(clientId);
    productId = parseInt(productId);
    categoryId = parseInt(categoryId);
    quantity = parseInt(quantity);

    // 1. التحقق من العميل (الإصلاح الرئيسي هنا)
    if (offer.clients && offer.clients.length > 0) {
        // تحويل جميع هويات عملاء العرض إلى أرقام
        const offerClientIds = offer.clients.map(c => {
            return typeof c === 'object' ? parseInt(c.id) : parseInt(c);
        });

        if (!offerClientIds.includes(clientId)) {
            return false;
        }
    }

    // 2. التحقق من نوع الوحدة
    switch (parseInt(offer.unit_type)) {
        case 1: break; // الكل
        case 2: // التصنيف
            if (!offer.categories || !offer.categories.map(c => parseInt(c.id || c)).includes(categoryId)) {
                return false;
            }
            break;
        case 3: // المنتجات
            if (!offer.products || !offer.products.map(p => parseInt(p.id || p)).includes(productId)) {
                return false;
            }
            break;
    }

    // 3. التحقق من الكمية المطلوبة
    if (parseInt(offer.type) == 2 && quantity < parseInt(offer.quantity)) {
        return false;
    }

    return true;
}

// دالة التحقق من شروط العرض
// function checkOfferConditions(offer, clientId, productId, categoryId, quantity) {
  

//     // 1. التحقق من العميل
//     if (offer.clients.length > 0 && !offer.clients.includes(parseInt(clientId))) {
//         return false;
//     }

//     // 2. التحقق من نوع الوحدة
//     switch (offer.unit_type) {
//         case 1: break; // الكل
//         case 2: // التصنيف
//             if (!offer.categories.includes(categoryId)) return false;
//             break;
//         case 3: // المنتجات
//             if (!offer.products.includes(productId)) return false;
//             break;
//     }

//     // 3. التحقق من الكمية المطلوبة
//     if (offer.type == 2 && quantity < offer.quantity) {
//         return false;
//     }

//     return true;
// }

// دالة تطبيق الخصم على العنصر
function applyDiscountToItem(row, offer, originalPrice) {
    const discountInput = row.find('.discount-value');
    const discountTypeSelect = row.find('.discount-type');
    const currentDiscount = parseFloat(discountInput.val()) || 0;
    let newDiscount = 0;

    // حساب الخصم حسب النوع
    if (offer.discount_type == 1) { // مبلغ ثابت
        newDiscount = offer.discount_value;
    } else { // نسبة مئوية
        newDiscount = (originalPrice * offer.discount_value) / 100;
    }

    // إضافة الخصم الجديد إلى الخصم الحالي
    discountInput.val(currentDiscount + newDiscount).trigger('change');
    discountTypeSelect.val('amount'); // جعل نوع الخصم "مبلغ" بعد التطبيق

    // إضافة بادج للإشارة إلى الخصم التلقائي
    // row.find('.discount-value').after(`
    //     <small class="text-success offer-applied-badge" 
    //             title="خصم تلقائي من عرض ${offer.name}">
    //         (تلقائي)
    //     </small>
    // `);
}

// استدعاء الدالة عند تغيير العميل أو المنتجات أو الكميات
$(document).on('change', '#clientSelect, .product-select, .quantity', function() {
    applyOffersToInvoice();
});

// عند تحميل الصفحة
$(document).ready(function() {
    // جلب بيانات المنتجات مرة واحدة
    productsData = <?php echo json_encode($items->map(function($item) {
        
        return [
            'id' => $item->id, 'category_id' => $item->category_id
        ];
    }), 512) ?>;
   

    // تطبيق العروض عند التحميل إذا كان هناك عميل محدد
    if ($('#clientSelect').val()) {
        applyOffersToInvoice();
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/sales/invoices/create.blade.php ENDPATH**/ ?>