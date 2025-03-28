<?php $__env->startSection('title'); ?>
    اضافة اتفاقية قسط
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">  اضافة اتفاقية قسط</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a></li>
                            <li class="breadcrumb-item active">عرض</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php echo $__env->make('layouts.alerts.success', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('layouts.alerts.error', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


    <div class="content-body">
        <form class="form" action="<?php echo e(route('installments.store')); ?>" method="post" enctype="multipart/form-data">
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

            <div class="card" style="max-width: 90%; margin: 0 auto;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h1 class="card-title"> معلومات اتفاقية التقسيط </h1>
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

                    <div class="form-body row">
                        <div class="form-group col-md-6">
                            <label for="client_id" class="form-label" style="margin-bottom: 10px"> العميل </label>
                            <select class="form-control duration-field" name="client_id" required>
                                <option value="">اختر العميل</option>
                                <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($client->id); ?>" <?php echo e($client->id == $invoice->client_id ? 'selected' : ''); ?>>
                                        <?php echo e($client->trade_name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-body row">
                        <div class="form-group col-md-6">
                            <label for="amount" class=""> مبلغ اتفاقية التقسيط </label>
                            <input type="number" id="amount" class="form-control" name="amount" value="<?php echo e($invoice->grand_total); ?>" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="invoice_id" class=""> رقم الفاتورة  </label>
                            <input type="number" id="invoice_id" class="form-control" name="invoice_id" value="<?php echo e($invoice->id); ?>" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="installment_amount" class=""> مبلغ القسط </label>
                            <input type="number" id="installment_amount" class="form-control" name="amount" oninput="calculateInstallments()">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="installments" class=""> عدد الاقساط </label>
                            <input type="number" id="installments" class="form-control" name="installment number" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="payment_rate" class=""> معدل السداد </label>
                            <select name="payment_rate" class="form-control duration-field" id="">
                                <option value=""> اختر معدل السداد</option>
                                <option value="1"> شهري </option>
                                <option value="2"> اسبوعي </option>
                                <option value="3"> سنوي </option>
                                <option value="4"> ربع سنوي </option>
                                <option value="5"> مرة كل اسبوعين </option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="start_date" class=""> تاريخ بدء السداد </label>
                            <input type="date" id="start_date" class="form-control" name="due_date">
                        </div>

                    </div>

                    <div class="form-group col-md-6">
                        <label for="note" class=""> ملاحضات </label>
                        <textarea name="note" id="note" class="form-control"></textarea>
                    </div>
                </div>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
    function calculateInstallments() {
        const grandTotal = parseFloat(document.getElementById('amount').value);
        const installmentAmount = parseFloat(document.getElementById('installment_amount').value);

        if (!isNaN(grandTotal) && !isNaN(installmentAmount) && installmentAmount > 0) {
            const numberOfInstallments = Math.ceil(grandTotal / installmentAmount);
            document.getElementById('installments').value = numberOfInstallments;
        } else {
            document.getElementById('installments').value = '';
        }
    }
</script>

<script>
    // تعيين التاريخ الحالي كقيمة افتراضية لحقل تاريخ بدء السداد
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0]; // الحصول على التاريخ الحالي بصيغة YYYY-MM-DD
        document.getElementById('start_date').value = today; // تعيين القيمة لحقل الإدخال
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/Installments/create.blade.php ENDPATH**/ ?>