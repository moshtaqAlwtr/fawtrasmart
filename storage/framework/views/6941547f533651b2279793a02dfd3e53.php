<?php $__env->startSection('title'); ?>
    تعديل قسيمة الراتب
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">تعديل قسيمة الراتب</h2>
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
        <form class="form" action="<?php echo e(route('salarySlip.update', $salarySlip->id)); ?>" method="POST"
            enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
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
                <h1>
                </h1>
                <div class="card-body">

                    <div class="form-body row">


                        <div class="form-group col-md-6">
                            <label for="contract_date" class="">اختر موظف </label>
                            <select name="employee_id" class="form-control" id=""
                                value="<?php echo e(old('employee_id', $salarySlip->employee->fullname)); ?>">
                                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($employee->id); ?>"><?php echo e($employee->full_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="feedback1" class=""> تاريخ التسجيل </label>
                            <input type="date" id="feedback1" class="form-control" placeholder="الاسم" name="slip_date"
                                value=" <?php echo e(old('slip_date', $salarySlip->slip_date)); ?>">
                        </div>
                    </div>

                    <div class="form-body row">
                        <div class="form-group col-md-6">
                            <label for="feedback1" class=""> تاريخ البدء </label>
                            <input type="date" id="feedback1" class="form-control" placeholder="" name="from_date"
                                value=" <?php echo e(old('from_date', $salarySlip->from_date)); ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="feedback1" class=""> تاريخ النهاية </label>
                            <input type="date" id="feedback1" class="form-control" placeholder="" name="to_date"
                                value=" <?php echo e(old('to_date', $salarySlip->to_date)); ?>">
                        </div>
                    </div>
                    <div class="form-body row">
                        <?php if (isset($component)) { $__componentOriginal8cee41e4af1fe2df52d1d5acd06eed36 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8cee41e4af1fe2df52d1d5acd06eed36 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form.select','data' => ['label' => 'عملة ','name' => 'currency','id' => 'from_currency','col' => '6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'عملة ','name' => 'currency','id' => 'from_currency','col' => '6']); ?>
                            <option value="">العملة</option>
                            <?php $__currentLoopData = \App\Helpers\CurrencyHelper::getAllCurrencies(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($code); ?>"><?php echo e($code); ?> <?php echo e($name); ?></option>
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
                    </div>
                </div>


            </div>
            <div class="card" style="max-width: 90%; margin: 0 auto; margin-top: 20px">
                <div class="card-body">



                    <div class="mt-4">
                        <h6>مستحق</h6>
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="" style="background: #e9ecef">
                                    <tr>
                                        <th style="width: 50px"></th>
                                        <th>بند الراتب</th>
                                        <th>الصيغة الحسابية</th>
                                        <th>المبلغ</th>
                                        <th style="width: 50px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="align-middle text-center">
                                            <li class="fas fa-lock text-muted"></li>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span>basic</span>
                                        </td>
                                        <td class="" style="background: #e9ecef"></td>
                                        <td>
                                            <input type="text" class="form-control" name="basic_amount"
                                                placeholder="ادخل القيمة" style="background-color: #fff3cd;">
                                        </td>
                                        <td class="align-middle">
                                            <div class="row">
                                                <i class="fas fa-key text-muted" style="margin-right: 5px;"></i>
                                                <span>رئيسي</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="newRow" style="display: none; background-color: #fff7d6;">
                                        <td class="align-middle text-center">
                                            <i class="fas fa-grip-vertical text-muted"></i>
                                        </td>
                                        <td>
                                            <div class="position-relative">
                                                <select class="form-control item-select" name="addition_type[]"
                                                    data-type="addition">
                                                    <option value="">اختر البند</option>
                                                    <?php $__currentLoopData = $additionItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($item->id); ?>"
                                                            data-calculation="<?php echo e($item->calculation_formula); ?>"
                                                            data-amount="<?php echo e($item->amount); ?>">
                                                            <?php echo e($item->name); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <option value=""> اضافة بند مستحقات جديد</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control calculation-input"
                                                placeholder="ادخل الصيغة" name="addition_calculation_formula[]">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control amount-input"
                                                placeholder="ادخل المبلغ" name="addition_amount[]">
                                        </td>
                                        <td class="align-middle text-center">
                                            <i class="fas fa-minus-circle text-danger remove-row"
                                                style="cursor: pointer;"></i>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <a class="btn btn-success add-row-button-addition">
                                <i class="fas fa-plus"></i> إضافة
                            </a>

                        </div>
                    </div>

                    <!-- مستقطع -->
                    <div class="mt-4">
                        <h6>مستقطع</h6>
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="" style="background: #e9ecef">
                                    <tr>
                                        <th style="width: 50px"></th>
                                        <th>بند الراتب</th>
                                        <th>الصيغة الحسابية</th>
                                        <th>المبلغ</th>
                                        <th style="width: 50px"></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr id="newRow2" style="display: none; background-color: #fff7d6;">
                                        <td class="align-middle text-center">
                                            <i class="fas fa-grip-vertical text-muted"></i>
                                        </td>
                                        <td>
                                            <div class="position-relative">
                                                <select class="form-control item-select" name="deduction_type[]"
                                                    data-type="deduction">
                                                    <option value="">اختر البند</option>
                                                    <?php $__currentLoopData = $deductionItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($item->id); ?>"
                                                            data-calculation="<?php echo e($item->calculation_formula); ?>"
                                                            data-amount="<?php echo e($item->amount); ?>">
                                                            <?php echo e($item->name); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control calculation-input"
                                                placeholder="ادخل الصيغة" name="deduction_calculation_formula[]">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control amount-input"
                                                placeholder="ادخل المبلغ" name="deduction_amount[]">
                                        </td>
                                        <td class="align-middle text-center">
                                            <i class="fas fa-minus-circle text-danger remove-row"
                                                style="cursor: pointer;"></i>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <a class="btn btn-success add-row-button-deduction">
                                <i class="fas fa-plus"></i> إضافة
                            </a>
                        </div>
                    </div>


                </div>

            </div>

    </div>

    <div class="card" style="max-width: 90%; margin: 0 auto; margin-top: 20px">
        <div class="card-body">


            <!-- الإجماليات -->
            <div class="row mt-4">
                <div class="form-group col-md-6">
                    <label class="  ">اجمالي الراتب</label>
                    <input type="text" class="form-control text-end" name="total_salary" readonly value="">
                </div>
                <div class="form-group col-md-6">
                    <h6 class="mb-0">اجمالي الخصم</h6>
                    <input type="text" class="form-control text-end" name="total_deductions" readonly value="">
                </div>

            </div>

            <!-- صافي الراتب -->
            <div class="row mt-3">

                <div class="form-group col-12">
                    <label class="mb-0">صافي الراتب</label>
                    <input type="text" class="form-control text-end" name="net_salary" readonly value="">
                    <div class="text-end mt-1">
                        <small class="text-muted">اجمالي الراتب - اجمالي الخصم</small>
                    </div>
                </div>
            </div>


            <!-- الملاحظات -->
            <div class="mt-4">
                <h6 class="mb-2">الملاحظات</h6>
                <textarea class="form-control" name="note" rows="4" placeholder="اكتب ملاحظاتك هنا..."></textarea>
            </div>
            <div class="mt-4">
                <div class="form-group">
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

        </div>
    </div> <!-- مستقطع -->


    </form>
    </div>

    </div>

    </div>

    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        $(document).ready(function() {
            // إضافة صف جديد للمستحقات
            $('.add-row-button-addition').on('click', function() {
                var newRow = $('#newRow').clone();
                newRow.removeAttr('id').show();
                $(this).closest('.table-responsive').find('table tbody').append(newRow);
                initializeSelect2();
            });

            // إضافة صف جديد للمستقطعات
            $('.add-row-button-deduction').on('click', function() {
                var newRow = $('#newRow2').clone();
                newRow.removeAttr('id').show();
                $(this).closest('.table-responsive').find('table tbody').append(newRow);
                initializeSelect2();
            });

            // حذف الصف
            $(document).on('click', '.remove-row', function() {
                $(this).closest('tr').remove();
                calculateTotals();
            });

            // تحديث الصيغة والمبلغ عند اختيار البند
            $(document).on('change', '.item-select', function() {
                var row = $(this).closest('tr');
                var selectedOption = $(this).find('option:selected');

                if (selectedOption.val() !== '') {
                    row.find('.calculation-input').val(selectedOption.data('calculation'));
                    row.find('.amount-input').val(selectedOption.data('amount'));
                    calculateTotals();
                }
            });

            // تحديث المجاميع عند تغيير أي مبلغ
            $(document).on('input', 'input[name="basic_amount"], .amount-input', function() {
                calculateTotals();
            });

            // دالة حساب المجاميع
            function calculateTotals() {
                var totalAdditions = 0;
                var totalDeductions = 0;

                // إضافة الراتب الأساسي
                var basicSalary = parseFloat($('input[name="basic_amount"]').val()) || 0;
                totalAdditions += basicSalary;

                // حساب مجموع المستحقات
                $('select[name="addition_type[]"]').each(function() {
                    var amount = parseFloat($(this).closest('tr').find('.amount-input').val()) || 0;
                    totalAdditions += amount;
                });

                // حساب مجموع المستقطعات
                $('select[name="deduction_type[]"]').each(function() {
                    var amount = parseFloat($(this).closest('tr').find('.amount-input').val()) || 0;
                    totalDeductions += amount;
                });

                // تحديث الحقول
                updateTotalFields(totalAdditions, totalDeductions);
            }

            // دالة تحديث حقول المجاميع
            function updateTotalFields(totalAdditions, totalDeductions) {
                totalAdditions = parseFloat(totalAdditions).toFixed(2);
                totalDeductions = parseFloat(totalDeductions).toFixed(2);
                var netSalary = (parseFloat(totalAdditions) - parseFloat(totalDeductions)).toFixed(2);

                // تحديث الحقول مع تنسيق الأرقام
                $('input[name="total_salary"]').val(formatNumber(totalAdditions));
                $('input[name="total_deductions"]').val(formatNumber(totalDeductions));
                $('input[name="net_salary"]').val(formatNumber(netSalary));
            }

            // دالة تنسيق الأرقام بالإنجليزي
            function formatNumber(number) {
                return new Intl.NumberFormat('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }).format(number);
            }

            // التحقق من المدخلات الرقمية
            $(document).on('input', '.amount-input', function() {
                var value = $(this).val();
                // السماح فقط بالأرقام والنقطة العشرية
                if (!/^\d*\.?\d*$/.test(value)) {
                    $(this).val(value.replace(/[^\d.]/g, ''));
                }
                // منع تكرار النقطة العشرية
                if ((value.match(/\./g) || []).length > 1) {
                    $(this).val(value.replace(/\.+$/, ''));
                }
            });

            // تهيئة Select2
            function initializeSelect2() {
                if ($.fn.select2) {
                    $('.item-select').select2({
                        placeholder: "اختر البند",
                        allowClear: true,
                        width: '100%'
                    });
                }
            }

            // معالجة النموذج عند الإرسال
            $('form').on('submit', function(e) {
                var employeeId = $('select[name="employee_id"]').val();
                if (!employeeId) {
                    e.preventDefault();
                    alert('الرجاء اختيار الموظف');
                    return false;
                }
                return true;
            });

            // تهيئة Select2 عند تحميل الصفحة
            initializeSelect2();

            // تأخير حساب المجاميع حتى اكتمال تحميل الصفحة
            setTimeout(calculateTotals, 500);
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/salaries/salary_slip/edit.blade.php ENDPATH**/ ?>