<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سند قبض حراري</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            direction: rtl;
            text-align: right;
            margin: 0;
            padding: 0;
            width: 80mm; /* عرض الطابعة الحرارية */
        }
        .container {
            padding: 5px;
            width: 100%;
        }
        .header, .footer {
            text-align: center;
            margin: 5px 0;
            font-weight: bold;
        }
        .details {
            margin: 10px 0;
            font-size: 14px;
        }
        .details p {
            margin: 5px 0;
        }
        .signature {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            font-size: 12px;
        }
        .barcode {
            text-align: center;
            margin: 10px 0;
        }
        hr {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>موسسة  اعمال خاصة </h2>
            <h3>سند القبض</h3>
        </div>

        <hr>

        <div class="details">
            <p><strong>رقم السند:</strong> {{ $income->code }}</p>
            <p><strong>التاريخ:</strong> {{ $income->date }}</p>
            <p><strong>استلمنا من العميل:</strong> {{ $income->account->name }}</p>
            <p><strong>مبلغ وقدره:</strong> {{ $income->amount }} رس</p>
            <p><strong>وذلك مقابل:</strong> {{ $income->description }}</p>
        </div>

        <hr>

        <div class="signature">
            <div>توقيع المستلم</div>
            <div>ختم المؤسسة</div>
        </div>

        <div class="barcode">
            *{{ $income->code }}*
        </div>

        <div class="footer">
            شكراً لتعاملكم معنا
        </div>
    </div>

    <script>
        // طباعة تلقائية عند فتح الصفحة
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
