<?php $__env->startSection('title'); ?>
    ايصال
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">ادارة ايصالات الدفع</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                            <li class="breadcrumb-item active">عرض</li>
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
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex gap-2">
                            <a href="#" class="btn btn-sm btn-outline-success d-inline-flex align-items-center" onclick="printReceipt()">
                                <i class="far fa-sticky-note me-1"></i> طباعة
                            </a>
                            <a href="#" class="btn btn-sm btn-outline-info d-inline-flex align-items-center">
                                <i class="fas fa-file-invoice me-1"></i> PDF
                            </a>
                            <a href="#" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center">
                                <i class="far fa-file-alt me-1"></i> ارسال بريد
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="tab-pane fade show active" style="background: lightslategray; min-height: 100vh; padding: 20px;">
                            <div class="card shadow" style="max-width: 600px; margin: 20px auto;">
                                <div class="card-body bg-white p-4" style="min-height: 400px; overflow: auto;">
                                    <div id="receipt-content" style="transform: scale(0.8); transform-origin: top center;">
                                        <?php if(request()->query('type') == 'thermal'): ?>
                                            
                                            <?php echo $__env->make('sales.payment.receipt.pdf_receipt', ['receipt' => $receipt], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                        <?php else: ?>
                                            
                                            <?php echo $__env->make('sales.payment.receipt.pdf_repeatA4', ['receipt' => $receipt], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        function printReceipt() {
            const receiptContent = document.getElementById('receipt-content').innerHTML;
            const originalContent = document.body.innerHTML;

            document.body.innerHTML = receiptContent;
            window.print();
            document.body.innerHTML = originalContent;
            window.location.reload();
        }

        document.addEventListener('DOMContentLoaded', function() {
            var toastElList = [].slice.call(document.querySelectorAll('.toast'));
            toastElList.map(function(toastEl) {
                return new bootstrap.Toast(toastEl).show();
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/sales/payment/receipt/index_repeat.blade.php ENDPATH**/ ?>