@extends('master')

@section('title')
    تقرير مبيعاتالمنتجات اليومية
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/report.css') }}">
@endsection

@section('content')
    <div class="container-fluid mt-4">
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('salesReports.byProduct') }}" method="GET">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="product">البند:</label>
                            <select name="product" class="form-control">
                                <option value="">الكل</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="employee">فاتورة:</label>
                            <select name="employee" class="form-control">
                                <option value="">فاتورة</option>
                                <option value="1">مرتجع</option>
                                <option value="2">اشعار مدين</option>
                                <option value="2">اشعار دائن</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="employee">حالة الفاتورة:</label>
                            <select name="status" class="form-control">
                                <option value="">الكل</option>

                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="employee">التصنيف:</label>
                            <select name="status" class="form-control">
                                <option value="">اختر التصنيف</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="employee">:المخزن</label>
                            <select name="status" class="form-control">
                                <option value="">اختر المخزن</option>
                                @foreach ($storehouses as $storehouse)
                                    <option value="{{ $storehouse->id }}">{{ $storehouse->name }}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="col-md-3">

                            <input type="checkbox" name="add_draft" class="INPUT" value="1" id="add_draft"
                                style="margin-bottom: 30px" /><label for="add_draft">Show Draft
                                Items</label>


                        </div>
                        <div class="col-md-3">
                            <label for="employee">:ماركةال</label>
                            <select name="status" class="form-control">
                                <option value="">اختر الماركة</option>
                                <option value="">2</option>
                                <option value="">22</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="employee">:العميل</label>
                            <select name="status" class="form-control">
                                <option value="">اختر العميل</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="employee">:تصنيف العميل</label>
                            <select name="status" class="form-control">
                                <option value="">اختر التصنيف</option>
                                @foreach ($client_categories as $client_category)
                                    <option value="{{ $client_category->id }}">{{ $client_category->name }}</option>
                                @endforeach

                            </select>
                        </div>


                        <div class="col-md-3">
                            <label for="branch">الفرع:</label>
                            <select name="branch" class="form-control">
                                <option value="">الكل</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="client">الموضف:</label>
                            <select name="client" class="form-control">
                                <option value="">الكل</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="client">العملة:</label>
                            <select name="client" class="form-control">
                                <option value="">اختر العملة</option>

                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label for="from_date">من تاريخ:</label>
                            <input type="date" name="from_date" class="form-control"
                                value="{{ $fromDate->format('Y-m-d') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="to_date">إلى تاريخ:</label>
                            <input type="date" name="to_date" class="form-control"
                                value="{{ $toDate->format('Y-m-d') }}">
                        </div>
                        <div class="col-md-3 align-self-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> عرض التقرير
                            </button>
                        </div>
                        <div class="col-md-3">
                            <label for="report_period">الفترة:</label>
                            <select name="report_period" id="report_period" class="form-control">
                                <option value="">اختر الفترة</option>
                                <option value="daily" {{ request('report_period') == 'daily' ? 'selected' : '' }}>يومي</option>
                                <option value="weekly" {{ request('report_period') == 'weekly' ? 'selected' : '' }}>أسبوعي</option>
                                <option value="monthly" {{ request('report_period') == 'monthly' ? 'selected' : '' }}>شهري</option>
                                <option value="yearly" {{ request('report_period') == 'yearly' ? 'selected' : '' }}>سنوي</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Tabs for Summary and Details --}}
        <div class="card mt-4">
            <div class="card-body">
                <ul class="nav nav-tabs" id="reportTabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#summary">الملخص</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#details">التفاصيل</a>
                    </li>
                    <li class="nav-item dropdown ms-auto">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">خيارات</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">طباعة</a>
                            <a class="dropdown-item" href="#">تصدير Excel</a>
                            <a class="dropdown-item" href="#">تصدير PDF</a>
                        </div>
                    </li>
                </ul>

                <div class="tab-content mt-3">
                    {{-- Summary Tab --}}
                    <div class="tab-pane fade show active" id="summary">
                        <div class="row">
                            <div class="col-md-6">
                                <canvas id="quantityChart"></canvas>
                            </div>
                            <div class="col-md-6">
                                <canvas id="amountChart"></canvas>
                            </div>
                        </div>
                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th>المعرف</th>
                                    <th>الاسم</th>
                                    <th>كود المنتج</th>
                                    <th>رقم الفاتورة</th>
                                    <th>العميل</th>
                                    <th>سعر الوحدة</th>
                                    <th>الكمية</th>
                                    <th>الخصم</th>
                                    <th>الإجمالي</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productSales as $sale)
                                    <tr>
                                        <td>{{ $sale->product->id }}</td>
                                        <td>{{ $sale->product->name }}</td>
                                        <td>{{ $sale->product->code }}</td>
                                        <td>{{ $sale->invoice->code }}</td>
                                        <td>{{ $sale->invoice->client->trade_name }}</td>
                                        <td>{{ number_format($sale->unit_price, 2) }}</td>
                                        <td>{{ $sale->quantity }}</td>
                                        <td>{{ number_format($sale->discount_amount ?? 0, 2) }}</td>
                                        <td>{{ number_format($sale->quantity * $sale->unit_price, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6" class="text-end"><strong>المجموع</strong></td>
                                    <td>{{ $productSales->sum('quantity') }}</td>
                                    <td>{{ number_format($productSales->sum('discount_amount'), 2) }}</td>
                                    <td>{{ number_format($productSales->sum(function($sale) {
                                        return $sale->quantity * $sale->unit_price;
                                    }), 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    {{-- Details Tab --}}
                    <div class="tab-pane fade" id="details">
                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th>المعرف</th>
                                    <th>الاسم</th>
                                    <th>كود المنتج</th>
                                    <th>رقم الفاتورة</th>
                                    <th>العميل</th>
                                    <th>سعر الوحدة</th>
                                    <th>الكمية</th>
                                    <th>الخصم</th>
                                    <th>الإجمالي</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productSales as $sale)
                                    <tr>
                                        <td>{{ $sale->product->id }}</td>
                                        <td>{{ $sale->product->name }}</td>
                                        <td>{{ $sale->product->code }}</td>
                                        <td>{{ $sale->invoice->code }}</td>
                                        <td>{{ $sale->invoice->client->trade_name }}</td>
                                        <td>{{ number_format($sale->unit_price, 2) }}</td>
                                        <td>{{ $sale->quantity }}</td>
                                        <td>{{ number_format($sale->discount_amount ?? 0, 2) }}</td>
                                        <td>{{ number_format($sale->quantity * $sale->unit_price, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Quantity Chart
        const quantityCtx = document.getElementById('quantityChart').getContext('2d');
        new Chart(quantityCtx, {
            type: 'bar',
            data: {
                labels: @json($chartData['labels']),
                datasets: [{
                    label: 'الكمية',
                    data: @json($chartData['quantities']),
                    backgroundColor: 'rgba(54, 162, 235, 0.6)'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'كمية المبيعات حسب المنتج'
                    }
                }
            }
        });

        // Amount Chart
        const amountCtx = document.getElementById('amountChart').getContext('2d');
        new Chart(amountCtx, {
            type: 'pie',
            data: {
                labels: @json($chartData['labels']),
                datasets: [{
                    label: 'المبلغ',
                    data: @json($chartData['amounts']),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'إجمالي المبيعات حسب المنتج'
                    }
                }
            }
        });
    </script>
@endsection
