<!DOCTYPE html>
<html class="loading" dir="<?php echo e(App::getLocale() == 'ar' || App::getLocale() == 'ur' ? 'rtl' : 'ltr'); ?>">
<!-- BEGIN: Head-->

<?php if(App::getLocale() == 'ar'): ?>
    <!-- BEGIN: Head-->
    <?php echo $__env->make('layouts.head_rtl', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <!-- END: Head-->
<?php elseif(App::getLocale() == 'ur'): ?>
    <!-- END: Head-->
    <?php echo $__env->make('layouts.head_rtl', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <!-- BEGIN: Head-->
<?php else: ?>
    <!-- BEGIN: Head-->
    <?php echo $__env->make('layouts.head_ltr', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <!-- END: Head-->
<?php endif; ?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0-alpha1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.1/spectrum.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/blueimp-file-upload/9.10.1/css/jquery.fileupload.css" />

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-file-upload/9.10.1/js/jquery.fileupload.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous" />

    <style>
        #DataTable_filter input {
            border-radius: 5px;
        }

        button span {
            font-family: 'Cairo', sans-serif !important;
        }

        .profile-picture-header {
            width: 40px;
            height: 40px;
            background-color: #7367F0;
            color: white;
            font-size: 18px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        #location-permission-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.8);
            z-index: 9999;
            color: white;
            display: none;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 20px;
        }

        #location-permission-content {
            max-width: 600px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            color: #333;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        #location-permission-overlay h3 {
            color: #7367F0;
            margin-bottom: 20px;
        }

        #location-permission-overlay p {
            margin-bottom: 20px;
            font-size: 16px;
        }

        #location-status {
            margin: 15px 0;
        }

        .tracking-status {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9998;
            padding: 10px 15px;
            border-radius: 5px;
            font-weight: bold;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            transition: opacity 0.5s ease;
        }

        .tracking-active {
            background-color: #28a745;
            color: white;
        }

        .tracking-inactive {
            background-color: #dc3545;
            color: white;
        }

        .tracking-paused {
            background-color: #ffc107;
            color: #212529;
        }

        .fade-out {
            opacity: 0;
        }

        /* رسالة التحميل */
        .loading-message {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.7);
            z-index: 9999;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 18px;
        }

        .loading-spinner {
            border: 5px solid #f3f3f3;
            border-top: 5px solid #7367F0;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin-bottom: 15px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* أنماط جديدة للـ Toast */
        .custom-toast {
            background-color: #28a745;
            color: white;
            border-radius: 8px;
            padding: 15px 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            max-width: 350px;
            margin: 0 auto;
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 99999;
            transition: all 0.5s ease;
            opacity: 0;
            transform: translateY(20px);
        }

        .custom-toast i {
            font-size: 24px;
            margin-left: 10px;
        }

        .custom-toast-content {
            flex: 1;
        }

        .custom-toast-title {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .custom-toast-text {
            font-size: 14px;
        }
    </style>
</head>

<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static   menu-collapsed" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">

    <!-- رسالة التحميل -->
    <div class="loading-message">
        <div class="loading-spinner"></div>
        <p>جاري تحميل التطبيق...</p>
    </div>

    <!-- طبقة حجب التطبيق حتى يتم تفعيل الموقع -->
    <div id="location-permission-overlay">
        <div id="location-permission-content">
            <h3><i class="fas fa-map-marker-alt"></i> تفعيل خدمة الموقع</h3>
            <p>يتطلب نظامنا تفعيل خدمة الموقع لتسجيل الزيارات والعملاء القريبين تلقائياً.</p>
            <ul class="text-start mb-3">
                <li>سيتم تسجيل موقعك أثناء وقت العمل فقط</li>
                <li>لن يتم مشاركة موقعك مع أي جهات خارجية</li>
                <li>يمكنك إيقاف التتبع في أي وقت من الإعدادات</li>
            </ul>

            <div class="form-check mb-3 text-start">
                <input class="form-check-input" type="checkbox" id="remember-choice">
                <label class="form-check-label" for="remember-choice">تذكر اختياري ولا تسألني مرة أخرى</label>
            </div>

            <div class="alert alert-warning" id="location-status">جاري طلب إذن الموقع...</div>
            <div class="d-flex justify-content-center gap-3">
                <button id="enable-location-btn" class="btn btn-primary">
                    <i class="fas fa-check-circle"></i> موافق وتفعيل
                </button>
                <button id="cancel-location-btn" class="btn btn-danger" style="display: none;">
                    <i class="fas fa-times-circle"></i> رفض (تسجيل الخروج)
                </button>
            </div>
        </div>
    </div>

    <!-- شريط حالة التتبع -->
    <div id="tracking-status" class="tracking-status tracking-inactive" style="display: none;">
        <i class="fas fa-map-marker-alt"></i> <span id="tracking-status-text">جاري التتبع</span>
    </div>

    <!-- BEGIN: Header-->
    <?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <!-- END: Header-->

    <!-- BEGIN: Main Menu-->
    <?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <!-- END: Footer-->

    <!-- BEGIN: Vendor JS-->
    <script src="<?php echo e(asset('app-assets/vendors/js/vendors.min.js')); ?>"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="<?php echo e(asset('app-assets/vendors/js/forms/select/select2.full.min.js')); ?>"></script>
    <script src="<?php echo e(asset('app-assets/vendors/js/charts/apexcharts.min.js')); ?>"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="<?php echo e(asset('app-assets/js/core/app-menu.js')); ?>"></script>
    <script src="<?php echo e(asset('app-assets/js/core/app.js')); ?>"></script>
    <script src="<?php echo e(asset('app-assets/js/scripts/components.js')); ?>"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(env('GOOGLE_MAPS_API_KEY')); ?>&libraries=places"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="<?php echo e(asset('app-assets/js/scripts/forms/select/form-select2.js')); ?>"></script>
    <script src="<?php echo e(asset('app-assets/js/scripts/pages/dashboard-ecommerce.js')); ?>"></script>
    <script src="<?php echo e(asset('app-assets/js/scripts/pages/app-chat.js')); ?>"></script>
    <script src="https://cdn.tiny.cloud/1/61l8sbzpodhm6pvdpqdk0vlb1b7wazt4fbq47y376qg6uslq/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <!-- END: Page JS-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.1/spectrum.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            // إخفاء رسالة التحميل بعد تحميل الصفحة
            $('.loading-message').fadeOut(500);

            $('#fawtra').DataTable({
                dom: 'Bfrtip',
                "pagingType": "full_numbers",
                buttons: [
                    {
                        "extend": 'excel',
                        "text": ' اكسيل',
                        'className': 'btn btn-success fa fa-plus'
                    },
                    {
                        "extend": 'print',
                        "text": ' طباعه',
                        'className': 'btn btn-warning fa fa-print'
                    },
                    {
                        "extend": 'copy',
                        "text": ' نسخ',
                        'className': 'btn btn-info fa fa-copy'
                    }
                ],
                initComplete: function() {
                    var btns = $('.dt-button');
                    btns.removeClass('dt-button');
                },
            });

            $('').selectize({
                sortField: 'text'
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const overlay = document.getElementById('location-permission-overlay');
            const enableBtn = document.getElementById('enable-location-btn');
            const cancelBtn = document.getElementById('cancel-location-btn');
            const statusElement = document.getElementById('location-status');
            const trackingStatusElement = document.getElementById('tracking-status');
            const trackingStatusText = document.getElementById('tracking-status-text');
            const rememberChoice = document.getElementById('remember-choice');

            // متغيرات التتبع
            let watchId = null;
            let trackingInterval = null;
            let isTracking = false;
            let lastLocation = null;
            let permissionDenied = false;
            let trackingPaused = false;
            let pageRefreshInterval = null;

            // تهيئة حالة التتبع من sessionStorage
            if (!sessionStorage.getItem('trackingState')) {
                sessionStorage.setItem('trackingState', JSON.stringify({
                    isTracking: false,
                    lastLocation: null,
                    lastUpdate: null,
                    permissionAsked: false,
                    pageAlreadyLoaded: false
                }));
            }

            // فحص حالة التتبع عند التحميل
            const trackingState = JSON.parse(sessionStorage.getItem('trackingState'));
            if (trackingState.isTracking) {
                updateTrackingStatus('active', 'جاري التتبع - موقعك يتم تسجيله');
            }

            // التحقق من إذن الموقع عند تحميل الصفحة
            checkLocationPermission();

            // بدء مؤقت لتحديث الصفحة كل دقيقة
            startPageRefreshTimer();

            // دالة لبدء مؤقت تحديث الصفحة
            function startPageRefreshTimer() {
                // تنظيف أي مؤقت سابق
                if (pageRefreshInterval) {
                    clearInterval(pageRefreshInterval);
                }

                // تعيين مؤقت جديد لتحديث الصفحة كل 10 دقائق (600000 مللي ثانية)
                pageRefreshInterval = setInterval(() => {
                    location.reload();
                }, 600000); // 600 ثانية (10 دقائق)
            }

            // دالة لعرض Toast Notification
            function showToastNotification(title, text, type) {
                const toast = document.createElement('div');
                toast.className = `custom-toast toast-${type}`;
                toast.innerHTML = `
                    <div class="custom-toast-content">
                        <div class="custom-toast-title">${title}</div>
                        <div class="custom-toast-text">${text}</div>
                    </div>
                    <i class="fas fa-check-circle"></i>
                `;

                // إضافة الـ Toast إلى الجسم
                document.body.appendChild(toast);

                // إظهار الـ Toast
                setTimeout(() => {
                    toast.style.opacity = '1';
                    toast.style.transform = 'translateY(0)';
                }, 100);

                // إخفاء الـ Toast بعد 5 ثوانٍ
                setTimeout(() => {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateY(20px)';

                    // إزالة الـ Toast من DOM بعد انتهاء الانتقال
                    setTimeout(() => {
                        document.body.removeChild(toast);
                    }, 500);
                }, 5000);
            }

            // دالة للتحقق من إذن الموقع
            function checkLocationPermission() {
                const trackingState = JSON.parse(sessionStorage.getItem('trackingState'));

                // إذا كان المستخدم قد رفض الإذن سابقاً
                if (localStorage.getItem('locationPermission') === 'denied') {
                    showPermissionDenied();
                    return;
                }

                // إذا كان المستخدم قد وافق سابقاً
                if (localStorage.getItem('locationPermission') === 'granted') {
                    startTrackingSilently();

                    // إظهار حالة التتبع إذا كان نشطاً
                    if (trackingState.isTracking) {
                        updateTrackingStatus('active', 'جاري التتبع - موقعك يتم تسجيله');
                        // إخفاء بعد 5 ثوانٍ فقط إذا كانت الصفحة جديدة
                        if (!trackingState.pageAlreadyLoaded) {
                            setTimeout(() => {
                                fadeOutTrackingStatus();
                            }, 5000);
                            trackingState.pageAlreadyLoaded = true;
                            sessionStorage.setItem('trackingState', JSON.stringify(trackingState));
                        }
                    }
                    return;
                }

                // إذا لم يتم طلب الإذن بعد في هذه الجلسة
                if (!trackingState.permissionAsked) {
                    showPermissionRequest();
                    trackingState.permissionAsked = true;
                    sessionStorage.setItem('trackingState', JSON.stringify(trackingState));
                }
            }

            // عرض طلب إذن الموقع
            function showPermissionRequest() {
                if (permissionDenied) return;

                overlay.style.display = 'flex';
                statusElement.textContent = 'جاري طلب إذن الموقع...';
                statusElement.className = 'alert alert-info';
                cancelBtn.style.display = 'none';
            }

            // عرض رسالة رفض الإذن
            function showPermissionDenied() {
                overlay.style.display = 'flex';
                statusElement.textContent = 'تم رفض إذن الوصول إلى الموقع. يرجى تفعيله في إعدادات المتصفح.';
                statusElement.className = 'alert alert-danger';
                cancelBtn.style.display = 'block';
                permissionDenied = true;

                updateTrackingStatus('inactive', 'تم إيقاف التتبع - إذن الموقع مرفوض');
            }

            // دالة لطلب إذن الموقع
            function requestLocationPermission() {
                statusElement.textContent = 'جاري طلب إذن الموقع...';
                statusElement.className = 'alert alert-info';

                if (!navigator.geolocation) {
                    statusElement.textContent = 'المتصفح لا يدعم ميزة تحديد الموقع';
                    statusElement.className = 'alert alert-danger';
                    cancelBtn.style.display = 'block';
                    return;
                }

                navigator.geolocation.getCurrentPosition(
                    locationPermissionGranted,
                    locationPermissionDenied,
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            }

            // تم منح إذن الموقع
            function locationPermissionGranted(position) {
                overlay.style.display = 'none';

                if (rememberChoice.checked) {
                    localStorage.setItem('locationPermission', 'granted');
                }

                startTracking(position);

                // عرض Toast بدلاً من SweetAlert
                showToastNotification('تم تفعيل التتبع', 'سيتم الآن تسجيل موقعك تلقائياً لتسجيل الزيارات', 'success');

                // إخفاء رسالة التتبع بعد 5 ثوانٍ
                setTimeout(() => {
                    fadeOutTrackingStatus();
                }, 5000);
            }

            // تم رفض إذن الموقع
            function locationPermissionDenied(error) {
                let errorMessage = 'حدث خطأ غير معروف';

                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        errorMessage = 'تم رفض إذن الوصول إلى الموقع. يرجى تفعيله في إعدادات المتصفح.';
                        if (rememberChoice.checked) {
                            localStorage.setItem('locationPermission', 'denied');
                        }
                        break;
                    case error.POSITION_UNAVAILABLE:
                        errorMessage = 'معلومات الموقع غير متوفرة حالياً.';
                        break;
                    case error.TIMEOUT:
                        errorMessage = 'انتهت مهلة طلب الموقع. يرجى المحاولة مرة أخرى.';
                        break;
                }

                statusElement.textContent = errorMessage;
                statusElement.className = 'alert alert-danger';
                cancelBtn.style.display = 'block';
                permissionDenied = true;

                updateTrackingStatus('inactive', 'تم إيقاف التتبع - إذن الموقع مرفوض');

                Swal.fire({
                    icon: 'error',
                    title: 'مطلوب تفعيل الموقع',
                    text: errorMessage,
                    confirmButtonText: 'حسناً'
                });
            }

            // بدء التتبع بعد منح الإذن
            function startTracking(position) {
                const trackingState = JSON.parse(sessionStorage.getItem('trackingState'));

                lastLocation = {
                    latitude: position.coords.latitude,
                    longitude: position.coords.longitude
                };

                trackingState.isTracking = true;
                trackingState.lastLocation = lastLocation;
                trackingState.lastUpdate = new Date().toISOString();
                trackingState.pageAlreadyLoaded = true;
                sessionStorage.setItem('trackingState', JSON.stringify(trackingState));

                sendLocationToServer(position);

                watchId = navigator.geolocation.watchPosition(
                    handlePositionUpdate,
                    handleTrackingError,
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0,
                        distanceFilter: 10
                    }
                );

                trackingInterval = setInterval(() => {
                    if (lastLocation) {
                        sendLocationToServer({
                            coords: {
                                latitude: lastLocation.latitude,
                                longitude: lastLocation.longitude,
                                accuracy: 20
                            }
                        });
                    }
                }, 60000);

                isTracking = true;
                trackingPaused = false;

                updateTrackingStatus('active', 'جاري التتبع - موقعك يتم تسجيله');
            }

            // بدء التتبع بدون عرض أي رسائل
            function startTrackingSilently() {
                if (!navigator.geolocation) return;

                const trackingState = JSON.parse(sessionStorage.getItem('trackingState'));

                // إذا كان التتبع نشطاً بالفعل في الجلسة
                if (trackingState.isTracking && trackingState.lastLocation) {
                    const lastUpdate = new Date(trackingState.lastUpdate);
                    const now = new Date();
                    const minutesDiff = (now - lastUpdate) / (1000 * 60);

                    if (minutesDiff < 5) { // إذا مر أقل من 5 دقائق منذ آخر تحديث
                        lastLocation = trackingState.lastLocation;
                        isTracking = true;
                        trackingPaused = false;

                        watchId = navigator.geolocation.watchPosition(
                            handlePositionUpdate,
                            handleTrackingError,
                            {
                                enableHighAccuracy: true,
                                timeout: 10000,
                                maximumAge: 0,
                                distanceFilter: 10
                            }
                        );

                        trackingInterval = setInterval(() => {
                            if (lastLocation) {
                                sendLocationToServer({
                                    coords: {
                                        latitude: lastLocation.latitude,
                                        longitude: lastLocation.longitude,
                                        accuracy: 20
                                    }
                                });
                            }
                        }, 60000);

                        updateTrackingStatus('active', 'جاري التتبع - موقعك يتم تسجيله');

                        // إخفاء رسالة التتبع بعد 5 ثوانٍ فقط إذا كانت الصفحة جديدة
                        if (!trackingState.pageAlreadyLoaded) {
                            setTimeout(() => {
                                fadeOutTrackingStatus();
                            }, 5000);
                            trackingState.pageAlreadyLoaded = true;
                            sessionStorage.setItem('trackingState', JSON.stringify(trackingState));
                        }

                        return;
                    }
                }

                // إذا لم يكن هناك تتبع نشط، نبدأ جلسة جديدة
                navigator.geolocation.getCurrentPosition(
                    position => {
                        lastLocation = {
                            latitude: position.coords.latitude,
                            longitude: position.coords.longitude
                        };

                        trackingState.isTracking = true;
                        trackingState.lastLocation = lastLocation;
                        trackingState.lastUpdate = new Date().toISOString();
                        trackingState.pageAlreadyLoaded = true;
                        sessionStorage.setItem('trackingState', JSON.stringify(trackingState));

                        sendLocationToServer(position);

                        watchId = navigator.geolocation.watchPosition(
                            handlePositionUpdate,
                            handleTrackingError,
                            {
                                enableHighAccuracy: true,
                                timeout: 10000,
                                maximumAge: 0,
                                distanceFilter: 10
                            }
                        );

                        trackingInterval = setInterval(() => {
                            if (lastLocation) {
                                sendLocationToServer({
                                    coords: {
                                        latitude: lastLocation.latitude,
                                        longitude: lastLocation.longitude,
                                        accuracy: 20
                                    }
                                });
                            }
                        }, 60000);

                        isTracking = true;
                        trackingPaused = false;

                        updateTrackingStatus('active', 'جاري التتبع - موقعك يتم تسجيله');

                        // إخفاء رسالة التتبع بعد 5 ثوانٍ فقط إذا كانت الصفحة جديدة
                        if (!trackingState.pageAlreadyLoaded) {
                            setTimeout(() => {
                                fadeOutTrackingStatus();
                            }, 5000);
                            trackingState.pageAlreadyLoaded = true;
                            sessionStorage.setItem('trackingState', JSON.stringify(trackingState));
                        }
                    },
                    error => {
                        console.error('خطأ في الحصول على الموقع:', error);
                        updateTrackingStatus('inactive', 'تم إيقاف التتبع - خطأ في الموقع');
                    }
                );
            }

            // إيقاف التتبع مؤقتاً
            function pauseTracking() {
                if (isTracking) {
                    navigator.geolocation.clearWatch(watchId);
                    if (trackingInterval) clearInterval(trackingInterval);

                    const trackingState = JSON.parse(sessionStorage.getItem('trackingState'));
                    trackingState.isTracking = false;
                    sessionStorage.setItem('trackingState', JSON.stringify(trackingState));

                    isTracking = false;
                    trackingPaused = true;

                    updateTrackingStatus('paused', 'التتبع متوقف مؤقتاً');
                }
            }

            // استئناف التتبع
            function resumeTracking() {
                if (!isTracking && !permissionDenied) {
                    if (lastLocation) {
                        startTrackingSilently();
                    } else {
                        requestLocationPermission();
                    }
                }
            }

            // معالجة تحديث الموقع
            function handlePositionUpdate(position) {
                const { latitude, longitude } = position.coords;

                if (!lastLocation || getDistance(latitude, longitude, lastLocation.latitude, lastLocation.longitude) > 10) {
                    lastLocation = { latitude, longitude };

                    const trackingState = JSON.parse(sessionStorage.getItem('trackingState'));
                    trackingState.lastLocation = lastLocation;
                    trackingState.lastUpdate = new Date().toISOString();
                    sessionStorage.setItem('trackingState', JSON.stringify(trackingState));

                    sendLocationToServer(position);
                }
            }

            // معالجة أخطاء التتبع
            function handleTrackingError(error) {
                console.error('خطأ في تتبع الموقع:', error);

                if (error.code === error.PERMISSION_DENIED) {
                    permissionDenied = true;
                    updateTrackingStatus('inactive', 'تم إيقاف التتبع - إذن الموقع مرفوض');

                    Swal.fire({
                        icon: 'error',
                        title: 'تم إيقاف التتبع',
                        text: 'تم سحب إذن الموقع، يرجى تحديث الصفحة ومنح الإذن مرة أخرى',
                        confirmButtonText: 'حسناً'
                    });
                }
            }

            // تحديث حالة التتبع في الواجهة
            function updateTrackingStatus(status, text) {
                const trackingState = JSON.parse(sessionStorage.getItem('trackingState'));

                trackingStatusElement.style.display = 'block';
                trackingStatusElement.classList.remove('fade-out');
                trackingStatusText.textContent = text;

                // إزالة جميع الفئات أولاً
                trackingStatusElement.classList.remove('tracking-active', 'tracking-inactive', 'tracking-paused');

                // إضافة الفئة المناسبة
                if (status === 'active') {
                    trackingStatusElement.classList.add('tracking-active');
                } else if (status === 'paused') {
                    trackingStatusElement.classList.add('tracking-paused');
                } else {
                    trackingStatusElement.classList.add('tracking-inactive');
                }

                // إذا كانت الصفحة قد تم تحميلها مسبقاً، لا تخفي الرسالة تلقائياً
                if (!trackingState.pageAlreadyLoaded) {
                    setTimeout(() => {
                        fadeOutTrackingStatus();
                    }, 5000);
                }
            }

            // إخفاء رسالة التتبع بتأثير تدريجي
            function fadeOutTrackingStatus() {
                if (trackingStatusElement.style.display !== 'none') {
                    trackingStatusElement.classList.add('fade-out');

                    // إخفاء العنصر تماماً بعد انتهاء التأثير
                    setTimeout(() => {
                        trackingStatusElement.style.display = 'none';
                    }, 500);
                }
            }

            // إرسال الموقع إلى الخادم
            async function sendLocationToServer(position) {
                const { latitude, longitude, accuracy } = position.coords;

                try {
                    const response = await fetch("<?php echo e(route('visits.storeLocationEnhanced')); ?>", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>"
                        },
                        body: JSON.stringify({
                            latitude,
                            longitude,
                            accuracy: accuracy || null,
                            timestamp: new Date().toISOString()
                        })
                    });

                    if (!response.ok) {
                        throw new Error('خطأ في الخادم');
                    }

                    const data = await response.json();

                    if (data.nearby_clients && data.nearby_clients.length > 0) {
                        console.log('العملاء القريبون:', data.nearby_clients);
                    }

                } catch (error) {
                    console.error('خطأ في إرسال الموقع:', error);
                }
            }

            // حساب المسافة بين موقعين (بالمتر)
            function getDistance(lat1, lon1, lat2, lon2) {
                const R = 6371000;
                const φ1 = lat1 * Math.PI / 180;
                const φ2 = lat2 * Math.PI / 180;
                const Δφ = (lat2 - lat1) * Math.PI / 180;
                const Δλ = (lon2 - lon1) * Math.PI / 180;

                const a = Math.sin(Δφ / 2) * Math.sin(Δφ / 2) +
                          Math.cos(φ1) * Math.cos(φ2) *
                          Math.sin(Δλ / 2) * Math.sin(Δλ / 2);
                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

                return R * c;
            }

            // أحداث الأزرار
            enableBtn.addEventListener('click', requestLocationPermission);

            cancelBtn.addEventListener('click', function() {
                window.location.href = "<?php echo e(route('logout')); ?>";
            });

            // أحداث لضمان استمرارية التتبع
            window.addEventListener('blur', pauseTracking);
            window.addEventListener('focus', resumeTracking);

            window.addEventListener('beforeunload', function() {
                pauseTracking();

                if (lastLocation) {
                    sendLocationToServer({
                        coords: {
                            latitude: lastLocation.latitude,
                            longitude: lastLocation.longitude,
                            accuracy: 20,
                            isExit: true
                        }
                    });
                }

                // تنظيف المؤقت قبل إغلاق الصفحة
                if (pageRefreshInterval) {
                    clearInterval(pageRefreshInterval);
                }
            });

            // التحقق من التتبع كل دقيقة
            setInterval(() => {
                const trackingState = JSON.parse(sessionStorage.getItem('trackingState'));
                if (trackingState.isTracking && !isTracking && !trackingPaused) {
                    resumeTracking();
                }
            }, 60000);
        });
    </script>

    <?php echo $__env->yieldContent('scripts'); ?>

</body>
<!-- END: Body-->

</html>
<?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/master.blade.php ENDPATH**/ ?>