<?php $__env->startSection('title'); ?>
    اضافة مسير راتب
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">اضافة مسير راتب</h2>
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
        <form class="form" action="<?php echo e(route('PayrollProcess.store')); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="alert alert-danger">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

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


            <div class="card" style="max-width: 90%; margin: 0 auto;">

                <div class="card-body">
                    <h1 class="card-title"> معلومات مسير الراتب </h1>

                    <div class="form-body row">
                        <div class="form-group col-md-6">
                            <label for="feedback1" class="">الاسم </label>
                            <input type="text" id="feedback1" class="form-control" placeholder="الاسم" name="name">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="feedback2" class=""> تاريخ التسجيل </label>
                            <input type="date" id="feedback2" class="form-control" name="registration_date">
                        </div>


                    </div>
                    <div class="form-body row">

                        <div class="form-group col-md-6">
                            <label for="feedback2" class=""> تاريخ البدء </label>
                            <input type="date" id="feedback2" class="form-control" name="start_date">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="feedback2" class=""> تاريخ النهاية </label>
                            <input type="date" id="feedback2" class="form-control" name="end_date">
                        </div>



                    </div>

                    <div class="form-body row">
                        <div class="col-md-6">
                            <div class="input-group form-group">
                                <div class="input-group-text w-100 text-left">
                                    <div
                                        class="custom-control custom-checkbox d-flex justify-content-start align-items-center w-100">
                                        <input id="duration_check" class="custom-control-input" type="checkbox"
                                            name="attendance_check" value="1">
                                        <label for="duration_check" class="custom-control-label ml-2">
                                            التحقق من الحضور <span class="required">*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
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
                                                    type="radio" name="select_emp_role" value="1" checked onchange="toggleFields()">
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
                                            <select class="form-control duration-field" name="branch_id"
                                                style="margin-bottom: 10px">
                                                <option value="all">كل الفروع</option>
                                                <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($branch->id); ?>"><?php echo e($branch->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <label for="departments" class="form-label"
                                                style="margin-bottom: 10px">الأقسام</label>
                                            <select class="form-control duration-field" name="department_id"
                                                style="margin-bottom: 10px">
                                                <option value="all">كل الأقسام</option>
                                                <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($department->id); ?>"><?php echo e($department->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <label for="positions" class="form-label"
                                                style="margin-bottom: 10px">المسميات الوظيفية</label>
                                            <select class="form-control duration-field" name="jop_title_id"
                                                style="margin-bottom: 10px">
                                                <option value="all">كل المسميات الوظيفية</option>
                                                <?php $__currentLoopData = $jop_titles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jop_title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($jop_title->id); ?>"><?php echo e($jop_title->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="contract_date" class="">دورة القبض </label>
                                            <select name="receiving_cycle" class="form-control duration-field" id="">
                                                <option value=""> اختر دورة القبض</option>
                                                <option value="1"> شهري </option>
                                                <option value="2"> اسبوعي </option>
                                                <option value="3"> سنوي </option>
                                                <option value="4"> ربع سنوي </option>
                                                <option value="5"> مرة كل اسبوعين </option>




                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <label for="employee" class="form-label">الموظف</label>
                                            <select id="employee-select-employees" class="form-control select2 duration-field" name="employee_id[]"
                                                multiple="multiple">
                                                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($employee->id); ?>"
                                                        <?php echo e(in_array($employee->id, old('employee_id', $selectedEmployees ?? [])) ? 'selected' : ''); ?>>
                                                        <?php echo e($employee->full_name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                                    type="radio" onchange="toggleFields()" name="select_emp_role" value="2">
                                                <label for="enddate_radio" class="custom-control-label">اختيار الموظفين
                                                    <span class="required">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <label for="employee" class="form-label">الموظف</label>
                                        <select id="feedback2" class="form-control select2 employee-field" name="employee_id[]"
                                            multiple="multiple">
                                            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($employee->id); ?>"
                                                    <?php echo e(in_array($employee->id, old('employee_id', $selectedEmployees ?? [])) ? 'selected' : ''); ?>>
                                                    <?php echo e($employee->full_name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
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

        $('#employee-select-employees').select2({
                        allowClear: true
                    });

                    $('#employee-select-rules').select2({
                        allowClear: true
                    });

    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/salaries/payroll_ process/create.blade.php ENDPATH**/ ?>