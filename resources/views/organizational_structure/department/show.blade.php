@extends('master')

@section('title')
    عرض مسمى الوظيفي
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">{{ $department->name }}</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a></li>
                            <li class="breadcrumb-item active">عرض</li>
                            <li class="breadcrumb-item active">
                                @if ($department->status == 0)
                                    <div class="badge badge-pill badge badge-success">نشط</div>
                                @else
                                    <div class="badge badge-pill badge badge-danger">غير نشط</div>
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
            <a href="#" class="btn btn-outline-danger btn-sm waves-effect waves-light" data-toggle="modal" data-target="#modal_DELETE{{ $department->id }}">حذف <i class="fa fa-trash"></i></a>
            <a href="{{ route('department.edit',$department->id) }}" class="btn btn-outline-primary btn-sm waves-effect waves-light">تعديل <i class="fa fa-edit"></i></a>
            <a href="{{ route('department.updateStatus',$department->id) }}" class="btn btn-outline-{{ $department->status == 0 ? 'danger' : 'success' }} btn-sm waves-effect waves-light">
                {{ $department->status == 0 ? 'تعطيل' : 'تفعيل' }} <i class="fa {{ $department->status == 0 ? 'fa-ban' : 'fa-check' }}"></i>
            </a>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details" role="tab"
                        aria-controls="details" aria-selected="true">تفاصيل </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="journal-entries-tab" data-toggle="tab" href="#journal-entries"
                        role="tab" aria-controls="journal-entries" aria-selected="false">الموطفين المُعَيَّنون ({{ $department->employees->where('employee_type',1)->count() }})
                    </a>
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
                                                <th style="width: 70%">معلومات نوع وظيفة</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <p><small>الوصف</small>: </p><span>{{ $department->description }}</span>
                                                </td>
                                                <td>
                                                    <p><small>الاختصار</small>: </p><strong>{{ $department->short_name }}</strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <table class="table">
                                        <thead style="background: #f8f8f8">
                                            <tr>
                                                <th>المديرون المُعَيَّنون</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($department->employees as $employee)
                                                <tr>
                                                    <td style="width: 10%">#{{ $employee->id }}</td>
                                                    <td>{{ $employee->full_name }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- الحركات -->
                <div class="tab-pane fade" id="journal-entries" role="tabpanel"
                    aria-labelledby="journal-entries-tab">
                    <div class="card">
                        <div class="card-body">
                            @if ($department->employees->where('employee_type',1) !== null && !@empty($department->employees->where('employee_type',1)) && count($department->employees->where('employee_type',1)) > 0)
                                <table class="table">
                                    <thead style="background: #f8f8f8">
                                        <tr>
                                            <th>الموطفين المُعَيَّنون</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($department->employees->where('employee_type',1) as $employee)
                                            <tr>
                                                <td style="width: 10%">#{{ $employee->id }}</td>
                                                <td>{{ $employee->full_name }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="alert alert-danger text-xl-center">
                                    لا يوجد  موظفين حتى الان !!
                                </div>
                            @endif
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
    <div class="modal fade text-left" id="modal_DELETE{{ $department->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #EA5455 !important;">
                    <h4 class="modal-title" id="myModalLabel1" style="color: #FFFFFF">حذف {{ $department->name }}</h4>
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
                    <a href="{{ route('department.delete', $department->id) }}" class="btn btn-danger waves-effect waves-light">تأكيد</a>
                </div>
            </div>
        </div>
    </div>
    <!--end delete-->

@endsection
