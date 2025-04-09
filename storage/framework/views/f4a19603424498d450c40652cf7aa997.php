<?php $__env->startSection('title'); ?>
    تقرير أرباح العملاء
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        :root {
            --primary-color: #2E7D32;
            --secondary-color: #4CAF50;
            --accent-color: #2196F3;
            --warning-color: #FF9800;
            --danger-color: #F44336;
            --light-bg: #F5F5F5;
        }

        body {
            background-color: #f8f9fa;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 1.25rem 1.5rem;
        }

        .insights-badge {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
            border-radius: 50px;
        }

        .filter-card {
            background-color: white;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .filter-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #495057;
        }

        .btn-filter {
            background-color: var(--primary-color);
            color: white;
            border-radius: 6px;
            padding: 0.5rem 1.25rem;
        }

        .btn-filter:hover {
            background-color: #1B5E20;
            color: white;
        }

        .employee-performance-card {
            background-color: white;
            border-radius: 8px;
            padding: 1.25rem;
            height: 100%;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            transition: transform 0.3s ease;
        }

        .employee-performance-card:hover {
            transform: translateY(-5px);
        }

        .table {
            border-radius: 8px;
            overflow: hidden;
        }

        .table thead th {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            padding: 1rem;
        }

        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }

        .table tfoot td {
            font-weight: bold;
            background-color: #e8f5e9;
        }

        .profit-positive {
            color: var(--primary-color);
            font-weight: bold;
        }

        .profit-negative {
            color: var(--danger-color);
            font-weight: bold;
        }


        @media (max-width: 768px) {
            .card-header {
                flex-direction: column;
                align-items: flex-start !important;
            }

            .insights-badge {
                margin-top: 0.5rem;
                margin-left: 0 !important;
            }
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">
                            <i class="fas fa-chart-line me-2"></i>
                            تقرير أرباح العملاء
                        </h3>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-success me-2 insights-badge">
                                <i class="fas fa-coins me-1"></i>
                                إجمالي الربح: <?php echo e(number_format($insights['total_profit'], 2)); ?> ر.س
                            </span>
                            <button id="exportExcel" class="btn btn-success">
                                <i class="fas fa-file-excel me-1"></i> تصدير إكسل
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- فلترة البيانات -->
                        <div class="filter-card">
                            <form method="GET" action="<?php echo e(route('salesReports.customerProfits')); ?>"
                                id="profitsFilterForm">
                                <div class="row g-3">
                                    <!-- فترة التقرير -->
                                    <div class="col-md-3">
                                        <label class="form-label filter-label">
                                            <i class="fas fa-calendar-alt me-2"></i>نوع التقرير
                                        </label>
                                        <select name="report_period" class="form-control select2"
                                            onchange="updateDateRange(this)">
                                            <option value="monthly"
                                                <?php echo e(request('report_period', 'monthly') == 'monthly' ? 'selected' : ''); ?>>
                                                شهري</option>
                                            <option value="weekly"
                                                <?php echo e(request('report_period') == 'weekly' ? 'selected' : ''); ?>>أسبوعي</option>
                                            <option value="daily"
                                                <?php echo e(request('report_period') == 'daily' ? 'selected' : ''); ?>>يومي</option>
                                            <option value="yearly"
                                                <?php echo e(request('report_period') == 'yearly' ? 'selected' : ''); ?>>سنوي</option>
                                        </select>
                                    </div>

                                    <!-- تاريخ البداية -->
                                    <div class="col-md-3">
                                        <label class="form-label filter-label">
                                            <i class="fas fa-calendar-alt me-2"></i>من تاريخ
                                        </label>
                                        <input type="date" name="from_date" class="form-control"
                                            value="<?php echo e(request('from_date', $fromDate)); ?>" id="fromDate">
                                    </div>

                                    <!-- تاريخ النهاية -->
                                    <div class="col-md-3">
                                        <label class="form-label filter-label">
                                            <i class="fas fa-calendar-alt me-2"></i>إلى تاريخ
                                        </label>
                                        <input type="date" name="to_date" class="form-control"
                                            value="<?php echo e(request('to_date', $toDate)); ?>" id="toDate">
                                    </div>

                                    <!-- فلترة العملاء -->
                                    <div class="col-md-3">
                                        <label class="form-label filter-label">
                                            <i class="fas fa-users me-2"></i>العميل
                                        </label>
                                        <select name="client" class="form-control select2">
                                            <option value="">اختر العميل</option>
                                            <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($client->id); ?>"
                                                    <?php echo e(request('client') == $client->id ? 'selected' : ''); ?>>
                                                    <?php echo e($client->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <!-- فلترة المنتجات -->
                                    <div class="col-md-3">
                                        <label class="form-label filter-label">
                                            <i class="fas fa-box me-2"></i>المنتج
                                        </label>
                                        <select name="product" class="form-control select2">
                                            <option value="">اختر المنتج</option>
                                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($product->id); ?>"
                                                    <?php echo e(request('product') == $product->id ? 'selected' : ''); ?>>
                                                    <?php echo e($product->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <!-- فلترة التصنيفات -->
                                    <div class="col-md-3">
                                        <label class="form-label filter-label">
                                            <i class="fas fa-tags me-2"></i>التصنيف
                                        </label>
                                        <select name="category" class="form-control select2">
                                            <option value="">اختر التصنيف</option>
                                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($category->id); ?>"
                                                    <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>>
                                                    <?php echo e($category->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <!-- فلترة الماركات -->
                                    <div class="col-md-3">
                                        <label class="form-label filter-label">
                                            <i class="fas fa-trademark me-2"></i>الماركة
                                        </label>
                                        <select name="brand" class="form-control select2">
                                            <option value="">اختر الماركة</option>
                                            <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($brand); ?>"
                                                    <?php echo e(request('brand') == $brand ? 'selected' : ''); ?>>
                                                    <?php echo e($brand); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <!-- فلترة الفروع -->
                                    <div class="col-md-3">
                                        <label class="form-label filter-label">
                                            <i class="fas fa-store me-2"></i>الفرع
                                        </label>
                                        <select name="branch" class="form-control select2">
                                            <option value="">اختر الفرع</option>
                                            <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($branch->id); ?>"
                                                    <?php echo e(request('branch') == $branch->id ? 'selected' : ''); ?>>
                                                    <?php echo e($branch->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="col-md-12 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary me-2">
                                                    <i class="fas fa-filter me-1"></i> تطبيق الفلتر
                                                </button>
                                                <a href="<?php echo e(route('salesReports.customerProfits')); ?>"
                                                    class="btn btn-outline-secondary">
                                                    <i class="fas fa-redo me-1"></i> إعادة تعيين
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- بطاقات الأداء -->
                        <div class="row mb-4 g-3">
                            <div class="col-md-4">
                                <div class="employee-performance-card">
                                    <h5 class="text-center mb-3 text-warning">
                                        <i class="fas fa-trophy me-2"></i>
                                        أفضل أداء
                                    </h5>
                                    <?php if($insights['top_performing_client']): ?>
                                        <div class="text-center">
                                            <h6><?php echo e($insights['top_performing_client']['name']); ?></h6>
                                            <p class="text-success">
                                                <strong>الربح:
                                                    <?php echo e(number_format($insights['top_performing_client']['profit'], 2)); ?>

                                                    ر.س</strong>
                                            </p>
                                            <small class="text-muted">
                                                إجمالي المبيعات:
                                                <?php echo e(number_format($insights['top_performing_client']['total_value'], 2)); ?>

                                                ر.س
                                            </small>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-center text-muted">لا توجد بيانات</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="employee-performance-card">
                                    <h5 class="text-center mb-3 text-info">
                                        <i class="fas fa-chart-pie me-2"></i>
                                        ملخص الأداء
                                    </h5>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>عدد العملاء</span>
                                        <strong><?php echo e($insights['total_clients']); ?></strong>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>إجمالي الإيرادات</span>
                                        <strong><?php echo e(number_format($insights['total_revenue'], 2)); ?> ر.س</strong>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>هامش الربح المتوسط</span>
                                        <strong><?php echo e(number_format($insights['avg_profit_margin'], 2)); ?>%</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="employee-performance-card">
                                    <h5 class="text-center mb-3 text-danger">
                                        <i class="fas fa-chart-line me-2"></i>
                                        الأداء الأقل
                                    </h5>
                                    <?php if($insights['lowest_performing_client']): ?>
                                        <div class="text-center">
                                            <h6><?php echo e($insights['lowest_performing_client']['name']); ?></h6>
                                            <p class="text-danger">
                                                <strong>الربح:
                                                    <?php echo e(number_format($insights['lowest_performing_client']['profit'], 2)); ?>

                                                    ر.س</strong>
                                            </p>
                                            <small class="text-muted">
                                                إجمالي المبيعات:
                                                <?php echo e(number_format($insights['lowest_performing_client']['total_value'], 2)); ?>

                                                ر.س
                                            </small>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-center text-muted">لا توجد بيانات</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- جدول البيانات -->
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover mb-0" id="clientProfitsTable">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>اسم العميل</th>
                                                <th class="text-end">الكمية المباعة</th>
                                                <th class="text-end">القيمة الإجمالية</th>
                                                <th class="text-end">متوسط سعر البيع</th>
                                                <th class="text-end">التكلفة الإجمالية</th>
                                                <th class="text-end">صافي الربح</th>
                                                <th class="text-end">نسبة الربح</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__empty_1 = true; $__currentLoopData = $clientProfitsReport; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <tr>
                                                    <td><?php echo e($client['name']); ?></td>
                                                    <td class="text-end"><?php echo e(number_format($client['total_quantity'], 2)); ?>

                                                    </td>
                                                    <td class="text-end"><?php echo e(number_format($client['total_value'], 2)); ?>

                                                        ر.س</td>
                                                    <td class="text-end">
                                                        <?php echo e(number_format($client['avg_selling_price'], 2)); ?> ر.س</td>
                                                    <td class="text-end"><?php echo e(number_format($client['total_cost'], 2)); ?> ر.س
                                                    </td>
                                                    <td
                                                        class="text-end <?php echo e($client['profit'] >= 0 ? 'profit-positive' : 'profit-negative'); ?>">
                                                        <?php echo e(number_format($client['profit'], 2)); ?> ر.س
                                                    </td>
                                                    <td
                                                        class="text-end <?php echo e($client['profit_percentage'] >= 0 ? 'profit-positive' : 'profit-negative'); ?>">
                                                        <?php echo e(number_format($client['profit_percentage'], 2)); ?>%
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <tr>
                                                    <td colspan="7" class="text-center py-4">
                                                        <div class="alert alert-info mb-0">
                                                            <i class="fas fa-info-circle me-2"></i>
                                                            لا توجد بيانات للعرض في الفترة المحددة
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                        <tfoot class="table-secondary">
                                            <tr>
                                                <td class="text-end"><strong>الإجمالي</strong></td>
                                                <td class="text-end">
                                                    <?php echo e(number_format($clientProfitsReport->sum('total_quantity'), 2)); ?>

                                                </td>
                                                <td class="text-end">
                                                    <?php echo e(number_format($clientProfitsReport->sum('total_value'), 2)); ?> ر.س
                                                </td>
                                                <td class="text-end">-</td>
                                                <td class="text-end">
                                                    <?php echo e(number_format($clientProfitsReport->sum('total_cost'), 2)); ?> ر.س
                                                </td>
                                                <td class="text-end">
                                                    <?php echo e(number_format($clientProfitsReport->sum('profit'), 2)); ?> ر.س</td>
                                                <td class="text-end">
                                                    <?php echo e(number_format(
                                                        $clientProfitsReport->sum('total_value') > 0
                                                            ? ($clientProfitsReport->sum('profit') / $clientProfitsReport->sum('total_value')) * 100
                                                            : 0,
                                                        2,
                                                    )); ?>%
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2


            // Excel Export
            $('#exportExcel').on('click', function() {
                const table = document.getElementById('clientProfitsTable');
                const wb = XLSX.utils.table_to_book(table, {
                    raw: true,
                    cellDates: true
                });

                const today = new Date();
                const fileName =
                    `تقرير_أرباح_العملاء_${today.getFullYear()}-${today.getMonth() + 1}-${today.getDate()}.xlsx`;

                XLSX.writeFile(wb, fileName);
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/reports/sals/proudect_proifd/customer_profit.blade.php ENDPATH**/ ?>