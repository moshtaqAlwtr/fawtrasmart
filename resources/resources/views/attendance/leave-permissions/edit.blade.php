@extends('master')

@section('title', 'تعديل أذونات إجازة')

@section('content')
    <!-- Header Section -->
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">تعديل أذونات إجازة</h2>
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

    <!-- Form Actions -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                </div>
                <div>
                    <a href="{{ route('leave_permissions.index') }}" class="btn btn-outline-danger">
                        <i class="fa fa-ban"></i> إلغاء
                    </a>
                    <button type="submit" form="addLeavePermissionForm" class="btn btn-outline-primary">
                        <i class="fa fa-save"></i> تحديث
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <div class="card">
        <div class="card-body">
            <h4 class="mb-4">معلومات إذن إجازة</h4>
            <form id="addLeavePermissionForm" method="POST" action="{{ route('leave_permissions.update', $leavePermission->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label for="employee" class="form-label">موظف <span class="text-danger">*</span></label>
                        <select class="form-control select2" id="employee" name="employee_id">
                            <option selected disabled>اختر موظف</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}" {{ old('employee_id', $leavePermission->employee_id) == $employee->id ? 'selected' : '' }}>{{ $employee->full_name }}</option>
                            @endforeach
                        </select>
                        @error('employee_id')
                        <small class="text-danger" id="basic-default-name-error" class="error"></small>
                            {{ $message }}
                        </small>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="start-date" class="form-label">التاريخ من <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="start-date" name="start_date" value="{{ old('start_date', $leavePermission->start_date) }}">
                        @error('start_date')
                        <small class="text-danger" id="basic-default-name-error" class="error"></small>
                            {{ $message }}
                        </small>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="end-date" class="form-label">التاريخ إلى <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="end-date" name="end_date" value="{{ old('end_date', $leavePermission->end_date) }}">
                        @error('end_date')
                        <small class="text-danger" id="basic-default-name-error" class="error"></small>
                            {{ $message }}
                        </small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="leave-type" class="form-label">النوع <span class="text-danger">*</span></label>
                        <select class="form-control" id="leave-type" name="leave_type">
                            <option selected disabled>اختر</option>
                            <option value="1" {{ old('leave_type', $leavePermission->leave_type) == '1' ? 'selected' : '' }}>الوصول المتأخر</option>
                            <option value="2" {{ old('leave_type', $leavePermission->leave_type) == '2' ? 'selected' : '' }}>الانصراف المبكر</option>
                        </select>
                        @error('leave_type')
                        <small class="text-danger" id="basic-default-name-error" class="error"></small>
                            {{ $message }}
                        </small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="type" class="form-label">نوع الاجازة <span class="text-danger">*</span></label>
                        <select class="form-control" id="type" name="type">
                            <option selected disabled>إجازة</option>
                            <option value="1" {{ old('type', $leavePermission->type) == '1' ? 'selected' : '' }}> إجازة اعتيادية</option>
                            <option value="2" {{ old('type', $leavePermission->type) == '2' ? 'selected' : '' }}>إجازة عرضية</option>
                        </select>
                        @error('type')
                        <small class="text-danger" id="basic-default-name-error" class="error"></small>
                            {{ $message }}
                        </small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="application-date" class="form-label">تاريخ التقديم</label>
                        <input type="date" class="form-control" id="application-date" name="submission_date" value="{{ old('submission_date', $leavePermission->submission_date) }}">
                    </div>
                    <div class="col-md-6">
                        <label for="attachments" class="form-label">المرفقات</label>
                        <input type="file" name="attachments" id="attachments" class="form-control">
                    </div>

                    <div class="col-md-12">
                        <label for="notes" class="form-label">ملاحظة</label>
                        <textarea class="form-control" id="notes" rows="3" placeholder="أدخل ملاحظاتك" name="notes">{{ old('notes', $leavePermission->notes) }}</textarea>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
