<?php $__env->startSection('title'); ?>
    ادارة مرتجعات  الشراء
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2"></i>
                <strong><?php echo e(session('success')); ?></strong>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">ادارة مرتجعات الشراء</h2>
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

    <div class="content-body">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">

                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item">
                                    <button class="btn btn-sm btn-outline-secondary px-2" aria-label="Previous">
                                        <i class="fa fa-angle-right"></i>
                                    </button>
                                </li>
                                <li class="page-item mx-2">
                                    <span class="text-muted">صفحة 1 من 1</span>
                                </li>
                                <li class="page-item">
                                    <button class="btn btn-sm btn-outline-secondary px-2" aria-label="Next">
                                        <i class="fa fa-angle-left"></i>
                                    </button>
                                </li>
                            </ul>
                        </nav>

                        <span class="text-muted mx-2">1-1 من 1</span>

                        <a href="<?php echo e(route('ReturnsInvoice.create')); ?>" class="btn btn-success">
                            <i class="fa fa-plus me-1"></i>
                            اضف مرتجع  شراء
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center p-2">
                <div class="d-flex gap-2">
                    <span class="hide-button-text">بحث وتصفية</span>
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
                <form class="form" id="searchForm" method="GET" action="<?php echo e(route('invoicePurchases.index')); ?>">
                    <div class="row g-3">
                        <!-- الحقول الأساسية -->
                        <div class="col-md-4">
                            <select name="employee_search" class="form-control">
                                <option value="">البحث بواسطة إسم المورد أو الرقم التعريفي</option>
                                <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($supplier->id); ?>" <?php echo e(request('employee_search') == $supplier->id ? 'selected' : ''); ?>>
                                        <?php echo e($supplier->trade_name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <input type="text" name="number_invoice" class="form-control"
                                   placeholder="رقم الفاتورة" value="<?php echo e(request('number_invoice')); ?>">
                        </div>

                        <div class="col-md-4">
                            <select name="status" class="form-control">
                                <option value="">الحالة</option>
                                <option value="1" <?php echo e(request('status') == '1' ? 'selected' : ''); ?>>نشط</option>
                                <option value="0" <?php echo e(request('status') == '0' ? 'selected' : ''); ?>>غير نشط</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <select name="payment_status" class="form-control">
                                <option value="">اختر حالة الدفع</option>
                                <option value="paid" <?php echo e(request('payment_status') == 'paid' ? 'selected' : ''); ?>>مدفوع</option>
                                <option value="partial" <?php echo e(request('payment_status') == 'partial' ? 'selected' : ''); ?>>مدفوع جزئيا</option>
                                <option value="unpaid" <?php echo e(request('payment_status') == 'unpaid' ? 'selected' : ''); ?>>غير مدفوع</option>
                                <option value="returned" <?php echo e(request('payment_status') == 'returned' ? 'selected' : ''); ?>>مرتجع</option>
                                <option value="overpaid" <?php echo e(request('payment_status') == 'overpaid' ? 'selected' : ''); ?>>مدفوعة بالزيادة</option>
                                <option value="draft" <?php echo e(request('payment_status') == 'draft' ? 'selected' : ''); ?>>مسودة</option>
                            </select>
                        </div>

                        <div class="col-md-4 advanced-field" style="display: none;">
                            <select name="created_by" class="form-control">
                                <option value="">اضيفت بواسطة</option>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($user->id); ?>" <?php echo e(request('created_by') == $user->id ? 'selected' : ''); ?>>
                                        <?php echo e($user->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-4 advanced-field" style="display: none;">
                            <select name="tag" class="form-control">
                                <option value="">اختر الوسم</option>
                                <?php $__currentLoopData = $tags ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($tag->id); ?>" <?php echo e(request('tag') == $tag->id ? 'selected' : ''); ?>>
                                        <?php echo e($tag->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <!-- حقول البحث المتقدم -->
                    <div class="collapse" id="advancedSearchForm">
                        <div class="row g-3 mt-2">
                            <div class="col-md-4">
                                <input type="text" name="contract" class="form-control"
                                       placeholder="حقل مخصص" value="<?php echo e(request('contract')); ?>">
                            </div>

                            <div class="col-md-4">
                                <input type="text" name="description" class="form-control"
                                       placeholder="تحتوي على البند" value="<?php echo e(request('description')); ?>">
                            </div>

                            <div class="col-md-4">
                                <select name="source" class="form-control">
                                    <option value="">إختر المصدر</option>
                                    <option value="invoice" <?php echo e(request('source') == 'invoice' ? 'selected' : ''); ?>>فاتورة</option>
                                    <option value="return" <?php echo e(request('source') == 'return' ? 'selected' : ''); ?>>المرتجع</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <select name="delivery_status" class="form-control">
                                    <option value="">حالة التسليم</option>
                                    <option value="received" <?php echo e(request('delivery_status') == 'received' ? 'selected' : ''); ?>>مستلم</option>
                                    <option value="rejected" <?php echo e(request('delivery_status') == 'rejected' ? 'selected' : ''); ?>>مرفوض</option>
                                    <option value="pending" <?php echo e(request('delivery_status') == 'pending' ? 'selected' : ''); ?>>تحت التسليم</option>
                                    <option value="partial_rejected" <?php echo e(request('delivery_status') == 'partial_rejected' ? 'selected' : ''); ?>>مرفوض جزئيا</option>
                                    <option value="partial_received" <?php echo e(request('delivery_status') == 'partial_received' ? 'selected' : ''); ?>>مستلم جزئيا</option>
                                    <option value="not_received" <?php echo e(request('delivery_status') == 'not_received' ? 'selected' : ''); ?>>لم يستلم</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <input type="date" name="start_date_from" class="form-control"
                                       value="<?php echo e(request('start_date_from')); ?>" placeholder="التاريخ من">
                            </div>

                            <div class="col-md-4">
                                <input type="date" name="start_date_to" class="form-control"
                                       value="<?php echo e(request('start_date_to')); ?>" placeholder="التاريخ الى">
                            </div>

                            <div class="col-md-4">
                                <input type="date" name="created_at_from" class="form-control"
                                       value="<?php echo e(request('created_at_from')); ?>" placeholder="تاريخ الانشاء من">
                            </div>

                            <div class="col-md-4">
                                <input type="date" name="created_at_to" class="form-control"
                                       value="<?php echo e(request('created_at_to')); ?>" placeholder="تاريخ الانشاء الى">
                            </div>
                        </div>
                    </div>

                    <div class="form-actions mt-2">
                        <button type="submit" class="btn btn-primary">بحث</button>
                        <a href="<?php echo e(route('invoicePurchases.index')); ?>" class="btn btn-outline-warning">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <?php if($invoices->count() > 0): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 5%">
                                    <input type="checkbox" class="form-check-input" id="selectAll">
                                </th>
                                <th>رقم المرتجع</th>
                                <th>المورد</th>
                                <th>التاريخ</th>
                                <th>طريقة الدفع</th>
                                <th>المبلغ الإجمالي</th>
                                <th>حالة الدفع</th>
                                <th>حالة المرتجع</th>
                                <th style="width: 10%">خيارات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input order-checkbox"
                                            value="<?php echo e($invoice->id); ?>">
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar me-2" style="background-color: #E74C3C">
                                                <span class="avatar-content">R</span>
                                            </div>
                                            <div>
                                                <?php echo e($invoice->code); ?>

                                                <div class="text-muted small">#<?php echo e($invoice->id); ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo e($invoice->supplier->trade_name ?? 'غير محدد'); ?></td>
                                    <td><?php echo e(\Carbon\Carbon::parse($invoice->date)->format('Y-m-d')); ?></td>
                                    <td>
                                        <?php switch($invoice->payment_method):
                                            case (1): ?>
                                                <span class="badge bg-success">نقدي</span>
                                                <?php break; ?>
                                            <?php case (2): ?>
                                                <span class="badge bg-warning">آجل</span>
                                                <?php break; ?>
                                            <?php default: ?>
                                                <span class="badge bg-secondary">غير محدد</span>
                                        <?php endswitch; ?>
                                    </td>
                                     <?php
                                            $currency = $account_setting->currency ?? 'SAR';
                                            $currencySymbol = $currency == 'SAR' || empty($currency) ? '<img src="' . asset('assets/images/Saudi_Riyal.svg') . '" alt="ريال سعودي" width="15" style="vertical-align: middle;">' : $currency;
                                        ?>
                                    <td><?php echo e(number_format($invoice->grand_total, 2)); ?> <?php echo $currencySymbol; ?></td>
                                    <td>
                                        <?php if($invoice->is_paid): ?>
                                            <span class="badge bg-success">تم التسوية</span>
                                        <?php elseif($invoice->advance_payment > 0): ?>
                                            <span class="badge bg-warning">تسوية جزئية</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">غير مسوى</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php switch($invoice->status):
                                            case (1): ?>
                                                <span class="badge bg-success">مكتمل</span>
                                                <?php break; ?>
                                            <?php case (2): ?>
                                                <span class="badge bg-warning">قيد المراجعة</span>
                                                <?php break; ?>
                                            <?php case (3): ?>
                                                <span class="badge bg-info">قيد التنفيذ</span>
                                                <?php break; ?>
                                            <?php case (4): ?>
                                                <span class="badge bg-danger">مرفوض</span>
                                                <?php break; ?>
                                            <?php default: ?>
                                                <span class="badge bg-secondary">غير محدد</span>
                                        <?php endswitch; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <div class="dropdown">
                                                <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1 btn-sm"
                                                    type="button" id="dropdownMenuButton<?php echo e($invoice->id); ?>"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end"
                                                    aria-labelledby="dropdownMenuButton<?php echo e($invoice->id); ?>">
                                                    <a class="dropdown-item"
                                                        href="<?php echo e(route('ReturnsInvoice.show', $invoice->id)); ?>">
                                                        <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                    </a>
                                                    <a class="dropdown-item"
                                                        href="<?php echo e(route('ReturnsInvoice.edit', $invoice->id)); ?>">
                                                        <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                    </a>
                                                    <a class="dropdown-item" href="" target="_blank">
                                                        <i class="fa fa-print me-2 text-info"></i>طباعة
                                                    </a>
                                                    <a class="dropdown-item text-danger" href="#"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal<?php echo e($invoice->id); ?>">
                                                        <i class="fa fa-trash me-2"></i>حذف
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal delete -->
                                        <div class="modal fade" id="deleteModal<?php echo e($invoice->id); ?>" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title">حذف مرتجع المشتريات</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>هل أنت متأكد من حذف مرتجع المشتريات رقم
                                                            "<?php echo e($invoice->code); ?>"؟</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light"
                                                            data-bs-dismiss="modal">إلغاء</button>
                                                        <form
                                                            action="<?php echo e(route('ReturnsInvoice.destroy', $invoice->id)); ?>"
                                                            method="POST" class="d-inline">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                            <button type="submit" class="btn btn-danger">حذف</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>

                    <div class="mt-3">
                        <?php echo e($invoices->links()); ?>

                    </div>
                <?php else: ?>
                    <div class="alert alert-info text-center" role="alert">
                        <p class="mb-0">لا يوجد مرتجعات مشتريات مضافة حتى الآن</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>


    <?php $__env->stopSection(); ?>

    <?php $__env->startSection('css'); ?>
        <style>
            .col-md-1-5 {
                flex: 0 0 12.5%;
                max-width: 12.5%;
                padding-right: 15px;
                padding-left: 15px;
            }

            .form-control {
                margin-bottom: 10px;
            }
        </style>
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('scripts'); ?>
        <script>
            function toggleSearchText(button) {
                const buttonText = button.querySelector('.button-text');
                const advancedFields = document.querySelectorAll('.advanced-field');

                if (buttonText.textContent.trim() === 'متقدم') {
                    buttonText.textContent = 'بحث بسيط';
                    advancedFields.forEach(field => field.style.display = 'block');
                } else {
                    buttonText.textContent = 'متقدم';
                    advancedFields.forEach(field => field.style.display = 'none');
                }
            }

            function toggleSearchFields(button) {
                const searchForm = document.getElementById('searchForm');
                const buttonText = button.querySelector('.hide-button-text');
                const icon = button.querySelector('i');

                if (buttonText.textContent === 'اخفاء') {
                    searchForm.style.display = 'none';
                    buttonText.textContent = 'اظهار';
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-eye');
                } else {
                    searchForm.style.display = 'block';
                    buttonText.textContent = 'اخفاء';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-times');
                }
            }
        </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/Purchases/Returns/index.blade.php ENDPATH**/ ?>