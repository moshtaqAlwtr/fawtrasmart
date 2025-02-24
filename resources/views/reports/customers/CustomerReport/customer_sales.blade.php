@extends('master')

@section('title')
    تقرير مبيعات العملاء
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">

    <link rel="stylesheet" href="{{ asset('assets/css/customer.css') }}">
@endsection

@section('content')
    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    <h2 class="content-header-title float-start mb-0">تقرير مبيعات العملاء</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                            <li class="breadcrumb-item active">عرض</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <div class="card-body">
                <form id="filterForm" method="GET" action="{{ route('ClientReport.customerSales') }}">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="date-from" class="form-label">التاريخ من:</label>
                            <input type="date" id="date-from" name="date_from" class="form-control"
                                value="{{ request('date_from', '2024-10-09') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="date-to" class="form-label">التاريخ إلى:</label>
                            <input type="date" id="date-to" name="date_to" class="form-control"
                                value="{{ request('date_to', '2024-11-09') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="client-category" class="form-label">تصنيف العميل:</label>
                            <select id="client-category" name="client_category" class="form-select">
                                <option value="">الكل</option>
                                <option value="عميل فردي">عميل فردي</option>
                                <option value="مؤسسة">مؤسسة</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="currency" class="form-label">العملة:</label>
                            <select id="currency" name="currency" class="form-select">
                                <option value="SAR">(SAR) الجمع إلى</option>
                                <option value="USD">USD</option>
                                <option value="EUR">EUR</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <label for="order-by" class="form-label">ترتيب حسب:</label>
                            <select id="order-by" name="order_by" class="form-select">
                                <option value="">الكل</option>
                                <option value="client">العميل</option>
                                <option value="branch">الفرع</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="branch" class="form-label">فرع:</label>
                            <select id="branch" name="branch" class="form-select">
                                <option value="">الكل</option>
                                <option value="main">Main Branch</option>
                                <option value="branch2">فرع 2</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="client" class="form-label">العميل:</label>
                            <select id="client" name="client" class="form-select">
                                <option value="">الكل</option>
                                @foreach ($clients ?? [] as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="status" class="form-label">حالة المتابعة:</label>
                            <select id="status" name="status" class="form-select">
                                <option value="">الكل</option>
                                <option value="active">نشط</option>
                                <option value="inactive">غير نشط</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-custom me-2">
                                <i class="fas fa-search"></i> عرض التقرير
                            </button>
                            <button type="button" id="resetFilters" class="btn btn-secondary">
                                <i class="fas fa-undo"></i> إلغاء الفلتر
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <div class="action-buttons text-end">
                    <button class="btn btn-success" onclick="window.print()"><i class="fas fa-print"></i> طباعة</button>
                    <button class="btn btn-primary" onclick="exportToExcel()"><i class="fas fa-file-excel"></i> تصدير إلى Excel</button>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="header-section">
                    <h5>مبيعات العملاء - تجميع حسب العميل</h5>
                    <p>الوقت: {{ now()->format('H:i') }} | التاريخ: {{ now()->format('d/m/Y') }}</p>
                    <p>مؤسسة أعمال خاصة للتجارة - الرياض</p>
                </div>
            </div>
        </div>
        <div class="table-container">
            <div class="table-responsive">
                @foreach ($groupedInvoices ?? [] as $clientName => $invoices)
                    <div class="client-section mb-4">
                        <h5 class="client-name mb-3" style="color: #0077b6; font-weight: 600;">{{ $clientName }}</h5>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>التاريخ</th>
                                    <th>النوع</th>
                                    <th>الاسم</th>
                                    <th>رقم المستند</th>
                                    <th>فرع</th>
                                    <th>مصاريف الشحن</th>
                                    <th>القيمة (SAR)</th>
                                    <th>الضرائب (SAR)</th>
                                    <th>المجموعات</th>
                                    <th>الإجمالي (SAR)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoices as $invoice)
                                    <tr>
                                        <td>{{ $invoice->date }}</td>
                                        <td>{{ $invoice->type }}</td>
                                        <td>{{ $invoice->client_name }}</td>
                                        <td>{{ $invoice->document_number }}</td>
                                        <td>{{ $invoice->branch }}</td>
                                        <td>{{ number_format($invoice->shipping_cost, 2) }}</td>
                                        <td>{{ number_format($invoice->value, 2) }}</td>
                                        <td>{{ number_format($invoice->taxes, 2) }}</td>
                                        <td>{{ number_format($invoice->groups, 2) }}</td>
                                        <td>{{ number_format($invoice->total, 2) }}</td>
                                    </tr>
                                @endforeach
                                <tr class="total-row">
                                    <td colspan="6">المجموع</td>
                                    <td>{{ number_format($invoices->sum('value'), 2) }}</td>
                                    <td>{{ number_format($invoices->sum('taxes'), 2) }}</td>
                                    <td>{{ number_format($invoices->sum('groups'), 2) }}</td>
                                    <td>{{ number_format($invoices->sum('total'), 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>

    <script>
        $(document).ready(function() {
            // تهيئة Select2 للقوائم المنسدلة
            $('.form-select').select2({
                dir: "rtl",
                placeholder: "اختر...",
                allowClear: true
            });

            // إعادة تعيين الفلتر
            $('#resetFilters').click(function() {
                $('#filterForm')[0].reset();
                $('.form-select').trigger('change');
                window.location.href = "{{ route('ClientReport.customerSales') }}";
            });
        });

        function printReport() {
            window.print();
        }

        function exportToCSV() {
            // تنفيذ تصدير CSV
        }

        function exportToExcel() {
            const table = document.querySelector('table');
            const workbook = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });
            XLSX.writeFile(workbook, 'دليل_العملاء.xlsx');
        }

        function exportToPDF() {
            // تنفيذ تصدير PDF
        }
    </script>
@endsection
