@extends('master')

@section('title')
التكاليف غير المباشرة
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">التكاليف غير المباشرة</h2>
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

        @include('layouts.alerts.error')
        @include('layouts.alerts.success')

        <div class="card">
            <div class="card-title">
                <div class="d-flex justify-content-between align-items-center flex-wrap p-1">
                    <div>
                        <a href="{{ route('manufacturing.indirectcosts.edit', $indirectCost->id) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fa fa-edit"></i>تعديل
                        </a>
                        <a class="btn btn-sm btn-outline-danger" href="#" data-toggle="modal" data-target="#modal_DELETE{{ $indirectCost->id }}">
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
                                <strong>معلومات التكاليف غير المباشرة</strong>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td style="width: 50%">
                                                    <p><small>الحساب</small></p>
                                                    <strong>{{ $indirectCost->account->name }}</strong>
                                                </td>
                                                <td>
                                                    <p><small>اجمالي التكاليف</small></p>
                                                    <strong>{{ $indirectCost->total }}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 50%">
                                                    <p><small>من تاريخ</small></p>
                                                    <strong>{{ $indirectCost->from_date }}</strong>
                                                </td>
                                                <td>
                                                    <p><small>الي تاريخ</small></p>
                                                    <strong>{{ $indirectCost->to_date }}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 50%">
                                                    <p><small>نوع التوزيع</small></p>
                                                    <strong>
                                                        @if($indirectCost->based_on == 1)
                                                            بناءً على الكمية
                                                        @else
                                                            بناءً على التكلفة
                                                        @endif
                                                    </strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="card">

                            @if(isset($indirectCost->indirectCostItems) && !@empty($indirectCost->indirectCostItems) && count($indirectCost->indirectCostItems) > 0)
                                <div class="card-body">
                                    <p><strong>القيود اليومية : </strong></p>
                                    <div class="row">
                                        <table class="table table-striped">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th style="width: 50%">قيد</th>
                                                    <th>المجموع</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($indirectCost->indirectCostItems as $item)
                                                    <tr>
                                                        <td>{{ $item->restriction_id }}</td>
                                                        <td>{{ $item->restriction_total }} ر.س</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif

                            @if(isset($indirectCost->indirectCostItems) && !@empty($indirectCost->indirectCostItems) && count($indirectCost->indirectCostItems) > 0)
                                <div class="card-body">
                                    <p><strong>أوامر التصنيع : </strong></p>
                                    <div class="row">
                                        <table class="table table-striped">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th style="width: 50%">أمر التصنيع</th>
                                                    <th>المبلغ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($indirectCost->indirectCostItems as $item)
                                                    <tr>
                                                        <td>{{ $item->ManufacturingOrder->name }}</td>
                                                        <td>{{ $item->manufacturing_price }} ر.س</td>
                                                    </tr>
                                                @endforeach
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
                                                    <strong>{{ optional($indirectCost->createdByUser)->name }}</strong>
                                                    قام بإضافة قائمة مواد الإنتاج
                                                    <strong>#{{ $indirectCost->code }}</strong> - <strong>{{ $indirectCost->name }}</strong>
                                                </p>
                                                <br>
                                                <span>
                                                    <i class="fa fa-clock-o"></i> {{ $indirectCost->created_at->format('H:i:s') }} -
                                                    <i class="fa fa-user"></i> {{ optional($indirectCost->createdByUser)->name }}
                                                </span>
                                            </div>
                                        </li>
                                        <hr>

                                        @if($indirectCost->updated_by)
                                        <li>
                                            <div class="timeline-icon bg-warning">
                                                <i class="feather icon-edit font-medium-2"></i>
                                            </div>
                                            <div class="timeline-info">
                                                <p>
                                                    <strong>{{ optional($indirectCost->updatedByUser)->name }}</strong>
                                                    قام بتعديل قائمة مواد الإنتاج
                                                    <strong>#{{ $indirectCost->code }}</strong> - <strong>{{ $indirectCost->name }}</strong>
                                                </p>
                                                <br>
                                                <span>
                                                    <i class="fa fa-clock-o"></i> {{ $indirectCost->updated_at->format('H:i:s') }} -
                                                    <i class="fa fa-user"></i> {{ optional($indirectCost->updatedByUser)->name }}
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
    <div class="modal fade text-left" id="modal_DELETE{{ $indirectCost->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #EA5455 !important;">
                    <h4 class="modal-title" id="myModalLabel1" style="color: #FFFFFF">حذف التكاليف غير المباشرة</h4>
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
                    <a href="{{ route('manufacturing.indirectcosts.delete', $indirectCost->id) }}" class="btn btn-danger waves-effect waves-light">تأكيد</a>
                </div>
            </div>
        </div>
    </div>
    <!--end delete-->

@endsection
