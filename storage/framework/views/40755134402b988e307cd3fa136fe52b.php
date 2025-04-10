<?php $__env->startSection('title'); ?>
    تقرير المبيعات بحسب العملاء
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .table-return {
            background-color: #ffdddd !important;
        }
        .text-return {
            color: #dc3545 !important;
        }
        .filter-card {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3>تقرير المبيعات بحسب العملاء</h3>
        </div>

        
        <div class="card-body">
            <div class="filter-card">
                <form action="<?php echo e(route('salesReports.byCustomer')); ?>" method="GET" id="reportForm">
                    <div class="row g-3">
                        


                        <div class="col-md-3">
                            <label class="form-label">العميل</label>
                            <select name="client" class="form-control select2">
                                <option value="">جميع العملاء</option>
                                <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($client->id); ?>"
                                        <?php echo e(request('client') == $client->id ? 'selected' : ''); ?>>
                                        <?php echo e($client->trade_name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">الفرع</label>
                            <select name="branch" class="form-control">
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
                            <select name="status" class="form-control">
                                <option value="">الكل</option>
                                <option value="1" <?php echo e(request('status') == '1' ? 'selected' : ''); ?>>مدفوعة</option>
                                <option value="0" <?php echo e(request('status') == '0' ? 'selected' : ''); ?>>غير مدفوعة</option>
                                <option value="5" <?php echo e(request('status') == '5' ? 'selected' : ''); ?>>مرتجعة</option>
                            </select>
                        </div>

                        


                        
                        <div class="col-md-3">
                            <label class="form-label">تمت الإضافة بواسطة</label>
                            <select name="added_by" class="form-control">
                                <option value="">الكل</option>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($user->id); ?>" <?php echo e(request('added_by') == $user->id ? 'selected' : ''); ?>>
                                        <?php echo e($user->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

                        
                        <div class="col-md-3">
                            <label class="form-label">نوع التقرير</label>
                            <select name="report_type" class="form-control">
                                <option value="">الكل</option>
                                <option value="daily" <?php echo e(request('report_type') == 'daily' ? 'selected' : ''); ?>>يومي
                                </option>
                                <option value="weekly" <?php echo e(request('report_type') == 'weekly' ? 'selected' : ''); ?>>أسبوعي
                                </option>
                                <option value="monthly" <?php echo e(request('report_type') == 'monthly' ? 'selected' : ''); ?>>شهري
                                </option>
                                <option value="yearly" <?php echo e(request('report_type') == 'yearly' ? 'selected' : ''); ?>>سنوي
                                </option>
                                <option value="sales_manager"
                                    <?php echo e(request('report_type') == 'sales_manager' ? 'selected' : ''); ?>>مدير مبيعات</option>
                                <option value="employee" <?php echo e(request('report_type') == 'employee' ? 'selected' : ''); ?>>
                                    موظفين</option>
                                <option value="returns" <?php echo e(request('report_type') == 'returns' ? 'selected' : ''); ?>>مرتجعات
                                </option>
                            </select>
                        </div>

                        <div class="col-md-3 align-self-end">
                            <button type="submit" class="btn btn-primary w-80">
                                <i class="fas fa-filter me-2"></i> تصفية التقرير
                            </button>
                            <a href="<?php echo e(route('salesReports.byCustomer')); ?>" class="btn btn-primary w-20">
                                <i class="fas fa-filter me-2"></i> الغاء الفلتر
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        
        <div class="card-body">
            <div class="table-responsive">
                <table id="salesReportTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>
                                <?php switch($reportPeriod):
                                    case ('daily'): ?>
                                        التاريخ (يومي)
                                    <?php break; ?>
                                    <?php case ('weekly'): ?>
                                        الأسبوع
                                    <?php break; ?>
                                    <?php case ('monthly'): ?>
                                        الشهر
                                    <?php break; ?>
                                    <?php case ('yearly'): ?>
                                        السنة
                                    <?php break; ?>
                                    <?php default: ?>
                                        التاريخ
                                <?php endswitch; ?>
                            </th>
                            <th>العميل</th>
                            <th>رقم الفاتورة</th>
                            <th>الموظف</th>
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

                        <?php $__currentLoopData = $groupedInvoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clientId => $invoices): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            
                            <tr class="table-secondary">
                                <td colspan="8">
                                    <?php echo e($invoices->first()->client->trade_name ?? 'عميل ' . $clientId); ?>

                                </td>
                            </tr>

                            
                            <?php
                                $clientPaidTotal = 0;
                                $clientUnpaidTotal = 0;
                                $clientReturnedTotal = 0;
                                $clientOverallTotal = 0;
                            ?>

                            
                            <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="<?php echo e(in_array($invoice->type, ['return', 'returned']) ? 'table-return text-return' : ''); ?>">
                                    <td>
                                        <?php switch($reportPeriod):
                                            case ('daily'): ?>
                                                <?php echo e(\Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y')); ?>

                                            <?php break; ?>
                                            <?php case ('weekly'): ?>
                                                الأسبوع <?php echo e(\Carbon\Carbon::parse($invoice->invoice_date)->weekOfYear); ?>

                                                (<?php echo e(\Carbon\Carbon::parse($invoice->invoice_date)->startOfWeek()->format('d/m/Y')); ?>

                                                - <?php echo e(\Carbon\Carbon::parse($invoice->invoice_date)->endOfWeek()->format('d/m/Y')); ?>)
                                            <?php break; ?>
                                            <?php case ('monthly'): ?>
                                                <?php echo e(\Carbon\Carbon::parse($invoice->invoice_date)->format('m/Y')); ?>

                                            <?php break; ?>
                                            <?php case ('yearly'): ?>
                                                <?php echo e(\Carbon\Carbon::parse($invoice->invoice_date)->format('Y')); ?>

                                            <?php break; ?>
                                            <?php default: ?>
                                                <?php echo e(\Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y')); ?>

                                        <?php endswitch; ?>
                                    </td>
                                    <td><?php echo e($invoice->client->trade_name ?? 'عميل ' . $clientId); ?></td>
                                    <td><?php echo e(str_pad($invoice->code, 5, '0', STR_PAD_LEFT)); ?></td>
                                    <td><?php echo e($invoice->createdByUser->name ?? 'غير محدد'); ?></td>

                                    <?php
                                        // Calculate total paid amount
                                        $paidAmount = $invoice->payments->sum('amount');
                                        $remainingAmount = $invoice->grand_total - $paidAmount;
                                    ?>

                                    <?php if(in_array($invoice->type, ['return', 'returned'])): ?>
                                        <td>-</td>
                                        <td>-</td>
                                        <td class="text-return">
                                            -<?php echo e(number_format($invoice->grand_total, 2)); ?>

                                        </td>
                                        <td class="text-return">
                                            -<?php echo e(number_format($invoice->grand_total, 2)); ?>

                                        </td>

                                        <?php
                                            $clientReturnedTotal += $invoice->grand_total;
                                            $grandReturnedTotal += $invoice->grand_total;
                                            $clientOverallTotal -= $invoice->grand_total;
                                            $grandOverallTotal -= $invoice->grand_total;
                                        ?>
                                    <?php else: ?>
                                        <td>
                                            <?php echo e(number_format($paidAmount, 2)); ?>

                                        </td>
                                        <td>
                                            <?php echo e(number_format($remainingAmount > 0 ? $remainingAmount : 0, 2)); ?>

                                        </td>
                                        <td>-</td>
                                        <td><?php echo e(number_format($invoice->grand_total, 2)); ?></td>

                                        <?php
                                            $clientPaidTotal += $paidAmount;
                                            $clientUnpaidTotal += max($remainingAmount, 0);
                                            $grandPaidTotal += $paidAmount;
                                            $grandUnpaidTotal += max($remainingAmount, 0);
                                            $clientOverallTotal += $invoice->grand_total;
                                            $grandOverallTotal += $invoice->grand_total;
                                        ?>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            
                            <tr class="table-info">
                                <td colspan="4">مجموع العميل</td>
                                <td><?php echo e(number_format($clientPaidTotal, 2)); ?></td>
                                <td><?php echo e(number_format($clientUnpaidTotal, 2)); ?></td>
                                <td>-<?php echo e(number_format($clientReturnedTotal, 2)); ?></td>
                                <td><?php echo e(number_format($clientPaidTotal + $clientUnpaidTotal - $clientReturnedTotal, 2)); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        
                        <tr class="table-dark">
                            <td colspan="4">المجموع الكلي</td>
                            <td><?php echo e(number_format($grandPaidTotal, 2)); ?></td>
                            <td><?php echo e(number_format($grandUnpaidTotal, 2)); ?></td>
                            <td>-<?php echo e(number_format($grandReturnedTotal, 2)); ?></td>
                            <td><?php echo e(number_format($grandPaidTotal + $grandUnpaidTotal - $grandReturnedTotal, 2)); ?></td>
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
                        <th>
                            <?php switch($reportPeriod):
                                case ('daily'): ?>
                                    التاريخ (يومي)
                                <?php break; ?>
                                <?php case ('weekly'): ?>
                                    الأسبوع
                                <?php break; ?>
                                <?php case ('monthly'): ?>
                                    الشهر
                                <?php break; ?>
                                <?php case ('yearly'): ?>
                                    السنة
                                <?php break; ?>
                                <?php default: ?>
                                    التاريخ
                            <?php endswitch; ?>
                        </th>
                        <th>رقم الفاتورة</th>
                        <th>العميل</th>
                        <th>الموضف</th>
                        <th>مدفوعة (SAR)</th>
                        <th>غير مدفوعة (SAR)</th>
                        <th>مرتجع (SAR)</th>
                        <th>الإجمالي (SAR)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $groupedInvoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clientId => $invoices): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <?php switch($reportPeriod):
                                        case ('daily'): ?>
                                            <?php echo e(\Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y')); ?>

                                        <?php break; ?>
                                        <?php case ('weekly'): ?>
                                            الأسبوع <?php echo e(\Carbon\Carbon::parse($invoice->invoice_date)->weekOfYear); ?>

                                            (<?php echo e(\Carbon\Carbon::parse($invoice->invoice_date)->startOfWeek()->format('d/m/Y')); ?>

                                            - <?php echo e(\Carbon\Carbon::parse($invoice->invoice_date)->endOfWeek()->format('d/m/Y')); ?>)
                                        <?php break; ?>
                                        <?php case ('monthly'): ?>
                                            <?php echo e(\Carbon\Carbon::parse($invoice->invoice_date)->format('m/Y')); ?>

                                        <?php break; ?>
                                        <?php case ('yearly'): ?>
                                            <?php echo e(\Carbon\Carbon::parse($invoice->invoice_date)->format('Y')); ?>

                                        <?php break; ?>
                                        <?php default: ?>
                                            <?php echo e(\Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y')); ?>

                                    <?php endswitch; ?>
                                </td>
                                <td><?php echo e(str_pad($invoice->code, 5, '0', STR_PAD_LEFT)); ?></td>
                                <td><?php echo e($invoice->client->trade_name ?? 'غير محدد'); ?></td>
                                <td><?php echo e($invoice->user->name ?? 'غير محدد'); ?></td>
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
            // Get the table
            const table = document.getElementById('salesReportTable');

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

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/reports/sals/salesRport/Sales_By_Customer.blade.php ENDPATH**/ ?>