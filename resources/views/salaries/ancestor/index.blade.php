@extends('master')

@section('title')
    سلفة الراتب
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2"></i>
                <strong>{{ session('success') }}</strong>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">السلفة الراتب</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                            <li class="breadcrumb-item active"> عرض </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">


                    <div class="d-flex align-items-center gap-3">
                        <div class="btn-group">
                            <button class="btn btn-light border">
                                <i class="fa fa-chevron-right"></i>
                            </button>
                            <button class="btn btn-light border">
                                <i class="fa fa-chevron-left"></i>
                            </button>
                        </div>
                        <span class="mx-2">1 - 1 من 1</span>
                        <div class="input-group" style="width: 150px">
                            <input type="text" class="form-control text-center" value="صفحة 1 من 1">
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-gradient-secondary border dropdown-toggle" type="button">
                                الإجراءات
                            </button>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-gradient-info border">
                                <i class="fa fa-table"></i>
                            </button>
                        </div>
                    </div>
                    <div class="d-flex" style="gap: 15px">
                        <a href="{{ route('ancestor.create') }}" class="btn btn-success">
                            <i class="fa fa-plus me-2"></i>
                            أضف سلفة
                        </a>

                    </div>
                </div>
            </div>
        </div>

        <form class="form" method="GET" action="{{ route('ancestor.index') }}">
            <div class="card">
                <div class="card-body">
                    <div class="form-body row">
                        <div class="form-group col-md-4">
                            <label for="advance_search">السلف</label>
                            <input type="text" id="advance_search" class="form-control" placeholder="البحث بواسطة السلف"
                                name="advance_search" value="{{ request('advance_search') }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label>إختر فترة القسط</label>
                            <select class="form-control" name="payment_rate">
                                <option value="">إختر فترة القسط</option>
                                @foreach ($paymentRates as $key => $rate)
                                    <option value="{{ $key }}"
                                        {{ request('payment_rate') == $key ? 'selected' : '' }}>
                                        {{ $rate }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="employee_search">البحث بواسطة الموظف</label>


                            <select class="form-control"name="employee_search" value="{{ request('employee_search') }}">
                                <option>اختر الموظف</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}"
                                        {{ request('employee') == $employee->id ? 'selected' : '' }}>
                                        {{ $employee->first_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-body row">
                        <div class="form-group col-md-4">
                            <label>الدفعة القادمة (من)</label>
                            <input type="date" class="form-control text-start" name="next_payment_from"
                                value="{{ request('next_payment_from') }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label>الدفعة القادمة (إلى)</label>
                            <input type="date" class="form-control text-start" name="next_payment_to"
                                value="{{ request('next_payment_to') }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label>الحالة</label>
                            <select class="form-control" name="status">
                                <option value="">إختر الحالة</option>
                                @foreach ($statuses as $key => $status)
                                    <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="collapse {{ request()->hasAny(['branch_id', 'tag']) ? 'show' : '' }}"
                        id="advancedSearchForm">
                        <div class="form-body row">
                            <div class="form-group col-md-4">
                                <label>اختر فرع</label>
                                <select class="form-control" name="branch_id">
                                    <option value="">كل الفروع</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}"
                                            {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label>اختر وسم</label>
                                <input type="text" class="form-control" name="tag">


                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary mr-1">
                            <i class="fa fa-search"></i> بحث
                        </button>

                        <a class="btn btn-outline-secondary ml-2 mr-2" data-toggle="collapse"
                            data-target="#advancedSearchForm">
                            <i class="bi bi-sliders"></i> بحث متقدم
                        </a>

                        <a href="{{ route('ancestor.index') }}" class="btn btn-outline-warning">
                            <i class="fa fa-refresh"></i> إعادة تعيين
                        </a>
                    </div>
                </div>
            </div>
        </form>

        <div class="card">
            <div class="card-body">

                <table class="table">
                    <thead>
                        <tr>
                            <th>معرف السلفة</th>
                            <th>موظف</th>
                            <th>الأقساط المدفوعة</th>
                            <th>الدفعة القادمة</th>
                            <th>المبلغ</th>
                            <th>وسوم</th>
                            <th>ترتيب بواسطة</th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ancestors as $ancestor)
                            <tr>
                                <td>{{ $ancestor->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="btn btn-info btn-sm ms-2"
                                            style="background-color: #0dcaf0; border-color: #0dcaf0;">
                                            {{ mb_substr($ancestor->employee->full_name ?? 'غ', 0, 1, 'UTF-8') }}
                                        </div>
                                        <span class="text-primary" style="color: #0d6efd !important;">
                                            {{ $ancestor->employee->full_name }}
                                            <span style="margin-right: 4px;">#{{ $ancestor->employee->id }}</span>
                                        </span>
                                    </div>
                                </td>


                                <!-- عمود الأقساط المدفوعة -->
                                <td>
                                    {{ $ancestor->total_installments }} / {{ $ancestor->paid_installments }}
                                </td>
                                <td>{{ $ancestor->installment_start_date }}</td>

                                <td>
                                    <div style="text-align: right;">
                                        <div style="width: fit-content; margin-right: auto;">
                                            <div style="font-weight: bold; margin-bottom: 4px; position: relative;">
                                                <div style="border-bottom: 2px solid #ffc107; width: {{ ($ancestor->installment_amount / $ancestor->amount) * 100 }}%; position: absolute; bottom: -2px;"></div>
                                                <div style="border-bottom: 1px solid #dee2e6; width: fit-content;">
                                                    {{ number_format($ancestor->amount, 2) }} ر.س
                                                </div>
                                            </div>
                                            <div style="color: #666; font-size: 0.9em;">
                                                <span>{{ $ancestor->status ?? 'Paid' }}</span>
                                                <span>{{ number_format($ancestor->installment_amount, 2) }} ر.س</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td></td>
                                <td>
                                    <div class="btn-group">
                                        <div class="dropdown">
                                            <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1 btn-sm"
                                                type="button" id="dropdownMenuButton{{ $ancestor->id }}"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            </button>
                                            <div class="dropdown-menu"
                                                aria-labelledby="dropdownMenuButton{{ $ancestor->id }}">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('ancestor.show', $ancestor->id) }}">
                                                        <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('ancestor.edit', $ancestor->id) }}">
                                                        <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-danger" href="#"
                                                        data-toggle="modal"
                                                        data-target="#delete-modal-{{ $ancestor->id }}">
                                                        <i class="fa fa-trash me-2"></i>حذف
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-success" href="#"
                                                        data-toggle="modal"
                                                        data-target="#copy-modal-{{ $ancestor->id }}">
                                                        <i class="fa fa-copy me-2"></i>نسخ
                                                    </a>
                                                </li>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Delete -->
                                    <div class="modal fade" id="delete-modal-{{ $ancestor->id }}" tabindex="-1"
                                        role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">تأكيد الحذف</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>هل أنت متأكد من حذف هذه السلفة؟</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ route('ancestor.destroy', $ancestor->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">إلغاء</button>
                                                        <button type="submit" class="btn btn-danger">حذف</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Copy -->
                                    <div class="modal fade" id="copy-modal-{{ $ancestor->id }}" tabindex="-1"
                                        role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">نسخ السلفة</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>هل تريد نسخ هذه السلفة؟</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">إلغاء</button>
                                                    <a href="" class="btn btn-success">نسخ</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">لا توجد سلف</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>




    @endsection
