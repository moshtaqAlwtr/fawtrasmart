<!-- العنوان -->
@extends('master')

@section('title')
مبيعات البنود حسب الموظف
@stop


@section('content')


<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">مبيعات البنود حسب الموظف</h2>
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
    <div class="card shadow">

        <div class="card-body">
            <!-- نموذج البحث -->
            <form>
                <div class="row">
                    <!-- السطر الأول -->
                    <div class="col-md-3">
                        <label for="order"> البند:</label>
                        <select class="form-control" id="order">
                            <option>الكل</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="status">فاتورة:</label>
                        <select class="form-control" id="status">
                            <option>الكل</option>
                            <option>فاتورة</option>
                            <option>فاتورة مرتجعة </option>
                            <option>أشعار دائن</option>
                            <option>أشعار مدين</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="supplier">حالة الفاتورة:</label>
                        <select class="form-control" id="supplier">
                            <option>الكل </option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="supplier">التصنيف </label>
                        <select class="form-control" id="supplier">
                            <option>الكل </option>
                            <option>منتج</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <!-- السطر الثاني -->
                    <div class="col-md-3">
                        <label for="employee">موظف :</label>
                        <select class="form-control" id="employee">
                            <option>الكل</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="date-range">الفترة من / إلى:</label>
                        <input type="text" class="form-control" id="date-range" value="14/11/2024 - 14/12/2024">
                    </div>
                    <div class="col-md-3">
                        <label for="order"> العمله:</label>
                        <select class="form-control" id="order">
                            <option>ريال</option>
                            <option>دولار</option>
                            <option>جنيه</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="branch">فرع:</label>
                        <select class="form-control" id="branch">
                            <option>-None selected</option>
                        </select>
                    </div>
                </div>
                <div class="row md-4">
                    <div class="col-md-3">
                        <label for="supplier">العميل</label>
                        <select class="form-control" id="supplier">
                            <option>الكل </option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="order"> تصنيف العميل</label>
                        <select class="form-control" id="order">
                            <option>الكل</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="order"> الماركة</label>
                        <select class="form-control" id="order">
                            <option>الكل</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="order"> المخزن:</label>
                        <select class="form-control" id="order">
                            <option>الكل</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input type="checkbox" checked value="false">
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">Show Draft Items</span>
                                                    </div>
                                                    </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary mr-1 waves-effect waves-light">عرض التقرير</button>
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
                        مبيعات البنود حسب الموظف
                    </div>
                    <!-- المدة الزمنية -->
                    <div class="report-subtitle">
                        <strong>من:</strong> 15/11/2024
                        <strong>إلى:</strong> 15/11/2024
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
                            محمد المنصوب
                        </div>
                        <div class="container mt-4">
    <div class="card">
        <div class="card-body">
            <!-- العنوان الرئيسي -->
            <div class="row mb-3">
                <div class="col-12 text-center">
                    <h4>التقرير التفصيلي للفواتير</h4>
                    <p>التاريخ: 15/11/2024</p>
                </div>
            </div>

            <!-- جدول الفواتير -->
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>التاريخ</th>
                        <th>المعرف</th>
                        <th>الاسم</th>
                        <th>كود المنتج</th>
                        <th>موظف</th>
                        <th>فاتورة</th>
                        <th>العميل</th>
                        <th>سعر الوحدة</th>
                        <th>الكمية</th>
                        <th>الخصم</th>
                        <th>الإجمالي</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- صفوف البيانات -->
                    <tr>
                        <td>16/11/2024</td>
                        <td>48</td>
                        <td>عطر 50 ملي</td>
                        <td>3961</td>
                        <td>محمد المنصوب مدير</td>
                        <td>فاتورة #08859</td>
                        <td>تموينات النفط المتجدد #-123240</td>
                        <td>18.00</td>
                        <td>12</td>
                        <td>0.00</td>
                        <td>216.00</td>
                    </tr>
                    <tr>
                        <td>16/11/2024</td>
                        <td>48</td>
                        <td>عطر 50 ملي</td>
                        <td>3961</td>
                        <td>محمد المنصوب مدير</td>
                        <td>فاتورة #08860</td>
                        <td>أسواق ومخابز مستقبل الخير حي اليرموك #419</td>
                        <td>18.00</td>
                        <td>15</td>
                        <td>0.00</td>
                        <td>270.00</td>
                    </tr>
                    <tr>
                        <td>16/11/2024</td>
                        <td>48</td>
                        <td>عطر 50 ملي</td>
                        <td>3961</td>
                        <td>محمد المنصوب مدير</td>
                        <td>فاتورة #08861</td>
                        <td>أسواق ومخابز مستقبل الخير حي اليرموك #419</td>
                        <td>18.00</td>
                        <td>15</td>
                        <td>0.00</td>
                        <td>270.00</td>
                    </tr>
                    <tr>
                        <td>16/11/2024</td>
                        <td>48</td>
                        <td>عطر 50 ملي</td>
                        <td>3961</td>
                        <td>محمد المنصوب مدير</td>
                        <td>فاتورة مرتجعة #00787</td>
                        <td>أسواق ومخابز مستقبل الخير حي اليرموك #419</td>
                        <td>18.00</td>
                        <td>-15</td>
                        <td>0.00</td>
                        <td>-270.00</td>
                    </tr>
                    <tr>
                        <td>16/11/2024</td>
                        <td>48</td>
                        <td>عطر 50 ملي</td>
                        <td>3961</td>
                        <td>محمد الادريسي</td>
                        <td>فاتورة #08862</td>
                        <td>فرع تموينات شمال المجمعة #1130</td>
                        <td>18.00</td>
                        <td>12</td>
                        <td>0.00</td>
                        <td>216.00</td>
                    </tr>
                    <!-- المزيد من الصفوف كما هو موضح في المثال -->
                    <!-- إجمالي -->
                    <tr>
                        <td colspan="9" class="text-end"><strong>المجموع</strong></td>
                        <td>0.00</td>
                        <td><strong>3,888.00</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
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