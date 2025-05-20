<?php $__env->startSection('title'); ?>
اضافة موظف
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">أضافة موظف </h2>
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

    <form action="<?php echo e(route('employee.store')); ?>" method="POST" enctype="multipart/form-data">
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
                        <a href="<?php echo e(route('employee.index')); ?>" class="btn btn-outline-danger">
                            <i class="fa fa-ban"></i>الغاء
                        </a>
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="fa fa-save"></i>حفظ
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-primary text-white font-weight-bold p-1">
                معلومات الموظف
            </div>
            <div class="card-body">

                <div class="form-row">

                    <div class="form-group col-md-4">
                        <label for="first_name">الاسم الأول <span class="text-danger">*</span></label>
                        <input type="text" name="first_name" class="form-control" placeholder="أدخل الاسم الأول" value="<?php echo e(old('first_name')); ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="middle_name">الاسم الأوسط</label>
                        <input type="text" name="middle_name" class="form-control" placeholder="أدخل الاسم الأوسط" value="<?php echo e(old('middle_name')); ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="last_name">اللقب</label>
                        <input type="text" name="nickname" class="form-control" placeholder="أدخل اللقب" value="<?php echo e(old('nickname')); ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="employee_photo">صورة الموظف</label>
                        <div class="custom-file">
                            <input type="file" name="employee_photo" class="custom-file-input">
                            <label class="custom-file-label" for="employee_photo">اختر صورة الموظف</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="notes">الملاحظات</label>
                        <textarea name="notes" class="form-control" id="notes" rows="2" placeholder="أدخل ملاحظات"><?php echo e(old('notes')); ?></textarea>
                    </div>
                </div>

                <div class="form-row">

                    <div class="form-group col-md-4">
                        <label for="email">البريد الإلكتروني <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="example@email.com" value="<?php echo e(old('email')); ?>">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="employee_type">نوع الموظف</label>
                        <select name="employee_type" class="form-control">
                            <option value="1" <?php echo e(old('employee_type') == 1 ? 'selected' : ''); ?>>موظف</option>
                            <option value="2" <?php echo e(old('employee_type') == 2 ? 'selected' : ''); ?>>مستخدم</option>
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="status">الحالة <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" id="status" required>
                            <option value="1" <?php echo e(old('status') == 1 ? 'selected' : ''); ?>>نشط</option>
                            <option value="2" <?php echo e(old('status') == 2 ? 'selected' : ''); ?>>غير نشط</option>
                        </select>
                    </div>

                </div>

                <div class="form-row pb-2">
                    <div class="form-check form-check-inline ml-4">
                        <input name="allow_system_access" class="form-check-input" type="checkbox" >
                        <label class="form-check-label" for="allow_access">السماح بالدخول الى النظام</label>
                    </div>
                    <div class="form-check form-check-inline ml-4">
                        <input name="send_credentials" class="form-check-input" type="checkbox">
                        <label class="form-check-label" for="send_data">إرسال بيانات الدخول عبر البريد الإلكتروني</label>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="id_number">لغة العرض </label>
                        <select name="language" class="form-control">
                            <option value="1" <?php echo e(old('language') == 1 ? 'selected' : ''); ?>>العربيه</option>
                            <option value="2" <?php echo e(old('language') == 2 ? 'selected' : ''); ?>>انجليزيه</option>
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="nationality">الدور الوظيفي</label>
                        <select name="Job_role_id" class="form-control">
                            <?php $__currentLoopData = $job_roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job_role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($job_role->id); ?>" <?php echo e(old('Job_role_id') == $job_role->id ? 'selected' : ''); ?>><?php echo e($job_role->role_name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="gender">الفروع المسموح الدخول بها</label>
                        <select name="branch_id" class="form-control">
                            <option selected disabled>-- اختر الفروع المسموح الدخول بها--</option>
                            <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($branch->id); ?>" <?php echo e(old('branch_id') == $branch->id ? 'selected' : ''); ?>><?php echo e($branch->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

            </div>
        </div>

        <div class="card">
            <div class="card-header bg-primary text-white font-weight-bold p-1">
                معلومات شخصية
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="dob">تاريخ الميلاد <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="date_of_birth" value="<?php echo e(old('date_of_birth')); ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="type">النوع</label>
                        <select class="form-control" name="gender">
                            <option value="1" <?php echo e(old('gender') == 1 ? 'selected' : ''); ?>>ذكر</option>
                            <option value="2" <?php echo e(old('gender') == 2 ? 'selected' : ''); ?>>انثى</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nationalityStatus">حالة المواطنة</label>
                        <select class="form-control" name="nationality_status">
                            <option selected disabled>من فضلك اختر</option>
                            <option value="1" <?php echo e(old('nationality_status') == 1 ? 'selected' : ''); ?>>مواطن</option>
                            <option value="2" <?php echo e(old('nationality_status') == 2 ? 'selected' : ''); ?>>مقيم</option>
                            <option value="3" <?php echo e(old('nationality_status') == 3 ? 'selected' : ''); ?>>زائر</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="country">البلد <span class="text-danger">*</span></label>
                        <select class="form-control select2" name="country">
                            <option value="" disabled selected>اختر البلد</option>
                            <?php
                                $arabic_countries = [
                                    1 => 'المملكة العربية السعودية',
                                    3 => 'الكويت',
                                    18 => 'السودان',
                                    4 => 'قطر',
                                    13 => 'اليمن',
                                    5 => 'البحرين',
                                    6 => 'سلطنة عمان',
                                    7 => 'مصر',
                                    8 => 'الأردن',
                                    9 => 'لبنان',
                                    10 => 'سوريا',
                                    11 => 'العراق',
                                    12 => 'فلسطين',
                                    2 => 'الإمارات العربية المتحدة',
                                    14 => 'الجزائر',
                                    15 => 'المغرب',
                                    16 => 'تونس',
                                    17 => 'ليبيا',
                                    19 => 'موريتانيا',
                                    20 => 'جيبوتي',
                                    21 => 'الصومال',
                                    22 => 'جزر القمر',
                                ];
                            ?>
                            <?php $__currentLoopData = $arabic_countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($key); ?>" <?php echo e(old('country') == $key ? 'selected' : ''); ?>>
                                    <?php echo e($country); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                </div>

            </div>
        </div>

