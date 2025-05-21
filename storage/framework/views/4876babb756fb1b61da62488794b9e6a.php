<?php $__env->startSection('title'); ?>
    اعدادات المجموعات
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <style>
        #map {
            height: 500px;
            width: 100%;
            margin-bottom: 20px;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0"> اعدادات المجموعات</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                            <li class="breadcrumb-item active">عرض</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">


        <!-- بطاقة الإجراءات -->
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-body">
                <div class="row align-items-center gy-3">
                    <!-- القسم الأيمن -->
                    <div
                        class="col-md-6 d-flex flex-wrap align-items-center gap-2 justify-content-center justify-content-md-start">
                        <!-- زر إضافة عميل -->
                        <a href="<?php echo e(route('groups.group_client_create')); ?>"
                            class="btn btn-success btn-sm rounded-pill px-4 text-center">
                            <i class="fas fa-plus-circle me-1"></i>
                            إضافة مجموعة
                        </a>


                    </div>
                </div>
            </div>
        </div>
        <form action="<?php echo e(route('groups.group_client')); ?>" method="GET">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="name">اسم المجموعة</label>
                            <input type="text" name="name" class="form-control" value="<?php echo e(request('name')); ?>"
                                placeholder="ابحث باسم المجموعة">
                        </div>
                        <div class="col-md-4">
                            <label for="branch_id">الفرع</label>
                            <select name="branch_id" class="form-control select2">
                                <option value="">-- اختر الفرع --</option>
                                <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($branch->id); ?>"
                                        <?php echo e(request('branch_id') == $branch->id ? 'selected' : ''); ?>>
                                        <?php echo e($branch->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="directions_id">الاتجاة</label>
                            <select name="directions_id" class="form-control select2">
                                <option value="">-- اختر الاتجاه --</option>
                                <?php $__currentLoopData = $directions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $direction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($direction->id); ?>"
                                        <?php echo e(request('directions_id') == $direction->id ? 'selected' : ''); ?>>
                                        <?php echo e($direction->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary mr-2">
                                <i class="fa fa-search"></i> بحث
                            </button>
                            <a href="<?php echo e(route('groups.group_client')); ?>" class="btn btn-secondary">
                                <i class="fa fa-times"></i> إلغاء
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>



        <!-- جدول العملاء -->

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>المجموعة</th>
                                <th>الاتجاه</th>
                                <th>الفرع</th>
                                <th style="width: 10%">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $Regions_groub; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Region_groub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td> <!-- ترقيم تلقائي -->
                                    <td><?php echo e($Region_groub->name); ?></td>
                                    <td><?php echo e($Region_groub->direction->name ?? 'غير محدد'); ?></td>


                                    <td><?php echo e($Region_groub->branch->name ?? ''); ?></td>
                                    <td>
                                            <div class="btn-group">
                                                <div class="dropdown">
                                                    <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1 btn-sm"
                                                        type="button"id="dropdownMenuButton303" data-toggle="dropdown"
                                                        aria-haspopup="true"aria-expanded="false"></button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton303">

                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="<?php echo e(route('groups.group_client_edit', $Region_groub->id)); ?>">
                                                                <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#modal_DELETE<?php echo e($Region_groub->id); ?>">
                                                                <i class="fa fa-trash me-2"></i>حذف
                                                            </a>
                                                        </li>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                </tr>
                                                                    <div class="modal fade text-left" id="modal_DELETE<?php echo e($Region_groub->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background-color: #EA5455 !important;">
                                                    <h4 class="modal-title" id="myModalLabel1" style="color: #FFFFFF">حذف <?php echo e($Region_groub->name); ?></h4>
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
                                                    <a href="<?php echo e(route('groups.group_client_destroy', $Region_groub->id)); ?>" class="btn btn-danger waves-effect waves-light">تأكيد</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>



    <?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/client/groups/group_client.blade.php ENDPATH**/ ?>