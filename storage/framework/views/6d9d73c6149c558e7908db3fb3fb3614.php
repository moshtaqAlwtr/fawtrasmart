<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>التقرير اليومي للموظف <?php echo e($user->name); ?></title>
    <style>
        @font-face {
            font-family: 'DejaVu Sans';
            font-style: normal;
            font-weight: normal;
            src: url('<?php echo e(storage_path('fonts/dejavu-sans/DejaVuSans.ttf')); ?>') format('truetype');
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            direction: rtl;
            font-size: 9pt;
            margin: 0;
            padding: 5mm;
            line-height: 1.3;
        }
        .header {
            text-align: center;
            margin-bottom: 5mm;
            padding-bottom: 2mm;
            border-bottom: 0.5pt solid #333;
        }
        .header h1 {
            font-size: 12pt;
            margin: 2pt 0;
            color: #2c3e50;
        }
        .header .subtitle {
            font-size: 9pt;
            color: #7f8c8d;
        }
        .employee-info {
            margin-bottom: 5mm;
        }
        .info-table {
            width: 100%;
            margin-bottom: 3mm;
            font-size: 9pt;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 2mm;
            border: 0.5pt solid #eee;
        }
        .section {
            margin-bottom: 8mm;
            page-break-inside: avoid;
        }
        .section-title {
            background-color: #3498db;
            color: white;
            padding: 2mm 3mm;
            border-radius: 1.5pt;
            font-size: 10pt;
            margin-bottom: 3mm;
            display: flex;
            justify-content: space-between;
        }
        .section-count {
            background-color: #2980b9;
            padding: 1pt 3pt;
            border-radius: 1.5pt;
            font-size: 9pt;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5mm;
            font-size: 8pt;
            table-layout: fixed;
        }
        th, td {
            border: 0.5pt solid #ddd;
            padding: 2mm;
            text-align: right;
            direction: rtl;
            word-wrap: break-word;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .currency {
            text-align: left;
            direction: ltr;
            font-family: 'DejaVu Sans', sans-serif;
        }
        .time {
            text-align: right;
            direction: rtl;
        }
        .total-row {
            font-weight: bold;
            background-color: #f5f5f5;
        }
        .no-data {
            color: #999;
            font-style: italic;
            text-align: center;
            padding: 5mm;
            border: 0.5pt dashed #ddd;
            margin: 3mm 0;
        }
        .status-badge {
            display: inline-block;
            padding: 1.5pt 3pt;
            border-radius: 2pt;
            font-size: 8pt;
            color: white;
            min-width: 50px;
            text-align: center;
        }
        .status-paid { background-color: #28a745; }
        .status-partial { background-color: #17a2b8; }
        .status-unpaid { background-color: #dc3545; }
        .status-completed { background-color: #28a745; }
        .status-pending { background-color: #ffc107; color: #000; }
        .status-cancelled { background-color: #dc3545; }
        .payment-summary {
            margin-bottom: 8mm;
            border: 0.5pt solid #ddd;
            padding: 4mm;
            border-radius: 3pt;
        }
        .payment-summary-title {
            font-weight: bold;
            margin-bottom: 4mm;
            font-size: 10pt;
            text-align: center;
            color: #2c3e50;
        }
        .payment-summary-grid {
            display: table;
            width: 100%;
        }
        .payment-summary-item {
            display: table-row;
        }
        .payment-summary-label, .payment-summary-value {
            display: table-cell;
            padding: 2mm 1mm;
            vertical-align: middle;
        }
        .payment-summary-label {
            font-size: 9pt;
            color: #495057;
            text-align: right;
            width: 70%;
        }
        .payment-summary-value {
            font-size: 9pt;
            font-weight: bold;
            text-align: left;
            width: 30%;
            direction: ltr;
        }
        .grand-total {
            background-color: #e9f7ef;
            border-top: 0.5pt solid #28a745;
        }
        .footer {
            text-align: center;
            margin-top: 8mm;
            padding-top: 3mm;
            border-top: 0.5pt solid #eee;
            font-size: 8pt;
            color: #6c757d;
        }
        .col-5 { width: 5%; }
        .col-10 { width: 10%; }
        .col-15 { width: 15%; }
        .col-20 { width: 20%; }
        .col-25 { width: 25%; }
        .col-30 { width: 30%; }
        .col-35 { width: 35%; }
        .col-40 { width: 40%; }
        .nowrap { white-space: nowrap; }
        .wrap-text {
            white-space: normal;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        .text-center { text-align: center; }
    </style>
</head>
<body>

    <div class="header">
        <h1>التقرير اليومي لأداء الموظف</h1>
        <div class="subtitle">تاريخ التقرير: <?php echo e($date); ?></div>
    </div>

    <!-- معلومات الموظف -->
    <div class="employee-info">
        <table class="info-table">
            <tr>
                <td style="width: 30%; font-weight: bold;">اسم الموظف</td>
                <td style="width: 70%;"><?php echo e($user->name); ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">رقم الموظف</td>
                <td><?php echo e($user->id); ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">البريد الإلكتروني</td>
                <td><?php echo e($user->email); ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">تاريخ الإنضمام</td>
                <td><?php echo e($user->created_at->format('Y-m-d')); ?></td>
            </tr>
        </table>
    </div>

    <!-- ملخص المدفوعات -->
    <div class="payment-summary">
        <div class="payment-summary-title">ملخص المدفوعات</div>
        <div class="payment-summary-grid">
            <div class="payment-summary-item">
                <div class="payment-summary-label">إجمالي المدفوعات المستلمة</div>
                <div class="payment-summary-value">
                    <?php echo e($payments->sum('amount'), 2, '.', ','); ?> ر.س
                </div>
            </div>
            <div class="payment-summary-item">
                <div class="payment-summary-label">إجمالي سندات القبض</div>
                <div class="payment-summary-value">
                    <?php echo e($receipts->sum('amount'), 2, '.', ','); ?> ر.س
                </div>
            </div>
            <div class="payment-summary-item">
                <div class="payment-summary-label">إجمالي سندات الصرف</div>
                <div class="payment-summary-value">
                    <?php echo e($expenses->sum('amount'), 2, '.', ','); ?> ر.س
                </div>
            </div>
            <div class="payment-summary-item grand-total">
                <div class="payment-summary-label">صافي التحصيل النقدي</div>
                <div class="payment-summary-value">
                    <?php
                        $totalCollection = $payments->sum('amount') + $receipts->sum('amount') - $expenses->sum('amount');
                    ?>
                    <?php echo e($totalCollection, 2, '.', ','); ?> ر.س
                </div>
            </div>
        </div>
    </div>

    <!-- الفواتير -->
    <div class="section">
        <div class="section-title">
            <span>الفواتير الصادرة</span>
            <span class="section-count"><?php echo e($invoices->count()); ?></span>
        </div>
        <?php if($invoices->count() > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th class="col-10">رقم الفاتورة</th>
                        <th class="col-20">العميل</th>
                        <th class="col-15">المجموع</th>
                        <th class="col-10">النوع</th>
                        <th class="col-15">الحالة</th>
                        <th class="col-15">التاريخ</th>
                        <th class="col-15">ملاحظات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $totalNormal = 0;
                        $totalReturned = 0;
                    ?>

                    <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            if($invoice->type == 'returned') {
                                $totalReturned += $invoice->grand_total;
                            } else {
                                $totalNormal += $invoice->grand_total;
                            }
                        ?>
                        <tr>
                            <td class="nowrap text-center">#<?php echo e($invoice->id); ?></td>
                            <td class="wrap-text"><?php echo e($invoice->client->trade_name ?? 'غير محدد'); ?></td>
                            <td class="currency"><?php echo e(number_format($invoice->grand_total, 2, '.', ',')); ?> ر.س</td>
                            <td class="text-center">
                                <?php if($invoice->type == 'returned'): ?>
                                    <span class="status-badge status-cancelled">مرتجع</span>
                                <?php else: ?>
                                    <span class="status-badge status-completed">مبيعات</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if($invoice->payment_status == 1): ?>
                                    <span class="status-badge status-paid">مدفوعة</span>
                                <?php elseif($invoice->payment_status == 2): ?>
                                    <span class="status-badge status-partial">جزئي</span>
                                <?php elseif($invoice->payment_status == 3): ?>
                                    <span class="status-badge status-unpaid">غير مدفوعة</span>
                                <?php endif; ?>
                            </td>
                            <td class="nowrap text-center"><?php echo e($invoice->created_at->format('H:i')); ?></td>
                            <td class="wrap-text"><?php echo e($invoice->notes ?? '--'); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr class="total-row">
                        <td colspan="2">إجمالي الفواتير العادية</td>
                        <td class="currency"><?php echo e($totalNormal, 2, '.', ','); ?> ر.س</td>
                        <td colspan="4"></td>
                    </tr>
                    <tr class="total-row" style="background-color: #f8d7da;">
                        <td colspan="2">إجمالي الفواتير المرتجعة</td>
                        <td class="currency">-<?php echo e($totalReturned, 2, '.', ','); ?> ر.س</td>
                        <td colspan="4"></td>
                    </tr>
                    <tr class="total-row" style="background-color: #e7f1ff;">
                        <td colspan="2">صافي المبيعات</td>
                        <td class="currency"><?php echo e($totalNormal - $totalReturned, 2, '.', ','); ?> ر.س</td>
                        <td colspan="4"></td>
                    </tr>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-data">لا يوجد فواتير مسجلة</div>
        <?php endif; ?>
    </div>

    <!-- المدفوعات -->
    <div class="section">
        <div class="section-title">
            <span>المدفوعات المستلمة</span>
            <span class="section-count"><?php echo e($payments->count()); ?></span>
        </div>
        <?php if($payments->count() > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th class="col-10">رقم العملية</th>
                        <th class="col-25">العميل</th>
                        <th class="col-15">المبلغ</th>
                        <th class="col-20">طريقة الدفع</th>
                        <th class="col-15">التاريخ</th>
                        <th class="col-15">رقم الفاتورة</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="nowrap text-center">#<?php echo e($payment->id); ?></td>
                            <td class="wrap-text"><?php echo e($payment->invoice->client->trade_name ?? 'غير محدد'); ?></td>
                            <td class="currency"><?php echo e($payment->amount, 2, '.', ','); ?> ر.س</td>
                            <td class="wrap-text"><?php echo e($payment->payment_method); ?></td>
                            <td class="nowrap text-center"><?php echo e($payment->payment_date); ?></td>
                            <td class="nowrap text-center">#<?php echo e($payment->invoice_id); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr class="total-row">
                        <td colspan="2">المجموع</td>
                        <td class="currency"><?php echo e($payments->sum('amount'), 2, '.', ','); ?> ر.س</td>
                        <td colspan="3"></td>
                    </tr>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-data">لا يوجد مدفوعات مسجلة</div>
        <?php endif; ?>
    </div>

    <!-- سندات القبض -->
    <div class="section">
        <div class="section-title">
            <span>سندات القبض</span>
            <span class="section-count"><?php echo e($receipts->count()); ?></span>
        </div>
        <?php if($receipts->count() > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th class="col-15">رقم السند</th>
                        <th class="col-30">من</th>
                        <th class="col-15">المبلغ</th>
                        <th class="col-20">التاريخ</th>
                        <th class="col-20">الوصف</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $receipts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $receipt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="nowrap text-center">#<?php echo e($receipt->id); ?></td>
                            <td class="wrap-text"><?php echo e($receipt->account->name ?? 'غير محدد'); ?></td>
                            <td class="currency"><?php echo e($receipt->amount, 2, '.', ','); ?> ر.س</td>
                            <td class="nowrap text-center"><?php echo e($receipt->created_at->format('H:i')); ?></td>
                            <td class="wrap-text"><?php echo e($receipt->description ?? '--'); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr class="total-row">
                        <td colspan="2">المجموع</td>
                        <td class="currency"><?php echo e($receipts->sum('amount'), 2, '.', ','); ?> ر.س</td>
                        <td colspan="2"></td>
                    </tr>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-data">لا يوجد سندات قبض</div>
        <?php endif; ?>
    </div>

    <!-- سندات الصرف -->
    <div class="section">
        <div class="section-title">
            <span>سندات الصرف</span>
            <span class="section-count"><?php echo e($expenses->count()); ?></span>
        </div>
        <?php if($expenses->count() > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th class="col-15">رقم السند</th>
                        <th class="col-30">إلى</th>
                        <th class="col-15">المبلغ</th>
                        <th class="col-20">التاريخ</th>
                        <th class="col-20">الوصف</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="nowrap text-center">#<?php echo e($expense->id); ?></td>
                            <td class="wrap-text"><?php echo e($expense->name); ?></td>
                            <td class="currency"><?php echo e($expense->amount, 2, '.', ','); ?> ر.س</td>
                            <td class="nowrap text-center"><?php echo e($expense->created_at->format('H:i')); ?></td>
                            <td class="wrap-text"><?php echo e($expense->description ?? '--'); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr class="total-row">
                        <td colspan="2">المجموع</td>
                        <td class="currency"><?php echo e($expenses->sum('amount'), 2, '.', ','); ?> ر.س</td>
                        <td colspan="2"></td>
                    </tr>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-data">لا يوجد سندات صرف</div>
        <?php endif; ?>
    </div>

    <!-- زيارات العملاء -->
    <div class="section">
        <div class="section-title">
            <span>زيارات العملاء</span>
            <span class="section-count"><?php echo e($visits->count()); ?></span>
        </div>
        <?php if($visits->count() > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th class="col-25">العميل</th>
                        <th class="col-25">العنوان</th>
                        <th class="col-10">الوصول</th>
                        <th class="col-10">الانصراف</th>
                        <th class="col-15">التاريخ</th>
                        <th class="col-15">ملاحظات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $visits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $visit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="wrap-text"><?php echo e(optional($visit->client)->trade_name ?? 'غير محدد'); ?></td>
                            <td class="wrap-text"><?php echo e(optional($visit->client)->formattedAddress ?? 'غير محدد'); ?></td>
                            <td class="nowrap text-center"><?php echo e($visit->arrival_time ?? '--'); ?></td>
                            <td class="nowrap text-center"><?php echo e($visit->departure_time ?? '--'); ?></td>
                            <td class="nowrap text-center"><?php echo e($visit->created_at->format('H:i')); ?></td>
                            <td class="wrap-text"><?php echo e($visit->notes ?? '--'); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr class="total-row">
                        <td colspan="6">إجمالي الزيارات: <?php echo e($visits->count()); ?></td>
                    </tr>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-data">لا يوجد زيارات مسجلة</div>
        <?php endif; ?>
    </div>

    <!-- الملاحظات -->
    <div class="section">
        <div class="section-title">
            <span>ملاحظات الموظف</span>
            <span class="section-count"><?php echo e($notes->count()); ?></span>
        </div>
        <?php if($notes->count() > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th class="col-25">العميل</th>
                        <th class="col-15">الحالة</th>
                        <th class="col-15">الوقت</th>
                        <th class="col-15">التاريخ</th>
                        <th class="col-30">الوصف</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $notes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="wrap-text"><?php echo e($note->client->trade_name ?? 'غير محدد'); ?></td>
                            <td class="text-center">
                                <?php if($note->status == 'completed'): ?>
                                    <span class="status-badge status-completed">مكتمل</span>
                                <?php elseif($note->status == 'pending'): ?>
                                    <span class="status-badge status-pending">قيد التنفيذ</span>
                                <?php elseif($note->status == 'cancelled'): ?>
                                    <span class="status-badge status-cancelled">ملغى</span>
                                <?php else: ?>
                                    <?php echo e($note->status); ?>

                                <?php endif; ?>
                            </td>
                            <td class="nowrap text-center"><?php echo e($note->time ?? '--'); ?></td>
                            <td class="nowrap text-center"><?php echo e($note->date ?? '--'); ?></td>
                            <td class="wrap-text"><?php echo e($note->description ?? '--'); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr class="total-row">
                        <td colspan="5">إجمالي الملاحظات: <?php echo e($notes->count()); ?></td>
                    </tr>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-data">لا يوجد ملاحظات مسجلة</div>
        <?php endif; ?>
    </div>

    <div class="footer">
        تم إنشاء التقرير تلقائياً بتاريخ <?php echo e(date('Y-m-d H:i')); ?> - نظام فوترة سمارت
    </div>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/reports/daily_employee_single.blade.php ENDPATH**/ ?>