<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>أمر شراء</title>
    <style>
        body {
            direction: rtl;
            font-family: aealarabiya;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border: 1px solid #000;
            padding: 10px;
        }

        .header h1 {
            margin: 0;
            padding: 0;
            font-size: 18px;
        }

        .header p {
            margin: 5px 0;
        }

        .info-grid {
            width: 100%;
            margin: 20px 0;
        }

        .info-grid td {
            padding: 5px;
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
            margin: 20px 0;
        }

        .data-table th, .data-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        .data-table th {
            background-color: #f5f5f5;
        }

        .section-title {
            margin: 20px 0 10px;
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
        }

        .signatures {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            width: 200px;
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #000;
            margin-top: 40px;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    @php
        // التحقق من وجود العناصر وتهيئة المتغيرات
        $hasItems = isset($purchaseOrdersRequests->items) && is_object($purchaseOrdersRequests->items) && $purchaseOrdersRequests->items->count() > 0;
        $items = $hasItems ? $purchaseOrdersRequests->items : collect([]);

        // تهيئة المتغيرات الحسابية
        $subtotal = 0;
        $totalDiscount = 0;
        $totalTax = 0;

        if ($hasItems) {
            foreach ($items as $item) {
                $itemSubtotal = $item->quantity * $item->unit_price;
                $subtotal += $itemSubtotal;
                $totalDiscount += ($itemSubtotal * $item->discount) / 100;
                $afterDiscount = $itemSubtotal - ($itemSubtotal * $item->discount) / 100;
                $totalTax += ($afterDiscount * $item->tax) / 100;
            }
        }
    @endphp

    <div class="header">
        <h1>أمر شراء</h1>
        <p>{{ date('d/m/Y') }}</p>
        <p>مؤسسة اعمال عتمة للتجارة</p>
        <p>رقم الأمر: {{ $purchaseOrdersRequests->code }}</p>
        @if($purchaseOrdersRequests->status == 'under_review')
            <p>الحالة: تحت المراجعة</p>
        @elseif($purchaseOrdersRequests->status == 'canceled')
            <p>الحالة: ملغي</p>
        @elseif($purchaseOrdersRequests->status == 'converted')
            <p>الحالة: محول إلى فاتورة</p>
        @endif
    </div>

    <table class="info-grid" cellpadding="0" cellspacing="0">
        <tr>
            <td class="info-label">المورد:</td>
            <td class="info-value">{{ optional($purchaseOrdersRequests->supplier)->trade_name ?? 'غير محدد' }}</td>
            <td class="info-label">رقم الأمر:</td>
            <td class="info-value">{{ $purchaseOrdersRequests->code }}</td>
        </tr>
        <tr>
            <td class="info-label">تاريخ الأمر:</td>
            <td class="info-value">{{ $purchaseOrdersRequests->date }}</td>
            <td class="info-label">تاريخ التسليم:</td>
            <td class="info-value">{{ $purchaseOrdersRequests->delivery_date }}</td>
        </tr>
        <tr>
            <td class="info-label">الحساب:</td>
            <td class="info-value">{{ optional($purchaseOrdersRequests->account)->name ?? 'غير محدد' }}</td>
            <td class="info-label">منشئ الأمر:</td>
            <td class="info-value">{{ optional($purchaseOrdersRequests->creator)->name ?? 'غير محدد' }}</td>
        </tr>
        <tr>
            <td class="info-label">العملة:</td>
            <td class="info-value">{{ $purchaseOrdersRequests->currency }}</td>
            <td class="info-label">شروط الدفع:</td>
            <td class="info-value">{{ $purchaseOrdersRequests->payment_terms }}</td>
        </tr>
    </table>

    <h3 class="section-title">تفاصيل المنتجات:</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>المنتج</th>
                <th>الكمية</th>
                <th>سعر الوحدة</th>
                <th>الخصم (%)</th>
                <th>الضريبة (%)</th>
                @if($purchaseOrdersRequests->shipping_cost > 0)
                    <th>الشحن</th>
                @endif
                <th>الإجمالي</th>
            </tr>
        </thead>
        <tbody>
            @if($hasItems)
                @foreach($items as $item)
                    @php
                        $itemSubtotal = $item->quantity * $item->unit_price;
                        $itemDiscount = ($itemSubtotal * $item->discount) / 100;
                        $afterDiscount = $itemSubtotal - $itemDiscount;
                        $itemTax = ($afterDiscount * $item->tax) / 100;
                        $itemTotal = $afterDiscount + $itemTax;
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ optional($item->product)->name ?? $item->item }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->unit_price, 2) }}</td>
                        <td>{{ number_format($item->discount, 1) }}%</td>
                        <td>{{ number_format($item->tax, 1) }}%</td>
                        @if($purchaseOrdersRequests->shipping_cost > 0)
                            <td>{{ number_format($item->shipping, 2) }}</td>
                        @endif
                        <td>{{ number_format($itemTotal, 2) }}</td>
                    </tr>
                @endforeach

                <!-- إجماليات -->
                <tr>
                    <td colspan="{{ $purchaseOrdersRequests->shipping_cost > 0 ? '7' : '6' }}" style="text-align: left; font-weight: bold;">
                        المجموع قبل الخصم والضريبة:
                    </td>
                    <td>{{ number_format($subtotal, 2) }}</td>
                </tr>

                @if($totalDiscount > 0)
                    <tr>
                        <td colspan="{{ $purchaseOrdersRequests->shipping_cost > 0 ? '7' : '6' }}" style="text-align: left; font-weight: bold;">
                            إجمالي الخصم:
                        </td>
                        <td>{{ number_format($totalDiscount, 2) }}</td>
                    </tr>
                @endif

                @if($totalTax > 0)
                    <tr>
                        <td colspan="{{ $purchaseOrdersRequests->shipping_cost > 0 ? '7' : '6' }}" style="text-align: left; font-weight: bold;">
                            إجمالي الضريبة:
                        </td>
                        <td>{{ number_format($totalTax, 2) }}</td>
                    </tr>
                @endif

                @if($purchaseOrdersRequests->shipping_cost > 0)
                    <tr>
                        <td colspan="7" style="text-align: left; font-weight: bold;">تكلفة الشحن:</td>
                        <td>{{ number_format($purchaseOrdersRequests->shipping_cost, 2) }}</td>
                    </tr>
                @endif

                <tr>
                    <td colspan="{{ $purchaseOrdersRequests->shipping_cost > 0 ? '7' : '6' }}" style="text-align: left; font-weight: bold;">
                        المجموع النهائي:
                    </td>
                    <td>{{ number_format($subtotal - $totalDiscount + $totalTax + ($purchaseOrdersRequests->shipping_cost ?? 0), 2) }}</td>
                </tr>
            @else
                <tr>
                    <td colspan="{{ $purchaseOrdersRequests->shipping_cost > 0 ? '8' : '7' }}" class="text-center">
                        لا توجد منتجات مضافة
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    @if($purchaseOrdersRequests->notes)
        <div class="footer">
            <p><strong>ملاحظات:</strong> {{ $purchaseOrdersRequests->notes }}</p>
        </div>
    @endif

    <div class="signatures">
        <div class="signature-box">
            <div class="signature-line">توقيع المورد</div>
        </div>
        <div class="signature-box">
            <div class="signature-line">توقيع المشتري</div>
        </div>
        <div class="signature-box">
            <div class="signature-line">ختم الشركة</div>
        </div>
    </div>
</body>
</html>
