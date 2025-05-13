<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>التقرير الشهري للموظف <?php echo e($user->name); ?></title>
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
        }
        .info-table td {
            padding: 1mm;
        }
        .section {
            margin-bottom: 5mm;
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
        }
        th, td {
            border: 0.5pt solid #ddd;
            padding: 1.5mm;
            text-align: right;
            direction: rtl;
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
            padding: 3mm;
            border: 0.5pt dashed #ddd;
            margin: 3mm 0;
        }
        .status-badge {
            display: inline-block;
            padding: 1pt 2pt;
            border-radius: 1.5pt;
            font-size: 7pt;
            color: white;
        }
        .status-paid { background-color: #28a745; }
        .status-partial { background-color: #17a2b8; }
        .status-unpaid { background-color: #dc3545; }
        .status-completed { background-color: #28a745; }
        .status-pending { background-color: #ffc107; color: #000; }
        .status-cancelled { background-color: #dc3545; }
        .status-returned { background-color: #6c757d; }
        .payment-summary {
            margin-bottom: 5mm;
            border: 0.5pt solid #ddd;
            padding: 3mm;
        }
        .sales-summary {
            margin-bottom: 5mm;
            border: 0.5pt solid #ddd;
            padding: 3mm;
        }
        .payment-summary-title, .sales-summary-title {
            font-weight: bold;
            margin-bottom: 3mm;
            font-size: 10pt;
            text-align: center;
        }
        .payment-summary-grid, .sales-summary-grid {
            display: table;
            width: 100%;
        }
        .payment-summary-item, .sales-summary-item {
            display: table-row;
        }
        .payment-summary-label, .payment-summary-value,
        .sales-summary-label, .sales-summary-value {
            display: table-cell;
            padding: 1mm;
        }
        .payment-summary-label, .sales-summary-label {
            font-size: 8pt;
            color: #6c757d;
            text-align: right;
            width: 70%;
        }
        .payment-summary-value, .sales-summary-value {
            font-size: 9pt;
            font-weight: bold;
            text-align: left;
            width: 30%;
            direction: ltr;
        }
        .grand-total, .net-sales {
            background-color: #e9f7ef;
            border-top: 0.5pt solid #28a745;
        }
        .footer {
            text-align: center;
            margin-top: 5mm;
            padding-top: 2mm;
            border-top: 0.5pt solid #eee;
            font-size: 8pt;
            color: #6c757d;
        }
        .col-5 { width: 5%; }
        .col-10 { width: 10%; }
        .col-15 { width: 15%; }
        .col-20 { width: 20%; }
        .col-25 { width: 25%; }
        .date-range {
            text-align: center;
            margin-bottom: 5mm;
            font-weight: bold;
            color: #3498db;
        }
        .visit-count {
            font-weight: bold;
            color: #2980b9;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>التقرير الشهري لأداء الموظف</h1>
        <div class="subtitle">فترة التقرير: لشهر <?php echo e($startDate->format('Y-m')); ?></div>
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

    <!-- ملخص المبيعات -->
    <div class="sales-summary">
        <div class="sales-summary-title">ملخص المبيعات الشهري</div>
        <div class="sales-summary-grid">
            <div class="sales-summary-item">
                <div class="sales-summary-label">إجمالي المبيعات (فواتير عادية)</div>
                <div class="sales-summary-value">
                    <?php echo e($totalSales, 2, '.', ','); ?> ر.س
                </div>
            </div>
            <div class="sales-summary-item">
                <div class="sales-summary-label">إجمالي المرتجعات (فواتير مرتجعة)</div>
                <div class="sales-summary-value">
                    <?php echo e($totalReturns, 2, '.', ','); ?> ر.س
                </div>
            </div>
            <div class="sales-summary-item net-sales">
                <div class="sales-summary-label">صافي المبيعات بعد المرتجعات</div>
                <div class="sales-summary-value">
                    <?php echo e($netSales, 2, '.', ','); ?> ر.س
                </div>
            </div>
        </div>
    </div>

    <!-- ملخص المدفوعات -->
    <div class="payment-summary">
        <div class="payment-summary-title">ملخص المدفوعات الشهري</div>
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
                <div class="payment-summary-label">صافي التحصيل النقدي الشهري</div>
                <div class="payment-summary-value">
                    <?php
                        $totalCollection = $payments->sum('amount') + $receipts->sum('amount') - $expenses->sum('amount');
                    ?>
                    <?php echo e($totalCollection, 2, '.', ','); ?> ر.س
                </div>
            </div>
        </div>
    </div>

    
    <div class="section">
        <div class="section-title">
            <span>الفواتير الصادرة خلال الشهر</span>
            <span class="section-count"><?php echo e($invoices->count()); ?></span>
        </div>
        <?php if($invoices->count() > 0): ?>
            <div class="date-range">لشهر <?php echo e($startDate->format('Y-m')); ?></div>
            <table>
                <thead>
                    <tr>

                        <th class="col-10">رقم الفاتورة</th>
                        <th class="col-20">العميل</th>
                        <th class="col-15">المجموع</th>
                        <th class="col-15">الحالة</th>
                         <th class="col-5">النوع</th>
                        <th class="col-15">التاريخ</th>
                        <th class="col-20">ملاحظات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>

                            <td>#<?php echo e($invoice->id); ?></td>
                            <td><?php echo e($invoice->client->trade_name ?? 'غير محدد'); ?></td>
                            <td class="currency">
                                <?php if($invoice->type == 'returned'): ?>
                                    -<?php echo e(number_format($invoice->grand_total, 2, '.', ',')); ?>

                                <?php else: ?>
                                    <?php echo e(number_format($invoice->grand_total, 2, '.', ',')); ?>

                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($invoice->payment_status == 1): ?>
                                    <span class="status-badge status-paid">مدفوعة</span>
                                <?php elseif($invoice->payment_status == 2): ?>
                                    <span class="status-badge status-partial">جزئي</span>
                                <?php elseif($invoice->payment_status == 3): ?>
                                    <span class="status-badge status-unpaid">غير مدفوعة</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($invoice->type == 'returned'): ?>
                                    <span class="status-badge status-returned">مرتجع</span>
                                <?php else: ?>
                                    <span class="status-badge status-paid"> مبيعات</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($invoice->created_at->format('Y-m-d H:i')); ?></td>
                            <td><?php echo e($invoice->notes ?? '--'); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr class="total-row">
                        <td colspan="3">المجموع</td>
                        <td class="currency"><?php echo e($invoices->where('type', 'normal')->sum('grand_total') - $invoices->where('type', 'returned')->sum('grand_total'), 2, '.', ','); ?> ر.س</td>
                        <td colspan="3"></td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="3">إجمالي المبيعات (فواتير عادية)</td>
                        <td class="currency"><?php echo e($invoices->where('type', 'normal')->sum('grand_total'), 2, '.', ','); ?> ر.س</td>
                        <td colspan="3"></td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="3">إجمالي المرتجعات (فواتير مرتجعة)</td>
                        <td class="currency">-<?php echo e($invoices->where('type', 'returned')->sum('grand_total'), 2, '.', ','); ?> ر.س</td>
                        <td colspan="3"></td>
                    </tr>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-data">لا يوجد فواتير مسجلة خلال هذا الشهر</div>
        <?php endif; ?>
    </div>

    
    <div class="section">
        <div class="section-title">
            <span>المدفوعات المستلمة خلال الشهر</span>
            <span class="section-count"><?php echo e($payments->count()); ?></span>
        </div>
        <?php if($payments->count() > 0): ?>
            <div class="date-range">لشهر <?php echo e($startDate->format('Y-m')); ?></div>
            <table>
                <thead>
                    <tr>
                        <th class="col-10">رقم العملية</th>
                        <th class="col-20">العميل</th>
                        <th class="col-15">المبلغ</th>
                        <th class="col-15">طريقة الدفع</th>
                        <th class="col-15">التاريخ</th>
                        <th class="col-25">رقم الفاتورة</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>#<?php echo e($payment->id); ?></td>
                            <td><?php echo e($payment->client->trade_name ?? 'غير محدد'); ?></td>
                            <td class="currency"><?php echo e($payment->amount, 2, '.', ','); ?> ر.س</td>
                            <td><?php echo e($payment->payment_method); ?></td>
                            <td class="time"><?php echo e($payment->payment_date); ?></td>
                            <td>#<?php echo e($payment->invoice_id); ?></td>
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
            <div class="no-data">لا يوجد مدفوعات مسجلة خلال هذا الشهر</div>
        <?php endif; ?>
    </div>

    
    <div class="section">
        <div class="section-title">
            <span>سندات القبض خلال الشهر</span>
            <span class="section-count"><?php echo e($receipts->count()); ?></span>
        </div>
        <?php if($receipts->count() > 0): ?>
            <div class="date-range">لشهر <?php echo e($startDate->format('Y-m')); ?></div>
            <table>
                <thead>
                    <tr>
                        <th class="col-15">رقم السند</th>
                        <th class="col-25">من</th>
                        <th class="col-15">المبلغ</th>
                        <th class="col-20">التاريخ</th>
                        <th class="col-25">الوصف</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $receipts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $receipt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>#<?php echo e($receipt->id); ?></td>
                            <td><?php echo e($receipt->account->name ?? 'غير محدد'); ?></td>
                            <td class="currency"><?php echo e($receipt->amount, 2, '.', ','); ?> ر.س</td>
                            <td><?php echo e($receipt->created_at->format('Y-m-d H:i')); ?></td>
                            <td><?php echo e($receipt->description ?? '--'); ?></td>
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
            <div class="no-data">لا يوجد سندات قبض خلال هذا الشهر</div>
        <?php endif; ?>
    </div>

    
    <div class="section">
        <div class="section-title">
            <span>سندات الصرف خلال الشهر</span>
            <span class="section-count"><?php echo e($expenses->count()); ?></span>
        </div>
        <?php if($expenses->count() > 0): ?>
            <div class="date-range">لشهر <?php echo e($startDate->format('Y-m')); ?></div>
            <table>
                <thead>
                    <tr>
                        <th class="col-15">رقم السند</th>
                        <th class="col-25">إلى</th>
                        <th class="col-15">المبلغ</th>
                        <th class="col-20">التاريخ</th>
                        <th class="col-25">الوصف</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>#<?php echo e($expense->id); ?></td>
                            <td><?php echo e($expense->name); ?></td>
                            <td class="currency"><?php echo e($expense->amount, 2, '.', ','); ?> ر.س</td>
                            <td><?php echo e($expense->created_at->format('Y-m-d H:i')); ?></td>
                            <td><?php echo e($expense->description ?? '--'); ?></td>
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
            <div class="no-data">لا يوجد سندات صرف خلال هذا الشهر</div>
        <?php endif; ?>
    </div>

    
    <div class="section">
        <div class="section-title">
            <span>زيارات العملاء خلال الشهر</span>
            <span class="section-count"><?php echo e($visits->count()); ?></span>
        </div>
        <?php if($visits->count() > 0): ?>
            <div class="date-range">لشهر <?php echo e($startDate->format('Y-m')); ?></div>
            <table>
                <thead>
                    <tr>
                        <th class="col-15">التاريخ</th>
                        <th class="col-20">العميل</th>
                        <th class="col-10">عدد الزيارات</th>
                        <th class="col-20">العنوان</th>
                        <th class="col-10">الوصول</th>
                        <th class="col-10">الانصراف</th>
                        <th class="col-15">ملاحظات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $visits->groupBy('client_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clientId => $clientVisits): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $firstVisit = $clientVisits->first();
                            $visitCount = $clientVisits->count();
                        ?>
                        <tr>
                            <td><?php echo e($firstVisit->created_at->format('Y-m-d')); ?></td>
                            <td><?php echo e($firstVisit->client->trade_name ?? 'غير محدد'); ?></td>
                            <td class="visit-count"><?php echo e($visitCount); ?></td>
                            <td><?php echo e($firstVisit->client->formattedAddress ?? 'غير محدد'); ?></td>
                            <td class="time"><?php echo e($firstVisit->arrival_time ?? '--'); ?></td>
                            <td class="time"><?php echo e($firstVisit->departure_time ?? '--'); ?></td>
                            <td><?php echo e($firstVisit->notes ?? '--'); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr class="total-row">
                        <td colspan="7">
                            إجمالي الزيارات: <?php echo e($visits->count()); ?> -
                            عدد العملاء المزورين: <?php echo e($visits->groupBy('client_id')->count()); ?>

                        </td>
                    </tr>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-data">لا يوجد زيارات مسجلة خلال هذا الشهر</div>
        <?php endif; ?>
    </div>

    
    <div class="section">
        <div class="section-title">
            <span>ملاحظات الموظف خلال الشهر</span>
            <span class="section-count"><?php echo e($notes->count()); ?></span>
        </div>
        <?php if($notes->count() > 0): ?>
            <div class="date-range">لشهر <?php echo e($startDate->format('Y-m')); ?></div>
            <table>
                <thead>
                    <tr>
                        <th class="col-15">التاريخ</th>
                        <th class="col-20">العميل</th>
                        <th class="col-15">الحالة</th>
                        <th class="col-15">الوقت</th>
                        <th class="col-35">الوصف</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $notes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($note->created_at->format('Y-m-d')); ?></td>
                            <td><?php echo e($note->client->trade_name ?? 'غير محدد'); ?></td>
                            <td>
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
                            <td class="time"><?php echo e($note->time ?? '--'); ?></td>
                            <td><?php echo e($note->description ?? '--'); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr class="total-row">
                        <td colspan="5">إجمالي الملاحظات: <?php echo e($notes->count()); ?></td>
                    </tr>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-data">لا يوجد ملاحظات مسجلة خلال هذا الشهر</div>
        <?php endif; ?>
    </div>

    <div class="footer">
        تم إنشاء التقرير تلقائياً بتاريخ <?php echo e(date('Y-m-d H:i')); ?> - نظام فوترة سمارت
    </div>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/reports/monthly_employee.blade.php ENDPATH**/ ?>