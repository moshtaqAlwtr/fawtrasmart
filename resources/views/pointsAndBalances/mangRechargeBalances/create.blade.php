@extends('master')

@section('title')
    اضافة شحن ارصدة
@stop

@section('content')
    <div style="font-size: 1.1rem;">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0"> اضافة شحن ارصدة</h2>
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

        <div class="content-body">
            <form class="form mt-4" style="font-size: 1.1rem;" action="{{ route('MangRechargeBalances.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card mb-5 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
                            <div>
                                <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                            </div>
                            <div>
                                <a href="" class="btn btn-outline-danger">
                                    <i class="fa fa-ban"></i> الغاء
                                </a>
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fa fa-save"></i> حفظ
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm" style="max-width: 90%; margin: 0 auto;">
                    <div class="card-header bg-primary text-white">
                        <h1 class="mb-0">تفاصيل شحن ارصدة</h1>
                    </div>
                    <div class="card-body">
                        <!-- العميل -->
                        <div class="form-group row mb-4">
                            <label for="client_id" class="col-md-3 col-form-label">العميل <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <select name="client_id" class="form-control select2" id="client_id">
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->first_name }} {{ $client->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- نوع الرصيد وقيمة الرصيد -->
                        <div class="form-group row mb-4">
                            <label for="status" class="col-md-3 col-form-label">نوع الرصيد <span class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <select name="status" class="form-control" id="status">
                                    <option value="1">نوع الرصيد</option>
                                    @foreach ($balanceTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <label for="value" class="col-md-3 col-form-label">قيمة الرصيد <span class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <input type="number" name="value" class="form-control" value="0.00" id="value">
                            </div>
                        </div>

                        <!-- تاريخ البدء وتاريخ الانتهاء -->
                        <div class="form-group row mb-4">
                            <label for="start_date" class="col-md-3 col-form-label">تاريخ البدء <span class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <input type="date" name="start_date" class="form-control" id="start_date" value="{{ date('Y-m-d') }}">
                            </div>

                            <label for="end_date" class="col-md-3 col-form-label">تاريخ الانتهاء <span class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <input type="date" name="end_date" class="form-control" id="end_date" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>

                        <!-- الوصف وحالة الإيقاف -->
                        <div class="form-group row mb-4">
                            <label for="description" class="col-md-3 col-form-label">الوصف <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <textarea name="description" class="form-control" id="description" rows="3"></textarea>
                            </div>

                            <div class="col-md-3">
                                <div class="form-check form-switch mt-4">
                                    <input class="form-check-input" type="checkbox" id="duration_checkbox" name="contract_type" value="1">
                                    <label class="form-check-label" for="duration_checkbox">موقوف <span class="text-danger">*</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
