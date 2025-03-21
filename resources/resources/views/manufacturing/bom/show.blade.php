@extends('master')

@section('title')
قائمة مواد الإنتاج
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">قائمة مواد الإنتاج</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a>
                            </li>
                            <li class="breadcrumb-item active">{{ $productionMaterial->name }} | <small class="text-muted">#{{ $productionMaterial->code }}</small>
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
                        <a href="{{ route('Bom.edit', $productionMaterial->id) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fa fa-edit"></i>تعديل
                        </a>
                        <a class="btn btn-sm btn-outline-danger" href="#" data-toggle="modal" data-target="#modal_DELETE{{ $productionMaterial->id }}">
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
                                <strong>معلومات قائمة مواد الإنتاج</strong>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td style="width: 50%">
                                                    <p><small>الاسم</small></p>
                                                    <strong>{{ $productionMaterial->name }}</strong>
                                                </td>
                                                <td>
                                                    <p><small>الكمية</small></p>
                                                    <strong>{{ $productionMaterial->quantity }}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 50%">
                                                    <p><small>كود</small></p>
                                                    <strong>{{ $productionMaterial->code }}</strong>
                                                </td>
                                                <td>
                                                    <p><small>مسار الإنتاج</small></p>
                                                    <strong>{{ $productionMaterial->productionPath->name }}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 50%">
                                                    <p><small>المنتجات</small></p>
                                                    <strong>{{ $productionMaterial->product->name }}</strong>
                                                </td>
                                                <td>
                                                    <p><small>الحساب</small></p>
                                                    <strong>{{ $productionMaterial->account->name }}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p><span>إجمالي التكلفة</span></p>
                                                    <h4><strong>{{ $productionMaterial->last_total_cost }} ر.س</strong></h4>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="card">

                            @if(isset($productionMaterial->ProductionMaterialsItem) && !@empty($productionMaterial->ProductionMaterialsItem) && count($productionMaterial->ProductionMaterialsItem) > 0)
                                <div class="card-body">
                                    <p><strong>المواد الخام : </strong></p>
                                    <div class="row">
                                        <table class="table table-striped">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>المنتج</th>
                                                    <th>السعر</th>
                                                    <th>الكمية</th>
                                                    <th>مسار الإنتاج الفرعي</th>
                                                    <th>المجموع</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($productionMaterial->ProductionMaterialsItem as $item)
                                                    <tr>
                                                        <td>{{ $item->rawProduct->name }}</td>
                                                        <td>{{ $item->raw_unit_price }}</td>
                                                        <td>{{ $item->raw_quantity }}</td>
                                                        <td>{{ $item->rawProductionStage->stage_name }}</td>
                                                        <td>{{ $item->raw_total }} ر.س</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif

                            @if(isset($productionMaterial->ProductionMaterialsItem) && !@empty($productionMaterial->ProductionMaterialsItem) && count($productionMaterial->ProductionMaterialsItem) > 0)
                                <div class="card-body">
                                    <p><strong>المصروفات : </strong></p>
                                    <div class="row">
                                        <table class="table table-striped">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>الحساب</th>
                                                    <th>نوع المصروف</th>
                                                    <th>المبلغ</th>
                                                    <th>مسار الإنتاج الفرعي</th>
                                                    <th>الوصف</th>
                                                    <th>المجموع</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($productionMaterial->ProductionMaterialsItem as $item)
                                                    <tr>
                                                        <td>{{ $item->expensesAccount->name }}</td>
                                                        <td>
                                                            @if($item->expenses_cost_type == 1)
                                                            مبلغ ثابت
                                                            @elseif($item->expense_type == 2)
                                                            بناءً على الكمية
                                                            @elseif($item->expense_type == 3)
                                                            معادلة
                                                            @endif
                                                        </td>
                                                        <td>{{ $item->expenses_price }}</td>
                                                        <td>{{ $item->expensesProductionStage->stage_name }}</td>
                                                        <td>{{ $item->expenses_description }}</td>
                                                        <td>{{ $item->expenses_total }} ر.س</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif

                            @if(isset($productionMaterial->ProductionMaterialsItem) && !@empty($productionMaterial->ProductionMaterialsItem) && count($productionMaterial->ProductionMaterialsItem) > 0)
                                <div class="card-body">
                                    <p><strong>عمليات التصنيع : </strong></p>
                                    <div class="row">
                                        <table class="table table-striped">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>محطة العمل</th>
                                                    <th>نوع التكلفة</th>
                                                    <th>وقت التشغيل</th>
                                                    <th>مسار الإنتاج الفرعي</th>
                                                    <th>الوصف</th>
                                                    <th>المجموع</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($productionMaterial->ProductionMaterialsItem as $item)
                                                    <tr>
                                                        <td>{{ $item->workStation->name }}</td>
                                                        <td>
                                                            @if($item->manu_cost_type == 1)
                                                            مبلغ ثابت
                                                            @elseif($item->manu_cost_type == 2)
                                                            بناءً على الكمية
                                                            @elseif($item->manu_cost_type == 3)
                                                            معادلة
                                                            @endif
                                                        </td>
                                                        <td>{{ $item->operating_time }}</td>
                                                        <td>{{ $item->workshopProductionStage->stage_name }}</td>
                                                        <td>{{ $item->manu_description }}</td>
                                                        <td>{{ $item->manu_total_cost }} ر.س</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif

                            @if(isset($productionMaterial->ProductionMaterialsItem) && !@empty($productionMaterial->ProductionMaterialsItem) && count($productionMaterial->ProductionMaterialsItem) > 0)
                                <div class="card-body">
                                    <p><strong> المواد الهالكة: </strong></p>
                                    <div class="row">
                                        <table class="table table-striped">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>المنتجات</th>
                                                    <th>السعر</th>
                                                    <th>الكمية</th>
                                                    <th>مسار الإنتاج الفرعي</th>
                                                    <th>المجموع</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($productionMaterial->ProductionMaterialsItem as $item)
                                                    <tr>
                                                        <td>{{ $item->endLifeProduct->name }}</td>
                                                        <td>{{ $item->end_life_unit_price }}</td>
                                                        <td>{{ $item->end_life_quantity }} ر.س</td>
                                                        <td>{{ $item->endLifeProductionStage->stage_name }}</td>
                                                        <td>{{ $item->end_life_total }} ر.س</td>
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
                                                    <strong>{{ optional($productionMaterial->createdByUser)->name }}</strong>
                                                    قام بإضافة قائمة مواد الإنتاج
                                                    <strong>#{{ $productionMaterial->code }}</strong> - <strong>{{ $productionMaterial->name }}</strong>
                                                </p>
                                                <br>
                                                <span>
                                                    <i class="fa fa-clock-o"></i> {{ $productionMaterial->created_at->format('H:i:s') }} -
                                                    <i class="fa fa-user"></i> {{ optional($productionMaterial->createdByUser)->name }}
                                                </span>
                                            </div>
                                        </li>
                                        <hr>

                                        @if($productionMaterial->updated_by)
                                        <li>
                                            <div class="timeline-icon bg-warning">
                                                <i class="feather icon-edit font-medium-2"></i>
                                            </div>
                                            <div class="timeline-info">
                                                <p>
                                                    <strong>{{ optional($productionMaterial->updatedByUser)->name }}</strong>
                                                    قام بتعديل قائمة مواد الإنتاج
                                                    <strong>#{{ $productionMaterial->code }}</strong> - <strong>{{ $productionMaterial->name }}</strong>
                                                </p>
                                                <br>
                                                <span>
                                                    <i class="fa fa-clock-o"></i> {{ $productionMaterial->updated_at->format('H:i:s') }} -
                                                    <i class="fa fa-user"></i> {{ optional($productionMaterial->updatedByUser)->name }}
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
    <div class="modal fade text-left" id="modal_DELETE{{ $productionMaterial->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #EA5455 !important;">
                    <h4 class="modal-title" id="myModalLabel1" style="color: #FFFFFF">حذف {{ $productionMaterial->name }}</h4>
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
                    <a href="{{ route('Bom.delete', $productionMaterial->id) }}" class="btn btn-danger waves-effect waves-light">تأكيد</a>
                </div>
            </div>
        </div>
    </div>
    <!--end delete-->

@endsection
