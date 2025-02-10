@extends('master')

@section('title')
    الورديات
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">الورديات</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a>
                            </li>
                            <li class="breadcrumb-item active">اضافة
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
                        <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                    </div>

                    <div>
                        <button form="shift_form" type="submit" class="btn btn-outline-primary">
                            <i class="fa fa-save"></i>حفظ
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.alerts.error')
        @include('layouts.alerts.success')

        <div class="card">
            <div class="card-header"><strong>معلومات وردية</strong></div>
            <div class="card-body">
                <form id="shift_form" class="form" action="{{ route('shift_management.store') }}" method="POST">
                    @csrf
                    <div class="row">

                        <div class="form-group col-md-6">
                            <label for="">الاسم <span style="color: red">*<span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                            @error('name')
                            <span class="text-danger" id="basic-default-name-error" class="error">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="">النوع <span style="color: red">*<span></label>
                            <select class="form-control" name="type">
                                <option value="basic" {{ old('type') == 'basic' ? 'selected' : '' }} selected>اساسي</option>
                                <option value="advanced" {{ old('type') == 'advanced' ? 'selected' : '' }}>متقدم</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div id="basic">
                        <div class="card">
                            <div class="card-header p-1" style="background: #f8f8f8"><strong class="">أيام العمل</strong></div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>يوم</th>
                                            <th style="width: 50%">يوم عمل</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $days = ['sunday' => 'الأحد', 'monday' => 'الإثنين', 'tuesday' => 'الثلاثاء', 'wednesday' => 'الأربعاء', 'thursday' => 'الخميس', 'friday' => 'الجمعة', 'saturday' => 'السبت'];
                                        @endphp

                                        @foreach ($days as $dayKey => $dayName)
                                        <tr>
                                            <td>{{ $dayName }}</td>
                                            <td>
                                                <div class="custom-control custom-switch custom-switch-success mr-2 mb-1">
                                                    <input type="checkbox" class="custom-control-input" id="{{ $dayKey }}" name="days[{{ $dayKey }}][working_day]" value="1" {{ in_array($dayKey, ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday']) ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="{{ $dayKey }}"></label>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header p-1" style="background: #f8f8f8"><strong class="">قواعد الحضور</strong></div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="form-group col-md-6">
                                        <label for="">بداية الوردية <span style="color: red">*<span></label>
                                        <input type="time" name="start_time" class="form-control" value="09:00">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="">نهاية الوردية <span style="color: red">*<span></label>
                                        <input type="time" name="end_time" class="form-control" value="17:00">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="">بداية تسجيل الدخول <span style="color: red">*<span></label>
                                        <input type="time" name="login_start_time" class="form-control" value="07:00">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="">بداية تسجيل الخروج <span style="color: red">*<span></label>
                                        <input type="time" name="logout_start_time" class="form-control" value="15:00">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="">نهاية تسجيل الدخول <span style="color: red">*<span></label>
                                        <input type="time" name="login_end_time" class="form-control" value="11:00">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="">نهاية تسجيل الخروج <span style="color: red">*<span></label>
                                        <input type="time" name="logout_end_time" class="form-control" value="19:00">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="">فترة سماح التأخير <span style="color: red">*<span></label>
                                        <input type="text" name="grace_period" class="form-control" value="15" placeholder="دقائق">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="">حساب التأخير <span style="color: red">*<span></label>
                                        <select class="form-control" name="delay_calculation" >
                                            <option value="1" selected >بعد موعد بداية الوردية + مهلة التأخير</option>
                                            <option value="2">من موعد بداية الوردية</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="advanced" style="display: none">
                        <div class="card">
                            <div class="card-header p-1" style="background: #f8f8f8"><strong class="">أيام العمل</strong></div>
                            <div class="card-body">

                                @php
                                    $days = ['sunday' => 'الأحد', 'monday' => 'الإثنين', 'tuesday' => 'الثلاثاء', 'wednesday' => 'الأربعاء', 'thursday' => 'الخميس', 'friday' => 'الجمعة', 'saturday' => 'السبت'];
                                @endphp

                                @foreach ($days as $dayKey => $dayName)
                                    <div class="card mb-3" style="background: #f8f8f8">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-6">
                                                    <span><strong>{{ $dayName }}</strong></span>
                                                </div>
                                                <div class="col-6 text-end">
                                                    <div class="custom-control custom-switch custom-switch-success">
                                                        <input type="checkbox" class="custom-control-input" id="{{ $dayKey }}_enabled" name="days[{{ $dayKey }}][working_day]" value="1" onchange="toggleDayFields('{{ $dayKey }}')" checked>
                                                        <label class="custom-control-label" for="{{ $dayKey }}_enabled"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="{{ $dayKey }}_fields" class="row">
                                        <div class="form-group col-md-6">
                                            <label for="">بداية الوردية <span style="color: red">*</span></label>
                                            <input type="time" name="days[{{ $dayKey }}][start_time]" class="form-control" value="09:00">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="">نهاية الوردية <span style="color: red">*</span></label>
                                            <input type="time" name="days[{{ $dayKey }}][end_time]" class="form-control" value="17:00">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="">بداية تسجيل الدخول <span style="color: red">*</span></label>
                                            <input type="time" name="days[{{ $dayKey }}][login_start_time]" class="form-control" value="07:00">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="">نهاية تسجيل الدخول <span style="color: red">*</span></label>
                                            <input type="time" name="days[{{ $dayKey }}][login_end_time]" class="form-control" value="11:00">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="">بداية تسجيل الخروج <span style="color: red">*</span></label>
                                            <input type="time" name="days[{{ $dayKey }}][logout_start_time]" class="form-control" value="15:00">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="">نهاية تسجيل الخروج <span style="color: red">*</span></label>
                                            <input type="time" name="days[{{ $dayKey }}][logout_end_time]" class="form-control" value="19:00">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="">فترة سماح التأخير <span style="color: red">*</span></label>
                                            <input type="number" name="days[{{ $dayKey }}][grace_period]" class="form-control" value="15" placeholder="دقائق">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="">حساب التأخير <span style="color: red">*</span></label>
                                            <select class="form-control" name="days[{{ $dayKey }}][delay_calculation]">
                                                <option value="1" selected>بعد موعد بداية الوردية + مهلة التأخير</option>
                                                <option value="2">من موعد بداية الوردية</option>
                                            </select>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>

                    </div>

                </form>
            </div>
        </div>
    </div><!-- content-body -->
@endsection


@section('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // العناصر
        const typeSelect = document.querySelector('select[name="type"]');
        const basicSection = document.getElementById('basic');
        const advancedSection = document.getElementById('advanced');

        // تحديث العرض وتمكين/تعطيل المدخلات بناءً على الاختيار
        function toggleSections() {
            if (typeSelect.value === 'basic') {
                basicSection.style.display = 'block';
                advancedSection.style.display = 'none';

                // تعطيل المدخلات داخل القسم المتقدم
                Array.from(advancedSection.querySelectorAll('input, select, textarea')).forEach(input => {
                    input.disabled = true;
                });

                // تمكين المدخلات داخل القسم الاساسي
                Array.from(basicSection.querySelectorAll('input, select, textarea')).forEach(input => {
                    input.disabled = false;
                });
            } else if (typeSelect.value === 'advanced') {
                advancedSection.style.display = 'block';
                basicSection.style.display = 'none';

                // تعطيل المدخلات داخل القسم الأساسي
                Array.from(basicSection.querySelectorAll('input, select, textarea')).forEach(input => {
                    input.disabled = true;
                });

                // تمكين المدخلات داخل القسم المتقدم
                Array.from(advancedSection.querySelectorAll('input, select, textarea')).forEach(input => {
                    input.disabled = false;
                });
            }
        }

        // إضافة الحدث عند تغيير الخيار
        typeSelect.addEventListener('change', toggleSections);

        // استدعاء الوظيفة عند التحميل
        toggleSections();
    });
</script>

<script>
    function toggleDayFields(dayKey) {
        const isChecked = document.getElementById(`${dayKey}_enabled`).checked;
        const fieldsContainer = document.getElementById(`${dayKey}_fields`);
        fieldsContainer.style.display = isChecked ? 'flex' : 'none';
        const inputs = fieldsContainer.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.disabled = !isChecked;
        });
    }

    // إخفاء الحقول الغير مفعلة عند بداية الصفحة
    document.addEventListener('DOMContentLoaded', () => {
        @foreach ($days as $dayKey => $dayName)
            toggleDayFields('{{ $dayKey }}');
        @endforeach
    });

</script>

@endsection


