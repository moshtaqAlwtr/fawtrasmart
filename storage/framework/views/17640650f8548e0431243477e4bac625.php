<?php $__env->startSection('title'); ?>
    اضافة عملية الدفع
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">اضافة عملية دفع </h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a></li>
                            <li class="breadcrumb-item active">عرض </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="<?php echo e(route('paymentsClient.store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <!-- عرض الأخطاء -->
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
                            <i class="fa fa-save"></i> اضافة عملية الدفع
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <!-- الحقول -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">المبلغ <span style="color: red">*</span></label>
                        <input type="number" id="name" name="amount" class="form-control" placeholder="المبلغ"
                            step="0.01" value="<?php echo e($amount ?? ''); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="date" class="form-label">تاريخ الدفع <span style="color: red">*</span></label>
                        <input type="date" id="date" name="payment_date" class="form-control" value="<?php echo e(date('Y-m-d')); ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="payment_method" class="form-label">وسيلة الدفع <span style="color: red">*</span></label>
                        <select name="payment_type" class="form-control" id="payment_method" required>
                            <option value="">اختر نوع الدفع</option>
                            <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($payment->id); ?>"><?php echo e($payment->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="treasury_id" class="form-label">الخزينة المستخدمة </label>
                       
                         
                       
                          <input type="text"   class="form-control" placeholder="رقم المعرف"
                            value="<?php echo e($mainTreasuryAccount->name ?? ""); ?>" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="status_payment" class="form-label">حالة الدفع <span style="color: red">*</span></label>
                        <select name="status_payment" class="form-control" id="status_payment" required>
                            <option value="">اختر حالة الدفع</option>
                            <option value="2">غير مكتمل</option>
                            <option value="1">مكتمل</option>
                            <option value="4">تحت المراجعة</option>
                            <option value="5">فاشلة</option>
                            <option value="3">مسودة</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="employee" class="form-label">تم التحصيل بواسطة <span style="color: red">*</span></label>
                        <select name="employee_id" class="form-control" id="employee" required>
                            <option value="">اختر الموظف</option>
                            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($employee->id); ?>"><?php echo e($employee->full_name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <!-- حقل مخفي لتحديد نوع الدفع -->
                <input type="hidden" name="type" value="<?php echo e($type); ?>">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="address1" class="form-label">رقم المعرف</label>
                        <input type="text" id="address1" name="id" class="form-control" placeholder="رقم المعرف"
                            value="<?php echo e($invoiceId); ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="description" class="form-label">بيانات الدفع</label>
                        <textarea id="description" name="payment_data" class="form-control" rows="2"
                            placeholder="مثل: رقم الشيك، رقم التحويل"></textarea>
                    </div>
                </div>

                <input type="hidden" name="invoice_id" value="<?php echo e($invoiceId); ?>">
                <input type="hidden" name="installment_id" value="<?php echo e($installmentId ?? ''); ?>">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="work_hours" class="form-label">ملاحظات</label>
                        <textarea id="work_hours" name="notes" class="form-control" rows="2" placeholder="أي ملاحظات إضافية"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="file" class="form-label">المرفقات</label>
                        <input id="file" type="file" name="attachments" class="form-control"
                            accept=".pdf,.jpg,.jpeg,.png">
                        <small class="text-muted">يمكنك رفع ملف PDF أو صورة (الحد الأقصى 2 ميجابايت)</small>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    function getInvoiceDetails(invoiceId) {
        fetch(`/payments/invoice-details/${invoiceId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // تحديث النموذج بتفاصيل الفاتورة
                    document.getElementById('remaining_amount').textContent = data.data.remaining_amount;
                    document.getElementById('client_name').textContent = data.data.client_name;
                    document.getElementById('invoice_total').textContent = data.data.grand_total;
                    document.getElementById('total_paid').textContent = data.data.total_paid;
                } else {
                    alert('خطأ في جلب تفاصيل الفاتورة');
                }
            })
            .catch(error => console.error('Error:', error));
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/sales/payment/create.blade.php ENDPATH**/ ?>