<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>قيد يومية</title>
    <style>
        body {
            direction: rtl;
            font-family: 'Cairo', sans-serif;
            padding: 20px;
            margin: 0;
            font-size: 14px;
            background-color: #d3d9e1;
        }
        .entry-header {
            margin-bottom: 20px;
            text-align: right;
        }
        .entry-header h2 {
            margin: 0;
            font-size: 20px;
        }
        .entry-header .entry-number {
            font-size: 18px;
            color: #000;
        }
        .entry-info {
            margin-bottom: 10px;
            text-align: right;
        }
        .entry-info p {
            margin: 5px 0;
            font-size: 14px;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
        }
        th {
            background-color: #e8e8e8;
            border: 1px solid #aaa;
            padding: 10px;
            font-size: 14px;
            text-align: center;
        }
        td {
            border: 1px solid #aaa;
            padding: 10px;
            font-size: 14px;
            text-align: right;
        }
        .total-row td {
            font-weight: bold;
            background-color: #f4f4f4;
        }
        .total-row td:nth-child(3),
        .total-row td:nth-child(4) {
            color: #000;
        }
    </style>
</head>
<body>
    <?php
        $total_debit = 0;
        $total_credit = 0;
    ?>

    <div class="entry-header">
        <h2>قيد يومية <span class="entry-number">#<?php echo e($entry->id); ?></span></h2>
        <div class="entry-info"></div>
            <p>التاريخ: <?php echo e($entry->date); ?></p>
            <p>الوصف: تكلفة مبيعات - فاتورة #<?php echo e($entry->invoice_id); ?></p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th colspan="2">الحساب</th>

                <th>مدين</th>
                <th>دائن</th>
            </tr>
        </thead>
        <tbody>
            <?php if(isset($entry) && is_array($entry)): ?>
                <?php $__currentLoopData = $entry; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $total_debit += $item->debit ?? 0;
                        $total_credit += $item->credit ?? 0;
                    ?>
                    <tr>
                        <td>
                            <?php if(isset($item->account)): ?>
                                <?php echo e($item->account->code); ?>

                            <?php endif; ?>
                        </td>
                        <td><?php echo e($item->account->name); ?></td>
                        <td><?php echo e(isset($item->debit) ? number_format($item->debit, 2) : ''); ?></td>
                        <td><?php echo e(isset($item->credit) ? number_format($item->credit, 2) : ''); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php elseif(isset($entry) && is_object($entry)): ?>
                <?php $__currentLoopData = $entry->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $total_debit += $item->debit ?? 0;
                        $total_credit += $item->credit ?? 0;
                    ?>
                    <tr>
                        <td>
                            <?php if(isset($item->account)): ?>
                                <?php echo e($item->account->code ?? ''); ?>

                            <?php endif; ?>
                        </td>
                        <td><?php echo e($item->account->name ?? ''); ?></td>
                        <td><?php echo e(isset($item->debit) ? number_format($item->debit, 2) : ''); ?></td>
                        <td><?php echo e(isset($item->credit) ? number_format($item->credit, 2) : ''); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            <tr class="total-row">
                <td colspan="2">الإجمالى</td>
                <td><?php echo e(number_format($total_debit, 2)); ?> ر.س</td>
                <td><?php echo e(number_format($total_credit, 2)); ?> ر.س</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
<?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/Accounts/journal/pdf.blade.php ENDPATH**/ ?>