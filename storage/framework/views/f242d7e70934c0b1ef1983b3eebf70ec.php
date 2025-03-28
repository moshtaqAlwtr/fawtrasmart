<?php $__env->startSection('title'); ?>
    القيود اليومية
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">القيود اليومية</h2>
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
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <!-- Checkbox لتحديد الكل -->
                <div class="form-check me-3">
                    <input class="form-check-input" type="checkbox" id="selectAll" onclick="toggleSelectAll()">
                </div>

                <!-- زر "قيد جديد" -->
                <a href="<?php echo e(route('journal.create')); ?>"
                    class="btn btn-success btn-sm d-flex align-items-center rounded-pill px-3">
                    <i class="fas fa-plus-circle me-1"></i>قيد جديد
                </a>

                <!-- زر "سجل التعديلات" -->
                <a href="<?php echo e(route('journal.index')); ?>"
                    class="btn btn-outline-primary btn-sm d-flex align-items-center rounded-pill px-3">
                    <i class="fas fa-calendar-alt me-1"></i>سجل التعديلات
                </a>

                <!-- زر "استيراد" -->
                <a href="<?php echo e(route('questions.logsaction')); ?>"
                    class="btn btn-outline-primary btn-sm d-flex align-items-center rounded-pill px-3">
                    <i class="fas fa-cloud-upload-alt me-1"></i>استيراد
                </a>

                <!-- جزء التنقل بين الصفحات -->
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm mb-0">
                        <!-- زر الانتقال إلى أول صفحة -->
                        <?php if($entries->onFirstPage()): ?>
                            <li class="page-item disabled">
                                <span class="page-link border-0 rounded-pill" aria-label="First">
                                    <i class="fas fa-angle-double-right"></i>
                                </span>
                            </li>
                        <?php else: ?>
                            <li class="page-item">
                                <a class="page-link border-0 rounded-pill" href="<?php echo e($entries->url(1)); ?>" aria-label="First">
                                    <i class="fas fa-angle-double-right"></i>
                                </a>
                            </li>
                        <?php endif; ?>

                        <!-- زر الانتقال إلى الصفحة السابقة -->
                        <?php if($entries->onFirstPage()): ?>
                            <li class="page-item disabled">
                                <span class="page-link border-0 rounded-pill" aria-label="Previous">
                                    <i class="fas fa-angle-right"></i>
                                </span>
                            </li>
                        <?php else: ?>
                            <li class="page-item">
                                <a class="page-link border-0 rounded-pill" href="<?php echo e($entries->previousPageUrl()); ?>"
                                    aria-label="Previous">
                                    <i class="fas fa-angle-right"></i>
                                </a>
                            </li>
                        <?php endif; ?>

                        <!-- عرض رقم الصفحة الحالية -->
                        <li class="page-item">
                            <span class="page-link border-0 bg-light rounded-pill px-3">
                                صفحة <?php echo e($entries->currentPage()); ?> من <?php echo e($entries->lastPage()); ?>

                            </span>
                        </li>

                        <!-- زر الانتقال إلى الصفحة التالية -->
                        <?php if($entries->hasMorePages()): ?>
                            <li class="page-item">
                                <a class="page-link border-0 rounded-pill" href="<?php echo e($entries->nextPageUrl()); ?>"
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
                        <?php if($entries->hasMorePages()): ?>
                            <li class="page-item">
                                <a class="page-link border-0 rounded-pill" href="<?php echo e($entries->url($entries->lastPage())); ?>"
                                    aria-label="Last">
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

    <div class="card shadow-sm">
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
            <form id="searchForm" action="<?php echo e(route('journal.index')); ?>" method="GET" class="form">
                <div class="row g-3">
                    <!-- 1. الحساب -->
                    <div class="col-md-4">
                        <label for="accountSelect">الحساب</label>
                        <select name="account_id" class="form-control select2" id="accountSelect">
                            <option value="">اختر الحساب</option>
                            <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($account->id); ?>" <?php echo e(request('account_id') == $account->id ? 'selected' : ''); ?>>
                                    <?php echo e($account->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- 2. الوصف -->
                    <div class="col-md-4">
                        <label for="description">الوصف</label>
                        <input type="text" id="description" class="form-control"
                            placeholder="الوصف" name="description" value="<?php echo e(request('description')); ?>">
                    </div>

                    <!-- 3. التخصيص -->
                    <div class="col-md-4">
                        <label for="date_type">التخصيص</label>
                        <select name="date_type" class="form-control" id="date_type">
                            <option value="">التخصيص</option>
                            <option value="monthly" <?php echo e(request('date_type') == 'monthly' ? 'selected' : ''); ?>>شهرياً</option>
                            <option value="weekly" <?php echo e(request('date_type') == 'weekly' ? 'selected' : ''); ?>>أسبوعياً</option>
                            <option value="daily" <?php echo e(request('date_type') == 'daily' ? 'selected' : ''); ?>>يومياً</option>
                        </select>
                    </div>
                </div>

                <!-- البحث المتقدم -->
                <div class="collapse <?php echo e(request()->hasAny(['total_from', 'total_to', 'from_date', 'to_date', 'created_by', 'cost_center', 'source']) ? 'show' : ''); ?>" id="advancedSearchForm">
                    <div class="row g-3 mt-2">
                        <!-- 4. الإجمالي أكبر من -->
                        <div class="col-md-2">
                            <label for="total_from">الإجمالي أكبر من</label>
                            <input type="number" class="form-control" placeholder="الإجمالي أكبر من"
                                name="total_from" step="0.01" value="<?php echo e(request('total_from')); ?>">
                        </div>

                        <!-- 5. الإجمالي أصغر من -->
                        <div class="col-md-2">
                            <label for="total_to">الإجمالي أصغر من</label>
                            <input type="number" class="form-control" placeholder="الإجمالي أصغر من"
                                name="total_to" step="0.01" value="<?php echo e(request('total_to')); ?>">
                        </div>

                        <!-- 6. التاريخ من -->
                        <div class="col-md-2">
                            <label for="from_date">التاريخ من</label>
                            <input type="date" class="form-control" placeholder="من"
                                name="from_date" value="<?php echo e(request('from_date')); ?>">
                        </div>

                        <!-- 7. التاريخ إلى -->
                        <div class="col-md-2">
                            <label for="to_date">التاريخ إلى</label>
                            <input type="date" class="form-control" placeholder="إلى"
                                name="to_date" value="<?php echo e(request('to_date')); ?>">
                        </div>

                        <!-- 8. أضيفت بواسطة -->
                        <div class="col-md-4">
                            <label for="created_by">أضيفت بواسطة</label>
                            <select name="created_by" class="form-control select2">
                                <option value="">أضيفت بواسطة</option>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($user->id); ?>" <?php echo e(request('created_by') == $user->id ? 'selected' : ''); ?>>
                                        <?php echo e($user->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mt-2">
                        <!-- 9. مركز التكلفة -->
                        <div class="col-md-4">
                            <label for="cost_center">مركز التكلفة</label>
                            <select name="cost_center" class="form-control select2">
                                <option value="">مركز التكلفة</option>
                                <?php $__currentLoopData = $costCenters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $costCent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($costCent->id); ?>" <?php echo e(request('cost_center') == $costCent->id ? 'selected' : ''); ?>>
                                        <?php echo e($costCent->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- 10. حالة القيد -->
                        <div class="col-md-4">
                            <label for="status">حالة القيد</label>
                            <select name="status" class="form-control">
                                <option value="">حالة القيد</option>
                                <option value="1" <?php echo e(request('status') == '1' ? 'selected' : ''); ?>>مدفوع</option>
                                <option value="0" <?php echo e(request('status') == '0' ? 'selected' : ''); ?>>غير مدفوع</option>
                            </select>
                        </div>

                        <!-- 11. المصدر -->
                        <div class="col-md-4">
                            <label for="source">المصدر</label>
                            <select name="source" class="form-control">
                                <option value="">المصدر</option>
                                <option value="invoice">فاتورة</option>
                                <option value="requisition">إذن مخزن</option>
                                <option value="stock_transaction">عملية مخزون</option>
                                <option value="invoice_payment">مدفوعات الفواتير</option>
                                <option value="income">سندات القبض</option>
                                <option value="sales_cost">تكلفة مبيعات الفواتير</option>
                                <option value="refund_receipt">فاتورة مرتجعة</option>
                                <option value="expense">مصروف</option>
                                <option value="stock_transfer">حركة مخزون</option>
                                <option value="purchase_refund">مرتجع مشتريات</option>
                                <option value="asset">أصل</option>
                                <option value="asset_operation">عملية أصل</option>
                                <option value="asset_deprecation">إهلاك الأصل</option>
                                <option value="treasury_transfer">تحويل خزينة</option>
                                <option value="credit_note">إشعار دائن</option>
                                <option value="asset_write_off">شطب الأصول</option>
                                <option value="asset_re_evaluate">إعادة تقدير أصل</option>
                                <option value="asset_sell">بيع أصل</option>
                                <option value="pay_run">مسير الراتب</option>
                                <option value="delivered_pay_cheque">إستلام شيك مدفوع</option>
                                <option value="rejected_pay_cheque">رفض شيك مدفوع</option>
                                <option value="collected_pay_cheque">تحصيل شيك مدفوع</option>
                                <option value="receivable_cheque_received">إستلام شيك</option>
                                <option value="receivable_cheque_deposited">إيداع شيك</option>
                                <option value="receivable_cheque_collected">تحصيل شيك مستلم</option>
                                <option value="receivable_cheque_deposit_collected">تحصيل وديعة شيك</option>
                                <option value="receivable_cheque_reject">رفض شيك مستلم</option>
                                <option value="receivable_cheque_deposit_rejected">رفض وديعة شيك</option>
                                <option value="product_cost_sales">Product Sales Cost</option>
                                <option value="purchase_order_payment">دفع فاتورة الشراء</option>
                                <option value="purchase_order">فاتورة شراء</option>
                                <option value="pos_shift_validate">POS Shift Validation</option>
                                <option value="pos_shift_refund">POS Shift Refund</option>
                                <option value="pos_shift_sales">POS Shift Sales</option>
                                <option value="pos_shift_transaction">POS Shift Transaction</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- الأزرار -->
                <div class="form-actions mt-2">
                    <button type="submit" class="btn btn-primary">بحث</button>
                    <a href="<?php echo e(route('journal.index')); ?>" type="reset" class="btn btn-outline-warning">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body p-0">
            <?php if(count($entries) > 0): ?>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>


                            <th>العملية</th>
                            <th>الحساب</th>

                            <th>التاريخ</th>
                            <th>بواسطة</th>

                            <th>المبلغ</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $entries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <!-- القسم الأيمن - رقم القيد والمبلغ -->



                                <!-- القسم الأوسط - نوع العملية -->
                                <td>
                                    <span class="badge bg-light text-dark"><?php echo e($entry->id ?? 'قيد محاسبي'); ?></span>
                                </td>

                                <!-- القسم الأيمن - الحساب والوصف -->
                                <td>
                                    <?php if($entry->details->count() > 0): ?>
                                        <div class="account-flow d-flex justify-content-center align-items-center">
                                            <?php $__currentLoopData = $entry->details->reverse(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($detail->account && $detail->account->name): ?>
                                                    <a href="<?php echo e(route('accounts_chart.index', $detail->account->id)); ?>"
                                                        class="btn btn-outline-primary mx-2">
                                                        <?php echo e($detail->account->name); ?>

                                                    </a>
                                                    <?php if(!$loop->last): ?>
                                                        <i class="fas fa-long-arrow-alt-left text-muted mx-2"></i>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted">لا توجد تفاصيل</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($entry->date->format('Y-m-d')); ?></td>
                                <td><?php echo e($entry->createdByEmployee->name ?? 'غير محدد'); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo e($entry->status == 1 ? 'success' : 'warning'); ?>">
                                        <?php echo e($entry->status == 1 ? 'معتمد' : 'غير معتمد'); ?>

                                    </span>
                                </td>
                                <td><?php echo e(number_format($entry->details->sum('debit'), 2)); ?> ر.س</td>
                                <!-- الإجراءات -->
                                <td>
                                    <div class="btn-group">
                                        <div class="dropdown">
                                            <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="<?php echo e(route('journal.edit', $entry->id)); ?>">
                                                    <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                </a>
                                                <a class="dropdown-item" href="<?php echo e(route('journal.show', $entry->id)); ?>">
                                                    <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                </a>
                                                <form action="<?php echo e(route('journal.destroy', $entry->id)); ?>" method="POST"
                                                    class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="fa fa-trash me-2"></i>حذف
                                                    </button>
                                                </form>

                                                <a class="dropdown-item" href="">
                                                    <i class="fa fa-edit me-2 text-success"></i>عرض المصدر
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert alert-warning m-3" role="alert">
                    <p class="mb-0">لا توجد قيود محاسبية</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/Accounts/journal/index.blade.php ENDPATH**/ ?>