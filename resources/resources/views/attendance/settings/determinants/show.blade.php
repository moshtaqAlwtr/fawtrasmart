@extends('master')

@section('title', 'عرض محدد الحضور')

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">{{ $attendance_determinant->name }}</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a></li>
                            <li class="breadcrumb-item active">عرض</li>
                            <li class="breadcrumb-item active">
                                @if($attendance_determinant->status == 0)
                                    <span class="mr-1 bullet bullet-success bullet-sm"></span><span class="mail-date">نشط</span>
                                @else
                                    <span class="mr-1 bullet bullet-danger bullet-sm"></span><span class="mail-date">غير نشط</span>
                                @endif
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.alerts.error')
    @include('layouts.alerts.success')

    <div class="card">
        <div class="card-title p-2">
            <a href="#" class="btn btn-outline-danger btn-sm waves-effect waves-light" data-toggle="modal" data-target="#modal_DELETE{{ $attendance_determinant->id }}">حذف <i class="fa fa-trash"></i></a>
            <a href="{{ route('attendance_determinants.edit',$attendance_determinant->id) }}" class="btn btn-outline-primary btn-sm waves-effect waves-light">تعديل <i class="fa fa-edit"></i></a>
            <a href="{{ route('attendance_determinants.updateStatus',$attendance_determinant->id) }}" class="btn btn-outline-{{ $attendance_determinant->status == 0 ? 'danger' : 'success' }} btn-sm waves-effect waves-light">
                {{ $attendance_determinant->status == 0 ? 'تعطيل' : 'تفعيل' }} <i class="fa {{ $attendance_determinant->status == 0 ? 'fa-ban' : 'fa-check' }}"></i>
            </a>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details" role="tab"
                        aria-controls="details" aria-selected="true">تفاصيل </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="activity-log-tab" data-toggle="tab" href="#activity-log" role="tab"
                        aria-controls="activity-log" aria-selected="false">سجل النشاطات</a>
                </li>
            </ul>

            <div class="tab-content">
                <!-- تفاصيل  -->
                <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                    <div class="tab-content">
                        <div class="card">
                            <div class="card-body">

                                <div class="row">
                                    <table class="table">
                                        <thead style="background: #f8f8f8">
                                            <tr>
                                                <th>مطابقة ال IP</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <label for=""></label>
                                                        <input type="checkbox" disabled  {{ $attendance_determinant->enable_ip_verification == 1 ? 'checked' : '' }} >
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">تعيين ال IPs المسموح بها إلى التوقيع</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p><small>التحقيق</small>: </p><strong>{{ $attendance_determinant->ip_investigation == 1 ? 'مطلوب' : 'اختياري' }}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p><small>بروتوكولات التعريف الشبكى المسموح بها </small>: </p><span>{{ $attendance_determinant->allowed_ips }}</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="row">
                                    <table class="table">
                                        <thead style="background: #f8f8f8">
                                            <tr>
                                                <th>مطابقة صور الموظفين</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <label for=""></label>
                                                        <input type="checkbox" disabled  {{ $attendance_determinant->capture_employee_image == 1 ? 'checked' : '' }} >
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">التقاط صور الموظفين</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p><small>التحقيق</small>: </p><strong>{{ $attendance_determinant->image_investigation == 1 ? 'مطلوب' : 'اختياري' }}</strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="row">
                                    <table class="table">
                                        <thead style="background: #f8f8f8">
                                            <tr>
                                                <th>مطابقة موقع الحضور</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <label for=""></label>
                                                        <input type="checkbox" disabled  {{ $attendance_determinant->enable_location_verification == 1 ? 'checked' : '' }} >
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">تعيين نطاق موقع الحضور</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p><small>التحقيق</small>: </p><strong>{{ $attendance_determinant->location_investigation == 1 ? 'مطلوب' : 'اختياري' }}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p><small>نطاق الموقع </small>: </p><span>{{ $attendance_determinant->radius }} {{ $attendance_determinant->radius_type == 1 ? 'متر' : 'كيلومتر' }}</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div id="map" style="width: 100%; height: 400px"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- سجل النشاطات -->
                <div class="tab-pane fade" id="activity-log" role="tabpanel" aria-labelledby="activity-log-tab">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center gap-3 w-100">

                            <!-- أزرار للأعلى وللأسفل -->
                            <div class="btn-group">
                                <button class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-chevron-up"></i>
                                </button>
                                <button class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                            </div>

                            <!-- حقل اختيار الإجراءات -->
                            <div class="input-group flex-grow-1">
                                <select class="form-control form-control-sm select2">
                                    <option value="">كل الاجراءات</option>
                                    <option value="1">الكل</option>
                                </select>
                            </div>

                            <!-- حقل اختيار الفاعلين -->
                            <div class="input-group flex-grow-1">
                                <select class="form-control form-control-sm select2">
                                    <option value="">كل الفاعلين</option>
                                    <option value="1">الكل</option>
                                </select>
                            </div>

                            <!-- حقل الفترة -->
                            <div class="input-group flex-grow-1">
                                <input type="text" class="form-control form-control-sm"
                                    placeholder="الفترة من / إلى">
                            </div>

                            <!-- أزرار لليمين ولليسار -->
                            <div class="btn-group">
                                <button class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                                <button class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                            </div>

                        </div>
                    </div>


                    <div class="position-relative">
                        <div class="position-absolute end-0 me-4">
                            <button class="btn btn-light btn-sm rounded-pill shadow-sm">اليوم</button>
                        </div>
                        <div class="car" style="background: #f8f9fa">
                            <div class="activity-list p-4">
                                <div class="card-content">
                                    <div class="card border-0">
                                        <ul class="activity-timeline timeline-left list-unstyled">
                                            <li class="d-flex position-relative mb-4">
                                                <div class="timeline-icon position-absolute"
                                                    style="left: -43px; top: 0;">
                                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center"
                                                        style="width: 35px; height: 35px;">
                                                        <i class="fas fa-plus text-white"></i>
                                                    </div>
                                                </div>
                                                <div class="timeline-info position-relative"
                                                    style="padding-left: 20px; border-left: 2px solid #e9ecef;">
                                                    <div class="d-flex align-items-center mb-1">
                                                        <span class="badge bg-purple me-2">محمد العتيبي</span>
                                                        <span class="text-dark">قام بإضافة المسمى الوظيفي moshtaq
                                                            #1</span>
                                                    </div>
                                                    <div class="d-flex align-items-center mt-2">
                                                        <small class="text-muted me-3">
                                                            <i class="fas fa-building me-1"></i>
                                                            Main Branch
                                                        </small>
                                                        <small class="text-muted">
                                                            <i class="far fa-clock me-1"></i>
                                                            14:45:53
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="ms-auto">
                                                    <a href="#" class="text-muted">
                                                        <i class="fas fa-external-link-alt"></i>
                                                    </a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal delete -->
    <div class="modal fade text-left" id="modal_DELETE{{ $attendance_determinant->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #EA5455 !important;">
                    <h4 class="modal-title" id="myModalLabel1" style="color: #FFFFFF">حذف {{ $attendance_determinant->name }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: #DC3545">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <strong>
                        هل انت متاكد من انك تريد الحذف ؟
                    </strong>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect waves-light" data-dismiss="modal">الغاء</button>
                    <a href="{{ route('attendance_determinants.delete',$attendance_determinant->id) }}" class="btn btn-danger waves-effect waves-light">تأكيد</a>
                </div>
            </div>
        </div>
    </div>
    <!--end delete-->

@endsection

@section('scripts')
    <script>
        function initMap() {
            const latitude = {{ $attendance_determinant->latitude }};
            const longitude = {{ $attendance_determinant->longitude }};

            const center = { lat: latitude, lng: longitude };

            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 12,
                center: center,
            });

            new google.maps.Marker({
                position: center,
                map: map,
            });
        }
    </script>

    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB6Hsnt5MiyjXtrGT5q-5KUj09XmLPV5So&callback=initMap">
    </script>
@endsection
