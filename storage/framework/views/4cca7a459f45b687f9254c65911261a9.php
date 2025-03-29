<?php $__env->startSection('title'); ?>
    المخزون
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">ادارة المنتجات</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a>
                            </li>
                            <li class="breadcrumb-item active">اضافه عملية على المخزون
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

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <div>
                            <strong><?php echo e($product->name); ?> </strong> | <small><?php echo e($product->serial_number); ?>#</small> | <span class="badge badge-pill badge badge-success">في المخزن</span>
                        </div>
                    </div>

                    <div></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form action="<?php echo e(route('products.add_manual_stock_adjust',$product->id)); ?>" method="POST" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label for="email-id-vertical">عملية اضافة او سحب</label>
                                                <select class="form-control" name="type">
                                                    <option value="1" <?php echo e(old('type') == 1 ? 'selected' : ''); ?>>اضافة</option>
                                                    <option value="2" <?php echo e(old('type') == 2 ? 'selected' : ''); ?>>سحب</option>
                                                </select>
                                            </div>
                                        </div>
                                       <?php if($role): ?>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="quantity">الكمية</label>
                                                <div class="input-group">
                                                    <input type="text" id="quantity" class="form-control" name="quantity" value="<?php echo e(old('quantity')); ?>">
                                                    <select class="form-select form-select-sm" id="sub-unit" name="sub_unit_id" style="width: auto;">
                                                        <?php $__currentLoopData = $SubUnits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $SubUnit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($SubUnit->id); ?>" <?php echo e($key == 0 ? 'selected' : ''); ?>>
                                                                <?php echo e($SubUnit->larger_unit_name); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <?php else: ?>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="first-name-vertical">الكمية</label>
                                                <input type="text" id="first-name-vertical" class="form-control" name="quantity" value="<?php echo e(old('quantity')); ?>">
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    

                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="email-id-vertical">سعر الوحدة</label>
                                                <input type="text" class="form-control" name="unit_price" value="<?php echo e(old('unit_price', $product->sale_price)); ?>">
                                            </div>
                                        </div>

                                        <div class="col-2">
                                            <div class="form-group">
                                                <label for="email-id-vertical">تاريخ الحركة</label>
                                                <input type="date" class="form-control" name="date" id="date" value="<?php echo e(old('date')); ?>">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label for="email-id-vertical">الوقت</label>
                                                <input type="time" class="form-control" name="time" id="time" value="<?php echo e(old('time')); ?>">
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="first-name-vertical">المستودع</label>
                                                <select class="form-control" name="store_house_id">
                                                    <?php $__currentLoopData = $storehouses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $storehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($storehouse->id); ?>" <?php echo e(old('store_house_id') == $storehouse->id ? 'selected' : ''); ?>><?php echo e($storehouse->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="email-id-vertical">نوع العملية</label>
                                                <select class="form-control" name="type_of_operation">
                                                    <option value="1" <?php echo e(old('type_of_operation') == 1 ? 'selected' : ''); ?>>رصيد افتتاحي</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="email-id-vertical">الحساب الفرعي</label>
                                                <input type="text" class="form-control" name="subaccount" value="<?php echo e(old('subaccount')); ?>">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="status">الحالة</label>
                                                <select class="form-control" name="status">
                                                    <option value="1">معلق</option>
                                                    <option value="2">مكتمل</option>
                                                    <option value="3">متجاهل</option>
                                                    <option value="4">مجدول مرة أخرى</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="duration">المدة</label>
                                                <input type="number" class="form-control" name="duration" value="<?php echo e(old('duration')); ?>">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="email-id-vertical">المرفقات</label>
                                                <input type="file" class="form-control" name="attachments" value="<?php echo e(old('attachments')); ?>">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="email-id-vertical">ملاحظات</label>
                                                <textarea name="comments" class="form-control" id="comments" rows="2"><?php echo e(old('comments')); ?></textarea>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">حفظ</button>
                                            <button type="reset" class="btn btn-outline-warning mr-1 mb-1 waves-effect waves-light">تفريغ</button>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // الحصول على التاريخ والوقت الحاليين
            const now = new Date();

            // تنسيق التاريخ إلى YYYY-MM-DD
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0'); // الأشهر من 0 إلى 11
            const day = String(now.getDate()).padStart(2, '0');
            const formattedDate = `${year}-${month}-${day}`;

            // تنسيق الوقت إلى HH:MM
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const formattedTime = `${hours}:${minutes}`;

            // تعيين القيم في حقلي الإدخال
            document.getElementById('date').value = formattedDate;
            document.getElementById('time').value = formattedTime;
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtrasmart\fawtrasmart\resources\views/stock/products/manual_stock_adjust.blade.php ENDPATH**/ ?>