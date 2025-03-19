@extends('master')

@section('title')
سياسة الاجازة
@stop

@section('content')


    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">سياسة الاجازة</h2>
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

        @include('layouts.alerts.success')
        @include('layouts.alerts.error')

        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="card-title">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>بحث </div>
                            <div>
                                <a href="{{ route('leave_policy.create') }}" class="btn btn-outline-primary">
                                    <i class="fa fa-plus me-2"></i>أضف نوع الاجازة
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form class="form" method="GET" action="#">
                        <div class="form-body row">
                            <div class="form-group col-md-6">
                                <label for="">البحث بواسطة اسم القائمة</label>
                                <input type="text" class="form-control" placeholder="ادخل الإسم او المعرف"name="keywords">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">الحالة</label>
                                <select name="status" class="form-control">
                                    <option value="">الكل</option>
                                    <option value="active">نشط</option>
                                    <option value="inactive">غير نشط</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary mr-1 waves-effect waves-light">بحث</button>
                            <a href="{{ route('leave_policy.index') }}" class="btn btn-outline-danger waves-effect waves-light">الغاء الفلترة</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="table-responsive">
                        @if(isset($leave_policies) && !@empty($leave_policies) && $leave_policies->count() > 0)
                            <table class="table table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">الاسم</th>
                                        <th scope="col">الموظفين</th>
                                        <th scope="col">الحالة</th>
                                        <th scope="col">اجراء</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($leave_policies as $leave_policy)
                                        <tr>
                                            <td>{{ $leave_policy->name }}</td>
                                            <td>{{ $leave_policy->leavePolicyCustomize->employees->full_name??'غير محدد' }}</td>
                                            <td>
                                                @if($leave_policy->status == 0)
                                                    <span class="mr-1 bullet bullet-success bullet-sm"></span><span class="mail-date">نشط</span>
                                                @else
                                                    <span class="mr-1 bullet bullet-danger bullet-sm"></span><span class="mail-date">غير نشط</span>
                                                @endif
                                            </td>
                                            <td style="width: 10%">
                                                <div class="btn-group">
                                                    <div class="dropdown">
                                                        <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1 btn-sm" type="button"id="dropdownMenuButton303" data-toggle="dropdown" aria-haspopup="true"aria-expanded="false"></button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton303">
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('leave_policy.show', $leave_policy->id) }}">
                                                                    <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('leave_policy.edit', $leave_policy->id) }}">
                                                                    <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                                </a>
                                                            </li>

                                                            <li>
                                                                <a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#modal_DELETE{{ $leave_policy->id }}">
                                                                    <i class="fa fa-trash me-2"></i>حذف
                                                                </a>
                                                            </li>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Modal delete -->
                                            <div class="modal fade text-left" id="modal_DELETE{{ $leave_policy->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header" style="background-color: #EA5455 !important;">
                                                            <h4 class="modal-title" id="myModalLabel1" style="color: #FFFFFF">حذف {{ $leave_policy->name }}</h4>
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
                                                            <a href="{{ route('leave_policy.delete',$leave_policy->id) }}" class="btn btn-danger waves-effect waves-light">تأكيد</a>
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
                                    لا توجد سياسات إجازة مضافة حتى الان !!
                                </p>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection
