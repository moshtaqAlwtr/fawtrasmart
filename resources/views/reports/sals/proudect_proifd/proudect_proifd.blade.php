@extends('master')

@section('title')
    تقرير أرباح المنتجات
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="container-fluid">
        <div class="report-container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="mb-0">
                                <i class="fas fa-chart-line me-2"></i>
                                تقرير أرباح المنتجات
                            </h3>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-success me-2 insights-badge">
                                    <i class="fas fa-coins me-1"></i>
                                    إجمالي الربح: {{ number_format($profitsReport->sum('profit'), 2) }} ر.س
                                </span>
                                <button id="exportExcel" class="btn btn-success">
                                    <i class="fas fa-file-excel me-1"></i> تصدير إكسل
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="filter-card">
                                <form method="GET" action="{{ route('salesReports.profits') }}" id="profitsFilterForm">
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label filter-label">
                                                <i class="fas fa-calendar-alt me-2"></i>الفترة من
                                            </label>
                                            <input type="date" name="from_date" class="form-control"
                                                value="{{ $fromDate }}">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label filter-label">
                                                <i class="fas fa-calendar-alt me-2"></i>الفترة إلى
                                            </label>
                                            <input type="date" name="to_date" class="form-control"
                                                value="{{ $toDate }}">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label filter-label">
                                                <i class="fas fa-box me-2"></i>المنتجات
                                            </label>
                                            <select name="products[]" class="form-control select2" multiple>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label filter-label">
                                                <i class="fas fa-tags me-2"></i>التصنيفات
                                            </label>
                                            <select name="categories[]" class="form-control select2" multiple>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label filter-label">
                                                <i class="fas fa-trademark me-2"></i>الماركات
                                            </label>
                                            <select name="brands[]" class="form-control select2" multiple>
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand }}">{{ $brand }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label filter-label">
                                                <i class="fas fa-store me-2"></i>الفروع
                                            </label>
                                            <select name="branches[]" class="form-control select2" multiple>
                                                @foreach ($branches as $branch)
                                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 d-flex align-items-end">
                                            <div>
                                                <button type="submit" class="btn btn-filter me-2">
                                                    <i class="fas fa-filter me-1"></i> تصفية
                                                </button>
                                                <a href="{{ route('salesReports.profits') }}" class="btn btn-secondary"
                                                    id="resetFilters">
                                                    <i class="fas fa-redo me-1"></i> إعادة تعيين
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover table-profits" id="profitsTable">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>اسم المنتج</th>
                                                    <th>التصنيف</th>
                                                    <th>الماركة</th>
                                                    <th>الكمية المباعة</th>
                                                    <th>القيمة الإجمالية</th>
                                                    <th>سعر الشراء</th>
                                                    <th>سعر البيع</th>
                                                    <th>التكلفة الإجمالية</th>
                                                    <th>صافي الربح</th>
                                                    <th>نسبة الربح</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($profitsReport as $product)
                                                    <tr>
                                                        <td>{{ $product['name'] }}</td>
                                                        <td>{{ $product['category_name'] ?? 'غير محدد' }}</td>
                                                        <td>{{ $product['brand'] ?? 'غير محدد' }}</td>
                                                        <td>{{ number_format($product['total_quantity'], 2) }}</td>
                                                        <td>{{ number_format($product['total_value'], 2) }} ر.س</td>
                                                        <td>{{ number_format($product['purchase_price'], 2) }} ر.س</td>
                                                        <td>{{ number_format($product['sale_price'], 2) }} ر.س</td>
                                                        <td>{{ number_format($product['total_cost'], 2) }} ر.س</td>
                                                        <td
                                                            class="{{ $product['profit'] >= 0 ? 'profit-positive' : 'profit-negative' }}">
                                                            {{ number_format($product['profit'], 2) }} ر.س
                                                        </td>
                                                        <td
                                                            class="{{ $product['profit_percentage'] >= 0 ? 'profit-positive' : 'profit-negative' }}">
                                                            {{ number_format($product['profit_percentage'], 2) }}%
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="10" class="text-center">
                                                            <div class="alert alert-info">
                                                                <i class="fas fa-info-circle me-2"></i>
                                                                لا توجد بيانات للعرض في الفترة المحددة
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                            <tfoot>
                                                <tr class="table-secondary">
                                                    <td colspan="8" class="text-end"><strong>الإجمالي</strong></td>
                                                    <td>
                                                        {{ number_format($profitsReport->sum('profit'), 2) }} ر.س
                                                    </td>
                                                    <td>
                                                        {{ number_format(
                                                            $profitsReport->sum('total_value') > 0
                                                                ? ($profitsReport->sum('profit') / $profitsReport->sum('total_value')) * 100
                                                                : 0,
                                                            2,
                                                        ) }}%
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2


            // Reset filters
            $('#resetFilters').on('click', function() {
                $('.select2').val(null).trigger('change');
                $('input[type="date"]').val('');
            });

            // Excel Export
            $('#exportExcel').on('click', function() {
                // Prepare data for export
                const table = document.getElementById('profitsTable');
                const wb = XLSX.utils.table_to_book(table, {
                    raw: true,
                    cellDates: true
                });

                // Generate file name with current date
                const today = new Date();
                const fileName =
                    `تقرير_أرباح_المنتجات_${today.getFullYear()}-${today.getMonth() + 1}-${today.getDate()}.xlsx`;

                // Export the workbook
                XLSX.writeFile(wb, fileName);
            });
        });
    </script>
@endsection
