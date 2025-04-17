@extends('master')

@section('title')
    ادارة المواعيد
@stop

@section('css')

    <style>
        /* إضافة CSS للتجاوب مع أحجام الشاشات المختلفة */
        @media (max-width: 575.98px) {
            .min-mobile {
                display: table-cell;
            }


            .fixed-status-menu {
                position: fixed;
                left: 20px;
                top: 50%;
                transform: translateY(-50%);
                z-index: 1000;
                background: white;
                border-radius: 8px;
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
                padding: 10px 0;
                width: 180px;
            }

            .status-menu-item {
                padding: 8px 15px;
                display: flex;
                align-items: center;
                cursor: pointer;
                transition: all 0.3s;
            }

            .status-menu-item:hover {
                background-color: #f8f9fa;
            }

            .status-menu-item i {
                margin-left: 8px;
                font-size: 14px;
            }

            .status-menu-item .text-danger {
                color: #dc3545;
            }

            .status-menu-item .text-success {
                color: #28a745;
            }

            .status-menu-item .text-warning {
                color: #ffc107;
            }

            .status-menu-item .text-info {
                color: #17a2b8;
            }

            .status-menu-item .text-primary {
                color: #007bff;
            }

            .min-tablet {
                display: none;
            }

            .min-desktop {
                display: none;
            }
        }

        @media (min-width: 576px) and (max-width: 991.98px) {
            .min-mobile {
                display: table-cell;
            }

            .min-tablet {
                display: table-cell;
            }

            .min-desktop {
                display: none;
            }
        }

        @media (min-width: 992px) {
            .min-mobile {
                display: table-cell;
            }

            .min-tablet {
                display: table-cell;
            }

            .min-desktop {
                display: table-cell;
            }
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .dropdown-menu {
            position: absolute;
            right: 0;
            left: auto;
        }

        /* عشان نخلي القائمة ثابتة على الشاشة وقت ما تظهر */
        .fixed-dropdown-menu {
            position: fixed !important;
            top: 100px;
            /* عدّل حسب المكان المناسب */
            right: 120px;
            /* تزحزح نحو اليسار */
            z-index: 1050;
            /* عشان تبقى فوق كل العناصر */
        }
    </style>

@endsection

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2"></i>
                <strong>{{ session('success') }}</strong>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @include('layouts.alerts.success')
    @include('layouts.alerts.error')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">ادارة المواعيد</h2>
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
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <!-- Checkbox لتحديد الكل -->
                    <div class="form-check me-3">.
                        <input class="form-check-input" type="checkbox" id="selectAll" onclick="toggleSelectAll()">

                    </div>

                    <div class="d-flex flex-wrap justify-content-between">
                        <a href="{{ route('appointments.create') }}" class="btn btn-success btn-sm flex-fill me-1 mb-1">
                            <i class="fas fa-plus-circle me-1"></i> موعد جديد
                        </a>

                        <button class="btn btn-outline-primary btn-sm flex-fill mb-1">
                            <i class="fas fa-cloud-upload-alt me-1"></i>استيراد
                        </button>
                    </div>
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm mb-0">
                            <!-- زر الانتقال إلى أول صفحة -->
                            @if ($appointments->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link border-0 rounded-pill" aria-label="First">
                                        <i class="fas fa-angle-double-right"></i>
                                    </span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link border-0 rounded-pill" href="{{ $appointments->url(1) }}"
                                        aria-label="First">
                                        <i class="fas fa-angle-double-right"></i>
                                    </a>
                                </li>
                            @endif

                            <!-- زر الانتقال إلى الصفحة السابقة -->
                            @if ($appointments->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link border-0 rounded-pill" aria-label="Previous">
                                        <i class="fas fa-angle-right"></i>
                                    </span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link border-0 rounded-pill" href="{{ $appointments->previousPageUrl() }}"
                                        aria-label="Previous">
                                        <i class="fas fa-angle-right"></i>
                                    </a>
                                </li>
                            @endif

                            <!-- عرض رقم الصفحة الحالية -->
                            <li class="page-item">
                                <span class="page-link border-0 bg-light rounded-pill px-3">
                                    صفحة {{ $appointments->currentPage() }} من {{ $appointments->lastPage() }}
                                </span>
                            </li>

                            <!-- زر الانتقال إلى الصفحة التالية -->
                            @if ($appointments->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link border-0 rounded-pill" href="{{ $appointments->nextPageUrl() }}"
                                        aria-label="Next">
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
                            @if ($appointments->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link border-0 rounded-pill"
                                        href="{{ $appointments->url($appointments->lastPage()) }}" aria-label="Last">
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

                    <!-- جزء التنقل بين الصفحات -->

                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <h4 class="card-title">بحث</h4>


                    <div class="card-body">
                        <form class="form" action="{{ route('appointments.index') }}" method="GET">
                            <div class="form-body row">
                                <div class="form-group col-md-4">
                                    <label for=""> اختر الاجراء</label>
                                    <select name="status" id="feedback2" class="form-control">
                                        <option value="">-- اختر الحالة --</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>تم
                                            جدولته</option>
                                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                                            تم</option>
                                        <option value="ignored" {{ request('status') == 'ignored' ? 'selected' : '' }}>صرف
                                            النظر عنه</option>
                                        <option value="rescheduled"
                                            {{ request('status') == 'rescheduled' ? 'selected' : '' }}>تم جدولته مجددا
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="sales_person_user">مسؤول المبيعات (المستخدمين)</label>
                                    <select name="sales_person_user" class="form-control" id="sales_person_user">
                                        <option value="">مسؤول المبيعات</option>
                                        @foreach ($employees as $user)
                                            <option value="{{ $user->id }}"
                                                {{ request('sales_person_user') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="time" class="form-label">اختار الحالة </label>
                                    <select class="form-control" name="status_id">
                                        <option value="">-- اختر الحالة --</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->id }}"
                                                {{ request('status_id') == $status->id ? 'selected' : '' }}>
                                                {{ $status->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="collapse" id="advancedSearchForm">
                                <div class="form-body row d-flex align-items-center g-0">
                                    <div class="form-group col-md-2">
                                        <select name="action_type" class="form-control">
                                            <option value="">نوع الإجراء</option>
                                            @foreach ($actionTypes as $type)
                                                <option value="{{ $type }}"
                                                    {{ request('action_type') == $type ? 'selected' : '' }}>
                                                    {{ $type }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-2">
                                        <input type="date" class="form-control" placeholder="من" name="from_date"
                                            value="{{ request('from_date') }}">
                                    </div>

                                    <div class="form-group col-md-2">
                                        <input type="date" class="form-control" placeholder="إلى" name="to_date"
                                            value="{{ request('to_date') }}">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <select name="client_id" class="form-control">
                                            <option value="">العميل</option>
                                            @if (isset($clients) && !empty($clients) && count($clients) > 0)
                                                @foreach ($clients as $client)
                                                    <option value="{{ $client->id }}"
                                                        {{ request('client_id') == $client->id ? 'selected' : '' }}>
                                                        {{ $client->trade_name }} {{ $client->last_name }}
                                                    </option>
                                                @endforeach
                                            @else
                                                <option value="">لا توجد عملاء حاليا</option>
                                            @endif
                                        </select>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <select name="employee_id" class="form-control">
                                            <option value="">أضيفت بواسطة</option>
                                            @if (isset($employees) && !empty($employees) && count($employees) > 0)
                                                @foreach ($employees as $employee)
                                                    <option value="{{ $employee->id }}"
                                                        {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                                                        {{ $employee->name }}
                                                    </option>
                                                @endforeach
                                            @else
                                                <option value="">لا توجد موظفين حاليا</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary mr-1 waves-effect waves-light">بحث</button>
                                <a class="btn btn-outline-secondary ml-2 mr-2" data-toggle="collapse"
                                    data-target="#advancedSearchForm">
                                    <i class="bi bi-sliders"></i> بحث متقدم
                                </a>
                                <a href="{{ route('appointments.index') }}"
                                    class="btn btn-outline-warning waves-effect waves-light">إلغاء</a>
                            </div>
                        </form>
                    </div>






                </div>
            </div>
        </div>
        @if (@isset($appointments) && !@empty($appointments) && count($appointments) > 0)
            <div class="card">
                <div class="card-body">
                    <div class="table"> <!-- إضافة div لجعل الجدول متجاوبًا -->
                        <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                            <thead class="bg-light">
                                <tr>
                                    <th class="min-mobile">اسم العميل</th>
                                    <th class="min-tablet">حالة العميل</th>
                                    <th class="min-tablet">رقم الهاتف</th>
                                    <th class="min-mobile">التاريخ</th>
                                    <th class="min-tablet">الوقت</th>
                                    <th class="min-desktop">المدة</th>
                                    <th class="min-tablet">الموظف</th>
                                    <th class="min-mobile">الحالة</th>
                                    <th style="width: 80px">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($appointments as $info)
                                    <tr>
                                        <td class="min-mobile">{{ $info->client->trade_name }}</td>
                                        <td class="min-tablet">
                                            @if ($info->client->status_client)
                                            <span
                                                style="background-color: {{ $info->client->status_client->color }}; color: #fff; padding: 2px 8px; font-size: 12px; border-radius: 4px; display: inline-block;">
                                                {{ $info->client->status_client->name }}
                                            </span>
                                        @else
                                            <span
                                                style="background-color: #6c757d; color: #fff; padding: 2px 8px; font-size: 12px; border-radius: 4px; display: inline-block;">
                                                غير محدد
                                            </span>
                                        @endif
                                        </td>
                                        <td class="min-tablet">{{ $info->client->phone }}</td>
                                        <td class="min-mobile">
                                            {{ \Carbon\Carbon::parse($info->appointment_date)->format('Y-m-d') }}</td>
                                        <td class="min-tablet">{{ $info->time }}</td>
                                        <td class="min-desktop">{{ $info->duration ?? 'غير محدد' }}</td>
                                        <td class="min-tablet">
                                            {{ $info->createdBy ? $info->createdBy->name : 'غير محدد' }}</td>
                                        <td class="min-mobile">
                                            <span
                                                class="badge
                                    {{ $info->status == 1
                                        ? 'bg-warning'
                                        : ($info->status == 2
                                            ? 'bg-success'
                                            : ($info->status == 3
                                                ? 'bg-danger'
                                                : 'bg-info')) }}">
                                                {{ $info->status == 1
                                                    ? 'قيد الانتظار'
                                                    : ($info->status == 2
                                                        ? 'مكتمل'
                                                        : ($info->status == 3
                                                            ? 'ملغي'
                                                            : 'معاد جدولته')) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <div class="dropdown">
                                                    <button class="btn btn-sm bg-gradient-info fa fa-ellipsis-v"
                                                        type="button" id="dropdownMenuButton{{ $info->id }}"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                    </button>

                                                    <ul class="dropdown-menu dropdown-menu-end show"
                                                        aria-labelledby="dropdownMenuButton{{ $info->id }}"
                                                        style="position: fixed; top: 100px; right: 120px; z-index: 1050;">



                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('appointments.edit', $info->id) }}">
                                                                <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                            </a>
                                                        </li>

                                                        <form
                                                            action="{{ route('appointments.update-status', $info->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="1">
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="fa fa-clock me-2 text-warning"></i>تم جدولته
                                                            </button>
                                                        </form>

                                                        <form
                                                            action="{{ route('appointments.update-status', $info->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="2">
                                                            <input type="hidden" name="auto_delete" value="1">
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="fa fa-check me-2 text-success"></i>تم
                                                            </button>
                                                        </form>

                                                        <form
                                                            action="{{ route('appointments.update-status', $info->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="3">
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="fa fa-times me-2 text-danger"></i>صرف النظر عنه
                                                            </button>
                                                        </form>

                                                        <form
                                                            action="{{ route('appointments.update-status', $info->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="4">
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="fa fa-redo me-2 text-info"></i>تم جدولته مجددا
                                                            </button>
                                                        </form>

                                                        <li>
                                                            <form action="{{ route('appointments.destroy', $info->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger"
                                                                    onclick="return confirm('هل أنت متأكد من حذف هذا الموعد؟')">
                                                                    <i class="fa fa-trash me-2"></i>حذف
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-info text-center">
                <p class="mb-0">لا توجد مواعيد مسجلة حالياً</p>
            </div>
        @endif

    </div>
    </div>
    </div>




@endsection


@section('scripts')
    <script src="{{ asset('assets/js/applmintion.js') }}"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection
