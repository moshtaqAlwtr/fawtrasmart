@extends('master')

@section('title')
   عرض الخدمة
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">عرض الخدمة</h2>
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
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="avatar avatar-md bg-light-primary">
                        <span class="avatar-content fs-4">ت</span>
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center gap-2">
                                <h5 class="mb-0 fw-bolder">عرض الخدمة</h5>
                                <small class="text-muted">#1</small>
                            </div>
                            <div class="vr mx-2"></div>
                            <div class="d-flex align-items-center">
                                <small class="text-success">
                                    <i class="fa fa-circle me-1" style="font-size: 8px;"></i>
                                  
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
                       <!-- Example single danger button -->

                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <form action="{{ route('reservations.updateStatus', $booking->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                    <div class="btn-group">
                        <button type="button" class="btn btn-danger dropdown-toggle" id="statusButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            الحالة
                        </button>
                        <div class="dropdown-menu">
                            <button type="submit" name="status" value="confirm" class="dropdown-item">تأكيد</button>
                            <button type="submit" name="status" value="review" class="dropdown-item">تحت المراجعة</button>
                            <button type="submit" name="status" value="bill" class="dropdown-item">حولت لفاتورة</button>
                            <button type="submit" name="status" value="cancel" class="dropdown-item">تم الإلغاء</button>
                            <button type="submit" name="status" value="done" class="dropdown-item">تم</button>
                        </div>
                    </div>
                    
                   
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="card">

        <div class="card-body">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#details" role="tab">
                        <span>التفاصيل</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#activity" role="tab">
                        <span>سجل النشاطات</span>
                    </a>
                </li>
            </ul>

            <div class="tab-content p-3">
                <!-- تبويب التفاصيل -->
                <div class="tab-pane active" id="details" role="tabpanel">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="d-flex align-items-center gap-3 mb-4">
                                                <div class="avatar avatar-md bg-secondary"
                                                    style="width: 42px; height: 42px;">
                                                    <span class="avatar-content" style="font-size: 1rem;">م</span>
                                                </div>
                                                <div>
                                                    <h4 class="mb-0" style="font-size: 1.1rem;">{{$booking->client->first_name ?? ""}}<span
                                                            class="text-muted" style="font-size: 0.9rem;"></span></h4>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 mb-4">
                                                    <h6 class="text-muted mb-2">تاريخ العملية التجارية</h6>
                                                    <p class="h5">{{$booking->appointment_date ?? ""}}</p>
                                                </div>
                                                <div class="col-md-4 mb-4">
                                                    <h6 class="text-muted mb-2">الخدمة</h6>
                                                    <p class="h5">
                                                        <a href="#" class="text-primary">{{$booking->product->name ?? ""}}</a>
                                                     
                                                        
                                                    </p>
                                                </div>
                                                <div class="col-md-4 mb-4">
                                                    <h6 class="text-muted mb-2">اجمالي الوقت</h6>
                                                    <p class="h5">
                                                        @php
                                                        use Carbon\Carbon;
                                                    
                                                        $startTime = $booking->start_time ? Carbon::parse($booking->start_time) : null;
                                                        $endTime = $booking->end_time ? Carbon::parse($booking->end_time) : null;
                                                    
                                                        $minutesDifference = ($startTime && $endTime) ? $endTime->diffInMinutes($startTime) : 0;
                                                    @endphp
                                                    
                                                    <p>وقت البدء: {{ $booking->start_time ?? "غير محدد" }}</p>
                                                    <p>وقت الانتهاء: {{ $booking->end_time ?? "غير محدد" }}</p>
                                                    <p>عدد الدقائق: {{ $minutesDifference }}</p>

                                                    </p>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 mb-4">
                                                    <h6 class="text-muted mb-2">وقت البداية </h6>
                                                    <p class="h5">{{ $booking->start_time ?? "غير محدد" }} </p>
                                                </div>
                                                <div class="col-md-4 mb-4">
                                                    <h6 class="text-muted mb-2">ملاحظات</h6>
                                                    <p class="h5 text-success"></p>
                                                </div>
                                            </div>



            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- تبويب سجل النشاطات -->
                <div class="tab-pane" id="activity" role="tabpanel">
                    <div class="timeline p-4">
                        <!-- يمكن إضافة سجل النشاطات هنا -->
                        <p class="text-muted text-center"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
$(document).ready(function() {
    $(".status-option").click(function(event) {
        event.preventDefault();

        var statusValue = $(this).data("value");  // الحصول على القيمة الجديدة للحالة
        var statusText = $(this).text();  // الحصول على نص الحالة لعرضه في الزر
        var reservationId = $("#reservationId").val();  // جلب ID الحجز

        $("#statusButton").text(statusText);  // تغيير نص الزر
        $("#statusInput").val(statusValue);  // تحديث القيمة المخفية

        // إرسال الحالة إلى الخادم عبر Ajax
        $.ajax({
            url: "/reservations/update-status/" + reservationId,
            type: "PUT",
            data: {
                status: statusValue,
                _token: "{{ csrf_token() }}"  // تأمين الطلب بـ CSRF Token
            },
            success: function(response) {
                alert("تم تحديث الحالة بنجاح!");
            },
            error: function(xhr, status, error) {
                alert("حدث خطأ أثناء التحديث، حاول مرة أخرى.");
            }
        });
    });
});
</script>