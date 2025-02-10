@extends('master')

@section('title')
تقارير الحسابات العامة
@stop


@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">


<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">تقارير الحسابات العامة</h2>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">الرئيسيه</a>
                        </li>
                        <li class="breadcrumb-item active">عرض
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container mt-4">
    <div class="row">
        <!-- كرت تقرير الموردين -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title text-primary"><i class="fas fa-book"></i> تقارير الحسابات العامة</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-book text-success"></i> تقرير الضرائب
                            <a href="{{route('reports.general_accounts.Tax_Report')}}" class="btn btn-link p-0">عرض</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-money-bill-alt text-info"></i> أقرار ضريبي 
                            <a href="{{route('reports.general_accounts.Tax_Declaration')}}" class="btn btn-link p-0">التفاصيل</a> | 
                            <a href="#" class="btn btn-link p-0">الملخص</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-chart-line text-warning"></i> قائمة الدخل
                            <a href="{{route('reports.general_accounts.income_Statement')}}" class="btn btn-link p-0">عرض</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-shopping-cart text-danger"></i> الميزانية العمومية
                            <a href="{{route('reports.general_accounts.Balance_Sheet')}}" class="btn btn-link p-0">عرض</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-file-invoice-dollar text-primary"></i>  الربح والخسارة 
                            <a href="{{route('reports.general_accounts.Profit_Loss')}}" class="btn btn-link p-0">عرض</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-receipt text-secondary"></i> الحركات المالية
                            <a href="{{route('reports.general_accounts.Financial_Transactions')}}" class="btn btn-link p-0">عرض</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-receipt text-secondary"></i> التدفقات النقدية
                            <a href="{{route('reports.general_accounts.Cash_Flow_Report')}}" class="btn btn-link p-0">عرض</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-receipt text-secondary"></i> الأصول 
                            <a href="{{route('reports.general_accounts.Assets')}}" class="btn btn-link p-0">عرض</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

       
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title text-primary"><i class="fas fa-user-tie"></i> تقارير القيود اليومية</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-user-tie text-danger"></i>تقرير ميزان مراجعة مجاميع وأرصدة
                            <a href="{{route('reports.general_accounts.Trial_Balance_Summary_and_Balances_Report')}}" class="btn btn-link p-0">التفاصيل</a> | 
                            <a href="#" class="btn btn-link p-0">الملخص</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-user text-success"></i> تقرير حساب مراجعة
                            <a href="{{route('reports.general_accounts.Trial_Balance_Account_Report')}}" class="btn btn-link p-0">التفاصيل</a> | 
                            <a href="#" class="btn btn-link p-0">الملخص</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-balance-scale text-white"></i>تقرير ميزان مراجعة أرصدة

                            <a href="{{route('reports.general_accounts.Trial_Balance_Balances_Report')}}" class="btn btn-link p-0">التفاصيل</a> | 
                            <a href="#" class="btn btn-link p-0">الملخص</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-user text-success"></i> حساب الأستاذ
                            <a href="{{route('reports.general_accounts.General_Ledger')}}" class="btn btn-link p-0">التفاصيل</a> | 
                            <a href="#" class="btn btn-link p-0">الملخص</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-user text-success"></i>مراكز التكلفة
                            <a href="{{route('reports.general_accounts.Cost_Centers')}}" class="btn btn-link p-0">التفاصيل</a> | 
                            <a href="#" class="btn btn-link p-0">الملخص</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-user text-success"></i> تقرير القيود
                            <a href="{{route('reports.general_accounts.Journal_Entries_Report')}}" class="btn btn-link p-0">التفاصيل</a> | 
                            <a href="#" class="btn btn-link p-0">الملخص</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-user text-success"></i> دليل الحسابات العامة
                            <a href="{{route('reports.general_accounts.General_Chart_of_Accounts')}}" class="btn btn-link p-0">التفاصيل</a> | 
                            <a href="#" class="btn btn-link p-0">الملخص</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- كرت تقارير المدفوعات -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title text-primary"><i class="fas fa-calendar-alt"></i> تقارير المصروفات بالمدة الزمنية</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-calendar-day text-info"></i> المصروفات اليومية
                            <a href="{{route('reports.general_accounts.Daily_Expenses')}}" class="btn btn-link p-0">التفاصيل</a> | 
                            <a href="#" class="btn btn-link p-0">الملخص</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-calendar-week text-warning"></i> المصروفات الأسبوعية
                            <a href="{{route('reports.general_accounts.Daily_Expenses')}}" class="btn btn-link p-0">التفاصيل</a> | 
                            <a href="#" class="btn btn-link p-0">الملخص</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-calendar-alt text-primary"></i> المصروفات الشهرية
                            <a href="{{route('reports.general_accounts.Monthly_Expenses')}}" class="btn btn-link p-0">التفاصيل</a> | 
                            <a href="#" class="btn btn-link p-0">الملخص</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-calendar-alt text-primary"></i> المصروفات السنوية
                            <a href="{{route('reports.general_accounts.Monthly_Expenses')}}" class="btn btn-link p-0">التفاصيل</a> | 
                            <a href="#" class="btn btn-link p-0">الملخص</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- كرت تقارير مشتريات المنتجات -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title text-primary"><i class="fas fa-box"></i> تقارير المصروفات المقسمة</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-box text-secondary"></i> المصروفات حسب التصنيف
                            <a href="{{route('reports.general_accounts.Expenses_By_Category')}}" class="btn btn-link p-0">التفاصيل</a> | 
                            <a href="#" class="btn btn-link p-0">الملخص</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-truck text-danger"></i> المصروفات حسب الموظف
                            <a href="{{route('reports.general_accounts.Expenses_By_Employee')}}" class="btn btn-link p-0">التفاصيل</a> | 
                            <a href="#" class="btn btn-link p-0">الملخص</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-user text-success"></i> المصروفات حسب البائع
                            <a href="{{route('reports.general_accounts.Expenses_By_Vendor')}}" class="btn btn-link p-0">التفاصيل</a> | 
                            <a href="#" class="btn btn-link p-0">الملخص</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-user text-success"></i> المصروفات حسب العميل
                            <a href="{{route('reports.general_accounts.Expenses_By_Customer')}}" class="btn btn-link p-0">التفاصيل</a> | 
                            <a href="#" class="btn btn-link p-0">الملخص</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- كرت تقارير المدفوعات -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title text-primary"><i class="fas fa-calendar-alt"></i> تقارير سندات القبض بالمدة الزمنية</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-calendar-day text-info"></i> سندات القبض اليومية
                            <a href="{{route('reports.general_accounts.Daily_Receivables')}}" class="btn btn-link p-0">التفاصيل</a> | 
                            <a href="#" class="btn btn-link p-0">الملخص</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-calendar-week text-warning"></i> سندات القبض الأسبوعية
                            <a href="{{route('reports.general_accounts.Weekly_Receivables')}}" class="btn btn-link p-0">التفاصيل</a> | 
                            <a href="#" class="btn btn-link p-0">الملخص</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-calendar-alt text-primary"></i> سندات القبض الشهرية
                            <a href="{{route('reports.general_accounts.Monthly_Receivables')}}" class="btn btn-link p-0">التفاصيل</a> | 
                            <a href="#" class="btn btn-link p-0">الملخص</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-calendar-alt text-primary"></i> سندات القبض السنوية
                            <a href="{{route('reports.general_accounts.Annual_Receivables')}}" class="btn btn-link p-0">التفاصيل</a> | 
                            <a href="#" class="btn btn-link p-0">الملخص</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- كرت تقارير مشتريات المنتجات -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title text-primary"><i class="fas fa-box"></i> تقارير سندات القبض المقسمة</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-box text-secondary"></i> سندات القبض حسب التصنيف
                            <a href="{{route('reports.general_accounts.Receivables_By_Category')}}" class="btn btn-link p-0">التفاصيل</a> | 
                            <a href="#" class="btn btn-link p-0">الملخص</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-truck text-danger"></i> سندات القبض حسب البائع
                            <a href="{{route('reports.general_accounts.Receivables_By_Vendor')}}" class="btn btn-link p-0">التفاصيل</a> | 
                            <a href="#" class="btn btn-link p-0">الملخص</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-user text-success"></i> سندات القبض حسب الموظف
                            <a href="{{route('reports.general_accounts.Receivables_By_Employee')}}" class="btn btn-link p-0">التفاصيل</a> | 
                            <a href="#" class="btn btn-link p-0">الملخص</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-user text-success"></i> سندات القبض حسب العميل
                            <a href="{{route('reports.general_accounts.Receivables_By_Customer')}}" class="btn btn-link p-0">التفاصيل</a> | 
                            <a href="#" class="btn btn-link p-0">الملخص</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection