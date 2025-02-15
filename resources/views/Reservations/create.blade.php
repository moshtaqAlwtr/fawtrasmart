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
                    <select id="serviceSelect" class="form-select">
                        <option value="العناية الشخصية">العناية الشخصية</option>
                        <option value="الاستشارة الطبية">الاستشارة الطبية</option>
                        <option value="الخدمات المصرفية">الخدمات المصرفية</option>
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
                    <label for="employeeSelect" class="form-label">اختر موظف</label>
                    <select id="employeeSelect" class="form-select">
                        <option value="موظف 1">موظف 1</option>
                        <option value="موظف 2">موظف 2</option>
                        <option value="موظف 3">موظف 3</option>
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
                    <input type="date" id="dateSelect" class="form-control">
                    <label for="timeSelect" class="form-label mt-3">اختر الوقت</label>
                    <input type="time" id="timeSelect" class="form-control">
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <h5>تفاصيل الحجز</h5>
                    <p><strong>الخدمات المختارة:</strong> <span id="selectedServiceStep3">-</span></p>
                    <p><strong>الموظف المختار:</strong> <span id="selectedEmployeeStep3">-</span></p>
                    <p><strong>التاريخ والوقت:</strong> <span id="selectedDateTime">-</span></p>
                </div>
            </div>
        </div>
        <div class="text-end mt-3">
            <button id="prevButton3" class="btn btn-secondary">السابق</button>
            <button id="nextButton3" class="btn btn-primary">التالي</button>
        </div>
    </div>

    <!-- الخطوة 4: اختيار العميل -->
    <div id="step4" class="step" style="display: none;">
        <div class="row">
            <div class="col-md-8">
                <div class="card p-3">
                    <h5>اختر العميل</h5>
                    <label for="clientSelect" class="form-label">اختر عميل</label>
                    <select id="clientSelect" class="form-select">
                        <option value="عميل 1">عميل 1</option>
                        <option value="عميل 2">عميل 2</option>
                        <option value="عميل 3">عميل 3</option>
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
        <div class="text-end mt-3">
            <button id="prevButton4" class="btn btn-secondary">السابق</button>
            <button id="saveButton" class="btn btn-success">حفظ الحجز</button>
        </div>
    </div>
</div>

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

        // الخطوة 1: اختيار الخدمة
        document.getElementById('serviceSelect').addEventListener('change', function() {
            document.getElementById('selectedService').textContent = this.value;
            document.getElementById('selectedServiceStep2').textContent = this.value;
            document.getElementById('selectedServiceStep3').textContent = this.value;
            document.getElementById('selectedServiceStep4').textContent = this.value;
        });

        document.getElementById('nextButton1').addEventListener('click', function() {
            currentStep = 2;
            showStep(currentStep);
        });

        // الخطوة 2: اختيار الموظف
        document.getElementById('employeeSelect').addEventListener('change', function() {
            document.getElementById('selectedEmployee').textContent = this.value;
            document.getElementById('selectedEmployeeStep3').textContent = this.value;
            document.getElementById('selectedEmployeeStep4').textContent = this.value;
        });

        document.getElementById('prevButton2').addEventListener('click', function() {
            currentStep = 1;
            showStep(currentStep);
        });

        document.getElementById('nextButton2').addEventListener('click', function() {
            currentStep = 3;
            showStep(currentStep);
        });

        // الخطوة 3: اختيار التاريخ والوقت
        document.getElementById('dateSelect').addEventListener('change', function() {
            document.getElementById('selectedDateTime').textContent = this.value + ' ' + document.getElementById('timeSelect').value;
            document.getElementById('selectedDateTimeStep4').textContent = this.value + ' ' + document.getElementById('timeSelect').value;
        });

        document.getElementById('timeSelect').addEventListener('change', function() {
            document.getElementById('selectedDateTime').textContent = document.getElementById('dateSelect').value + ' ' + this.value;
            document.getElementById('selectedDateTimeStep4').textContent = document.getElementById('dateSelect').value + ' ' + this.value;
        });

        document.getElementById('prevButton3').addEventListener('click', function() {
            currentStep = 2;
            showStep(currentStep);
        });

        document.getElementById('nextButton3').addEventListener('click', function() {
            currentStep = 4;
            showStep(currentStep);
        });

        // الخطوة 4: اختيار العميل
        document.getElementById('clientSelect').addEventListener('change', function() {
            document.getElementById('selectedClient').textContent = this.value;
        });

        document.getElementById('prevButton4').addEventListener('click', function() {
            currentStep = 3;
            showStep(currentStep);
        });

        document.getElementById('saveButton').addEventListener('click', function() {
            alert('تم حفظ الحجز بنجاح!');
            // يمكنك إضافة الكود لحفظ الحجز هنا
        });

        // تهيئة الخطوة الأولى
        showStep(currentStep);
    });
</script>

@endsection