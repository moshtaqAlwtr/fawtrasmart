@extends('master')

@section('title')
    ملخص رصيد المخزون
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
                    <h2 class="content-header-title mb-0 me-3">ملخص رصيد المخزون </h2>
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
        <div class="card-header">ملخص رصيد المخزون </div>
        <div class="card-body">
            <form id="inventoryForm" method="GET" action="{{ route('StorHouseReport.inventoryBlance') }}">
                <div class="row mb-3">
                    <!-- المنتجات -->
                    <div class="col-md-3">
                        <label for="product" class="form-label">المنتج</label>
                        <select id="product" name="product" class="custom-select">
                            <option value="">اختر المنتج</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- التصنيف -->
                    <div class="col-md-3">
                        <label for="category" class="form-label">التصنيف</label>
                        <select id="category" name="category" class="custom-select">
                            <option value="">الكل</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- العلامة التجارية -->
                    <div class="col-md-3">
                        <label for="brand" class="form-label">العلامة</label>
                        <select id="brand" name="brand" class="custom-select">
                            <option value="">الكل</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand }}">{{ $brand }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- المستودع -->
                    <div class="col-md-3">
                        <label for="warehouse" class="form-label">المستودع</label>
                        <select id="warehouse" name="warehouse" class="custom-select">
                            <option value="">كل المخزن</option>
                            @foreach ($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- الحالة -->
                    <div class="col-md-3">
                        <label for="status" class="form-label">الحالة</label>
                        <select id="status" name="status" class="form-control">
                            <option value="">الكل</option>
                            <option value="1">متاح</option>
                            <option value="2">مخزون منخفض</option>
                            <option value="3">مخزون نفد</option>
                            <option value="4">غير نشط</option>
                        </select>
                    </div>
                </div>

                <!-- أزرار التقرير -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">عرض التقرير</button>
                    <a href="{{ route('StorHouseReport.inventoryBlance') }}" class="btn btn-secondary" id="resetFilter">إلغاء الفلترة</a>
                    <button type="button" class="btn btn-export" id="exportExcel">تصدير Excel</button>
                    <button type="button" class="btn btn-export" id="exportPDF">تصدير PDF</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="card-header"> تقرير ملخص رصيد المخزون </div>

            <div class="table-responsive">
                <table id="inventoryTable" class="table table-bordered table-striped text-center">
                    <thead class="bg-light">
                        <tr>
                            <th class="product_code-column">الكود</th>
                            <th class="name-column">الاسم</th>
                            <th class="category-column">التصنيف</th>
                            <th class="brand-column">الماركة</th>
                            <th class="total-column">الإجمالي</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ $product->brand }}</td>
                                <td>{{ $product->total_value }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

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
