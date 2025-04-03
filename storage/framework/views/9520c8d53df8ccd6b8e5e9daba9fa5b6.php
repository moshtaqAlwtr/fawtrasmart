<?php $__env->startSection('title'); ?>
اعدادات العميل
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <style>
        .setting{
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            flex-direction: column;
        }
        .hover-card:hover{
            background-color: #cdd2d8;
            scale: .98;
        }
        .container{
            max-width: 1200px;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-body">

        <section id="statistics-card" class="container">
            <div class="row">

                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="card hover-card">
                        <div class="card-content">
                            <div class="card-body setting">
                                <a href="<?php echo e(route('clients.general')); ?>">
                                    <img class="p-3" src="<?php echo e(asset('app-assets/images/icons8-user-90.png')); ?>" alt="img placeholder">

                                    <h5><strong>عام</strong></h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="card hover-card">
                        <div class="card-content">
                            <div class="card-body setting">
                                <a href="<?php echo e(route('clients.permission')); ?>">
                                    <img class="p-3" src="<?php echo e(asset('app-assets/images/icons8-user-lock-100.png')); ?>" alt="img placeholder">
                                    <h5><strong>صلاحيات العميل</strong></h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="card hover-card">
                        <div class="card-content">
                            <div class="card-body setting">
                                <a href="<?php echo e(route('SupplyOrders.edit_status')); ?>">
                                    <img class="p-3" src="<?php echo e(asset('app-assets/images/icons8-pager-100.png')); ?>" alt="img placeholder">
                                    <h5><strong>حالات متابعة العميل</strong></h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="card hover-card">
                        <div class="card-content">
                            <div class="card-body setting">
                                <a href="">
                                    <img class="p-3" src="<?php echo e(asset('app-assets/images/icons8-pager-100.png')); ?>" alt="img placeholder">
                                    <h5><strong>الحقول الاضافية الخاصة بالعميل</strong></h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </section>

    </div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/client/setting/index.blade.php ENDPATH**/ ?>