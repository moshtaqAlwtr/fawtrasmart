<?php $__env->startSection('title'); ?>
    ادارة عروض السعر
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">ادارة عروض السعر </h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a>
                            </li>
                            <li class="breadcrumb-item active">عرض
                            </li>
                        </ol>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <div class="content-body">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <!-- Checkbox لتحديد الكل -->
                    <div class="form-check me-3">
                        <input class="form-check-input" type="checkbox" id="selectAll" onclick="toggleSelectAll()">
                    </div>

                    <!-- زر عرض سعر جديد -->
                    <a href="<?php echo e(route('questions.create')); ?>" class="btn btn-success btn-sm d-flex align-items-center rounded-pill px-3">
                        <i class="fas fa-plus-circle me-1"></i>عرض سعر جديد
                    </a>

                    <!-- زر المواعيد -->
                    <a href="<?php echo e(route('appointments.index')); ?>" class="btn btn-outline-primary btn-sm d-flex align-items-center rounded-pill px-3">
                        <i class="fas fa-calendar-alt me-1"></i>المواعيد
                    </a>

                    <!-- زر استيراد -->
                    <a href="<?php echo e(route('questions.logsaction')); ?>" class="btn btn-outline-primary btn-sm d-flex align-items-center rounded-pill px-3">
                        <i class="fas fa-cloud-upload-alt me-1"></i>استيراد
                    </a>

                    <!-- جزء التنقل بين الصفحات -->
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm mb-0">
                            <!-- زر الانتقال إلى أول صفحة -->
                            <?php if($quotes->onFirstPage()): ?>
                                <li class="page-item disabled">
                                    <span class="page-link border-0 rounded-pill" aria-label="First">
                                        <i class="fas fa-angle-double-right"></i>
                                    </span>
                                </li>
                            <?php else: ?>
                                <li class="page-item">
                                    <a class="page-link border-0 rounded-pill" href="<?php echo e($quotes->url(1)); ?>" aria-label="First">
                                        <i class="fas fa-angle-double-right"></i>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- زر الانتقال إلى الصفحة السابقة -->
                            <?php if($quotes->onFirstPage()): ?>
                                <li class="page-item disabled">
                                    <span class="page-link border-0 rounded-pill" aria-label="Previous">
                                        <i class="fas fa-angle-right"></i>
                                    </span>
                                </li>
                            <?php else: ?>
                                <li class="page-item">
                                    <a class="page-link border-0 rounded-pill" href="<?php echo e($quotes->previousPageUrl()); ?>" aria-label="Previous">
                                        <i class="fas fa-angle-right"></i>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- عرض رقم الصفحة الحالية -->
                            <li class="page-item">
                                <span class="page-link border-0 bg-light rounded-pill px-3">
                                    صفحة <?php echo e($quotes->currentPage()); ?> من <?php echo e($quotes->lastPage()); ?>

                                </span>
                            </li>

                            <!-- زر الانتقال إلى الصفحة التالية -->
                            <?php if($quotes->hasMorePages()): ?>
                                <li class="page-item">
                                    <a class="page-link border-0 rounded-pill" href="<?php echo e($quotes->nextPageUrl()); ?>" aria-label="Next">
                                        <i class="fas fa-angle-left"></i>
                                    </a>
                                </li>
                            <?php else: ?>
                                <li class="page-item disabled">
                                    <span class="page-link border-0 rounded-pill" aria-label="Next">
                                        <i class="fas fa-angle-left"></i>
                                    </span>
                                </li>
                            <?php endif; ?>

                            <!-- زر الانتقال إلى آخر صفحة -->
                            <?php if($quotes->hasMorePages()): ?>
                                <li class="page-item">
                                    <a class="page-link border-0 rounded-pill" href="<?php echo e($quotes->url($quotes->lastPage())); ?>" aria-label="Last">
                                        <i class="fas fa-angle-double-left"></i>
                                    </a>
                                </li>
                            <?php else: ?>
                                <li class="page-item disabled">
                                    <span class="page-link border-0 rounded-pill" aria-label="Last">
                                        <i class="fas fa-angle-double-left"></i>
                                    </span>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center p-2">
                <div class="d-flex gap-2">
                    <span class="hide-button-text">
                        بحث وتصفية
                    </span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-outline-secondary btn-sm" onclick="toggleSearchFields(this)">
                        <i class="fa fa-times"></i>
                        <span class="hide-button-text">اخفاء</span>
                    </button>
                    <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="collapse"
                        data-bs-target="#advancedSearchForm" onclick="toggleSearchText(this)">
                        <i class="fa fa-filter"></i>
                        <span class="button-text">متقدم</span>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form id="searchForm" action="<?php echo e(route('questions.index')); ?>" method="GET" class="form">
                    <div class="row g-3">
                        <!-- 1. العميل -->
                        <div class="col-md-4">
                            <label for="clientSelect">العميل</label>
                            <select name="client_id" class="form-control select2" id="clientSelect">
                                <option value="">اي العميل</option>
                                <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($client->id); ?>" <?php echo e(request('client_id') == $client->id ? 'selected' : ''); ?>>
                                        <?php echo e($client->trade_name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- 2. رقم عرض السعر -->
                        <div class="col-md-4">
                            <label for="feedback2">رقم عرض السعر</label>
                            <input type="text" id="feedback2" class="form-control"
                                placeholder="رقم عرض السعر" name="id" value="<?php echo e(request('id')); ?>">
                        </div>

                        <!-- 3. الحالة -->
                        <div class="col-md-4">
                            <label for="statusSelect">الحالة</label>
                            <select name="status" class="form-control" id="statusSelect">
                                <option value="">الحالة</option>
                                <option value="1" <?php echo e(request('status') == '1' ? 'selected' : ''); ?>>مفتوح</option>
                                <option value="2" <?php echo e(request('status') == '2' ? 'selected' : ''); ?>> مغلق</option>
                            </select>
                        </div>
                    </div>

                    <!-- البحث المتقدم -->
                    <div class="collapse <?php echo e(request()->hasAny(['currency', 'total_from', 'total_to', 'date_type_1', 'date_type_2', 'item_search', 'created_by', 'sales_representative']) ? 'show' : ''); ?>" id="advancedSearchForm">
                        <div class="row g-3 mt-2">
                            <!-- 4. العملة -->
                            <div class="col-md-4">
                                <label for="currencySelect">العملة</label>
                                <select name="currency" class="form-control" id="currencySelect">
                                    <option value="">العملة</option>
                                    <option value="SAR" <?php echo e(request('currency') == 'SAR' ? 'selected' : ''); ?>>ريال سعودي</option>
                                    <option value="USD" <?php echo e(request('currency') == 'USD' ? 'selected' : ''); ?>>دولار أمريكي</option>
                                </select>
                            </div>

                            <!-- 5. الإجمالي أكبر من -->
                            <div class="col-md-2">
                                <label for="total_from">الإجمالي أكبر من</label>
                                <input type="number" class="form-control" placeholder="الإجمالي أكبر من"
                                    name="total_from" step="0.01" value="<?php echo e(request('total_from')); ?>">
                            </div>

                            <!-- 6. الإجمالي أصغر من -->
                            <div class="col-md-2">
                                <label for="total_to">الإجمالي أصغر من</label>
                                <input type="number" class="form-control" placeholder="الإجمالي أصغر من"
                                    name="total_to" step="0.01" value="<?php echo e(request('total_to')); ?>">
                            </div>

                            <!-- 7. الحالة -->

                        </div>

                        <div class="row g-3 mt-2">
                            <!-- 8. التخصيص -->
                            <div class="col-md-2">
                                <label for="date_type_1">التخصيص</label>
                                <select name="date_type_1" class="form-control">
                                    <option value="">تخصيص</option>
                                    <option value="monthly" <?php echo e(request('date_type_1') == 'monthly' ? 'selected' : ''); ?>>شهرياً</option>
                                    <option value="weekly" <?php echo e(request('date_type_1') == 'weekly' ? 'selected' : ''); ?>>أسبوعياً</option>
                                    <option value="daily" <?php echo e(request('date_type_1') == 'daily' ? 'selected' : ''); ?>>يومياً</option>
                                </select>
                            </div>

                            <!-- 9. التاريخ من -->
                            <div class="col-md-2">
                                <label for="from_date_1">التاريخ من</label>
                                <input type="date" class="form-control" placeholder="من"
                                    name="from_date_1" value="<?php echo e(request('from_date_1')); ?>">
                            </div>

                            <!-- 10. التاريخ إلى -->
                            <div class="col-md-2">
                                <label for="to_date_1">التاريخ إلى</label>
                                <input type="date" class="form-control" placeholder="إلى"
                                    name="to_date_1" value="<?php echo e(request('to_date_1')); ?>">
                            </div>

                            <!-- 11. التخصيص -->
                            <div class="col-md-2">
                                <label for="date_type_2">التخصيص</label>
                                <select name="date_type_2" class="form-control">
                                    <option value="">تخصيص</option>
                                    <option value="monthly" <?php echo e(request('date_type_2') == 'monthly' ? 'selected' : ''); ?>>شهرياً</option>
                                    <option value="weekly" <?php echo e(request('date_type_2') == 'weekly' ? 'selected' : ''); ?>>أسبوعياً</option>
                                    <option value="daily" <?php echo e(request('date_type_2') == 'daily' ? 'selected' : ''); ?>>يومياً</option>
                                </select>
                            </div>

                            <!-- 12. تاريخ الإنشاء من -->
                            <div class="col-md-2">
                                <label for="from_date_2">تاريخ الإنشاء من</label>
                                <input type="date" class="form-control" placeholder="من"
                                    name="from_date_2" value="<?php echo e(request('from_date_2')); ?>">
                            </div>

                            <!-- 13. تاريخ الإنشاء إلى -->
                            <div class="col-md-2">
                                <label for="to_date_2">تاريخ الإنشاء إلى</label>
                                <input type="date" class="form-control" placeholder="إلى"
                                    name="to_date_2" value="<?php echo e(request('to_date_2')); ?>">
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <!-- 14. تحتوي على البند -->
                            <div class="col-md-4">
                                <label for="item_search">تحتوي على البند</label>
                                <input type="text" class="form-control" placeholder="تحتوي على البند"
                                    name="item_search" value="<?php echo e(request('item_search')); ?>">
                            </div>

                            <!-- 15. أضيفت بواسطة -->
                            <div class="col-md-4">
                                <label for="created_by">أضيفت بواسطة</label>
                                <select name="created_by" class="form-control select2">
                                    <option value="">أضيفت بواسطة</option>
                                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($employee->id); ?>" <?php echo e(request('created_by') == $employee->id ? 'selected' : ''); ?>>
                                            <?php echo e($employee->full_name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <!-- 16. مسؤول المبيعات -->
                            <div class="col-md-4">
                                <label for="sales_representative">مسؤول المبيعات</label>
                                <select name="sales_representative" class="form-control select2">
                                    <option value="">مسؤول المبيعات</option>
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($user->id); ?>" <?php echo e(request('sales_representative') == $user->id ? 'selected' : ''); ?>>
                                            <?php echo e($user->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                        </div>
                    </div>

                    <!-- الأزرار -->
                    <div class="form-actions mt-2">
                        <button type="submit" class="btn btn-primary">بحث</button>
                        <a href="<?php echo e(route('questions.index')); ?>" type="reset" class="btn btn-outline-warning">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">


            <!-- قائمة الفواتير -->
            <?php $__currentLoopData = $quotes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quote): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card-body">
                    <div class="row border-bottom py-2 align-items-center">
                        <!-- معلومات الفاتورة -->
                        <div class="col-md-4">
                            <p class="mb-0">
                                <strong>#<?php echo e($quote->id); ?></strong>
                            </p>
                            <small class="text-muted">
                                <i class="fas fa-user me-1"></i>
                                <?php echo e($quote->client ? ($quote->client->trade_name ?: $quote->client->first_name . ' ' . $quote->client->last_name) : 'عميل غير معروف'); ?>


                                الرقم الضريبي
                                <?php if($quote->client && $quote->client->tax_number): ?>
                                    <i class="fas fa- me-1"></i><?php echo e($quote->client->tax_number); ?>

                                <?php endif; ?>
                            </small>
                            <small class="d-block">
                                <?php if($quote->client && $quote->client->full_address): ?>
                                    <i class="fas fa-map-marker-alt me-1"></i><?php echo e($quote->client->full_address); ?>

                                <?php endif; ?>
                            </small>
                            <small class="text-muted">
                                <i class="fas fa-user-tie me-1"></i> بواسطة:
                                <?php echo e($quote->creator->name ?? 'غير محدد'); ?>

                            </small>
                            <p class="mb-0 text-muted">
                                <i class="fas fa-mobile-alt me-1"></i> المصدر: تطبيق الهاتف المحمول
                            </p>
                        </div>

                        <!-- تاريخ الفاتورة -->
                        <div class="col-md-3">
                            <p class="mb-0">
                                <i class="fas fa-calendar-alt me-1"></i>
                                <?php echo e($quote->created_at ? $quote->created_at->format('H:i:s d/m/Y') : ''); ?>

                            </p>
                            <small class="text-muted">
                                <i class="fas fa-user me-1"></i> بواسطة:
                                <?php echo e($quote->creator->name ?? 'غير محدد'); ?>

                            </small>
                        </div>

                        <!-- المبلغ وحالة الدفع -->
                        <div class="col-md-3 text-center">
                             <?php
                                            $currency = $account_setting->currency ?? 'SAR';
                                            $currencySymbol = $currency == 'SAR' || empty($currency) ? '<img src="' . asset('assets/images/Saudi_Riyal.svg') . '" alt="ريال سعودي" width="15" style="vertical-align: middle;">' : $currency;
                                        ?>
                            <!-- عرض المبلغ الإجمالي -->
                            <div class="mb-2">
                                <strong class="text-danger fs-2 d-block">
                                    <?php echo e(number_format($quote->grand_total ?? $quote->total, 2)); ?>

                                    <small class="currency"><?php echo $currencySymbol; ?></small>
                                </strong>

                                <!-- عرض حالة الدفع مع تغيير اللون بناءً على الحالة -->
                                <?php
                                    $statusClass = '';
                                    $statusText = '';

                                    if ($quote->status == 1) {
                                        $statusClass = 'bg-success';
                                        $statusText = 'مفتوح';
                                    } else {
                                        $statusClass = 'bg-info';
                                        $statusText = 'مغلق ';
                                    }
                                ?>

                                <!-- عرض حالة الدفع -->
                                <span class="badge <?php echo e($statusClass); ?> d-inline-block mt-2 p-1 rounded small"
                                    style="font-size: 0.8rem;">
                                    <i class="fas fa-circle me-1"></i> <?php echo e($statusText); ?>

                                </span>
                            </div>
                        </div>

                        <!-- الأزرار -->
                        <div class="col-md-2 text-end">
                            <div class="btn-group">
                                <div class="dropdown">
                                    <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1" type="button"
                                        id="dropdownMenuButton<?php echo e($quote->id); ?>" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton<?php echo e($quote->id); ?>">
                                        <a class="dropdown-item" href="<?php echo e(route('questions.edit', $quote->id)); ?>">
                                            <i class="fa fa-edit me-2 text-success"></i>تعديل
                                        </a>
                                        <a class="dropdown-item" href="<?php echo e(route('questions.show', $quote->id)); ?>">
                                            <i class="fa fa-eye me-2 text-primary"></i>عرض
                                        </a>
                                        <a class="dropdown-item"
                                            href="<?php echo e(route('questions.create', ['id' => $quote->id])); ?>">
                                            <i class="fa fa-money-bill me-2 text-success"></i>إضافة دفعة
                                        </a>
                                        <a class="dropdown-item" href="">
                                            <i class="fa fa-file-pdf me-2 text-danger"></i>PDF
                                        </a>
                                        <a class="dropdown-item" href="">
                                            <i class="fa fa-print me-2 text-dark"></i>طباعة
                                        </a>
                                        <a class="dropdown-item" href="">
                                            <i class="fa fa-envelope me-2 text-warning"></i>إرسال إلى العميل
                                        </a>

                                        <a class="dropdown-item" href="">
                                            <i class="fa fa-copy me-2 text-secondary"></i>نسخ
                                        </a>
                                        <form action="<?php echo e(route('questions.destroy', $quote->id)); ?>" method="POST"
                                            class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fa fa-trash me-2"></i>حذف
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <!-- إذا لم تكن هناك فواتير -->
            <?php if($quotes->isEmpty()): ?>
                <div class="alert alert-warning" role="alert">
                    <p class="mb-0"><i class="fas fa-exclamation-circle me-2"></i>لا توجد عروض اسعار </p>
                </div>
            <?php endif; ?>
        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('assets/js/search.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/sales/qoution/index.blade.php ENDPATH**/ ?>