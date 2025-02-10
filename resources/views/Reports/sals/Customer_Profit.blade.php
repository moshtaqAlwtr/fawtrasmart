<!-- العنوان -->
@extends('master')

@section('title')
أرباح مبيعات الأصناف للعميل
@stop


@section('content')


<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">أرباح مبيعات الأصناف للعميل</h2>
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
<div class="container mt-4">
    <div class="card">
        <div class="card-body">
            <form>
                <div class="row">
                    <div class="col-md-4 mb-1">
                        <div class="form-group">
                            <label for="category">التصنيف</label>
                            <select class="form-control" id="category">
                                <option>جميع التصنيفات</option>
                                <!-- Add more options here -->
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 mb-1">
                        <div class="form-group">
                            <label for="items_group">مجموعة البنود</label>
                            <select class="form-control" id="items_group">
                                <option>اختار مجموعة البنود</option>
                                <!-- Add more options here -->
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 mb-1">
                        <div class="form-group">
                            <label for="branch">الفرع</label>
                            <select class="form-control" id="branch">
                                <option>جميع الفروع</option>
                                <!-- Add more options here -->
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-1">
                        <div class="form-group">
                            <label for="from_date">من</label>
                            <input type="date" class="form-control" id="from_date">
                        </div>
                    </div>
                    <div class="col-md-4 mb-1">
                        <div class="form-group">
                            <label for="to_date">إلى</label>
                            <input type="date" class="form-control" id="to_date">
                        </div>
                    </div>
                    <div class="col-md-4 mb-1">
                        <div class="form-group">
                            <label for="month">الفترة </label>
                            <select class="form-control" id="month">
                                <option> الشهر الأول</option>
                                <option> الشهر الثاني</option>
                                <option> الشهر الأخير</option>
                                <option> السنه الماضية</option>
                                <!-- Add more options here -->
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="company">الماركة</label>
                            <select class="form-control" id="company">
                                <option>جميع الماركات</option>
                                <!-- Add more options here -->
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary mr-1 waves-effect waves-light">بحث</button>

                    
                    <button type="reset" class="btn btn-outline-warning waves-effect waves-light">ألغاء</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container mt-4">
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
                    أرباح مبيعات الأصناف - للعميل  
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
                   
                    <div class="container mt-4">
                        <!-- العنوان الأول للمؤسسة -->
                        <div class="header text-center text-primary mb-4" style="font-size: 24px; font-weight: bold;">
                            مؤسسة عقلا العنزي للتجارة
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>العميل</th>
                                        <th>الموظف</th>
                                        <th>مدفوعة (SAR)</th>
                                        <th>غير مدفوعة (SAR)</th>
                                        <th>مرتجع (SAR)</th>
                                        <th>الإجمالي (SAR)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>08856</td>
                                        <td>عقلا العنزي</td>
                                        <td>محمد المنصوب</td>
                                        <td>100.00</td>
                                        <td>200.00</td>
                                        <td>0.00</td>
                                        <td>300.00</td>
                                    </tr>
                                    <tr>
                                        <td>08857</td>
                                        <td>عقلا العنزي</td>
                                        <td>سعيد الغامدي</td>
                                        <td>50.00</td>
                                        <td>100.00</td>
                                        <td>20.00</td>
                                        <td>170.00</td>
                                    </tr>
                                    <tr>
                                        <td>08858</td>
                                        <td>عقلا العنزي</td>
                                        <td>علي الزهراني</td>
                                        <td>150.00</td>
                                        <td>50.00</td>
                                        <td>30.00</td>
                                        <td>230.00</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end">المجموع</td>
                                        <td>300.00</td>
                                        <td>350.00</td>
                                        <td>50.00</td>
                                        <td>700.00</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="container mt-4">
                        <!-- العنوان الثاني للمؤسسة -->
                        <div class="header text-center text-danger mb-4" style="font-size: 24px; font-weight: bold;">
                            أسواق سلطان المركزية للتجارة
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>العميل</th>
                                        <th>الموظف</th>
                                        <th>مدفوعة (SAR)</th>
                                        <th>غير مدفوعة (SAR)</th>
                                        <th>مرتجع (SAR)</th>
                                        <th>الإجمالي (SAR)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>08856</td>
                                        <td>عقلا العنزي</td>
                                        <td>محمد المنصوب</td>
                                        <td>100.00</td>
                                        <td>200.00</td>
                                        <td>0.00</td>
                                        <td>300.00</td>
                                    </tr>
                                    <tr>
                                        <td>08857</td>
                                        <td>عقلا العنزي</td>
                                        <td>سعيد الغامدي</td>
                                        <td>50.00</td>
                                        <td>100.00</td>
                                        <td>20.00</td>
                                        <td>170.00</td>
                                    </tr>
                                    <tr>
                                        <td>08858</td>
                                        <td>عقلا العنزي</td>
                                        <td>علي الزهراني</td>
                                        <td>150.00</td>
                                        <td>50.00</td>
                                        <td>30.00</td>
                                        <td>230.00</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end">المجموع</td>
                                        <td>300.00</td>
                                        <td>350.00</td>
                                        <td>50.00</td>
                                        <td>700.00</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
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