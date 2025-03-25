<?php $__env->startSection('title'); ?>
    اضف طلب عرض سعر  مشتريات
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="card">

    </div>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">ادارة عروض الاسعار الشراء</h2>
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

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">

                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item">
                                    <button class="btn btn-sm btn-outline-secondary px-2" aria-label="Previous">
                                        <i class="fa fa-angle-right"></i>
                                    </button>
                                </li>
                                <li class="page-item mx-2">
                                    <span class="text-muted">صفحة 1 من 1</span>
                                </li>
                                <li class="page-item">
                                    <button class="btn btn-sm btn-outline-secondary px-2" aria-label="Next">
                                        <i class="fa fa-angle-left"></i>
                                    </button>
                                </li>
                            </ul>
                        </nav>

                        <span class="text-muted mx-2">1-1 من 1</span>

                        <a href="<?php echo e(route('Quotations.create')); ?>" class="btn btn-success">
                            <i class="fa fa-plus me-1"></i>
                            أضف طلب عرض اسعار شراء
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form class="form" method="GET" action="<?php echo e(route('Quotations.index')); ?>">
                    <div class="form-body row">
                        <div class="form-group col-md-3">
                            <label for="supplier_id">مورد</label>
                            <select name="supplier_id" class="form-control select2" id="supplier_id">
                                <option value=""> اختر المورد </option>
                                <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($supplier->id); ?>"
                                        <?php echo e(request('supplier_id') == $supplier->id ? 'selected' : ''); ?>>
                                        <?php echo e($supplier->trade_name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="follow_status">حالة المتابعة</label>
                            <select name="follow_status" class="form-control" id="follow_status">
                                <option value=""> جميع حالات المتابعة</option>
                                <option value="1" <?php echo e(request('follow_status') == '1' ? 'selected' : ''); ?>>متابع</option>
                                <option value="2" <?php echo e(request('follow_status') == '2' ? 'selected' : ''); ?>>غير متابع</option>
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="code">الكود</label>
                            <input type="text" class="form-control" name="code" id="code"
                                value="<?php echo e(request('code')); ?>" placeholder="ادخل الكود">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="order_date_from">تاريخ الطلب (من)</label>
                            <input type="date" class="form-control" name="order_date_from" id="order_date_from"
                                value="<?php echo e(request('order_date_from')); ?>">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="order_date_to">تاريخ الطلب (إلى)</label>
                            <input type="date" class="form-control" name="order_date_to" id="order_date_to"
                                value="<?php echo e(request('order_date_to')); ?>">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="due_date_from">تاريخ الاستحقاق (من)</label>
                            <input type="date" class="form-control" name="due_date_from" id="due_date_from"
                                value="<?php echo e(request('due_date_from')); ?>">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="due_date_to">تاريخ الاستحقاق (إلى)</label>
                            <input type="date" class="form-control" name="due_date_to" id="due_date_to"
                                value="<?php echo e(request('due_date_to')); ?>">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="status">الحالة</label>
                            <select class="form-control" name="status" id="status">
                                <option value="">الحالة</option>
                                <option value="1" <?php echo e(request('status') == '1' ? 'selected' : ''); ?>>نشط</option>
                                <option value="2" <?php echo e(request('status') == '2' ? 'selected' : ''); ?>>متوقف</option>
                                <option value="3" <?php echo e(request('status') == '3' ? 'selected' : ''); ?>>غير نشط</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary mr-1">
                            <i class="fa fa-search"></i> بحث
                        </button>
                        <a href="<?php echo e(route('Quotations.index')); ?>" class="btn btn-outline-danger">
                            <i class="fa fa-times"></i> إلغاء الفلترة
                        </a>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <?php if($purchaseQuotation->count() > 0): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 5%">
                                    <input type="checkbox" class="form-check-input" id="selectAll">
                                </th>
                                <th>الكود</th>
                                <th>تاريخ الطلب</th>
                                <th>تاريخ الاستحقاق</th>

                                <th>الحالة</th>
                                <th style="width: 10%">خيارات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $purchaseQuotation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input order-checkbox"
                                            value="<?php echo e($quot->id); ?>">
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar me-2" style="background-color: #4B6584">
                                                <span class="avatar-content"><?php echo e(substr($quot->code, 0, 1)); ?></span>
                                            </div>
                                            <div>
                                                <?php echo e($quot->code); ?>

                                                <div class="text-muted small">#<?php echo e($quot->id); ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo e($quot->title); ?></td>
                                    <td><?php echo e(\Carbon\Carbon::parse($quot->order_date)->format('Y-m-d')); ?></td>
                                    <td>
                                        <?php if($quot->due_date): ?>
                                            <?php echo e(\Carbon\Carbon::parse($quot->due_date)->format('Y-m-d')); ?>

                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php if($quot->status == 1): ?>
                                            <span class="badge bg-warning">تحت المراجعة </span>
                                        <?php elseif($quot->status == 2): ?>
                                            <span class="badge bg-success">تم الموافقة علية </span>
                                        <?php elseif($quot->status == 3): ?>
                                            <span class="badge bg-danger">مرفوض</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <div class="dropdown">
                                                <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1 btn-sm"
                                                    type="button" id="dropdownMenuButton<?php echo e($quot->id); ?>"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end"
                                                    aria-labelledby="dropdownMenuButton<?php echo e($quot->id); ?>">
                                                    <a class="dropdown-item"
                                                        href="<?php echo e(route('Quotations.show', $quot->id)); ?>">
                                                        <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                    </a>
                                                    <a class="dropdown-item"
                                                        href="<?php echo e(route('Quotations.edit', $quot->id)); ?>">
                                                        <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                    </a>
                                                    <a class="dropdown-item text-danger" href="#"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal<?php echo e($quot->id); ?>">
                                                        <i class="fa fa-trash me-2"></i>حذف
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal delete -->
                                        <div class="modal fade" id="deleteModal<?php echo e($quot->id); ?>" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title">حذف طلب الشراء</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>هل أنت متأكد من حذف طلب الشراء رقم "<?php echo e($quot->code); ?>"؟
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light"
                                                            data-bs-dismiss="modal">إلغاء</button>
                                                        <form action="<?php echo e(route('Quotations.destroy', $quot->id)); ?>"
                                                            method="POST" class="d-inline">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                            <button type="submit" class="btn btn-danger">حذف</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="alert alert-info text-center" role="alert">
                        <p class="mb-0">لا يوجد طلبات شراء مضافة حتى الآن</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>




<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/Purchases/Quotations/index.blade.php ENDPATH**/ ?>