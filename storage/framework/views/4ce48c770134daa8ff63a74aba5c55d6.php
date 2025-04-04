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

    <form action="<?php echo e(route('salary-advance.store-payments', $id)); ?>

" method="POST" enctype="multipart/form-data">
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
                   <div class="col-md-4">
                        <label for="payment_method" class="form-label">الاقساط <span style="color: red">*</span></label>
                        <select name="installmentId" class="form-control" id="payment_method" required>
                            <option value="">اختر القسط </option>
                            <?php $__currentLoopData = $InstallmentPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $InstallmentPayment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($InstallmentPayment->id); ?>"><?php echo e($InstallmentPayment->amount); ?> - <?php echo e($InstallmentPayment->due_date); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="date" class="form-label">تاريخ الدفع <span style="color: red">*</span></label>
                        <input type="date" id="date" name="payment_date" class="form-control" value="<?php echo e(date('Y-m-d')); ?>" required>
                    </div>
                      <div class="col-md-4">
                        <label for="treasury_id" class="form-label">الخزينة المستخدمة </label>
                    
                          <input type="text"   class="form-control" placeholder="رقم المعرف"
                            value="<?php echo e($mainTreasuryAccount->name ?? ""); ?>" readonly>
                  
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

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/salaries/ancestor/pay.blade.php ENDPATH**/ ?>