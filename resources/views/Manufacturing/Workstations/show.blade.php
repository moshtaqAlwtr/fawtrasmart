@extends('master')

@section('title')
محطة العمل
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">محطة العمل</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a>
                            </li>
                            <li class="breadcrumb-item active">{{ $workstation->name }} | <small class="text-muted">#{{ $workstation->code }}</small>
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
                        <a href="{{ route('manufacturing.workstations.edit',$workstation->id) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fa fa-edit"></i>تعديل
                        </a>
                        <a class="btn btn-sm btn-outline-danger" href="#" data-toggle="modal" data-target="#modal_DELETE{{ $workstation->id }}">
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
                                <strong>معلومات محطة العمل</strong>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td style="width: 50%">
                                                    <p><small>الاسم</small></p>
                                                    <strong>{{ $workstation->name }}</strong>
                                                </td>
                                                <td>
                                                    <p><small>إجمالي التكلفة</small></p>
                                                    <h4><strong>{{ $workstation->total_cost }} ر.س</strong></h4>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 20%">
                                                    <p><small>الوحدة</small></p>
                                                    <strong>{{ $workstation->unit }}</strong>
                                                </td>
                                                <td>
                                                    <p><small>الوصف</small></p>
                                                    <strong>{{ $workstation->description }}</strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header p-1" style="background: #f8f8f8">
                                <strong >التكلفة</strong>
                            </div>

                            @if(isset($workstation->stationsCosts) && !@empty($workstation->stationsCosts))
                                <div class="card-body">
                                    <p><strong>المصروفات : </strong></p>
                                    <div class="row">
                                        <table class="table table-striped">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th style="width: 50%">التكلفة</th>
                                                    <th>الحساب</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($workstation->stationsCosts as $stationsCost)
                                                    <tr>
                                                        <td>{{ $stationsCost->cost_expenses }} <small class="text-muted"> - {{ $workstation->unit }}</small></td>
                                                        <td>{{ $stationsCost->accountExpenses->name }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif

                            @if($workstation->cost_wages && $workstation->account_wages)
                                <div class="card-body">
                                    <p><strong>الأجور : </strong></p>
                                    <div class="row">
                                        <table class="table table-striped">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th style="width: 50%">التكلفة</th>
                                                    <th>الحساب</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{ $workstation->cost_wages }} <small class="text-muted"> - {{ $workstation->unit }}</small></td>
                                                    <td>{{ $workstation->accountWages->name }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif

                            @if($workstation->cost_wages && $workstation->account_wages)
                                <div class="card-body">
                                    <p><strong>أصل : </strong></p>
                                    <div class="row">
                                        <table class="table table-striped">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th style="width: 50%">التكلفة</th>
                                                    <th>الحساب</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{ $workstation->cost_origin }} <small class="text-muted"> - {{ $workstation->unit }}</small></td>
                                                    <td>{{ $workstation->accountOrigin->name }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif

                        </div>

                    </div>

                    <div class="tab-pane" id="activate" aria-labelledby="activate-tab" role="tabpanel">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">

                                    <ul class="activity-timeline timeline-left list-unstyled">
                                        <li>
                                            <div class="timeline-icon bg-success">
                                                <i class="feather icon-package font-medium-2"></i>
                                            </div>
                                            <div class="timeline-info">
                                                <p>
                                                    <strong>{{ optional($workstation->createdByUser)->name }}</strong>
                                                    قام بإضافة محطة العمل
                                                    <strong>#{{ $workstation->code }}</strong> - <strong>{{ $workstation->name }}</strong>
                                                </p>
                                                <br>
                                                <span>
                                                    <i class="fa fa-clock-o"></i> {{ $workstation->created_at->format('H:i:s') }} -
                                                    <i class="fa fa-user"></i> {{ optional($workstation->createdByUser)->name }}
                                                </span>
                                            </div>
                                        </li>
                                        <hr>

                                        @if($workstation->updated_by)
                                        <li>
                                            <div class="timeline-icon bg-warning">
                                                <i class="feather icon-edit font-medium-2"></i>
                                            </div>
                                            <div class="timeline-info">
                                                <p>
                                                    <strong>{{ optional($workstation->updatedByUser)->name }}</strong>
                                                    قام بتعديل محطة العمل
                                                    <strong>#{{ $workstation->code }}</strong> - <strong>{{ $workstation->name }}</strong>
                                                </p>
                                                <br>
                                                <span>
                                                    <i class="fa fa-clock-o"></i> {{ $workstation->updated_at->format('H:i:s') }} -
                                                    <i class="fa fa-user"></i> {{ optional($workstation->updatedByUser)->name }}
                                                </span>
                                            </div>
                                        </li>
                                        <hr>
                                        @endif
                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <!-- Modal delete -->
    <div class="modal fade text-left" id="modal_DELETE{{ $workstation->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #EA5455 !important;">
                    <h4 class="modal-title" id="myModalLabel1" style="color: #FFFFFF">حذف {{ $workstation->name }}</h4>
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
                    <a href="{{ route('manufacturing.paths.delete', $workstation->id) }}" class="btn btn-danger waves-effect waves-light">تأكيد</a>
                </div>
            </div>
        </div>
    </div>
    <!--end delete-->

@endsection


@section('scripts')



@endsection
