<?php $__env->startSection('title'); ?>
    تحليل الزيارات
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">تحليل الزيارات   </h2>
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

<?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <h4 class="mt-4">📍 <?php echo e($group->name); ?></h4>
    <table class="table table-bordered text-center">
        <thead class="table-light">
            <tr>
                <th>العميل</th>
                <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <th><?php echo e(\Carbon\Carbon::parse($date)->format('Y-m-d')); ?></th>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <th>💰 مجموع المدفوع</th>
            </tr>
        </thead>
        <tbody>
            <?php if($group->customers && count($group->customers) > 0): ?>
            <?php $__currentLoopData = $group->customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $totalPaid = 0;
                    $debt = $customer->invoices->sum('total') - $customer->payments->sum('amount');
                ?>
                <tr>
                    <td class="text-start">
                        <?php echo e($customer->name); ?>

                        <br>
                        <?php if($debt > 0): ?>
                            <span class="badge bg-danger">💰 <?php echo e(number_format($debt)); ?> ريال</span>
                        <?php else: ?>
                            <span class="badge bg-success">✅ مسدد</span>
                        <?php endif; ?>
                    </td>

                    <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $visit = $customer->visits->firstWhere('visit_date', $date);
                            $icons = '';
                            $paidAmount = 0;
                        ?>

                        <?php if($visit): ?>
                            <?php $icons .= '🚶‍♂️'; ?>

                            <?php if($visit->note): ?>
                                <?php $icons .= ' 📝'; ?>
                            <?php endif; ?>

                            <?php if($visit->invoice): ?>
                                <?php $icons .= ' 🧾'; ?>
                            <?php endif; ?>

                            <?php if($visit->payment): ?>
                                <?php
                                    $paidAmount += $visit->payment->amount;
                                    $icons .= ' 💵' . number_format($visit->payment->amount);
                                ?>
                            <?php endif; ?>

                            <?php $totalPaid += $paidAmount; ?>
                            <td><?php echo $icons; ?></td>
                        <?php else: ?>
                            <td>❌</td>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <td><strong><?php echo e(number_format($totalPaid)); ?> ريال</strong></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </tbody>
    </table>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/reports/sals/traffic_analytics.blade.php ENDPATH**/ ?>