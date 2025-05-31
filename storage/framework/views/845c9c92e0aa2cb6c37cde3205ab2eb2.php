<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سند قبض</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            direction: rtl;
            text-align: right;
            margin: 0;
            padding: 0;
            background-color: #f7f9fc;
        }
        .container {
            background: #ffffff;
            padding: 20px;
            width: 210mm; /* حجم A4 */
            margin: 0 auto;
            border: 1px solid #d1e7dd;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #6c757d;
            padding-bottom: 10px;
        }
        .header h2 {
            color: #6c757d;
            font-size: 24px;
            margin: 5px 0;
        }
        .header h3 {
            color: #495057;
            font-size: 20px;
            margin: 5px 0;
        }
        .details {
            margin: 20px 0;
            font-size: 16px;
            line-height: 1.6;
        }
        .details p {
            margin: 8px 0;
        }
        .signature {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
        }
        .signature div {
            width: 45%;
            text-align: center;
            border-top: 1px dashed #6c757d;
            padding-top: 10px;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #6c757d;
        }
        .watermark {
            position: absolute;
            opacity: 0.1;
            font-size: 80px;
            transform: rotate(-45deg);
            z-index: -1;
            top: 40%;
            left: 25%;
        }
        @media print {
            .no-print {
                display: none;
            }
            .container {
                box-shadow: none;
                border: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>مؤ سسة الطيب الافضل - جميع الحقوق محفوظة </h2>
            <h3>سند القبض</h3>
        </div>

        <div class="details">
            <p><strong>رقم السند:</strong> <?php echo e($income->code); ?></p>
            <p><strong>التاريخ:</strong> <?php echo e($income->date); ?></p>
            <p><strong>استلمنا من العميل:</strong> <?php echo e($income->account->name); ?></p>
            <p><strong>مبلغ وقدره:</strong> <?php echo e($income->amount); ?> رس</p>
            <p><strong>فقط:</strong> <?php echo e($income->amount_in_words); ?></p>
            <p><strong>وذلك مقابل:</strong> <?php echo e($income->description); ?></p>
        </div>

        <div class="signature">
            <div>توقيع المستلم</div>
            <div>أمين الصندوق</div>
        </div>

        <div class="footer">
            © <?php echo e(date('Y')); ?> مؤ سسة الطيب الافضل - جميع الحقوق محفوظة
        </div>

        <div class="watermark">
            سند قبض
        </div>
    </div>

    <div class="no-print" style="text-align:center; margin:20px;">
        <button onclick="window.print()" style="padding:10px 20px; background:#4CAF50; color:white; border:none; cursor:pointer;">
            طباعة السند
        </button>
        <button onclick="window.close()" style="padding:10px 20px; background:#f44336; color:white; border:none; cursor:pointer;">
            إغلاق النافذة
        </button>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/finance/incomes/print_normal.blade.php ENDPATH**/ ?>