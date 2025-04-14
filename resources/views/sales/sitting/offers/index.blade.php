@extends('master')

@section('title')
    العروض
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0"> العروض </h2>
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
    @include('layouts.alerts.error')
    @include('layouts.alerts.success')


    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div></div>
                    <div>
                        <a href="{{ route('Offers.create') }}" class="btn btn-outline-primary">
                            <i class="fa fa-plus me-2"></i> اضافة عرض
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            @if (@isset($offers) && !@empty($offers) && count($offers) > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>الرقم التعريفي </th>
                            <th>الاسم </th>
                            <th>الحالة </th>
                            <th style="width: 10%">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($offers as $offer)
                            <tr>
                                <td>{{ $offer->id }}</td>
                                <td>{{ $offer->name }}</td>
                                <td>
                                    @if ($offer->status == 1)  <!-- Changed $title to $offer -->
                                        <div class="badge badge-pill badge badge-success">نشط</div>
                                    @else
                                        <div class="badge badge-pill badge badge-danger">غير نشط</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <div class="dropdown">
                                            <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1 btn-sm"
                                                type="button" id="dropdownMenuButton303" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false"></button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton303">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('Offers.show', $offer->id) }}">
                                                        <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('Offers.edit', $offer->id) }}">
                                                        <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-danger" href="{{ route('Offers.destroy', $offer->id) }}" data-toggle="modal"
                                                        data-target="#modal_DELETE{{ $offer->id }}">
                                                        <i class="fa fa-trash me-2"></i>حذف
                                                    </a>
                                                </li>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Modal delete -->
                                <div class="modal fade text-left" id="modal_DELETE{{ $offer->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: #EA5455 !important;">
                                                <h4 class="modal-title" id="myModalLabel1" style="color: #FFFFFF">حذف
                                                    {{ $offer->name }}</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true" style="color: #DC3545">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <strong>
                                                    هل انت متاكد من انك تريد الحذف ؟
                                                </strong>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light waves-effect waves-light"
                                                    data-dismiss="modal">الغاء</button>
                                                <a href="{{ route('Offers.destroy', $offer->id) }}"
                                                    class="btn btn-danger waves-effect waves-light">تأكيد</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end delete-->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-danger text-xl-center" role="alert">
                    <p class="mb-0">
                        لا توجد عروض مضافة حتى الان !!
                    </p>
                </div>
            @endif

        </div>
    </div>

@endsection
