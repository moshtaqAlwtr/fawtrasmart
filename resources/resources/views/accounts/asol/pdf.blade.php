<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>تقرير الأصل المحصصي</title>
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

        .data-table th,
        .data-table td {
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
    </style>
</head>

<body>
    <div class="header">
        <h1>تقرير الأصل المحصصي</h1>
        <p>{{ date('d/m/Y') }}</p>
        <p>مؤسسة أبعاد عتمة للتجارة</p>
        <p>{{ $asset->name }}</p>
        <p>الرقم الضريبي: {{ $asset->code }}</p>
    </div>

    <table class="info-grid" cellpadding="0" cellspacing="0">
        <tr>
            <td class="info-label">طريقة الإهلاك:</td>
            <td class="info-value">
                @switch($asset->dep_method)
                    @case(1)
                        القسط الثابت
                    @break

                    @case(2)
                        القسط المتناقص
                    @break

                    @case(3)
                        وحدات الإنتاج
                    @break

                    @case(4)
                        بدون إهلاك
                    @break

                    @default
                        بدون إهلاك
                @endswitch
            </td>
            <td class="info-label">الرقم المعرف:</td>
            <td class="info-value">{{ $asset->id }}</td>
        </tr>
        <tr>
            <td class="info-label">الكود:</td>
            <td class="info-value">{{ $asset->code }}</td>
            <td class="info-label">الكمية:</td>
            <td class="info-value">{{ $asset->quantity }}</td>
        </tr>
        <tr>
            <td class="info-label">العمر الإنتاجي:</td>
            <td class="info-value">{{ $asset->region_age }} سنة</td>
            <td class="info-label">الموقع:</td>
            <td class="info-value">{{ $asset->place ?: 'غير محدد' }}</td>
        </tr>
        <tr>
            <td class="info-label">الوصف:</td>
            <td class="info-value">{{ $asset->description ?: 'لا يوجد وصف' }}</td>
            <td class="info-label">الموظف:</td>
            <td class="info-value">{{ optional($asset->employee)->full_name ?? 'غير محدد' }}</td>
        </tr>
        <tr>
            <td class="info-label">الحساب الرئيسي:</td>
            <td class="info-value">{{ optional($asset->account)->name ?? 'غير محدد' }}</td>
            <td class="info-label">حساب الإهلاك:</td>
            <td class="info-value">{{ optional($asset->depreciation_account)->name ?? 'غير محدد' }}</td>
        </tr>
        <tr>
            <td class="info-label">قيمة الشراء:</td>
            <td class="info-value">{{ number_format($asset->purchase_value, 2) }}
                {{ $asset->currency == 1 ? 'ريال' : 'دولار' }}</td>
            <td class="info-label">القيمة الحالية:</td>
            <td class="info-value">{{ number_format($asset->current_value, 2) }}
                {{ $asset->currency == 1 ? 'ريال' : 'دولار' }}</td>
        </tr>
        <tr>
            <td class="info-label">تاريخ بداية الخدمة:</td>
            <td class="info-value">{{ $asset->date_service }}</td>
            <td class="info-label">تاريخ الشراء:</td>
            <td class="info-value">{{ $asset->date_price }}</td>
        </tr>
    </table>

    <h3 class="section-title">سجل الحركات:</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>التاريخ</th>
                <th>العملية</th>
                <th>المبلغ</th>
                <th>الرصيد</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $asset->date_price }}</td>
                <td>شراء</td>
                <td>{{ number_format($asset->purchase_value, 2) }}</td>
                <td>{{ number_format($asset->purchase_value, 2) }}</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: center;">القيمة الحالية</td>
                <td>{{ number_format($asset->current_value, 2) }}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
