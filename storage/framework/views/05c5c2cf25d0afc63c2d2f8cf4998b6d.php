<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>فاتورة #<?php echo e($invoice->id); ?></title>
    <style>
        /* أنماط الصفحة الرئيسية */
        body {
            font-family: 'aealarabiya', Arial, sans-serif;
            direction: rtl;
            background: white; /* خلفية بيضاء */
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
/* أنماط قائمة المعلومات */
.info-list {
    width: 100%;
    margin: 15px 0;
    border-bottom: 1px solid #eee;
}

.info-row {
    display: flex;
    padding: 8px 0;
    border-top: 1px solid #eee;
}

.info-label {
    font-weight: bold;
    width: 120px;
    flex-shrink: 0;
}

.info-value {
    flex-grow: 1;
    text-align: left;
    padding-right: 10px;
}

/* أنماط قائمة العناصر */
.items-list {
    width: 100%;
    margin: 20px 0;
}

.items-header {
    display: flex;
    font-weight: bold;
    padding: 8px 0;
    border-bottom: 2px solid #000;
}

.item-row {
    display: flex;
    padding: 8px 0;
    border-bottom: 1px solid #eee;
}

.item-col {
    flex: 1;
    text-align: center;
    padding: 0 5px;
}

/* تعديلات للطباعة */
@media print {
    .info-row, .item-row {
        page-break-inside: avoid;
    }
}
        /* وعاء الفاتورة الرئيسي */
        .invoice-main-container {
            width: 100%;
            max-width: 58mm;
            background: white;
            padding: 15px;
            margin: 20px auto;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        
        /* أزرار التحكم */
        .invoice-controls {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 20px 0;
            width: 100%;
            position: fixed;
            top: 20px;
            left: 0;
            right: 0;
            z-index: 1000;
        }
        
        .invoice-controls button {
            padding: 8px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        
        .print-btn {
            background: #28a745;
            color: white;
        }
        
        .back-btn {
            background: #6c757d;
            color: white;
        }
        
        /* أنماط الفاتورة الداخلية */
        .invoice-content {
            width: 100%;
            margin-top: 60px; /* لمنع تداخل الأزرار مع المحتوى */
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
        
        /* أنماط الجداول والمحتوى */
        .info-grid {
            width: 100%;
            margin: 10px 0;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }
        
        .data-table th, 
        .data-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }
        
        /* أنماط الطباعة */
        @media print {
            body {
                background: white !important;
                padding: 0 !important;
                display: block !important;
            }
            
            .invoice-controls {
                display: none !important;
            }
            
            .invoice-main-container {
                box-shadow: none !important;
                margin: 0 auto !important;
                padding: 10px !important;
                width: 58mm !important;
                max-width: 100% !important;
            }
            
            .invoice-content {
                margin-top: 0 !important;
            }
        }
    </style>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="invoice-controls">
        <!--<button class="print-btn" onclick="window.print()">-->
        <!--    <i class="fas fa-print"></i> طباعة-->
        <!--</button>-->
        <!--<button class="back-btn" onclick="window.history.back()">-->
        <!--    <i class="fas fa-arrow-left"></i> رجوع-->
        <!--</button>-->
    </div>
    
    <div class="invoice-main-container">
        <div class="invoice-content">
            <div class="header">
                <h1>فاتورة ضريبية مبسطة</h1>
                <p><?php echo e($invoice->client->trade_name ?? $invoice->client->first_name . ' ' . $invoice->client->last_name); ?></p>
                <p><?php echo e($invoice->client->street1 ?? 'غير متوفر'); ?></p>
                <p><?php echo e($invoice->client->phone ?? 'غير متوفر'); ?></p>
            </div>

           <div class="info-list">
    <div class="info-row">
        <span class="info-label">رقم الفاتورة:</span>
        <span class="info-value"><?php echo e(str_pad($invoice->id, 5, '0', STR_PAD_LEFT)); ?></span>
    </div>
    <div class="info-row">
        <span class="info-label">تاريخ الفاتورة:</span>
        <span class="info-value">
            <?php echo e($invoice->created_at ? $invoice->created_at->format($account_setting->time_formula ?? 'H:i:s d/m/Y') : ''); ?>

        </span>
    </div>
    <div class="info-row">
        <span class="info-label">العميل:</span>
        <span class="info-value">
            <?php echo e($invoice->client->trade_name ?? $invoice->client->first_name . ' ' . $invoice->client->last_name); ?>

        </span>
    </div>
    <div class="info-row">
        <span class="info-label">العنوان:</span>
        <span class="info-value"><?php echo e($invoice->client->street2 ?? 'غير متوفر'); ?></span>
    </div>
</div>

            <h3 class="section-title">تفاصيل الفاتورة:</h3>
         <div class="items-list">
    <div class="items-header">
        <span class="item-col">#</span>
        <span class="item-col">البند</span>
        <span class="item-col">الكمية</span>
        <span class="item-col">سعر الوحدة</span>
        <span class="item-col">الخصم</span>
        <span class="item-col">المجموع</span>
    </div>
    
    <?php $__currentLoopData = $invoice->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="item-row">
        <span class="item-col"><?php echo e($loop->iteration); ?></span>
        <span class="item-col"><?php echo e($item->item); ?></span>
        <span class="item-col"><?php echo e($item->quantity); ?></span>
        <span class="item-col"><?php echo e(number_format($item->unit_price, 2)); ?></span>
        <span class="item-col"><?php echo e(number_format($item->discount, 2)); ?></span>
        <span class="item-col"><?php echo e(number_format($item->total, 2)); ?></span>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

            <div class="totals">
                <?php
                    $currency = $account_setting->currency ?? 'SAR';
                    $currencySymbol = $currency == 'SAR' || empty($currency)
                        ? '<img src="' . asset('assets/images/Saudi_Riyal.svg') . '" alt="ريال سعودي" width="15">'
                        : $currency;
                ?>

                <p>المجموع الكلي: <?php echo e(number_format($invoice->grand_total ?? 0, 2)); ?> <?php echo $currencySymbol; ?></p>
                
                <?php if($TaxsInvoice->isNotEmpty()): ?>
                    <?php $__currentLoopData = $TaxsInvoice; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $TaxInvoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <p><?php echo e($TaxInvoice->name); ?> (<?php echo e($TaxInvoice->rate); ?>%): 
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
                 <?php echo $qrCodeSvg; ?>

               

           
        </div>
    </div>

    <script>
        // طباعة تلقائية عند تحميل الصفحة
        window.onload = function() {
            setTimeout(() => {
                window.print();
            }, 500);
        };
        
        // إعادة الطباعة عند محاولة الإغلاق
        window.onbeforeunload = function() {
            window.print();
        };
    </script>
</body>
</html><?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/sales/invoices/print.blade.php ENDPATH**/ ?>