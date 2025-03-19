@extends('master')

@section('title')
    تقرير مدفوعات العملاء
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/customer.css') }}">
@endsection

@section('content')
    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    <h2 class="content-header-title float-start mb-0">تقرير مدفوعات العملاء</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                            <li class="breadcrumb-item active">عرض</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="filter-section">
                <form method="GET" action="{{ route('ClientReport.customerPayments') }}">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="date-from" class="form-label">التاريخ من</label>
                            <input type="date" id="date-from" name="date_from" class="form-control"
                                value="{{ request('date_from') }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="date-to" class="form-label">التاريخ إلى</label>
                            <input type="date" id="date-to" name="date_to" class="form-control"
                                value="{{ request('date_to') }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="employee" class="form-label">الموظف</label>
                            <select id="employee" name="employee" class="form-select">
                                <option value="">الكل</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="client-category" class="form-label">تصنيف العميل</label>
                            <select id="client-category" name="client_category" class="form-select">
                                <option value="">الكل</option>
                                @foreach ($clientCategories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="payment-method" class="form-label">وسيلة دفع</label>
                            <select id="payment-method" name="payment_method" class="form-select">
                                <option value="">الكل</option>
                                <option value="cash">نقدي</option>
                                <option value="credit_card">بطاقة ائتمان</option>
                                <option value="bank_transfer">تحويل بنكي</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="branch" class="form-label">فرع</label>
                            <select id="branch" name="branch" class="form-select">
                                <option value="">الكل</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="tax-status" class="form-label">حالة الضريبة</label>
                            <select id="tax-status" name="tax_status" class="form-select">
                                <option value="">الكل</option>
                                <option value="with_tax">مع ضريبة</option>
                                <option value="without_tax">بدون ضريبة</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-chart-bar"></i> عرض
                                التقرير</button>
                            <button type="button" id="exportExcel" class="btn btn-success"><i
                                    class="fas fa-file-excel"></i> تصدير إلى Excel</button>
                            <a href="{{ route('ClientReport.customerPayments') }}" id="resetFilters"
                                class="btn btn-secondary"><i class="fas fa-times-circle"></i> إلغاء الفلتر</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="chart-wrapper">
                <canvas id="paymentChart"></canvas>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="paymentsTable">
                    <thead>
                        <tr class="table-primary">
                            <th>رقم المدفوعات</th>
                            <th>التاريخ</th>
                            <th>كود العميل</th>
                            <th>اسم العميل</th>
                            <th>نوع</th>
                            <th>رقم المستند</th>
                            <th>وسيلة الدفع</th>
                            <th>الخزينة ( <img src="' . asset('assets/images/Saudi_Riyal.svg') . '" alt="ريال سعودي" width="15" style="vertical-align: middle;">)</th>
                            <th>المبلغ ( <img src="' . asset('assets/images/Saudi_Riyal.svg') . '" alt="ريال سعودي" width="15" style="vertical-align: middle;">)</th>
                            <th>الفرع</th>
                            <th>الموظف</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $payment)
                            <tr>
                                <td>{{ $payment->id }}</td>
                                <td>{{ $payment->payment_date->format('d/m/Y') }}</td>
                                <td>{{ $payment->invoice->client->code ?? 'غير متوفر' }}</td>
                                <td>{{ $payment->invoice->client->trade_name ?? 'غير متوفر' }}</td>
                                <td>{{ $payment->type }}</td>
                                <td>{{ $payment->document_number }}</td>
                                <td>
                                    @if ($payment->payment_method == '1')
                                        كاش
                                    @elseif ($payment->payment_method == '2')
                                        بطاقة ائتمان
                                    @elseif ($payment->payment_method == '3')
                                        بنك
                                    @endif
                                </td>
                                <td>{{ $payment->treasury ? $payment->treasury->name : 'غير محدد' }}</td>
                                <td>{{ number_format($payment->amount, 2) }}</td>
                                <td>{{ $payment->invoice->employee->branch->name ?? 'غير متوفر' }}</td>
                                <td>{{ $payment->invoice->employee->full_name ?? 'غير متوفر' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Move this line up -->

    <script>
        // إعادة تعيين الفلتر
        document.getElementById('resetFilters').addEventListener('click', function() {
            document.getElementById('filterForm').reset();
        });

        // تصدير الجدول إلى Excel
        document.getElementById('exportExcel').addEventListener('click', function() {
            const table = document.getElementById('paymentsTable');
            const ws = XLSX.utils.table_to_sheet(table);
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Payments');
            XLSX.writeFile(wb, 'payments_report.xlsx');
        });

        // Initialize the payment chart with dynamic data
        var ctx = document.getElementById('paymentChart').getContext('2d');
        var paymentChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: @json($paymentLabels), // Assuming you pass this data from the controller
                datasets: [{
                    data: @json($paymentData), // Assuming you pass this data from the controller
                    backgroundColor: ['#28a745', '#ffc107', '#dc3545']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
    </script>

@endsection
