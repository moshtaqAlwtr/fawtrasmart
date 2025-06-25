<?php $__env->startSection('title'); ?>
خزائن الموظفين
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">خزائن الموظفين</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a>
                            </li>
                            <li class="breadcrumb-item active">تعديل
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
                        <a href="<?php echo e(route('finance_settings.treasury_employee')); ?>" class="btn btn-outline-danger">
                            <i class="fa fa-ban"></i>الغاء
                        </a>

                        <button type="submit" form="expenses_form" class="btn btn-outline-primary">
                            <i class="fa fa-save"></i>تحديث
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form id="expenses_form" action="<?php echo e(route('treasury_employee.update',$treasury_employee->id)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row">

                        <div class="form-group col-md-6">
                            <label for="amount">الموظف <span style="color: red">*</span></label>
                            <select class="form-control" name="employee_id">
                                <option selected value="">-- اختر الموظف --</option>
                                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($employee->id); ?>" <?php echo e(old('employee_id',$treasury_employee->employee_id) == $employee->id ? 'selected' : ''); ?>><?php echo e($employee->full_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['employee_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-danger" id="basic-default-name-error" class="error">
                                <?php echo e($message); ?>

                            </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="amount">الخزينة الافتراضية <span style="color: red">*</span></label>
                            <select class="form-control" name="treasury_id">
                                <option selected value="">-- اختر الخزينة --</option>
                                <?php $__currentLoopData = $treasuries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $treasury): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($treasury->id); ?>" <?php echo e(old('treasury_id',$treasury_employee->treasury_id) == $treasury->id ? 'selected' : ''); ?>><?php echo e($treasury->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['treasury_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-danger" id="basic-default-name-error" class="error">
                                <?php echo e($message); ?>

                            </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                    </div>

                </form>
            </div>
        </div>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/finance/treasury_employee/edit.blade.php ENDPATH**/ ?>