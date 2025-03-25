<?php $__env->startSection('title'); ?>
    العملاء
<?php $__env->stopSection(); ?>
<?php $__env->startSection('head'); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>

    <style>
        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 20px;
        }

        .timeline-date {
            position: absolute;
            left: -30px;
            top: 0;
        }

        .timeline-content {
            display: flex;
            align-items: center;
            position: relative;
        }

        .note-box {
            width: 100%;
        }

        .timeline-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            position: absolute;
            right: -6px;
            top: 50%;
            transform: translateY(-50%);
        }
        .dropdown-menu .dropdown-item {
    transition: background 0.3s ease-in-out;
}

.dropdown-menu .dropdown-item:hover {
    filter: brightness(90%);
}

    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php if(session('toast_message')): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                toastr.<?php echo e(session('toast_type', 'success')); ?>('<?php echo e(session('toast_message')); ?>', '', {
                    positionClass: 'toast-bottom-left',
                    closeButton: true,
                    progressBar: true,
                    timeOut: 5000
                });
            });
        </script>
    <?php endif; ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">ادارة العملاء </h2>
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
    <?php echo $__env->make('layouts.alerts.error', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('layouts.alerts.success', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="modal fade" id="assignEmployeeModal" tabindex="-1" aria-labelledby="assignEmployeeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assignEmployeeModalLabel">تعيين موظفين للعميل</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo e(route('clients.assign-employees', $client->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="client_id" value="<?php echo e($client->id); ?>">
                        <select name="employee_id[]" multiple class="form-control select2">
                            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($employee->id); ?>" <?php if($client->employees && $client->employees->contains('id', $employee->id)): ?> selected <?php endif; ?>>
                                    <?php echo e($employee->full_name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <button type="submit" class="btn btn-primary mt-2">تعيين الموظفين</button>
                    </form>


                    <!-- Current Assigned Employees -->

                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <strong><?php echo e($client->trade_name); ?></strong>
                        <small class="text-muted">#<?php echo e($client->id); ?></small>
                        <span class="badge badge-success">
                            <?php if($client->status == 'active'): ?>
                                نشط
                            <?php elseif($client->status == 'inactive'): ?>
                                غير نشط
                            <?php endif; ?>
                        </span>
                        <br>
                        <small class="text-muted">
                            حساب الأستاذ:
                            <?php if($client->account): ?>
                                <a href="#"><?php echo e($client->account->name); ?> #<?php echo e($client->account->code); ?></a>
                            <?php else: ?>
                                <span>No account associated</span>
                            <?php endif; ?>
                        </small>
                    </div>
                     <?php
                                            $currency = $account_setting->currency ?? 'SAR';
                                            $currencySymbol = $currency == 'SAR' || empty($currency) ? '<img src="' . asset('assets/images/Saudi_Riyal.svg') . '" alt="ريال سعودي" width="15" style="vertical-align: middle;">' : $currency;
                                        ?>
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div class="text-muted">
                            <strong class="text-dark"><?php echo e($invoice_due ?? 0); ?></strong> <span class="text-muted"><?php echo $currencySymbol; ?></span>
                            <span class="d-block text-danger">المطلوب دفعة</span>
                        </div>
                        <?php if($invoices->isNotEmpty()): ?>
                            <div class="text-muted">
                                <strong class="text-dark"><?php echo e($invoice_due ?? 0); ?></strong> <span
                                    class="text-muted"></span>
                                <span class="d-block text-warning">مفتوح</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="mt-4">
                        <h6>الموظفون المعينون حالياً</h6>
                        <div class="d-flex flex-wrap gap-2" id="assignedEmployeesList">
                            <?php if($client->employees && $client->employees->count() > 0): ?>
                                <?php $__currentLoopData = $client->employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="badge bg-primary d-flex align-items-center">
                                        <?php echo e($employee->full_name); ?>


                                        <form action="<?php echo e(route('clients.remove-employee', $client->id)); ?>" method="POST"
                                            class="ms-2">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="employee_id" value="<?php echo e($employee->id); ?>">

                                            <button type="submit" class="btn btn-sm btn-link text-white p-0">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <span class="text-muted"><?php echo e(__('لا يوجد موظفون مرتبطون بهذا العميل')); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php
                    // جلب الحالة الحالية للعميل
                    $currentStatus = $statuses->where('id', old('status_id', $client->status_id))->first();
                ?>

                <form method="POST" action="<?php echo e(route('clients.updateStatusClient')); ?>">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="client_id" value="<?php echo e($client->id); ?>" id="client_id">

                    <div class="dropdown">
                        <!-- زر القائمة المنسدلة -->
                        <button class="btn btn-light dropdown-toggle text-start" type="button" id="clientStatusDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false"
                            style="background-color: <?php echo e($currentStatus->color ?? '#ffffff'); ?>;
                                   color: #000;
                                   border: 1px solid #ccc;
                                   min-width: 150px; /* عرض افتراضي للزر */
                                   max-width: max-content; /* التوسع حسب المحتوى */
                                   white-space: nowrap;">
                            <?php echo e($currentStatus->name ?? 'اختر الحالة '); ?>

                        </button>

                        <!-- القائمة المنسدلة -->
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="clientStatusDropdown"
                            style="min-width: 150px; /* عرض افتراضي */
                                   width: auto; /* يجعل الحجم يتكيف */
                                   max-width: max-content; /* يتمدد حسب المحتوى */
                                   white-space: nowrap; /* يمنع كسر النص إلى سطر جديد */
                                   border-radius: 8px;">
                            <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <button type="submit" class="dropdown-item text-white d-flex align-items-center justify-content-between"
                                        name="status_id" value="<?php echo e($status->id); ?>" style="background-color: <?php echo e($status->color); ?>;">
                                        <span><i class="fas fa-thumbtack me-1"></i> <?php echo e($status->name); ?></span>
                                    </button>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <!-- زر تعديل الحالات -->
                            <li>
                                <a href="<?php echo e(route('SupplyOrders.edit_status')); ?>" class="dropdown-item text-muted d-flex align-items-center justify-content-center"
                                    style="border-top: 1px solid #ddd; padding: 8px;">
                                    <i class="fas fa-cog me-2"></i> تعديل قائمة الحالات - العميل
                                </a>
                            </li>
                        </ul>
                    </div>
                </form>
                                </div>
            </div>
        </div>
        <div class="card border-0">
            <div class="card-body d-flex justify-content-between align-items-center">
                <!-- القسم الأيمن (الاسم والموقع) -->
                <div class="text-end">
                    <strong class="text-dark"><?php echo e($client->first_name); ?></strong>
                    <br>
                    <span class="text-primary">
                        <i class="fas fa-map-marker-alt"></i><?php echo e($client->full_address); ?>

                    </span>
                </div>

                <!-- القسم الأيسر (رقم الهاتف) -->
                <div class="d-flex align-items-center">
                    <button class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-copy"></i>
                    </button>
                    <span class="mx-2 text-dark"><?php echo e($client->phone); ?></span>
                    <button class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-mobile-alt"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                    <!-- زر الخيارات الإضافية -->
                    <div class="dropdown mt-2 mt-md-0">
                        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle"
                            data-bs-toggle="dropdown">
                            خيارات أخرى
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal"
                                    data-bs-target="#openingBalanceModal">
                                    <i class="fas fa-wallet me-2"></i> إضافة رصيد افتتاحي
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center"
                                    href="<?php echo e(route('SupplyOrders.create')); ?>">
                                    <i class="fas fa-truck me-2"></i> إضافة أمر توريد
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <i class="fas fa-user me-2"></i> الدخول كعميل
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <i class="fas fa-ban me-2"></i> موقوف
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center text-danger"
                                    href="<?php echo e(route('clients.destroy', $client->id)); ?>">
                                    <i class="fas fa-trash-alt me-2"></i> حذف عميل
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal"
                                    data-bs-target="#assignEmployeeModal">
                                    <i class="fas fa-user-tie me-2"></i> تعيين إلى موظف
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <i class="fas fa-copy me-2"></i> نسخ
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- الأزرار الرئيسية -->
                    <div class="dropdown mt-2 mt-md-0 d-md-none">
                        <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle"
                            data-bs-toggle="dropdown">
                            <i class="far fa-file-alt me-1"></i> الإجراءات
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a href="#" class="dropdown-item d-inline-flex align-items-center">
                                    <i class="far fa-file-alt me-1"></i> كشف حساب
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('CreditNotes.create')); ?>"
                                    class="dropdown-item d-inline-flex align-items-center">
                                    <i class="far fa-sticky-note me-1"></i> إنشاء إشعار دائن
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('questions.create')); ?>"
                                    class="dropdown-item d-inline-flex align-items-center">
                                    <i class="fas fa-file-invoice me-1"></i> إنشاء عرض سعر
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('invoices.create')); ?>"
                                    class="dropdown-item d-inline-flex align-items-center">
                                    <i class="fas fa-file-invoice me-1"></i> إنشاء فاتورة
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('Reservations.client', $client->id)); ?>"
                                    class="dropdown-item d-inline-flex align-items-center">
                                    <i class="fas fa-file-invoice me-1"></i> الحجوزات
                                </a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item d-inline-flex align-items-center">
                                    <i class="far fa-comment-alt me-1"></i> أرسل SMS
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('appointments.create')); ?>"
                                    class="dropdown-item d-inline-flex align-items-center">
                                    <i class="far fa-calendar-alt me-1"></i> ترتيب موعد
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('appointment.notes.create', $client->id)); ?>"
                                    class="dropdown-item d-inline-flex align-items-center">
                                    <i class="far fa-calendar-alt me-1"></i> إضافة ملاحظة/مرفق
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('clients.edit', $client->id)); ?>"
                                    class="dropdown-item d-inline-flex align-items-center">
                                    <i class="fas fa-edit me-1"></i> تعديل
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- الأزرار الرئيسية للأجهزة الكبيرة -->
                    <div class="d-none d-md-flex flex-wrap gap-2">
                        <a href="#" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center">
                            <i class="far fa-file-alt me-1"></i> كشف حساب
                        </a>
                        <a href="<?php echo e(route('CreditNotes.create')); ?>"
                            class="btn btn-sm btn-outline-success d-inline-flex align-items-center">
                            <i class="far fa-sticky-note me-1"></i> إنشاء إشعار دائن
                        </a>
                        <a href="<?php echo e(route('questions.create')); ?>"
                            class="btn btn-sm btn-outline-info d-inline-flex align-items-center">
                            <i class="fas fa-file-invoice me-1"></i> إنشاء عرض سعر
                        </a>
                        <a href="<?php echo e(route('invoices.create')); ?>"
                            class="btn btn-sm btn-outline-warning d-inline-flex align-items-center">
                            <i class="fas fa-file-invoice me-1"></i> إنشاء فاتورة
                        </a>
                        <a href="<?php echo e(route('Reservations.client', $client->id)); ?>"
                            class="btn btn-sm btn-outline-warning d-inline-flex align-items-center">
                            <i class="fas fa-file-invoice me-1"></i> الحجوزات
                        </a>
                        <a href="#" class="btn btn-sm btn-outline-danger d-inline-flex align-items-center">
                            <i class="far fa-comment-alt me-1"></i> أرسل SMS
                        </a>
                        <a href="<?php echo e(route('appointments.create')); ?>"
                            class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center">
                            <i class="far fa-calendar-alt me-1"></i> ترتيب موعد
                        </a>
                        <a href="<?php echo e(route('appointment.notes.create', $client->id)); ?>"
                            class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center">
                            <i class="far fa-calendar-alt me-1"></i> إضافة ملاحظة/مرفق
                        </a>
                        <a href="<?php echo e(route('clients.edit', $client->id)); ?>"
                            class="btn btn-sm btn-outline-primary d-inline-flex align-items-center">
                            <i class="fas fa-edit me-1"></i> تعديل
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <div class="card">

            <div class="card-body">



                <div class="container-fluid">
                    <div class="row">
                        <!-- تبويبات العمود الجانبي -->
                        <div class="col-12">
                            <!-- تبويبات أفقية على الشاشات الكبيرة -->
                            <ul class="nav nav-tabs d-none d-md-flex" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details"
                                        aria-controls="details" role="tab" aria-selected="true">
                                        <span class="badge badge-pill badge-primary"><?php echo e($client->count()); ?></span>
                                        التفاصيل
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="appointments-tab" data-toggle="tab" href="#appointments"
                                        aria-controls="appointments" role="tab" aria-selected="false">
                                        المواعيد <span
                                            class="badge badge-pill badge-primary"><?php echo e($client->appointments()->count()); ?></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="invoices-tab" data-toggle="tab" href="#invoices"
                                        aria-controls="invoices" role="tab" aria-selected="false">
                                        الفواتير <span
                                            class="badge badge-pill badge-primary"><?php echo e($client->invoices->count()); ?></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="notes-tab" data-toggle="tab" href="#notes"
                                        aria-controls="notes" role="tab" aria-selected="false">
                                        الملاحظات <span class="badge badge-pill badge-primary"></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="payments-tab" data-toggle="tab" href="#payments"
                                        aria-controls="payments" role="tab" aria-selected="false">
                                        المدفوعات <span
                                            class="badge badge-pill badge-primary"><?php echo e($client->payments->count()); ?></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="account-movement-tab" data-toggle="tab"
                                        href="#account-movement" aria-controls="account-movement" role="tab"
                                        aria-selected="false">
                                        حركة الحساب <span
                                            class="badge badge-pill badge-info"><?php echo e($client->transactions->count()); ?></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="balance-summary-tab" data-toggle="tab"
                                        href="#balance-summary" aria-controls="balance-summary" role="tab"
                                        aria-selected="false">ملخص الرصيد</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="membership-tab" data-toggle="tab" href="#membership"
                                        aria-controls="membership" role="tab" aria-selected="false">العضوية</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="timeline-tab" data-toggle="tab" href="#timeline"
                                        aria-controls="timeline" role="tab" aria-selected="false">الجدول الزمني</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="service-tab" data-toggle="tab" href="#service"
                                        aria-controls="service" role="tab" aria-selected="false">الحجوزات /
                                        الخدمات</a>
                                </li>
                            </ul>

                            <!-- تبويبات عمودية على الشاشات الصغيرة -->
                            <ul class="nav nav-tabs flex-column d-block d-md-none" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details"
                                        aria-controls="details" role="tab" aria-selected="true">
                                        <span class="badge badge-pill badge-primary"><?php echo e($client->count()); ?></span>
                                        التفاصيل
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="appointments-tab" data-toggle="tab" href="#appointments"
                                        aria-controls="appointments" role="tab" aria-selected="false">
                                        المواعيد <span
                                            class="badge badge-pill badge-primary"><?php echo e($client->appointments()->count()); ?></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="invoices-tab" data-toggle="tab" href="#invoices"
                                        aria-controls="invoices" role="tab" aria-selected="false">
                                        الفواتير <span
                                            class="badge badge-pill badge-primary"><?php echo e($client->invoices->count()); ?></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="notes-tab" data-toggle="tab" href="#notes"
                                        aria-controls="notes" role="tab" aria-selected="false">
                                        الملاحظات <span class="badge badge-pill badge-primary"></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="payments-tab" data-toggle="tab" href="#payments"
                                        aria-controls="payments" role="tab" aria-selected="false">
                                        المدفوعات <span
                                            class="badge badge-pill badge-primary"><?php echo e($client->payments->count()); ?></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="account-movement-tab" data-toggle="tab"
                                        href="#account-movement" aria-controls="account-movement" role="tab"
                                        aria-selected="false">
                                        حركة الحساب <span
                                            class="badge badge-pill badge-info"><?php echo e($client->transactions->count()); ?></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="balance-summary-tab" data-toggle="tab"
                                        href="#balance-summary" aria-controls="balance-summary" role="tab"
                                        aria-selected="false">ملخص الرصيد</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="membership-tab" data-toggle="tab" href="#membership"
                                        aria-controls="membership" role="tab" aria-selected="false">العضوية</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="timeline-tab" data-toggle="tab" href="#timeline"
                                        aria-controls="timeline" role="tab" aria-selected="false">الجدول الزمني</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="service-tab" data-toggle="tab" href="#service"
                                        aria-controls="service" role="tab" aria-selected="false">الحجوزات /
                                        الخدمات</a>
                                </li>
                            </ul>
                        </div>

                        <!-- محتوى التبويبات -->
                        <div class="col-12">
                            <div class="tab-content">
                                <!-- تبويب التفاصيل -->
                                <div class="tab-pane active" id="details" aria-labelledby="details-tab"
                                    role="tabpanel">
                                    <div class="card">
                                        <div class="card-header">
                                            <strong>التفاصيل :</strong>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p><strong>الاسم التجاري:</strong> <?php echo e($client->trade_name); ?></p>
                                                    <p><strong>الاسم الأول:</strong> <?php echo e($client->first_name); ?></p>
                                                    <p><strong>الاسم الأخير:</strong> <?php echo e($client->last_name); ?></p>
                                                    <p><strong>رقم الهاتف:</strong> <?php echo e($client->phone); ?></p>
                                                    <p><strong>الجوال:</strong> <?php echo e($client->mobile); ?></p>
                                                    <p><strong>البريد الإلكتروني:</strong> <?php echo e($client->email); ?></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><strong>العنوان:</strong> <?php echo e($client->street1); ?>

                                                        <?php echo e($client->street2); ?></p>
                                                    <p><strong>المدينة:</strong> <?php echo e($client->city); ?></p>
                                                    <p><strong>المنطقة:</strong> <?php echo e($client->region); ?></p>
                                                    <p><strong>الرمز البريدي:</strong> <?php echo e($client->postal_code); ?></p>
                                                    <p><strong>الدولة:</strong> <?php echo e($client->country); ?></p>
                                                    <p><strong>الرقم الضريبي:</strong> <?php echo e($client->tax_number); ?></p>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p><strong>السجل التجاري:</strong>
                                                        <?php echo e($client->commercial_registration); ?></p>
                                                    <p><strong>حد الائتمان:</strong> <?php echo e($client->credit_limit); ?></p>
                                                    <p><strong>فترة الائتمان:</strong> <?php echo e($client->credit_period); ?> يوم</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><strong>طريقة الطباعة:</strong>
                                                        <?php if($client->printing_method == 1): ?>
                                                            طباعة عادية
                                                        <?php elseif($client->printing_method == 2): ?>
                                                            طباعة حرارية
                                                        <?php else: ?>
                                                            غير محدد
                                                        <?php endif; ?>
                                                    </p>
                                                    <p><strong>نوع العميل:</strong>
                                                        <?php if($client->client_type == 1): ?>
                                                            فرد
                                                        <?php elseif($client->client_type == 2): ?>
                                                            شركة
                                                        <?php else: ?>
                                                            غير محدد
                                                        <?php endif; ?>
                                                    </p>
                                                    <p><strong>الرصيد الافتتاحي:</strong> <?php echo e($client->opening_balance); ?>

                                                    </p>
                                                    <p><strong>تاريخ الرصيد الافتتاحي:</strong>
                                                        <?php echo e($client->opening_balance_date); ?></p>
                                                </div>
                                            </div>
                                            <?php if($client->notes): ?>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <p><strong>ملاحظات:</strong></p>
                                                        <p><?php echo e($client->notes); ?></p>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- تبويب المواعيد -->
                                <div class="tab-pane" id="appointments" aria-labelledby="appointments-tab"
                                    role="tabpanel">
                                    <?php
                                        $completedAppointments = $client->appointments->where(
                                            'status',
                                            App\Models\Appointment::STATUS_COMPLETED,
                                        );
                                        $ignoredAppointments = $client->appointments->where(
                                            'status',
                                            App\Models\Appointment::STATUS_IGNORED,
                                        );
                                        $pendingAppointments = $client->appointments->where(
                                            'status',
                                            App\Models\Appointment::STATUS_PENDING,
                                        );
                                        $rescheduledAppointments = $client->appointments->where(
                                            'status',
                                            App\Models\Appointment::STATUS_RESCHEDULED,
                                        );
                                    ?>

                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <!-- زر القائمة المنسدلة للأجهزة الصغيرة -->
                                            <div class="dropdown d-block d-md-none">
                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle"
                                                    type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    تصفية المواعيد
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <button class="dropdown-item filter-appointments" data-filter="all">
                                                        الكل <span
                                                            class="badge badge-light"><?php echo e($client->appointments->count()); ?></span>
                                                    </button>
                                                    <button class="dropdown-item filter-appointments"
                                                        data-filter="<?php echo e(App\Models\Appointment::STATUS_COMPLETED); ?>">
                                                        تم <span
                                                            class="badge badge-light"><?php echo e($completedAppointments->count()); ?></span>
                                                    </button>
                                                    <button class="dropdown-item filter-appointments"
                                                        data-filter="<?php echo e(App\Models\Appointment::STATUS_IGNORED); ?>">
                                                        تم صرف النظر عنه <span
                                                            class="badge badge-light"><?php echo e($ignoredAppointments->count()); ?></span>
                                                    </button>
                                                    <button class="dropdown-item filter-appointments"
                                                        data-filter="<?php echo e(App\Models\Appointment::STATUS_PENDING); ?>">
                                                        تم جدولته <span
                                                            class="badge badge-light"><?php echo e($pendingAppointments->count()); ?></span>
                                                    </button>
                                                    <button class="dropdown-item filter-appointments"
                                                        data-filter="<?php echo e(App\Models\Appointment::STATUS_RESCHEDULED); ?>">
                                                        تم جدولته مجددا <span
                                                            class="badge badge-light"><?php echo e($rescheduledAppointments->count()); ?></span>
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- الأزرار العادية للأجهزة الكبيرة -->
                                            <div class="d-none d-md-flex gap-2 flex-wrap">
                                                <button class="btn btn-sm btn-outline-primary filter-appointments"
                                                    data-filter="all">
                                                    الكل <span
                                                        class="badge badge-light"><?php echo e($client->appointments->count()); ?></span>
                                                </button>
                                                <button class="btn btn-sm btn-outline-success filter-appointments"
                                                    data-filter="<?php echo e(App\Models\Appointment::STATUS_COMPLETED); ?>">
                                                    تم <span
                                                        class="badge badge-light"><?php echo e($completedAppointments->count()); ?></span>
                                                </button>
                                                <button class="btn btn-sm btn-outline-warning filter-appointments"
                                                    data-filter="<?php echo e(App\Models\Appointment::STATUS_IGNORED); ?>">
                                                    تم صرف النظر عنه <span
                                                        class="badge badge-light"><?php echo e($ignoredAppointments->count()); ?></span>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger filter-appointments"
                                                    data-filter="<?php echo e(App\Models\Appointment::STATUS_PENDING); ?>">
                                                    تم جدولته <span
                                                        class="badge badge-light"><?php echo e($pendingAppointments->count()); ?></span>
                                                </button>
                                                <button class="btn btn-sm btn-outline-info filter-appointments"
                                                    data-filter="<?php echo e(App\Models\Appointment::STATUS_RESCHEDULED); ?>">
                                                    تم جدولته مجددا <span
                                                        class="badge badge-light"><?php echo e($rescheduledAppointments->count()); ?></span>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="card-body">
                                            <div id="appointments-container">
                                                <?php if($client->appointments->count() > 0): ?>
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>العنوان</th>
                                                                    <th>الوصف</th>
                                                                    <th>التاريخ</th>
                                                                    <th>بواسطة</th>
                                                                    <th>الحالة</th>
                                                                    <th>الإجراءات</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $__currentLoopData = $client->appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <tr data-appointment-id="<?php echo e($appointment->id); ?>"
                                                                        data-status="<?php echo e($appointment->status); ?>"
                                                                        data-date="<?php echo e($appointment->created_at->format('Y-m-d')); ?>">
                                                                        <td><?php echo e($appointment->id); ?></td>
                                                                        <td><?php echo e($appointment->title); ?></td>
                                                                        <td><?php echo e($appointment->description); ?></td>
                                                                        <td><?php echo e($appointment->created_at->format('Y-m-d H:i')); ?>

                                                                        </td>
                                                                        <td><?php echo e($appointment->employee->name ?? 'غير محدد'); ?>

                                                                        </td>
                                                                        <td>
                                                                            <span
                                                                                class="badge status-badge <?php echo e($appointment->status_color); ?>">
                                                                                <?php echo e($appointment->status_text); ?>

                                                                            </span>
                                                                        </td>
                                                                        <td>
                                                                            <div class="dropdown">
                                                                                <button
                                                                                    class="btn btn-sm bg-gradient-info fa fa-ellipsis-v"
                                                                                    type="button"
                                                                                    id="dropdownMenuButton<?php echo e($appointment->id); ?>"
                                                                                    data-toggle="dropdown"
                                                                                    aria-haspopup="true"
                                                                                    aria-expanded="false"></button>
                                                                                <div class="dropdown-menu dropdown-menu-end"
                                                                                    aria-labelledby="dropdownMenuButton<?php echo e($appointment->id); ?>">
                                                                                    <form
                                                                                        action="<?php echo e(route('appointments.update-status', $appointment->id)); ?>"
                                                                                        method="POST" class="d-inline">
                                                                                        <?php echo csrf_field(); ?>
                                                                                        <?php echo method_field('PATCH'); ?>
                                                                                        <input type="hidden"
                                                                                            name="status" value="1">
                                                                                        <button type="submit"
                                                                                            class="dropdown-item">
                                                                                            <i
                                                                                                class="fa fa-clock me-2 text-warning"></i>تم
                                                                                            جدولته
                                                                                        </button>
                                                                                    </form>
                                                                                    <form
                                                                                        action="<?php echo e(route('appointments.update-status', $appointment->id)); ?>"
                                                                                        method="POST" class="d-inline">
                                                                                        <?php echo csrf_field(); ?>
                                                                                        <?php echo method_field('PATCH'); ?>
                                                                                        <input type="hidden"
                                                                                            name="status" value="2">
                                                                                        <input type="hidden"
                                                                                            name="auto_delete"
                                                                                            value="1">
                                                                                        <button type="submit"
                                                                                            class="dropdown-item">
                                                                                            <i
                                                                                                class="fa fa-check me-2 text-success"></i>تم
                                                                                        </button>
                                                                                    </form>
                                                                                    <form
                                                                                        action="<?php echo e(route('appointments.update-status', $appointment->id)); ?>"
                                                                                        method="POST" class="d-inline">
                                                                                        <?php echo csrf_field(); ?>
                                                                                        <?php echo method_field('PATCH'); ?>
                                                                                        <input type="hidden"
                                                                                            name="status" value="3">
                                                                                        <button type="submit"
                                                                                            class="dropdown-item">
                                                                                            <i
                                                                                                class="fa fa-times me-2 text-danger"></i>صرف
                                                                                            النظر عنه
                                                                                        </button>
                                                                                    </form>
                                                                                    <form
                                                                                        action="<?php echo e(route('appointments.update-status', $appointment->id)); ?>"
                                                                                        method="POST" class="d-inline">
                                                                                        <?php echo csrf_field(); ?>
                                                                                        <?php echo method_field('PATCH'); ?>
                                                                                        <input type="hidden"
                                                                                            name="status" value="4">
                                                                                        <button type="submit"
                                                                                            class="dropdown-item">
                                                                                            <i
                                                                                                class="fa fa-redo me-2 text-info"></i>تم
                                                                                            جدولته مجددا
                                                                                        </button>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="alert alert-info text-center">
                                                        لا توجد مواعيد
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- تبويب الفواتير -->
                                <div class="tab-pane" id="invoices" aria-labelledby="invoices-tab" role="tabpanel">
                                    <div class="table-responsive">
                                        <table class="table table-hover custom-table" id="fawtra">
                                            <thead>
                                                <tr class="bg-gradient-light text-center">
                                                    <th></th>
                                                    <th class="border-start">رقم الفاتورة</th>
                                                    <th>معلومات العميل</th>
                                                    <th>تاريخ الفاتورة</th>
                                                    <th>المصدر والعملية</th>
                                                    <th>المبلغ والحالة</th>
                                                    <th style="width: 100px;">الإجراءات</th>
                                                </tr>
                                            </thead>
                                            <tbody id="invoiceTableBody">
                                                <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr class="align-middle invoice-row"
                                                        onclick="window.location.href='<?php echo e(route('invoices.show', $invoice->id)); ?>'"
                                                        style="cursor: pointer;"
                                                        data-status="<?php echo e($invoice->payment_status); ?>">
                                                        <td onclick="event.stopPropagation()">
                                                            <input type="checkbox" class="invoice-checkbox"
                                                                name="invoices[]" value="<?php echo e($invoice->id); ?>">
                                                        </td>
                                                        <td class="text-center border-start"><span
                                                                class="invoice-number">#<?php echo e($invoice->id); ?></span></td>
                                                        <td>
                                                            <div class="client-info">
                                                                <div class="client-name mb-2">
                                                                    <i class="fas fa-user text-primary me-1"></i>
                                                                    <strong><?php echo e($invoice->client ? ($invoice->client->trade_name ?: $invoice->client->first_name . ' ' . $invoice->client->last_name) : 'عميل غير معروف'); ?></strong>
                                                                </div>
                                                                <?php if($invoice->client && $invoice->client->tax_number): ?>
                                                                    <div class="tax-info mb-1">
                                                                        <i class="fas fa-hashtag text-muted me-1"></i>
                                                                        <span class="text-muted small">الرقم الضريبي:
                                                                            <?php echo e($invoice->client->tax_number); ?></span>
                                                                    </div>
                                                                <?php endif; ?>
                                                                <?php if($invoice->client && $invoice->client->full_address): ?>
                                                                    <div class="address-info">
                                                                        <i
                                                                            class="fas fa-map-marker-alt text-muted me-1"></i>
                                                                        <span
                                                                            class="text-muted small"><?php echo e($invoice->client->full_address); ?></span>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="date-info mb-2">
                                                                <i class="fas fa-calendar text-info me-1"></i>
                                                                <?php echo e($invoice->created_at ? $invoice->created_at->format($account_setting->time_formula ?? 'H:i:s d/m/Y') : ''); ?>

                                                            </div>
                                                            <div class="creator-info">
                                                                <i class="fas fa-user text-muted me-1"></i>
                                                                <span class="text-muted small">بواسطة:
                                                                    <?php echo e($invoice->createdByUser->name ?? 'غير محدد'); ?></span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex flex-column gap-2"
                                                                style="margin-bottom: 60px">
                                                                <?php
                                                                    $payments = \App\Models\PaymentsProcess::where(
                                                                        'invoice_id',
                                                                        $invoice->id,
                                                                    )
                                                                        ->where('type', 'client payments')
                                                                        ->orderBy('created_at', 'desc')
                                                                        ->get();
                                                                ?>

                                                                <?php if($invoice->type == 'returned'): ?>
                                                                    <span class="badge bg-danger text-white"><i
                                                                            class="fas fa-undo me-1"></i>مرتجع</span>
                                                                <?php elseif($invoice->type == 'normal' && $payments->count() == 0): ?>
                                                                    <span class="badge bg-secondary text-white"><i
                                                                            class="fas fa-file-invoice me-1"></i>أنشئت
                                                                        فاتورة</span>
                                                                <?php endif; ?>

                                                                <?php if($payments->count() > 0): ?>
                                                                    <span class="badge bg-success text-white"><i
                                                                            class="fas fa-check-circle me-1"></i>أضيفت
                                                                        عملية دفع</span>
                                                                <?php endif; ?>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <?php
                                                                $statusClass = match ($invoice->payment_status) {
                                                                    1 => 'success',
                                                                    2 => 'info',
                                                                    3 => 'danger',
                                                                    4 => 'secondary',
                                                                    default => 'dark',
                                                                };
                                                                $statusText = match ($invoice->payment_status) {
                                                                    1 => 'مدفوعة بالكامل',
                                                                    2 => 'مدفوعة جزئياً',
                                                                    3 => 'غير مدفوعة',
                                                                    4 => 'مستلمة',
                                                                    default => 'غير معروفة',
                                                                };
                                                            ?>
                                                            <div class="text-center">
                                                                <span
                                                                    class="badge bg-<?php echo e($statusClass); ?> text-white status-badge"><?php echo e($statusText); ?></span>
                                                            </div>
                                                            <?php
                                                                $currency = $account_setting->currency ?? 'SAR';
                                                                $currencySymbol =
                                                                    $currency == '' || empty($currency)
                                                                        ? '<img src="' .
                                                                            asset('assets/images/Saudi_Riyal.svg') .
                                                                            '" alt="ريال سعودي" width="15" style="vertical-align: middle;">'
                                                                        : $currency;
                                                            ?>
                                                            <div class="amount-info text-center mb-2">
                                                                <h6 class="amount mb-1">
                                                                    <?php echo e(number_format($invoice->grand_total ?? $invoice->total, 2)); ?>

                                                                    <small class="currency"><?php echo $currencySymbol; ?></small>
                                                                </h6>
                                                                <?php if($invoice->due_value > 0): ?>
                                                                    <div class="due-amount">
                                                                        <small class="text-danger">المبلغ المستحق:
                                                                            <?php echo e(number_format($invoice->due_value, 2)); ?>

                                                                            <?php echo $currencySymbol; ?></small>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="dropdown" onclick="event.stopPropagation()">
                                                                <button
                                                                    class="btn btn-sm bg-gradient-info fa fa-ellipsis-v "
                                                                    type="button"
                                                                    id="dropdownMenuButton<?php echo e($invoice->id); ?>"
                                                                    data-bs-toggle="dropdown" data-bs-auto-close="outside"
                                                                    aria-haspopup="true" aria-expanded="false"></button>
                                                                <div class="dropdown-menu">
                                                                    <a class="dropdown-item"
                                                                        href="<?php echo e(route('invoices.edit', $invoice->id)); ?>">
                                                                        <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                                    </a>
                                                                    <a class="dropdown-item"
                                                                        href="<?php echo e(route('invoices.show', $invoice->id)); ?>">
                                                                        <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                                    </a>
                                                                    <a class="dropdown-item"
                                                                        href="<?php echo e(route('invoices.generatePdf', $invoice->id)); ?>">
                                                                        <i class="fa fa-file-pdf me-2 text-danger"></i>PDF
                                                                    </a>
                                                                    <a class="dropdown-item"
                                                                        href="<?php echo e(route('invoices.generatePdf', $invoice->id)); ?>">
                                                                        <i class="fa fa-print me-2 text-dark"></i>طباعة
                                                                    </a>
                                                                    <a class="dropdown-item" href="#">
                                                                        <i
                                                                            class="fa fa-envelope me-2 text-warning"></i>إرسال
                                                                        إلى العميل
                                                                    </a>
                                                                    <a class="dropdown-item"
                                                                        href="<?php echo e(route('paymentsClient.create', ['id' => $invoice->id])); ?>">
                                                                        <i
                                                                            class="fa fa-credit-card me-2 text-info"></i>إضافة
                                                                        عملية دفع
                                                                    </a>
                                                                    <a class="dropdown-item" href="#">
                                                                        <i class="fa fa-copy me-2 text-secondary"></i>نسخ
                                                                    </a>
                                                                    <form
                                                                        action="<?php echo e(route('invoices.destroy', $invoice->id)); ?>"
                                                                        method="POST" class="d-inline">
                                                                        <?php echo csrf_field(); ?>
                                                                        <?php echo method_field('DELETE'); ?>
                                                                        <button type="submit"
                                                                            class="dropdown-item text-danger">
                                                                            <i class="fa fa-trash me-2"></i>حذف
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>

                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- تبويب الملاحظات -->

                                <div class="tab-pane" id="notes" aria-labelledby="notes-tab" role="tabpanel">
                                    <div class="timeline">
                                        <?php $__currentLoopData = $ClientRelations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="timeline-item">
                                                <div class="timeline-content d-flex align-items-start">
                                                    <div class="status-badge bg-danger text-white p-2 rounded">متابعة</div>
                                                    <div
                                                        class="note-box border rounded bg-white shadow-sm p-3 ms-3 flex-grow-1">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h6 class="mb-0"><i class="fas fa-user"></i>
                                                                <?php echo e($note->created_by); ?></h6>
                                                            <small class="text-muted">
                                                                <i class="fas fa-clock"></i>
                                                                <?php echo e($note->created_at->format('H:i d/m/Y')); ?> - <span
                                                                    class="text-primary"><?php echo e($note->status); ?></span>
                                                            </small>
                                                        </div>
                                                        <hr> <i class="far fa-user me-1"></i>
                                                        <p class="mb-2"><?php echo e($note->process ?? ''); ?></p>
                                                        <small class="text-muted"><?php echo e($note->description ?? ''); ?></small>
                                                    </div>
                                                    <div class="timeline-dot bg-danger"></div>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>


                                <!-- تبويب المدفوعات -->
                                <div class="tab-pane" id="payments" aria-labelledby="payments-tab" role="tabpanel">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>رقم الفاتورة</th>
                                                        <th>ملاحظات</th>
                                                        <th>تاريخ الدفع</th>
                                                        <th>بواسطة</th>
                                                        <th>المبلغ</th>
                                                        <th>الحالة</th>
                                                        <th>الإجراءات</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $__currentLoopData = $client->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><?php echo e($payment->id); ?></td>
                                                            <td><?php echo e($payment->invoice->code ?? 'غير محدد'); ?></td>
                                                            <td><?php echo e($payment->notes); ?></td>
                                                            <td><?php echo e($payment->payment_date); ?></td>
                                                            <td><?php echo e($payment->employee->full_name ?? 'غير محدد'); ?></td>
                                                            <td class="text-end"><?php echo e(number_format($payment->amount, 2)); ?>

                                                                ر.س</td>
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
                                                                <span class="badge <?php echo e($statusClass); ?>">
                                                                    <i class="fas <?php echo e($statusIcon); ?> me-1"></i>
                                                                    <?php echo e($statusText); ?>

                                                                </span>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="btn-group">
                                                                    <div class="dropdown">
                                                                        <button
                                                                            class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1"
                                                                            type="button" id="dropdownMenuButton303"
                                                                            data-toggle="dropdown" aria-haspopup="true"
                                                                            aria-expanded="false"></button>
                                                                        <div class="dropdown-menu"
                                                                            aria-labelledby="dropdownMenuButton303">
                                                                            <li>
                                                                                <a class="dropdown-item"
                                                                                    href="<?php echo e(route('paymentsClient.show', $payment->id)); ?>">
                                                                                    <i
                                                                                        class="fa fa-eye me-2 text-primary"></i>عرض
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="dropdown-item"
                                                                                    href="<?php echo e(route('paymentsClient.edit', $payment->id)); ?>">
                                                                                    <i
                                                                                        class="fa fa-edit me-2 text-success"></i>تعديل
                                                                                </a>
                                                                            </li>
                                                                            <form
                                                                                action="<?php echo e(route('paymentsClient.destroy', $payment->id)); ?>"
                                                                                method="POST">
                                                                                <?php echo csrf_field(); ?>
                                                                                <?php echo method_field('DELETE'); ?>
                                                                                <button type="submit"
                                                                                    class="dropdown-item"
                                                                                    style="border: none; background: none;">
                                                                                    <i
                                                                                        class="fa fa-trash me-2 text-danger"></i>
                                                                                    حذف
                                                                                </button>
                                                                            </form>
                                                                            <li>
                                                                                <a class="dropdown-item" href="#">
                                                                                    <i
                                                                                        class="fa fa-envelope me-2 text-warning"></i>ايصال
                                                                                    مدفوعات
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="dropdown-item" href="#">
                                                                                    <i
                                                                                        class="fa fa-envelope me-2 text-warning"></i>ايصال
                                                                                    مدفوعات حراري
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
                                    </div>
                                </div>

                                <!-- تبويب حركة الحساب -->
                                <div class="tab-pane" id="account-movement" aria-labelledby="account-movement-tab"
                                    role="tabpanel">
                                    <div class="mb-3">
                                        <div class="row">
                                            <!-- الأزرار على الشاشات الصغيرة (الهاتف والتابلت) -->
                                            <div class="col-12 d-block d-md-none mb-3">
                                                <div class="d-flex flex-column gap-2">
                                                    <a href="#" class="btn btn-sm btn-info text-white">
                                                        <i class="fas fa-file-export me-1"></i> خيارات التصدير
                                                    </a>
                                                    <a href="#" class="btn btn-sm btn-light">
                                                        <i class="fas fa-print me-1"></i> طباعة
                                                    </a>
                                                    <a href="#" class="btn btn-sm btn-light">
                                                        <i class="fas fa-cog me-1"></i> تخصيص
                                                    </a>
                                                </div>
                                            </div>

                                            <!-- الأزرار على الشاشات الكبيرة (اللاب توب) -->
                                            <div class="col-md-7 d-none d-md-block">
                                                <div class="d-flex flex-wrap gap-2">
                                                    <a href="#" class="btn btn-sm btn-info text-white">
                                                        <i class="fas fa-file-export me-1"></i> خيارات التصدير
                                                    </a>
                                                    <a href="#" class="btn btn-sm btn-light">
                                                        <i class="fas fa-print me-1"></i> طباعة
                                                    </a>
                                                    <a href="#" class="btn btn-sm btn-light">
                                                        <i class="fas fa-cog me-1"></i> تخصيص
                                                    </a>
                                                </div>
                                            </div>

                                            <!-- عناصر التحكم (على جميع الأجهزة) -->
                                            <div class="col-12 col-md-5">
                                                <div
                                                    class="d-flex flex-column flex-md-row align-items-center justify-content-end gap-2">
                                                    <!-- زر التبديل -->
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="showDetails">
                                                        <label class="form-check-label" for="showDetails">اعرض
                                                            التفاصيل</label>
                                                    </div>

                                                    <!-- حقل التاريخ -->
                                                    <div class="input-group input-group-sm" style="width: 200px;">
                                                        <input type="date" class="form-control"
                                                            placeholder="الفترة من / إلى">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-body p-4">
                                            <div class="row mb-4">
                                                <div class="col-md-6 text-start">
                                                    <h5 class="mb-2"><?php echo e($client->trade_name); ?></h5>
                                                    <p class="mb-1"><?php echo e($client->city); ?></p>
                                                    <p class="mb-1"><?php echo e($client->region); ?>، <?php echo e($client->city); ?></p>
                                                    <p class="mb-0"><strong>التاريخ:</strong> <?php echo e(date('d/m/Y')); ?></p>
                                                </div>
                                                <div class="col-md-6 text-end">
                                                    <h4 class="mb-2">كشف حساب</h4>
                                                    <p class="mb-1"><?php echo e($client->trade_name); ?></p>
                                                    <p class="mb-1"><?php echo e($client->region); ?> - <?php echo e($client->city); ?></p>
                                                    <p class="mb-0"><?php echo e($client->country); ?></p>
                                                    <p class="mt-2"><strong>حركة الحساب حتى:</strong>
                                                        <?php echo e(date('d/m/Y')); ?></p>
                                                </div>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover mb-0">
                                                    <thead class="bg-dark text-white">
                                                        <tr>
                                                            <th class="text-end" style="width: 20%;">التاريخ</th>
                                                            <th class="text-end" style="width: 40%;">العملية</th>
                                                            <th class="text-start" style="width: 20%;">المبلغ</th>
                                                            <th class="text-start" style="width: 20%;">المبلغ المتبقي</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $total_amount = 0; // المجموع الكلي للمبلغ
                                                            $total_due = 0; // المجموع الكلي للمبلغ المتبقي
                                                        ?>

                                                        <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <!-- عرض بيانات الفاتورة -->
                                                            <tr>
                                                                <td class="text-end"><?php echo e($invoice->invoice_date); ?></td>
                                                                <td class="text-end">
                                                                    <?php if($invoice->type == 'returned'): ?>
                                                                        مرتجع لفاتورة رقم <?php echo e($invoice->code); ?>

                                                                    <?php else: ?>
                                                                        فاتورة <?php echo e($invoice->code); ?>

                                                                    <?php endif; ?>
                                                                </td>
                                                                <td class="text-start">
                                                                    <?php echo e(number_format($invoice->grand_total, 2)); ?></td>
                                                                <td class="text-start">
                                                                    <?php echo e(number_format($invoice->due_value, 2)); ?></td>
                                                            </tr>

                                                            <?php
                                                                $total_amount += $invoice->grand_total; // زيادة المجموع الكلي للمبلغ
                                                                $total_due += $invoice->due_value; // زيادة المجموع الكلي للمبلغ المتبقي
                                                            ?>

                                                            <!-- عرض بيانات المدفوعات المرتبطة بالفاتورة -->
                                                            <?php $__currentLoopData = $invoice->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr>
                                                                    <td class="text-end"><?php echo e($payment->payment_date); ?>

                                                                    </td>
                                                                    <td class="text-end">عملية دفع
                                                                        (<?php if($payment->Payment_method == 1): ?>
                                                                            نقدي
                                                                        <?php elseif($payment->Payment_method == 2): ?>
                                                                            شيك
                                                                        <?php else: ?>
                                                                            بطاقة ائتمان
                                                                        <?php endif; ?>)
                                                                    </td>
                                                                    <td class="text-start">
                                                                        <?php if($invoice->advance_payment > 0): ?>
                                                                            -<?php echo e(number_format($invoice->advance_payment, 2)); ?>

                                                                        <?php else: ?>
                                                                            <?php echo e(number_format($invoice->advance_payment, 2)); ?>

                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td class="text-start">
                                                                        <?php echo e(number_format($invoice->due_value, 2)); ?></td>
                                                                </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </tbody>
                                                    <!-- عرض المجموع الكلي -->
                                                    <tfoot class="bg-light">
                                                        <tr>
                                                            <th class="text-end" colspan="2">المجموع الكلي</th>
                                                            <th class="text-start"><?php echo e(number_format($total_amount, 2)); ?>

                                                            </th>
                                                            <th class="text-start"><?php echo e(number_format($total_due, 2)); ?>

                                                            </th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- تبويب ملخص الرصيد -->
                                <div class="tab-pane" id="balance-summary" aria-labelledby="balance-summary-tab"
                                    role="tabpanel">
                                    <div class="d-flex justify-content-end gap-2 mb-3">
                                        <a href="#" class="btn btn-info text-white">
                                            <i class="fas fa-plus"></i>
                                            أضف شحن الرصيد
                                        </a>
                                        <a href="#" class="btn btn-secondary">
                                            <i class="fas fa-history"></i>
                                            عرض السجل
                                        </a>
                                    </div>

                                    <div class="card">
                                        <div class="card-body">
                                            <div class="text-center py-5">
                                                <div class="text-muted">
                                                    لا يوجد انواع الرصيد اضيفت حتى الآن
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- تبويب العضوية -->
                                <div class="tab-pane" id="membership" aria-labelledby="membership-tab" role="tabpanel">
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table" style="font-size: 1.1rem;">
                                                <thead>
                                                    <tr>
                                                        <th>المعرف</th>
                                                        <th>بيانات العميل</th>
                                                        <th>الباقة الحالية </th>
                                                        <th>تاريخ الانتهاء</th>
                                                        <th>الحالة</th>
                                                        <th>ترتيب بواسطة</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $__currentLoopData = $memberships; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $membership): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td>#1</td>
                                                            <td>
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <div class="avatar avatar-sm bg-danger">
                                                                        <span class="avatar-content">أ</span>
                                                                    </div>
                                                                    <div>
                                                                        <?php echo e($membership->client->first_name ?? ''); ?>

                                                                        <br>
                                                                        <small class="text-muted"></small>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td><br><small
                                                                    class="text-muted"><?php echo e($membership->packege->commission_name ?? ''); ?></small>
                                                            </td>
                                                            <td><small
                                                                    class="text-muted"><?php echo e($membership->end_date ?? ''); ?></small>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <div class="rounded-circle bg-info"
                                                                        style="width: 8px; height: 8px;"></div>
                                                                    <span class="text-muted">
                                                                        <?php if($membership->status == 'active'): ?>
                                                                            نشط
                                                                        <?php else: ?>
                                                                            غير نشط
                                                                        <?php endif; ?>
                                                                    </span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="btn-group">
                                                                    <div class="dropdown">
                                                                        <button
                                                                            class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1 btn-sm"
                                                                            type="button" id="dropdownMenuButton303"
                                                                            data-toggle="dropdown" aria-haspopup="true"
                                                                            aria-expanded="false"></button>
                                                                        <div class="dropdown-menu"
                                                                            aria-labelledby="dropdownMenuButton303">
                                                                            <li>
                                                                                <a class="dropdown-item"
                                                                                    href="<?php echo e(route('Memberships.show', $membership->id)); ?>">
                                                                                    <i
                                                                                        class="fa fa-eye me-2 text-primary"></i>عرض
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="dropdown-item"
                                                                                    href="<?php echo e(route('Memberships.edit', $membership->id)); ?>">
                                                                                    <i
                                                                                        class="fa fa-edit me-2 text-success"></i>تعديل
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="dropdown-item text-danger"
                                                                                    href="<?php echo e(route('Memberships.delete', $membership->id)); ?>">
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
                                    </div>
                                </div>

                                <!-- تبويب الحجوزات / الخدمات -->
                                <div class="tab-pane" id="service" aria-labelledby="service-tab" role="tabpanel">
                                    <div class="card">
                                        <div class="card-body">
                                            <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="row">
                                                    <div class="col-auto">
                                                        <!-- صورة افتراضية -->
                                                        <div
                                                            style="width: 50px; height: 50px; background-color: #f0f0f0; border-radius: 5px;">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <h6>بيانات العميل</h6>
                                                        <p class="mb-1"><?php echo e($booking->client->first_name ?? ''); ?></p>
                                                        <p class="mb-1">الخدمة :<?php echo e($booking->product->name ?? ''); ?></p>
                                                    </div>
                                                    <div class="col-auto text-end">
                                                        <p class="mb-1">الوقت من <?php echo e($booking->start_time ?? 0); ?> الى
                                                            <?php echo e($booking->end_time ?? 0); ?></p>
                                                        <p class="text-muted small mb-0">16:45:00</p>

                                                        <?php if($booking->status == 'confirm'): ?>
                                                            <span class="badge bg-warning text-dark">مؤكد</span>
                                                        <?php elseif($booking->status == 'review'): ?>
                                                            <span class="badge bg-warning text-dark">تحت المراجعة</span>
                                                        <?php elseif($booking->status == 'bill'): ?>
                                                            <span class="badge bg-warning text-dark">حولت للفاتورة</span>
                                                        <?php elseif($booking->status == 'cancel'): ?>
                                                            <span class="badge bg-warning text-dark">تم الالغاء</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-warning text-dark">تم</span>
                                                        <?php endif; ?>

                                                        <a href="<?php echo e(route('Reservations.show', $booking->id)); ?>"
                                                            class="badge bg-danger text-dark">عرض</a>
                                                        <a href="<?php echo e(route('Reservations.edit', $booking->id)); ?>"
                                                            class="btn btn-sm btn-primary">
                                                            <i class="fa fa-edit"></i> تعديل
                                                        </a>
                                                    </div>
                                                </div>

                                                <!-- Horizontal line after each customer's data -->
                                                <hr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal إضافة الرصيد الافتتاحي -->
                <div class="modal fade" id="openingBalanceModal" tabindex="-1"
                    aria-labelledby="openingBalanceModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="openingBalanceModalLabel">إضافة رصيد افتتاحي</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="openingBalanceForm">
                                    <div class="mb-3">
                                        <label for="openingBalance" class="form-label">الرصيد الافتتاحي</label>
                                        <input type="number" class="form-control" id="openingBalance"
                                            name="opening_balance" value="<?php echo e($client->opening_balance ?? 0); ?>"
                                            step="0.01">
                                    </div>
                                    <input type="hidden" id="clientId" value="<?php echo e($client->id); ?>">
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                                <button type="button" class="btn btn-primary"
                                    onclick="saveOpeningBalance()">حفظ</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('scripts'); ?>

        <script>
            $(document).ready(function() {
                // تأكيد حذف الموظف
                $('.btn-remove-employee').on('click', function(e) {
                    if (!confirm('هل أنت متأكد من إزالة هذا الموظف؟')) {
                        e.preventDefault();
                    }
                });
            });
        </script>
        <script>
            function updateClientStatus(selectElement) {
                var status = selectElement.value; // الحصول على القيمة المحددة
                var clientId = "<?php echo e($client->id); ?>"; // تأكد من أن لديك معرف العميل في الصفحة

                fetch(`/clients/clients_management/clients/${clientId}/update-status`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            notes: status
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("تم تحديث الحالة بنجاح!");
                        } else {
                            alert("حدث خطأ أثناء تحديث الحالة.");
                        }
                    })
                    .catch(error => console.error("Error:", error));
            }
        </script>
        <script>
            function saveOpeningBalance() {
                let clientId = document.getElementById('clientId').value;
                let openingBalance = document.getElementById('openingBalance').value;

                fetch(`/clients/clients_management/${clientId}/update-opening-balance`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                        },
                        body: JSON.stringify({
                            opening_balance: openingBalance
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('تم تحديث الرصيد الافتتاحي بنجاح!');
                            location.reload();
                        } else {
                            alert('حدث خطأ أثناء التحديث، يرجى المحاولة مجدداً.');
                        }
                    })
                    .catch(error => console.error('❌ خطأ:', error));
            }
            function selectStatus(name, color) {
        document.getElementById("clientStatusDropdown").innerHTML = `<span class="status-color" style="background-color: ${color};"></span> ${name}`;
    }
        </script>


        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <script src="<?php echo e(asset('assets/js/applmintion.js')); ?>"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/client/show.blade.php ENDPATH**/ ?>