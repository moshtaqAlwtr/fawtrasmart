@extends('master')

@section('title')
    تقرير أقساط العملاء
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/customer.css') }}">
    <style>
        @media (max-width: 768px) {
            .col-md-3 {
                margin-bottom: 1rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">تقرير أقساط العملاء</h2>
                    <div class="breadcrumb-wrapper col-12">
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
                <form action="{{ route('ClientReport.customerInstallments') }}" method="GET">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="client" class="form-label">العميل:</label>
                            <select id="client" name="client" class="form-control">
                                <option value="">من فضلك اختر</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="category" class="form-label">القسم:</label>
                            <select id="category" name="category" class="form-control">
                                <option value="">من فضلك اختر</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="from_date" class="form-label">التاريخ من:</label>
                            <input type="date" id="from_date" name="from_date" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="to_date" class="form-label">التاريخ إلى:</label>
                            <input type="date" id="to_date" name="to_date" class="form-control">
                        </div>

                    </div>

                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label for="status" class="form-label">الحالة:</label>
                            <select id="status" name="status" class="form-control">
                                <option value="">اختر الحالة</option>
                                <option value="paid">مدفوع</option>
                                <option value="unpaid">غير مدفوع</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="branch" class="form-label">فرع:</label>
                            <select id="branch" name="branch" class="form-control">
                                <option value="">الكل</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="group_by" class="form-label">تجميع حسب:</label>
                            <select id="group_by" name="group_by" class="form-control">
                                <option value="">العميل</option>
                                <option value="branch">الفرع</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="currency" class="form-label">العملة:</label>
                            <select id="currency" name="currency" class="form-control">
                                <option value="SAR">جميع العمليات بـ (SAR)</option>
                                <option value="USD">جميع العمليات بـ (USD)</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary me-2">عرض التقرير</button>
                            <a href="{{ route('ClientReport.customerInstallments') }}" class="btn btn-secondary">إلغاء
                                الفلتر</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="action-buttons text-end mb-3">
                <button class="btn btn-success" onclick="printReport()"><i class="fas fa-print"></i> طباعة</button>
                <button class="btn btn-export export-excel" onclick="exportToExcel()"><i class="fas fa-file-excel"></i>
                    تصدير إلى Excel</button>
            </div>
            <div class="table-responsive">
                <table id="installments-table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>العميل</th>
                            <th>البريد الإلكتروني</th>
                            <th>العنوان</th>
                            <th>رقم الجوال</th>
                            <th>رقم الهاتف</th>
                            <th>تاريخ الاستحقاق</th>
                            <th>العملة</th>
                            <th>إجمالي المبلغ (SAR)</th>
                            <th>المبلغ المتبقي (SAR)</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($installments as $installment)
                            <tr>
                                <td>{{ $installment->invoice->client->trade_name }}</td>
                                <td>{{ $installment->invoice->client->email }}</td>
                                <td>{{ $installment->invoice->client->address }}</td>
                                <td>{{ $installment->invoice->client->mobile }}</td>
                                <td>{{ $installment->invoice->client->phone }}</td>
                                <td>{{ $installment->due_date }}</td>
                                <td>SAR</td>
                                <td>{{ number_format($installment->amount, 2) }}</td>
                                <td>{{ number_format($installment->amount - $installment->paid_amount, 2) }}</td>
                                <td>
                                    @if ($installment->invoice->payment_status == 1)
                                        مدفوعة بالكامل
                                    @elseif ($installment->invoice->payment_status == 2)
                                        مدفوعة جزئياً
                                    @elseif ($installment->invoice->payment_status == 3)
                                        غير مدفوعة
                                    @elseif ($installment->invoice->payment_status == 4)
                                        مستلمة
                                    @else
                                        غير معروفة
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
    <script>
        function exportToExcel() {
            const table = document.getElementById('installments-table');
            const wb = XLSX.utils.table_to_book(table, {
                sheet: "Sheet1"
            });
            XLSX.writeFile(wb, 'تقرير_أقساط_العملاء.xlsx');
        }

        function printReport() {
            window.print();
        }
    </script>
@endsection
