<!DOCTYPE html>
<html class="loading">
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-file-upload/9.10.1/js/jquery.fileupload.js"></script>
    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css ">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css"
        integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />


    <style>
        #DataTable_filter input {
            border-radius: 5px;
        }

        button span {
            font-family: 'Cairo', sans-serif !important;
        }

    </style>

    <style>
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
    </style>
</head>

<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static   menu-collapsed" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">

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
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY"></script>
    <!-- END: Page JS-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.1/spectrum.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src=" https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>


    <script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js "></script>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js" defer></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"
        integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>



    <script>
        $(document).ready(function() {

            // $('#fawtra').DataTable({
            //     dom: 'Bfrtip',
            //     buttons: [
            //         'copy', 'csv', 'excel', 'pdf', 'print'
            //     ]
            // });

            $('#fawtra').DataTable({
                dom: 'Bfrtip',
                "pagingType": "full_numbers",
                buttons: [{
                        "extend": 'excel',
                        "text": ' اكسيل',
                        'className': 'btn btn-success fa fa-plus'
                    },
                    {
                        "extend": 'print',
                        "text": ' طباعه',
                        'className': 'btn btn-warning  fa fa-print'
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



        });

    </script>
    <script>
        $(document).ready(function() {
            $('').selectize({
                sortField: 'text'
            });
        });

    </script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // عناصر واجهة المستخدم
        const statusElement = document.getElementById('location-status');
        const lastUpdateElement = document.getElementById('last-update');
        const nearbyClientsElement = document.getElementById('nearby-clients');
        const startTrackingBtn = document.getElementById('start-tracking');
        const stopTrackingBtn = document.getElementById('stop-tracking');

        // متغيرات التتبع
        let watchId = null;
        let lastLocation = null;
        let isTracking = false;
        let trackingInterval = null;

        // ========== دوال الواجهة ========== //

        // تحديث حالة الواجهة
        function updateUI(status, message) {
            statusElement.textContent = message;
            statusElement.className = `alert alert-${status}`;
            lastUpdateElement.textContent = new Date().toLocaleTimeString();
        }

        // عرض العملاء القريبين
        function displayNearbyClients(count) {
            if (count > 0) {
                nearbyClientsElement.innerHTML = `
            <div class="alert alert-info mt-3">
                <i class="feather icon-users mr-2"></i>
                يوجد ${count} عميل قريب من موقعك الحالي
            </div>
        `;
            } else {
                nearbyClientsElement.innerHTML = '';
            }
        }

        // ========== دوال التتبع ========== //

        // إرسال بيانات الموقع إلى الخادم
        async function sendLocationToServer(position) {
            const {
                latitude,
                longitude,
                accuracy
            } = position.coords;

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
                        accuracy: accuracy || null
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    updateUI('success', 'تم تحديث موقعك بنجاح');
                    displayNearbyClients(data.nearby_clients || 0);
                    return true;
                } else {
                    throw new Error(data.message || 'خطأ في الخادم');
                }
            } catch (error) {
                console.error('❌ خطأ في إرسال الموقع:', error);
                updateUI('danger', `خطأ في تحديث الموقع: ${error.message}`);
                return false;
            }
        }

        // معالجة أخطاء الموقع
        function handleGeolocationError(error) {
            let errorMessage;
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    errorMessage = "تم رفض إذن الوصول إلى الموقع. يرجى تفعيله في إعدادات المتصفح.";
                    break;
                case error.POSITION_UNAVAILABLE:
                    errorMessage = "معلومات الموقع غير متوفرة حالياً.";
                    break;
                case error.TIMEOUT:
                    errorMessage = "انتهت مهلة طلب الموقع. يرجى المحاولة مرة أخرى.";
                    break;
                case error.UNKNOWN_ERROR:
                    errorMessage = "حدث خطأ غير معروف أثناء محاولة الحصول على الموقع.";
                    break;
            }

            updateUI('danger', errorMessage);
            if (isTracking) stopTracking();
        }

        // بدء تتبع الموقع
        function startTracking() {
            if (!navigator.geolocation) {
                updateUI('danger', 'المتصفح لا يدعم ميزة تحديد الموقع');
                return;
            }

            updateUI('info', 'جاري طلب إذن الموقع...');

            // طلب الموقع الحالي أولاً
            navigator.geolocation.getCurrentPosition(
                async (position) => {
                        const {
                            latitude,
                            longitude
                        } = position.coords;
                        lastLocation = {
                            latitude,
                            longitude
                        };

                        // إرسال الموقع الأولي
                        await sendLocationToServer(position);

                        // بدء التتبع المستمر
                        watchId = navigator.geolocation.watchPosition(
                            async (position) => {
                                    const {
                                        latitude,
                                        longitude
                                    } = position.coords;

                                    // التحقق من تغير الموقع بشكل كافي (أكثر من 10 أمتار)
                                    if (!lastLocation ||
                                        getDistance(latitude, longitude, lastLocation.latitude,
                                            lastLocation.longitude) > 10) {

                                        lastLocation = {
                                            latitude,
                                            longitude
                                        };
                                        await sendLocationToServer(position);
                                    }
                                },
                                (error) => {
                                    console.error('❌ خطأ في تتبع الموقع:', error);
                                    handleGeolocationError(error);
                                }, {
                                    enableHighAccuracy: true,
                                    timeout: 10000,
                                    maximumAge: 0,
                                    distanceFilter: 10 // تحديث عند التحرك أكثر من 10 أمتار
                                }
                        );

                        // بدء التتبع الدوري (كل دقيقة)
                        trackingInterval = setInterval(async () => {
                            if (lastLocation) {
                                const fakePosition = {
                                    coords: {
                                        latitude: lastLocation.latitude,
                                        longitude: lastLocation.longitude,
                                        accuracy: 20
                                    }
                                };
                                await sendLocationToServer(fakePosition);
                            }
                        }, 60000);

                        isTracking = true;
                        updateUI('success', 'جاري تتبع موقعك...');
                        if (startTrackingBtn) startTrackingBtn.disabled = true;
                        if (stopTrackingBtn) stopTrackingBtn.disabled = false;
                    },
                    (error) => {
                        console.error('❌ خطأ في الحصول على الموقع:', error);
                        handleGeolocationError(error);
                    }, {
                        enableHighAccuracy: true,
                        timeout: 15000,
                        maximumAge: 0
                    }
            );
        }

        // إيقاف تتبع الموقع
        function stopTracking() {
            if (watchId) {
                navigator.geolocation.clearWatch(watchId);
                watchId = null;
            }

            if (trackingInterval) {
                clearInterval(trackingInterval);
                trackingInterval = null;
            }

            isTracking = false;
            updateUI('warning', 'تم إيقاف تتبع الموقع');
            if (startTrackingBtn) startTrackingBtn.disabled = false;
            if (stopTrackingBtn) stopTrackingBtn.disabled = true;
            nearbyClientsElement.innerHTML = '';
        }

        // حساب المسافة بين موقعين (بالمتر)
        function getDistance(lat1, lon1, lat2, lon2) {
            const R = 6371000; // نصف قطر الأرض بالمتر
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

        // ========== تهيئة الأحداث ========== //

        // أحداث الأزرار
        if (startTrackingBtn) {
            startTrackingBtn.addEventListener('click', startTracking);
        }

        if (stopTrackingBtn) {
            stopTrackingBtn.addEventListener('click', stopTracking);
        }

        // بدء التتبع تلقائياً عند تحميل الصفحة
        startTracking();

        // إيقاف التتبع عند إغلاق الصفحة
        window.addEventListener('beforeunload', function() {
            if (isTracking) {
                // إرسال بيانات الإغلاق إلى الخادم إذا لزم الأمر
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const fakePosition = {
                            coords: {
                                latitude: position.coords.latitude,
                                longitude: position.coords.longitude,
                                accuracy: position.coords.accuracy,
                                isExit: true
                            }
                        };
                        sendLocationToServer(fakePosition);
                    },
                    () => {}, {
                        enableHighAccuracy: true
                    }
                );
                stopTracking();
            }
        });
    });
</script>



    <?php echo $__env->yieldContent('scripts'); ?>


</body>
<!-- END: Body-->

</html>
<?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/master.blade.php ENDPATH**/ ?>