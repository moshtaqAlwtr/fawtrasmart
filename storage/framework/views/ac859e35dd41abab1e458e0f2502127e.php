<?php $__env->startSection('title'); ?>
خزائن وحسابات بنكية
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">خزائن وحسابات بنكية</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a>
                            </li>
                            <li class="breadcrumb-item active">تعديل خزينة
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
                        <a href="<?php echo e(route('treasury.index')); ?>" class="btn btn-outline-danger">
                            <i class="fa fa-ban"></i>الغاء
                        </a>
                        <button type="submit" form="products_form" class="btn btn-outline-primary">
                            <i class="fa fa-save"></i>تحديث
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">تسجيل البيانات</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form id="products_form" class="form form-vertical" action="<?php echo e(route('treasury.update',$treasury->id)); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="form-body">
                            <div class="row">

                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="first-name-vertical">النوع</label>
                                        <input type="text" disabled id="first-name-vertical" class="form-control" value="خزينة">
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="first-name-vertical">الحالة</label>
                                        <select class="form-control" id="basicSelect" name="status">
                                            <option value="0" <?php echo e(old('status',$treasury->status) == 0 ? 'selected' : ''); ?>>نشط</option>
                                            <option value="1" <?php echo e(old('status',$treasury->status) == 1 ? 'selected' : ''); ?>>غير نشط</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="email-id-vertical">اسم الخزينة<span style="color: red">*</span></label>
                                        <input type="text" id="email-id-vertical" class="form-control"name="name" value="<?php echo e(old('name',$treasury->name)); ?>">
                                        <?php $__errorArgs = ['name'];
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

                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="email-id-vertical">الوصف</label>
                                        <textarea name="description" class="form-control" id="basicTextarea" rows="2"><?php echo e(old('description',$treasury->description)); ?></textarea>
                                    </div>
                                </div>

                            </div>

                            <hr>
                            <div class="card">
                                <div class="card-header">
                                    <h5>الصلاحيات</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="first-name-icon">ايداع</label>
                                                <select class="form-control" id="deposit_permissions" name="deposit_permissions">
                                                    <option selected value="0">الكل</option>
                                                    <option value="1" <?php echo e(old('deposit_permissions',$treasury->deposit_permissions) == 1 ? 'selected' : ''); ?>>موظف محدد</option>
                                                    <option value="2" <?php echo e(old('deposit_permissions',$treasury->deposit_permissions) == 2 ? 'selected' : ''); ?>>دور وظيفي محدد</option>
                                                    <option value="3" <?php echo e(old('deposit_permissions',$treasury->deposit_permissions) == 3 ? 'selected' : ''); ?>>فرع محدد</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="first-name-icon">سحب</label>
                                                <select class="form-control" id="withdraw_permissions" name="withdraw_permissions">
                                                    <option value="0">الكل</option>
                                                    <option value="1" <?php echo e(old('withdraw_permissions',$treasury->withdraw_permissions) == 1 ? 'selected' : ''); ?>>موظف محدد</option>
                                                    <option value="2" <?php echo e(old('withdraw_permissions',$treasury->withdraw_permissions) == 2 ? 'selected' : ''); ?>>دور وظيفي محدد</option>
                                                    <option value="3" <?php echo e(old('withdraw_permissions',$treasury->withdraw_permissions) == 3 ? 'selected' : ''); ?>>فرع محدد</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-6">
                                            <div class="form-group" style='display: none' id="employee_id">
                                                <label for="first-name-icon">اختر الموظف</label>
                                                <select class="form-control" name="v_employee_id">
                                                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="1"><?php echo e($employee->full_name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                            <div class="form-group" style='display: none' id="functional_role_id">
                                                <label for="first-name-icon">اختر الدور الوظيفي</label>
                                                <select class="form-control" name="v_functional_role_id">
                                                    <option value="1">دور وظيفي 1</option>
                                                    <option value="2">دور وظيفي 2</option>
                                                    <option value="3">دور وظيفي 3</option>
                                                </select>
                                            </div>
                                            <div class="form-group" style='display: none' id="branch_id">
                                                <label for="first-name-icon">اختر الفرع</label>
                                                <select class="form-control" name="v_branch_id">
                                                    <option value="1">فرع 1</option>
                                                    <option value="2">فرع 2</option>
                                                    <option value="3">فرع 3</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group" style='display: none' id="1employee_id">
                                                <label for="first-name-icon">اختر الموظف</label>
                                                <select class="form-control" name="c_employee_id">
                                                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="1"><?php echo e($employee->full_name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                            <div class="form-group" style='display: none' id="1functional_role_id">
                                                <label for="first-name-icon">اختر الدور الوظيفي</label>
                                                <select class="form-control" name="c_functional_role_id">
                                                    <option value="1">دور وظيفي 1</option>
                                                    <option value="2">دور وظيفي 2</option>
                                                    <option value="3">دور وظيفي 3</option>
                                                </select>
                                            </div>
                                            <div class="form-group" style='display: none' id="1branch_id">
                                                <label for="first-name-icon">اختر الفرع</label>
                                                <select class="form-control" name="c_branch_id">
                                                    <option value="1">فرع 1</option>
                                                    <option value="2">فرع 2</option>
                                                    <option value="3">فرع 3</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>


                        </div>
                </div>
            </div>
        </div>

    </div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        document.getElementById('deposit_permissions').onchange = function(){
            if(this.value == 1){
                document.getElementById('employee_id').style.display = '';
                document.getElementById('functional_role_id').style.display = 'none';
                document.getElementById('branch_id').style.display = 'none';
            } else if(this.value == 2) {
                document.getElementById('functional_role_id').style.display = '';
                document.getElementById('branch_id').style.display = 'none';
                document.getElementById('employee_id').style.display = 'none';
            } else if(this.value == 3) {
                document.getElementById('branch_id').style.display = '';
                document.getElementById('employee_id').style.display = 'none';
                document.getElementById('functional_role_id').style.display = 'none';
            }
            else{
                document.getElementById('branch_id').style.display = 'none';
                document.getElementById('employee_id').style.display = 'none';
                document.getElementById('functional_role_id').style.display = 'none';
            }
        };
    </script>

    <script>
        document.getElementById('withdraw_permissions').onchange = function(){
            if(this.value == 1){
                document.getElementById('1employee_id').style.display = '';
                document.getElementById('1functional_role_id').style.display = 'none';
                document.getElementById('1branch_id').style.display = 'none';
            } else if(this.value == 2) {
                document.getElementById('1functional_role_id').style.display = '';
                document.getElementById('1branch_id').style.display = 'none';
                document.getElementById('1employee_id').style.display = 'none';
            } else if(this.value == 3) {
                document.getElementById('1branch_id').style.display = '';
                document.getElementById('1employee_id').style.display = 'none';
                document.getElementById('1functional_role_id').style.display = 'none';
            }
            else{
                document.getElementById('1branch_id').style.display = 'none';
                document.getElementById('1employee_id').style.display = 'none';
                document.getElementById('1functional_role_id').style.display = 'none';
            }
        };
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/finance/treasury/edit.blade.php ENDPATH**/ ?>