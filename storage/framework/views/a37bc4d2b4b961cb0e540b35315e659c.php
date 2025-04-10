<?php $__env->startSection('title'); ?>
تقرير المبيعات
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<link rel="stylesheet" href="<?php echo e(asset('assets/css/report.css')); ?>">
<style>
    /* أنماط مخصصة لتنسيق التقارير */
    .report-link {
        display: inline-flex;
        align-items: center;
        padding: 5px 10px;
        border-radius: 4px;
        background-color: #f8f9fa;
        color: #333;
        transition: all 0.3s ease;
        border: 1px solid #dee2e6;
        margin-left: 8px;
        font-size: 13px;
    }

    .report-link:hover {
        background-color: #e9ecef;
        text-decoration: none;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .report-link i {
        margin-right: 5px;
        font-size: 12px;
    }

    .report-link.details {
        background-color: #f0f7ff;
        border-color: #cce5ff;
        color: #0062cc;
    }

    .report-link.summary {
        background-color: #f0fff4;
        border-color: #c3e6cb;
        color: #155724;
    }

    .report-link.view {
        background-color: #fff5f5;
        border-color: #f5c6cb;
        color: #721c24;
    }

    .list-group-item {
        display: flex;
        align-items: center;
        padding: 12px 15px;
    }

    .list-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        margin-left: 10px;
        color: white;
        font-size: 14px;
    }

    /* ألوان أيقونات القوائم */
    .orange { background-color: #fd7e14; }
    .red { background-color: #dc3545; }
    .green { background-color: #28a745; }
    .blue { background-color: #007bff; }
    .teal { background-color: #20c997; }
    .purple { background-color: #6f42c1; }
    .gradient-blue { background: linear-gradient(135deg, #007bff, #00b4ff); }
    .gradient-orange { background: linear-gradient(135deg, #fd7e14, #ff9d2e); }
    .gradient-red { background: linear-gradient(135deg, #dc3545, #ff6b6b); }
    .gradient-teal { background: linear-gradient(135deg, #20c997, #3dd5f3); }
    .gradient-purple { background: linear-gradient(135deg, #6f42c1, #9c42f5); }
    .gradient-green { background: linear-gradient(135deg, #28a745, #5cb85c); }

    .card-title i {
        margin-left: 8px;
        color: #5a5a5a;
    }

    .card {
        margin-bottom: 20px;
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .card-body {
        padding: 1.25rem;
    }

    .content-header-title {
        font-weight: 600;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">تقارير المبيعات</h2>
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
        <!-- تقارير متابعة الفواتير المقسمة -->
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
                            <span class="flex-grow-1">المبيعات حسب العميل</span>
                            <div class="d-flex">
                                <a href="<?php echo e(route('salesReports.byCustomer')); ?>" class="report-link details">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="<?php echo e(route('salesReports.byCustomer')); ?>" class="report-link summary">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon red">
                                <i class="fa-solid fa-user-tie"></i>
                            </span>
                            <span class="flex-grow-1">المبيعات حسب الموظف</span>
                            <div class="d-flex">
                                <a href="<?php echo e(route('salesReports.byEmployee')); ?>" class="report-link details">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="<?php echo e(route('salesReports.byEmployee')); ?>" class="report-link summary">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon green">
                                <i class="fa-solid fa-handshake"></i>
                            </span>
                            <span class="flex-grow-1">المبيعات حسب مندوب المبيعات</span>
                            <div class="d-flex">
                                <a href="<?php echo e(route('salesReports.byEmployee')); ?>" class="report-link details">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="<?php echo e(route('salesReports.byEmployee')); ?>" class="report-link summary">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- تقارير مبيعات المنتجات بالمدة الزمنية -->
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
                            <span class="flex-grow-1">المبيعات اليومية للمنتجات</span>
                            <div class="d-flex">
                                <a href="<?php echo e(route('salesReports.byProduct', ['report_period' => 'daily'])); ?>" class="report-link details">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="<?php echo e(route('salesReports.byProduct', ['report_period' => 'daily'])); ?>" class="report-link summary">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon blue">
                                <i class="fa-solid fa-calendar-week"></i>
                            </span>
                            <span class="flex-grow-1">المبيعات الأسبوعية للمنتجات</span>
                            <div class="d-flex">
                                <a href="<?php echo e(route('salesReports.byProduct', ['report_period' => 'weekly'])); ?>" class="report-link details">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="<?php echo e(route('salesReports.byProduct', ['report_period' => 'weekly'])); ?>" class="report-link summary">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon blue">
                                <i class="fa-solid fa-calendar-alt"></i>
                            </span>
                            <span class="flex-grow-1">المبيعات الشهرية للمنتجات</span>
                            <div class="d-flex">
                                <a href="<?php echo e(route('salesReports.byProduct', ['report_period' => 'monthly'])); ?>" class="report-link details">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="<?php echo e(route('salesReports.byProduct', ['report_period' => 'monthly'])); ?>" class="report-link summary">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon blue">
                                <i class="fa-solid fa-calendar"></i>
                            </span>
                            <span class="flex-grow-1">المبيعات السنوية للمنتجات</span>
                            <div class="d-flex">
                                <a href="<?php echo e(route('salesReports.byProduct', ['report_period' => 'yearly'])); ?>" class="report-link details">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="<?php echo e(route('salesReports.byProduct', ['report_period' => 'yearly'])); ?>" class="report-link summary">
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
        <!-- تقارير الفواتير حسب المدة الزمنية -->
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
                            <span class="flex-grow-1">المبيعات اليومية</span>
                            <div class="d-flex">
                                <a href="<?php echo e(route('salesReports.byCustomer', ['report_period' => 'daily'])); ?>" class="report-link details">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="<?php echo e(route('salesReports.byCustomer', ['report_period' => 'daily'])); ?>" class="report-link summary">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon blue">
                                <i class="fa-solid fa-calendar-week"></i>
                            </span>
                            <span class="flex-grow-1">المبيعات الأسبوعية</span>
                            <div class="d-flex">
                                <a href="<?php echo e(route('salesReports.byCustomer', ['report_period' => 'weekly'])); ?>" class="report-link details">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="<?php echo e(route('salesReports.byCustomer', ['report_period' => 'weekly'])); ?>" class="report-link summary">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon blue">
                                <i class="fa-solid fa-calendar-alt"></i>
                            </span>
                            <span class="flex-grow-1">المبيعات الشهرية</span>
                            <div class="d-flex">
                                <a href="<?php echo e(route('salesReports.byCustomer', ['report_period' => 'monthly'])); ?>" class="report-link details">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="<?php echo e(route('salesReports.byCustomer', ['report_period' => 'monthly'])); ?>" class="report-link summary">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon blue">
                                <i class="fa-solid fa-calendar"></i>
                            </span>
                            <span class="flex-grow-1">المبيعات السنوية</span>
                            <div class="d-flex">
                                <a href="<?php echo e(route('salesReports.byCustomer', ['report_period' => 'yearly'])); ?>" class="report-link details">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="<?php echo e(route('salesReports.byCustomer', ['report_period' => 'yearly'])); ?>" class="report-link summary">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- تقارير المدفوعات المقسمة -->
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
                            <span class="flex-grow-1">المدفوعات حسب العميل</span>
                            <div class="d-flex">
                                <a href="<?php echo e(route('salesReports.clientPaymentReport')); ?>" class="report-link details">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="<?php echo e(route('salesReports.clientPaymentReport')); ?>" class="report-link summary">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon red">
                                <i class="fa-solid fa-user-tie"></i>
                            </span>
                            <span class="flex-grow-1">المدفوعات حسب الموظف</span>
                            <div class="d-flex">
                                <a href="<?php echo e(route('salesReports.employeePaymentReport')); ?>" class="report-link details">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="<?php echo e(route('salesReports.employeePaymentReport')); ?>" class="report-link summary">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon teal">
                                <i class="fa-solid fa-cash-register"></i>
                            </span>
                            <span class="flex-grow-1">المدفوعات حسب طريقة الدفع</span>
                            <div class="d-flex">
                                <a href="<?php echo e(route('salesReports.paymentMethodReport')); ?>" class="report-link details">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="<?php echo e(route('salesReports.paymentMethodReport')); ?>" class="report-link summary">
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
        <!-- تقارير المدفوعات بالمدة الزمنية -->
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
                            <span class="flex-grow-1">المدفوعات اليومية</span>
                            <div class="d-flex">
                                <a href="<?php echo e(route('salesReports.patyment', ['report_period' => 'daily'])); ?>" class="report-link details">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="<?php echo e(route('salesReports.patyment', ['report_period' => 'daily'])); ?>" class="report-link summary">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon blue">
                                <i class="fa-solid fa-calendar-week"></i>
                            </span>
                            <span class="flex-grow-1">المدفوعات الأسبوعية</span>
                            <div class="d-flex">
                                <a href="<?php echo e(route('salesReports.patyment', ['report_period' => 'weekly'])); ?>" class="report-link details">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="<?php echo e(route('salesReports.patyment', ['report_period' => 'weekly'])); ?>" class="report-link summary">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon blue">
                                <i class="fa-solid fa-calendar-alt"></i>
                            </span>
                            <span class="flex-grow-1">المدفوعات الشهرية</span>
                            <div class="d-flex">
                                <a href="<?php echo e(route('salesReports.patyment', ['report_period' => 'monthly'])); ?>" class="report-link details">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="<?php echo e(route('salesReports.patyment', ['report_period' => 'monthly'])); ?>" class="report-link summary">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon blue">
                                <i class="fa-solid fa-calendar"></i>
                            </span>
                            <span class="flex-grow-1">المدفوعات السنوية</span>
                            <div class="d-flex">
                                <a href="<?php echo e(route('salesReports.patyment', ['report_period' => 'yearly'])); ?>" class="report-link details">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="<?php echo e(route('salesReports.patyment', ['report_period' => 'yearly'])); ?>" class="report-link summary">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- أرباح مبيعات الأصناف -->
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
                            <span class="flex-grow-1">أرباح مبيعات الأصناف - المنتجات</span>
                            <div class="d-flex">
                                <a href="<?php echo e(route('salesReports.profits')); ?>" class="report-link view">
                                    <i class="fa-solid fa-eye"></i> عرض
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon red">
                                <i class="fa-solid fa-user"></i>
                            </span>
                            <span class="flex-grow-1">أرباح مبيعات الأصناف - العميل</span>
                            <div class="d-flex">
                                <a href="<?php echo e(route('salesReports.customerProfits')); ?>" class="report-link view">
                                    <i class="fa-solid fa-eye"></i> عرض
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon green">
                                <i class="fa-solid fa-user-tie"></i>
                            </span>
                            <span class="flex-grow-1">أرباح مبيعات الأصناف - موظف</span>
                            <div class="d-flex">
                                <a href="<?php echo e(route('salesReports.employeeProfits')); ?>" class="report-link view">
                                    <i class="fa-solid fa-eye"></i> عرض
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon purple">
                                <i class="fa-solid fa-handshake"></i>
                            </span>
                            <span class="flex-grow-1">أرباح مبيعات الأصناف - مسؤول مبيعات</span>
                            <div class="d-flex">
                                <a href="<?php echo e(route('salesReports.employeeProfits')); ?>" class="report-link view">
                                    <i class="fa-solid fa-eye"></i> عرض
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- تقارير الربح حسب الفترة -->
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
                            <span class="flex-grow-1">الأرباح اليومية</span>
                            <div class="d-flex">
                                <a href="<?php echo e(route('salesReports.ProfitReportTime', ['report_period' => 'daily'])); ?>" class="report-link details">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="<?php echo e(route('salesReports.ProfitReportTime', ['report_period' => 'daily'])); ?>" class="report-link summary">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon gradient-blue">
                                <i class="fa-solid fa-calendar-week"></i>
                            </span>
                            <span class="flex-grow-1">الأرباح الأسبوعية</span>
                            <div class="d-flex">
                                <a href="<?php echo e(route('salesReports.ProfitReportTime', ['report_period' => 'weekly'])); ?>" class="report-link details">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="<?php echo e(route('salesReports.ProfitReportTime', ['report_period' => 'weekly'])); ?>" class="report-link summary">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon gradient-blue">
                                <i class="fa-solid fa-calendar-month"></i>
                            </span>
                            <span class="flex-grow-1">الأرباح الشهرية</span>
                            <div class="d-flex">
                                <a href="<?php echo e(route('salesReports.ProfitReportTime', ['report_period' => 'monthly'])); ?>" class="report-link details">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="<?php echo e(route('salesReports.ProfitReportTime', ['report_period' => 'monthly'])); ?>" class="report-link summary">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon gradient-blue">
                                <i class="fa-solid fa-calendar"></i>
                            </span>
                            <span class="flex-grow-1">الأرباح السنوية</span>
                            <div class="d-flex">
                                <a href="<?php echo e(route('salesReports.ProfitReportTime', ['report_period' => 'yearly'])); ?>" class="report-link details">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="<?php echo e(route('salesReports.ProfitReportTime', ['report_period' => 'yearly'])); ?>" class="report-link summary">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- تقارير مبيعات البنود المقسمة -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fa-solid fa-chart-bar"></i>
                        تقارير مبيعات البنود المقسمة
                    </h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <span class="list-icon gradient-orange">
                                <i class="fa-solid fa-box"></i>
                            </span>
                            <span class="flex-grow-1">مبيعات البنود حسب البند</span>
                            <div class="d-flex">
                                <a href="<?php echo e(route('salesReports.byItem', ['filter' => 'item'])); ?>" class="report-link details">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="<?php echo e(route('salesReports.byItem', ['filter' => 'item', 'summary' => true])); ?>" class="report-link summary">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon gradient-red">
                                <i class="fa-solid fa-tags"></i>
                            </span>
                            <span class="flex-grow-1">مبيعات البنود حسب التصنيف</span>
                            <div class="d-flex">
                                <a href="<?php echo e(route('salesReports.byItem', ['filter' => 'category'])); ?>" class="report-link details">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="<?php echo e(route('salesReports.byItem', ['filter' => 'category', 'summary' => true])); ?>" class="report-link summary">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon gradient-teal">
                                <i class="fa-solid fa-tag"></i>
                            </span>
                            <span class="flex-grow-1">مبيعات البنود حسب الماركة</span>
                            <div class="d-flex">
                                <a href="<?php echo e(route('salesReports.byItem', ['filter' => 'brand'])); ?>" class="report-link details">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="<?php echo e(route('salesReports.byItem', ['filter' => 'brand', 'summary' => true])); ?>" class="report-link summary">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon gradient-purple">
                                <i class="fa-solid fa-user-tie"></i>
                            </span>
                            <span class="flex-grow-1">مبيعات البنود حسب الموظف</span>
                            <div class="d-flex">
                                <a href="<?php echo e(route('salesReports.byItem', ['filter' => 'employee'])); ?>" class="report-link details">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="<?php echo e(route('salesReports.byItem', ['filter' => 'employee', 'summary' => true])); ?>" class="report-link summary">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon gradient-green">
                                <i class="fa-solid fa-handshake"></i>
                            </span>
                            <span class="flex-grow-1">مبيعات البنود حسب مندوب المبيعات</span>
                            <div class="d-flex">
                                <a href="<?php echo e(route('salesReports.byItem', ['filter' => 'sales_manager'])); ?>" class="report-link details">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="<?php echo e(route('salesReports.byItem', ['filter' => 'sales_manager', 'summary' => true])); ?>" class="report-link summary">
                                    <i class="fa-solid fa-clipboard"></i> الملخص
                                </a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="list-icon gradient-blue">
                                <i class="fa-solid fa-user"></i>
                            </span>
                            <span class="flex-grow-1">مبيعات البنود حسب العميل</span>
                            <div class="d-flex">
                                <a href="<?php echo e(route('salesReports.byItem', ['filter' => 'client'])); ?>" class="report-link details">
                                    <i class="fa-solid fa-file-lines"></i> التفاصيل
                                </a>
                                <a href="<?php echo e(route('salesReports.byItem', ['filter' => 'client', 'summary' => true])); ?>" class="report-link summary">
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
        <!-- تقارير تتبع الزيارات -->
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
                            <span class="flex-grow-1">تتبع الزيارات</span>
                            <div class="d-flex">
                                <a href="<?php echo e(route('visits.tracktaff')); ?>" class="report-link view">
                                    <i class="fa-solid fa-eye"></i> عرض
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

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/reports/sals/index.blade.php ENDPATH**/ ?>