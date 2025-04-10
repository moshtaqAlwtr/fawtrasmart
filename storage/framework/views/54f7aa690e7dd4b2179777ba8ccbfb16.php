<?php $__env->startSection('title'); ?>
    لوحة التحكم
<?php $__env->stopSection(); ?>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<?php $__env->startSection('css'); ?>
    <style>
        .ficon {

                font-size: 16px;
                margin-left: 8px;
            }
            .ml-auto a {
                display: inline-block;
                margin: 7px 10px;
                width: 100%;
                padding: 4px;
            }
            .chart-container {
    width: 100%;
    height: auto;
}

@media (max-width: 576px) {
    canvas {
        max-width: 100% !important;
        height: auto !important;
    }
}

            font-size: 16px;
            margin-left: 8px;
        }

        .ml-auto a {
            display: inline-block;
            margin: 7px 10px;
            width: 100%;
            padding: 4px;
        }

    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-between align-items-center mb-1">
                <div class="mr-1">
                    <p><span><?php echo e(\Carbon\Carbon::now()->translatedFormat('l، d F Y')); ?></span></p>
                    <h4 class="content-header-title float-left mb-0"> أهلاً <strong
                            style="color: #2C2C2C"><?php echo e(auth()->user()->name); ?> ، </strong> مرحباً بعودتك!</h4>
                </div>
                <div class="ml-auto bg-rgba-success">
                    <a href="" class="text-success"><i class="ficon feather icon-globe"></i> <span>الذهاب إلى
                            الموقع</span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">

        <section id="dashboard-ecommerce">
            <div class="row">
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-header d-flex flex-column align-items-start pb-0">
                            <div class="avatar bg-rgba-primary p-50 m-0">
                                <div class="avatar-content">
                                    <i class="feather icon-users text-primary font-medium-5"></i>
                                </div>
                            </div>
                            <h2 class="text-bold-700 mt-1"><?php echo e($ClientCount ?? 0); ?></h2>
                            <p class="mb-0">العملاء</p>
                        </div>
                        <div class="card-content">
                            <div id="line-area-chart-1"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-header d-flex flex-column align-items-start pb-0">
                            <div class="avatar bg-rgba-success p-50 m-0">
                                <div class="avatar-content">
                                    <i class="feather icon-credit-card text-success font-medium-5"></i>
                                </div>
                            </div>
                            <h2 class="text-bold-700 mt-1"> <?php echo e(number_format($Invoice, 2) ?? 0); ?></h2>
                            <p class="mb-0">المبيعات</p>
                        </div>
                        <div class="card-content">
                            <div id="line-area-chart-2"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-header d-flex flex-column align-items-start pb-0">
                            <div class="avatar bg-rgba-danger p-50 m-0">
                                <div class="avatar-content">
                                    <i class="feather icon-shopping-cart text-danger font-medium-5"></i>
                                </div>
                            </div>
                            <h2 class="text-bold-700 mt-1"><?php echo e($Visit ?? 0); ?></h2>
                            <p class="mb-0">الزيارات</p>
                        </div>
                        <div class="card-content">
                            <div id="line-area-chart-3"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-header d-flex flex-column align-items-start pb-0">
                            <div class="avatar bg-rgba-warning p-50 m-0">
                                <div class="avatar-content">
                                    <i class="feather icon-package text-warning font-medium-5"></i>
                                </div>
                            </div>
                            <h2 class="text-bold-700 mt-1">97.5K</h2>
                            <p class="mb-0">الطلبات الواردة</p>
                        </div>
                        <div class="card-content">
                            <div id="line-area-chart-4"></div>
                        </div>
                    </div>
                </div>
            </div>

                <div class="row">
              <div class="col-md-12 col-12">
                  <div class="accordion mb-3" id="summaryAccordion">
    <div class="row mb-3">
    <div class="col-md-4 col-12">
        <div class="card text-center shadow-sm border-success">
            <div class="card-body">
                <h5 class="text-success">إجمالي المبيعات</h5>
                <h3 class="fw-bold"><?php echo e(number_format($totalSales, 2)); ?> ريال</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-12">
        <div class="card text-center shadow-sm border-primary">
            <div class="card-body">
                <h5 class="text-primary">إجمالي المدفوعات</h5>
                <h3 class="fw-bold"><?php echo e(number_format($totalPayments, 2)); ?> ريال</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-12">
        <div class="card text-center shadow-sm border-warning">
            <div class="card-body">
                <h5 class="text-warning">إجمالي سندات القبض</h5>
                <h3 class="fw-bold"><?php echo e(number_format($totalReceipts, 2)); ?> ريال</h3>
            </div>
        </div>
    </div>
