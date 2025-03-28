@extends('master')

@section('title')
محطات العمل
@stop

@section('content')

    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">محطات العمل</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a></li>
                            <li class="breadcrumb-item active">عرض</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.alerts.success')
    @include('layouts.alerts.error')

    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <div class="card-title">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>بحث</div>
                        <div>
                            <a href="{{ route(name: 'manufacturing.workstations.create') }}" class="btn btn-outline-success waves-effect waves-light">
                                <i class="fa fa-plus me-2"></i>أضف محطة العمل
                            </a>
                        </div>
                    </div>
                </div>

                <form method="GET" action="">
                    <div class="row mb-3 mt-3">
                        <div class="col">
                            <input type="text" name="search" class="form-control" placeholder="البحث بواسطة الاسم أو الكود">
                        </div>

                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">بحث</button>
                            <a href="" class="btn btn-secondary waves-effect waves-light">إعادة تعيين</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            @if(isset($workstations) && !@empty($workstations) && $workstations->count() > 0)
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>الاسم</th>
                            <th>الوصف</th>
                            <th>التكلفة الاجمالية</th>
                            <th style="width: 10%">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($workstations as $workstation)
                            <tr>
                                <td>
                                    <div>{{ $workstation->name }}</div>
                                    <small class="text-muted">#{{ $workstation->code }}</small>
                                </td>
                                <td>{{ $workstation->description }}</td>
                                <td>{{ $workstation->total_cost }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <div class="dropdown">
                                            <button class="btn btn-sm bg-gradient-info fa fa-ellipsis-v" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('manufacturing.workstations.show', $workstation->id) }}">
                                                        <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('manufacturing.workstations.edit', $workstation->id) }}">
                                                        <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#modal_DELETE{{ $workstation->id }}">
                                                        <i class="fa fa-trash me-2"></i>حذف
                                                    </a>
                                                </li>
                                            </div>
                                        </div>
                                    </div>
                                </td>

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
                                                <a href="{{ route('manufacturing.workstations.delete', $workstation->id) }}" class="btn btn-danger waves-effect waves-light">تأكيد</a>
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
                        لا توجد محطات عمل مضافة حتى الان !!
                    </p>
                </div>
            @endif
        </div>
    </div>

@endsection
