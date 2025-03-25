<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>فاتورة #<?php echo e($invoice->id); ?></title>
    <style>
        body {
            font-family: 'aealarabiya';
            direction: rtl;
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

        .data-table th,
        .data-table td {
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
            width: 100%;
            text-align: center;
        }

        .signature-box {
            display: inline-block;
            width: 30%;
            text-align: center;
            margin: 0 1%;
        }

        .signature-line {
            border-top: 1px solid #000;
            margin-top: 20px;
            padding-top: 3px;
        }

        .qrcode {
            text-align: center;
            margin: 20px auto;
            width: 100px;
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
</head>

<body>
    <div class="header">
        <h1>فاتورة ضريبية مبسطة</h1>
        <p><?php echo e($invoice->client->trade_name ?? $invoice->client->first_name . ' ' . $invoice->client->last_name); ?></p>
        <p><?php echo e($invoice->client->street1 ?? 'غير متوفر'); ?></p>
        <p><?php echo e($invoice->client->mobile ?? 'غير متوفر'); ?></p>
    </div>

    <table class="info-grid" cellpadding="0" cellspacing="0">
        <tr>
            <td class="info-label">رقم الفاتورة:</td>
            <td class="info-value"><?php echo e(str_pad($invoice->id, 5, '0', STR_PAD_LEFT)); ?></td>
            <td class="info-label">تاريخ الفاتورة:</td>
            <td class="info-value">
                <?php echo e($invoice->created_at ? $invoice->created_at->format($account_setting->time_formula ?? 'H:i:s d/m/Y') : ''); ?>

            </td>

        </tr>
        <tr>
            <td class="info-label">العميل:</td>
            <td class="info-value">
                <?php echo e($invoice->client->trade_name ?? $invoice->client->first_name . ' ' . $invoice->client->last_name); ?>

            </td>
            <td class="info-label">العنوان:</td>
            <td class="info-value"><?php echo e($invoice->client->street2 ?? 'غير متوفر'); ?></td>
        </tr>
    </table>

    <h3 class="section-title">تفاصيل الفاتورة:</h3>
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
            <tbody>
                <?php $__currentLoopData = $invoice->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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

        <p>المجموع الكلي: <?php echo e(number_format($invoice->grand_total ?? 0, 2)); ?> <?php echo $currencySymbol; ?>

        </p>
        
     <?php if($TaxsInvoice->isNotEmpty()): ?>
    <?php $__currentLoopData = $TaxsInvoice; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $TaxInvoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <p> <?php echo e($TaxInvoice->name); ?> (<?php echo e($TaxInvoice->rate); ?>%): 
            <?php echo e(number_format($TaxInvoice->value ?? 0, 2)); ?> <?php echo $currencySymbol; ?>

        </p>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php else: ?>
    <p>الضريبة: 0.00 <?php echo $currencySymbol; ?></p>
<?php endif; ?>




        <?php if(($invoice->shipping_cost ?? 0) > 0): ?>
            <p>تكلفة الشحن: <?php echo e(number_format($invoice->shipping_cost, 2)); ?> <?php echo $currencySymbol; ?></p>
        <?php endif; ?>

        <?php if(($invoice->total_discount ?? 0) > 0): ?>
            <p>الخصم: <?php echo e(number_format($invoice->total_discount, 2)); ?> <?php echo $currencySymbol; ?></p>
        <?php endif; ?>

        <?php if(($invoice->advance_payment ?? 0) > 0): ?>
            <p>الدفعة المقدمة: <?php echo e(number_format($invoice->advance_payment, 2)); ?> <?php echo $currencySymbol; ?></p>
        <?php endif; ?>

        <?php if(($invoice->due_value ?? 0) > 0): ?>
            <p>المبلغ المستحق: <?php echo e(number_format($invoice->due_value, 2)); ?> <?php echo $currencySymbol; ?></p>
        <?php endif; ?>




    </div>
    <div class="barcode" style="text-align: center; margin: 20px auto;">
        <img src="<?php echo e($barcodeImage); ?>" style="height: 50px;">
        <div style="font-size: 12px; margin-top: 5px;"><?php echo e(str_pad($invoice->id, 13, '0', STR_PAD_LEFT)); ?></div>
    </div>
    <table class="signatures" cellpadding="0" cellspacing="0">
        <tr>
            <td style="width: 33%;">
                <div class="signature-box">
                    <div class="signature-line">توقيع البائع</div>
                </div>
            </td>
            <td style="width: 33%;">
                <div class="signature-box">
                    <div class="signature-line">توقيع العميل</div>
                </div>
            </td>
            <td style="width: 33%;">
                <div class="signature-box">
                    <div class="signature-line">ختم الشركة</div>
                </div>
            </td>
        </tr>
    </table>
</body>

</html>
<?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/sales/invoices/pdf.blade.php ENDPATH**/ ?>