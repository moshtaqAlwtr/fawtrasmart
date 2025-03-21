@extends('master')

@section('title')
    تقرير الاقرار الضريبي
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/customer.css') }}">
    <style>
        @media (max-width: 768px) {
            .col-md-3 {
                margin-bottom: 1rem;
            }
        }
        .btn-custom {
            margin: 5px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
    </style>
@endsection

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">تقرير الاقرار الضريبي</h2>
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
<div class="card">
    <div class="card-body">
        <form action="{{ route('GeneralAccountReports.taxDeclaration') }}" method="GET">
            <div class="row">
                <div class="col-md-3">
                    <label for="tax_type" class="form-label">الضرائب</label>
                    <select id="tax_type" name="tax_type" class="form-control">
                        <option value="">كل الضرائب</option>
                        <option value="مضافة" {{ request('tax_type') == 'مضافة' ? 'selected' : '' }}>مضافة</option>
                        <option value="القيمة الصفرية" {{ request('tax_type') == 'القيمة الصفرية' ? 'selected' : '' }}>القيمة الصفرية</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="income_type" class="form-label">نوعية الدخل: </label>
                    <select id="income_type" name="income_type" class="form-control">
                        <option value="">الكل</option>
                        <option value="مستحقة" {{ request('income_type') == 'مستحقة' ? 'selected' : '' }}>تم اصدارها(مستحقة)</option>
                        <option value="مدفوع بالكامل" {{ request('income_type') == 'مدفوع بالكامل' ? 'selected' : '' }}>مدفوع بالكامل</option>
                        <option value="مدفوع جزئيا" {{ request('income_type') == 'مدفوع جزئيا' ? 'selected' : '' }}>مدفوع جزئيا(نقدا)</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="dateRangeDropdown" class="form-label me-2">الفترة:</label>
                    <div class="d-flex align-items-center">
                        <div class="dropdown me-2">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                id="dateRangeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                اختر الفترة
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dateRangeDropdown">
                                <li><a class="dropdown-item" href="#" onclick="setDateRange('الأسبوع الماضي')">الأسبوع الماضي</a></li>
                                <li><a class="dropdown-item" href="#" onclick="setDateRange('الشهر الأخير')">الشهر الأخير</a></li>
                                <li><a class="dropdown-item" href="#" onclick="setDateRange('من أول الشهر حتى اليوم')">من أول الشهر حتى اليوم</a></li>
                                <li><a class="dropdown-item" href="#" onclick="setDateRange('السنة الماضية')">السنة الماضية</a></li>
                                <li><a class="dropdown-item" href="#" onclick="setDateRange('من أول السنة حتى اليوم')">من أول السنة حتى اليوم</a></li>
                            </ul>
                        </div>
                        <input type="text" class="form-control" id="selectedDateRange" name="dateRange" placeholder="الفترة المحددة" readonly value="{{ request('dateRange') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="currency" class="form-label">العملة: </label>
                    <select id="currency" name="currency" class="form-control">
                        <option value="الجميع" {{ request('currency') == 'الجميع' ? 'selected' : '' }}>الجميع الى (SAR)</option>
                        <option value="SAR" {{ request('currency') == 'SAR' ? 'selected' : '' }}>SAR</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="branch" class="form-label">فرع الحسابات:</label>
                    <select id="branch" name="branch" class="form-control">
                        <option value="">كل الفروع</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}" {{ request('branch') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn-custom">عرض التقرير</button>
                    <a href="{{ route('GeneralAccountReports.taxDeclaration') }}" class="btn-custom">إلغاء الفلتر</a>
                    <button type="button" class="btn-custom" onclick="exportTableToExcel()">تصدير إلى Excel</button>
                    <button type="button" class="btn-custom" onclick="exportTableToPDF()">تصدير إلى PDF</button>
                </div>
            </div>
        </form>
    </div>
</div>

@if(isset($salesTaxDeclaration) && isset($purchasesTaxDeclaration))
<div class="card">
    <div class="card-header">
        <h4 class="card-title">تفاصيل الاقرار الضريبي</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5>فواتير المبيعات</h5>
                <div class="table-responsive">
                    <table id="salesTaxTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>نوع الضريبة</th>
                                <th>المبيعات</th>
                                <th>التعديل</th>
                                <th>الضريبة المستحقة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($salesTaxDeclaration as $sale)
                                <tr>
                                    <td>{{ $sale->tax_type }}</td>
                                    <td>{{ number_format($sale->grand_total, 2) }}</td>
                                    <td>{{ number_format($sale->tax_total, 2) }}</td>
                                    <td>{{ number_format($sale->tax_total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6">
                <h5>فواتير المشتريات</h5>
                <div class="table-responsive">
                    <table id="purchasesTaxTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>نوع الضريبة</th>
                                <th>المشتريات</th>
                                <th>التعديل</th>
                                <th>الضريبة المستحقة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($purchasesTaxDeclaration as $purchase)
                                <tr>
                                    <td>{{ $purchase->tax_type }}</td>
                                    <td>{{ number_format($purchase->grand_total, 2) }}</td>
                                    <td>{{ number_format($purchase->tax_total, 2) }}</td>
                                    <td>{{ number_format($purchase->tax_total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@section('scripts')
<script src="{{ asset('assets/js/date_range_picker.js') }}"></script>
<script>
    function setDateRange(range) {
        let startDate, endDate;
        const today = new Date();

        switch (range) {
            case 'الأسبوع الماضي':
                startDate = new Date(today.setDate(today.getDate() - 7));
                endDate = new Date();
                break;
            case 'الشهر الأخير':
                startDate = new Date(today.setMonth(today.getMonth() - 1));
                endDate = new Date();
                break;
            case 'من أول الشهر حتى اليوم':
                startDate = new Date(today.getFullYear(), today.getMonth(), 1);
                endDate = new Date();
                break;
            case 'السنة الماضية':
                startDate = new Date(today.getFullYear() - 1, 0, 1);
                endDate = new Date(today.getFullYear() - 1, 11, 31);
                break;
            case 'من أول السنة حتى اليوم':
                startDate = new Date(today.getFullYear(), 0, 1);
                endDate = new Date();
                break;
        }

        const formattedStartDate = startDate.toISOString().split('T')[0];
        const formattedEndDate = endDate.toISOString().split('T')[0];

        document.getElementById('selectedDateRange').value = `${formattedStartDate} - ${formattedEndDate}`;
    }

    function exportTableToExcel() {
        const table = document.getElementById("salesTaxTable");
        const rows = table.querySelectorAll("tr");
        let csv = [];

        for (let i = 0; i < rows.length; i++) {
            const row = [], cols = rows[i].querySelectorAll("td, th");
            for (let j = 0; j < cols.length; j++) {
                row.push(cols[j].innerText);
            }
            csv.push(row.join(","));
        }

        const csvContent = "data:text/csv;charset=utf-8," + csv.join("\n");
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "tax_declaration.csv");
        document.body.appendChild(link);
        link.click();
    }

    function exportTableToPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        const table = document.getElementById("salesTaxTable");
        doc.autoTable({ html: table });
        doc.save("tax_declaration.pdf");
    }
</script>
@endsection
