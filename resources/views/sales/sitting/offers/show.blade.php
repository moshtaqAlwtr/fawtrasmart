@extends('master')

@section('title')
    عرض العرض
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">{{ $offer->title }}</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a></li>
                            <li class="breadcrumb-item active">عرض</li>
                            <li class="breadcrumb-item active">
                                @if ($offer->status == 1)
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
            <a href="#" class="btn btn-outline-danger btn-sm waves-effect waves-light" data-toggle="modal"
                data-target="#modal_DELETE1">حذف <i class="fa fa-trash"></i></a>
            <a href="{{ route('Offers.edit', $offer->id) }}"
                class="btn btn-outline-primary btn-sm waves-effect waves-light">تعديل <i class="fa fa-edit"></i></a>

        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details" role="tab"
                        aria-controls="details" aria-selected="true">تفاصيل العرض</a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" id="activity-log-tab" data-toggle="tab" href="#activity-log" role="tab"
                        aria-controls="activity-log" aria-selected="false">سجل النشاطات</a>
                </li>
            </ul>

            <div class="tab-content">
                <!-- تفاصيل العرض -->
                <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                    <div class="tab-content">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <table class="table">
                                        <thead style="background: #f8f8f8">
                                            <tr>
                                                <th colspan="4">معلومات العرض</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><small>الاسم</small></td>
                                                <td>{{ $offer->name }}</td>
                                                <td><small>النوع</small></td>
                                                <td>{{ $offer->type }}</td>
                                            </tr>
                                            <tr>
                                                <td><small>صالح من</small></td>
                                                <td>{{ $offer->valid_from }}</td>
                                                <td><small>صالح حتى</small></td>
                                                <td>{{ $offer->valid_to }}</td>
                                            </tr>
                                            <tr>
                                                <td><small>نوع الخصم</small></td>
                                                <td>{{ $offer->discount_type }}</td>
                                                <td><small>نسبة الخصم</small></td>
                                                <td>{{ $offer->discount_percentage }}%</td>
                                            </tr>
                                            <tr>
                                                <td><small>النقطة المستهدفة لتطبيق العرض</small></td>
                                                <td>{{ $offer->target_points }}</td>
                                                <td><small>الحالة</small></td>
                                                <td>
                                                    @if ($offer->status == 1)
                                                        <div class="badge badge-pill badge badge-success">نشط</div>
                                                    @else
                                                        <div class="badge badge-pill badge badge-danger">غير نشط</div>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <table class="table mt-3">
                                        <thead style="background: #f8f8f8">
                                            <tr>
                                                <th colspan="2">تفاصيل البند العرض</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><small>نوع الوحدة</small></td>
                                                <td>
                                                    @if ($offer->unit_type == 1)
                                                        الكل
                                                    @elseif($offer->unit_type == 2)
                                                        المنتجات
                                                    @else
                                                        التصنيفات
                                                    @endif
                                                </td>
                                            </tr>

                                            @if ($offer->unit_type == 2) <!-- إذا كان نوع الوحدة هو "المنتجات" -->
                                                <tr>
                                                    <td><small>البنود</small></td>
                                                    <td>{{ $offer->product_id }}</td>
                                                </tr>
                                            @endif

                                            @if ($offer->unit_type == 3) <!-- إذا كان نوع الوحدة هو "التصنيفات" -->
                                                <tr>
                                                    <td><small>البنود</small></td>
                                                    <td>{{ $offer->category_id }}</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- المنتجات -->


            </div>
        </div>
    </div>
@endsection
