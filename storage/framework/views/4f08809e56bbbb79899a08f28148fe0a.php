<?php $__env->startSection('title'); ?>
اعدادات المخزون
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
                                <a href="<?php echo e(route('product_settings.barcode_settings')); ?>">
                                    <img class="p-3" src="<?php echo e(asset('app-assets/images/barcode.png')); ?>" alt="img placeholder">
                                    <h5><strong>اعدادات الباركود</strong></h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="card hover-card">
                        <div class="card-content">
                            <div class="card-body setting">
                                <a href="<?php echo e(route('product_settings.category')); ?>">
                                    <img class="p-3" src="<?php echo e(asset('app-assets/images/tag.png')); ?>" alt="img placeholder">
                                    <h5><strong>التصنيفات</strong></h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="card hover-card">
                        <div class="card-content">
                            <div class="card-body setting">
                                <a href="<?php echo e(route('template_unit.index')); ?>">
                                    <img class="p-3" src="<?php echo e(asset('app-assets/images/balance.png')); ?>" alt="img placeholder">
                                    <h5><strong>قوالب الوحدات</strong></h5>
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
                                    <img class="p-3" src="<?php echo e(asset('app-assets/images/form.png')); ?>" alt="img placeholder">
                                    <h5><strong>حقول اضافيه</strong></h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="card hover-card">
                        <div class="card-content">
                            <div class="card-body setting">
                                <a href="<?php echo e(route('product_settings.default_taxes')); ?>">
                                    <img class="p-3" src="<?php echo e(asset('app-assets/images/invoce.png')); ?>" alt="img placeholder">
                                    <h5><strong>الضرائب الافتراضيه</strong></h5>
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

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/stock/products_settings/index.blade.php ENDPATH**/ ?>