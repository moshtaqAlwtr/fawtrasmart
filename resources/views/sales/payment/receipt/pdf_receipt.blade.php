<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>إيصال استلام #{{ $receipt->id }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            direction: rtl;
            margin: 0;
            padding: 0;
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .receipt-container {
            width: 80mm;
            background: white;
            padding: 15px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border: 1px solid #ddd;
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px dashed #000;
        }

        .receipt-header h1 {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
        }

        .receipt-header p {
            margin: 5px 0;
            font-size: 14px;
        }

        .receipt-details {
            margin: 15px 0;
        }

        .receipt-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .receipt-label {
            font-weight: bold;
            min-width: 100px;
        }

        .receipt-value {
            text-align: left;
        }

        .receipt-divider {
            border-top: 2px dashed #000;
            margin: 15px 0;
            padding-top: 10px;
        }

        .receipt-footer {
            text-align: center;
            margin-top: 20px;
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 60%;
            margin: 30px auto 10px;
            text-align: center;
            padding-top: 5px;
            font-size: 14px;
        }

        @media print {
            body {
                background: white !important;
                padding: 0 !important;
            }

            .receipt-container {
                box-shadow: none !important;
                border: none !important;
                width: 80mm !important;
                padding: 10px !important;
                margin: 0 !important;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="no-print" style="position: fixed; top: 20px; right: 20px; z-index: 1000;">
        <button onclick="window.print()" style="padding: 8px 15px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;">
            <i class="fas fa-print"></i> طباعة
        </button>
    </div>

    <div class="receipt-container">
        <div class="receipt-header">
            <h1>إيصال استلام</h1>
            <p>مؤسسة أعمال خاصة للتجارة</p>
            <p>الرياض - الرياض</p>
        </div>

        <div class="receipt-divider"></div>

        <div class="receipt-details">
            <div class="receipt-row">
                <span class="receipt-label">رقم:</span>
                <span class="receipt-value">{{ str_pad($receipt->id, 6, '0', STR_PAD_LEFT) }}</span>
            </div>

            <div class="receipt-row">
                <span class="receipt-label">تاريخ:</span>
                <span class="receipt-value">{{ $receipt->payment_date ? $receipt->payment_date->format('d/m/Y') : date('d/m/Y') }}</span>
            </div>

            <div class="receipt-row">
                <span class="receipt-label">من:</span>
                <span class="receipt-value">
                    @if($receipt->client)
                        {{ $receipt->client->trade_name ?? $receipt->client->first_name . ' ' . $receipt->client->last_name }}
                    @else
                        أسواق ومخابر البادية
                    @endif
                </span>
            </div>

            <div class="receipt-row">
                <span class="receipt-label">المبلغ:</span>
                <span class="receipt-value">SAR {{ number_format($receipt->amount, 2) }}</span>
            </div>

            <div class="receipt-row">
                <span class="receipt-label">المستلم:</span>
                <span class="receipt-value">{{ $receipt->employee->full_name ?? 'ركان' }}</span>
            </div>

            <div class="receipt-row">
                <span class="receipt-label">الخزينة:</span>
                <span class="receipt-value">{{ $receipt->treasury->name ?? 'خزينة مكة المكرمة' }}</span>
            </div>
        </div>

        <div class="receipt-divider"></div>

        <div class="receipt-footer">
            <div class="signature-line">التوقيع</div>
        </div>
    </div>

    <script>
        // طباعة تلقائية عند تحميل الصفحة
        window.onload = function() {
            setTimeout(() => {
                window.print();
            }, 500);
        };
    </script>
</body>
</html>
