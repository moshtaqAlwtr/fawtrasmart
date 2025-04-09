<?php $__env->startSection('title'); ?>
    تقرير العملاء
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">


    <style>
        body {
            background-color: #f4f7fc;
            direction: rtl;

        }

        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .card-title {
            display: flex;
            align-items: center;
            font-weight: bold;
            color: #374957;
        }

        .card-title i {
            margin-left: 10px;
            color: #5869b7;
        }

        .list-group-item {
            border: none;
            padding: 15px;
            display: flex;
            align-items: center;
            transition: background-color 0.3s;
        }

        .list-group-item:hover {
            background-color: #f0f0f5;
        }

        .list-icon {
            width: 40px;
            height: 40px;
            margin-left: 15px;
            border-radius: 50%;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        /* Gradient Styles for Icons */
        .list-icon.gradient-orange {
            background: linear-gradient(45deg, #ffa726, #fb8c00);
        }

        .list-icon.gradient-red {
            background: linear-gradient(45deg, #ef5350, #e53935);
        }

        .list-icon.gradient-teal {
            background: linear-gradient(45deg, #26a69a, #00897b);
        }

        .list-icon.gradient-purple {
            background: linear-gradient(45deg, #ab47bc, #8e24aa);
        }

        .list-icon.gradient-green {
            background: linear-gradient(45deg, #66bb6a, #43a047);
        }

        .list-icon.gradient-blue {
            background: linear-gradient(45deg, #42a5f5, #1e88e5);
        }

        .ms-auto {
            margin-right: auto;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">  تقرير العملاء</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a></li>
                            <li class="breadcrumb-item active">عرض</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 ">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fa-solid fa-chart-line"></i>
                            تقارير العملاء
                        </h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item" onclick="window.location.href=''">
                                <span class="list-icon gradient-orange">
                                    <i class="fa-solid fa-file-invoice-dollar"></i>
                                </span>
                                أعمار الديون (الفواتير)
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('ClientReport.debtReconstructionInv')); ?>" class="text-decoration-none text-dark"><i
                                            class="fas fa-eye"></i> عرض</a>
                                </div>
                            </li>
                            <li class="list-group-item" onclick="window.location.href='debt_report_by_teach.html'">
                                <span class="list-icon gradient-red">
                                    <i class="fa-solid fa-calculator"></i>
                                </span>
                                أعمار الديون (حساب الأستاذ)
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('ClientReport.debtAgingGeneralLedger')); ?>" class="text-decoration-none text-dark"><i
                                            class="fas fa-eye"></i> عرض</a>
                                </div>
                            </li>
                            <li class="list-group-item" onclick="window.location.href='customer_guide.html'">
                                <span class="list-icon gradient-teal">
                                    <i class="fa-solid fa-address-book"></i>
                                </span>
                                دليل العملاء
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('ClientReport.customerGuide')); ?>" class="text-decoration-none text-dark"><i
                                            class="fas fa-eye"></i> عرض</a>
                                </div>
                            </li>
                            <li class="list-group-item" onclick="window.location.href='customer_blances.html'">
                                <span class="list-icon gradient-purple">
                                    <i class="fa-solid fa-wallet"></i>
                                </span>
                                أرصدة العملاء
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('ClientReport.customerBalances')); ?>" class="text-decoration-none text-dark"><i
                                            class="fas fa-eye"></i> عرض</a>
                                </div>
                            </li>
                            <li class="list-group-item" onclick="window.location.href='client_sales.html'">
                                <span class="list-icon gradient-green">
                                    <i class="fa-solid fa-dollar-sign"></i>
                                </span>
                                مبيعات العملاء
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('ClientReport.customerSales')); ?>" class="text-decoration-none text-dark"><i
                                            class="fas fa-eye"></i> عرض</a>
                                </div>
                            </li>
                            <li class="list-group-item" onclick="window.location.href='customer_payment.html'">
                                <span class="list-icon gradient-blue">
                                    <i class="fa-solid fa-credit-card"></i>
                                </span>
                                مدفوعات العملاء
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('ClientReport.customerPayments')); ?>" class="text-decoration-none text-dark"><i
                                            class="fas fa-eye"></i> عرض</a>
                                </div>
                            </li>
                            <li class="list-group-item" onclick="window.location.href='customer_account.html'">
                                <span class="list-icon gradient-red">
                                    <i class="fa-solid fa-search"></i>
                                </span>
                                كشف حساب العملاء
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('ClientReport.customerAccountStatement')); ?>" class="text-decoration-none text-dark"><i
                                            class="fas fa-eye"></i> عرض</a>
                                </div>
                            </li>
                            <li class="list-group-item" onclick="window.location.href='customer_apptlmition.html'">
                                <span class="list-icon gradient-teal">
                                    <i class="fa-solid fa-users"></i>
                                </span>
                                مواعيد العملاء
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('ClientReport.customerAppointments')); ?>" class="text-decoration-none text-dark"><i
                                            class="fas fa-eye"></i> عرض</a>
                                </div>
                            </li>
                            <li class="list-group-item" onclick="window.location.href='customer_install.html'">
                                <span class="list-icon gradient-purple">
                                    <i class="fa-solid fa-calendar-check"></i>
                                </span>
                                أقساط العملاء
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('ClientReport.customerInstallments')); ?>" class="text-decoration-none text-dark"><i
                                            class="fas fa-eye"></i> عرض</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/reports/customers/index.blade.php ENDPATH**/ ?>