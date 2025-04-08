<?php $__env->startSection('title'); ?>
    إدارة الإشعارات
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container mt-4">
        <div class="card shadow-lg p-4 rounded">
            <!-- عنوان الإشعارات بخلفية بيضاء -->
            <div class="card-header bg-white text-dark border-bottom">
                <h4 class="mb-0 fw-bold">الإشعارات</h4>
            </div>

            <!-- محتوى الكارد -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover text-center">
                        <thead class="bg-secondary text-white">
                            <tr>
                                <th>عنوان التنبيه</th>
                                <th>بيانات التنبيه</th>
                                <th>إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="align-middle">
                                    <td class="fw-bold text-dark"><?php echo e($notification->title ?? 'بدون عنوان'); ?></td>
                                    <td class="fw-bold text-dark"><?php echo e($notification->description ?? 'لا توجد بيانات'); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('notifications.markAsReadid', $notification->id)); ?>" 
                                           class="btn btn-sm btn-danger fw-bold">
                                            <i class="fa fa-eye-slash"></i> إخفاء
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="3" class="text-muted fw-bold">لا توجد إشعارات حاليًا</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/notifications/index.blade.php ENDPATH**/ ?>