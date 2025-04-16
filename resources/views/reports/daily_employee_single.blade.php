<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>التقرير اليومي للموظف {{ $user->name }}</title>
    <style>
        @font-face {
            font-family: 'DejaVu Sans';
            font-style: normal;
            font-weight: normal;
            src: url('{{ storage_path('fonts/dejavu-sans/DejaVuSans.ttf') }}') format('truetype');
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            direction: rtl;
            font-size: 9pt;
            margin: 0;
            padding: 5mm;
            line-height: 1.3;
        }
        .header {
            text-align: center;
            margin-bottom: 5mm;
            padding-bottom: 2mm;
            border-bottom: 0.5pt solid #333;
        }
        .header h1 {
            font-size: 12pt;
            margin: 2pt 0;
            color: #2c3e50;
        }
        .header .subtitle {
            font-size: 9pt;
            color: #7f8c8d;
        }
        .employee-info {
            margin-bottom: 5mm;
        }
        .info-table {
            width: 100%;
            margin-bottom: 3mm;
            font-size: 9pt;
        }
        .info-table td {
            padding: 1mm;
        }
        .section {
            margin-bottom: 5mm;
            page-break-inside: avoid;
        }
        .section-title {
            background-color: #3498db;
            color: white;
            padding: 2mm 3mm;
            border-radius: 1.5pt;
            font-size: 10pt;
            margin-bottom: 3mm;
            display: flex;
            justify-content: space-between;
        }
        .section-count {
            background-color: #2980b9;
            padding: 1pt 3pt;
            border-radius: 1.5pt;
            font-size: 9pt;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5mm;
            font-size: 8pt;
        }
        th, td {
            border: 0.5pt solid #ddd;
            padding: 1.5mm;
            text-align: right;
            direction: rtl;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .currency {
            text-align: left;
            direction: ltr;
            font-family: 'DejaVu Sans', sans-serif;
        }
        .time {
            text-align: right;
            direction: rtl;
        }
        .total-row {
            font-weight: bold;
            background-color: #f5f5f5;
        }
        .no-data {
            color: #999;
            font-style: italic;
            text-align: center;
            padding: 3mm;
            border: 0.5pt dashed #ddd;
            margin: 3mm 0;
        }
        .status-badge {
            display: inline-block;
            padding: 1pt 2pt;
            border-radius: 1.5pt;
            font-size: 7pt;
            color: white;
        }
        .status-paid { background-color: #28a745; }
        .status-partial { background-color: #17a2b8; }
        .status-unpaid { background-color: #dc3545; }
        .status-completed { background-color: #28a745; }
        .status-pending { background-color: #ffc107; color: #000; }
        .status-cancelled { background-color: #dc3545; }
        .payment-summary {
            margin-bottom: 5mm;
            border: 0.5pt solid #ddd;
            padding: 3mm;
        }
        .payment-summary-title {
            font-weight: bold;
            margin-bottom: 3mm;
            font-size: 10pt;
            text-align: center;
        }
        .payment-summary-grid {
            display: table;
            width: 100%;
        }
        .payment-summary-item {
            display: table-row;
        }
        .payment-summary-label, .payment-summary-value {
            display: table-cell;
            padding: 1mm;
        }
        .payment-summary-label {
            font-size: 8pt;
            color: #6c757d;
            text-align: right;
            width: 70%;
        }
        .payment-summary-value {
            font-size: 9pt;
            font-weight: bold;
            text-align: left;
            width: 30%;
            direction: ltr;
        }
        .grand-total {
            background-color: #e9f7ef;
            border-top: 0.5pt solid #28a745;
        }
        .footer {
            text-align: center;
            margin-top: 5mm;
            padding-top: 2mm;
            border-top: 0.5pt solid #eee;
            font-size: 8pt;
            color: #6c757d;
        }
        .col-5 { width: 5%; }
        .col-10 { width: 10%; }
        .col-15 { width: 15%; }
        .col-20 { width: 20%; }
        .col-25 { width: 25%; }
    </style>
</head>
<body>

    <div class="header">
        <h1>التقرير اليومي لأداء الموظف</h1>
        <div class="subtitle">تاريخ التقرير: {{ $date }}</div>
    </div>

    <!-- معلومات الموظف -->
    <div class="employee-info">
        <table class="info-table">
            <tr>
                <td style="width: 30%; font-weight: bold;">اسم الموظف</td>
                <td style="width: 70%;">{{ $user->name }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">رقم الموظف</td>
                <td>{{ $user->id }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">البريد الإلكتروني</td>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">تاريخ الإنضمام</td>
                <td>{{ $user->created_at->format('Y-m-d') }}</td>
            </tr>
        </table>
    </div>

    <!-- ملخص المدفوعات -->
    <div class="payment-summary">
        <div class="payment-summary-title">ملخص المدفوعات</div>
        <div class="payment-summary-grid">
            <div class="payment-summary-item">
                <div class="payment-summary-label">إجمالي المدفوعات المستلمة</div>
                <div class="payment-summary-value">
                    {{ number_format($payments->sum('amount'), 2, '.', ',') }} ر.س
                </div>
            </div>
            <div class="payment-summary-item">
                <div class="payment-summary-label">إجمالي سندات القبض</div>
                <div class="payment-summary-value">
                    {{ number_format($receipts->sum('amount'), 2, '.', ',') }} ر.س
                </div>
            </div>
            <div class="payment-summary-item">
                <div class="payment-summary-label">إجمالي سندات الصرف</div>
                <div class="payment-summary-value">
                    {{ number_format($expenses->sum('amount'), 2, '.', ',') }} ر.س
                </div>
            </div>
            <div class="payment-summary-item grand-total">
                <div class="payment-summary-label">صافي التحصيل النقدي</div>
                <div class="payment-summary-value">
                    @php
                        $totalCollection = $payments->sum('amount') + $receipts->sum('amount') - $expenses->sum('amount');
                    @endphp
                    {{ number_format($totalCollection, 2, '.', ',') }} ر.س
                </div>
            </div>
        </div>
    </div>

    {{-- الفواتير --}}
    <div class="section">
        <div class="section-title">
            <span>الفواتير الصادرة</span>
            <span class="section-count">{{ $invoices->count() }}</span>
        </div>
        @if ($invoices->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th class="col-10">رقم الفاتورة</th>
                        <th class="col-20">العميل</th>
                        <th class="col-15">المجموع</th>
                        <th class="col-15">الحالة</th>
                        <th class="col-15">التاريخ</th>
                        <th class="col-25">ملاحظات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $invoice)
                        <tr>
                            <td>#{{ $invoice->id }}</td>
                            <td>{{ Str::limit($invoice->client->trade_name ?? 'غير محدد', 15) }}</td>
                            <td class="currency">{{ number_format($invoice->grand_total, 2, '.', ',') }} ر.س</td>
                            <td>
                                @if($invoice->payment_status == 1)
                                    <span class="status-badge status-paid">مدفوعة</span>
                                @elseif ($invoice->payment_status == 2)
                                    <span class="status-badge status-partial">جزئي</span>
                                @elseif ($invoice->payment_status == 3)
                                    <span class="status-badge status-unpaid">غير مدفوعة</span>
                                @endif
                            </td>
                            <td>{{ $invoice->created_at->format('H:i') }}</td>
                            <td>{{ Str::limit($invoice->notes ?? '--', 20) }}</td>
                        </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="2">المجموع</td>
                        <td class="currency">{{ number_format($invoices->sum('grand_total'), 2, '.', ',') }} ر.س</td>
                        <td colspan="3"></td>
                    </tr>
                </tbody>
            </table>
        @else
            <div class="no-data">لا يوجد فواتير مسجلة</div>
        @endif
    </div>

    {{-- المدفوعات --}}
    <div class="section">
        <div class="section-title">
            <span>المدفوعات المستلمة</span>
            <span class="section-count">{{ $payments->count() }}</span>
        </div>
        @if ($payments->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th class="col-10">رقم العملية</th>
                        <th class="col-20">العميل</th>
                        <th class="col-15">المبلغ</th>
                        <th class="col-15">طريقة الدفع</th>
                        <th class="col-15">التاريخ</th>
                        <th class="col-25">رقم الفاتورة</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $payment)
                        <tr>
                            <td>#{{ $payment->id }}</td>
                            <td>{{ Str::limit($payment->client->trade_name ?? 'غير محدد', 15) }}</td>
                            <td class="currency">{{ number_format($payment->amount, 2, '.', ',') }} ر.س</td>
                            <td>{{ Str::limit($payment->payment_method, 10) }}</td>
                            <td class="time">{{ $payment->payment_date }}</td>
                            <td>#{{ $payment->invoice_id }}</td>
                        </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="2">المجموع</td>
                        <td class="currency">{{ number_format($payments->sum('amount'), 2, '.', ',') }} ر.س</td>
                        <td colspan="3"></td>
                    </tr>
                </tbody>
            </table>
        @else
            <div class="no-data">لا يوجد مدفوعات مسجلة</div>
        @endif
    </div>

    {{-- زيارات العملاء --}}
    <div class="section">
        <div class="section-title">
            <span>زيارات العملاء</span>
            <span class="section-count">{{ $visits->count() }}</span>
        </div>
        @if ($visits->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th class="col-20">العميل</th>
                        <th class="col-20">العنوان</th>
                        <th class="col-10">الوصول</th>
                        <th class="col-10">الانصراف</th>
                        <th class="col-15">التاريخ</th>
                        <th class="col-25">ملاحظات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($visits as $visit)
                        <tr>
                            <td>{{ Str::limit($visit->client->trade_name ?? 'غير محدد', 15) }}</td>
                            <td>{{ Str::limit($visit->client->formattedAddress ?? 'غير محدد', 15) }}</td>
                            <td class="time">{{ $visit->arrival_time ?? '--' }}</td>
                            <td class="time">{{ $visit->departure_time ?? '--' }}</td>
                            <td>{{ $visit->created_at->format('H:i') }}</td>
                            <td>{{ Str::limit($visit->notes ?? '--', 15) }}</td>
                        </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="6">إجمالي الزيارات: {{ $visits->count() }}</td>
                    </tr>
                </tbody>
            </table>
        @else
            <div class="no-data">لا يوجد زيارات مسجلة</div>
        @endif
    </div>

    {{-- الملاحظات --}}
    <div class="section">
        <div class="section-title">
            <span>ملاحظات الموظف</span>
            <span class="section-count">{{ $notes->count() }}</span>
        </div>
        @if ($notes->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th class="col-20">العميل</th>
                        <th class="col-15">الحالة</th>
                        <th class="col-15">الوقت</th>
                        <th class="col-15">التاريخ</th>
                        <th class="col-35">الوصف</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notes as $note)
                        <tr>
                            <td>{{ Str::limit($note->client->trade_name ?? 'غير محدد', 15) }}</td>
                            <td>
                                @if($note->status == 'completed')
                                    <span class="status-badge status-completed">مكتمل</span>
                                @elseif($note->status == 'pending')
                                    <span class="status-badge status-pending">قيد التنفيذ</span>
                                @elseif($note->status == 'cancelled')
                                    <span class="status-badge status-cancelled">ملغى</span>
                                @else
                                    {{ $note->status }}
                                @endif
                            </td>
                            <td class="time">{{ $note->time ?? '--' }}</td>
                            <td>{{ $note->date ?? '--' }}</td>
                            <td>{{ Str::limit($note->description ?? '--', 30) }}</td>
                        </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="5">إجمالي الملاحظات: {{ $notes->count() }}</td>
                    </tr>
                </tbody>
            </table>
        @else
            <div class="no-data">لا يوجد ملاحظات مسجلة</div>
        @endif
    </div>

    {{-- سندات القبض --}}
    <div class="section">
        <div class="section-title">
            <span>سندات القبض</span>
            <span class="section-count">{{ $receipts->count() }}</span>
        </div>
        @if ($receipts->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th class="col-15">رقم السند</th>
                        <th class="col-25">من</th>
                        <th class="col-15">المبلغ</th>
                        <th class="col-20">التاريخ</th>
                        <th class="col-25">الوصف</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($receipts as $receipt)
                        <tr>
                            <td>#{{ $receipt->id }}</td>
                            <td>{{ Str::limit($receipt->account->name ?? 'غير محدد', 15) }}</td>
                            <td class="currency">{{ number_format($receipt->amount, 2, '.', ',') }} ر.س</td>
                            <td>{{ $receipt->created_at->format('H:i') }}</td>
                            <td>{{ Str::limit($receipt->description ?? '--', 15) }}</td>
                        </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="2">المجموع</td>
                        <td class="currency">{{ number_format($receipts->sum('amount'), 2, '.', ',' )}} ر.س</td>
                        <td colspan="2"></td>
                    </tr>
                </tbody>
            </table>
        @else
            <div class="no-data">لا يوجد سندات قبض</div>
        @endif
    </div>

    {{-- سندات الصرف --}}
    <div class="section">
        <div class="section-title">
            <span>سندات الصرف</span>
            <span class="section-count">{{ $expenses->count() }}</span>
        </div>
        @if ($expenses->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th class="col-15">رقم السند</th>
                        <th class="col-25">إلى</th>
                        <th class="col-15">المبلغ</th>
                        <th class="col-20">التاريخ</th>
                        <th class="col-25">الوصف</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($expenses as $expense)
                        <tr>
                            <td>#{{ $expense->id }}</td>
                            <td>{{ Str::limit($expense->name, 15) }}</td>
                            <td class="currency">{{ number_format($expense->amount, 2, '.', ',') }} ر.س</td>
                            <td>{{ $expense->created_at->format('H:i') }}</td>
                            <td>{{ Str::limit($expense->description ?? '--', 15) }}</td>
                        </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="2">المجموع</td>
                        <td class="currency">{{ number_format($expenses->sum('amount'), 2, '.', ',') }} ر.س</td>
                        <td colspan="2"></td>
                    </tr>
                </tbody>
            </table>
        @else
            <div class="no-data">لا يوجد سندات صرف</div>
        @endif
    </div>

    <div class="footer">
        تم إنشاء التقرير تلقائياً بتاريخ {{ date('Y-m-d H:i') }} - نظام فوترة سمارت
    </div>

</body>
</html>
