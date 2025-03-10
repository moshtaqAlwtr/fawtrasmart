<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>فاتورة #{{ $invoice->id }}</title>
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
        <p>{{ $invoice->client->trade_name ?? $invoice->client->first_name . ' ' . $invoice->client->last_name }}</p>
        <p>{{ $invoice->client->street1 ?? 'غير متوفر' }}</p>
        <p>{{ $invoice->client->mobile ?? 'غير متوفر' }}</p>
    </div>

    <table class="info-grid" cellpadding="0" cellspacing="0">
        <tr>
            <td class="info-label">رقم الفاتورة:</td>
            <td class="info-value">{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}</td>
            <td class="info-label">تاريخ الفاتورة:</td>
            <td class="info-value">
                {{ $invoice->created_at ? $invoice->created_at->format($account_setting->time_formula ?? 'H:i:s d/m/Y') : '' }}
            </td>

        </tr>
        <tr>
            <td class="info-label">العميل:</td>
            <td class="info-value">
                {{ $invoice->client->trade_name ?? $invoice->client->first_name . ' ' . $invoice->client->last_name }}
            </td>
            <td class="info-label">العنوان:</td>
            <td class="info-value">{{ $invoice->client->street2 ?? 'غير متوفر' }}</td>
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
            @foreach ($invoice->items as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->item }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->unit_price, 2) }}</td>
                    <td>{{ number_format($item->discount, 2) }}</td>
                    <td>{{ number_format($item->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        @php
        $currency = $account_setting->currency ?? 'SAR';
        $currencySymbol =
            $currency == 'SAR' || empty($currency)
                ? '<img src="' . asset('assets/images/Saudi_Riyal.svg') . '" alt="ريال سعودي" width="15">'
                : $currency;
    @endphp

        <p>المجموع الكلي: {{ number_format($invoice->grand_total ?? 0, 2) }} {!! $currencySymbol !!}
        </p>
        <p>ضريبة القيمة المضافة (15%): {{ number_format($invoice->tax_total ?? 0, 2) }}
            {!! $currencySymbol !!}</p>

       

        @if (($invoice->shipping_cost ?? 0) > 0)
            <p>تكلفة الشحن: {{ number_format($invoice->shipping_cost, 2) }} {!! $currencySymbol !!}</p>
        @endif

        @if (($invoice->total_discount ?? 0) > 0)
            <p>الخصم: {{ number_format($invoice->total_discount, 2) }} {!! $currencySymbol !!}</p>
        @endif

        @if (($invoice->advance_payment ?? 0) > 0)
            <p>الدفعة المقدمة: {{ number_format($invoice->advance_payment, 2) }} {!! $currencySymbol !!}</p>
        @endif

        @if (($invoice->due_value ?? 0) > 0)
            <p>المبلغ المستحق: {{ number_format($invoice->due_value, 2) }} {!! $currencySymbol !!}</p>
        @endif




    </div>
    <div class="barcode" style="text-align: center; margin: 20px auto;">
        <img src="{{ $barcodeImage }}" style="height: 50px;">
        <div style="font-size: 12px; margin-top: 5px;">{{ str_pad($invoice->id, 13, '0', STR_PAD_LEFT) }}</div>
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
