<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>إشعار دائن</title>
    <style>
        * {
            font-family: Arial, sans-serif !important;
            direction: rtl;
            unicode-bidi: embed;
        }

        body {
            font-family: Arial, sans-serif !important;
            direction: rtl;
            padding: 20px;
            font-size: 13px;
            line-height: 1.6;
            unicode-bidi: embed;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: right;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .company-info {
            margin-bottom: 20px;
            text-align: center;
        }

        .invoice-details {
            margin-bottom: 20px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .section-title {
            background-color: #f5f5f5;
            padding: 5px;
            margin: 10px 0;
            font-weight: bold;
        }

        .numbers {
            font-family: Arial, sans-serif !important;
            direction: ltr;
            display: inline-block;
        }

        @page {
            margin: 1cm;
            size: A4 portrait;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.1/build/qrcode.min.js"></script>
</head>
<body>
    <div class="company-info">
        <?php if(isset($company_logo)): ?>
            <img src="<?php echo e($company_logo); ?>" alt="شعار الشركة">
        <?php endif; ?>
        <h2><?php echo e($company_name ?? 'اسم الشركة'); ?></h2>
        <p><?php echo e($company_address ?? 'عنوان الشركة'); ?></p>
        <p>هاتف: <span class="numbers"><?php echo e($company_phone ?? 'رقم الهاتف'); ?></span></p>
    </div>

    <div class="header">
        <h1>إشعار دائن</h1>
        <p><?php echo e($credit->client->trade_name ?? $credit->client->first_name . ' ' . $credit->client->last_name); ?></p>
        <p><?php echo e($credit->client->street1 ?? 'غير متوفر'); ?></p>
        <p><?php echo e($credit->client->mobile ?? 'غير متوفر'); ?></p>
    </div>


    <h3 class="section-title">تفاصيل الإشعار الدائن:</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>البند</th>
                <th>الوصف</th>
                <th>الكمية</th>
                <th>سعر الوحدة</th>
                <th>الخصم</th>
                <th>المجموع</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $credit->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($loop->iteration); ?></td>
                <td><?php echo e($item->item); ?></td>
                <td><?php echo e($item->description ?? '-'); ?></td>
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
        <p>المجموع الفرعي: <?php echo e(number_format($credit->subtotal ?? 0, 2)); ?> <?php echo $currencySymbol; ?></p>

        <?php if(($credit->total_discount ?? 0) > 0): ?>
            <p>الخصم: <?php echo e(number_format($credit->total_discount, 2)); ?> <?php echo $currencySymbol; ?></p>
        <?php endif; ?>

            <?php if($TaxsInvoice->isNotEmpty()): ?>
    <?php $__currentLoopData = $TaxsInvoice; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $TaxInvoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <p> <?php echo e($TaxInvoice->name); ?> (<?php echo e($TaxInvoice->rate); ?>%): 
            <?php echo e(number_format($TaxInvoice->value ?? 0, 2)); ?> <?php echo $currencySymbol; ?>

        </p>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php else: ?>
    <p>الضريبة: 0.00 <?php echo $currencySymbol; ?></p>
<?php endif; ?>
        <p style="font-size: 14px; margin-top: 10px;">المجموع الكلي: <?php echo e(number_format($credit->grand_total ?? 0, 2)); ?> <?php echo $currencySymbol; ?></p>
        <p><?php echo e($amount_in_words ?? ''); ?></p>
    </div>

    <?php if($credit->notes): ?>
    <div class="notes">
        <h3 class="section-title">ملاحظات:</h3>
        <p><?php echo e($credit->notes); ?></p>
    </div>
    <?php endif; ?>

    <div class="qrcode">
        <canvas id="qrcode"></canvas>
    </div>

    <div class="signatures">
        <div class="signature-box">
            <div class="signature-line">توقيع المحاسب</div>
        </div>
        <div class="signature-box">
            <div class="signature-line">توقيع المدير المالي</div>
        </div>
        <div class="signature-box">
            <div class="signature-line">ختم الشركة</div>
        </div>
    </div>



    <script>
        const creditData = `
            رقم الإشعار الدائن: <?php echo e($credit->credit_number); ?>

            التاريخ: <?php echo e($credit->created_at->format('Y/m/d')); ?>

            العميل: <?php echo e($credit->client->trade_name ?? $credit->client->first_name . ' ' . $credit->client->last_name); ?>

            الإجمالي: <?php echo e(number_format($credit->grand_total, 2)); ?> ر.س
            رقم الفاتورة المرجعية: <?php echo e($credit->reference_invoice_number ?? 'غير متوفر'); ?>

            الرقم الضريبي: <?php echo e($credit->client->tax_number ?? 'غير متوفر'); ?>

        `;

        QRCode.toCanvas(document.getElementById('qrcode'), creditData, {
            width: 150,
            margin: 1
        }, function (error) {
            if (error) console.error(error);
            console.log('QR Code generated successfully!');
        });
    </script>
</body>
</html>
<?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/sales/creted_note/pdf.blade.php ENDPATH**/ ?>