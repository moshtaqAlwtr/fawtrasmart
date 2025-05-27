<?php $__env->startSection('title'); ?>
    أدارة أدوار الموظفين
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">أدارة أداوار الموظفين</h2>
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
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                    </div>

                    <div>

                        <a href="<?php echo e(route('managing_employee_roles.create')); ?>" class="btn btn-outline-primary">
                            <i class="fa fa-plus"></i> دور جديد
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <?php echo $__env->make('layouts.alerts.error', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('layouts.alerts.success', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="card">
            <div class="card-content">
                <div class="card-body">

                    <!-- جدول عرض الأدوار -->
                    <?php if(@isset($roles) && !@empty($roles) && count($roles) > 0): ?>
                    <table class="table table-hover align-middle text-center table-striped">
                        <thead>
                            <tr>
                                <th scope="col">المعرف</th>
                                <th scope="col">الدور الوظيفي</th>
                                <th scope="col">النوع</th>
                                <th scope="col">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($index + 1); ?></td>
                                <td><?php echo e($role->role_name); ?></td>
                                <td><?php if($role->role_type == 1): ?> مستخدم <?php else: ?> موظف <?php endif; ?></td>
                                <td>
                                    <a href="<?php echo e(route('managing_employee_roles.edit',$role->id)); ?>" class="btn btn-outline-info btn-sm">
                                        <i class="fa fa-pencil-square"></i> تعديل
                                    </a>
                                    <button class="btn btn-outline-secondary btn-sm">
                                        <i class="fa fa-file"></i> نسخ
                                    </button>
                                    <button class="btn btn-outline-warning btn-sm">
                                        <i class="fa fa-lock"></i> صفحات محظورة
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#modal_DELETE<?php echo e($role->id); ?>">
                                        <i class="fa fa-trash"></i> حذف
                                    </button>
                                </td>

                                <!-- Modal delete -->
                                <div class="modal fade text-left" id="modal_DELETE<?php echo e($role->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: #EA5455 !important;">
                                                <h4 class="modal-title" id="myModalLabel1" style="color: #FFFFFF">حذف <?php echo e($role->role_name); ?></h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true" style="color: #DC3545">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <strong>
                                                    هل انت متاكد من انك تريد الحذف ؟
                                                </strong>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light waves-effect waves-light" data-dismiss="modal">الغاء</button>
                                                <a href="<?php echo e(route('managing_employee_roles.delete',$role->id)); ?>" class="btn btn-danger waves-effect waves-light">تأكيد</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end delete-->

                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                        <div class="alert alert-danger text-xl-center" role="alert">
                            <p class="mb-0">
                                لا توجد ادوار موظفين مضافه حتى الان !!
                            </p>
                        </div>
                    <?php endif; ?>

                </div>

                <!-- رسالة نجاح عند تنفيذ الإجراء -->
                <div class="alert alert-success mt-3" style="display: none;">
                    تم تنفيذ الإجراء بنجاح.
                </div>
            </div>
        </div>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/hr/managing_employee_roles/index.blade.php ENDPATH**/ ?>