</div>



</div>
 <div class="card">
    <div class="card-header">
        <h4 class="card-title">مبيعات المجموعات</h4>
    </div>
    <div class="card-body">
        <div class="chart-container" style="position: relative; width: 100%;">
            <canvas id="group-sales-chart"></canvas>
        </div>
    </div>
</div>

</div>



<!-- السكربت يوضع خارج البلوك -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('group-sales-chart').getContext('2d');

        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($groupChartData->pluck('region')); ?>,
                datasets: [
    {
        label: 'المبيعات',
        data: <?php echo json_encode($groupChartData->pluck('sales')); ?>,
        backgroundColor: 'rgba(54, 162, 235, 0.7)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
    },
    {
        label: 'المدفوعات',
        data: <?php echo json_encode($groupChartData->pluck('payments')); ?>,
        backgroundColor: 'rgba(75, 192, 192, 0.7)',
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 1
    },
    {
        label: 'سندات القبض',
        data: <?php echo json_encode($groupChartData->pluck('receipts')); ?>,
        backgroundColor: 'rgba(255, 159, 64, 0.7)',
        borderColor: 'rgba(255, 159, 64, 1)',
        borderWidth: 1
    }
]

            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'المبلغ (ريال)'
                        }
                    }
                }
            }
        });
    });
