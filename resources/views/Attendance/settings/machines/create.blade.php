@extends('master')

@section('title', 'إضافة ماكينة')

@section('content')
    <!-- Header Section -->
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">إضافة ماكينة</h2>
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

    <form id="addLeaveTypeForm" method="POST" action="{{ route('attendance.settings.machines.store') }}">
        @csrf

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <!-- Form Actions -->
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                    </div>
                    <div>
                        <a href="{{ route('leave_types.index') }}" class="btn btn-outline-danger">
                            <i class="fa fa-ban"></i> إلغاء
                        </a>
                        <button type="submit" form="addLeaveTypeForm" class="btn btn-outline-primary">
                            <i class="fa fa-save"></i> حفظ
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="card">
            <div class="card-body">
                <h4 class="mb-4">معلومات نوع الإجازات</h4>

                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="name" class="form-label">الاسم <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                            required>
                    </div>

                    <div class="col-md-6">
                        <label for="status" class="form-label">الحالة <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="1">نشط</option>
                            <option value="0">غير نشط</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="serial_number" class="form-label">الرقم التسلسلي</label>
                        <input type="text" id="serial_number" name="serial_number" class="form-control"
                            value="{{ old('serial_number') }}">
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="host_name" class="form-label">اسم المضيف <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="host_name" id="host_name"
                            value="{{ old('host_name') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="port_number" class="form-label"> رقم المنفذ</label>
                        <input type="number" class="form-control" name="port_number" id="port_number"
                            value="{{ old('port_number') }}">
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="connection_key" class="form-label">مفتاح الاتصال</label>
                        <input type="text" class="form-control" name="connection_key" id="connection_key"
                            value="{{ old('connection_key') }}">
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="machine_type" class="form-label">نوع الماكينة</label>
                        <input type="text" class="form-control" name="machine_type" id="machine_type"
                            value="{{ old('machine_type') }}">
                    </div>
                </div>

            </div>
        </div>
    </form>
@endsection
