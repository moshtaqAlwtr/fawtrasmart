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
                            <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                            <li class="breadcrumb-item active">عرض</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header border-bottom">
            <h4 class="card-title">
                <i class="fas fa-chart-line mr-1"></i> تحليل حركة العملاء
            </h4>
            <div class="heading-elements">
                <button class="btn btn-sm btn-outline-primary toggle-week-dates">إظهار/إخفاء التواريخ</button>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-4">
                    <input type="text" id="client-search" class="form-control" placeholder="بحث باسم العميل...">
                </div>
                <div class="col-md-4">
                    <select id="group-filter" class="form-control">
                        <option value="">جميع المجموعات</option>
                        <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="group-<?php echo e($group->id); ?>"><?php echo e($group->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <div class="activity-filter btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-outline-primary active">
                            <input type="radio" name="activity" value="all" checked> الكل
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="radio" name="activity" value="has-activity"> لديه نشاط
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="radio" name="activity" value="no-activity"> بدون نشاط
                        </label>
                    </div>
                </div>
            </div>

            <div class="accordion" id="groups-accordion">
                <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card mb-2 group-section" id="group-<?php echo e($group->id); ?>">
                    <div class="card-header" id="heading-<?php echo e($group->id); ?>">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse-<?php echo e($group->id); ?>" aria-expanded="true" aria-controls="collapse-<?php echo e($group->id); ?>">
                                <i class="fas fa-map-marker-alt text-danger"></i> <?php echo e($group->name); ?>

                                <span class="badge badge-primary badge-pill ml-2"><?php echo e($group->neighborhoods->flatMap(fn($n) => $n->client ? [$n->client] : [])->filter()->unique('id')->count()); ?></span>
                            </button>
                        </h5>
                    </div>

                    <div id="collapse-<?php echo e($group->id); ?>" class="collapse show" aria-labelledby="heading-<?php echo e($group->id); ?>" data-parent="#groups-accordion">
                        <div class="card-body p-0">
                            <?php
                                $clients = $group->neighborhoods->flatMap(function($neigh) {
                                    return $neigh->client ? [$neigh->client] : [];
                                })->filter()->unique('id');
                            ?>

                            <?php if($clients->count() > 0): ?>
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered text-center mb-0 client-table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th style="width: 20%; min-width: 200px;">العميل</th>
                                                <?php $__currentLoopData = $weeks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $week): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <th class="week-header" style="min-width: 80px;">
                                                    <div class="week-number">الأسبوع <?php echo e($loop->iteration); ?></div>
                                                    <div class="week-dates">
                                                        <?php echo e(\Carbon\Carbon::parse($week['start'])->format('d/m')); ?> -
                                                        <?php echo e(\Carbon\Carbon::parse($week['end'])->format('d/m')); ?>

                                                    </div>
                                                </th>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <th>إجمالي النشاط</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="client-row" data-client="<?php echo e($client->trade_name); ?>">
                                                <td class="text-start align-middle">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar mr-1">
                                                            <span class="avatar-content bg-primary"><?php echo e(substr($client->trade_name, 0, 1)); ?></span>
                                                        </div>
                                                        <div>
                                                            <strong><?php echo e($client->trade_name); ?></strong>
                                                            <div class="small text-muted"><?php echo e(optional($client->neighborhood)->name); ?></div>
                                                        </div>
                                                    </div>
                                                </td>

                                                <?php $totalActivities = 0; ?>
                                                <?php $__currentLoopData = $weeks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $week): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        $activities = [];
                                                        $hasActivity = false;

                                                        if ($client->invoices && $client->invoices->whereBetween('created_at', [$week['start'], $week['end']])->count()) {
                                                            $activities[] = ['icon' => '🧾', 'title' => 'فاتورة'];
                                                            $hasActivity = true;
                                                        }

                                                        if ($client->payments && $client->payments->whereBetween('created_at', [$week['start'], $week['end']])->count()) {
                                                            $activities[] = ['icon' => '💵', 'title' => 'دفعة'];
                                                            $hasActivity = true;
                                                        }

                                                        if ($client->notes && $client->notes->whereBetween('created_at', [$week['start'], $week['end']])->count()) {
                                                            $activities[] = ['icon' => '📝', 'title' => 'ملاحظة'];
                                                            $hasActivity = true;
                                                        }

                                                        if ($client->visits && $client->visits->whereBetween('created_at', [$week['start'], $week['end']])->count()) {
                                                            $activities[] = ['icon' => '👣', 'title' => 'زيارة'];
                                                            $hasActivity = true;
                                                        }

                                                        if ($hasActivity) $totalActivities++;
                                                    ?>
                                                    <td class="align-middle activity-cell <?php if($hasActivity): ?> bg-light-success <?php endif; ?>"
                                                        data-has-activity="<?php echo e($hasActivity ? '1' : '0'); ?>">
                                                        <?php if($hasActivity): ?>
                                                            <div class="activity-icons">
                                                                <?php $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <span title="<?php echo e($activity['title']); ?>"><?php echo e($activity['icon']); ?></span>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </div>
                                                        <?php else: ?>
                                                            <span class="text-muted">—</span>
                                                        <?php endif; ?>
                                                    </td>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                <td class="align-middle">
                                                    <span class="badge badge-pill <?php if($totalActivities > 0): ?> badge-light-success <?php else: ?> badge-light-secondary <?php endif; ?>">
                                                        <?php echo e($totalActivities); ?> / <?php echo e(count($weeks)); ?>

                                                    </span>
                                                </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-info m-3">لا يوجد عملاء في هذه المجموعة</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .card-header h5 button {
        font-weight: 600;
        color: #5a5a5a;
        text-decoration: none;
        width: 100%;
        text-align: right;
    }

    .activity-icons span {
        margin: 0 2px;
        font-size: 1.2em;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .activity-icons span:hover {
        transform: scale(1.3);
    }

    .week-header {
        vertical-align: middle;
        font-size: 0.85rem;
    }

    .week-number {
        font-weight: bold;
        margin-bottom: 3px;
    }

    .week-dates {
        color: #6c757d;
        font-size: 0.75rem;
    }

    .client-table th {
        white-space: nowrap;
    }

    .avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 50%;
    }

    .avatar-content {
        color: white;
        font-weight: bold;
    }

    .toggle-week-dates {
        font-size: 0.8rem;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function() {
    // إظهار/إخفاء تواريخ الأسابيع
    $('.toggle-week-dates').click(function() {
        $('.week-dates').toggle();
    });

    // فلترة حسب اسم العميل
    $('#client-search').on('keyup', function() {
        const searchText = $(this).val().toLowerCase();
        $('.client-row').each(function() {
            const clientName = $(this).data('client').toLowerCase();
            $(this).toggle(clientName.includes(searchText));
        });
    });

    // فلترة حسب المجموعة
    $('#group-filter').change(function() {
        const groupId = $(this).val();
        if (groupId) {
            $('.group-section').addClass('d-none');
            $(groupId).removeClass('d-none');
        } else {
            $('.group-section').removeClass('d-none');
        }
    });

    // فلترة حسب النشاط
    $('input[name="activity"]').change(function() {
        const filter = $(this).val();

        $('.client-row').each(function() {
            const row = $(this);
            if (filter === 'all') {
                row.show();
            } else if (filter === 'has-activity') {
                const hasActivity = row.find('.activity-cell[data-has-activity="1"]').length > 0;
                row.toggle(hasActivity);
            } else if (filter === 'no-activity') {
                const noActivity = row.find('.activity-cell[data-has-activity="1"]').length === 0;
                row.toggle(noActivity);
            }
        });
    });

    // توسيع/طي جميع الأقسام
    $('#toggle-all').click(function() {
        $('.collapse').collapse('toggle');
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/reports/sals/traffic_analytics.blade.php ENDPATH**/ ?>