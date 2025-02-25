@extends('master')

@section('title')
    تقرير المشتريات بحسب الموردين
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
            <h3>تقرير المشتريات بحسب الموردين</h3>
        </div>

        {{-- Filter Section --}}
        <div class="card-body">
            <div class="filter-card">
                <form action="{{ route('ReportsPurchases.bySupplier') }}" method="GET" id="reportForm">
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
            <a href="{{ route('ReportsPurchases.bySupplier') }}" class="btn btn-primary w-20">
                <i class="fas fa-filter me-2"></i> الغاء الفلتر
            </a>
        </div>
    </div>
</div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Purchase Report Table --}}
        <div class="card-body">
            <div class="table-responsive">
                <table id="purchaseReportTable" class="table table-bordered table-striped">
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
                            <th>المورد</th>
                            <th>رقم الفاتورة</th>
                            <th>الموظف</th>
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

                        @foreach ($groupedPurchaseInvoices as $supplierId => $invoices)
                            {{-- Supplier Group Header --}}
                            <tr class="table-secondary">
                                <td colspan="8">
                                    {{ $invoices->first()->supplier->trade_name ?? 'مورد ' . $supplierId }}
                                </td>
                            </tr>

                            {{-- Initialize totals for each supplier --}}
                            @php
                                $supplierPaidTotal = 0;
                                $supplierUnpaidTotal = 0;
                                $supplierReturnedTotal = 0;
                                $supplierOverallTotal = 0;
                            @endphp

                            {{-- Invoices for this supplier --}}
                            @foreach ($invoices as $invoice)
                                <tr class="{{ in_array($invoice->type, ['return', 'returned']) ? 'table-return text-return' : '' }}">
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
                                    <td>{{ $invoice->supplier->trade_name ?? 'مورد ' . $supplierId }}</td>
                                    <td>{{ str_pad($invoice->code, 5, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ $invoice->createdByUser->name ?? 'غير محدد' }}</td>

                                    @php
                                        // Calculate total paid amount
                                        $paidAmount = $invoice->payments_process->sum('amount');
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
                                            $supplierReturnedTotal += $invoice->grand_total;
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
                                            $supplierPaidTotal += $paidAmount;
                                            $supplierUnpaidTotal += max($remainingAmount, 0);
                                            $grandPaidTotal += $paidAmount;
                                            $grandUnpaidTotal += max($remainingAmount, 0);
                                            $supplierOverallTotal += $invoice->grand_total;
                                            $grandOverallTotal += $invoice->grand_total;
                                        @endphp
                                    @endif
                                </tr>
                            @endforeach

                            {{-- Supplier Total Summary Row --}}
                            <tr class="table-info">
                                <td colspan="4">مجموع المورد</td>
                                <td>{{ number_format($supplierPaidTotal, 2) }}</td>
                                <td>{{ number_format($supplierUnpaidTotal, 2) }}</td>
                                <td>{{ number_format($supplierReturnedTotal, 2) }}</td>
                                <td>{{ number_format($supplierPaidTotal + $supplierUnpaidTotal + $supplierReturnedTotal, 2) }}</td>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
<script>
    $(document).ready(function() {
        // Excel Export
        $('#exportExcel').on('click', function() {
            // Get the table
            const table = document.getElementById('purchaseReportTable');

            // Create a new workbook and worksheet
            const wb = XLSX.utils.table_to_book(table, {
                raw: true,
                cellDates: true
            });

            // Generate file name with current date
            const today = new Date();
            const fileName = `تقرير_المشتريات_${today.getFullYear()}-${today.getMonth() + 1}-${today.getDate()}.xlsx`;

            // Export the workbook
            XLSX.writeFile(wb, fileName);
        });
    });
</script>
@endsection
