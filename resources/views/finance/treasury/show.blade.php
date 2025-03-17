@extends('master')

@section('title')
    خزائن وحسابات بنكية
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">خزائن وحسابات بنكية</h2>
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
        <div class="card-title p-2">
            <a href="{{ route('treasury.edit', $treasury->id) }}" class="btn btn-outline-primary btn-sm">
                تعديل <i class="fa fa-edit"></i>
            </a>
            <a href="{{ route('treasury.updateStatus', $treasury->id) }}" class="btn btn-outline-secondary btn-sm">
                @if ($treasury->is_active == 0)
                    <i class="fa fa-ban me-2 text-danger"></i> تعطيل
                @else
                    <i class="fa fa-check me-2 text-success"></i> تفعيل
                @endif
            </a>
            <a href="{{ route('treasury.transferCreate') }}" class="btn btn-outline-success btn-sm">
                تحويل <i class="fa fa-reply-all"></i>
            </a>
            <a href="{{ route('treasury.updateType', $treasury->id) }}" class="btn btn-outline-info btn-sm">
                @if ($treasury->type == 'main')
                    <i class="fa fa-star me-2 text-secondary"></i> اجعله
                    فرعي
                @else
                    <i class="fa fa-star me-2 text-secondary"></i> اجعله
                    رئيسي
                @endif
            </a>
            <a href="{{ route('treasury.destroy', $treasury->id) }}" class="btn btn-outline-danger btn-sm">
                حذف <i class="fa fa-trash"></i>
            </a>
        </div>


        <div class="content-body">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <strong>
                                @if ($treasury->type_accont == 0)
                                    <i class="fa fa-archive"></i>
                                @else
                                    <i class="fa fa-bank"></i>
                                @endif
                                {{ $treasury->name }}
                            </strong>
                        </div>

                        <div>
                            @if ($treasury->is_active == 0)
                                <div class="badge badge-pill badge-success">نشط</div>
                            @else
                                <div class="badge badge-pill badge-danger">غير نشط</div>
                            @endif
                        </div>

                        <div>
                            <small>SAR </small> <strong>{{ number_format($treasury->balance, 2) }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            @include('layouts.alerts.error')
            @include('layouts.alerts.success')

            <div class="card">
                <div class="card-body">
                    <!-- 🔹 التبويبات -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home"
                                role="tab">التفاصيل</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="transactions-tab" data-toggle="tab" href="#transactions"
                                role="tab">معاملات النظام</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="transfers-tab" data-toggle="tab" href="#transfers"
                                role="tab">التحويلات</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="activate-tab" data-toggle="tab" href="#activate" role="tab">سجل
                                النشاطات</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- 🔹 تبويب التفاصيل -->
                        <div class="tab-pane fade show active" id="home" role="tabpanel">
                            <div class="card">
                                <div class="card-header"><strong>معلومات الحساب</strong></div>
                                <div class="card-body">
                                    <table class="table">
                                        <tr>
                                            <td><small>الاسم</small> : <strong>{{ $treasury->name }}</strong></td>
                                            @if ($treasury->type_accont == 1)
                                                <td><small>اسم الحساب البنكي</small> :
                                                    <strong>{{ $treasury->name }}</strong></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td><small>النوع</small> : <strong>
                                                    @if ($treasury->type_accont == 0)
                                                        خزينة
                                                    @else
                                                        حساب بنكي
                                                    @endif
                                                </strong></td>
                                            <td><small>الحالة</small> :
                                                @if ($treasury->is_active == 0)
                                                    <div class="badge badge-pill badge-success">نشط</div>
                                                @else
                                                    <div class="badge badge-pill badge-danger">غير نشط</div>
                                                @endif
                                            </td>
                                            <td><small>المبلغ</small> : <strong
                                                    style="color: #00CFE8">{{ number_format($treasury->balance, 2) }}</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>الوصف</strong> : <small>{{ $treasury->description ?? '' }}</small>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="transactions" role="tabpanel">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center p-2">
                                    <div class="d-flex gap-2">
                                        <span class="hide-button-text">بحث وتصفية</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <button class="btn btn-outline-secondary btn-sm" onclick="toggleSearchFields(this)">
                                            <i class="fa fa-times"></i>
                                            <span class="hide-button-text">اخفاء</span>
                                        </button>
                                        <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="collapse"
                                            data-bs-target="#advancedSearchForm" onclick="toggleSearchText(this)">
                                            <i class="fa fa-filter"></i>
                                            <span class="button-text">متقدم</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form id="searchForm" action="" method="GET" class="form">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label for="from_date_1">التاريخ من</label>
                                                <input type="date" class="form-control" placeholder="من"
                                                    name="from_date_1" value="{{ request('from_date_1') }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="to_date">التاريخ إلى</label>
                                                <input type="date" class="form-control" placeholder="إلى"
                                                    name="to_date" value="{{ request('to_date') }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="date_type_2">الحالة</label>
                                                <select name="date_type_2" class="form-control">
                                                    <option value="">الحالة</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- البحث المتقدم -->
                                        <div class="collapse {{ request()->hasAny(['currency', 'total_from', 'total_to', 'date_type_1', 'date_type_2', 'item_search', 'created_by', 'sales_representative']) ? 'show' : '' }}"
                                            id="advancedSearchForm">
                                            <div class="row g-3 mt-2">
                                                <div class="col-md-4">
                                                    <label for="currencySelect">البحث بواسطة فرع</label>
                                                    <select name="currency" class="form-control" id="currencySelect">
                                                        <option value="">اختر الفرع</option>
                                                        @foreach ($branches as $branch)
                                                            <option value="{{ $branch->id }}"
                                                                {{ request('currency') == $branch->id ? 'selected' : '' }}>
                                                                {{ $branch->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="total_from">المبلغ من</label>
                                                    <input type="number" class="form-control"
                                                        placeholder="الإجمالي أكبر من" name="total_from" step="0.01"
                                                        value="{{ request('total_from') }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="total_to">المبلغ إلى</label>
                                                    <input type="number" class="form-control"
                                                        placeholder="الإجمالي أصغر من" name="total_to" step="0.01"
                                                        value="{{ request('total_to') }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="date_type_1">البحث بواسطة النوع</label>
                                                    <select name="date_type_1" class="form-control">
                                                        <option value="">اختر النوع</option>
                                                        <option value="">فاتورة</option>
                                                        <option value="">قيد يدوي</option>
                                                        <option value="">فاتورة شراء</option>
                                                        <option value="">اذن مخزني</option>
                                                        <option value="">عمليات مخزون</option>
                                                        <option value="">مدفوعات الفواتير</option>
                                                        <option value="">سندات القبض</option>
                                                        <option value="">مدفوعات المشتريات</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- الأزرار -->
                                        <div class="form-actions mt-2">
                                            <button type="submit" class="btn btn-primary">بحث</button>
                                            <a href="" type="reset" class="btn btn-outline-warning">إلغاء</a>
                                        </div>
                                    </form>
                                </div>

                                <!-- عرض جميع العمليات في جدول واحد -->
                                <h3>جميع العمليات</h3>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>العملية</th>
                                            <th>الإيداع</th>
                                            <th>السحب</th>
                                            <th>الرصيد بعد</th>
                                            <th style="width: 10%">الإجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($operationsPaginator as $operation)
                                            <tr>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <span
                                                            class="text-muted font-weight-bold">(#{{ $operation['invoice']->id ?? 'N/A' }})
                                                            {{ $operation['date'] }}</span>
                                                        <span class="text-dark">
                                                            @if ($operation['type'] === 'transaction')
                                                                مدفوعات العميل <span
                                                                    class="text-primary">#{{ $operation['client']->id ?? 'N/A' }}</span>،
                                                                فاتورة <span
                                                                    class="text-primary">#{{ $operation['invoice']->id ?? 'N/A' }}</span>
                                                            @elseif ($operation['type'] === 'transfer')
                                                                {{ $operation['operation'] }}
                                                            @elseif ($operation['type'] === 'expense')
                                                                سند صرف: {{ $operation['operation'] }}
                                                            @elseif ($operation['type'] === 'revenue')
                                                                سند قبض: {{ $operation['operation'] }}
                                                            @endif
                                                        </span>
                                                        <div class="d-flex align-items-center mt-1">
                                                            <span class="badge bg-success text-white p-1">م</span>
                                                            <span
                                                                class="mx-1">{{ $operation['client']->name ?? 'N/A' }}</span>
                                                            <i class="fa fa-building text-secondary mx-1"></i>
                                                            <span>{{ $operation['branch']->name ?? 'N/A' }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ number_format($operation['deposit'], 2) }}</td>
                                                <td>{{ number_format($operation['withdraw'], 2) }}</td>
                                                
                                                <td>{{ number_format($operation['balance_after'], 2) }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <div class="dropdown">
                                                            <button
                                                                class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1 btn-sm"
                                                                type="button" id="dropdownMenuButton303"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false"></button>
                                                            <div class="dropdown-menu"
                                                                aria-labelledby="dropdownMenuButton303">
                                                                <li>
                                                                    <a class="dropdown-item" href="">
                                                                        <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item text-danger" href="#"
                                                                        data-toggle="modal" data-target="#modal_DELETE_">
                                                                        <i class="fa fa-trash me-2"></i>حذف
                                                                    </a>
                                                                </li>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>الرصيد قبل العمليات:</strong></td>
                                            <td colspan="2">{{ number_format($initialBalance, 2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>

                                <!-- تعدد الصفحات -->
                                <nav aria-label="Page navigation">
                                    <ul class="pagination pagination-sm mb-0">
                                        @if ($operationsPaginator->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link border-0 rounded-pill" aria-label="First">
                                                    <i class="fas fa-angle-double-right"></i>
                                                </span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link border-0 rounded-pill"
                                                    href="{{ $operationsPaginator->url(1) }}" aria-label="First">
                                                    <i class="fas fa-angle-double-right"></i>
                                                </a>
                                            </li>
                                        @endif

                                        @if ($operationsPaginator->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link border-0 rounded-pill" aria-label="Previous">
                                                    <i class="fas fa-angle-right"></i>
                                                </span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link border-0 rounded-pill"
                                                    href="{{ $operationsPaginator->previousPageUrl() }}"
                                                    aria-label="Previous">
                                                    <i class="fas fa-angle-right"></i>
                                                </a>
                                            </li>
                                        @endif

                                        <li class="page-item">
                                            <span class="page-link border-0 bg-light rounded-pill px-3">
                                                صفحة {{ $operationsPaginator->currentPage() }} من
                                                {{ $operationsPaginator->lastPage() }}
                                            </span>
                                        </li>

                                        @if ($operationsPaginator->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link border-0 rounded-pill"
                                                    href="{{ $operationsPaginator->nextPageUrl() }}" aria-label="Next">
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

                                        @if ($operationsPaginator->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link border-0 rounded-pill"
                                                    href="{{ $operationsPaginator->url($operationsPaginator->lastPage()) }}"
                                                    aria-label="Last">
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
                            </div>
                        </div>
                        <div class="tab-pane fade" id="activate" role="tabpanel">
                            <p>سجل النشاطات هنا...</p>
                        </div>
                    </div> <!-- tab-content -->
                </div> <!-- card-body -->
            </div> <!-- card -->
        </div> <!-- content-body -->
    </div> <!-- card -->

@endsection

@section('scripts')
    <script src="{{ asset('assets/js/search.js') }}"></script>
@endsection
