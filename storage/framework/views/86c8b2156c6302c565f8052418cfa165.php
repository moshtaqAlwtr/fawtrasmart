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
                                                <select class="form-control select2" id="clientSelect" name="client_id"
                                                    required>
                                                    <option value="">اختر العميل </option>
                                                    <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($client->id); ?>"><?php echo e($client->trade_name); ?>

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
                                            <select name="items[0][product_id]" class="form-control product-select"
                                                required>
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
                                        </td <input type="hidden" name="items[0][store_house_id]" value="">
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
        document.addEventListener("DOMContentLoaded", function() {
            // =============== المتغيرات الأساسية ===============
            const clientSelect = document.getElementById("clientSelect");
            const saveButton = document.getElementById("saveInvoice");
            const invoiceForm = document.getElementById("invoiceForm");
            const itemsTable = document.getElementById("items-table");
            const clientIdHidden = document.getElementById("client_id_hidden");

            // =============== الأحداث الأساسية ===============
            saveButton.addEventListener("click", handleSaveInvoice);
            itemsTable.addEventListener("input", calculateTotals);

            // =============== معالجة الحفظ ===============
            function handleSaveInvoice(event) {
                event.preventDefault();
                if (validateRequiredFields()) {
                    const clientId = clientSelect.value;
                    verifyClient(clientId);
                }
            }

            // =============== التحقق من الحقول الإلزامية ===============
            function validateRequiredFields() {
                clearErrorStyles();
                let isValid = true;

                // 1. التحقق من العميل
                if (!clientSelect.value) {
                    markFieldAsError(clientSelect);
                    showErrorAlert("الرجاء اختيار عميل من القائمة");
                    return false;
                }

                // 2. التحقق من الصفوف
                const rows = document.querySelectorAll(".item-row");
                let hasValidRow = false;

                rows.forEach((row, index) => {
                    const productSelect = row.querySelector(".product-select");
                    const quantityInput = row.querySelector(".quantity");
                    const priceInput = row.querySelector(".price");

                    if (productSelect.value) {
                        if (!validateField(quantityInput, `الرجاء إدخال كمية صحيحة للصف ${index + 1}`) ||
                            !validateField(priceInput, `الرجاء إدخال سعر صحيح للصف ${index + 1}`)) {
                            isValid = false;
                        } else {
                            hasValidRow = true;
                        }
                    }
                });

                if (!hasValidRow) {
                    const firstProduct = document.querySelector(".item-row .product-select");
                    markFieldAsError(firstProduct);
                    showErrorAlert("الرجاء إدخال منتج واحد على الأقل مع الكمية والسعر");
                    return false;
                }

                return isValid;
            }

            function validateField(input, errorMessage) {
                if (!input.value || input.value <= 0) {
                    markFieldAsError(input);
                    showErrorAlert(errorMessage);
                    return false;
                }
                return true;
            }

            // =============== التحقق من العميل ===============
            function verifyClient(clientId) {
                fetch(`/sales/invoices/get-client/${clientId}`)
                    .then(response => {
                        if (!response.ok) throw new Error("فشل في جلب بيانات العميل");
                        return response.json();
                    })
                    .then(client => {
                        showVerificationDialog(client, clientId);
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        showErrorAlert("تعذر جلب بيانات العميل");
                    });
            }

            function showVerificationDialog(client, clientId) {
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

            // =============== إدارة الصفوف ===============
            $(document).ready(function() {
                initializeEvents();

                $(document).on('click', '.add-row', function() {
                    const lastRow = $('.item-row').last();
                    const newRow = lastRow.clone();
                    const rowIndex = $('.item-row').length;

                    resetRowValues(newRow);
                    updateRowFieldNames(newRow, rowIndex);
                    newRow.appendTo('tbody');
                    initializeEvents();
                });
            });

            function resetRowValues(row) {
                row.find('input, select').val('');
                row.find('.row-total').text('0.00');
            }

            function updateRowFieldNames(row, index) {
                row.find('[name]').each(function() {
                    const name = $(this).attr('name').replace(/\[\d+\]/, '[' + index + ']');
                    $(this).attr('name', name);
                });
            }

            function initializeEvents() {
                $('.product-select, #price-list-select').off('change').on('change', handleProductChange);
                $('.tax-select').off('change').on('change', handleTaxChange);
            }

            // =============== معالجة التغييرات ===============
            function handleProductChange() {
                const priceListId = $('#price-list-select').val();
                const productId = $(this).closest('tr').find('.product-select').val();
                const priceInput = $(this).closest('tr').find('.price');

                if (priceListId && productId) {
                    fetchProductPrice(priceListId, productId, priceInput);
                } else {
                    const productPrice = $(this).find('option:selected').data('price');
                    if (productPrice) {
                        priceInput.val(productPrice);
                    }
                }
                calculateTotals();
            }

            function handleTaxChange() {
                updateHiddenTaxInput(this);
                calculateTotals();
            }

            function fetchProductPrice(priceListId, productId, priceInput) {
                $.ajax({
                    url: '/sales/invoices/get-price',
                    method: 'GET',
                    data: { price_list_id: priceListId, product_id: productId },
                    success: function(response) {
                        if (response.price) {
                            priceInput.val(response.price);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching price:", error);
                    }
                });
            }

            function updateHiddenTaxInput(selectElement) {
                const row = $(selectElement).closest('.item-row');
                const taxType = $(selectElement).data('target');
                const hiddenInput = row.find(`input[name$="[${taxType}_id]"]`);
                const selectedOption = selectElement.options[selectElement.selectedIndex];

                if (hiddenInput.length && selectedOption) {
                    hiddenInput.val(selectedOption.getAttribute('data-id'));
                }
            }

            // =============== حساب المجاميع والضرائب ===============
            function calculateTotals() {
                let subtotal = 0, totalTax = 0, grandTotal = 0;
                const taxDetails = {};

                $('.item-row').each(function() {
                    const row = $(this);
                    const qty = parseFloat(row.find('.quantity').val()) || 0;
                    const price = parseFloat(row.find('.price').val()) || 0;
                    const discountValue = parseFloat(row.find('.discount-value').val()) || 0;
                    const discountType = row.find('.discount-type').val();
                    const tax1 = parseFloat(row.find('.tax-1').val()) || 0;
                    const tax2 = parseFloat(row.find('.tax-2').val()) || 0;
                    const tax1Name = row.find('.tax-1 option:selected').data('name') || '';
                    const tax2Name = row.find('.tax-2 option:selected').data('name') || '';

                    // الحسابات الأساسية
                    let rowTotal = qty * price;
                    let discount = discountType === "percentage" ?
                        rowTotal * (discountValue / 100) : discountValue;

                    rowTotal -= discount;

                    // حساب الضرائب
                    const taxAmount = (rowTotal * (tax1 + tax2) / 100);
                    rowTotal += taxAmount;

                    // تحديث واجهة الصف
                    row.find('.row-total').text(rowTotal.toFixed(2));

                    // تجميع القيم
                    subtotal += (qty * price);
                    totalTax += taxAmount;
                    grandTotal += rowTotal;

                    // تجميع تفاصيل الضرائب
                    if (tax1 > 0) updateTaxDetails(taxDetails, tax1Name, tax1, qty * price);
                    if (tax2 > 0) updateTaxDetails(taxDetails, tax2Name, tax2, qty * price);
                });

                updateTaxRows(taxDetails);
                updateTotalsUI(subtotal, totalTax, grandTotal);
            }

            function updateTaxDetails(taxDetails, taxName, taxRate, amount) {
                if (!taxDetails[taxName]) {
                    taxDetails[taxName] = { rate: taxRate, amount: 0 };
                }
                taxDetails[taxName].amount += (amount * taxRate / 100);
            }

            function updateTaxRows(taxDetails) {
                $('#tax-rows .dynamic-tax-row').remove();

                for (const [taxName, taxInfo] of Object.entries(taxDetails)) {
                    const taxRow = `
                        <tr class="dynamic-tax-row">
                            <td colspan="7" class="text-right">${taxName} (${taxInfo.rate}%)</td>
                            <td>${taxInfo.amount.toFixed(2)}${currencySymbol}</td>
                        </tr>
                    `;
                    $('#tax-rows tr:last').before(taxRow);
                }
            }

            function updateTotalsUI(subtotal, totalTax, grandTotal) {
                $('#subtotal').text(subtotal.toFixed(2));
                $('#total-tax').text(totalTax.toFixed(2));
                $('#grand-total').text(grandTotal.toFixed(2));
            }

            // =============== أدوات مساعدة ===============
            function markFieldAsError(field) {
                $(field).addClass('required-error');
                field.focus();
            }

            function clearErrorStyles() {
                $('.required-error').removeClass('required-error');
            }

            function showErrorAlert(message) {
                Swal.fire({
                    icon: "error",
                    title: "خطأ",
                    text: message,
                    confirmButtonText: "حسناً",
                    customClass: { confirmButton: "btn btn-danger" }
                });
            }

            // =============== التهيئة الأولية ===============
            calculateTotals();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/sales/invoices/create.blade.php ENDPATH**/ ?>