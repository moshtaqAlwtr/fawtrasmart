@extends('master')

@section('title')
    تقرير كشف حساب العملاء
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
                    <h2 class="content-header-title float-left mb-0">تقرير كشف حساب العملاء</h2>
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
                <form action="{{ route('ClientReport.customerAccountStatement') }}" method="GET">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="branch" class="form-label">فرع الحسابات:</label>
                            <select id="branch" name="branch" class="form-control">
                                <option value="">كل الفروع</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="account" class="form-label">حساب:</label>
                            <select id="account" name="account" class="form-control">
                                <option value="">الحساب الافتراضي</option>
                                @foreach ($accounts as $account)
                                    <option value="{{ $account->id }}">{{ $account->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="days" class="form-label">الفترة (أيام):</label>
                            <input type="number" id="days" name="days" class="form-control" value="30">
                        </div>


                        <div class="col-md-3 col-sm-6">
                            <div class="form-group">
                                <label for="financial-year">السنة المالية:</label>
                                <select id="financial-year" name="financial_year[]" class="form-control select2" multiple>
                                    <option value="current">السنة المفتوحة</option>
                                    <option value="all">جميع السنوات</option>
                                    @for ($year = date('Y'); $year >= date('Y') - 10; $year--)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="customer-type" class="form-label">تصنيف العميل:</label>
                            <select id="customer-type" name="customer_type" class="form-control">
                                <option value="">الكل</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="customer" class="form-label">العميل:</label>
                            <select id="customer" name="customer" class="form-control">
                                <option value="">الكل</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->trade_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="cost-center" class="form-label">مركز التكلفة:</label>
                            <select id="cost-center" name="cost_center" class="form-control">
                                <option value="">اختر مركز التكلفة</option>
                                @foreach ($costCenters as $costCenter)
                                    <option value="{{ $costCenter->id }}">{{ $costCenter->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="sales-manager" class="form-label">مسؤول مبيعات:</label>
                            <select id="sales-manager" name="sales_manager" class="form-control">
                                <option value="">الكل</option>
                                @foreach ($salesManagers as $manager)
                                    <option value="{{ $manager->id }}">{{ $manager->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn-custom">عرض التقرير</button>
                            <a href="{{ route('ClientReport.customerAccountStatement') }}" class="btn-custom">إلغاء
                                الفلتر</a>
                            <button type="button" class="btn-custom" onclick="exportTableToExcel()">تصدير إلى
                                Excel</button>
                            <button type="button" class="btn-custom" onclick="exportTableToPDF()">تصدير إلى PDF</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="customer-account-statement-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th rowspan="2">رقم الحساب</th>
                            <th rowspan="2">رقم القيد</th>
                            <th rowspan="2">رقم معرف التحويل</th>
                            <th rowspan="2">التاريخ</th>
                            <th rowspan="2">الموظف</th>
                            <th colspan="2">العملية</th>
                            <th colspan="2">الرصيد</th>
                        </tr>
                        <tr>
                            <th>مدين</th>
                            <th>دائن</th>
                            <th>مدين</th>
                            <th>دائن</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalBalance = 0; // متغير لتخزين الرصيد التراكمي
                            $totalDebit = 0; // مجموع المدين
                            $totalCredit = 0; // مجموع الدائن
                        @endphp
                        @foreach ($journalEntries as $entry)
                            <tr>
                                <td colspan="11">{{ $entry->client ? $entry->client->trade_name : 'غير متوفر' }}</td>
                            </tr>
                            <tr>
                                <td colspan="8">الرصيد قبل</td>
                                <td>{{ number_format($totalBalance, 2) }}</td>
                                <td></td>
                            </tr>
                            @foreach ($entry->details as $detail)
                                @php
                                    $totalBalance += $detail->debit - $detail->credit;
                                    $totalDebit += $detail->debit; // إضافة المدين للمجموع
                                    $totalCredit += $detail->credit; // إضافة الدائن للمجموع
                                @endphp
                                <tr>
                                    <td>{{ $detail->account ? $detail->account->name : 'غير متوفر' }}</td>
                                    <td>{{ $entry->reference_number }}</td>
                                    <td>{{ $entry->id }}</td>
                                    <td>{{ $entry->date->format('Y-m-d') }}</td>
                                    <td>{{ $entry->employee ? $entry->employee->full_name : 'غير متوفر' }}</td>
                                    <td>{{ number_format($detail->debit, 2) }}</td>
                                    <td>{{ number_format($detail->credit, 2) }}</td>
                                    <td>{{ number_format($totalBalance > 0 ? $totalBalance : 0, 2) }}</td>
                                    <td>{{ number_format($totalBalance < 0 ? abs($totalBalance) : 0, 2) }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tfoot>
                            <tr>
                                <td colspan="5" style="text-align: right;"><strong>المجموع:</strong></td>
                                <td>{{ number_format($totalDebit, 2) }}</td> <!-- مجموع المدين -->
                                <td>{{ number_format($totalCredit, 2) }}</td> <!-- مجموع الدائن -->
                                <td>{{ number_format($totalBalance > 0 ? $totalBalance : 0, 2) }}</td> <!-- الرصيد المدين -->
                                <td>{{ number_format($totalBalance < 0 ? abs($totalBalance) : 0, 2) }}</td> <!-- الرصيد الدائن -->
                            </tr>
                        </tfoot>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        function exportTableToExcel() {
            let downloadLink;
            const dataType = 'application/vnd.ms-excel';
            const tableSelect = document.getElementById('customer-account-statement-table');
            const tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
            const filename = 'customer_account_statement.xls';

            downloadLink = document.createElement("a");
            document.body.appendChild(downloadLink);

            if (navigator.msSaveOrOpenBlob) {
                const blob = new Blob(['\ufeff', tableHTML], {
                    type: dataType
                });
                navigator.msSaveOrOpenBlob(blob, filename);
            } else {
                downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
                downloadLink.download = filename;
                downloadLink.click();
            }
        }

        function exportTableToPDF() {
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF('l', 'mm', 'a4');

            html2canvas(document.getElementById('customer-account-statement-table')).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const imgWidth = 280;
                const imgHeight = (canvas.height * imgWidth) / canvas.width;

                doc.addImage(imgData, 'PNG', 10, 10, imgWidth, imgHeight);
                doc.save('customer_account_statement.pdf');
            });
        }
    </script>
@endsection
