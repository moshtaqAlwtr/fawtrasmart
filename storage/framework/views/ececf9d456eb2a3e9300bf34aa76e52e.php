<?php $__env->startSection('title'); ?>
    الاعدادات الرواتب
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <style>
        .setting {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            flex-direction: column;
        }
        .hover-card:hover {
            background-color: #cdd2d8;
            scale: .98;
        }
        .container {
            max-width: 1200px;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-body">

        <section id="statistics-card" class="container">
            <div class="row">
                <!-- إعدادات الفواتير وعروض الأسعار -->
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="card hover-card">
                        <div class="card-content">
                            <div class="card-body setting">
                                <a href="">
                                    <i class="fas fa-file-invoice fa-8x p-3" style="color: primary;"></i>
                                    <h5><strong>اعدادات الفواتير وعروض الاسعار</strong></h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- تصاميم الفواتير / عروض الأسعار -->
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="card hover-card">
                        <div class="card-content">
                            <div class="card-body setting">
                                <a href="">
                                    <i class="fas fa-paint-brush fa-8x p-3" style="color: primary;"></i>
                                    <h5><strong>تصاميم الفواتير / عروض الاسعار</strong></h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- العروض -->
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="card hover-card">
                        <div class="card-content">
                            <div class="card-body setting">
                                <a href="<?php echo e(route('Offers.index')); ?>">
                                    <i class="fas fa-gift fa-8x p-3" style="color: primary;"></i>
                                    <h5><strong>العروض</strong></h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- حقول إضافية -->
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="card hover-card">
                        <div class="card-content">
                            <div class="card-body setting">
                                <a href="">
                                    <i class="fas fa-plus-circle fa-8x p-3" style="color: primary;"></i>
                                    <h5><strong>حقول أضافية</strong></h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- خيارات الشحن -->
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="card hover-card">
                        <div class="card-content">
                            <div class="card-body setting">
                                <a href="<?php echo e(route('shippingOptions.index')); ?>">
                                    <i class="fas fa-truck fa-8x p-3" style="color: primary;"></i>
                                    <h5><strong>خيارات الشحن</strong></h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- إعدادات الفواتير الإلكترونية -->
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="card hover-card">
                        <div class="card-content">
                            <div class="card-body setting">
                                <a href="">
                                    <i class="fas fa-file-code fa-8x p-3" style="color: primary;"></i>
                                    <h5><strong>إعدادات الفواتير الإلكترونية</strong></h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- مصادر الطلب -->
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="card hover-card">
                        <div class="card-content">
                            <div class="card-body setting">
                                <a href="">
                                    <i class="fas fa-cogs fa-8x p-3" style="color: primary;"></i>
                                    <h5><strong>مصادر الطلب</strong></h5>
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

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/sales/sitting/index.blade.php ENDPATH**/ ?>