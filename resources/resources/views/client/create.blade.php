@extends('master')

@section('title')
    اضافة عميل
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">اضافة عميل جديد </h2>
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
    <div class="content-body">
        <form id="clientForm" action="{{ route('clients.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- حقلين مخفيين لتخزين الإحداثيات -->
            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">

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
                                                        class="form-control" value="{{ old('trade_name') }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-briefcase"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- الاسم الأول والأخير -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="first_name">الاسم الأول</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="first_name" id="first_name"
                                                        class="form-control" value="{{ old('first_name') }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-user"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="last_name">الاسم الأخير</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="last_name" id="last_name"
                                                        class="form-control" value="{{ old('last_name') }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-user"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- الهاتف والجوال -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="phone">الهاتف</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="phone" id="phone" class="form-control"
                                                        value="{{ old('phone') }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-phone"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="mobile">جوال</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="mobile" id="mobile" class="form-control"
                                                        value="{{ old('mobile') }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-smartphone"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- عنوان الشارع -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="street1">عنوان الشارع 1</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="street1" id="street1" class="form-control"
                                                        value="{{ old('street1') }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-map-pin"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="street2">عنوان الشارع 2</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="street2" id="street2"
                                                        class="form-control" value="{{ old('street2') }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-map-pin"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- المدينة والمنطقة والرمز البريدي -->
                                        <div class="col-md-4 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="city">المدينة</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="city" id="city"
                                                        class="form-control" value="{{ old('city') }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-map"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="region">المنطقة</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="region" id="region"
                                                        class="form-control" value="{{ old('region') }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-map"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="postal_code">الرمز البريدي</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="postal_code" id="postal_code"
                                                        class="form-control" value="{{ old('postal_code') }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-mail"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- البلد -->
                                        <div class="col-12 mb-3">
                                            <div class="form-group">
                                                <label for="country">البلد</label>
                                                <select name="country" id="country" class="form-control">
                                                    <option value="SA" {{ old('country') == 'SA' ? 'selected' : '' }}>
                                                        المملكة العربية السعودية (SA)</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- الرقم الضريبي والسجل التجاري -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="tax_number">الرقم الضريبي (اختياري)</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="tax_number" id="tax_number"
                                                        class="form-control" value="{{ old('tax_number') }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-file-text"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="commercial_registration">سجل تجاري (اختياري)</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="commercial_registration"
                                                        id="commercial_registration" class="form-control"
                                                        value="{{ old('commercial_registration') }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-file"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- الحد الائتماني والمدة الائتمانية -->
                                        @foreach ($GeneralClientSettings as $GeneralClientSetting)
                                        @if($GeneralClientSetting->is_active)
                                        @if($GeneralClientSetting->key == "credit_limit")
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="credit_limit">الحد الائتماني</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="number" name="credit_limit" id="credit_limit"
                                                        class="form-control" value="{{ old('credit_limit', 0) }}">
                                                    <div class="form-control-position">
                                                        <span>SAR</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @endif
                                        @endforeach

                                        @foreach ($GeneralClientSettings as $GeneralClientSetting)
                                        @if($GeneralClientSetting->is_active)
                                        @if($GeneralClientSetting->key == "credit_duration")
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="credit_period">المدة الائتمانية</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="number" name="credit_period" id="credit_period"
                                                        class="form-control" value="{{ old('credit_period', 0) }}">
                                                    <div class="form-control-position">
                                                        <span>أيام</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @endif
                                        @endforeach
                                        <!-- زر إظهار الخريطة -->
                                        @foreach ($GeneralClientSettings as $GeneralClientSetting)
                                        @if($GeneralClientSetting->is_active)
                                        @if($GeneralClientSetting->key == "location")
                                        <div class="col-12 mb-3">
                                            <button type="button" class="btn btn-outline-primary mb-2"
                                                onclick="toggleMap()">
                                                <i class="feather icon-map"></i> إظهار الخريطة
                                            </button>
                                            <div id="map-container" style="display: none;">
                                                <div id="map" style="height: 400px; width: 100%;"></div>
                                            </div>
                                        </div>
                                         @endif
                                         @endif
                                         @endforeach
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
                <div class="col-md-6 col-12">
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
                                                        name="code" value="{{ old('code', $newCode) }}" readonly>
                                                    <div class="form-control-position">
                                                        <i class="feather icon-hash"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- طريقة الفاتورة -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="printing_method">طريقة الفاتورة</label>
                                                <div class="position-relative has-icon-left">
                                                    <select class="form-control" id="printing_method"
                                                        name="printing_method">
                                                        <option value="1"
                                                            {{ old('printing_method') == 1 ? 'selected' : '' }}>الطباعة
                                                        </option>
                                                        <option value="2"
                                                            {{ old('printing_method') == 2 ? 'selected' : '' }}>ارسل عبر
                                                            البريد</option>
                                                    </select>
                                                    <div class="form-control-position">
                                                        <i class="feather icon-file-text"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- الرصيد الافتتاحي -->
                                        @foreach ($GeneralClientSettings as $GeneralClientSetting)
                                        @if($GeneralClientSetting->is_active)
                                        @if($GeneralClientSetting->key == "opening_balance")
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="opening_balance">الرصيد الافتتاحي</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="number" id="opening_balance" class="form-control"
                                                        name="opening_balance" value="{{ old('opening_balance') }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-dollar-sign"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                          @endif
                                           @endif
                                           @endforeach
                                        <!-- تاريخ الرصيد الاستحقاق -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="opening_balance_date">تاريخ الرصيد الاستحقاق</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="date" id="opening_balance_date" class="form-control"
                                                        name="opening_balance_date"
                                                        value="{{ old('opening_balance_date', date('Y-m-d')) }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- العملة -->
                                        <div class="col-md-12 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="currency">العملة</label>
                                                <div class="position-relative has-icon-left">
                                                    <select class="form-control" id="currency" name="currency">
                                                        <option value="SAR"
                                                            {{ old('currency') == 'SAR' ? 'selected' : '' }}>SAR</option>
                                                        <option value="USD"
                                                            {{ old('currency') == 'USD' ? 'selected' : '' }}>USD</option>
                                                        <option value="EUR"
                                                            {{ old('currency') == 'EUR' ? 'selected' : '' }}>EUR</option>
                                                    </select>
                                                    <div class="form-control-position">
                                                        <i class="feather icon-credit-card"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- البريد الإلكتروني -->
                                        <div class="col-md-12 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="email">البريد الإلكتروني</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="email" id="email" class="form-control"
                                                        name="email" value="{{ old('email') }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-mail"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- التصنيف -->
                                        <div class="col-md-12 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="category">التصنيف</label>
                                                <input list="classifications" class="form-control" id="client_type"
                                                    name="category" placeholder="اكتب التصنيف" value="">
                                                <datalist id="classifications" name="classification_id">
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->name }}"> <!-- هنا نعرض الـ name فقط -->
                                                    @endforeach
                                                </datalist>
                                            </div>
                                        </div>

                                        <!-- الملاحظات -->
                                        <div class="col-md-12 col-12 mb-3">
                                            <label for="notes">الملاحظات</label>
                                            <textarea class="form-control" id="notes" name="notes" rows="5" style="resize: none;">{{ old('notes') }}</textarea>
                                        </div>

                                        <!-- المرفقات -->
                                        @foreach ($GeneralClientSettings as $GeneralClientSetting)
                                        @if($GeneralClientSetting->is_active)
                                        @if($GeneralClientSetting->key == "image")
                                        <div class="col-md-12 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="attachments">المرفقات</label>
                                                <input type="file" name="attachments" id="attachments"
                                                    class="d-none">
                                                <div class="upload-area border rounded p-3 text-center position-relative"
                                                    onclick="document.getElementById('attachments').click()">
                                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                                        <i class="fas fa-cloud-upload-alt text-primary"></i>
                                                        <span class="text-primary">اضغط هنا</span>
                                                        <span>أو</span>
                                                        <span class="text-primary">اختر من جهازك</span>
                                                    </div>
                                                    <div class="position-absolute end-0 top-50 translate-middle-y me-3">
                                                        <i class="fas fa-file-alt fs-3 text-secondary"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="language">نوع العميل </label>
                                                    <div class="position-relative has-icon-left">
                                                        <select class="form-control" name="client_type" id="client_type">
                                                            <option value="1"
                                                                {{ old('client_type') == 1 ? 'selected' : '' }}>عميل VIP
                                                            </option>
                                                            <option value="2"
                                                                {{ old('client_type') == 2 ? 'selected' : '' }}>عميل عادي
                                                                عادي</option>
                                                            {{-- --}}

                                                        </select>
                                                        <div class="form-control-position">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="employee_id" class="form-label">الموظف المسؤول</label>
                                                    <select name="employee_id" id="employee_id"
                                                        class="form-control @error('employee_id') is-invalid @enderror">
                                                        <option value="">اختر الموظف</option>
                                                        @foreach ($employees as $employee)
                                                            <option value="{{ $employee->id }}">
                                                                {{ $employee->full_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('employee_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>
                                         @endif
                                         @endif
                                         @endforeach
                                        <!-- لغة العرض -->

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

        </form>
    </div>
    </div>
    </div>
@endsection

@section('scripts')

    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script>
        document.getElementById('clientForm').addEventListener('submit', function(e) {
            // e.preventDefault(); // احذف هذا السطر إذا كنت تريد أن يتم إرسال النموذج

            console.log('تم تقديم النموذج');

            // طباعة جميع البيانات المرسلة
            const formData = new FormData(this);
            for (let pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }
        });

        // دالة
    // دالة علشان نجيب الإحداثيات

    document.getElementById('clientForm').addEventListener('submit', function(e) {
        let lat = document.getElementById('latitude').value;
        let lon = document.getElementById('longitude').value;

        if (!lat || !lon) {
            e.preventDefault(); // إيقاف الإرسال إذا لم تكن هناك إحداثيات
            alert("يجب تحديد موقعك قبل إرسال النموذج!");
            getLocation(); // محاولة جلب الموقع من جديد
        }
    });

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const { latitude, longitude } = position.coords;

                    document.getElementById('latitude').value = latitude;
                    document.getElementById('longitude').value = longitude;

                    console.log('تم جلب الإحداثيات:', latitude, longitude);
                    alert('تم تسجيل الموقع بنجاح: ' + latitude + ', ' + longitude);
                },
                (error) => {
                    console.error('حدث خطأ أثناء جلب الموقع:', error);
                    alert('⚠️ يرجى السماح للمتصفح بالوصول إلى موقعك!');
                },
                { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
            );
        } else {
            alert("المتصفح لا يدعم تحديد الموقع.");
        }
    }

    // اجلب الموقع فور تحميل الصفحة
    window.onload = getLocation;

    </script>
