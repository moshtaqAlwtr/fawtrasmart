<?php $__env->startSection('title'); ?>
    قسيمة الراتب
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
                    <h2 class="content-header-title float-left mb-0">قسيمة الراتب</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                            <li class="breadcrumb-item active">قسيمة الراتب</li>
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
                        <a href="<?php echo e(route('salarySlip.create')); ?>" class="btn btn-primary">
                            <i class="fa fa-plus me-2"></i>
                            أضف قسيمة الراتب
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <h4 class="card-title">بحث</h4>
                </div>

                <div class="card-body">

                    <form class="form" method="GET" action="<?php echo e(route('salarySlip.index')); ?>">
                        <div class="form-body row">
                            <div class="form-group col-md-4">
                                <label for="employee_name">اسم الموظف</label>
                                <input type="text" id="employee_name" class="form-control" placeholder="اسم الموظف"
                                    name="employee_name" value="<?php echo e(request('employee_name')); ?>">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="payrun">PayRun</label>
                                <input type="text" id="payrun" class="form-control" placeholder="PayRun"
                                    name="payrun" value="<?php echo e(request('payrun')); ?>">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="department">اختر القسم</label>
                                <select id="department" name="department" class="form-control">
                                    <option value="">اختر القسم</option>
                                    <?php $__currentLoopData = $departments ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($department->id); ?>"
                                            <?php echo e(request('department') == $department->id ? 'selected' : ''); ?>>
                                            <?php echo e($department->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="collapse" id="advancedSearchForm">
                            <div class="form-body row">
                                <?php if (isset($component)) { $__componentOriginal8cee41e4af1fe2df52d1d5acd06eed36 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8cee41e4af1fe2df52d1d5acd06eed36 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form.select','data' => ['label' => 'عملة','name' => 'currency','id' => 'from_currency','col' => '4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'عملة','name' => 'currency','id' => 'from_currency','col' => '4']); ?>
                                    <option value="">العملة</option>
                                    <?php $__currentLoopData = \App\Helpers\CurrencyHelper::getAllCurrencies(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($code); ?>"
                                            <?php echo e(request('currency') == $code ? 'selected' : ''); ?>>
                                            <?php echo e($code); ?> <?php echo e($name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8cee41e4af1fe2df52d1d5acd06eed36)): ?>
