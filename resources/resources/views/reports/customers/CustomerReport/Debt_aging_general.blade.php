@extends('master')
@section('title')
    تقريراعمار الديون الاستاذ العام
@stop
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .card {
            border: none;
            margin-bottom: 20px;
        }

        .filter-section {
            background: linear-gradient(to right, #f0f4f8, #e0eafc);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .filter-section select,
        .filter-section input {
            margin-bottom: 10px;
        }

        .btn-custom {
            background: linear-gradient(45deg, #1e90ff, #00bcd4);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .btn-custom:hover {
            background: linear-gradient(45deg, #00bcd4, #1e90ff);
            color: white;
        }

        .action-buttons {
            margin: 20px 0;
        }

        .action-buttons .btn {
            margin-right: 10px;
            border-radius: 5px;
        }

        .btn-primary {
            background: linear-gradient(45deg, #00c6ff, #0072ff);
            border: none;
        }

        .chart-container {
            padding: 20px;
            background: linear-gradient(to right, #e0eafc, #cfdef3);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .table-container {
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table thead {
            background-color: #e9f0f7;
            font-weight: bold;
        }

        .export-print-buttons {
            margin-bottom: 15px;
        }

        .chart {
            height: 300px;
        }
    </style>
@endsection
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0"> تقرير اعمار الديون الاستاذ العام</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a></li>
                            <li class="breadcrumb-item active">عرض</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="filter-section">
                <form action="{{ route('ClientReport.debtAgingGeneralLedger') }}" method="GET">
                    <div class="row">
                        <!-- Branch Filter -->
                        <div class="col-md-3">
                            <label for="branch" class="form-label">فرع:</label>
                            <select id="branch" name="branch" class="form-control">
                                <option value="">كل الفروع</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="days" class="form-label">الفترة (أيام):</label>
                            <input type="number" id="days" name="days" class="form-control" value="30">
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="financial-year">السنة المالية:</label>
                                <select id="financial-year" name="financial_year[]" class="form-control select2" multiple>
                                    <option value="current">السنة المفتوحة</option>
                                    <option value="all">جميع السنوات</option>
                                    @for ($year = date('Y'); $year >= date('Y') - 10; $year--)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <!-- Customer Type Filter -->
                        <div class="col-md-3">
                            <label for="customer-type" class="form-label">تصنيف العميل:</label>
                            <select id="customer-type" name="customer_type" class="form-control">
                                <option value="">الكل</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Customer Filter -->
                        <div class="col-md-3">
                            <label for="customer" class="form-label">العميل:</label>
                            <select id="customer" name="customer" class="form-control">
                                <option value="">الكل</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->trade_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sales Manager Filter -->
                        <div class="col-md-3">
                            <label for="sales-manager" class="form-label">مسؤول مبيعات:</label>
                            <select id="sales-manager" name="sales_manager" class="form-control">
                                <option value="">الكل</option>
                                @foreach ($salesManagers as $manager)
                                    <option value="{{ $manager->id }}">{{ $manager->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn-custom">عرض التقرير</button>
                            <a href="{{ route('ClientReport.debtAgingGeneralLedger') }}" class="btn-custom"> الغاء الفلتر
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Export & Print Buttons -->
    <div class="card">
        <div class="card-body">
            <div class="action-buttons text-end">
                <button class="btn btn-primary" onclick="window.print()"><i class="fas fa-print"></i> طباعة</button>
                <div class="btn-group">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fas fa-download"></i> خيارات التصدير
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" onclick="exportToExcel()"><i
                                    class="fas fa-file-excel"></i> تصدير إلى Excel</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Chart Section -->
    <div class="card">
        <div class="card-body">
            <div class="chart-container">
                <h5 class="text-center mb-4">أعمار الديون (SAR)</h5>
                <canvas class="chart bg-light" id="chart"></canvas>
            </div>
        </div>
    </div>
    <!-- Table Section -->
    <div class="table-container">
        <h5 class="text-center mb-4">أعمار الديون (حساب الأستاذ) - تجميع حسب العميل</h5>
        <p class="text-center">الوقت: 14:24 09/11/2024 | الفترة (أيام): 30</p>
        <p class="text-center">مؤسسة أعمال خاصة للتجارة</p>

        <table class="table table-striped table-hover text-center">
            <thead>
                <tr>
                    <th>كود العميل</th>
                    <th>رقم الحساب</th>
                    <th>الاسم</th>
                    <th>فرع</th>
                    <th>اليوم</th>
                    <th>1 - 30 يوم</th>
                    <th>31 - 60 يوم</th>
                    <th>61 - 90 يوم</th>
                    <th>91 - 120 يوم</th>
                    <th>+120 يوم</th>
                    <th>الإجمالي</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reportData as $data)
                    <tr>
                        <td>{{ $data['client_code'] }}</td>
                        <td>{{ $data['account_number'] }}</td>
                        <td>{{ $data['client_name'] }}</td>
                        <td>{{ $data['branch'] }}</td>
                        <td>{{ number_format($data['today'], 2) }}</td>
                        <td>{{ number_format($data['days1to30'], 2) }}</td>
                        <td>{{ number_format($data['days31to60'], 2) }}</td>
                        <td>{{ number_format($data['days61to90'], 2) }}</td>
                        <td>{{ number_format($data['days91to120'], 2) }}</td>
                        <td>{{ number_format($data['daysOver120'], 2) }}</td>
                        <td>{{ number_format($data['total_due'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="text-end">الاجمالي </th>
                    <th>{{ number_format($reportData->sum('today'), 2) }}</th>
                    <th>{{ number_format($reportData->sum('days1to30'), 2) }}</th>
                    <th>{{ number_format($reportData->sum('days31to60'), 2) }}</th>
                    <th>{{ number_format($reportData->sum('days61to90'), 2) }}</th>
                    <th>{{ number_format($reportData->sum('days91to120'), 2) }}</th>
                    <th>{{ number_format($reportData->sum('daysOver120'), 2) }}</th>
                    <th>{{ number_format($reportData->sum('total_due'), 2) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
<script>
    const ctx = document.getElementById('chart').getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(0, 191, 255, 1)'); // لون بداية التدرج
    gradient.addColorStop(1, 'rgba(72, 61, 139, 0.5)'); // لون نهاية التدرج

    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['اليوم', '1 - 30 يوم', '31 - 60 يوم', '61 - 90 يوم', '91 - 120 يوم', '+120 يوم'],
            datasets: [
                {
                    label: 'إجمالي الديون (SAR)',
                    data: [
                        {{ $reportData->sum('today') }},
                        {{ $reportData->sum('days1to30') }},
                        {{ $reportData->sum('days31to60') }},
                        {{ $reportData->sum('days61to90') }},
                        {{ $reportData->sum('days91to120') }},
                        {{ $reportData->sum('daysOver120') }}
                    ],
                    backgroundColor: gradient,
                    borderColor: '#4a00e0',
                    borderWidth: 1,
                    hoverBackgroundColor: 'rgba(0, 191, 255, 0.8)', // لون عند التمرير
                    hoverBorderColor: '#4a00e0',
                },
                {
                    label: 'عدد الفواتير لكل موظف',
                    data: [
                        @foreach ($reportData as $data)
                            {{ $data['invoice_count'] }},
                        @endforeach
                    ],
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: '#ff6384',
                    borderWidth: 1,
                    hoverBackgroundColor: 'rgba(255, 99, 132, 0.8)', // لون عند التمرير
                    hoverBorderColor: '#ff6384',
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'تقرير أعمار الديون (حساب الأستاذ)',
                    font: {
                        size: 18,
                        weight: 'bold'
                    }
                },
                tooltip: {
                    enabled: true,
                    mode: 'index',
                    intersect: false,
                    backgroundColor: 'rgba(0, 0, 0, 0.7)',
                    titleFont: {
                        size: 16,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 14
                    },
                    footerFont: {
                        size: 12
                    }
                },
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        font: {
                            size: 14
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: true,
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    title: {
                        display: true,
                        text: 'فترات الأعمار',
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    }
                },
                y: {
                    ticks: {
                        callback: function(value) {
                            if (value >= 1000) {
                                return (value / 1000) + 'K'; // تقسيم على الألف وإضافة K
                            }
                            return value;
                        },
                        font: {
                            size: 14
                        }
                    },
                    grid: {
                        display: true,
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    title: {
                        display: true,
                        text: 'المبلغ (SAR)',
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    },
                    beginAtZero: true
                }
            },
            animation: {
                duration: 1000, // مدة الرسوم المتحركة
                easing: 'easeInOutQuad' // نوع الرسوم المتحركة
            }
        }
    });
    function updateCircularChart(data) {
    const employeeNames = data.map(item => item.employee_name);
    const invoiceCounts = data.map(item => item.invoice_count);

    circularChart.data.labels = employeeNames; // Set employee names as labels
    circularChart.data.datasets[0].data = invoiceCounts; // Set invoice counts as data
    circularChart.update(); // Update the chart
}
</script>
@endsection
