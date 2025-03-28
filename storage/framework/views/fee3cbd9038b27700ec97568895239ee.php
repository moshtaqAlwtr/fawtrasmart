<?php $__env->startSection('title'); ?>
    مدفوعات المورين
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">ادارة مدفوعات الموردين </h2>
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
    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>
    <div class="content-body">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
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
                    <form class="form" method="GET" action="<?php echo e(route('PaymentSupplier.indexPurchase')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="form-body row">
                            <div class="form-group col-md-4">
                                <label for="invoice_number">رقم الفاتورة</label>
                                <input type="text" id="invoice_number" class="form-control" placeholder="رقم الفاتورة"
                                    name="invoice_number" value="<?php echo e(request('invoice_number')); ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="payment_number">رقم عملية الدفع</label>
                                <input type="text" id="payment_number" class="form-control" placeholder="رقم عملية الدفع"
                                    name="payment_number" value="<?php echo e(request('payment_number')); ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="customer_id">اي العميل</label>
                                <select name="customer_id" class="form-control" id="customer_id">
                                    <option value="">اي العميل</option>
                                    <!-- Add your customers loop here -->
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="payment_method">وسيلة دفع</label>
                                <select name="payment_method" class="form-control" id="payment_method">
                                    <option value="">اي وسيلة دفع</option>
                                    <option value="1" <?php echo e(request('payment_method') == '1' ? 'selected' : ''); ?>>نقدي</option>
                                    <option value="0" <?php echo e(request('payment_method') == '0' ? 'selected' : ''); ?>>شيك</option>
                                    <option value="2" <?php echo e(request('payment_method') == '2' ? 'selected' : ''); ?>>تحويل بنكي</option>
                                    <option value="3" <?php echo e(request('payment_method') == '3' ? 'selected' : ''); ?>>اون لاين</option>
                                    <option value="4" <?php echo e(request('payment_method') == '4' ? 'selected' : ''); ?>>اخرى</option>
                                </select>
                            </div>
                        </div>

                        <div class="collapse <?php echo e(request()->hasAny(['date_type', 'from_date', 'to_date', 'total_min', 'total_max', 'payment_status', 'creation_date_type', 'creation_from_date', 'creation_to_date', 'created_by']) ? 'show' : ''); ?>" id="advancedSearchForm">
                            <div class="form-body row d-flex align-items-center g-2">
                                <div class="form-group col-md-1">
                                    <label for="date_type">تاريخ</label>
                                    <select name="date_type" class="form-control" id="date_type">
                                        <option value="">تخصيص</option>
                                        <option value="1" <?php echo e(request('date_type') == '1' ? 'selected' : ''); ?>>شهرياً</option>
                                        <option value="0" <?php echo e(request('date_type') == '0' ? 'selected' : ''); ?>>أسبوعياً</option>
                                        <option value="2" <?php echo e(request('date_type') == '2' ? 'selected' : ''); ?>>يومياً</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="from_date">من (التاريخ)</label>
                                    <input type="date" id="from_date" class="form-control" style="margin-left: 20px"
                                        name="from_date" value="<?php echo e(request('from_date')); ?>">
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="to_date">الى (التاريخ)</label>
                                    <input type="date" id="to_date" class="form-control"
                                        name="to_date" value="<?php echo e(request('to_date')); ?>">
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="total_min">الاجمالي اكبر من</label>
                                    <input type="number" id="total_min" class="form-control" placeholder="الاجمالي اكبر من"
                                        name="total_min" value="<?php echo e(request('total_min')); ?>">
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="total_max">الاجمالي اصغر من</label>
                                    <input type="number" id="total_max" class="form-control" placeholder="الاجمالي اصغر من"
                                        name="total_max" value="<?php echo e(request('total_max')); ?>">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="payment_status">حالة الدفع</label>
                                    <select name="payment_status" class="form-control" id="payment_status">
                                        <option value=""> اختر حالة الدفع</option>
                                        <option value="1" <?php echo e(request('payment_status') == '1' ? 'selected' : ''); ?>>تحت المراجعة </option>
                                        <option value="2" <?php echo e(request('payment_status') == '2' ? 'selected' : ''); ?>>مكتمل </option>
                                        <option value="3" <?php echo e(request('payment_status') == '3' ? 'selected' : ''); ?>>غير مكتمل </option>
                                        <option value="4" <?php echo e(request('payment_status') == '4' ? 'selected' : ''); ?>>فاشلة</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-body row d-flex align-items-center g-2">
                                <div class="form-group col-md-1">
                                    <label for="creation_date_type">تاريخ الانشاء</label>
                                    <select name="creation_date_type" class="form-control" id="creation_date_type">
                                        <option value="">تخصيص</option>
                                        <option value="1" <?php echo e(request('creation_date_type') == '1' ? 'selected' : ''); ?>>شهرياً</option>
                                        <option value="0" <?php echo e(request('creation_date_type') == '0' ? 'selected' : ''); ?>>أسبوعياً</option>
                                        <option value="2" <?php echo e(request('creation_date_type') == '2' ? 'selected' : ''); ?>>يومياً</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="creation_from_date">من (التاريخ)</label>
                                    <input type="date" id="creation_from_date" class="form-control" style="margin-left: 20px"
                                        name="creation_from_date" value="<?php echo e(request('creation_from_date')); ?>">
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="creation_to_date">الى (التاريخ)</label>
                                    <input type="date" id="creation_to_date" class="form-control"
                                        name="creation_to_date" value="<?php echo e(request('creation_to_date')); ?>">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="created_by">منشئ الفاتورة</label>
                                    <select name="created_by" class="form-control" id="created_by">
                                        <option value="">منشئ الفاتورة</option>
                                        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($employee->id); ?>" <?php echo e(request('created_by') == $employee->id ? 'selected' : ''); ?>>
                                                <?php echo e($employee->full_name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                            <a href="<?php echo e(route('PaymentSupplier.indexPurchase')); ?>" type="reset" class="btn btn-outline-warning waves-effect waves-light">إلغاء</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card">
            <!-- بداية الصف -->
            <div class="card-body">
                <?php $__currentLoopData = $payments->where('type', 'supplier payments'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="row border-bottom py-2 align-items-center">
                        <div class="col-md-4">
                            <p class="mb-"><strong>#<?php echo e($payment->id); ?></strong> </p>
                            <small class="text-muted">#<?php echo e($payment->invoice->invoice_number ?? ''); ?> ملاحظات:
                                <?php echo e($payment->notes); ?></small>
                        </div>
                        <div class="col-md-3">
                            <p class="mb-0"><small><?php echo e($payment->payment_date); ?></small></p>
                            <small class="text-muted">بواسطة: <?php echo e($payment->employee->full_name ?? ''); ?></small>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="d-flex flex-column align-items-center gap-2">
                                <strong class="text-danger fs-5"><?php echo e(number_format($payment->amount, 2)); ?> ر.س</strong>

                                <span
                                    class="badge rounded-pill px-3 py-2
                                    <?php if($payment->payment_status == 1): ?> bg-warning text-dark
                                    <?php elseif($payment->payment_status == 2): ?>
                                        bg-success text-white
                                    <?php elseif($payment->payment_status == 3): ?>
                                        bg-info text-white
                                    <?php elseif($payment->payment_status == 4): ?>
                                        bg-danger text-white
                                    <?php elseif($payment->payment_status == 5): ?>
                                        bg-secondary text-white
                                    <?php else: ?>
                                        bg-light text-dark <?php endif; ?>">
                                    <i
                                        class="fas
                                        <?php if($payment->payment_status == 1): ?> fa-clock
                                        <?php elseif($payment->payment_status == 2): ?>
                                            fa-check-circle
                                        <?php elseif($payment->payment_status == 3): ?>
                                            fa-sync
                                        <?php elseif($payment->payment_status == 4): ?>
                                            fa-times-circle
                                        <?php elseif($payment->payment_status == 5): ?>
                                            fa-file-alt
                                        <?php else: ?>
                                            fa-question-circle <?php endif; ?> me-1">
                                    </i>
                                    <?php echo e($payment->payment_status == 1
                                        ? 'تحت المراجعة '
                                        : ($payment->payment_status == 2
                                            ? 'مكتمل'
                                            : ($payment->payment_status == 3
                                                ? 'غير مكتمل '
                                                : ($payment->payment_status == 4
                                                    ? 'فاشلة'
                                                    : ($payment->payment_status == 5
                                                        ? 'مسودة'
                                                        : 'غير معروف'))))); ?>

                                </span>
                            </div>
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
                                                href="<?php echo e(route('PaymentSupplier.showSupplierPayment', $payment->id)); ?>">
                                                <i class="fa fa-eye me-2 text-primary"></i>عرض
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="<?php echo e(route('PaymentSupplier.editSupplierPayment', $payment->id)); ?>">
                                                <i class="fa fa-edit me-2 text-success"></i>تعديل
                                            </a>
                                        </li>
                                        <form action="<?php echo e(route('paymentsClient.destroy', $payment->id)); ?>"
                                            method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>

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
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/Purchases/Supplier_Payments/index.blade.php ENDPATH**/ ?>