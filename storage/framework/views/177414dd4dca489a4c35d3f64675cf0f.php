<?php $__env->startSection('title'); ?>
    إدارة العملاء
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <style>
        #map {
            height: 85vh;
            width: 100%;
            position: relative;
        }

        /* تصميم صندوق البحث على غرار جوجل مابس */
        .pac-card {
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            width: 400px;
            font-family: Roboto, Arial, sans-serif;
        }

        .search-container {
            padding: 0;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            height: 48px;
            display: flex;
            align-items: center;
        }

        .search-box {
            width: 100%;
            height: 100%;
            border: none;
            padding: 0 16px 0 48px;
            font-size: 15px;
            border-radius: 8px;
            direction: rtl;
        }

        .search-box:focus {
            outline: none;
        }

        .search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
            font-size: 18px;
        }

        /* تصميم لوحة التحكم على غرار جوجل مابس */
        .map-controls {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 1000;
        }

        .map-control-group {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            margin-bottom: 10px;
            overflow: hidden;
        }

        .map-control-button {
            width: 40px;
            height: 40px;
            background: #fff;
            border: none;
            border-bottom: 1px solid #e6e6e6;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.2s;
        }

        .map-control-button:last-child {
            border-bottom: none;
        }

        .map-control-button:hover {
            background-color: #f1f1f1;
        }

        .map-control-button i {
            color: #666;
            font-size: 18px;
        }

        /* تصميم نافذة المعلومات على غرار جوجل مابس */
        .gm-style .gm-style-iw-c {
            padding: 0 !important;
            border-radius: 8px !important;
            max-width: 300px !important;
        }

        .gm-style .gm-style-iw-d {
            overflow: hidden !important;
            padding: 0 !important;
        }

        .client-info-window {
            font-family: Roboto, Arial, sans-serif;
        }

        .info-header {
            padding: 12px 16px;
            border-bottom: 1px solid #e6e6e6;
        }

        .info-content {
            padding: 16px;
        }

        .info-row {
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }

        .info-label {
            color: #666;
            margin-left: 8px;
            font-size: 13px;
        }

        .info-value {
            color: #333;
            font-size: 13px;
        }

        .info-actions {
            display: flex;
            gap: 8px;
            margin-top: 16px;
        }

        .info-button {
            flex: 1;
            padding: 8px;
            border: none;
            border-radius: 4px;
            font-size: 13px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            transition: background-color 0.2s;
        }

        .info-button.primary {
            background: #1a73e8;
            color: white;
        }

        .info-button.secondary {
            background: #fff;
            color: #1a73e8;
            border: 1px solid #1a73e8;
        }

        .info-button:hover {
            opacity: 0.9;
        }

        .hover-effect:hover {
            background-color: #f8f9fa;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .btn-indigo {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            border: none;
        }

        .btn-violet {
            background: linear-gradient(135deg, #9c27b0 0%, #e91e63 100%);
            color: white;
            border: none;
        }

        .btn-orange {
            background: linear-gradient(135deg, #ff7b00 0%, #ff9a00 100%);
            color: white;
            border: none;
        }

        /* تأثيرات عند المرور */
        .btn-hover-shine:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            opacity: 0.92;
            transition: all 0.2s ease;
        }

        /* تأثير إضاءة خفيف */
        .btn-hover-shine:after {
            content: "";
            position: absolute;
            top: -50%;
            left: -60%;
            width: 200%;
            height: 200%;
            background: rgba(255, 255, 255, 0.15);
            transform: rotate(30deg);
            transition: all 0.3s ease;
        }

        .btn-hover-shine:hover:after {
            left: 100%;
        }

        /* تكيف مع الشاشات الصغيرة */
        @media (max-width: 768px) {
            .card-body {
                padding: 0.75rem;
            }

            .btn-sm {
                height: 32px !important;
                font-size: 0.8rem;
            }

            .fs-6 {
                font-size: 0.8rem !important;
            }

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

        .card {
            transition: all 0.3s ease;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn {
            border-radius: 0.25rem;
            transition: all 0.2s ease;
        }

        .badge {
            padding: 0.5em 0.75em;
            border-radius: 0.25rem;
        }

        .collapse-section {
            margin-bottom: 1rem;
        }

        .table th {
            white-space: nowrap;
        }

        .dropdown-menu {
            border-radius: 0.25rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        #clientSearch {
            transition: all 0.3s ease;
            border: 1px solid #ddd;
        }

        #clientSearch:focus {
            outline: none;
            border-color: #80bdff;
        }

        .input-group-text {
            color: #6c757d;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('layouts.alerts.success', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('layouts.alerts.error', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">إدارة العملاء</h2>
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

    <div class="content-body">
        <div class="position-relative">
            <div id="map"></div>
            <div class="pac-card">
                <div class="search-container">
                    <input type="text" id="clientSearch" class="search-box" placeholder="ابحث عن عميل...">
                    <i class="fas fa-search search-icon"></i>
                </div>
            </div>
            <div class="map-controls">
                <div class="map-control-group">
                    <button class="map-control-button" onclick="map.setZoom(map.getZoom() + 1)" title="تكبير">
                        <i class="fas fa-plus"></i>
                    </button>
                    <button class="map-control-button" onclick="map.setZoom(map.getZoom() - 1)" title="تصغير">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
                <div class="map-control-group">
                    <button class="map-control-button" onclick="getCurrentLocation()" title="موقعي الحالي">
                        <i class="fas fa-location-arrow"></i>
                    </button>
                    <button class="map-control-button" onclick="resetMapView()" title="إعادة ضبط الخريطة">
                        <i class="fas fa-redo-alt"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- بطاقة الإجراءات -->
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-3">
                <div class="row align-items-center gy-2">
                    <!-- زر إضافة عميل -->
                    <div class="col-12 col-md-6 col-lg-3">
                        <a href="<?php echo e(route('clients.create')); ?>"
                            class="btn btn-success btn-sm rounded-pill px-3 w-100 d-flex align-items-center justify-content-center"
                            style="height: 36px;">
                            <i class="fas fa-user-plus me-2 fs-6"></i>
                            <span class="fw-medium">إضافة عميل</span>
                        </a>
                    </div>

                    <!-- زر تحميل ملف Excel -->
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="d-flex flex-column flex-md-row gap-2">
                            <label
                                class="btn btn-info btn-sm rounded-pill px-2 w-100 d-flex align-items-center justify-content-center"
                                style="height: 36px;">
                                <i class="fas fa-cloud-upload-alt me-2 fs-6"></i>
                                <span class="fw-medium">تحميل</span>
                                <input type="file" name="file" class="d-none" required>
                            </label>
                            <button type="submit"
                                class="btn btn-secondary btn-sm rounded-pill px-2 w-100 d-flex align-items-center justify-content-center"
                                style="height: 36px;">
                                <i class="fas fa-database me-2 fs-6"></i>
                                <span class="fw-medium">استيراد</span>
                            </button>
                        </div>
                    </div>

                    <!-- زر إضافة حد ائتماني -->
                    <div class="col-12 col-md-6 col-lg-3">
                        <a href="javascript:void(0);"
                            class="btn btn-danger btn-sm rounded-pill px-3 w-100 d-flex align-items-center justify-content-center"
                            style="height: 36px;" data-bs-toggle="modal" data-bs-target="#creditLimitModal">
                            <i class="fas fa-credit-card me-2 fs-6"></i>
                            <span class="fw-medium">حد ائتماني</span>
                        </a>
                    </div>

                    <!-- زر التقارير -->

                </div>
            </div>
        </div>


        <!-- بطاقة البحث -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center p-2">
                <div class="d-flex gap-2">
                    <span class="hide-button-text">بحث وتصفية</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-outline-secondary btn-sm" onclick="toggleSearchFields(this)">
                        <i class="fa fa-times"></i>
                        <span class="hide-button-text">إخفاء</span>
                    </button>
                    <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="collapse"
                        data-bs-target="#advancedSearchForm" onclick="toggleSearchText(this)">
                        <i class="fa fa-filter"></i>
                        <span class="button-text">متقدم</span>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form class="form" id="searchForm" method="GET" action="<?php echo e(route('clients.index')); ?>">
                    <div class="card p-3 mb-4">
                        <div class="row g-3 align-items-end">
                            <!-- اسم العميل -->
                            <div class="col-md-3 col-12">
                                <label for="client" class="form-label">العميل</label>
                                <select name="client" id="client" class="form-control select2">
                                    <option value="">اختر العميل</option>
                                    <?php $__currentLoopData = $allClients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($client->id); ?>"
                                            <?php echo e(request('client') == $client->id ? 'selected' : ''); ?>>
                                            <?php echo e($client->trade_name); ?> - <?php echo e($client->code); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <!-- الاسم -->
                            <div class="col-md-3 col-12">
                                <label for="name" class="form-label">الاسم</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="الاسم" value="<?php echo e(request('name')); ?>">
                            </div>

                            <!-- الحالة -->
                            <div class="col-md-3 col-12">
                                <label for="status" class="form-label">الحالة</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">اختر الحالة</option>
                                    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($status->id); ?>"
                                            <?php echo e(request('status') == $status->id ? 'selected' : ''); ?>>
                                            <?php echo e($status->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <!-- المجموعة -->
                            <div class="col-md-3 col-12">
                                <label for="region" class="form-label">المجموعة</label>
                                <select name="region" id="region" class="form-control select2">
                                    <option value="">اختر المجموعة</option>
                                    <?php $__currentLoopData = $Region_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Region_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($Region_group->id); ?>"
                                            <?php echo e(request('region') == $Region_group->id ? 'selected' : ''); ?>>
                                            <?php echo e($Region_group->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <!-- الحي -->
                            <div class="col-md-12 col-12">
                                <label for="neighborhood" class="form-label">الحي</label>
                                <input type="text" name="neighborhood" id="neighborhood" class="form-control"
                                    placeholder="الحي" value="<?php echo e(request('neighborhood')); ?>">
                            </div>
                        </div>
                    </div>



                    <div class="collapse" id="advancedSearchForm">
                        <div class="row g-3 mt-2">
                            <div class="col-md-4 col-12">
                                <select name="classifications" class="form-control">
                                    <option value="">اختر التصنيف</option>
                                    <option value="1" <?php echo e(request('classifications') == '1' ? 'selected' : ''); ?>>
                                    </option>
                                    <option value="0" <?php echo e(request('classifications') == '0' ? 'selected' : ''); ?>>
                                    </option>
                                    <option value="0" <?php echo e(request('classifications') == '0' ? 'selected' : ''); ?>>
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-4 col-12">
                                <input type="date" name="end_date_to" class="form-control"
                                    placeholder="تاريخ الانتهاء (من)" value="<?php echo e(request('end_date_to')); ?>">
                            </div>
                            <div class="col-md-4 col-12">
                                <input type="date" name="end_date_to" class="form-control"
                                    placeholder="تاريخ الانتهاء (الى)" value="<?php echo e(request('end_date_to')); ?>">
                            </div>
                            <div class="form-group col-md-4 col-12">
                                <input type="text" name="address" class="form-control" placeholder="العنوان"
                                    value="<?php echo e(request('address')); ?>">
                            </div>
                            <div class="form-group col-md-4 col-12">
                                <input type="text" name="postal_code" class="form-control"
                                    placeholder="الرمز البريدي" value="<?php echo e(request('postal_code')); ?>">
                            </div>
                            <div class="col-md-4 col-12">
                                <select name="country" class="form-control">
                                    <option value="">اختر البلد</option>
                                    <option value="1" <?php echo e(request('country') == '1' ? 'selected' : ''); ?>>السعودية
                                    </option>
                                    <option value="0" <?php echo e(request('country') == '0' ? 'selected' : ''); ?>>مصر</option>
                                    <option value="0" <?php echo e(request('country') == '0' ? 'selected' : ''); ?>>اليمن
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-4 col-12">
                                <select name="tage" class="form-control">
                                    <option value="">اختر الوسم</option>
                                    <option value="1" <?php echo e(request('tage') == '1' ? 'selected' : ''); ?>></option>
                                    <option value="0" <?php echo e(request('tage') == '0' ? 'selected' : ''); ?>></option>
                                    <option value="0" <?php echo e(request('tage') == '0' ? 'selected' : ''); ?>></option>
                                </select>
                            </div>
                            <div class="col-md-4 col-12">
                                <select name="user" class="form-control">
                                    <option value="">أضيفت بواسطة</option>
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($user->id); ?>"
                                            <?php echo e(request('user') == $user->id ? 'selected' : ''); ?>>
                                            <?php echo e($user->name); ?> - <?php echo e($user->id); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-4 col-12">
                                <select name="type" class="form-control">
                                    <option value="">اختر النوع</option>
                                    <option value="1" <?php echo e(request('type') == '1' ? 'selected' : ''); ?>></option>
                                    <option value="0" <?php echo e(request('type') == '0' ? 'selected' : ''); ?>></option>
                                    <option value="0" <?php echo e(request('type') == '0' ? 'selected' : ''); ?>></option>
                                </select>
                            </div>
                            <div class="col-md-4 col-12">
                                <select name="full_name" class="form-control">
                                    <option value="">اختر الموظفين المعيين</option>
                                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($employee->id); ?>"
                                            <?php echo e(request('employee') == $employee->id ? 'selected' : ''); ?>>
                                            <?php echo e($employee->full_name); ?> - <?php echo e($employee->id); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions mt-2">
                        <button type="submit" class="btn btn-primary">بحث</button>
                        <a href="<?php echo e(route('clients.index')); ?>" type="reset" class="btn btn-outline-warning">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- جدول العملاء -->
        <!-- جدول العملاء -->
      <?php if(isset($clients) && $clients->count() > 0): ?>
    <div class="row">
        <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $clientData = $clientsData[$client->id] ?? null;
                $due = $clientDueBalances[$client->id] ?? 0;
            ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <a href="<?php echo e(route('clients.show', $client->id)); ?>" class="text-decoration-none text-dark">
                    <div class="card shadow-sm border border-1 rounded-3" style="height: 380px; overflow: hidden;"> <!-- زيادة الارتفاع قليلاً وإضافة overflow -->
                        <div class="card-body">
                            <!-- Card Header Section -->
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="client-meta">
                                    <?php if($client->status_client): ?>
                                        <span class="client-status" style="background-color: <?php echo e($client->status_client->color); ?>; font-size: 11px; padding: 1px 6px;">
                                            <?php echo e($client->status_client->name); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="client-status" style="background-color: #6c757d; font-size: 11px; padding: 1px 6px;">
                                            غير محدد
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="ms-auto" style="transform: scale(0.8); transform-origin: top right;"> <!-- تصغير حجم الدائرة -->
                                    <svg width="70" height="70" viewBox="0 0 36 36" class="circular-chart">
                                        <path class="circle-bg" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                        <path class="circle" stroke-dasharray="<?php echo e($clientData['percentage'] ?? 0); ?>, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                        <text x="18" y="21" text-anchor="middle" class="percentage" font-size="7" fill="#333">
                                            <?php if(!empty($clientData['group'])): ?>
                                                <tspan x="18" dy="0" font-size="7" fill="#333">
                                                    <?php echo e($clientData['group']); ?></tspan>
                                            <?php endif; ?>
                                        </text>
                                    </svg>
                                </div>
                            </div>

                            <!-- Client Info Section -->
                            <div class="client-info" style="overflow: hidden; flex-grow: 1;">
                                <div class="text-muted small mb-1" style="font-size: 11px;">
                                    <i class="far fa-calendar-alt me-1"></i>
                                    تاريخ الإضافة: <?php echo e($client->created_at->format('d-m-Y')); ?>

                                </div>

                                <h6 class="client-name text-primary mb-1" style="font-size: 14px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo e($client->trade_name); ?></h6>
                                <?php if($client->code): ?>
                                    <div class="client-code text-muted small mb-1" style="font-size: 11px;">
                                        <i class="fas fa-hashtag me-1"></i>
                                        <?php echo e($client->code); ?>

                                    </div>
                                <?php endif; ?>

                                <div class="client-contact text-muted small mb-2" style="font-size: 11px; line-height: 1.4;">
                                    <div class="mb-1">
                                        <i class="fas fa-user me-1"></i>
                                        <?php echo e($client->first_name); ?> <?php echo e($client->last_name); ?>

                                    </div>
                                    <?php if($client->email): ?>
                                        <div class="mb-1" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            <i class="fas fa-envelope me-1"></i>
                                            <?php echo e($client->email); ?>

                                        </div>
                                    <?php endif; ?>
                                    <?php if($client->phone): ?>
                                        <div class="mb-1">
                                            <i class="fas fa-phone me-1"></i>
                                            <?php echo e($client->phone); ?>

                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <i class="fas fa-users me-1"></i>
                                        <?php echo e($client->Neighborhoodname->Region->name ?? ''); ?>

                                    </div>
                                </div>
                            </div>

                            <!-- Client Actions -->
                            <div class="client-actions d-flex justify-content-between mt-auto pt-2 border-top">
                                <a href="<?php echo e(route('clients.show', $client->id)); ?>" class="btn btn-outline-primary btn-sm px-2 py-1" style="font-size: 11px;">
                                    <i class="far fa-eye me-1"></i> عرض
                                </a>
                                <?php if(auth()->user()->hasPermissionTo('Edit_Client')): ?>
                                    <a href="<?php echo e(route('clients.edit', $client->id)); ?>" class="btn btn-outline-secondary btn-sm px-2 py-1" style="font-size: 11px;">
                                        <i class="far fa-edit me-1"></i> تعديل
                                    </a>
                                <?php endif; ?>
                                <?php if(auth()->user()->hasPermissionTo('Delete_Client')): ?>
                                    <a href="<?php echo e(route('clients.destroy', $client->id)); ?>" class="btn btn-outline-danger btn-sm px-2 py-1" style="font-size: 11px;">
                                        <i class="far fa-trash-alt me-1"></i> حذف
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php else: ?>
    <div class="alert alert-info text-center py-3" role="alert" style="font-size: 14px;">
        <i class="fas fa-info-circle fa-lg mb-2"></i>
        <h5 class="mb-0" style="font-size: 16px;">لا توجد عملاء مسجلين حالياً</h5>
    </div>
<?php endif; ?>

<style>
    /* Progress Circle Styles */
    .circular-chart {
        display: block;
        width: 80px;
        height: 80px;
    }

    .circle-bg {
        fill: none;
        stroke: #f3f4f6;
        stroke-width: 2.8;
    }

    .circle {
        fill: none;
        stroke: #4CC790;
        stroke-width: 2.8;
        stroke-linecap: round;
        animation: progress 1s ease-out forwards;
    }

    .percentage {
        fill: #4a5568;
        font-size: 0.5em;
        text-anchor: middle;
        font-weight: bold;
    }

    @keyframes progress {
        0% {
            stroke-dasharray: 0 100;
        }
    }

    /* Client Status */
    .client-status {
        color: #fff;
        border-radius: 4px;
        display: inline-block;
    }

    /* Responsive Adjustments */
    @media (max-width: 767.98px) {
        .card {
            height: auto !important;
        }

        .client-meta {
            align-items: flex-start;
        }

        .circular-chart {
            width: 60px;
            height: 60px;
        }
    }
</style>
        <?php if($clients->hasPages()): ?>
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm mb-0">
                    <!-- زر الانتقال إلى أول صفحة -->
                    <?php if($clients->onFirstPage()): ?>
                        <li class="page-item disabled">
                            <span class="page-link border-0 rounded-pill" aria-label="First">
                                <i class="fas fa-angle-double-right"></i>
                            </span>
                        </li>
                    <?php else: ?>
                        <li class="page-item">
                            <a class="page-link border-0 rounded-pill" href="<?php echo e($clients->url(1)); ?>" aria-label="First">
                                <i class="fas fa-angle-double-right"></i>
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- زر الانتقال إلى الصفحة السابقة -->
                    <?php if($clients->onFirstPage()): ?>
                        <li class="page-item disabled">
                            <span class="page-link border-0 rounded-pill" aria-label="Previous">
                                <i class="fas fa-angle-right"></i>
                            </span>
                        </li>
                    <?php else: ?>
                        <li class="page-item">
                            <a class="page-link border-0 rounded-pill" href="<?php echo e($clients->previousPageUrl()); ?>"
                                aria-label="Previous">
                                <i class="fas fa-angle-right"></i>
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- عرض رقم الصفحة الحالية -->
                    <li class="page-item">
                        <span class="page-link border-0 bg-light rounded-pill px-3">
                            صفحة <?php echo e($clients->currentPage()); ?> من <?php echo e($clients->lastPage()); ?>

                        </span>
                    </li>

                    <!-- زر الانتقال إلى الصفحة التالية -->
                    <?php if($clients->hasMorePages()): ?>
                        <li class="page-item">
                            <a class="page-link border-0 rounded-pill" href="<?php echo e($clients->nextPageUrl()); ?>"
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
                    <?php if($clients->hasMorePages()): ?>
                        <li class="page-item">
                            <a class="page-link border-0 rounded-pill" href="<?php echo e($clients->url($clients->lastPage())); ?>"
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
        <?php endif; ?>

    </div>

    <!-- Modal إضافة حد ائتماني -->
    <div class="modal fade" id="creditLimitModal" tabindex="-1" aria-labelledby="creditLimitModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="creditLimitModalLabel">تعديل الحد الائتماني</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo e(route('clients.update_credit_limit')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="credit_limit" class="form-label">
                                الحد الائتماني الحالي: <span
                                    id="current_credit_limit"><?php echo e($creditLimit->value ?? 'غير محدد'); ?></span>
                            </label>
                            <input type="number" class="form-control" id="credit_limit" name="value"
                                value="<?php echo e($creditLimit->value ?? ''); ?>" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(env('GOOGLE_MAPS_API_KEY')); ?>&libraries=places&callback=initMap"
        async defer></script>
    <script>
        let map;
        let infoWindow;
        let currentUserMarker;

        function initMap() {
            const mapOptions = {
                zoom: 14,
                center: {
                    lat: 24.7136,
                    lng: 46.6753
                },
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                mapTypeControl: true,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                    position: google.maps.ControlPosition.TOP_RIGHT,
                    mapTypeIds: [
                        google.maps.MapTypeId.ROADMAP,
                        google.maps.MapTypeId.SATELLITE,
                        google.maps.MapTypeId.HYBRID,
                        google.maps.MapTypeId.TERRAIN
                    ]
                },
                zoomControl: true,
                zoomControlOptions: {
                    position: google.maps.ControlPosition.LEFT_CENTER
                },
                streetViewControl: true,
                streetViewControlOptions: {
                    position: google.maps.ControlPosition.LEFT_BOTTOM
                },
                fullscreenControl: true,
                fullscreenControlOptions: {
                    position: google.maps.ControlPosition.RIGHT_TOP
                },
            };

            map = new google.maps.Map(document.getElementById('map'), mapOptions);
            infoWindow = new google.maps.InfoWindow({
                maxWidth: 300
            });

            // تحديث تصميم نافذة المعلومات
            function showClientInfo(markerData) {
                if (infoWindow) {
                    infoWindow.close();
                }

                const contentString = `
        <div class="client-info-window" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; width: 300px; max-height: 400px; overflow-y: auto; box-shadow: 0 4px 12px rgba(0,0,0,0.15); border-radius: 10px; overflow: hidden;">
            <div class="info-header" style="background: linear-gradient(135deg, #3a0ca3 0%, #4361ee 100%); color: white; padding: 16px; text-align: center;">
                <h6 style="margin: 0; font-size: 18px; font-weight: 700;">
                    ${markerData.data.name}
                </h6>
            </div>

            <div class="info-content" style="padding: 16px; background: #f8f9fa;">
                <div style="display: grid; gap: 10px;">
                    <!-- هاتف العميل -->
                    <div class="info-row" style="display: flex; align-items: center; background: white; padding: 10px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                        <i class="fas fa-phone" style="color: #4361ee; width: 20px; text-align: center;"></i>
                        <span class="info-label" style="color: #6c757d; margin-right: 8px; font-size: 13px;">الهاتف:</span>
                        <a href="tel:${markerData.data.phone}" style="color: #4361ee; text-decoration: none; font-weight: 600; font-size: 14px;">
                            ${markerData.data.phone}
                        </a>
                    </div>

                    <!-- موقع العميل -->
                    <div class="info-row" style="display: flex; align-items: center; background: white; padding: 10px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                        <i class="fas fa-map-marker-alt" style="color: #f72585; width: 20px; text-align: center;"></i>
                        <span class="info-label" style="color: #6c757d; margin-right: 8px; font-size: 13px;">الموقع:</span>
                        <span class="info-value" style="color: #343a40; font-weight: 500; font-size: 14px;">
                            ${markerData.data.region}
                        </span>
                    </div>

                    <!-- رصيد العميل -->
                    <div class="info-row" style="display: flex; align-items: center; background: white; padding: 10px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                        <i class="fas fa-wallet" style="color: ${markerData.data.balance < 0 ? '#ef233c' : '#2b9348'}; width: 20px; text-align: center;"></i>
                        <span class="info-label" style="color: #6c757d; margin-right: 8px; font-size: 13px;">الرصيد:</span>
                        <span class="info-value" style="color: ${markerData.data.balance < 0 ? '#ef233c' : '#2b9348'}; font-weight: 700; font-size: 14px;">
                            ${markerData.data.balance} ر.س
                        </span>
                    </div>
                </div>

                <!-- أزرار الإجراءات -->
                <div class="info-actions" style="display: flex; gap: 10px; margin-top: 20px;">
                    <button onclick="window.location.href='<?php echo e(route('clients.show', '')); ?>/${markerData.data.id}'"
                        style="flex: 1; padding: 10px 12px; border: none; border-radius: 8px; background: linear-gradient(135deg, #28a745 0%, #5cb85c 100%); color: white; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; font-weight: 600; font-size: 14px; transition: all 0.2s ease;">
                        <i class="fas fa-info-circle"></i>
                        التفاصيل
                    </button>
                    <button onclick="openMap(${markerData.marker.getPosition().lat()}, ${markerData.marker.getPosition().lng()})"
                            style="flex: 1; padding: 10px 12px; border: 1px solid #4361ee; border-radius: 8px; background: white; color: #4361ee; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; font-weight: 600; font-size: 14px; transition: all 0.2s ease;">
                        <i class="fas fa-map-marked-alt"></i>
                        الخريطة
                    </button>
                </div>
            </div>
        </div>
    `;
                infoWindow = new google.maps.InfoWindow({
                    content: contentString,
                    maxWidth: 300
                });
                infoWindow.open(map, markerData.marker);
            }

            // إضافة علامات العملاء
            let allMarkers = [];

            <?php $__currentLoopData = $allClients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($client->locations && $client->locations->latitude && $client->locations->longitude): ?>
                    const marker<?php echo e($client->id); ?> = new google.maps.Marker({
                        position: {
                            lat: <?php echo e($client->locations->latitude); ?>,
                            lng: <?php echo e($client->locations->longitude); ?>

                        },
                        map: map,
                        title: "<?php echo e($client->trade_name); ?>",
                        icon: {
                            url: "data:image/svg+xml;charset=UTF-8," + encodeURIComponent(`
                                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="24" viewBox="0 0 60 24">
                                    <!-- Background bubble -->
                                    <rect x="0" y="0" width="60" height="16" rx="8" fill="<?php echo e(optional($client->status_client)->color ?? '#4CAF50'); ?>" />
                                    <!-- Bottom triangle -->
                                    <path d="M8 16 L12 22 L16 16 Z" fill="<?php echo e(optional($client->status_client)->color ?? '#4CAF50'); ?>" />
                                    <!-- Text -->
                                    <text x="30" y="12" font-family="Arial" font-size="10" font-weight="bold" text-anchor="middle" fill="white"><?php echo e($client->code); ?></text>
                                </svg>
                            `),
                            scaledSize: new google.maps.Size(60, 24),
                            anchor: new google.maps.Point(12, 22)
                        },
                        animation: google.maps.Animation.DROP
                    });

                    // إضافة الماركر للمصفوفة
                    allMarkers.push({
                        marker: marker<?php echo e($client->id); ?>,
                        clientName: "<?php echo e($client->trade_name); ?>".toLowerCase(),
                        clientCode: "<?php echo e($client->code); ?>".toLowerCase(),
                        data: {
                            id: <?php echo e($client->id); ?>,
                            name: "<?php echo e($client->trade_name); ?>",
                            status: "<?php echo e(optional($client->status_client)->color ?? '#CCCCCC'); ?>",
                            phone: "<?php echo e($client->phone); ?>",
                            region: "<?php echo e($client->Neighborhoodname->Region->name ?? ''); ?>",
                            balance: "<?php echo e($client->Balance()); ?>"
                        }
                    });

                    // إضافة مستمع حدث النقر
                    marker<?php echo e($client->id); ?>.addListener('click', () => {
                        showClientInfo(allMarkers.find(m => m.marker === marker<?php echo e($client->id); ?>));
                    });
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            // إضافة ماركر موقع المستخدم
            <?php if(isset($userLocation)): ?>
                var userLocation = {
                    lat: parseFloat('<?php echo e($userLocation->latitude); ?>'),
                    lng: parseFloat('<?php echo e($userLocation->longitude); ?>')
                };

                // إضافة ماركر موقع المستخدم
                const userMarker = new google.maps.Marker({
                    position: userLocation,
                    map: map,
                    icon: {
                        path: google.maps.SymbolPath.CIRCLE,
                        scale: 10,
                        fillColor: '#2196F3',
                        fillOpacity: 1,
                        strokeColor: '#ffffff',
                        strokeWeight: 2
                    },
                    title: 'موقعك الحالي'
                });

                // إضافة دائرة حول موقع المستخدم
                const userCircle = new google.maps.Circle({
                    strokeColor: '#2196F3',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: '#2196F3',
                    fillOpacity: 0.1,
                    map: map,
                    center: userLocation,
                    radius: 300 // نصف قطر 300 متر
                });
            <?php endif; ?>

            // تفعيل البحث
            const searchInput = document.getElementById('clientSearch');
            searchInput.addEventListener('input', function() {
                const searchValue = this.value.toLowerCase().trim();
                filterMarkers(searchValue, allMarkers);
            });
        }

        function filterMarkers(searchValue, markers) {
            markers.forEach(item => {
                const isVisible = item.clientName.includes(searchValue) ||
                    item.clientCode.includes(searchValue);
                item.marker.setVisible(isVisible);

                if (searchValue && (item.clientName === searchValue || item.clientCode === searchValue)) {
                    showClientInfo(item);
                    map.panTo(item.marker.getPosition());
                    map.setZoom(15);
                }
            });
        }

        function getCurrentLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const pos = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };

                        if (currentUserMarker) {
                            currentUserMarker.setPosition(pos);
                        } else {
                            currentUserMarker = new google.maps.Marker({
                                position: pos,
                                map: map,
                                icon: {
                                    url: "https://maps.google.com/mapfiles/ms/icons/blue-dot.png",
                                    scaledSize: new google.maps.Size(40, 40)
                                },
                                title: "موقعك الحالي",
                                animation: google.maps.Animation.DROP
                            });
                        }

                        map.setCenter(pos);
                        map.setZoom(14);
                    },
                    () => {
                        console.error("فشل في الحصول على الموقع");
                    }
                );
            }
        }

        function resetMapView() {
            if (currentUserMarker) {
                map.setCenter(currentUserMarker.getPosition());
                map.setZoom(14);
            } else {
                map.setCenter({
                    lat: 24.7136,
                    lng: 46.6753
                });
                map.setZoom(10);
            }
            infoWindow.close();
        }

        function openMap(lat, lng, title = '') {
            if (lat === 0 || lng === 0) {
                alert('لا يوجد إحداثيات متاحة لهذا العميل');
                return;
            }

            window.location.href = `https://www.google.com/maps?q=${lat},${lng}&z=17`;
        }

        function handleRowClick(event, url) {
            let target = event.target;

            // السماح بالنقر على العناصر التالية بدون تحويل
            if (target.tagName.toLowerCase() === 'a' ||
                target.closest('.dropdown-menu') ||
                target.closest('.btn') ||
                target.closest('.form-check-input')) {
                return;
            }

            // تحويل المستخدم لصفحة العميل عند الضغط على الصف
            window.location = url;
        }

        // إصلاح مشكلة عدم فتح الدروب داون
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".dropdown-toggle").forEach(function(dropdown) {
                dropdown.addEventListener("click", function(event) {
                    event.preventDefault();
                    event.stopImmediatePropagation();
                    let menu = this.nextElementSibling;
                    if (menu) {
                        menu.classList.toggle("show");
                    }
                });
            });

            // إغلاق الدروب داون عند النقر خارجها
            document.addEventListener("click", function(event) {
                document.querySelectorAll(".dropdown-menu").forEach(function(menu) {
                    if (!menu.parentElement.contains(event.target)) {
                        menu.classList.remove("show");
                    }
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/client/index.blade.php ENDPATH**/ ?>