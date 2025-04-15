@extends('master')

@section('title')
    تقرير كشف حساب العملاء
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #7367F0;
            --secondary-color: #82868B;
            --success-color: #28C76F;
            --danger-color: #EA5455;
            --warning-color: #FF9F43;
            --info-color: #00CFE8;
            --dark-color: #4B4B4B;
            --light-color: #F8F8F8;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 24px 0 rgba(34, 41, 47, 0.1);
            border: none;
            margin-bottom: 20px;
        }

        .card-header {
            background-color: var(--primary-color);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 15px 20px;
        }

        .btn-custom {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: 500;
            transition: all 0.3s;
            margin: 0 5px;
        }

        .btn-custom:hover {
            background-color: #5d50e8;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(115, 103, 240, 0.3);
        }

        .btn-custom:active {
            transform: translateY(0);
        }

        .btn-custom-outline {
            background-color: transparent;
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
        }

        .btn-custom-outline:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .filter-section {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .form-control {
            border-radius: 5px;
            height: 40px;
            border: 1px solid #EBE9F1;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(115, 103, 240, 0.25);
        }

        label {
            font-weight: 500;
            color: var(--dark-color);
            margin-bottom: 5px;
        }

        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }

        .table {
            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead th {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 15px;
            text-align: center;
        }

        .table tbody td {
            padding: 12px 15px;
            vertical-align: middle;
            border-top: 1px solid #EBE9F1;
        }

        .table tbody tr:nth-child(even) {
            background-color: #F9F9F9;
        }

        .table tbody tr:hover {
            background-color: rgba(115, 103, 240, 0.1);
        }

        .table tfoot th {
            background-color: #F5F5F5;
            font-weight: bold;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }

        .customer-header {
            background-color: #E8E7FC;
            font-weight: bold;
            color: var(--dark-color);
        }

        .balance-row {
            background-color: #F0EFFD;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .col-md-3 {
                margin-bottom: 1rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-custom {
                width: 100%;
                margin-bottom: 10px;
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
                            <li class="breadcrumb-item active">كشف حساب العملاء</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><i class="fas fa-filter"></i> فلترة التقرير</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('ClientReport.customerAccountStatement') }}" method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="branch"><i class="fas fa-code-branch"></i> فرع الحسابات:</label>
                            <select id="branch" name="branch" class="form-control select2">
                                <option value="">كل الفروع</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ request('branch') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="account"><i class="fas fa-file-invoice-dollar"></i> حساب:</label>
                            <select id="account" name="account" class="form-control select2">
                                <option value="">الحساب الافتراضي</option>
                                @foreach ($accounts as $account)
                                    <option value="{{ $account->id }}" {{ request('account') == $account->id ? 'selected' : '' }}>
                                        {{ $account->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="days"><i class="far fa-calendar-alt"></i> الفترة (أيام):</label>
                            <input type="number" id="days" name="days" class="form-control" value="{{ request('days', 30) }}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="financial-year"><i class="fas fa-calendar-check"></i> السنة المالية:</label>
                            <select id="financial-year" name="financial_year[]" class="form-control select2" multiple>
                                <option value="current" {{ in_array('current', (array)request('financial_year', [])) ? 'selected' : '' }}>السنة المفتوحة</option>
                                <option value="all" {{ in_array('all', (array)request('financial_year', [])) ? 'selected' : '' }}>جميع السنوات</option>
                                @for ($year = date('Y'); $year >= date('Y') - 10; $year--)
                                    <option value="{{ $year }}" {{ in_array($year, (array)request('financial_year', [])) ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="customer-type"><i class="fas fa-tags"></i> تصنيف العميل:</label>
                            <select id="customer-type" name="customer_type" class="form-control select2">
                                <option value="">الكل</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('customer_type') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="customer"><i class="fas fa-user-tie"></i> العميل:</label>
                            <select id="customer" name="customer" class="form-control select2">
                                <option value="">الكل</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ request('customer') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->trade_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="cost-center"><i class="fas fa-money-bill-wave"></i> مركز التكلفة:</label>
                            <select id="cost-center" name="cost_center" class="form-control select2">
                                <option value="">اختر مركز التكلفة</option>
                                @foreach ($costCenters as $costCenter)
                                    <option value="{{ $costCenter->id }}" {{ request('cost_center') == $costCenter->id ? 'selected' : '' }}>
                                        {{ $costCenter->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="sales-manager"><i class="fas fa-user-cog"></i> مسؤول مبيعات:</label>
                            <select id="sales-manager" name="sales_manager" class="form-control select2">
                                <option value="">الكل</option>
                                @foreach ($salesManagers as $manager)
                                    <option value="{{ $manager->id }}" {{ request('sales_manager') == $manager->id ? 'selected' : '' }}>
                                        {{ $manager->full_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="action-buttons">
                    <button type="submit" class="btn-custom">
                        <i class="fas fa-eye"></i> عرض التقرير
                    </button>
                    <a href="{{ route('ClientReport.customerAccountStatement') }}" class="btn-custom btn-custom-outline">
                        <i class="fas fa-times"></i> إلغاء الفلتر
                    </a>
                    <button type="button" class="btn-custom" onclick="exportTableToExcel()">
                        <i class="fas fa-file-excel"></i> تصدير إلى Excel
                    </button>
                    <button type="button" class="btn-custom" onclick="exportTableToPDF()">
                        <i class="fas fa-file-pdf"></i> تصدير إلى PDF
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><i class="fas fa-file-invoice-dollar"></i> نتائج التقرير</h4>
        </div>
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
                            $totalBalance = 0;
                            $totalDebit = 0;
                            $totalCredit = 0;
                        @endphp

                        @foreach ($journalEntries as $entry)
                            <tr class="customer-header">
                                <td colspan="9">
                                    <i class="fas fa-user-circle"></i>
                                    {{ $entry->client ? $entry->client->trade_name : 'غير متوفر' }}
                                </td>
                            </tr>
                            <tr class="balance-row">
                                <td colspan="5">الرصيد قبل</td>
                                <td></td>
                                <td></td>
                                <td>{{ number_format($totalBalance, 2) }}</td>
                                <td></td>
                            </tr>
                            @foreach ($entry->details as $detail)
                                @php
                                    $totalBalance += $detail->debit - $detail->credit;
                                    $totalDebit += $detail->debit;
                                    $totalCredit += $detail->credit;
                                @endphp
                                <tr>
                                    <td>{{ $detail->account ? $detail->account->name : 'غير متوفر' }}</td>
                                    <td>{{ $entry->reference_number }}</td>
                                    <td>{{ $entry->id }}</td>
                                    <td>{{ $entry->date->format('Y-m-d') }}</td>
                                    <td>{{ $entry->createdByEmployee ? $entry->createdByEmployee->name : 'غير متوفر' }}</td>
                                    <td class="{{ $detail->debit > 0 ? 'text-danger' : '' }}">{{ number_format($detail->debit, 2) }}</td>
                                    <td class="{{ $detail->credit > 0 ? 'text-success' : '' }}">{{ number_format($detail->credit, 2) }}</td>
                                    <td class="{{ $totalBalance > 0 ? 'text-danger' : '' }}">{{ number_format($totalBalance > 0 ? $totalBalance : 0, 2) }}</td>
                                    <td class="{{ $totalBalance < 0 ? 'text-success' : '' }}">{{ number_format($totalBalance < 0 ? abs($totalBalance) : 0, 2) }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" style="text-align: right;"><strong>المجموع:</strong></td>
                            <td class="text-danger">{{ number_format($totalDebit, 2) }}</td>
                            <td class="text-success">{{ number_format($totalCredit, 2) }}</td>
                            <td class="text-danger">{{ number_format($totalBalance > 0 ? $totalBalance : 0, 2) }}</td>
                            <td class="text-success">{{ number_format($totalBalance < 0 ? abs($totalBalance) : 0, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "اختر من القائمة",
                allowClear: true
            });
        });

        function exportTableToExcel() {
            let downloadLink;
            const dataType = 'application/vnd.ms-excel';
            const tableSelect = document.getElementById('customer-account-statement-table');
            const tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
            const filename = 'customer_account_statement_' + new Date().toISOString().slice(0, 10) + '.xls';

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
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('l', 'mm', 'a4');
            const title = "تقرير كشف حساب العملاء";
            const date = new Date().toLocaleDateString('ar-EG');

            // Add title and date
            doc.setFontSize(16);
            doc.setTextColor(40);
            doc.text(title, 140, 15, null, null, 'center');

            doc.setFontSize(10);
            doc.setTextColor(100);
            doc.text("تاريخ التقرير: " + date, 140, 22, null, null, 'center');

            // Add table
            html2canvas(document.getElementById('customer-account-statement-table')).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const imgWidth = 280;
                const pageHeight = doc.internal.pageSize.height;
                const imgHeight = (canvas.height * imgWidth) / canvas.width;
                let heightLeft = imgHeight;
                let position = 30; // Start position after title

                // Add first page
                doc.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;

                // Add additional pages if needed
                while (heightLeft >= 0) {
                    position = heightLeft - imgHeight;
                    doc.addPage();
                    doc.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);
                    heightLeft -= pageHeight;
                }

                doc.save('customer_account_statement_' + new Date().toISOString().slice(0, 10) + '.pdf');
            });
        }
    </script>
@endsection
