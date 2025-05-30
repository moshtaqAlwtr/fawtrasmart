@extends('master')

@section('title')
    تقرير مبيعات المنتجات اليومية
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('assets/css/report.css') }}">
@endsection

@section('content')
    <div class="container-fluid mt-4">
        <div class="card shadow">

            <div class="card-body">
                <h5 class="card-title">
                    @switch($reportPeriod)
                        @case('daily')
                            تقرير المبيعات اليومية للمنتجات
                            @break
                        @case('weekly')
                            تقرير المبيعات الأسبوعية للمنتجات
                            @break
                        @case('monthly')
                            تقرير المبيعات الشهرية للمنتجات
                            @break
                        @case('yearly')
                            تقرير المبيعات السنوية للمنتجات
                            @break
                    @endswitch
                </h5>
                <form action="{{ route('salesReports.byProduct') }}" method="GET" class="mb-4">
                    <div class="row g-3">
                        <!-- فلتر المنتج -->
                        <div class="col-md-3">
                            <label class="form-label">المنتج</label>
                            <select name="product" class="form-control">
                                <option value="">جميع المنتجات</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ request('product') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} ({{ $product->code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- فلتر التصنيف -->
                        <div class="col-md-3">
                            <label class="form-label">تصنيف المنتج</label>
                            <select name="category" class="form-control">
                                <option value="">جميع التصنيفات</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- فلتر نوع الفاتورة -->
                        <div class="col-md-3">
                            <label class="form-label">نوع الفاتورة</label>
                            <select name="invoice_type" class="form-control">
                                <option value="">الكل</option>
                                <option value="1" {{ request('invoice_type') == '1' ? 'selected' : '' }}>مرتجع</option>
                                <option value="2" {{ request('invoice_type') == '2' ? 'selected' : '' }}>اشعار مدين</option>
                                <option value="3" {{ request('invoice_type') == '3' ? 'selected' : '' }}>اشعار دائن</option>
                            </select>
                        </div>

                        <!-- فلتر الفرع -->
                        <div class="col-md-3">
                            <label class="form-label">الفرع</label>
                            <select name="branch" class="form-control">
                                <option value="">جميع الفروع</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ request('branch') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- فلتر العميل -->
                        <div class="col-md-3">
                            <label class="form-label">العميل</label>
                            <select name="client" class="form-control">
                                <option value="">جميع العملاء</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" {{ request('client') == $client->id ? 'selected' : '' }}>
                                        {{ $client->trade_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- فلتر فئة العميل -->
                        <div class="col-md-3">
                            <label class="form-label">فئة العميل</label>
                            <select name="client_category" class="form-control">
                                <option value="">جميع الفئات</option>
                                @foreach($client_categories as $category)
                                    <option value="{{ $category->id }}" {{ request('client_category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- فلتر الموظف -->
                        <div class="col-md-3">
                            <label class="form-label">الموظف</label>
                            <select name="employee" class="form-control">
                                <option value="">جميع الموظفين</option>
                                @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}" {{ request('employee') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->name }}
                                </option>
                            @endforeach
                            </select>
                        </div>

                        <!-- فلتر المخزن -->
                        <div class="col-md-3">
                            <label class="form-label">المخزن</label>
                            <select name="storehouse" class="form-control">
                                <option value="">جميع المخازن</option>
                                @foreach($storehouses as $storehouse)
                                    <option value="{{ $storehouse->id }}" {{ request('storehouse') == $storehouse->id ? 'selected' : '' }}>
                                        {{ $storehouse->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- فلتر الفترة -->
                        <div class="col-md-3">
                            <label class="form-label">الفترة</label>
                            <select name="report_period" class="form-control">
                                <option value="">اختر الفترة</option>
                                <option value="daily" {{ request('report_period') == 'daily' ? 'selected' : '' }}>يومي</option>
                                <option value="weekly" {{ request('report_period') == 'weekly' ? 'selected' : '' }}>أسبوعي</option>
                                <option value="monthly" {{ request('report_period') == 'monthly' ? 'selected' : '' }}>شهري</option>
                                <option value="yearly" {{ request('report_period') == 'yearly' ? 'selected' : '' }}>سنوي</option>
                                <option value="custom" {{ request('report_period') == 'custom' ? 'selected' : '' }}>مخصص</option>
                            </select>
                        </div>

                        <!-- فلتر من تاريخ (يظهر فقط عند اختيار مخصص) -->

                        <div class="col-md-3">
                            <label class="form-label">من تاريخ</label>
                            <input type="date" name="from_date" class="form-control"
                                value="{{ $fromDate->format('Y-m-d') }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">إلى تاريخ</label>
                            <input type="date" name="to_date" class="form-control"
                                value="{{ $toDate->format('Y-m-d') }}">
                        </div>

                        <!-- خيار عرض المسودات -->
                        <div class="col-md-3 align-self-end">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="add_draft" id="add_draft"
                                       value="1" {{ request('add_draft') ? 'checked' : '' }}>
                                <label class="form-check-label" for="add_draft">عرض المسودات</label>
                            </div>
                        </div>

                        <!-- أزرار التحكم -->
                        <div class="col-md-12 text-end mt-3">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-filter me-1"></i> تطبيق الفلتر
                            </button>
                            <a href="{{ route('salesReports.byProduct') }}" class="btn btn-secondary me-2">
                                <i class="fas fa-redo me-1"></i> إعادة تعيين
                            </a>
                            <button type="submit" name="export" value="excel" class="btn btn-success me-2">
                                <i class="fas fa-file-excel me-1"></i> تصدير إكسل
                            </button>
                            <button type="submit" name="export" value="pdf" class="btn btn-danger">
                                <i class="fas fa-file-pdf me-1"></i> تصدير PDF
                            </button>
                        </div>
                    </div>
                </form>

                <script>
                // عرض/إخفاء حقول التاريخ عند اختيار "مخصص"
                document.querySelector('select[name="report_period"]').addEventListener('change', function() {
                    const isCustom = this.value === 'custom';
                    document.getElementById('from_date_container').style.display = isCustom ? 'block' : 'none';
                    document.getElementById('to_date_container').style.display = isCustom ? 'block' : 'none';
                });
                </script>
            </div>
        </div>

        {{-- Results Section --}}
        @if ($productSales->count() > 0)
            <div class="card mt-4">
                <div class="card-body">
                    {{-- Tabs for Summary and Details --}}
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
                                <a class="dropdown-item" href="#" onclick="window.print()">
                                    <i class="fas fa-print"></i> طباعة
                                </a>
                                <a class="dropdown-item" href="#" id="exportExcel">
                                    <i class="fas fa-file-excel"></i> تصدير Excel
                                </a>
                                <a class="dropdown-item" href="#" id="exportPDF">
                                    <i class="fas fa-file-pdf"></i> تصدير PDF
                                </a>
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

                            {{-- Summary Table --}}
                            <table class="table table-bordered mt-3">
                                <thead>
                                    <tr>
                                        @if ($reportPeriod == 'daily')
                                            <th>التاريخ (يومي)</th>
                                        @elseif($reportPeriod == 'weekly')
                                            <th>الأسبوع</th>
                                        @elseif($reportPeriod == 'monthly')
                                            <th>الشهر</th>
                                        @elseif($reportPeriod == 'yearly')
                                            <th>السنة</th>
                                        @endif
                                        <th>رقم الفاتورة</th>
                                        <th>المعرف</th>
                                        <th>الاسم</th>
                                        <th>كود المنتج</th>
                                        <th>العميل</th>
                                        <th>نوع الفاتورة</th>
                                        <th>سعر الوحدة</th>
                                        <th>الكمية</th>
                                        <th>الخصم</th>
                                        <th>الإجمالي</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        // Adjust quantities and amounts for return invoices
                                        $adjustedSales = $productSales->map(function ($sale) {
                                            $sale->adjusted_quantity =
                                                $sale->invoice->type === 'return'
                                                    ? -abs($sale->quantity)
                                                    : $sale->quantity;
                                            $sale->adjusted_amount = $sale->adjusted_quantity * $sale->unit_price;
                                            return $sale;
                                        });

                                        $groupedSales = $adjustedSales->groupBy(function ($sale) use ($reportPeriod) {
                                            switch ($reportPeriod) {
                                                case 'daily':
                                                    return $sale->invoice->invoice_date->format('Y-m-d');
                                                case 'weekly':
                                                    return $sale->invoice->invoice_date->format('Y-W');
                                                case 'monthly':
                                                    return $sale->invoice->invoice_date->format('Y-m');
                                                case 'yearly':
                                                    return $sale->invoice->invoice_date->format('Y');
                                                default:
                                                    return $sale->invoice->invoice_date->format('Y-m-d');
                                            }
                                        });
                                    @endphp

                                    @foreach ($groupedSales as $period => $periodSales)
                                        @php
                                            $periodTotalQuantity = $periodSales->sum('adjusted_quantity');
                                            $periodTotalDiscount = $periodSales->sum('discount_amount');
                                            $periodTotalAmount = $periodSales->sum('adjusted_amount');
                                        @endphp

                                        {{-- Period Header Row --}}
                                        <tr class="table-secondary">
                                            <td colspan="11" class="text-center">
                                                @if ($reportPeriod == 'daily')
                                                    <strong>{{ Carbon\Carbon::parse($period)->locale('ar')->isoFormat('LL') }}</strong>
                                                @elseif($reportPeriod == 'weekly')
                                                    <strong>الأسبوع
                                                        {{ Carbon\Carbon::parse($period . '-1')->locale('ar')->weekOfYear }}
                                                        ({{ Carbon\Carbon::parse($period . '-1')->startOfWeek()->format('Y-m-d') }}
                                                        إلى
                                                        {{ Carbon\Carbon::parse($period . '-1')->endOfWeek()->format('Y-m-d') }})
                                                    </strong>
                                                @elseif($reportPeriod == 'monthly')
                                                    <strong>{{ Carbon\Carbon::parse($period . '-01')->locale('ar')->isoFormat('MMMM YYYY') }}</strong>
                                                @elseif($reportPeriod == 'yearly')
                                                    <strong>{{ $period }}</strong>
                                                @endif
                                            </td>
                                        </tr>

                                        {{-- Individual Invoice Rows --}}
                                        @foreach ($periodSales->groupBy('invoice_id') as $invoiceId => $invoiceSales)
                                            @php
                                                $firstSale = $invoiceSales->first();
                                                $invoiceTotalQuantity = $invoiceSales->sum('adjusted_quantity');
                                                $invoiceTotalDiscount = $invoiceSales->sum('discount_amount');
                                                $invoiceTotalAmount = $invoiceSales->sum('adjusted_amount');
                                            @endphp

                                            {{-- Invoice Header Row --}}
                                            <tr class="table-info">
                                                <td colspan="11" class="text-center">
                                                    <strong>
                                                        رقم الفاتورة: {{ $firstSale->invoice->code }} |
                                                        تاريخ الفاتورة:
                                                        {{ $firstSale->invoice->invoice_date->format('Y-m-d') }}
                                                    </strong>
                                                </td>
                                            </tr>

                                            {{-- Product Rows for this Invoice --}}
                                            @foreach ($invoiceSales as $sale)
                                                <tr @if ($sale->invoice->type === 'return') class="table-danger" @endif>
                                                    @if ($reportPeriod == 'daily')
                                                        <td>{{ Carbon\Carbon::parse($period)->format('Y-m-d') }}</td>
                                                    @elseif($reportPeriod == 'weekly')
                                                        <td>الأسبوع {{ Carbon\Carbon::parse($period . '-1')->weekOfYear }}
                                                        </td>
                                                    @elseif($reportPeriod == 'monthly')
                                                        <td>{{ Carbon\Carbon::parse($period . '-01')->format('Y-m') }}</td>
                                                    @elseif($reportPeriod == 'yearly')
                                                        <td>{{ $period }}</td>
                                                    @endif
                                                    <td>{{ $sale->invoice->code }}</td>
                                                    <td>{{ $sale->product->id }}</td>
                                                    <td>{{ $sale->product->name }}</td>
                                                    <td>{{ $sale->product->code }}</td>
                                                    <td>{{ $sale->invoice->client->trade_name }}</td>
                                                    <td>
                                                        @if ($sale->invoice->type === 'normal')
                                                            فاتورة
                                                        @elseif($sale->invoice->type === 'returned')
                                                            مرتجع
                                                        @elseif($sale->invoice->type === 'debit_note')
                                                            اشعار مدين
                                                        @elseif($sale->invoice->type === 'credit_note')
                                                            اشعار دائن
                                                        @endif
                                                    </td>
                                                    <td>{{ number_format($sale->unit_price, 2) }}</td>
                                                    <td>{{ $sale->adjusted_quantity }}</td>
                                                    <td>{{ number_format($sale->discount_amount ?? 0, 2) }}</td>
                                                    <td>{{ number_format($sale->adjusted_amount, 2) }}</td>
                                                </tr>
                                            @endforeach

                                            {{-- Invoice Total Row --}}
                                            <tr class="table-warning">
                                                <td colspan="7" class="text-end"><strong>مجموع الفاتورة</strong></td>
                                                <td>{{ number_format($invoiceTotalQuantity, 2) }}</td>
                                                <td>{{ number_format($invoiceTotalDiscount, 2) }}</td>
                                                <td>{{ number_format($invoiceTotalAmount, 2) }}</td>
                                            </tr>
                                        @endforeach

                                        {{-- Period Total Row --}}
                                        <tr class="table-success">
                                            <td colspan="7" class="text-end"><strong>مجموع الفترة</strong></td>
                                            <td>{{ number_format($periodTotalQuantity, 2) }}</td>
                                            <td>{{ number_format($periodTotalDiscount, 2) }}</td>
                                            <td>{{ number_format($periodTotalAmount, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    @php
                                        $grandTotalQuantity = $adjustedSales->sum('adjusted_quantity');
                                        $grandTotalDiscount = $adjustedSales->sum('discount_amount');
                                        $grandTotalAmount = $adjustedSales->sum('adjusted_amount');
                                    @endphp
                                    <tr class="table-primary">
                                        <td colspan="7" class="text-end"><strong>المجموع الكلي</strong></td>
                                        <td>{{ number_format($grandTotalQuantity, 2) }}</td>
                                        <td>{{ number_format($grandTotalDiscount, 2) }}</td>
                                        <td>{{ number_format($grandTotalAmount, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-info mt-4">
                لا توجد بيانات متاحة للعرض
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
    <script>
        // الرسومات البيانية (كما هي سابقًا)
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

        // تصدير Excel
        document.getElementById('exportExcel').addEventListener('click', function() {
            // العثور على جدول التقرير
            const table = document.querySelector('#summary table');

            // إنشاء كتاب Excel
            const wb = XLSX.utils.table_to_book(table, {
                raw: true,
                cellDates: true
            });

            // توليد اسم الملف مع التاريخ الحالي
            const today = new Date();
            const fileName = `تقرير_مبيعات_المنتجات_${today.getFullYear()}-${today.getMonth() + 1}-${today.getDate()}.xlsx`;

            // تصدير الكتاب
            XLSX.writeFile(wb, fileName);
        });

        // تصدير PDF (يمكنك استبدال هذا بمكتبة PDF مناسبة)
        document.getElementById('exportPDF').addEventListener('click', function() {
            window.print(); // طباعة الصفحة كـ PDF
        });
    </script>
@endsection
