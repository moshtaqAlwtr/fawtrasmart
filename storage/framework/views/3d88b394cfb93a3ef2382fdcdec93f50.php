<?php $__env->startSection('title'); ?>
    تقرير المدفوعات حسب طريقة الدفع
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Tajawal', sans-serif;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 10px 20px;
        }
        .table thead th {
            background-color: #4a6cf7;
            color: white;
            font-weight: 500;
        }
        .table tbody tr:hover {
            background-color: rgba(74, 108, 247, 0.1);
        }
        .chart-container {
            position: relative;
            height: 350px;
            margin: 20px 0;
        }
        .summary-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .summary-card h5 {
            color: #4a6cf7;
            font-weight: 600;
        }
        .summary-card .amount {
            font-size: 24px;
            font-weight: 700;
            color: #2d3748;
        }
        .filter-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .form-label {
            font-weight: 600;
            color: #4a5568;
        }
        .export-btn {
            border-radius: 8px;
            margin-left: 10px;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            .card {
                box-shadow: none;
                border: 1px solid #ddd;
            }
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">تقرير المدفوعات حسب طريقة الدفع</h4>
                </div>
                <div class="card-body">
                    <div class="filter-section">
                        <form method="GET" action="<?php echo e(route('salesReports.paymentMethodReport')); ?>">
                            <div class="row g-3">

                                <div class="col-md-3">
                                    <label for="client" class="form-label">العميل</label>
                                    <select name="client" id="client" class="form-control select2">
                                        <option value="">الكل</option>
                                        <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($client->id); ?>" <?php echo e(request('client') == $client->id ? 'selected' : ''); ?>>
                                                <?php echo e($client->trade_name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="collector" class="form-label">تم التحصيل بواسطة</label>
                                    <select name="collector" id="collector" class="form-control select2">
                                        <option value="">الكل</option>
                                        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($employee->id); ?>" <?php echo e(request('collector') == $employee->id ? 'selected' : ''); ?>>
                                                <?php echo e($employee->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="payment_method" class="form-label">وسيلة الدفع</label>
                                    <select name="payment_method" id="payment_method" class="form-control">
                                        <option value="">الكل</option>
                                        <?php $__currentLoopData = $paymentMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($method['id']); ?>" <?php echo e(request('payment_method') == $method['id'] ? 'selected' : ''); ?>>
                                                <?php echo e($method['name']); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="branch" class="form-label">الفرع</label>
                                    <select name="branch" id="branch" class="form-control">
                                        <option value="">الكل</option>
                                        <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($branch->id); ?>" <?php echo e(request('branch') == $branch->id ? 'selected' : ''); ?>>
                                                <?php echo e($branch->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="fromDate" class="form-label">من تاريخ</label>
                                    <input type="date" name="from_date" id="fromDate" class="form-control"
                                           value="<?php echo e(request('from_date', $fromDate->format('Y-m-d'))); ?>">
                                </div>
                                <div class="col-md-3">
                                    <label for="toDate" class="form-label">إلى تاريخ</label>
                                    <input type="date" name="to_date" id="toDate" class="form-control"
                                           value="<?php echo e(request('to_date', $toDate->format('Y-m-d'))); ?>">
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-filter me-2"></i>عرض التقرير
                                    </button>
                                    <a href="<?php echo e(route('salesReports.paymentMethodReport')); ?>" type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-filter me-2"></i>الغاء الفلتر
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="row no-print mb-4">
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="dropdown">
                                    <button class="btn btn-success dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-file-export me-2"></i> تصدير
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                                        <li><a class="dropdown-item" href="#" onclick="exportTo('excel')"><i class="fas fa-file-excel me-2"></i>Excel</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="exportTo('csv')"><i class="fas fa-file-csv me-2"></i>CSV</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="exportTo('pdf')"><i class="fas fa-file-pdf me-2"></i>PDF</a></li>
                                    </ul>
                                </div>
                                <button class="btn btn-secondary ms-2" onclick="window.print()">
                                    <i class="fas fa-print me-2"></i> طباعة
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="btn-group">
                                <button class="btn btn-outline-primary active" data-view="summary">
                                    <i class="fas fa-chart-pie me-2"></i> الملخص
                                </button>
                                <button class="btn btn-outline-primary" data-view="details">
                                    <i class="fas fa-table me-2"></i> التفاصيل
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="summary-card text-center">
                                <h5>إجمالي المدفوعات</h5>
                                <div class="amount text-success"><?php echo e(number_format($summaryTotals['total_paid'], 2)); ?> ر.س</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="summary-card text-center">
                                <h5>إجمالي المتبقي</h5>
                                <div class="amount text-danger"><?php echo e(number_format($summaryTotals['total_unpaid'], 2)); ?> ر.س</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="summary-card text-center">
                                <h5>عدد المدفوعات</h5>
                                <div class="amount text-primary"><?php echo e($payments->count()); ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="chart-container">
                        <canvas id="paymentChart"></canvas>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="paymentsTable">
                            <thead class="table-primary">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="15%">طريقة الدفع</th>
                                    <th width="15%">العميل</th>
                                    <th width="10%">التاريخ</th>
                                    <th width="15%">الموظف</th>
                                    <th width="10%">المبلغ</th>
                                    <th width="15%">المرجع</th>
                                    <th width="15%">ملاحظات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $payments->groupBy('Payment_method'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $methodId => $methodPayments): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php
                                        $methodName = collect($paymentMethods)
                                            ->firstWhere('id', $methodId)['name'] ?? 'غير محدد';
                                    ?>

                                    
                                    <tr class="table-secondary fw-bold">
                                        <td colspan="8"><?php echo e($methodName); ?></td>
                                    </tr>

                                    
                                    <?php $__currentLoopData = $methodPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $invoice = $payment->invoice;
                                        ?>

                                        <?php if($invoice): ?>
                                            <tr>
                                                <td><?php echo e($loop->iteration); ?></td>
                                                <td></td> 
                                                <td><?php echo e($invoice->client->trade_name ?? 'غير محدد'); ?></td>
                                                <td><?php echo e(optional($payment->payment_date)->format('d/m/Y') ?? '--'); ?></td>
                                                <td><?php echo e($invoice->createdByUser->name ?? 'غير محدد'); ?></td>
                                                <td class="text-end"><?php echo e(number_format($payment->amount, 2)); ?> ر.س</td>
                                                <td><?php echo e($payment->reference_number ?? '--'); ?></td>
                                                <td><?php echo e($payment->notes ?? '--'); ?></td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">لا توجد مدفوعات في الفترة المحددة</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.sheetjs.com/xlsx-0.19.3/package/dist/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>

<script>
    // Initialize Chart
    const ctx = document.getElementById('paymentChart').getContext('2d');
    const paymentChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($chartData['labels'], 15, 512) ?>,
            datasets: [{
                label: 'المدفوعات (ر.س)',
                data: <?php echo json_encode($chartData['values'], 15, 512) ?>,
                backgroundColor: 'rgba(74, 108, 247, 0.7)',
                borderColor: 'rgba(74, 108, 247, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    rtl: true
                },
                tooltip: {
                    rtl: true,
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y.toLocaleString() + ' ر.س';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString() + ' ر.س';
                        }
                    }
                },
                x: {
                    ticks: {
                        autoSkip: false,
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            }
        }
    });

    // Export functions
    function exportTo(type) {
        const table = document.getElementById('paymentsTable');
        const fileName = `تقرير_المدفوعات_حسب_طريقة_الدفع_${new Date().toLocaleDateString()}`;

        if (type === 'excel' || type === 'csv') {
            const wb = XLSX.utils.table_to_book(table);
            XLSX.writeFile(wb, `${fileName}.${type}`, { bookType: type });
        } else if (type === 'pdf') {
            // PDF export implementation
            alert('سيتم تطبيق تصدير PDF في الإصدارات القادمة');
        }
    }

    // View toggle
    $('[data-view]').click(function() {
        $('[data-view]').removeClass('active');
        $(this).addClass('active');

        const view = $(this).data('view');
        if (view === 'summary') {
            $('.chart-container').show();
            $('.summary-card').parent().show();
            $('#paymentsTable').hide();
        } else {
            $('.chart-container').hide();
            $('.summary-card').parent().hide();
            $('#paymentsTable').show();
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/reports/sals/payments/payment_method_report.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title'); ?>
    المدفوعات حسب طرق الدفع
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
<link href="<?php echo e(asset('assets/css/report.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">المدفوعات حسب طرق الدفع</h5>
            <form class="row g-3" method="GET" action="<?php echo e(route('salesReports.paymentMethodReport')); ?>">
                <div class="col-md-3">
                    <label for="customerCategory" class="form-label">منشأ الفاتورة:</label>
                    <select name="employee" id="customerCategory" class="form-select">
                        <option value="">الكل</option>
                        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($employee->id); ?>"><?php echo e($employee->trade_name); ?></option>
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
                    <a  href="<?php echo e(route('salesReports.employeePaymentReport')); ?>" class="btn btn-primary w-100">الغاء الفلتر</a>
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex justify-content-between mb-3">
        <div>
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="exportOptions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    خيارات التصدير <i class="fas fa-cloud-download-alt"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="exportOptions">
                    <a class="dropdown-item" href="#" onclick="exportData('csv')">تصدير إلى CSV</a>
                    <a class="dropdown-item" href="#" onclick="exportData('excel')">تصدير إلى Excel</a>
                    <a class="dropdown-item" href="#" onclick="exportData('pdf')">تصدير إلى PDF</a>
                    <a class="dropdown-item" href="#" onclick="exportData('pdfNoGraph')">Export to PDF no graph</a>
                </div>
            </div>
        </div>

        <div>
            <button class="btn btn-print ms-2" onclick="window.print()">
                <i class="fa-solid fa-print"></i> طباعة
            </button>
        </div>
    </div>

    <div class="chart-card">
        <h5 class="text-center">المدفوعات حسب طرق الدفع (SAR)</h5>
        <div class="chart-container">
            <canvas id="barChart" height="120"></canvas>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <h6 class="card-subtitle mb-2 text-muted">
                تقرير مفصل للمدفوعات من <?php echo e($fromDate->format('d/m/Y')); ?> إلى <?php echo e($toDate->format('d/m/Y')); ?>

            </h6>

            <?php
                $currentPaymentMethod = null;
            ?>

            <?php $__empty_1 = true; $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    // Find the payment method name
                    $paymentMethodName = collect($paymentMethods)
                        ->firstWhere('id', $payment->Payment_method)['name'] ?? 'غير محدد';

                    // Check if this is a new payment method
                    if ($currentPaymentMethod !== $paymentMethodName) {
                        $currentPaymentMethod = $paymentMethodName;

                        // Reset totals for this payment method
                        $totalPaid = 0;
                        $totalUnpaid = 0;
                        $totalReference = 0;
                ?>
                    <table class="table table-bordered mb-4">
                        <thead>
                            <tr class="table-primary">
                                <th colspan="7">
                                    <strong>طريقة الدفع: <?php echo e($currentPaymentMethod); ?></strong>
                                </th>
                            </tr>
                            <tr>
                                <th>رقم</th>
                                <th>التاريخ</th>
                                <th>العميل</th>
                                <th>الموظف</th>
                                <th>مدفوعة (SAR)</th>
                                <th>غير مدفوعة (SAR)</th>
                                <th>الإجمالي (SAR)</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?php
                    }

                    // Calculate totals
                    $totalPaid += $payment->amount;
                    $totalUnpaid += $payment->invoice->due_value ?? 0;
                    $totalReference += $payment->reference_number ? $payment->amount : 0;
                    $totalOverall = $payment->amount + ($payment->invoice->due_value ?? 0);
                    ?>

                    <tr>
                        <td><?php echo e($payment->id); ?></td>
                        <td><?php echo e($payment->payment_date->format('d/m/Y')); ?></td>
                        <td><?php echo e($payment->invoice->client->trade_name ?? 'غير محدد'); ?></td>
                        <td><?php echo e($payment->invoice->employee->full_name ?? 'غير محدد'); ?></td>
                        <td><?php echo e(number_format($payment->amount, 2)); ?></td>
                        <td><?php echo e(number_format($payment->invoice->due_value ?? 0, 2)); ?></td>
                        <td><?php echo e(number_format($totalOverall, 2)); ?></td>
                    </tr>

                    <?php if($loop->last ||
                        $paymentMethodName !== (collect($paymentMethods)
                            ->firstWhere('id', $payments[$loop->index + 1]->Payment_method)['name'] ?? null)): ?>
                        <tr class="table-info fw-bold">
                            <td colspan="4">مجموع طريقة الدفع <?php echo e($currentPaymentMethod); ?></td>
                            <td><?php echo e(number_format($totalPaid, 2)); ?></td>
                            <td><?php echo e(number_format($totalUnpaid, 2)); ?></td>
                            <td><?php echo e(number_format($totalPaid + $totalUnpaid, 2)); ?></td>
                        </tr>
                        </tbody>
                    </table>
                    <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="text-center">لا توجد مدفوعات</td>
                </tr>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    // Chart Script
    const ctx = document.getElementById('barChart').getContext('2d');

    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(0, 150, 255, 0.8)');
    gradient.addColorStop(1, 'rgba(0, 255, 255, 0.4)');

    // Calculate total payments for percentage
    const totalPayments = <?php echo json_encode($chartData['values'], 15, 512) ?>.reduce((a, b) => a + b, 0);

    const data = {
        labels: <?php echo json_encode($chartData['labels'], 15, 512) ?>,
        datasets: [{
            label: 'المدفوعات (SAR)',
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
                title: {
                    display: true,
                    text: 'المبلغ (SAR)'
                }
            },
            x: {
                ticks: {
                    autoSkip: false,
                    maxRotation: 45,
                    minRotation: 45,
                    callback: function(value, index) {
                        const label = <?php echo json_encode($chartData['labels'], 15, 512) ?>[index];
                        const amount = <?php echo json_encode($chartData['values'], 15, 512) ?>[index];
                        const percentage = ((amount / totalPayments) * 100).toFixed(2);
                        return `${label} (${percentage}%)`;
                    }
                }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    title: function(context) {
                        return <?php echo json_encode($chartData['labels'], 15, 512) ?>[context[0].dataIndex];
                    },
                    label: function(context) {
                        const value = context.parsed.y;
                        const percentage = ((value / totalPayments) * 100).toFixed(2);
                        return `المبلغ: ${value.toFixed(2)} SAR (${percentage}%)`;
                    }
                }
            }
        }
    };

    new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/reports/sals/payments/payment_method_report.blade.php ENDPATH**/ ?>