<?php $__env->startSection('title'); ?>
    العملاء
<?php $__env->stopSection(); ?>
<?php $__env->startSection('head'); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <style>
        /* Responsive CSS */
        @media (max-width: 768px) {
            .mobile-stack {
                flex-direction: column !important;
            }

            .mobile-full-width {
                width: 100% !important;
            }

            .mobile-text-center {
                text-align: center !important;
            }

            .mobile-mt-2 {
                margin-top: 1rem !important;
            }

            .mobile-hide {
                display: none !important;
            }

            .table-responsive {
                font-size: 0.875rem;
            }

            .card-body {
                padding: 1rem;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            .tablet-stack {
                flex-direction: column !important;
            }

            .tablet-text-center {
                text-align: center !important;
            }
        }

        /* Card Styles */
        .card {
            transition: all 0.3s ease;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
        }

        .card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Button & Badge Styles */
        .btn {
            border-radius: 0.25rem;
            transition: all 0.2s ease;
        }

        .badge {
            padding: 0.5em 0.75em;
            border-radius: 0.25rem;
        }

        /* Section Styles */
        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .info-group {
            margin-bottom: 0.5rem;
        }

        .info-label {
            font-weight: 600;
            color: #6c757d;
        }

        /* Timeline Styles */
        .timeline {
            position: relative;
            padding: 1rem 0;
        }

        .timeline-item {
            padding: 1rem;
            border-left: 2px solid #e9ecef;
            margin-left: 1rem;
            position: relative;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -0.5rem;
            top: 1.5rem;
            width: 1rem;
            height: 1rem;
            border-radius: 50%;
            background: #fff;
            border: 2px solid #007bff;
        }

        /* Table Styles */
        .custom-table {
            width: 100%;
        }

        .custom-table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .custom-table td,
        .custom-table th {
            padding: 0.75rem;
            vertical-align: middle;
        }

        /* Status Colors */
        .status-badge {
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 600;
            border-radius: 0.25rem;
        }

        .status-success {
            background-color: #d1e7dd;
            color: #0f5132;
        }

        .status-warning {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-danger {
            background-color: #f8d7da;
            color: #842029;
        }

        .status-info {
            background-color: #cff4fc;
            color: #055160;
        }

        /* Dropdown Menu */
        .dropdown-menu {
            border-radius: 0.25rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
        }

        .dropdown-item i {
            margin-right: 0.5rem;
            width: 1.25rem;
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
    <!-- الزر الذي سيتم النقر عليه لفتح النموذج -->

    <!-- النموذج (Modal) -->
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
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <!-- القسم العلوي: معلومات العميل الأساسية -->
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                    <div>
                        <strong><?php echo e($client->trade_name); ?></strong>
                        <small class="text-muted">#<?php echo e($client->code); ?></small>
                        <span class="badge"
                            style="background-color: <?php echo e($statuses->find($client->status_id)->color ?? '#007BFF'); ?>; color: white;">
                            <?php echo e($statuses->find($client->status_id)->name ?? 'غير محدد'); ?>

                        </span>
                        <br>
                        <small class="text-muted">
                            حساب الأستاذ:
                            <?php if($client->account_client && $client->account_client->client_id == $client->id): ?>
                                <a
                                    href="<?php echo e(route('journal.generalLedger', ['account_id' => $client->account_client->id])); ?>">
                                    <?php echo e($client->account_client->name ?? ''); ?>

                                    #<?php echo e($client->account_client->code ?? ''); ?>

                                </a>
                            <?php else: ?>
                                <span>لا يوجد حساب مرتبط</span>
                            <?php endif; ?>
                        </small>
                    </div>

                    <!-- معلومات الرصيد -->
                    <?php
                        $currency = $account_setting->currency ?? 'SAR';
                        $currencySymbol =
                            $currency == 'SAR' || empty($currency)
                                ? '<img src="' .
                                    asset('assets/images/Saudi_Riyal.svg') .
                                    '" alt="ريال سعودي" width="15" style="vertical-align: middle;">'
                                : $currency;
                    ?>
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div class="text-muted">
                            <strong class="text-dark"><?php echo e($due ?? 0); ?></strong> <span
                                class="text-muted"><?php echo $currencySymbol; ?></span>
                            <span class="d-block text-danger">المطلوب دفعة</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <?php
                            $currentStatus = $client->status;
                        ?>


                        <form method="POST" action="<?php echo e(route('clients.updateStatusClient')); ?>" class="flex-grow-1"
                            style="min-width: 220px;">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="client_id" value="<?php echo e($client->id); ?>">
                            <div class="dropdown w-100">
                                <button class="btn w-100 text-start dropdown-toggle" type="button"
                                    id="clientStatusDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                                    style="background-color: <?php echo e($currentStatus->color ?? '#e0f7fa'); ?>; color: #000; border: 1px solid #ccc; height: 42px;">
                                    <?php echo e($currentStatus->name ?? 'اختر الحالة'); ?>

                                </button>
                                <ul class="dropdown-menu w-100" aria-labelledby="clientStatusDropdown"
                                    style="border-radius: 8px;">
                                    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>
                                            <button type="submit"
                                                class="dropdown-item text-white d-flex align-items-center justify-content-between"
                                                name="status_id" value="<?php echo e($status->id); ?>"
                                                style="background-color: <?php echo e($status->color); ?>;">
                                                <span><i class="fas fa-thumbtack me-1"></i> <?php echo e($status->name); ?></span>
                                            </button>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <a href="<?php echo e(route('SupplyOrders.edit_status')); ?>"
                                            class="dropdown-item text-muted d-flex align-items-center justify-content-center"
                                            style="border-top: 1px solid #ddd; padding: 8px;">
                                            <i class="fas fa-cog me-2"></i> تعديل قائمة الحالات - العميل
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </form>

                    </div>
                </div>

                <!-- القسم الأوسط: معلومات الاتصال والعنوان -->
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                    <div class="text-end">
                        <strong class="text-dark"><?php echo e($client->first_name); ?></strong>
                        <br>
                        <span class="text-primary">
                            <i class="fas fa-map-marker-alt"></i> <?php echo e($client->full_address); ?>

                        </span>
                    </div>

                    <?php if(auth()->user()->role === 'manager'): ?>
                        <div class="row align-items-center">
                            <div id="assignedEmployeesList" class="col-12">
                                <?php if($client->employees && $client->employees->count() > 0): ?>
                                    <div class="row g-2">
                                        <?php $__currentLoopData = $client->employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-auto">
                                                <div class="badge bg-primary d-flex align-items-center">
                                                    <a href="<?php echo e(route('employee.show', $employee->id)); ?>"
                                                        class="text-white text-decoration-none me-2">
                                                        <?php echo e($employee->full_name); ?>

                                                    </a>
                                                    <form action="<?php echo e(route('clients.remove-employee', $client->id)); ?>"
                                                        method="POST" class="mb-0">
                                                        <?php echo csrf_field(); ?>
                                                        <input type="hidden" name="employee_id"
                                                            value="<?php echo e($employee->id); ?>">
                                                        <button type="submit" class="btn btn-sm btn-link text-white p-0">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php else: ?>
                                    <span class="text-muted"><?php echo e(__('لا يوجد موظفون مرتبطون')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>

                <!-- القسم السفلي: الحالة والموظفين والخيارات -->

            </div>
        </div>


        <div class="card">
            <div class="card-body">
                <!-- أزرار القائمة (تظهر فقط على الشاشات الكبيرة) -->
                <div class="d-grid d-md-flex flex-wrap gap-2 d-none d-md-block">
                    <?php if(auth()->user()->hasPermissionTo('Edit_Client')): ?>
                        <a href="<?php echo e(route('clients.edit', $client->id)); ?>"
                            class="btn btn-sm btn-outline-info text-dark bg-white">
                            <i class="fas fa-user-edit me-1"></i> تعديل
                        </a>
                    <?php endif; ?>

                    <?php if(auth()->user()->role === 'manager'): ?>
                        <form action="<?php echo e(route('clients.force-show', $client)); ?>" method="POST" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-sm btn-outline-warning text-dark bg-white">
                                <i class="fas fa-map-marker-alt"></i> إظهار في الخريطة الآن
                            </button>
                        </form>
                    <?php endif; ?>

                    <a href="<?php echo e(route('appointment.notes.create', $client->id)); ?>"
                        class="btn btn-sm btn-outline-secondary text-dark bg-white">
                        <i class="fas fa-paperclip me-1"></i> إضافة ملاحظة/مرفق
                    </a>

                    <a href="<?php echo e(route('incomes.create')); ?>" class="btn btn-sm btn-outline-success text-dark bg-white">
                        <i class="fas fa-receipt me-1"></i> سند القبض
                    </a>

                    <a href="<?php echo e(route('appointments.create')); ?>"
                        class="btn btn-sm btn-outline-success text-dark bg-white">
                        <i class="fas fa-calendar-plus me-1"></i> ترتيب موعد
                    </a>

                    <a href="<?php echo e(route('clients.statement', $client->id)); ?>"
                        class="btn btn-sm btn-outline-warning text-dark bg-white">
                        <i class="fas fa-file-invoice me-1"></i> كشف حساب
                    </a>

                    <a class="btn btn-sm btn-outline-primary text-dark bg-white" href="#" data-bs-toggle="modal"
                        data-bs-target="#openingBalanceModal">
                        <i class="fas fa-wallet me-2"></i> إضافة رصيد افتتاحي
                    </a>

                    <a class="btn btn-sm btn-outline-primary text-dark bg-white" href="#" data-bs-toggle="modal"
                        data-bs-target="#assignEmployeeModal">
                        <i class="fas fa-user-plus me-2"></i> تعيين موظفين
                    </a>

                    <a href="<?php echo e(route('CreditNotes.create')); ?>" class="btn btn-sm btn-outline-danger text-dark bg-white">
                        <i class="fas fa-file-invoice-dollar me-1"></i> إنشاء إشعار دائن
                    </a>

                    <a href="<?php echo e(route('invoices.create', ['client_id' => $client->id])); ?>"
                        class="btn btn-sm btn-outline-dark text-dark bg-white">
                        <i class="fas fa-file-invoice me-1"></i> إنشاء فاتورة
                    </a>

                    <a href="<?php echo e(route('Reservations.client', $client->id)); ?>"
                        class="btn btn-sm btn-outline-dark bg-white text-dark">
                        <i class="fas fa-calendar-check me-1"></i> الحجوزات
                    </a>
                </div>

                <!-- زر واحد يحتوي على القائمة المنسدلة (يظهر فقط على الشاشات الصغيرة) -->
                <div class="dropdown d-md-none">
                    <button class="btn btn-primary w-100 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-bars me-1"></i> خيارات
                    </button>
                    <ul class="dropdown-menu w-100">
                        <?php if(auth()->user()->hasPermissionTo('Edit_Client')): ?>
                            <li>
                                <a class="dropdown-item d-flex align-items-center"
                                    href="<?php echo e(route('clients.edit', $client->id)); ?>">
                                    <i class="fas fa-user-edit me-2 text-info"></i> تعديل
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if(auth()->user()->role === 'manager'): ?>
                            <li>
                                <form action="<?php echo e(route('clients.force-show', $client)); ?>" method="POST"
                                    class="dropdown-item p-0">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn w-100 text-start d-flex align-items-center">
                                        <i class="fas fa-map-marker-alt me-2 text-warning"></i> إظهار في الخريطة الآن
                                    </button>
                                </form>
                            </li>
                        <?php endif; ?>

                        <li>
                            <a class="dropdown-item d-flex align-items-center"
                                href="<?php echo e(route('appointment.notes.create', $client->id)); ?>">
                                <i class="fas fa-paperclip me-2 text-secondary"></i> إضافة ملاحظة/مرفق
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="<?php echo e(route('appointments.create')); ?>">
                                <i class="fas fa-calendar-plus me-2 text-success"></i> ترتيب موعد
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="<?php echo e(route('incomes.create')); ?>">
                                <i class="fas fa-receipt me-2 text-info"></i> سند قبض
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center"
                                href="<?php echo e(route('clients.statement', $client->id)); ?>">
                                <i class="fas fa-file-invoice me-2 text-warning"></i> كشف حساب
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal"
                                data-bs-target="#openingBalanceModal">
                                <i class="fas fa-wallet me-2 text-success"></i> إضافة رصيد افتتاحي
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal"
                                data-bs-target="#assignEmployeeModal">
                                <i class="fas fa-user-plus me-2 text-primary"></i> تعيين موظفين
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="<?php echo e(route('CreditNotes.create')); ?>">
                                <i class="fas fa-file-invoice-dollar me-2 text-danger"></i> إنشاء إشعار دائن
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center"
                                href="<?php echo e(route('invoices.create', ['client_id' => $client->id])); ?>">
                                <i class="fas fa-file-invoice me-2 text-dark"></i> إنشاء فاتورة
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center"
                                href="<?php echo e(route('Reservations.client', $client->id)); ?>">
                                <i class="fas fa-calendar-check me-2 text-dark"></i> الحجوزات
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>



        
        <div class="card">
            <div class="card-body p-0">
                <!-- تبويبات العميل -->
                <div class="client-tabs">
                    <!-- شريط التبويبات الأفقي -->
                    <div class="d-flex flex-wrap border-bottom">
                        <button class="tab-btn active" data-target="details-tab">
                            <i class="fas fa-info-circle me-2"></i> التفاصيل
                        </button>
                        <button class="tab-btn" data-target="appointments-tab">
                            <i class="fas fa-calendar-alt me-2"></i> المواعيد
                        </button>
                        <button class="tab-btn" data-target="invoices-tab">
                            <i class="fas fa-file-invoice me-2"></i> الفواتير
                        </button>
                        <button class="tab-btn" data-target="payments-tab">
                            <i class="fas fa-money-bill-wave me-2"></i> المدفوعات
                        </button>
                        <button class="tab-btn" data-target="notes-tab">
                            <i class="fas fa-sticky-note me-2"></i> الملاحظات
                        </button>
                        <button class="tab-btn" data-target="visits-tab">
                            <i class="fas fa-walking me-2"></i> الزيارات
                        </button>
                        <button class="tab-btn" data-target="reservations-tab">
                            <i class="fas fa-calendar-check me-2"></i> الحجوزات
                        </button>
                    </div>

                    <!-- محتوى التبويبات -->
                    <div class="tab-content p-3">
                        <!-- المعلومات الأساسية -->

                        <!-- معلومات سريعة -->


                        <!-- محتوى تبويب التفاصيل -->
                        <div id="details-tab" class="tab-pane active">
                            <div class="card card-body">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <p class="mb-2"><strong>الاسم التجاري:</strong> <?php echo e($client->trade_name); ?></p>
                                        <p class="mb-2"><strong>الاسم الأول:</strong> <?php echo e($client->first_name); ?></p>
                                        <p class="mb-2"><strong>الاسم الأخير:</strong> <?php echo e($client->last_name); ?></p>
                                        <p class="mb-2"><strong>رقم الهاتف:</strong> <?php echo e($client->phone); ?></p>
                                        <p class="mb-2"><strong>الجوال:</strong> <?php echo e($client->mobile); ?></p>
                                        <p class="mb-2 text-break"><strong>البريد الإلكتروني:</strong>
                                            <?php echo e($client->email); ?></p>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <p class="mb-2"><strong>العنوان:</strong> <?php echo e($client->street1); ?>

                                            <?php echo e($client->street2); ?></p>
                                        <p class="mb-2"><strong>المدينة:</strong> <?php echo e($client->city); ?></p>
                                        <p class="mb-2"><strong>المنطقة:</strong> <?php echo e($client->region); ?></p>
                                        <p class="mb-2"><strong>الرمز البريدي:</strong> <?php echo e($client->postal_code); ?></p>
                                        <p class="mb-2"><strong>الدولة:</strong> <?php echo e($client->country); ?></p>
                                        <p class="mb-2"><strong>الرقم الضريبي:</strong> <?php echo e($client->tax_number); ?></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <p class="mb-2"><strong>السجل التجاري:</strong>
                                            <?php echo e($client->commercial_registration); ?></p>
                                        <p class="mb-2"><strong>حد الائتمان:</strong> <?php echo e($client->credit_limit); ?></p>
                                        <p class="mb-2"><strong>فترة الائتمان:</strong> <?php echo e($client->credit_period); ?> يوم
                                        </p>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <p class="mb-2"><strong>طريقة الطباعة:</strong>
                                            <?php if($client->printing_method == 1): ?>
                                                طباعة عادية
                                            <?php elseif($client->printing_method == 2): ?>
                                                طباعة حرارية
                                            <?php else: ?>
                                                غير محدد
                                            <?php endif; ?>
                                        </p>
                                        <p class="mb-2"><strong>نوع العميل:</strong>
                                            <?php if($client->client_type == 1): ?>
                                                فرد
                                            <?php elseif($client->client_type == 2): ?>
                                                شركة
                                            <?php else: ?>
                                                غير محدد
                                            <?php endif; ?>
                                        </p>
                                        <p class="mb-2"><strong>الرصيد الافتتاحي:</strong>
                                            <?php echo e($client->opening_balance); ?></p>
                                        <p class="mb-2"><strong>تاريخ الرصيد الافتتاحي:</strong>
                                            <?php echo e($client->opening_balance_date); ?></p>
                                    </div>
                                </div>

                                <?php if($client->notes): ?>
                                    <hr>
                                    <div class="row">
                                        <div class="col-12">
                                            <p><strong>ملاحظات:</strong></p>
                                            <p class="text-break"><?php echo e($client->notes); ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- محتوى تبويب المواعيد -->
                        <div id="appointments-tab" class="tab-pane">
                            <div class="card card-body p-0">
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

                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <button class="btn btn-sm btn-outline-primary filter-appointments" data-filter="all">
                                        الكل <span class="badge badge-light"><?php echo e($client->appointments->count()); ?></span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-success filter-appointments"
                                        data-filter="<?php echo e(App\Models\Appointment::STATUS_COMPLETED); ?>">
                                        تم <span class="badge badge-light"><?php echo e($completedAppointments->count()); ?></span>
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
                                                            <td><?php echo e($appointment->created_at->format('Y-m-d H:i')); ?></td>
                                                            <td><?php echo e($appointment->employee->name ?? 'غير محدد'); ?></td>
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
                                                                        data-toggle="dropdown" aria-haspopup="true"
                                                                        aria-expanded="false"></button>
                                                                    <div class="dropdown-menu dropdown-menu-end"
                                                                        aria-labelledby="dropdownMenuButton<?php echo e($appointment->id); ?>">
                                                                        <form
                                                                            action="<?php echo e(route('appointments.update-status', $appointment->id)); ?>"
                                                                            method="POST" class="d-inline">
                                                                            <?php echo csrf_field(); ?>
                                                                            <?php echo method_field('PATCH'); ?>
                                                                            <input type="hidden" name="status"
                                                                                value="1">
                                                                            <button type="submit" class="dropdown-item">
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
                                                                            <input type="hidden" name="status"
                                                                                value="2">
                                                                            <button type="submit" class="dropdown-item">
                                                                                <i
                                                                                    class="fa fa-check me-2 text-success"></i>تم
                                                                            </button>
                                                                        </form>
                                                                        <form
                                                                            action="<?php echo e(route('appointments.update-status', $appointment->id)); ?>"
                                                                            method="POST" class="d-inline">
                                                                            <?php echo csrf_field(); ?>
                                                                            <?php echo method_field('PATCH'); ?>
                                                                            <input type="hidden" name="status"
                                                                                value="3">
                                                                            <button type="submit" class="dropdown-item">
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
                                                                            <input type="hidden" name="status"
                                                                                value="4">
                                                                            <button type="submit" class="dropdown-item">
                                                                                <i class="fa fa-redo me-2 text-info"></i>تم
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

                        <!-- محتوى تبويب الفواتير -->
                        <div id="invoices-tab" class="tab-pane">
                            <div class="card card-body">
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
                                                        <input type="checkbox" class="invoice-checkbox" name="invoices[]"
                                                            value="<?php echo e($invoice->id); ?>">
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
                                                                    <i class="fas fa-map-marker-alt text-muted me-1"></i>
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
                                                        <div class="d-flex flex-column gap-2" style="margin-bottom: 60px">
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
                                                                        class="fas fa-check-circle me-1"></i>أضيفت عملية
                                                                    دفع</span>
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
                                                            <button class="btn btn-sm bg-gradient-info fa fa-ellipsis-v"
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
                                                                    <i class="fa fa-envelope me-2 text-warning"></i>إرسال
                                                                    إلى العميل
                                                                </a>
                                                                <a class="dropdown-item"
                                                                    href="<?php echo e(route('paymentsClient.create', ['id' => $invoice->id])); ?>">
                                                                    <i class="fa fa-credit-card me-2 text-info"></i>إضافة
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
                        </div>

                        <!-- محتوى تبويب المدفوعات -->
                        <div id="payments-tab" class="tab-pane">
                            <div class="card card-body">
                                <div class="table-responsive">
                                    <table class="table">
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
                                                    <td
                                                        style="white-space: normal; word-wrap: break-word; min-width: 200px;">
                                                        <div class="d-flex flex-column">
                                                            <strong>#<?php echo e($payment->id); ?></strong>

                                                            <small class="text-muted">
                                                                <?php if($payment->invoice): ?>
                                                                    الفاتورة: #<?php echo e($payment->invoice->code ?? '--'); ?>

                                                                <?php endif; ?>
                                                            </small>

                                                            <?php if($payment->notes): ?>
                                                                <small class="text-muted mt-1"
                                                                    style="white-space: normal;">
                                                                    <i class="fas fa-comment-alt"></i>
                                                                    <?php echo e($payment->notes); ?>

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
                                                            <small><i class="fas fa-calendar"></i>
                                                                <?php echo e($payment->payment_date); ?></small>
                                                            <?php if($payment->employee): ?>
                                                                <small class="text-muted mt-1">
                                                                    <i class="fas fa-user"></i>
                                                                    <?php echo e($payment->employee->name ?? ''); ?>

                                                                </small>
                                                            <?php endif; ?>
                                                            <small class="text-muted mt-1">
                                                                <i class="fas fa-clock"></i>
                                                                <?php echo e($payment->created_at->format('H:i')); ?>

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
                                                            <?php echo e(number_format($payment->amount, 2)); ?>

                                                            <?php echo $currencySymbol; ?>

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
                                                                <button
                                                                    class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1 btn-sm"
                                                                    type="button"id="dropdownMenuButton303"
                                                                    data-toggle="dropdown"
                                                                    aria-haspopup="true"aria-expanded="false"></button>
                                                                <div class="dropdown-menu"
                                                                    aria-labelledby="dropdownMenuButton303">
                                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                                        <li>
                                                                            <a class="dropdown-item"
                                                                                href="<?php echo e(route('paymentsClient.show', $payment->id)); ?>">
                                                                                <i
                                                                                    class="fas fa-eye me-2 text-primary"></i>عرض
                                                                                التفاصيل
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a class="dropdown-item"
                                                                                href="<?php echo e(route('paymentsClient.edit', $payment->id)); ?>">
                                                                                <i
                                                                                    class="fas fa-edit me-2 text-success"></i>تعديل
                                                                                الدفع
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <form
                                                                                action="<?php echo e(route('paymentsClient.destroy', $payment->id)); ?>"
                                                                                method="POST">
                                                                                <?php echo csrf_field(); ?>
                                                                                <?php echo method_field('DELETE'); ?>
                                                                                <button type="submit"
                                                                                    class="dropdown-item text-danger"
                                                                                    onclick="return confirm('هل أنت متأكد من حذف هذه العملية؟')">
                                                                                    <i class="fas fa-trash me-2"></i>حذف
                                                                                    العملية
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
                                                                                <i
                                                                                    class="fas fa-file-pdf me-2 text-warning"></i>إيصال
                                                                                (A4)
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a class="dropdown-item"
                                                                                href="<?php echo e(route('paymentsClient.rereceipt', ['id' => $payment->id])); ?>?type=thermal"
                                                                                target="_blank">
                                                                                <i
                                                                                    class="fas fa-receipt me-2 text-warning"></i>إيصال
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
                                                                                    <i
                                                                                        class="fas fa-user me-2 text-info"></i>عرض
                                                                                    بيانات
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

                        <!-- محتوى تبويب الملاحظات -->
                        <!-- محتوى تبويب الملاحظات -->
                        <div id="notes-tab" class="tab-pane">
                            <div class="card card-body">
                                <!-- شريط أدوات الملاحظات -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="mb-0">
                                        <i class="fas fa-sticky-note text-primary me-2"></i>
                                        سجل الملاحظات
                                    </h5>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#addNoteModal">
                                        <i class="fas fa-plus me-1"></i> إضافة ملاحظة
                                    </button>
                                </div>

                                <!-- محتوى الملاحظات -->
                                <div class="timeline">
                                    <?php $__empty_1 = true; $__currentLoopData = $ClientRelations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <div class="timeline-item mb-4">
                                            <div
                                                class="timeline-content d-flex align-items-start flex-wrap flex-md-nowrap">
                                                <!-- الحالة -->
                                                <span class="badge mb-2 mb-md-0"
                                                    style="background-color: <?php echo e($statuses->find($client->status_id)->color ?? '#007BFF'); ?>; color: white;">
                                                    <?php echo e($statuses->find($client->status_id)->name ?? ''); ?>

                                                </span>

                                                <!-- مربع الملاحظة -->
                                                <div
                                                    class="note-box border rounded bg-white shadow-sm p-3 ms-md-3 mt-2 mt-md-0 flex-grow-1 w-100">
                                                    <!-- رأس الملاحظة -->
                                                    <div
                                                        class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center">
                                                        <div>
                                                            <h6 class="mb-1">
                                                                <i class="fas fa-user me-1"></i>
                                                                <?php echo e($note->employee->name ?? 'غير معروف'); ?>

                                                            </h6>
                                                            <small class="text-muted">
                                                                <i class="fas fa-tag me-1"></i>
                                                                <?php echo e($note->process ?? 'بدون تصنيف'); ?>

                                                            </small>
                                                        </div>
                                                        <small class="text-muted mt-2 mt-sm-0">
                                                            <i class="fas fa-clock me-1"></i>
                                                            <?php echo e($note->created_at->format('d/m/Y H:i')); ?>

                                                        </small>
                                                    </div>

                                                    <hr class="my-2">

                                                    <!-- محتوى الملاحظة -->
                                                    <div class="note-content mb-3">
                                                        <p class="mb-2"><?php echo e($note->description ?? 'لا يوجد وصف'); ?></p>

                                                        <!-- البيانات الإضافية -->
                                                        <?php if($note->deposit_count || $note->site_type || $note->competitor_documents): ?>
                                                            <div class="additional-data mt-3 p-2 bg-light rounded">
                                                                <div class="row">
                                                                    <?php if($note->deposit_count): ?>
                                                                        <div class="col-md-4 mb-2">
                                                                            <span class="d-block text-primary">
                                                                                <i class="fas fa-boxes me-1"></i> عدد
                                                                                العهدة:
                                                                            </span>
                                                                            <span
                                                                                class="fw-bold"><?php echo e($note->deposit_count); ?></span>
                                                                        </div>
                                                                    <?php endif; ?>

                                                                    <?php if($note->site_type): ?>
                                                                        <div class="col-md-4 mb-2">
                                                                            <span class="d-block text-primary">
                                                                                <i class="fas fa-store me-1"></i> نوع
                                                                                الموقع:
                                                                            </span>
                                                                            <span class="fw-bold">
                                                                                <?php switch($note->site_type):
                                                                                    case ('independent_booth'): ?>
                                                                                        بسطة مستقلة
                                                                                    <?php break; ?>

                                                                                    <?php case ('grocery'): ?>
                                                                                        بقالة
                                                                                    <?php break; ?>

                                                                                    <?php case ('supplies'): ?>
                                                                                        تموينات
                                                                                    <?php break; ?>

                                                                                    <?php case ('markets'): ?>
                                                                                        أسواق
                                                                                    <?php break; ?>

                                                                                    <?php case ('station'): ?>
                                                                                        محطة
                                                                                    <?php break; ?>

                                                                                    <?php default: ?>
                                                                                        <?php echo e($note->site_type); ?>

                                                                                <?php endswitch; ?>
                                                                            </span>
                                                                        </div>
                                                                    <?php endif; ?>

                                                                    <?php if($note->competitor_documents): ?>
                                                                        <div class="col-md-4 mb-2">
                                                                            <span class="d-block text-primary">
                                                                                <i class="fas fa-file-contract me-1"></i>
                                                                                استندات المنافسين:
                                                                            </span>
                                                                            <span
                                                                                class="fw-bold"><?php echo e($note->competitor_documents); ?></span>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>

                                                    <!-- المرفقات -->
                                                    <?php
                                                        $files = json_decode($note->attachments, true);
                                                        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                                                    ?>

                                                    <?php if(is_array($files) && count($files)): ?>
                                                        <div class="attachments mt-3">
                                                            <h6 class="mb-2">
                                                                <i class="fas fa-paperclip me-1"></i>
                                                                المرفقات:
                                                            </h6>
                                                            <div class="d-flex flex-wrap gap-2">
                                                                <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php
                                                                        $ext = pathinfo($file, PATHINFO_EXTENSION);
                                                                        $fileUrl = asset(
                                                                            'assets/uploads/notes/' . $file,
                                                                        );
                                                                    ?>

                                                                    <?php if(in_array(strtolower($ext), $imageExtensions)): ?>
                                                                        <a href="<?php echo e($fileUrl); ?>"
                                                                            data-fancybox="gallery-<?php echo e($note->id); ?>"
                                                                            class="d-inline-block me-2 mb-2">
                                                                            <img src="<?php echo e($fileUrl); ?>"
                                                                                alt="مرفق صورة" class="img-thumbnail"
                                                                                style="width: 100px; height: 100px; object-fit: cover;">
                                                                        </a>
                                                                    <?php else: ?>
                                                                        <a href="<?php echo e($fileUrl); ?>" target="_blank"
                                                                            class="btn btn-sm btn-outline-primary d-inline-flex align-items-center">
                                                                            <i class="fas fa-file-alt me-2"></i>
                                                                            <?php echo e(Str::limit($file, 15)); ?>

                                                                        </a>
                                                                    <?php endif; ?>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>

                                                    <!-- أدوات الملاحظة -->
                                                    <div
                                                        class="note-actions mt-3 pt-2 border-top d-flex justify-content-end gap-2">
                                                        <button class="btn btn-sm btn-outline-secondary edit-note"
                                                            data-note-id="<?php echo e($note->id); ?>"
                                                            data-process="<?php echo e($note->process); ?>"
                                                            data-description="<?php echo e($note->description); ?>"
                                                            data-deposit-count="<?php echo e($note->deposit_count); ?>"
                                                            data-site-type="<?php echo e($note->site_type); ?>"
                                                            data-competitor-documents="<?php echo e($note->competitor_documents); ?>">
                                                            <i class="fas fa-edit me-1"></i> تعديل
                                                        </button>
                                                        <form action="" method="POST" class="d-inline">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                onclick="return confirm('هل أنت متأكد من حذف هذه الملاحظة؟')">
                                                                <i class="fas fa-trash me-1"></i> حذف
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>

                                                <!-- نقطة الخط الزمني -->
                                                <div class="timeline-dot bg-primary d-none d-md-block ms-3 mt-2"></div>
                                            </div>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <div class="alert alert-info text-center py-4">
                                                <i class="fas fa-info-circle fa-2x mb-3"></i>
                                                <h5>لا توجد ملاحظات مسجلة</h5>
                                                <p class="mb-0">يمكنك إضافة ملاحظة جديدة بالضغط على زر "إضافة ملاحظة"</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- ترقيم الصفحات -->

                                </div>
                            </div>

                            <!-- مودال إضافة ملاحظة -->
                            <div class="modal fade" id="addNoteModal" tabindex="-1" aria-labelledby="addNoteModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <form action="" method="POST" enctype="multipart/form-data">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="client_id" value="<?php echo e($client->id); ?>">

                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title" id="addNoteModalLabel">
                                                    <i class="fas fa-plus-circle me-2"></i>
                                                    إضافة ملاحظة جديدة
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="process" class="form-label">نوع العملية</label>
                                                        <select class="form-select" id="process" name="process" required>
                                                            <option value="" selected disabled>اختر نوع العملية</option>
                                                            <option value="مكالمة هاتفية">مكالمة هاتفية</option>
                                                            <option value="زيارة ميدانية">زيارة ميدانية</option>
                                                            <option value="مراسلة">مراسلة</option>
                                                            <option value="متابعة">متابعة</option>
                                                            <option value="تحديث بيانات">تحديث بيانات</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label for="status" class="form-label">الحالة</label>
                                                        <select class="form-select" id="status" name="status">
                                                            <option value="" selected disabled>اختر الحالة</option>
                                                            <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($status->name); ?>"><?php echo e($status->name); ?>

                                                                </option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>

                                                    <div class="col-12 mb-3">
                                                        <label for="description" class="form-label">الوصف</label>
                                                        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                                                    </div>

                                                    <!-- البيانات الإضافية -->
                                                    <div class="col-md-4 mb-3">
                                                        <label for="deposit_count" class="form-label">عدد العهدة
                                                            (اختياري)</label>
                                                        <input type="number" class="form-control" id="deposit_count"
                                                            name="deposit_count">
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <label for="site_type" class="form-label">نوع الموقع (اختياري)</label>
                                                        <select class="form-select" id="site_type" name="site_type">
                                                            <option value="" selected disabled>اختر نوع الموقع</option>
                                                            <option value="independent_booth">بسطة مستقلة</option>
                                                            <option value="grocery">بقالة</option>
                                                            <option value="supplies">تموينات</option>
                                                            <option value="markets">أسواق</option>
                                                            <option value="station">محطة</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <label for="competitor_documents" class="form-label">استندات المنافسين
                                                            (اختياري)</label>
                                                        <input type="text" class="form-control" id="competitor_documents"
                                                            name="competitor_documents">
                                                    </div>

                                                    <div class="col-12 mb-3">
                                                        <?php
                                                        $files = json_decode($note->attachments, true);
                                                        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                                                    ?>

                                                    <?php if(is_array($files) && count($files)): ?>
                                                        <div class="attachment mt-3 d-flex flex-wrap gap-2">
                                                            <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php
                                                                    $ext = pathinfo($file, PATHINFO_EXTENSION);
                                                                    $fileUrl = asset('assets/uploads/notes/' . $file);
                                                                ?>

                                                                <?php if(in_array(strtolower($ext), $imageExtensions)): ?>
                                                                    <a href="<?php echo e($fileUrl); ?>" target="_blank"
                                                                        class="d-block">
                                                                        <img src="<?php echo e($fileUrl); ?>" alt="مرفق صورة"
                                                                            class="img-fluid rounded border"
                                                                            style="max-width: 180px; height: auto;">
                                                                    </a>
                                                                <?php else: ?>
                                                                    <a href="<?php echo e($fileUrl); ?>" target="_blank"
                                                                        class="btn btn-sm btn-outline-primary d-flex align-items-center">
                                                                        <i class="fas fa-file-alt me-2"></i> عرض الملف:
                                                                        <?php echo e($file); ?>

                                                                    </a>
                                                                <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </div>
                                                    <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    <i class="fas fa-times me-1"></i> إلغاء
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-save me-1"></i> حفظ الملاحظة
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- مودال تعديل ملاحظة -->
                            <div class="modal fade" id="editNoteModal" tabindex="-1" aria-labelledby="editNoteModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <form id="editNoteForm" method="POST" enctype="multipart/form-data">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>

                                            <div class="modal-header bg-warning text-dark">
                                                <h5 class="modal-title" id="editNoteModalLabel">
                                                    <i class="fas fa-edit me-2"></i>
                                                    تعديل الملاحظة
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">
                                                <!-- سيتم ملء هذا القسم عبر الجافاسكريبت -->
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    <i class="fas fa-times me-1"></i> إلغاء
                                                </button>
                                                <button type="submit" class="btn btn-warning text-white">
                                                    <i class="fas fa-save me-1"></i> حفظ التعديلات
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- ستايل إضافي لتبويب الملاحظات -->
                            <style>
                                .timeline {
                                    position: relative;
                                    padding-left: 30px;
                                }

                                .timeline-item {
                                    position: relative;
                                    margin-bottom: 25px;
                                }

                                .timeline-dot {
                                    position: absolute;
                                    left: -15px;
                                    top: 15px;
                                    width: 12px;
                                    height: 12px;
                                    border-radius: 50%;
                                    border: 2px solid #0d6efd;
                                }

                                .note-box {
                                    transition: all 0.3s ease;
                                    border-left: 3px solid #0d6efd;
                                }

                                .note-box:hover {
                                    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
                                }

                                .additional-data {
                                    border-right: 2px solid #0d6efd;
                                }

                                .note-actions {
                                    opacity: 0;
                                    transition: opacity 0.3s ease;
                                }

                                .note-box:hover .note-actions {
                                    opacity: 1;
                                }

                                @media (max-width: 768px) {
                                    .timeline {
                                        padding-left: 20px;
                                    }

                                    .timeline-dot {
                                        left: -10px;
                                        width: 10px;
                                        height: 10px;
                                    }
                                }
                            </style>

                            <div id="visits-tab" class="tab-pane">
                                <div class="card card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>تاريخ الزيارة</th>
                                                    <th>وقت الانصراف</th>
                                                    <th>الموظف</th>
                                                    <th>ملاحظات</th>
                                                    <th>الإجراءات</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $visits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $visit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($visit->id); ?></td>
                                                        <td><?php echo e($visit->visit_date); ?></td>
                                                        <td><?php echo e($visit->departure_time ?? '--'); ?></td>
                                                        <td><?php echo e($visit->employee->name ?? 'غير محدد'); ?></td>
                                                        <td><?php echo e(Str::limit($visit->notes, 30) ?? '--'); ?></td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn btn-sm bg-gradient-info fa fa-ellipsis-v"
                                                                    type="button"
                                                                    id="dropdownMenuButton<?php echo e($visit->id); ?>"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false"></button>
                                                                <div class="dropdown-menu dropdown-menu-end"
                                                                    aria-labelledby="dropdownMenuButton">
                                                                    <a class="dropdown-item" href="">
                                                                        <i class="fa fa-eye me-2 text-primary"></i>عرض التفاصيل
                                                                    </a>
                                                                    <a class="dropdown-item" href="">
                                                                        <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                                    </a>
                                                                    <form action="" method="POST" class="d-inline">
                                                                        <?php echo csrf_field(); ?>
                                                                        <?php echo method_field('DELETE'); ?>
                                                                        <button type="submit"
                                                                            class="dropdown-item text-danger"
                                                                            onclick="return confirm('هل أنت متأكد من حذف هذه الزيارة؟')">
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
                                    <?php if($visits->count() == 0): ?>
                                        <div class="alert alert-info text-center mt-3">
                                            لا توجد زيارات مسجلة لهذا العميل
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- محتوى تبويب الحجوزات -->
                            <div id="reservations-tab" class="tab-pane">
                                <div class="card card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="mb-0">حجوزات العميل</h5>
                                        <a href="" class="btn btn-primary btn-sm">
                                            <i class="fas fa-plus me-1"></i> إضافة حجز جديد
                                        </a>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>رقم الحجز</th>
                                                    <th>الخدمة</th>
                                                    <th>التاريخ والوقت</th>
                                                    <th>الحالة</th>
                                                    <th>المبلغ</th>
                                                    <th>الإجراءات</th>
                                                </tr>
                                            </thead>
                                            
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- إضافة ستايل إضافي للتبويبات -->
            <style>
                .client-tabs {
                    font-family: 'Tajawal', sans-serif;
                }

                .tab-btn {
                    padding: 12px 20px;
                    background: none;
                    border: none;
                    border-bottom: 3px solid transparent;
                    cursor: pointer;
                    font-weight: 500;
                    color: #6c757d;
                    transition: all 0.3s;
                    position: relative;
                    display: flex;
                    align-items: center;
                }

                .tab-btn:hover {
                    color: #0d6efd;
                    background-color: #f8f9fa;
                }

                .tab-btn.active {
                    color: #0d6efd;
                    border-bottom-color: #0d6efd;
                    background-color: #f8f9fa;
                }

                .tab-pane {
                    display: none;
                }

                .tab-pane.active {
                    display: block;
                }

                .quick-info {
                    border-right: 3px solid #0d6efd;
                }

                .info-item {
                    display: flex;
                    flex-direction: column;
                }

                @media (max-width: 768px) {
                    .tab-btn {
                        padding: 10px 15px;
                        font-size: 14px;
                        flex: 1 0 50%;
                    }

                    .quick-info .row>div {
                        margin-bottom: 10px;
                    }
                }

                @media (max-width: 576px) {
                    .tab-btn {
                        flex: 1 0 100%;
                        justify-content: center;
                    }
                }

                /* تحسينات للجداول على الأجهزة الصغيرة */
                .table-responsive {
                    overflow-x: auto;
                    -webkit-overflow-scrolling: touch;
                }

                /* تحسينات للخط الزمني */
                .timeline {
                    position: relative;
                    padding-left: 50px;
                }

                .timeline-item {
                    position: relative;
                    margin-bottom: 30px;
                }

                .timeline-dot {
                    position: absolute;
                    left: -25px;
                    top: 15px;
                    width: 20px;
                    height: 20px;
                    border-radius: 50%;
                }

                .note-box {
                    transition: all 0.3s ease;
                }

                .note-box:hover {
                    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                }
            </style>

            <!-- سكريبت لإدارة التبويبات -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // تبديل التبويبات
                    const tabButtons = document.querySelectorAll('.tab-btn');

                    tabButtons.forEach(button => {
                        button.addEventListener('click', function() {
                            // إزالة النشاط من جميع الأزرار
                            tabButtons.forEach(btn => btn.classList.remove('active'));

                            // إضافة النشاط للزر المحدد
                            this.classList.add('active');

                            // إخفاء جميع محتويات التبويبات
                            document.querySelectorAll('.tab-pane').forEach(pane => {
                                pane.classList.remove('active');
                            });

                            // إظهار محتوى التبويب المحدد
                            const targetId = this.getAttribute('data-target');
                            document.getElementById(targetId).classList.add('active');
                        });
                    });

                    // فلترة المواعيد
                    const filterButtons = document.querySelectorAll('.filter-appointments');
                    filterButtons.forEach(button => {
                        button.addEventListener('click', function() {
                            const filter = this.getAttribute('data-filter');
                            const rows = document.querySelectorAll(
                                '#appointments-container tr[data-appointment-id]');

                            rows.forEach(row => {
                                if (filter === 'all' || row.getAttribute('data-status') ===
                                    filter) {
                                    row.style.display = '';
                                } else {
                                    row.style.display = 'none';
                                }
                            });

                            // تحديث الأزرار النشطة
                            filterButtons.forEach(btn => btn.classList.remove('active'));
                            this.classList.add('active');
                        });
                    });

                    // جعل صفوف الجدول قابلة للنقر
                    document.querySelectorAll('.invoice-row').forEach(row => {
                        row.addEventListener('click', function(e) {
                            // تجنب فتح الرابط إذا تم النقر على عنصر منسدل أو زر
                            if (!e.target.closest('.dropdown') && !e.target.closest(
                                    'input[type="checkbox"]')) {
                                window.location.href = this.getAttribute('data-href');
                            }
                        });
                    });
                });
            </script>

            <!-- Modal إضافة الرصيد الافتتاحي -->
            <div class="modal fade" id="openingBalanceModal" tabindex="-1" aria-labelledby="openingBalanceModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="openingBalanceModalLabel">إضافة رصيد افتتاحي</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="openingBalanceForm">
                                <div class="mb-3">
                                    <label for="openingBalance" class="form-label">الرصيد الافتتاحي</label>
                                    <input type="number" class="form-control" id="openingBalance" name="opening_balance"
                                        value="<?php echo e($client->opening_balance ?? 0); ?>" step="0.01">
                                </div>
                                <input type="hidden" id="clientId" value="<?php echo e($client->id); ?>">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                            <button type="button" class="btn btn-primary" onclick="saveOpeningBalance()">حفظ</button>
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
                            alert('تم تحديث الرصيد الافتتاحي بنجاح');
                            location.reload();
                        } else {
                            alert('حدث خطأ أثناء التحديث، يرجى المحاولة مجدداً.');
                        }
                    })
                    .catch(error => console.error('❌ خطأ:', error));
            }

            function selectStatus(name, color) {
                document.getElementById("clientStatusDropdown").innerHTML =
                    `<span class="status-color" style="background-color: ${color};"></span> ${name}`;
            }
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let mediaRecorder;
                let audioChunks = [];

                document.getElementById("startRecording").addEventListener("click", async function() {
                    let stream = await navigator.mediaDevices.getUserMedia({
                        audio: true
                    });
                    mediaRecorder = new MediaRecorder(stream);
                    mediaRecorder.start();
                    audioChunks = [];

                    mediaRecorder.ondataavailable = event => audioChunks.push(event.data);
                    mediaRecorder.onstop = async () => {
                        let audioBlob = new Blob(audioChunks, {
                            type: "audio/wav"
                        });
                        let audioUrl = URL.createObjectURL(audioBlob);
                        document.getElementById("audioPreview").src = audioUrl;
                        document.getElementById("audioPreview").classList.remove("d-none");

                        let reader = new FileReader();
                        reader.readAsDataURL(audioBlob);
                        reader.onloadend = function() {
                            document.getElementById("recordedAudio").value = reader.result;
                        };
                    };

                    document.getElementById("stopRecording").classList.remove("d-none");
                    document.getElementById("startRecording").classList.add("d-none");
                });

                document.getElementById("stopRecording").addEventListener("click", function() {
                    mediaRecorder.stop();
                    document.getElementById("stopRecording").classList.add("d-none");
                    document.getElementById("startRecording").classList.remove("d-none");
                });
            });
            document.addEventListener('DOMContentLoaded', function() {
                // إذا كان هناك عميل محدد، قم باختياره في القائمة
                <?php if(isset($client_id)): ?>
                    $('#clientSelect').val('<?php echo e($client_id); ?>').trigger('change');
                <?php endif; ?>

                // أو إذا كان هناك كائن عميل
                <?php if(isset($client) && $client): ?>
                    $('#clientSelect').val('<?php echo e($client->id); ?>').trigger('change');
                <?php endif; ?>
            });
        </script>


        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtrasmart\fawtrasmart\resources\views/client/show.blade.php ENDPATH**/ ?>