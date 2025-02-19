@extends('master')

@section('title')
    تقرير المبيعات حسب مسئول المبيعات
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/report.css') }}">
@endsection

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">تقرير المبيعات حسب مسئول المبيعات</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                            <li class="breadcrumb-item active">تقرير المبيعات</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        {{-- Filter Card --}}
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">فلترة التقرير</h5>
                <form action="{{ route('salesReports.byEmployee') }}" method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label for="employee" class="form-label">الموظف:</label>
                        <select id="employee" name="employee" class="form-select">
                            <option value="">الكل</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}"
                                    {{ request('employee') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="branch" class="form-label">الفرع:</label>
                        <select id="branch" name="branch" class="form-select">
                            <option value="">الكل</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}"
                                    {{ request('branch') == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="status" class="form-label">حالة الدفع:</label>
                        <select id="status" name="status" class="form-select">
                            <option value="">الكل</option>
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>مدفوعة</option>
                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>غير مدفوعة</option>
                            <option value="5" {{ request('status') == '5' ? 'selected' : '' }}>مرتجعة</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="fromDate" class="form-label">من تاريخ:</label>
                        <input type="date" id="fromDate" name="from_date" class="form-control"
                               value="{{ request('from_date') ?? now()->subMonth()->format('Y-m-d') }}">
                    </div>

                    <div class="col-md-3">
                        <label for="toDate" class="form-label">إلى تاريخ:</label>
                        <input type="date" id="toDate" name="to_date" class="form-control"
                               value="{{ request('to_date') ?? now()->format('Y-m-d') }}">
                    </div>

                    <div class="col-md-3">
                        <label for="orderOrigin" class="form-label">منشأ الفاتورة:</label>
                        <select id="orderOrigin" name="order_origin" class="form-select">
                            <option value="">الكل</option>
                            <option value="sales" {{ request('order_origin') == 'sales' ? 'selected' : '' }}>مبيعات</option>
                            <option value="return" {{ request('order_origin') == 'return' ? 'selected' : '' }}>مرتجعات</option>
                        </select>
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fa-solid fa-filter"></i> عرض التقرير
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Action Buttons Card --}}
        <div class="card mt-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <button class="btn btn-export me-2">
                            <i class="fa-solid fa-file-export"></i> تصدير
                        </button>
                        <button class="btn btn-print">
                            <i class="fa-solid fa-print"></i> طباعة
                        </button>
                    </div>

                    <div class="d-flex align-items-center">
                        {{-- Report Type Dropdown --}}
                        <div class="dropdown me-2">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                    id="reportTypeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                نوع التقرير
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="reportTypeDropdown">
                                <li><a class="dropdown-item" href="#"
                                       onclick="updateReportType('yearly')">سنوي</a></li>
                                <li><a class="dropdown-item" href="#"
                                       onclick="updateReportType('monthly')">شهري</a></li>
                                <li><a class="dropdown-item" href="#"
                                       onclick="updateReportType('weekly')">أسبوعي</a></li>
                                <li><a class="dropdown-item" href="#"
                                       onclick="updateReportType('daily')">يومي</a></li>
                            </ul>
                        </div>

                        {{-- View Toggle Buttons --}}
                        <button class="btn btn-outline-secondary me-2" id="summaryButton">
                            <i class="fa-solid fa-clipboard"></i> الملخص
                        </button>
                        <button class="btn btn-outline-secondary" id="detailsButton">
                            <i class="fa-solid fa-search"></i> التفاصيل
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Charts Container --}}
        <div id="charts-container" class="mt-3" style="display: none;">
            <div class="row">
                <div class="col-md-6">
                    <canvas id="pieChart"></canvas>
                </div>
                <div class="col-md-6">
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Main Report Table --}}
        <div class="card mt-4" id="mainReportTable">
            <div class="card-body">
                <h6 class="card-subtitle mb-2 text-muted">
                    تقرير المبيعات حسب الموظف من
                    {{ \Carbon\Carbon::parse($fromDate)->format('d/m/Y') }}
                    إلى
                    {{ \Carbon\Carbon::parse($toDate)->format('d/m/Y') }}
                </h6>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>الموظف (الرقم الوظيفي)</th>
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
                        @foreach ($groupedInvoices as $employeeId => $invoices)
                            <tr class="table-secondary">
                                <td colspan="8">
                                    {{ $invoices->first()->createdByUser->name ?? 'موظف ' . $employeeId }}
                                    ({{ $invoices->first()->createdByUser->phone ?? 'غير محدد' }})
                                </td>
                            </tr>
                            @foreach ($invoices as $invoice)
                                <tr>
                                    <td></td>
                                    <td>{{ str_pad($invoice->code, 5, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}</td>
                                    <td>{{ $invoice->client->trade_name ?? 'غير محدد' }}</td>
                                    <td>{{ number_format($invoice->payment_status == 1 ? $invoice->grand_total : $invoice->paid_amount, 2) }}</td>
                                    <td>{{ number_format($invoice->payment_status == 1 ? 0 : $invoice->due_value, 2) }}</td>
                                    <td>{{ number_format($invoice->payment_status == 5 ? $invoice->grand_total : 0, 2) }}</td>
                                    <td>{{ number_format($invoice->grand_total, 2) }}</td>
                                </tr>
                            @endforeach
                            <tr class="table-info">
                                <td colspan="4">المجموع</td>
                                <td>{{ number_format($employeeTotals[$employeeId]['paid_amount'], 2) }}</td>
                                <td>{{ number_format($employeeTotals[$employeeId]['unpaid_amount'], 2) }}</td>
                                <td>{{ number_format($employeeTotals[$employeeId]['returned_amount'], 2) }}</td>
                                <td>{{ number_format($employeeTotals[$employeeId]['total_amount'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Detailed Report Table --}}
        <div class="card mt-3" id="detailedTable" style="display: none;">
            <div class="card-body">
                <h6 class="card-subtitle mb-3 text-muted">
                    التفاصيل الكاملة للفواتير
                </h6>

                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>الموظف</th>
                            <th>رقم الفاتورة</th>
                            <th>التاريخ</th>
                            <th>العميل</th>
                            <th>مدفوعة (SAR)</th>
                            <th>غير مدفوعة (SAR)</th>
                            <th>مرتجعة (SAR)</th>
                            <th>الإجمالي (SAR)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($groupedInvoices as $employeeId => $invoices)
                            @foreach ($invoices as $invoice)
                                <tr>
                                    <td>{{ $invoice->createdByUser->name ?? 'موظف ' . $employeeId }}</td>
                                    <td>{{ str_pad($invoice->code, 5, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}</td>
                                    <td>{{ $invoice->client->trade_name ?? 'غير محدد' }}</td>
                                    <td>{{ number_format($invoice->payment_status == 1 ? $invoice->grand_total : $invoice->paid_amount, 2) }}</td>
                                    <td>{{ number_format($invoice->payment_status == 1 ? 0 : $invoice->due_value, 2) }}</td>
                                    <td>{{ number_format($invoice->payment_status == 5 ? $invoice->grand_total : 0, 2) }}</td>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/js/report.js') }}"></script>
@endsection

