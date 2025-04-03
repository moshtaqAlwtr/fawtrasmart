

<?php $__env->startSection('title'); ?>
    المخزون
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">ادارة الخدمات</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a>
                            </li>
                            <li class="breadcrumb-item active">اضافه خدمة
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
                        <a href="<?php echo e(route('products.index')); ?>" class="btn btn-outline-danger">
                            <i class="fa fa-ban"></i>الغاء
                        </a>
                        <button type="submit" form="products_form" class="btn btn-outline-primary">
                            <i class="fa fa-save"></i>حفظ
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <?php echo $__env->make('layouts.alerts.success', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('layouts.alerts.error', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">تفاصيل الخدمة</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form id="products_form" class="form form-vertical" action="<?php echo e(route('products.store')); ?>" method="POST" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="form-group">
                                                <label for="first-name-vertical">الاسم <span style="color: red">*</span></label>
                                                <input type="text" id="first-name-vertical" class="form-control" name="name" value="<?php echo e(old('name')); ?>">
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
                                        <input type="hidden" name="type" value="services">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="email-id-vertical">الرقم التسلسلي</label>
                                                <input type="text" id="email-id-vertical" class="form-control"name="serial_number" value="<?php echo e($serial_number); ?>">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="email-id-vertical">الوصف</label>
                                                <textarea name="description" class="form-control" id="basicTextarea" rows="3"><?php echo e(old('description')); ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="password-vertical">الصور</label>
                                                <input type="file" name="images" class="form-control"name="contact">
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="first-name-vertical">التصنيف</label>
                                                        <select id="category-input" class="form-control" name="category_id">
                                                            <option value="">-- اختر التصنيف --</option>
                                                        </select>
                                                        <?php $__errorArgs = ['category_id'];
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
                                                        <label for="email-id-vertical">الماركة</label>
                                                        <input type="text" id="email-id-vertical" class="form-control" name="brand" value="<?php echo e(old('brand')); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="first-name-vertical">Sales Account</label>
                                                        <input type="text" id="first-name-vertical" class="form-control" name="sales_account" value="<?php echo e(old('sales_account')); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="email-id-vertical">Sales Cost Account</label>
                                                        <input type="text" id="email-id-vertical" class="form-control" name="sales_account" value="<?php echo e(old('sales_cost_account')); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="first-name-vertical">المورد</label>
                                                        <input type="number" id="first-name-vertical" class="form-control"name="supplier_id" value="<?php echo e(old('supplier_id')); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="email-id-vertical">باركود</label>
                                                        <input type="text" id="email-id-vertical" class="form-control" name="barcode" value="<?php echo e(old('barcode')); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12">
                                            <fieldset class="checkbox">
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="available_online" id="available_online" onchange="remove_disabled_ckeckbox()">
                                                    <span class="vs-checkbox">
                                                        <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                        </span>
                                                    </span>
                                                    <span class="">متاح اون لاين</span>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="form-group col-12">
                                            <fieldset class="checkbox">
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="featured_product" id="featured_product">
                                                    <span class="vs-checkbox">
                                                        <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                        </span>
                                                    </span>
                                                    <span class="">منتج مميز</span>
                                                </div>
                                            </fieldset>
                                        </div>

                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">تفاصيل التسعير</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="first-name-vertical">سعر الشراء</label>
                                                        <input type="text" id="first-name-vertical" class="form-control" name="purchase_price" value="<?php echo e(old('purchase_price')); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="email-id-vertical">سعر البيع</label>
                                                        <input type="text" id="email-id-vertical" class="form-control" name="sale_price" value="<?php echo e(old('sale_price')); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="first-name-vertical">الضريبه الاولى</label>
                                                        <select class="form-control" id="basicSelect" name="tax1">
                                                            <option value="">اختر ضريبة</option>
                                                            <option value="1">القيمة المضافة</option>
                                                            <option value="2">صفرية</option>
                                                            <option value="3">قيمة مضافة</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="email-id-vertical">الضريبه الثانية</label>
                                                        <select class="form-control" id="basicSelect" name="tax2">
                                                            <option value="">اختر ضريبة</option>
                                                            <option value="1">القيمة المضافة</option>
                                                            <option value="2">صفرية</option>
                                                            <option value="3">قيمة مضافة</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="first-name-vertical">اقل سعر بيع</label>
                                                        <input type="text" id="first-name-vertical" class="form-control" name="min_sale_price" value="<?php echo e(old('min_sale_price')); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label>الخصم</label>
                                                        <input type="text" id="email-id-vertical" class="form-control" name="discount" value="<?php echo e(old('discount')); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        <label for="email-id-vertical">نوع الخصم</label>
                                                        <select class="form-control" id="basicSelect" name="discount_type">
                                                            <option value="1">%</option>
                                                            <option value="2">$</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="first-name-vertical">هامش الربح نسبه مئوية</label>
                                                        <input type="text" id="first-name-vertical" class="form-control" name="profit_margin" value="<?php echo e(old('profit_margin')); ?>">
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

        </div>

      


        <div class="card">
            <div class="card-header">
                <h4 class="card-title">خيارات اكثر</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                        <div class="form-body">

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="email-id-vertical">ملاخظات داخلية</label>
                                        <textarea class="form-control" id="basicTextarea" name="Internal_notes" rows="3"><?php echo e(old('Internal_notes')); ?></textarea>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label>وسوم</label>
                                        <input type="text" id="email-id-vertical" class="form-control" name="tags" value="<?php echo e(old('tags')); ?>">
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="first-name-vertical">الحالة</label>
                                        <select class="form-control" id="basicSelect" name="status">
                                            <option value="0" <?php echo e(old('status') == 0 ? 'selected' : ''); ?>>نشط</option>
                                            <option value="1" <?php echo e(old('status') == 1 ? 'selected' : ''); ?>>موقوف</option>
                                            <option value="2" <?php echo e(old('status') == 2 ? 'selected' : ''); ?>>غير نشط</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<script>
    function remove_disabled() {
        if (document.getElementById("ProductTrackStock").checked) {
            disableForm(false);
        }
        if (!document.getElementById("ProductTrackStock").checked) {
            disableForm(true);
        }
    }

    function disableForm(flag) {
        var elements = document.getElementsByClassName("ProductTrackingInput");
        for (var i = 0, len = elements.length; i < len; ++i) {
            elements[i].readOnly = flag;
            elements[i].disabled = flag;
        }
    }
</script>
<!----------------------------------------------->
<script>
    function remove_disabled_ckeckbox() {
        if(document.getElementById("available_online").checked)
            document.getElementById("featured_product").disabled = false;
        else
        document.getElementById("featured_product").disabled = true;
    }
</script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // تهيئة Select2 مع البحث عبر Ajax
        $('#category-input').select2({
            placeholder: "اختر التصنيف",
            allowClear: true, // يتيح مسح الاختيار
            minimumInputLength: 1, // يسمح بالبحث عند الكتابة
            ajax: {
                url: '/stock/products/getcategories', // المسار الذي يعيد التصنيفات من الخادم
                dataType: 'json',
                delay: 250, // تأخير البحث قليلاً لتحسين الأداء
                data: function(params) {
                    return {
                        search: params.term, // إرسال نص البحث
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.results, // النتائج المرسلة من الخادم
                    };
                },
                cache: true // تخزين النتائج في الكاش لتحسين الأداء
            }
        });
    });
    
    
    
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/stock/products/create_services.blade.php ENDPATH**/ ?>