<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<nav class="header-navbar navbar-expand-lg navbar navbar-with-menu floating-nav navbar-light navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-container content" style="background-color: <?php echo e($backgroundColorr ?? '#ffffff'); ?>;">

            <div class="navbar-collapse" id="navbar-mobile">
                <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                    <ul class="nav navbar-nav">
                        <li class="nav-item mobile-menu d-xl-none mr-auto"><a
                                class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                    class="ficon feather icon-menu"></i></a></li>
                    </ul>
                    <ul class="nav navbar-nav bookmark-icons">
                        <!-- li.nav-item.mobile-menu.d-xl-none.mr-auto-->
                        <!--   a.nav-link.nav-menu-main.menu-toggle.hidden-xs(href='#')-->
                        <!--     i.ficon.feather.icon-menu-->
                        <li class="nav-item d-none d-lg-block"><a class="nav-link" href="<?php echo e(route('task.index')); ?>"
                                data-toggle="tooltip" data-placement="top" title="Todo"><i
                                    class="ficon feather icon-check-square"></i></a></li>
                        <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-chat.html"
                                data-toggle="tooltip" data-placement="top" title="Chat"><i
                                    class="ficon feather icon-message-square"></i></a></li>
                        <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-email.html"
                                data-toggle="tooltip" data-placement="top" title="Email"><i
                                    class="ficon feather icon-mail"></i></a></li>
                        <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-calender.html"
                                data-toggle="tooltip" data-placement="top" title="Calendar"><i
                                    class="ficon feather icon-calendar"></i></a></li>
                    </ul>
                    <ul class="nav navbar-nav">
                        <li class="nav-item d-none d-lg-block"><a class="nav-link bookmark-star"><i
                                    class="ficon feather icon-star warning"></i></a>
                            <div class="bookmark-input search-input">
                                <div class="bookmark-input-icon"><i class="feather icon-search primary"></i></div>
                                <input class="form-control input" type="text" placeholder="Explore Vuexy..."
                                    tabindex="0" data-search="template-list">
                                <ul class="search-list search-list-bookmark"></ul>
                            </div>
                            <!-- select.bookmark-select-->
                            <!--   option Chat-->
                            <!--   option email-->
                            <!--   option todo-->
                            <!--   option Calendar-->
                        </li>
                    </ul>
                </div>
                <ul class="nav navbar-nav float-right">
                    <li class="dropdown dropdown-language nav-item">
                        <a class="dropdown-toggle nav-link" id="dropdown-flag" href="#" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false"><i class="ficon feather icon-globe"></i><span
                                class="selected-language"></span></a>
                        <div class="dropdown-menu" aria-labelledby="dropdown-flag">
                            <?php $__currentLoopData = LaravelLocalization::getSupportedLocales(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $localeCode => $properties): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a class="dropdown-item" hreflang="<?php echo e($localeCode); ?>"
                                    href="<?php echo e(LaravelLocalization::getLocalizedURL($localeCode, null, [], true)); ?>"
                                    data-language="<?php echo e($localeCode); ?>">
                                    <?php if($localeCode == 'ar'): ?>
                                        <i class="flag-icon flag-icon-sa"></i> <?php echo e($properties['native']); ?>

                                        <!-- علم السعودية -->
                                    <?php elseif($localeCode == 'ur'): ?>
                                        <i class="flag-icon flag-icon-pk"></i> <?php echo e($properties['native']); ?>

                                        <!-- علم باكستان -->
                                    <?php elseif($localeCode == 'hi'): ?>
                                        <i class="flag-icon flag-icon-in"></i> <?php echo e($properties['native']); ?>

                                        <!-- علم الهند -->
                                    <?php elseif($localeCode == 'bn'): ?>
                                        <i class="flag-icon flag-icon-bd"></i> <?php echo e($properties['native']); ?>

                                        <!-- علم بنغلاديش -->
                                    <?php else: ?>
                                        <i class="flag-icon flag-icon-us"></i> <?php echo e($properties['native']); ?>

                                        <!-- علم الولايات المتحدة -->
                                    <?php endif; ?>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>
                    </li>


                    <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i
                                class="ficon feather icon-maximize"></i></a></li>
                    <li class="nav-item nav-search"><a class="nav-link nav-link-search"><i
                                class="ficon feather icon-search"></i></a>
                        <div class="search-input">
                            <div class="search-input-icon"><i class="feather icon-search primary"></i></div>
                            <input class="input" type="text" placeholder="Explore Vuexy..." tabindex="-1"
                                data-search="template-list">
                            <div class="search-input-close"><i class="feather icon-x"></i></div>
                            <ul class="search-list search-list-main"></ul>
                        </div>
                    </li>
                    <?php if(auth()->user()->role != 'employee'): ?>
                        <li class="dropdown dropdown-notification nav-item">
                            <a class="nav-link nav-link-label" href="#" data-toggle="dropdown">
                                <i class="ficon feather icon-calendar"></i>
                                <span
                                    class="badge badge-pill badge-primary badge-up"><?php echo e($todayVisits->count()); ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                <li class="dropdown-menu-header">
                                    <div class="dropdown-header m-0 p-2">
                                        <h3 class="white"><?php echo e($todayVisits->count()); ?> زيارة</h3>
                                        <span class="notification-title">زيارات اليوم</span>
                                    </div>
                                </li>
                                <li class="scrollable-container media-list">
                                    <?php $__empty_1 = true; $__currentLoopData = $todayVisits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $visit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <div class="visit-item media p-1">
                                            <div class="media-left">
                                                <div class="avatar bg-primary bg-lighten-4 rounded-circle">
                                                    <span
                                                        class="avatar-content"><?php echo e(substr($visit->client->trade_name, 0, 1)); ?></span>
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <h6 class="media-heading text-bold-500">
                                                    <?php echo e($visit->client->trade_name); ?></h6>
                                                <p class="mb-1">
                                                    <i class="feather icon-user"></i>
                                                    <small class="text-muted">الموظف:
                                                        <?php echo e($visit->employee->name ?? 'غير معروف'); ?></small>
                                                </p>
                                                <div class="visit-details">
                                                    <?php if($visit->arrival_time): ?>
                                                        <p class="mb-0">
                                                            <i class="feather icon-clock text-success"></i>
                                                            <span class="text-success">الوصول: </span>
                                                            <?php echo e(\Carbon\Carbon::parse($visit->arrival_time)->format('h:i A')); ?>

                                                        </p>
                                                    <?php endif; ?>
                                                    <?php if($visit->departure_time): ?>
                                                        <p class="mb-0">
                                                            <i class="feather icon-clock text-danger"></i>
                                                            <span class="text-danger">المغادرة: </span>
                                                            <?php echo e(\Carbon\Carbon::parse($visit->departure_time)->format('h:i A')); ?>

                                                        </p>
                                                    <?php else: ?>
                                                        <p class="mb-0 text-warning">
                                                            <i class="feather icon-clock"></i>
                                                            <span>ما زال عند العميل</span>
                                                        </p>
                                                    <?php endif; ?>
                                                    <?php if($visit->notes): ?>
                                                        <p class="mb-0 text-muted small">
                                                            <i class="feather icon-message-square"></i>
                                                            <?php echo e(Str::limit($visit->notes, 50)); ?>

                                                        </p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <li class="empty-visits p-2 text-center">لا توجد زيارات اليوم</li>
                    <?php endif; ?>
                    </li>
                    <li class="dropdown-menu-footer">
                        <a class="dropdown-item p-1 text-center text-primary" href="">
                            <i class="feather icon-list align-middle"></i>
                            <span class="align-middle text-bold-600">عرض كل الزيارات</span>
                        </a>
                    </li>
                </ul>
                </li>
                <?php endif; ?>




                <?php
                    $userRole = Auth::user()->role;
                ?>

                <?php if($userRole == 'employee' || $userRole == 'manager'): ?>
                    <li class="dropdown dropdown-notification nav-item">
                        <a class="nav-link nav-link-label" href="#" data-toggle="dropdown">
                            <i class="ficon feather icon-bell"></i>
                            <span class="badge badge-pill badge-primary badge-up" id="notification-count">0</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <li class="dropdown-menu-header">
                                <div class="dropdown-header m-0 p-2">
                                    <h3 class="white" id="notification-title">إشعارات جديدة</h3>
                                    <span class="notification-title">التنبيهات</span>
                                </div>
                            </li>
                            <li class="scrollable-container media-list" id="notification-list">
                                <p class="text-center p-2">لا يوجد إشعارات جديدة</p>
                            </li>
                            <li class="dropdown-menu-footer">
                                <a class="dropdown-item p-1 text-center"
                                    href="<?php echo e(route('notifications.index')); ?>">عرض كل الإشعارات</a>
                            </li>
                        </ul>
                    </li>

                    <script>
                        $(document).ready(function() {
                            function formatNotificationTime(dateTime) {
                                // ... (نفس الكود السابق)
                            }

                            function fetchNotifications() {
                                $.ajax({
                                    url: "<?php echo e(route('notifications.unread')); ?>",
                                    method: "GET",
                                    success: function(response) {
                                        let notifications = response.notifications;
                                        let count = notifications.length;
                                        $('#notification-count').text(count);

                                        // تعديل نص عنوان الإشعارات حسب الدور
                                        <?php if($userRole == 'manager'): ?>
                                            $('#notification-title').text(count + " إشعارات جديدة (جميع الإشعارات)");
                                        <?php else: ?>
                                            $('#notification-title').text(count + " إشعارات جديدة (خاصة بك)");
                                        <?php endif; ?>

                                        let notificationList = $('#notification-list');
                                        notificationList.empty();

                                        if (count > 0) {
                                            notifications.forEach(notification => {
                                                let timeAgo = formatNotificationTime(notification.created_at);
                                                let listItem = `
                                    <a class="d-flex justify-content-between notification-item"
                                        href="javascript:void(0)"
                                        data-id="${notification.id}">
                                        <div class="media d-flex align-items-start">
                                            <div class="media-left">
                                                <i class="feather icon-bell font-medium-5 primary"></i>
                                            </div>
                                            <div class="media-body">
                                                <h6 class="primary media-heading">${notification.title}</h6>
                                                <p class="notification-text mb-0">${notification.description}</p>
                                                <small class="text-muted">
                                                    <i class="far fa-clock"></i> ${timeAgo}
                                                </small>
                                                <?php if($userRole == 'manager'): ?>
                                                    <small class="text-info d-block">
                                                        ${notification.user ? notification.user.name : 'مستخدم غير معروف'}
                                                    </small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </a>
                                    <hr class="my-1">
                                `;
                                                notificationList.append(listItem);
                                            });
                                        } else {
                                            notificationList.append(
                                                '<p class="text-center p-2">لا يوجد إشعارات جديدة</p>');
                                        }
                                    }
                                });
                            }

                            fetchNotifications();

                            // تحديث الإشعارات كل دقيقة
                            setInterval(fetchNotifications, 60000);

                            $(document).on('click', '.notification-item', function() {
                                let notificationId = $(this).data('id');

                                $.ajax({
                                    url: "<?php echo e(route('notifications.markAsRead')); ?>",
                                    method: "POST",
                                    data: {
                                        _token: "<?php echo e(csrf_token()); ?>",
                                        id: notificationId
                                    },
                                    success: function() {
                                        fetchNotifications();
                                    }
                                });
                            });
                        });
                    </script>
                <?php endif; ?>
                <li class="dropdown dropdown-user nav-item">
                    <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown"
                        aria-expanded="false">
                        <div class="user-nav d-sm-flex d-none">
                            <span class="user-name text-bold-600"><?php echo e(auth()->user()->name ?? ''); ?></span>
                            <span class="user-status">
                                متصل
                                <?php if(auth()->user()->branch_id): ?>
                                    - <?php echo e(auth()->user()->currentBranch()->name ?? 'بدون فرع'); ?>

                                <?php endif; ?>
                            </span>
                        </div>
                        <span>
                            <?php
                                $firstLetter = mb_substr(auth()->user()->name, 0, 1, 'UTF-8');
                            ?>
                            <div class="profile-picture-header"><?php echo e($firstLetter); ?></div>
                        </span>
                        <i class="feather icon-chevron-down"></i> <!-- 🔽 رمز الدروب داون -->
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">

                        <div class="dropdown-divider"></div>

                        <!-- 🔹 قائمة الفروع (إذا لم يكن الموظف) -->
                        <?php if(auth()->user()->role !== 'employee'): ?>
                            <span class="dropdown-item font-weight-bold">🔹 الفروع:</span>
                            <?php $__currentLoopData = App\Models\Branch::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a class="dropdown-item branch-item <?php echo e(auth()->user()->branch_id == $branch->id ? 'active' : ''); ?>"
                                    href="<?php echo e(route('branch.switch', $branch->id)); ?>">
                                    <i class="feather icon-map-pin"></i> <?php echo e($branch->name); ?>

                                    <?php if(auth()->user()->branch_id == $branch->id): ?>
                                        <i class="feather icon-check text-success"></i>
                                        <!-- ✅ علامة عند تحديد الفرع -->
                                    <?php endif; ?>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>

                        <div class="dropdown-divider"></div>

                        <!-- زر تسجيل الخروج -->
                        <form action="<?php echo e(route('logout')); ?>" method="POST" style="display: inline;">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="dropdown-item"><i class="feather icon-power"></i> تسجيل
                                خروج</button>
                        </form>
                    </div>
                </li>


                </ul>
            </div>
        </div>
    </div>
