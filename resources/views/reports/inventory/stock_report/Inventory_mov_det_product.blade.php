@extends('master')

@section('title')
    تقرير تفاصيل حركة المخزون لكل منتج
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
                    <h2 class="content-header-title mb-0 me-3">تقرير تفاصيل حركة المخزون لكل منتج </h2>
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
        <div class="card-header">تقرير تفاصيل حركة المخزون لكل منتج </div>
        <div class="card-body">
            <form id="inventoryForm" method="GET" action="{{ route('StorHouseReport.Inventory_mov_det_product') }}">
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
                        <label for="source_type" class="form-label">المصدر</label>
                        <select id="source_type" name="source_type" class="custom-select">
                            <option value="">الكل</option>
                            <option value="6">فاتورة مرتجعة</option>
                            <option value="4">إشعار دائن</option>
                            <option value="3">فاتورة شراء</option>
                            <option value="7">مرتجع مشتريات</option>
                            <option value="14">اشعار مدين المشتريات</option>
                            <option value="2">فاتورة</option>
                            <option value="1">تعديل يدوي</option>
                            <option value="8">منتج مجمع</option>
                            <option value="9">إذن مخزن</option>
                            <option value="10">منتج مجمع الخارجي</option>
                            <option value="101">اذن مخزني اليدوي الداخلي</option>
                            <option value="102">اذن مخزني اليدوي الخارجي</option>
                            <option value="103">اذن مخزني فاتورة</option>
                            <option value="104">اذن مخزني مرتجع مبيعات</option>
                            <option value="105">اذن مخزني إشعار دائن</option>
                            <option value="106">اذن مخزني فاتورة الشراء</option>
                            <option value="107">اذن مخزني مرتجع شراء</option>
                            <option value="115">اذن مخزني إشعار مدين</option>
                            <option value="108">نقل اذن مخزني</option>
                            <option value="109">نقل اذن مخزني داخلي</option>
                            <option value="110">نقل اذن مخزني خارجي</option>
                            <option value="111">اذن مخزني نقطة البيع داخلي</option>
                            <option value="112">اذن مخزني نقطة البيع خارجي</option>
                            <option value="113"> جرد المخزون الخارجي</option>
                            <option value="114">جرد المخزون الداخلي</option>
                            <option value="5">نقل المخزون</option>
                            <option value="116">طلب التصنيع</option>
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
                        <label for="currency" class="form-label">العملة </label>
                        <select id="currency" name="currency" class="custom-select">
                            <option value="">الكل</option>
                            <option value="All" selected="selected">الجميع إلي (SAR)</option>
                            <option value="Sperated">كل علي حده</option>
                            <option value="SAR">SAR</option>
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
                    <a href="{{ route('StorHouseReport.Inventory_mov_det_product') }}" class="btn btn-secondary" id="resetFilter">إلغاء الفلترة</a>
                    <button type="button" class="btn btn-export" id="exportExcel">تصدير Excel</button>
                    <button type="button" class="btn btn-export" id="exportPDF">تصدير PDF</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="card-header"> تقرير تفاصيل حركة المخزون لكل منتج </div>

            <div class="table-responsive">
                <div class="table-responsive">
                    <table id="inventoryTable" class="table table-bordered table-striped text-center">
                        <thead>
                            <tr class="report-results-head">
                                <th class="transaction-column">العملية</th>
                                <th class="source_type-column">المصدر</th>
                                <th class="store_name-column">المستودع</th>
                                <th class="quantity-column">الكمية</th>
                                <th class="price-column">سعر الوحدة</th>
                                <th class="stock_after-column">المخزون بعد</th>
                                <th class="purchase_price-column">متوسط سعر التكلفة</th>
                                <th class="total_transaction_value-column">إجمالي قيمة الحركة</th>
                                <th class="total_transaction_price-column">السعر الكلي</th>
                                <th class="stock_value_after-column">قيمة المخزون بعد</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $currentProduct = null;
                            @endphp

                            @foreach ($movements as $movement)
                                @if ($currentProduct !== $movement->product_id)
                                    @php
                                        $currentProduct = $movement->product_id;
                                        $productMovements = $movements->where('product_id', $currentProduct);
                                    @endphp

                                    <tr>
                                        <td colspan="10" class="product-row">
                                             {{ $movement->product->name }}
                                        </td>
                                    </tr>
                                @endif

                                <tr>
                                    <td>{{ $movement->type }}</td>
                                    <td>{{ $movement->source_type }}</td>
                                    <td>{{ $movement->storeHouse->name ?? 'غير معروف' }}</td>
                                    <td>{{ $movement->quantity }}</td>
                                    <td>{{ $movement->unit_price }}</td>
                                    <td>{{ $movement->stock_after }}</td>
                                    <td>{{ $movement->purchase_price }}</td>
                                    <td>{{ $movement->total }}</td>
                                    <td>{{ $movement->total }}</td>
                                    <td>{{ $movement->stock_value_after }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
                document.getElementById('source_type').value = '';
                document.getElementById('brand').value = '';
                document.getElementById('currency').value = '';
                document.getElementById('warehouse').value = '';
                document.querySelector('form').submit();
            });

            // Export to Excel
            exportExcelButton.addEventListener('click', function() {
                const wb = XLSX.utils.table_to_book(table, {
                    sheet: "Sheet JS"
                });
                XLSX.writeFile(wb, 'inventory_movements.xlsx');
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
                doc.save('inventory_movements.pdf');
            });
        });
    </script>
@endsection
