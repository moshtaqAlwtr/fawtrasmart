@extends('master')

@section('title')
    المدفوعات
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/report.css') }}">
@endsection

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">
                @switch($reportPeriod)
                    @case('daily')
                        المدفوعات اليومية
                        @break
                    @case('weekly')
                        المدفوعات الأسبوعية
                        @break
                    @case('monthly')
                        المدفوعات الشهرية
                        @break
                    @case('yearly')
                        المدفوعات السنوية
                        @break
                @endswitch
            </h5>
            <form class="row g-3" method="GET" action="{{ route('salesReports.patyment') }}">
                <div class="col-md-3">
                    <label for="employee" class="form-label">الموظف:</label>
                    <select name="employee" id="employee" class="form-select">
                        <option value="">الكل</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}"
                                {{ request('employee') == $employee->id ? 'selected' : '' }}>
                                {{ $employee->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="payment_method" class="form-label">وسيلة الدفع</label>
                    <select name="payment_method" id="payment_method" class="form-select">
                        <option value="">الكل</option>
                        <option value="1" {{ request('payment_method') == '1' ? 'selected' : '' }}>نقدي</option>
                        <option value="2" {{ request('payment_method') == '2' ? 'selected' : '' }}>شيك</option>
                        <option value="3" {{ request('payment_method') == '3' ? 'selected' : '' }}>تحويل بنكي</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="client" class="form-label">العميل:</label>
                    <select name="client" id="client" class="form-select">
                        <option value="">الكل</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}"
                                {{ request('client') == $client->id ? 'selected' : '' }}>
                                {{ $client->trade_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="report_period" class="form-label">الفترة:</label>
                    <select name="report_period" id="report_period" class="form-select">
                        <option value="daily" {{ $reportPeriod == 'daily' ? 'selected' : '' }}>يومي</option>
                        <option value="weekly" {{ $reportPeriod == 'weekly' ? 'selected' : '' }}>أسبوعي</option>
                        <option value="monthly" {{ $reportPeriod == 'monthly' ? 'selected' : '' }}>شهري</option>
                        <option value="yearly" {{ $reportPeriod == 'yearly' ? 'selected' : '' }}>سنوي</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="fromDate" class="form-label">الفترة من:</label>
                    <input type="date" name="from_date" id="fromDate" class="form-control"
                           value="{{ $fromDate->format('Y-m-d') }}">
                </div>
                <div class="col-md-3">
                    <label for="toDate" class="form-label">إلى:</label>
                    <input type="date" name="to_date" id="toDate" class="form-control"
                           value="{{ $toDate->format('Y-m-d') }}">
                </div>
                <div class="col-md-3">
                    <label for="branch" class="form-label">الفرع:</label>
                    <select name="branch" id="branch" class="form-select">
                        <option value="">الكل</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}"
                                {{ request('branch') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100 me-2">عرض التقرير</button>
                    <a href="{{ route('salesReports.patyment') }}" class="btn btn-secondary w-100">إلغاء الفلتر</a>
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex justify-content-between my-3">
    <div class="btn-group" role="group" aria-label="Export Options">
        <button type="button" class="btn btn-primary" id="excelExport">
            <i class="fas fa-file-excel me-2"></i>تصدير إلى Excel
        </button>
        <button type="button" class="btn btn-danger" id="pdfExport">
            <i class="fas fa-file-pdf me-2"></i>تصدير إلى PDF
        </button>
        <button type="button" class="btn btn-secondary" onclick="window.print()">
            <i class="fas fa-print me-2"></i>طباعة
        </button>
    </div>
</div>

    @if($payments->isNotEmpty())
        <div class="chart-card">
            <h5 class="text-center">
                @switch($reportPeriod)
                    @case('daily')
                        المدفوعات اليومية (SAR)
                        @break
                    @case('weekly')
                        المدفوعات الأسبوعية (SAR)
                        @break
                    @case('monthly')
                        المدفوعات الشهرية (SAR)
                        @break
                    @case('yearly')
                        المدفوعات السنوية (SAR)
                        @break
                @endswitch
            </h5>
            <div class="chart-container">
                <canvas id="paymentsChart" height="120"></canvas>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h6 class="card-subtitle mb-2 text-muted">
                    تقرير مفصل للمدفوعات من {{ $fromDate->format('d/m/Y') }} إلى {{ $toDate->format('d/m/Y') }}
                </h6>

                @php
                    $currentPeriod = null;
                    $periodTotalAmount = 0;
                    $periodTotalCount = 0;
                @endphp

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>
                                @switch($reportPeriod)
                                    @case('daily') التاريخ @break
                                    @case('weekly') الأسبوع @break
                                    @case('monthly') الشهر @break
                                    @case('yearly') السنة @break
                                @endswitch
                            </th>
                            <th>العميل</th>
                            <th>طريقة الدفع</th>
                            <th>المبلغ (SAR)</th>
                            <th>التاريخ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($groupedPayments as $period => $periodPayments)
                            {{-- Period Header --}}
                            <tr class="table-secondary">
                                <td colspan="5" class="text-center">
                                    <strong>
                                        @switch($reportPeriod)
                                            @case('daily')
                                                {{ Carbon\Carbon::parse($period)->locale('ar')->isoFormat('LL') }}
                                                @break
                                            @case('weekly')
                                                الأسبوع {{ Carbon\Carbon::parse($period . '-1')->weekOfYear }}
                                                ({{ Carbon\Carbon::parse($period . '-1')->startOfWeek()->format('Y-m-d') }}
                                                إلى
                                                {{ Carbon\Carbon::parse($period . '-1')->endOfWeek()->format('Y-m-d') }})
                                                @break
                                            @case('monthly')
                                                {{ Carbon\Carbon::parse($period . '-01')->locale('ar')->isoFormat('MMMM YYYY') }}
                                                @break
                                            @case('yearly')
                                                {{ $period }}
                                                @break
                                        @endswitch
                                    </strong>
                                </td>
                            </tr>

                            @php
                                $periodTotalAmount = 0;
                                $periodTotalCount = $periodPayments->count();
                            @endphp

                            @foreach($periodPayments as $payment)
                                <tr>
                                    <td>{{ $period }}</td>
                                    <td>{{ optional($payment->invoice->client)->trade_name ?? 'غير محدد' }}</td>
                                    <td>
                                        @switch($payment->Payment_method)
                                            @case(1) نقدي @break
                                            @case(2) شيك @break
                                            @case(3) تحويل بنكي @break
                                            @default غير محدد
                                        @endswitch
                                    </td>
                                    <td>{{ number_format($payment->amount, 2) }}</td>
                                    <td>{{ $payment->payment_date->format('Y-m-d') }}</td>
                                </tr>

                                @php
                                    $periodTotalAmount += $payment->amount;
                                @endphp
                            @endforeach

                            {{-- Period Total Row --}}
                            <tr class="table-success">
                                <td colspan="3" class="text-end"><strong>مجموع الفترة</strong></td>
                                <td><strong>{{ number_format($periodTotalAmount, 2) }}</strong></td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="alert alert-info mt-4">
            لا توجد مدفوعات متاحة للعرض
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
<script>
    // Chart Script
    const ctx = document.getElementById('paymentsChart').getContext('2d');

    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(0, 150, 255, 0.8)');
    gradient.addColorStop(1, 'rgba(0, 255, 255, 0.4)');

    // Calculate total payments for percentage
    const totalPayments = @json($chartData['values']).reduce((a, b) => a + b, 0);

    const data = {
        labels: @json($chartData['labels']),
        datasets: [{
            label: 'المدفوعات (SAR)',
            data: @json($chartData['values']),
            backgroundColor: gradient,
            borderColor: 'rgba(0, 123, 255, 1)',
            borderWidth: 1
        }]
    };

    const options = {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'المبلغ (SAR)'
                }
            },
            x: {
                ticks: {
                    autoSkip: false,
                    maxRotation: 45,
                    minRotation: 45,
                    callback: function(value, index) {
                        const label = @json($chartData['labels'])[index];
                        const amount = @json($chartData['values'])[index];
                        const percentage = ((amount / totalPayments) * 100).toFixed(2);
                        return `${label} (${percentage}%)`;
                    }
                }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    title: function(context) {
                        return @json($chartData['labels'])[context[0].dataIndex];
                    },
                    label: function(context) {
                        const value = context.parsed.y;
                        const percentage = ((value / totalPayments) * 100).toFixed(2);
                        return `المبلغ: ${value.toFixed(2)} SAR (${percentage}%)`;
                    }
                }
            },
            legend: {
                display: true,
                labels: {
                    boxWidth: 20,
                    boxHeight: 15,
                    color: 'rgba(0, 123, 255, 1)'
                }
            }
        }
    };

    const paymentsChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options
    });

    // Excel Export Function
    document.getElementById('excelExport').addEventListener('click', function() {
        // Prepare data for Excel
        const worksheetData = [
            // Header row
            ['الفترة', 'العميل', 'طريقة الدفع', 'المبلغ (SAR)', 'التاريخ']
        ];

        // Payments data from PHP
        const payments = @json($payments);

        // Group payments by period
        const groupedPayments = @json($groupedPayments);

        // Iterate through grouped payments
        Object.keys(groupedPayments).forEach(period => {
            groupedPayments[period].forEach(payment => {
                // Determine payment method
                let paymentMethod = '';
                switch(payment.Payment_method) {
                    case 1: paymentMethod = 'نقدي'; break;
                    case 2: paymentMethod = 'شيك'; break;
                    case 3: paymentMethod = 'تحويل بنكي'; break;
                    default: paymentMethod = 'غير محدد';
                }

                // Add row to worksheet
                worksheetData.push([
                    period,
                    payment.invoice && payment.invoice.client ? payment.invoice.client.trade_name : 'غير محدد',
                    paymentMethod,
                    payment.amount.toFixed(2),
                    payment.payment_date
                ]);
            });
        });

        // Create workbook
        const worksheet = XLSX.utils.aoa_to_sheet(worksheetData);
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, 'المدفوعات');

        // Generate Excel file
        XLSX.writeFile(workbook, 'payments_report_{{ $fromDate->format('Y-m-d') }}_{{ $toDate->format('Y-m-d') }}.xlsx');
    });

    // PDF Export (Placeholder)
    document.getElementById('pdfExport').addEventListener('click', function() {
        alert('وظيفة التصدير إلى PDF قيد التطوير');
    });
</script>
@endsection
