@extends('master')

@section('title')
    تقرير ملخص المخزون
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
                    <h2 class="content-header-title mb-0 me-3">تقرير ملخص المخزون </h2>
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
        <div class="card-header">ملخص المخزون</div>
        <div class="card-body">
            <form id="inventoryForm" method="GET" action="{{ route('StorHouseReport.summaryInventory') }}">
                <div class="row mb-3">
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

                    <!-- النوع -->
                    <div class="col-md-3">
                        <label for="type" class="form-label">النوع</label>
                        <select id="type" name="type" class="form-control">
                            <option value="">[اختر النوع]</option>
                            <option value="sale">فاتورة بيع</option>
                            <option value="purchase">فاتورة شراء</option>
                            <option value="purchase_return">مرتجع شراء</option>
                            <option value="sale_return">مرتجع بيع</option>
                            <option value="transfer">نقل</option>
                            <option value="manual">يدوي</option>
                            <option value="">منتج مجمع</option>
                            <option value="">إذن مخزن</option>
                            <option value="">منتج مجمع الخارجي</option>
                            <option value="">اذن مخزني اليدوي الداخلي</option>
                            <option value="">اذن مخزني اليدوي الخارجي</option>
                            <option value="">اذن مخزني اليدوي الداخلي</option>
                            <option value="">اذن مخزني فاتورة</option>
                            <option value="">اذن مخزني مرتجع مبيعات</option>
                            <option value="">اذن مخزني إشعار دائن</option>
                            <option value="">اذن مخزني فاتورة الشراء</option>
                            <option value="">اذن مخزني مرتجع شراء</option>
                            <option value="">اذن مخزني إشعار مدين</option>
                            <option value="">نقل اذن مخزني</option>
                            <option value="">نقل اذن مخزني داخلي</option>
                            <option value="">نقل اذن مخزني خارجي</option>
                            <option value="">اذن مخزني نقطة البيع داخلي</option>
                            <option value="">اذن مخزني نقطة البيع خارجي</option>
                            <option value=""> جرد المخزون الخارجي</option>
                            <option value="">جرد المخزون الداخلي</option>
                            <option value="">نقل المخزون</option>
                            <option value="">طلب التصنيع</option>

                        </select>
                    </div>

                    <!-- التاريخ من -->
                    <div class="col-md-3">
                        <label for="start_date" class="form-label">من تاريخ</label>
                        <input type="date" id="start_date" name="start_date" class="form-control">
                    </div>

                    <!-- التاريخ إلى -->
                    <div class="col-md-3">
                        <label for="end_date" class="form-label">إلى تاريخ</label>
                        <input type="date" id="end_date" name="end_date" class="form-control">
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

                    <!-- ترتيب حسب المنتج -->
                    <div class="col-md-3">
                        <label for="groupBy" class="form-label">ترتيب حسب المنتج</label>
                        <select id="groupBy" class="custom-select">
                            <option selected> </option>
                            <option>كمية المخزون تصاعدي</option>
                            <option>كمية المخزون تنازلي</option>
                        </select>
                    </div>

                    <!-- تجميع حسب -->
                    <div class="col-md-3">
                        <label for="groupBy" class="form-label">تجميع حسب</label>
                        <select id="groupBy" class="custom-select">
                            <option selected>تجميع حسب </option>
                            <option>الماركة</option>
                            <option> التصنيف </option>
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
    </div>

    <!-- Table Section -->
    <div class="table-container card">
        <div class="card-header"></div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <p>تاريخ ووقت الطباعة: {{ now()->format('H:i d/m/Y') }}</p>
                <div>
                    <button type="button" class="btn btn-export" id="exportExcel">تصدير Excel</button>
                    <button type="button" class="btn btn-export" id="exportPDF">تصدير PDF</button>
                </div>
            </div>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th rowspan="2">اسم المنتج</th>
                        <th colspan="5">الوارد</th>
                        <th colspan="6">المنصرف</th>
                        <th rowspan="2">اجمالي الحركة </th>

                    </tr>
                    <tr>


                        <th>فواتير الشراء</th>
                        <th>الفواتير المرتجعة</th>
                        <th>التحويل </th>
                        <th>يدوي </th>
                        <th>الاجمالي </th>
                        <th>فواتير البيع</th>
                        <th>مرتجع مشتريات</th>
                        <th>الفواتير المرتجعة</th>
                        <th>التحويل </th>
                        <th>يدوي </th>
                        <th>الاجمالي </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->invoice_items->where('type', 'purchase')->sum('quantity') }}</td>
                            <td>{{ $product->invoice_items->where('type', 'purchase_return')->sum('quantity') }}</td>
                            <td>{{ $product->product_details->where('type_of_operation', 'transfer')->sum('quantity') }}
                            </td>

                            <td>{{ $product->product_details->where('type_of_operation', 'manual')->sum('quantity') }}</td>
                            <td>{{ $product->totalQuantity() }}</td>
                            <td>{{ $product->invoice_items->where('type', 'sale')->sum('quantity') }}</td>
                            <td>{{ $product->invoice_items->where('type', 'purchase_return')->sum('quantity') }}</td>
                            <td>{{ $product->invoice_items->where('type', 'sale_return')->sum('quantity') }}</td>
                            <td>{{ $product->product_details->where('type_of_operation', 'transfer')->sum('quantity') }}
                            </td>
                            <td>{{ $product->product_details->where('type_of_operation', 'manual')->sum('quantity') }}</td>
                            <td>{{ $product->totalSold() }}</td>
                            <td>{{ $product->totalQuantity() }}</td>
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