<!-- بعد قسم معلومات الحضور وقبل زر الإرسال -->
<div class="card">
    <div class="card-header bg-primary text-white font-weight-bold p-1">
        المجموعات والاتجاهات المسموحة
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="groups-directions-table">
                <thead class="bg-light">
                    <tr>
                        <th width="40%">المجموعة</th>
                        <th width="40%">الاتجاه</th>
                        <th width="20%">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select name="groups[]" class="form-control select2">
                                <option value="">اختر مجموعة</option>
                                <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($group->id); ?>"><?php echo e($group->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </td>
                        <td>
                            <select name="directions[]" class="form-control select2">
                                <option value="">اختر اتجاه</option>
                                <?php $__currentLoopData = $directions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $direction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($direction->id); ?>"><?php echo e($direction->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove-row">
                                <i class="fa fa-trash"></i> حذف
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <button type="button" class="btn btn-success mt-2" id="add-row">
            <i class="fa fa-plus"></i> إضافة صف جديد
        </button>
    </div>
</div>

        <div class="card">
            <div class="card-header bg-primary text-white font-weight-bold p-1">
                معلومات تواصل
            </div>
            <div class="card-body">
                <div class="form-row">

                    <div class="form-group col-md-6">
                        <label for="phone">رقم الجوال</label>
                        <input type="text" class="form-control" name="mobile_number" value="<?php echo e(old('mobile_number')); ?>">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="phone">رقم الهاتف</label>
                        <input type="text" class="form-control" name="phone_number" value="<?php echo e(old('phone_number')); ?>">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="personalEmail">البريد الإلكتروني الشخصي</label>
                        <input type="email" class="form-control"  name="personal_email" value="<?php echo e(old('personal_email')); ?>">
                    </div>

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-primary text-white font-weight-bold p-1">
                العنوان الحالي
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="address1">عنوان 1</label>
                        <input type="text" class="form-control" name="current_address_1" value="<?php echo e(old('current_address_1')); ?>">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="address2">عنوان 2</label>
                        <input type="text" class="form-control" name="current_address_2" value="<?php echo e(old('current_address_2')); ?>">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="city">المدينة</label>
                        <input type="text" class="form-control" name="city" value="<?php echo e(old('city')); ?>">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="region">المنطقة</label>
                        <input type="text" class="form-control" name="region" value="<?php echo e(old('region')); ?>">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="postalCode">الرمز البريدي</label>
                        <input type="text" class="form-control" name="postal_code" value="<?php echo e(old('postal_code')); ?>">
                    </div>
                </div>
            </div>
        </div>

        <!-- قسم معلومات وظيفية -->
        <div class="card">
            <div class="card-header bg-primary text-white font-weight-bold p-1">
                معلومات وظيفة
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="jobTitle">المسمى الوظيفي</label>
                        <select class="form-control" name="job_title_id">
                            <option selected value="">اختر المسمى الوظيفي</option>
                            <?php $__currentLoopData = $job_titles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job_title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($job_title->id); ?>" <?php echo e(old('job_title_id') == $job_title->id ? 'selected' : ''); ?>><?php echo e($job_title->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="department">القسم</label>
                        <select class="form-control" name="department_id">
                            <option disabled selected value="">اختر قسم</option>
                            <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($department->id); ?>" <?php echo e(old('department_id') == $department->id ? 'selected' : ''); ?>><?php echo e($department->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="">المستوى الوظيفي</label>
                        <select class="form-control" name="job_level_id">
                            <option selected value="">اختر المستوى الوظيفي</option>
                            <?php $__currentLoopData = $job_levels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job_level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($job_level->id); ?>" <?php echo e(old('job_level_id') == $job_level->id ? 'selected' : ''); ?>><?php echo e($job_level->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="">نوع وظيفة</label>
                        <select class="form-control" name="job_type_id">
                            <option  selected value="">اختر نوع وظيفة</option>
                            <?php $__currentLoopData = $job_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($job_type->id); ?>" <?php echo e(old('job_type_id') == $job_type->id ? 'selected' : ''); ?>><?php echo e($job_type->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="branch">فرع <span class="text-danger">*</span></label>
                        <select class="form-control" name="branch_id">
                            <option selected value="">اختر فرع</option>
                            <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($branch->id); ?>" <?php echo e(old('branch_id') == $branch->id ? 'selected' : ''); ?>><?php echo e($branch->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="manager">المدير المباشر</label>
                        <select class="form-control" name="direct_manager_id">
                            <option selected value="">اختر موظف</option>
                            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($employee->id); ?>" <?php echo e(old('direct_manager_id') == $employee->id ? 'selected' : ''); ?>><?php echo e($employee->full_name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="">تاريخ الالتحاق</label>
                        <input type="date" class="form-control" name="hire_date" value="<?php echo e(old('hire_date')); ?>">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="">ورديــة</label>
                        <select class="form-control" name="shift_id">
                            <option selected value="">اختر وردية</option>
                            <?php $__currentLoopData = $shifts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shift): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($shift->id); ?>" <?php echo e(old('shift_id') == $shift->id ? 'selected' : ''); ?>><?php echo e($shift->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- الخيارات المالية -->
                    <div class="form-group col-md-12 gradient-background d-flex justify-content-start align-items-center">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="defaultDate" checked>
                            <label class="form-check-label" for="defaultDate">استخدام التاريخ المالي الافتراضي</label>
                        </div>
                        <div class="form-check form-check-inline ml-4">
                            <input class="form-check-input" type="radio" id="customDate">
                            <label class="form-check-label" for="customDate">تاريخ مالي مخصص</label>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="month">الشهر</label>
                        <select class="custom-select" id="month" name="custom_financial_month">
                            <option value="" disabled selected>اختر الشهر</option>
                            <?php
                                $months = [
                                    1 => 'يناير',
                                    2 => 'فبراير',
                                    3 => 'مارس',
                                    4 => 'أبريل',
                                    5 => 'مايو',
                                    6 => 'يونيو',
                                    7 => 'يوليو',
                                    8 => 'أغسطس',
                                    9 => 'سبتمبر',
                                    10 => 'أكتوبر',
                                    11 => 'نوفمبر',
                                    12 => 'ديسمبر',
                                ];
                            ?>

                            <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($key); ?>" <?php echo e(old('custom_financial_month') == $key ? 'selected' : ''); ?>>
                                    <?php echo e($value); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="day">يوم</label>
                        <select class="custom-select" id="day" name="custom_financial_day">
                            <option value="" disabled selected>اختر اليوم</option>
                            <?php for($i = 1; $i <= 31; $i++): ?>
                                <option value="<?php echo e($i); ?>" <?php echo e(old('custom_financial_day') == $i ? 'selected' : ''); ?>>
                                    <?php echo e($i); ?>

                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header text-center bg-primary text-white p-1">
                معلومات الحضور
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="attendancePolicy">سياسة الإجازات</label>
                        <select class="custom-select" id="attendancePolicy">
                            <option selected>اختر سياسة الإجازات</option>
                            <!-- إضافة الخيارات الأخرى -->
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="attendanceSettings">معدلات الحضور</label>
                        <select class="custom-select" id="attendanceSettings">
                            <option selected>اختر قيد الحضور</option>
                            <!-- إضافة الخيارات الأخرى -->
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="attendanceRoster">ورديات الحضور</label>
                        <select class="custom-select" id="attendanceRoster">
                            <option selected>اختر وردية الحضور</option>
                            <!-- إضافة الخيارات الأخرى -->
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="holidayList">قوائم العطلات</label>
                        <select class="custom-select" id="holidayList">
                            <option selected>اختر قائمة العطلات</option>
                            <!-- إضافة الخيارات الأخرى -->
                        </select>
                    </div>



                </div>
            </div>
        </div>

        <!-- زر الإرسال -->

    </form>

</div>



<script>
    $(document).ready(function() {
        // إضافة صف جديد
        $('#add-row').click(function() {
            var newRow = `
                <tr>
                    <td>
                        <select name="groups[]" class="form-control select2">
                            <option value="">اختر مجموعة</option>
                            <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($group->id); ?>"><?php echo e($group->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </td>
                    <td>
                        <select name="directions[]" class="form-control select2">
                            <option value="">اختر اتجاه</option>
                            <?php $__currentLoopData = $directions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $direction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($direction->id); ?>"><?php echo e($direction->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-row">
                            <i class="fa fa-trash"></i> حذف
                        </button>
                    </td>
                </tr>
            `;
            $('#groups-directions-table tbody').append(newRow);
            $('.select2').select2(); // إعادة تهيئة select2 للعناصر الجديدة
        });

        // حذف صف
        $(document).on('click', '.remove-row', function() {
            if ($('#groups-directions-table tbody tr').length > 1) {
                $(this).closest('tr').remove();
            } else {
                alert('يجب أن يبقى صف واحد على الأقل');
            }
        });
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/hr/employee/create.blade.php ENDPATH**/ ?>