@extends('master')

@section('title')
    مصروفات
@stop

@section('css')
<style>
 .ex-card {
    background: linear-gradient(135deg, #4a90e2, #13d7fe); /* Gradient background */
    border-radius: 10px; /* Rounded corners */
    color: white; /* Default text color */
}

.card-title {
    font-weight: bold; /* Bold title */
}

.text-muted {
    color: rgba(255, 255, 255, 0.7); /* Muted white for labels */
}

.text-white {
    font-size: 1.5rem; /* Larger font size for totals */
}
</style>
@endsection

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">المصروفات</h2>
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
    <div class="content-body">

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                    </div>
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm mb-0">
                            <!-- زر الانتقال إلى أول صفحة -->
                            @if ($expenses->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link border-0 rounded-pill" aria-label="First">
                                        <i class="fas fa-angle-double-right"></i>
                                    </span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link border-0 rounded-pill" href="{{ $expenses->url(1) }}" aria-label="First">
                                        <i class="fas fa-angle-double-right"></i>
                                    </a>
                                </li>
                            @endif

                            <!-- زر الانتقال إلى الصفحة السابقة -->
                            @if ($expenses->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link border-0 rounded-pill" aria-label="Previous">
                                        <i class="fas fa-angle-right"></i>
                                    </span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link border-0 rounded-pill" href="{{ $expenses->previousPageUrl() }}" aria-label="Previous">
                                        <i class="fas fa-angle-right"></i>
                                    </a>
                                </li>
                            @endif

                            <!-- عرض رقم الصفحة الحالية -->
                            <li class="page-item">
                                <span class="page-link border-0 bg-light rounded-pill px-3">
                                    صفحة {{ $expenses->currentPage() }} من {{ $expenses->lastPage() }}
                                </span>
                            </li>

                            <!-- زر الانتقال إلى الصفحة التالية -->
                            @if ($expenses->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link border-0 rounded-pill" href="{{ $expenses->nextPageUrl() }}" aria-label="Next">
                                        <i class="fas fa-angle-left"></i>
                                    </a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link border-0 rounded-pill" aria-label="Next">
                                        <i class="fas fa-angle-left"></i>
                                    </span>
                                </li>
                            @endif

                            <!-- زر الانتقال إلى آخر صفحة -->
                            @if ($expenses->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link border-0 rounded-pill" href="{{ $expenses->url($expenses->lastPage()) }}" aria-label="Last">
                                        <i class="fas fa-angle-double-left"></i>
                                    </a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link border-0 rounded-pill" aria-label="Last">
                                        <i class="fas fa-angle-double-left"></i>
                                    </span>
                                </li>
                            @endif
                        </ul>
                    </nav>

                    <div>
                        <a href="#" class="btn btn-outline-dark">
                            <i class="fas fa-upload"></i>استيراد
                        </a>
                        <a href="{{ route('expenses.create') }}" class="btn btn-outline-primary">
                            <i class="fa fa-plus"></i>سند صرف
                        </a>
                    </div>

                </div>
            </div>
        </div>

        @include('layouts.alerts.error')
        @include('layouts.alerts.success')
        <div class="card ex-card shadow-sm border-light">
            <div class="card-body">
                <h5 class="card-title text-center">إجمالي المصروفات</h5>
                <div class="d-flex justify-content-between align-items-center flex-wrap">
 @php
                                            $currency = $account_setting->currency ?? 'SAR';
                                            $currencySymbol = $currency == 'SAR' || empty($currency) ? '<img src="' . asset('assets/images/Saudi_Riyal.svg') . '" alt="ريال سعودي" width="15" style="vertical-align: middle;">' : $currency;
                                        @endphp
                    <div class="text-center">
                        <p class="text-muted">آخر 7 أيام</p>
                        <h2 class="text-white">{!! $currencySymbol !!} {{ $totalLast7Days }}</h2>
                    </div>

                    <div class="text-center">
                        <p class="text-muted">آخر 30 يوم</p>
                        <h2 class="text-white">{!! $currencySymbol !!} {{ $totalLast30Days }}</h2>
                    </div>

                    <div class="text-center">
                        <p class="text-muted">آخر 365 يوم</p>
                        <h2 class="text-white">{!! $currencySymbol !!} {{ $totalLast365Days }}</h2>
                    </div>

                </div>
            </div>
        </div>
        <div class="card">
            <!-- Header Section -->
            <div class="card-header d-flex justify-content-between align-items-center p-2">
                <!-- Title -->
                <div class="d-flex gap-2">
                    <span class="hide-button-text">
                        بحث وتصفية
                    </span>
                </div>

                <!-- Buttons -->
                <div class="d-flex align-items-center gap-2">
                    <!-- Hide Button -->
                    <button class="btn btn-outline-secondary btn-sm" onclick="toggleSearchFields(this)">
                        <i class="fa fa-times"></i>
                        <span class="hide-button-text">اخفاء</span>
                    </button>

                    <!-- Advanced Search Button -->
                    <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="collapse"
                        data-bs-target="#advancedSearchForm" onclick="toggleSearchText(this)">
                        <i class="fa fa-filter"></i>
                        <span class="button-text">متقدم</span>
                    </button>
                </div>
            </div>

            <!-- Body Section -->
            <div class="card-body">
                <!-- Search Form -->
                <form class="form" id="searchForm" method="GET" action="{{ route('expenses.index') }}">
                    <div class="row g-3">
                        <!-- 1. Keyword Search -->
                        <div class="col-md-4">
                            <label for="keywords">البحث بكلمة مفتاحية</label>
                            <input type="text" id="keywords" class="form-control" placeholder="ادخل الإسم او الكود" name="keywords" value="{{ request('keywords') }}">
                        </div>

                        <!-- 2. From Date -->
                        <div class="col-md-2">
                            <label for="from_date">من تاريخ</label>
                            <input type="date" id="from_date" class="form-control" name="from_date" value="{{ request('from_date') }}">
                        </div>

                        <!-- 3. To Date -->
                        <div class="col-md-2">
                            <label for="to_date">إلى تاريخ</label>
                            <input type="date" id="to_date" class="form-control" name="to_date" value="{{ request('to_date') }}">
                        </div>

                        <!-- 4. Category -->
                        <div class="col-md-4">
                            <label for="category">التصنيف</label>
                            <select name="category" class="form-control" id="category">
                                <option value="">جميع التصنيفات</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- 5. Status -->
                        <div class="col-md-4">
                            <label for="status">الحالة</label>
                            <select name="status" class="form-control" id="status">
                                <option value="">الحالة</option>
                                <option value="1" {{ request('status') == 1 ? 'selected' : '' }}>نشط</option>
                                <option value="2" {{ request('status') == 2 ? 'selected' : '' }}>متوقف</option>
                                <option value="3" {{ request('status') == 3 ? 'selected' : '' }}>غير نشط</option>
                            </select>
                        </div>
                    </div>

                    <!-- Advanced Search Section -->
                    <div class="collapse" id="advancedSearchForm">
                        <div class="row g-3 mt-2">
                            <!-- 6. Description -->
                            <div class="col-md-4">
                                <label for="description">الوصف</label>
                                <input type="text" id="description" class="form-control" placeholder="الوصف" name="description" value="{{ request('description') }}">
                            </div>

                            <!-- 7. Vendor -->
                            <div class="col-md-4">
                                <label for="vendor">البائع</label>
                                <select name="vendor" class="form-control" id="vendor">
                                    <option value="">أي بائع</option>
                                    <option value="1" {{ request('vendor') == 1 ? 'selected' : '' }}>بائع 1</option>
                                    <option value="2" {{ request('vendor') == 2 ? 'selected' : '' }}>بائع 2</option>
                                </select>
                            </div>

                            <!-- 8. Amount From -->
                            <div class="col-md-2">
                                <label for="amount_from">أكبر مبلغ</label>
                                <input type="text" id="amount_from" class="form-control" placeholder="أكبر مبلغ" name="amount_from" value="{{ request('amount_from') }}">
                            </div>

                            <!-- 9. Amount To -->
                            <div class="col-md-2">
                                <label for="amount_to">أقل مبلغ</label>
                                <input type="text" id="amount_to" class="form-control" placeholder="أقل مبلغ" name="amount_to" value="{{ request('amount_to') }}">
                            </div>

                            <!-- 10. Created At From -->
                            <div class="col-md-2">
                                <label for="created_at_from">من تاريخ الإنشاء</label>
                                <input type="date" id="created_at_from" class="form-control" name="created_at_from" value="{{ request('created_at_from') }}">
                            </div>

                            <!-- 11. Created At To -->
                            <div class="col-md-2">
                                <label for="created_at_to">إلى تاريخ الإنشاء</label>
                                <input type="date" id="created_at_to" class="form-control" name="created_at_to" value="{{ request('created_at_to') }}">
                            </div>

                            <!-- 12. Sub Account -->
                            <div class="col-md-4">
                                <label for="sub_account">الحساب الفرعي</label>
                                <select name="sub_account" class="form-control" id="sub_account">
                                    <option value="">أي حساب</option>
                                    <option value="1" {{ request('sub_account') == 1 ? 'selected' : '' }}>حساب 1</option>
                                    <option value="2" {{ request('sub_account') == 2 ? 'selected' : '' }}>حساب 2</option>
                                </select>
                            </div>

                            <!-- 13. Added By -->
                            <div class="col-md-4">
                                <label for="added_by">أضيفت بواسطة</label>
                                <select name="added_by" class="form-control" id="added_by">
                                    <option value="">أي موظف</option>
                                    <option value="1" {{ request('added_by') == 1 ? 'selected' : '' }}>موظف 1</option>
                                    <option value="2" {{ request('added_by') == 2 ? 'selected' : '' }}>موظف 2</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions mt-2">
                        <button type="submit" class="btn btn-primary">بحث</button>
                        <a href="{{ route('expenses.index') }}" type="reset" class="btn btn-outline-warning">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">النتائج</div>
            <div class="card-body">
                @if (@isset($expenses) && !@empty($expenses) && count($expenses) > 0)
                    <table class="table">
                        <tbody>
                            @foreach ($expenses as $expense)
                                <tr>
                                    <td style="width: 80%">
                                        <p><strong>{{ $expense->expenses_category->name ?? "" }}</strong></p>
                                        <p><small>{{ $expense->date }} | {{ $expense->description }}</small></p>
                                        <img src="{{ asset('assets/uploads/expenses/'.$expense->attachments) }}" alt="img" width="100">
                                    </td>
                                    <td>
                                        <p><strong>{{ $expense->amount }} رس</strong></p>
                                        <i class="fa fa-archive"></i> <small>{{ $expense->store_id }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <div class="dropdown">
                                                <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1" type="button"id="dropdownMenuButton303" data-toggle="dropdown" aria-haspopup="true"aria-expanded="false"></button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton303">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('expenses.show',$expense->id) }}">
                                                            <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('expenses.edit',$expense->id) }}">
                                                            <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#modal_DELETE{{ $expense->id }}">
                                                            <i class="fa fa-trash me-2"></i>حذف
                                                        </a>
                                                    </li>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Modal delete -->
                                    <div class="modal fade text-left" id="modal_DELETE{{ $expense->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background-color: #EA5455 !important;">
                                                    <h4 class="modal-title" id="myModalLabel1" style="color: #FFFFFF">حذف سند صرف</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true" style="color: #DC3545">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <strong>
                                                        هل انت متاكد من انك تريد الحذف ؟
                                                    </strong>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light waves-effect waves-light" data-dismiss="modal">الغاء</button>
                                                    <a href="{{ route('expenses.delete',$expense->id) }}" class="btn btn-danger waves-effect waves-light">تأكيد</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end delete-->

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-danger text-xl-center" role="alert">
                        <p class="mb-0">
                            لا توجد سندات صرف
                        </p>
                    </div>
                @endif
                {{ $expenses->links('pagination::bootstrap-5') }}
            </div>
        </div>

    </div><!-- content-body -->
    @endsection
@section('scripts')
<script src="{{ asset('assets/js/search.js') }}"></script>
@endsection
