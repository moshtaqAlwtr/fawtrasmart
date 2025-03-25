<?php $__env->startSection('title'); ?>
عرض  سعر الشراء
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0"> عرض  سعر الشراء</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo e(route('pricesPurchase.index')); ?>">عروض الأسعار</a></li>
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
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0">
                            أمر شراء #<?php echo e($purchaseQuotation->code); ?>

                            <?php if($purchaseQuotation->status == 1): ?>
                                <span class="badge bg-warning ms-2">تحت المراجعة</span>
                            <?php elseif($purchaseQuotation->status == 2): ?>
                                <span class="badge bg-success ms-2">معتمد</span>
                            <?php elseif($purchaseQuotation->status == 3): ?>
                                <span class="badge bg-danger ms-2">مرفوض</span>
                            <?php endif; ?>
                        </h5>
                    </div>


                </div>




                <div class="d-flex gap-3"> 
                    <?php if($purchaseQuotation->status == 1): ?>
                        
                        <form action="<?php echo e(route('pricesPurchase.updateStatus', $purchaseQuotation->id)); ?>" method="POST" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <input type="hidden" name="status" value="2">
                            <button type="submit" class="btn btn-success btn-lg px-4" style="height: 48px;">
                                <i class="fas fa-check me-1"></i>
                                موافقة
                            </button>
                        </form>

                        <form action="<?php echo e(route('pricesPurchase.updateStatus', $purchaseQuotation->id)); ?>" method="POST" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <input type="hidden" name="status" value="3">
                            <button type="submit" class="btn btn-danger btn-lg px-4" style="height: 48px;">
                                <i class="fas fa-times me-1"></i>
                                رفض
                            </button>
                        </form>
                    <?php elseif($purchaseQuotation->status == 2): ?>
                        <div class="dropdown">
                            <button class="btn btn-lg btn-primary px-4 d-flex align-items-center justify-content-center"
                                style="height: 48px; background: linear-gradient(135deg, #4776E6 0%, #8E54E9 100%); color: white; border: none; margin-left:10px;"
                                type="button" data-bs-toggle="dropdown">
                                تحويل إلى أمر شراء <i class="fas fa-exchange-alt ms-2"></i>
                            </button>
                            <ul class="dropdown-menu py-1 shadow-lg">
                                <?php $__empty_1 = true; $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <li>
                                        <form action="<?php echo e(route('pricesPurchase.convertToPurchaseOrder', $purchaseQuotation->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="supplier_id" value="<?php echo e($supplier->id); ?>">
                                            <button type="submit" class="dropdown-item d-flex align-items-center py-2 px-3">
                                                <i class="fa fa-user me-2" style="color: #4776E6;"></i>
                                                <?php echo e($supplier->trade_name); ?>

                                            </button>
                                        </form>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <li><span class="dropdown-item text-muted">لا يوجد موردين</span></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <span class="badge fs-6 text-white d-flex align-items-center justify-content-center px-4"
                              style="background: linear-gradient(135deg, #43A047 0%, #2E7D32 100%); height: 48px;">
                            تمت الموافقة
                        </span>
                    <?php elseif($purchaseQuotation->status == 3): ?>
                        <span class="badge fs-6 text-white d-flex align-items-center justify-content-center px-4"
                              style="background: linear-gradient(135deg, #d32f2f 0%, #b71c1c 100%); height: 48px;">
                            تم الرفض
                        </span>
                    <?php endif; ?>
                </div>


            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-title p-2 d-flex align-items-center gap-2">
            <!-- زر تعديل -->
            <a href="<?php echo e(route('pricesPurchase.edit', $purchaseQuotation->id)); ?>" class="btn btn-outline-primary btn-sm">
                تعديل <i class="fa fa-edit ms-1"></i>
            </a>
            <div class="vr"></div>

            <!-- زر حذف -->
            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
                data-bs-target="#deleteModal">
                حذف <i class="fa fa-trash-alt ms-1"></i>
            </button>
            <div class="vr"></div>

            <!-- زر طباعة -->
            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm" type="button" id="printDropdown"
                    data-bs-toggle="dropdown">
                    طباعة <i class="fa fa-print ms-1"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#"><i class="fa fa-file-pdf me-2 text-danger"></i>PDF طباعة</a>
                    </li>
                    <li><a class="dropdown-item" href="#"><i class="fa fa-file-excel me-2 text-success"></i>Excel
                            تصدير</a></li>
                </ul>
            </div>

            <!-- زر المطبوعات -->
            <div class="dropdown">
                <button class="btn btn-outline-info btn-sm d-inline-flex align-items-center justify-content-center px-3"
                    style="min-width: 90px;" type="button" id="printDropdown" data-bs-toggle="dropdown">
                    المطبوعات <i class="fa fa-folder-open ms-1"></i>
                </button>
                <ul class="dropdown-menu py-1" aria-labelledby="printDropdown">
                    <li><a class="dropdown-item d-flex align-items-center" href="#"><i
                                class="fa fa-file-alt me-2 text-primary"></i> Layout 1</a></li>
                    <li><a class="dropdown-item d-flex align-items-center" href="#"><i
                                class="fa fa-file-alt me-2 text-primary"></i> Layout 2</a></li>
                    <li><a class="dropdown-item d-flex align-items-center" href="#"><i
                                class="fa fa-file-alt me-2 text-primary"></i> Layout 3</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item d-flex align-items-center" href="#"><i
                                class="fa fa-file-pdf me-2 text-danger"></i>نموذج 1</a></li>
                    <li><a class="dropdown-item d-flex align-items-center" href="#"><i
                                class="fa fa-file-pdf me-2 text-danger"></i>نموذج 2</a></li>
                    <li><a class="dropdown-item d-flex align-items-center" href="#"><i
                                class="fa fa-file-pdf me-2 text-danger"></i>نموذج 3</a></li>
                </ul>
            </div>

            <!-- زر إرسال إلى بريد المورد -->
            <button type="button" class="btn btn-outline-warning btn-sm">
                ارسل الى بريد المورد <i class="fa fa-envelope ms-1"></i>
            </button>

            <!-- زر إضافة ملاحظة أو مرفق -->
            <button type="button" class="btn btn-outline-success btn-sm">
                اضافة ملاحظة أو مرفق <i class="fa fa-paperclip ms-1"></i>
            </button>
        </div>





        <div class="card-body">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#details" role="tab">التفاصيل</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#items" role="tab">المنتجات</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#activity" role="tab">سجل النشاطات</a>
                </li>
            </ul>

            <div class="tab-content p-3">
                <!-- تبويب التفاصيل -->
                <div class="tab-pane active" id="details" role="tabpanel">

                        <div class="col-md-12">
                            <div class="card">
                                <div class="tab-pane fade show active" style="background: lightslategray; min-height: 100vh; padding: 20px;">
                                    <div class="card shadow" style="max-width: 600px; margin: 20px auto;">
                                        <div class="card-body bg-white p-4" style="min-height: 400px; overflow: auto;">
                                            <div style="transform: scale(0.8); transform-origin: top center;">
                                                <?php echo $__env->make('Purchases.view_purchase_price.pdf', ['purchaseQuotation' => $purchaseQuotation], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                </div>

                <!-- تبويب المنتجات -->
                <div class="tab-pane" id="items" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>المنتج</th>
                                    <th>الكمية</th>
                                    <th>سعر الوحدة</th>
                                    <th>الخصم</th>
                                    <th>الضريبة 1</th>
                                    <th>الضريبة 2</th>
                                    <th>الإجمالي</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $purchaseQuotation->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($loop->iteration); ?></td>
                                        <td><?php echo e($item->product->name ?? $item->item); ?></td>
                                        <td><?php echo e($item->quantity); ?></td>
                                        <td><?php echo e(number_format($item->unit_price, 2)); ?></td>
                                        <td><?php echo e(number_format($item->discount, 2)); ?></td>
                                        <td><?php echo e(number_format($item->tax_1, 2)); ?></td>
                                        <td><?php echo e(number_format($item->tax_2, 2)); ?></td>
                                        <td><?php echo e(number_format($item->total, 2)); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7" class="text-start">الإجمالي</td>
                                    <td><?php echo e(number_format($purchaseQuotation->grand_total, 2)); ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- تبويب سجل النشاطات -->
                <div class="tab-pane" id="activity" role="tabpanel">
                    <div class="timeline p-4">
                        <p class="text-muted text-center">لا توجد نشاطات حتى الآن</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Delete -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">حذف عرض السعر</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>هل أنت متأكد من حذف عرض السعر رقم "<?php echo e($purchaseQuotation->code); ?>"؟</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                    <form action="<?php echo e(route('pricesPurchase.destroy', $purchaseQuotation->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger">حذف</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/Purchases/view_purchase_price/show.blade.php ENDPATH**/ ?>