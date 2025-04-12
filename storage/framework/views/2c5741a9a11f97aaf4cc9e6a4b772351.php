<?php $__env->startSection('title'); ?>
    اضافة عرض
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">اضافة عرض </h2>
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
    <?php echo $__env->make('layouts.alerts.error', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('layouts.alerts.success', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>



    <div class="content-body">
        <div class="container-fluid">
            <form class="form-horizontal" action="<?php echo e(route('Offers.store')); ?>" method="POST" >
                <?php echo csrf_field(); ?>



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

                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <h4 class="card-title"> تفاصيل العرض </h4>
                        </div>

                        <div class="card-body">
                            <div class="form-body row">

                                <div class="form-group col-md-12">
                                    <label for="">الاسم <span style="color: red">*</span></label>
                                    <input type="text" id="feedback2" class="form-control" placeholder="الاسم"
                                        name="name" value="<?php echo e(old('name')); ?>">
                                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <small class="text-danger" id="basic-default-name-error" class="error">
                                            <?php echo e($message); ?>

                                        </small>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">صالح من <span style="color: red">*</span></label>
                                    <input type="date" name="valid_from" id="" class="form-control">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">صالح الى <span style="color: red">*</span></label>
                                    <input type="date" name="valid_to" class="form-control" id="">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">النوع</label>
                                    <select class="form-control" name="type">
                                        <option value="1">اختر البند</option>
                                        <option value="2">اشتري كمية واحصل خصم على البند</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">الكمية المطلوبة لتطبيق العرض <span style="color: red">*</span></label>
                                    <input type="text" name="quantity" class="form-control" id="quantity">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">نوع الخصم </label>
                                    <select class="form-control" name="discount_type">
                                        <option value="1">خصم حقيقي</option>
                                        <option value="2">خصم نسبي</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">قيمة الخصم <span style="color: red">*</span></label>
                                    <input type="text" name="discount_value" class="form-control" id="">
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category">التصنيف</label>
                                        <input list="classifications" class="form-control" id="client_type" name="category"
                                            placeholder="اكتب التصنيف" value="<?php echo e(old('category')); ?>">
                                        <datalist id="classifications">
                                            <option value="عميل فردي">
                                            <option value="طيور لبن">
                                            <option value="أجل">
                                            <option value="طيور">
                                            <option value="السعودي والسلمي">
                                            <option value="العربية والدار البيضاء">
                                        </datalist>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">العميل </label>
                                    <select class="form-control" name="client_id">
                                        <option value=""> اختر العميل </option>
                                        <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($client->id); ?>"><?php echo e($client->trade_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="d-flex align-items-center gap-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                            checked style="width: 3rem; height: 1.5rem;">
                                        <label class="form-check-label fw-bold"
                                            style="color: #34495e; margin-right: 20px">نشط</label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <h4 class="card-title">تفاصيل وحدات العرض</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-body row">
                                <div class="form-group col-md-6">
                                    <label for="">نوع الوحدة</label>
                                    <select class="form-control" name="unit_type">
                                        <option value="1">الكل</option>
                                        <option value="2">التصنيف</option>
                                        <option value="3">المنتجات</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">المنتج</label>
                                    <select class="form-control" name="product_id">
                                        <option value="">NotThing Select</option>
                                        <?php $__currentLoopData = $product; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($prod->id); ?>"><?php echo e($prod->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">التصنيف</label>
                                    <select class="form-control" name="category_id">
                                        <option value="">NotThing Select</option>
                                        <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($cat->id); ?>"><?php echo e($cat->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // عند تغيير حقل "نوع الوحدة"
        $('select[name="unit_type"]').change(function() {
            var selectedValue = $(this).val();
            var productField = $('select[name="product_id"]').closest('.form-group');
            var categoryField = $('select[name="category_id"]').closest('.form-group');

            productField.hide();
            categoryField.hide();

            if (selectedValue === "3") {
                productField.show();
            } else if (selectedValue === "2") {
                categoryField.show();
            } else {
                productField.hide();
                categoryField.hide();
            }
        });

        // إخفاء الحقول عند التحميل الأولي
        $('select[name="product_id"], select[name="category_id"]').closest('.form-group').hide();

        // عند تغيير حقل "النوع"
        $('select[name="type"]').change(function() {
            var selectedValue = $(this).val();
            var quantityInput = $('input[name="quantity"]');

            if (selectedValue === "") {
                quantityInput.val("0").prop("readonly", true);
            } else if (selectedValue === "discount") {
                quantityInput.val("").prop("readonly", false);
            }
        });

        // تعيين الحالة الأولية عند تحميل الصفحة
        if ($('select[name="type"]').val() === "") {
            $('input[name="quantity"]').val("0").prop("readonly", true);
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/sales/sitting/offers/create.blade.php ENDPATH**/ ?>