<?php $__env->startSection('title'); ?>
   ضبط التطبيقات
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<style>
    /* تحسين تصميم الكروت */
    .card {
        border: none !important;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }
    
    /* جعل الكروت بنفس الارتفاع */
    .card-body {
        min-height: 250px; /* يمكنك ضبط القيمة حسب الحاجة */
    }

    /* تحسين تصميم السويتش */
    .form-check-input {
        width: 50px !important; /* زيادة عرض السويتش */
        height: 25px !important; /* زيادة ارتفاع السويتش */
    }

    /* تحسين التباعد */
    .switch-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
    }

</style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <?php echo $__env->make('layouts.alerts.error', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('layouts.alerts.success', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <form id="clientForm" action="<?php echo e(route('Application.update')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="card p-3 mb-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                </div>
                <div>
                    <a href="" class="btn btn-outline-danger">
                        <i class="fa fa-ban"></i> إلغاء
                    </a>
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fa fa-save"></i> حفظ
                    </button>
                </div>
            </div>
        </div>

        <!-- الصف الأول -->
        <div class="row">
            <div class="col-md-6">                      


                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">إدارة المبيعات</div>
                    <div class="card-body text-dark">
                        <?php
                            $sales_options = [
                                'sales' => 'المبيعات',
                                'pos' => 'نقاط البيع',
                                'target_sales_commissions' => 'المبيعات المستهدفة و العمولات',
                                'installments_management' => 'إدارة الأقساط',
                                'offers' => 'العروض',
                                'insurance' => 'التأمينات',
                                'customer_loyalty_points' => 'نقاط ولاء العملاء'
                            ];
                        ?>

                        <?php $__currentLoopData = $sales_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="switch-container">
                                <label class="form-check-label" for="<?php echo e($key); ?>"><?php echo e($label); ?></label>
                                <div class="form-check form-switch">
                                    <input type="hidden" name="<?php echo e($key); ?>" value="inactive">
                                    <input class="form-check-input" type="checkbox" id="<?php echo e($key); ?>" name="<?php echo e($key); ?>"
                                        value="active" <?php echo e(old($key, $settings[$key] ?? 'inactive') === 'active' ? 'checked' : ''); ?>>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="card-footer bg-light">إعدادات إدارة المبيعات</div>
                </div>
            </div>
    <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">إدارة المخزون والمشتريات</div>
                    <div class="card-body text-dark">
                     
                        <?php
                            $sales_options = [
                                'inventory_management' => 'ادارة المخزون',
                                'manufacturing' => 'التصنيع',
                                'purchase_cycle' => 'دورة المشتريات',
                             
                            ];
                        ?>

                        <?php $__currentLoopData = $sales_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="switch-container">
                                <label class="form-check-label" for="<?php echo e($key); ?>"><?php echo e($label); ?></label>
                                <div class="form-check form-switch">
                                    <input type="hidden" name="<?php echo e($key); ?>" value="inactive">
                                    <input class="form-check-input" type="checkbox" id="<?php echo e($key); ?>" name="<?php echo e($key); ?>"
                                        value="active" <?php echo e(old($key, $settings[$key] ?? 'inactive') === 'active' ? 'checked' : ''); ?>>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="card-footer bg-light">إعدادات إدارة المخزون والمشتريات</div>
                </div>
         
        </div>

     
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">إدارة  الحسابات</div>
                <div class="card-body text-dark">
                 
                    <?php
                        $sales_options = [
                            'finance' => ' المالية',
                            'general_accounts_journal_entries' => 'الحسابات العامة والقيود اليومية',
                            'cheque_cycle' => 'دورة الشيكات',
                         
                        ];
                    ?>

                    <?php $__currentLoopData = $sales_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="switch-container">
                            <label class="form-check-label" for="<?php echo e($key); ?>"><?php echo e($label); ?></label>
                            <div class="form-check form-switch">
                                <input type="hidden" name="<?php echo e($key); ?>" value="inactive">
                                <input class="form-check-input" type="checkbox" id="<?php echo e($key); ?>" name="<?php echo e($key); ?>"
                                    value="active" <?php echo e(old($key, $settings[$key] ?? 'inactive') === 'active' ? 'checked' : ''); ?>>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="card-footer bg-light">إعدادات إدارة  الحسابات</div>
            </div>
            
        </div>
       
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">إدارة  العمليات</div>
                <div class="card-body text-dark">
                 
                    <?php
                        $sales_options = [
                            'work_orders' => ' أوامر الشغل',
                            'rental_management' => 'ادارات الايجارات والوحدات',
                            'booking_management' => 'ادارة الحجوزات',
                            'time_tracking' => 'تتبع الوقت',
                            'workflow' => 'دورة العمل',
                         
                        ];
                    ?>

                    <?php $__currentLoopData = $sales_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="switch-container">
                            <label class="form-check-label" for="<?php echo e($key); ?>"><?php echo e($label); ?></label>
                            <div class="form-check form-switch">
                                <input type="hidden" name="<?php echo e($key); ?>" value="inactive">
                                <input class="form-check-input" type="checkbox" id="<?php echo e($key); ?>" name="<?php echo e($key); ?>"
                                    value="active" <?php echo e(old($key, $settings[$key] ?? 'inactive') === 'active' ? 'checked' : ''); ?>>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="card-footer bg-light">إعدادات إدارة  العمليات</div>
            </div>
            
        </div>
        
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">إدارة  علاقة العملاء</div>
                <div class="card-body text-dark">
                 
                    <?php
                        $sales_options = [
                            'customers' => ' العملاء ',
                            'customer_followup' => 'متابعة العميل'  ,
                            'points_balances' => 'النقاط والارصدة',
                            'membership' => 'العضوية',
                            'customer_attendance' => 'حضور العملاء',
                         
                        ];
                    ?>

                    <?php $__currentLoopData = $sales_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="switch-container">
                            <label class="form-check-label" for="<?php echo e($key); ?>"><?php echo e($label); ?></label>
                            <div class="form-check form-switch">
                                <input type="hidden" name="<?php echo e($key); ?>" value="inactive">
                                <input class="form-check-input" type="checkbox" id="<?php echo e($key); ?>" name="<?php echo e($key); ?>"
                                    value="active" <?php echo e(old($key, $settings[$key] ?? 'inactive') === 'active' ? 'checked' : ''); ?>>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="card-footer bg-light">إعدادات إدارة  علاقة العملاء</div>
            </div>
            
        </div>

        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">إدارة الموارد البشرية</div>
                <div class="card-body text-dark">
                 
                    <?php
                        $sales_options = [
                            'employees' => ' الموظفين ',
                            'organizational_structure' => 'الهيكل التنظيمي'  ,
                            'employee_attendance' => 'حضور الموظفين',
                            'salaries' => 'المرتبات',
                            'orders' => 'الطلبات',
                         
                        ];
                    ?>

                    <?php $__currentLoopData = $sales_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="switch-container">
                            <label class="form-check-label" for="<?php echo e($key); ?>"><?php echo e($label); ?></label>
                            <div class="form-check form-switch">
                                <input type="hidden" name="<?php echo e($key); ?>" value="inactive">
                                <input class="form-check-input" type="checkbox" id="<?php echo e($key); ?>" name="<?php echo e($key); ?>"
                                    value="active" <?php echo e(old($key, $settings[$key] ?? 'inactive') === 'active' ? 'checked' : ''); ?>>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="card-footer bg-light">إعدادات إدارة  علاقة العملاء</div>
            </div>
            
        </div>
        

        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">العامة</div>
                <div class="card-body text-dark">
                 
                    <?php
                        $sales_options = [
                            'sms' => ' SMS ',
                            'ecommerce' => ' المتجر الالكتروني'  ,
                            'branches' => 'الفروع',
                          
                         
                        ];
                    ?>

                    <?php $__currentLoopData = $sales_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="switch-container">
                            <label class="form-check-label" for="<?php echo e($key); ?>"><?php echo e($label); ?></label>
                            <div class="form-check form-switch">
                                <input type="hidden" name="<?php echo e($key); ?>" value="inactive">
                                <input class="form-check-input" type="checkbox" id="<?php echo e($key); ?>" name="<?php echo e($key); ?>"
                                    value="active" <?php echo e(old($key, $settings[$key] ?? 'inactive') === 'active' ? 'checked' : ''); ?>>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="card-footer bg-light">إعدادات إدارة   العامة</div>
            </div>
            
        </div>
        <script>
            document.querySelectorAll('.form-check-input').forEach(switchInput => {
                switchInput.addEventListener('change', function() {
                    this.previousElementSibling.value = this.checked ? 'active' : 'inactive';
                });
            });
        </script>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/sitting/Application/index.blade.php ENDPATH**/ ?>