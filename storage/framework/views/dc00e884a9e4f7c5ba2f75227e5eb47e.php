<?php $__env->startSection('title'); ?>
  صلاحيات العميل
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<style>
/* تخصيص الـ checkbox */
.form-check-input.custom-checkbox {
 
    accent-color: blue; /* تغيير لون الـ checkbox إلى الأزرق */
  /* إضافة مسافة بين الـ checkbox والنص */
}

/* تخصيص النص بجانب الـ checkbox */
.form-check-label.custom-label {
  /* زيادة حجم النص */
    color: #333; /* لون النص */
 
}
</style>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">أعدادات الفروع </h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a></li>
                            <li class="breadcrumb-item active">أضافة</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    <form action="<?php echo e(route('clients.store_permission')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                </div>
                <div>
                    
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="fa fa-save"></i> حفظ
                        </button>
                </div>
            </div>
        </div>
    </div>
    <?php if(Session::has('success')): ?>
    <div class="alert alert-success text-xl-center" role="alert">
        <p class="mb-0">
            <?php echo e(Session::get('success')); ?>

        </p>
    </div>
<?php endif; ?>

   

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
              
            </div>
            <div id="settings-container">
                <div class="col-md-6 mb-3" id="branch-settings">
                    <?php $__currentLoopData = $ClientPermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ClientPermission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input
                                    type="checkbox"
                                    class="form-check-input custom-checkbox"
                                    id="setting_<?php echo e($ClientPermission->id); ?>"
                                    name="settings[]"
                                    value="<?php echo e($ClientPermission->id); ?>"
                                    <?php echo e($ClientPermission->is_active ? 'checked' : ''); ?>

                                >
                                <label class="form-check-label custom-label" for="setting_<?php echo e($ClientPermission->id); ?>">
                                    <?php echo e($ClientPermission->name); ?>

                                </label>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

        </div>
    </div>

    </form>
   
<?php $__env->stopSection(); ?>


<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtrasmart\fawtrasmart\resources\views/client/setting/permission.blade.php ENDPATH**/ ?>