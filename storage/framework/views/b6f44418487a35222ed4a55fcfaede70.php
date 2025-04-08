<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>فاتورة مرتجع #<?php echo e($return_invoice->id); ?></title>
    <style>
        body {
            direction: rtl;
            font-family: 'Cairo', sans-serif;
            padding: 10px;
            margin: 0;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 1px solid #000;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            padding: 0;
            font-size: 16px;
            color: #d32f2f; /* لون أحمر للتمييز أنها مرتجع */
        }

        .header p {
            margin: 3px 0;
        }

        .info-grid {
            width: 100%;
            margin: 10px 0;
        }

        .info-grid td {
            padding: 3px;
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
            margin: 10px 0;
        }

        .data-table th, .data-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        .data-table th {
            background-color: #ffebee; /* خلفية حمراء فاتحة للتمييز */
        }

        .section-title {
            margin: 10px 0 5px;
            border-bottom: 1px solid #d32f2f;
            padding-bottom: 3px;
            font-size: 14px;
            color: #d32f2f;
        }

        .footer {
            margin-top: 15px;
            text-align: center;
        }

        .signatures {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            width: 150px;
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #000;
            margin-top: 20px;
            padding-top: 3px;
        }

        .qrcode {
            text-align: center;
            margin-top: 10px;
        }

        .qrcode img {
            max-width: 100px;
            height: auto;
        }

        .totals {
            margin: 15px 0;
            text-align: left;
        }

        .totals p {
            margin: 5px 0;
            font-weight: bold;
        }

        .return-reason {
            margin: 15px 0;
            padding: 10px;
            border: 1px dashed #d32f2f;
            background-color: #ffebee;
        }

    </style>
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.1/build/qrcode.min.js"></script>
</head>
<body>
    <div class="header">
        <h1>فاتورة مرتجع</h1>
        <p><?php echo e($return_invoice->client->trade_name ?? $return_invoice->client->first_name . ' ' . $return_invoice->client->last_name); ?></p>
        <p><?php echo e($return_invoice->client->street1 ?? 'غير متوفر'); ?></p>
        <p><?php echo e($return_invoice->client->mobile ?? 'غير متوفر'); ?></p>
    </div>

    <table class="info-grid" cellpadding="0" cellspacing="0">
        <tr>
            <td class="info-label">رقم المرتجع:</td>
            <td class="info-value"><?php echo e(str_pad($return_invoice->id, 5, '0', STR_PAD_LEFT)); ?></td>
            <td class="info-label">تاريخ المرتجع:</td>
            <td class="info-value"><?php echo e($return_invoice->created_at->format('Y/m/d')); ?></td>
        </tr>
        <tr>
            <td class="info-label">رقم الفاتورة الأصلية:</td>
            <td class="info-value"><?php echo e($return_invoice->original_invoice_id); ?></td>
            <td class="info-label">تاريخ الفاتورة الأصلية:</td>
            <td class="info-value"><?php echo e($return_invoice->original_invoice_date ?? 'غير متوفر'); ?></td>
        </tr>
        <tr>
            <td class="info-label">العميل:</td>
            <td class="info-value"><?php echo e($return_invoice->client->trade_name ?? $return_invoice->client->first_name . ' ' . $return_invoice->client->last_name); ?></td>
            <td class="info-label">العنوان:</td>
            <td class="info-value"><?php echo e($return_invoice->client->street2 ?? 'غير متوفر'); ?></td>
        </tr>
    </table>

    <!-- سبب المرتجع -->
    <div class="return-reason">
        <strong>سبب المرتجع:</strong> <?php echo e($return_invoice->return_reason ?? 'لم يتم تحديد سبب'); ?>

    </div>

    <h3 class="section-title">تفاصيل المرتجع:</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>البند</th>
                <th>الكمية المرتجعة</th>
                <th>سعر الوحدة</th>
                <th>الخصم</th>
                <th>المجموع</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $return_invoice->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($loop->iteration); ?></td>
                <td><?php echo e($item->item); ?></td>
                <td><?php echo e($item->quantity); ?></td>
                <td><?php echo e(number_format($item->unit_price, 2)); ?></td>
                <td><?php echo e(number_format($item->discount, 2)); ?></td>
                <td><?php echo e(number_format($item->total, 2)); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
                                             <?php
                                            $currency = $account_setting->currency ?? 'SAR';
                                            $currencySymbol = $currency == 'SAR' || empty($currency) ? '<img src="' . asset('assets/images/Saudi_Riyal.svg') . '" alt="ريال سعودي" width="15" style="vertical-align: middle;">' : $currency;
                                        ?>
    <div class="totals">
        <p>إجمالي المرتجع قبل الضريبة: <?php echo e(number_format($return_invoice->subtotal ?? 0, 2)); ?> <?php echo $currencySymbol; ?></p>
        <p>ضريبة القيمة المضافة (15%): <?php echo e(number_format($return_invoice->tax_total ?? 0, 2)); ?> <?php echo $currencySymbol; ?></p>
        <?php if(($return_invoice->total_discount ?? 0) > 0): ?>
            <p>الخصم: <?php echo e(number_format($return_invoice->total_discount, 2)); ?> <?php echo $currencySymbol; ?></p>
        <?php endif; ?>
        <p>إجمالي المرتجع: <?php echo e(number_format($return_invoice->grand_total ?? 0, 2)); ?> <?php echo $currencySymbol; ?></p>
    </div>

    <div class="qrcode">
        <canvas id="qrcode"></canvas>
    </div>

    <div class="signatures">
        <div class="signature-box">
            <div class="signature-line">توقيع المستلم</div>
        </div>
        <div class="signature-box">
            <div class="signature-line">توقيع العميل</div>
        </div>
        <div class="signature-box">
            <div class="signature-line">ختم الشركة</div>
        </div>
    </div>

    <script>
        const returnData = `
            رقم المرتجع: <?php echo e($return_invoice->id); ?>

            التاريخ: <?php echo e($return_invoice->created_at->format('Y/m/d')); ?>

            العميل: <?php echo e($return_invoice->client->trade_name ?? $return_invoice->client->first_name . ' ' . $return_invoice->client->last_name); ?>

            الإجمالي: <?php echo e(number_format($return_invoice->grand_total, 2)); ?> ر.س
            رقم الفاتورة الأصلية: <?php echo e($return_invoice->original_invoice_id); ?>

        `;

        QRCode.toCanvas(document.getElementById('qrcode'), returnData, {
            width: 150,
            margin: 1
        }, function (error) {
            if (error) console.error(error);
            console.log('QR Code generated successfully!');
        });
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/sales/retend_invoice/pdf.blade.php ENDPATH**/ ?>