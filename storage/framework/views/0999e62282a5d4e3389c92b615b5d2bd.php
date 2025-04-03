

<?php $__env->startSection('title'); ?>
    إدارة العملاء
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <style>
        #map {
            height: 500px;
            width: 100%;
            margin-bottom: 20px;
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
        <!-- الخريطة -->
        <div id="map"></div>

        <!-- بطاقة الإجراءات -->
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-body">
                <div class="row align-items-center gy-3">
                    <!-- القسم الأيمن -->
                    <div
                        class="col-md-6 d-flex flex-wrap align-items-center gap-2 justify-content-center justify-content-md-start">
                        <!-- زر إضافة عميل -->
                        <a href="<?php echo e(route('clients.create')); ?>"
                            class="btn btn-success btn-sm rounded-pill px-4 text-center">
                            <i class="fas fa-plus-circle me-1"></i>
                            إضافة عميل
                        </a>

                        <!-- زر استيراد -->
                        <form action="<?php echo e(route('clients.import')); ?>" method="POST" enctype="multipart/form-data"
                            class="d-inline-flex align-items-center gap-2">
                            <?php echo csrf_field(); ?>
                            <label class="btn btn-outline-primary btn-sm rounded-pill px-3 mb-0 text-center">
                                <i class="fas fa-upload"></i> تحميل ملف Excel
                                <input type="file" name="file" class="d-none" required>
                            </label>
                            <button type="submit"
                                class="btn btn-primary btn-sm rounded-pill px-3 text-center">استيراد</button>
                        </form>
                    </div>

                    <!-- القسم الأيسر -->
                    <div class="col-md-6 d-flex justify-content-center justify-content-md-end gap-2">
                        <!-- زر إضافة حد ائتماني -->
                        <a href="javascript:void(0);" class="btn btn-success btn-sm rounded-pill px-4 text-center"
                            data-bs-toggle="modal" data-bs-target="#creditLimitModal">
                            <i class="fas fa-plus-circle me-1"></i> إضافة حد ائتماني
                        </a>
                    </div>
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
                    <div class="row g-3">
                        <div class="col-md-4 col-12">
                            <select name="client" class="form-control select2">
                                <option value="">اختر العميل</option>
                                <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($client->id); ?>"
                                        <?php echo e(request('client') == $client->id ? 'selected' : ''); ?>>
                                        <?php echo e($client->trade_name); ?> - <?php echo e($client->id); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-4 col-12">
                            <input type="text" name="name" class="form-control" placeholder="الاسم"
                                value="<?php echo e(request('end_date_to')); ?>">
                        </div>
                        <div class="col-md-4 col-12">
                            <select name="status" class="form-control">
                                <option value="">اختر الحالة</option>
                                <option value="1" <?php echo e(request('status') == '1' ? 'selected' : ''); ?>>مديون</option>
                                <option value="0" <?php echo e(request('status') == '0' ? 'selected' : ''); ?>>دائن</option>
                                <option value="0" <?php echo e(request('status') == '0' ? 'selected' : ''); ?>>مميز</option>
                            </select>
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
        <?php if(isset($clients) && $clients->count() > 0): ?>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="fawtra">
                            <thead>
                                <tr>
                                    <th width="50">#</th>
                                    <th>معلومات العميل</th>
                                    <th>العنوان</th>
                                       <th>المجموعة</th>
                                          <th>الحي</th>
                                    <th>الكود</th>
                                    <th>رقم الهاتف</th>
                                    <th style="width: 10%">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    value="<?php echo e($client->id); ?>">
                                            </div>
                                        </td>
                                        <td>
                                            <h6 class="mb-0"><?php echo e($client->trade_name); ?></h6>
                                            <small class="text-muted"><?php echo e($client->code); ?></small>
                                            <p class="text-muted mb-0">
                                                <i class="fas fa-user me-1"></i>
                                                <?php echo e($client->first_name); ?> <?php echo e($client->last_name); ?>

                                            </p>
                                            <?php if($client->employee): ?>
                                                <p class="text-muted mb-0">
                                                    <i class="fas fa-user-tie me-1"></i>
                                                    <?php echo e($client->employee->first_name); ?> <?php echo e($client->employee->last_name); ?>

                                                </p>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <p class="mb-0">
                                                <i class="fas fa-map-marker-alt text-primary me-2"
                                                   style="cursor: pointer;"
                                                   onclick="openMap(<?php echo e($client->locations->latitude ?? 0); ?>, <?php echo e($client->locations->longitude ?? 0); ?>, '<?php echo e($client->trade_name); ?>')"></i>
                                                <?php echo e($client->city); ?>, <?php echo e($client->region); ?>

                                            </p>
                                        </td>
                                        <td><?php echo e($client->Neighborhoodname->Region->name ?? ""); ?></td>
                                           <td><?php echo e($client->Neighborhoodname->name ?? ""); ?></td>
                                           
                                        <td><?php echo e($client->code ?? ""); ?></td>
                                        <td>
                                            <strong class="text-primary">
                                                <i class="fas fa-phone me-2"></i><?php echo e($client->phone); ?>

                                            </strong>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <div class="dropdown">
                                                    <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1 btn-sm"
                                                        type="button" id="dropdownMenuButton303" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false"></button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton303">
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="<?php echo e(route('clients.show', $client->id)); ?>">
                                                                <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                            </a>
                                                        </li>
                                                        <?php if(auth()->user()->hasPermissionTo('Edit_Client')): ?>
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="<?php echo e(route('clients.edit', $client->id)); ?>">
                                                                    <i class="fa fa-pencil-alt me-2 text-success"></i>تعديل
                                                                </a>
                                                            </li>
                                                        <?php endif; ?>

                                                        <a class="dropdown-item"
                                                            href="<?php echo e(route('clients.send_info', $client->id)); ?>">
                                                            <i class="fa fa-pencil-alt me-2 text-success"></i> إرسال بيانات
                                                            الدخول
                                                        </a>


                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="<?php echo e(route('clients.edit', $client->id)); ?>">
                                                                <i class="fa fa-copy me-2 text-info"></i>نسخ
                                                            </a>
                                                        </li>
                                                        <?php if(auth()->user()->hasPermissionTo('Delete_Client')): ?>
                                                            <li>
                                                                <a class="dropdown-item text-danger" href="#"
                                                                    data-toggle="modal"
                                                                    data-target="#modal_DELETE<?php echo e($client->id); ?>">
                                                                    <i class="fa fa-trash-alt me-2"></i>حذف
                                                                </a>
                                                            </li>
                                                        <?php endif; ?>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="<?php echo e(route('clients.edit', $client->id)); ?>">
                                                                <i class="fa fa-file-invoice me-2 text-warning"></i>كشف
                                                                حساب
                                                            </a>
                                                        </li>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>


                                        <!-- Modal Delete -->
                                        <div class="modal fade" id="modal_DELETE<?php echo e($client->id); ?>" tabindex="-1"
                                            role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger">
                                                        <h5 class="modal-title text-white">تأكيد الحذف</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="<?php echo e(route('clients.destroy', $client->id)); ?>"
                                                        method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <div class="modal-body">
                                                            <p>هل أنت متأكد من الحذف
                                                                "<?php echo e($client->trade_name); ?>"؟</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">إلغاء</button>
                                                            <button type="submit" class="btn btn-danger">تأكيد
                                                                الحذف</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-danger text-xl-center" role="alert">
                <p class="mb-0">
                    لا توجد عملاء !!
                </p>
            </div>
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
  function openMap(lat, lng, title = '') {
    if (lat === 0 || lng === 0) {
        alert('لا يوجد إحداثيات متاحة لهذا العميل');
        return;
    }

    window.location.href = `https://www.google.com/maps?q=${lat},${lng}&z=17`;
}
        function initMap() {
            // إنشاء الخريطة بنفس تصميم جوجل
            const map = new google.maps.Map(document.getElementById('map'), {

            })
            const infoWindow = new google.maps.InfoWindow();

            // 1. إضافة علامة خضراء لموقع المستخدم الحالي
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const userLocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };

                        // إنشاء علامة خضراء كبيرة لموقع المستخدم
                        const userMarker = new google.maps.Marker({
                            position: userLocation,
                            map: map,
                            title: "أنت هنا",
                            icon: {
                                url: "https://maps.google.com/mapfiles/ms/icons/green-dot.png",
                                scaledSize: new google.maps.Size(40, 40)
                            },
                            animation: google.maps.Animation.BOUNCE
                        });

                        // محتوى نافذة المعلومات لموقع المستخدم
                        const userContentString = `
                            <div style="color: #333; font-family: Arial, sans-serif; width: 250px;">
                                <h4 style="margin: 0; font-size: 16px; color: #28a745;">
                                    <i class="fas fa-map-marker-alt" style="color: #28a745;"></i> موقعك الحالي
                                </h4>
                                <hr style="margin: 5px 0; border-color: #eee;">
                                <p style="margin: 5px 0; font-size: 14px;">
                                    <strong>الإحداثيات:</strong><br>
                                    ${userLocation.lat.toFixed(6)}, ${userLocation.lng.toFixed(6)}
                                </p>
                                <a href="https://www.google.com/maps?q=${userLocation.lat},${userLocation.lng}"
                                   target="_blank"
                                   style="display: inline-block; margin-top: 5px; padding: 5px 10px; background: #28a745; color: white; text-decoration: none; border-radius: 3px; font-size: 13px;">
                                    <i class="fas fa-external-link-alt"></i> فتح في خرائط جوجل
                                </a>
                            </div>
                        `;

                        // إضافة حدث النقر لعلامة المستخدم
                        userMarker.addListener('click', () => {
                            infoWindow.setContent(userContentString);
                            infoWindow.open(map, userMarker);
                        });

                        // تحريك الخريطة لمركز موقع المستخدم
                        map.setCenter(userLocation);
                        map.setZoom(14); // تكبير أقرب لموقع المستخدم
                    },
                    (error) => {
                        console.error("حدث خطأ في الحصول على الموقع:", error);
                        // إذا فشل الحصول على الموقع، نستخدم الموقع الافتراضي
                        map.setCenter({
                            lat: 24.7136,
                            lng: 46.6753
                        });
                        map.setZoom(10);
                    }, {
                        enableHighAccuracy: true,
                        timeout: 5000,
                        maximumAge: 0
                    }
                );
            } else {
                alert("المتصفح لا يدعم خدمة تحديد الموقع الجغرافي");
                map.setCenter({
                    lat: 24.7136,
                    lng: 46.6753
                });
                map.setZoom(10);
            }

            // 2. إضافة علامات للعملاء (بلون أزرق)
            <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($client->locations && $client->locations->latitude && $client->locations->longitude): ?>
                    <?php
                        $statusColor = optional(\App\Models\Statuses::find($client->status_id))->color ?? '#CCCCCC';
                    ?>

                    // إنشاء علامة العميل
                    const marker<?php echo e($client->id); ?> = new google.maps.Marker({
                        position: {
                            lat: <?php echo e($client->locations->latitude); ?>,
                            lng: <?php echo e($client->locations->longitude); ?>

                        },
                        map: map,
                        title: "<?php echo e($client->trade_name); ?> (<?php echo e($statusColor); ?>)",
                        icon: {
                            url: "data:image/svg+xml;charset=UTF-8," + encodeURIComponent(`
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40">
                        <circle cx="20" cy="20" r="18" fill="<?php echo e($statusColor); ?>" stroke="#FFFFFF" stroke-width="2"/>
                        <path fill="#FFFFFF" d="M20 10a8 8 0 0 1 8 8c0 5-8 14-8 14s-8-9-8-14a8 8 0 0 1 8-8zm0 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8z"/>
                        <text x="20" y="32" font-family="Arial" font-size="12" font-weight="bold" text-anchor="middle" fill="#FFFFFF"><?php echo e($client->code); ?></text>
                    </svg>
                `),
                            scaledSize: new google.maps.Size(40, 40),
                            anchor: new google.maps.Point(20, 40)
                        },
                        animation: google.maps.Animation.DROP
                    });


                    // محتوى نافذة المعلومات للعميل
                    const contentString<?php echo e($client->id); ?> = `
            <div style="color: #333; font-family: Arial, sans-serif; width: 280px;">
                <div style="background: <?php echo e($statusColor); ?>; color: white; padding: 10px; border-radius: 5px 5px 0 0;">
                    <h4 style="margin: 0; font-size: 16px;">
                        <i class="fas fa-store" style="margin-right: 5px;"></i> <?php echo e($client->trade_name); ?>

                    </h4>
                </div>
                <div style="padding: 10px;">
                    <table style="width: 100%; font-size: 14px;">
                        <tr>
                            <td style="width: 30%; color: #666;">الكود:</td>
                            <td><strong><?php echo e($client->code); ?></strong></td>
                        </tr>
                        <tr>
                            <td style="color: #666;">المالك:</td>
                            <td><?php echo e($client->first_name); ?> <?php echo e($client->last_name); ?></td>
                        </tr>
                        <tr>
                            <td style="color: #666;">الحالة:</td>
                            <td>
                                <span style="display: inline-block; width: 12px; height: 12px; background: <?php echo e($statusColor); ?>; border-radius: 50%; margin-right: 5px;"></span>
                                <?php echo e($statusColor); ?>

                            </td>
                        </tr>
                        <tr>
                            <td style="color: #666;">الهاتف:</td>
                            <td><a href="tel:<?php echo e($client->phone); ?>" style="color: #4285F4;"><?php echo e($client->phone); ?></a></td>
                        </tr>
                        <tr>
                            <td style="color: #666;">الموقع:</td>
                            <td><?php echo e($client->city); ?>, <?php echo e($client->region); ?></td>
                        </tr>
                        <tr>
                            <td style="color: #666;">الرصيد:</td>
                            <td style="color: <?php echo e($client->Balance() < 0 ? '#EA4335' : '#34A853'); ?>; font-weight: bold;">
                                <?php echo e($client->Balance()); ?> ر.س
                         
                            </td>
                        </tr>
                    </table>
                    <div style="margin-top: 15px; display: flex; gap: 5px;">
                        <a href="<?php echo e(route('clients.show', $client->id)); ?>"
                           target="_blank"
                           style="flex: 1; padding: 8px; background: #4285F4; color: white; text-decoration: none; border-radius: 4px; text-align: center; font-size: 13px;">
                            <i class="fas fa-info-circle"></i> التفاصيل
                        </a>
                        <a href="https://www.google.com/maps?q=<?php echo e($client->locations->latitude); ?>,<?php echo e($client->locations->longitude); ?>"
                           target="_blank"
                           style="flex: 1; padding: 8px; background: #34A853; color: white; text-decoration: none; border-radius: 4px; text-align: center; font-size: 13px;">
                            <i class="fas fa-map-marked-alt"></i> فتح الخريطة
                        </a>
                    </div>
                </div>
            </div>
        `;

                    // إضافة أحداث الماركر
                    marker<?php echo e($client->id); ?>.addListener('click', () => {
                        infoWindow.setContent(contentString<?php echo e($client->id); ?>);
                        infoWindow.open(map, marker<?php echo e($client->id); ?>);
                        map.panTo(marker<?php echo e($client->id); ?>.getPosition());
                    });

                    marker<?php echo e($client->id); ?>.addListener('mouseover', () => {
                        marker<?php echo e($client->id); ?>.setAnimation(google.maps.Animation.BOUNCE);
                    });

                    marker<?php echo e($client->id); ?>.addListener('mouseout', () => {
                        marker<?php echo e($client->id); ?>.setAnimation(null);
                    });
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/client/index.blade.php ENDPATH**/ ?>