@extends('master')

@section('title')
    أدارة الحجوزات
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">أدارة الحجوزات</h2>
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
                <div class="d-flex justify-content-between align-items-rtl flex-wrap">
                    <div></div>

                  
                 
                    <div>
                                <a href="{{ route('Reservations.create') }}" class="btn btn-outline-success">
                                    <i class="fa fa-plus me-2"></i>أضف حجز 
                                </a>

                                <a href="{{ route('appointments.index') }}"  class="btn btn-outline-primary">
                                    <i class="fa fa-calendar-alt me-2"></i>المواعيد المحجوزة
                                    </a>
                            </div>
                </div>
            </div>
        </div>
        <div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">نموذج البحث</h5>
    </div>
    <div class="card-body">
        <form id="clientForm" action="{{ route('Reservations.filter') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-4">
                <!-- الموظف -->
                <div class="col-md-4">
                    <label for="employee-search" class="form-label">رقم:</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="employee-search" 
                        name="employee" 
                        placeholder="البحث بالرقم">
                </div>
                <div class="col-md-4">
                    <label for="employee-search" class="form-label">العميل:</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="employee-search" 
                        name="client_id" 
                        placeholder="البحث باسم العميل ">
                </div>
                <div class="col-md-4">
                    <label for="employee-search" class="form-label">الموظف:</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="employee-search" 
                        name="employee" 
                        placeholder="البحث باسم الموظف ">
                </div>

                <!-- الفترة من -->
                <div class="col-md-4">
                    <label for="date_from" class="form-label">الفترة من:</label>
                    <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" class="form-control">
                </div>

                <!-- الفترة إلى -->
                <div class="col-md-4">
                    <label for="date_to" class="form-label">الفترة إلى:</label>
                    <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="group_by" class="form-label">الحالة  :</label>
                    <select class="form-control" id="group_by" name="status">
                        <option>أختر</option>
                        <option value="confirm">تأكيد</option>
                        <option value="review">تحت المراجعة</option>
                        <option value="bill">حولت لفاتورة</option>
                        <option value="cancel">تم الالغاء</option>
                        <option value="done">تم </option>
                    </select>
                </div>
            </div>
            <div class="d-flex justify-content-start mt-3">
                <!-- زر البحث -->
                <button type="submit" class="btn btn-primary me-2 waves-effect waves-light">بحث</button>

                <!-- زر الإلغاء -->
                <button type="reset" class="btn btn-outline-warning waves-effect waves-light">إلغاء</button>
            </div>
        </form>
    </div>
</div>


    <div class="card my-5">
        <div class="card-body">
        <!-- شريط الترتيب -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <ul class="nav nav-tabs" id="sortTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="true">الكل</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="today-tab" data-bs-toggle="tab" data-bs-target="#today" type="button" role="tab" aria-controls="today" aria-selected="false">اليوم</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="week-tab" data-bs-toggle="tab" data-bs-target="#week" type="button" role="tab" aria-controls="week" aria-selected="false">الأسبوع</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="month-tab" data-bs-toggle="tab" data-bs-target="#month" type="button" role="tab" aria-controls="month" aria-selected="false">الشهر</button>
                </li>
            </ul>

            <!-- أزرار العرض -->
            <div class="btn-group" role="group" aria-label="View Toggle">
                <button type="button" class="btn btn-light">
                    <i class="bi bi-grid-3x3-gap-fill"></i> <!-- رمز الشبكة -->
                </button>
                <button type="button" class="btn btn-primary">
                    <i class="bi bi-list-ul"></i> <!-- رمز القائمة -->
                </button>
            </div>
        </div>

        <!-- بطاقة بيانات -->
        <div class="card">
            <div class="card-body">
                @foreach ($bookings as $booking)
                <div class="row">
                    <div class="col-auto">
                        <!-- صورة افتراضية -->
                        <div style="width: 50px; height: 50px; background-color: #f0f0f0; border-radius: 5px;"></div>
                    </div>
                    <div class="col">
                        <h6>بيانات العميل</h6>
                        <p class="mb-1">{{$booking->client->first_name ?? ""}}</p>
                        <p class="mb-1">الخدمة :{{$booking->product->name ?? ""}}</p>
                    </div>
                    <div class="col-auto text-end">
                        <p class="mb-1">الوقت من {{$booking->start_time ?? 0}} الى {{$booking->end_time ?? 0 }}</p>
                        <p class="text-muted small mb-0">16:45:00</p>
                        
                        @if($booking->status == "confirm")
                            <span class="badge bg-warning text-dark">مؤكد</span>
                        @elseif ($booking->status == "review")
                            <span class="badge bg-warning text-dark">تحت المراجعة</span>
                        @elseif ($booking->status == "bill")
                            <span class="badge bg-warning text-dark">حولت للفاتورة</span>
                        @elseif ($booking->status == "cancel")
                            <span class="badge bg-warning text-dark">تم الالغاء</span>  
                        @else
                            <span class="badge bg-warning text-dark">تم</span> 
                        @endif
            
                        <a href="{{ route('Reservations.show', $booking->id) }}" class="badge bg-danger text-dark">عرض</a> 
                        <a href="{{ route('Reservations.edit', $booking->id) }}" class="btn btn-sm btn-primary">
                            <i class="fa fa-edit"></i> تعديل
                        </a>
                    </div>
                </div>
               
                <!-- Horizontal line after each customer's data -->
                <hr>
            @endforeach
            
            </div>
        </div>
    </div>
</div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">




@endsection