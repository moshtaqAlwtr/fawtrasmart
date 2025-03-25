<?php $__env->startSection('title'); ?>
    عرض فاتورة المرتجع
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex gap-2">
                        <span class="badge badge-pill badge-danger">مرتجع</span>
                        <strong>فاتورة مرتجع #<?php echo e($return_invoice->id); ?></strong>
                        <span>العميل: <?php echo e($return_invoice->client->trade_name); ?></span>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-success d-inline-flex align-items-center print-button">
                            <i class="fas fa-print me-1"></i> طباعة المرتجع
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="d-flex gap-2">
                        <!-- تعديل -->
                        <a href="<?php echo e(route('ReturnIInvoices.edit', $return_invoice->id)); ?>"
                            class="btn btn-sm btn-outline-danger d-inline-flex align-items-center">
                            <i class="fas fa-pen me-1"></i> تعديل
                        </a>

                        <!-- طباعة -->
                        <a href="#" class="btn btn-sm btn-outline-success d-inline-flex align-items-center print-button">
                            <i class="fas fa-print me-1"></i> طباعة
                        </a>

                        <!-- PDF -->
                        <a href=""
                            class="btn btn-sm btn-outline-info d-inline-flex align-items-center">
                            <i class="fas fa-file-pdf me-1"></i> PDF
                        </a>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="return-details-tab" data-toggle="tab" href="#return-details"
                                   role="tab" aria-controls="return-details" aria-selected="true">تفاصيل المرتجع</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="activity-log-tab" data-toggle="tab" href="#activity-log"
                                   role="tab" aria-controls="activity-log" aria-selected="false">سجل النشاطات</a>
                            </li>
                        </ul>

                        <div class="tab-content mt-3">
                            <div class="tab-pane fade show active" id="return-details" role="tabpanel" aria-labelledby="return-details-tab">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div style="background: lightslategray; min-height: 100vh; padding: 20px;">
                                            <div class="card shadow" style="max-width: 600px; margin: 20px auto;">
                                                <div class="card-body bg-white p-4" style="min-height: 400px; overflow: auto;">
                                                    <div style="transform-origin: top center;">
                                                        <?php echo $__env->make('sales.retend_invoice.pdf', [
                                                            'return_invoice' => $return_invoice,
                                                        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="activity-log" role="tabpanel" aria-labelledby="activity-log-tab">
                                <h5>سجل النشاطات</h5>
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
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <script>
        $(document).ready(function() {
            $('.print-button').click(function() {
                window.print();
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/sales/retend_invoice/show.blade.php ENDPATH**/ ?>