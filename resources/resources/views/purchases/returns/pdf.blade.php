<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>مرتجع مشتريات</title>
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
        .info-table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 5px;
            border-bottom: 1px dotted #999;
        }
        .products-table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        .products-table th, .products-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
        .totals-table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        .totals-table td {
            padding: 5px;
            border: 1px solid #000;
        }
        .signatures {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            text-align: center;
        }
        .return-status {
            color: #E74C3C;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>مرتجع مشتريات</h2>
        <p>{{ $purchaseInvoiceReturn->date }}</p>
        <p>مؤسسة اعمال عتمة للتجارة</p>
        <p>رقم المرتجع: {{ $purchaseInvoiceReturn->code }}</p>
        <p class="return-status">حالة المرتجع:
            @switch($purchaseInvoiceReturn->status)
                @case(1)
                    معلق
                    @break
                @case(2)
                    مكتمل
                    @break
                @default
                    غير محدد
            @endswitch
        </p>
    </div>

    <table class="info-table">
        <tr>
            <td>المورد:</td>
            <td>{{ optional($purchaseInvoiceReturn->supplier)->trade_name }}</td>
            <td>رقم المرتجع:</td>
            <td>{{ $purchaseInvoiceReturn->code }}</td>
        </tr>
        <tr>
            <td>رقم فاتورة الشراء الأصلية:</td>
            <td>{{ $purchaseInvoiceReturn->reference_number }}</td>
            <td>تاريخ المرتجع:</td>
            <td>{{ $purchaseInvoiceReturn->date }}</td>
        </tr>
        <tr>
            <td>طريقة التسوية:</td>
            <td>
                @switch($purchaseInvoiceReturn->payment_method)
                    @case(1)
                        نقدي
                        @break
                    @case(2)
                        رصيد دائن
                        @break
                    @default
                        غير محدد
                @endswitch
            </td>
            <td>الملاحظات:</td>
            <td>{{ $purchaseInvoiceReturn->notes ?: 'لا يوجد' }}</td>
        </tr>
    </table>

    <h3>تفاصيل المنتجات المرتجعة:</h3>
    <table class="products-table">
        <thead>
            <tr>
                <th>#</th>
                <th>المنتج</th>
                <th>الكمية المرتجعة</th>
                <th>سعر الوحدة</th>
                <th>الخصم</th>
                <th>الضريبة 1</th>
                <th>الضريبة 2</th>
                <th>الإجمالي</th>
            </tr>
        </thead>
        <tbody>
            @if($purchaseInvoiceReturn->invoiceItems && $purchaseInvoiceReturn->invoiceItems->count() > 0)
                @foreach($purchaseInvoiceReturn->invoiceItems as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ optional($item->product)->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->unit_price, 2) }}</td>
                        <td>{{ number_format($item->discount, 2) }}</td>
                        <td>{{ number_format($item->tax_1, 2) }}</td>
                        <td>{{ number_format($item->tax_2, 2) }}</td>
                        <td>{{ number_format($item->total, 2) }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8">لا توجد منتجات مرتجعة</td>
                </tr>
            @endif
        </tbody>
    </table>

    <table class="totals-table">
        <tr>
            <td>إجمالي المنتجات:</td>
            <td>{{ number_format($purchaseInvoiceReturn->subtotal, 2) }}</td>
        </tr>
        <tr>
            <td>إجمالي الخصم:</td>
            <td>{{ number_format($purchaseInvoiceReturn->total_discount, 2) }}</td>
        </tr>
        <tr>
            <td>تكلفة الشحن:</td>
            <td>{{ number_format($purchaseInvoiceReturn->shipping_cost, 2) }}</td>
        </tr>
        <tr>
            <td>إجمالي الضريبة:</td>
            <td>{{ number_format($purchaseInvoiceReturn->total_tax, 2) }}</td>
        </tr>
        <tr>
            <td>المبلغ الإجمالي:</td>
            <td>{{ number_format($purchaseInvoiceReturn->grand_total, 2) }}</td>
        </tr>
    </table>

    <div class="signatures">
        <div>
            <p>توقيع المورد</p>
            <div style="margin-top: 40px; border-top: 1px solid #000; width: 150px;"></div>
        </div>
        <div>
            <p>توقيع المستلم</p>
            <div style="margin-top: 40px; border-top: 1px solid #000; width: 150px;"></div>
        </div>
        <div>
            <p>ختم المؤسسة</p>
            <div style="margin-top: 40px; border-top: 1px solid #000; width: 150px;"></div>
        </div>
    </div>
</body>
</html>
