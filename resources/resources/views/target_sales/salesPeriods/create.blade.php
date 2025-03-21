@extends('master')

@section('title')
    اضافة فترة مبيعات
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">اضافة فترة مبيعات</h2>
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
                        <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                    </div>

                    <div>
                        <a href="" class="btn btn-outline-danger">
                            <i class="fa fa-ban"></i>الغاء
                        </a>
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="fa fa-save"></i>حفظ
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <form class="form">
            <div class="card" style="max-width: 90%; margin: 0 auto;">

                <div class="card-body">
                    <h1 class="card-title"> معلومات فترة المبيعات </h1>

                    <div class="form-body row">

                        <div class="form-group col-md-6">
                            <label for="feedback2" class=""> تاريخ (من) </label>
                            <input type="date" id="feedback2" class="form-control" name="from_date">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="feedback2" class=""> تاريخ (الى) </label>
                            <input type="date" id="feedback2" class="form-control" name="from_date">
                        </div>


                    </div>






                    <div class="form-body row">
                        <!-- اختيار القواعد -->
                        <div class="col-md-6">
                            <div class="position-relative">
                                <div class="input-group form-group">
                                    <div class="input-group-prepend w-100">
                                        <div class="input-group-text w-100 text-right">
                                            <div
                                                class="custom-control custom-radio d-flex justify-content-start align-items-center w-100">
                                                <input id="duration_radio" name="selection" class="custom-control-input"
                                                    type="radio" checked onchange="toggleFields()">
                                                <label for="duration_radio" class="custom-control-label mr-2">اختيار القواعد
                                                    <span class="required">*</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" id="duration-inputs">
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <label for="branches" class="form-label" style="margin-bottom: 10px">كل
                                                الفروع</label>
                                            <select class="form-control duration-field" style="margin-bottom: 10px">
                                                <option value="all">كل الفروع</option>
                                                <option value="branch1">فرع 1</option>
                                                <option value="branch2">فرع 2</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <label for="departments" class="form-label"
                                                style="margin-bottom: 10px">الأقسام</label>
                                            <select class="form-control duration-field" style="margin-bottom: 10px">
                                                <option value="all">كل الأقسام</option>
                                                <option value="dept1">قسم 1</option>
                                                <option value="dept2">قسم 2</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <label for="positions" class="form-label" style="margin-bottom: 10px">المسميات
                                                الوظيفية</label>
                                            <select class="form-control duration-field" style="margin-bottom: 10px">
                                                <option value="all">كل المسميات الوظيفية</option>
                                                <option value="pos1">مسمي 1</option>
                                                <option value="pos2">مسمي 2</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <label for="pay-cycle" class="form-label" style="margin-bottom: 10px">دورة
                                                القبض</label>
                                            <select class="form-control duration-field" style="margin-bottom: 10px">
                                                <option value="all">كل دورات القبض</option>
                                                <option value="cycle1">دورة 1</option>
                                                <option value="cycle2">دورة 2</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <label for="excluded-employees" class="form-label"
                                                style="margin-bottom: 10px">الموظفين المستبعدين</label>
                                            <select class="form-control duration-field" style="margin-bottom: 10px">
                                                <option value="all">كل الموظفين المستبعدين</option>
                                                <option value="emp1">موظف 1</option>
                                                <option value="emp2">موظف 2</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- اختيار الموظفين -->
                        <div class="col-md-6">
                            <div class="position-relative">
                                <div class="input-group form-group">
                                    <div class="input-group-prepend w-100">
                                        <div class="input-group-text w-100">
                                            <div
                                                class="custom-control custom-radio d-flex justify-content-start align-items-center w-100">
                                                <input id="enddate_radio" name="selection" class="custom-control-input"
                                                    type="radio" onchange="toggleFields()">
                                                <label for="enddate_radio" class="custom-control-label">اختيار الموظفين
                                                    <span class="required">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <label for="employee" class="form-label">الموظف</label>
                                        <select class="form-control employee-field">
                                            <option value="emp1">موظف 1</option>
                                            <option value="emp2">موظف 2</option>
                                            <option value="emp3">موظف 3</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>






                </div>

            </div>

        </form>

    </div>

    </div>

@endsection

@section('scripts')
    <script>
        // ضبط الحقول عند تحميل الصفحة
        document.addEventListener('DOMContentLoaded', function() {
            toggleFields(); // استدعاء الدالة لضبط الحقول الافتراضية
        });

        function toggleFields() {
            const durationInputs = document.querySelectorAll('.duration-field');
            const employeeInputs = document.querySelectorAll('.employee-field');

            // تحقق إذا كان اختيار القواعد مفعلاً
            if (document.getElementById('duration_radio').checked) {
                durationInputs.forEach(input => input.disabled = false); // تمكين الحقول الخاصة باختيار القواعد
                employeeInputs.forEach(input => input.disabled = true); // تعطيل الحقول الخاصة باختيار الموظفين
            }

            // تحقق إذا كان اختيار الموظفين مفعلاً
            if (document.getElementById('enddate_radio').checked) {
                durationInputs.forEach(input => input.disabled = true); // تعطيل الحقول الخاصة باختيار القواعد
                employeeInputs.forEach(input => input.disabled = false); // تمكين الحقول الخاصة باختيار الموظفين
            }
        }
    </script>

@endsection
