@extends('master')

@section('title')
    تقرير ميزان المراجعة
@stop
@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/report.css') }}">
@endsection
@section('content')
<div class="content-header row mb-3">
    <div class="content-header-left col-md-12">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2 class="content-header-title float-start mb-0">{{ $pageTitle }}</h2>
            </div>
        </div>
    </div>
</div>
<div class="card">
<div class="card-body">
    <form action="{{ route('GeneralAccountReports.trialBalance') }}" method="GET">
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
                            <li><a class="dropdown-item" href="#" onclick="setDateRange('الأسبوع الماضي')">الأسبوع الماضي</a></li>
                            <li><a class="dropdown-item" href="#" onclick="setDateRange('الشهر الأخير')">الشهر الأخير</a></li>
                            <li><a class="dropdown-item" href="#" onclick="setDateRange('من أول الشهر حتى اليوم')">من أول الشهر حتى اليوم</a></li>
                            <li><a class="dropdown-item" href="#" onclick="setDateRange('السنة الماضية')">السنة الماضية</a></li>
                            <li><a class="dropdown-item" href="#" onclick="setDateRange('من أول السنة حتى اليوم')">من أول السنة حتى اليوم</a></li>
                        </ul>
                    </div>
                    <input type="text" class="form-control" id="selectedDateRange" name="dateRange" placeholder="الفترة المحددة" readonly value="{{ request('dateRange') }}">
                </div>
            </div>
            <div class="col-md-3">
                <label for="branch" class="form-label">نوع  الحسابات:</label>
                <select id="branch" name="branch" class="form-control">
                    <option value="">حساب رئيسي </option>
                    <option value="">حساب فرعي  </option>


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
                    <select id="financial-year" name="financial_year[]" class="form-control select2"
                        multiple>
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
                <a href="{{ route('GeneralAccountReports.trialBalance') }}" class="btn-custom">إلغاء
                    الفلتر</a>
                    <button type="button" class="btn-custom" onclick="exportTableToExcel()">تصدير إلى Excel</button>
                    <button type="button" class="btn-custom" onclick="exportTableToPDF()">تصدير إلى PDF</button>
            </div>
        </div>
    </form>
</div>
</div>
<div class="card">
    <div class="card-header">
        <h4>ميزان المراجعة من {{ $startDate->format('Y-m-d') }} إلى {{ $endDate->format('Y-m-d') }}</h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th rowspan="2">الاسم</th>
                    <th rowspan="2">الكود</th>
                    <th colspan="2" class="text-center">الرصيد قبل </th>
                    <th colspan="2" class="text-center">رصيد الحركات </th>
                    <th colspan="2" class="text-center">الرصيد بعد</th>
                    <th colspan="2" class="text-center">الارصدة </th>
                </tr>
                <tr>
                    <th>مدين</th>
                    <th>دائن</th>
                    <th>مدين</th>
                    <th>دائن</th>
                    <th>مدين</th>
                    <th>دائن</th>
                    <th>مدين</th>
                    <th>دائن</th>
                </tr>
            </thead>
            <tbody>
                @php
                    function renderAccountTree($accounts, $level = 0) {
                        foreach ($accounts as $account) {
                            $paddingRight = $level * 20;
                @endphp
                            <tr data-level="{{ $level }}" class="account-row">
                                <td style="padding-right: {{ $paddingRight }}px">
                                    @if(!empty($account['children']))
                                        <button class="btn btn-xs btn-toggle-children"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#children-{{ $account['id'] }}">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    @endif
                                    {{ $account['name'] }}
                                </td>
                                <td>{{ $account['code'] }}</td>
                                <td>{{ number_format($account['opening_balance_debit'], 2) }}</td>
                                <td>{{ number_format($account['opening_balance_credit'], 2) }}</td>
                                <td>{{ number_format($account['period_debit'], 2) }}</td>
                                <td>{{ number_format($account['period_credit'], 2) }}</td>
                                <td>{{ number_format($account['closing_balance_debit'], 2) }}</td>
                                <td>{{ number_format($account['closing_balance_credit'], 2) }}</td>
                                <td>{{ number_format($account['total_debit'], 2) }}</td>
                                <td>{{ number_format($account['total_credit'], 2) }}</td>
                            </tr>

                            @if(!empty($account['children']))
                                <tr>
                                    <td colspan="10" class="p-0">
                                        <div id="children-{{ $account['id'] }}" class="collapse">
                                            <table class="table table-bordered m-0">
                                                @php renderAccountTree($account['children'], $level + 1) @endphp
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                @php
                        }
                    }
                    renderAccountTree($accountTree);
                @endphp
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2">الإجمالي</th>
                    <th>{{ number_format($totals['opening_balance_debit'], 2) }}</th>
                    <th>{{ number_format($totals['opening_balance_credit'], 2) }}</th>
                    <th>{{ number_format($totals['period_debit'], 2) }}</th>
                    <th>{{ number_format($totals['period_credit'], 2) }}</th>
                    <th>{{ number_format($totals['closing_balance_debit'], 2) }}</th>
                    <th>{{ number_format($totals['closing_balance_credit'], 2) }}</th>
                    <th>{{ number_format($totals['total_debit'], 2) }}</th>
                    <th>{{ number_format($totals['total_credit'], 2) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

@endsection


@section('scripts')
<script src="{{ asset('assets/js/date_range_picker.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
$(document).ready(function() {
    $('.btn-toggle-children').click(function() {
        var $button = $(this);
        var $icon = $button.find('i');
        var $targetDiv = $($button.data('bs-target'));

        // إذا كان القسم مغلقًا (سيتم فتحه)
        if (!$targetDiv.hasClass('show')) {
            // إضافة رمز التحميل
            $icon.removeClass('fa-plus').addClass('fa-spinner fa-spin');

            // محاكاة التحميل (يمكنك استبدالها بطلب AJAX حقيقي إذا أردت)
            setTimeout(function() {
                $icon.removeClass('fa-spinner fa-spin').addClass('fa-minus');
                $targetDiv.collapse('show');
            }, 500); // تأخير 500 مللي ثانية لمحاكاة التحميل
        } else {
            // إغلاق القسم
            $icon.removeClass('fa-minus').addClass('fa-plus');
            $targetDiv.collapse('hide');
        }
    });

    // إضافة تأثير سلس لفتح وإغلاق الشجرة
    $('.collapse').on('show.bs.collapse', function() {
        $(this).parent().find('.btn-toggle-children i').removeClass('fa-plus').addClass('fa-minus');
    }).on('hide.bs.collapse', function() {
        $(this).parent().find('.btn-toggle-children i').removeClass('fa-minus').addClass('fa-plus');
    });
});

</script>


@endsection
