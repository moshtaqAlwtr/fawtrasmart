@extends('master')

@section('title')
مسار الإنتاج
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">مسار الإنتاج</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a>
                            </li>
                            <li class="breadcrumb-item active">{{ $path->name }} | <small class="text-muted">#{{ $path->code }}</small>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">

        @include('layouts.alerts.error')
        @include('layouts.alerts.success')

        <div class="card">
            <div class="card-title">
                <div class="d-flex justify-content-between align-items-center flex-wrap p-1">
                    <div>
                        <a href="{{ route('manufacturing.paths.edit',$path->id) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fa fa-edit"></i>تعديل
                        </a>
                        <a class="btn btn-sm btn-outline-danger" href="#" data-toggle="modal" data-target="#modal_DELETE{{ $path->id }}">
                            <i class="fa fa-trash me-2"></i>حذف
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" aria-controls="home" role="tab" aria-selected="false">معلومات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="activate-tab" data-toggle="tab" href="#activate" aria-controls="about" role="tab" aria-selected="true">سجل النشاطات</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="home" aria-labelledby="home-tab" role="tabpanel">
                        <div class="card">
                            <div class="card-header p-1" style="background: #f8f8f8">
                                <strong>معلومات مسار الإنتاج</strong>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td style="width: 50%">
                                                    <p><small>الاسم</small></p>
                                                    <strong>{{ $path->name }}</strong>
                                                </td>
                                                <td>
                                                    <p><small>الكود</small></p>
                                                    <strong>#{{ $path->code }}</strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header p-1" style="background: #f8f8f8">
                                <strong >المرحلة الإنتاجية</strong>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th style="width: 20%">رقم</th>
                                                <th>لاسم</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                @if(isset($path->stages) && !@empty($path->stages))
                                                    @foreach($path->stages as $key => $stage)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $stage->stage_name }}</td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <div class="alert alert-danger text-xl-center" role="alert">
                                                        <p class="mb-0">
                                                            لا توجد مراحل انتاج مضافة حتى الان !!
                                                        </p>
                                                    </div>
                                                @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane" id="activate" aria-labelledby="activate-tab" role="tabpanel">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <ul class="activity-timeline timeline-left list-unstyled">
                                        @foreach ($paths as $path)
                                            <li>
                                                <div class="timeline-icon bg-success">
                                                    <i class="feather icon-package font-medium-2"></i>
                                                </div>
                                                <div class="timeline-info">
                                                    <p>
                                                        <strong>{{ $path->createdBy->name }}</strong> قام بإضافة مسار الإنتاج
                                                        <strong>#{{ $path->code }}</strong> - <strong>{{ $path->name }}</strong>
                                                    </p>
                                                    <br>
                                                    <span>
                                                        <i class="fa fa-clock-o"></i> {{ $path->created_at->format('H:i:s') }} -
                                                        <i class="fa fa-user"></i> {{ $path->createdBy->name }}
                                                    </span>
                                                </div>
                                            </li>
                                            <hr>

                                            @foreach ($path->stages as $stage)
                                                <li>
                                                    <div class="timeline-icon bg-primary">
                                                        <i class="feather icon-layers font-medium-2"></i>
                                                    </div>
                                                    <div class="timeline-info">
                                                        <p>
                                                            <strong>{{ $path->createdBy->name }}</strong> قام بإضافة المرحلة الإنتاجية
                                                            <strong>{{ $stage->stage_name }}</strong>
                                                        </p>
                                                        <br>
                                                        <span>
                                                            <i class="fa fa-clock-o"></i> {{ $stage->created_at->format('H:i:s') }} -
                                                            <i class="fa fa-user"></i> {{ $path->createdBy->name }}
                                                        </span>
                                                    </div>
                                                </li>
                                                <hr>
                                            @endforeach

                                        @endforeach
                                    </ul>

                                    @if($paths->isEmpty())
                                        <div class="alert alert-danger text-center" role="alert">
                                            <p class="mb-0"> لا توجد مسارات إنتاج مضافة حتى الآن !! </p>
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

    <!-- Modal delete -->
    <div class="modal fade text-left" id="modal_DELETE{{ $path->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #EA5455 !important;">
                    <h4 class="modal-title" id="myModalLabel1" style="color: #FFFFFF">حذف {{ $path->name }}</h4>
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
                    <a href="{{ route('manufacturing.paths.delete', $path->id) }}" class="btn btn-danger waves-effect waves-light">تأكيد</a>
                </div>
            </div>
        </div>
    </div>
    <!--end delete-->

@endsection


@section('scripts')



@endsection
