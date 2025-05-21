<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>التقرير الشهري للموظف {{ $user->name }}</title>
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
        .status-returned { background-color: #6c757d; }
        .payment-summary {
            margin-bottom: 5mm;
            border: 0.5pt solid #ddd;
            padding: 3mm;
        }
        .sales-summary {
            margin-bottom: 5mm;
            border: 0.5pt solid #ddd;
            padding: 3mm;
        }
        .payment-summary-title, .sales-summary-title {
            font-weight: bold;
            margin-bottom: 3mm;
            font-size: 10pt;
            text-align: center;
        }
        .payment-summary-grid, .sales-summary-grid {
            display: table;
            width: 100%;
        }
        .payment-summary-item, .sales-summary-item {
            display: table-row;
        }
        .payment-summary-label, .payment-summary-value,
        .sales-summary-label, .sales-summary-value {
            display: table-cell;
            padding: 1mm;
        }
        .payment-summary-label, .sales-summary-label {
            font-size: 8pt;
            color: #6c757d;
            text-align: right;
            width: 70%;
        }
        .payment-summary-value, .sales-summary-value {
            font-size: 9pt;
            font-weight: bold;
            text-align: left;
            width: 30%;
            direction: ltr;
        }
        .grand-total, .net-sales {
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
        .date-range {
            text-align: center;
            margin-bottom: 5mm;
            font-weight: bold;
            color: #3498db;
        }
        .visit-count {
            font-weight: bold;
            color: #2980b9;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>التقرير الشهري لأداء الموظف</h1>
<div class="subtitle">فترة التقرير: لشهر {{ $startDate->translatedFormat('F Y') }}</div>
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

    <!-- ملخص المبيعات -->
    <div class="sales-summary">
        <div class="sales-summary-title">ملخص المبيعات الشهري</div>
        <div class="sales-summary-grid">
            <div class="sales-summary-item">
                <div class="sales-summary-label">إجمالي المبيعات (فواتير عادية)</div>
                <div class="sales-summary-value">
                    {{$totalSales, 2, '.', ',' }} ر.س
                </div>
            </div>
            <div class="sales-summary-item">
                <div class="sales-summary-label">إجمالي المرتجعات (فواتير مرتجعة)</div>
                <div class="sales-summary-value">
                    {{ $totalReturns, 2, '.', ',' }} ر.س
                </div>
            </div>
            <div class="sales-summary-item net-sales">
                <div class="sales-summary-label">صافي المبيعات بعد المرتجعات</div>
                <div class="sales-summary-value">
                    {{ $netSales, 2, '.', ',' }} ر.س
                </div>
            </div>
        </div>
    </div>

    <!-- ملخص المدفوعات -->
    <div class="payment-summary">
        <div class="payment-summary-title">ملخص المدفوعات الشهري</div>
        <div class="payment-summary-grid">
            <div class="payment-summary-item">
                <div class="payment-summary-label">إجمالي المدفوعات المستلمة</div>
                <div class="payment-summary-value">
                    {{$payments->sum('amount'), 2, '.', ',' }} ر.س
                </div>
            </div>
            <div class="payment-summary-item">
                <div class="payment-summary-label">إجمالي سندات القبض</div>
                <div class="payment-summary-value">
                    {{ $receipts->sum('amount'), 2, '.', ',' }} ر.س
                </div>
            </div>
            <div class="payment-summary-item">
                <div class="payment-summary-label">إجمالي سندات الصرف</div>
                <div class="payment-summary-value">
                    {{$expenses->sum('amount'), 2, '.', ',' }} ر.س
                </div>
            </div>
            <div class="payment-summary-item grand-total">
                <div class="payment-summary-label">صافي التحصيل النقدي الشهري</div>
                <div class="payment-summary-value">
                    @php
                        $totalCollection = $payments->sum('amount') + $receipts->sum('amount') - $expenses->sum('amount');
                    @endphp
                    {{ $totalCollection, 2, '.', ',' }} ر.س
                </div>
            </div>
        </div>
    </div>

    {{-- الفواتير --}}
    <div class="section">
        <div class="section-title">
            <span>الفواتير الصادرة خلال الشهر</span>
            <span class="section-count">{{ $invoices->count() }}</span>
        </div>
        @if ($invoices->count() > 0)
            <div class="date-range">لشهر {{ $startDate->format('Y-m') }}</div>
            <table>
                <thead>
                    <tr>

                        <th class="col-10">رقم الفاتورة</th>
                        <th class="col-20">العميل</th>
                        <th class="col-15">المجموع</th>
                        <th class="col-15">الحالة</th>
                         <th class="col-5">النوع</th>
                        <th class="col-15">التاريخ</th>
                        <th class="col-20">ملاحظات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $invoice)
                        <tr>

                            <td>#{{ $invoice->id }}</td>
                            <td>{{ $invoice->client->trade_name ?? 'غير محدد' }}</td>
                            <td class="currency">
                                @if($invoice->type == 'returned')
                                    -{{ number_format($invoice->grand_total, 2, '.', ',') }}
                                @else
                                    {{ number_format($invoice->grand_total, 2, '.', ',') }}
                                @endif
                            </td>
                            <td>
                                @if($invoice->payment_status == 1)
                                    <span class="status-badge status-paid">مدفوعة</span>
                                @elseif ($invoice->payment_status == 2)
                                    <span class="status-badge status-partial">جزئي</span>
                                @elseif ($invoice->payment_status == 3)
                                    <span class="status-badge status-unpaid">غير مدفوعة</span>
                                @endif
                            </td>
                            <td>
                                @if($invoice->type == 'returned')
                                    <span class="status-badge status-returned">مرتجع</span>
                                @else
                                    <span class="status-badge status-paid"> مبيعات</span>
                                @endif
                            </td>
                            <td>{{ $invoice->created_at->format('Y-m-d H:i') }}</td>
                            <td>{{ $invoice->notes ?? '--' }}</td>
                        </tr>
                    @endforeach

                    <tr class="total-row">
                        <td colspan="3">إجمالي المبيعات (فواتير عادية)</td>
                        <td class="currency">{{$invoices->where('type', 'normal')->sum('grand_total'), 2, '.', ',' }} ر.س</td>
                        <td colspan="3"></td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="3">إجمالي المرتجعات (فواتير مرتجعة)</td>
                        <td class="currency">-{{ $invoices->where('type', 'returned')->sum('grand_total'), 2, '.', ',' }} ر.س</td>
                        <td colspan="3"></td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="3">المجموع</td>
                        <td class="currency">{{$invoices->where('type', 'normal')->sum('grand_total') - $invoices->where('type', 'returned')->sum('grand_total'), 2, '.', ',' }} ر.س</td>
                        <td colspan="3"></td>
                    </tr>
                </tbody>
            </table>
        @else
            <div class="no-data">لا يوجد فواتير مسجلة خلال هذا الشهر</div>
        @endif
    </div>

    {{-- المدفوعات --}}
    <div class="section">
        <div class="section-title">
            <span>المدفوعات المستلمة خلال الشهر</span>
            <span class="section-count">{{ $payments->count() }}</span>
        </div>
        @if ($payments->count() > 0)
            <div class="date-range">لشهر {{ $startDate->format('Y-m') }}</div>
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
                            <td>{{ $payment->invoice->client->trade_name ?? 'غير محدد' }}</td>
                            <td class="currency">{{$payment->amount, 2, '.', ',' }} ر.س</td>
                            <td>{{ $payment->payment_method }}</td>
                            <td class="time">{{ $payment->payment_date }}</td>
                            <td>#{{ $payment->invoice_id }}</td>
                        </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="2">المجموع</td>
                        <td class="currency">{{ $payments->sum('amount'), 2, '.', ',' }} ر.س</td>
                        <td colspan="3"></td>
                    </tr>
                </tbody>
            </table>
        @else
            <div class="no-data">لا يوجد مدفوعات مسجلة خلال هذا الشهر</div>
        @endif
    </div>

    {{-- سندات القبض --}}
    <div class="section">
        <div class="section-title">
            <span>سندات القبض خلال الشهر</span>
            <span class="section-count">{{ $receipts->count() }}</span>
        </div>
        @if ($receipts->count() > 0)
            <div class="date-range">لشهر {{ $startDate->format('Y-m') }}</div>
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
                            <td>{{ $receipt->account->name ?? 'غير محدد' }}</td>
                            <td class="currency">{{ $receipt->amount, 2, '.', ',' }} ر.س</td>
                            <td>{{ $receipt->created_at->format('Y-m-d H:i') }}</td>
                            <td>{{ $receipt->description ?? '--' }}</td>
                        </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="2">المجموع</td>
                        <td class="currency">{{ $receipts->sum('amount'), 2, '.', ','}} ر.س</td>
                        <td colspan="2"></td>
                    </tr>
                </tbody>
            </table>
        @else
            <div class="no-data">لا يوجد سندات قبض خلال هذا الشهر</div>
        @endif
    </div>

    {{-- سندات الصرف --}}
    <div class="section">
        <div class="section-title">
            <span>سندات الصرف خلال الشهر</span>
            <span class="section-count">{{ $expenses->count() }}</span>
        </div>
        @if ($expenses->count() > 0)
            <div class="date-range">لشهر {{ $startDate->format('Y-m') }}</div>
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
                            <td>{{ $expense->name }}</td>
                            <td class="currency">{{$expense->amount, 2, '.', ',' }} ر.س</td>
                            <td>{{ $expense->created_at->format('Y-m-d H:i') }}</td>
                            <td>{{ $expense->description ?? '--' }}</td>
                        </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="2">المجموع</td>
                        <td class="currency">{{$expenses->sum('amount'), 2, '.', ',' }} ر.س</td>
                        <td colspan="2"></td>
                    </tr>
                </tbody>
            </table>
        @else
            <div class="no-data">لا يوجد سندات صرف خلال هذا الشهر</div>
        @endif
    </div>

    {{-- زيارات العملاء --}}
    <div class="section">
        <div class="section-title">
            <span>زيارات العملاء خلال الشهر</span>
            <span class="section-count">{{ $visits->count() }}</span>
        </div>
        @if ($visits->count() > 0)
            <div class="date-range">لشهر {{ $startDate->format('Y-m') }}</div>
            <table>
                <thead>
                    <tr>
                        <th class="col-15">التاريخ</th>
                        <th class="col-20">العميل</th>
                        <th class="col-10">عدد الزيارات</th>
                        <th class="col-20">العنوان</th>
                        <th class="col-10">الوصول</th>
                        <th class="col-10">الانصراف</th>
                        <th class="col-15">ملاحظات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($visits->groupBy('client_id') as $clientId => $clientVisits)
                        @php
                            $firstVisit = $clientVisits->first();
                            $visitCount = $clientVisits->count();
                        @endphp
                        <tr>
                            <td>{{ $firstVisit->created_at->format('Y-m-d') }}</td>
                            <td>{{ $firstVisit->client->trade_name ?? 'غير محدد' }}</td>
                            <td class="visit-count">{{ $visitCount }}</td>
                            <td>{{ $firstVisit->client->formattedAddress ?? 'غير محدد' }}</td>
                            <td class="time">{{ $firstVisit->arrival_time ?? '--' }}</td>
                            <td class="time">{{ $firstVisit->departure_time ?? '--' }}</td>
                            <td>{{ $firstVisit->notes ?? '--' }}</td>
                        </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="7">
                            إجمالي الزيارات: {{ $visits->count() }} -
                            عدد العملاء المزورين: {{ $visits->groupBy('client_id')->count() }}
                        </td>
                    </tr>
                </tbody>
            </table>
        @else
            <div class="no-data">لا يوجد زيارات مسجلة خلال هذا الشهر</div>
        @endif
    </div>

    {{-- الملاحظات --}}
    <div class="section">
        <div class="section-title">
            <span>ملاحظات الموظف خلال الشهر</span>
            <span class="section-count">{{ $notes->count() }}</span>
        </div>
        @if ($notes->count() > 0)
            <div class="date-range">لشهر {{ $startDate->format('Y-m') }}</div>
            <table>
                <thead>
                    <tr>
                        <th class="col-15">التاريخ</th>
                        <th class="col-20">العميل</th>
                        <th class="col-15">الحالة</th>
                        <th class="col-15">الوقت</th>
                        <th class="col-35">الوصف</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notes as $note)
                        <tr>
                            <td>{{ $note->created_at->format('Y-m-d') }}</td>
                            <td>{{ $note->client->trade_name ?? 'غير محدد' }}</td>
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
                            <td>{{ $note->description ?? '--' }}</td>
                        </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="5">إجمالي الملاحظات: {{ $notes->count() }}</td>
                    </tr>
                </tbody>
            </table>
        @else
            <div class="no-data">لا يوجد ملاحظات مسجلة خلال هذا الشهر</div>
        @endif
    </div>

    <div class="footer">
        تم إنشاء التقرير تلقائياً بتاريخ {{ date('Y-m-d H:i') }} - نظام فوترة سمارت
    </div>

</body>
</html>
