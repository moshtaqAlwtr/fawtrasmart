<?php $__env->startSection('title'); ?>
    المدفوعات حسب العميل
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            background-color: #f4f7fc;
            font-family: 'Tajawal', sans-serif;
        }

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .btn-primary {
            background: linear-gradient(45deg, #6a11cb, #2575fc);
            border: none;
        }

        .table thead {
            background: linear-gradient(45deg, #42a5f5, #1e88e5);
            color: #fff;
        }

        .table tbody tr {
            transition: background-color 0.3s;
        }

        .table tbody tr:hover {
            background-color: #f0f0f5;
        }

        .chart-card {
            background-color: #f0f8ff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">المدفوعات حسب العميل</h5>
            <form class="row g-3" method="GET" action="<?php echo e(route('salesReports.clientPaymentReport')); ?>">
                <div class="col-md-3">
                    <label for="customerCategory" class="form-label">منشأ الفاتورة:</label>
                    <select name="customer_category" id="customerCategory" class="form-select">
                        <option value="">الكل</option>
                        <?php $__currentLoopData = $customerCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="collector" class="form-label">تم التحصيل بواسطة</label>
                    <select name="collector" id="collector" class="form-select">
                        <option value="">الكل</option>
                        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($employee->id); ?>"><?php echo e($employee->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="payment_method" class="form-label">وسيلة الدفع</label>
                    <select name="payment_method" id="payment_method" class="form-select">
                        <option value="">الكل</option>
                        <?php $__currentLoopData = $paymentMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($method['id']); ?>"><?php echo e($method['name']); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="client" class="form-label">العميل:</label>
                    <select name="client" id="client" class="form-select">
                        <option value="">الكل</option>
                        <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($client->id); ?>"><?php echo e($client->trade_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="fromDate" class="form-label">الفترة من:</label>
                    <input type="date" name="from_date" id="fromDate" class="form-control"
                           value="<?php echo e($fromDate->format('Y-m-d')); ?>">
                </div>
                <div class="col-md-3">
                    <label for="toDate" class="form-label">إلى:</label>
                    <input type="date" name="to_date" id="toDate" class="form-control"
                           value="<?php echo e($toDate->format('Y-m-d')); ?>">
                </div>
                <div class="col-md-3">
                    <label for="branch" class="form-label">فرع:</label>
                    <select name="branch" id="branch" class="form-select">
                        <option value="">الكل</option>
                        <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($branch->id); ?>"><?php echo e($branch->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">عرض التقرير</button>
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex justify-content-between mb-3">
        <div>
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="exportOptions" data-bs-toggle="dropdown" aria-expanded="false">
                    خيارات التصدير <i class="fas fa-cloud-download-alt"></i>
                </button>
                <ul class="dropdown-menu" aria-labelledby="exportOptions">
                    <li><a class="dropdown-item" href="#" onclick="exportData('csv')">تصدير إلى CSV</a></li>
                    <li><a class="dropdown-item" href="#" onclick="exportData('excel')">تصدير إلى Excel</a></li>
                    <li><a class="dropdown-item" href="#" onclick="exportData('pdf')">تصدير إلى PDF</a></li>
                    <li><a class="dropdown-item" href="#" onclick="exportData('pdfNoGraph')">تصدير بدون رسم بياني</a></li>
                </ul>
            </div>
            <button onclick="exportTable('csv')" class="btn btn-outline-success btn-sm">
                <i class="fas fa-file-csv me-1"></i> CSV
            </button>
            <button onclick="exportTable('excel')" class="btn btn-outline-success btn-sm">
                <i class="fas fa-file-excel me-1"></i> Excel
            </button>
        </div>

        <div>
            <button class="btn btn-print ms-2" onclick="window.print()">
                <i class="fas fa-print"></i> طباعة
            </button>
        </div>

        <div>
            <button class="btn btn-outline-secondary">
                <i class="fas fa-search"></i> التفاصيل
            </button>
            <button class="btn btn-outline-secondary ms-2">
                <i class="fas fa-user"></i> العميل
            </button>
            <button class="btn btn-outline-secondary ms-2">
                <i class="fas fa-clipboard"></i> الملخص
            </button>
        </div>
    </div>

    <div class="chart-card">
        <h5 class="text-center">المدفوعات حسب العميل (SAR)</h5>
        <div class="chart-container">
            <canvas id="barChart" height="120"></canvas>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <h6 class="card-subtitle mb-2 text-muted">
                تقرير مفصل للمدفوعات من <?php echo e($fromDate->format('d/m/Y')); ?> إلى <?php echo e($toDate->format('d/m/Y')); ?>

            </h6>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>رقم</th>
                        <th>التاريخ</th>
                        <th>العميل</th>
                        <th>الموظف</th>
                        <th>وسيلة الدفع</th>
                        <th>المبلغ (SAR)</th>
                        <th>المرجع</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($payment->id); ?></td>
                        <td><?php echo e($payment->payment_date->format('d/m/Y')); ?></td>
                        <td><?php echo e($payment->invoice->client->trade_name ?? 'غير محدد'); ?></td>
                        <td><?php echo e($payment->invoice->employee->full_name ?? 'غير محدد'); ?></td>
                        <td>
                            <?php switch($payment->payment_status):
                                case (1): ?> نقدي <?php break; ?>
                                <?php case (2): ?> شيك <?php break; ?>
                                <?php case (3): ?> تحويل بنكي <?php break; ?>
                                <?php case (4): ?> بطاقة ائتمان <?php break; ?>
                                <?php default: ?> غير محدد
                            <?php endswitch; ?>
                        </td>
                        <td><?php echo e(number_format($payment->amount, 2)); ?></td>
                        <td><?php echo e($payment->reference_number ?? 'غير محدد'); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center">لا توجد مدفوعات</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('barChart').getContext('2d');

    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(0, 150, 255, 0.8)');
    gradient.addColorStop(1, 'rgba(0, 255, 255, 0.4)');

    const data = {
        labels: <?php echo json_encode($chartData['labels'], 15, 512) ?>,
        datasets: [{
            label: 'المجموع',
            data: <?php echo json_encode($chartData['values'], 15, 512) ?>,
            backgroundColor: gradient,
            borderColor: 'rgba(0, 123, 255, 1)',
            borderWidth: 1
        }]
    };

    const options = {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(200, 200, 200, 0.2)'
                }
            },
            x: {
                ticks: {
                    autoSkip: false,
                    maxRotation: 90,
                    minRotation: 90
                }
            }
        },
        plugins: {
            legend: {
                display: true,
                labels: {
                    boxWidth: 20,
                    boxHeight: 15,
                    color: 'rgba(0, 123, 255, 1)'
                }
            }
        }
    };

    const barChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options
    });

    // Export functions (to be implemented)
    function exportData(type) {
        alert('سيتم تصدير البيانات بصيغة ' + type);
    }
    function exportTable(type) {
            const table = document.getElementById('paymentsTable');
            const wb = XLSX.utils.table_to_book(table);

            if (type === 'csv') {
                XLSX.writeFile(wb, 'payments_report.csv');
            } else {
                XLSX.writeFile(wb, 'payments_report.xlsx');
            }
        }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/reports/sals/payments/client_report.blade.php ENDPATH**/ ?>