<?php $__env->startSection('title'); ?>
    ادارة الفواتير المرتجعة
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-start mb-0">الفواتير المرتجعة</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                            <li class="breadcrumb-item active">عرض</li>
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
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <!-- Checkbox لتحديد الكل -->
                        <div class="form-check me-3">
                            <input class="form-check-input" type="checkbox" id="selectAll" onclick="toggleSelectAll()">
                        </div>



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
                                <?php if($return->onFirstPage()): ?>
                                    <li class="page-item disabled">
                                        <span class="page-link border-0 rounded-pill" aria-label="First">
                                            <i class="fas fa-angle-double-right"></i>
                                        </span>
                                    </li>
                                <?php else: ?>
                                    <li class="page-item">
                                        <a class="page-link border-0 rounded-pill" href="<?php echo e($return->url(1)); ?>" aria-label="First">
                                            <i class="fas fa-angle-double-right"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <!-- زر الانتقال إلى الصفحة السابقة -->
                                <?php if($return->onFirstPage()): ?>
                                    <li class="page-item disabled">
                                        <span class="page-link border-0 rounded-pill" aria-label="Previous">
                                            <i class="fas fa-angle-right"></i>
                                        </span>
                                    </li>
                                <?php else: ?>
                                    <li class="page-item">
                                        <a class="page-link border-0 rounded-pill" href="<?php echo e($return->previousPageUrl()); ?>" aria-label="Previous">
                                            <i class="fas fa-angle-right"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <!-- عرض رقم الصفحة الحالية -->
                                <li class="page-item">
                                    <span class="page-link border-0 bg-light rounded-pill px-3">
                                        صفحة <?php echo e($return->currentPage()); ?> من <?php echo e($return->lastPage()); ?>

                                    </span>
                                </li>

                                <!-- زر الانتقال إلى الصفحة التالية -->
                                <?php if($return->hasMorePages()): ?>
                                    <li class="page-item">
                                        <a class="page-link border-0 rounded-pill" href="<?php echo e($return->nextPageUrl()); ?>" aria-label="Next">
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
                                <?php if($return->hasMorePages()): ?>
                                    <li class="page-item">
                                        <a class="page-link border-0 rounded-pill" href="<?php echo e($return->url($return->lastPage())); ?>" aria-label="Last">
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
                    <form id="searchForm" class="form" method="GET" action="<?php echo e(route('invoices.index')); ?>">
                        <div class="row g-3">
                            <!-- 1. العميل -->
                            <div class="col-md-4">
                                <label for="client_id">أي العميل</label>
                                <select name="client_id" class="form-control" id="client_id">
                                    <option value="">أي العميل</option>
                                    <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($client->id); ?>" <?php echo e(request('client_id') == $client->id ? 'selected' : ''); ?>>
                                            <?php echo e($client->first_name); ?> <?php echo e($client->last_name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <!-- 2. رقم الفاتورة -->
                            <div class="col-md-4">
                                <label for="invoice_number">رقم الفاتورة</label>
                                <input type="text" id="invoice_number" class="form-control"
                                    placeholder="رقم الفاتورة" name="invoice_number" value="<?php echo e(request('invoice_number')); ?>">
                            </div>

                            <!-- 3. حالة الفاتورة -->
                            <div class="col-md-4">
                                <label for="status">حالة الفاتورة</label>
                                <select name="status" class="form-control" id="status">
                                    <option value="">الحالة</option>
                                    <option value="1" <?php echo e(request('status') == 1 ? 'selected' : ''); ?>>غير مدفوعة</option>
                                    <option value="2" <?php echo e(request('status') == 2 ? 'selected' : ''); ?>>مدفوعة جزئيًا</option>
                                    <option value="3" <?php echo e(request('status') == 3 ? 'selected' : ''); ?>>مدفوعة بالكامل</option>
                                    <option value="4" <?php echo e(request('status') == 4 ? 'selected' : ''); ?>>مرتجع</option>
                                    <option value="5" <?php echo e(request('status') == 5 ? 'selected' : ''); ?>>مرتجع جزئي</option>
                                    <option value="6" <?php echo e(request('status') == 6 ? 'selected' : ''); ?>>مدفوع بزيادة</option>
                                    <option value="7" <?php echo e(request('status') == 7 ? 'selected' : ''); ?>>مستحقة الدفع</option>
                                </select>
                            </div>
                        </div>

                        <!-- البحث المتقدم -->
                        <div class="collapse" id="advancedSearchForm">
                            <div class="row g-3 mt-2">
                                <!-- 4. البند -->
                                <div class="col-md-4">
                                    <label for="item">البند</label>
                                    <input type="text" id="item" class="form-control"
                                        placeholder="تحتوي على البند" name="item" value="<?php echo e(request('item')); ?>">
                                </div>

                                <!-- 5. العملة -->
                                <div class="col-md-4">
                                    <label for="currency">العملة</label>
                                    <select name="currency" class="form-control" id="currency">
                                        <option value="">العملة</option>
                                        <option value="SAR" <?php echo e(request('currency') == 'SAR' ? 'selected' : ''); ?>>SAR</option>
                                        <option value="USD" <?php echo e(request('currency') == 'USD' ? 'selected' : ''); ?>>USD</option>
                                    </select>
                                </div>

                                <!-- 6. الإجمالي (من) -->
                                <div class="col-md-2">
                                    <label for="total_from">الإجمالي أكبر من</label>
                                    <input type="text" id="total_from" class="form-control"
                                        placeholder="الإجمالي أكبر من" name="total_from" value="<?php echo e(request('total_from')); ?>">
                                </div>

                                <!-- 7. الإجمالي (إلى) -->
                                <div class="col-md-2">
                                    <label for="total_to">الإجمالي أصغر من</label>
                                    <input type="text" id="total_to" class="form-control"
                                        placeholder="الإجمالي أصغر من" name="total_to" value="<?php echo e(request('total_to')); ?>">
                                </div>
                            </div>

                            <!-- 8. حالة الدفع -->
                            <div class="row g-3 mt-2">
                                <div class="col-md-4">
                                    <label for="payment_status">حالة الدفع</label>
                                    <select name="payment_status" class="form-control" id="payment_status">
                                        <option value="">حالة الدفع</option>
                                        <option value="1" <?php echo e(request('payment_status') == 1 ? 'selected' : ''); ?>>غير مدفوعة</option>
                                        <option value="2" <?php echo e(request('payment_status') == 2 ? 'selected' : ''); ?>>مدفوعة جزئيًا</option>
                                        <option value="3" <?php echo e(request('payment_status') == 3 ? 'selected' : ''); ?>>مدفوعة بالكامل</option>
                                    </select>
                                </div>

                                <!-- 9. التخصيص (شهريًا، أسبوعيًا، يوميًا) -->
                                <div class="col-md-2">
                                    <label for="custom_period">التخصيص</label>
                                    <select name="custom_period" class="form-control" id="custom_period">
                                        <option value="">التخصيص</option>
                                        <option value="monthly" <?php echo e(request('custom_period') == 'monthly' ? 'selected' : ''); ?>>شهريًا</option>
                                        <option value="weekly" <?php echo e(request('custom_period') == 'weekly' ? 'selected' : ''); ?>>أسبوعيًا</option>
                                        <option value="daily" <?php echo e(request('custom_period') == 'daily' ? 'selected' : ''); ?>>يوميًا</option>
                                    </select>
                                </div>

                                <!-- 10. التاريخ (من) -->
                                <div class="col-md-3">
                                    <label for="from_date">التاريخ من</label>
                                    <input type="date" id="from_date" class="form-control" name="from_date"
                                        value="<?php echo e(request('from_date')); ?>">
                                </div>

                                <!-- 11. التاريخ (إلى) -->
                                <div class="col-md-3">
                                    <label for="to_date">التاريخ إلى</label>
                                    <input type="date" id="to_date" class="form-control" name="to_date"
                                        value="<?php echo e(request('to_date')); ?>">
                                </div>
                            </div>

                            <!-- 12. تخصيص آخر -->
                            <div class="row g-3 mt-2">
                                <div class="col-md-2">
                                    <label for="custom_period_2">التخصيص</label>
                                    <select name="custom_period_2" class="form-control" id="custom_period_2">
                                        <option value="">التخصيص</option>
                                        <option value="monthly" <?php echo e(request('custom_period_2') == 'monthly' ? 'selected' : ''); ?>>شهريًا</option>
                                        <option value="weekly" <?php echo e(request('custom_period_2') == 'weekly' ? 'selected' : ''); ?>>أسبوعيًا</option>
                                        <option value="daily" <?php echo e(request('custom_period_2') == 'daily' ? 'selected' : ''); ?>>يوميًا</option>
                                    </select>
                                </div>

                                <!-- 13. تاريخ الاستحقاق (من) -->
                                <div class="col-md-3">
                                    <label for="due_date_from">تاريخ الاستحقاق (من)</label>
                                    <input type="date" id="due_date_from" class="form-control"
                                        name="due_date_from" value="<?php echo e(request('due_date_from')); ?>">
                                </div>

                                <!-- 14. تاريخ الاستحقاق (إلى) -->
                                <div class="col-md-3">
                                    <label for="due_date_to">تاريخ الاستحقاق (إلى)</label>
                                    <input type="date" id="due_date_to" class="form-control" name="due_date_to"
                                        value="<?php echo e(request('due_date_to')); ?>">
                                </div>

                                <!-- 15. المصدر -->
                                <div class="col-md-4">
                                    <label for="source">المصدر</label>
                                    <select name="source" class="form-control" id="source">
                                        <option value="">المصدر</option>
                                        <option value="mobile" <?php echo e(request('source') == 'mobile' ? 'selected' : ''); ?>>تطبيق الهاتف</option>
                                        <option value="web" <?php echo e(request('source') == 'web' ? 'selected' : ''); ?>>الويب</option>
                                    </select>
                                </div>
                            </div>

                            <!-- 16. الحقل المخصص -->
                            <div class="row g-3 mt-2">
                                <div class="col-4">
                                    <label for="custom_field">حقل مخصص</label>
                                    <input type="text" id="custom_field" class="form-control"
                                        placeholder="حقل مخصص" name="custom_field" value="<?php echo e(request('custom_field')); ?>">
                                </div>

                                <!-- 17. تخصيص آخر -->
                                <div class="col-md-2">
                                    <label for="custom_period_3">التخصيص</label>
                                    <select name="custom_period_3" class="form-control" id="custom_period_3">
                                        <option value="">التخصيص</option>
                                        <option value="monthly" <?php echo e(request('custom_period_3') == 'monthly' ? 'selected' : ''); ?>>شهريًا</option>
                                        <option value="weekly" <?php echo e(request('custom_period_3') == 'weekly' ? 'selected' : ''); ?>>أسبوعيًا</option>
                                        <option value="daily" <?php echo e(request('custom_period_3') == 'daily' ? 'selected' : ''); ?>>يوميًا</option>
                                    </select>
                                </div>

                                <!-- 18. تاريخ الإنشاء (من) -->
                                <div class="col-3">
                                    <label for="created_at_from">تاريخ الإنشاء (من)</label>
                                    <input type="date" id="created_at_from" class="form-control"
                                        name="created_at_from" value="<?php echo e(request('created_at_from')); ?>">
                                </div>

                                <!-- 19. تاريخ الإنشاء (إلى) -->
                                <div class="col-3">
                                    <label for="created_at_to">تاريخ الإنشاء (إلى)</label>
                                    <input type="date" id="created_at_to" class="form-control"
                                        name="created_at_to" value="<?php echo e(request('created_at_to')); ?>">
                                </div>
                            </div>

                            <!-- 20. حالة التسليم -->
                            <div class="row g-3 mt-2">
                                <div class="col-md-4">
                                    <label for="delivery_status">حالة التسليم</label>
                                    <select name="delivery_status" class="form-control" id="delivery_status">
                                        <option value="">حالة التسليم</option>
                                        <option value="delivered" <?php echo e(request('delivery_status') == 'delivered' ? 'selected' : ''); ?>>تم التسليم</option>
                                        <option value="pending" <?php echo e(request('delivery_status') == 'pending' ? 'selected' : ''); ?>>قيد الانتظار</option>
                                    </select>
                                </div>

                                <!-- 21. أضيفت بواسطة (الموظفين) -->
                                <div class="col-md-4">
                                    <label for="added_by_employee">أضيفت بواسطة (الموظفين)</label>
                                    <select name="added_by_employee" class="form-control" id="added_by_employee">
                                        <option value="">أضيفت بواسطة</option>
                                        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($employee->id); ?>" <?php echo e(request('added_by_employee') == $employee->id ? 'selected' : ''); ?>>
                                                <?php echo e($employee->full_name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <!-- 22. مسؤول المبيعات (المستخدمين) -->
                                <div class="col-md-4">
                                    <label for="sales_person_user">مسؤول المبيعات (المستخدمين)</label>
                                    <select name="sales_person_user" class="form-control" id="sales_person_user">
                                        <option value="">مسؤول المبيعات</option>
                                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($user->id); ?>" <?php echo e(request('sales_person_user') == $user->id ? 'selected' : ''); ?>>
                                                <?php echo e($user->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <!-- 23. Post Shift -->
                            <div class="row g-3 mt-2">
                                <div class="col-md-4">
                                    <label for="post_shift">Post Shift</label>
                                    <input type="text" id="post_shift" class="form-control"
                                        placeholder="Post Shift" name="post_shift" value="<?php echo e(request('post_shift')); ?>">
                                </div>

                                <!-- 24. خيارات الشحن -->
                                <div class="col-md-4">
                                    <label for="shipping_option">خيارات الشحن</label>
                                    <select name="shipping_option" class="form-control" id="shipping_option">
                                        <option value="">خيارات الشحن</option>
                                        <option value="standard" <?php echo e(request('shipping_option') == 'standard' ? 'selected' : ''); ?>>عادي</option>
                                        <option value="express" <?php echo e(request('shipping_option') == 'express' ? 'selected' : ''); ?>>سريع</option>
                                    </select>
                                </div>

                                <!-- 25. مصدر الطلب -->
                                <div class="col-md-4">
                                    <label for="order_source">مصدر الطلب</label>
                                    <select name="order_source" class="form-control" id="order_source">
                                        <option value="">مصدر الطلب</option>
                                        <option value="website" <?php echo e(request('order_source') == 'website' ? 'selected' : ''); ?>>الموقع</option>
                                        <option value="mobile_app" <?php echo e(request('order_source') == 'mobile_app' ? 'selected' : ''); ?>>تطبيق الهاتف</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- الأزرار -->
                        <div class="form-actions mt-2">
                            <button type="submit" class="btn btn-primary">بحث</button>
                            <a class="btn btn-outline-secondary" data-toggle="collapse" href="#advancedSearchForm" role="button">
                                <i class="bi bi-sliders"></i> بحث متقدم
                            </a>
                            <button type="reset" class="btn btn-outline-warning">إلغاء</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <!-- الترويسة -->
                <div class="card-header d-flex justify-content-between align-items-center p-3">
                    <div class="d-flex gap-2 flex-wrap">
                        <button class="btn btn-sm btn-outline-primary <?php echo e(request()->status == null ? 'active' : ''); ?>"
                            onclick="filterInvoices('')">
                            <i class="fas fa-list me-1"></i> الكل
                        </button>
                        <button class="btn btn-sm btn-outline-warning <?php echo e(request()->status == 'late' ? 'active' : ''); ?>"
                            onclick="filterInvoices('late')">
                            <i class="fas fa-clock me-1"></i> متأخر
                        </button>
                        <button class="btn btn-sm btn-outline-info <?php echo e(request()->status == 'due' ? 'active' : ''); ?>"
                            onclick="filterInvoices('due')">
                            <i class="fas fa-calendar-day me-1"></i> مستحقة الدفع
                        </button>
                        <button class="btn btn-sm btn-outline-danger <?php echo e(request()->status == 'unpaid' ? 'active' : ''); ?>"
                            onclick="filterInvoices('unpaid')">
                            <i class="fas fa-times-circle me-1"></i> غير مدفوع
                        </button>
                        <button class="btn btn-sm btn-outline-secondary <?php echo e(request()->status == 'draft' ? 'active' : ''); ?>"
                            onclick="filterInvoices('draft')">
                            <i class="fas fa-file-alt me-1"></i> مسودة
                        </button>
                        <button class="btn btn-sm btn-outline-success <?php echo e(request()->status == 'overpaid' ? 'active' : ''); ?>"
                            onclick="filterInvoices('overpaid')">
                            <i class="fas fa-check-double me-1"></i> مدفوع بزيادة
                        </button>
                    </div>
                </div>

                <!-- قائمة الفواتير -->
                <?php $__currentLoopData = $return; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $retur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($retur->type == 'returned'): ?>
                        <div class="card-body invoice-card">
                            <div class="row border-bottom py-2 align-items-center">
                                <!-- معلومات الفاتورة -->
                                <div class="col-md-4">
                                    <p class="mb-0">
                                        <strong>#<?php echo e($retur->code); ?></strong>
                                    </p>
                                    <small class="text-muted">
                                        <i class="fas fa-user me-1"></i>
                                        <?php echo e($retur->client ? ($retur->client->trade_name ?: $retur->client->first_name . ' ' . $retur->client->last_name) : 'عميل غير معروف'); ?>

                                        <?php if($retur->client && $retur->client->tax_number): ?>
                                            <br><i class="fas fa-hashtag me-1"></i>الرقم الضريبي: <?php echo e($retur->client->tax_number); ?>

                                        <?php endif; ?>
                                    </small>
                                    <?php if($retur->client && $retur->client->full_address): ?>
                                        <small class="d-block">
                                            <i class="fas fa-map-marker-alt me-1"></i><?php echo e($retur->client->full_address); ?>

                                        </small>
                                    <?php endif; ?>
                                </div>

                                <!-- تاريخ الفاتورة -->
                                <div class="col-md-3">
                                    <p class="mb-0">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        <?php echo e($retur->created_at ? $retur->created_at->format('H:i:s d/m/Y') : ''); ?>

                                    </p>
                                    <small class="text-muted">
                                        <i class="fas fa-user me-1"></i> بواسطة:
                                        <?php echo e($retur->createdByUser->name ?? 'غير محدد'); ?>

                                    </small>
                                    <small class="d-block text-muted">
                                        <i class="fas fa-mobile-alt me-1"></i> المصدر: تطبيق الهاتف المحمول
                                    </small>
                                </div>
 <?php
                                            $currency = $account_setting->currency ?? 'SAR';
                                            $currencySymbol = $currency == 'SAR' || empty($currency) ? '<img src="' . asset('assets/images/Saudi_Riyal.svg') . '" alt="ريال سعودي" width="15" style="vertical-align: middle;">' : $currency;
                                        ?>
                                <!-- المبلغ وحالة الدفع -->
                                <div class="col-md-3 text-center">
                                    <h5 class="mb-1 font-weight-bold">
                                        <?php echo e(number_format($retur->grand_total ?? $retur->total, 2)); ?>

                                       <small class="currency"><?php echo $currencySymbol; ?></small>
                                    </h5>

                                    <?php if($retur->due_value > 0): ?>
                                        <small class="d-block mb-2 text-danger">
                                            المبلغ المستحق: <?php echo e(number_format($retur->due_value, 2)); ?> <?php echo $currencySymbol; ?>

                                        </small>
                                    <?php endif; ?>

                                    <?php
                                        $statusClass = '';
                                        $statusText = '';

                                        if ($retur->payment_status == 1) {
                                            $statusClass = 'badge-success';
                                            $statusText = 'مدفوعة بالكامل';
                                        } elseif ($retur->payment_status == 2) {
                                            $statusClass = 'badge-info';
                                            $statusText = 'مدفوعة جزئياً';
                                        } elseif ($retur->payment_status == 3) {
                                            $statusClass = 'badge-danger';
                                            $statusText = 'غير مدفوعة';
                                        } elseif ($retur->payment_status == 4) {
                                            $statusClass = 'badge-secondary';
                                            $statusText = 'مستلمة';
                                        } else {
                                            $statusClass = 'badge-dark';
                                            $statusText = 'غير معروفة';
                                        }
                                    ?>

                                    <span class="badge <?php echo e($statusClass); ?>"><?php echo e($statusText); ?></span>
                                </div>

                                <!-- الأزرار -->
                                <div class="col-md-2 text-end">
                                    <div class="btn-group">
                                        <div class="dropdown">
                                            <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1" type="button"
                                                id="dropdownMenuButton<?php echo e($retur->id); ?>" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="dropdownMenuButton<?php echo e($retur->id); ?>">
                                                <a class="dropdown-item" href="<?php echo e(route('invoices.edit', $retur->id)); ?>">
                                                    <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                </a>
                                                <a class="dropdown-item" href="<?php echo e(route('invoices.show', $retur->id)); ?>">
                                                    <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                </a>
                                                <a class="dropdown-item" href="<?php echo e(route('invoices.generatePdf', $retur->id)); ?>">
                                                    <i class="fa fa-file-pdf me-2 text-danger"></i>PDF
                                                </a>
                                                <a class="dropdown-item" href="<?php echo e(route('invoices.generatePdf', $retur->id)); ?>">
                                                    <i class="fa fa-print me-2 text-dark"></i>طباعة
                                                </a>
                                                <a class="dropdown-item" href="#">
                                                    <i class="fa fa-envelope me-2 text-warning"></i>إرسال إلى العميل
                                                </a>
                                                <a class="dropdown-item"
                                                    href="<?php echo e(route('paymentsClient.create', ['id' => $retur->id])); ?>">
                                                    <i class="fa fa-credit-card me-2 text-info"></i>إضافة عملية دفع
                                                </a>
                                                <a class="dropdown-item" href="#">
                                                    <i class="fa fa-copy me-2 text-secondary"></i>نسخ
                                                </a>
                                                <form action="<?php echo e(route('invoices.destroy', $retur->id)); ?>" method="POST"
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

                            <!-- عمليات الدفع -->
                            <?php
                                $payments = \App\Models\PaymentsProcess::where('invoice_id', $retur->id)
                                    ->where('type', 'client payments')
                                    ->orderBy('created_at', 'desc')
                                    ->get();
                            ?>

                            <?php if($payments->count() > 0): ?>
                                <div class="payment-history mt-2">
                                    <div class="ps-4">
                                        <small class="text-muted mb-2 d-block">
                                            <i class="fas fa-money-bill-wave me-1"></i> عمليات الدفع:
                                        </small>
                                        <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="d-flex align-items-center gap-3 mb-1 payment-item ps-3">
                                                <div class="payment-info">
                                                    <small class="text-muted">
                                                        <i class="fas fa-calendar-alt me-1"></i>
                                                        <?php echo e($payment->created_at->format('H:i:s d/m/Y')); ?>

                                                    </small>
                                                    <span class="mx-2 text-success">

                                                        <?php echo e(number_format($payment->amount, 2)); ?> <?php echo e($retur->currency ?? 'SAR'); ?>

                                                    </span>
                                                    <?php if($payment->attachments): ?>
                                                        <i class="fas fa-paperclip text-muted"></i>
                                                    <?php endif; ?>
                                                    <small class="text-muted">
                                                        <i class="fas fa-user me-1"></i>
                                                        بواسطة:   <?php echo e($retur->createdByUser->name ?? 'غير محدد'); ?>

                                                    </small>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <!-- إذا لم تكن هناك فواتير -->
                <?php if($return->isEmpty()): ?>
                    <div class="alert alert-warning m-3" role="alert">
                        <p class="mb-0"><i class="fas fa-exclamation-circle me-2"></i>لا توجد فواتير</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="<?php echo e(asset('assets/js/search.js')); ?>"></script>

    <script>
        function filterInvoices(status) {
            const currentUrl = new URL(window.location.href);
            if (status) {
                currentUrl.searchParams.set('status', status);
            } else {
                currentUrl.searchParams.delete('status');
            }
            window.location.href = currentUrl.toString();
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/sales/retend_invoice/index.blade.php ENDPATH**/ ?>