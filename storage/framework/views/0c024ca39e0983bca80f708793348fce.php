<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>عرض سعر #<?php echo e($quote->quotes_number); ?></title>
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
            width: 100px;
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
            background-color: #f5f5f5;
        }

        .section-title {
            margin: 10px 0 5px;
            border-bottom: 1px solid #000;
            padding-bottom: 3px;
            font-size: 14px;
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
    </style>
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.1/build/qrcode.min.js"></script>
</head>
<body>
    <div class="header">
        <h1>عرض سعر</h1>
        <p><?php echo e($quote->client->trade_name ?? $quote->client->first_name . ' ' . $quote->client->last_name); ?></p>
        <p><?php echo e($quote->client->street1 ?? 'غير متوفر'); ?></p>
        <p><?php echo e($quote->client->mobile ?? 'غير متوفر'); ?></p>
    </div>

    <table class="info-grid" cellpadding="0" cellspacing="0">
        <tr>
            <td class="info-label">رقم عرض السعر:</td>
            <td class="info-value"><?php echo e(str_pad($quote->quotes_number, 5, '0', STR_PAD_LEFT)); ?></td>
            <td class="info-label">تاريخ العرض:</td>
            <td class="info-value"><?php echo e($quote->quote_date); ?></td>
        </tr>
        <tr>
            <td class="info-label">العميل:</td>
            <td class="info-value"><?php echo e($quote->client->trade_name ?? $quote->client->first_name . ' ' . $quote->client->last_name); ?></td>
            <td class="info-label">العنوان:</td>
            <td class="info-value"><?php echo e($quote->client->street2 ?? 'غير متوفر'); ?></td>
        </tr>
    </table>

    <h3 class="section-title">تفاصيل عرض السعر:</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>البند</th>
                <th>الكمية</th>
                <th>سعر الوحدة</th>
                <th>الخصم</th>
                <th>المجموع</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $quote->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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

    <div class="totals">
         <?php
        $currency = $account_setting->currency ?? 'SAR';
        $currencySymbol =
            $currency == 'SAR' || empty($currency)
                ? '<img src="' . asset('assets/images/Saudi_Riyal.svg') . '" alt="ريال سعودي" width="15">'
                : $currency;
    ?>
        <!-- الضريبة -->
        <?php if($TaxsInvoice->isNotEmpty()): ?>
    <?php $__currentLoopData = $TaxsInvoice; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $TaxInvoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <p> <?php echo e($TaxInvoice->name); ?> (<?php echo e($TaxInvoice->rate); ?>%): 
            <?php echo e(number_format($TaxInvoice->value ?? 0, 2)); ?> <?php echo $currencySymbol; ?>

        </p>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php else: ?>
    <p>الضريبة: 0.00 <?php echo $currencySymbol; ?></p>
<?php endif; ?>

        <!-- الشحن -->
        <?php if(($quote->shipping_cost ?? 0) > 0): ?>
            <p>تكلفة الشحن: <?php echo e(number_format($quote->shipping_cost, 2)); ?> <?php echo $currencySymbol; ?></p>
        <?php endif; ?>

        <!-- الخصم -->
        <?php if(($quote->total_discount ?? 0) > 0): ?>
            <p>الخصم: <?php echo e(number_format($quote->total_discount, 2)); ?> <?php echo $currencySymbol; ?></p>
        <?php endif; ?>

        <!-- المجموع الكلي -->
        <p>المجموع الكلي: <?php echo e(number_format($quote->grand_total ?? 0, 2)); ?> <?php echo $currencySymbol; ?></p>
    </div>

    <!-- قسم QR Code -->
    <div class="qrcode">
        <canvas id="qrcode"></canvas>
    </div>

    <div class="signatures">
        <div class="signature-box">
            <div class="signature-line">توقيع البائع</div>
        </div>
        <div class="signature-box">
            <div class="signature-line">توقيع العميل</div>
        </div>
        <div class="signature-box">
            <div class="signature-line">ختم الشركة</div>
        </div>
    </div>

    <script>
        const quoteData = `
            رقم عرض السعر: <?php echo e($quote->quotes_number); ?>

            التاريخ: <?php echo e($quote->quote_date); ?>

            العميل: <?php echo e($quote->client->trade_name ?? $quote->client->first_name . ' ' . $quote->client->last_name); ?>

            الإجمالي: <?php echo e(number_format($quote->grand_total, 2)); ?> ر.س
        `;

        QRCode.toCanvas(document.getElementById('qrcode'), quoteData, {
            width: 150,
            margin: 1
        }, function (error) {
            if (error) console.error(error);
            console.log('QR Code generated successfully!');
        });
    </script>
</body>
</html>
<?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/sales/qoution/pdf.blade.php ENDPATH**/ ?>