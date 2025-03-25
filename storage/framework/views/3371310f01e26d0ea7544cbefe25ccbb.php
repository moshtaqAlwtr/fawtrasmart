<?php $__env->startSection('title'); ?>
    اضافة امر تشغيل
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">اضافة امر تشغيل</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo e(route('SupplyOrders.index')); ?>">أوامر التشغيل</a></li>
                            <li class="breadcrumb-item active">عرض </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->make('layouts.alerts.success', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('layouts.alerts.error', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="content-body">
        <div class="container-fluid">
            <form class="form-horizontal" action="<?php echo e(route('SupplyOrders.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                            </div>

                            <div>
                                <a href="<?php echo e(route('SupplyOrders.index')); ?>" class="btn btn-outline-danger">
                                    <i class="fa fa-ban"></i> الغاء
                                </a>
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fa fa-save"></i> حفظ
                                </button>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <h4 class="card-title">معلومات اوامر التوريد</h4>
                        </div>

                        <div class="card-body">
                            <div class="form-body row">
                                
                                <div class="form-group col-md-3">
                                    <label for="supply_order_name">مسمى</label>
                                    <input type="text" id="supply_order_name" name="name"
                                           class="form-control" placeholder="مسمى"
                                           value="<?php echo e(old('supply_order_name')); ?>">
                                    <?php $__errorArgs = ['supply_order_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="supply_order_number">رقم امر</label>
                                    <input type="text" id="supply_order_number" name="supply_order_number"
                                           class="form-control" placeholder="رقم امر"
                                           value="<?php echo e(old('supply_order_number', $supply_order_number)); ?>"
                                           readonly>
                                    <?php $__errorArgs = ['supply_order_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="start_date">تاريخ البدء</label>
                                    <input type="date" id="start_date" name="start_date"
                                           class="form-control"
                                           value="<?php echo e(old('start_date', now()->format('Y-m-d'))); ?>"
                                           onchange="updateEndDate()">
                                    <?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="end_date">تاريخ النهاية</label>
                                    <input type="date" id="end_date" name="end_date"
                                           class="form-control"
                                           value="<?php echo e(old('end_date', now()->addMonth()->format('Y-m-d'))); ?>">
                                    <?php $__errorArgs = ['end_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="description">الوصف</label>
                                <textarea id="description" name="description"
                                          class="form-control" rows="5"
                                          placeholder="الوصف"><?php echo e(old('description')); ?></textarea>
                                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="form-body row">
                                
                                <div class="col-md-3">
                                    <label for="client_id">العميل</label>
                                    <select id="client_id" name="client_id" class="form-control">
                                        <option value="">اختر عميل</option>
                                        <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($client->id); ?>"
                                                <?php echo e(old('client_id') == $client->id ? 'selected' : ''); ?>>
                                                <?php echo e($client->trade_name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['client_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="col-md-2">
                                    <label>&nbsp;</label>
                                    <a href="<?php echo e(route('clients.create')); ?>" class="btn btn-success form-control">جديد</a>
                                </div>

                                
                                <div class="form-group col-md-3">
                                    <label for="tag">الوسم</label>
                                    <select id="tag" name="tag" class="form-control">
                                        <option value="">اختر وسم</option>
                                        <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($tag); ?>"
                                                <?php echo e(old('tag') == $tag ? 'selected' : ''); ?>>
                                                <?php echo e($tag); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['tag'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                
                                <div class="form-group col-md-2">
                                    <label for="budget">الميزانية</label>
                                    <input type="number" step="0.01" id="budget" name="budget"
                                           class="form-control" placeholder="الميزانية"
                                           value="<?php echo e(old('budget')); ?>">
                                    <?php $__errorArgs = ['budget'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                
                                <div class="form-group col-md-2">
                                    <label for="currency">العملة</label>
                                    <select id="currency" name="currency" class="form-control">
                                        <option value="1" <?php echo e(old('currency', '1') == '1' ? 'selected' : ''); ?>>SAR</option>
                                        <option value="2" <?php echo e(old('currency') == '2' ? 'selected' : ''); ?>>USD</option>
                                        <option value="3" <?php echo e(old('currency') == '3' ? 'selected' : ''); ?>>EUR</option>
                                        <option value="4" <?php echo e(old('currency') == '4' ? 'selected' : ''); ?>>GBP</option>
                                        <option value="5" <?php echo e(old('currency') == '5' ? 'selected' : ''); ?>>CNY</option>
                                    </select>
                                    <?php $__errorArgs = ['currency'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            
                            <div class="form-body row">
                                <div class="col-md-3 d-flex gap-2 align-items-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="show-employee-input"
                                               style="width: 1.5em; height: 1.5em;" name="show_employee">
                                        <label class="form-check-label" for="show-employee-input"
                                               style="font-size: 1.2rem; margin-right: 10px;">
                                            تعيين الموظفين
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3" id="employee-input-container" style="display: none;">
                                    <label for="employee_id">اختر موظف</label>
                                    <select id="employee_id" name="employee_id" class="form-control">
                                        <option value="">اختر موظف</option>
                                        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($employee->id); ?>"
                                                <?php echo e(old('employee_id') == $employee->id ? 'selected' : ''); ?>>
                                                <?php echo e($employee->full_name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['employee_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="product_details" class="form-label text-end d-block">بيانات المنتجات</label>
                                <textarea id="product_details" name="product_details"
                                          class="form-control" rows="4"><?php echo e(old('product_details')); ?></textarea>
                                <?php $__errorArgs = ['product_details'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="shipping_address" class="form-label text-end d-block">عنوان الشحن</label>
                                <textarea id="shipping_address" name="shipping_address"
                                          class="form-control" rows="4"><?php echo e(old('shipping_address')); ?></textarea>
                                <?php $__errorArgs = ['shipping_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="tracking_number" class="form-label text-end d-block">رقم التتبع</label>
                                <input type="text" id="tracking_number" name="tracking_number"
                                       class="form-control" value="<?php echo e(old('tracking_number')); ?>">
                                <?php $__errorArgs = ['tracking_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-12">
                                <label for="shipping_policy_file" class="form-label text-end d-block">بوليصة الشحن</label>
                                <input type="file" id="shipping_policy_file" name="shipping_policy_file"
                                       class="form-control">
                                <?php $__errorArgs = ['shipping_policy_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php echo $__env->make('supplyOrders.custom_fields_modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/supply_orders.js')); ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const employeeCheckbox = document.getElementById('show-employee-input');
            const employeeInputContainer = document.getElementById('employee-input-container');

            employeeCheckbox.addEventListener('change', function() {
                employeeInputContainer.style.display = this.checked ? 'block' : 'none';
                if (!this.checked) {
                    document.getElementById('employee_id').value = '';
                }
            });
        });
        <?php echo \Illuminate\View\Factory::parentPlaceholder('scripts'); ?>

        function updateEndDate() {
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');

            if (startDateInput.value) {
                const startDate = new Date(startDateInput.value);
                const endDate = new Date(startDate);
                endDate.setMonth(endDate.getMonth() + 1);

                // Format the end date to YYYY-MM-DD
                const year = endDate.getFullYear();
                const month = String(endDate.getMonth() + 1).padStart(2, '0');
                const day = String(endDate.getDate()).padStart(2, '0');

                endDateInput.value = `${year}-${month}-${day}`;
            }
        }

        // Run on page load to set initial end date
        document.addEventListener('DOMContentLoaded', updateEndDate);

    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/supplyOrders/create.blade.php ENDPATH**/ ?>