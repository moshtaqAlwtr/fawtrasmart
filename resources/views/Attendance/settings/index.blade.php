@extends('master')

@section('title')
إعدادات الحضور
@stop
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

@section('content')
<div class="content-body">

    <section class="container">
        <div class="row g-4">
            <!-- قوائم العطلات -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card text-center shadow h-100">
                    <div class="card-body">
                        <a href="{{ route('holiday_lists.index') }}" class="text-decoration-none text-dark">
                            <div class="mb-3">
                                <i class="bi bi-calendar3 display-4 text-warning"></i>
                            </div>
                            <h5><strong>قوائم العطلات</strong></h5>
                        </a>
                    </div>
                </div>
            </div>

            <!-- قواعد الحضور -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card text-center shadow h-100">
                    <div class="card-body">
                        <a href="{{ route('attendance.settings.flags.index') }}" class="text-decoration-none text-dark">
                            <div class="mb-3">
                                <i class="bi bi-clipboard-check display-4 text-success"></i>
                            </div>
                            <h5><strong>قواعد الحضور</strong></h5>
                        </a>
                    </div>
                </div>
            </div>

            <!-- نوع الإجازات -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card text-center shadow h-100">
                    <div class="card-body">
                        <a href="{{ route('leave_types.index') }}" class="text-decoration-none text-dark">
                            <div class="mb-3">
                                <i class="bi bi-box-arrow-in-right display-4 text-primary"></i>
                            </div>
                            <h5><strong>نوع الإجازات</strong></h5>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-4">
            <!-- الماكينات -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card text-center shadow h-100">
                    <div class="card-body">
                        <a href="{{ route('attendance.settings.machines.index') }}" class="text-decoration-none text-dark">
                            <div class="mb-3">
                                <i class="bi bi-cpu display-4 text-purple"></i>
                            </div>
                            <h5><strong>الماكينات</strong></h5>
                        </a>
                    </div>
                </div>
            </div>

            <!-- سياسة الإجازات -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card text-center shadow h-100">
                    <div class="card-body">
                        <a href="{{ route('leave_policy.index') }}" class="text-decoration-none text-dark">
                            <div class="mb-3">
                                <i class="bi bi-bookmark-star display-4 text-danger"></i>
                            </div>
                            <h5><strong>سياسة الإجازات</strong></h5>
                        </a>
                    </div>
                </div>
            </div>

            <!-- الإعدادات الأساسية -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card text-center shadow h-100">
                    <div class="card-body">
                        <a href="{{ route('settings_basic.index') }}" class="text-decoration-none text-dark">
                            <div class="mb-3">
                                <i class="bi bi-gear display-4 text-secondary"></i>
                            </div>
                            <h5><strong>الإعدادات الأساسية</strong></h5>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-4">
            <!-- محددات الحضور -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card text-center shadow h-100">
                    <div class="card-body">
                        <a href="{{ route('attendance_determinants.index') }}" class="text-decoration-none text-dark">
                            <div class="mb-3">
                                <i class="bi bi-person-check display-4 text-teal"></i>
                            </div>
                            <h5><strong>محددات الحضور</strong></h5>
                        </a>
                    </div>
                </div>
            </div>

            <!-- قوالب الطباعة -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card text-center shadow h-100">
                    <div class="card-body">
                        <a href="{{ route('attendance.settings.printable-templates.index') }}" class="text-decoration-none text-dark">
                            <div class="mb-3">
                                <i class="bi bi-printer display-4 text-dark"></i>
                            </div>
                            <h5><strong>قوالب الطباعة</strong></h5>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
