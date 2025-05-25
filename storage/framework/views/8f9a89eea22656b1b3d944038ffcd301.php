<?php $__env->startSection('title'); ?>
    إدارة الإشعارات
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <!-- Card Container -->
    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
        <!-- Card Header with Gradient Background -->
<div class="card">
<div class="card-body">
   <div class="text-center text-md-start">
            <h3 class="mb-1 fw-bold">
                <i class="fas fa-bell me-2"></i> لوحة الإشعارات
            </h3>
            <p class="mb-0 opacity-75 small">إدارة وعرض جميع الإشعارات في نظامك</p>
        </div>
      <form method="GET" action="<?php echo e(route('notifications.index')); ?>" class="needs-validation" novalidate>
                <div class="d-flex flex-column flex-sm-row align-items-stretch gap-2">
                    <select name="user_id" class="form-select form-select-sm select2" style="min-width: 180px;">
                        <option value="">جميع الموظفين</option>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($user->id); ?>" <?php echo e(request('user_id') == $user->id ? 'selected' : ''); ?>>
                                <?php echo e($user->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>

                    <button type="submit" class="btn btn-light btn-sm d-flex align-items-center justify-content-center">
                        <i class="fas fa-filter me-1"></i> تصفية
                    </button>
                </div>
            </form>

</div>
</div>

        <!-- Card Body -->
        <div class="card-body p-0">
            <?php if($notifications->isEmpty()): ?>
                <!-- Empty State -->
                <div class="text-center p-5 bg-light rounded-3 m-3">
                    <div class="mb-3">
                        <i class="fas fa-bell-slash text-muted opacity-25" style="font-size: 3.5rem;"></i>
                    </div>
                    <h5 class="text-muted mb-2">لا توجد إشعارات</h5>
                    <p class="text-muted mb-4">لم يتم العثور على أي إشعارات لعرضها</p>
                    <a href="#" class="btn btn-sm btn-outline-primary rounded-pill">
                        <i class="fas fa-sync-alt me-1"></i> تحديث الصفحة
                    </a>
                </div>
            <?php else: ?>
                <!-- Notifications List -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 rounded-start" style="min-width: 220px;">الموظف</th>
                                <th>محتوى الإشعار</th>
                                <th class="text-center" style="min-width: 120px;">التاريخ</th>
                                <th class="text-center rounded-end" style="min-width: 100px;">إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="<?php echo e(is_null($notification->read_at) ? 'unread-notification' : ''); ?>">
                                    <!-- User Column -->
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-3">
                                                <?php if($notification->user): ?>
                                                    <img src="<?php echo e(asset('assets/img/avatars/default.png')); ?>"
                                                        alt="<?php echo e($notification->user->name); ?>" class="rounded-circle border"
                                                        onerror="this.onerror=null; this.src='data:image/svg+xml;charset=UTF-8,<svg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 100 100\'><rect width=\'100%\' height=\'100%\' fill=\'%23f8f9fa\'/><text x=\'50%\' y=\'50%\' font-size=\'40\' text-anchor=\'middle\' dominant-baseline=\'middle\' fill=\'%236c757d\'><?php echo e(substr($notification->user->name, 0, 1)); ?></text></svg>'">
                                                <?php else: ?>
                                                    <span class="avatar-initial rounded-circle bg-secondary text-white">
                                                        ?
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <div>
                                                <h6 class="mb-0"><?php echo e($notification->user->name ?? 'مستخدم محذوف'); ?></h6>
                                                <small
                                                    class="text-muted"><?php echo e($notification->user->department->name ?? 'غير محدد'); ?></small>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Notification Content -->
                                    <td>
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-1 fw-semibold"><?php echo e($notification->title ?? 'بدون عنوان'); ?></h6>
                                            <p class="mb-0 text-muted text-truncate pe-2" style="max-width: 350px;">
                                                <?php echo e($notification->description ?? 'لا توجد تفاصيل'); ?>

                                            </p>
                                        </div>
                                    </td>

                                    <!-- Date Column -->
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark" data-bs-toggle="tooltip"
                                            title="<?php echo e($notification->created_at->format('Y/m/d h:i A')); ?>">
                                            <i class="far fa-clock me-1"></i>
                                            <?php echo e($notification->created_at->diffForHumans()); ?>

                                        </span>
                                    </td>

                                    <!-- Actions Column -->
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="<?php echo e(route('notifications.markAsRead', $notification->id)); ?>"
                                                class="btn btn-icon btn-sm btn-outline-primary rounded-circle"
                                                data-bs-toggle="tooltip" title="تحديد كمقروء">
                                                <i class="fas fa-check"></i>
                                            </a>
                                            <form action="" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit"
                                                    class="btn btn-icon btn-sm btn-outline-danger rounded-circle delete-notification"
                                                    data-bs-toggle="tooltip" title="حذف الإشعار">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <!-- Card Footer - Pagination -->
        <?php if($notifications->hasPages()): ?>
            <div class="card-footer bg-transparent border-0 py-3">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <div class="mb-2 mb-md-0">
                        <p class="mb-0 text-muted small">
                            عرض <span class="fw-bold"><?php echo e($notifications->firstItem()); ?></span> إلى
                            <span class="fw-bold"><?php echo e($notifications->lastItem()); ?></span> من
                            <span class="fw-bold"><?php echo e($notifications->total()); ?></span> إشعار
                        </p>
                    </div>

                    <nav aria-label="Notifications pagination">
                        <ul class="pagination pagination-sm mb-0">
                            <!-- First Page Link -->
                            <li class="page-item <?php echo e($notifications->onFirstPage() ? 'disabled' : ''); ?>">
                                <a class="page-link border-0 rounded-start-pill" href="<?php echo e($notifications->url(1)); ?>"
                                    aria-label="First">
                                    <i class="fas fa-angle-double-right"></i>
                                </a>
                            </li>

                            <!-- Previous Page Link -->
                            <li class="page-item <?php echo e($notifications->onFirstPage() ? 'disabled' : ''); ?>">
                                <a class="page-link border-0" href="<?php echo e($notifications->previousPageUrl()); ?>"
                                    aria-label="Previous">
                                    <i class="fas fa-angle-right"></i>
                                </a>
                            </li>

                            <!-- Page Numbers -->
                            <?php $__currentLoopData = range(1, $notifications->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(
                                    $i == 1 ||
                                        $i == $notifications->lastPage() ||
                                        ($i >= $notifications->currentPage() - 2 && $i <= $notifications->currentPage() + 2)): ?>
                                    <li class="page-item <?php echo e($i == $notifications->currentPage() ? 'active' : ''); ?>">
                                        <a class="page-link border-0"
                                            href="<?php echo e($notifications->url($i)); ?>"><?php echo e($i); ?></a>
                                    </li>
                                <?php elseif($i == $notifications->currentPage() - 3 || $i == $notifications->currentPage() + 3): ?>
                                    <li class="page-item disabled">
                                        <span class="page-link border-0">...</span>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <!-- Next Page Link -->
                            <li class="page-item <?php echo e(!$notifications->hasMorePages() ? 'disabled' : ''); ?>">
                                <a class="page-link border-0" href="<?php echo e($notifications->nextPageUrl()); ?>"
                                    aria-label="Next">
                                    <i class="fas fa-angle-left"></i>
                                </a>
                            </li>

                            <!-- Last Page Link -->
                            <li class="page-item <?php echo e(!$notifications->hasMorePages() ? 'disabled' : ''); ?>">
                                <a class="page-link border-0 rounded-end-pill"
                                    href="<?php echo e($notifications->url($notifications->lastPage())); ?>" aria-label="Last">
                                    <i class="fas fa-angle-double-left"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        <?php endif; ?>
    </div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>
    <script>
        $(document).ready(function() {
            // Initialize tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();

            // Confirm before deleting notification
            $('.delete-notification').click(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'هل أنت متأكد؟',
                    text: "لن تتمكن من استعادة هذا الإشعار بعد الحذف!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'نعم، احذفه!',
                    cancelButtonText: 'إلغاء'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).closest('form').submit();
                    }
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/notifications/index.blade.php ENDPATH**/ ?>