@extends('master')

@section('title')
    تعديل العميل - {{ $client->trade_name }}
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">تعديل العميل</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a>
                            </li>
                            <li class="breadcrumb-item active">تعديل
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <form id="clientForm" action="{{ route('clients.update', $client->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- حقلين مخفيين لتخزين الإحداثيات -->
            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $client->latitude) }}">
            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $client->longitude) }}">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                        </div>

                        <div>
                            <a href="{{ route('clients.index') }}" class="btn btn-outline-danger">
                                <i class="fa fa-ban"></i>الغاء
                            </a>
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="fa fa-save"></i>حفظ
                            </button>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">بيانات العميل</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="form-body">
                                    <div class="row">
                                        <!-- الاسم التجاري -->
                                        <div class="col-12 mb-3">
                                            <div class="form-group">
                                                <label for="trade_name">الاسم التجاري <span
                                                        class="text-danger">*</span></label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="trade_name" id="trade_name"
                                                        class="form-control"
                                                        value="{{ old('trade_name', $client->trade_name) }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-briefcase"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- الاسم الأول والأخير -->
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="first_name">الاسم الأول</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="first_name" id="first_name"
                                                        class="form-control"
                                                        value="{{ old('first_name', $client->first_name) }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-user"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="last_name">الاسم الأخير</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="last_name" id="last_name"
                                                        class="form-control"
                                                        value="{{ old('last_name', $client->last_name) }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-user"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- الهاتف والجوال -->
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="phone">هاتف</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="phone" id="phone" class="form-control"
                                                        value="{{ old('phone', $client->phone) }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-phone"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="mobile">جوال</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="mobile" id="mobile" class="form-control"
                                                        value="{{ old('mobile', $client->mobile) }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-smartphone"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- العنوان -->
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="street1">الشارع</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="street1" id="street1"
                                                        class="form-control"
                                                        value="{{ old('street1', $client->street1) }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-map-pin"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="street2">الحي</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="street2" id="street2"
                                                        class="form-control"
                                                        value="{{ old('street2', $client->street2) }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-map-pin"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- المدينة والمنطقة والرمز البريدي -->
                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label for="city">المدينة</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="city" id="city"
                                                        class="form-control" value="{{ old('city', $client->city) }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-map"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label for="region">المنطقة</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="region" id="region"
                                                        class="form-control"
                                                        value="{{ old('region', $client->region) }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-map"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label for="postal_code">الرمز البريدي</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="postal_code" id="postal_code"
                                                        class="form-control"
                                                        value="{{ old('postal_code', $client->postal_code) }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-map-pin"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- البلد -->
                                        <div class="col-12 mb-3">
                                            <div class="form-group">
                                                <label for="country">البلد</label>
                                                <input type="text" name="country" id="country" class="form-control"
                                                    value="{{ old('country', $client->country) }}">
                                            </div>
                                        </div>

                                        <!-- الرقم الضريبي والسجل التجاري -->
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="tax_number">الرقم الضريبي</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="tax_number" id="tax_number"
                                                        class="form-control"
                                                        value="{{ old('tax_number', $client->tax_number) }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-file-text"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="commercial_registration">السجل التجاري</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="commercial_registration"
                                                        id="commercial_registration" class="form-control"
                                                        value="{{ old('commercial_registration', $client->commercial_registration) }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-file"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- الحد الائتماني والمدة الائتمانية -->
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="credit_limit">الحد الائتماني (SAR)</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="number" name="credit_limit" id="credit_limit"
                                                        class="form-control"
                                                        value="{{ old('credit_limit', $client->credit_limit) }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-credit-card"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="credit_period">المدة الائتمانية (أيام)</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="number" name="credit_period" id="credit_period"
                                                        class="form-control"
                                                        value="{{ old('credit_period', $client->credit_period) }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-clock"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- زر إظهار الخريطة -->
                                        <div class="col-12 mb-3">
                                            <button type="button" class="btn btn-outline-primary"
                                                onclick="requestLocationPermission()">
                                                <i class="feather icon-map"></i> إظهار الخريطة
                                            </button>
                                            <div id="map-container"
                                                style="display: none; height: 400px; width: 100%; margin-top: 10px;"
                                                class="border rounded">
                                                <div id="map" style="height: 100%;"></div>
                                            </div>
                                        </div>

                                        <!-- قائمة الاتصال -->
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">قائمة الاتصال</h4>
                                            </div>
                                            <div class="card-content">
                                                <div class="card-body">
                                                    <div class="contact-fields-container" id="contactContainer">
                                                        <!-- الحقول الديناميكية ستضاف هنا -->
                                                    </div>
                                                    <div class="text-right mt-1">
                                                        <button type="button"
                                                            class="btn btn-outline-success mr-1 mb-1 إضافة"
                                                            onclick="addContactFields()">
                                                            <i class="feather icon-plus"></i> إضافة جهة اتصال
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">بيانات الحساب</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="form-body">
                                    <div class="row">
                                        <!-- رقم الكود -->
                                        <div class="col-6 mb-3">
                                            <div class="form-group">
                                                <label for="code">رقم الكود <span class="text-danger">*</span></label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" id="code" class="form-control"
                                                        name="code" value="{{ old('code', $client->code) }}" required>
                                                    <div class="form-control-position">
                                                        <i class="feather icon-hash"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- طريقة الطباعة -->
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="printing_method">طريقة الطباعة</label>
                                                <div class="position-relative has-icon-left">
                                                    <select name="printing_method" id="printing_method"
                                                        class="form-control">
                                                        <option value="">اختر طريقة الطباعة</option>
                                                        <option value="1"
                                                            {{ old('printing_method', $client->printing_method) == '1' ? 'selected' : '' }}>
                                                            طباعة</option>
                                                        <option value="2"
                                                            {{ old('printing_method', $client->printing_method) == '2' ? 'selected' : '' }}>
                                                            ارسل عبر البريد</option>
                                                    </select>
                                                    <div class="form-control-position">
                                                        <i class="feather icon-printer"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- الرصيد الافتتاحي -->
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="opening_balance">الرصيد الافتتاحي</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="number" step="0.01" name="opening_balance"
                                                        id="opening_balance" class="form-control"
                                                        value="{{ old('opening_balance', $client->opening_balance) }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-dollar-sign"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- تاريخ الرصيد الاستحقاق -->
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="opening_balance_date">تاريخ الرصيد الاستحقاق</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="date" name="opening_balance_date"
                                                        id="opening_balance_date" class="form-control"
                                                        value="{{ old('opening_balance_date', $client->opening_balance_date) }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- البريد الإلكتروني -->
                                        <div class="col-12 mb-3">
                                            <div class="form-group">
                                                <label for="email">البريد الإلكتروني</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="email" name="email" id="email"
                                                        class="form-control" value="{{ old('email', $client->email) }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-mail"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- العملة -->
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <label for="currency">العملة</label>
                                                <div class="position-relative has-icon-left">
                                                    <select class="form-control" id="currency" name="currency">
                                                        <option value="">اختر العملة</option>
                                                        <option value="SAR"
                                                            {{ old('currency', $client->currency) == 'SAR' ? 'selected' : '' }}>
                                                            ريال سعودي</option>
                                                        <option value="USD"
                                                            {{ old('currency', $client->currency) == 'USD' ? 'selected' : '' }}>
                                                            دولار أمريكي</option>
                                                        <option value="EUR"
                                                            {{ old('currency', $client->currency) == 'EUR' ? 'selected' : '' }}>
                                                            يورو</option>
                                                    </select>
                                                    <div class="form-control-position">
                                                        <i class="feather icon-dollar-sign"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- تصنيف العميل -->
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="client_type">تصنيف العميل</label>
                                                <div class="position-relative has-icon-left">
                                                    <select name="client_type" id="client_type" class="form-control">
                                                        <option value="">اختر نوع العميل</option>
                                                        <option value="1"
                                                            {{ old('client_type', $client->client_type) == '1' ? 'selected' : '' }}>
                                                            عميل عادي</option>
                                                        <option value="2"
                                                            {{ old('client_type', $client->client_type) == '2' ? 'selected' : '' }}>
                                                            عميل VIP</option>
                                                    </select>
                                                    <div class="form-control-position">
                                                        <i class="feather icon-users"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- الملاحظات -->
                                        <div class="col-12 mb-3">
                                            <div class="form-group">
                                                <label for="notes">ملاحظات</label>
                                                <div class="position-relative has-icon-left">
                                                    <textarea name="notes" id="notes" class="form-control" rows="3">{{ old('notes', $client->notes) }}</textarea>
                                                    <div class="form-control-position">
                                                        <i class="feather icon-file-text"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- المرفقات -->
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <label for="attachments" class="form-label">المرفقات</label>
                                                <input type="file"
                                                    class="form-control @error('attachments') is-invalid @enderror"
                                                    id="attachments" name="attachments">
                                                @error('attachments')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                @if ($client->attachments)
                                                    <div class="mt-2">
                                                        <img src="{{ asset('uploads/clients/' . $client->attachments) }}"
                                                            alt="مرفق العميل" class="img-thumbnail"
                                                            style="max-width: 200px;">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <!-- إضافة مكتبة Google Maps -->
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places"></script>
    <script>
        // دالة لعرض الخريطة
        function toggleMap() {
            const mapContainer = document.getElementById('map-container');
            if (mapContainer.style.display === 'none') {
                mapContainer.style.display = 'block';
            } else {
                mapContainer.style.display = 'none';
            }
        }

        // دالة لطلب الإذن من المستخدم للوصول إلى موقعه الحالي
        function requestLocationPermission() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        // إذا وافق المستخدم، نعرض الخريطة
                        toggleMap();
                        initMap(position.coords.latitude, position.coords.longitude);
                    },
                    (error) => {
                        // إذا رفض المستخدم أو حدث خطأ
                        alert('⚠️ يرجى السماح بالوصول إلى الموقع لعرض الخريطة.');
                        console.error('Error getting location:', error);
                    }
                );
            } else {
                // إذا كان المتصفح لا يدعم الـ Geolocation
                alert('⚠️ المتصفح لا يدعم تحديد الموقع. يرجى استخدام متصفح آخر.');
            }
        }

        // دالة لتهيئة الخريطة
        function initMap(lat, lng) {
            // تعيين الإحداثيات في الحقول المخفية
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            // تهيئة الخريطة مع الإحداثيات المحددة
            const map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat,
                    lng
                },
                zoom: 15, // زيادة مستوى التكبير لدقة أعلى
            });

            // إضافة علامة (Marker) في الموقع المحدد
            const marker = new google.maps.Marker({
                position: {
                    lat,
                    lng
                },
                map: map,
                draggable: true, // السماح بسحب العلامة
                title: 'موقعك الحالي',
            });

            // تحديث الحقول المخفية عند تحريك العلامة
            google.maps.event.addListener(marker, 'dragend', function() {
                const newLat = marker.getPosition().lat();
                const newLng = marker.getPosition().lng();
                document.getElementById('latitude').value = newLat;
                document.getElementById('longitude').value = newLng;

                // جلب العنوان بناءً على الإحداثيات الجديدة
                fetchAddressFromCoordinates(newLat, newLng);
            });

            // جلب العنوان عند النقر على الخريطة
            google.maps.event.addListener(map, 'click', function(event) {
                const newLat = event.latLng.lat();
                const newLng = event.latLng.lng();
                marker.setPosition({
                    lat: newLat,
                    lng: newLng
                });
                document.getElementById('latitude').value = newLat;
                document.getElementById('longitude').value = newLng;

                // جلب العنوان بناءً على الإحداثيات الجديدة
                fetchAddressFromCoordinates(newLat, newLng);
            });
        }

        // دالة لجلب العنوان من الإحداثيات
        function fetchAddressFromCoordinates(lat, lng) {
            const geocoder = new google.maps.Geocoder();
            const latLng = {
                lat,
                lng
            };

            geocoder.geocode({
                location: latLng
            }, (results, status) => {
                if (status === 'OK') {
                    if (results[0]) {
                        const addressComponents = results[0].address_components;

                        // تعبئة الحقول بناءً على البيانات المسترجعة
                        document.getElementById('country').value = getAddressComponent(addressComponents,
                        'country');
                        document.getElementById('region').value = getAddressComponent(addressComponents,
                            'administrative_area_level_1');
                        document.getElementById('city').value = getAddressComponent(addressComponents,
                            'locality') || getAddressComponent(addressComponents, 'administrative_area_level_2');
                        document.getElementById('postal_code').value = getAddressComponent(addressComponents,
                            'postal_code');
                        document.getElementById('street1').value = getAddressComponent(addressComponents, 'route');
                        document.getElementById('street2').value =
    getAddressComponent(addressComponents, 'neighborhood') ||
    getAddressComponent(addressComponents, 'sublocality') ||
    getAddressComponent(addressComponents, 'sublocality_level_1');
                    } else {
                        console.error('لم يتم العثور على عنوان لهذه الإحداثيات.');
                    }
                } else {
                    console.error('حدث خطأ أثناء جلب العنوان:', status);
                }
            });
        }

        // دالة مساعدة لاستخراج مكونات العنوان
        function getAddressComponent(addressComponents, type) {
            const component = addressComponents.find(component => component.types.includes(type));
            return component ? component.long_name : '';
        }

        // التأكد من وجود الإحداثيات قبل الإرسال
        document.getElementById('clientForm').addEventListener('submit', function(e) {
            const lat = document.getElementById('latitude').value;
            const lon = document.getElementById('longitude').value;

            if (!lat || !lon) {
                e.preventDefault();
                alert('⚠️ يرجى تحديد الموقع من الخريطة قبل الإرسال!');
            }
        });
    </script>
@endsection
