<!-- العنوان -->
@extends('master')

@section('title')
    تقرير حسب العميل مفصل للفواتير
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
                    <h2 class="content-header-title float-left mb-0">تقارير المبيعات</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a>
                            </li>
                            <li class="breadcrumb-item active">عرض
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">تقرير حسب العميل مفصل للفواتير</h5>
                <form class="row g-3">
                    <div class="col-md-3">
                        <label for="" class="form-label">تصنيف العميل:</label>
                        <select id="" class="form-select">
                            <option>الكل</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->trade_name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="customer" class="form-label">العميل:</label>
                        <select id="customer" class="form-select">
                            <option>الكل</option>
                            <!-- خيارات إضافية هنا -->
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="branch" class="form-label">فرع:</label>
                        <select id="branch" class="form-select">
                            <option>None selected</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">الحالة:</label>
                        <select id="status" class="form-select">
                            <option>الكل</option>
                            <!-- خيارات إضافية هنا -->
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="fromDate" class="form-label">الفترة من:</label>
                        <input type="date" id="fromDate" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label for="toDate" class="form-label">إلى:</label>
                        <input type="date" id="toDate" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label for="orderOrigin" class="form-label">منشأ الفاتورة:</label>
                        <select id="orderOrigin" class="form-select">
                            <option>الكل</option>
                            <!-- خيارات إضافية هنا -->
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="button" class="btn btn-primary w-100" onclick="showCharts()">عرض التقرير</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <div>
                        <button class="btn btn-export"><i class="fa-solid fa-file-export"></i> خيارات التصدير</button>
                        <button class="btn btn-print ms-2"><i class="fa-solid fa-print"></i> طباعة</button>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <form action="{{ route('salesReports.byCustomer') }}" method="GET" id="reportForm">
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                        id="reportTypeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        عميل
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="reportTypeDropdown">
                                        <li><button type="submit" name="report_type" value="yearly"
                                                class="dropdown-item">سنوي</button></li>
                                        <li><button type="submit" name="report_type" value="weekly"
                                                class="dropdown-item">اسبوعي</button></li>
                                        <li><button type="submit" name="report_type" value="monthly"
                                                class="dropdown-item">شهري</button></li>
                                        <li><button type="submit" name="report_type" value="daily"
                                                class="dropdown-item">يومي</button></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><button type="submit" name="report_type" value="sales_manager"
                                                class="dropdown-item">مسئول المبيعات</button></li>
                                        <li><button type="submit" name="report_type" value="employee"
                                                class="dropdown-item">الموظف</button></li>
                                    </ul>
                                </div>
                                <!-- إخفاء حقول النموذج الأخرى -->
                                <input type="hidden" name="from_date" value="{{ request('from_date') }}">
                                <input type="hidden" name="to_date" value="{{ request('to_date') }}">
                                <input type="hidden" name="customer" value="{{ request('customer') }}">
                                <input type="hidden" name="branch" value="{{ request('branch') }}">
                                <input type="hidden" name="status" value="{{ request('status') }}">
                                <input type="hidden" name="order_origin" value="{{ request('order_origin') }}">
                            </form>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-outline-secondary" id="detailsButton">
                                <i class="fa-solid fa-search"></i> التفاصيل
                            </button>
                        </div>

                        <div class="col-auto">
                            <button class="btn btn-outline-secondary" id="summaryButton">
                                <i class="fa-solid fa-clipboard"></i> الملخص
                            </button>
                        </div>


                    </div>
                </div>
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

        <div class="card mt-4" id="mainReportTable">
            <div class="card-body">
                <h6 class="card-subtitle mb-2 text-muted">
                    تقرير حسب العميل مفصل للفواتير من
                    {{ \Carbon\Carbon::parse($fromDate)->format('d/m/Y') }}
                    إلى
                    {{ \Carbon\Carbon::parse($toDate)->format('d/m/Y') }}
                </h6>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>العميل (الرقم الضريبي)</th>
                            <th>رقم</th>
                            <th>التاريخ</th>
                            <th>موظف</th>
                            <th>مدفوعة (SAR)</th>
                            <th>غير مدفوعة (SAR)</th>
                            <th>مرجع (SAR)</th>
                            <th>الإجمالي (SAR)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($groupedInvoices as $clientId => $invoices)
                            <tr class="table-secondary">
                                <td colspan="8">
                                    {{ $invoices->first()->client->trade_name ?? 'عميل ' . $clientId }}
                                    ({{ $invoices->first()->client->tax_number ?? 'غير محدد' }})
                                </td>
                            </tr>
                            @foreach ($invoices as $invoice)
                                <tr>
                                    <td></td>
                                    <td>{{ str_pad($invoice->code, 5, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}</td>
                                    <td>{{ $invoice->createdByUser->name ?? 'غير محدد' }}</td>
                                    <td>{{ number_format($invoice->payment_status == 1 ? $invoice->grand_total : $invoice->paid_amount, 2) }}
                                    </td>
                                    <td>{{ number_format($invoice->payment_status == 1 ? 0 : $invoice->due_value, 2) }}
                                    </td>
                                    <td>{{ number_format($invoice->payment_status == 5 ? $invoice->grand_total : 0, 2) }}
                                    </td>
                                    <td>{{ number_format($invoice->grand_total, 2) }}</td>
                                </tr>
                            @endforeach
                            <tr class="table-info">
                                <td colspan="4">المجموع</td>
                                <td>{{ number_format($clientTotals[$clientId]['paid_amount'], 2) }}</td>
                                <td>{{ number_format($clientTotals[$clientId]['unpaid_amount'], 2) }}</td>
                                <td>{{ number_format($clientTotals[$clientId]['returned_amount'], 2) }}</td>
                                <td>{{ number_format($clientTotals[$clientId]['total_amount'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Detailed Table (initially hidden) -->
        <div class="card mt-4" id="detailedTable" style="display: none;">
            <div class="card-body">
                <h6 class="card-subtitle mb-2 text-muted">
                    التفاصيل الكاملة للفواتير
                </h6>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>رقم الفاتورة</th>
                            <th>التاريخ</th>
                            <th>العميل</th>
                            <th>الموظف</th>
                            <th>مدفوعة</th>
                            <th>غير مدفوعة</th>
                            <th>مرتجع</th>
                            <th>الاجمالي</th>
                        </tr>
                    </thead>
                    <tbody id="detailedTableBody">
                        @foreach ($groupedInvoices as $clientId => $invoices)
                            @foreach ($invoices as $invoice)
                                <tr>
                                    <td>{{ str_pad($invoice->code, 5, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}</td>
                                    <td>{{ $invoice->client->trade_name ?? 'غير محدد' }}</td>
                                    <td>{{ $invoice->createdByUser->name ?? 'غير محدد' }}</td>
                                    <td>
                                        {{ number_format($invoice->payment_status == 1 ? $invoice->grand_total : $invoice->paid_amount, 2) }}
                                    </td>
                                    <td>
                                        {{ number_format($invoice->payment_status == 1 ? 0 : $invoice->due_value, 2) }}
                                    </td>
                                    <td>
                                        {{ number_format($invoice->payment_status == 5 ? $invoice->grand_total : 0, 2) }}
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('assets/js/report.js') }}"></script>
@endsection
