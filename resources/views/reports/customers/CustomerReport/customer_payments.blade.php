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
                            <option value="cashier">خزينة</option>
                            <option value="sales_manager">مدير المبيعات</option>
                            <option value="billing_staff">موظف الفواتير</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="client-category" class="form-label">تصنيف العميل</label>
                        <select id="client-category" name="client_category" class="form-select">
                            <option value="">الكل</option>
                            <option value="individual">عملاء أفراد</option>
                            <option value="corporate">شركات</option>
                            <option value="suppliers">موردين</option>
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
                            <option value="main">Main Branch</option>
                            <option value="branch2">فرع 2</option>
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
                        <button type="submit" class="btn btn-primary"><i class="fas fa-chart-bar"></i> عرض التقرير</button>
                        <button type="button" id="resetFilters" class="btn btn-secondary"><i
                                class="fas fa-times-circle"></i> إلغاء الفلتر</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>

        <!-- Report Title Section -->

        <div class="card">
            <div class="card-body">
                <div class="report-section">
                    <div class="header-section">
                        <h5 class="card-title">مدفوعات العملاء - تجميع حسب العمل</h5>
                        <p class="card-text">الوقت: {{ now()->format('H:i') }} | التاريخ: {{ now()->format('d/m/Y') }}</p>
                        <p class="card-text"><i class="fas fa-building"></i> مؤسسة أعمال خاصة للتجارة</p>
                        <p class="card-text"><i class="fas fa-map-marker-alt"></i> الرياض - الرياض</p>
                    </div>
                </div>
            </div>
        </div>

               <div class="card">
                <div class="card-body">
                <div class="table-section">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr class="table-primary">
                                <th>رقم المدفوعات</th>
                                <th>التاريخ</th>
                                <th>كود العميل</th>
                                <th>اسم العميل</th>
                                <th>نوع</th>
                                <th>رقم المستند</th>
                                <th>وسيلة الدفع</th>
                                <th>الخزينة (ريال سعودي)</th>
                                <th>المبلغ (ريال سعودي)</th>
                                <th>الفرع</th>
                                <th>الموظف</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tbody>
                            @foreach ($payments as $payment)
                                <tr>
                                    <td>{{ $payment->id }}</td>
                                    <td>{{ $payment->payment_date->format('d/m/Y') }}</td>
                                    <td>{{ $payment->invoice->client->code }}</td>
                                    <td>{{ $payment->invoice->client->trade_name }}</td>
                                    <td></td>
                                    <td>{{ $payment->document_number }}</td>
                                    <td>
                                        @if ($payment->Payment_method == '1')
                                            كاش
                                        @elseif ($payment->Payment_method == '2')
                                            بطاقة ايتمان
                                        @elseif ($payment->Payment_method == '3')
                                            بنك
                                        @endif
                                    </td>
                                    <td>{{ $payment->treasury ? $payment->treasury->name : 'غير محدد' }}</td>
                                    <td>{{ number_format($payment->amount, 2) }}</td>
                                    <td>{{ $payment->invoice->employee->branch->name }}</td>
                                    <td>{{ $payment->invoice->employee->full_name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endsection

        @section('scripts')
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <script>
                // إعادة تعيين الفلتر
                document.getElementById('resetFilters').addEventListener('click', function() {
                    document.getElementById('filterForm').reset();
                });
            </script>
        @endsection
