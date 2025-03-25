<?php $__env->startSection('title'); ?>
    سند صرف
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">سند صرف</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a>
                            </li>
                            <li class="breadcrumb-item active">اضافه
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

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                    </div>

                    <div>
                        <a href="<?php echo e(route('expenses.index')); ?>" class="btn btn-outline-danger">
                            <i class="fa fa-ban"></i>الغاء
                        </a>

                        <button type="submit" form="expenses_form" class="btn btn-outline-primary">
                            <i class="fa fa-save"></i>حفظ
                        </button>
                    </div>


                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form id="expenses_form" action="<?php echo e(route('expenses.store')); ?>" method="POST"
                    enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="amount">المبلغ <span style="color: red">*</span></label>
                            <input type="text" class="form-control form-control-lg py-3" id="amount"
                                placeholder="ر.س 0.00" name="">
                            <?php $__errorArgs = ['amount'];
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
<div class="form-group col-md-3">
    <label for="total_amount">المبلغ الإجمالي بعد الضريبة</label>
    <input type="text" class="form-control form-control-lg py-3" id="total_amount"
        placeholder="ر.س 0.00" name="amount" readonly>
</div>

                        <div class="form-group col-md-3">
                            <label for="description">الوصف</label>
                            <textarea class="form-control" id="description" rows="3" name="description"></textarea>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="attachments">المرفقات</label>
                            <input type="file" name="attachments" id="attachments" class="d-none">
                            <div class="upload-area border rounded p-3 text-center position-relative"
                                onclick="document.getElementById('attachments').click()">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <i class="fas fa-cloud-upload-alt text-primary"></i>
                                    <span class="text-primary">اضغط هنا</span>
                                    <span>أو</span>
                                    <span class="text-primary">اختر من جهازك</span>
                                </div>
                                <div class="position-absolute end-0 top-50 translate-middle-y me-3">
                                    <i class="fas fa-file-alt fs-3 text-secondary"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="code-number">رقم الكود</label>
                            <input type="text" class="form-control" id="code-number" name="code"
                                value="<?php echo e($code); ?>" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="date">التاريخ</label>
                            <input type="date" class="form-control" id="date" name="date"
                                value="<?php echo e(date('Y-m-d')); ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="unit">الوحدة</label>
                            <select id="unit" class="form-control" name="unit_id">
                                <option selected disabled>حدد الوحدة</option>
                                <option value="1">وحدة 1</option>
                                <option value="2">وحدة 2</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="category">التصنيف</label>
                            <select id="category" class="form-control" name="expenses_category_id">
                                <option selected value="">-- اضافه تصنيف --</option>
                                <?php $__currentLoopData = $expenses_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expenses_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($expenses_category->id); ?>"
                                        <?php echo e(old('expenses_category_id') == $expenses_category->id ? 'selected' : ''); ?>>
                                        <?php echo e($expenses_category->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="seller">البائع</label>
                            <input type="text" class="form-control" id="seller" name="seller">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="warehouse">خزينة</label>
                              <input type="text"   class="form-control" placeholder="رقم المعرف"
                            value="<?php echo e($MainTreasury->name ?? ""); ?>" readonly>
                        </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="min-limit"> الحساب </label>
                            <select id="" class="form-control select2" name="account_id">
                                <option>اختر الحساب</option>

                                <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($account->id); ?>"><?php echo e($account->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="items">المورد</label>
                            <select id="items" class="form-control" name="supplier_id">
                                <option selected disabled>اختر مورد</option>
                                <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($supplier->id); ?>"><?php echo e($supplier->trade_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="tax">الضرائب</label>
                            <button type="button" class="btn btn-info btn-block" onclick="toggleTaxFields()">إضافة
                                ضرائب</button>
                        </div>
                    </div>

                    <!-- حقول الضرائب -->
                    <div id="tax-fields" class="tax-fields">
                        <span class="remove-tax" onclick="removeTaxFields()">إزالة الضرائب ×</span>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="tax1">الضريبة الأولى</label>
                                <select id="tax1" class="form-control" name="tax1">
                                    <option>اختر الضريبة</option>
                                    <?php $__currentLoopData = $taxs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    
                                    <option value="<?php echo e($tax->tax); ?>"><?php echo e($tax->name ?? ""); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <input type="text" class="form-control mt-2" placeholder="المبلغ" name="tax1_amount">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="tax2">الضريبة الثانية</label>
                                <select id="tax2" class="form-control" name="tax2">
                                 <option>اختر الضريبة</option>
                                    <?php $__currentLoopData = $taxs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    
                                    <option value="<?php echo e($tax->tax); ?>"><?php echo e($tax->name ?? ""); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <input type="text" class="form-control mt-2" placeholder="المبلغ" name="tax2_amount">
                            </div>
                        </div>
                    </div>

                    <div class="container mt-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-2">
                                        <label for="checkbox">مكرر</label>
                                        <input type="checkbox" id="checkbox" name="is_recurring">
                                    </div>
                                </div>
                                <!-- حقل التكرار و تاريخ الإنتهاء يظهر عند تحديد الـ checkbox -->
                                <div class="row" id="duplicate-options-container" style="display: none;">
                                    <div class="form-group col-md-4">
                                        <label for="duplicate-options">التكرار</label>
                                        <select id="duplicate-options" class="form-control">
                                            <option selected>حدد التكرار</option>
                                            <option value="weekly">إسبوعي</option>
                                            <option value="bi-weekly">كل أسبوعين</option>
                                            <option value="monthly">شهري</option>
                                            <option value="yearly">سنوي</option>
                                            <option value="daily">يومي</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- حقل تاريخ الإنتهاء -->
                                <div class="row" id="end-date-container" style="display: none;">
                                    <div class="form-group col-md-4">
                                        <label for="end-date">تاريخ الإنتهاء</label>
                                        <input type="date" class="form-control" id="end-date"
                                            value="<?php echo e(date('Y-m-d')); ?>" name="end_date">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>
    <!-- JavaScript للتحكم في إظهار وإخفاء الخيارات -->
    <script>
        document.getElementById('checkbox').addEventListener('change', function() {
            var duplicateOptionsContainer = document.getElementById('duplicate-options-container');
            var endDateContainer = document.getElementById('end-date-container');
            if (this.checked) {
                duplicateOptionsContainer.style.display = 'block'; // إظهار خيارات التكرار
                endDateContainer.style.display = 'block'; // إظهار حقل تاريخ الإنتهاء
            } else {
                duplicateOptionsContainer.style.display = 'none'; // إخفاء خيارات التكرار
                endDateContainer.style.display = 'none'; // إخفاء حقل تاريخ الإنتهاء
            }
        });
    </script>
    <script>
        function toggleTaxFields() {
            $("#tax-fields").slideToggle();
        }

        function removeTaxFields() {
            $("#tax-fields").slideUp();
        }
    </script>
    <!-- إضافة مكتبة jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



<script>
    $(document).ready(function () {
        function calculateTax() {
            let amount = parseFloat($("#amount").val()) || 0; // المبلغ الأساسي
            let tax1Rate = parseFloat($("#tax1").val()) || 0; // نسبة الضريبة الأولى
            let tax2Rate = parseFloat($("#tax2").val()) || 0; // نسبة الضريبة الثانية

            // حساب قيمة الضرائب
            let tax1Amount = (amount * tax1Rate) / 100;
            let tax2Amount = (amount * tax2Rate) / 100;

            // تحديث الحقول بقيم الضرائب
            $("input[name='tax1_amount']").val(tax1Amount.toFixed(2));
            $("input[name='tax2_amount']").val(tax2Amount.toFixed(2));

            // حساب المجموع النهائي مع الضرائب
            let totalAmount = amount + tax1Amount + tax2Amount;
            $("#total_amount").val(totalAmount.toFixed(2));
        }

        // عند إدخال المبلغ أو تغيير الضريبة يتم تحديث الحساب
        $("#amount, #tax1, #tax2").on("input change", calculateTax);
    });
</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/finance/expenses/create.blade.php ENDPATH**/ ?>