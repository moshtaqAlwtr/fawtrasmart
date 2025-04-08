<?php $__env->startSection('title'); ?>
    تحليل الزيارات
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">تحليل الزيارات</h2>
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
<div class="card">
    <div class="card-body">
    <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <h4 class="mt-4">📍 <?php echo e($group->name); ?></h4>

    <?php
        // جمع العملاء من خلال الأحياء التابعة للمجموعة
        $clients = $group->neighborhoods->flatMap(function($neigh) {
            return $neigh->client ? [$neigh->client] : [];
        })->filter()->unique('id');
    ?>

    <?php if($clients->count() > 0): ?>
        <table class="table table-bordered text-center">
            <thead class="table-light">
                <tr>
                    <th>العميل</th>
                    <?php $__currentLoopData = $weeks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $week): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <th>
                            <?php echo e(\Carbon\Carbon::parse($week['start'])->format('d M')); ?><br>
                            إلى<br>
                            <?php echo e(\Carbon\Carbon::parse($week['end'])->format('d M')); ?>

                        </th>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="text-start"><?php echo e($client->trade_name); ?></td>
                        <?php $__currentLoopData = $weeks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $week): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $icons = '';
                                $hasActivity = false;

                                // Check invoices
                                if ($client->invoices && $client->invoices->whereBetween('created_at', [$week['start'], $week['end']])->count()) {
                                    $icons .= '🧾 ';
                                    $hasActivity = true;
                                }

                                // Check payments
                                if ($client->payments && $client->payments->whereBetween('created_at', [$week['start'], $week['end']])->count()) {
                                    $icons .= '💵 ';
                                    $hasActivity = true;
                                }

                                // Check notes
                                if ($client->notes && $client->notes->whereBetween('created_at', [$week['start'], $week['end']])->count()) {
                                    $icons .= '📝 ';
                                    $hasActivity = true;
                                }

                                // Check visits
                                if ($client->visits && $client->visits->whereBetween('created_at', [$week['start'], $week['end']])->count()) {
                                    $icons .= '👣 ';
                                    $hasActivity = true;
                                }
                            ?>
                            <td><?php echo $hasActivity ? $icons : '❌'; ?></td>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">لا يوجد عملاء في هذه المجموعة</div>
    <?php endif; ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/reports/sals/traffic_analytics.blade.php ENDPATH**/ ?>