@endsection










{{--


@extends('master')

@section('title')
    عرض تفاصيل العميل
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">تفاصيل العميل: {{ $client->trade_name }}</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('clients.index') }}">الرئيسيه</a></li>
                            <li class="breadcrumb-item active">عرض تفاصيل العميل</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">معلومات العميل</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>الاسم التجاري:</strong> {{ $client->trade_name }}</p>
                            <p><strong>الاسم الأول:</strong> {{ $client->first_name }}</p>
                            <p><strong>الاسم الأخير:</strong> {{ $client->last_name }}</p>
                            <p><strong>الهاتف:</strong> {{ $client->phone }}</p>
                            <p><strong>الجوال:</strong> {{ $client->mobile }}</p>
                            <p><strong>البريد الإلكتروني:</strong> {{ $client->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>العنوان:</strong> {{ $client->street1 }}, {{ $client->street2 }}</p>
                            <p><strong>المدينة:</strong> {{ $client->city }}</p>
                            <p><strong>المنطقة:</strong> {{ $client->region }}</p>
                            <p><strong>الرمز البريدي:</strong> {{ $client->postal_code }}</p>
                            <p><strong>البلد:</strong> {{ $client->country }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h5>المرفقات</h5>
                            @if($client->attachments)
                                <a href="{{ asset('assets/uploads/' . $client->attachments) }}" target="_blank">
                                    <img src="{{ asset('assets/uploads/' . $client->attachments) }}" alt="Attachment" style="width: 100px; height: auto;">
                                </a>
                            @else
                                <p>لا توجد مرفقات.</p>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h5>جهات الاتصال</h5>
                            @if($client->contacts->isNotEmpty())
                                <ul>
                                    @foreach($client->contacts as $contact)
                                        <li>{{ $contact->name }} - {{ $contact->phone }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p>لا توجد جهات اتصال.</p>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h5>الإحداثيات</h5>
                            @if($client->locations->isNotEmpty())
                                @foreach($client->locations as $location)
                                    <p><strong>خط العرض:</strong> {{ $location->latitude }}</p>
                                    <p><strong>خط الطول:</strong> {{ $location->longitude }}</p>
                                    <div id="map" style="height: 400px; width: 100%;"></div>
                                    <script>
                                        function initMap() {
                                            const clientLocation = { lat: {{ $location->latitude }}, lng: {{ $location->longitude }} };
                                            const map = new google.maps.Map(document.getElementById("map"), {
                                                zoom: 15,
                                                center: clientLocation,
                                            });
                                            new google.maps.Marker({
                                                position: clientLocation,
                                                map: map,
                                                title: "موقع العميل",
                                            });
                                        }
                                    </script>
                                    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDd6qRt4o5zv4V9L2kE2w6bWmV2gK2XVU&callback=initMap"></script>
                                @endforeach
                            @else
                                <p>لا توجد إحداثيات مسجلة.</p>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('clients.index') }}" class="btn btn-outline-primary">عودة إلى القائمة</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection --}}
