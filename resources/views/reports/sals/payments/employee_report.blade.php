@extends('master')

@section('title')
    المدفوعات حسب الموظف
@endsection

@section('css')
    <!-- Existing CSS from original HTML -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<link rel="stylesheet" href="{{ asset('assets/css/report.css') }}">

@endsection

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">المدفوعات حسب الموظف</h5>
            <form class="row g-3" method="GET" action="{{ route('salesReports.employeePaymentReport') }}">
                <!-- منشأ الفاتورة (الموظف المسؤول عن إنشاء الفاتورة) -->
                <div class="col-md-3">
                    <label for="employee" class="form-label">منشأ الفاتورة:</label>
                    <select name="employee" id="employee" class="form-select">
                        <option value="">الكل</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ request('employee') == $employee->id ? 'selected' : '' }}>
                                {{ $employee->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- الموظف المسؤول عن التحصيل -->
                <div class="col-md-3">
                    <label for="collector" class="form-label">تم التحصيل بواسطة</label>
                    <select name="collector" id="collector" class="form-select">
                        <option value="">الكل</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ request('collector') == $employee->id ? 'selected' : '' }}>
                                {{ $employee->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- وسيلة الدفع -->
                <div class="col-md-3">
                    <label for="payment_method" class="form-label">وسيلة الدفع</label>
                    <select name="payment_method" id="payment_method" class="form-select">
                        <option value="">الكل</option>
                        @foreach($paymentMethods as $method)
                            <option value="{{ $method['id'] }}" {{ request('payment_method') == $method['id'] ? 'selected' : '' }}>
                                {{ $method['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- العميل -->
                <div class="col-md-3">
                    <label for="client" class="form-label">العميل:</label>
                    <select name="client" id="client" class="form-select">
                        <option value="">الكل</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ request('client') == $client->id ? 'selected' : '' }}>
                                {{ $client->trade_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- التاريخ من -->
                <div class="col-md-3">
                    <label for="fromDate" class="form-label">الفترة من:</label>
                    <input type="date" name="from_date" id="fromDate" class="form-control"
                           value="{{ request('from_date', $fromDate->format('Y-m-d')) }}">
                </div>

                <!-- التاريخ إلى -->
                <div class="col-md-3">
                    <label for="toDate" class="form-label">إلى:</label>
                    <input type="date" name="to_date" id="toDate" class="form-control"
                           value="{{ request('to_date', $toDate->format('Y-m-d')) }}">
                </div>

                <!-- الفرع -->
                <div class="col-md-3">
                    <label for="branch" class="form-label">فرع:</label>
                    <select name="branch" id="branch" class="form-select">
                        <option value="">الكل</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ request('branch') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- فئة العميل -->
                <div class="col-md-3">
                    <label for="customerCategory" class="form-label">فئة العميل:</label>
                    <select name="customer_category" id="customerCategory" class="form-select">
                        <option value="">الكل</option>
                        @foreach($customerCategories as $category)
                            <option value="{{ $category->id }}" {{ request('customer_category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- أزرار الإجراء -->
                <div class="col-md-6 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary w-50">عرض التقرير</button>
                    <a href="{{ route('salesReports.employeePaymentReport') }}" class="btn btn-secondary w-50">إلغاء الفلتر</a>
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex justify-content-between mb-3">
        <div>
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="exportOptions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    خيارات التصدير <i class="fas fa-cloud-download-alt"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="exportOptions">
                    <a class="dropdown-item" href="#" onclick="exportData('csv')">تصدير إلى CSV</a>
                    <a class="dropdown-item" href="#" onclick="exportData('excel')">تصدير إلى Excel</a>
                    <a class="dropdown-item" href="#" onclick="exportData('pdf')">تصدير إلى PDF</a>
                    <a class="dropdown-item" href="#" onclick="exportData('pdfNoGraph')">Export to PDF no graph</a>
                </div>
            </div>
        </div>

        <div>
            <button class="btn btn-print ms-2" onclick="window.print()">
                <i class="fa-solid fa-print"></i> طباعة
            </button>
        </div>

        <div>
            <button class="btn btn-outline-secondary">
                <i class="fa-solid fa-search"></i> التفاصيل
            </button>
            <button class="btn btn-outline-secondary ms-2">
                <i class="fa-solid fa-user"></i> العميل
            </button>
            <button class="btn btn-outline-secondary ms-2">
                <i class="fa-solid fa-clipboard"></i> الملخص
            </button>
        </div>
    </div>

    <div class="chart-card">
        <h5 class="text-center">المدفوعات حسب الموظف (SAR)</h5>
        <div class="chart-container">
            <canvas id="barChart" height="120"></canvas>
        </div>
    </div>

    <<div class="card mt-4">
        <div class="card-body">
            <h6 class="card-subtitle mb-2 text-muted">
                تقرير مفصل للمدفوعات من {{ $fromDate->format('d/m/Y') }} إلى {{ $toDate->format('d/m/Y') }}
            </h6>

            @php
                $currentEmployee = null;
            @endphp

            @forelse($payments as $payment)
                @php
                    $employeeName = $payment->invoice->employee->full_name ?? 'غير محدد';

                    // Check if this is a new employee
                    if ($currentEmployee !== $employeeName) {
                        $currentEmployee = $employeeName;

                        // Reset totals for this employee
                        $totalPaid = 0;
                        $totalUnpaid = 0;
                        $totalReference = 0;
                    @endphp
                    <table class="table table-bordered mb-4">
                        <thead>
                            <tr class="table-primary">
                                <th colspan="7">
                                    <strong>الموظف: {{ $currentEmployee }}</strong>
                                </th>
                            </tr>
                            <tr>
                                <th>رقم</th>
                                <th>التاريخ</th>
                                <th>العميل</th>
                                <th>مدفوعة (SAR)</th>
                                <th>غير مدفوعة (SAR)</th>
                                <th>مرجع (SAR)</th>
                                <th>الإجمالي (SAR)</th>
                            </tr>
                        </thead>
                        <tbody>
                    @php
                    }

                    // Calculate totals
                    $totalPaid += $payment->amount;
                    $totalUnpaid += $payment->invoice->due_value ?? 0;
                    $totalReference += $payment->reference_number ? $payment->amount : 0;
                    $totalOverall = $payment->amount + ($payment->invoice->due_value ?? 0);
                    @endphp

                    <tr>
                        <td>{{ $payment->id }}</td>
                        <td>{{ $payment->payment_date->format('d/m/Y') }}</td>
                        <td>{{ $payment->invoice->client->trade_name ?? 'غير محدد' }}</td>
                        <td>{{ number_format($payment->amount, 2) }}</td>
                        <td>{{ number_format($payment->invoice->due_value ?? 0, 2) }}</td>
                        <td>{{ number_format($payment->reference_number ? $payment->amount : 0, 2) }}</td>
                        <td>{{ number_format($totalOverall, 2) }}</td>
                    </tr>

                    @if($loop->last ||
                        $employeeName !== ($payments[$loop->index + 1]->invoice->employee->full_name ?? null))
                        <tr class="table-info fw-bold">
                            <td colspan="3">مجموع الموظف {{ $currentEmployee }}</td>
                            <td>{{ number_format($totalPaid, 2) }}</td>
                            <td>{{ number_format($totalUnpaid, 2) }}</td>
                            <td>{{ number_format($totalReference, 2) }}</td>
                            <td>{{ number_format($totalPaid + $totalUnpaid, 2) }}</td>
                        </tr>
                        </tbody>
                    </table>
                    @endif
            @empty
                <tr>
                    <td colspan="7" class="text-center">لا توجد مدفوعات</td>
                </tr>
            @endforelse
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>

<script>
    // Export functionality
    function exportToExcel() {
        // Get the table
        const table = document.querySelector('.table');

        // Convert table to workbook
        const wb = XLSX.utils.table_to_book(table);

        // Save the file
        XLSX.writeFile(wb, 'employee_payments_report.xlsx');
    }

    // Attach export function to dropdown
    document.addEventListener('DOMContentLoaded', function() {
        const excelExportBtn = document.querySelector('[onclick="exportData(\'excel\')"]');
        if (excelExportBtn) {
            excelExportBtn.addEventListener('click', exportToExcel);
        }
    });

    // Chart Script (previous chart script remains the same)
    const ctx = document.getElementById('barChart').getContext('2d');

    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(0, 150, 255, 0.8)');
    gradient.addColorStop(1, 'rgba(0, 255, 255, 0.4)');

    // Calculate total payments for percentage
    const totalPayments = @json($chartData['values']).reduce((a, b) => a + b, 0);

    const data = {
        labels: @json($chartData['labels']),  // Keep original labels
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

    const barChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options
    });

    // Fix for dropdown display
    document.addEventListener('DOMContentLoaded', function() {
        const exportOptionsBtn = document.getElementById('exportOptions');
        const exportDropdown = exportOptionsBtn.nextElementSibling;

        exportOptionsBtn.addEventListener('click', function() {
            exportDropdown.classList.toggle('show');
        });

        // Close dropdown when clicking outside
        window.addEventListener('click', function(event) {
            if (!event.target.matches('#exportOptions')) {
                if (exportDropdown.classList.contains('show')) {
                    exportDropdown.classList.remove('show');
                }
            }
        });
    });
</script>
@endsection