</nav>
<ul class="main-search-list-defaultlist d-none">
    <li class="d-flex align-items-center"><a class="pb-25" href="#">
            <h6 class="text-primary mb-0">Files</h6>
        </a></li>
    <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a
            class="d-flex align-items-center justify-content-between w-100" href="#">
            <div class="d-flex">
                <div class="mr-50"><img src="../../../app-assets/images/icons/xls.png" alt="png"
                        height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">Two new item submitted</p><small class="text-muted">Marketing
                        Manager</small>
                </div>
            </div><small class="search-data-size mr-50 text-muted">&apos;17kb</small>
        </a></li>
    <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a
            class="d-flex align-items-center justify-content-between w-100" href="#">
            <div class="d-flex">
                <div class="mr-50"><img src="../../../app-assets/images/icons/jpg.png" alt="png"
                        height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">52 JPG file Generated</p><small class="text-muted">FontEnd
                        Developer</small>
                </div>
            </div><small class="search-data-size mr-50 text-muted">&apos;11kb</small>
        </a></li>
    <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a
            class="d-flex align-items-center justify-content-between w-100" href="#">
            <div class="d-flex">
                <div class="mr-50"><img src="../../../app-assets/images/icons/pdf.png" alt="png"
                        height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">25 PDF File Uploaded</p><small class="text-muted">Digital
                        Marketing Manager</small>
                </div>
            </div><small class="search-data-size mr-50 text-muted">&apos;150kb</small>
        </a></li>
    <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a
            class="d-flex align-items-center justify-content-between w-100" href="#">
            <div class="d-flex">
                <div class="mr-50"><img src="../../../app-assets/images/icons/doc.png" alt="png"
                        height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">Anna_Strong.doc</p><small class="text-muted">Web
                        Designer</small>
                </div>
            </div><small class="search-data-size mr-50 text-muted">&apos;256kb</small>
        </a></li>
    <li class="d-flex align-items-center"><a class="pb-25" href="#">
            <h6 class="text-primary mb-0">Members</h6>
        </a></li>
    <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a
            class="d-flex align-items-center justify-content-between py-50 w-100" href="#">
            <div class="d-flex align-items-center">
                <div class="avatar mr-50"><img src="../../../app-assets/images/portrait/small/avatar-s-8.jpg"
                        alt="png" height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0"><?php echo e(auth()->user()->name); ?></p><small class="text-muted">UI
                        designer</small>
                </div>
            </div>
        </a></li>
    <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a
            class="d-flex align-items-center justify-content-between py-50 w-100" href="#">
            <div class="d-flex align-items-center">
                <div class="avatar mr-50"><img src="../../../app-assets/images/portrait/small/avatar-s-1.jpg"
                        alt="png" height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">Michal Clark</p><small class="text-muted">FontEnd
                        Developer</small>
                </div>
            </div>
        </a></li>
    <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a
            class="d-flex align-items-center justify-content-between py-50 w-100" href="#">
            <div class="d-flex align-items-center">
                <div class="avatar mr-50"><img src="../../../app-assets/images/portrait/small/avatar-s-14.jpg"
                        alt="png" height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">Milena Gibson</p><small class="text-muted">Digital Marketing
                        Manager</small>
                </div>
            </div>
        </a></li>
    <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a
            class="d-flex align-items-center justify-content-between py-50 w-100" href="#">
            <div class="d-flex align-items-center">
                <div class="avatar mr-50"><img src="../../../app-assets/images/portrait/small/avatar-s-6.jpg"
                        alt="png" height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">Anna Strong</p><small class="text-muted">Web Designer</small>
                </div>
            </div>
        </a></li>
