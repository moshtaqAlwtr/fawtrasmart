<?php $__env->startSection('title'); ?>
    الموظفين
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <style>
        .profile-picture {
            width: 100px;
            height: 100px;
            background-color: #4CAF50;
            color: white;
            font-size: 24px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            padding: 2px;
        }

        .ficon {
            font-size: 12px;
        }

        .ml-auto a {
            color: #fff;
            background-color: #4e5381;
            border-color: #4e5381;
            border-radius: 5px;
            display: inline-block;
            margin-bottom: 5px;
            width: 100%;
            padding: 4px;

        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">الموظفين</h2>
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

        <?php echo $__env->make('layouts.alerts.error', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('layouts.alerts.success', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="container" style="max-width: 1200px">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-between align-items-center mb-1">
                        <?php
                            $firstLetter = mb_substr($employee->full_name, 0, 1, 'UTF-8');
                            $timestamp = strtotime($employee->created_at);
                            $formattedDate = date("d M Y \\a\\t h:i A", $timestamp);
                        ?>
                        <div class="mr-1">
                            
                            <div class="profile-picture"><?php echo e($firstLetter); ?></div>
                        </div>
                        <div class="user-page-info">
                            <p class="mb-0"><strong><?php echo e($employee->full_name); ?></strong>
                                <small>(<?php echo e($employee->employee_type == 1 ? 'موظف' : 'مستخدم'); ?>)</small></p>
                            <span class="font-small-2"><?php echo e($formattedDate); ?></span><br>
                            <span>#<?php echo e($employee->id); ?></span>
                        </div>
                        <div class="ml-auto">
                            <a href="mailto:<?php echo e($employee->email); ?>"
                                style="font-size: 18px; font-weight: bold; display: block; margin-bottom: 8px;">
                                <i class="ficon feather icon-mail"></i> <small>ايميل : <?php echo e($employee->email); ?></small>
                            </a>

                            <a href="<?php echo e(route('employee.login_to', $user->id ?? $employee->id)); ?>"
                                style="font-size: 18px; font-weight: bold; display: block; margin-bottom: 8px;">
                                <i class="ficon feather icon-user"></i> <small>تسجيل الدخول ك
                                    <?php echo e($employee->full_name); ?></small>
                            </a>

                            <a href="" style="font-size: 18px; font-weight: bold; display: block;">
                                <i class="ficon feather icon-smartphone"></i> <small>إعداد تطبيق الحضور</small>
                            </a>
                        </div>


                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-title p-1">
                    <a href="<?php echo e(route('employee.edit', $employee->id)); ?>" class="btn btn-outline-primary btn-sm">تعديل <i
                            class="fa fa-edit"></i></a>
                    <a href="#" class="btn btn-outline-danger btn-sm" data-toggle="modal"
                        data-target="#modal_DELETE<?php echo e($employee->id); ?>">حذف <i class="fa fa-trash"></i></a>
                    <a href="" class="btn btn-outline-success btn-sm" data-toggle="modal"
                        data-target="#ChangePassword">تغيير كلمه المرور <i class="fa fa-lock"></i></a>
                    <a href="<?php echo e(route('employee.updateStatus', $employee->id)); ?>"
                        class="btn btn-outline-<?php echo e($employee->status == 1 ? 'danger' : 'success'); ?> btn-sm waves-effect waves-light">
                        <?php echo e($employee->status == 1 ? 'تعطيل' : 'تفعيل'); ?>

                        <i class="fa <?php echo e($employee->status == 1 ? 'fa-ban' : 'fa-check'); ?>"></i>
                    </a>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" aria-controls="home"
                                role="tab" aria-selected="false">التفاصيل</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="activate-tab" data-toggle="tab" href="#activate" aria-controls="about"
                                role="tab" aria-selected="true">سجل النشاطات</a>
                        </li>

                    </ul>
                    <div class="tab-content">

                        <div class="tab-pane active" id="home" aria-labelledby="home-tab" role="tabpanel">

                            <div class="card">

                                <div class="card-body">
                                    <div class="row">
                                        <table class="table">
                                            <thead style="background: #f8f8f8">
                                                <tr>
                                                    <th>معلومات عامة</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <p><small>البريد الالكتروني</small>:
                                                            <strong><?php echo e($employee->email); ?></strong></p>
                                                        <p><small>الفروع المسموح الدخول به </small>:
                                                            <strong><?php echo e($employee->branch_id); ?></strong></p>
                                                    </td>
                                                    <td>
                                                        <p><small>الدور الوظيفي </small>:
                                                            <strong><?php echo e($employee->job_role->role_name ?? 'غير محدد'); ?></strong>
                                                        </p>
                                                        <p><small>لغة العرض </small>:
                                                            <strong><?php echo e($employee->language == 1 ? 'العربية' : 'انجليزي'); ?></strong>
                                                        </p>
                                                    </td>
                                                </tr>
                                            </tbody>

                                            <thead style="background: #f8f8f8">
                                                <tr>
                                                    <th>البيانات الشخصيه</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
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
                                                    <td>
                                                        <p><small>البلد </small>:
                                                            <strong><?php echo e($arabic_countries[$employee->country] ?? 'غير محدد'); ?></strong>
                                                        </p>
                                                        <p><small>تاريخ الميلاد </small>:
                                                            <strong><?php echo e($employee->date_of_birth); ?></strong></p>
                                                    </td>
                                                    <td>
                                                        <p><small>حاله الموطنة </small>: <strong>
                                                                <?php if($employee->nationality_status == 1): ?>
                                                                    مواطن
                                                                <?php elseif($employee->nationality_status == 2): ?>
                                                                    مقيم
                                                                <?php else: ?>
                                                                    زائر
                                                                <?php endif; ?>
                                                            </strong></p>
                                                        <p><small>النوع </small>:
                                                            <strong><?php echo e($employee->gender == 1 ? 'ذكر' : 'انثى'); ?></strong>
                                                        </p>
                                                    </td>
                                                </tr>
                                            </tbody>

                                            <thead style="background: #f8f8f8">
                                                <tr>
                                                    <th>العنوان</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <p><small>العنوان </small>:
                                                            <strong><?php echo e($employee->current_address_1); ?></strong></p>
                                                        <p><small>المدينة </small>: <strong><?php echo e($employee->city); ?></strong>
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <p><small>المنطقة </small>:
                                                            <strong><?php echo e($employee->region); ?></strong></p>
                                                        <p><small>الرمز البريدي </small>:
                                                            <strong><?php echo e($employee->postal_code); ?></strong></p>
                                                    </td>
                                                </tr>
                                            </tbody>

                                            <thead style="background: #f8f8f8">
                                                <tr>
                                                    <th>بيانات الوظيفة</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
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
                                                    <td>
                                                        <p><small>تاريخ الالتحاق </small>:
                                                            <strong><?php echo e($employee->hire_date); ?></strong></p>
                                                        <p><small>التاريخ المالي </small>:
                                                            <strong><?php echo e($employee->custom_financial_day . '-'); ?><?php echo e($months[$employee->custom_financial_month] ?? 'غير محدد'); ?></strong>
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <p><small>فرع </small>: <strong><?php echo e($employee->branch_id); ?></strong>
                                                        </p>
                                                    </td>
                                                </tr>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="tab-pane" id="activate" aria-labelledby="activate-tab" role="tabpanel">
                            <p>activate records</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal delete -->
        <div class="modal fade text-left" id="modal_DELETE<?php echo e($employee->id); ?>" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #EA5455 !important;">
                        <h4 class="modal-title" id="myModalLabel1" style="color: #FFFFFF">حذف <?php echo e($employee->full_name); ?>

                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: #DC3545">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <strong>
                            هل انت متاكد من انك تريد الحذف ؟
                        </strong>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light waves-effect waves-light"
                            data-dismiss="modal">الغاء</button>
                        <a href="<?php echo e(route('employee.delete', $employee->id)); ?>"
                            class="btn btn-danger waves-effect waves-light">تأكيد</a>
                    </div>
                </div>
            </div>
        </div>
        <!--end delete-->

        <!-- Modal change passwoard -->
        <div class="modal fade text-left" id="ChangePassword" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel1">تغير كلمة المرور</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form" action="<?php echo e(route('employee.updatePassword', $employee->id)); ?>"
                            method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-label-group">
                                            <input type="password" class="form-control" placeholder="كلمة المرور الجديدة"
                                                name="password" value="<?php echo e(old('password')); ?>">
                                            <label for="password">كلمة المرور الجديدة</label>
                                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="text-danger" class="error">
                                                    <?php echo e($message); ?>

                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-label-group">
                                            <input type="password" class="form-control" placeholder="تأكيد كلمة المرور"
                                                name="password_confirmation" value="<?php echo e(old('password_confirmation')); ?>">
                                            <label for="password_confirmation">تأكيد كلمة المرور</label>
                                            <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="text-danger" class="error">
                                                    <?php echo e($message); ?>

                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit"
                            class="btn btn-outline-primary btn-sm round mr-1 mb-1 waves-effect waves-light">حفظ</button>
                        <button type="reset"
                            class="btn btn-outline-warning btn-sm round mr-1 mb-1 waves-effect waves-light">تفريغ</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!--end Model change passwoard-->


    </div><!-- content-body -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/hr/employee/show.blade.php ENDPATH**/ ?>