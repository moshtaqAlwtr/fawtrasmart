<?php $__env->startSection('title'); ?>
    تعديل فرع - <?php echo e($branch->name); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">تعديل فرع</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo e(route('branches.index')); ?>">الفروع</a></li>
                            <li class="breadcrumb-item active">تعديل</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">
        <section id="basic-vertical-layouts">
            <div class="row match-height">
                <div class="col-md-12 col-12">
                    <form class="form form-vertical" action="<?php echo e(route('branches.update', $branch->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <ul>
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center flex-wrap">
                                    <div>
                                        <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                                    </div>
                                    <div>
                                        <a href="<?php echo e(route('branches.index')); ?>" class="btn btn-outline-danger">
                                            <i class="fa fa-ban"></i>الغاء
                                        </a>
                                        <button type="submit" class="btn btn-outline-primary">
                                            <i class="fa fa-save"></i> حفظ
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">بيانات الفرع</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="name">اسم الفرع <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="name" class="form-control" name="name"
                                                        placeholder="اسم الفرع" value="<?php echo e(old('name', $branch->name)); ?>" required>
                                                </div>
                                            </div>

                                            <!-- إضافة حقل رئيسي -->
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="is_main"
                                                            name="is_main" value="1"
                                                            <?php echo e($branch->is_main ? 'checked' : ''); ?>>
                                                        <label class="custom-control-label" for="is_main">فرع رئيسي</label>
                                                    </div>
                                                    <small class="text-muted">إذا تم تحديده، سيكون هذا الفرع الرئيسي
                                                        للنظام</small>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="code">الكود <span class="text-danger">*</span></label>
                                                    <input type="text" id="code" class="form-control" name="code"
                                                        value="<?php echo e(old('code', $branch->code)); ?>" readonly required>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="phone">هاتف الفرع</label>
                                                    <input type="text" id="phone" class="form-control" name="phone"
                                                        value="<?php echo e(old('phone', $branch->phone)); ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="mobile">الجوال</label>
                                                    <input type="text" id="mobile" class="form-control" name="mobile"
                                                        value="<?php echo e(old('mobile', $branch->mobile)); ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="country">البلد <span class="text-danger">*</span></label>
                                                    <input type="text" id="country" class="form-control" name="country"
                                                        value="<?php echo e(old('country', $branch->country)); ?>" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="city">المدينة <span class="text-danger">*</span></label>
                                                    <input type="text" id="city" class="form-control" name="city"
                                                        value="<?php echo e(old('city', $branch->city)); ?>" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="region">المنطقة</label>
                                                    <input type="text" id="region" class="form-control"
                                                        name="region" value="<?php echo e(old('region', $branch->region)); ?>">
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="address1">العنوان الرئيسي</label>
                                                    <input type="text" id="address1" class="form-control"
                                                        name="address1" value="<?php echo e(old('address1', $branch->address1)); ?>">
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="address2">العنوان الثانوي</label>
                                                    <input type="text" id="address2" class="form-control"
                                                        name="address2" value="<?php echo e(old('address2', $branch->address2)); ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="work_hours">ساعات العمل</label>
                                                    <textarea id="work_hours" class="form-control" name="work_hours"><?php echo e(old('work_hours', $branch->work_hours)); ?></textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="description">وصف الفرع</label>
                                                    <textarea id="description" class="form-control" name="description"><?php echo e(old('description', $branch->description)); ?></textarea>
                                                </div>
                                            </div>

                                            <!-- خريطة تحديد الموقع -->
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-outline-primary mb-2"
                                                        onclick="toggleMap()">
                                                        <i class="feather icon-map"></i>
                                                        <?php echo e($branch->location ? 'تعديل موقع الفرع' : 'تحديد موقع الفرع'); ?>

                                                    </button>
                                                    <div id="map-container" style="display: none; margin-bottom: 20px;">
                                                        <div class="input-group mb-2">
                                                            <input type="text" id="search-location"
                                                                class="form-control" placeholder="ابحث عن موقع...">
                                                            <div class="input-group-append">
                                                                <button class="btn btn-outline-secondary" type="button"
                                                                    onclick="searchLocation()">
                                                                    <i class="feather icon-search"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div id="map"
                                                            style="height: 400px; width: 100%; border: 1px solid #ddd; border-radius: 4px;">
                                                        </div>
                                                        <small class="text-muted">اسحب العلامة لتحديد الموقع بدقة</small>
                                                    </div>
                                                    <input type="hidden" id="latitude" name="latitude"
                                                        value="<?php echo e($branch->location->latitude ?? ''); ?>">
                                                    <input type="hidden" id="longitude" name="longitude"
                                                        value="<?php echo e($branch->location->longitude ?? ''); ?>">

                                                    <?php if($branch->location): ?>
                                                        <div class="current-location mt-2">
                                                            <p class="mb-0">
                                                                <i class="feather icon-map-pin text-primary"></i>
                                                                الموقع الحالي:
                                                                <span class="text-info">
                                                                    <?php echo e($branch->location->latitude); ?>,
                                                                    <?php echo e($branch->location->longitude); ?>

                                                                </span>
                                                            </p>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(env('GOOGLE_MAPS_API_KEY')); ?>&libraries=places&callback=initMap"
        async defer></script>

    <script>
        let map;
        let marker;
        let geocoder;
        let searchBox;

        function initMap() {
            // الموقع الافتراضي (الرياض)
            const defaultLocation = {
                lat: 24.7136,
                lng: 46.6753
            };

            // إنشاء الخريطة
            map = new google.maps.Map(document.getElementById('map'), {
                center: defaultLocation,
                zoom: 12,
                mapTypeControl: true,
                streetViewControl: false
            });

            // إنشاء العلامة
            marker = new google.maps.Marker({
                position: defaultLocation,
                map: map,
                draggable: true,
                title: "اسحبني لتحديد الموقع"
            });

            // تهيئة خدمة العناوين
            geocoder = new google.maps.Geocoder();

            // تحديث الإحداثيات وعنوان الفرع عند تحريك العلامة
            marker.addListener('dragend', function() {
                updatePosition(marker.getPosition());
                getAddressFromLatLng(marker.getPosition());
            });

            // تحديد الموقع وعنوان الفرع عند النقر على الخريطة
            map.addListener('click', function(event) {
                marker.setPosition(event.latLng);
                updatePosition(event.latLng);
                getAddressFromLatLng(event.latLng);
            });

            // تهيئة مربع البحث
            const input = document.getElementById('search-location');
            searchBox = new google.maps.places.SearchBox(input);

            // عند اختيار نتيجة بحث
            searchBox.addListener('places_changed', function() {
                const places = searchBox.getPlaces();
                if (places.length === 0) return;

                const bounds = new google.maps.LatLngBounds();
                places.forEach(place => {
                    if (!place.geometry) return;

                    if (place.geometry.viewport) {
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }

                    marker.setPosition(place.geometry.location);
                    updatePosition(place.geometry.location);
                    getAddressFromPlace(place); // استخدام بيانات المكان مباشرة
                    map.fitBounds(bounds);
                });
            });
        }

        function updatePosition(latLng) {
            document.getElementById('latitude').value = latLng.lat();
            document.getElementById('longitude').value = latLng.lng();
        }

        function getAddressFromLatLng(latLng) {
            geocoder.geocode({
                'location': latLng
            }, function(results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                        fillAddressFields(results[0]);
                    }
                }
            });
        }

        function getAddressFromPlace(place) {
            // إنشاء كائن بنفس بنية نتائج geocoder
            const result = {
                address_components: place.address_components,
                formatted_address: place.formatted_address
            };
            fillAddressFields(result);
        }

        function fillAddressFields(result) {
            // تحليل مكونات العنوان
            const addressComponents = result.address_components;
            let streetNumber = '';
            let route = '';
            let neighborhood = ''; // الحي
            let locality = ''; // المدينة
            let administrativeArea = ''; // المنطقة
            let country = ''; // البلد
            let postalCode = '';

            addressComponents.forEach(component => {
                const types = component.types;
                if (types.includes('street_number')) {
                    streetNumber = component.long_name;
                } else if (types.includes('route')) {
                    route = component.long_name;
                } else if (types.includes('neighborhood') || types.includes('sublocality')) {
                    neighborhood = component.long_name;
                } else if (types.includes('locality')) {
                    locality = component.long_name;
                } else if (types.includes('administrative_area_level_1')) {
                    administrativeArea = component.long_name;
                } else if (types.includes('country')) {
                    country = component.long_name;
                } else if (types.includes('postal_code')) {
                    postalCode = component.long_name;
                }
            });

            // ملء الحقول في النموذج
            document.getElementById('address1').value = [streetNumber, route].filter(Boolean).join(' ');
            document.getElementById('address2').value = neighborhood;
            document.getElementById('city').value = locality;
            document.getElementById('region').value = administrativeArea;
            document.getElementById('country').value = country;
        }

        function toggleMap() {
            const mapContainer = document.getElementById('map-container');
            if (mapContainer.style.display === 'none') {
                mapContainer.style.display = 'block';
                if (typeof google === 'object' && typeof google.maps === 'object') {
                    if (!map) initMap();
                } else {
                    alert('جاري تحميل الخريطة، يرجى الانتظار...');
                }
            } else {
                mapContainer.style.display = 'none';
            }
        }

        function searchLocation() {
            const input = document.getElementById('search-location');
            if (input.value.trim() !== '') {
                if (searchBox && map) {
                    const places = searchBox.getPlaces();
                    if (places.length === 0) {
                        alert('لم يتم العثور على الموقع المطلوب');
                    }
                }
            }
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/branches/edit.blade.php ENDPATH**/ ?>