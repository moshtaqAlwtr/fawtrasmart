<?php $__env->startSection('title'); ?>
    مدفوعات العملاء
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">ادارة مدفوعات العملاء</h2>
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



                    <!-- زر المواعيد -->
                    <a href="<?php echo e(route('appointments.index')); ?>"
                        class="btn btn-outline-primary btn-sm d-flex align-items-center rounded-pill px-3">
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
                            <?php if($payments->onFirstPage()): ?>
                                <li class="page-item disabled">
                                    <span class="page-link border-0 rounded-pill" aria-label="First">
                                        <i class="fas fa-angle-double-right"></i>
                                    </span>
                                </li>
                            <?php else: ?>
                                <li class="page-item">
                                    <a class="page-link border-0 rounded-pill" href="<?php echo e($payments->url(1)); ?>"
                                        aria-label="First">
                                        <i class="fas fa-angle-double-right"></i>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- زر الانتقال إلى الصفحة السابقة -->
                            <?php if($payments->onFirstPage()): ?>
                                <li class="page-item disabled">
                                    <span class="page-link border-0 rounded-pill" aria-label="Previous">
                                        <i class="fas fa-angle-right"></i>
                                    </span>
                                </li>
                            <?php else: ?>
                                <li class="page-item">
                                    <a class="page-link border-0 rounded-pill" href="<?php echo e($payments->previousPageUrl()); ?>"
                                        aria-label="Previous">
                                        <i class="fas fa-angle-right"></i>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- عرض رقم الصفحة الحالية -->
                            <li class="page-item">
                                <span class="page-link border-0 bg-light rounded-pill px-3">
                                    صفحة <?php echo e($payments->currentPage()); ?> من <?php echo e($payments->lastPage()); ?>

                                </span>
                            </li>

                            <!-- زر الانتقال إلى الصفحة التالية -->
                            <?php if($payments->hasMorePages()): ?>
                                <li class="page-item">
                                    <a class="page-link border-0 rounded-pill" href="<?php echo e($payments->nextPageUrl()); ?>"
                                        aria-label="Next">
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
                            <?php if($payments->hasMorePages()): ?>
                                <li class="page-item">
                                    <a class="page-link border-0 rounded-pill"
                                        href="<?php echo e($payments->url($payments->lastPage())); ?>" aria-label="Last">
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
                <form id="searchForm" class="form" method="GET" action="<?php echo e(route('paymentsClient.index')); ?>">
                    <div class="row g-3" id="basicSearchFields">
                        <!-- 1. رقم الفاتورة -->
                        <div class="col-md-4">
                            <label for="invoice_number" class="sr-only">رقم الفاتورة</label>
                            <input type="text" id="invoice_number" class="form-control" placeholder="رقم الفاتورة"
                                name="invoice_number" value="<?php echo e(request('invoice_number')); ?>">
                        </div>

                        <!-- 2. رقم عملية الدفع -->
                        <div class="col-md-4">
                            <label for="payment_number" class="sr-only">رقم عملية الدفع</label>
                            <input type="text" id="payment_number" class="form-control" placeholder="رقم عملية الدفع"
                                name="payment_number" value="<?php echo e(request('payment_number')); ?>">
                        </div>

                        <!-- 3. العميل -->
                        <div class="col-md-4">
                            <select name="customer" class="form-control" id="customer">
                                <option value="">اي العميل</option>
                                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($employee->id); ?>"
                                        <?php echo e(request('customer') == $employee->id ? 'selected' : ''); ?>><?php echo e($employee->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <!-- البحث المتقدم -->
                    <div class="collapse" id="advancedSearchForm">
                        <div class="row g-3 mt-2">
                            <!-- 4. حالة الدفع -->
                            <div class="col-md-4">
                                <select name="payment_status" class="form-control" id="payment_status">
                                    <option value="">حالة الدفع</option>
                                    <option value="1" <?php echo e(request('payment_status') == '1' ? 'selected' : ''); ?>>مدفوعة
                                    </option>
                                    <option value="0" <?php echo e(request('payment_status') == '0' ? 'selected' : ''); ?>>غير
                                        مدفوعة</option>
                                </select>
                            </div>

                            <!-- 5. التخصيص -->
                            <div class="col-md-2">
                                <select name="customization" class="form-control" id="customization">
                                    <option value="">تخصيص</option>
                                    <option value="1" <?php echo e(request('customization') == '1' ? 'selected' : ''); ?>>شهريًا
                                    </option>
                                    <option value="0" <?php echo e(request('customization') == '0' ? 'selected' : ''); ?>>
                                        أسبوعيًا</option>
                                    <option value="2" <?php echo e(request('customization') == '2' ? 'selected' : ''); ?>>يوميًا
                                    </option>
                                </select>
                            </div>

                            <!-- 6. من (التاريخ) -->
                            <div class="col-md-2">
                                <input type="date" id="from_date" class="form-control" placeholder="من"
                                    name="from_date" value="<?php echo e(request('from_date')); ?>">
                            </div>

                            <!-- 7. إلى (التاريخ) -->
                            <div class="col-md-2">
                                <input type="date" id="to_date" class="form-control" placeholder="إلى"
                                    name="to_date" value="<?php echo e(request('to_date')); ?>">
                            </div>

                            <!-- 8. رقم التعريفي -->
                            <div class="col-md-4">
                                <input type="text" id="identifier" class="form-control" placeholder="رقم التعريفي"
                                    name="identifier" value="<?php echo e(request('identifier')); ?>">
                            </div>

                            <!-- 9. رقم معرف التحويل -->
                            <div class="col-md-4">
                                <input type="text" id="transfer_id" class="form-control"
                                    placeholder="رقم معرف التحويل" name="transfer_id"
                                    value="<?php echo e(request('transfer_id')); ?>">
                            </div>

                            <!-- 10. الإجمالي أكبر من -->
                            <div class="col-md-4">
                                <input type="text" id="total_greater_than" class="form-control"
                                    placeholder="الاجمالي اكبر من" name="total_greater_than"
                                    value="<?php echo e(request('total_greater_than')); ?>">
                            </div>

                            <!-- 11. الإجمالي أصغر من -->
                            <div class="col-md-4">
                                <input type="text" id="total_less_than" class="form-control"
                                    placeholder="الاجمالي اصغر من" name="total_less_than"
                                    value="<?php echo e(request('total_less_than')); ?>">
                            </div>

                            <!-- 12. حقل مخصص -->
                            <div class="col-md-4">
                                <input type="text" id="custom_field" class="form-control" placeholder="حقل مخصص"
                                    name="custom_field" value="<?php echo e(request('custom_field')); ?>">
                            </div>

                            <!-- 13. منشأ الفاتورة -->
                            <div class="col-md-4">
                                <select name="invoice_origin" class="form-control" id="invoice_origin">
                                    <option value="">منشأ الفاتورة</option>
                                    <option value="1" <?php echo e(request('invoice_origin') == '1' ? 'selected' : ''); ?>>الكل
                                    </option>
                                </select>
                            </div>

                            <!-- 14. تم التحصيل بواسطة -->
                            <div class="col-md-4">
                                <select name="collected_by" class="form-control" id="collected_by">
                                    <option value="">تم التحصيل بواسطة</option>
                                    <option value="1" <?php echo e(request('collected_by') == '1' ? 'selected' : ''); ?>>الكل
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- الأزرار -->
                    <div class="form-actions mt-2">
                        <button type="submit" class="btn btn-primary">بحث</button>
                        <a class="btn btn-outline-secondary" data-toggle="collapse" href="#advancedSearchForm"
                            role="button">
                            <i class="bi bi-sliders"></i> بحث متقدم
                        </a>
                        <button type="reset" class="btn btn-outline-warning">إلغاء</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <!-- الترويسة -->
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex gap-2 flex-wrap">
                    <button class="btn btn-sm btn-outline-primary">الكل</button>
                    <button class="btn btn-sm btn-outline-success">متأخر</button>
                    <button class="btn btn-sm btn-outline-danger">مستحقة الدفع</button>
                    <button class="btn btn-sm btn-outline-danger">غير مدفوع</button>
                    <button class="btn btn-sm btn-outline-secondary">مسودة</button>
                    <button class="btn btn-sm btn-outline-success">مدفوع بزيادة</button>
                </div>
            </div>

            <!-- بداية الصف -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th width="20%">البيانات الأساسية</th>
                                <th width="15%">العميل</th>
                                <th width="15%">التاريخ والموظف</th>
                                <th width="15%" class="text-center">المبلغ</th>
                                <th width="15%" class="text-center">الحالة</th>
                                <th width="20%" class="text-end">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $payments->where('type', 'client payments'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td style="white-space: normal; word-wrap: break-word; min-width: 200px;">
                                        <div class="d-flex flex-column">
                                            <strong>#<?php echo e($payment->id); ?></strong>

                                            <small class="text-muted">
                                                <?php if($payment->invoice): ?>
                                                    <?php if($payment->invoice->id??''): ?>
                                                        <span class="badge bg-light text-dark">
                                                            <i class="fas fa-file-invoice"></i> عملية دفع من الفاتورة
                                                            #<?php echo e($payment->invoice->code); ?>

                                                        </span>
                                                    <?php else: ?>
                                                        <span class="text-muted">فاتورة غير مرقمة</span>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <span class="text-danger">-- لا توجد فاتورة مرتبطة --</span>
                                                <?php endif; ?>
                                            </small>

                                            <?php if($payment->notes): ?>
                                                <small class="text-muted mt-1" style="white-space: normal;">
                                                    <i class="fas fa-comment-alt"></i> <?php echo e($payment->notes); ?>

                                                </small>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if($payment->invoice->client): ?>
                                            <div class="d-flex flex-column">
                                                <strong><?php echo e($payment->invoice->client->trade_name ?? ''); ?></strong>
                                                <small class="text-muted">
                                                    <i class="fas fa-phone"></i>
                                                    <?php echo e($payment->invoice->client->phone ?? ''); ?>

                                                </small>

                                            </div>
                                        <?php else: ?>
                                            <span class="text-danger">لا يوجد عميل</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <small><i class="fas fa-calendar"></i> <?php echo e($payment->payment_date); ?></small>
                                            <?php if($payment->employee): ?>
                                                <small class="text-muted mt-1">
                                                    <i class="fas fa-user"></i> <?php echo e($payment->employee->name ?? ''); ?>

                                                </small>
                                            <?php endif; ?>
                                            <small class="text-muted mt-1">
                                                <i class="fas fa-clock"></i> <?php echo e($payment->created_at->format('H:i')); ?>

                                            </small>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                            $currency = $account_setting->currency ?? 'SAR';
                                            $currencySymbol =
                                                $currency == 'SAR' || empty($currency)
                                                    ? '<img src="' .
                                                        asset('assets/images/Saudi_Riyal.svg') .
                                                        '" alt="ريال سعودي" width="15" style="vertical-align: middle;">'
                                                    : $currency;
                                        ?>
                                        <h6 class="mb-0 font-weight-bold">
                                            <?php echo e(number_format($payment->amount, 2)); ?> <?php echo $currencySymbol; ?>

                                        </h6>
                                        <small class="text-muted">
                                            <?php echo e($payment->payment_method ?? 'غير محدد'); ?>

                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                            $statusClass = '';
                                            $statusText = '';
                                            $statusIcon = '';

                                            if ($payment->payment_status == 2) {
                                                $statusClass = 'badge-warning';
                                                $statusText = 'غير مكتمل';
                                                $statusIcon = 'fa-clock';
                                            } elseif ($payment->payment_status == 1) {
                                                $statusClass = 'badge-success';
                                                $statusText = 'مكتمل';
                                                $statusIcon = 'fa-check-circle';
                                            } elseif ($payment->payment_status == 4) {
                                                $statusClass = 'badge-info';
                                                $statusText = 'تحت المراجعة';
                                                $statusIcon = 'fa-sync';
                                            } elseif ($payment->payment_status == 5) {
                                                $statusClass = 'badge-danger';
                                                $statusText = 'فاشلة';
                                                $statusIcon = 'fa-times-circle';
                                            } elseif ($payment->payment_status == 3) {
                                                $statusClass = 'badge-secondary';
                                                $statusText = 'مسودة';
                                                $statusIcon = 'fa-file-alt';
                                            } else {
                                                $statusClass = 'badge-light';
                                                $statusText = 'غير معروف';
                                                $statusIcon = 'fa-question-circle';
                                            }
                                        ?>
                                        <span class="badge <?php echo e($statusClass); ?> rounded-pill">
                                            <i class="fas <?php echo e($statusIcon); ?> me-1"></i>
                                            <?php echo e($statusText); ?>

                                        </span>
                                        <?php if($payment->payment_status == 1): ?>
                                            <small class="d-block text-muted mt-1">
                                                <i class="fas fa-check-circle"></i> تم التأكيد
                                            </small>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group">
                                            <div class="dropdown">
                                                <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1 btn-sm"
                                                    type="button"id="dropdownMenuButton303" data-toggle="dropdown"
                                                    aria-haspopup="true"aria-expanded="false"></button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton303">
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="<?php echo e(route('paymentsClient.show', $payment->id)); ?>">
                                                                <i class="fas fa-eye me-2 text-primary"></i>عرض التفاصيل
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="<?php echo e(route('paymentsClient.edit', $payment->id)); ?>">
                                                                <i class="fas fa-edit me-2 text-success"></i>تعديل الدفع
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form
                                                                action="<?php echo e(route('paymentsClient.destroy', $payment->id)); ?>"
                                                                method="POST">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('DELETE'); ?>
                                                                <button type="submit" class="dropdown-item text-danger"
                                                                    onclick="return confirm('هل أنت متأكد من حذف هذه العملية؟')">
                                                                    <i class="fas fa-trash me-2"></i>حذف العملية
                                                                </button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="<?php echo e(route('paymentsClient.rereceipt', ['id' => $payment->id])); ?>?type=a4"
                                                                target="_blank">
                                                                <i class="fas fa-file-pdf me-2 text-warning"></i>إيصال (A4)
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="<?php echo e(route('paymentsClient.rereceipt', ['id' => $payment->id])); ?>?type=thermal"
                                                                target="_blank">
                                                                <i class="fas fa-receipt me-2 text-warning"></i>إيصال
                                                                (حراري)
                                                            </a>
                                                        </li>
                                                        <?php if($payment->client): ?>
                                                            <li>
                                                                <hr class="dropdown-divider">
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="<?php echo e(route('clients.show', $payment->client->id)); ?>">
                                                                    <i class="fas fa-user me-2 text-info"></i>عرض بيانات
                                                                    العميل
                                                                </a>
                                                            </li>
                                                        <?php endif; ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/search.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/sales/payment/index.blade.php ENDPATH**/ ?>