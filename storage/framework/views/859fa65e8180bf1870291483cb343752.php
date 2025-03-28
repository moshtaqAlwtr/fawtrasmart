<?php $__env->startSection('title'); ?>
    عرض القيد المحاسبي
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex gap-2">
                        <strong>قيد يومية #<?php echo e($entry->id); ?></strong>
                        <span><?php echo e($entry->description); ?></span>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-success d-inline-flex align-items-center print-button">
                            <i class="fas fa-print me-1"></i> طباعة القيد
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
                        <a href="<?php echo e(route('journal.edit', $entry->id)); ?>"
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
                                <a class="nav-link active" id="entry-tab" data-toggle="tab" href="#entry" role="tab"
                                    aria-controls="entry" aria-selected="true">القيد</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="entry-details-tab" data-toggle="tab" href="#entry-details"
                                    role="tab" aria-controls="entry-details" aria-selected="false">تفاصيل القيد</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="activity-log-tab" data-toggle="tab" href="#activity-log"
                                    role="tab" aria-controls="activity-log" aria-selected="false">سجل النشاطات</a>
                            </li>
                        </ul>

                        <div class="tab-content mt-3">
                            <!-- القيد -->
                            <div class="tab-pane fade show active" id="entry" role="tabpanel" aria-labelledby="entry-tab">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="tab-pane fade show active"
                                            style="background: lightslategray; min-height: 100vh; padding: 20px;">
                                            <div class="card shadow" style="max-width: 600px; margin: 20px auto;">
                                                <div class="card-body bg-white p-4"
                                                    style="min-height: 400px; overflow: auto;">
                                                    <div style="transform: scale(0.8); transform-origin: top center;">
                                                        <?php echo $__env->make('Accounts.journal.pdf', [
                                                            'entry' => $entry,
                                                        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- تفاصيل القيد -->
                            <div class="tab-pane fade" id="entry-details" role="tabpanel" aria-labelledby="entry-details-tab">
                                <div class="pdf-view" style="background: lightslategray; min-height: 100vh; padding: 20px;">
                                    <div class="card shadow" style="max-width: 600px; margin: 20px auto;">
                                        <div class="card-body bg-white p-4">
                                            <div style="transform: scale(0.8); transform-origin: top center;">
                                                <!-- PDF Content -->
                                                <div dir="rtl" style="font-family: 'Cairo', sans-serif;">
                                                    <div style="text-align: center; margin-bottom: 20px;">
                                                        <h2 style="margin: 0;">قيد يومية #<?php echo e($entry->id); ?></h2>
                                                    </div>

                                                    <div style="margin-bottom: 20px;">
                                                        <p style="margin: 5px 0;">التاريخ: <?php echo e($entry->date); ?></p>
                                                        <p style="margin: 5px 0;">الوصف: <?php echo e($entry->description); ?></p>
                                                    </div>

                                                    <table style="width: 100%; border-collapse: collapse;">
                                                        <thead>
                                                            <tr>
                                                                <th style="border: 1px solid #000; padding: 8px; text-align: right;">الحساب</th>
                                                                <th style="border: 1px solid #000; padding: 8px; text-align: right;">الوصف</th>
                                                                <th style="border: 1px solid #000; padding: 8px; text-align: right;">مدين</th>
                                                                <th style="border: 1px solid #000; padding: 8px; text-align: right;">دائن</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $__currentLoopData = $entry->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td style="border: 1px solid #000; padding: 8px;"><?php echo e($detail->account_number); ?></td>
                                                                <td style="border: 1px solid #000; padding: 8px;"><?php echo e($detail->description); ?></td>
                                                                <td style="border: 1px solid #000; padding: 8px;"><?php echo e($detail->debit ? number_format($detail->debit, 2) : ''); ?></td>
                                                                <td style="border: 1px solid #000; padding: 8px;"><?php echo e($detail->credit ? number_format($detail->credit, 2) : ''); ?></td>
                                                            </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <tr style="font-weight: bold;">
                                                                <td colspan="2" style="border: 1px solid #000; padding: 8px;">الإجمالى</td>
                                                                <td style="border: 1px solid #000; padding: 8px;"><?php echo e(number_format($entry->total_debit, 2)); ?> ر.س</td>
                                                                <td style="border: 1px solid #000; padding: 8px;"><?php echo e(number_format($entry->total_credit, 2)); ?> ر.س</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- سجل النشاطات -->
                            <div class="tab-pane fade" id="activity-log" role="tabpanel" aria-labelledby="activity-log-tab">
                                <div class="activity-log">

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

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/Accounts/journal/show.blade.php ENDPATH**/ ?>