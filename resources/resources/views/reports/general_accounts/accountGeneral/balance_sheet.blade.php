@extends('master')

@section('title')
    تقرير الميزانية العمومية
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
        .table-bordered {
            border: 1px solid #dee2e6;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.075);
        }
        .bg-info {
            background-color: #17a2b8 !important;
        }
        .bg-danger {
            background-color: #dc3545 !important;
        }
        .text-white {
            color: #fff !important;
        }
        .table-success {
            background-color: #d4edda !important;
        }
        .table-danger {
            background-color: #f8d7da !important;
        }
        .table-primary {
            background-color: #cce5ff !important;
        }
    </style>
@endsection

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">تقرير الميزانية العمومية</h2>
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
                    <form action="{{ route('GeneralAccountReports.BalanceSheet') }}" method="GET">
                        <div class="row">
                            <div class="col-md-4">
                                <label for=""> كل التواريخ قبل </label>
                                <input type="date" id="before-date" name="before_date" class="form-control" value="{{ request('before_date') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="cost-center" class="form-label">فرع الحسابات :</label>
                                <select id="cost-center" name="cost_center" class="form-control">
                                    <option value="">اختر فرع الحسابات</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ request('cost_center') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="cost-center" class="form-label">فرع القيود :</label>
                                <select id="cost-center" name="cost_center" class="form-control">
                                    <option value="">اختر فرع القيود</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ request('cost_center') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="financial-year">السنة المالية:</label>
                                    <select id="financial-year" name="financial_year[]" class="form-control select2" multiple>
                                        <option value="current" {{ in_array('current', request('financial_year', [])) ? 'selected' : '' }}>السنة المفتوحة</option>
                                        <option value="all" {{ in_array('all', request('financial_year', [])) ? 'selected' : '' }}>جميع السنوات</option>
                                        @for ($year = date('Y'); $year >= date('Y') - 10; $year--)
                                            <option value="{{ $year }}" {{ in_array($year, request('financial_year', [])) ? 'selected' : '' }}>{{ $year }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="account" class="form-label">عرض جميع الحسابات:</label>
                                <select name="account" class="form-control" id="">
                                    <option value="">عرض جميع الحسابات</option>
                                    <option value="1" {{ request('account') == '1' ? 'selected' : '' }}> عرض الحسابات التي عليها معاملات </option>
                                    <option value="2" {{ request('account') == '2' ? 'selected' : '' }}> اخفاء الحسابات الصفرية</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="branch" class="form-label">المستويات:</label>
                                <select id="" name="branch" class="form-control">
                                    <option value="">المستويات الافتراضية</option>
                                    <option value="1" {{ request('branch') == '1' ? 'selected' : '' }}>مستوى 1</option>
                                    <option value="2" {{ request('branch') == '2' ? 'selected' : '' }}>مستوى 2</option>
                                    <option value="3" {{ request('branch') == '3' ? 'selected' : '' }}>مستوى 3</option>
                                    <option value="4" {{ request('branch') == '4' ? 'selected' : '' }}>مستوى 4</option>
                                    <option value="5" {{ request('branch') == '5' ? 'selected' : '' }}>مستوى 5</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="cost-center" class="form-label">مركز التكلفة:</label>
                                <select id="cost-center" name="cost_center" class="form-control">
                                    <option value="">اختر مركز التكلفة</option>
                                    @foreach ($costCenters as $costCenter)
                                        <option value="{{ $costCenter->id }}" {{ request('cost_center') == $costCenter->id ? 'selected' : '' }}>{{ $costCenter->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn-custom">عرض التقرير</button>
                                <a href="{{ route('GeneralAccountReports.BalanceSheet') }}" class="btn-custom">إلغاء الفلتر</a>
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
                                        <h4 class="mb-0">الأصول</h4>
                                    </th>
                                </tr>
                                <tr>
                                    <th>الأصول</th>
                                    <th class="text-center">الكود</th>
                                    <th class="text-right">المبلغ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($assets)
                                    @foreach ($assets->childrenRecursive as $asset)
                                        <tr class="{{ $loop->even ? 'table-secondary' : '' }}">
                                            <td>
                                                <span class="pl-4">{{ $asset->name }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-primary">{{ $asset->code }}</span>
                                            </td>
                                            <td class="text-right font-weight-bold">
                                                {{ number_format($asset->balance, 2) }} ر.س
                                            </td>
                                        </tr>
                                        @if ($asset->childrenRecursive->count() > 0)
                                            @foreach ($asset->childrenRecursive as $childAsset)
                                                <tr class="{{ $loop->even ? 'table-secondary' : '' }}">
                                                    <td>
                                                        <span class="pl-5">{{ $childAsset->name }}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge badge-primary">{{ $childAsset->code }}</span>
                                                    </td>
                                                    <td class="text-right font-weight-bold">
                                                        {{ number_format($childAsset->balance, 2) }} ر.س
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr class="table-success">
                                    <th colspan="2">
                                        <span class="h5">إجمالي الأصول</span>
                                    </th>
                                    <td class="text-right text-success h5 font-weight-bold">
                                        {{ number_format($assets->childrenRecursive->sum('balance'), 2) }} ر.س
                                    </td>
                                </tr>
                            </tfoot>
                        </table>

                        <table class="table table-bordered table-striped table-hover mt-4">
                            <thead class="thead-light">
                                <tr>
                                    <th colspan="3" class="text-center bg-danger text-white">
                                        <h4 class="mb-0">الخصوم</h4>
                                    </th>
                                </tr>
                                <tr>
                                    <th>الخصوم</th>
                                    <th class="text-center">الكود</th>
                                    <th class="text-right">المبلغ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($liabilities)
                                    @foreach ($liabilities->childrenRecursive as $liability)
                                        <tr class="{{ $loop->even ? 'table-secondary' : '' }}">
                                            <td>
                                                <span class="pl-4">{{ $liability->name }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-danger">{{ $liability->code }}</span>
                                            </td>
                                            <td class="text-right font-weight-bold">
                                                {{ number_format($liability->balance, 2) }} ر.س
                                            </td>
                                        </tr>
                                        @if ($liability->childrenRecursive->count() > 0)
                                            @foreach ($liability->childrenRecursive as $childLiability)
                                                <tr class="{{ $loop->even ? 'table-secondary' : '' }}">
                                                    <td>
                                                        <span class="pl-5">{{ $childLiability->name }}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge badge-danger">{{ $childLiability->code }}</span>
                                                    </td>
                                                    <td class="text-right font-weight-bold">
                                                        {{ number_format($childLiability->balance, 2) }} ر.س
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr class="table-danger">
                                    <th colspan="2">
                                        <span class="h5">إجمالي الخصوم</span>
                                    </th>
                                    <td class="text-right text-danger h5 font-weight-bold">
                                        {{ number_format($liabilities->childrenRecursive->sum('balance'), 2) }} ر.س
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
