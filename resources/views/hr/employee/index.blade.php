@extends('master')

@section('title')
    أدارة الموظفين
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">أدارة الموظفين</h2>
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
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div></div>
                    <div>
                        <a href="{{ route('employee.export_view') }}" class="btn btn-outline-info waves-effect waves-light">
                            <i class="fa fa-share-square me-2"></i>  تصدير
                        </a>
                        <a href="{{ route('employee.create') }}" class="btn btn-outline-primary waves-effect waves-light">
                            <i class="fa fa-plus me-2"></i> اضافة موظف جديد
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <form class="form" method="GET" action="#">
                        <div class="form-body row">
                            <div class="form-group col-md-3">
                                <select name="employee" class="form-control">
                                    <option value="">البحث بواسطة اسم الموظف أو الرقم التعريفي</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->trans_name }} {{ $client->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <input type="text" class="form-control" placeholder="أختر الحالة" name="status">
                            </div>

                            <div class="form-group col-md-3">
                                <select name="type" class="form-control">
                                    <option value="">أختر النوع</option>
                                    <option value="1">مستخدم</option>
                                    <option value="0">موظف</option>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <select name="role" class="form-control">
                                    <option value="">أختر الدور الوظيفي</option>
                                    <option value="1">مدير</option>
                                    <option value="0">موظف</option>
                                </select>
                            </div>
                        </div>
                        <!-- Hidden Div -->
                        <div class="collapse" id="advancedSearchForm" style="">
                            <div class="form-body row">
                                <div class="form-group col-md-3">
                                    <select name="job_type" class="form-control">
                                        <option value="">أختر نوع الوظيفة</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <select name="level" class="form-control">
                                        <option value="">أختر المستوى الوظيفي</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <select name="department" class="form-control">
                                        <option value="">أختر القسم</option>
                                        <option value="1">الكل</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <select name="manager" class="form-control">
                                        <option value="">البحث بواسطة المدير المباشر</option>
                                        <option value="1">الكل</option>
                                        <option value="0">محمد</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <select name="position" class="form-control">
                                        <option value="">أختر المسمى الوظيفي</option>
                                        <option value="1">الكل</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <select name="attendance_status" class="form-control">
                                        <option value="">أختر قيد الحضور</option>
                                        <option value="1">الكل</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <select name="citizenship_status" class="form-control">
                                        <option value="">أختر حالة المواطنة</option>
                                        <option value="1">الكل</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <select name="nationality" class="form-control">
                                        <option value="">أختر الجنسية</option>
                                        <option value="1">الكل</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="from_date">إنهاء الإقامة (من)</label>
                                    <input type="date" id="from_date" class="form-control" name="from_date">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="to_date">إنهاء الإقامة (إلى)</label>
                                    <input type="date" id="to_date" class="form-control" name="to_date">
                                </div>
                            </div>

                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary mr-1 waves-effect waves-light">بحث</button>

                            <a class="btn btn-outline-secondary ml-2 mr-2 waves-effect waves-light collapsed" data-toggle="collapse" data-target="#advancedSearchForm" aria-expanded="false">
                                <i class="bi bi-sliders"></i> بحث متقدم
                            </a>
                            <a href="#" class="btn btn-outline-danger waves-effect waves-light">الغاء الفلترة</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-body">
                    @if (@isset($employees) && !@empty($employees) && count($employees) > 0)
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <td>الاسم</td>
                                    <td>الدور الوظيفي</td>
                                    <td>المسمى الوظيفي</td>
                                    <td>قسم</td>
                                    <td>فرع</td>
                                    <th>الحاله</th>
                                    <th style="width: 10%">اجراء</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $employee)
                                    <tr>
                                        <td>
                                            <p><strong>{{ $employee->full_name }}</strong></p>
                                            <small>#{{ $employee->id }}</small>
                                        </td>
                                        <td>
                                            <p><strong>{{ optional($employee->job_role->role_name)->role_name ?? 'غير محدد' }}</strong></p>
                                            <small>@if ($employee->employee_type == 1) موظف @else مستخدم @endif</small>
                                        </td>
                                        <td>{{ optional($employee->job_title)->name ?? 'غير محدد' }}</td>
                                        <td>{{ optional($employee->department)->name ?? 'غير محدد' }}</td>
                                        <td>{{ optional($employee->branch)->name ?? 'غير محدد' }}</td>
                                        <td>
                                            @if ($employee->status == 1)
                                                <span class="badge badge-pill badge badge-success">نشط</span>
                                            @else
                                                <span class="badge badge-pill badge badge-danger">غير نشط</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <div class="dropdown">
                                                    <button class="btn btn-sm bg-gradient-info fa fa-ellipsis-v mr-1 mb-1" type="button"id="dropdownMenuButton303" data-toggle="dropdown" aria-haspopup="true"aria-expanded="false"></button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton303">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('employee.show',$employee->id) }}">
                                                                <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ChangePassword">
                                                                <i class="fa fa-lock me-2 text-info"></i>تغيير كلمة المرور
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('employee.edit',$employee->id) }}">
                                                                <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#modal_DELETE{{ $employee->id }}">
                                                                <i class="fa fa-trash me-2"></i>حذف
                                                            </a>
                                                            <li>    
                                                                <a class="dropdown-item text-primary" href="{{ route('employee.send_email',$employee->id) }}">
                                                                    <i class="fa fa-paper-plane me-2"></i> ارسال بيانات الدخول بالبريد
                                                                </a>
                                                                
                                                        </li>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Modal delete -->
                                        <div class="modal fade text-left" id="modal_DELETE{{ $employee->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="background-color: #EA5455 !important;">
                                                        <h4 class="modal-title" id="myModalLabel1" style="color: #FFFFFF">حذف {{ $employee->full_name }}</h4>
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
                                                        <a href="{{ route('employee.delete',$employee->id) }}" class="btn btn-danger waves-effect waves-light">تأكيد</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end delete-->

                                        <!-- Modal change passwoard -->
                                        <div class="modal fade text-left" id="ChangePassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myModalLabel1">تغير  كلمة المرور</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="form" action="{{ route('employee.updatePassword',$employee->id) }}" method="POST">
                                                            @csrf
                                                            <div class="form-body">
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="form-label-group">
                                                                            <input type="password" class="form-control" placeholder="كلمة المرور الجديدة" name="password" value="{{ old('password') }}">
                                                                            <label for="password">كلمة المرور الجديدة</label>
                                                                            @error('password')
                                                                            <span class="text-danger" class="error">
                                                                                {{ $message }}
                                                                            </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-12">
                                                                        <div class="form-label-group">
                                                                            <input type="password" class="form-control" placeholder="تأكيد كلمة المرور" name="password_confirmation" value="{{ old('password_confirmation') }}">
                                                                            <label for="password_confirmation">تأكيد كلمة المرور</label>
                                                                            @error('password_confirmation')
                                                                            <span class="text-danger" class="error">
                                                                                {{ $message }}
                                                                            </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-outline-primary btn-sm round mr-1 mb-1 waves-effect waves-light">حفظ</button>
                                                            <button type="reset" class="btn btn-outline-warning btn-sm round mr-1 mb-1 waves-effect waves-light">تفريغ</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end Model change passwoard-->

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- {{ $employees->links('pagination::bootstrap-5') }} --}}
                    @else
                        <div class="alert alert-danger text-xl-center" role="alert">
                            <p class="mb-0">
                                لا يوجد موظفين حتى الان
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

@endsection
