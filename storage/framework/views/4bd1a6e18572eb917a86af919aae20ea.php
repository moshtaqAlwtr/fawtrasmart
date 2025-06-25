<?php $__env->startSection('title'); ?>
    خزائن وحسابات بنكية
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">خزائن وحسابات بنكية</h2>
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
        <div class="card-title p-2">
            <a href="<?php echo e(route('treasury.transferCreate')); ?>" class="btn btn-outline-success btn-sm">
                تحويل <i class="fa fa-reply-all"></i>
            </a>
        </div>

        <div class="content-body">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <strong>
                                <?php if($treasury->type_accont == 0): ?>
                                    <i class="fa fa-archive"></i>
                                <?php else: ?>
                                    <i class="fa fa-bank"></i>
                                <?php endif; ?>
                                <?php echo e($treasury->name); ?>

                            </strong>
                        </div>

                        <div>
                            <?php if($treasury->is_active == 0): ?>
                                <div class="badge badge-pill badge-success">نشط</div>
                            <?php else: ?>
                                <div class="badge badge-pill badge-danger">غير نشط</div>
                            <?php endif; ?>
                        </div>

                        <div>
                            <small>SAR </small> <strong><?php echo e(number_format($treasury->balance, 2)); ?></strong>
                        </div>
                    </div>
                </div>
            </div>

            <?php echo $__env->make('layouts.alerts.error', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php echo $__env->make('layouts.alerts.success', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <div class="card">
                <div class="card-body">
                    <!-- 🔹 التبويبات -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home"
                                role="tab">التفاصيل</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="transactions-tab" data-toggle="tab" href="#transactions"
                                role="tab">معاملات النظام</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="transfers-tab" data-toggle="tab" href="#transfers"
                                role="tab">التحويلات</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="activate-tab" data-toggle="tab" href="#activate" role="tab">سجل
                                النشاطات</a>
                        </li>
                    </ul>


                    <div class="tab-content">
                        <!-- 🔹 تبويب التفاصيل -->
                        <div class="tab-pane fade show active" id="home" role="tabpanel">
                            <div class="card">
                                <div class="card-header"><strong>معلومات الحساب</strong></div>
                                <div class="card-body">
                                    <table class="table">
                                        <tr>
                                            <td><small>الاسم</small> : <strong><?php echo e($treasury->name); ?></strong></td>
                                            <?php if($treasury->type_accont == 1): ?>
                                                <td><small>اسم الحساب البنكي</small> :
                                                    <strong><?php echo e($treasury->name); ?></strong>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                        <tr>
                                            <td><small>النوع</small> : <strong>
                                                    <?php if($treasury->type_accont == 0): ?>
                                                        خزينة
                                                    <?php else: ?>
                                                        حساب بنكي
                                                    <?php endif; ?>
                                                </strong></td>
                                            <td><small>الحالة</small> :
                                                <?php if($treasury->is_active == 0): ?>
                                                    <div class="badge badge-pill badge-success">نشط</div>
                                                <?php else: ?>
                                                    <div class="badge badge-pill badge-danger">غير نشط</div>
                                                <?php endif; ?>
                                            </td>
                                            <td><small>المبلغ</small> : <strong
                                                    style="color: #00CFE8"><?php echo e(number_format($treasury->balance, 2)); ?></strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>الوصف</strong> : <small><?php echo e($treasury->description ?? ''); ?></small>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="transactions" role="tabpanel">
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
                                    <form id="searchForm" action="" method="GET" class="form">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label for="from_date_1">التاريخ من</label>
                                                <input type="date" class="form-control" placeholder="من"
                                                    name="from_date_1" value="<?php echo e(request('from_date_1')); ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="from_date_1">التاريخ الي</label>
                                                <input type="date" class="form-control" placeholder="من"
                                                    name="from_date_1" value="<?php echo e(request('from_date_1')); ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="date_type_2">الحالة</label>
                                                <select name="date_type_2" class="form-control">
                                                    <option value="">الحالة</option>
                                                </select>
                                            </div>


                                        </div>

                                        <!-- البحث المتقدم -->
                                        <div class="collapse <?php echo e(request()->hasAny(['currency', 'total_from', 'total_to', 'date_type_1', 'date_type_2', 'item_search', 'created_by', 'sales_representative']) ? 'show' : ''); ?>"
                                            id="advancedSearchForm">
                                            <div class="row g-3 mt-2">
                                                <!-- 4. العملة -->
                                                <div class="col-md-4">
                                                    <label for="currencySelect">البحث بواسطة فرع </label>
                                                    <select name="currency" class="form-control" id="currencySelect">
                                                        <option value="">اختر الفرع</option>
                                                        <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($branch->id); ?>"
                                                                <?php echo e(request('currency') == $branch->id ? 'selected' : ''); ?>>
                                                                <?php echo e($branch->name); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>

                                                <!-- 5. الإجمالي أكبر من -->
                                                <div class="col-md-4">
                                                    <label for="total_from">المبلغ من</label>
                                                    <input type="number" class="form-control"
                                                        placeholder="الإجمالي أكبر من" name="total_from" step="0.01"
                                                        value="<?php echo e(request('total_from')); ?>">
                                                </div>

                                                <!-- 6. الإجمالي أصغر من -->
                                                <div class="col-md-4">
                                                    <label for="total_to">المبلغ الي</label>
                                                    <input type="number" class="form-control"
                                                        placeholder="الإجمالي أصغر من" name="total_to" step="0.01"
                                                        value="<?php echo e(request('total_to')); ?>">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="date_type_1">البحث بواسطة النوع</label>
                                                    <select name="date_type_1" class="form-control">
                                                        <option value="">اختر النوع</option>
                                                        <option value="">فاتورة</option>
                                                        <option value="">قيد يدوي </option>
                                                        <option value="">فاتورة شراء</option>
                                                        <option value="">اذن مخزني</option>
                                                        <option value="">عمليات مخزون</option>
                                                        <option value="">مدفوعات الفواتير </option>
                                                        <option value="">سندات القبض </option>
                                                        <option value="">مدفوعات المشتريات </option>
                                                        <option value="">فاتورة شراء</option>
                                                        <option value="">post Shift</option>

                                                    </select>
                                                </div>


                                                <!-- 7. الحالة -->
                                            </div>
                                        </div>

                                        <!-- الأزرار -->
                                        <div class="form-actions mt-2">
                                            <button type="submit" class="btn btn-primary">بحث</button>
                                            <a href="" type="reset" class="btn btn-outline-warning">إلغاء</a>
                                        </div>
                                    </form>
                                </div>


                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>العملية</th>
                                            <th>الإيداع</th>
                                            <th>السحب</th>
                                            <th>الرصيد بعد العملية</th>
                                            <th>التاريخ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $operationsPaginator; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $operation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($operation['operation'] ?? '---'); ?></td>
                                                <td><?php echo e(number_format($operation['deposit'] ?? 0, 2)); ?></td>
                                                <td><?php echo e(number_format($operation['withdraw'] ?? 0, 2)); ?></td>
                                                <td><?php echo e(number_format($operation['balance_after'] ?? 0, 2)); ?></td>
                                                <td><?php echo e($operation['date'] ?? '---'); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>

                                <!-- Pagination -->
                                <nav aria-label="Page navigation">
                                    <ul class="pagination pagination-sm mb-0">
                                        <!-- زر الانتقال إلى أول صفحة -->
                                        <?php if($operationsPaginator->onFirstPage()): ?>
                                            <li class="page-item disabled">
                                                <span class="page-link border-0 rounded-pill" aria-label="First">
                                                    <i class="fas fa-angle-double-right"></i>
                                                </span>
                                            </li>
                                        <?php else: ?>
                                            <li class="page-item">
                                                <a class="page-link border-0 rounded-pill"
                                                    href="<?php echo e($operationsPaginator->url(1)); ?>" aria-label="First">
                                                    <i class="fas fa-angle-double-right"></i>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <!-- زر الانتقال إلى الصفحة السابقة -->
                                        <?php if($operationsPaginator->onFirstPage()): ?>
                                            <li class="page-item disabled">
                                                <span class="page-link border-0 rounded-pill" aria-label="Previous">
                                                    <i class="fas fa-angle-right"></i>
                                                </span>
                                            </li>
                                        <?php else: ?>
                                            <li class="page-item">
                                                <a class="page-link border-0 rounded-pill"
                                                    href="<?php echo e($operationsPaginator->previousPageUrl()); ?>"
                                                    aria-label="Previous">
                                                    <i class="fas fa-angle-right"></i>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <!-- عرض رقم الصفحة الحالية -->
                                        <li class="page-item">
                                            <span class="page-link border-0 bg-light rounded-pill px-3">
                                                صفحة <?php echo e($operationsPaginator->currentPage()); ?> من
                                                <?php echo e($operationsPaginator->lastPage()); ?>

                                            </span>
                                        </li>

                                        <!-- زر الانتقال إلى الصفحة التالية -->
                                        <?php if($operationsPaginator->hasMorePages()): ?>
                                            <li class="page-item">
                                                <a class="page-link border-0 rounded-pill"
                                                    href="<?php echo e($operationsPaginator->nextPageUrl()); ?>" aria-label="Next">
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
                                        <?php if($operationsPaginator->hasMorePages()): ?>
                                            <li class="page-item">
                                                <a class="page-link border-0 rounded-pill"
                                                    href="<?php echo e($operationsPaginator->url($operationsPaginator->lastPage())); ?>"
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


                        <div class="tab-pane" id="transfers" role="tabpanel">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center p-2">
                                    <div class="d-flex gap-2">
                                        <span class="hide-button-text">بحث وتصفية</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <button class="btn btn-outline-secondary btn-sm"
                                            onclick="toggleSearchFields(this)">
                                            <i class="fa fa-times"></i>
                                            <span class="hide-button-text">اخفاء</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form class="form" id="searchForm" method="GET"
                                        action="<?php echo e(route('invoices.index')); ?>">
                                        <div class="row g-3">
                                            <!-- 1. التاريخ (من) -->
                                            <div class="col-md-4">
                                                <label for="from_date">form date</label>
                                                <input type="date" id="from_date" class="form-control"
                                                    name="from_date" value="<?php echo e(request('from_date')); ?>">
                                            </div>

                                            <!-- 2. التاريخ (إلى) -->
                                            <div class="col-md-4">
                                                <label for="to_date">التاريخ من</label>
                                                <input type="date" id="to_date" class="form-control" name="to_date"
                                                    value="<?php echo e(request('to_date')); ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="to_date">التاريخ إلى</label>
                                                <input type="date" id="to_date" class="form-control" name="to_date"
                                                    value="<?php echo e(request('to_date')); ?>">
                                            </div>
                                        </div>

                                        <!-- الأزرار -->
                                        <div class="form-actions mt-2">
                                            <button type="submit" class="btn btn-primary">بحث</button>
                                            <a href="" type="reset" class="btn btn-outline-warning">إلغاء</a>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- 🔹 الجدول لعرض التحويلات -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>رقم القيد</th>
                                        <th>التاريخ</th>
                                        <th>من خزينة الى خزينة</th>
                                        <th>المبلغ</th>
                                        <th style="width: 10%">الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $formattedTransfers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transfer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <!-- استخدم $formattedTransfers هنا -->
                                        <tr>
                                            <td><?php echo e($transfer['reference_number'] ?? '---'); ?></td>
                                            <td><?php echo e(\Carbon\Carbon::parse($transfer['date'])->format('d/m/Y')); ?></td>
                                            <td>
                                                <div class="account-flow d-flex justify-content-center align-items-center">
                                                    <?php if($transfer['from_account']): ?>
                                                        <a href="<?php echo e(route('accounts_chart.index', $transfer['from_account']->id)); ?>"
                                                            class="btn btn-outline-primary mx-2">
                                                            <?php echo e($transfer['from_account']->name ?? '---'); ?>

                                                        </a>
                                                        <i class="fas fa-long-arrow-alt-right text-muted mx-2"></i>
                                                    <?php endif; ?>
                                                    <?php if($transfer['to_account']): ?>
                                                        <a href="<?php echo e(route('accounts_chart.index', $transfer['to_account']->id)); ?>"
                                                            class="btn btn-outline-primary mx-2">
                                                            <?php echo e($transfer['to_account']->name ?? '---'); ?>

                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span
                                                        class="font-weight-bold"><?php echo e(number_format($transfer['amount'] ?? 0, 2)); ?></span>
                                                    <small class="text-muted">الرصيد:
                                                        <?php echo e(number_format($transfer['balance_after'] ?? 0, 2)); ?></small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <div class="dropdown">
                                                        <button
                                                            class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1 btn-sm"
                                                            type="button" id="dropdownMenuButton<?php echo e($transfer['id']); ?>"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false"></button>
                                                        <div class="dropdown-menu"
                                                            aria-labelledby="dropdownMenuButton<?php echo e($transfer['id']); ?>">
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="<?php echo e(route('treasury.transferEdit', $transfer['id'])); ?>">
                                                                    <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item text-danger" href="#"
                                                                    data-toggle="modal"
                                                                    data-target="#modal_DELETE_<?php echo e($transfer['id']); ?>">
                                                                    <i class="fa fa-trash me-2"></i>حذف
                                                                </a>
                                                            </li>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- 🔹 تبويب سجل النشاطات -->

                        <div class="tab-pane fade" id="activate" role="tabpanel">
                            <p>سجل النشاطات هنا...</p>
                        </div>

                    </div> <!-- tab-content -->
                </div> <!-- card-body -->
            </div> <!-- card -->
        </div> <!-- content-body -->
    </div> <!-- card -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/search.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/finance/treasury/show.blade.php ENDPATH**/ ?>