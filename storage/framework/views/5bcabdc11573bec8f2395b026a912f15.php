<?php $__env->startSection('title'); ?>
    سلفة الراتب
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
                    <h2 class="content-header-title float-left mb-0">السلفة الراتب</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                            <li class="breadcrumb-item active"> عرض </li>
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
                        <a href="<?php echo e(route('ancestor.create')); ?>" class="btn btn-success">
                            <i class="fa fa-plus me-2"></i>
                            أضف سلفة
                        </a>

                    </div>
                </div>
            </div>
        </div>

        <form class="form" method="GET" action="<?php echo e(route('ancestor.index')); ?>">
            <div class="card">
                <div class="card-body">
                    <div class="form-body row">
                        <div class="form-group col-md-4">
                            <label for="advance_search">السلف</label>
                            <input type="text" id="advance_search" class="form-control" placeholder="البحث بواسطة السلف"
                                name="advance_search" value="<?php echo e(request('advance_search')); ?>">
                        </div>

                        <div class="form-group col-md-4">
                            <label>إختر فترة القسط</label>
                            <select class="form-control" name="payment_rate">
                                <option value="">إختر فترة القسط</option>
                                <?php $__currentLoopData = $paymentRates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $rate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>"
                                        <?php echo e(request('payment_rate') == $key ? 'selected' : ''); ?>>
                                        <?php echo e($rate); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="employee_search">البحث بواسطة الموظف</label>


                            <select class="form-control"name="employee_search" value="<?php echo e(request('employee_search')); ?>">
                                <option>اختر الموظف</option>
                                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($employee->id); ?>"
                                        <?php echo e(request('employee') == $employee->id ? 'selected' : ''); ?>>
                                        <?php echo e($employee->first_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-body row">
                        <div class="form-group col-md-4">
                            <label>الدفعة القادمة (من)</label>
                            <input type="date" class="form-control text-start" name="next_payment_from"
                                value="<?php echo e(request('next_payment_from')); ?>">
                        </div>

                        <div class="form-group col-md-4">
                            <label>الدفعة القادمة (إلى)</label>
                            <input type="date" class="form-control text-start" name="next_payment_to"
                                value="<?php echo e(request('next_payment_to')); ?>">
                        </div>

                        <div class="form-group col-md-4">
                            <label>الحالة</label>
                            <select class="form-control" name="status">
                                <option value="">إختر الحالة</option>
                                <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>" <?php echo e(request('status') == $key ? 'selected' : ''); ?>>
                                        <?php echo e($status); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="collapse <?php echo e(request()->hasAny(['branch_id', 'tag']) ? 'show' : ''); ?>"
                        id="advancedSearchForm">
                        <div class="form-body row">
                            <div class="form-group col-md-4">
                                <label>اختر فرع</label>
                                <select class="form-control" name="branch_id">
                                    <option value="">كل الفروع</option>
                                    <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($branch->id); ?>"
                                            <?php echo e(request('branch_id') == $branch->id ? 'selected' : ''); ?>>
                                            <?php echo e($branch->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label>اختر وسم</label>
                                <input type="text" class="form-control" name="tag">


                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary mr-1">
                            <i class="fa fa-search"></i> بحث
                        </button>

                        <a class="btn btn-outline-secondary ml-2 mr-2" data-toggle="collapse"
                            data-target="#advancedSearchForm">
                            <i class="bi bi-sliders"></i> بحث متقدم
                        </a>

                        <a href="<?php echo e(route('ancestor.index')); ?>" class="btn btn-outline-warning">
                            <i class="fa fa-refresh"></i> إعادة تعيين
                        </a>
                    </div>
                </div>
            </div>
        </form>

        <div class="card">
            <div class="card-body">

                <table class="table">
                    <thead>
                        <tr>
                            <th>معرف السلفة</th>
                            <th>موظف</th>
                            <th>الأقساط المدفوعة</th>
                            <th>الدفعة القادمة</th>
                            <th>المبلغ</th>
                            <th>وسوم</th>
                            <th>ترتيب بواسطة</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $ancestors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ancestor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($ancestor->id); ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="btn btn-info btn-sm ms-2"
                                            style="background-color: #0dcaf0; border-color: #0dcaf0;">
                                            <?php echo e(mb_substr($ancestor->employee->full_name ?? 'غ', 0, 1, 'UTF-8')); ?>

                                        </div>
                                        <span class="text-primary" style="color: #0d6efd !important;">
                                            <?php echo e($ancestor->employee->full_name); ?>

                                            <span style="margin-right: 4px;">#<?php echo e($ancestor->employee->id); ?></span>
                                        </span>
                                    </div>
                                </td>


                                <!-- عمود الأقساط المدفوعة -->
                                <td>
                                    <?php echo e($ancestor->total_installments); ?> / <?php echo e($ancestor->paid_installments); ?>

                                </td>
                                <td><?php echo e($ancestor->installment_start_date); ?></td>

                                <td>
                                    <div style="text-align: right;">
                                        <div style="width: fit-content; margin-right: auto;">
                                            <div style="font-weight: bold; margin-bottom: 4px; position: relative;">
                                                <div style="border-bottom: 2px solid #ffc107; width: <?php echo e(($ancestor->installment_amount / $ancestor->amount) * 100); ?>%; position: absolute; bottom: -2px;"></div>
                                                <div style="border-bottom: 1px solid #dee2e6; width: fit-content;">
                                                    <?php echo e(number_format($ancestor->amount, 2)); ?> ر.س
                                                </div>
                                            </div>
                                            <div style="color: #666; font-size: 0.9em;">
                                                <span><?php echo e($ancestor->status ?? 'Paid'); ?></span>
                                                <span><?php echo e(number_format($ancestor->installment_amount, 2)); ?> ر.س</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td></td>
                                <td>
                                    <div class="btn-group">
                                        <div class="dropdown">
                                            <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1 btn-sm"
                                                type="button" id="dropdownMenuButton<?php echo e($ancestor->id); ?>"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            </button>
                                            <div class="dropdown-menu"
                                                aria-labelledby="dropdownMenuButton<?php echo e($ancestor->id); ?>">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="<?php echo e(route('ancestor.show', $ancestor->id)); ?>">
                                                        <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="<?php echo e(route('ancestor.edit', $ancestor->id)); ?>">
                                                        <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-danger" href="#"
                                                        data-toggle="modal"
                                                        data-target="#delete-modal-<?php echo e($ancestor->id); ?>">
                                                        <i class="fa fa-trash me-2"></i>حذف
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-success" href="#"
                                                        data-toggle="modal"
                                                        data-target="#copy-modal-<?php echo e($ancestor->id); ?>">
                                                        <i class="fa fa-copy me-2"></i>نسخ
                                                    </a>
                                                </li>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Delete -->
                                    <div class="modal fade" id="delete-modal-<?php echo e($ancestor->id); ?>" tabindex="-1"
                                        role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">تأكيد الحذف</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>هل أنت متأكد من حذف هذه السلفة؟</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="<?php echo e(route('ancestor.destroy', $ancestor->id)); ?>"
                                                        method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">إلغاء</button>
                                                        <button type="submit" class="btn btn-danger">حذف</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Copy -->
                                    <div class="modal fade" id="copy-modal-<?php echo e($ancestor->id); ?>" tabindex="-1"
                                        role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">نسخ السلفة</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>هل تريد نسخ هذه السلفة؟</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">إلغاء</button>
                                                    <a href="" class="btn btn-success">نسخ</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center">لا توجد سلف</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>




    <?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/salaries/ancestor/index.blade.php ENDPATH**/ ?>