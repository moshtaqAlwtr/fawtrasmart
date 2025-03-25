<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>عرض سعر</title>
    <style>
        body {
            direction: rtl;
            font-family: aealarabiya;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border: 1px solid #000;
            padding: 10px;
        }

        .header h1 {
            margin: 0;
            padding: 0;
            font-size: 18px;
        }

        .header p {
            margin: 5px 0;
        }

        .info-grid {
            width: 100%;
            margin: 20px 0;
        }

        .info-grid td {
            padding: 5px;
        }

        .info-label {
            font-weight: bold;
            width: 120px;
        }

        .info-value {
            border-bottom: 1px dotted #000;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .data-table th, .data-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        .data-table th {
            background-color: #f5f5f5;
        }

        .section-title {
            margin: 20px 0 10px;
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>عرض سعر</h1>
        <p><?php echo e(date('d/m/Y')); ?></p>
        <p>مؤسسة اعمال  عتمة للتجارة</p>
        <p>رقم العرض: <?php echo e($purchaseQuotation->code); ?></p>
        <?php if($purchaseQuotation->status == 1): ?>
            <p>الحالة: تحت المراجعة</p>
        <?php elseif($purchaseQuotation->status == 2): ?>
            <p>الحالة: معتمد</p>
        <?php elseif($purchaseQuotation->status == 3): ?>
            <p>الحالة: مرفوض</p>
        <?php endif; ?>
    </div>

    <table class="info-grid" cellpadding="0" cellspacing="0">
        <tr>
            <td class="info-label">المورد:</td>
            <td class="info-value"><?php echo e($purchaseQuotation->supplier->trade_name ?? 'غير محدد'); ?></td>
            <td class="info-label">رقم العرض:</td>
            <td class="info-value"><?php echo e($purchaseQuotation->code); ?></td>
        </tr>
        <tr>
            <td class="info-label">تاريخ العرض:</td>
            <td class="info-value"><?php echo e($purchaseQuotation->date); ?></td>
            <td class="info-label">صالح لمدة:</td>
            <td class="info-value"><?php echo e($purchaseQuotation->valid_days); ?> يوم</td>
        </tr>
        <tr>
            <td class="info-label">الحساب:</td>
            <td class="info-value"><?php echo e(optional($purchaseQuotation->account)->name ?? 'غير محدد'); ?></td>
            <td class="info-label">منشئ العرض:</td>
            <td class="info-value"><?php echo e(optional($purchaseQuotation->creator)->name ?? 'غير محدد'); ?></td>
        </tr>
    </table>

    <h3 class="section-title">تفاصيل المنتجات:</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>المنتج</th>
                <th>الكمية</th>
                <th>سعر الوحدة</th>
                <th>الخصم</th>
                <th>الضريبة 1</th>
                <th>الضريبة 2</th>
                <th>الإجمالي</th>
            </tr>
        </thead>
       <tbody>
    <?php $__currentLoopData = $purchaseQuotation->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($loop->iteration); ?></td>
            <td><?php echo e($item->product->name ?? $item->item); ?></td>
            <td><?php echo e($item->quantity); ?></td>
            <td><?php echo e(number_format($item->unit_price, 2)); ?></td>
            <td><?php echo e(number_format($item->discount, 2)); ?></td>
            <td><?php echo e(number_format($item->tax_1, 2)); ?>%</td>
            <td><?php echo e(number_format($item->tax_2, 2)); ?>%</td>
            <td><?php echo e(number_format($item->total, 2)); ?></td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td colspan="7" style="text-align: left; font-weight: bold;">إجمالي الخصم:</td>
        <td><?php echo e(number_format($purchaseQuotation->total_discount, 2)); ?></td>
    </tr>
    <tr>
        <td colspan="7" style="text-align: left; font-weight: bold;">إجمالي الضريبة:</td>
        <td><?php echo e(number_format($purchaseQuotation->total_tax, 2)); ?></td>
    </tr>
    <tr>
        <td colspan="7" style="text-align: left; font-weight: bold;">المجموع النهائي:</td>
        <td><?php echo e(number_format($purchaseQuotation->grand_total, 2)); ?></td>
    </tr>
</tbody>

    </table>
</body>
</html>
<?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/Purchases/view_purchase_price/pdf.blade.php ENDPATH**/ ?>