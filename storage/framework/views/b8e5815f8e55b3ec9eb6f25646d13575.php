<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>إشعار دائن</title>
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
        .info-table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 5px;
            border-bottom: 1px dotted #999;
        }
        .products-table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        .products-table th, .products-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
        .totals-table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        .totals-table td {
            padding: 5px;
            border: 1px solid #000;
        }
        .signatures {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            text-align: center;
        }
        .notice-status {
            color: #2980B9;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>إشعار دائن</h2>
        <p><?php echo e($cityNotice->date); ?></p>
        <p>مؤسسة اعمال عتمة للتجارة</p>
        <p>رقم الإشعار: <?php echo e($cityNotice->invoice_number); ?></p>
        <p class="notice-status">حالة الإشعار:
            <?php switch($cityNotice->status):
                case (1): ?>
                    نشط
                    <?php break; ?>
                <?php case (0): ?>
                    غير نشط
                    <?php break; ?>
                <?php default: ?>
                    غير محدد
            <?php endswitch; ?>
        </p>
    </div>

    <table class="info-table">
        <tr>
            <td>المورد:</td>
            <td><?php echo e(optional($cityNotice->supplier)->trade_name); ?></td>
            <td>رقم الإشعار:</td>
            <td><?php echo e($cityNotice->invoice_number); ?></td>
        </tr>
        <tr>
            <td>الرقم المرجعي:</td>
            <td><?php echo e($cityNotice->reference_number); ?></td>
            <td>تاريخ الإشعار:</td>
            <td><?php echo e($cityNotice->date); ?></td>
        </tr>
        <tr>
            <td>حالة الدفع:</td>
            <td>
                <?php switch($cityNotice->payment_status):
                    case ('paid'): ?>
                        مدفوع
                        <?php break; ?>
                    <?php case ('partial'): ?>
                        مدفوع جزئياً
                        <?php break; ?>
                    <?php case ('unpaid'): ?>
                        غير مدفوع
                        <?php break; ?>
                    <?php default: ?>
                        <?php echo e($cityNotice->payment_status); ?>

                <?php endswitch; ?>
            </td>
            <td>الشروط:</td>
            <td><?php echo e($cityNotice->terms ?: 'لا يوجد'); ?></td>
        </tr>
        <tr>
            <td>الملاحظات:</td>
            <td colspan="3"><?php echo e($cityNotice->notes ?: 'لا يوجد'); ?></td>
        </tr>
    </table>

    <h3>تفاصيل الإشعار:</h3>
    <table class="products-table">
        <thead>
            <tr>
                <th>#</th>
                <th>المنتج</th>
                <th>الوصف</th>
                <th>الكمية</th>
                <th>سعر الوحدة</th>
                <th>الخصم</th>
                <th>الضريبة 1</th>
                <th>الضريبة 2</th>
                <th>الإجمالي</th>
            </tr>
        </thead>
        <tbody>
            <?php if($cityNotice->items && $cityNotice->items->count() > 0): ?>
                <?php $__currentLoopData = $cityNotice->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($loop->iteration); ?></td>
                        <td><?php echo e($item->item); ?></td>
                        <td><?php echo e($item->description ?: '-'); ?></td>
                        <td><?php echo e($item->quantity); ?></td>
                        <td><?php echo e(number_format($item->unit_price, 2)); ?></td>
                        <td><?php echo e(number_format($item->discount, 2)); ?></td>
                        <td><?php echo e(number_format($item->tax_1, 2)); ?>%</td>
                        <td><?php echo e(number_format($item->tax_2, 2)); ?>%</td>
                        <td><?php echo e(number_format($item->total, 2)); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <tr>
                    <td colspan="9">لا توجد منتجات</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <table class="totals-table">
        <tr>
            <td>المجموع الفرعي:</td>
            <td><?php echo e(number_format($cityNotice->subtotal, 2)); ?></td>
        </tr>
        <tr>
            <td>إجمالي الخصم:</td>
            <td><?php echo e(number_format($cityNotice->total_discount, 2)); ?></td>
        </tr>
        <tr>
            <td>تكلفة الشحن:</td>
            <td><?php echo e(number_format($cityNotice->shipping_cost, 2)); ?></td>
        </tr>
        <tr>
            <td>إجمالي الضريبة:</td>
            <td><?php echo e(number_format($cityNotice->total_tax, 2)); ?></td>
        </tr>
        <tr>
            <td><strong>المبلغ الإجمالي:</strong></td>
            <td><strong><?php echo e(number_format($cityNotice->grand_total, 2)); ?></strong></td>
        </tr>
    </table>

    <div class="signatures">
        <div>
            <p>توقيع المورد</p>
            <div style="margin-top: 40px; border-top: 1px solid #000; width: 150px;"></div>
        </div>
        <div>
            <p>توقيع المحاسب</p>
            <div style="margin-top: 40px; border-top: 1px solid #000; width: 150px;"></div>
        </div>
        <div>
            <p>ختم المؤسسة</p>
            <div style="margin-top: 40px; border-top: 1px solid #000; width: 150px;"></div>
        </div>
    </div>
</body>
</html>
<?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/Purchases/city_notices/pdf.blade.php ENDPATH**/ ?>