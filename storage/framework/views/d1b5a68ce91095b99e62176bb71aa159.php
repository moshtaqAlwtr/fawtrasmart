<?php $__env->startSection('title'); ?>
    عرض الفاتورة
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <style>
        /* تخصيص الأزرار */
        .custom-btn {
            min-width: 120px;
            /* تحديد عرض ثابت للأزرار */
            margin: 5px;
            /* إضافة margin بقيمة 10px بين الأزرار */
            justify-content: center;
            /* توسيط النص والأيقونات داخل الأزرار */
        }

        .custom-dropdown {
            min-width: 200px;
            /* يمكنك تعديل العرض حسب الحاجة */
        }

        /* إصلاح تخطيط الصفحة الرئيسية */
        .tab-content {
            position: relative;
            z-index: 1;
        }

        .pdf-iframe {
            width: 100%;
            height: 800px;
            border: none;
            display: block;
            margin: 0 auto;
        }

        .sidebar {
            position: fixed;
            z-index: 100;
            /* تأكد من وجود هذه الخصائص */
            top: 0;
            right: 0;
            height: 100vh;
            width: 250px;
            /* تعديل حسب عرض السايد بار */
            background: #f8f9fa;
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .invoice-wrapper {
            /* عزل الفاتورة عن تخطيط الصفحة */
            contain: content;
            position: relative;
            z-index: 1;
            width: 100%;
            overflow: visible;
            padding: 20px 0;
        }

        /* إصلاحات نهائية للسايد بار */
        .sidebar {
            position: fixed !important;
            right: 0 !important;
            top: 0 !important;
            bottom: 0 !important;
            transform: none !important;
            margin: 0 !important;
        }

        .main-content {
            transition: none !important;
            transform: none !important;
        }

        .main-content {
            margin-left: 250px;
            /* نفس عرض السايد بار */
            padding: 20px;
            width: calc(100% - 250px);
        }

        /* تحسينات لعرض الفاتورة ضمن التبويب */
        .pdf-wrapper {
            width: 100%;
            overflow-x: auto;
            background: white;
            padding: 20px;
            display: flex;
            justify-content: center;
        }

        /* إصلاح مشكلة الـ RTL */
        [dir="rtl"] .pdf-wrapper {
            direction: rtl;
        }

        /* منع تأثيرات التبويبات على الفاتورة */
        .tab-content>.active {
            overflow: visible !important;
        }

        .custom-dropdown .dropdown-item {
            padding: 0.5rem 1rem;
            /* تعديل الحشوة لتتناسب مع الأزرار */
            font-size: 0.875rem;
            /* حجم الخط */
        }

        .custom-dropdown .dropdown-item:hover {
            background-color: #f8f9fa;
            /* لون الخلفية عند التحويم */
            color: #0056b3;
            /* لون النص عند التحويم */
        }

        /* التأكد من أن الأزرار متساوية في الارتفاع */
        .custom-btn i {
            margin-right: 5px;
            /* إضافة مسافة بين الأيقونة والنص */
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-body">
        <!-- Card 1: Invoice Header -->
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mb-3">
                    <div class="d-flex gap-2 mb-2 mb-sm-0">
                        <span
                            class="badge badge-pill
                            <?php if($invoice->payment_status == 1): ?> badge-success
                            <?php elseif($invoice->payment_status == 2): ?> badge-warning
                            <?php elseif($invoice->payment_status == 3): ?> badge-danger
                            <?php elseif($invoice->payment_status == 4): ?> badge-info <?php endif; ?>">
                            <?php if($invoice->payment_status == 1): ?>
                                مدفوعة
                            <?php elseif($invoice->payment_status == 2): ?>
                                مدفوعة جزئيا
                            <?php elseif($invoice->payment_status == 3): ?>
                                غير مدفوعة
                            <?php elseif($invoice->payment_status == 4): ?>
                                مستلمة
                            <?php endif; ?>
                        </span>
                        <strong>الفاتورة #<?php echo e($invoice->id); ?></strong>
                    </div>
                    <div class="d-flex gap-2">
                        <button onclick="printInvoice('<?php echo e(route('invoices.print', $invoice->id)); ?>')"
                            class="btn btn-primary btn-sm">
                            <i class="fa fa-print"></i> طباعة الفاتورة
                        </button>
                    </div>
                </div>
                <div class="text-center text-sm-start">
                    <span>المستلم: <?php echo e($invoice->client->trade_name ?? ''); ?></span><br>
                    <a href="#">Journal #<?php echo e($invoice->journal_id); ?></a> |
                    <a href="#">تكلفة مبيعات #<?php echo e($invoice->sales_cost_id); ?></a> - <?php echo e($invoice->source); ?>

                </div>
            </div>
        </div>

        <!-- Card 2: Actions -->
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex flex-column flex-sm-row gap-2 justify-content-between align-items-center">
                    <!-- تعديل -->
                    <a href="<?php echo e(route('invoices.edit', $invoice->id)); ?>"
                        class="btn btn-sm btn-outline-danger d-flex align-items-center custom-btn">
                        <i class="fas fa-pen me-1"></i> تعديل
                    </a>

                    <!-- طباعة -->
                    <a href="<?php echo e(route('invoices.print', $invoice->id)); ?>"
                        class="btn btn-sm btn-outline-success d-flex align-items-center custom-btn">
                        <i class="fas fa-print me-1"></i> طباعة
                    </a>

                    <!-- PDF -->
                    <a href="<?php echo e(route('invoices.generatePdf', $invoice->id)); ?>"
                        class="btn btn-sm btn-outline-info d-flex align-items-center custom-btn">
                        <i class="fas fa-file-pdf me-1"></i> PDF
                    </a>

                    <!-- إضافة عملية دفع -->
                    <a href="<?php echo e(route('paymentsClient.create', ['id' => $invoice->id, 'type' => 'invoice'])); ?>"
                        class="btn btn-sm btn-outline-dark d-flex align-items-center custom-btn">
                        <i class="fas fa-wallet me-1"></i> إضافة عملية دفع
                    </a>

                    <!-- قسائم -->
                    <div class="btn-group">
                        <div class="dropdown">
                            <button
                                class="btn btn-sm btn-outline-warning dropdown-toggle d-flex align-items-center custom-btn"
                                type="button" id="dropdownMenuButton200" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="fas fa-tags me-1"></i> القسائم
                            </button>
                            <div class="dropdown-menu custom-dropdown" aria-labelledby="dropdownMenuButton200">
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a href="<?php echo e(route('invoices.label', $invoice->id)); ?>"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-file-pdf me-1"></i> تحميل ملصق الطرد
                                        </a>

                                    <li><a class="dropdown-item" href="<?php echo e(route('invoices.picklist', $invoice->id)); ?>"><i
                                                class="fas fa-list me-1"></i> قائمة
                                            الاستلام</a></li>
                                    <li><a class="dropdown-item"
                                            href="<?php echo e(route('invoices.shipping_label', $invoice->id)); ?>"><i
                                                class="fas fa-truck me-1"></i> ملصق
                                            التوصيل</a></li>

                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- إضافة اتفاقية تقسيط -->
                    <a href="<?php echo e(route('installments.create', ['id' => $invoice->id])); ?>"
                        class="btn btn-sm btn-outline-primary d-flex align-items-center custom-btn">
                        <i class="fas fa-handshake me-1"></i> إضافة اتفاقية تقسيط
                    </a>


                    <div class="btn-group">
                        <div class="dropdown">
                            <button
                                class="btn btn-sm btn-outline-success dropdown-toggle d-flex align-items-center custom-btn"
                                type="button" id="dropdownMenuButton200" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="fas fa me-1"></i> ارسال عبر
                            </button>
                            <div class="dropdown-menu custom-dropdown" aria-labelledby="dropdownMenuButton200">
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center" target="_blank"
                                            href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $invoice->client->phone)); ?>?text=<?php echo e(urlencode(
                                                'مرحبًا ' .
                                                    $invoice->client->trade_name .
                                                    ',' .
                                                    "\n\n" .
                                                    'يسعدنا إعلامكم بأن فاتورتكم أصبحت جاهزة. يمكنكم الاطلاع عليها من خلال الرابط التالي:' .
                                                    "\n" .
                                                    route('invoices.print', ['id' => $invoice->id, 'embed' => true]) .
                                                    "\n\n" .
                                                    'مع أطيب التحيات،' .
                                                    "\n" .
                                                    ($account_setting->trade_name ?? 'مؤسسة أعمال خاصة للتجارة'),
                                            )); ?>">
                                            <i class="fab fa-whatsapp me-2 text-success"></i> واتساب
                                        </a>

                                    </li>




                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- مرتجع -->
                    <a href="<?php echo e(route('ReturnIInvoices.create', ['id' => $invoice->id])); ?>"
                        class="btn btn-sm btn-outline-secondary d-flex align-items-center custom-btn">
                        <i class="fas fa-undo-alt me-1"></i> مرتجع
                    </a>

                    <!-- اشعار دائن -->
                    <a href="<?php echo e(route('CreditNotes.create', ['id' => $invoice->id])); ?>"
                        class="btn btn-sm btn-outline-secondary d-flex align-items-center custom-btn">
                        <i class="fas fa-undo-alt me-1"></i> اشعار دائن
                    </a>

                    <!-- خيارات أخرى -->
                    <div class="btn-group">
                        <div class="dropdown">
                            <button
                                class="btn btn-sm btn-outline-success dropdown-toggle d-flex align-items-center custom-btn"
                                type="button" id="dropdownMenuButton200" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="fas fa-cog me-1"></i> خيارات اخرى
                            </button>
                            <div class="dropdown-menu custom-dropdown" aria-labelledby="dropdownMenuButton200">
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center" href="#">
                                            <i class="fas fa-money-bill-wave me-2"></i> تعيين مراكز تكلفة
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center" href="#">
                                            <i class="fas fa-tasks me-2"></i> تعيين أمر شغل
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center"
                                            href="<?php echo e(route('appointments.create')); ?>">
                                            <i class="fas fa-calendar-alt me-2"></i> ترتيب موعد
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center" href="#">
                                            <i class="fas fa-copy me-2"></i> نسخ
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center"
                                            href="<?php echo e(route('invoices.destroy', ['id' => $invoice->id])); ?>">
                                            <i class="fas fa-trash-alt me-2"></i> حذف
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Tabs -->
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs flex-column flex-sm-row" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="invoice-tab" data-bs-toggle="tab" data-bs-target="#invoice"
                            type="button" role="tab" aria-controls="invoice" aria-selected="true">فاتورة</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="invoice-details-tab" data-bs-toggle="tab"
                            data-bs-target="#invoice-details" type="button" role="tab"
                            aria-controls="invoice-details" aria-selected="false">تفاصيل الفاتورة</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="payments-tab" data-bs-toggle="tab" data-bs-target="#payments"
                            type="button" role="tab" aria-controls="payments"
                            aria-selected="false">مدفوعات</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="warehouse-orders-tab" data-bs-toggle="tab"
                            data-bs-target="#warehouse-orders" type="button" role="tab"
                            aria-controls="warehouse-orders" aria-selected="false">الاذون المخزني</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="activity-log-tab" data-bs-toggle="tab"
                            data-bs-target="#activity-log" type="button" role="tab" aria-controls="activity-log"
                            aria-selected="false">سجل النشاطات</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="invoice-profit-tab" data-bs-toggle="tab"
                            data-bs-target="#invoice-profit" type="button" role="tab"
                            aria-controls="invoice-profit" aria-selected="false">ربح الفاتورة</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <!-- Tab 1: Invoice -->
                    <div class="tab-pane fade show active" id="invoice" role="tabpanel" aria-labelledby="invoice-tab">
                        <iframe src="<?php echo e(route('invoices.print', ['id' => $invoice->id, 'embed' => true])); ?>"
                            class="pdf-iframe" frameborder="0"></iframe>
                    </div>

                </div>

                <!-- Tab 2: Invoice Details -->
                <div class="tab-pane fade" id="invoice-details" role="tabpanel" aria-labelledby="invoice-details-tab">
                    <div id="custom-form-view">
                        <br>
                        <div class="input-fields">
                            <h3 class="head-bar theme-color-a"><span class="details-info">هدايا مجانا</span></h3>
                            <div class="row">
                                <div class="col-sm-12">
                                    <dl class="row">
                                        <dt><strong>الوقت</strong>:</dt>
                                        <dd>00:00:00</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>

                <!-- Tab 3: Payments -->
                <div class="tab-pane fade" id="payments" role="tabpanel" aria-labelledby="payments-tab">
                    <div class="invoice-payments content-area invoice-Block">
                        <h3>
                            <?php echo e(__('عمليات الدفع على الفاتورة')); ?> #<?php echo e($invoice->id); ?>

                            <a href="<?php echo e(route('paymentsClient.create', ['id' => $invoice->id, 'type' => 'invoice'])); ?>"
                                class="btn btn-success btn-sm float-end">
                                <?php echo e(__('إضافة عملية دفع')); ?>

                            </a>
                        </h3>
                        <div class="clear"></div><br>

                        <div class="card">
                            <div class="card-body">
                                <?php $__empty_1 = true; $__currentLoopData = $invoice->payments_process; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="card-title mb-0">
                                                    <span class="text-muted">#<?php echo e($payment->id); ?></span>
                                                    <?php echo e($invoice->client->trade_name); ?>

                                                </h5>
                                                <?php switch($payment->payment_status):
                                                    case (1): ?>
                                                        <span class="badge badge-success"><?php echo e(__('مكتمل')); ?></span>
                                                    <?php break; ?>

                                                    <?php case (2): ?>
                                                        <span class="badge badge-warning"><?php echo e(__('جزئي')); ?></span>
                                                    <?php break; ?>

                                                    <?php case (3): ?>
                                                        <span class="badge badge-danger"><?php echo e(__('غير مكتمل')); ?></span>
                                                    <?php break; ?>

                                                    <?php default: ?>
                                                        <span class="badge badge-secondary"><?php echo e(__('غير محدد')); ?></span>
                                                <?php endswitch; ?>
                                            </div>

                                            <div class="row">
                                                <div class="col-12 col-sm-4">
                                                    <small class="text-muted"><?php echo e(__('تاريخ الدفع')); ?></small>
                                                    <p class="mb-0"><?php echo e($payment->payment_date->format('d/m/Y')); ?>

                                                    </p>
                                                </div>
                                                <div class="col-12 col-sm-4">
                                                    <small class="text-muted"><?php echo e(__('المبلغ')); ?></small>
                                                    <p class="mb-0 font-weight-bold">
                                                        <?php echo e(number_format($payment->amount, 2)); ?> ر.س</p>
                                                </div>
                                                <div class="col-12 col-sm-4">
                                                    <div class="">
                                                        <small class="text-muted"><?php echo e(__('طريقة الدفع')); ?></small>
                                                        <?php switch($payment->Payment_method):
                                                            case (1): ?>
                                                                <span
                                                                    class="d-block badge badge-secondary"><?php echo e(__('نقدي')); ?></span>
                                                            <?php break; ?>

                                                            <?php case (2): ?>
                                                                <span class="d-block badge badge-info"><?php echo e(__('شيك')); ?></span>
                                                            <?php break; ?>

                                                            <?php case (3): ?>
                                                                <span
                                                                    class="d-block badge badge-primary"><?php echo e(__('تحويل بنكي')); ?></span>
                                                            <?php break; ?>

                                                            <?php default: ?>
                                                                <span
                                                                    class="d-block badge badge-light"><?php echo e(__('غير محدد')); ?></span>
                                                        <?php endswitch; ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                <div class="text-muted">
                                                    <i class="fa fa-user mr-2"></i>
                                                    <?php echo e($payment->employee ? $payment->employee->full_name : __('غير محدد')); ?>

                                                </div>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                        type="button" data-toggle="dropdown">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item"
                                                            href="<?php echo e(route('paymentsClient.show', $payment->id)); ?>">
                                                            <i class="fa fa-eye mr-2"></i><?php echo e(__('عرض')); ?>

                                                        </a>
                                                        <a class="dropdown-item"
                                                            href="<?php echo e(route('paymentsClient.edit', $payment->id)); ?>">
                                                            <i class="fa fa-edit mr-2"></i><?php echo e(__('تعديل')); ?>

                                                        </a>
                                                        <a class="dropdown-item text-danger"
                                                            href="<?php echo e(route('paymentsClient.destroy', $payment->id)); ?>">
                                                            <i class="fa fa-trash mr-2"></i><?php echo e(__('حذف')); ?>

                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <div class="col-12">
                                            <div class="alert alert-info text-center">
                                                <?php echo e(__('لا توجد عمليات دفع لهذه الفاتورة')); ?>

                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="content-area">
                                <div class="invoice-info">
                                    <h3><?php echo e(__('ملخص الدفع')); ?></h3>
                                    <div class="table-responsive">
                                        <table class="table table-striped b-light" cellpadding="0" cellspacing="0"
                                            width="100%">
                                            <tr>
                                                <th><?php echo e(__('رقم الفاتورة')); ?></th>
                                                <th><?php echo e(__('العملة')); ?></th>
                                                <th><?php echo e(__('إجمالي الفاتورة')); ?></th>
                                                <th><?php echo e(__('مرتجع')); ?></th>
                                                <th><?php echo e(__('المدفوع')); ?></th>
                                                <th><?php echo e(__('الباقي')); ?></th>
                                            </tr>
                                            <tr>
                                                <td><?php echo e($invoice->id); ?></td>
                                                <td><?php echo e($invoice->currency ?? 'SAR'); ?></td>
                                                <td><?php echo e(number_format($invoice->grand_total, 2)); ?> ر.س</td>
                                                <td><?php echo e(number_format($invoice->return_amount ?? 0, 2)); ?> ر.س</td>
                                                <td><?php echo e(number_format($invoice->payments_process->sum('amount'), 2)); ?> ر.س
                                                </td>
                                                <td><?php echo e(number_format($invoice->remaining_amount, 2)); ?> ر.س</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 4: Warehouse Orders -->
                    <div class="tab-pane fade" id="warehouse-orders" role="tabpanel" aria-labelledby="warehouse-orders-tab">
                        <div class="table-responsive">
                            <table class="table table-striped b-light" cellpadding="0" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('اسم المنتج')); ?></th>
                                        <th><?php echo e(__('الكمية')); ?></th>
                                        <th><?php echo e(__('رصيد المخزون')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $invoice->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e($item->product->name ?? __('غير متوفر')); ?></td>
                                            <td><?php echo e($item->quantity); ?></td>
                                            <td><?php echo e($item->product->product_details->quantity); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="3" class="text-center">
                                                <?php echo e(__('لا توجد عناصر في الفاتورة')); ?>

                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tab 5: Activity Log -->
                    <div class="tab-pane fade" id="activity-log" role="tabpanel" aria-labelledby="activity-log-tab">
                        <p>سجل النشاطات سيظهر هنا.</p>
                    </div>

                    <!-- Tab 6: Invoice Profit -->
                    <div class="tab-pane fade" id="invoice-profit" role="tabpanel" aria-labelledby="invoice-profit-tab">
                        <div class="tab-pane" id="InvoiceProfit">
                            <div class="table-responsive">
                                <table class="list-table table table-hover tableClass">
                                    <thead>
                                        <tr>
                                            <th><?php echo e(__('الاسم')); ?></th>
                                            <th><?php echo e(__('الكمية')); ?></th>
                                            <th><?php echo e(__('سعر البيع')); ?></th>
                                            <th><?php echo e(__('متوسط السعر')); ?></th>
                                            <th><?php echo e(__('الربح')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $invoice->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td>
                                                    #<?php echo e($item->id); ?> <?php echo e($item->product->name); ?>

                                                    <div class="store_handle"></div>
                                                </td>
                                                <td><?php echo e($item->quantity); ?></td>
                                                <td>
                                                    <?php if($item->product): ?>
                                                        <?php echo e(number_format($item->product->sale_price, 2)); ?> ر.س
                                                    <?php else: ?>
                                                        <?php echo e(__('غير متوفر')); ?>

                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($item->product): ?>
                                                        <?php echo e(number_format($item->product->purchase_price, 2)); ?> ر.س
                                                    <?php else: ?>
                                                        <?php echo e(__('غير متوفر')); ?>

                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span dir="ltr">
                                                        <?php if($item->product): ?>
                                                            <?php echo e(number_format(($item->product->sale_price - $item->product->purchase_price) * $item->quantity, 2)); ?>

                                                        <?php else: ?>
                                                            <?php echo e(__('غير متوفر')); ?>

                                                        <?php endif; ?>
                                                    </span> ر.س
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    <?php echo e(__('لا توجد عناصر في الفاتورة')); ?>

                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4"><?php echo e(__('الإجمالي')); ?></td>
                                            <td>
                                                <b>
                                                    <span dir="ltr">
                                                        <?php echo e(number_format(
                                                            $invoice->items->sum(function ($item) {
                                                                return $item->product ? ($item->product->sale_price - $item->product->purchase_price) * $item->quantity : 0;
                                                            }),
                                                            2,
                                                        )); ?>

                                                    </span> ر.س
                                                </b>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>


    <?php $__env->stopSection(); ?>

    <?php $__env->startSection('scripts'); ?>

        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <script src="<?php echo e(asset('assets/js/applmintion.js')); ?>"></script>
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>


<script>
// استقبال الرسائل من نافذة الطباعة لتحديث الإطار
window.addEventListener('message', function(event) {
    if (event.data.type === 'signatureSaved' && event.data.invoiceId == <?php echo e($invoice->id); ?>) {
        // إعادة تحميل الإطار الداخلي
        const iframe = document.querySelector('.pdf-iframe');
        if (iframe) {
            // إضافة timestamp لمنع الكاش
            iframe.src = iframe.src.split('?')[0] + '?t=' + new Date().getTime();

            // أو يمكنك إعادة تحميل الصفحة كاملة إذا لزم الأمر
            // window.location.reload();
        }
    }
});
</script>
        <!-- تأكد أنك استوردت SweetAlert -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/sales/invoices/show.blade.php ENDPATH**/ ?>