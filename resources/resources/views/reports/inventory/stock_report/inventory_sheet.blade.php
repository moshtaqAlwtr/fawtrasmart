@extends('master')

@section('title')
    تقرير ورقة الجرد
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
            background: linear-gradient(45deg, #2196F3, #1976D2);
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
            background: linear-gradient(45deg, #1d8cf8, #d8e3e8);
            color: white;
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
                <h2 class="content-header-title mb-0 me-3">تقارير ورقة الجرد</h2>
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
        <div class="card-header">ورقة الجرد</div>
        <div class="card-body">
            <form id="inventoryForm" method="GET" action="{{ route('StorHouseReport.inventorySheet') }}">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="category" class="form-label">التصنيف</label>
                        <select id="category" name="category" class="custom-select">
                            <option value="">الكل</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="brand" class="form-label">العلامة</label>
                        <select id="brand" name="brand" class="custom-select">
                            <option value="">الكل</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand }}">{{ $brand }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="warehouse" class="form-label">المستودع</label>
                        <select id="warehouse" name="warehouse" class="custom-select">
                            <option value="">كل المخزن</option>
                            @foreach($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="groupBy" class="form-label">ترتيب حسب المنتج</label>
                        <select id="groupBy" class="custom-select">
                            <option selected> </option>
                            <option>كمية المخزون تصاعدي</option>
                            <option>كمية المخزون تنازلي</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="groupBy" class="form-label">تجميع حسب</label>
                        <select id="groupBy" class="custom-select">
                            <option selected>تجميع حسب </option>
                            <option>الماركة</option>
                            <option> التصنيف </option>
                        </select>
                    </div>

                    <div class="col-md-3 d-flex align-items-center">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="hideZeroBalance" name="hideZeroBalance">
                            <label class="form-check-label" for="hideZeroBalance">إخفاء الرصيد الصفري</label>
                        </div>
                        <div class="col-md-3 d-flex align-items-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="totalCount">
                                <label class="form-check-label" for="totalCount">العدد الكلي</label>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">إعرض الورقة</button>
                <a href="{{ route('StorHouseReport.inventorySheet') }}"  class="btn btn-secondary" id="resetFilter">إلغاء الفلترة</a>
                <button type="button" class="btn btn-export" id="exportExcel">تصدير Excel</button>
                <button type="button" class="btn btn-export" id="exportPDF">تصدير PDF</button>
            </div>
            </form>
        </div>
    </div>

    <!-- Table Section -->
    <div class="table-container card">
        <div class="card-header">ورقة الجرد - مؤسسة أعمال خاصة للتجارة</div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <p>تاريخ ووقت الطباعة: {{ now()->format('H:i d/m/Y') }}</p>
                <div>
                    <button class="btn btn-print"><i class="fas fa-print"></i> طباعة</button>
                    <button class="btn btn-export"><i class="fas fa-download"></i> خيارات التصدير</button>
                </div>
            </div>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>الكود</th>
                        <th>الاسم</th>
                        <th>التصنيف</th>
                        <th>الماركة</th>
                        <th>العدد بالنظام</th>
                        <th>الكمية</th>
                        <th>ملاحظات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ $product->brand }}</td>
                            <td>{{ $product->totalQuantity() }}</td>
                            <td>{{ $product->product_details->quantity }}</td>
                            <td>{{ $product->Internal_notes }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const table = document.querySelector('.table');
        const resetFilterButton = document.getElementById('resetFilter');
        const exportExcelButton = document.getElementById('exportExcel');
        const exportPDFButton = document.getElementById('exportPDF');

        // Reset Filter
        resetFilterButton.addEventListener('click', function () {
            document.getElementById('category').value = '';
            document.getElementById('brand').value = '';
            document.getElementById('warehouse').value = '';
            document.getElementById('groupBy').value = '';
            document.getElementById('hideZeroBalance').checked = false;
            document.getElementById('totalCount').checked = false;
            document.querySelector('form').submit();
        });

        // Export to Excel
        exportExcelButton.addEventListener('click', function () {
            const wb = XLSX.utils.table_to_book(table, {sheet: "Sheet JS"});
            XLSX.writeFile(wb, 'inventory_sheet.xlsx');
        });

        // Export to PDF
        exportPDFButton.addEventListener('click', function () {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            doc.autoTable({ html: table });
            doc.save('inventory_sheet.pdf');
        });
    });
</script>
@endsection