</script>


                <!--<div class="col-lg-4 col-12">-->
                <!--    <div class="card chat-application">-->
                <!--        <div class="card-header">-->
                <!--            <h4 class="card-title">الدردشة</h4>-->
                <!--        </div>-->
                <!--        <div class="chat-app-window">-->
                <!--            <div class="user-chats">-->
                <!--                <div class="chats">-->
                <!--                    <div class="chat">-->
                <!--                        <div class="chat-avatar">-->
                <!--                            <a class="avatar m-0" data-toggle="tooltip" href="#" data-placement="right" title="" data-original-title="">-->
                <!--                                <img src="../../../app-assets/images/portrait/small/avatar-s-2.jpg" alt="avatar" height="40" width="40" />-->
                <!--                            </a>-->
                <!--                        </div>-->
                <!--                        <div class="chat-body">-->
                <!--                            <div class="chat-content">-->
                <!--                                <p>كعكة السمسم</p>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                    <div class="chat chat-left">-->
                <!--                        <div class="chat-avatar mt-50">-->
                <!--                            <a class="avatar m-0" data-toggle="tooltip" href="#" data-placement="left" title="" data-original-title="">-->
                <!--                                <img src="../../../app-assets/images/portrait/small/avatar-s-5.jpg" alt="avatar" height="40" width="40" />-->
                <!--                            </a>-->
                <!--                        </div>-->
                <!--                        <div class="chat-body">-->
                <!--                            <div class="chat-content">-->
                <!--                                <p>فطيرة التفاح</p>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                    <div class="chat">-->
                <!--                        <div class="chat-avatar">-->
                <!--                            <a class="avatar m-0" data-toggle="tooltip" href="#" data-placement="right" title="" data-original-title="">-->
                <!--                                <img src="../../../app-assets/images/portrait/small/avatar-s-2.jpg" alt="avatar" height="40" width="40" />-->
                <!--                            </a>-->
                <!--                        </div>-->
                <!--                        <div class="chat-body">-->
                <!--                            <div class="chat-content">-->
                <!--                                <p>كعكة الشوكولاتة</p>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                    <div class="chat chat-left">-->
                <!--                        <div class="chat-avatar mt-50">-->
                <!--                            <a class="avatar m-0" data-toggle="tooltip" href="#" data-placement="left" title="" data-original-title="">-->
                <!--                                <img src="../../../app-assets/images/portrait/small/avatar-s-5.jpg" alt="avatar" height="40" width="40" />-->
                <!--                            </a>-->
                <!--                        </div>-->
                <!--                        <div class="chat-body">-->
                <!--                            <div class="chat-content">-->
                <!--                                <p>دونات</p>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                    <div class="chat">-->
                <!--                        <div class="chat-avatar mt-50">-->
                <!--                            <a class="avatar m-0" data-toggle="tooltip" href="#" data-placement="right" title="" data-original-title="">-->
                <!--                                <img src="../../../app-assets/images/portrait/small/avatar-s-2.jpg" alt="avatar" height="40" width="40" />-->
                <!--                            </a>-->
                <!--                        </div>-->
                <!--                        <div class="chat-body">-->
                <!--                            <div class="chat-content">-->
                <!--                                <p>حلوى عرق السوس</p>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                    <div class="chat chat-left">-->
                <!--                        <div class="chat-avatar mt-50">-->
                <!--                            <a class="avatar m-0" data-toggle="tooltip" href="#" data-placement="left" title="" data-original-title="">-->
                <!--                                <img src="../../../app-assets/images/portrait/small/avatar-s-5.jpg" alt="avatar" height="40" width="40" />-->
                <!--                            </a>-->
                <!--                        </div>-->
                <!--                        <div class="chat-body">-->
                <!--                            <div class="chat-content">-->
                <!--                                <p>حلوى التوفي</p>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                    <div class="chat">-->
                <!--                        <div class="chat-avatar">-->
                <!--                            <a class="avatar m-0" data-toggle="tooltip" href="#" data-placement="right" title="" data-original-title="">-->
                <!--                                <img src="../../../app-assets/images/portrait/small/avatar-s-2.jpg" alt="avatar" height="40" width="40" />-->
                <!--                            </a>-->
                <!--                        </div>-->
                <!--                        <div class="chat-body">-->
                <!--                            <div class="chat-content">-->
                <!--                                <p>فطيرة التفاح</p>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                    <div class="chat chat-left">-->
                <!--                        <div class="chat-avatar mt-50">-->
                <!--                            <a class="avatar m-0" data-toggle="tooltip" href="#" data-placement="left" title="" data-original-title="">-->
                <!--                                <img src="../../../app-assets/images/portrait/small/avatar-s-5.jpg" alt="avatar" height="40" width="40" />-->
                <!--                            </a>-->
                <!--                        </div>-->
                <!--                        <div class="chat-body">-->
                <!--                            <div class="chat-content">-->
                <!--                                <p>كعكة البسكويت</p>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->
                <!--            </div>-->
                <!--            <div class="chat-footer">-->
                <!--                <div class="card-body d-flex justify-content-around pt-0">-->
                <!--                    <input type="text" class="form-control mr-50" placeholder="اكتب رسالتك">-->
                <!--                    <button type="button" class="btn btn-icon btn-primary"><i class="feather icon-navigation"></i></button>-->
                <!--                </div>-->
                <!--            </div>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->
                <div class="col-md-12 col-12">

            <div class="row">
                <div class="col-lg-4 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-end">
                            <h4>مبيعات المجموعات</h4>
                            <div class="dropdown chart-dropdown">

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownItem1">
                                    <a class="dropdown-item" href="#">آخر 28 يوم</a>
                                    <a class="dropdown-item" href="#">الشهر الماضي</a>
                                    <a class="dropdown-item" href="#">العام الماضي</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body pt-0">
                                <div id="sales-chart" class="mb-1"></div>
                                <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="chart-info d-flex justify-content-between mb-1">
                                        <div class="series-info d-flex align-items-center">
                                            <i class="feather icon-layers font-medium-2 text-primary"></i>
                                            <span class="text-bold-600 mx-50"><?php echo e($group->Region->name ?? ''); ?></span>
                                            <span> - <?php echo e(number_format($group->total_sales, 2)); ?> ريال</span>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-4 col-12">

                    <div class="card">
                        <div class="card-header d-flex justify-content-between pb-0">
                            <h4 class="card-title">مبيعات الموظفين</h4>
                            <div class="dropdown chart-dropdown">

                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body py-0">
                                <div id="customer-charts">
                                    <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            var options = {
                                                series: <?php echo json_encode($chartData->pluck('percentage'), 15, 512) ?>,
                                                chart: {
                                                    type: 'donut',
                                                    height: 300
                                                },
                                                labels: <?php echo json_encode($chartData->pluck('name'), 15, 512) ?>,
                                                colors: ['#007bff', '#ffc107', '#dc3545', '#28a745'],
                                                legend: {
                                                    position: 'bottom'
                                                },
                                                dataLabels: {
                                                    formatter: function(val) {
                                                        return val.toFixed(2) + "%";
                                                    }
                                                }
                                            };

                                            var chart = new ApexCharts(document.querySelector("#customer-charts"), options);
                                            chart.render();
                                        });
                                    </script>


                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-6 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-end">
                            <h4 class="card-title">الإيرادات</h4>
                            <p class="font-medium-5 mb-0"><i class="feather icon-settings text-muted cursor-pointer"></i>
                            </p>
                        </div>
                        <div class="card-content">
                            <div class="card-body pb-0">
                                <div class="d-flex justify-content-start">
                                    <div class="mr-2">
                                        <p class="mb-50 text-bold-600">هذا الشهر</p>
                                        <h2 class="text-bold-400">
                                            <sup class="font-medium-1">$</sup>
                                            <span class="text-success">86,589</span>
                                        </h2>
                                    </div>
                                    <div>
                                        <p class="mb-50 text-bold-600">الشهر الماضي</p>
                                        <h2 class="text-bold-400">
                                            <sup class="font-medium-1">$</sup>
                                            <span>73,683</span>
                                        </h2>
                                    </div>

                                </div>
                                <div id="revenue-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-end">
                            <h4 class="mb-0">نظرة عامة على الأهداف</h4>
                            <p class="font-medium-5 mb-0"><i
                                    class="feather icon-help-circle text-muted cursor-pointer"></i></p>
                        </div>
                        <div class="card-content">
                            <div class="card-body px-0 pb-0">
                                <div id="goal-overview-chart" class="mt-75"></div>
                                <div class="row text-center mx-0">
                                    <div class="col-6 border-top border-right d-flex align-items-between flex-column py-1">
                                        <p class="mb-50">مكتمل</p>
                                        <p class="font-large-1 text-bold-700">786,617</p>
                                    </div>
                                    <div class="col-6 border-top d-flex align-items-between flex-column py-1">
                                        <p class="mb-50">قيد التقدم</p>
                                        <p class="font-large-1 text-bold-700">13,561</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">


                <div class="col-md-12 col-12">

