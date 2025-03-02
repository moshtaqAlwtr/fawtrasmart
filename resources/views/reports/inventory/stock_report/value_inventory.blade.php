@extends('master')

@section('title')
    قيمة المخزن
@stop

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .card {
            background-color: #ffffff;
            border: none;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .card-header {

            font-weight: bold;
            font-size: 20px;
            padding: 15px;
            border-radius: 10px 10px 0 0;
            text-align: center;
        }

        .form-control,
        .custom-select {
            border-radius: 5px;
        }

        .btn-primary {
            background: linear-gradient(45deg, #4CAF50, #2E7D32);
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #66BB6A, #388E3C);
        }

        .btn-export,
        .btn-print {
            background: linear-gradient(45deg, #2196F3, #dbe0e5);
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
            margin-right: 10px;
        }

        .btn-export:hover,
        .btn-print:hover {
            opacity: 0.9;
        }

        .form-check-label {
            font-weight: bold;
        }

        .table-container {

            margin-top: 20px;
        }

        .table thead th {
            background: linear-gradient(45deg, #e3e9ef, #d8e3e8);

            font-weight: bold;
            text-align: center;
        }

        .table tbody td {
            text-align: center;
            vertical-align: middle;
        }
    </style>
@endsection

@section('content')
    <div class="content-header row mb-3">
        <div class="content-header-left col-md-9 col-12 d-flex align-items-center">
            <div class="row breadcrumbs-top flex-grow-1">
                <div class="col-12 d-flex align-items-center">
                    <h2 class="content-header-title mb-0 me-3">تقرير قيمة المخزن </h2>
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
        <div class="card-header">قيمة المخزون</div>
        <div class="card-body">
            <form id="inventoryForm" method="GET" action="{{ route('StorHouseReport.valueInventory') }}">
                <div class="row mb-3">
                    <!-- المورد -->
                    <div class="col-md-4">
                        <label for="supplier" class="form-label">المورد</label>
                        <select id="supplier" name="supplier" class="custom-select">
                            <option value="">اختر المورد</option>
                            @foreach ($suppliers as $sup)
                                <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- العلامة التجارية -->
                    <div class="col-md-4">
                        <label for="brand" class="form-label">العلامة</label>
                        <select id="brand" name="brand" class="custom-select">
                            <option value="">الكل</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand }}">{{ $brand }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- التصنيف -->
                    <div class="col-md-4">
                        <label for="category" class="form-label">التصنيف</label>
                        <select id="category" name="category" class="custom-select">
                            <option value="">الكل</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="groupBy" class="form-label">ترتيب حسب المنتج</label>
                        <select id="groupBy" class="custom-select">
                            <option selected> </option>
                            <option>كمية المخزون تصاعدي</option>
                            <option>كمية المخزون تنازلي</option>
                        </select>
                    </div>

                    <!-- الفترة الزمنية -->
                    <div class="col-md-4">
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
                                    <li class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#" onclick="setDateRange('تاريخ محدد')">تاريخ محدد</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="setDateRange('كل التواريخ قبل')">كل التواريخ قبل</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="setDateRange('كل التواريخ بعد')">كل التواريخ بعد</a></li>
                                </ul>
                            </div>
                            <input type="text" class="form-control" id="selectedDateRange" name="dateRange" placeholder="الفترة المحددة" readonly>
                        </div>
                    </div>

                    <!-- المستودع -->
                    <div class="col-md-4">
                        <label for="warehouse" class="form-label">المستودع</label>
                        <select id="warehouse" name="warehouse" class="custom-select">
                            <option value="">كل المخزن</option>
                            @foreach ($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- أزرار التقرير -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">عرض التقرير</button>
                    <a href="{{ route('StorHouseReport.summaryInventory') }}" class="btn btn-secondary"
                        id="resetFilter">إلغاء الفلترة</a>
                </div>
            </form>
        </div>

    </div>
<div class="card">
<div class="card-body">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <p>تاريخ ووقت الطباعة: {{ now()->format('H:i d/m/Y') }}</p>
        <div>
            <button type="button" class="btn btn-export" id="exportExcel">تصدير Excel</button>
            <button type="button" class="btn btn-export" id="exportPDF">تصدير PDF</button>
        </div>
    </div>
</div>
</div>

    <div class="card">
        <div class="card-body">
            <table id="inventoryTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>الكود</th>
                        <th>الاسم</th>
                        <th>الكمية</th>
                        <th>سعر البيع الحالي</th>
                        <th>متوسط سعر الشراء</th>
                        <th>متوسط سعر البيع</th>
                        <th>إجمالي سعر البيع المتوقع</th>
                        <th>إجمالي سعر الشراء</th>
                        <th>الربح المتوقع</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->total_quantity }}</td>
                            <td>{{ $product->sale_price }}</td>
                            <td>{{ $product->purchase_price }}</td>
                            <td>{{ $product->average_sale_price }}</td>
                            <td>{{ $product->total_sale_value }}</td>
                            <td>{{ $product->total_purchase_value }}</td>
                            <td>{{ $product->expected_profit }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/date_range_picker.js') }}"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const table = document.querySelector('.table');
                const resetFilterButton = document.getElementById('resetFilter');
                const exportExcelButton = document.getElementById('exportExcel');
                const exportPDFButton = document.getElementById('exportPDF');

                // Reset Filter
                resetFilterButton.addEventListener('click', function() {
                    document.getElementById('category').value = '';
                    document.getElementById('brand').value = '';
                    document.getElementById('warehouse').value = '';
                    document.getElementById('groupBy').value = '';
                    document.getElementById('hideZeroBalance').checked = false;
                    document.getElementById('totalCount').checked = false;
                    document.querySelector('form').submit();
                });

                // Export to Excel
                exportExcelButton.addEventListener('click', function() {
                    const wb = XLSX.utils.table_to_book(table, {
                        sheet: "Sheet JS"
                    });
                    XLSX.writeFile(wb, 'inventory_sheet.xlsx');
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
                    doc.save('inventory_sheet.pdf');
                });
            });
        </script>
@endsection
