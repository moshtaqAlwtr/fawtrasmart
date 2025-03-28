@extends('master')

@section('title', 'الماكينات')

@section('content')
    <!-- Header Section -->
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">الماكينات</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">الرئيسية</a></li>
                            <li class="breadcrumb-item active">إضافة</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.alerts.success')
    @include('layouts.alerts.error')
    <div class="card">
        <div class="card-body">
            <!-- السطر الأول: زر أضف وكلمة بحث -->

            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div></div>
                <a href="{{ route('attendance.settings.machines.create') }}" class="btn btn-outline-success">
                    <i class="fa fa-plus me-2"></i> أضف مكينة
                </a>
            </div>


            <form id="search-form" action="{{ route('attendance.settings.machines.index') }}" method="GET">
                <div class="row">
                    <div class="col-6">
                        <label for="search" class="form-label">البحث بأسم المكينه</label>
                        <input type="text" class="form-control" id="search" name="search"
                               placeholder="البحث باسم المكينة أو الرقم التسلسلي" value="{{ request('search') }}">
                    </div>
                    <div class="col-6">
                        <label for="status" class="form-label">جميع الحالات</label>
                        <select name="status" id="status" class="form-control">
                            <option value="">اختر الحالة</option>
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>نشط</option>
                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>غير نشط</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="machine_type" class="form-label">كل الأنواع</label>
                        <input type="text" class="form-control" id="machine_type" name="machine_type"
                               placeholder="كل الأنواع" value="{{ request('machine_type') }}">
                    </div>
                </div>
                <div class="d-flex justify-content-start mt-3">
                    <button type="submit" class="btn btn-primary me-2 waves-effect waves-light">بحث</button>
                    <a href="{{ route('attendance.settings.machines.index') }}" class="btn btn-outline-warning waves-effect waves-light">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
    @if (@isset($machines) && !@empty($machines) && count($machines) > 0)
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>اسم الماكينة</th>
                        <th>النوع</th>
                        <th>المضيف</th>
                        <th>المنفذ</th>
                        <th>الحالة</th>
                        <th style="width: 10%">الإجراءات</th>
                    </tr>
                </thead>

                @foreach ($machines as $machine)
                    <tbody>
                        <tr>
                            <td>{{ $machine->name }}</td>
                            <td>{{ $machine->machine_type }}</td>
                            <td>{{ $machine->host_name }}</td>
                            <td>{{ $machine->port_number }}</td>
                            <td>
                                @if ($machine->status == 1)
                                    <div class="badge badge-pill badge badge-success">نشط</div>
                                @else
                                    <div class="badge badge-pill badge badge-danger">غير نشط</div>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <div class="dropdown">
                                        <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1 btn-sm"
                                            type="button"id="dropdownMenuButton{{ $machine->id }}" data-toggle="dropdown"
                                            aria-haspopup="true"aria-expanded="false"></button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $machine->id }}">
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('attendance.settings.machines.show', $machine->id) }}">
                                                    <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('attendance.settings.machines.edit', $machine->id) }}">
                                                    <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                </a>
                                            </li>

                                            <li>
                                                <a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#modal_DELETE{{ $machine->id }}">
                                                    <i class="fa fa-trash me-2"></i>حذف
                                                </a>
                                            </li>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <!-- Modal delete -->
                            <div class="modal fade text-left" id="modal_DELETE{{ $machine->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color: #EA5455 !important;">
                                            <h4 class="modal-title" id="myModalLabel1" style="color: #FFFFFF">حذف {{ $machine->name }}</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true" style="color: #DC3545">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <strong>
                                                هل انت متاكد من انك تريد حذف هذه الماكينة؟
                                            </strong>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light waves-effect waves-light" data-dismiss="modal">الغاء</button>
                                            <form action="{{ route('attendance.settings.machines.destroy', $machine->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger waves-effect waves-light">تأكيد</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end delete-->
                        </tr>
                    </tbody>
                @endforeach
            </table>
        </div>
    </div>
@else
    <div class="alert alert-danger text-xl-center" role="alert">
        <p class="mb-0">
            لا توجد ماكينات مضافة حتى الآن !!
        </p>
    </div>
@endif

{{ $machines->links('pagination::bootstrap-5') }}

@endsection
