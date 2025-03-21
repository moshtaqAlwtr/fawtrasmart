@extends('master')

@section('title', 'تعديل سياسة الإجازات')

@section('content')
    <!-- Header Section -->
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">تعديل سياسة الإجازات</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">الرئيسية</a></li>
                            <li class="breadcrumb-item active">تعديل</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                </div>
                <div>
                    <a href="{{ route('leave_policy.index') }}" class="btn btn-outline-danger">
                        <i class="fa fa-ban"></i> إلغاء
                    </a>
                    <button type="submit" form="editHolidayForm" class="btn btn-outline-primary">
                        <i class="fa fa-save"></i> تجديث
                    </button>
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Section -->
    <div class="card">
        <div class="card-body">
            <h4 class="mb-4 p-1" style="background: #f8f8f8">تعديل سياسة الإجازات</h4>
            <form id="editHolidayForm" method="POST" action="{{ route('leave_policy.update', $leave_policy->id) }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label for="employee" class="form-label">الاسم <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" value="{{ old('name', $leave_policy->name) }}">
                    </div>

                    <div class="col-md-6">
                        <label for="">الحالة <span class="text-danger">*</span></label>
                        <select name="status" class="form-control">
                            <option value="0" {{ old('status', $leave_policy->status) == 0 ? 'selected' : '' }}>نشط</option>
                            <option value="1" {{ old('status', $leave_policy->status) == 1 ? 'selected' : '' }}>غير نشط</option>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label for="description" class="form-label">الوصف</label>
                        <textarea class="form-control" name="description" rows="2">{{ old('description', $leave_policy->description) }}</textarea>
                    </div>
                </div>

                <br><br>
                <h4 class="mb-4 p-1" style="background: #f8f8f8">الإجازات</h4>
                <div class="col-md-6">
                    <p>عدد الإجازات المختارة: <strong id="holidayCount">{{ $leave_policy->leaveType->count() }}</strong></p>
                </div>
                <table class="table table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>الرقم المتسلسل</th>
                            <th>نوع الإجازة</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="holidayTable">
                        @foreach ($leave_policy->leaveType as $index => $leave_type)
                            <tr>
                                <td style="width: 10%">{{ $index + 1 }}</td>
                                <td>
                                    <select name="leave_type_id[]" class="form-control">
                                        <option value="" disabled>-- اختر نوع الإجازة --</option>
                                        @foreach ($leave_types as $type)
                                            <option value="{{ $type->id }}" {{ $leave_type->id == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="width: 10%">
                                    <button type="button" class="btn btn-outline-danger btn-sm remove-row">إزالة <i class="fa fa-minus-circle"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-6">
                        <button type="button" id="addRow" class="btn btn-outline-success btn-sm">إضافة <i class="fa fa-plus-circle"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const holidayTable = document.getElementById('holidayTable');
            const holidayCount = document.getElementById('holidayCount');
            let rowCount = holidayTable.rows.length;

            function updateHolidayCount() {
                holidayCount.textContent = holidayTable.rows.length;
            }

            document.getElementById('addRow').addEventListener('click', function () {
                rowCount++;
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td style="width: 10%">${rowCount}</td>
                    <td>
                        <select name="leave_type_id[]" class="form-control">
                            <option value="" disabled selected>-- اختر نوع الإجازة --</option>
                            @foreach ($leave_types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td style="width: 10%">
                        <button type="button" class="btn btn-outline-danger btn-sm remove-row">إزالة <i class="fa fa-minus-circle"></i></button>
                    </td>
                `;
                holidayTable.appendChild(newRow);
                updateHolidayCount();
            });

            holidayTable.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-row') || e.target.closest('.remove-row')) {
                    const row = e.target.closest('tr');
                    row.remove();
                    updateHolidayCount();
                }
            });
        });
    </script>
@endsection
