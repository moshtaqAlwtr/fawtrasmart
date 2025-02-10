@extends('master')

@section('title')
أقرار ضريبي
@stop


@section('content')




<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">أقرار ضريبي </h2>
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
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">نموذج البحث</h5>
    </div>
    <div class="card-body">
        <form method="GET">
            <div class="row g-3">
                <!-- الضرائب -->
                <div class="col-md-4">
                    <label for="taxes" class="form-label">الضرائب:</label>
                    <select class="form-control" id="taxes" name="taxes">
                        <option>اختر</option>
                    </select>
                </div>

                <!-- نوعية الدخل -->
                <div class="col-md-4">
                    <label for="income_type" class="form-label">نوعية الدخل:</label>
                    <select class="form-control" id="income_type" name="income_type">
                        <option>اختر</option>
                    </select>
                </div>

                <!-- الفترة من -->
                <div class="col-md-2">
                    <label for="date_from" class="form-label">الفترة من:</label>
                    <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" class="form-control">
                </div>

                <!-- الفترة إلى -->
                <div class="col-md-2">
                    <label for="date_to" class="form-label">الفترة إلى:</label>
                    <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" class="form-control">
                </div>
            </div>

            <div class="row g-3 mt-3">
                <!-- تجميع حسب -->
                <div class="col-md-4">
                    <label for="group_by" class="form-label">تجميع حسب:</label>
                    <select class="form-control" id="group_by" name="group_by">
                        <option>الكل</option>
                    </select>
                </div>

                <!-- العملة -->
                <div class="col-md-4">
                    <label for="currency" class="form-label">العملة:</label>
                    <select class="form-control" id="currency" name="currency">
                        <option>ريال</option>
                        <option>دولار</option>
                    </select>
                </div>

                <!-- الفرع -->
                <div class="col-md-4">
                    <label for="branch" class="form-label">الفرع:</label>
                    <input type="text" name="branch" id="branch" value="{{ request('branch') }}" class="form-control" placeholder="اسم الفرع">
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <!-- زر البحث -->
                <button type="submit" class="btn btn-primary me-2 waves-effect waves-light">بحث</button>

                <!-- زر الإلغاء -->
                <button type="reset" class="btn btn-outline-warning waves-effect waves-light">إلغاء</button>
            </div>
        </form>
    </div>
</div>

    <div class="card">
        <div class="card-body">
            <!-- العنوان الرئيسي -->
            <div class="row">
                <!-- اسم المؤسسة - يمين -->
                <div class="col-6 text-left">
                    <p>مؤسسة أعمال خاصة للتجارة</p>
                    <p>الرياض</p>
                </div>

                <!-- العنوان الفرعي و التاريخ - يسار -->
                <div class="col-6 text-right">
                    <div class="report-title">
                        الأرباح السنوية لمبيعات المنتجات
                    </div>
                    <!-- المدة الزمنية -->
                    <div class="report-subtitle">
                        <strong>من:</strong> 15/11/2024
                        <strong>إلى:</strong> 15/12/2024
                    </div>
                </div>
            </div>

            <!-- تبويبات رئيسية -->
            <ul class="nav nav-tabs mt-4" id="reportTabs" role="tablist">
                <!-- تبويب الملخص -->
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="summary-tab" data-bs-toggle="tab" href="#summary" role="tab"
                        aria-controls="summary" aria-selected="true">الملخص</a>
                </li>
                <!-- تبويب التفاصيل -->
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="details-tab" data-bs-toggle="tab" href="#details" role="tab"
                        aria-controls="details" aria-selected="false">التفاصيل</a>
                </li>
                <!-- تبويب العميل -->
                <li class="nav-item dropdown ms-auto" role="presentation">
                    <a class="nav-link dropdown-toggle" id="exportDropdown" data-bs-toggle="dropdown" href="#"
                        role="button" aria-expanded="false">العميل</a>
                    <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                        <li><a class="dropdown-item" href="#">يومي</a></li>
                        <li><a class="dropdown-item" href="#"> أسبوعي </a></li>
                        <li><a class="dropdown-item" href="#">شهري</a></li>
                        <li><a class="dropdown-item" href="#">سنوي</a></li>
                        <li><a class="dropdown-item" href="#">موظف</a></li>
                        <li><a class="dropdown-item" href="#">مسؤول مبيعات</a></li>
                        <li><a class="dropdown-item" href="#">  العميل</a></li>
                    </ul>
                </li>
                <!-- تبويبات خيارات التصدير والطباعة -->
                <li class="nav-item dropdown ms-auto" role="presentation">
                    <a class="nav-link dropdown-toggle" id="exportDropdown" data-bs-toggle="dropdown" href="#"
                        role="button" aria-expanded="false">خيارات</a>
                    <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                        <li><a class="dropdown-item" href="#">طباعة</a></li>
                        <li><a class="dropdown-item" href="#">تصدير إلى Excel</a></li>
                        <li><a class="dropdown-item" href="#">تصدير إلى PDF</a></li>
                    </ul>
                </li>
            </ul>



            <!-- محتوى التبويبات -->
            <div class="tab-content mt-4" id="reportTabsContent">
                <!-- تبويب الملخص -->
                <div class="tab-pane fade show active" id="summary" role="tabpanel" aria-labelledby="summary-tab">
                    <h4>الملخص</h4>
                    <p>هنا يمكنك إضافة محتوى الملخص...</p>
                </div>
                <!-- تبويب التفاصيل -->
                <div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="details-tab">
                  
                    <div class="card">
                    <h3 class="mb-3">المبيعات</h3>
    <table class="table table-bordered text-center">
        <thead class="table-light">
            <tr>
                <th>الضريبة</th>
                <th>المبيعات</th>
                <th>التعديل</th>
                <th>الضريبة المستحقة</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>القيمة المضافة (15%)</td>
                <td>15.65</td>
                <td>0.00</td>
                <td>2.35</td>
            </tr>
        </tbody>
    </table>

    <h3 class="mb-3">المشتريات</h3>
    <table class="table table-bordered text-center">
        <thead class="table-light">
            <tr>
                <th>الضريبة</th>
                <th>المشتريات</th>
                <th>التعديل</th>
                <th>الضريبة المدفوعة</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>القيمة المضافة (15%)</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
            </tr>
        </tbody>
    </table>

    <h3 class="mb-3">آخرون</h3>
    <table class="table table-bordered text-center">
        <thead class="table-light">
            <tr>
                <th>الضريبة</th>
                <th>تمت التسوية</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>القيمة المضافة (15%)</td>
                <td>0.00</td>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered text-center">
        <tr class="table-info fw-bold">
            <td colspan="4">الإجمالي (SAR): 2.35</td>
        </tr>
    </table>

    </div>
</div>
              
                <!-- تبويب العميل -->
                <div class="tab-pane fade" id="client" role="tabpanel" aria-labelledby="client-tab">
                    <h4>العميل</h4>
                    <p>هنا يمكنك إضافة محتوى العميل...</p>
                </div>
            </div>
        </div>
    </div>
</div>












<script>
    // تفعيل الـ Datepicker على حقل الفترة
    $('#date-range').datepicker({
        format: 'dd/mm/yyyy',
        startView: 1,
        minViewMode: 0,
        autoclose: true
    });
</script>
@endsection