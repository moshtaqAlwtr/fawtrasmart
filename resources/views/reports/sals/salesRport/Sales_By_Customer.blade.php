@extends('master')

@section('title')
    تقرير المبيعات حسب العميل
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/report.css') }}">
    <style>
        .table-return {
            background-color: #fff3f3 !important;
        }
        .text-return {
            color: #dc3545 !important;
        }
        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
@endsection

@section('content')
<div class="container-fluid px-4">
    {{-- Page Header --}}
    <div class="content-header row mb-3">
        <div class="content-header-left col-md-9 col-12">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-start mb-0">تقارير مبيعات العملاء</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                            <li class="breadcrumb-item active">تقرير المبيعات</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters Card --}}
    <div class="card mb-3">
        <div class="card-body">
            <form action="{{ route('salesReports.byCustomer') }}" method="GET" id="reportForm">
                <div class="row g-3">
                    {{-- First Row of Filters --}}
                    <div class="col-md-3">
                        <label class="form-label">العميل</label>
                        <select name="customer" class="form-select">
                            <option value="">جميع العملاء</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}"
                                    {{ request('customer') == $client->id ? 'selected' : '' }}>
                                    {{ $client->trade_name }}
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

                    <div class="col-md-3 align-self-end">
                        <button type="submit" class="btn btn-primary w-80">
                            <i class="fas fa-filter me-2"></i> تصفية التقرير
                        </button>
                        <a href="{{ route('salesReports.byCustomer') }}" class="btn btn-primary w-20">
                            <i class="fas fa-filter me-2"></i> الغاء الفلتر
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="card mb-3 no-print">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <a href="{{ route('salesReports.exportByCustomerToExcel', request()->query()) }}"
                   class="btn btn-success me-2" id="exportBtn">
                    <i class="fas fa-file-export me-2"></i> تصدير
                </a>
                <button class="btn btn-info" id="printBtn">
                    <i class="fas fa-print me-2"></i> طباعة
                </button>
            </div>

            <div class="d-flex align-items-center">
                {{-- View Toggles --}}
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-primary active" id="summaryViewBtn">
                        <i class="fas fa-chart-pie me-2"></i> ملخص
                    </button>
                    <button type="button" class="btn btn-outline-primary" id="detailViewBtn">
                        <i class="fas fa-list me-2"></i> تفاصيل
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Totals Summary --}}
    {{-- <div class="row">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h5>إجمالي المبيعات</h5>
                    <h3>{{ number_format($totals['total_amount'], 2) }} SAR</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h5>المبالغ المدفوعة</h5>
                    <h3>{{ number_format($totals['paid_amount'], 2) }} SAR</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <h5>المبالغ غير المدفوعة</h5>
                    <h3>{{ number_format($totals['unpaid_amount'], 2) }} SAR</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body text-center">
                    <h5>المبالغ المرتجعة</h5>
                    <h3>{{ number_format($totals['returned_amount'], 2) }} SAR</h3>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- Main Report Table --}}
    <div class="card mt-3" id="mainReportTable">
        <div class="card-header">
            <h5 class="card-title">
                تقرير المبيعات من {{ $fromDate->format('d/m/Y') }} إلى {{ $toDate->format('d/m/Y') }}
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
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
                            <th>العميل</th>
                            <th>رقم الفاتورة</th>
                            <th>الموضف</th>
                            <th>مدفوعة (SAR)</th>
                            <th>غير مدفوعة (SAR)</th>
                            <th>مرتجع (SAR)</th>
                            <th>الإجمالي (SAR)</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Initialize grand totals --}}
                        @php
                            $grandPaidTotal = 0;
                            $grandUnpaidTotal = 0;
                            $grandReturnedTotal = 0;
                            $grandOverallTotal = 0;
                        @endphp

                        @foreach ($groupedInvoices as $clientId => $invoices)
                            {{-- Client Group Header --}}
                            <tr class="table-secondary">
                                <td colspan="8">
                                    {{ $invoices->first()->client->trade_name ?? 'عميل ' . $clientId }}
                                </td>
                            </tr>

                            {{-- Initialize totals for each client --}}
                            @php
                                $clientPaidTotal = 0;
                                $clientUnpaidTotal = 0;
                                $clientReturnedTotal = 0;
                                $clientOverallTotal = 0;
                            @endphp

                            {{-- Invoices for this client --}}
                            @foreach ($invoices as $invoice)
                                <tr class="{{ in_array($invoice->type, ['return', 'returned']) ? 'table-return text-return' : '' }}">
                                    <td>
                                        @switch($reportPeriod)
                                            @case('daily')
                                                {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}
                                            @break
                                            @case('weekly')
                                                الأسبوع {{ \Carbon\Carbon::parse($invoice->invoice_date)->weekOfYear }}
                                                ({{ \Carbon\Carbon::parse($invoice->invoice_date)->startOfWeek()->format('d/m/Y') }}
                                                - {{ \Carbon\Carbon::parse($invoice->invoice_date)->endOfWeek()->format('d/m/Y') }})
                                            @break
                                            @case('monthly')
                                                {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('m/Y') }}
                                            @break
                                            @case('yearly')
                                                {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('Y') }}
                                            @break
                                            @default
                                                {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}
                                        @endswitch
                                    </td>
                                    <td>{{ $invoice->client->trade_name ?? 'عميل ' . $clientId }}</td>
                                    <td>{{ str_pad($invoice->code, 5, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ $invoice->employee->full_name ?? 'غير محدد' }}</td>

                                    @php
                                        // Calculate total paid amount
                                        $paidAmount = $invoice->payments->sum('amount');
                                        $remainingAmount = $invoice->grand_total - $paidAmount;
                                    @endphp

                                    @if (in_array($invoice->type, ['return', 'returned']))
                                        <td>-</td>
                                        <td>-</td>
                                        <td class="text-return">
                                            {{ number_format($invoice->grand_total, 2) }}
                                        </td>
                                        <td class="text-return">
                                            {{ number_format($invoice->grand_total, 2) }}
                                        </td>

                                        @php
                                            $clientReturnedTotal += $invoice->grand_total;
                                            $grandReturnedTotal += $invoice->grand_total;
                                        @endphp
                                    @else
                                        <td>
                                            {{ number_format($paidAmount, 2) }}
                                        </td>
                                        <td>
                                            {{ number_format($remainingAmount > 0 ? $remainingAmount : 0, 2) }}
                                        </td>
                                        <td>-</td>
                                        <td>{{ number_format($invoice->grand_total, 2) }}</td>

                                        @php
                                            $clientPaidTotal += $paidAmount;
                                            $clientUnpaidTotal += max($remainingAmount, 0);
                                            $grandPaidTotal += $paidAmount;
                                            $grandUnpaidTotal += max($remainingAmount, 0);
                                            $clientOverallTotal += $invoice->grand_total;
                                            $grandOverallTotal += $invoice->grand_total;
                                        @endphp
                                    @endif
                                </tr>
                            @endforeach

                            {{-- Client Total Summary Row --}}
                            <tr class="table-info">
                                <td colspan="4">مجموع العميل</td>
                                <td>{{ number_format($clientPaidTotal, 2) }}</td>
                                <td>{{ number_format($clientUnpaidTotal, 2) }}</td>
                                <td>{{ number_format($clientReturnedTotal, 2) }}</td>
                                <td>{{ number_format($clientPaidTotal + $clientUnpaidTotal + $clientReturnedTotal, 2) }}</td>
                            </tr>
                        @endforeach

                        {{-- Grand Total Row --}}
                        <tr class="table-dark">
                            <td colspan="4">المجموع الكلي</td>
                            <td>{{ number_format($grandPaidTotal, 2) }}</td>
                            <td>{{ number_format($grandUnpaidTotal, 2) }}</td>
                            <td>{{ number_format($grandReturnedTotal, 2) }}</td>
                            <td>{{ number_format($grandPaidTotal + $grandUnpaidTotal + $grandReturnedTotal, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Detailed Report Table --}}
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
                        <th>العميل</th>
                        <th>الموضف</th>
                        <th>مدفوعة (SAR)</th>
                        <th>غير مدفوعة (SAR)</th>
                        <th>مرتجع (SAR)</th>
                        <th>الإجمالي (SAR)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($groupedInvoices as $clientId => $invoices)
                        @foreach ($invoices as $invoice)
                            <tr>
                                <td>
                                    @switch($reportPeriod)
                                        @case('daily')
                                            {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}
                                        @break
                                        @case('weekly')
                                            الأسبوع {{ \Carbon\Carbon::parse($invoice->invoice_date)->weekOfYear }}
                                            ({{ \Carbon\Carbon::parse($invoice->invoice_date)->startOfWeek()->format('d/m/Y') }}
                                            - {{ \Carbon\Carbon::parse($invoice->invoice_date)->endOfWeek()->format('d/m/Y') }})
                                        @break
                                        @case('monthly')
                                            {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('m/Y') }}
                                        @break
                                        @case('yearly')
                                            {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('Y') }}
                                        @break
                                        @default
                                            {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}
                                    @endswitch
                                </td>
                                <td>{{ str_pad($invoice->code, 5, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $invoice->client->trade_name ?? 'غير محدد' }}</td>
                                <td>{{ $invoice->user->name ?? 'غير محدد' }}</td>
                                <td>
                                    {{ number_format($invoice->payment_status == 1 ? $invoice->grand_total : $invoice->paid_amount, 2) }}
                                </td>
                                <td>
                                    {{ number_format($invoice->payment_status == 1 ? 0 : $invoice->due_value, 2) }}
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // View Toggle Functionality
    const summaryViewBtn = document.getElementById('summaryViewBtn');
    const detailViewBtn = document.getElementById('detailViewBtn');
    const mainReportTable = document.getElementById('mainReportTable');
    const detailedReportTable = document.getElementById('detailedReportTable');

    // Function to reset view
    function resetView() {
        mainReportTable.style.display = 'none';
        detailedReportTable.style.display = 'none';

        summaryViewBtn.classList.remove('active');
        detailViewBtn.classList.remove('active');
    }

    // Initially show main report table
    mainReportTable.style.display = 'block';
    summaryViewBtn.classList.add('active');

    // Summary View Handler
    summaryViewBtn.addEventListener('click', function() {
        resetView();

        summaryViewBtn.classList.add('active');
        mainReportTable.style.display = 'block';
    });

    // Detailed View Handler
    detailViewBtn.addEventListener('click', function() {
        resetView();

        detailViewBtn.classList.add('active');
        detailedReportTable.style.display = 'block';
    });

    // Print Functionality
    document.getElementById('printBtn').addEventListener('click', function() {
        window.print();
    });
});
</script>
@endsection
