<?php $__env->startSection('title'); ?>
   اعدادات العميل
<?php $__env->stopSection(); ?>
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
<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
           
            </div>
        </div>
    </div>
    <div class="content-body">
        <form id="clientForm" action="<?php echo e(route('clients.store_general')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <?php if(session('success')): ?>
            <div class="alert alert-success">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                        </div>

                        <div>
                            <a href="<?php echo e(route('clients.index')); ?>" class="btn btn-outline-danger">
                                <i class="fa fa-ban"></i>الغاء
                            </a>
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="fa fa-save"></i>حفظ
                            </button>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <!-- الحقول الإضافية على اليسار -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">الحقول الاضافية للعميل</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="form-body">
                                    <div class="row">
                                        <?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-md-12">
                                                <div class="form-check">
                                                    <input
                                                        type="checkbox"
                                                        class="form-check-input custom-checkbox"
                                                        id="setting_<?php echo e($setting->id); ?>"
                                                        name="settings[]"
                                                        value="<?php echo e($setting->id); ?>"
                                                        <?php echo e($setting->is_active ? 'checked' : ''); ?>

                                                    >
                                                    <label class="form-check-label" for="setting_<?php echo e($setting->id); ?>">
                                                        <?php echo e($setting->name); ?>

                                                    </label>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <!-- نوع العميل على اليمين -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">اعدادات العميل</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="form-body">
                                    <div class="row">
                                        <!-- نوع العميل -->
                                        <div class="col-12 mb-3">
                                            <div class="form-group">
                                                <label for="trade_name"> نوع العميل <span class="text-danger">*</span></label>
                                                <div class="position-relative has-icon-left">
                                                    <select name="type" class="form-control">
                                                        <option value="Both" <?php echo e($selectedType === 'Both' ? 'selected' : ''); ?>>كلاهما</option>
                                                        <option value="individual" <?php echo e($selectedType === 'individual' ? 'selected' : ''); ?>>فردي</option>
                                                        <option value="commercial" <?php echo e($selectedType === 'commercial' ? 'selected' : ''); ?>>تجاري</option>
                                                    </select>
                                                    <div class="form-control-position">
                                                        <i class="feather icon-briefcase"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>


    </div>
    </div>

    <!------------------------->


<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

    <script src="<?php echo e(asset('assets/js/scripts.js')); ?>"></script>
    <script>
        document.getElementById('clientForm').addEventListener('submit', function(e) {
            // e.preventDefault(); // احذف هذا السطر إذا كنت تريد أن يتم إرسال النموذج

            console.log('تم تقديم النموذج');

            // طباعة جميع البيانات المرسلة
            const formData = new FormData(this);
            for (let pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }
        });
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtrasmart\fawtrasmart\resources\views/client/setting/general.blade.php ENDPATH**/ ?>