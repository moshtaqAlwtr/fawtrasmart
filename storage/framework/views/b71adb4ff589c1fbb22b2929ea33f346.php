<?php $__env->startSection('title'); ?>
تقرير المبيعات
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo e(asset('assets/css/report.css')); ?>">

<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>


<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">تقارير المبيعات</h2>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">الرئيسيه</a>
                        </li>
                        <li class="breadcrumb-item active">عرض
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>


<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fa-solid fa-chart-line"></i>
                            تقارير متابعة الفواتير المقسمة
                        </h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <span class="list-icon orange">
                                    <i class="fa-solid fa-user"></i>
                                </span>
                                المبيعات حسب العميل
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('salesReports.byCustomer')); ?>" class="text-decoration-none">
                                        <i class="fa-solid fa-file-lines"></i> التفاصيل
                                    </a>
                                    <a href="<?php echo e(route('salesReports.byCustomer')); ?>" class="text-decoration-none ms-3">
                                        <i class="fa-solid fa-clipboard"></i> الملخص
                                    </a>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <span class="list-icon red">
                                    <i class="fa-solid fa-user-tie"></i>
                                </span>
                                المبيعات حسب الموظف
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('salesReports.byEmployee')); ?>" class="text-decoration-none">
                                        <i class="fa-solid fa-file-lines"></i> التفاصيل
                                    </a>
                                    <a href="<?php echo e(route('salesReports.byEmployee')); ?>" class="text-decoration-none ms-3">
                                        <i class="fa-solid fa-clipboard"></i> الملخص
                                    </a>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <span class="list-icon green">
                                    <i class="fa-solid fa-handshake"></i>
                                </span>
                                المبيعات حسب مندوب المبيعات
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('salesReports.byEmployee')); ?>" class="text-decoration-none">
                                        <i class="fa-solid fa-file-lines"></i> التفاصيل
                                    </a>
                                    <a href="<?php echo e(route('salesReports.byEmployee')); ?>" class="text-decoration-none ms-3">
                                        <i class="fa-solid fa-clipboard"></i> الملخص
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fa-solid fa-chart-bar"></i>
                            تقارير مبيعات المنتجات بالمدة الزمنية
                        </h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <span class="list-icon blue">
                                    <i class="fa-solid fa-calendar-day"></i>
                                </span>
                                المبيعات اليومية للمنتجات
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('salesReports.byProduct', ['report_period' => 'daily'])); ?>" class="text-decoration-none">
                                        <i class="fa-solid fa-file-lines"></i> التفاصيل
                                    </a>
                                    <a href="<?php echo e(route('salesReports.byProduct', ['report_period' => 'daily'])); ?>" class="text-decoration-none ms-3">
                                        <i class="fa-solid fa-clipboard"></i> الملخص
                                    </a>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <span class="list-icon blue">
                                    <i class="fa-solid fa-calendar-week"></i>
                                </span>
                                المبيعات الأسبوعية للمنتجات
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('salesReports.byProduct', ['report_period' => 'weekly'])); ?>" class="text-decoration-none">
                                        <i class="fa-solid fa-file-lines"></i> التفاصيل
                                    </a>
                                    <a href="<?php echo e(route('salesReports.byProduct', ['report_period' => 'weekly'])); ?>" class="text-decoration-none ms-3">
                                        <i class="fa-solid fa-clipboard"></i> الملخص
                                    </a>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <span class="list-icon blue">
                                    <i class="fa-solid fa-calendar-alt"></i>
                                </span>
                                المبيعات الشهرية للمنتجات
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('salesReports.byProduct', ['report_period' => 'monthly'])); ?>" class="text-decoration-none">
                                        <i class="fa-solid fa-file-lines"></i> التفاصيل
                                    </a>
                                    <a href="<?php echo e(route('salesReports.byProduct', ['report_period' => 'monthly'])); ?>" class="text-decoration-none ms-3">
                                        <i class="fa-solid fa-clipboard"></i> الملخص
                                    </a>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <span class="list-icon blue">
                                    <i class="fa-solid fa-calendar"></i>
                                </span>
                                المبيعات السنوية للمنتجات
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('salesReports.byProduct', ['report_period' => 'yearly'])); ?>" class="text-decoration-none">
                                        <i class="fa-solid fa-file-lines"></i> التفاصيل
                                    </a>
                                    <a href="<?php echo e(route('salesReports.byProduct', ['report_period' => 'yearly'])); ?>" class="text-decoration-none ms-3">
                                        <i class="fa-solid fa-clipboard"></i> الملخص
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>


        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fa-solid fa-chart-line"></i>
                            تقارير الفواتير حسب المدة الزمنية
                        </h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <span class="list-icon blue">
                                    <i class="fa-solid fa-calendar-day"></i>
                                </span>
                                المبيعات اليومية
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('salesReports.byCustomer', ['report_period' => 'daily'])); ?>" class="text-decoration-none">
                                        <i class="fa-solid fa-file-lines"></i> التفاصيل
                                    </a>
                                    <a href="<?php echo e(route('salesReports.byCustomer', ['report_period' => 'daily'])); ?>" class="text-decoration-none ms-3">
                                        <i class="fa-solid fa-clipboard"></i> الملخص
                                    </a>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <span class="list-icon blue">
                                    <i class="fa-solid fa-calendar-week"></i>
                                </span>
                                المبيعات الأسبوعية
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('salesReports.byCustomer', ['report_period' => 'weekly'])); ?>" class="text-decoration-none">
                                        <i class="fa-solid fa-file-lines"></i> التفاصيل
                                    </a>
                                    <a href="<?php echo e(route('salesReports.byCustomer', ['report_period' => 'weekly'])); ?>" class="text-decoration-none ms-3">
                                        <i class="fa-solid fa-clipboard"></i> الملخص
                                    </a>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <span class="list-icon blue">
                                    <i class="fa-solid fa-calendar-alt"></i>
                                </span>
                                المبيعات الشهرية
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('salesReports.byCustomer', ['report_period' => 'monthly'])); ?>" class="text-decoration-none">
                                        <i class="fa-solid fa-file-lines"></i> التفاصيل
                                    </a>
                                    <a href="<?php echo e(route('salesReports.byCustomer', ['report_period' => 'monthly'])); ?>" class="text-decoration-none ms-3">
                                        <i class="fa-solid fa-clipboard"></i> الملخص
                                    </a>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <span class="list-icon blue">
                                    <i class="fa-solid fa-calendar"></i>
                                </span>
                                المبيعات السنوية
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('salesReports.byCustomer', ['report_period' => 'yearly'])); ?>" class="text-decoration-none">
                                        <i class="fa-solid fa-file-lines"></i> التفاصيل
                                    </a>
                                    <a href="<?php echo e(route('salesReports.byCustomer', ['report_period' => 'yearly'])); ?>" class="text-decoration-none ms-3">
                                        <i class="fa-solid fa-clipboard"></i> الملخص
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fa-solid fa-chart-bar"></i>
                            تقارير المدفوعات المقسمة
                        </h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <span class="list-icon orange">
                                    <i class="fa-solid fa-user"></i>
                                </span>
                                المدفوعات حسب العميل
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('salesReports.clientPaymentReport')); ?>" class="text-decoration-none">
                                        <i class="fa-solid fa-file-lines"></i> التفاصيل
                                    </a>
                                    <a href="<?php echo e(route('salesReports.clientPaymentReport')); ?>" class="text-decoration-none ms-3">
                                        <i class="fa-solid fa-clipboard"></i> الملخص
                                    </a>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <span class="list-icon red">
                                    <i class="fa-solid fa-user-tie"></i>
                                </span>
                                المدفوعات حسب الموظف
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('salesReports.employeePaymentReport')); ?>" class="text-decoration-none">
                                        <i class="fa-solid fa-file-lines"></i> التفاصيل
                                    </a>
                                    <a href="<?php echo e(route('salesReports.employeePaymentReport')); ?>" class="text-decoration-none ms-3">
                                        <i class="fa-solid fa-clipboard"></i> الملخص
                                    </a>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <span class="list-icon teal">
                                    <i class="fa-solid fa-cash-register"></i>
                                </span>
                                المدفوعات حسب طريقة الدفع
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('salesReports.paymentMethodReport')); ?>" class="text-decoration-none">
                                        <i class="fa-solid fa-file-lines"></i> التفاصيل
                                    </a>
                                    <a href="<?php echo e(route('salesReports.paymentMethodReport')); ?>" class="text-decoration-none ms-3">
                                        <i class="fa-solid fa-clipboard"></i> الملخص
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fa-solid fa-chart-line"></i>
                            تقارير المدفوعات بالمدة الزمنية
                        </h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <span class="list-icon blue">
                                    <i class="fa-solid fa-calendar-day"></i>
                                </span>
                                المدفوعات اليومية
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('salesReports.patyment', ['report_period' => 'daily'])); ?>" class="text-decoration-none">
                                        <i class="fa-solid fa-file-lines"></i> التفاصيل
                                    </a>
                                    <a href="<?php echo e(route('salesReports.patyment', ['report_period' => 'daily'])); ?>" class="text-decoration-none ms-3">
                                        <i class="fa-solid fa-clipboard"></i> الملخص
                                    </a>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <span class="list-icon blue">
                                    <i class="fa-solid fa-calendar-week"></i>
                                </span>
                                المدفوعات الأسبوعية
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('salesReports.patyment', ['report_period' => 'weekly'])); ?>" class="text-decoration-none">
                                        <i class="fa-solid fa-file-lines"></i> التفاصيل
                                    </a>
                                    <a href="<?php echo e(route('salesReports.patyment', ['report_period' => 'weekly'])); ?>" class="text-decoration-none ms-3">
                                        <i class="fa-solid fa-clipboard"></i> الملخص
                                    </a>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <span class="list-icon blue">
                                    <i class="fa-solid fa-calendar-alt"></i>
                                </span>
                                المدفوعات الشهرية
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('salesReports.patyment', ['report_period' => 'monthly'])); ?>" class="text-decoration-none">
                                        <i class="fa-solid fa-file-lines"></i> التفاصيل
                                    </a>
                                    <a href="<?php echo e(route('salesReports.patyment', ['report_period' => 'monthly'])); ?>" class="text-decoration-none ms-3">
                                        <i class="fa-solid fa-clipboard"></i> الملخص
                                    </a>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <span class="list-icon blue">
                                    <i class="fa-solid fa-calendar"></i>
                                </span>
                                المدفوعات السنوية
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('salesReports.patyment', ['report_period' => 'yearly'])); ?>" class="text-decoration-none">
                                        <i class="fa-solid fa-file-lines"></i> التفاصيل
                                    </a>
                                    <a href="<?php echo e(route('salesReports.patyment', ['report_period' => 'yearly'])); ?>" class="text-decoration-none ms-3">
                                        <i class="fa-solid fa-clipboard"></i> الملخص
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fa-solid fa-chart-bar"></i>
                            أرباح مبيعات الأصناف
                        </h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <span class="list-icon orange">
                                    <i class="fa-solid fa-box"></i>
                                </span>
                                أرباح مبيعات الأصناف - المنتجات
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('salesReports.profits')); ?>" class="text-decoration-none">
                                        <i class="fa-solid fa-eyes"></i> عرض
                                    </a>

                                </div>
                            </li>
                            <li class="list-group-item">
                                <span class="list-icon red">
                                    <i class="fa-solid fa-user"></i>
                                </span>
                                أرباح مبيعات الأصناف - العميل
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('salesReports.customerProfits')); ?>" class="text-decoration-none">
                                        <i class="fa-solid fa-eyes"></i> عرض
                                    </a>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <span class="list-icon green">
                                    <i class="fa-solid fa-user-tie"></i>
                                </span>
                                أرباح مبيعات الأصناف - موظف
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('salesReports.employeeProfits')); ?>" class="text-decoration-none">
                                        <i class="fa-solid fa-eyes"></i> عرض
                                    </a>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <span class="list-icon purple">
                                    <i class="fa-solid fa-handshake"></i>
                                </span>
                                أرباح مبيعات الأصناف - مسؤول مبيعات
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('salesReports.employeeProfits')); ?>" class="text-decoration-none">
                                        <i class="fa-solid fa-eyes"></i> عرض
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fa-solid fa-chart-line"></i>
                            تقارير الربح حسب الفترة
                        </h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <span class="list-icon gradient-blue">
                                    <i class="fa-solid fa-calendar-day"></i>
                                </span>
                                الأرباح اليومية
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('salesReports.ProfitReportTime', ['report_period' => 'daily'])); ?>" class="text-decoration-none">
                                        <i class="fa-solid fa-file-lines"></i> التفاصيل
                                    </a>
                                    <a href="<?php echo e(route('salesReports.ProfitReportTime', ['report_period' => 'daily'])); ?>" class="text-decoration-none ms-3">
                                        <i class="fa-solid fa-clipboard"></i> الملخص
                                    </a>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <span class="list-icon gradient-blue">
                                    <i class="fa-solid fa-calendar-week"></i>
                                </span>
                                الأرباح الأسبوعية
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('salesReports.ProfitReportTime', ['report_period' => 'weekly'])); ?>" class="text-decoration-none">
                                        <i class="fa-solid fa-file-lines"></i> التفاصيل
                                    </a>
                                    <a href="<?php echo e(route('salesReports.ProfitReportTime', ['report_period' => 'weekly'])); ?>" class="text-decoration-none ms-3">
                                        <i class="fa-solid fa-clipboard"></i> الملخص
                                    </a>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <span class="list-icon gradient-blue">
                                    <i class="fa-solid fa-calendar-month"></i>
                                </span>
                                الأرباح الشهرية
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('salesReports.ProfitReportTime', ['report_period' => 'monthly'])); ?>" class="text-decoration-none">
                                        <i class="fa-solid fa-file-lines"></i> التفاصيل
                                    </a>
                                    <a href="<?php echo e(route('salesReports.ProfitReportTime', ['report_period' => 'monthly'])); ?>" class="text-decoration-none ms-3">
                                        <i class="fa-solid fa-clipboard"></i> الملخص
                                    </a>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <span class="list-icon gradient-blue">
                                    <i class="fa-solid fa-calendar"></i>
                                </span>
                                الأرباح السنوية
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('salesReports.ProfitReportTime', ['report_period' => 'yearly'])); ?>" class="text-decoration-none">
                                        <i class="fa-solid fa-file-lines"></i> التفاصيل
                                    </a>
                                    <a href="<?php echo e(route('salesReports.ProfitReportTime', ['report_period' => 'yearly'])); ?>" class="text-decoration-none ms-3">
                                        <i class="fa-solid fa-clipboard"></i> الملخص
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fa-solid fa-chart-bar"></i>
                            تقارير مبيعات البنود المقسمة
                        </h5>
                        <ul class="list-group list-group-flush">
                            <!-- مبيعات البنود حسب البند -->
                            <li class="list-group-item">
                                <span class="list-icon gradient-orange">
                                    <i class="fa-solid fa-box"></i>
                                </span>
                                مبيعات البنود حسب البند
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('salesReports.byItem', ['filter' => 'item'])); ?>" class="text-decoration-none">
                                        <i class="fa-solid fa-file-lines"></i> التفاصيل
                                    </a>
                                    <a href="<?php echo e(route('salesReports.byItem', ['filter' => 'item', 'summary' => true])); ?>" class="text-decoration-none ms-3">
                                        <i class="fa-solid fa-clipboard"></i> الملخص
                                    </a>
                                </div>
                            </li>

                            <!-- مبيعات البنود حسب التصنيف -->
                            <li class="list-group-item">
                                <span class="list-icon gradient-red">
                                    <i class="fa-solid fa-tags"></i>
                                </span>
                                مبيعات البنود حسب التصنيف
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('salesReports.byItem', ['filter' => 'category'])); ?>" class="text-decoration-none">
                                        <i class="fa-solid fa-file-lines"></i> التفاصيل
                                    </a>
                                    <a href="<?php echo e(route('salesReports.byItem', ['filter' => 'category', 'summary' => true])); ?>" class="text-decoration-none ms-3">
                                        <i class="fa-solid fa-clipboard"></i> الملخص
                                    </a>
                                </div>
                            </li>

                            <!-- مبيعات البنود حسب الماركة -->
                            <li class="list-group-item">
                                <span class="list-icon gradient-teal">
                                    <i class="fa-solid fa-tag"></i>
                                </span>
                                مبيعات البنود حسب الماركة
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('salesReports.byItem', ['filter' => 'brand'])); ?>" class="text-decoration-none">
                                        <i class="fa-solid fa-file-lines"></i> التفاصيل
                                    </a>
                                    <a href="<?php echo e(route('salesReports.byItem', ['filter' => 'brand', 'summary' => true])); ?>" class="text-decoration-none ms-3">
                                        <i class="fa-solid fa-clipboard"></i> الملخص
                                    </a>
                                </div>
                            </li>

                            <!-- مبيعات البنود حسب الموظف -->
                            <li class="list-group-item">
                                <span class="list-icon gradient-purple">
                                    <i class="fa-solid fa-user-tie"></i>
                                </span>
                                مبيعات البنود حسب الموظف
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('salesReports.byItem', ['filter' => 'employee'])); ?>" class="text-decoration-none">
                                        <i class="fa-solid fa-file-lines"></i> التفاصيل
                                    </a>
                                    <a href="<?php echo e(route('salesReports.byItem', ['filter' => 'employee', 'summary' => true])); ?>" class="text-decoration-none ms-3">
                                        <i class="fa-solid fa-clipboard"></i> الملخص
                                    </a>
                                </div>
                            </li>

                            <!-- مبيعات البنود حسب مندوب المبيعات -->
                            <li class="list-group-item">
                                <span class="list-icon gradient-green">
                                    <i class="fa-solid fa-handshake"></i>
                                </span>
                                مبيعات البنود حسب مندوب المبيعات
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('salesReports.byItem', ['filter' => 'sales_manager'])); ?>" class="text-decoration-none">
                                        <i class="fa-solid fa-file-lines"></i> التفاصيل
                                    </a>
                                    <a href="<?php echo e(route('salesReports.byItem', ['filter' => 'sales_manager', 'summary' => true])); ?>" class="text-decoration-none ms-3">
                                        <i class="fa-solid fa-clipboard"></i> الملخص
                                    </a>
                                </div>
                            </li>

                            <!-- مبيعات البنود حسب العميل -->
                            <li class="list-group-item">
                                <span class="list-icon gradient-blue">
                                    <i class="fa-solid fa-user"></i>
                                </span>
                                مبيعات البنود حسب العميل
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('salesReports.byItem', ['filter' => 'client'])); ?>" class="text-decoration-none">
                                        <i class="fa-solid fa-file-lines"></i> التفاصيل
                                    </a>
                                    <a href="<?php echo e(route('salesReports.byItem', ['filter' => 'client', 'summary' => true])); ?>" class="text-decoration-none ms-3">
                                        <i class="fa-solid fa-clipboard"></i> الملخص
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>


        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fa-solid fa-chart-line"></i>
                            تقارير تتبع الزيارات
                        </h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <span class="list-icon gradient-blue">
                                    <i class="fa-solid fa-calendar-day"></i>
                                </span>
                                تتبع الزيارات
                                <div class="ms-auto">
                                    <a href="<?php echo e(route('visits.tracktaff')); ?>" class="text-decoration-none">
                                        <i class="fa-solid fa-file-lines"></i>عرض
                                    </a>

                                </div>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>



        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtrasmart\fawtrasmart\resources\views/reports/sals/index.blade.php ENDPATH**/ ?>