<?php $__env->startSection('title'); ?>
    اضافة سلفة راتب
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">اضافة سلفة راتب</h2>
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
        <form class="form" action="<?php echo e(route('ancestor.store')); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="alert alert-danger">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

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


            <div class="card" style="max-width: 90%; margin: 0 auto;">

                <div class="card-body">
                    <h1 class="card-title">تفاصيل السلفة</h1>

                    <div class="form-body">
                        <div class="row">
                            <!-- موظف -->
                            <div class="col-md-6 mb-3">
                                <label for="employee">موظف<span class="text-danger">*</span></label>
                                <select class="form-control" id="employee" name="employee_id">
                                    <option value="">إختر موظف...</option>
                                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($employee->id); ?>"><?php echo e($employee->full_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <!-- تاريخ التقديم -->
                            <div class="col-md-6 mb-3">
                                <label for="submission_date">تاريخ التقديم<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="submission_date" name="submission_date"
                                    placeholder="DD/MM/YYYY">
                            </div>

                            <!-- المبلغ -->
                            <div class="col-md-6 mb-3">
                                <label for="amount">المبلغ<span class="text-danger">*</span></label>
                                <div class="input-group border rounded" style="height: 50px;">
                                    <input type="number" class="form-control border-0 text-center" value="0.00"
                                        id="amount" name="amount" style="height: 100%; font-size: 1rem;">

                                    <select name="currency" id="" class="form-select border-0 h-100 text-center"
                                        style="font-size: 1rem;">
                                        <option value="1">SAR</option>
                                        <option value="2">USD</option>
                                        <option value="3">EUR</option>
                                        <option value="4">GBP</option>
                                        <option value="5">CNY</option>
                                    </select>
                                </div>
                            </div>

                            <!-- القسط -->
                            <div class="col-md-6 mb-3">
                                <label for="installment_amount">القسط<span class="text-danger">*</span></label>
                                <div class="input-group border rounded" style="height: 50px;">
                                    <input type="number"
                                        class="form-control border-0 text-center <?php $__errorArgs = ['installment_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="installment_amount" name="installment_amount"
                                        value="<?php echo e(old('installment_amount', '0.00')); ?>" step="0.01"
                                        style="height: 100%; font-size: 1rem;">

                                    <div class="input-group-prepend" style="min-width: 120px;">
                                        <div class="input-group-text border-0 w-100 bg-white h-100">
                                            <div class="text-center w-100">
                                                <label for="installment_count" class="form-label"> عدد الاقساط</label>
                                                <input type="number" class="form-control border-0 text-center"
                                                    value="0" readonly id="installment_count"
                                                    style="background: transparent; font-size: 1rem;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php $__errorArgs = ['installment_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger"><?php echo e($message); ?></small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <small class="text-danger" id="installment-error" style="display: none;">
                                    قيمة القسط يجب أن تكون أقل من أو تساوي قيمة السلفة
                                </small>
                            </div>


                            <!-- معدل السداد -->
                            <div class="col-md-6 mb-3">
                                <label for="payment_rate">معدل السداد<span class="text-danger">*</span></label>

                                <select name="payment_rate" id="payment_rate" class="form-control" required>
                                    <option value="">اختر معدل الدفع</option>
                                    <option value="monthly" <?php echo e(old('payment_rate') == 'monthly' ? 'selected' : ''); ?>>شهري
                                    </option>
                                    <option value="weekly" <?php echo e(old('payment_rate') == 'weekly' ? 'selected' : ''); ?>>أسبوعي
                                    </option>
                                    <option value="daily" <?php echo e(old('payment_rate') == 'daily' ? 'selected' : ''); ?>>يومي
                                    </option>
                                </select>
                            </div>

                            <!-- تاريخ بدء الأقساط -->
                            <div class="col-md-6 mb-3">
                                <label for="installment_start_date">تاريخ بدء الأقساط<span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="installment_start_date"
                                    name="installment_start_date" placeholder="DD/MM/YYYY">
                            </div>

                            <!-- الخزنة -->
                            <div class="col-md-6 mb-3">
                                <label for="treasury">الخزنة<span class="text-danger">*</span></label>
                                <select class="form-control" id="treasury" name="treasury_id">
                                    <option value="">إختر خزنة...</option>
                                    <?php $__currentLoopData = $treasuries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $treasure): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($treasure->id); ?>"><?php echo e($treasure->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <!-- الدفع من قسيمة الراتب -->

                            <div class="col-md-6">
                                <div class="input-group form-group">
                                    <div class="input-group-text w-100 text-left">
                                        <div
                                            class="custom-control custom-checkbox d-flex justify-content-start align-items-center w-100">
                                            <input id="duration_check" class="custom-control-input" type="checkbox"
                                                name="pay_from_salary">
                                            <label for="duration_check" class="custom-control-label ml-2">
                                                التحقق من الحضور <span class="required">*</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- رسوم -->
                            <div class="col-md-6 mb-3">
                                <label for="fees">وسوم</label>
                                <input type="text" class="form-control" id="fees" name="tag" placeholder=""
                                    placeholder="الوسوم">
                            </div>

                            <!-- ملاحظة -->
                            <div class="col-md-6 mb-3">
                                <label for="note">ملاحظة</label>
                                <textarea class="form-control" id="note" name="note" rows="3"></textarea>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const amountInput = document.querySelector('input[name="amount"]');
            const installmentInput = document.querySelector('input[name="installment_amount"]');
            const errorDiv = document.getElementById('installment-error');

            function checkAmount() {
                const amount = parseFloat(amountInput.value) || 0;
                const installment = parseFloat(installmentInput.value) || 0;

                if (installment > amount) {
                    errorDiv.style.display = 'block';
                    installmentInput.classList.add('is-invalid');
                } else {
                    errorDiv.style.display = 'none';
                    installmentInput.classList.remove('is-invalid');
                }
            }

            installmentInput.addEventListener('input', checkAmount);
            amountInput.addEventListener('input', checkAmount);
        });
    </script>

    <script>
        // ضبط الحقول عند تحميل الصفحة
        document.addEventListener('DOMContentLoaded', function() {
            // استدعاء الدالة لضبط الحقول الافتراضية
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const amountInput = document.getElementById('amount');
            const installmentInput = document.getElementById('installment_amount');
            const installmentCountInput = document.getElementById('installment_count');
            const installmentError = document.getElementById('installment-error');

            function calculateInstallments() {
                const amount = parseFloat(amountInput.value) || 0;
                const installment = parseFloat(installmentInput.value) || 0;

                if (installment > 0) {
                    const total = Math.floor(amount / installment);
                    installmentCountInput.value = total;

                    // التحقق من صحة قيمة القسط
                    if (installment > amount) {
                        installmentError.style.display = 'block';
                    } else {
                        installmentError.style.display = 'none';
                    }
                } else {
                    installmentCountInput.value = 0;
                }
            }

            // تفعيل الحساب عند تغيير أي من القيم
            amountInput.addEventListener('input', calculateInstallments);
            installmentInput.addEventListener('input', calculateInstallments);

            // حساب القيمة الأولية
            calculateInstallments();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/salaries/ancestor/create.blade.php ENDPATH**/ ?>