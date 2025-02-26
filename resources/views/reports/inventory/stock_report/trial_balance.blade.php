@extends('master')

@section('title')
    تقرير ميزان المراجعة
@stop

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/report.css') }}">
@endsection

@section('content')
    <div class="content-header row mb-3">
        <div class="content-header-left col-md-9 col-12 d-flex align-items-center">
            <div class="row breadcrumbs-top flex-grow-1">
                <div class="col-12 d-flex align-items-center">
                    <h2 class="content-header-title mb-0 me-3">تقرير ميزان المراجعة </h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                            <li class="breadcrumb-item active">عرض</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">تقرير ميزان المراجعة </div>
        <div class="card-body">
            <form id="inventoryForm" method="GET" action="{{ route('StorHouseReport.trialBalance') }}">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="start_date" class="form-label">من تاريخ</label>
                        <input type="date" id="start_date" name="start_date" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label for="end_date" class="form-label">إلى تاريخ</label>
                        <input type="date" id="end_date" name="end_date" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label for="product" class="form-label">المنتج</label>
                        <select id="product" name="product" class="custom-select">
                            <option value="">اختر المنتج</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="category" class="form-label">التصنيف</label>
                        <select id="category" name="category" class="custom-select">
                            <option value="">الكل</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="warehouse" class="form-label">المستودع</label>
                        <select id="warehouse" name="warehouse" class="custom-select">
                            <option value="">كل المخزن</option>
                            @foreach ($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">عرض التقرير</button>
                    <a href="{{ route('StorHouseReport.trialBalance') }}" class="btn btn-secondary"
                        id="resetFilter">إلغاء الفلترة</a>
                    <button type="button" class="btn btn-export" id="exportExcel">تصدير Excel</button>
                    <button type="button" class="btn btn-export" id="exportPDF">تصدير PDF</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="card-header"> تقرير ميزان المراجعة </div>

            <div class="table-responsive">
                <table id="inventoryTable" class="table table-bordered table-striped text-center">
                    <thead>
                        <tr class="report-results-head">
                            <th class="text-center v-middle" rowspan="2">الكود</th>
                            <th class="text-center v-middle" rowspan="2">باركود</th>
                            <th class="text-center v-middle" rowspan="2">الاسم</th>
                            <th class="text-center v-middle" colspan="2">قبل</th>
                            <th class="text-center v-middle" colspan="2">الوارد</th>
                            <th class="text-center v-middle" colspan="2">المنصرف</th>
                            <th class="text-center v-middle" colspan="2">الصافى</th>
                        </tr>
                        <tr class='report-results-head'>
                            <th class="text-center v-middle">الكمية</th>
                            <th class="text-center v-middle">المبلغ</th>
                            <th class="text-center v-middle">الكمية</th>
                            <th class="text-center v-middle">المبلغ</th>
                            <th class="text-center v-middle">الكمية</th>
                            <th class="text-center v-middle">المبلغ</th>
                            <th class="text-center v-middle">الكمية</th>
                            <th class="text-center v-middle">المبلغ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalInitialQuantity = 0;
                            $totalInitialAmount = 0;
                            $totalIncomingQuantity = 0;
                            $totalIncomingAmount = 0;
                            $totalOutgoingQuantity = 0;
                            $totalOutgoingAmount = 0;
                            $totalNetQuantity = 0;
                            $totalNetAmount = 0;
                        @endphp

                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->barcode }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->initial_quantity }}</td>
                                <td>{{ $product->initial_amount }}</td>
                                <td>{{ $product->incoming_quantity }}</td>
                                <td>{{ $product->incoming_amount }}</td>
                                <td>{{ $product->outgoing_quantity }}</td>
                                <td>{{ $product->outgoing_amount }}</td>
                                <td>{{ $product->net_quantity }}</td>
                                <td>{{ $product->net_amount }}</td>
                            </tr>

                            @php
                                $totalInitialQuantity += $product->initial_quantity;
                                $totalInitialAmount += $product->initial_amount;
                                $totalIncomingQuantity += $product->incoming_quantity;
                                $totalIncomingAmount += $product->incoming_amount;
                                $totalOutgoingQuantity += $product->outgoing_quantity;
                                $totalOutgoingAmount += $product->outgoing_amount;
                                $totalNetQuantity += $product->net_quantity;
                                $totalNetAmount += $product->net_amount;
                            @endphp
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-center">الإجمالي</th>
                            <th>{{ $totalInitialQuantity }}</th>
                            <th>{{ $totalInitialAmount }}</th>
                            <th>{{ $totalIncomingQuantity }}</th>
                            <th>{{ $totalIncomingAmount }}</th>
                            <th>{{ $totalOutgoingQuantity }}</th>
                            <th>{{ $totalOutgoingAmount }}</th>
                            <th>{{ $totalNetQuantity }}</th>
                            <th>{{ $totalNetAmount }}</th>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const table = document.querySelector('.table');
        const resetFilterButton = document.getElementById('resetFilter');
        const exportExcelButton = document.getElementById('exportExcel');
        const exportPDFButton = document.getElementById('exportPDF');

        // Reset Filter
        resetFilterButton.addEventListener('click', function() {
            document.getElementById('start_date').value = '';
            document.getElementById('end_date').value = '';
            document.getElementById('product').value = '';
            document.getElementById('category').value = '';
            document.getElementById('warehouse').value = '';
            document.querySelector('form').submit();
        });

        // Export to Excel
        exportExcelButton.addEventListener('click', function() {
            const wb = XLSX.utils.table_to_book(table, {
                sheet: "Sheet JS"
            });
            XLSX.writeFile(wb, 'trial_balance.xlsx');
        });

        // Export to PDF
        exportPDFButton.addEventListener('click', function() {
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF();

            doc.autoTable({
                html: table
            });
            doc.save('trial_balance.pdf');
        });
    });
</script>
@endsection
