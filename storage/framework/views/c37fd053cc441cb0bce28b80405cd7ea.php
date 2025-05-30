<?php $__env->startSection('title'); ?>
    انشاء فاتورة مرتجعة
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0"> انشاء فاتورة مرتجعة </h2>
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
        <form id="invoice-form" action="<?php echo e(route('ReturnIInvoices.store')); ?>" method="post">
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
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <span>العميل :</span>
                                            </div>
                                            <div class="col-md-6">
                                                <select class="form-control" id="clientSelect" name="payment">
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
                                                    <option value="">اختر العميل</option>
                                                    <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($client->id); ?>"
                                                            <?php echo e($client->id == $invoice->client_id ? 'selected' : ''); ?>>
                                                            <?php echo e($client->trade_name); ?> -  <?php echo e($client->code ?? ""); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>

                                            </div>
                                            <div class="col-md-4">
                                                <a href="<?php echo e(route('clients.create')); ?>" type="button"
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
                                                <span>رقم الفاتورة :</span>
                                            </div>
                                            <div class="col-md-8">
                                                <label class="form-control"></label>
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
                                                    value="<?php echo e(date('Y-m-d')); ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span>مسئول المبيعات :</span>
                                            </div>
                                            <div class="col-md-9">
                                                <select name="created_by" class="form-control" id="">
                                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
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
                                                    value="<?php echo e(date('Y-m-d')); ?>">
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
                <input type="hidden" name="invoice_id" value="<?php echo e($invoice->id); ?>">
            </div>
            <div class="card">
                <div class="card-content">
                    <div class="card-body">

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
                                    <?php $__currentLoopData = $invoice->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="item-row">
                                            <td style="width:18%">
                                                <select name="items[<?php echo e($index); ?>][product_id]"
                                                    class="form-control product-select">
                                                    <option value="">اختر المنتج</option>
                                                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($product->id); ?>"
                                                            <?php echo e($product->id == $item->product_id ? 'selected' : ''); ?>

                                                            data-price="<?php echo e($product->price); ?>">
                                                            <?php echo e($product->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="items[<?php echo e($index); ?>][description]"
                                                    class="form-control item-description"
                                                    value="<?php echo e($item->description); ?>">
                                            </td>
                                            <td>
                                                <input type="number" name="items[<?php echo e($index); ?>][quantity]"
                                                    class="form-control quantity" value="<?php echo e($item->quantity); ?>"
                                                    min="1" required>
                                            </td>
                                            <td>
                                                <input type="number" name="items[<?php echo e($index); ?>][unit_price]"
                                                    class="form-control price" step="0.01"
                                                    value="<?php echo e($invoice->items[$index]->unit_price); ?>" required>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="number" name="items[<?php echo e($index); ?>][discount]"
                                                        class="form-control discount-value" value="<?php echo e($item->discount); ?>"
                                                        min="0" step="0.01">
                                                    <select name="items[<?php echo e($index); ?>][discount_type]"
                                                        class="form-control discount-type">
                                                        <option value="amount"
                                                            <?php echo e($item->discount_type == 'amount' ? 'selected' : ''); ?>>ريال
                                                        </option>
                                                        <option value="percentage"
                                                            <?php echo e($item->discount_type == 'percentage' ? 'selected' : ''); ?>>
                                                            نسبة %</option>
                                                    </select>
                                                </div>
                                            </td>
                                            </td>
                                            <td data-label="الضريبة 1">
                                                <div class="input-group">
                                                    <select name="items[0][tax_1]" class="form-control tax-select"
                                                        data-target="tax_1" style="width: 150px;"
                                                        onchange="updateHiddenInput(this, 'taxOne_0')">
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
                                                    <input type="hidden" name="items[0][tax_1_id]" id="taxOne_0">
                                                </div>
                                            </td>

                                            <td data-label="الضريبة 2">
                                                <div class="input-group">
                                                    <select name="items[0][tax_2]" class="form-control tax-select"
                                                        data-target="tax_2" style="width: 150px;"
                                                        onchange="updateHiddenInput(this, 'taxTwo_0')">
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
                                                    <input type="hidden" name="items[0][tax_2_id]" id="taxTwo_0">
                                                </div>
                                            </td>

                                            <td>
                                                <span class="row-total"><?php echo e($item->total); ?></span>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm remove-row">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <tfoot id="tax-rows">
                                    <tr>
                                        <td colspan="9" class="text-right">
                                            <button type="button" id="add-row" class="btn btn-success">
                                                <i class="fa fa-plus"></i> إضافة صف
                                            </button>
                                        </td>
                                    </tr>
                                    <?php
                                        $currency = $account_setting->currency ?? 'SAR';
                                        $currencySymbol =
                                            $currency == 'SAR' || empty($currency)
                                                ? '<img src="' .
                                                    asset('assets/images/Saudi_Riyal.svg') .
                                                    '" alt="ريال سعودي" width="15" style="vertical-align: middle;">'
                                                : $currency;
                                    ?>
                                    <tr>
                                        <td colspan="7" class="text-right">المجموع الفرعي</td>
                                        <td><span id="subtotal">0.00</span> <?php echo $currencySymbol; ?></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" class="text-right">مجموع الخصومات</td>
                                        <td>
                                            <span id="total-discount">0.00</span><?php echo $currencySymbol; ?>

                                            <span id="discount-type-label"></span>
                                        </td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td>

                                            <small id="tax-details"></small> <!-- مكان عرض تفاصيل الضرائب -->
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" class="text-right">تكلفة الشحن</td>
                                        <td><span id="shipping-cost">0.00</span> <?php echo $currencySymbol; ?></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" class="text-right">الدفعة القادمة</td>
                                        <td><span id="next-payment">0.00</span> <?php echo $currencySymbol; ?></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" class="text-right">المجموع الكلي</td>
                                        <td><span id="grand-total">0.00</span> <?php echo $currencySymbol; ?></td>
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
                                تم دفع الفاتورة، وإعادة قيمة المبلغ المرتجع للعميل؟
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        function updateHiddenInput(selectElement, hiddenInputId) {
            var selectedOption = selectElement.options[selectElement.selectedIndex];
            document.getElementById(hiddenInputId).value = selectedOption.getAttribute('data-id');
        }
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
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/sales/retend_invoice/create.blade.php ENDPATH**/ ?>