@extends('master')

@section('title')
    تقرير مراكز التكلفة
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/report.css') }}">
    <style>
        .account-row-level-0 {
            font-weight: bold;
            background-color: #f8f9fa;
        }

        .account-row-level-1 {
            background-color: #f1f3f5;
        }

        .account-row-level-2 {
            background-color: #f8f9fa;
        }

        .btn-toggle-children {
            background: none;
            border: none;
            color: #007bff;
            cursor: pointer;
        }

        .btn-toggle-children:hover {
            color: #0056b3;
        }
    </style>
@endsection

@section('content')
    <div class="content-header row mb-3">
        <div class="content-header-left col-md-12">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2 class="content-header-title float-start mb-0">تقرير مراكز التكلفة</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('GeneralAccountReports.generalLedger') }}" method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <label for="dateRangeDropdown" class="form-label me-2">الفترة:</label>
                        <div class="d-flex align-items-center">
                            <div class="dropdown me-2">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                    id="dateRangeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    اختر الفترة
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dateRangeDropdown">
                                    <li><a class="dropdown-item" href="#"
                                            onclick="setDateRange('الأسبوع الماضي')">الأسبوع الماضي</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="setDateRange('الشهر الأخير')">الشهر
                                            الأخير</a></li>
                                    <li><a class="dropdown-item" href="#"
                                            onclick="setDateRange('من أول الشهر حتى اليوم')">من أول الشهر حتى اليوم</a></li>
                                    <li><a class="dropdown-item" href="#"
                                            onclick="setDateRange('السنة الماضية')">السنة الماضية</a></li>
                                    <li><a class="dropdown-item" href="#"
                                            onclick="setDateRange('من أول السنة حتى اليوم')">من أول السنة حتى اليوم</a></li>
                                </ul>
                            </div>
                            <input type="text" class="form-control" id="selectedDateRange" name="dateRange"
                                placeholder="الفترة المحددة" readonly value="{{ request('dateRange') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="branch" class="form-label">نوع الحسابات:</label>
                        <select id="branch" name="branch" class="form-control">
                            <option value="">حساب رئيسي </option>
                            <option value="">حساب فرعي </option>


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
                            <option value="">اضيفت بواسطة</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="branch" class="form-label">فرع القيود:</label>
                        <select id="branch" name="branch" class="form-control">
                            <option value="">كل الفروع</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="account" class="form-label">عرض جميع الحسابات:</label>
                        <select name="account" class="form-control" id="">
                            <option value="">عرض جميع الحسابات</option>
                            <option value="1"> عرض الحسابات التي عليها معاملات </option>
                            <option value="2"> اخفاء الحسابات الصفرية</option>
                        </select>


                    </div>

                    <div class="col-md-3">
                        <label for="account" class="form-label">المستويات:</label>
                        <select name="account" class="form-control" id="">
                            <option value="">المستوى الاول </option>
                            <option value="1"> المستوى الثاني </option>
                            <option value="2"> المستوى الثالث</option>
                            <option value="2"> المستوى الرابع</option>
                            <option value="2"> المستوى الخامس</option>
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

                </div>
                <div class="row mt-3">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn-custom">عرض التقرير</button>
                        <a href="{{ route('GeneralAccountReports.generalLedger') }}" class="btn-custom">إلغاء
                            الفلتر</a>
                        <button type="button" class="btn-custom" onclick="exportTableToExcel()">تصدير إلى Excel</button>
                        <button type="button" class="btn-custom" onclick="exportTableToPDF()">تصدير إلى PDF</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr class="report-results-head">
                            <th rowspan="2" class="first-column no-sort">رقم</th>
                            <th rowspan="2" class="first-column no-sort">رقم القيد</th>
                            <th rowspan="2" class="first-column no-sort">التاريخ</th>
                            <th rowspan="2" class="first-column no-sort">الموظف</th>
                            <th rowspan="2" class="no-sort">الوصف</th>
                            <th colspan="2"> العملية </th>
                            <th colspan="2"> الرصيد </th>
                        </tr>
                        <tr>
                            <td class="no-sort">مدين (SAR)</td>
                            <td class="no-sort">دائن (SAR)</td>
                            <td class="no-sort">مدين (SAR)</td>
                            <td class="no-sort">دائن (SAR)</td>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- صف "الحساب المبيعات" -->
                        @if ($salesAccount)
                            <tr>
                                <td colspan="11" class="text-center" style="font-weight: bold; background-color: #f8f9fa;">{{ $salesAccount->name }}{{$salesAccount->code}}</td>

                            </tr>
                        @endif

                        <!-- البيانات العادية -->
                        @foreach ($journalEntries as $entry)
                            @foreach ($entry->details as $detail)
                                <tr>
                                    <td>{{ $entry->id }}</td>
                                    <td>{{ $entry->reference_number }}</td>
                                    <td>{{ $entry->date }}</td>
                                    <td>{{ $entry->employee ? $entry->employee->full_name : 'غير متوفر' }}</td>
                                    <td>{{ $detail->description }}</td>
                                    <td>{{ $detail->debit }}</td>
                                    <td>{{ $detail->credit }}</td>
                                    <td>{{ $detail->account->balance }}</td>
                                    <td>{{ $detail->account->balance }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5" class="text-end">الإجمالي:</th>
                            <th>{{ $totalDebit }}</th>
                            <th>{{ $totalCredit }}</th>
                            <th>{{ $totalBalanceDebit }}</th>
                            <th>{{ $totalBalanceCredit }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>
    <script>
        // تصدير إلى Excel
        function exportTableToExcel() {
            const table = document.getElementById('generalLedgerTable');
            const workbook = XLSX.utils.table_to_book(table);
            XLSX.writeFile(workbook, 'تقرير_الأستاذ_العام.xlsx');
        }

        // تصدير إلى PDF
        function exportTableToPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            doc.autoTable({
                html: '#generalLedgerTable',
                theme: 'grid',
                headStyles: { fillColor: [41, 128, 185], textColor: 255 },
                styles: { font: 'tajawal', fontSize: 10 },
                margin: { top: 20 },
                didDrawPage: function (data) {
                    doc.text('تقرير الأستاذ العام', data.settings.margin.left, 10);
                }
            });

            doc.save('تقرير_الأستاذ_العام.pdf');
        }

        // فلترة الجدول
        document.addEventListener('DOMContentLoaded', function () {
            const filters = {
                dateRange: document.getElementById('selectedDateRange'),
                account: document.getElementById('account'),
                branch: document.getElementById('branch'),
                costCenter: document.getElementById('cost-center'),
                // أضف بقية المدخلات هنا
            };

            const tableRows = document.querySelectorAll('#generalLedgerTable tbody tr');

            function applyFilters() {
                const dateRange = filters.dateRange.value.toLowerCase();
                const account = filters.account.value.toLowerCase();
                const branch = filters.branch.value.toLowerCase();
                const costCenter = filters.costCenter.value.toLowerCase();

                tableRows.forEach(row => {
                    const rowDate = row.cells[2].textContent.toLowerCase();
                    const rowAccount = row.cells[4].textContent.toLowerCase();
                    const rowBranch = row.cells[5].textContent.toLowerCase();
                    const rowCostCenter = row.cells[6].textContent.toLowerCase();

                    const matchDate = !dateRange || rowDate.includes(dateRange);
                    const matchAccount = !account || rowAccount.includes(account);
                    const matchBranch = !branch || rowBranch.includes(branch);
                    const matchCostCenter = !costCenter || rowCostCenter.includes(costCenter);

                    if (matchDate && matchAccount && matchBranch && matchCostCenter) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            Object.values(filters).forEach(filter => {
                filter.addEventListener('change', applyFilters);
            });
        });
    </script>
@endsection
