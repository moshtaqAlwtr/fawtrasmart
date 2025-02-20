@extends('master')

@section('title')
    تقرير مدفوعات العملاء
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
                <h5 class="card-title">
                    @switch($reportPeriod)
                        @case('daily')
                            تقرير المدفوعات اليومية
                            @break
                        @case('weekly')
                            تقرير المدفوعات الأسبوعية
                            @break
                        @case('monthly')
                            تقرير المدفوعات الشهرية
                            @break
                        @case('yearly')
                            تقرير المدفوعات السنوية
                            @break
                    @endswitch
                </h5>

                <form action="{{ route('salesReports.clientPaymentReport') }}" method="GET">
                    <div class="row">
                        {{-- العميل --}}
                        <div class="col-md-3">
                            <label for="client">العميل:</label>
                            <select name="client" class="form-control">
                                <option value="">اختر العميل</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}"
                                        {{ request('client') == $client->id ? 'selected' : '' }}>
                                        {{ $client->trade_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- الفرع --}}
                        <div class="col-md-3">
                            <label for="branch">الفرع:</label>
                            <select name="branch" class="form-control">
                                <option value="">اختر الفرع</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}"
                                        {{ request('branch') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- طريقة الدفع --}}
                        <div class="col-md-3">
                            <label for="payment_method">طريقة الدفع:</label>
                            <select name="payment_method" class="form-control">
                                <option value="">اختر طريقة الدفع</option>
                                <option value="1" {{ request('payment_method') == '1' ? 'selected' : '' }}>نقدي</option>
                                <option value="2" {{ request('payment_method') == '2' ? 'selected' : '' }}>شيك</option>
                                <option value="3" {{ request('payment_method') == '3' ? 'selected' : '' }}>تحويل بنكي</option>
                                <option value="4" {{ request('payment_method') == '4' ? 'selected' : '' }}>بطاقة ائتمان</option>
                            </select>
                        </div>

                        {{-- الفترة --}}
                        <div class="col-md-3">
                            <label for="report_period">الفترة:</label>
                            <select name="report_period" class="form-control">
                                <option value="daily" {{ $reportPeriod == 'daily' ? 'selected' : '' }}>يومي</option>
                                <option value="weekly" {{ $reportPeriod == 'weekly' ? 'selected' : '' }}>أسبوعي</option>
                                <option value="monthly" {{ $reportPeriod == 'monthly' ? 'selected' : '' }}>شهري</option>
                                <option value="yearly" {{ $reportPeriod == 'yearly' ? 'selected' : '' }}>سنوي</option>
                            </select>
                        </div>

                        {{-- من تاريخ --}}
                        <div class="col-md-3">
                            <label for="from_date">من تاريخ:</label>
                            <input type="date" name="from_date" class="form-control"
                                value="{{ $fromDate->format('Y-m-d') }}">
                        </div>

                        {{-- إلى تاريخ --}}
                        <div class="col-md-3">
                            <label for="to_date">إلى تاريخ:</label>
                            <input type="date" name="to_date" class="form-control"
                                value="{{ $toDate->format('Y-m-d') }}">
                        </div>

                        {{-- أزرار البحث والتصدير --}}
                        <div class="col-md-12 mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> عرض التقرير
                            </button>
                            <a href="{{ route('salesReports.clientPaymentReport') }}" class="btn btn-secondary">
                                <i class="fas fa-reset"></i> إعادة تعيين
                            </a>

                            <div class="d-flex justify-content-end mb-3">
                                <a href="" class="btn btn-success me-2">
                                    <i class="fas fa-file-excel me-2"></i>تصدير اكسل
                                </a>

                                <form action="" method="GET">
                                    <button type="submit" class="btn btn-danger me-2">
                                        <i class="fas fa-file-pdf me-2"></i>تصدير PDF
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- نتائج التقرير --}}
        @if ($payments->count() > 0)
            <div class="card mt-4">
                <div class="card-body">
                    {{-- Tabs للملخص والتفاصيل --}}
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
                        {{-- Tab الملخص --}}
                        <div class="tab-pane fade show active" id="summary">
                            <div class="row">
                                <div class="col-md-6">
                                    <canvas id="quantityChart"></canvas>
                                </div>
                                <div class="col-md-6">
                                    <canvas id="amountChart"></canvas>
                                </div>
                            </div>

                            {{-- جدول الملخص --}}
                            <table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th>المعرف</th>
            <th>رقم الفاتورة</th>
            <th>التاريخ</th>
            <th>منشأ الفاتورة</th>
            <th>طريقة الدفع</th>
            <th>رقم المعرف</th>
            <th>الإجمالي</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($payments as $payment)
            <tr>
                <td>{{ $payment->id }}</td>
                <td>{{ $payment-> ?? 'غير محدد' }}</td>
                <td>{{ $payment->payment_date->format('Y-m-d') }}</td>
                <td>{{ optional($payment->employee)->name ?? 'غير محدد' }}</td>
                <td>
                    @if ($payment->payment_method=1)
                        نقدي

                    @elseif ($payment->payment_method=2)
                        شيك
                        @elseif ($payment->payment_method=3)
                        تحويل بنكي
                        @elseif ($payment->payment_method=4)
                        بطاقة ائتمان
                        @endif
                </td>
                <td>{{ $payment->reference_number ?? 'غير محدد' }}</td>
                <td>{{ number_format($payment->amount, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr class="table-primary">
            <td colspan="6" class="text-end"><strong>المجموع الكلي</strong></td>
            <td>{{ number_format($payments->sum('amount'), 2) }}</td>
        </tr>
    </tfoot>
</table>
                        </div>

                        {{-- Tab التفاصيل --}}
                        <div class="tab-pane fade" id="details">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>التاريخ</th>
                                        <th>العميل</th>
                                        <th>طريقة الدفع</th>
                                        <th>المبلغ</th>
                                        <th>رقم المرجع</th>
                                        <th>الملاحظات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payments as $payment)
                                        <tr>
                                            <td>{{ $payment->payment_date->format('Y-m-d') }}</td>
                                            <td> {{ optional($payment->client)->trade_name ?? 'عميل غير محدد' }}</td>
                                            <td>
                                                @switch($payment->payment_method)
                                                    @case(1)
                                                        نقدي
                                                        @break
                                                    @case(2)
                                                        شيك
                                                        @break
                                                    @case(3)
                                                        تحويل بنكي
                                                        @break
                                                    @case(4)
                                                        بطاقة ائتمان
                                                        @break
                                                    @default
                                                        غير محدد
                                                @endswitch
                                            </td>
                                            <td>{{ number_format($payment->amount, 2) }}</td>
                                            <td>{{ $payment->reference_number }}</td>
                                            <td>{{ $payment->notes }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
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
    <script>
        // رسم مخطط الكمية
        const quantityCtx = document.getElementById('quantityChart').getContext('2d');
        new Chart(quantityCtx, {
            type: 'bar',
            data: {
                labels: @json($chartData['labels']),
                datasets: [{
                    label: 'عدد المعاملات',
                    data: @json($chartData['quantities']),
                    backgroundColor: 'rgba(54, 162, 235, 0.6)'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'عدد المعاملات حسب العميل'
                    }
                }
            }
        });

        // رسم مخطط المبلغ
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
                        text: 'إجمالي المدفوعات حسب العميل'
                    }
                }
            }
        });

        // وظائف التصدير
        document.getElementById('exportExcel').addEventListener('click', function() {
            alert('تصدير Excel قيد التطوير');
        });

        document.getElementById('exportPDF').addEventListener('click', function() {
            alert('تصدير PDF قيد التطوير');
        });
    </script>
@endsection
