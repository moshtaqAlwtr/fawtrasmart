<?php $__env->startSection('title'); ?>
    الاشعارات الدائنة
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">ادارة الاشعارات الدائنة </h2>
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

                    <!-- زر اشعة دائنة جديدة -->
                    <a href="<?php echo e(route('CreditNotes.create')); ?>" class="btn btn-success btn-sm d-flex align-items-center rounded-pill px-3">
                        <i class="fas fa-plus-circle me-1"></i>اشعة دائنة جديدة
                    </a>

                    <!-- زر المواعيد -->
                    <a href="<?php echo e(route('appointments.index')); ?>" class="btn btn-outline-primary btn-sm d-flex align-items-center rounded-pill px-3">
                        <i class="fas fa-calendar-alt me-1"></i>المواعيد
                    </a>

                    <!-- زر استيراد -->
                    <button class="btn btn-outline-primary btn-sm d-flex align-items-center rounded-pill px-3">
                        <i class="fas fa-cloud-upload-alt me-1"></i>استيراد
                    </button>

                    <!-- جزء التنقل بين الصفحات -->
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm mb-0">
                            <!-- زر الانتقال إلى أول صفحة -->
                            <?php if($credits->onFirstPage()): ?>
                                <li class="page-item disabled">
                                    <span class="page-link border-0 rounded-pill" aria-label="First">
                                        <i class="fas fa-angle-double-right"></i>
                                    </span>
                                </li>
                            <?php else: ?>
                                <li class="page-item">
                                    <a class="page-link border-0 rounded-pill" href="<?php echo e($CreditNotes->url(1)); ?>" aria-label="First">
                                        <i class="fas fa-angle-double-right"></i>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- زر الانتقال إلى الصفحة السابقة -->
                            <?php if($credits->onFirstPage()): ?>
                                <li class="page-item disabled">
                                    <span class="page-link border-0 rounded-pill" aria-label="Previous">
                                        <i class="fas fa-angle-right"></i>
                                    </span>
                                </li>
                            <?php else: ?>
                                <li class="page-item">
                                    <a class="page-link border-0 rounded-pill" href="<?php echo e($credits->previousPageUrl()); ?>" aria-label="Previous">
                                        <i class="fas fa-angle-right"></i>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- عرض رقم الصفحة الحالية -->
                            <li class="page-item">
                                <span class="page-link border-0 bg-light rounded-pill px-3">
                                    صفحة <?php echo e($credits->currentPage()); ?> من <?php echo e($credits->lastPage()); ?>

                                </span>
                            </li>

                            <!-- زر الانتقال إلى الصفحة التالية -->
                            <?php if($credits->hasMorePages()): ?>
                                <li class="page-item">
                                    <a class="page-link border-0 rounded-pill" href="<?php echo e($credits->nextPageUrl()); ?>" aria-label="Next">
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
                            <?php if($credits->hasMorePages()): ?>
                                <li class="page-item">
                                    <a class="page-link border-0 rounded-pill" href="<?php echo e($credits->url($credits->lastPage())); ?>" aria-label="Last">
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
                <form   id="searchForm"  action="<?php echo e(route('CreditNotes.index')); ?>" method="GET" class="form">
                    <div class="row g-3">
                        <!-- 1. العميل -->
                        <div class="col-md-4">
                            <label for="client_id">العميل</label>
                            <select name="client_id" class="form-control select2" id="client_id">
                                <option value="">اي العميل</option>
                                <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($client->id); ?>" <?php echo e(request('client_id') == $client->id ? 'selected' : ''); ?>>
                                        <?php echo e($client->trade_name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- 2. رقم الإشعار -->
                        <div class="col-md-4">
                            <label for="invoice_number">رقم الإشعار</label>
                            <input type="text" id="invoice_number" class="form-control"
                                placeholder="رقم الإشعار" name="invoice_number" value="<?php echo e(request('invoice_number')); ?>">
                        </div>
                    </div>

                    <!-- البحث المتقدم -->
                    <div class="collapse <?php echo e(request()->hasAny(['item_search', 'currency', 'total_from', 'total_to', 'date_type_1', 'date_type_2', 'source', 'custom_field', 'created_by', 'shipping_option', 'post_shift', 'order_source']) ? 'show' : ''); ?>" id="advancedSearchForm">
                        <div class="row g-3 mt-2">
                            <!-- 3. تحتوي على البند -->
                            <div class="col-md-4">
                                <label for="item_search">تحتوي على البند</label>
                                <input type="text" id="item_search" class="form-control"
                                    placeholder="تحتوي على البند" name="item_search" value="<?php echo e(request('item_search')); ?>">
                            </div>

                            <!-- 4. العملة -->
                            <div class="col-md-4">
                                <label for="currency">العملة</label>
                                <select name="currency" class="form-control" id="currency">
                                    <option value="">العملة</option>
                                    <option value="SAR" <?php echo e(request('currency') == 'SAR' ? 'selected' : ''); ?>> <img src="' . asset('assets/images/Saudi_Riyal.svg') . '" alt="ريال سعودي" width="15" style="vertical-align: middle;"></option>
                                    <option value="USD" <?php echo e(request('currency') == 'USD' ? 'selected' : ''); ?>>دولار أمريكي</option>
                                </select>
                            </div>

                            <!-- 5. الإجمالي أكبر من -->
                            <div class="col-md-2">
                                <label for="total_from">الإجمالي أكبر من</label>
                                <input type="number" id="total_from" class="form-control" step="0.01"
                                    placeholder="الإجمالي أكبر من" name="total_from" value="<?php echo e(request('total_from')); ?>">
                            </div>

                            <!-- 6. الإجمالي أصغر من -->
                            <div class="col-md-2">
                                <label for="total_to">الإجمالي أصغر من</label>
                                <input type="number" id="total_to" class="form-control" step="0.01"
                                    placeholder="الإجمالي أصغر من" name="total_to" value="<?php echo e(request('total_to')); ?>">
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <!-- 7. تخصيص -->
                            <div class="col-md-2">
                                <label for="date_type_1">تخصيص</label>
                                <select name="date_type_1" class="form-control" id="date_type_1">
                                    <option value="">تخصيص</option>
                                    <option value="monthly" <?php echo e(request('date_type_1') == 'monthly' ? 'selected' : ''); ?>>شهرياً</option>
                                    <option value="weekly" <?php echo e(request('date_type_1') == 'weekly' ? 'selected' : ''); ?>>أسبوعياً</option>
                                    <option value="daily" <?php echo e(request('date_type_1') == 'daily' ? 'selected' : ''); ?>>يومياً</option>
                                </select>
                            </div>

                            <!-- 8. تاريخ الإنشاء (من) -->
                            <div class="col-md-2">
                                <label for="from_date_1">تاريخ الإنشاء (من)</label>
                                <input type="date" id="from_date_1" class="form-control"
                                    name="from_date_1" value="<?php echo e(request('from_date_1')); ?>">
                            </div>

                            <!-- 9. تاريخ الإنشاء (إلى) -->
                            <div class="col-md-2">
                                <label for="to_date_1">تاريخ الإنشاء (إلى)</label>
                                <input type="date" id="to_date_1" class="form-control"
                                    name="to_date_1" value="<?php echo e(request('to_date_1')); ?>">
                            </div>

                            <!-- 10. تخصيص آخر -->
                            <div class="col-md-2">
                                <label for="date_type_2">تخصيص</label>
                                <select name="date_type_2" class="form-control" id="date_type_2">
                                    <option value="">تخصيص</option>
                                    <option value="monthly" <?php echo e(request('date_type_2') == 'monthly' ? 'selected' : ''); ?>>شهرياً</option>
                                    <option value="weekly" <?php echo e(request('date_type_2') == 'weekly' ? 'selected' : ''); ?>>أسبوعياً</option>
                                    <option value="daily" <?php echo e(request('date_type_2') == 'daily' ? 'selected' : ''); ?>>يومياً</option>
                                </select>
                            </div>

                            <!-- 11. تاريخ الاستحقاق (من) -->
                            <div class="col-md-2">
                                <label for="from_date_2">تاريخ الاستحقاق (من)</label>
                                <input type="date" id="from_date_2" class="form-control"
                                    name="from_date_2" value="<?php echo e(request('from_date_2')); ?>">
                            </div>

                            <!-- 12. تاريخ الاستحقاق (إلى) -->
                            <div class="col-md-2">
                                <label for="to_date_2">تاريخ الاستحقاق (إلى)</label>
                                <input type="date" id="to_date_2" class="form-control"
                                    name="to_date_2" value="<?php echo e(request('to_date_2')); ?>">
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <!-- 13. المصدر -->
                            <div class="col-md-4">
                                <label for="source">المصدر</label>
                                <select name="source" class="form-control" id="source">
                                    <option value="">المصدر</option>
                                    <option value="1" <?php echo e(request('source') == '1' ? 'selected' : ''); ?>>مدفوعة</option>
                                    <option value="0" <?php echo e(request('source') == '0' ? 'selected' : ''); ?>>غير مدفوعة</option>
                                </select>
                            </div>

                            <!-- 14. حقل مخصص -->
                            <div class="col-md-4">
                                <label for="custom_field">حقل مخصص</label>
                                <input type="text" id="custom_field" class="form-control"
                                    placeholder="حقل مخصص" name="custom_field" value="<?php echo e(request('custom_field')); ?>">
                            </div>

                            <!-- 15. أضيفت بواسطة -->
                            <div class="col-md-4">
                                <label for="created_by">أضيفت بواسطة</label>
                                <select name="created_by" class="form-control select2" id="created_by">
                                    <option value="">اختر المستخدم</option>
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($user->id); ?>" <?php echo e(request('created_by') == $user->id ? 'selected' : ''); ?>>
                                            <?php echo e($user->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <!-- 16. خيارات الشحن -->
                            <div class="col-md-4">
                                <label for="shipping_option">خيارات الشحن</label>
                                <select name="shipping_option" class="form-control" id="shipping_option">
                                    <option value="">خيارات الشحن</option>
                                    <option value="1" <?php echo e(request('shipping_option') == '1' ? 'selected' : ''); ?>>الكل</option>
                                </select>
                            </div>

                            <!-- 17. Post Shift -->
                            <div class="col-md-4">
                                <label for="post_shift">Post Shift</label>
                                <input type="text" id="post_shift" class="form-control"
                                    placeholder="post shift" name="post_shift" value="<?php echo e(request('post_shift')); ?>">
                            </div>

                            <!-- 18. مصدر الطلب -->
                            <div class="col-md-4">
                                <label for="order_source">مصدر الطلب</label>
                                <select name="order_source" class="form-control" id="order_source">
                                    <option value="">مصدر الطلب</option>
                                    <option value="1" <?php echo e(request('order_source') == '1' ? 'selected' : ''); ?>>الكل</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- الأزرار -->
                    <div class="form-actions mt-2">
                        <button type="submit" class="btn btn-primary">بحث</button>
                        <a href="<?php echo e(route('CreditNotes.index')); ?>" type="reset" class="btn btn-outline-warning">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <!-- قائمة الاشعارات الدائنة -->
            <?php $__currentLoopData = $credits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $credit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card-body">
                    <div class="row border-bottom py-2 align-items-center">
                        <!-- معلومات الاشعار الدائن -->
                        <div class="col-md-4">
                            <p class="mb-0">
                                <strong>#<?php echo e($credit->credit_number); ?></strong>
                            </p>
                            <small class="text-muted">
                                <i class="fas fa-user me-1"></i>
                                <?php echo e($credit->client ? ($credit->client->trade_name ?: $credit->client->first_name . ' ' . $credit->client->last_name) : 'عميل غير معروف'); ?>


                                الرقم الضريبي
                                <?php if($credit->client && $credit->client->tax_number): ?>
                                    <i class="fas fa- me-1"></i><?php echo e($credit->client->tax_number); ?>

                                <?php endif; ?>
                            </small>
                            <small class="d-block">
                                <?php if($credit->client && $credit->client->full_address): ?>
                                    <i class="fas fa-map-marker-alt me-1"></i><?php echo e($credit->client->full_address); ?>

                                <?php endif; ?>
                            </small>
                            <small class="text-muted">
                                <i class="fas fa-user-tie me-1"></i> بواسطة:
                                <?php echo e($credit->createdBy->name ?? 'غير محدد'); ?>

                            </small>
                            <p class="mb-0 text-muted">
                                <i class="fas fa-mobile-alt me-1"></i> المصدر: تطبيق الهاتف المحمول
                            </p>
                        </div>

                        <!-- تاريخ الاشعار الدائن -->
                        <div class="col-md-3">
                            <p class="mb-0">
                                <i class="fas fa-calendar-alt me-1"></i>
                                <?php echo e($credit->credit_date ? $credit->credit_date : '--'); ?>

                            </p>
                            <small class="text-muted">
                                <i class="fas fa-user me-1"></i> بواسطة:
                                <?php echo e($credit->createdBy->name ?? 'غير محدد'); ?>

                            </small>
                        </div>
                                        <?php
                                            $currency = $account_setting->currency ?? 'SAR';
                                            $currencySymbol = $currency == 'SAR' || empty($currency) ? '<img src="' . asset('assets/images/Saudi_Riyal.svg') . '" alt="ريال سعودي" width="15" style="vertical-align: middle;">' : $currency;
                                        ?>
                        <!-- المبلغ وحالة الاشعار -->
                        <div class="col-md-3 text-center">
                            <!-- عرض المبلغ الإجمالي -->
                            <div class="mb-2">
                                <strong class="text-danger fs-2 d-block">
                                    <?php echo e(number_format($credit->grand_total, 2)); ?>

                                    <small class="currency"><?php echo $currencySymbol; ?></small>
                                </strong>

                                <!-- عرض حالة الاشعار مع تغيير اللون بناءً على الحالة -->
                                <?php
                                    $statusClass = '';
                                    $statusText = '';

                                    switch ($credit->status) {
                                        case 1:
                                            $statusClass = 'bg-success';
                                            $statusText = 'مسودة';
                                            break;
                                        case 2:
                                            $statusClass = 'bg-warning';
                                            $statusText = 'قيد الانتظار';
                                            break;
                                        case 3:
                                            $statusClass = 'bg-primary';
                                            $statusText = 'معتمد';
                                            break;
                                        case 4:
                                            $statusClass = 'bg-info';
                                            $statusText = 'تم التحويل إلى فاتورة';
                                            break;
                                        case 5:
                                            $statusClass = 'bg-danger';
                                            $statusText = 'ملغى';
                                            break;
                                        default:
                                            $statusClass = 'bg-secondary';
                                            $statusText = 'غير معروف';
                                    }
                                ?>

                                <!-- عرض حالة الاشعار -->
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
                                        id="dropdownMenuButton<?php echo e($credit->id); ?>" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton<?php echo e($credit->id); ?>">
                                        <a class="dropdown-item" href="<?php echo e(route('CreditNotes.edit', $credit->id)); ?>">
                                            <i class="fa fa-edit me-2 text-success"></i>تعديل
                                        </a>
                                        <a class="dropdown-item" href="<?php echo e(route('CreditNotes.show', $credit->id)); ?>">
                                            <i class="fa fa-eye me-2 text-primary"></i>عرض
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            <i class="fa fa-money-bill me-2 text-success"></i>إضافة دفعة
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            <i class="fa fa-file-pdf me-2 text-danger"></i>PDF
                                        </a>
                                        <a class="dropdown-item" href="<?php echo e(route('CreditNotes.print', $credit->id)); ?>" target="_blank">
                                            <i class="fa fa-print me-2 text-dark"></i>طباعة
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            <i class="fa fa-envelope me-2 text-warning"></i>إرسال إلى العميل
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            <i class="fa fa-copy me-2 text-secondary"></i>نسخ
                                        </a>
                                        <form action="<?php echo e(route('CreditNotes.destroy', $credit->id)); ?>" method="POST"
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

            <!-- إذا لم تكن هناك اشعارات دائنة -->
            <?php if($credits->isEmpty()): ?>
                <div class="alert alert-warning" role="alert">
                    <p class="mb-0"><i class="fas fa-exclamation-circle me-2"></i>لا توجد اشعارات دائنة</p>
                </div>
            <?php endif; ?>
        </div>





    </div>




<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>

<script src="<?php echo e(asset('assets/js/search.js')); ?>"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/sales/creted_note/index.blade.php ENDPATH**/ ?>