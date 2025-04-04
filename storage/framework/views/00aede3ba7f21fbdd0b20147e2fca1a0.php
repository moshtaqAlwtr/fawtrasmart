<?php $__env->startSection('title'); ?>
    مسير الراتب
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2"></i>
                <strong><?php echo e(session('success')); ?></strong>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">مسير الراتب</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                            <li class="breadcrumb-item active">عرض </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">


                    <div class="d-flex align-items-center gap-3">
                        <div class="btn-group">
                            <button class="btn btn-light border">
                                <i class="fa fa-chevron-right"></i>
                            </button>
                            <button class="btn btn-light border">
                                <i class="fa fa-chevron-left"></i>
                            </button>
                        </div>
                        <span class="mx-2">1 - 1 من 1</span>
                        <div class="input-group" style="width: 150px">
                            <input type="text" class="form-control text-center" value="صفحة 1 من 1">
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-gradient-secondary border dropdown-toggle" type="button">
                                الإجراءات
                            </button>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-gradient-info border">
                                <i class="fa fa-table"></i>
                            </button>
                        </div>
                    </div>
                    <div class="d-flex" style="gap: 15px">
                        <a href="<?php echo e(route('PayrollProcess.create')); ?>" class="btn btn-success">
                            <i class="fa fa-plus me-2"></i>
                            أضف مسير الراتب
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <form class="form" method="GET" action="<?php echo e(route('PayrollProcess.index')); ?>">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <h4 class="card-title">بحث</h4>
                    </div>

                    <div class="card-body">
                        <div class="form-body row">
                            <div class="form-group col-md-4">
                                <label for="name" class=""> اختر مسير راتب </label>
                                <select id="name" name="name" class="form-control">
                                    <option value="">اختر مسير راتب</option>
                                    <?php $__currentLoopData = $payrolls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payroll): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($payroll->name); ?>" <?php echo e(request('name') == $payroll->name ? 'selected' : ''); ?>>
                                            <?php echo e($payroll->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
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

                            <div class="form-group col-md-4">
                                <label for="department_id" class=""> اختر القسم </label>
                                <select id="department_id" name="department_id" class="form-control">
                                    <option value="">اختر القسم</option>
                                    <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($department->id); ?>" <?php echo e(request('department_id') == $department->id ? 'selected' : ''); ?>>
                                            <?php echo e($department->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="collapse" id="advancedSearchForm">
                            <div class="form-body row">
                                <div class="form-group col-md-4">
                                    <label>الفترة (من)</label>
                                    <input type="date" name="start_date" class="form-control text-start" value="<?php echo e(request('start_date')); ?>">
                                </div>

                                <div class="form-group col-md-4">
                                    <label>الفترة (إلى)</label>
                                    <input type="date" name="end_date" class="form-control text-start" value="<?php echo e(request('end_date')); ?>">
                                </div>

                                <div class="form-group col-md-4">
                                    <label>إختر المسمى الوظيفي</label>
                                    <select name="jop_title_id" class="form-control">
                                        <option value="">إختر المسمى الوظيفي</option>
                                        <?php $__currentLoopData = $jobTitles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($title->id); ?>" <?php echo e(request('jop_title_id') == $title->id ? 'selected' : ''); ?>>
                                                <?php echo e($title->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>تاريخ التسجيل (من)</label>
                                    <input type="date" name="registration_date_from" class="form-control text-start" value="<?php echo e(request('registration_date_from')); ?>">
                                </div>

                                <div class="form-group col-md-4">
                                    <label>تاريخ التسجيل (إلى)</label>
                                    <input type="date" name="registration_date_to" class="form-control text-start" value="<?php echo e(request('registration_date_to')); ?>">
                                </div>

                                <div class="form-group col-md-4">
                                    <label>تاريخ الانشاء (من)</label>
                                    <input type="date" name="created_at_from" class="form-control text-start" value="<?php echo e(request('created_at_from')); ?>">
                                </div>

                                <div class="form-group col-md-4">
                                    <label>تاريخ الإنشاء (إلى)</label>
                                    <input type="date" name="created_at_to" class="form-control text-start" value="<?php echo e(request('created_at_to')); ?>">
                                </div>

                                <div class="form-group col-md-4">
                                    <label>إختر الفروع</label>
                                    <select name="branch_id" class="form-control">
                                        <option value="">إختر الفروع</option>
                                        <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($branch->id); ?>" <?php echo e(request('branch_id') == $branch->id ? 'selected' : ''); ?>>
                                                <?php echo e($branch->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary mr-1 waves-effect waves-light">بحث</button>
                            <a class="btn btn-outline-secondary ml-2 mr-2" data-toggle="collapse" data-target="#advancedSearchForm">
                                <i class="bi bi-sliders"></i> بحث متقدم
                            </a>
                            <button type="reset" class="btn btn-outline-warning waves-effect waves-light">إلغاء</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-end">الاسم</th>
                                <th class="text-end">الفترة</th>
                                <th class="text-end">قسائم الرواتب</th>
                                <th class="text-end">المبالغ</th>
                                <th class="text-end">الحالة</th>
                                <th class="text-end">ترتيب بواسطة</th>
                                <th class="text-end" style="width: 10%"></th>
                            </tr>
                        </thead>
                        <?php $__currentLoopData = $payrolls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payroll): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tbody>
                                <tr>
                                    <td><span> <?php echo e($payroll->id); ?></span>
                                        <?php echo e($payroll->name); ?></td>
                                    <td>
                                        <div><?php echo e($payroll->start_date); ?> - <?php echo e($payroll->end_date); ?></div>
                                        <small class="text-muted"><?php echo e($payroll->end_date); ?></small>
                                    </td>
                                    <td>1</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fa fa-circle text-secondary me-1" style="font-size: 8px;"></i>
                                            تم إنشاؤها
                                        </div>
                                    </td>
                                    <td>
                                        <div>0 مدفوعة / 0 موافق عليه</div>
                                        <small class="text-muted">تم إنشاؤها</small>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <div class="dropdown">
                                                <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1 btn-sm"
                                                    type="button" id="dropdownMenuButton303" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false"></button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton303">
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="<?php echo e(route('PayrollProcess.show', $payroll->id)); ?>">
                                                            <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-danger" href="#"
                                                            data-toggle="modal"
                                                            data-target="#modal_DELETE_<?php echo e($payroll->id); ?>">
                                                            <i class="fa fa-trash me-2"></i>حذف
                                                        </a>
                                                    </li>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>

                            <!-- Delete Modal for each payroll -->
                            <div class="modal fade text-left" id="modal_DELETE_<?php echo e($payroll->id); ?>" tabindex="-1"
                                role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color: #EA5455 !important;">
                                            <h4 class="modal-title" id="myModalLabel1" style="color: #FFFFFF">حذف</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true" style="color: #DC3545">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <strong>هل انت متاكد من انك تريد حذف مسير الرواتب
                                                "<?php echo e($payroll->name); ?>"؟</strong>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light waves-effect waves-light"
                                                data-dismiss="modal">الغاء</button>
                                            <form action="<?php echo e(route('PayrollProcess.destroy', $payroll->id)); ?>"
                                                method="post" style="display: inline;">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit"
                                                    class="btn btn-danger waves-effect waves-light">تأكيد</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script>
$('#employee-select-employees').select2({
    allowClear: true
});

$('#employee-select-rules').select2({
    allowClear: true
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/salaries/payroll_ process/index.blade.php ENDPATH**/ ?>