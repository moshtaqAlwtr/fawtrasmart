<?php $__env->startSection('title'); ?>
مرتجع مشتريات #<?php echo e($purchaseInvoiceReturn->code); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header d-flex justify-content-between align-items-center mb-2">
        <div>
            <h2 class="content-header-title mb-0">
                مرتجع مشتريات <?php echo e($purchaseInvoiceReturn->code); ?>

                <span class="badge <?php echo e($purchaseInvoiceReturn->status == 1 ? 'bg-warning' : 'bg-success'); ?>">
                    <?php echo e($purchaseInvoiceReturn->status == 1 ? 'معلق' : 'مكتمل'); ?>

                </span>
            </h2>
            <small>المورد: <?php echo e($purchaseInvoiceReturn->supplier->name); ?> - رقم المرتجع #<?php echo e($purchaseInvoiceReturn->code); ?></small>
        </div>
    </div>

    <?php if(session()->has('success')): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> تم حفظ مرتجع المشتريات
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header p-2">
            <div class="d-flex gap-2">
                <!-- مجموعة الأزرار الأولى -->
                <div class="btn-group">
                    <a href="<?php echo e(route('ReturnsInvoice.edit', $purchaseInvoiceReturn->id)); ?>" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-edit"></i> تعديل
                    </a>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="sendToSupplier()">
                        <i class="fas fa-envelope"></i> إرسل بريد إلى المورد
                    </button>
                </div>

                <!-- مجموعة الأزرار الثانية -->
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addNote()">
                        <i class="fas fa-sticky-note"></i> إضافة ملاحظة/مرفق
                    </button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-print"></i> طباعة
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-file-pdf text-danger me-2"></i>PDF</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-file-excel text-success me-2"></i>Excel</a></li>
                        </ul>
                    </div>
                </div>

                <!-- مجموعة الأزرار الثالثة -->
                <div class="btn-group">
                    <div class="dropdown">
                        <button type="button" class="btn btn-outline-info btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i> قائمة
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-clone me-2"></i>نسخ</a></li>
                            <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fas fa-trash-alt me-2"></i>حذف
                            </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" href="#invoice" data-bs-toggle="tab">مرتجع المشتريات</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#attachments" data-bs-toggle="tab">المرفقات</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#activity" data-bs-toggle="tab">سجل النشاطات</a>
                </li>
            </ul>

            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="invoice">
                    <div class="tab-content p-3">
                        <div class="tab-pane active" id="details" role="tabpanel">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="tab-pane fade show active" style="background: lightslategray; min-height: 100vh; padding: 20px;">
                                        <div class="card shadow" style="max-width: 600px; margin: 20px auto;">
                                            <div class="card-body bg-white p-4" style="min-height: 400px; overflow: auto;">
                                                <div style="transform: scale(0.8); transform-origin: top center;">
                                                    <?php echo $__env->make('Purchases.Returns.pdf', ['purchaseInvoiceReturn' => $purchaseInvoiceReturn], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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
                                            <th>الكمية المرتجعة</th>
                                            <th>سعر الوحدة</th>
                                            <th>الخصم</th>
                                            <th>الضريبة 1</th>
                                            <th>الضريبة 2</th>
                                            <th>الإجمالي</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if($purchaseInvoiceReturn->invoiceItems && $purchaseInvoiceReturn->invoiceItems->count() > 0): ?>
                                            <?php $__currentLoopData = $purchaseInvoiceReturn->invoiceItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($loop->iteration); ?></td>
                                                    <td><?php echo e(optional($item->product)->name); ?></td>
                                                    <td><?php echo e($item->quantity); ?></td>
                                                    <td><?php echo e(number_format($item->unit_price, 2)); ?></td>
                                                    <td><?php echo e(number_format($item->discount, 2)); ?></td>
                                                    <td><?php echo e(number_format($item->tax_1, 2)); ?></td>
                                                    <td><?php echo e(number_format($item->tax_2, 2)); ?></td>
                                                    <td><?php echo e(number_format($item->total, 2)); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="8">لا توجد منتجات مرتجعة</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
                    <h5 class="modal-title">حذف المرتجع</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>هل أنت متأكد من حذف مرتجع المشتريات رقم "<?php echo e($purchaseInvoiceReturn->code); ?>"؟</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                    <form action="<?php echo e(route('ReturnsInvoice.destroy', $purchaseInvoiceReturn->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger">حذف</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/Purchases/Returns/show.blade.php ENDPATH**/ ?>