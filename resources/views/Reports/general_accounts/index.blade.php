@extends('master')

@section('title')
    تقرير الحسابات العامة
@stop

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f9fc;
            direction: rtl;
            text-align: right;
        }

        .card {
            border: none;
            background-color: #edf2f7;
        }

        .section-title {
            background-color: #d8e3e8;
            font-weight: bold;
            padding: 15px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            font-size: 16px;
        }

        .icon-box {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }

        .icon1 {
            background: linear-gradient(45deg, #ff7e5f, #feb47b);
        }

        .icon2 {
            background: linear-gradient(45deg, #86a8e7, #91eae4);
        }

        .icon3 {
            background: linear-gradient(45deg, #00c6ff, #0072ff);
        }

        .icon4 {
            background: linear-gradient(45deg, #00f260, #0575e6);
        }

        .icon5 {
            background: linear-gradient(45deg, #f7971e, #ffd200);
        }

        .view-button {
            color: #6c757d;
            font-size: 14px;
            display: flex;
            align-items: center;
        }

        .view-button i {
            margin-left: 5px;
        }

        .list-group-item {
            padding: 15px 20px;
            background-color: #f7f9fc;
            border: none;
            border-bottom: 1px solid #ddd;
        }

        .list-group-item:last-child {
            border-bottom: none;
        }
    </style>
@endsection

@section('content')
    <div class="content-header row mb-3">
        <div class="content-header-left col-md-12">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2 class="content-header-title float-start mb-0">تقارير الحسابات العامة</h2>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper float-start">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                            <li class="breadcrumb-item active">عرض</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="section-title">
                        <i class="fas fa-file-alt ml-2"></i>
                        تقارير الحسابات العامة
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='stock_reprt_a/Inventory_sheet.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon5 ml-2"><i class="fas fa-file-invoice-dollar"></i></div>
                                تقرير الضرائب
                            </div>
                            <a href="{{ route('GeneralAccountReports.taxReport') }}" class="view-button"><i
                                    class="fas fa-eye"></i> عرض</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='stock_reprt_a/Summary_inventory_operations.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon1 ml-2"><i class="fas fa-file-signature"></i></div>
                                اقرار ضرائب
                            </div>
                            <a href="{{ route('GeneralAccountReports.taxDeclaration') }}" class="view-button"><i
                                    class="fas fa-eye"></i> عرض</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='stock_reprt_a/Inventory_sheet.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon5 ml-2"><i class="fas fa-chart-line"></i></div>
                                قائمة الدخل
                            </div>
                            <a href="{{ route('GeneralAccountReports.incomeStatement') }}" class="view-button"><i
                                    class="fas fa-eye"></i> عرض</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='stock_reprt_a/Summary_inventory_operations.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon1 ml-2"><i class="fas fa-balance-scale"></i></div>
                                الميزانية العمومية
                            </div>
                            <a href="" class="view-button"><i class="fas fa-eye"></i> عرض</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='stock_reprt_a/Inventory_sheet.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon5 ml-2"><i class="fas fa-coins"></i></div>
                                الربح و الخسارة
                            </div>
                            <a href="" class="view-button"><i class="fas fa-eye"></i> عرض</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='stock_reprt_a/Summary_inventory_operations.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon1 ml-2"><i class="fas fa-exchange-alt"></i></div>
                                الحركات المالية
                            </div>
                            <a href="" class="view-button"><i class="fas fa-eye"></i> عرض</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='stock_reprt_a/Inventory_sheet.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon5 ml-2"><i class="fas fa-money-bill-wave"></i></div>
                                تقرير التدفقات النقدية
                            </div>
                            <a href="" class="view-button"><i class="fas fa-eye"></i> عرض</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='stock_reprt_a/Summary_inventory_operations.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon1 ml-2"><i class="fas fa-building"></i></div>
                                الاصول
                            </div>
                            <a href="" class="view-button"><i class="fas fa-eye"></i> عرض</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- تقارير الموردين -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="section-title">
                        <i class="fas fa-file-alt ml-2"></i>

                        تقارير القيود اليومية
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='{{ route('GeneralAccountReports.trialBalance', ['report_type' => 'balances_summary']) }}'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon1 ml-2"><i class="fas fa-address-book"></i></div>
                                تقرير ميزان المراجعه مجاميع الارصدة
                            </div>
                            <a href="{{ route('GeneralAccountReports.trialBalance', ['report_type' => 'balances_summary']) }}"
                                class="view-button">
                                <i class="fas fa-eye"></i> عرض
                            </a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='{{ route('GeneralAccountReports.trialBalance', ['report_type' => 'account_review']) }}'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon2 ml-2"><i class="fas fa-balance-scale"></i></div>
                                تقرير حساب المراجعة
                            </div>
                            <a href="{{ route('GeneralAccountReports.trialBalance', ['report_type' => 'account_review']) }}"
                                class="view-button">
                                <i class="fas fa-eye"></i> عرض
                            </a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='Product_tracking/Track_shipment_num.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon3 ml-2"><i class="fas fa-clock"></i></div>
                                تقرير حساب مراجعة الارصدة
                            </div>
                            <a href="{{ route('GeneralAccountReports.accountBalanceReview') }}" class="view-button"><i
                                    class="fas fa-eye"></i> عرض</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='Product_tracking/Track_use_expiry_date.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon4 ml-2"><i class="fas fa-shopping-cart"></i></div>
                                حساب الاستاذ العام
                            </div>
                            <a href="{{ route('GeneralAccountReports.generalLedger') }}" class="view-button"><i class="fas fa-eye"></i> عرض</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='Product_tracking/Track_use_expiry_date.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon4 ml-2"><i class="fas fa-money-bill-wave"></i></div>
                                مراكز التكلفة
                            </div>
                            <a href="{{route('GeneralAccountReports.CostCentersReport')}}" class="view-button"><i class="fas fa-eye"></i> عرض</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='Product_tracking/Track_use_expiry_date.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon4 ml-2"><i class="fas fa-file-invoice"></i></div>
                                تقرير القيود
                            </div>
                            <a href="{{route('GeneralAccountReports.ReportJournal')}}" class="view-button"><i
                                    class="fas fa-eye"></i> عرض</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='Product_tracking/Track_use_expiry_date.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon4 ml-2"><i class="fas fa-file-invoice"></i></div>
                                دليل الحسابات العامة
                            </div>
                            <a href="{{route('GeneralAccountReports.ChartOfAccounts')}}" class="view-button"><i
                                    class="fas fa-eye"></i> عرض</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="section-title">
                        <i class="fas fa-file-alt ml-2"></i>

                        تقارير المصاريف المقسمة
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='stock_reprt_a/Inventory_sheet.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon5 ml-2"><i class="fas fa-box"></i></div>
                                مصروفات حسب التصنيف
                            </div>
                            <a href="{{ route('GeneralAccountReports.splitExpensesByCategory') }}" class="view-button"><i
                                    class="fas fa-eye"></i> عرض</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='stock_reprt_a/Summary_inventory_operations.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon1 ml-2"><i class="fas fa-truck"></i></div>
                                مصروفات حسب البائع
                            </div>
                            <a href="{{ route('GeneralAccountReports.splitExpensesBySeller') }}" class="view-button"><i
                                    class="fas fa-eye"></i> عرض</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='stock_reprt_a/Summary_inventory_operations.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon1 ml-2"><i class="fas fa-user"></i></div>
                                مصروفات حسب الموضف
                            </div>
                            <a href="{{ route('GeneralAccountReports.splitExpensesByEmployee') }}" class="view-button"><i
                                    class="fas fa-eye"></i> عرض</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='stock_reprt_a/Summary_inventory_operations.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon1 ml-2"><i class="fas fa-user"></i></div>
                                مصروفات حسب العميل
                            </div>
                            <a href="{{ route('GeneralAccountReports.splitExpensesByClient') }}" class="view-button"><i
                                    class="fas fa-eye"></i> عرض</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- تقارير المدفوعات بالمدة الزمنية -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="section-title">
                        <i class="fas fa-file-alt ml-2"></i>
                        تقارير المصروفات بالمدة الزمنية
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href=''">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon1 ml-2"><i class="fas fa-sun"></i></div>
                                المصروفات اليومية
                            </div>
                            <a href="{{ route('GeneralAccountReports.splitExpensesByTimePeriod', ['period' => 'daily']) }}"
                                class="view-button"><i class="fas fa-eye"></i> عرض</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href=''">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon2 ml-2"><i class="fas fa-calendar-week"></i></div>
                                المصروفات الاسبوعية
                            </div>
                            <a href="{{ route('GeneralAccountReports.splitExpensesByTimePeriod', ['period' => 'weekly']) }}"
                                class="view-button"><i class="fas fa-eye"></i> عرض</a>
                        </li>
                        <l class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href=''">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon3 ml-2"><i class="fas fa-calendar-alt"></i></div>
                                المصروفات الشهرية
                            </div>
                            <a href="{{ route('GeneralAccountReports.splitExpensesByTimePeriod', ['period' => 'monthly']) }}"
                                class="view-button"><i class="fas fa-eye"></i> عرض</a>
                        </l i>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href=''">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon4 ml-2"><i class="fas fa-calendar-check"></i></div>
                                المدفوعات السنوية
                            </div>
                            <a href="{{ route('GeneralAccountReports.splitExpensesByTimePeriod', ['period' => 'yearly']) }}"
                                class="view-button"><i class="fas fa-eye"></i> عرض</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">



            <!-- تقارير المدفوعات بالمدة الزمنية -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="section-title">
                        <i class="fas fa-file-alt ml-2"></i>
                        تقارير المصروفات بالمدة الزمنية
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='Product_tracking/Track_expiry_date.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon1 ml-2"><i class="fas fa-sun"></i></div>
                                سندات القبض حسب التصنيف
                            </div>
                            <a href="{{ route('GeneralAccountReports.ReceiptByCategory') }}" class="view-button"><i
                                    class="fas fa-eye"></i> عرض</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='Product_tracking/Track_serial_num.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon2 ml-2"><i class="fas fa-calendar-week"></i></div>
                                سندات القبض حسب البائع
                            </div>
                            <a href="{{ route('GeneralAccountReports.ReceiptBySeller') }}" class="view-button"><i
                                    class="fas fa-eye"></i> عرض</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='Product_tracking/Track_shipment_num.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon3 ml-2"><i class="fas fa-calendar-alt"></i></div>
                                سندات القبض حسب الموضف
                            </div>
                            <a href="{{ route('GeneralAccountReports.ReceiptByEmployee') }}" class="view-button"><i
                                    class="fas fa-eye"></i> عرض</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='Product_tracking/Track_use_expiry_date.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon4 ml-2"><i class="fas fa-calendar-check"></i></div>
                                سندات القبض حسب العميل
                            </div>
                            <a href="{{ route('GeneralAccountReports.ReceiptByClient') }}" class="view-button"><i
                                    class="fas fa-eye"></i> عرض</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="section-title">
                        <i class="fas fa-file-alt ml-2"></i>
                        تقرير سندات القبض المقسمة
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='stock_reprt_a/Inventory_sheet.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon5 ml-2"><i class="fas fa-box"></i></div>
                                سندات القبض اليومية
                            </div>
                            <a href="{{ route('GeneralAccountReports.ReceiptByTimePeriod', ['reportPeriod' => 'daily']) }}"
                                class="view-button"><i class="fas fa-eye"></i> عرض</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='stock_reprt_a/Summary_inventory_operations.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon1 ml-2"><i class="fas fa-truck"></i></div>
                                سندات القبض الاسبوعية
                            </div>
                            <a href="{{ route('GeneralAccountReports.ReceiptByTimePeriod', ['reportPeriod' => 'weekly']) }}"
                                class="view-button"><i class="fas fa-eye"></i> عرض</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='stock_reprt_a/Summary_inventory_operations.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon1 ml-2"><i class="fas fa-user"></i></div>
                                سندات القبض الشهرية
                            </div>
                            <a href="{{ route('GeneralAccountReports.ReceiptByTimePeriod', ['reportPeriod' => 'monthly']) }}"
                                class="view-button"><i class="fas fa-eye"></i> عرض</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            onclick="window.location.href='stock_reprt_a/Summary_inventory_operations.html'">
                            <div class="d-flex align-items-center">
                                <div class="icon-box icon1 ml-2"><i class="fas fa-user"></i></div>
                                سندات القبض السنوية
                            </div>
                            <a href="{{ route('GeneralAccountReports.ReceiptByTimePeriod', ['reportPeriod' => 'yearly']) }}"
                                class="view-button"><i class="fas fa-eye"></i> عرض</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
