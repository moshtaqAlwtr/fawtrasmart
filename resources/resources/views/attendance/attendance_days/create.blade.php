@extends('master')

@section('title', 'أيام الحضور')

@section('content')
    <!-- Header Section -->
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">أيام الحضور</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">الرئيسية</a></li>
                            <li class="breadcrumb-item active">إضافة</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">

        <!-- Form Actions -->
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                    </div>
                    <div>
                        <a href="{{ route('attendanceDays.index') }}" class="btn btn-outline-danger">
                            <i class="fa fa-ban"></i> إلغاء
                        </a>
                        <button type="submit" form="addAttendanceForm" class="btn btn-outline-primary">
                            <i class="fa fa-save"></i> حفظ
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
                <form id="addAttendanceForm" action="{{ route('attendanceDays.store') }}" method="POST">
                    @csrf
                    <p style="background-color: #f8f8f8; padding: 10px"><strong>معلومات الحضور</strong></p>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="employee-select" class="form-label">الموظف <span style="color: red">*</span></label>
                            <select id="employee-select" name="employee_id" class="form-control select2" required>
                                <option value="" selected>اختر الموظف</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }} {{ old('employee_id') == $employee->id ? 'selected' : '' }}">{{ $employee->full_name }}</option>
                                @endforeach
                            </select>
                            @error('employee_id')
                            <small class="text-danger" id="basic-default-name-error" class="error">
                                {{ $message }}
                            </small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="attendance-date" class="form-label">تاريخ الحضور <span style="color: red">*</span></label>
                            <input type="date" name="attendance_date" class="form-control" placeholder="ادخل تاريخ الحضور" value="{{ old('attendance_date') }}">
                            @error('attendance_date')
                            <small class="text-danger" id="basic-default-name-error" class="error">
                                {{ $message }}
                            </small>
                            @enderror
                        </div>
                    </div>

                    <hr>

                    <!-- Attendance Status -->
                    <div class="mb-3">
                        <p class="mb-2"><strong>الحالة</strong></p>
                        <div class="row g-3">
                            <!-- Present -->
                            <div class="col-12">
                                <ul class="list-unstyled mb-0">
                                    <li class="d-inline-block mr-5">
                                        <fieldset>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" name="status" id="customRadio1" {{ old('status') == 'present' ? 'checked' : '' }} value="present">
                                                <label class="custom-control-label" for="customRadio1">حاضر <span style="color: red">*</span></label>
                                            </div>
                                        </fieldset>
                                    </li>
                                    <li class="d-inline-block mr-5">
                                        <fieldset>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" name="status" id="customRadio2" {{ old('status') == 'absent' ? 'checked' : '' }} value="absent">
                                                <label class="custom-control-label" for="customRadio2">إجازة <span style="color: red">*</span></label>
                                            </div>
                                        </fieldset>
                                    </li>
                                    <li class="d-inline-block mr-5">
                                        <fieldset>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" name="status" id="customRadio3" {{ old('status') == 'late' ? 'checked' : '' }} value="late">
                                                <label class="custom-control-label" for="customRadio3">غائب <span style="color: red">*</span></label>
                                            </div>
                                        </fieldset>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div id="attendance-rules" style="display: none">
                        <p style="background-color: #f8f8f8; padding: 10px"><strong>قواعد الحضور</strong></p>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="attendance-date" class="form-label">بداية الوردية <span style="color: red">*</span></label>
                                <input type="time" name="start_shift" class="form-control" value="{{ old('start_shift') }}">
                                @error('start_shift')
                                <small class="text-danger" id="basic-default-name-error" class="error">
                                    {{ $message }}
                                </small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="attendance-date" class="form-label">نهاية الوردية <span style="color: red">*</span></label>
                                <input type="time" name="end_shift" class="form-control" value="{{ old('end_shift') }}">
                                @error('end_shift')
                                <small class="text-danger" id="basic-default-name-error" class="error">
                                    {{ $message }}
                                </small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="attendance-date" class="form-label">تسجيل الدخول <span style="color: red">*</span></label>
                                <input type="time" name="login_time" class="form-control" value="{{ old('login_time') }}">
                                @error('login_time')
                                <small class="text-danger" id="basic-default-name-error" class="error">
                                    {{ $message }}
                                </small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="attendance-date" class="form-label">تسجيل الخروج <span style="color: red">*</span></label>
                                <input type="time" name="logout_time" class="form-control" value="{{ old('logout_time') }}">
                                @error('logout_time')
                                <small class="text-danger" id="basic-default-name-error" class="error">
                                    {{ $message }}
                                </small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div id="vacation-rules"style="display: none">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="attendance-date" class="form-label">نوع الاجازة <span style="color: red">*</span></label>
                                <select id="employee-select" name="absence_type" class="form-control">
                                    <option value="" disabled selected>اختر نوع الاجازة</option>
                                    <option value="1" {{ old('absence_type') == 1 ? 'selected' : '' }}>اجازة اعتيادية</option>
                                    <option value="2" {{ old('absence_type') == 2 ? 'selected' : '' }}>اجازة عرضية</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="attendance-date" class="form-label">رصيد الاجازة <span style="color: red">*</span></label>
                                <input type="number" name="absence_balance" class="form-control" value="{{ old('absence_balance',1) }}">
                            </div>
                        </div>
                    </div>

                    <!-- Notes Section -->
                    <div class="mb-3">
                        <label for="notes" class="form-label">الملاحظات</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="أدخل الملاحظات هنا">{{ old('notes') }}</textarea>
                    </div>
                </form>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const employeeSelect = document.getElementById('employee-select');
            const attendanceDate = document.querySelector('input[name="attendance_date"]');
            const radios = document.querySelectorAll('input[name="status"]');
            const attendanceRules = document.getElementById('attendance-rules');
            const vacationRules = document.getElementById('vacation-rules');

            // تعطيل الحالة عند تحميل الصفحة
            radios.forEach(radio => radio.disabled = true);

            // تفعيل الحالة إذا تم تحديد الموظف والتاريخ
            function toggleRadios() {
                const isEmployeeSelected = employeeSelect.value !== '';
                const isDateSelected = attendanceDate.value !== '';
                radios.forEach(radio => radio.disabled = !(isEmployeeSelected && isDateSelected));
            }

            employeeSelect.addEventListener('change', toggleRadios);
            attendanceDate.addEventListener('input', toggleRadios);

            // عرض الأقسام بناءً على اختيار الحالة
            radios.forEach(radio => {
                radio.addEventListener('change', function () {
                    if (this.id === 'customRadio1') { // حاضر
                        attendanceRules.style.display = 'block';
                        vacationRules.style.display = 'none';
                    } else if (this.id === 'customRadio2') { // إجازة
                        attendanceRules.style.display = 'none';
                        vacationRules.style.display = 'block';
                    } else { // غائب أو حالة أخرى
                        attendanceRules.style.display = 'none';
                        vacationRules.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endsection
