@extends('master')

@section('title')
تقارير الضرائب
@stop


@section('content')




<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">تقارير الضرائب </h2>
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
                    <h4>التفاصيل</h4>
                    <div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">تقرير الضرائب</h5>
    </div>
    <div class="card-body">
        <!-- القيمة المضافة (15%) - فواتير البيع -->
        <h6 class="text-secondary">القيمة المضافة (15%) - فواتير البيع</h6>
        <table class="table table-striped table-bordered mb-4">
            <thead class="table-dark">
                <tr>
                    <th>رقم</th>
                    <th>الممول</th>
                    <th>الرقم الضريبي</th>
                    <th>التاريخ</th>
                    <th>البند</th>
                    <th>الوصف</th>
                    <th>المبلغ الخاضع للضريبة (SAR)</th>
                    <th>الضرائب (SAR)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>09132</td>
                    <td>عميل نقدي</td>
                    <td>—</td>
                    <td>14/12/2024</td>
                    <td>عطر 50 ملي - 3961</td>
                    <td>فاتورة #09132</td>
                    <td>15.65</td>
                    <td>2.35</td>
                </tr>
                <tr class="fw-bold">
                    <td colspan="6" class="text-end">المجموع:</td>
                    <td>15.65</td>
                    <td>2.35</td>
                </tr>
            </tbody>
        </table>

        <!-- القيمة المضافة (15%) - Sales Debit Note -->
        <h6 class="text-secondary">القيمة المضافة (15%) - Sales Debit Note</h6>
        <table class="table table-striped table-bordered mb-4">
            <thead class="table-dark">
                <tr>
                    <th colspan="6" class="text-end">المجموع:</th>
                    <th>0.00</th>
                    <th>0.00</th>
                </tr>
            </thead>
        </table>

        <!-- مردودات المبيعات -->
        <h6 class="text-secondary">مردودات المبيعات</h6>
        <table class="table table-striped table-bordered mb-4">
            <thead class="table-dark">
                <tr>
                    <th colspan="6" class="text-end">المجموع:</th>
                    <th>0.00</th>
                    <th>0.00</th>
                </tr>
            </thead>
        </table>

        <!-- فواتير الشراء -->
        <h6 class="text-secondary">فواتير الشراء</h6>
        <table class="table table-striped table-bordered mb-4">
            <thead class="table-dark">
                <tr>
                    <th colspan="6" class="text-end">المجموع:</th>
                    <th>0.00</th>
                    <th>0.00</th>
                </tr>
            </thead>
        </table>

        <!-- مردودات المشتريات -->
        <h6 class="text-secondary">مردودات المشتريات</h6>
        <table class="table table-striped table-bordered mb-4">
            <thead class="table-dark">
                <tr>
                    <th colspan="6" class="text-end">المجموع:</th>
                    <th>0.00</th>
                    <th>0.00</th>
                </tr>
            </thead>
        </table>

        <!-- Purchases Credit Note -->
        <h6 class="text-secondary">Purchases Credit Note</h6>
        <table class="table table-striped table-bordered mb-4">
            <thead class="table-dark">
                <tr>
                    <th colspan="6" class="text-end">المجموع:</th>
                    <th>0.00</th>
                    <th>0.00</th>
                </tr>
            </thead>
        </table>

        <!-- الإجمالي الكلي -->
        <h5 class="text-primary text-end mt-4">الإجمالي الكلي (SAR):</h5>
        <table class="table table-bordered">
            <tbody>
                <tr class="fw-bold">
                    <td class="text-end">المبلغ الخاضع للضريبة:</td>
                    <td>15.65</td>
                </tr>
                <tr class="fw-bold">
                    <td class="text-end">الضرائب:</td>
                    <td>2.35</td>
                </tr>
            </tbody>
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