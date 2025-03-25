<?php $__env->startSection('title'); ?>
    عرض طلب عرض سعر
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">عرض طلب عرض سعر</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo e(route('Quotations.index')); ?>">طلبات عروض الأسعار</a></li>
                            <li class="breadcrumb-item active">عرض</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->make('layouts.alerts.error', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('layouts.alerts.success', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="card">
        <div class="card-body p-1">
            <div class="d-flex justify-content-between align-items-center">
                <!-- الجانب الأيمن - حالة الطلب والرقم -->
                <div class="d-flex align-items-center gap-3">
                    <h5 class="mb-0">طلب عرض سعر <?php echo e($purchaseQuotation->id); ?> #<?php echo e($purchaseQuotation->code); ?></h5>
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-circle text-warning" style="font-size: 8px;"></i>
                        <?php if($purchaseQuotation->status == 1): ?>
                            <span class="badge bg-warning">تحت المراجعة </span>
                        <?php elseif($purchaseQuotation->status == 2): ?>
                            <span class="badge bg-success">تم الموافقة علية </span>
                        <?php elseif($purchaseQuotation->status == 3): ?>
                            <span class="badge bg-danger">مرفوض</span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- الجانب الأيسر - أزرار الموافقة والرفض -->
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-exchange-alt me-1"></i>
                        تحويل إلى عرض مشتريات
                    </button>
                    <ul class="dropdown-menu">
                        <?php $__empty_1 = true; $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div><?php echo e($supplier->name); ?></div>
                                            <small class="text-muted"><?php echo e($supplier->trade_name); ?></small>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <li>
                                <span class="dropdown-item text-muted">
                                    لا يوجد موردين
                                </span>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-title p-2 d-flex align-items-center gap-2">
            <a href="<?php echo e(route('Quotations.edit', $purchaseQuotation->id)); ?>" class="btn btn-outline-primary btn-sm">
                تعديل <i class="fa fa-edit ms-1"></i>
            </a>
            <div class="vr"></div>

            <a href="<?php echo e(route('Quotations.duplicate', $purchaseQuotation->id)); ?>" class="btn btn-outline-info btn-sm">
                نسخ <i class="fa fa-copy ms-1"></i>
            </a>
            <div class="vr"></div>

            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
                data-bs-target="#deleteModal">
                حذف <i class="fa fa-trash ms-1"></i>
            </button>
            <div class="vr"></div>

            <div class="dropdown">
                <button class="btn btn-outline-dark btn-sm" type="button" id="printDropdown" data-bs-toggle="dropdown">
                    طباعة <i class="fa fa-print ms-1"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="">
                            <i class="fa fa-file-pdf me-2 text-danger"></i>PDF طباعة</a></li>
                    <li><a class="dropdown-item" href="">
                            <i class="fa fa-file-excel me-2 text-success"></i>Excel تصدير</a></li>
                </ul>
            </div>
        </div>

        <div class="card-body">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#details" role="tab">التفاصيل</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#suppliers" role="tab">الموردين</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#products" role="tab">المنتجات</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#activity" role="tab">سجل النشاطات</a>
                </li>
            </ul>

            <div class="tab-content p-3">
                <!-- تبويب التفاصيل -->
                <div class="tab-pane active" id="details" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="text-start" style="width: 50%">
                                        <div class="mb-2">
                                            <label class="text-muted">رقم الطلب:</label>
                                            <div><?php echo e($purchaseQuotation->code); ?></div>
                                        </div>
                                        <div class="mb-2">
                                            <label class="text-muted">تاريخ الطلب:</label>
                                            <div><?php echo e($purchaseQuotation->order_date); ?></div>
                                        </div>
                                        <div class="mb-2">
                                            <label class="text-muted">منشئ الطلب:</label>
                                            <div><?php echo e($purchaseQuotation->creator->name ?? 'غير محدد'); ?></div>
                                        </div>
                                    </td>
                                    <td class="text-start" style="width: 50%">
                                        <div class="mb-2">
                                            <label class="text-muted">تاريخ الاستحقاق:</label>
                                            <div><?php echo e($purchaseQuotation->due_date ?? 'غير محدد'); ?></div>
                                        </div>
                                        <div class="mb-2">
                                            <label class="text-muted">عدد المنتجات:</label>
                                            <div><?php echo e($purchaseQuotation->items->count()); ?></div>
                                        </div>
                                        <div class="mb-2">
                                            <label class="text-muted">الملاحظات:</label>
                                            <div><?php echo e($purchaseQuotation->notes ?? 'لا توجد ملاحظات'); ?></div>
                                        </div>
                                        <div class="mb-2">
                                            <label class="text-muted">المرفقات:</label>
                                            <?php if($purchaseQuotation->attachments): ?>
                                                <div><a href="<?php echo e(asset('storage/' . $purchaseQuotation->attachments)); ?>"
                                                        target="_blank">عرض المرفق</a></div>
                                            <?php else: ?>
                                                <div>لا توجد مرفقات</div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- تبويب الموردين -->
                <div class="tab-pane" id="suppliers" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>اسم المورد</th>
                                    <th>الاسم التجاري</th>
                                    <th>رقم الهاتف</th>
                                    <th>البريد الإلكتروني</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $purchaseQuotation->suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($loop->iteration); ?></td>
                                        <td><?php echo e($supplier->name); ?></td>
                                        <td><?php echo e($supplier->trade_name); ?></td>
                                        <td><?php echo e($supplier->phone); ?></td>
                                        <td><?php echo e($supplier->email); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- تبويب المنتجات -->


                <!-- تبويب سجل النشاطات -->
                
            </div>
        </div>
    </div>

    <!-- Modal Delete -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">حذف طلب عرض السعر</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>هل أنت متأكد من حذف طلب عرض السعر رقم "<?php echo e($purchaseQuotation->code); ?>"؟</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                    <form action="<?php echo e(route('Quotations.destroy', $purchaseQuotation->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger">حذف</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/Purchases/Quotations/show.blade.php ENDPATH**/ ?>