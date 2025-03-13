@extends('master')

@section('title')
خزائن وحسابات بنكية
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">خزائن وحسابات بنكية</h2>
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
    <div class="card">
        <div class="card-title p-2">

            <a href="{{ route('treasury.transferin') }}" class="btn btn-outline-success btn-sm">تحويل <i class="fa fa-reply-all"></i></a>


        </div>
    <div class="content-body">

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <strong>@if($treasury->type_accont == 0) <i class="fa fa-archive"></i> @else <i class="fa fa-bank"></i> @endif {{ $treasury->name }}</strong>
                    </div>

                    <div>
                        @if ($treasury->is_active == 0)
                            <div class="badge badge-pill badge badge-success">نشط</div>
                        @else
                            <div class="badge badge-pill badge badge-danger">غير نشط</div>
                        @endif
                    </div>

                    <div>
                        <small>SAR </small> <strong>0.00</strong>
                    </div>

                </div>
            </div>
        </div>

        @include('layouts.alerts.error')
        @include('layouts.alerts.success')

        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" aria-controls="home" role="tab" aria-selected="false">التفاصيل</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="activate-tab" data-toggle="tab" href="#activate" aria-controls="about" role="tab" aria-selected="true">سجل النشاطات</a>
                    </li>

                </ul>
                <div class="tab-content">

                    <div class="tab-pane active" id="home" aria-labelledby="home-tab" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <strong>معلومات الحساب</strong>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <table class="table">
                                        <tr>
                                            <td><small>الاسم</small> : <strong>{{ $treasury->name }}</strong></td>
                                            @if($treasury->type_accont == 1)
                                                <td><small>اسم الحساب البنكي</small> : <strong>{{ $treasury->name }}</strong></td>
                                                {{-- <td><small>رقم الحساب</small> : <strong>{{ $treasury->account_number }}</strong></td> --}}
                                            @endif
                                        </tr>
                                        <tr>
                                            <td><small>النوع</small> : <strong>@if($treasury->type_accont == 0) خزينة @else حساب بنكي @endif</strong></td>
                                            <td><small>الحاله</small> : <span> @if ($treasury->is_active == 0)
                                                <div class="badge badge-pill badge badge-success">نشط</div>
                                                    @else
                                                        <div class="badge badge-pill badge badge-danger">غير نشط</div>
                                                    @endif
                                                </span>
                                            </td>
                                            <td><small>المبلغ</small> : <strong style="color: #00CFE8">{{  $treasury->balance }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%"><strong>الوصف</strong> : <small>{{ $treasury->description ?? ""}}</small></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <strong>الصلاحيات</strong>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ايداع</th>
                                                <th>سحب</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    @if($treasury->deposit_permissions !== 0)
                                                        @if ($treasury->deposit_permissions == 1)
                                                        <!---employee_id--->
                                                        {{ App\Models\Employee::find($treasury->value_of_deposit_permissions)->full_name?? " " }}
                                                        @elseif ($treasury->deposit_permissions == 2)
                                                        <!---functional_role_id--->
                                                            {{ $treasury->value_of_deposit_permissions }}
                                                        @else
                                                        <!---branch_id--->
                                                            {{ $treasury->value_of_deposit_permissions }}
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($treasury->withdraw_permissions !== 0)
                                                        @if ($treasury->withdraw_permissions == 1)
                                                        <!---employee_id--->
                                                        {{ App\Models\Employee::find($treasury->value_of_deposit_permissions)->full_name ??"" }}
                                                        @elseif ($treasury->withdraw_permissions == 2)
                                                        <!---functional_role_id--->
                                                            {{ $treasury->value_of_withdraw_permissions }}
                                                        @else
                                                        <!---branch_id--->
                                                            {{ $treasury->value_of_withdraw_permissions }}
                                                        @endif
                                                    @endif
                                                </td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane" id="activate" aria-labelledby="activate-tab" role="tabpanel">
                        <p>activate records</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection


@section('scripts')



@endsection
