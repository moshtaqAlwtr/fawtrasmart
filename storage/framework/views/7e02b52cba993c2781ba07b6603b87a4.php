<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body {
            font-family: DejaVu Sans;
            direction: rtl;
            font-size: 12px;
        }

        h1 {
            text-align: center;
            font-size: 18px;
        }

        h2 {
            background: #f0f0f0;
            padding: 8px;
            font-size: 16px;
            margin: 10px 0;
        }

        h3 {
            font-size: 14px;
            margin: 8px 0;
        }
        .text-left {
        text-align: left;
        direction: ltr;
        font-family: 'Courier New', monospace;
    }
    .total-row {
        font-weight: bold;
        background-color: #f5f5f5;
    }
    .no-data {
        color: #999;
        font-style: italic;
        text-align: center;
        padding: 15px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    table, th, td {
        border: 1px solid #ddd;
    }
    th, td {
        padding: 8px;
        text-align: right;
    }
    .page-break {
        page-break-after: always;
    }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 11px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: right;
        }

        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }

        .employee-section {
            margin-bottom: 30px;
            border-bottom: 1px solid #333;
            padding-bottom: 15px;
        }

        .summary-card {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 15px;
        }

        .summary-item {
            flex: 1;
            min-width: 150px;
            border: 1px solid #ddd;
            padding: 8px;
            border-radius: 4px;
            background: #f9f9f9;
        }

        .summary-label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .total-row {
            font-weight: bold;
            background-color: #f0f0f0;
        }

        .no-data {
            color: #666;
            text-align: center;
            padding: 10px;
            border: 1px dashed #ccc;
            margin: 10px 0;
        }

        .page-break {
            page-break-after: always;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #333;
            font-size: 11px;
            color: #555;
        }

        .report-date {
            text-align: center;
            margin-bottom: 15px;
            font-size: 12px;
        }

        .badge {
            display: inline-block;
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 11px;
            margin-left: 5px;
        }

        .badge-primary {
            background-color: #007bff;
            color: white;
        }

        .badge-success {
            background-color: #28a745;
            color: white;
        }

        .badge-danger {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>التقرير اليومي لأداء الموظفين</h1>
        <p class="report-date">تاريخ التقرير: <?php echo e($date); ?></p>
    </div>

    <?php $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="employee-section">
        <h2 class="employee-header">
            <span class="badge badge-primary"><?php echo e($loop->iteration); ?></span>
            الموظف: <?php echo e($report['user']->name); ?>

        </h2>

        
        <h3 class="section-title">
            <span class="badge badge-success"><?php echo e($report['invoices']->count()); ?></span>
            الفواتير الصادرة
        </h3>
        <?php if($report['invoices']->count() > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th width="10%">رقم الفاتورة</th>
                        <th width="25%">العميل</th>
                        <th width="15%">المجموع</th>
                        <th width="15%">الحالة</th>
                        <th width="15%">التاريخ</th>
                        <th width="20%">ملاحظات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $report['invoices']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>#<?php echo e($invoice->id); ?></td>
                            <td><?php echo e($invoice->client->trade_name ?? 'غير محدد'); ?></td>
                            <td class="text-left"><?php echo e(number_format($invoice->grand_total, 2)); ?> ر.س</td>
                            <td>
                                <?php if($invoice->payment_status == 1): ?>
                                    <span class="badge badge-success">مدفوعة بالكامل</span>
                                <?php elseif($invoice->payment_status == 2): ?>
                                    <span class="badge badge-info">مدفوعة جزئياً</span>
                                <?php elseif($invoice->payment_status == 3): ?>
                                    <span class="badge badge-danger">غير مدفوعة</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($invoice->created_at->format('Y-m-d H:i')); ?></td>
                            <td><?php echo e($invoice->notes ?? '--'); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr class="total-row">
                        <td colspan="2">المجموع</td>
                        <td class="text-left"><?php echo e(number_format($report['invoices']->sum('grand_total'), 2)); ?> ر.س</td>
                        <td colspan="3"></td>
                    </tr>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-data">لا يوجد فواتير مسجلة لهذا اليوم</p>
        <?php endif; ?>

        
        <h3 class="section-title">
            <span class="badge badge-success"><?php echo e($report['payments']->count()); ?></span>
            المدفوعات المستلمة
        </h3>
        <?php if($report['payments']->count() > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th width="15%">رقم العملية</th>
                        <th width="25%">العميل</th>
                        <th width="15%">المبلغ</th>
                        <th width="15%">طريقة الدفع</th>
                        <th width="15%">التاريخ</th>
                        <th width="15%">رقم الفاتورة</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $report['payments']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>#<?php echo e($payment->id); ?></td>
                            <td><?php echo e($payment->client->trade_name ?? 'غير محدد'); ?></td>
                            <td class="text-left"><?php echo e(number_format($payment->amount, 2)); ?> ر.س</td>
                            <td><?php echo e($payment->payment_method); ?></td>
                            <td><?php echo e($payment->payment_date); ?></td>
                            <td>#<?php echo e($payment->invoice_id); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr class="total-row">
                        <td colspan="2">المجموع</td>
                        <td class="text-left"><?php echo e(number_format($report['payments']->sum('amount'), 2)); ?> ر.س</td>
                        <td colspan="3"></td>
                    </tr>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-data">لا يوجد مدفوعات مسجلة لهذا اليوم</p>
        <?php endif; ?>

        
        <h3 class="section-title">
            <span class="badge badge-success"><?php echo e($report['visits']->count()); ?></span>
            زيارات العملاء
        </h3>
        <?php if($report['visits']->count() > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th width="25%">العميل</th>
                        <th width="20%">العنوان</th>
                        <th width="10%">الوصول</th>
                        <th width="10%">الانصراف</th>
                        <th width="15%">التاريخ</th>
                        <th width="20%">ملاحظات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $report['visits']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $visit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($visit->client->trade_name ?? 'غير محدد'); ?></td>
                            <td><?php echo e($visit->client->street1 ?? 'غير محدد'); ?></td>
                            <td><?php echo e($visit->arrival_time ?? '--'); ?></td>
                            <td><?php echo e($visit->departure_time ?? '--'); ?></td>
                            <td><?php echo e($visit->created_at->format('Y-m-d H:i')); ?></td>
                            <td><?php echo e(Str::limit($visit->notes ?? 'لا توجد ملاحظات', 30)); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr class="total-row">
                        <td colspan="6">إجمالي عدد الزيارات: <?php echo e($report['visits']->count()); ?></td>
                    </tr>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-data">لا يوجد زيارات مسجلة لهذا اليوم</p>
        <?php endif; ?>

        
        <h3 class="section-title">
            <span class="badge badge-success"><?php echo e($report['receipts']->count()); ?></span>
            سندات القبض
        </h3>
        <?php if($report['receipts']->count() > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th width="20%">رقم السند</th>
                        <th width="25%">من</th>
                        <th width="15%">المبلغ</th>
                        <th width="20%">التاريخ</th>
                        <th width="20%">الوصف</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $report['receipts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $receipt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>#<?php echo e($receipt->id); ?></td>
                            <td><?php echo e($receipt->account->name ?? 'غير محدد'); ?></td>
                            <td class="text-left"><?php echo e(number_format($receipt->amount, 2)); ?> ر.س</td>
                            <td><?php echo e($receipt->created_at->format('Y-m-d H:i')); ?></td>
                            <td><?php echo e(Str::limit($receipt->description ?? '--', 30)); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr class="total-row">
                        <td colspan="2">المجموع</td>
                        <td class="text-left"><?php echo e(number_format($report['receipts']->sum('amount'), 2)); ?> ر.س</td>
                        <td colspan="2"></td>
                    </tr>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-data">لا يوجد سندات قبض مسجلة لهذا اليوم</p>
        <?php endif; ?>

        
        <h3 class="section-title">
            <span class="badge badge-success"><?php echo e($report['expenses']->count()); ?></span>
            سندات الصرف
        </h3>
        <?php if($report['expenses']->count() > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th width="20%">رقم السند</th>
                        <th width="25%">إلى</th>
                        <th width="15%">المبلغ</th>
                        <th width="20%">التاريخ</th>
                        <th width="20%">الوصف</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $report['expenses']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>#<?php echo e($expense->id); ?></td>
                            <td><?php echo e($expense->name); ?></td>
                            <td class="text-left"><?php echo e(number_format($expense->amount, 2)); ?> ر.س</td>
                            <td><?php echo e($expense->created_at->format('Y-m-d H:i')); ?></td>
                            <td><?php echo e(Str::limit($expense->description ?? '--', 30)); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr class="total-row">
                        <td colspan="2">المجموع</td>
                        <td class="text-left"><?php echo e(number_format($report['expenses']->sum('amount'), 2)); ?> ر.س</td>
                        <td colspan="2"></td>
                    </tr>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-data">لا يوجد سندات صرف مسجلة لهذا اليوم</p>
        <?php endif; ?>
    </div>

    <?php if(!$loop->last): ?>
        <div class="page-break"></div>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


    <div class="footer">
        تم إنشاء هذا التقرير تلقائياً بتاريخ <?php echo e($date); ?> - نظام فوترة سمارت
    </div>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/reports/daily_employee.blade.php ENDPATH**/ ?>