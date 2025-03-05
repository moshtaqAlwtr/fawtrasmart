@extends('master')

@section('title')
    تقرير قائمة الدخل
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
                    <h2 class="content-header-title float-left mb-0">تقرير قائمة الدخل</h2>
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
            <div class="d-flex justify-content-between align-items-rtl flex-wrap">
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="filter-section">
                    <form action="{{ route('GeneralAccountReports.incomeStatement') }}" method="GET">
                        <div class="row">
                            <div class="col-md-4 col-sm-6">
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
                            <div class="col-md-4">
                                <label for="account" class="form-label">عرض جميع الحسابات:</label>
                                <select name="account" class="form-control" id="">
                                    <option value="">عرض جميع الحسابات</option>
                                    <option value="1"> عرض الحسابات التي عليها معاملات </option>
                                    <option value="2"> اخفاء الحسابات الصفرية</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="branch" class="form-label">المستويات:</label>
                                <select id="" name="branch" class="form-control">
                                    <option value="">المستويات الافتراضية</option>
                                    <option value="1">مستوى 1</option>
                                    <option value="1">مستوى 2</option>
                                    <option value="1">مستوى 3</option>
                                    <option value="1">مستوى 4</option>
                                    <option value="1">مستوى 5</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="cost-center" class="form-label">مركز التكلفة:</label>
                                <select id="cost-center" name="cost_center" class="form-control">
                                    <option value="">اختر مركز التكلفة</option>
                                    @foreach ($costCenters as $costCenter)
                                        <option value="{{ $costCenter->id }}">{{ $costCenter->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn-custom">عرض التقرير</button>
                                <a href="{{ route('GeneralAccountReports.incomeStatement') }}" class="btn-custom">إلغاء الفلتر</a>
                                <button type="button" class="btn-custom" onclick="exportTableToExcel()">تصدير إلى Excel</button>
                                <button type="button" class="btn-custom" onclick="exportTableToPDF()">تصدير إلى PDF</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-1"></i>
                        التقرير المالي التفصيلي
                    </h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th colspan="3" class="text-center bg-info text-white">
                                        <h4 class="mb-0">الإيرادات</h4>
                                    </th>
                                </tr>
                                <tr>
                                    <th>الدخل</th>
                                    <th class="text-center">الكود</th>
                                    <th class="text-right">المبلغ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($revenues)
                                    @foreach($revenues->childrenRecursive as $revenue)
                                        <tr class="{{ $loop->even ? 'table-secondary' : '' }}">
                                            <td>
                                                <span class="pl-4">{{ $revenue->name }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-primary">{{ $revenue->code }}</span>
                                            </td>
                                            <td class="text-right font-weight-bold">
                                                {{ number_format($revenue->balance, 2) }} ر.س
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr class="table-success">
                                    <th colspan="2">
                                        <span class="h5">إجمالي الإيراد</span>
                                    </th>
                                    <td class="text-right text-success h5 font-weight-bold">
                                        {{ number_format($revenues->childrenRecursive->sum('balance'), 2) }} ر.س
                                    </td>
                                </tr>
                            </tfoot>
                        </table>

                        <table class="table table-bordered table-striped table-hover mt-4">
                            <thead class="thead-light">
                                <tr>
                                    <th colspan="3" class="text-center bg-danger text-white">
                                        <h4 class="mb-0">المصروفات</h4>
                                    </th>
                                </tr>
                                <tr>
                                    <th>المصروفات</th>
                                    <th class="text-center">الكود</th>
                                    <th class="text-right">المبلغ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($expenses)
                                    @foreach($expenses->childrenRecursive as $expense)
                                        <tr class="{{ $loop->even ? 'table-secondary' : '' }}">
                                            <td>
                                                <span class="pl-4">{{ $expense->name }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-danger">{{ $expense->code }}</span>
                                            </td>
                                            <td class="text-right font-weight-bold">
                                                {{ number_format($expense->balance, 2) }} ر.س
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr class="table-danger">
                                    <th colspan="2">
                                        <span class="h5">إجمالي المصروفات</span>
                                    </th>
                                    <td class="text-right text-danger h5 font-weight-bold">
                                        {{ number_format($expenses->childrenRecursive->sum('balance'), 2) }} ر.س
                                    </td>
                                </tr>
                            </tfoot>
                        </table>

                        <table class="table table-bordered table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th colspan="3" class="text-center">
                                        <h4 class="mb-0">صافي الدخل</h4>
                                    </th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr class="table-primary">
                                    <th colspan="2">
                                        <span class="h4">صافي الدخل</span>
                                    </th>
                                    <td class="text-right text-primary h3 font-weight-bold">
                                        {{ number_format($revenues->childrenRecursive->sum('balance') - $expenses->childrenRecursive->sum('balance'), 2) }} ر.س
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
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
            const { jsPDF } = window.jspdf;
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
