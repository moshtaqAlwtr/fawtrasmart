<?php $__env->startSection('title'); ?>
    تقرير الأرباح حسب الفترة الزمنية
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/report.css')); ?>">
    <style>
        .profit-positive {
            color: #28a745;
            font-weight: bold;
        }
        .profit-negative {
            color: #e74c3c;
            font-weight: bold;
        }
        .period-header {
            background-color: #f8f9fa;
            font-weight: bold;
            font-size: 1.1rem;
        }
        .total-row {
            background-color: #e9ecef;
        }
        .chart-wrapper {
            background: white;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .table-responsive {
            overflow-x: auto;
        }
        .summary-card {
            transition: all 0.3s ease;
        }
        .summary-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title text-center mb-4">
                    <?php switch($reportPeriod):
                        case ('daily'): ?>
                            <i class="fas fa-calendar-day me-2"></i>تقرير الأرباح اليومي
                        <?php break; ?>
                        <?php case ('weekly'): ?>
                            <i class="fas fa-calendar-week me-2"></i>تقرير الأرباح الأسبوعي
                        <?php break; ?>
                        <?php case ('monthly'): ?>
                            <i class="fas fa-calendar-alt me-2"></i>تقرير الأرباح الشهري
                        <?php break; ?>
                        <?php case ('yearly'): ?>
                            <i class="fas fa-calendar me-2"></i>تقرير الأرباح السنوي
                        <?php break; ?>
                    <?php endswitch; ?>
                </h5>

                <form class="row g-3" method="GET" action="<?php echo e(route('salesReports.ProfitReportTime')); ?>">
                    <!-- فلتر العميل -->
                    <div class="col-md-3">
                        <label for="client" class="form-label"><i class="fas fa-user me-2"></i>العميل</label>
                        <select id="client" name="client" class="form-select">
                            <option value="">الكل</option>
                            <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($client->id); ?>" <?php echo e(request()->input('client') == $client->id ? 'selected' : ''); ?>>
                                    <?php echo e($client->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- فلتر الموظف -->
                    <div class="col-md-3">
                        <label for="employee" class="form-label"><i class="fas fa-user-tie me-2"></i>الموظف</label>
                        <select id="employee" name="employee" class="form-select">
                            <option value="">الكل</option>
                            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($employee->id); ?>" <?php echo e(request()->input('employee') == $employee->id ? 'selected' : ''); ?>>
                                    <?php echo e($employee->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- فلتر الفرع -->
                    <div class="col-md-3">
                        <label for="branch" class="form-label"><i class="fas fa-store me-2"></i>الفرع</label>
                        <select id="branch" name="branch" class="form-select">
                            <option value="">الكل</option>
                            <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($branch->id); ?>" <?php echo e(request()->input('branch') == $branch->id ? 'selected' : ''); ?>>
                                    <?php echo e($branch->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- فلتر المنتج -->
                    <div class="col-md-3">
                        <label for="product" class="form-label"><i class="fas fa-box me-2"></i>المنتج</label>
                        <select id="product" name="product" class="form-select">
                            <option value="">الكل</option>
                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($product->id); ?>" <?php echo e(request()->input('product') == $product->id ? 'selected' : ''); ?>>
                                    <?php echo e($product->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- فلتر التصنيف -->
                    <div class="col-md-3">
                        <label for="category" class="form-label"><i class="fas fa-tags me-2"></i>التصنيف</label>
                        <select id="category" name="category" class="form-select">
                            <option value="">الكل</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>" <?php echo e(request()->input('category') == $category->id ? 'selected' : ''); ?>>
                                    <?php echo e($category->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- فلتر العلامة التجارية -->
                    <div class="col-md-3">
                        <label for="brand" class="form-label"><i class="fas fa-tag me-2"></i>العلامة التجارية</label>
                        <select id="brand" name="brand" class="form-select">
                            <option value="">الكل</option>
                            <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($brand); ?>" <?php echo e(request()->input('brand') == $brand ? 'selected' : ''); ?>>
                                    <?php echo e($brand); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- فلتر فئة العميل -->
                    <div class="col-md-3">
                        <label for="customer_category" class="form-label"><i class="fas fa-users me-2"></i>فئة العميل</label>
                        <select id="customer_category" name="customer_category" class="form-select">
                            <option value="">الكل</option>
                            <?php $__currentLoopData = $customerCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>" <?php echo e(request()->input('customer_category') == $category->id ? 'selected' : ''); ?>>
                                    <?php echo e($category->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- فلتر حالة الفاتورة -->
                    <div class="col-md-3">
                        <label for="status" class="form-label"><i class="fas fa-info-circle me-2"></i>حالة الفاتورة</label>
                        <select id="status" name="status" class="form-select">
                            <option value="">الكل</option>
                            <option value="paid" <?php echo e(request()->input('status') == 'paid' ? 'selected' : ''); ?>>مدفوعة</option>
                            <option value="unpaid" <?php echo e(request()->input('status') == 'unpaid' ? 'selected' : ''); ?>>غير مدفوعة</option>
                            <option value="partially_paid" <?php echo e(request()->input('status') == 'partially_paid' ? 'selected' : ''); ?>>مدفوعة جزئياً</option>
                        </select>
                    </div>

                    <!-- فلتر التاريخ من -->
                    <div class="col-md-3">
                        <label for="from_date" class="form-label"><i class="fas fa-calendar me-2"></i>من تاريخ</label>
                        <input type="date" id="from_date" name="from_date" class="form-control" value="<?php echo e($fromDate); ?>">
                    </div>

                    <!-- فلتر التاريخ إلى -->
                    <div class="col-md-3">
                        <label for="to_date" class="form-label"><i class="fas fa-calendar me-2"></i>إلى تاريخ</label>
                        <input type="date" id="to_date" name="to_date" class="form-control" value="<?php echo e($toDate); ?>">
                    </div>

                    <!-- فلتر نوع التقرير -->
                    <div class="col-md-3">
                        <label for="report_period" class="form-label"><i class="fas fa-chart-line me-2"></i>نوع التقرير</label>
                        <select id="report_period" name="report_period" class="form-select">
                            <option value="daily" <?php echo e($reportPeriod == 'daily' ? 'selected' : ''); ?>>يومي</option>
                            <option value="weekly" <?php echo e($reportPeriod == 'weekly' ? 'selected' : ''); ?>>أسبوعي</option>
                            <option value="monthly" <?php echo e($reportPeriod == 'monthly' ? 'selected' : ''); ?>>شهري</option>
                            <option value="yearly" <?php echo e($reportPeriod == 'yearly' ? 'selected' : ''); ?>>سنوي</option>
                        </select>
                    </div>

                    <!-- أزرار التفعيل -->
                    <div class="col-md-3 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter me-2"></i>عرض التقرير
                        </button>
                        <a href="<?php echo e(route('salesReports.ProfitReportTime')); ?>" class="btn btn-danger w-100">
                            <i class="fas fa-times me-2"></i>إلغاء الفلترة
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- أزرار التحكم -->
        <div class="d-flex justify-content-between mb-3 mt-3">
            <div class="btn-group">
                <button class="btn btn-primary dropdown-toggle" type="button" id="exportOptions" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-cloud-download-alt me-2"></i>خيارات التصدير
                </button>
                <ul class="dropdown-menu" aria-labelledby="exportOptions">
                    <li><a class="dropdown-item" href="#" onclick="exportData('csv')"><i class="fas fa-file-csv me-2"></i>CSV</a></li>
                    <li><a class="dropdown-item" href="#" onclick="exportData('excel')"><i class="fas fa-file-excel me-2"></i>Excel</a></li>
                    <li><a class="dropdown-item" href="#" onclick="exportData('pdf')"><i class="fas fa-file-pdf me-2"></i>PDF</a></li>
                </ul>
                <button class="btn btn-print ms-2" onclick="window.print()">
                    <i class="fa-solid fa-print me-2"></i>طباعة
                </button>
            </div>

            <button class="btn btn-outline-primary" onclick="showCharts()">
                <i class="fas fa-chart-pie me-2"></i>عرض الرسوم البيانية
            </button>
        </div>

        <!-- الرسوم البيانية -->
        <div id="charts-container" class="mb-4" style="display: none;">
            <div class="row">
                <div class="col-md-6">
                    <div class="card chart-wrapper">
                        <div class="card-body">
                            <canvas id="profitTrendChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card chart-wrapper">
                        <div class="card-body">
                            <canvas id="profitDistributionChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- التقرير الرئيسي -->
        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <div class="container mt-4">
                    <h2 class="text-center mb-4">
                        <i class="fas fa-file-invoice-dollar me-2"></i>تقرير الأرباح حسب الفترة الزمنية
                    </h2>

                    <!-- بطاقات الملخص -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card summary-card h-100 border-primary">
                                <div class="card-body text-center">
                                    <h6 class="card-title text-primary">
                                        <i class="fas fa-money-bill-wave me-2"></i>إجمالي الإيرادات
                                    </h6>
                                    <p class="card-text h4"><?php echo e(number_format($insights['total_revenue'], 2)); ?> <small>ر.س</small></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card summary-card h-100 border-warning">
                                <div class="card-body text-center">
                                    <h6 class="card-title text-warning">
                                        <i class="fas fa-money-bill-alt me-2"></i>إجمالي التكاليف
                                    </h6>
                                    <p class="card-text h4"><?php echo e(number_format($insights['total_cost'], 2)); ?> <small>ر.س</small></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card summary-card h-100 <?php echo e($insights['total_profit'] >= 0 ? 'border-success' : 'border-danger'); ?>">
                                <div class="card-body text-center">
                                    <h6 class="card-title <?php echo e($insights['total_profit'] >= 0 ? 'text-success' : 'text-danger'); ?>">
                                        <i class="fas fa-coins me-2"></i>إجمالي الأرباح
                                    </h6>
                                    <p class="card-text h4 <?php echo e($insights['total_profit'] >= 0 ? 'text-success' : 'text-danger'); ?>">
                                        <?php echo e(number_format($insights['total_profit'], 2)); ?> <small>ر.س</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card summary-card h-100 <?php echo e($insights['avg_profit_margin'] >= 0 ? 'border-success' : 'border-danger'); ?>">
                                <div class="card-body text-center">
                                    <h6 class="card-title <?php echo e($insights['avg_profit_margin'] >= 0 ? 'text-success' : 'text-danger'); ?>">
                                        <i class="fas fa-percentage me-2"></i>متوسط هامش الربح
                                    </h6>
                                    <p class="card-text h4 <?php echo e($insights['avg_profit_margin'] >= 0 ? 'text-success' : 'text-danger'); ?>">
                                        <?php echo e(number_format($insights['avg_profit_margin'], 2)); ?>%
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- جدول البيانات -->
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="profitsTable">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>رقم الفاتورة</th>
                                    <th>التاريخ</th>
                                    <th>العميل</th>
                                    <th>الموظف</th>
                                    <th>المنتج</th>
                                    <th>الكمية</th>
                                    <th>سعر الشراء</th>
                                    <th>سعر البيع</th>
                                    <th>الخصم</th>
                                    <th>التكلفة</th>
                                    <th>الإيراد</th>
                                    <th>الربح</th>
                                    <th>نسبة الربح</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $reportData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($index + 1); ?></td>
                                        <td><?php echo e($item['invoice_number']); ?></td>
                                        <td><?php echo e(\Carbon\Carbon::parse($item['date'])->format('Y-m-d')); ?></td>
                                        <td><?php echo e($item['client_name']); ?></td>
                                        <td><?php echo e($item['employee_name']); ?></td>
                                        <td><?php echo e($item['product_name']); ?></td>
                                        <td><?php echo e($item['quantity']); ?></td>
                                        <td><?php echo e(number_format($item['purchase_price'], 2)); ?></td>
                                        <td><?php echo e(number_format($item['selling_price'], 2)); ?></td>
                                        <td><?php echo e(number_format($item['discount'], 2)); ?></td>
                                        <td><?php echo e(number_format($item['cost'], 2)); ?></td>
                                        <td><?php echo e(number_format($item['revenue'], 2)); ?></td>
                                        <td class="<?php echo e($item['profit'] >= 0 ? 'profit-positive' : 'profit-negative'); ?>">
                                            <?php echo e(number_format($item['profit'], 2)); ?>

                                        </td>
                                        <td class="<?php echo e($item['profit_percentage'] >= 0 ? 'profit-positive' : 'profit-negative'); ?>">
                                            <?php echo e(number_format($item['profit_percentage'], 2)); ?>%
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="14" class="text-center">
                                            <div class="alert alert-info">
                                                <i class="fas fa-info-circle me-2"></i>
                                                لا توجد بيانات للعرض في الفترة المحددة
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                            <?php if(count($reportData) > 0): ?>
                                <tfoot>
                                    <tr class="total-row">
                                        <td colspan="6" class="text-end"><strong>المجموع:</strong></td>
                                        <td><?php echo e(array_sum(array_column($reportData, 'quantity'))); ?></td>
                                        <td></td>
                                        <td></td>
                                        <td><?php echo e(number_format(array_sum(array_column($reportData, 'discount')), 2)); ?></td>
                                        <td><?php echo e(number_format($insights['total_cost'], 2)); ?></td>
                                        <td><?php echo e(number_format($insights['total_revenue'], 2)); ?></td>
                                        <td class="<?php echo e($insights['total_profit'] >= 0 ? 'profit-positive' : 'profit-negative'); ?>">
                                            <?php echo e(number_format($insights['total_profit'], 2)); ?>

                                        </td>
                                        <td class="<?php echo e($insights['avg_profit_margin'] >= 0 ? 'profit-positive' : 'profit-negative'); ?>">
                                            <?php echo e(number_format($insights['avg_profit_margin'], 2)); ?>%
                                        </td>
                                    </tr>
                                </tfoot>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
    <script>
        // تصدير البيانات
        function exportData(format) {
            const table = document.getElementById('profitsTable');
            const wb = XLSX.utils.table_to_book(table, {sheet: "تقرير الأرباح", raw: true});
            const today = new Date();
            const fileName = `تقرير_الأرباح_${today.getFullYear()}-${today.getMonth()+1}-${today.getDate()}`;

            try {
                if (format === 'excel') {
                    XLSX.writeFile(wb, `${fileName}.xlsx`);
                    showAlert('success', 'تم التصدير إلى Excel بنجاح');
                }
                else if (format === 'csv') {
                    const csv = XLSX.utils.sheet_to_csv(wb.Sheets[wb.SheetNames[0]]);
                    const blob = new Blob(["\uFEFF" + csv], {type: "text/csv;charset=utf-8"});
                    saveAs(blob, `${fileName}.csv`);
                    showAlert('success', 'تم التصدير إلى CSV بنجاح');
                }
                else if (format === 'pdf') {
                    // يمكنك استخدام مكتبة مثل jsPDF هنا
                    showAlert('info', 'تصدير PDF غير مفعل حالياً');
                }
            } catch (e) {
                console.error(e);
                showAlert('danger', 'حدث خطأ أثناء التصدير');
            }
        }

        // عرض الرسوم البيانية
        function showCharts() {
            const container = document.getElementById('charts-container');
            if (container.style.display === 'none') {
                container.style.display = 'block';
                createProfitTrendChart();
                createProfitDistributionChart();
            } else {
                container.style.display = 'none';
            }
        }

        // رسم مخطط اتجاه الأرباح
        function createProfitTrendChart() {
            const ctx = document.getElementById('profitTrendChart').getContext('2d');

            // تجميع البيانات حسب التاريخ
            const reportData = <?php echo json_encode($reportData); ?>;
            const dates = [...new Set(reportData.map(item => item.date))].sort();
            const profitsByDate = dates.map(date => {
                return reportData.filter(item => item.date === date)
                    .reduce((sum, item) => sum + item.profit, 0);
            });

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dates.map(date => new Date(date).toLocaleDateString('ar-SA')),
                    datasets: [{
                        label: 'الأرباح حسب التاريخ (ر.س)',
                        data: profitsByDate,
                        borderColor: '#4e73df',
                        backgroundColor: 'rgba(78, 115, 223, 0.05)',
                        fill: true,
                        tension: 0.3,
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'اتجاه الأرباح حسب التاريخ',
                            font: {size: 16}
                        },
                        legend: {position: 'bottom'},
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y.toFixed(2) + ' ر.س';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            ticks: {
                                callback: function(value) {
                                    return value + ' ر.س';
                                }
                            }
                        }
                    }
                }
            });
        }

        // رسم مخطط توزيع الأرباح
        function createProfitDistributionChart() {
            const ctx = document.getElementById('profitDistributionChart').getContext('2d');

            // تجميع البيانات حسب المنتج (أعلى 10 منتجات ربحاً)
            const reportData = <?php echo json_encode($reportData); ?>;
            const products = [...new Set(reportData.map(item => item.product_name))];
            const productProfits = products.map(product => {
                return reportData.filter(item => item.product_name === product)
                    .reduce((sum, item) => sum + item.profit, 0);
            });

            // فرز المنتجات حسب الأرباح (تنازلياً)
            const sortedIndices = [...Array(products.length).keys()]
                .sort((a, b) => productProfits[b] - productProfits[a]);

            // أخذ أعلى 10 منتجات فقط
            const topCount = Math.min(10, products.length);
            const topProducts = sortedIndices.slice(0, topCount).map(i => products[i]);
            const topProfits = sortedIndices.slice(0, topCount).map(i => productProfits[i]);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: topProducts,
                    datasets: [{
                        label: 'الأرباح حسب المنتج (ر.س)',
                        data: topProfits,
                        backgroundColor: '#1cc88a',
                        borderColor: '#17a673',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'أعلى 10 منتجات ربحاً',
                            font: {size: 16}
                        },
                        legend: {position: 'bottom'},
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y.toFixed(2) + ' ر.س';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value + ' ر.س';
                                }
                            }
                        }
                    }
                }
            });
        }

        // تحديث نطاق التاريخ عند تغيير نوع التقرير
        document.getElementById('report_period').addEventListener('change', function() {
            const period = this.value;
            const fromDateInput = document.getElementById('from_date');
            const toDateInput = document.getElementById('to_date');
            const today = new Date();

            let fromDate = new Date(today);

            switch(period) {
                case 'daily':
                    fromDate = today;
                    break;
                case 'weekly':
                    fromDate.setDate(today.getDate() - 7);
                    break;
                case 'monthly':
                    fromDate.setMonth(today.getMonth() - 1);
                    break;
                case 'yearly':
                    fromDate.setFullYear(today.getFullYear() - 1);
                    break;
            }

            // تنسيق التاريخ كـ YYYY-MM-DD
            const formatDate = (date) => {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            };

            fromDateInput.value = formatDate(fromDate);
            toDateInput.value = formatDate(today);
        });

        // عرض تنبيه
        function showAlert(type, message) {
            const alert = `<div class="alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;

            $('body').append(alert);
            setTimeout(() => $('.alert').alert('close'), 3000);
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/reports/sals/proudect_proifd/profit_timeline.blade.php ENDPATH**/ ?>