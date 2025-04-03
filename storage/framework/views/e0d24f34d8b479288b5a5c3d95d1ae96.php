<?php $__env->startSection('title'); ?>
    اضافة مجموعة
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">اضافة  مجموعة </h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a></li>
                            <li class="breadcrumb-item active">عرض </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="<?php echo e(route('clients.group_client_store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <!-- عرض الأخطاء -->
        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert alert-danger">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                    </div>
                    <div>
                        <a href="" class="btn btn-outline-danger">
                            <i class="fa fa-ban"></i>الغاء
                        </a>
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="fa fa-save"></i>   اضافة
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <!-- الحقول -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">المجموعة <span style="color: red">*</span></label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="المجموعة"
                            step="0.01" value="" required>
                    </div>
                    
                </div>
             
            </div>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/client/group_client_create.blade.php ENDPATH**/ ?>