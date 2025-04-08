<?php $__env->startSection('title'); ?>
    لوحة التحكم
<?php $__env->stopSection(); ?>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<?php $__env->startSection('css'); ?>
    <style>
        .ficon {
            font-size: 16px;
            margin-left: 8px;
        }

        .ml-auto a {
            display: inline-block;
            margin: 7px 10px;
            width: 100%;
            padding: 4px;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-between align-items-center mb-1">
                <div class="mr-1">
                    <p><span><?php echo e(\Carbon\Carbon::now()->translatedFormat('l، d F Y')); ?></span></p>
                    <h4 class="content-header-title float-left mb-0"> أهلاً <strong
                            style="color: #2C2C2C"><?php echo e(auth()->user()->name); ?> ، </strong> مرحباً بعودتك!</h4>
                </div>
                <div class="ml-auto bg-rgba-success">
                    <a href="" class="text-success"><i class="ficon feather icon-globe"></i> <span>الذهاب إلى
                            الموقع</span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">

        <section id="dashboard-ecommerce">
            <div class="row">
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-header d-flex flex-column align-items-start pb-0">
                            <div class="avatar bg-rgba-primary p-50 m-0">
                                <div class="avatar-content">
                                    <i class="feather icon-users text-primary font-medium-5"></i>
                                </div>
                            </div>
                            <h2 class="text-bold-700 mt-1"><?php echo e($ClientCount ?? 0); ?></h2>
                            <p class="mb-0">العملاء</p>
                        </div>
                        <div class="card-content">
                            <div id="line-area-chart-1"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-header d-flex flex-column align-items-start pb-0">
                            <div class="avatar bg-rgba-success p-50 m-0">
                                <div class="avatar-content">
                                    <i class="feather icon-credit-card text-success font-medium-5"></i>
                                </div>
                            </div>
                            <h2 class="text-bold-700 mt-1"> <?php echo e(number_format($Invoice, 2) ?? 0); ?></h2>
                            <p class="mb-0">المبيعات</p>
                        </div>
                        <div class="card-content">
                            <div id="line-area-chart-2"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-header d-flex flex-column align-items-start pb-0">
                            <div class="avatar bg-rgba-danger p-50 m-0">
                                <div class="avatar-content">
                                    <i class="feather icon-shopping-cart text-danger font-medium-5"></i>
                                </div>
                            </div>
                            <h2 class="text-bold-700 mt-1"><?php echo e($Visit ?? 0); ?></h2>
                            <p class="mb-0">الزيارات</p>
                        </div>
                        <div class="card-content">
                            <div id="line-area-chart-3"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-header d-flex flex-column align-items-start pb-0">
                            <div class="avatar bg-rgba-warning p-50 m-0">
                                <div class="avatar-content">
                                    <i class="feather icon-package text-warning font-medium-5"></i>
                                </div>
                            </div>
                            <h2 class="text-bold-700 mt-1">97.5K</h2>
                            <p class="mb-0">الطلبات الواردة</p>
                        </div>
                        <div class="card-content">
                            <div id="line-area-chart-4"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-end">
                            <h4>مبيعات المجموعات</h4>
                            <div class="dropdown chart-dropdown">

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownItem1">
                                    <a class="dropdown-item" href="#">آخر 28 يوم</a>
                                    <a class="dropdown-item" href="#">الشهر الماضي</a>
                                    <a class="dropdown-item" href="#">العام الماضي</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body pt-0">
                                <div id="sales-chart" class="mb-1"></div>
                                <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="chart-info d-flex justify-content-between mb-1">
                                        <div class="series-info d-flex align-items-center">
                                            <i class="feather icon-layers font-medium-2 text-primary"></i>
                                            <span class="text-bold-600 mx-50"><?php echo e($group->Region->name ?? ''); ?></span>
                                            <span> - <?php echo e(number_format($group->total_sales, 2)); ?> ريال</span>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-4 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between pb-0">
                            <h4 class="card-title">مبيعات الموظفين</h4>
                            <div class="dropdown chart-dropdown">

                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body py-0">
                                <div id="customer-charts">
                                    <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            var options = {
                                                series: <?php echo json_encode($chartData->pluck('percentage'), 15, 512) ?>,
                                                chart: {
                                                    type: 'donut',
                                                    height: 300
                                                },
                                                labels: <?php echo json_encode($chartData->pluck('name'), 15, 512) ?>,
                                                colors: ['#007bff', '#ffc107', '#dc3545', '#28a745'],
                                                legend: {
                                                    position: 'bottom'
                                                },
                                                dataLabels: {
                                                    formatter: function(val) {
                                                        return val.toFixed(2) + "%";
                                                    }
                                                }
                                            };

                                            var chart = new ApexCharts(document.querySelector("#customer-charts"), options);
                                            chart.render();
                                        });
                                    </script>


                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-6 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-end">
                            <h4 class="card-title">الإيرادات</h4>
                            <p class="font-medium-5 mb-0"><i class="feather icon-settings text-muted cursor-pointer"></i>
                            </p>
                        </div>
                        <div class="card-content">
                            <div class="card-body pb-0">
                                <div class="d-flex justify-content-start">
                                    <div class="mr-2">
                                        <p class="mb-50 text-bold-600">هذا الشهر</p>
                                        <h2 class="text-bold-400">
                                            <sup class="font-medium-1">$</sup>
                                            <span class="text-success">86,589</span>
                                        </h2>
                                    </div>
                                    <div>
                                        <p class="mb-50 text-bold-600">الشهر الماضي</p>
                                        <h2 class="text-bold-400">
                                            <sup class="font-medium-1">$</sup>
                                            <span>73,683</span>
                                        </h2>
                                    </div>

                                </div>
                                <div id="revenue-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-end">
                            <h4 class="mb-0">نظرة عامة على الأهداف</h4>
                            <p class="font-medium-5 mb-0"><i
                                    class="feather icon-help-circle text-muted cursor-pointer"></i></p>
                        </div>
                        <div class="card-content">
                            <div class="card-body px-0 pb-0">
                                <div id="goal-overview-chart" class="mt-75"></div>
                                <div class="row text-center mx-0">
                                    <div class="col-6 border-top border-right d-flex align-items-between flex-column py-1">
                                        <p class="mb-50">مكتمل</p>
                                        <p class="font-large-1 text-bold-700">786,617</p>
                                    </div>
                                    <div class="col-6 border-top d-flex align-items-between flex-column py-1">
                                        <p class="mb-50">قيد التقدم</p>
                                        <p class="font-large-1 text-bold-700">13,561</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">إحصائيات المتصفحات</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-25">
                                    <div class="browser-info">
                                        <p class="mb-25">جوجل كروم</p>
                                        <h4>73%</h4>
                                    </div>
                                    <div class="stastics-info text-right">
                                        <span>800 <i class="feather icon-arrow-up text-success"></i></span>
                                        <span class="text-muted d-block">13:16</span>
                                    </div>
                                </div>
                                <div class="progress progress-bar-primary mb-2">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="73" aria-valuemin="73"
                                        aria-valuemax="100" style="width:73%"></div>
                                </div>
                                <div class="d-flex justify-content-between mb-25">
                                    <div class="browser-info">
                                        <p class="mb-25">أوبرا</p>
                                        <h4>8%</h4>
                                    </div>
                                    <div class="stastics-info text-right">
                                        <span>-200 <i class="feather icon-arrow-down text-danger"></i></span>
                                        <span class="text-muted d-block">13:16</span>
                                    </div>
                                </div>
                                <div class="progress progress-bar-primary mb-2">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="8" aria-valuemin="8"
                                        aria-valuemax="100" style="width:8%"></div>
                                </div>
                                <div class="d-flex justify-content-between mb-25">
                                    <div class="browser-info">
                                        <p class="mb-25">فايرفوكس</p>
                                        <h4>19%</h4>
                                    </div>
                                    <div class="stastics-info text-right">
                                        <span>100 <i class="feather icon-arrow-up text-success"></i></span>
                                        <span class="text-muted d-block">13:16</span>
                                    </div>
                                </div>
                                <div class="progress progress-bar-primary mb-2">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="19" aria-valuemin="19"
                                        aria-valuemax="100" style="width:19%"></div>
                                </div>
                                <div class="d-flex justify-content-between mb-25">
                                    <div class="browser-info">
                                        <p class="mb-25">إنترنت إكسبلورر</p>
                                        <h4>27%</h4>
                                    </div>
                                    <div class="stastics-info text-right">
                                        <span>-450 <i class="feather icon-arrow-down text-danger"></i></span>
                                        <span class="text-muted d-block">13:16</span>
                                    </div>
                                </div>
                                <div class="progress progress-bar-primary mb-50">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="27" aria-valuemin="27"
                                        aria-valuemax="100" style="width:27%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">الاحتفاظ بالعملاء</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div id="client-retention-chart">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-end">
                            <h4>مبيعات المجموعات</h4>
                            <div class="dropdown chart-dropdown">

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownItem1">
                                    <a class="dropdown-item" href="#">آخر 28 يوم</a>
                                    <a class="dropdown-item" href="#">الشهر الماضي</a>
                                    <a class="dropdown-item" href="#">العام الماضي</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body pt-0">
                                <div id="sales-chart" class="mb-1"></div>
                                <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="chart-info d-flex justify-content-between mb-1">
                                        <div class="series-info d-flex align-items-center">
                                            <i class="feather icon-layers font-medium-2 text-primary"></i>
                                            <span class="text-bold-600 mx-50"><?php echo e($group->Region->name ?? ''); ?></span>
                                            <span> - <?php echo e(number_format($group->total_sales, 2)); ?> ريال</span>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card tracking-card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="card-title mb-0">
                            <i class="feather icon-navigation mr-2"></i>
                            نظام تتبع الموقع
                        </h4>
                    </div>
                    <div class="card-body">
                        <div id="location-status" class="tracking-status alert alert-info">
                            جاري تهيئة نظام التتبع...
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center">
                                <i class="feather icon-clock location-icon"></i>
                                <div>
                                    <div class="text-muted small">آخر تحديث</div>
                                    <div id="last-update" class="font-weight-bold">--:--:--</div>
                                </div>
                            </div>

                            <div>
                                <button id="start-tracking" class="btn btn-primary btn-tracking">
                                    <i class="feather icon-play"></i> بدء التتبع
                                </button>
                                <?php if(Auth::user()->role != 'employee'): ?>
                                    <button id="stop-tracking" class="btn btn-danger btn-tracking">
                                        <i class="feather icon-stop-circle"></i> إيقاف
                                    </button>
                                <?php endif; ?>

                            </div>
                        </div>

                        <div id="nearby-clients"></div>

                        <div class="mt-3 text-center text-muted small">
                            <i class="feather icon-info"></i>
                            سيتم تتبع موقعك تلقائياً عند فتح هذه الصفحة
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>

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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/dashboard/sales/index.blade.php ENDPATH**/ ?>