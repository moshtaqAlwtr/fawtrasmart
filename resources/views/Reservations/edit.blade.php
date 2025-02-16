@extends('master')

@section('title')
    تعديل حجز
@stop

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">تعديل حجز</h2>
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

<div class="container mt-5">
    <div class="card">
        <form action="{{ route('Reservations.update', $booking->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                    </div>
                    <div>
                        <a href="{{ route('Reservations.index') }}" class="btn btn-outline-danger">
                            <i class="fa fa-ban"></i> الغاء
                        </a>
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="fa fa-save"></i> حفظ التعديلات
                        </button>
                    </div>
                </div>
            </div>
       
    </div>

    <!-- Form Card -->
    <div class="card">
        <div class="card-body">
         
                <!-- Booking Slots Division -->
                <div class="mb-3">
                    <label for="serviceSelect" class="form-label">اختر خدمة</label>
                    <select id="serviceSelect" class="form-select" name="product_id">
                        <option value="">اختر خدمة</option>
                        @foreach ($Products as $Product)
                            <option value="{{ $Product->id }}" {{ $booking->product_id == $Product->id ? 'selected' : '' }}>{{ $Product->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Employee Selection -->
                <div class="mb-3">
                    <label for="employeeSelect" class="form-label">اختر موظف</label>
                    <select id="employeeSelect" class="form-select" name="employee_id">
                        @foreach ($Employees as $Employee)
                            <option value="{{ $Employee->id }}" {{ $booking->employee_id == $Employee->id ? 'selected' : '' }}>{{ $Employee->first_name ?? "" }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Date and Time Selection -->
                <div class="mb-3">
                    <label for="dateSelect" class="form-label">اختر التاريخ</label>
                    <input type="date" id="dateSelect" class="form-control" name="appointment_date" value="{{ $booking->appointment_date }}">
                </div>

                <div class="mb-3">
                    <label for="startTime" class="form-label">وقت البدء</label>
                    <input type="time" id="startTime" class="form-control" name="start_time" value="{{ $booking->start_time }}">
                </div>

                <div class="mb-3">
                    <label for="endTime" class="form-label">وقت الانتهاء</label>
                    <input type="time" id="endTime" class="form-control" name="end_time" value="{{ $booking->end_time }}">
                </div>

                <!-- Client Selection -->
                <div class="mb-3">
                    <label for="clientSelect" class="form-label">اختر عميل</label>
                    <select id="clientSelect" class="form-select" name="client_id">
                        @foreach ($Clients as $Client)
                            <option value="{{ $Client->id }}" {{ $booking->client_id == $Client->id ? 'selected' : '' }}>{{ $Client->first_name ?? "" }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection