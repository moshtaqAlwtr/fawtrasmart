<?php $__env->startSection('title'); ?>
    تقرير المبيعات حسب الموظف
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/report.css')); ?>">
    <style>
        .table-return {
            background-color: #fff3f3 !important;
        }
        .text-return {
            color: #dc3545 !important;
        }
        .stat-box {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            margin-bottom: 15px;
        }
        .stat-value {
            font-size: 1.5rem;
            font-weight: bold;
            color: #007bff;
        }
        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4">
    
    <div class="content-header row mb-3">
        <div class="content-header-left col-md-9 col-12">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-start mb-0">تقارير مبيعات الموظفين</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                            <li class="breadcrumb-item active">تقرير المبيعات</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="card mb-3">
        <div class="card-body">
            <form action="<?php echo e(route('salesReports.byEmployee')); ?>" method="GET" id="reportForm">
                <div class="row g-3">
                    
                    <div class="col-md-3">
                        <label class="form-label">العميل</label>
                        <select name="customer" class="form-select">
                            <option value="">جميع العملاء</option>
                            <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($client->id); ?>"
                                    <?php echo e(request('customer') == $client->id ? 'selected' : ''); ?>>
                                    <?php echo e($client->trade_name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    
                    <div class="col-md-3">
                        <label class="form-label">أضيفت بواسطة</label>
                        <select name="user" class="form-select">
                            <option value="">جميع الموظفين</option>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($user->id); ?>"
                                    <?php echo e(request('user') == $user->id ? 'selected' : ''); ?>>
                                    <?php echo e($user->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    
                    <div class="col-md-3">
                        <label class="form-label">الفرع</label>
                        <select name="branch" class="form-select">
                            <option value="">جميع الفروع</option>
                            <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($branch->id); ?>"
                                    <?php echo e(request('branch') == $branch->id ? 'selected' : ''); ?>>
                                    <?php echo e($branch->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    
                    <div class="col-md-3">
                        <label class="form-label">حالة الدفع</label>
                        <select name="status" class="form-select">
                            <option value="">الكل</option>
                            <option value="1" <?php echo e(request('status') == '1' ? 'selected' : ''); ?>>مدفوعة</option>
                            <option value="0" <?php echo e(request('status') == '0' ? 'selected' : ''); ?>>غير مدفوعة</option>
                            <option value="5" <?php echo e(request('status') == '5' ? 'selected' : ''); ?>>مرتجعة</option>
                        </select>
                    </div>

                    
                    <div class="col-md-3">
                        <label class="form-label">الفترة</label>
                        <select name="report_period" class="form-select">
                            <option value="daily" <?php echo e($reportPeriod == 'daily' ? 'selected' : ''); ?>>يومي</option>
                            <option value="weekly" <?php echo e($reportPeriod == 'weekly' ? 'selected' : ''); ?>>أسبوعي</option>
                            <option value="monthly" <?php echo e($reportPeriod == 'monthly' ? 'selected' : ''); ?>>شهري</option>
                            <option value="yearly" <?php echo e($reportPeriod == 'yearly' ? 'selected' : ''); ?>>سنوي</option>
                        </select>
                    </div>

                    
                    <div class="col-md-3">
                        <label class="form-label">من تاريخ</label>
                        <input type="date" name="from_date" class="form-control"
                            value="<?php echo e($fromDate->format('Y-m-d')); ?>">
                    </div>

                    
                    <div class="col-md-3">
                        <label class="form-label">إلى تاريخ</label>
                        <input type="date" name="to_date" class="form-control"
                            value="<?php echo e($toDate->format('Y-m-d')); ?>">
                    </div>

                    <div class="col-md-3 align-self-end">
                        <button type="submit" class="btn btn-primary w-80">
                            <i class="fas fa-filter me-2"></i> تصفية التقرير
                        </button>
                        <a href="<?php echo e(route('salesReports.byEmployee')); ?>" class="btn btn-primary w-20">
                            <i class="fas fa-filter me-2"></i> الغاء الفلتر
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    
    <div class="card mb-3 no-print">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <a href="javascript:void(0)" class="btn btn-success me-2"id="exportExcel">
                    <i class="fas fa-file-export me-2"></i> تصدير إكسل
                </a>

                <button class="btn btn-info" id="printBtn">
                    <i class="fas fa-print me-2"></i> طباعة
                </button>
            </div>

            <div class="d-flex align-items-center">
                
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-primary active" id="summaryViewBtn">
                        <i class="fas fa-chart-pie me-2"></i> ملخص
                    </button>
                    <button type="button" class="btn btn-outline-primary" id="detailViewBtn">
                        <i class="fas fa-list me-2"></i> تفاصيل
                    </button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h5>إجمالي المبيعات</h5>
                    <h3><?php echo e(number_format($totals['total_sales'], 2)); ?> SAR</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h5>المبالغ المدفوعة</h5>
                    <h3><?php echo e(number_format($totals['paid_amount'], 2)); ?> SAR</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <h5>المبالغ غير المدفوعة</h5>
                    <h3><?php echo e(number_format($totals['unpaid_amount'], 2)); ?> SAR</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body text-center">
                    <h5>المبالغ المرتجعة</h5>
                    <h3><?php echo e(number_format($totals['total_returns'], 2)); ?> SAR</h3>
                </div>
            </div>
        </div>
    </div>

    
    <div class="card mt-3" id="mainReportTable">
        <div class="card-header">
            <h5 class="card-title">
                تقرير المبيعات من <?php echo e($fromDate->format('d/m/Y')); ?> إلى <?php echo e($toDate->format('d/m/Y')); ?>

            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>الموظف</th>
                            <th>رقم الفاتورة</th>
                            <th>التاريخ</th>
                            <th>العميل</th>
                            <th>مدفوعة (SAR)</th>
                            <th>غير مدفوعة (SAR)</th>
                            <th>مرتجع (SAR)</th>
                            <th>الإجمالي (SAR)</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php
                            $grandPaidTotal = 0;
                            $grandUnpaidTotal = 0;
                            $grandReturnedTotal = 0;
                            $grandOverallTotal = 0;
                        ?>

                        <?php $__currentLoopData = $groupedInvoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employeeId => $invoices): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            
                            <tr class="table-secondary">
                                <td colspan="8">
                                    <?php echo e($invoices->first()->employee->full_name ?? 'موظف ' . $employeeId); ?>

                                </td>
                            </tr>

                            
                            <?php
                                $employeePaidTotal = 0;
                                $employeeUnpaidTotal = 0;
                                $employeeReturnedTotal = 0;
                                $employeeOverallTotal = 0;
                            ?>

                            
                            <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="<?php echo e(in_array($invoice->type, ['return', 'returned']) ? 'table-return text-return' : ''); ?>">
                                    <td><?php echo e($invoice->employee->full_name ?? 'موظف ' . $employeeId); ?></td>
                                    <td><?php echo e(str_pad($invoice->code, 5, '0', STR_PAD_LEFT)); ?></td>
                                    <td><?php echo e(\Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y')); ?></td>
                                    <td><?php echo e($invoice->client->trade_name ?? 'غير محدد'); ?></td>

                                    <?php if(in_array($invoice->type, ['return', 'returned'])): ?>
                                        <td>-</td>
                                        <td>-</td>
                                        <td class="text-return">
                                            <?php echo e(number_format($invoice->grand_total, 2)); ?>

                                        </td>
                                        <td class="text-return">
                                            <?php echo e(number_format($invoice->grand_total, 2)); ?>

                                        </td>

                                        <?php
                                            $employeeReturnedTotal += $invoice->grand_total;
                                            $grandReturnedTotal += $invoice->grand_total;
                                        ?>
                                    <?php else: ?>
                                        <td>
                                            <?php echo e(number_format($invoice->payment_status == 1 ? $invoice->grand_total : $invoice->paid_amount, 2)); ?>

                                        </td>
                                        <td>
                                            <?php echo e(number_format($invoice->payment_status == 1 ? 0 : $invoice->due_value, 2)); ?>

                                        </td>
                                        <td>-</td>
                                        <td><?php echo e(number_format($invoice->grand_total, 2)); ?></td>

                                        <?php
                                            if ($invoice->payment_status == 1) {
                                                $employeePaidTotal += $invoice->grand_total;
                                                $grandPaidTotal += $invoice->grand_total;
                                            } else {
                                                $employeeUnpaidTotal += $invoice->due_value;
                                                $grandUnpaidTotal += $invoice->due_value;
                                            }
                                            $employeeOverallTotal += $invoice->grand_total;
                                            $grandOverallTotal += $invoice->grand_total;
                                        ?>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            
                            <tr class="table-info">
                                <td colspan="4">مجموع الموظف</td>
                                <td><?php echo e(number_format($employeePaidTotal, 2)); ?></td>
                                <td><?php echo e(number_format($employeeUnpaidTotal, 2)); ?></td>
                                <td><?php echo e(number_format($employeeReturnedTotal, 2)); ?></td>
                                <td><?php echo e(number_format($employeePaidTotal + $employeeUnpaidTotal + $employeeReturnedTotal, 2)); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        
                        <tr class="table-dark">
                            <td colspan="4">المجموع الكلي</td>
                            <td><?php echo e(number_format($grandPaidTotal, 2)); ?></td>
                            <td><?php echo e(number_format($grandUnpaidTotal, 2)); ?></td>
                            <td><?php echo e(number_format($grandReturnedTotal, 2)); ?></td>
                            <td><?php echo e(number_format($grandPaidTotal + $grandUnpaidTotal + $grandReturnedTotal, 2)); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
    <div class="card mt-4" id="detailedReportTable" style="display: none;">
        <div class="card-body">
            <h6 class="card-subtitle mb-2 text-muted">
                التفاصيل الكاملة للتقرير
            </h6>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>رقم الفاتورة</th>
                        <th>التاريخ</th>
                        <th>العميل</th>
                        <th>الموظف</th>
                        <th>مدفوعة (SAR)</th>
                        <th>غير مدفوعة (SAR)</th>
                        <th>مرتجع (SAR)</th>
                        <th>الإجمالي (SAR)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $groupedInvoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employeeId => $invoices): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e(str_pad($invoice->code, 5, '0', STR_PAD_LEFT)); ?></td>
                                <td><?php echo e(\Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y')); ?></td>
                                <td><?php echo e($invoice->client->trade_name ?? 'غير محدد'); ?></td>
                                <td><?php echo e($invoice->createdByUser->name ?? 'غير محدد'); ?></td>
                                <td>
                                    <?php echo e(number_format($invoice->payment_status == 1 ? $invoice->grand_total : $invoice->paid_amount, 2)); ?>

                                </td>
                                <td>
                                    <?php echo e(number_format($invoice->payment_status == 1 ? 0 : $invoice->due_value, 2)); ?>

                                </td>
                                <td>
                                    <?php echo e(number_format(in_array($invoice->type, ['return', 'returned']) ? $invoice->grand_total : 0, 2)); ?>

                                </td>
                                <td><?php echo e(number_format($invoice->grand_total, 2)); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>

<script>
$(document).ready(function() {
    // Excel Export
    $('#exportExcel').on('click', function() {
        // Get the table (use the main report table)
        const table = document.querySelector('#mainReportTable table');

        // Create a new workbook and worksheet
        const wb = XLSX.utils.table_to_book(table, {
            raw: true,
            cellDates: true
        });

        // Generate file name with current date
        const today = new Date();
        const fileName = `تقرير_المبيعات_${today.getFullYear()}-${today.getMonth() + 1}-${today.getDate()}.xlsx`;

        // Export the workbook
        XLSX.writeFile(wb, fileName);
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/reports/sals/salesRport/Sales_By_Employee.blade.php ENDPATH**/ ?>