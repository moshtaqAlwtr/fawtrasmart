@extends('master')

@section('title')
    تقرير القيود
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
                    <h2 class="content-header-title float-left mb-0">تقرير القيود</h2>
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
            <form action="{{ route('GeneralAccountReports.ReportJournal') }}" method="GET">
                <div class="row g-3 align-items-center">
                    <!-- فلترة حسب المصدر -->
                    <div class="col-md-3">
                        <label for="inputTaxType" class="form-label">المصدر :</label>
                        <select class="form-control" id="inputTaxType" name="treasury">
                            <option value="">الكل</option>
                            <option value="0">قيد يدوي</option>
                            <option value="invoice">فاتورة</option>
                            <option value="requisition">إذن مخزن</option>
                            <option value="stock_transaction">عملية مخزون</option>
                            <option value="invoice_payment">مدفوعات الفواتير</option>
                            <option value="income">سندات القبض</option>
                            <option value="sales_cost">تكلفة مبيعات الفواتير</option>
                            <option value="refund_receipt">فاتورة مرتجعة</option>
                            <option value="expense">مصروف</option>
                            <option value="stock_transfer">حركة مخزون</option>
                            <option value="purchase_refund">مرتجع مشتريات</option>
                            <option value="asset">أصل</option>
                            <option value="asset_operation">عملية أصل</option>
                            <option value="asset_deprecation">إهلاك الأصل</option>
                            <option value="treasury_transfer">تحويل خزينة</option>
                            <option value="credit_note">إشعار دائن</option>
                            <option value="asset_write_off">شطب الأصول</option>
                            <option value="asset_re_evaluate">إعادة تقدير أصل</option>
                            <option value="asset_sell">بيع أصل</option>
                            <option value="pay_run">مسير الراتب</option>
                            <option value="delivered_pay_cheque">إستلام شيك مدفوع</option>
                            <option value="rejected_pay_cheque">رفض شيك مدفوع</option>
                            <option value="collected_pay_cheque">تحصيل شيك مدفوع</option>
                            <option value="receivable_cheque_received">إستلام شيك</option>
                            <option value="receivable_cheque_deposited">إيداع شيك</option>
                            <option value="receivable_cheque_collected">تحصيل شيك مستلم</option>
                            <option value="receivable_cheque_deposit_collected">تحصيل وديعة شيك</option>
                            <option value="receivable_cheque_reject">رفض شيك مستلم</option>
                            <option value="receivable_cheque_deposit_rejected">رفض وديعة شيك</option>
                            <option value="product_cost_sales">Product Sales Cost</option>
                            <option value="purchase_order_payment">دفع فاتورة الشراء</option>
                            <option value="purchase_order">فاتورة شراء</option>
                            <option value="pos_shift_validate">POS Shift Validation</option>
                            <option value="pos_shift_refund">POS Shift Refund</option>
                            <option value="pos_shift_sales">POS Shift Sales</option>
                            <option value="pos_shift_transaction">POS Shift Transaction</option>
                        </select>
                    </div>

                    <!-- فلترة حسب الحساب الفرعي -->
                    <div class="col-md-3">
                        <label for="inputTaxType" class="form-label">الحساب الفرعي :</label>
                        <select class="form-control" id="inputTaxType" name="account">
                            <option value="">اختر الحساب</option>
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}" {{ request('account') == $account->id ? 'selected' : '' }}>
                                    {{ $account->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- فلترة حسب الفترة من -->
                    <div class="col-md-3">
                        <label for="inputDateFrom" class="form-label">الفترة من:</label>
                        <input type="date" class="form-control" id="inputDateFrom" name="from_date" value="{{ request('from_date') }}">
                    </div>

                    <!-- فلترة حسب الفترة إلى -->
                    <div class="col-md-3">
                        <label for="inputDateFrom" class="form-label">الفترة إلى:</label>
                        <input type="date" class="form-control" id="inputDateFrom" name="to_date" value="{{ request('to_date') }}">
                    </div>

                    <!-- فلترة حسب أمر التوريد -->
                    <div class="col-md-3">
                        <label for="inputCurrency" class="form-label">امر التوريد:</label>
                        <select class="form-control" id="inputCurrency" name="supply">
                            <option value="all" {{ request('supply') == 'all' ? 'selected' : '' }}>اختر امر توريد</option>
                            @foreach ($supplyOrders as $supply)
                                <option value="{{ $supply->id }}" {{ request('supply') == $supply->id ? 'selected' : '' }}>
                                    {{ $supply->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- فلترة حسب الفرع -->
                    <div class="col-md-3">
                        <label for="inputCurrency" class="form-label">الفرع:</label>
                        <select class="form-control" id="inputCurrency" name="branch">
                            <option value="all" {{ request('branch') == 'all' ? 'selected' : '' }}>كل الفروع</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}" {{ request('branch') == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- زر عرض التقرير -->
                    <div class="col-md-12 text-center mt-3">
                        <button type="submit" class="btn btn-custom">عرض التقرير</button>
                        <a href="{{ route('GeneralAccountReports.ReportJournal') }}" class="btn btn-custom">الغاء الفلتر</a>
                    </div>
                </div>
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

            <div id="summaryTable">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr class="report-results-head">
                            <th class="date-column">التاريخ</th>
                            <th class="number-column">رقم</th>
                            <th class="name-column">الحساب</th>
                            <th class="code-column">كود الحساب</th>
                            <th class="description-column">الوصف</th>
                            <th class="entity_type-column">المصدر</th>
                            <th class="branch-column">فرع</th>
                            <th class="debit-column">مدين</th>
                            <th class="credit-column">دائن</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($journalEntries as $entry)
                            <!-- عنوان القيد -->
                            <tr class="entry-header">
                                <td colspan="9" class="text-center bg-light">
                                    <strong>القيد رقم: {{ $entry->reference_number }}</strong>
                                </td>
                            </tr>

                            <!-- تفاصيل القيد -->
                            @foreach ($entry->details as $detail)
                                <tr>
                                    <td>{{ $entry->date }}</td>
                                    <td>{{ $entry->reference_number }}</td>
                                    <td>{{ optional($detail->account)->name ?? 'N/A' }}</td>
                                    <td>{{ optional($detail->account)->code ?? 'N/A' }}</td>
                                    <td>{{ $detail->description }}</td>
                                    <td>{{ $entry->entity_type }}</td>
                                    <td>{{ optional($entry->branch)->name ?? 'N/A' }}</td>
                                    <td>{{ $detail->debit }}</td>
                                    <td>{{ $detail->credit }}</td>
                                </tr>
                            @endforeach

                            <!-- المجموع لكل قيد -->
                            <tr class="entry-total">
                                <td colspan="7" class="text-right"><strong>المجموع</strong></td>
                                <td><strong>{{ $entry->total_debit }}</strong></td>
                                <td><strong>{{ $entry->total_credit }}</strong></td>
                            </tr>

                            <!-- فاصل بين القيود -->
                            <tr>
                                <td colspan="9" class="bg-light"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Details Table -->
            <div id="detailsTable" class="hidden">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr class="report-results-head">
                            <th class="date-column">التاريخ</th>
                            <th class="number-column">رقم</th>
                            <th class="description-column">الوصف</th>
                            <th class="entity_type-column">المصدر</th>
                            <th class="branch-column">فرع</th>
                            <th class="total_debit-column">مدين</th>
                            <th class="total_credit-column">دائن</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($journalEntries as $entry)
                            @foreach ($entry->details as $detail)
                                <tr>
                                    <td>{{ $entry->date }}</td>
                                    <td>{{ $entry->reference_number }}</td>
                                    <td>{{ $detail->description }}</td>
                                    <td>{{ $entry->entity_type }}</td>
                                    <td>{{ optional($entry->branch)->name ?? 'N/A' }}</td>
                                    <td>{{ $detail->debit }}</td>
                                    <td>{{ $detail->credit }}</td>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script>
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
