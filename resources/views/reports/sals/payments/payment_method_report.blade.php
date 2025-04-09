@extends('master')

@section('title')
    تقرير المدفوعات حسب الفترة
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Tajawal', sans-serif;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            border: none;
        }
        .card-header {
            background: linear-gradient(135deg, #4a6cf7 0%, #2541b2 100%);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 15px 20px;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 10px 20px;
        }
        .table thead th {
            background-color: #4a6cf7;
            color: white;
            font-weight: 500;
        }
        .table tbody tr:hover {
            background-color: rgba(74, 108, 247, 0.1);
        }
        .chart-container {
            position: relative;
            height: 350px;
            margin: 20px 0;
        }
        .summary-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .summary-card h5 {
            color: #4a6cf7;
            font-weight: 600;
        }
        .summary-card .amount {
            font-size: 24px;
            font-weight: 700;
            color: #2d3748;
        }
        .filter-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .form-label {
            font-weight: 600;
            color: #4a5568;
        }
        .export-btn {
            border-radius: 8px;
            margin-left: 10px;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            .card {
                box-shadow: none;
                border: 1px solid #ddd;
            }
        }
        .period-header {
            background-color: #f8f9fa !important;
            font-weight: bold;
        }
        .period-total {
            background-color: #e9ecef !important;
            font-weight: bold;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        @switch($reportPeriod)
                            @case('daily') المدفوعات اليومية @break
                            @case('weekly') المدفوعات الأسبوعية @break
                            @case('monthly') المدفوعات الشهرية @break
                            @case('yearly') المدفوعات السنوية @break
                        @endswitch
                    </h4>
                </div>
                <div class="card-body">
                    <div class="filter-section">
                        <form method="GET" action="{{ route('salesReports.patyment') }}">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label for="employee" class="form-label">الموظف</label>
                                    <select name="employee" id="employee" class="form-control">
                                        <option value="">الكل</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}" {{ request('employee') == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="payment_method" class="form-label">وسيلة الدفع</label>
                                    <select name="payment_method" id="payment_method" class="form-control">
                                        <option value="">الكل</option>
                                        <option value="1" {{ request('payment_method') == '1' ? 'selected' : '' }}>نقدي</option>
                                        <option value="2" {{ request('payment_method') == '2' ? 'selected' : '' }}>شيك</option>
                                        <option value="3" {{ request('payment_method') == '3' ? 'selected' : '' }}>تحويل بنكي</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="client" class="form-label">العميل</label>
                                    <select name="client" id="client" class="form-control">
                                        <option value="">الكل</option>
                                        @foreach($clients as $client)
                                            <option value="{{ $client->id }}" {{ request('client') == $client->id ? 'selected' : '' }}>
                                                {{ $client->trade_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="report_period" class="form-label">الفترة</label>
                                    <select name="report_period" id="report_period" class="form-control">
                                        <option value="daily" {{ $reportPeriod == 'daily' ? 'selected' : '' }}>يومي</option>
                                        <option value="weekly" {{ $reportPeriod == 'weekly' ? 'selected' : '' }}>أسبوعي</option>
                                        <option value="monthly" {{ $reportPeriod == 'monthly' ? 'selected' : '' }}>شهري</option>
                                        <option value="yearly" {{ $reportPeriod == 'yearly' ? 'selected' : '' }}>سنوي</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="fromDate" class="form-label">من تاريخ</label>
                                    <input type="date" name="from_date" id="fromDate" class="form-control"
                                           value="{{ $fromDate->format('Y-m-d') }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="toDate" class="form-label">إلى تاريخ</label>
                                    <input type="date" name="to_date" id="toDate" class="form-control"
                                           value="{{ $toDate->format('Y-m-d') }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="branch" class="form-label">الفرع</label>
                                    <select name="branch" id="branch" class="form-control">
                                        <option value="">الكل</option>
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}" {{ request('branch') == $branch->id ? 'selected' : '' }}>
                                                {{ $branch->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-filter me-2"></i>عرض التقرير
                                    </button>
                                    <a href="{{route('salesReports.patyment')}}" class="btn btn-primary w-100 ms-2">
                                        <i class="fas fa-times me-2"></i>إلغاء الفلتر
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="row no-print mb-4">
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="dropdown">
                                    <button class="btn btn-success dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-file-export me-2"></i> تصدير
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                                        <li><a class="dropdown-item" href="#" onclick="exportTo('excel')"><i class="fas fa-file-excel me-2"></i>Excel</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="exportTo('pdf')"><i class="fas fa-file-pdf me-2"></i>PDF</a></li>
                                    </ul>
                                </div>
                                <button class="btn btn-secondary ms-2" onclick="window.print()">
                                    <i class="fas fa-print me-2"></i> طباعة
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="btn-group">
                                <button class="btn btn-outline-primary active" data-view="summary">
                                    <i class="fas fa-chart-pie me-2"></i> الملخص
                                </button>
                                <button class="btn btn-outline-primary" data-view="details">
                                    <i class="fas fa-table me-2"></i> التفاصيل
                                </button>
                            </div>
                        </div>
                    </div>

                    @if($payments->isNotEmpty())
                        <div class="row mb-4" id="summaryView">
                            <div class="col-md-4">
                                <div class="summary-card text-center">
                                    <h5>إجمالي المدفوعات</h5>
                                    <div class="amount text-success">{{ number_format($summaryTotals['total_paid'], 2) }} ر.س</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="summary-card text-center">
                                    <h5>عدد المدفوعات</h5>
                                    <div class="amount text-primary">{{ $payments->count() }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="summary-card text-center">
                                    <h5>متوسط المدفوعات</h5>
                                    <div class="amount text-info">{{ number_format($summaryTotals['average_payment'], 2) }} ر.س</div>
                                </div>
                            </div>
                        </div>

                        <div class="chart-container" id="chartView">
                            <canvas id="paymentChart"></canvas>
                        </div>

                        <div class="table-responsive" id="detailsView" style="display: none;">
                            <table class="table table-hover table-bordered" id="paymentsTable">
                                <thead class="table-primary">
                                    <tr>
                                        <th width="15%">
                                            @switch($reportPeriod)
                                                @case('daily') التاريخ @break
                                                @case('weekly') الأسبوع @break
                                                @case('monthly') الشهر @break
                                                @case('yearly') السنة @break
                                            @endswitch
                                        </th>
                                        <th width="20%">العميل</th>
                                        <th width="15%">طريقة الدفع</th>
                                        <th width="10%">المبلغ (ر.س)</th>
                                        <th width="15%">المرجع</th>
                                        <th width="15%">الموظف</th>
                                        <th width="10%">التاريخ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($unifiedData['grouped_data'] as $period => $groupData)
                                    @php
                                        $periodPayments = $groupData['items'];
                                        $periodTotalAmount = 0;
                                    @endphp

                                    <tr class="period-header">
                                        <td colspan="7" class="text-center">
                                            <strong>
                                                @switch($reportPeriod)
                                                    @case('daily')
                                                        {{ \Carbon\Carbon::parse($period)->locale('ar')->isoFormat('LL') }}
                                                        @break
                                                    @case('weekly')
                                                        الأسبوع {{ \Carbon\Carbon::parse($period . '-1')->weekOfYear }}
                                                        ({{ \Carbon\Carbon::parse($period . '-1')->startOfWeek()->format('Y-m-d') }}
                                                        إلى
                                                        {{ \Carbon\Carbon::parse($period . '-1')->endOfWeek()->format('Y-m-d') }})
                                                        @break
                                                    @case('monthly')
                                                        {{ \Carbon\Carbon::parse($period . '-01')->locale('ar')->isoFormat('MMMM YYYY') }}
                                                        @break
                                                    @case('yearly')
                                                        {{ $period }}
                                                        @break
                                                @endswitch
                                            </strong>
                                        </td>
                                    </tr>

                                    @foreach($periodPayments as $payment)
                                        <tr>
                                            <td>{{ $period }}</td>
                                            <td>{{ optional($payment->invoice->client)->trade_name ?? 'غير محدد' }}</td>
                                            <td>
                                                @switch($payment->Payment_method)
                                                    @case(1) نقدي @break
                                                    @case(2) شيك @break
                                                    @case(3) تحويل بنكي @break
                                                    @case(4) بطاقة ائتمان @break
                                                    @default غير محدد
                                                @endswitch
                                            </td>
                                            <td class="text-end">{{ number_format($payment->amount, 2) }}</td>
                                            <td>{{ $payment->reference_number ?? '--' }}</td>
                                            <td>{{ optional($payment->invoice->employee)->name ?? 'غير محدد' }}</td>
                                            <td>{{ $payment->payment_date->format('Y-m-d') }}</td>
                                        </tr>

                                        @php
                                            $periodTotalAmount += $payment->amount;
                                        @endphp
                                    @endforeach

                                    <tr class="period-total">
                                        <td colspan="3" class="text-end"><strong>مجموع الفترة</strong></td>
                                        <td class="text-end"><strong>{{ number_format($periodTotalAmount, 2) }}</strong></td>
                                        <td colspan="3"></td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mt-4">
                            لا توجد مدفوعات متاحة للعرض
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.sheetjs.com/xlsx-0.19.3/package/dist/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>

<script>
    // Initialize Chart
    const ctx = document.getElementById('paymentChart').getContext('2d');
    const paymentChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($chartData['labels']),
            datasets: [{
                label: 'المدفوعات (ر.س)',
                data: @json($chartData['values']),
                backgroundColor: 'rgba(74, 108, 247, 0.7)',
                borderColor: 'rgba(74, 108, 247, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    rtl: true
                },
                tooltip: {
                    rtl: true,
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y.toLocaleString() + ' ر.س';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString() + ' ر.س';
                        }
                    }
                },
                x: {
                    ticks: {
                        autoSkip: false,
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            }
        }
    });

    // Export functions
    function exportTo(type) {
        const table = document.getElementById('paymentsTable');
        const fileName = `تقرير_المدفوعات_حسب_الفترة_${new Date().toLocaleDateString()}`;

        if (type === 'excel') {
            const wb = XLSX.utils.table_to_book(table);
            XLSX.writeFile(wb, `${fileName}.xlsx`);
        } else if (type === 'pdf') {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            // Add title
            doc.setFont('tajawal', 'normal');
            doc.setFontSize(18);
            doc.text('تقرير المدفوعات حسب الفترة', 105, 15, { align: 'center' });

            // Add filters info
            doc.setFontSize(12);
            doc.text(`الفترة: ${document.getElementById('report_period').options[document.getElementById('report_period').selectedIndex].text}`, 14, 25);
            doc.text(`من: ${document.getElementById('fromDate').value} إلى: ${document.getElementById('toDate').value}`, 14, 35);

            // Add table
            doc.autoTable({
                html: '#paymentsTable',
                startY: 45,
                styles: { font: 'tajawal', halign: 'right' },
                headStyles: { fillColor: [74, 108, 247], textColor: 255 }
            });

            doc.save(`${fileName}.pdf`);
        }
    }

    // View toggle
    $('[data-view]').click(function() {
        $('[data-view]').removeClass('active');
        $(this).addClass('active');

        const view = $(this).data('view');
        if (view === 'summary') {
            $('#summaryView').show();
            $('#chartView').show();
            $('#detailsView').hide();
        } else {
            $('#summaryView').hide();
            $('#chartView').hide();
            $('#detailsView').show();
        }
    });
</script>
@endsection
