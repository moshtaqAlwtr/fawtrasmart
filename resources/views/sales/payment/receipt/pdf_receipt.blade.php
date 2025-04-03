<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="UTF-8">
    <title>إيصال استلام #{{ $receipt->id }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            direction: rtl;
            margin: 0;
            padding: 20px;
            background: #f5f5f5;
        }

        .receipt-container {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border: 1px solid #ddd;
            position: relative;
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #000;
        }

        .receipt-title {
            font-size: 20px;
            font-weight: bold;
            margin: 5px 0;
        }

        .receipt-info {
            margin: 15px 0;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .info-label {
            font-weight: bold;
        }

        .signature-area {
            margin-top: 40px;
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 200px;
            margin: 20px auto;
            padding-top: 5px;
        }

        .payment-details {
            margin-top: 15px;
            font-size: 14px;
            text-align: center;
        }

        .stamp {
            position: absolute;
            bottom: 30px;
            left: 30px;
            opacity: 0.7;
        }

        .stamp-content {
            border: 2px solid red;
            color: red;
            padding: 5px 10px;
            transform: rotate(-15deg);
            display: inline-block;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .receipt-container {
                border: none;
                box-shadow: none;
            }
        }
    </style>
</head>

<body>
    <div class="receipt-container">
        <div class="receipt-header">
            <div class="receipt-title">إيصال استلام</div>
            <div>{{ $receipt->branch->name ?? 'مؤسسة أعمال خاصة للنجارة' }}</div>
            <div>{{ $receipt->branch->address ?? 'الرياض' }}</div>
        </div>

        <div class="receipt-info">
            <div class="info-row">
                <span class="info-label">رقم:</span>
                <span>{{ str_pad($receipt->id, 6, '0', STR_PAD_LEFT) }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">تاريخ:</span>
                <span>{{ $receipt->payment_date->format('d/m/Y') }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">من:</span>
                <span>
                    {{ $receipt->invoice->client->trade_name ?? 'غير محدد' }}
                </span>
            </div>

            <div class="info-row">
                <span class="info-label">المبلغ:</span>
                <span>SAR {{ number_format($receipt->amount, 2) }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">المستلم:</span>
                <span>{{ $receipt->employee->name ?? 'غير محدد' }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">الخزينة:</span>
                <span>{{ $receipt->treasury->name ?? 'خزينة الرئيسية' }}</span>
            </div>
        </div>

        <div class="payment-details">
            <div>طريقة الدفع: {{ $receipt->payment_type->name ?? 'غير محدد' }}</div>
            <div>رقم المرجع: {{ $receipt->reference_number ?? 'غير محدد' }}</div>
        </div>

        <div class="signature-area">
            <div>......</div>
            <div class="signature-line">التوقيع: {{ $receipt->invoice->employee->full_name ?? 'غير محدد' }}</div>
            <div style="margin-top: 30px;">شكراً لتعاملكم معنا</div>
            <div style="margin-top: 10px;">لديك سؤال؟</div>
        </div>

        @if ($receipt->payment_status == 1)
            <div class="stamp">
                <div class="stamp-content">مدفوع</div>
            </div>
        @endif
    </div>

    <script>
        window.onload = function() {
            setTimeout(() => {
                window.print();
            }, 200);
        };
    </script>
</body>

</html>
