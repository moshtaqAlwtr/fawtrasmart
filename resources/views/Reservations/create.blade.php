@extends('master')

@section('title')
أضف حجز
@stop

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">أضف حجز</h2>
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
    <!-- شريط التقدم -->
    <div class="d-flex justify-content-between mb-4">
        <div class="text-center">
            <div id="step1Circle" class="circle bg-primary text-white d-inline-block p-2 rounded-circle">1</div>
            <span class="d-block">خدمة</span>
        </div>
        <div class="text-center">
            <div id="step2Circle" class="circle bg-secondary text-white d-inline-block p-2 rounded-circle">2</div>
            <span class="d-block">موظف</span>
        </div>
        <div class="text-center">
            <div id="step3Circle" class="circle bg-secondary text-white d-inline-block p-2 rounded-circle">3</div>
            <span class="d-block">التاريخ</span>
        </div>
        <div class="text-center">
            <div id="step4Circle" class="circle bg-secondary text-white d-inline-block p-2 rounded-circle">4</div>
            <span class="d-block">العميل</span>
        </div>
    </div>
    
    <!-- الخطوة 1: اختيار الخدمة -->
    <div id="step1" class="step">
        <div class="row">
            <div class="col-md-8">
                <div class="card p-3">
                    <h5>موعد جديد</h5>
                    <label for="serviceSelect" class="form-label">اختر خدمة</label>
                    <select id="serviceSelect" class="form-select" name="product_id">
                        <option value="">اختر خدمة</option>
                        @foreach ($Products as $Product)
                            <option value="{{$Product->id}}" data-name="{{$Product->name}}">{{$Product->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <h5>تفاصيل الحجز</h5>
                    <p><strong>الخدمات المختارة:</strong> <span id="selectedService">-</span></p> 
                </div>
            </div>
        </div>
        <div class="text-end mt-3">
            <button id="nextButton1" class="btn btn-primary">التالي</button>
        </div>
    </div>

    <!-- الخطوة 2: اختيار الموظف -->
    <div id="step2" class="step" style="display: none;">
        <div class="row">
            <div class="col-md-8">
                <div class="card p-3">
                    <h5>اختر الموظف</h5>
                    <label for="employeeSelect_1" class="form-label">اختر موظف</label>
                    <select id="employeeSelect_1" class="form-select" name="employee_id">
                        @foreach ($Employees as $Employee)
                            <option value="{{$Employee->id}}">{{$Employee->first_name ?? ""}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <h5>تفاصيل الحجز</h5>
                    <p><strong>الخدمات المختارة:</strong> <span id="selectedServiceStep2">-</span></p>
                    <p><strong>الموظف المختار:</strong> <span id="selectedEmployee">-</span></p>
                </div>
            </div>
        </div>
        <div class="text-end mt-3">
            <button id="prevButton2" class="btn btn-secondary">السابق</button>
            <button id="nextButton2" class="btn btn-primary">التالي</button>
        </div>
    </div>

    
    <!-- الخطوة 3: اختيار التاريخ والوقت -->
<div id="step3" class="step" style="display: none;">
    <div class="row">
        <div class="col-md-8">
            <div class="card p-3">
                <h5>اختر التاريخ والوقت</h5>
                <label for="dateSelect" class="form-label">اختر التاريخ</label>
                <input type="date" id="dateSelect" class="form-control" name="appointment_date">

                <label for="startTime" class="form-label mt-3">وقت البدء</label>
                <input type="time" id="startTime" class="form-control" name="start_time">

                <label for="endTime" class="form-label mt-3">وقت الانتهاء</label>
                <input type="time" id="endTime" class="form-control" name="end_time">
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h5>تفاصيل الحجز</h5>
                <p><strong>الخدمات المختارة:</strong> <span id="selectedServiceStep3">-</span></p>
                <p><strong>الموظف المختار:</strong> <span id="selectedEmployeeStep3">-</span></p>
                <p><strong>التاريخ:</strong> <span id="selectedDate">-</span></p>
                <p><strong>الفترة الزمنية:</strong> <span id="selectedTimeRange">-</span></p>
            </div>
        </div>
    </div>
    <div class="text-end mt-3">
        <button id="prevButton3" class="btn btn-secondary">السابق</button>
        <button id="nextButton3" class="btn btn-primary">التالي</button>
    </div>
</div>

    <!-- الخطوة 4: اختيار العميل وحفظ البيانات -->
    <form id="clientForm" action="{{ route('Reservations.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div id="step4" class="step" style="display: none;">
            <div class="row">
                <div class="col-md-8">
                    <div class="card p-3">
                        <h5>اختر العميل</h5>
                        <label for="clientSelect" class="form-label">اختر عميل</label>
                        <select id="clientSelect" class="form-select" name="client_id">
                            @foreach ($Clients as $Client)
                                <option value="{{ $Client->id }}">{{ $Client->first_name ?? "" }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-3">
                        <h5>تفاصيل الحجز</h5>
                        <p><strong>الخدمات المختارة:</strong> <span id="selectedServiceStep4">-</span></p>
                        <p><strong>الموظف المختار:</strong> <span id="selectedEmployeeStep4">-</span></p>
                        <p><strong>التاريخ والوقت:</strong> <span id="selectedDateTimeStep4">-</span></p>
                        <p><strong>العميل المختار:</strong> <span id="selectedClient">-</span></p>
                    </div>
                </div>
            </div>

            <!-- حقول مخفية لإرسال البيانات -->
            <input type="hidden" name="product_id" id="hiddenService">
            <input type="hidden" name="employee_id" id="hiddenEmployee">
            <input type="hidden" name="appointment_date" id="hiddenDate">
            <input type="hidden" name="start_time" id="hiddenTime1">
            <input type="hidden" name="end_time" id="hiddenTime12">
            
            <input type="hidden" name="client_id" id="hiddenClient">

            <div class="text-end mt-3">
                <button id="prevButton4" class="btn btn-secondary">السابق</button>
                <button type="submit" id="saveButton" class="btn btn-success">حفظ الحجز</button>
            </div>
        </div>
    </form>
</div>
@endsection
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentStep = 1;

    // تحديث شريط التقدم
    function updateProgress() {
        document.querySelectorAll('.circle').forEach((circle, index) => {
            if (index + 1 === currentStep) {
                circle.classList.remove('bg-secondary');
                circle.classList.add('bg-primary');
            } else {
                circle.classList.remove('bg-primary');
                circle.classList.add('bg-secondary');
            }
        });
    }

    // الانتقال بين الخطوات
    function showStep(step) {
        document.querySelectorAll('.step').forEach((stepElement, index) => {
            if (index + 1 === step) {
                stepElement.style.display = 'block';
            } else {
                stepElement.style.display = 'none';
            }
        });
        updateProgress();
    }

    // تعبئة الحقول المخفية قبل إرسال النموذج
    document.getElementById('clientForm').addEventListener('submit', function(event) {
        document.getElementById('hiddenService').value = document.getElementById('serviceSelect').value;
        document.getElementById('hiddenEmployee').value = document.getElementById('employeeSelect_1').value;
        document.getElementById('hiddenDate').value = document.getElementById('dateSelect').value;
        document.getElementById('hiddenTime1').value = document.getElementById('startTime').value; // تعبئة start_time
        document.getElementById('hiddenTime12').value = document.getElementById('endTime').value; // تعبئة end_time
        document.getElementById('hiddenClient').value = document.getElementById('clientSelect').value;
    });

    // تحديث تفاصيل الحجز في الكارد الأيمن
    function updateReservationDetails() {
        // الخطوة 1: الخدمة
        let selectedService = document.getElementById('serviceSelect').options[document.getElementById('serviceSelect').selectedIndex].getAttribute('data-name');
        document.getElementById('selectedService').textContent = selectedService || "-";
        document.getElementById('selectedServiceStep2').textContent = selectedService || "-";
        document.getElementById('selectedServiceStep3').textContent = selectedService || "-";
        document.getElementById('selectedServiceStep4').textContent = selectedService || "-";

        // الخطوة 2: الموظف
        let selectedEmployee = document.getElementById('employeeSelect_1').options[document.getElementById('employeeSelect_1').selectedIndex].text;
        document.getElementById('selectedEmployee').textContent = selectedEmployee || "-";
        document.getElementById('selectedEmployeeStep3').textContent = selectedEmployee || "-";
        document.getElementById('selectedEmployeeStep4').textContent = selectedEmployee || "-";

        // الخطوة 3: التاريخ والوقت
        let selectedDate = document.getElementById('dateSelect').value;
        let startTime = document.getElementById('startTime').value;
        let endTime = document.getElementById('endTime').value;
        document.getElementById('selectedDate').textContent = selectedDate || "-";
        document.getElementById('selectedTimeRange').textContent = (startTime && endTime) ? `${startTime} - ${endTime}` : "-";
        document.getElementById('selectedDateTimeStep4').textContent = (selectedDate && startTime && endTime) ? `${selectedDate} ${startTime} - ${endTime}` : "-";

        // الخطوة 4: العميل
        let selectedClient = document.getElementById('clientSelect').options[document.getElementById('clientSelect').selectedIndex].text;
        document.getElementById('selectedClient').textContent = selectedClient || "-";
    }

    // الخطوة 1: اختيار الخدمة
    document.getElementById('serviceSelect').addEventListener('change', function() {
        updateReservationDetails();
    });

    document.getElementById('nextButton1').addEventListener('click', function() {
        currentStep = 2;
        showStep(currentStep);
        updateReservationDetails();
    });

    // الخطوة 2: اختيار الموظف
    document.getElementById('employeeSelect_1').addEventListener('change', function() {
        updateReservationDetails();
    });

    document.getElementById('nextButton2').addEventListener('click', function() {
        currentStep = 3;
        showStep(currentStep);
        updateReservationDetails();
    });

    document.getElementById('prevButton2').addEventListener('click', function() {
        currentStep = 1;
        showStep(currentStep);
        updateReservationDetails();
    });

    // الخطوة 3: اختيار التاريخ والوقت
    document.getElementById('dateSelect').addEventListener('change', function() {
        updateReservationDetails();
    });

    document.getElementById('startTime').addEventListener('change', function() {
        updateReservationDetails();
    });

    document.getElementById('endTime').addEventListener('change', function() {
        updateReservationDetails();
    });

    document.getElementById('nextButton3').addEventListener('click', function() {
        currentStep = 4;
        showStep(currentStep);
        updateReservationDetails();
    });

    document.getElementById('prevButton3').addEventListener('click', function() {
        currentStep = 2;
        showStep(currentStep);
        updateReservationDetails();
    });

    // الخطوة 4: اختيار العميل
    document.getElementById('clientSelect').addEventListener('change', function() {
        updateReservationDetails();
    });

    document.getElementById('prevButton4').addEventListener('click', function() {
        currentStep = 3;
        showStep(currentStep);
        updateReservationDetails();
    });

    // تهيئة الخطوة الأولى
    showStep(currentStep);
    updateReservationDetails();
});
</script>