</ul>
<ul class="main-search-list-defaultlist-other-list d-none">
    <li class="auto-suggestion d-flex align-items-center justify-content-between cursor-pointer"><a
            class="d-flex align-items-center justify-content-between w-100 py-50">
            <div class="d-flex justify-content-start"><span class="mr-75 feather icon-alert-circle"></span><span>No
                    results found.</span></div>
        </a></li>
</ul>

<?php $__env->startSection('scripts'); ?>
    <script>
        $(document).ready(function() {
            function formatVisitTime(dateTime) {
                try {
                    const now = new Date();
                    const visitDate = new Date(dateTime);
                    const diffInSeconds = Math.floor((now - visitDate) / 1000);

                    if (diffInSeconds < 60) return 'الآن';
                    if (diffInSeconds < 3600) return `منذ ${Math.floor(diffInSeconds / 60)} دقيقة`;
                    if (diffInSeconds < 86400) return `منذ ${Math.floor(diffInSeconds / 3600)} ساعة`;
                    return `منذ ${Math.floor(diffInSeconds / 86400)} يوم`;
                } catch (e) {
                    console.error('Error formatting time:', e);
                    return '--';
                }
            }

            function fetchTodayVisits() {
                $.ajax({
                    url: "<?php echo e(route('visits.today')); ?>",
                    method: "GET",
                    success: function(response) {
                        let visits = response.visits || [];
                        let count = response.count || 0;

                        $('#visits-count').text(count);
                        $('#visits-title').text(count + ' زيارة');

                        let visitsList = $('#visits-list');
                        visitsList.empty();

                        if (count > 0) {
                            visits.forEach(visit => {
                                let timeAgo = formatVisitTime(visit.created_at);
                                visitsList.append(`
                                <div class="media d-flex align-items-start px-2 py-1">
                                    <div class="media-left">
                                        <i class="feather icon-user font-medium-5 primary"></i>
                                    </div>
                                    <div class="media-body">
                                        <h6 class="primary media-heading mb-0">${visit.client_name}</h6>
                                        <small class="text-muted d-block">الموظف: ${visit.employee_name}</small>
                                        <small class="text-muted d-block">الوصول: ${visit.arrival_time} | الانصراف: ${visit.departure_time}</small>
                                        <small class="text-muted"><i class="far fa-clock"></i> ${timeAgo}</small>
                                    </div>
                                </div>
                                <hr class="my-1">
                            `);
                            });
                        } else {
                            visitsList.append('<p class="text-center p-2">لا توجد زيارات اليوم</p>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching visits:', error);
                        $('#visits-list').html(
                            '<p class="text-center p-2 text-danger">حدث خطأ أثناء جلب البيانات</p>');
                    }
                });
            }

            fetchTodayVisits(); // أول مرة عند التحميل
            setInterval(fetchTodayVisits, 60000); // كل دقيقة
        });
    </script>
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
<?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/layouts/header.blade.php ENDPATH**/ ?>