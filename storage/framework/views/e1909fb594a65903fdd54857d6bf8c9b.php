

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
                    <h2 class="content-header-title float-left mb-0"> اعدادات  المجموعات</h2>
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
                        <a href="<?php echo e(route('clients.group_client_create')); ?>"
                            class="btn btn-success btn-sm rounded-pill px-4 text-center">
                            <i class="fas fa-plus-circle me-1"></i>
                            إضافة مجموعة
                        </a>

                       
                </div>
            </div>
        </div>
     
        <!-- بطاقة البحث -->
        <div class="card">
          
            <div class="card-body">
                <form class="form" id="searchForm" method="GET" action="<?php echo e(route('clients.index')); ?>">
                    <div class="row g-3">
                        <div class="col-md-4 col-12">
                            
                        </div>
                      
                    </div>

                    <div class="collapse" id="advancedSearchForm">
                        <div class="row g-3 mt-2">
                         
                          
                           
                     
                        </div>
                    </div>

                    
                </form>
            </div>
        </div>

        <!-- جدول العملاء -->
     
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                      <table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>المجموعة</th>
            <th>عدد الأحياء</th>
            <th style="width: 10%">الإجراءات</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $Regions_groub; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Region_groub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($loop->iteration); ?></td> <!-- ترقيم تلقائي -->
                <td><?php echo e($Region_groub->name ?? ""); ?></td>
                <td></td>
                <td></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>

                    </div>
                </div>
            </div>
     
      

<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/client/group_client.blade.php ENDPATH**/ ?>