</div>

<!-- السكربت يوضع خارج البلوك -->


            </div>
            <div class="row">
              <div class="col-lg-4 col-12">

</div>

                <div class="col-md-4 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">إحصائيات المتصفحات</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-25">
                                    <div class="browser-info">
                                        <p class="mb-25">جوجل كروم</p>
                                        <h4>73%</h4>
                                    </div>
                                    <div class="stastics-info text-right">
                                        <span>800 <i class="feather icon-arrow-up text-success"></i></span>
                                        <span class="text-muted d-block">13:16</span>
                                    </div>
                                </div>
                                <div class="progress progress-bar-primary mb-2">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="73" aria-valuemin="73"
                                        aria-valuemax="100" style="width:73%"></div>
                                </div>
                                <div class="d-flex justify-content-between mb-25">
                                    <div class="browser-info">
                                        <p class="mb-25">أوبرا</p>
                                        <h4>8%</h4>
                                    </div>
                                    <div class="stastics-info text-right">
                                        <span>-200 <i class="feather icon-arrow-down text-danger"></i></span>
                                        <span class="text-muted d-block">13:16</span>
                                    </div>
                                </div>
                                <div class="progress progress-bar-primary mb-2">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="8" aria-valuemin="8"
                                        aria-valuemax="100" style="width:8%"></div>
                                </div>
                                <div class="d-flex justify-content-between mb-25">
                                    <div class="browser-info">
                                        <p class="mb-25">فايرفوكس</p>
                                        <h4>19%</h4>
                                    </div>
                                    <div class="stastics-info text-right">
                                        <span>100 <i class="feather icon-arrow-up text-success"></i></span>
                                        <span class="text-muted d-block">13:16</span>
                                    </div>
                                </div>
                                <div class="progress progress-bar-primary mb-2">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="19" aria-valuemin="19"
                                        aria-valuemax="100" style="width:19%"></div>
                                </div>
                                <div class="d-flex justify-content-between mb-25">
                                    <div class="browser-info">
                                        <p class="mb-25">إنترنت إكسبلورر</p>
                                        <h4>27%</h4>
                                    </div>
                                    <div class="stastics-info text-right">
                                        <span>-450 <i class="feather icon-arrow-down text-danger"></i></span>
                                        <span class="text-muted d-block">13:16</span>
                                    </div>
                                </div>
                                <div class="progress progress-bar-primary mb-50">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="27" aria-valuemin="27"
                                        aria-valuemax="100" style="width:27%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">الاحتفاظ بالعملاء</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div id="client-retention-chart">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-end">
                            <h4>مبيعات المجموعات</h4>
                            <div class="dropdown chart-dropdown">

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownItem1">
                                    <a class="dropdown-item" href="#">آخر 28 يوم</a>
                                    <a class="dropdown-item" href="#">الشهر الماضي</a>
                                    <a class="dropdown-item" href="#">العام الماضي</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body pt-0">
                                <div id="sales-chart" class="mb-1"></div>
                                <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="chart-info d-flex justify-content-between mb-1">
                                        <div class="series-info d-flex align-items-center">
                                            <i class="feather icon-layers font-medium-2 text-primary"></i>
                                            <span class="text-bold-600 mx-50"><?php echo e($group->Region->name ?? ''); ?></span>
                                            <span> - <?php echo e(number_format($group->total_sales, 2)); ?> ريال</span>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card tracking-card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="card-title mb-0">
                            <i class="feather icon-navigation mr-2"></i>
                            نظام تتبع الموقع
                        </h4>
                    </div>
                    <div class="card-body">
                        <div id="location-status" class="tracking-status alert alert-info">
                            جاري تهيئة نظام التتبع...
                        </div>


                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center">
                                <i class="feather icon-clock location-icon"></i>
                                <div>
                                    <div class="text-muted small">آخر تحديث</div>
                                    <div id="last-update" class="font-weight-bold">--:--:--</div>
                                </div>
                            </div>

                            <div>
                                <button id="start-tracking" class="btn btn-primary btn-tracking">
                                    <i class="feather icon-play"></i> بدء التتبع
                                </button>
                                <?php if(Auth::user()->role != 'employee'): ?>
                                    <button id="stop-tracking" class="btn btn-danger btn-tracking">
                                        <i class="feather icon-stop-circle"></i> إيقاف
                                    </button>
                                <?php endif; ?>

                            </div>
                        </div>

                        <div id="nearby-clients"></div>

                        <div class="mt-3 text-center text-muted small">
                            <i class="feather icon-info"></i>
                            سيتم تتبع موقعك تلقائياً عند فتح هذه الصفحة
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (!navigator.geolocation) {
            console.error("❌ المتصفح لا يدعم ميزة تحديد الموقع الجغرافي.");
            return;
        }

        // متغيرات لتخزين الإحداثيات السابقة
        let previousLatitude = null;
        let previousLongitude = null;

        // طلب الوصول إلى الموقع
        requestLocationAccess();

        function requestLocationAccess() {
            navigator.permissions.query({ name: 'geolocation' }).then(function (result) {
                if (result.state === "granted") {
                    // إذا كان الإذن ممنوحًا مسبقًا، ابدأ بمتابعة الموقع
                    watchEmployeeLocation();
                } else if (result.state === "prompt") {
                    // إذا لم يكن الإذن ممنوحًا، اطلبه من المستخدم
                    navigator.geolocation.getCurrentPosition(
                        function () {
                            watchEmployeeLocation();
                        },
                        function (error) {
                            console.error("❌ خطأ في الحصول على الموقع:", error);
                        }
                    );
                } else {
                    console.error("⚠️ الوصول إلى الموقع محظور! يرجى تغييره من إعدادات المتصفح.");
                }
            });
        }

        // دالة لمتابعة تغييرات الموقع
        function watchEmployeeLocation() {
            navigator.geolocation.watchPosition(
                function (position) {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    console.log("📍 الإحداثيات الجديدة:", latitude, longitude);

                    // التحقق من تغيير الموقع
                    if (latitude !== previousLatitude || longitude !== previousLongitude) {
                        console.log("🔄 الموقع تغير، يتم التحديث...");

                        // إرسال البيانات إلى السيرفر
                        fetch("<?php echo e(route('visits.storeEmployeeLocation')); ?>", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>"
                            },
                            body: JSON.stringify({ latitude, longitude })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error("❌ خطأ في الشبكة");
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log("✅ تم تحديث الموقع بنجاح:", data);
                        })
                        .catch(error => {
                            console.error("❌ خطأ في تحديث الموقع:", error);
                        });

                        // تحديث الإحداثيات السابقة
                        previousLatitude = latitude;
                        previousLongitude = longitude;
                    } else {
                        console.log("⏹️ الموقع لم يتغير.");
                    }
                },
                function (error) {
                    console.error("❌ خطأ في متابعة الموقع:", error);
                },
                {
                    enableHighAccuracy: true, // دقة عالية
                    timeout: 5000, // انتظار 5 ثواني
                    maximumAge: 0 // لا تستخدم بيانات موقع قديمة
                }
            );
        }
    });
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var options = {
        chart: {
            type: 'bar',
            height: 350
        },
        series: [{
            name: 'المبيعات',
            data: <?php echo json_encode($groups->pluck('total_sales'), 15, 512) ?>
        }],
        xaxis: {
            categories: <?php echo json_encode($groups->pluck('Region.name'), 15, 512) ?>
        }
    };

    var chart = new ApexCharts(document.querySelector("#sales-chart"), options);
    chart.render();
});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/dashboard/sales/index.blade.php ENDPATH**/ ?>