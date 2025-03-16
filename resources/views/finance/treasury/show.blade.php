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
            <a href="{{ route('treasury.transferCreate') }}" class="btn btn-outline-success btn-sm">
                تحويل <i class="fa fa-reply-all"></i>
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
                                <div class="card-header">

                                    <form>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>التاريخ من</label>
                                                    <input type="date" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>التاريخ إلى</label>
                                                    <input type="date" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>البحث بواسطة الحالة</label>
                                                    <select class="form-control">
                                                        <option>اختر الحالة</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>البحث بواسطة الفرع</label>
                                                    <select class="form-control">
                                                        <option>اختر الفرع</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>البحث بواسطة النوع</label>
                                                    <select class="form-control">
                                                        <option>اختر النوع</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>المبلغ من</label>
                                                    <input type="number" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>المبلغ إلى</label>
                                                    <input type="number" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-footer text-center">
                                            <button type="submit" class="btn btn-primary">بحث</button>
                                            <button type="reset" class="btn btn-secondary">إعادة تعيين</button>
                                        </div>
                                    </form>

                                </div>

                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>العملية</th>
                                                <th>الإيداع</th>
                                                <th>السحب</th>
                                                <th>الرصيد بعد</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- @foreach ($transactions as $transaction)
                                        <tr>
                                            <td>
                                                <strong>#{{ $transaction->id }}</strong>
                                                {{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}
                                                <br>
                                                {{ $transaction->description }}
                                            </td>
                                            <td style="color: green;">{{ number_format($transaction->deposit, 2) }}</td>
                                            <td style="color: red;">{{ number_format($transaction->withdraw, 2) }}</td>
                                            <td><strong>{{ number_format($transaction->balance_after, 2) }}</strong></td>
                                        </tr>
                                        @endforeach --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                        <div class="tab-pane" id="transfers" role="tabpanel">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center p-2">
                                    <div class="d-flex gap-2">
                                        <span class="hide-button-text">بحث وتصفية</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <button class="btn btn-outline-secondary btn-sm"
                                            onclick="toggleSearchFields(this)">
                                            <i class="fa fa-times"></i>
                                            <span class="hide-button-text">اخفاء</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form class="form" id="searchForm" method="GET"
                                        action="{{ route('invoices.index') }}">
                                        <div class="row g-3">
                                            <!-- 1. التاريخ (من) -->
                                            <div class="col-md-4">
                                                <label for="from_date">التاريخ من</label>
                                                <input type="date" id="from_date" class="form-control"
                                                    name="from_date" value="{{ request('from_date') }}">
                                            </div>

                                            <!-- 2. التاريخ (إلى) -->
                                            <div class="col-md-4">
                                                <label for="to_date">التاريخ إلى</label>
                                                <input type="date" id="to_date" class="form-control" name="to_date"
                                                    value="{{ request('to_date') }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="to_date">التاريخ إلى</label>
                                                <input type="date" id="to_date" class="form-control" name="to_date"
                                                    value="{{ request('to_date') }}">
                                            </div>
                                        </div>

                                        <!-- الأزرار -->
                                        <div class="form-actions mt-2">
                                            <button type="submit" class="btn btn-primary">بحث</button>
                                            <a href="{{ route('invoices.index') }}" type="reset"
                                                class="btn btn-outline-warning">إلغاء</a>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- 🔹 الجدول لعرض التحويلات -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>رقم القيد</th>
                                        <th>التاريخ</th>
                                        <th>من خزينة الى خزينة </th>

                                        <th>المبلغ</th>
                                        <th style="width: 10%">الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transfers as $transfer)
                                        <tr>
                                            <td>{{ $transfer->reference_number }}</td>
                                            <td>{{ \Carbon\Carbon::parse($transfer->date)->format('d/m/Y') }}</td>
                                            <td>
                                                @if ($transfer->details->count() > 0)
                                                    <div
                                                        class="account-flow d-flex justify-content-center align-items-center">
                                                        @foreach ($transfer->details->reverse() as $detail)
                                                            @if ($detail->account && $detail->account->name)
                                                                <a href="{{ route('accounts_chart.index', $detail->account->id) }}"
                                                                    class="btn btn-outline-primary mx-2">
                                                                    {{ $detail->account->name }}
                                                                </a>
                                                                @if (!$loop->last)
                                                                    <i
                                                                        class="fas fa-long-arrow-alt-right text-muted mx-2"></i>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <span class="text-muted">لا توجد تفاصيل</span>
                                                @endif
                                            </td>
                                            <td>{{ number_format($transfer->details->sum('debit'), 2) }}</td>
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
                                                                <a class="dropdown-item" href="{{ route('treasury.transferEdit', $transfer->id) }}">
                                                                    <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item text-danger" href="#"
                                                                    data-toggle="modal"
                                                                    data-target="#modal_DELETE_{{ $transfer->id }}">
                                                                    <i class="fa fa-trash me-2"></i>حذف
                                                                </a>
                                                            </li>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Modal delete -->
                                            <div class="modal fade text-left" id="modal_DELETE_{{ $transfer->id }}"
                                                tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header"
                                                            style="background-color: #EA5455 !important;">
                                                            <h4 class="modal-title" id="myModalLabel1"
                                                                style="color: #FFFFFF">حذف </h4>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true"
                                                                    style="color: #DC3545">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <strong>هل انت متاكد من انك تريد الحذف ؟</strong>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button"
                                                                class="btn btn-light waves-effect waves-light"
                                                                data-dismiss="modal">الغاء</button>
                                                            <a href=""
                                                                class="btn btn-danger waves-effect waves-light">تأكيد</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end delete-->
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- 🔹 تبويب سجل النشاطات -->

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
