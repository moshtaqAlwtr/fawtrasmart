<?php $__env->startSection('title'); ?>
أدارة الفروع
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">أدارة الفروع </h2>
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

<?php echo $__env->make('layouts.alerts.error', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('layouts.alerts.success', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
          
            </div>

            <div class="d-flex justify-content-start">
                <!-- أيقونة الترس (إعدادات الفروع) -->
                <a href="<?php echo e(route('branches.settings')); ?>" class="btn btn-outline-secondary me-2">
                    <i class="fa fa-cogs"></i>
                </a>
                
                <!-- زر فرع جديد -->
                <a href="<?php echo e(route('branches.create')); ?>" class="btn btn-outline-success me-2">
                    <i class="fa fa-plus"></i> فرع جديد
                </a>
            </div>
        </div>
    </div>
</div>



<!-- عرض الفروع -->
<?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="card">
    <div class="card-body d-flex justify-content-between align-items-center text-end">
        <!-- العمود الأول (التفاصيل) -->
        <div>
            <div><strong><?php echo e($branch->name); ?><?php echo e($branch->code ?? ""); ?></strong></div>
            <small class="text-muted"></small>
        </div>

        <!-- العمود الثاني (العلامة أو النص) -->
        <div>
    <span class="badge 
        <?php echo e($branch->status == 0 ? 'bg-success' : 
           ($branch->status == 1 ? 'bg-warning' : 'bg-secondary')); ?>">
        <?php echo e($branch->status == 0 ? 'نشط' : 
           ($branch->status == 1 ? 'غير نشط' : 'موقوف')); ?>

    </span>
</div>


   <!-- العمود الثالث (القائمة المنسدلة) -->
   <div class="col-md-2 text-end">
            <div class="btn-group">
                <div class="dropdown">
                    <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1" type="button" id="dropdownMenuButton303" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton303">
                        <!-- خيار التعديل -->
                        <a class="dropdown-item" href="<?php echo e(route('branches.edit', $branch->id)); ?>">
                            <i class="fa fa-edit text-primary me-2"></i> تعديل
                        </a>

                        <!-- خيار التعطيل -->
                        <a class="dropdown-item" href="<?php echo e(route('branches.updateStatus', $branch->id)); ?>">
                        <i class="fa fa-ban text-warning me-2"></i> 
                            <?php if($branch->status == 0): ?>
                                تعطيل
                            <?php else: ?> 
                                تنشيط
                            <?php endif; ?>
                        </a>

                        <!-- خيار التعطيل -->
                        <!-- <form action="<?php echo e(route('branches.updateStatus', $branch->id)); ?>" method="POST" style="display: inline;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <input type="hidden" name="status" value="0"> 
                            <button type="submit" class="dropdown-item">
                                <i class="fa fa-ban text-warning me-2"></i> 
                                <?php if($branch->status == 0): ?>
                                تعطيل
                                <?php else: ?> 
                                تفعيل
                            
                                <?php endif; ?>
                            </button>
                        </form> -->

                        <!-- خيار الموقوف -->
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php if($branches->isEmpty()): ?>
    <p>لا توجد فروع حالياً.</p>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/branches/index.blade.php ENDPATH**/ ?>