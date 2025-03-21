@extends('master')

@section('title', 'محددات الحضور')

@section('content')
    <!-- Header Section -->
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">محددات الحضور</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">الرئيسية</a></li>
                            <li class="breadcrumb-item active">إضافة</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                </div>
                <div>
                    <a href="{{ route('attendance_determinants.index') }}" class="btn btn-outline-danger">
                        <i class="fa fa-ban"></i> إلغاء
                    </a>
                    <button type="submit" form="AttendanceDeterminantForm" class="btn btn-outline-primary">
                        <i class="fa fa-save"></i> حفظ
                    </button>
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Section -->
    <div class="card">
        <div class="card-body">
            <h6 class="mb-2 p-1" style="background: #f8f8f8">معلومات قيد الحضور</h6>
            <form id="AttendanceDeterminantForm" method="POST" action="{{ route('attendance_determinants.store') }}">
                @csrf
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label for="employee" class="form-label">الاسم <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="application-date" name="name" value="{{ old('name') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="">الحالة <span class="text-danger">*</span></label>
                        <select name="status" class="form-control">
                            <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>نشط</option>
                            <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>غير نشط</option>
                        </select>
                    </div>
                </div>

                <h6 class="mb-2 p-1" style="background: #f8f8f8">مطابقة صور الموظفين</h6>

                <div class="row mb-2">
                    <div class="col-md-6 mt-1">
                        <fieldset>
                            <div class="vs-checkbox-con vs-checkbox-primary">
                                <input type="checkbox" value="1" name="capture_employee_image" {{ old('capture_employee_image') == 1 ? 'checked' : '' }}>
                                <span class="vs-checkbox">
                                    <span class="vs-checkbox--check">
                                        <i class="vs-icon feather icon-check"></i>
                                    </span>
                                </span>
                                <span class="">التقاط صور الموظفين</span>
                            </div>
                        </fieldset>
                    </div>

                    <div class="col-md-6">
                        <label for="">التحقق <span class="text-danger">*</span></label>
                        <select name="image_investigation" class="form-control">
                            <option value="1" {{ old('image_investigation') == 1 ? 'selected' : '' }}>مطلوب</option>
                            <option value="2" {{ old('image_investigation') == 2 ? 'selected' : '' }}>اختياري</option>
                        </select>
                    </div>
                </div>

                <h6 class="mb-2 p-1" style="background: #f8f8f8">مطابقة ال IP</h6>

                <div class="row mb-2">
                    <div class="col-md-6 mt-1">
                        <fieldset>
                            <div class="vs-checkbox-con vs-checkbox-primary">
                                <input type="checkbox" value="1" name="enable_ip_verification" {{ old('enable_ip_verification') == 1 ? 'checked' : '' }}>
                                <span class="vs-checkbox">
                                    <span class="vs-checkbox--check">
                                        <i class="vs-icon feather icon-check"></i>
                                    </span>
                                </span>
                                <span class="">تعيين ال IPs المسموح بها إلى التوقيع</span>
                            </div>
                        </fieldset>
                    </div>

                    <div class="col-md-6">
                        <label for="">التحقق <span class="text-danger">*</span></label>
                        <select name="image_investigation" class="form-control">
                            <option value="1" {{ old('image_investigation') == 1 ? 'selected' : '' }}>مطلوب</option>
                            <option value="2" {{ old('image_investigation') == 2 ? 'selected' : '' }}>اختياري</option>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label for="">بروتوكولات التعريف الشبكى المسموح بها <span class="text-danger">*</span></label>
                        <textarea name="allowed_ips" class="form-control" rows="2">{{ old('allowed_ips','2a02:cb80:4226:39aa:a4b2:a9c2:913d:a3de') }}</textarea>
                    </div>
                </div>

                <h6 class="mb-2 p-1" style="background: #f8f8f8">مطابقة موقع الحضور</h6>

                <div class="row mb-2">
                    <div class="col-md-6 mt-1">
                        <fieldset>
                            <div class="vs-checkbox-con vs-checkbox-primary">
                                <input type="checkbox" value="1" name="enable_location_verification" {{ old('enable_location_verification') == 1 ? 'checked' : '' }}>
                                <span class="vs-checkbox">
                                    <span class="vs-checkbox--check">
                                        <i class="vs-icon feather icon-check"></i>
                                    </span>
                                </span>
                                <span class="">تعيين نطاق موقع الحضور</span>
                            </div>
                        </fieldset>
                    </div>

                    <div class="col-md-6">
                        <label for="">التحقق <span class="text-danger">*</span></label>
                        <select name="location_investigation" class="form-control">
                            <option value="1" {{ old('location_investigation') == 1 ? 'selected' : '' }}>مطلوب</option>
                            <option value="2" {{ old('location_investigation') == 2 ? 'selected' : '' }}>اختياري</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="">نطاق التوقيع <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" min="1" step="0.01"  name="radius" value="{{ old('radius') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="">المقياس <span class="text-danger">*</span></label>
                        <select name="radius_type" class="form-control">
                            <option value="1" {{ old('radius_type') == 1 ? 'selected' : '' }}>أمتار</option>
                            <option value="2" {{ old('radius_type') == 2 ? 'selected' : '' }}>كيلومترات</option>
                        </select>
                    </div>

                    <br>

                    <div class="col-md-12">
                        <label class="mb-2">الموقع <span class="text-danger">*</span></label>
                        <div id="map" style="width: 100%; height: 400px"></div>
                        <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                        <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
                    </div>
                </div>


            </form>
        </div>
    </div>

@endsection

@section('scripts')

    <script>
        function initMap() {
            // إعداد موقع الخريطة الافتراضي
            const center = { lat: 24.7136, lng: 46.6753 }; // الرياض كموقع افتراضي

            // إنشاء الخريطة
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 12,
                center: center,
            });

            // إضافة مؤشر يتم تحديثه عند النقر أو السحب
            const marker = new google.maps.Marker({
                position: center,
                map: map,
                draggable: true, // يتيح سحب المؤشر
            });

            // تحديث الحقول المخفية عند تحريك المؤشر
            function updateHiddenFields(lat, lng) {
                document.getElementById("latitude").value = lat;
                document.getElementById("longitude").value = lng;
            }

            // حدث النقر على الخريطة
            map.addListener("click", function (event) {
                const latitude = event.latLng.lat(); // إحداثيات العرض (Latitude)
                const longitude = event.latLng.lng(); // إحداثيات الطول (Longitude)

                // نقل المؤشر إلى الموقع الجديد
                marker.setPosition(event.latLng);

                // تحديث الحقول المخفية
                updateHiddenFields(latitude, longitude);
            });

            // حدث سحب المؤشر
            marker.addListener("dragend", function (event) {
                const latitude = event.latLng.lat(); // إحداثيات العرض (Latitude)
                const longitude = event.latLng.lng(); // إحداثيات الطول (Longitude)

                // تحديث الحقول المخفية
                updateHiddenFields(latitude, longitude);
            });

            // إعداد القيم الافتراضية للحقلين المخفيين عند تحميل الخريطة
            updateHiddenFields(center.lat, center.lng);
        }
    </script>

    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB6Hsnt5MiyjXtrGT5q-5KUj09XmLPV5So&callback=initMap">
    </script>

@endsection
