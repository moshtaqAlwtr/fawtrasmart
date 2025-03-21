@extends('master')

@section('title')
المستودعات
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">المستودعات</h2>
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

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <strong>{{ $storehouse->name }} </strong> |
                        @if ($storehouse->status == 0)
                            <div class="badge badge-pill badge badge-success">نشط</div>
                        @elseif ($storehouse->status == 1)
                            <div class="badge badge-pill badge badge-danger">غير نشط</div>
                        @else
                            <div class="badge badge-pill badge badge-warning">متوقف</div>
                        @endif
                    </div>

                    <div>
                        <a href="{{ route('storehouse.edit',$storehouse->id) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fa fa-edit"></i>تعديل
                        </a>
                        <a href="" class="btn btn-outline-danger btn-sm">
                            <i class="fa fa-trash"></i>حذف
                        </a>
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
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" aria-controls="home" role="tab" aria-selected="false">معلومات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="activate-tab" data-toggle="tab" href="#activate" aria-controls="about" role="tab" aria-selected="true">سجل النشاطات</a>
                    </li>

                </ul>
                <div class="tab-content">

                    <div class="tab-pane active" id="home" aria-labelledby="home-tab" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <strong>معلومات</strong>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th><small>الاسم</small></th>
                                                <th><small>عنوان الشحن</small></th>
                                                <th><small>الحاله</small></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    {{ $storehouse->name }}
                                                </td>
                                                <td>
                                                    {{ $storehouse->shipping_address }}
                                                </td>
                                                <td>
                                                    @if ($storehouse->status == 0)
                                                        <div class="badge badge-pill badge badge-success">نشط</div>
                                                    @elseif ($storehouse->status == 1)
                                                        <div class="badge badge-pill badge badge-danger">غير نشط</div>
                                                    @else
                                                        <div class="badge badge-pill badge badge-warning">متوقف</div>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
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
                                                <th><small>عرض</small></th>
                                                <th><small>انشاء فاتورة</small></th>
                                                <th><small>تعديل المخازن</small></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    @if($storehouse->view_permissions !== 0)
                                                        @if ($storehouse->view_permissions == 1)
                                                        <!---employee_id--->
                                                        {{ App\Models\Employee::find($storehouse->value_of_view_permissions)->full_name }}
                                                        @elseif ($storehouse->view_permissions == 2)
                                                        <!---functional_role_id--->
                                                            {{ $storehouse->value_of_view_permissions }} functional_role_id
                                                        @else
                                                        <!---branch_id--->
                                                            {{ $storehouse->value_of_view_permissions }} branch_id
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($storehouse->crate_invoices_permissions !== 0)
                                                        @if ($storehouse->crate_invoices_permissions == 1)
                                                        <!---employee_id--->
                                                            {{ $storehouse->value_of_crate_invoices_permissions }} employee_id
                                                        @elseif ($storehouse->crate_invoices_permissions == 2)
                                                        <!---functional_role_id--->
                                                            {{ $storehouse->value_of_crate_invoices_permissions }} functional_role_id
                                                        @else
                                                        <!---branch_id--->
                                                            {{ $storehouse->value_of_crate_invoices_permissions }} branch_id
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($storehouse->edit_stock_permissions !== 0)
                                                        @if ($storehouse->edit_stock_permissions == 1)
                                                        <!---employee_id--->
                                                            {{ $storehouse->value_of_edit_stock_permissions }}
                                                        @elseif ($storehouse->edit_stock_permissions == 2)
                                                        <!---functional_role_id--->
                                                            {{ $storehouse->value_of_edit_stock_permissions }} functional_role_id
                                                        @else
                                                        <!---branch_id--->
                                                            {{ $storehouse->value_of_edit_stock_permissions }} branch_id
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
