<?php $__env->startSection('title'); ?>
    قائمة الحالات
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">قائمة الحالات</h2>
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

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <a href="" class="btn btn-outline-danger">
                            <i class="fa fa-ban"></i> الغاء
                        </a>
                        <button type="submit" form="statusForm" class="btn btn-outline-primary">
                            <i class="fa fa-save"></i> حفظ
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <form id="statusForm" action="<?php echo e(route('SupplyOrders.storeStatus')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>الاسم</th>
                                        <th>اللون</th>
                                        <th>الحالة</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody id="statusTable">
                                    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr data-status-id="<?php echo e($status->id); ?>">
                                            <td>
                                                <input type="text" name="statuses[<?php echo e($status->id); ?>][name]"
                                                    class="form-control form-control-lg" placeholder="اسم الحالة"
                                                    value="<?php echo e($status->name); ?>" required />
                                            </td>
                                            <td>
                                                <input type="color" name="statuses[<?php echo e($status->id); ?>][color]"
                                                    class="form-control form-control-lg" value="<?php echo e($status->color); ?>" />
                                            </td>
                                            <td>
                                                <select name="statuses[<?php echo e($status->id); ?>][state]" class="form-control">
                                                    <option value="open" <?php echo e($status->state == 'open' ? 'selected' : ''); ?>>مفتوح</option>
                                                    <option value="closed" <?php echo e($status->state == 'closed' ? 'selected' : ''); ?>>مغلق</option>
                                                </select>
                                            </td>
                                            <td>
                                                <?php if($status->is_deletable): ?>
                                                    <button type="button" class="btn btn-danger btn-sm delete-btn">
                                                        <i class="feather icon-trash"></i> حذف
                                                    </button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <button type="button" class="btn btn-success mt-2" id="addRow">
                            <i class="feather icon-plus"></i> إضافة حالة جديدة
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // إضافة صف جديد
            document.getElementById('addRow').addEventListener('click', function() {
                let uniqueId = Date.now();
                let newRow = `
                    <tr>
                        <td>
                            <input type="text" name="statuses[${uniqueId}][name]"
                                   class="form-control form-control-lg"
                                   placeholder="اسم الحالة" required>
                        </td>
                        <td>
                            <input type="color" name="statuses[${uniqueId}][color]"
                                   class="form-control form-control-lg"
                                   value="#009688">
                        </td>
                        <td>
                            <select name="statuses[${uniqueId}][state]" class="form-control">
                                <option value="open">مفتوح</option>
                                <option value="closed">مغلق</option>
                            </select>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm delete-btn">
                                <i class="feather icon-trash"></i> حذف
                            </button>
                        </td>
                    </tr>`;

                document.getElementById('statusTable').insertAdjacentHTML('beforeend', newRow);
            });

            // حذف صف
            document.addEventListener('click', function(event) {
                if (event.target.classList.contains('delete-btn')) {
                    if (confirm('هل أنت متأكد من حذف هذه الحالة؟')) {
                        event.target.closest('tr').remove();
                    }
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtrasmart\fawtrasmart\resources\views/supplyOrders/edit_status.blade.php ENDPATH**/ ?>