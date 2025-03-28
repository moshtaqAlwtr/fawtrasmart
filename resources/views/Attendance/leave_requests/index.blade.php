@extends('master')

@section('title')
    طلبات الأجازة
@stop

@section('content')

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">طلبات الأجازة</h2>
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

    @include('layouts.alerts.success')
    @include('layouts.alerts.error')

    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <div class="card-title">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <!-- التبويبات -->
                        <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all"
                                    type="button" role="tab" aria-controls="all" aria-selected="true">الكل</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending"
                                    type="button" role="tab" aria-controls="pending" aria-selected="false">تحت
                                    المراجعة</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved"
                                    type="button" role="tab" aria-controls="approved" aria-selected="false">موافق
                                    عليه</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#rejected"
                                    type="button" role="tab" aria-controls="rejected"
                                    aria-selected="false">مرفوض</button>
                            </li>
                        </ul>

                        <!-- الأزرار -->
                        <div>
                            <div>
                                <a href="{{ route('attendance.leave_requests.create') }}" class="btn btn-outline-success">
                                    <i class="fa fa-plus me-2"></i>أضف طلب الأجازة
                                </a>

                                <button class="btn btn-outline-primary">
                                    <i class="fa fa-calendar-alt me-2"></i>رصيد الأجازات
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
                    <form class="form" id="searchForm" method="GET"
                        action="{{ route('attendance.leave_requests.index') }}">
                        <div class="row g-3">
                            <!-- البحث بالرقم التعريفي -->
                            <div class="col-md-4">
                                <label for="employee_id">الموظف</label>
                                <select name="employee_id" class="form-control select2" id="employee_id">
                                    <option value="">اختر الموظف</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- نوع الطلب -->
                            <div class="col-md-4">
                                <label for="request_type">النوع</label>
                                <select name="request_type" class="form-control" id="request_type">
                                    <option value="">اختر النوع</option>
                                    <option value="leave" {{ request('request_type') == 'leave' ? 'selected' : '' }}>إجازة
                                    </option>
                                    <option value="emergency"
                                        {{ request('request_type') == 'emergency' ? 'selected' : '' }}>طارئة</option>
                                    <option value="sick" {{ request('request_type') == 'sick' ? 'selected' : '' }}>مرضية
                                    </option>
                                </select>
                            </div>

                            <!-- تاريخ من -->
                            <div class="col-md-4">
                                <label for="from_date">تاريخ من</label>
                                <input type="date" id="from_date" class="form-control" name="from_date"
                                    value="{{ request('from_date') }}">
                            </div>

                            <!-- تاريخ إلى -->
                            <div class="col-md-4">
                                <label for="to_date">تاريخ الى</label>
                                <input type="date" id="to_date" class="form-control" name="to_date"
                                    value="{{ request('to_date') }}">
                            </div>

                            <!-- نوع الإجازة -->
                            <div class="col-md-4">
                                <label for="leave_type">نوع الإجازة</label>
                                <select name="leave_type" class="form-control" id="leave_type">
                                    <option value="">اختر نوع الإجازة</option>
                                    @foreach ($leaveTypes as $type)
                                        <option value="{{ $type->id }}"
                                            {{ request('leave_type') == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- البحث المتقدم -->
                        <div class="collapse" id="advancedSearchForm">
                            <div class="row g-3 mt-2">
                                <!-- الحالة -->
                                <div class="col-md-4">
                                    <label for="status">الحالة</label>
                                    <select name="status" class="form-control" id="status">
                                        <option value="">اختر الحالة</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>تحت
                                            المراجعة</option>
                                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                                            موافق عليه</option>
                                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>
                                            مرفوض</option>
                                    </select>
                                </div>

                                <!-- القسم -->
                                <div class="col-md-4">
                                    <label for="department">القسم</label>
                                    <select name="department" class="form-control" id="department">
                                        <option value="">اختر القسم</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}"
                                                {{ request('department') == $department->id ? 'selected' : '' }}>
                                                {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- المسمى الوظيفي -->
                                <div class="col-md-4">
                                    <label for="job_title">المسمى الوظيفي</label>
                                    <select name="job_title" class="form-control" id="job_title">
                                        <option value="">اختر المسمى الوظيفي</option>
                                        @foreach ($jopTitles as $title)
                                            <option value="{{ $title->id }}"
                                                {{ request('job_title') == $title->id ? 'selected' : '' }}>
                                                {{ $title->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- المستوى الوظيفي -->
                                <div class="col-md-4">
                                    <label for="functional_level">المستوى الوظيفي</label>
                                    <select name="functional_level" class="form-control" id="functional_level">
                                        <option value="">اختر المستوى الوظيفي</option>
                                        @foreach ($functionLevels as $level)
                                            <option value="{{ $level->id }}"
                                                {{ request('functional_level') == $level->id ? 'selected' : '' }}>
                                                {{ $level->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- نوع الوظيفة -->
                                <div class="col-md-4">
                                    <label for="job_type">نوع الوظيفة</label>
                                    <select name="job_type" class="form-control" id="job_type">
                                        <option value="">اختر نوع الوظيفة</option>
                                        @foreach ($jobTypes as $type)
                                            <option value="{{ $type->id }}"
                                                {{ request('job_type') == $type->id ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- الفرع -->
                                <div class="col-md-4">
                                    <label for="branch">الفرع</label>
                                    <select name="branch" class="form-control" id="branch">
                                        <option value="">اختر الفرع</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}"
                                                {{ request('branch') == $branch->id ? 'selected' : '' }}>
                                                {{ $branch->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- الوردية -->
                                <div class="col-md-4">
                                    <label for="shift">الوردية</label>
                                    <select name="shift" class="form-control" id="shift">
                                        <option value="">اختر الوردية</option>
                                        @foreach ($shifts as $shift)
                                            <option value="{{ $shift->id }}"
                                                {{ request('shift') == $shift->id ? 'selected' : '' }}>
                                                {{ $shift->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- أزرار الإجراءات -->
                        <div class="form-actions mt-2">
                            <button type="submit" class="btn btn-primary">بحث</button>
                            <a href="{{ route('attendance.leave_requests.index') }}" type="reset"
                                class="btn btn-outline-warning">إلغاء</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- جدول عرض النتائج -->
            <div class="card mt-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الموظف</th>
                                    <th>القسم</th>
                                    <th>نوع الإجازة</th>
                                    <th>نوع الطلب</th>

                                    <th>تاريخ البدء</th>
                                    <th>تاريخ الانتهاء</th>
                                    <th>عدد الأيام</th>
                                    <th>الحالة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($leaveRequests as $request)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $request->employee->full_name }}</td>
                                        <td>{{ $request->employee->department->name ?? '-' }}</td>
                                        <td>
                                            @if ($request->leave_type == 'annual')
                                                <span class="badge bg-primary">أجازة اعتيادية</span>
                                            @elseif($request->leave_type == 'casual')
                                                <span class="badge bg-warning">اجازة عرضية</span>
                                            @elseif($request->leave_type == 'sick')
                                                <span class="badge bg-danger">مرضية</span>
                                            @else
                                                <span class="badge bg-info">إجازة بدون راتب</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($request->request_type == 'sick')
                                                <span class="badge bg-danger">مرضية</span>
                                            @elseif($request->request_type == 'emergency')
                                                <span class="badge bg-primary">غياب طاريء</span>
                                            @else
                                                <span class="badge bg-info">إجازة</span>
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($request->start_date)->format('Y-m-d') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($request->end_date)->format('Y-m-d') }}</td>
                                        <td>{{ $request->days }}</td>
                                        <td>
                                            @if ($request->status == 'pending')
                                                <span class="badge bg-warning">تحت المراجعة</span>
                                            @elseif($request->status == 'approved')
                                                <span class="badge bg-success">موافق عليه</span>
                                            @else
                                                <span class="badge bg-danger">مرفوض</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('attendance.leave_requests.show', $request->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <a href="{{ route('attendance.leave_requests.edit', $request->id) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('attendance.leave_requests.destroy', $request->id) }}" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash3-fill"></i>
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- التقسيم (Pagination) -->
                    <div class="mt-3">
                        {{ $leaveRequests->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        @endsection

        @section('scripts')
            <script src="{{ asset('assets/js/search.js') }}"></script>
        @endsection
