@extends('master')

@section('title')
    تقرير المشتريات بحسب الموظف
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .table-return {
            background-color: #ffdddd !important;
        }
        .text-return {
            color: #dc3545 !important;
        }
        .filter-card {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3>تقرير المشتريات بحسب الموظف</h3>
        </div>

        {{-- Filter Section --}}
        <div class="card-body">
            <div class="filter-card">
                <form action="{{ route('ReportsPurchases.purchaseByEmployee') }}" method="GET" id="reportForm">
                    <div class="row g-3">
                        {{-- First Row of Filters --}}
                        <div class="col-md-3">
                            <label class="form-label">المورد</label>
                            <select name="supplier" class="form-select">
                                <option value="">جميع الموردين</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}"
                                        {{ request('supplier') == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->trade_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">الفرع</label>
                            <select name="branch" class="form-select">
                                <option value="">جميع الفروع</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}"
                                        {{ request('branch') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">حالة الدفع</label>
                            <select name="status" class="form-select">
                                <option value="">الكل</option>
                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>مدفوعة</option>
                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>غير مدفوعة</option>
                                <option value="5" {{ request('status') == '5' ? 'selected' : '' }}>مرتجعة</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">الفترة</label>
                            <select name="report_period" class="form-select">
                                <option value="daily" {{ $reportPeriod == 'daily' ? 'selected' : '' }}>يومي</option>
                                <option value="weekly" {{ $reportPeriod == 'weekly' ? 'selected' : '' }}>أسبوعي</option>
                                <option value="monthly" {{ $reportPeriod == 'monthly' ? 'selected' : '' }}>شهري</option>
                                <option value="yearly" {{ $reportPeriod == 'yearly' ? 'selected' : '' }}>سنوي</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">من تاريخ</label>
                            <input type="date" name="from_date" class="form-control"
                                value="{{ $fromDate->format('Y-m-d') }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">إلى تاريخ</label>
                            <input type="date" name="to_date" class="form-control"
                                value="{{ $toDate->format('Y-m-d') }}">
                        </div>

<div class="card">
    <div class="card-body">
        <div class="col-md-6">
            <button type="button" id="exportExcel" class="btn btn-success">
                <i class="fas fa-file-excel me-2"></i> تصدير إكسل
            </button>
            <button type="submit" class="btn btn-primary w-80">
                <i class="fas fa-filter me-2"></i> تصفية التقرير
            </button>
            <a href="{{ route('ReportsPurchases.purchaseByEmployee') }}" class="btn btn-primary w-20">
                <i class="fas fa-filter me-2"></i> الغاء الفلتر
            </a>
        </div>
    </div>
</div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                {{-- مخطط حالة الدفع --}}
                <div class="col-md-6">
                    <div class="chart-container">
                        <canvas id="paymentStatusChart"></canvas>
                    </div>
                </div>

                {{-- مخطط الموردين --}}
                <div class="col-md-6">
                    <div class="chart-container">
                        <canvas id="supplierChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

          {{-- جدول التقرير --}}
          <div class="card-body">
            <div class="table-responsive">
                <table id="purchaseReportTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>التاريخ</th>
                            <th>الموظف</th>
                            <th>رقم الفاتورة</th>
                            <th>الفرع</th>
                            <th>مدفوعة (SAR)</th>
                            <th>غير مدفوعة (SAR)</th>
                            <th>مرتجع (SAR)</th>
                            <th>الإجمالي (SAR)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $grandPaidTotal = 0;
                            $grandUnpaidTotal = 0;
                            $grandReturnedTotal = 0;
                            $grandOverallTotal = 0;
                        @endphp

                        @foreach ($groupedPurchaseInvoices as $employeeId => $invoices)
                            @php
                                $employeePaidTotal = 0;
                                $employeeUnpaidTotal = 0;
                                $employeeReturnedTotal = 0;
                                $employeeOverallTotal = 0;
                            @endphp

                            <tr class="table-secondary">
                                <td colspan="8">{{ $invoices->first()->creator->name ?? 'موظف ' . $employeeId }}</td>
                            </tr>

                            @foreach ($invoices as $invoice)
                                @php
                                    $paidAmount = $invoice->is_paid == 1 ? $invoice->grand_total : $invoice->payments_process->sum('amount');
                                    $remainingAmount = $invoice->is_paid == 0 ? max($invoice->grand_total - $paidAmount, 0) : 0;
                                    $returnedAmount = in_array($invoice->type, ['return', 'returned']) ? $invoice->grand_total : 0;

                                    $employeePaidTotal += $paidAmount;
                                    $employeeUnpaidTotal += $remainingAmount;
                                    $employeeReturnedTotal += $returnedAmount;
                                    $employeeOverallTotal += $invoice->grand_total;

                                    $grandPaidTotal += $paidAmount;
                                    $grandUnpaidTotal += $remainingAmount;
                                    $grandReturnedTotal += $returnedAmount;
                                    $grandOverallTotal += $invoice->grand_total;
                                @endphp

                                <tr class="{{ in_array($invoice->type, ['return', 'returned']) ? 'table-return text-return' : '' }}">
                                    <td>{{ \Carbon\Carbon::parse($invoice->date)->format('d/m/Y') }}</td>
                                    <td>{{ $invoice->creator->name ?? 'غير محدد' }}</td>
                                    <td>{{ $invoice->code }}</td>
                                    <td>{{ $invoice->branch->name ?? 'غير محدد' }}</td>
                                    <td>{{ number_format($paidAmount, 2) }}</td>
                                    <td>{{ number_format($remainingAmount, 2) }}</td>
                                    <td>{{ number_format($returnedAmount, 2) }}</td>
                                    <td>{{ number_format($invoice->grand_total, 2) }}</td>
                                </tr>
                            @endforeach

                            {{-- إجمالي لكل موظف --}}
                            <tr class="table-info">
                                <td colspan="4">إجمالي الموظف</td>
                                <td>{{ number_format($employeePaidTotal, 2) }}</td>
                                <td>{{ number_format($employeeUnpaidTotal, 2) }}</td>
                                <td>{{ number_format($employeeReturnedTotal, 2) }}</td>
                                <td>{{ number_format($employeeOverallTotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>

                    {{-- الإجمالي الكلي --}}
                    <tfoot>
                        <tr class="table-dark">
                            <td colspan="4">الإجمالي الكلي</td>
                            <td>{{ number_format($grandPaidTotal, 2) }}</td>
                            <td>{{ number_format($grandUnpaidTotal, 2) }}</td>
                            <td>{{ number_format($grandReturnedTotal, 2) }}</td>
                            <td>{{ number_format($grandOverallTotal, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="card mt-4" id="detailedReportTable" style="display: none;">
        <div class="card-body">
            <h6 class="card-subtitle mb-2 text-muted">
                التفاصيل الكاملة للتقرير
            </h6>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>
                            @switch($reportPeriod)
                                @case('daily')
                                    التاريخ (يومي)
                                @break
                                @case('weekly')
                                    الأسبوع
                                @break
                                @case('monthly')
                                    الشهر
                                @break
                                @case('yearly')
                                    السنة
                                @break
                                @default
                                    التاريخ
                            @endswitch
                        </th>
                        <th>رقم الفاتورة</th>
                        <th>المورد</th>
                        <th>الموظف</th>
                        <th>مدفوعة (SAR)</th>
                        <th>غير مدفوعة (SAR)</th>
                        <th>مرتجع (SAR)</th>
                        <th>الإجمالي (SAR)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($groupedPurchaseInvoices as $supplierId => $invoices)
                        @foreach ($invoices as $invoice)
                            <tr>
                                <td>
                                    @switch($reportPeriod)
                                        @case('daily')
                                            {{ \Carbon\Carbon::parse($invoice->date)->format('d/m/Y') }}
                                        @break
                                        @case('weekly')
                                            الأسبوع {{ \Carbon\Carbon::parse($invoice->date)->weekOfYear }}
                                            ({{ \Carbon\Carbon::parse($invoice->date)->startOfWeek()->format('d/m/Y') }}
                                            - {{ \Carbon\Carbon::parse($invoice->date)->endOfWeek()->format('d/m/Y') }})
                                        @break
                                        @case('monthly')
                                            {{ \Carbon\Carbon::parse($invoice->date)->format('m/Y') }}
                                        @break
                                        @case('yearly')
                                            {{ \Carbon\Carbon::parse($invoice->date)->format('Y') }}
                                        @break
                                        @default
                                            {{ \Carbon\Carbon::parse($invoice->date)->format('d/m/Y') }}
                                    @endswitch
                                </td>
                                <td>{{ str_pad($invoice->code, 5, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $invoice->supplier->trade_name ?? 'غير محدد' }}</td>
                                <td>{{ $invoice->employee->full_name ?? 'غير محدد' }}</td>
                                <td>
                                    {{ number_format($invoice->is_paid == 1 ? $invoice->grand_total : $invoice->paid_amount, 2) }}
                                </td>
                                <td>
                                    {{ number_format($invoice->is_paid == 1 ? 0 : $invoice->due_value, 2) }}
                                </td>
                                <td>
                                    {{ number_format(in_array($invoice->type, ['return', 'returned']) ? $invoice->grand_total : 0, 2) }}
                                </td>
                                <td>{{ number_format($invoice->grand_total, 2) }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
    <script>
        $(document).ready(function() {
            // بيانات المخطط البياني لحالة الدفع
            const paymentStatusChartData = @json($paymentStatusChartData);

            // إنشاء مخطط دائري لحالة الدفع
            const paymentStatusChart = new Chart(document.getElementById('paymentStatusChart'), {
                type: 'pie',
                data: {
                    labels: paymentStatusChartData.labels,
                    datasets: [{
                        data: paymentStatusChartData.values,
                        backgroundColor: paymentStatusChartData.colors,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'حالة الدفع'
                        }
                    }
                }
            });

            // بيانات المخطط البياني للموظفين
            const employeeChartData = @json($employeeChartData);

            // إنشاء مخطط شريطي للموظفين
            const employeeChart = new Chart(document.getElementById('employeeChart'), {
                type: 'bar',
                data: {
                    labels: employeeChartData.labels,
                    datasets: [{
                        label: 'إجمالي المشتريات',
                        data: employeeChartData.values,
                        backgroundColor: employeeChartData.colors,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false,
                        },
                        title: {
                            display: true,
                            text: 'المشتريات بحسب الموظفين'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // تصدير الجدول إلى Excel
            $('#exportExcel').on('click', function() {
                const table = document.getElementById('purchaseReportTable');
                const wb = XLSX.utils.table_to_book(table, {
                    raw: true
                });
                const today = new Date();
                const fileName =
                    `تقرير_المشتريات_${today.getFullYear()}-${today.getMonth() + 1}-${today.getDate()}.xlsx`;
                XLSX.writeFile(wb, fileName);
            });
        });
    </script>
@endsection
