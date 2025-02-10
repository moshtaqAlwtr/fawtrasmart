@extends('master')

@section('title')
تقرير المدفوعات الشهرية
@stop


@section('content')


<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">تقرير المدفوعات الشهرية</h2>
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

<div class="container mt-4">
    <div class="card shadow">

        <div class="card-body">
            <!-- نموذج البحث -->
            <form>
                <div class="row">
                    <!-- السطر الأول -->
                    <div class="col-md-4">
                        <label for="date-range">الفترة من / إلى:</label>
                        <input type="text" class="form-control" id="date-range" value="14/11/2024 - 14/12/2024">
                    </div>
                    <div class="col-md-4">
                        <label for="status">الحالة:</label>
                        <select class="form-control" id="status">
                            <option>الكل</option>
                            <option>مدفوع</option>
                            <option>متأخر</option>
                            <option>غير مدفوع</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="supplier">العميل:</label>
                        <select class="form-control" id="supplier">
                            <option>اختر مورد</option>
                        </select>
                    </div>
                </div>

                <div class="row mt-3">
                    <!-- السطر الثاني -->
                    <div class="col-md-4">
                        <label for="employee">موظف:</label>
                        <select class="form-control" id="employee">
                            <option>الكل</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="order">أمر التوريد:</label>
                        <select class="form-control" id="order">
                            <option>الكل</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="branch">فرع:</label>
                        <select class="form-control" id="branch">
                            <option>-None selected</option>
                        </select>
                    </div>
                </div>
                <div class="row md-4">
                        <div class="col-md-4">
                            <label for="supplier">تصنيف العميل:</label>
                            <select class="form-control" id="supplier">
                                <option>اختر التصنيف</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary mr-1 waves-effect waves-light">بحث</button>

                        <a class="btn btn-outline-secondary ml-2 mr-2" data-toggle="collapse"
                            data-target="#advancedSearchForm">
                            <i class="bi bi-sliders"></i> بحث متقدم
                        </a>
                        <button type="reset" class="btn btn-outline-warning waves-effect waves-light">Cancel</button>
                    </div>
            </form>
        </div>
     </div>
</div>
        <div class="container mt-4">
    <div class="card shadow">
        <div class="card-body">
            <h5 class="card-title">بيانات المدفوعات الشهرية</h5>

            <!-- تاريخ الشهر -->
            <h6>التاريخ:من 01/12/2024 إلى 31/12/2024</h6>

            <!-- الجدول -->
            <table class="table table-bordered table-striped mt-3">
                <thead>
                    <tr>
                        <th>رقم</th>
                        <th>العميل</th>
                        <th>موظف</th>
                        <th>مدفوعة (SAR)</th>
                        <th>غير مدفوعة (SAR)</th>
                        <th>مرتجع (SAR)</th>
                        <th>الإجمالي (SAR)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>08856</td>
                        <td>لمسات الهزاز</td>
                        <td>محمد المنصوب مدير</td>
                        <td>0.00</td>
                        <td>432.00</td>
                        <td>0.00</td>
                        <td>432.00</td>
                    </tr>
                    <tr>
                        <td>08857</td>
                        <td>تموينات المرشد</td>
                        <td>محمد المنصوب مدير</td>
                        <td>0.00</td>
                        <td>216.00</td>
                        <td>0.00</td>
                        <td>216.00</td>
                    </tr>
                    <tr>
                        <td>08858</td>
                        <td>تموينات صالح فرحان بن دغيم الشكره</td>
                        <td>محمد المنصوب مدير</td>
                        <td>0.00</td>
                        <td>216.00</td>
                        <td>0.00</td>
                        <td>216.00</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right"><strong>المجموع</strong></td>
                        <td><strong>0.00</strong></td>
                        <td><strong>864.00</strong></td>
                        <td><strong>0.00</strong></td>
                        <td><strong>864.00</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

        <!-- رسالة لا توجد نتائج -->
        <div class="card-footer bg-light border-0">
            <div class="alert alert-warning text-center mb-0" role="alert">
                لا توجد نتائج تطابق هذه الاختيارات <br>
                قم بتغيير فترة البحث وحاول مجدداً.
            </div>
        </div>
    </div>
</div>


<!-- إضافة رابط الجافاسكربت الخاص بـ Bootstrap Datepicker -->


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