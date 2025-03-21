@extends('master')

@section('title')
    تقرير سندات القبض حسب الفترة الزمنية
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .gradient-bg {
            background: linear-gradient(90deg, #007bff, #6610f2);
            color: white;
        }

        body {
            background-color: #f8f9fa;
            direction: rtl;
        }

        .card-header {
            background-color: #007bff;
            color: white;
        }

        .btn-custom {
            background-color: #28a745;
            color: white;
        }

        .table-header {
            background-color: #e9ecef;
        }

        .hidden {
            display: none;
        }
    </style>
@endsection

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0"> تقرير سندات القبض حسب الفترة الزمنية
                    </h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                            <li class="breadcrumb-item active">عرض</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <!-- Filter Section -->
        <div class="card p-4 mb-3">
            <form action="{{ route('GeneralAccountReports.ReceiptByTimePeriod') }}" method="GET">
                <div class="row g-3 align-items-center">
                    <div class="col-md-3">
                        <label for="inputTaxType" class="form-label">الخزينة :</label>
                        <select class="form-control" id="inputTaxType" name="treasury">
                            <option value="">اختر الخزينة</option>
                            @foreach ($treasuries as $treasury)
                                <option value="{{ $treasury->id }}" {{ request('treasury') == $treasury->id ? 'selected' : '' }}>
                                    {{ $treasury->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="inputTaxType" class="form-label">الموظف :</label>
                        <select class="form-control" id="inputTaxType" name="employee">
                            <option value="">اختر الموظف</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}" {{ request('employee') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="inputDateFrom" class="form-label">الفترة من:</label>
                        <input type="date" class="form-control" id="inputDateFrom" name="from_date"
                            value="{{ request('from_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="inputDateFrom" class="form-label">الفترة إلى:</label>
                        <input type="date" class="form-control" id="inputDateFrom" name="to_date"
                            value="{{ request('to_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="inputGroupBy" class="form-label">نوع التقرير:</label>
                        <select class="form-control" id="inputGroupBy" name="report_period">
                            <option value="daily" {{ request('report_period') == 'daily' ? 'selected' : '' }}>يومي</option>
                            <option value="weekly" {{ request('report_period') == 'weekly' ? 'selected' : '' }}>أسبوعي</option>
                            <option value="monthly" {{ request('report_period') == 'monthly' ? 'selected' : '' }}>شهري</option>
                            <option value="quarterly" {{ request('report_period') == 'quarterly' ? 'selected' : '' }}>ربع سنوي</option>
                            <option value="yearly" {{ request('report_period') == 'yearly' ? 'selected' : '' }}>سنوي</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="inputCurrency" class="form-label">الفرع:</label>
                        <select class="form-control" id="inputCurrency" name="branch">
                            <option value="all" {{ request('branch') == 'all' ? 'selected' : '' }}>كل الفروع</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}" {{ request('branch') == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="inputCurrency" class="form-label">العملة:</label>
                        <select class="form-control" id="inputCurrency" name="currency">
                            <option value="all" {{ request('currency') == 'all' ? 'selected' : '' }}>كل العملات</option>
                            <option value="SAR" {{ request('currency') == 'SAR' ? 'selected' : '' }}>SAR</option>
                            <option value="USD" {{ request('currency') == 'USD' ? 'selected' : '' }}>USD</option>
                            <option value="EUR" {{ request('currency') == 'EUR' ? 'selected' : '' }}>EUR</option>
                            <option value="GBP" {{ request('currency') == 'GBP' ? 'selected' : '' }}>GBP</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-custom mt-3">عرض التقرير</button>
                <a href="{{ route('GeneralAccountReports.ReceiptByTimePeriod') }}" class="btn btn-custom mt-3">الغاء
                    الفلتر</a>
            </form>
        </div>

        <!-- Report Summary -->
        <div class="card p-4 mb-3">
            <h5>الجميع إلى ({{ request('currency', 'SAR') }})</h5>
            <p>من {{ request('from_date', 'بداية التاريخ') }} إلى {{ request('to_date', 'نهاية التاريخ') }}</p>
            <p>مؤسسة أعمال خاصة للتجارة<br>الرياض<br>الرياض</p>
        </div>

        <!-- Table Section -->
        <div class="card p-4 mb-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <button class="btn btn-outline-primary" id="summaryButton">الملخص</button>
                    <button class="btn btn-outline-primary" id="detailsButton">التفاصيل</button>
                </div>
                <div>
                    <button class="btn btn-outline-secondary" onclick="exportCSV()">تصدير إلى CSV</button>
                    <button class="btn btn-outline-secondary" onclick="exportExcel()">تصدير إلى Excel</button>
                    <button class="btn btn-outline-secondary" onclick="exportPDF()">تصدير إلى PDF</button>
                    <button class="btn btn-outline-secondary" onclick="printTable()">طباعة</button>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="card p-4 mb-3">
                <h5>مخطط الإجمالي حسب الفترة الزمنية</h5>
                <canvas id="receiptsChart" width="400" height="200"></canvas>
            </div>

            <!-- Summary Table -->
            <div id="summaryTable">
                <table class="table table-bordered table-striped">
                    <thead class="table-header">
                        <tr>
                            <th>الفترة الزمنية</th>
                            <th>الكود</th>
                            <th>التاريخ</th>
                            <th>خزينة</th>
                            <th>التصنيف</th>
                            <th>البائع</th>
                            <th>الحساب الفرعي</th>
                            <th>موظف</th>
                            <th>ملاحظة</th>
                            <th>فرع</th>
                            <th>المبلغ</th>
                            <th>الضرائب</th>
                            <th>الإجمالي مع الضريبة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            // تجميع البيانات حسب الفترة الزمنية
                            $groupedReceipts = $receipts->groupBy(function ($receipt) use ($reportPeriod) {
                                $date = date_create($receipt->date); // استخدام date_create بدلاً من Carbon::parse

                                switch ($reportPeriod) {
                                    case 'daily':
                                        return date_format($date, 'Y-m-d'); // استخدام date_format بدلاً من ->format()
                                    case 'weekly':
                                        return date_format($date, 'Y') . ' Week ' . date_format($date, 'W'); // الأسبوع
                                    case 'monthly':
                                        return date_format($date, 'Y-m');
                                    case 'quarterly':
                                        return date_format($date, 'Y') . ' Q' . ceil(date_format($date, 'm') / 3); // الربع
                                    case 'yearly':
                                        return date_format($date, 'Y');
                                    default:
                                        return date_format($date, 'Y-m-d');
                                }
                            });
                        @endphp

                        @foreach ($groupedReceipts as $periodKey => $receiptsInPeriod)
                            <!-- عرض الفترة الزمنية -->
                            <tr style="background-color: #f8f9fa;">
                                <td colspan="13"><strong>{{ $periodKey }}</strong></td>
                            </tr>

                            <!-- عرض التفاصيل تحت الفترة الزمنية -->
                            @foreach ($receiptsInPeriod as $receipt)
                                <tr>
                                    <td>{{ $periodKey }}</td>
                                    <td>{{ $receipt->code }}</td>
                                    <td>{{ $receipt->date }}</td>
                                    <td>{{ $receipt->treasury->name ?? 'N/A' }}</td>
                                    <td>{{ $receipt->incomes_category->name ?? 'N/A' }}</td>
                                    <td>{{ $receipt->seller }}</td>
                                    <td>{{ $receipt->sup_account }}</td>
                                    <td>{{ $receipt->employee->full_name ?? 'N/A' }}</td>
                                    <td>{{ $receipt->description }}</td>
                                    <td>{{ $receipt->branch->name ?? 'N/A' }}</td>
                                    <td>{{ number_format($receipt->amount, 2) }}</td>
                                    <td>{{ number_format($receipt->tax1_amount + $receipt->tax2_amount, 2) }}</td>
                                    <td>{{ number_format($receipt->amount + $receipt->tax1_amount + $receipt->tax2_amount, 2) }}</td>
                                </tr>
                            @endforeach

                            <!-- عرض المجموع لكل فترة زمنية -->
                            <tr style="background-color: #e9ecef;">
                                <td colspan="10"><strong>المجموع</strong></td>
                                <td><strong>{{ number_format($receiptsInPeriod->sum('amount'), 2) }}</strong></td>
                                <td><strong>{{ number_format($receiptsInPeriod->sum('tax1_amount') + $receiptsInPeriod->sum('tax2_amount'), 2) }}</strong></td>
                                <td><strong>{{ number_format($receiptsInPeriod->sum('amount') + $receiptsInPeriod->sum('tax1_amount') + $receiptsInPeriod->sum('tax2_amount'), 2) }}</strong></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Details Table -->
            <div id="detailsTable" class="hidden">
                <table class="table table-bordered table-striped">
                    <thead class="table-header">
                        <tr>
                            <th>الفترة الزمنية</th>
                            <th>المبلغ</th>
                            <th>الضرائب</th>
                            <th>الإجمالي مع الضريبة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($receipts as $receipt)
                            <tr>
                                <td>{{ $receipt->date }}</td>
                                <td>{{ number_format($receipt->amount, 2) }}</td>
                                <td>{{ number_format($receipt->tax1_amount + $receipt->tax2_amount, 2) }}</td>
                                <td>{{ number_format($receipt->amount + $receipt->tax1_amount + $receipt->tax2_amount, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script>
        // بيانات المخطط
        const chartData = {
            labels: @json($chartData['labels']), // أسماء الفترات الزمنية
            datasets: [{
                label: 'الإجمالي',
                data: @json($chartData['values']), // بيانات الإجمالي
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        };

        // إنشاء المخطط
        const ctx = document.getElementById('receiptsChart').getContext('2d');
        const receiptsChart = new Chart(ctx, {
            type: 'bar',
            data: chartData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'الإجمالي حسب الفترة الزمنية'
                    }
                }
            }
        });

        // Toggle between summary and details table visibility
        document.getElementById('summaryButton').addEventListener('click', function() {
            document.getElementById('summaryTable').classList.remove('hidden');
            document.getElementById('detailsTable').classList.add('hidden');
        });

        document.getElementById('detailsButton').addEventListener('click', function() {
            document.getElementById('detailsTable').classList.remove('hidden');
            document.getElementById('summaryTable').classList.add('hidden');
        });

        // دالة لتصدير إلى CSV
        function exportCSV() {
            const table = document.getElementById("summaryTable").getElementsByTagName('table')[0];
            const rows = table.querySelectorAll("tr");
            let csv = [];

            for (let i = 0; i < rows.length; i++) {
                const row = [],
                    cols = rows[i].querySelectorAll("td, th");
                for (let j = 0; j < cols.length; j++) {
                    row.push(cols[j].innerText);
                }
                csv.push(row.join(","));
            }

            const csvContent = "data:text/csv;charset=utf-8," + csv.join("\n");
            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "receipts_report.csv");
            document.body.appendChild(link);
            link.click();
        }

        // دالة لتصدير إلى Excel
        function exportExcel() {
            const table = document.getElementById("summaryTable").getElementsByTagName('table')[0];
            const workbook = XLSX.utils.table_to_book(table);
            XLSX.writeFile(workbook, "receipts_report.xlsx");
        }

        // دالة لتصدير إلى PDF
        function exportPDF() {
            alert("تصدير إلى PDF تم تنفيذه");
        }

        // دالة للطباعة
        function printTable() {
            window.print();
        }
    </script>
@endsection
