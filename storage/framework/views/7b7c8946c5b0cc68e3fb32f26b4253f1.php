<?php $__env->startSection('title'); ?>
    اعدادات العميل
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>

    <style>
        /* إضافة هذه الأنماط في head أو في ملف CSS منفصل */
        .equal-height-card {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .equal-height-card .card-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .equal-height-card .card-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .hover-card {
            transition: transform 0.3s;
            height: 100%;
        }

        .hover-card:hover {
            transform: translateY(-5px);
        }

        .card-body.setting {
            text-align: center;
            /* لتوسيط النص أفقيًا */
            display: flex;
            flex-direction: column;
            justify-content: center;
            /* لتوسيط المحتوى رأسيًا */
            align-items: center;
            /* لتوسيط المحتوى أفقيًا */
            height: 100%;
        }

        .card-body.setting a {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            text-decoration: none;
        }

        .card-body.setting h5 {
            margin-top: 10px;
            width: 100%;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-body">


        <section id="statistics-card" class="container">
            <div class="row">

                <div class="col-lg-4 col-sm-6 col-12 mb-4">
                    <div class="card hover-card equal-height-card">
                        <div class="card-content">
                            <div class="card-body setting">
                                <a href="<?php echo e(route('clients.general')); ?>">
                                    <img class="p-3" src="<?php echo e(asset('app-assets/images/icons8-user-90.png')); ?>"
                                        alt="img placeholder">
                                    <h5><strong>عام</strong></h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6 col-12 mb-4">
                    <div class="card hover-card equal-height-card">
                        <div class="card-content">
                            <div class="card-body setting">
                                <a href="<?php echo e(route('categoriesClient.index')); ?>">
                                    <i class="fas fa-tags fa-8x p-3"></i>
                                    <h5><strong>تصنيف العملاء</strong></h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6 col-12 mb-4">
                    <div class="card hover-card equal-height-card">
                        <div class="card-content">
                            <div class="card-body setting">
                                <a href="<?php echo e(route('clients.permission')); ?>">
                                    <img class="p-3" src="<?php echo e(asset('app-assets/images/icons8-user-lock-100.png')); ?>"
                                        alt="img placeholder">
                                    <h5><strong>صلاحيات العميل</strong></h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6 col-12 mb-4">
                    <div class="card hover-card equal-height-card">
                        <div class="card-content">
                            <div class="card-body setting">
                                <a href="<?php echo e(route('SupplyOrders.edit_status')); ?>">
                                    <img class="p-3" src="<?php echo e(asset('app-assets/images/icons8-pager-100.png')); ?>"
                                        alt="img placeholder">
                                    <h5><strong>حالات متابعة العميل</strong></h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6 col-12 mb-4">
                    <div class="card hover-card equal-height-card">
                        <div class="card-content">
                            <div class="card-body setting">
                                <a href="">
                                    <img class="p-3" src="<?php echo e(asset('app-assets/images/icons8-pager-100.png')); ?>"
                                        alt="img placeholder">
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

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/client/setting/index.blade.php ENDPATH**/ ?>