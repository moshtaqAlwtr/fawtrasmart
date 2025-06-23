<?php $__env->startSection('title'); ?>
    لوحة التحكم
<?php $__env->stopSection(); ?>

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
        
        .branch-card {
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 15px;
            background: #fff;
        }
        
        .attention-item {
            background-color: #fff9f9;
            border-left: 3px solid #ff6b6b;
            transition: all 0.3s ease;
        }
        
        .attention-item:hover {
            background-color: #fff0f0;
            transform: translateY(-2px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        
        .attention-list {
            max-height: 400px;
            overflow-y: auto;
            padding-right: 5px;
        }
        
        .attention-list::-webkit-scrollbar {
            width: 5px;
        }
        
        .attention-list::-webkit-scrollbar-thumb {
            background: #ddd;
            border-radius: 10px;
        }
        
        .smaller {
            font-size: 0.8em;
        }
        
        .district-performance-card {
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            overflow: hidden;
            width: 250px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .district-header {
            background-color: #f8f9fa;
            padding: 12px 16px;
            font-weight: bold;
            font-size: 16px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .district-main {
            padding: 16px;
            text-align: center;
            background-color: #ffffff;
        }
        
        .district-name {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        
        .district-secondary {
            background-color: #f8f9fa;
            border-top: 1px solid #e0e0e0;
        }
        
        .district-sub {
            display: flex;
            justify-content: space-between;
            padding: 12px 16px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .district-sub:last-child {
            border-bottom: none;
        }
        
        .district-sub-name {
            font-size: 14px;
            color: #555;
        }
        
        .district-sub-percentage {
            font-weight: bold;
            color: #28a745;
        }
        
        .district-sub-count {
            font-weight: bold;
            color: #333;
        }
        
        .card:hover {
            transform: scale(1.02);
            transition: all 0.3s ease-in-out;
        }
        
        .progress-bar {
            background-color: #28a745 !important;
            transition: width 0.6s ease;
        }
        
        .text-success {
            color: #28a745 !important;
            font-weight: bold;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-between align-items-center mb-1">
                <div class="mr-1">
                    <p><span><?php echo e(\Carbon\Carbon::now()->translatedFormat('l، d F Y')); ?></span></p>
                    <h4 class="content-header-title float-left mb-0"> أهلاً <strong style="color: #2C2C2C"><?php echo e(auth()->user()->name); ?> ، </strong> مرحباً بعودتك!</h4>
                </div>
                <div class="ml-auto bg-rgba-success">
                    <a href="" class="text-success"><i class="ficon feather icon-globe"></i> <span>الذهاب إلى الموقع</span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">
        <section id="dashboard-ecommerce">
            <!-- بطاقة العملاء حسب الحالة -->
 <!-- البطاقتان في سطر واحد -->
<div class="row">
    <!-- ✅ بطاقة العملاء حسب الحالة -->
    <div class="col-lg-8 col-12 mb-4">
        <div class="card shadow-lg border-0 rounded-4 bg-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="d-flex align-items-center">
                        <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mr-3 shadow" style="width: 70px; height: 70px;">
                            <i class="feather icon-users font-large-1"></i>
                        </div>
                        <div>
                            <h3 class="font-weight-bolder mb-1">العملاء</h3>
                            <h6 class="text-muted">إجمالي العملاء: <span class="text-dark font-weight-bold"><?php echo e($totalClients ?? 0); ?></span></h6>
                        </div>
                    </div>
                    <img src="<?php echo e(asset('images/client-status.png')); ?>" alt="clients" height="60">
                </div>

                <div class="row">
                    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $icon = match($status->name) {
                                'نشط' => 'check-circle',
                                'متابعة' => 'eye',
                                'موقوف' => 'slash',
                                default => 'user'
                            };
                            $color = match($status->name) {
                                'نشط' => 'success',
                                'متابعة' => 'warning',
                                'موقوف' => 'danger',
                                default => 'secondary'
                            };
                        ?>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-3">
                            <div class="card border-0 shadow-sm rounded-3 h-100 bg-white">
                                <div class="card-body d-flex align-items-center">
                                    <div class="avatar bg-<?php echo e($color); ?> text-white rounded-circle d-flex align-items-center justify-content-center mr-3 shadow-sm" style="width: 50px; height: 50px;">
                                        <i class="feather icon-<?php echo e($icon); ?> font-medium-4"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-weight-bold text-dark mb-0"><?php echo e($status->name); ?></h5>
                                        <h4 class="font-weight-bolder text-<?php echo e($color); ?>"><?php echo e($status->clients->count()); ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- ✅ بطاقة المبيعات -->
    <div class="col-lg-4 col-12 mb-4">
        <div class="card shadow-lg border-0 rounded-4 h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar bg-success text-white rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 50px; height: 50px;">
                        <i class="feather icon-credit-card font-medium-4"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold">المبيعات</h5>
                        <small class="text-muted">الإجمالي</small>
                    </div>
                </div>

                <h3 class="text-success font-weight-bold mb-3"><?php echo e(number_format($Invoice, 2) ?? 0); ?> ﷼</h3>

                <ul class="list-unstyled mb-0">
                    <li class="d-flex justify-content-between align-items-center mb-2">
                        <span><i class="feather icon-calendar text-primary mr-1"></i> المبيعات الآجلة</span>
                        <span class="text-dark font-weight-bold">45,000.00 ﷼</span>
                    </li>
                    <li class="d-flex justify-content-between align-items-center mb-2">
                        <span><i class="feather icon-dollar-sign text-warning mr-1"></i> المبيعات النقدية</span>
                        <span class="text-dark font-weight-bold">70,000.00 ﷼</span>
                    </li>
                    <li class="d-flex justify-content-between align-items-center mb-2">
                        <span><i class="feather icon-credit-card text-info mr-1"></i> المدفوعات</span>
                        <span class="text-dark font-weight-bold">5,500.00 ﷼</span>
                    </li>
                    <li class="d-flex justify-content-between align-items-center">
                        <span><i class="feather icon-file-text text-success mr-1"></i> سندات القبض</span>
                        <span class="text-dark font-weight-bold">2,956.00 ﷼</span>
                    </li>
                </ul>

                <div id="line-area-chart-2" style="height: 80px;"></div>
            </div>
        </div>
    </div>
</div>

            <!-- أفضل الفروع والمجموعات والأحياء -->
            <div class="row g-3">
                <?php if($branchesPerformance->count() >= 3): ?>
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold mb-0">⭐ أفضل الفروع أداءً</h5>
                                <a href="<?php echo e(route('statistics.group')); ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-list me-1"></i> عرض الكل
                                </a>
                            </div>

                            <?php $__currentLoopData = $branchesPerformance->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $max = $branchesPerformance->max('total_collected') ?: 1;
                                    $percentage = round($branch->total_collected / $max * 100, 2);
                                    $colors = ['#d8a700', '#a2a6b1', '#a14f03'];
                                    $color = $colors[$index] ?? '#ccc';
                                ?>

                                <div class="mb-4 position-relative">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="fw-bold fs-6 text-truncate"><?php echo e($branch->branch_name); ?></div>
                                        <span class="badge rounded-circle text-white fw-bold" style="background-color: <?php echo e($color); ?>; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                                            <?php echo e($index + 1); ?>

                                        </span>
                                    </div>

                                    <div class="progress mb-1" style="height: 8px; direction: rtl; background-color: #eee;">
                                        <div class="progress-bar" role="progressbar" style="width: <?php echo e(min($percentage, 100)); ?>%;" aria-valuenow="<?php echo e($percentage); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>

                                    <div class="text-end mb-2 text-muted small">
                                        <?php echo e($percentage); ?>٪ من التحصيل الأعلى
                                    </div>

                                    <div class="text-muted small">
                                        🔹 المدفوعات: <strong><?php echo e(number_format($branch->payments)); ?></strong> ر.س<br>
                                        🔹 السندات: <strong><?php echo e(number_format($branch->receipts)); ?></strong> ر.س<br>
                                        🔸 الإجمالي: <strong><?php echo e(number_format($branch->total_collected)); ?></strong> ر.س
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if($regionPerformance->count() >= 3): ?>
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold mb-0">🗺️ أفضل المجموعات أداءً</h5>
                                <a href="<?php echo e(route('statistics.groupall')); ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-list me-1"></i> عرض الكل
                                </a>
                            </div>
                            
                            <?php $__currentLoopData = $regionPerformance->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $max = $regionPerformance->max('total_collected') ?: 1;
                                    $percent = round($region->total_collected / $max * 100, 2);
                                    $colors = ['#d8a700', '#a2a6b1', '#a14f03'];
                                    $color = $colors[$index] ?? '#ccc';
                                ?>

                                <div class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="fw-bold fs-6 text-truncate"><?php echo e($region->region_name); ?></div>
                                        <span class="badge text-white fw-bold rounded-circle" style="background-color: <?php echo e($color); ?>; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                                            <?php echo e($index + 1); ?>

                                        </span>
                                    </div>

                                    <div class="progress mb-1" style="height: 8px; direction: rtl; background-color: #eee;">
                                        <div class="progress-bar" role="progressbar" style="width: <?php echo e($percent); ?>%; background-color: <?php echo e($color); ?>;" aria-valuenow="<?php echo e($percent); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>

                                    <div class="text-end mb-2 text-muted small">
                                        <?php echo e($percent); ?>٪ من الأعلى
                                    </div>

                                    <div class="text-muted small">
                                        🔹 المدفوعات: <strong><?php echo e(number_format($region->payments)); ?></strong> ر.س<br>
                                        🔹 السندات: <strong><?php echo e(number_format($region->receipts)); ?></strong> ر.س<br>
                                        🔸 الإجمالي: <strong><?php echo e(number_format($region->total_collected)); ?></strong> ر.س
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if($neighborhoodPerformance->count() >= 3): ?>
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold mb-0">🏘️ أفضل الأحياء أداءً</h5>
                                <a href="<?php echo e(route('statistics.neighborhood')); ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-list me-1"></i> عرض الكل
                                </a>
                            </div>
                            
                            <?php $__currentLoopData = $neighborhoodPerformance->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $neigh): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $max = $neighborhoodPerformance->max('total_collected') ?: 1;
                                    $percent = round($neigh->total_collected / $max * 100, 2);
                                    $colors = ['#d8a700', '#a2a6b1', '#a14f03'];
                                    $color = $colors[$index] ?? '#ccc';
                                ?>

                                <div class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="fw-bold fs-6 text-truncate"><?php echo e($neigh->neighborhood_name); ?></div>
                                        <span class="badge text-white fw-bold rounded-circle" style="background-color: <?php echo e($color); ?>; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                                            <?php echo e($index + 1); ?>

                                        </span>
                                    </div>

                                    <div class="progress mb-1" style="height: 8px; direction: rtl; background-color: #eee;">
                                        <div class="progress-bar" role="progressbar" style="width: <?php echo e($percent); ?>%; background-color: <?php echo e($color); ?>;" aria-valuenow="<?php echo e($percent); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>

                                    <div class="text-end mb-2 text-muted small">
                                        <?php echo e($percent); ?>٪ من الأعلى
                                    </div>

                                    <div class="text-muted small">
                                        🔹 المدفوعات: <strong><?php echo e(number_format($neigh->payments)); ?></strong> ر.س<br>
                                        🔹 السندات: <strong><?php echo e(number_format($neigh->receipts)); ?></strong> ر.س<br>
                                        🔸 الإجمالي: <strong><?php echo e(number_format($neigh->total_collected)); ?></strong> ر.س
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- متوسط التحصيل والزيارات -->
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card shadow-sm border-0 mb-4">
                                <div class="card-body text-center">
                                    <h5 class="fw-bold mb-3">📊 متوسط تحصيل الفروع</h5>
                                    <div class="display-6 text-primary fw-bold">
                                        <?php echo e(number_format($averageBranchCollection)); ?> <small class="fs-5">ريال</small>
                                    </div>
                                    <p class="text-muted mt-2">متوسط إجمالي التحصيل على مستوى الفروع</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card shadow-sm border-0 mb-4">
                                <div class="card-body text-center">
                                    <h5 class="fw-bold mb-3">🚶‍♂️ إحصائية الزيارات</h5>
                                    <canvas id="visitChart" style="max-width: 200px; max-height: 200px; margin: 0 auto;"></canvas>
                                    <p class="mt-3 text-muted">
                                        <?php echo e(number_format($actualVisits)); ?> زيارة من أصل <?php echo e(number_format($target)); ?>

                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card shadow-sm border-0 mb-4">
                                <div class="card-body text-center">
                                    <h5 class="fw-bold mb-3">💰 إحصائية التحصيل</h5>
                                    <canvas id="collectionChart" style="max-width: 200px; max-height: 200px; margin: 0 auto;"></canvas>
                                    <p class="mt-3 text-muted">
                                        <?php echo e(number_format($totalCollection)); ?> ريال من أصل <?php echo e(number_format($collectionTarget)); ?>

                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- أداء الموظفين -->
            <div class="container py-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0 fw-bold text-primary">أداء الموظفين مقارنة بالهدف الشهري</h4>
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center me-3">
                                    <span class="badge bg-success me-2" style="width: 12px; height: 12px; border-radius: 50%;"></span>
                                    <small>تحقيق 100%+</small>
                                </div>
                                <div class="d-flex align-items-center me-3">
                                    <span class="badge bg-warning me-2" style="width: 12px; height: 12px; border-radius: 50%;"></span>
                                    <small>80% - 99%</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-danger me-2" style="width: 12px; height: 12px; border-radius: 50%;"></span>
                                    <small>أقل من 80%</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <form method="GET" class="mb-3">
                            <div class="row g-2 align-items-center">
                                <div class="col-auto">
                                    <label for="month" class="form-label">اختر الشهر:</label>
                                </div>
                                <div class="col-auto">
                                    <input type="month" name="month" id="month" class="form-control" value="<?php echo e($month); ?>">
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">عرض</button>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="25%">الموظف</th>
                                        <th width="15%">العملاء</th>
                                        <th width="15%" class="text-end">المبالغ المحصله</th>
                                        <th width="15%" class="text-end">الهدف</th>
                                        <th width="25%">النسبة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo e($card['name']); ?></strong>
                                            <div class="text-muted small mt-1">
                                                المدفوعات: <?php echo e(number_format($card['payments'])); ?> ريال<br>
                                                السندات: <?php echo e(number_format($card['receipts'])); ?> ريال<br>
                                                الإجمالي: <?php echo e(number_format($card['total'])); ?> / الهدف: <?php echo e(number_format($card['target'])); ?> ريال
                                            </div>
                                        </td>
                                        <td class="text-end"><?php echo e($card['clients_count']); ?></td>
                                        <td class="text-end"><?php echo e(number_format($card['total'])); ?> ريال</td>
                                        <td class="text-end"><?php echo e(number_format($card['target'])); ?> ريال</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="text-success me-2"><?php echo e($card['percentage']); ?>%</span>
                                                <div class="progress" style="width: 100%; height: 8px;">
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo e($card['percentage']); ?>%;" aria-valuenow="<?php echo e($card['percentage']); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- إحصائيات المبيعات -->
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
            </div>

            <!-- المزيد من الإحصائيات -->
            <div class="row">
                <div class="col-lg-6 col-12">
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

                <div class="col-lg-6 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between pb-0">
                            <h4 class="card-title">مبيعات الموظفين</h4>
                            <div class="dropdown chart-dropdown"></div>
                        </div>
                        <div class="card-content">
                            <div class="card-body py-0">
                                <div id="customer-charts"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- إيرادات الفروع -->
            <div class="container mt-4">
                <div class="row">
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card shadow-sm border-start border-primary border-4 rounded-4">
                            <div class="card-body">
                                <h5 class="mb-3 text-primary fw-bold">فرع الرياض</h5>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2 d-flex justify-content-between">
                                        <span><i class="feather icon-trending-up text-success me-1"></i> الإيرادات</span>
                                        <span class="fw-bold text-success">150,000 ﷼</span>
                                    </li>
                                    <li class="mb-2 d-flex justify-content-between">
                                        <span><i class="feather icon-dollar-sign text-warning me-1"></i> المدفوعات</span>
                                        <span class="fw-bold text-warning">95,000 ﷼</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span><i class="feather icon-arrow-down-circle text-danger me-1"></i> المصروفات</span>
                                        <span class="fw-bold text-danger">35,000 ﷼</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card shadow-sm border-start border-success border-4 rounded-4">
                            <div class="card-body">
                                <h5 class="mb-3 text-success fw-bold">فرع القصيم</h5>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2 d-flex justify-content-between">
                                        <span><i class="feather icon-trending-up text-success me-1"></i> الإيرادات</span>
                                        <span class="fw-bold text-success">120,000 ﷼</span>
                                    </li>
                                    <li class="mb-2 d-flex justify-content-between">
                                        <span><i class="feather icon-dollar-sign text-warning me-1"></i> المدفوعات</span>
                                        <span class="fw-bold text-warning">60,000 ﷼</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span><i class="feather icon-arrow-down-circle text-danger me-1"></i> المصروفات</span>
                                        <span class="fw-bold text-danger">25,000 ﷼</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card shadow-sm border-start border-warning border-4 rounded-4">
                            <div class="card-body">
                                <h5 class="mb-3 text-warning fw-bold">فرع الشرقية</h5>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2 d-flex justify-content-between">
                                        <span><i class="feather icon-trending-up text-success me-1"></i> الإيرادات</span>
                                        <span class="fw-bold text-success">100,000 ﷼</span>
                                    </li>
                                    <li class="mb-2 d-flex justify-content-between">
                                        <span><i class="feather icon-dollar-sign text-warning me-1"></i> المدفوعات</span>
                                        <span class="fw-bold text-warning">70,000 ﷼</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span><i class="feather icon-arrow-down-circle text-danger me-1"></i> المصروفات</span>
                                        <span class="fw-bold text-danger">20,000 ﷼</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card shadow-sm border-start border-danger border-4 rounded-4">
                            <div class="card-body">
                                <h5 class="mb-3 text-danger fw-bold">فرع الغربية</h5>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2 d-flex justify-content-between">
                                        <span><i class="feather icon-trending-up text-success me-1"></i> الإيرادات</span>
                                        <span class="fw-bold text-success">180,000 ﷼</span>
                                    </li>
                                    <li class="mb-2 d-flex justify-content-between">
                                        <span><i class="feather icon-dollar-sign text-warning me-1"></i> المدفوعات</span>
                                        <span class="fw-bold text-warning">80,000 ﷼</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span><i class="feather icon-arrow-down-circle text-danger me-1"></i> المصروفات</span>
                                        <span class="fw-bold text-danger">50,000 ﷼</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // تحديد الموقع الجغرافي
            if (!navigator.geolocation) {
                console.error("❌ المتصفح لا يدعم ميزة تحديد الموقع الجغرافي.");
                return;
            }

            let previousLatitude = null;
            let previousLongitude = null;

            requestLocationAccess();

            function requestLocationAccess() {
                navigator.permissions.query({ name: 'geolocation' }).then(function (result) {
                    if (result.state === "granted") {
                        watchEmployeeLocation();
                    } else if (result.state === "prompt") {
                        navigator.geolocation.getCurrentPosition(
                            function () { watchEmployeeLocation(); },
                            function (error) { console.error("❌ خطأ في الحصول على الموقع:", error); }
                        );
                    } else {
                        console.error("⚠️ الوصول إلى الموقع محظور! يرجى تغييره من إعدادات المتصفح.");
                    }
                });
            }

            function watchEmployeeLocation() {
                navigator.geolocation.watchPosition(
                    function (position) {
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;

                        console.log("📍 الإحداثيات الجديدة:", latitude, longitude);

                        if (latitude !== previousLatitude || longitude !== previousLongitude) {
                            console.log("🔄 الموقع تغير، يتم التحديث...");

                            fetch("<?php echo e(route('visits.storeEmployeeLocation')); ?>", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>"
                                },
                                body: JSON.stringify({ latitude, longitude })
                            })
                            .then(response => {
                                if (!response.ok) throw new Error("❌ خطأ في الشبكة");
                                return response.json();
                            })
                            .then(data => console.log("✅ تم تحديث الموقع بنجاح:", data))
                            .catch(error => console.error("❌ خطأ في تحديث الموقع:", error));

                            previousLatitude = latitude;
                            previousLongitude = longitude;
                        } else {
                            console.log("⏹️ الموقع لم يتغير.");
                        }
                    },
                    function (error) { console.error("❌ خطأ في متابعة الموقع:", error); },
                    { enableHighAccuracy: true, timeout: 5000, maximumAge: 0 }
                );
            }

            // مخطط تحصيل الفروع
            const collectionCtx = document.getElementById('collectionChart').getContext('2d');
            const collectionChart = new Chart(collectionCtx, {
                type: 'doughnut',
                data: {
                    labels: ['المبلغ المحصل', 'المتبقي من الهدف السنوي'],
                    datasets: [{
                        data: [<?php echo e($totalCollection); ?>, <?php echo e(max(0, $collectionTarget - $totalCollection)); ?>],
                        backgroundColor: ['#1cc88a', '#e0e0e0'],
                        hoverBackgroundColor: ['#17a673', '#d1d1d1'],
                        borderWidth: 1,
                    }]
                },
                options: {
                    cutout: '70%',
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ' + context.parsed + ' ريال';
                                }
                            }
                        },
                        legend: { display: true, position: 'bottom' }
                    }
                }
            });

            // مخطط الزيارات
            const visitCtx = document.getElementById('visitChart').getContext('2d');
            const visitChart = new Chart(visitCtx, {
                type: 'doughnut',
                data: {
                    labels: ['الزيارات المنجزة', 'المتبقي من الهدف السنوي'],
                    datasets: [{
                        data: [<?php echo e($actualVisits); ?>, <?php echo e(max(0, $target - $actualVisits)); ?>],
                        backgroundColor: ['#4e73df', '#e0e0e0'],
                        hoverBackgroundColor: ['#2e59d9', '#d1d1d1'],
                        borderWidth: 1,
                    }]
                },
                options: {
                    cutout: '70%',
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ' + context.parsed + ' زيارة';
                                }
                            }
                        },
                        legend: { display: true, position: 'bottom' }
                    }
                }
            });

            // مخطط مبيعات المجموعات
            const groupSalesCtx = document.getElementById('group-sales-chart').getContext('2d');
            const groupSalesChart = new Chart(groupSalesCtx, {
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
                            title: { display: true, text: 'المبلغ (ريال)' }
                        }
                    }
                }
            });

            // مخطط مبيعات الموظفين
            document.addEventListener("DOMContentLoaded", function() {
                var options = {
                    series: <?php echo json_encode($chartData->pluck('percentage'), 15, 512) ?>,
                    chart: { type: 'donut', height: 300 },
                    labels: <?php echo json_encode($chartData->pluck('name'), 15, 512) ?>,
                    colors: ['#007bff', '#ffc107', '#dc3545', '#28a745'],
                    legend: { position: 'bottom' },
                    dataLabels: {
                        formatter: function(val) { return val.toFixed(2) + "%"; }
                    }
                };

                var chart = new ApexCharts(document.querySelector("#customer-charts"), options);
                chart.render();
            });

            // مخطط مبيعات المجموعات
            document.addEventListener("DOMContentLoaded", function() {
                var options = {
                    chart: { type: 'bar', height: 350 },
                    series: [{ name: 'المبيعات', data: <?php echo json_encode($groups->pluck('total_sales'), 15, 512) ?> }],
                    xaxis: { categories: <?php echo json_encode($groups->pluck('Region.name'), 15, 512) ?> }
                };

                var chart = new ApexCharts(document.querySelector("#sales-chart"), options);
                chart.render();
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/dashboard/sales/index.blade.php ENDPATH**/ ?>