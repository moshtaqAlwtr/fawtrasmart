@extends('master')

@section('title')
    تقرير أرباح حسب الفترة الزمنية
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/report.css') }}">
@endsection

@section('content')
    <div class="container mt-5">
        <h5 class="card-title">
            @switch($reportPeriod)
                @case('daily')
                    تقرير المبيعات اليومية
                @break

                @case('weekly')
                    تقرير المبيعات الأسبوعية
                @break

                @case('monthly')
                    تقرير الارباح الشهرية
                @break

                @case('yearly')
                    تقرير المبيعات السنوية
                @break
            @endswitch
        </h5>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">تقرير أرباح حسب الفترة الزمنية</h5>
                <form class="row g-3" method="GET" action="{{ route('salesReports.ProfitReportTime') }}">
                    <div class="col-md-3">
                        <label for="customerCategory" class="form-label">تصنيف العميل:</label>
                        <select id="customerCategory" name="customer_category" class="form-select">
                            <option value="all" {{ request()->input('customer_category') == 'all' ? 'selected' : '' }}>الكل</option>
                            @foreach ($customerCategories as $id => $name)
                                <option value="{{ $id }}" {{ request()->input('customer_category') == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="customer" class="form-label">العميل:</label>
                        <select id="customer" name="customer" class="form-select">
                            <option value="all" {{ request()->input('customer') == 'all' ? 'selected' : '' }}>الكل</option>
                            @foreach ($customers as $id => $name)
                                <option value="{{ $id }}" {{ request()->input('customer') == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="branch" class="form-label">فرع:</label>
                        <select id="branch" name="branch" class="form-select">
                            <option value="none" {{ request()->input('branch') == 'none' ? 'selected' : '' }}>لا يوجد</option>
                            @foreach ($branches as $id => $name)
                                <option value="{{ $id }}" {{ request()->input('branch') == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">الحالة:</label>
                        <select id="status" name="status" class="form-select">
                            <option value="all" {{ request()->input('status') == 'all' ? 'selected' : '' }}>الكل</option>
                            <option value="pending" {{ request()->input('status') == 'pending' ? 'selected' : '' }}>معلق</option>
                            <option value="completed" {{ request()->input('status') == 'completed' ? 'selected' : '' }}>مكتمل</option>
                            <option value="canceled" {{ request()->input('status') == 'canceled' ? 'selected' : '' }}>ملغي</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="fromDate" class="form-label">الفترة من:</label>
                        <input type="date" id="fromDate" name="from_date" class="form-control" value="{{ request()->input('from_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="toDate" class="form-label">إلى:</label>
                        <input type="date" id="toDate" name="to_date" class="form-control" value="{{ request()->input('to_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="orderOrigin" class="form-label">منشأ الفاتورة:</label>
                        <select id="orderOrigin" name="order_origin" class="form-select">
                            <option value="all" {{ request()->input('order_origin') == 'all' ? 'selected' : '' }}>الكل</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}" {{ request()->input('order_origin') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->full_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary w-100">عرض التقرير</button>
                        <a href="{{ route('salesReports.ProfitReportTime') }}" class="btn btn-danger w-100">إلغاء الفلترة</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="d-flex justify-content-between mb-3">
            <div>
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="exportOptions" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        خيارات التصدير <i class="fas fa-cloud-download-alt"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="exportOptions">
                        <a class="dropdown-item" href="#" onclick="exportData('csv')">تصدير إلى CSV</a>
                        <a class="dropdown-item" href="#" onclick="exportData('excel')">تصدير إلى Excel</a>
                        <a class="dropdown-item" href="#" onclick="exportData('pdf')">تصدير إلى PDF</a>
                        <a class="dropdown-item" href="#" onclick="exportData('pdfNoGraph')">تصدير إلى PDF بدون
                            رسم</a>
                    </div>
                </div>
            </div>

            <div>
                <button class="btn btn-print ms-2"><i class="fa-solid fa-print"></i> طباعة</button>
            </div>

            <div>
                <button class="btn btn-outline-secondary"><i class="fas fa-search"></i> التفاصيل</button>
                <button class="btn btn-outline-secondary ms-2"><i class="fas fa-user"></i> العميل</button>
                <button class="btn btn-outline-secondary ms-2"><i class="fas fa-clipboard"></i> الملخص</button>
            </div>
        </div>

        <div id="charts-container" style="display: none;">
            <div id="charts" class="row">
                <div class="col-md-6 chart-wrapper">
                    <canvas id="pieChart"></canvas>
                </div>
                <div class="col-md-6 chart-wrapper">
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <div class="container mt-4">
                    <h2 class="text-center">تقرير الأرباح</h2>
                    <table class="table table-striped table-bordered table-hover" id="clientProfitsTable">
                        <thead class="thead-light">
                            <tr>

                                <th>المعرف</th>
                                <th>رقم الفاتورة</th>
                                <th>العميل</th>
                                <th>موظف</th>
                                <th>المنتجات</th>
                                <th>الكمية</th>
                                <th>سعر شراء الوحدة (SAR)</th>
                                <th>سعر شراء الفاتورة (SAR)</th>
                                <th>سعر البيع الوحدة (SAR)</th>
                                <th>سعر البيع الفاتورة (SAR)</th>
                                <th>الخصم (SAR)</th>
                                <th>الربح (SAR)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $currentPeriod = null; // متغير لتخزين الفترة الحالية
                                $totalPurchasePrice = 0; // متغير لتخزين مجموع سعر الشراء
                                $totalSellingPrice = 0; // متغير لتخزين مجموع سعر البيع
                                $totalProfit = 0; // متغير لتخزين مجموع الربح
                            @endphp
                            @forelse($clientProfitsReport as $client)
                                @php
                                    // تحديد الفترة الزمنية
                                    $period = '';
                                    if ($reportPeriod == 'daily') {
                                        $period = \Carbon\Carbon::parse($client['invoice_date'])->format('Y-m-d');
                                    } elseif ($reportPeriod == 'weekly') {
                                        $period =
                                            'الأسبوع ' .
                                            \Carbon\Carbon::parse($client['invoice_date'])->format('W') .
                                            ' من ' .
                                            \Carbon\Carbon::parse($client['invoice_date'])
                                                ->startOfWeek()
                                                ->format('Y-m-d') .
                                            ' إلى ' .
                                            \Carbon\Carbon::parse($client['invoice_date'])
                                                ->endOfWeek()
                                                ->format('Y-m-d');
                                    } elseif ($reportPeriod == 'monthly') {
                                        $period = \Carbon\Carbon::parse($client['invoice_date'])->format('F Y');
                                    } elseif ($reportPeriod == 'yearly') {
                                        $period = \Carbon\Carbon::parse($client['invoice_date'])->format('Y');
                                    }
                                @endphp

                                @if ($currentPeriod !== $period)
                                    @if ($currentPeriod !== null)
                                        <tr class="table-secondary">
                                            <td colspan="7" class="text-end"><strong>المجموع:</strong></td>
                                            <td>{{ number_format($totalPurchasePrice, 2) }} ر.س</td>
                                            <td></td>
                                            <td>{{ number_format($totalSellingPrice, 2) }} ر.س</td>
                                            <td></td>
                                            <td class="{{ $totalProfit >= 0 ? 'profit-positive' : 'profit-negative' }}">
                                                {{ number_format($totalProfit, 2) }} ر.س
                                            </td>
                                        </tr>
                                    @endif

                                    <tr>
                                        <td colspan="13" class="text-center font-weight-bold">{{ $period }}</td>
                                    </tr>
                                    @php
                                        $currentPeriod = $period; // تحديث الفترة الحالية
                                        // إعادة تعيين المجاميع
                                        $totalPurchasePrice = 0;
                                        $totalSellingPrice = 0;
                                        $totalProfit = 0;
                                    @endphp
                                @endif

                                <tr>
                                    <td>{{ $client['client_id'] }}</td>
                                    <td>{{ $client['invoice_number'] }}</td>
                                    <td>{{ $client['name'] }}</td>
                                    <td>{{ $client['employee'] }}</td>
                                    <td>{{ $client['product_name'] }}</td>
                                    <td>{{ number_format($client['total_quantity'], 2) }}</td>
                                    <td>{{ number_format($client['purchase_price'], 2) }} ر.س</td>
                                    <td>{{ number_format($client['invoice_total_purchase'], 2) }} ر.س</td>
                                    <td>{{ number_format($client['selling_price'], 2) }} ر.س</td>
                                    <td>{{ number_format($client['invoice_total_selling'], 2) }} ر.س</td>
                                    <td>{{ number_format($client['discount'], 2) }} ر.س</td>
                                    <td class="{{ $client['profit'] >= 0 ? 'profit-positive' : 'profit-negative' }}">
                                        {{ number_format($client['profit'], 2) }} ر.س
                                    </td>
                                </tr>

                                @php
                                    // إضافة القيم إلى المجموعات
                                    $totalPurchasePrice += $client['invoice_total_purchase'];
                                    $totalSellingPrice += $client['invoice_total_selling'];
                                    $totalProfit += $client['profit'];
                                @endphp
                            @empty
                                <tr>
                                    <td colspan="13" class="text-center">
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle me-2"></i>
                                            لا توجد بيانات للعرض في الفترة المحددة
                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                            @if ($currentPeriod !== null)
                                <tr class="table-secondary">
                                    <td colspan="7" class="text-end"><strong>المجموع:</strong></td>
                                    <td>{{ number_format($totalPurchasePrice, 2) }} ر.س</td>
                                    <td></td>
                                    <td>{{ number_format($totalSellingPrice, 2) }} ر.س</td>
                                    <td></td>
                                    <td class="{{ $totalProfit >= 0 ? 'profit-positive' : 'profit-negative' }}">
                                        {{ number_format($totalProfit, 2) }} ر.س
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
    <script>
        function exportData(format) {
            const table = document.getElementById('clientProfitsTable');
            const wb = XLSX.utils.table_to_book(table, {
                raw: true
            });
            const today = new Date();
            let fileName = `تقرير_أرباح_${today.getFullYear()}-${today.getMonth() + 1}-${today.getDate()}`;

            if (format === 'excel') {
                fileName += '.xlsx';
                XLSX.writeFile(wb, fileName);
            } else if (format === 'csv') {
                fileName += '.csv';
                XLSX.writeFile(wb, fileName);
            } else if (format === 'pdf') {
                // يمكنك استخدام مكتبة أخرى لتصدير PDF
                alert('تصدير PDF غير مفعل حالياً.');
            } else if (format === 'pdfNoGraph') {
                // يمكنك استخدام مكتبة أخرى لتصدير PDF بدون رسم
                alert('تصدير PDF بدون رسم غير مفعل حالياً.');
            }
        }

        function showCharts() {
            document.getElementById('charts-container').style.display = 'block';
            createPieChart();
            createBarChart();
        }

        function createPieChart() {
            var ctx = document.getElementById('pieChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['مدفوعة', 'غير مدفوعة', 'مرجع'],
                    datasets: [{
                        data: [38.2, 61.2, 0.6],
                        backgroundColor: ['#28a745', '#e74c3c', '#007bff']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }

        function createBarChart() {
            var ctx = document.getElementById('barChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['شركة 1', 'شركة 2', 'شركة 3', 'شركة 4', 'شركة 5'],
                    datasets: [{
                            label: 'الإجمالي',
                            data: [450, 900, 300, 500, 700],
                            backgroundColor: '#42a5f5'
                        },
                        {
                            label: 'مدفوعة',
                            data: [300, 600, 200, 400, 500],
                            backgroundColor: '#28a745'
                        },
                        {
                            label: 'غير مدفوعة',
                            data: [150, 300, 100, 100, 200],
                            backgroundColor: '#e74c3c'
                        },
                        {
                            label: 'مرجع',
                            data: [0, 0, 0, 0, 0],
                            backgroundColor: '#007bff'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            ticks: {
                                autoSkip: false,
                                maxRotation: 45,
                                minRotation: 45
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
    </script>
@endsection
