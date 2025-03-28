<?php $__env->startSection('title'); ?>
المستودعات
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">المستودعات</h2>
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
                        <a href="<?php echo e(route('storehouse.create')); ?>" class="btn btn-outline-primary">
                            <i class="feather icon-plus"></i>مستودع جديد
                        </a>
                    </div>

                </div>
            </div>
        </div>

        <?php echo $__env->make('layouts.alerts.error', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('layouts.alerts.success', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="card">
            <div class="card-body">
                <?php if(@isset($storehouses) && !@empty($storehouses) && count($storehouses) > 0): ?>
                <table class="table table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>الاسم</th>
                            <th>الحاله</th>
                            <th>اجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $storehouses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$storehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <strong><?php echo e($storehouse->name); ?></strong>
                            <small>
                                <?php if($storehouse->major == 1): ?>
                                    <div class="badge badge-pill badge badge-success">رئيسي</div>
                                <?php endif; ?>
                            </small>
                        </td>
                        <td>
                            <?php if($storehouse->status == 0): ?>
                                    <span class="mr-1 bullet bullet-success bullet-sm"></span><span class="mail-date">نشط</span>
                            <?php elseif($storehouse->status == 1): ?>
                                <span class="mr-1 bullet bullet-danger bullet-sm"></span><span class="mail-date">غير نشط</span>
                            <?php else: ?>
                                <span class="mr-1 bullet bullet-secondary bullet-sm"></span><span class="mail-date">متوقف</span>
                            <?php endif; ?>
                        </td>
                        <td style="width: 10%">
                            <div class="btn-group">
                                <div class="dropdown">
                                    <button class="btn btn-sm bg-gradient-info fa fa-ellipsis-v mr-1 mb-1" type="button"id="dropdownMenuButton303" data-toggle="dropdown" aria-haspopup="true"aria-expanded="false"></button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton303">
                                        <li>
                                            <a class="dropdown-item" href="<?php echo e(route('storehouse.show',$storehouse->id)); ?>">
                                                <i class="fa fa-eye me-2 text-primary"></i>عرض
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="<?php echo e(route('storehouse.edit',$storehouse->id)); ?>">
                                                <i class="fa fa-edit me-2 text-success"></i>تعديل
                                            </a>
                                        </li>
                                        <?php if($storehouse->major == 0): ?>
                                            <li>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal_DELETE<?php echo e($storehouse->id); ?>">
                                                    <i class="fa fa-trash me-2 text-danger"></i>حذف
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if($storehouse->status == 0): ?>
                                            <li>
                                                <a class="dropdown-item" href="<?php echo e(route('storehouse.summary_inventory_operations', $storehouse->id)); ?>">
                                                    <i class="fa fa-bars me-2 text-info"></i>ملخص عمليات المخزون
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="<?php echo e(route('storehouse.inventory_value', $storehouse->id)); ?>">
                                                    <i class="fa fa-bars me-2 text-info"></i>قيمة المخزون
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="<?php echo e(route('storehouse.inventory_sheet', $storehouse->id)); ?>">
                                                    <i class="fa fa-bars me-2 text-info"></i>ورقة الجرد
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Modal delete -->
                        <div class="modal fade text-left" id="modal_DELETE<?php echo e($storehouse->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header" style="background-color: #EA5455 !important;">
                                        <h4 class="modal-title" id="myModalLabel1" style="color: #FFFFFF">حذف <?php echo e($storehouse->name); ?></h4>
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
                                        <a href="<?php echo e(route('storehouse.delete', $storehouse->id)); ?>" class="btn btn-danger waves-effect waves-light">تأكيد</a>
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
                            لا توجد مستودعات
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtrasmart\fawtrasmart\resources\views/stock/storehouse/index.blade.php ENDPATH**/ ?>