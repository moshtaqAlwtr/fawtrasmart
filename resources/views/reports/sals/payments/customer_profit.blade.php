@extends('master')

@section('title')
    تقرير أرباح العملاء
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
    body {
        background-color: #f4f6f9;
    }
    .report-container {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        padding: 20px;
        margin-top: 30px;
    }
    .filter-card {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .profit-positive {
        color: #28a745;
        font-weight: bold;
    }
    .profit-negative {
        color: #dc3545;
        font-weight: bold;
    }
    .card-header {
        background: linear-gradient(to left, #2c3e50, #3498db);
        color: white;
    }
    .insights-badge {
        font-size: 0.9rem;
        margin-right: 5px;
    }
    .filter-label {
        font-weight: 600;
        color: #495057;
    }
    .btn-filter {
        background-color: #3498db;
        color: white;
        transition: all 0.3s ease;
    }
    .btn-filter:hover {
        background-color: #2980b9;
        transform: translateY(-2px);
    }
    .employee-performance-card {
        background-color: #f1f4f8;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="report-container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">
                            <i class="fas fa-users me-2"></i>
                            تقرير أرباح العملاء
                        </h3>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-success me-2 insights-badge">
                                <i class="fas fa-coins me-1"></i>
                                إجمالي الربح: {{ number_format($insights['total_profit'], 2) }} ر.س
                            </span>
                            <button id="exportExcel" class="btn btn-success">
                                <i class="fas fa-file-excel me-1"></i> تصدير إكسل
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="filter-card">
                            <form method="GET" action="{{ route('salesReports.customerProfits') }}" id="profitsFilterForm">
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
                                            <i class="fas fa-users me-2"></i>العملاء
                                        </label>
                                        <select name="clients[]" class="form-control select2" multiple>
                                            @foreach ($clients as $client)
                                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                                            @endforeach
                                        </select>
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
                                </div>
                                <div class="row">
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
                                    <div class="col-md-3 d-flex align-items-end">
                                        <div>
                                            <button type="submit" class="btn btn-filter me-2">
                                                <i class="fas fa-filter me-1"></i> تصفية
                                            </button>
                                            <a href="{{ route('salesReports.customerProfits') }}" class="btn btn-secondary"
                                                id="resetFilters">
                                                <i class="fas fa-redo me-1"></i> إعادة تعيين
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="employee-performance-card">
                                    <h5 class="text-center mb-3">
                                        <i class="fas fa-trophy text-warning me-2"></i>
                                        أفضل أداء
                                    </h5>
                                    @if($insights['top_performing_client'])
                                        <div class="text-center">
                                            <h6>{{ $insights['top_performing_client']['name'] }}</h6>
                                            <p class="text-success">
                                                <strong>الربح: {{ number_format($insights['top_performing_client']['profit'], 2) }} ر.س</strong>
                                            </p>
                                            <small>
                                                إجمالي المبيعات: {{ number_format($insights['top_performing_client']['total_value'], 2) }} ر.س
                                            </small>
                                        </div>
                                    @else
                                        <p class="text-center text-muted">لا توجد بيانات</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="employee-performance-card">
                                    <h5 class="text-center mb-3">
                                        <i class="fas fa-chart-pie text-info me-2"></i>
                                        ملخص الأداء
                                    </h5>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>عدد العملاء</span>
                                        <strong>{{ $insights['total_clients'] }}</strong>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>إجمالي الإيرادات</span>
                                        <strong>{{ number_format($insights['total_revenue'], 2) }} ر.س</strong>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>هامش الربح المتوسط</span>
                                        <strong>{{ number_format($insights['avg_profit_margin'], 2) }}%</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="employee-performance-card">
                                    <h5 class="text-center mb-3">
                                        <i class="fas fa-chart-line text-danger me-2"></i>
                                        الأداء الأقل
                                    </h5>
                                    @if($insights['lowest_performing_client'])
                                        <div class="text-center">
                                            <h6>{{ $insights['lowest_performing_client']['name'] }}</h6>
                                            <p class="text-danger">
                                                <strong>الربح: {{ number_format($insights['lowest_performing_client']['profit'], 2) }} ر.س</strong>
                                            </p>
                                            <small>
                                                إجمالي المبيعات: {{ number_format($insights['lowest_performing_client']['total_value'], 2) }} ر.س
                                            </small>
                                        </div>
                                    @else
                                        <p class="text-center text-muted">لا توجد بيانات</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" id="clientProfitsTable">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>اسم العميل</th>
                                                <th>الكمية المباعة</th>
                                                <th>القيمة الإجمالية</th>
                                                <th>متوسط سعر البيع</th>
                                                <th>التكلفة الإجمالية</th>
                                                <th>صافي الربح</th>
                                                <th>نسبة الربح</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($clientProfitsReport as $client)
                                                <tr>
                                                    <td>{{ $client['name'] }}</td>
                                                    <td>{{ number_format($client['total_quantity'], 2) }}</td>
                                                    <td>{{ number_format($client['total_value'], 2) }} ر.س</td>
                                                    <td>{{ number_format($client['avg_selling_price'], 2) }} ر.س</td>
                                                    <td>{{ number_format($client['total_cost'], 2) }} ر.س</td>
                                                    <td class="{{ $client['profit'] >= 0 ? 'profit-positive' : 'profit-negative' }}">
                                                        {{ number_format($client['profit'], 2) }} ر.س
                                                    </td>
                                                    <td class="{{ $client['profit_percentage'] >= 0 ? 'profit-positive' : 'profit-negative' }}">
                                                        {{ number_format($client['profit_percentage'], 2) }}%
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">
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
                                                <td class="text-end"><strong>الإجمالي</strong></td>
                                                <td>{{ number_format($clientProfitsReport->sum('total_quantity'), 2) }}</td>
                                                <td>{{ number_format($clientProfitsReport->sum('total_value'), 2) }} ر.س</td>
                                                <td>-</td>
                                                <td>{{ number_format($clientProfitsReport->sum('total_cost'), 2) }} ر.س</td>
                                                <td>{{ number_format($clientProfitsReport->sum('profit'), 2) }} ر.س</td>
                                                <td>
                                                    {{ number_format(
                                                        $clientProfitsReport->sum('total_value') > 0
                                                        ? ($clientProfitsReport->sum('profit') / $clientProfitsReport->sum('total_value')) * 100
                                                        : 0,
                                                    2) }}%
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


        // Reset filters


        // Excel Export
        $('#exportExcel').on('click', function() {
            // Prepare data for export
            const table = document.getElementById('clientProfitsTable');
            const wb = XLSX.utils.table_to_book(table, {
                raw: true,
                cellDates: true
            });

            // Generate file name with current date
            const today = new Date();
            const fileName = `تقرير_أرباح_العملاء_${today.getFullYear()}-${today.getMonth() + 1}-${today.getDate()}.xlsx`;

            // Export the workbook
            XLSX.writeFile(wb, fileName);
        });
    });
</script>
@endsection