<?php $attributes = $__attributesOriginal8cee41e4af1fe2df52d1d5acd06eed36; ?>
<?php unset($__attributesOriginal8cee41e4af1fe2df52d1d5acd06eed36); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8cee41e4af1fe2df52d1d5acd06eed36)): ?>
<?php $component = $__componentOriginal8cee41e4af1fe2df52d1d5acd06eed36; ?>
<?php unset($__componentOriginal8cee41e4af1fe2df52d1d5acd06eed36); ?>
<?php endif; ?>

                                <div class="form-group col-md-4">
                                    <label>الفترة (من)</label>
                                    <input type="date" name="period_from" class="form-control text-start"
                                        value="<?php echo e(request('period_from')); ?>">
                                </div>

                                <div class="form-group col-md-4">
                                    <label>الفترة (إلى)</label>
                                    <input type="date" name="period_to" class="form-control text-start"
                                        value="<?php echo e(request('period_to')); ?>">
                                </div>

                                <div class="form-group col-md-4">
                                    <label>المسمى الوظيفي</label>
                                    <select name="job_title" class="form-control">
                                        <option value="">إختر المسمى الوظيفي</option>
                                        <?php $__currentLoopData = $jobTitles ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jobTitle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($jobTitle->id); ?>"
                                                <?php echo e(request('job_title') == $jobTitle->id ? 'selected' : ''); ?>>
                                                <?php echo e($jobTitle->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>تاريخ التسجيل (من)</label>
                                    <input type="date" name="registration_from" class="form-control text-start"
                                        value="<?php echo e(request('registration_from')); ?>">
                                </div>

                                <div class="form-group col-md-4">
                                    <label>تاريخ التسجيل (إلى)</label>
                                    <input type="date" name="registration_to" class="form-control text-start"
                                        value="<?php echo e(request('registration_to')); ?>">
                                </div>

                                <div class="form-group col-md-4">
                                    <label>الحالة</label>
                                    <select name="status" class="form-control">
                                        <option value="">كل الحالات</option>
                                        <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>نشط
                                        </option>
                                        <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>>
                                            غير نشط</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>تاريخ الإنشاء (من)</label>
                                    <input type="date" name="created_from" class="form-control text-start"
                                        value="<?php echo e(request('created_from')); ?>">
                                </div>

                                <div class="form-group col-md-4">
                                    <label>تاريخ الإنشاء (إلى)</label>
                                    <input type="date" name="created_to" class="form-control text-start"
                                        value="<?php echo e(request('created_to')); ?>">
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Overlap Start</label>
                                    <input type="date" name="overlap_start" class="form-control text-start"
                                        value="<?php echo e(request('overlap_start')); ?>">
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Overlap End</label>
                                    <input type="date" name="overlap_end" class="form-control text-start"
                                        value="<?php echo e(request('overlap_end')); ?>">
                                </div>

                                <div class="form-group col-md-4">
                                    <label>الفروع</label>
                                    <select name="branch" class="form-control">
                                        <option value="">إختر الفروع</option>
                                        <?php $__currentLoopData = $branches ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($branch->id); ?>"
                                                <?php echo e(request('branch') == $branch->id ? 'selected' : ''); ?>>
                                                <?php echo e($branch->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary mr-1">بحث</button>
                            <a class="btn btn-outline-secondary ml-2 mr-2" data-toggle="collapse"
                                href="#advancedSearchForm">
                                <i class="bi bi-sliders"></i> بحث متقدم
                            </a>
                            <button type="reset" class="btn btn-outline-warning">إلغاء</button>
                        </div>
                    </form>
                </div>

            </div>

        </div>

        <?php if(isset($salarySlip) && $salarySlip->count() > 0): ?>
            <div class="card">
                <div class="card-body">

                    <table class="table">
                        <thead>
                            <tr>

                                <th>المعرف</th>
                                <th>اسم الموظف</th>
                                <th> الفترة</th>
                                <th> اجمالي المبلغ</th>
                                <th> الحالة</th>
                                <th style="width: 10%">الترتيب</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $salarySlip; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" style="margin-left: 10px;">
                                        <?php echo e($slip->id); ?>

                                    </td>
                                    <td><?php echo e($slip->employee->first_name); ?> <?php echo e($slip->employee->middle_name); ?> <?php echo e($slip->employee->nickname); ?></td>
                                    <td><?php echo e(date('d/m/Y', strtotime($slip->from_date))); ?> -
                                        <?php echo e(date('d/m/Y', strtotime($slip->to_date))); ?></td>

                                    <td><?php echo e($slip->net_salary); ?></td>
                                   <td>
            <?php if($slip->status == 'approved'): ?>
                <span class="badge badge-success">
                    ✅ تمت الموافقة
                </span>
            <?php else: ?>
                <span class="badge badge-danger">
                    ❌ لم يتم الموافقة
                </span>
            <?php endif; ?>
        </td>
                                    <td>
                                        <div class="btn-group">
                                            <div class="dropdown">
                                                <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1 btn-sm"
                                                    type="button"id="dropdownMenuButton303" data-toggle="dropdown"
                                                    aria-haspopup="true"aria-expanded="false"></button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton303">
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="<?php echo e(route('salarySlip.show', $slip->id)); ?>">
                                                            <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="<?php echo e(route('salarySlip.edit', $slip->id)); ?>">
                                                            <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a class="dropdown-item text-danger" href="#"
                                                            data-toggle="modal"
                                                            data-target="#modal_DELETE<?php echo e($slip->id); ?>">
                                                            <i class="fa fa-trash"></i> حذف
                                                        </a>
                                                    </li>
                                                </div>
                                            </div>
                                        </div>
                                    </td>


                                    <div class="modal fade" id="modal_DELETE<?php echo e($slip->id); ?>" tabindex="-1"
                                        role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger">
                                                    <h5 class="modal-title text-white">تأكيد الحذف</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="<?php echo e(route('salarySlip.destroy', $slip->id)); ?>"
                                                    method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <div class="modal-body">
                                                        <p>هل أنت متأكد من حذف بند الراتب
                                                            "<?php echo e($slip->name); ?>"؟</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">إلغاء</button>
                                                        <button type="submit" class="btn btn-danger">تأكيد
                                                            الحذف</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>
                    </table>


                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-danger text-xl-center" role="alert">
                <p class="mb-0">
                    لا توجد مضافة حتى الان قسائم الرواتب !!
                </p>
            </div>
        <?php endif; ?>




    <?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/salaries/salary_slip/index.blade.php ENDPATH**/ ?>