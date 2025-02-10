@extends('master')

@section('title')
الحركات المالية
@stop


@section('content')




<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">الحركات المالية</h2>
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

<div class="cart mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white text-center">
            <h4>بحث الحركات المالية</h4>
        </div>
        <div class="card-body">
            <form>
                <!-- جميع الحقول في سطر واحد -->
                <div class="row mb-3">
                    <!-- الحقل الأول -->
                    <div class="col-md-3">
                        <label for="branch">فرع :</label>
                        <select class="form-control" id="branch">
                            <option>أختر</option>
                        </select>
                    </div>
                    <!-- الحقل الثاني -->
                    <div class="col-md-3">
                        <label for="currency">العملة :</label>
                        <select class="form-control" id="currency">
                            <option>أختر</option>
                        </select>
                    </div>
                    <!-- الحقل الثالث -->
                    <div class="col-md-2">
                        <label for="custom">تخصيص :</label>
                        <select class="form-control" id="custom">
                            <option>الشهر الأول</option>
                            <option>الشهر الأخير</option>
                        </select>
                    </div>
                    <!-- الحقل الرابع -->
                    <div class="col-md-2">
                        <label for="from" class="form-label"> من :</label>
                        <input type="date" class="form-control" id="from" name="from">
                    </div>
                    <!-- الحقل الخامس -->
                    <div class="col-md-2">
                        <label for="to" class="form-label">إلى :</label>
                        <input type="date" class="form-control" id="to" name="to">
                    </div>
                </div>

                <!-- أزرار البحث وإلغاء الفلتر -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary mr-1 waves-effect waves-light">بحث</button>

                    <button type="reset" class="btn btn-outline-warning waves-effect waves-light">ألغاء</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <div class="cart mt-5">
        <!-- معلومات المؤسسة -->
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="text-center mb-3">نتائج</h4>
                <h5 class="text-center fw-bold">مؤسسة أعمال خاصة للتجارة</h5>
                <p class="text-center mb-0">الرياض</p>
                <p class="text-center">الرياض، الرياض</p>
            </div>
        </div>

        <!-- معلومات الفترة -->
        <div class="alert alert-info text-center mb-4">
            <strong>الحركات المالية (SAR)</strong><br>
            <span>من 12/04/2021 إلى 12/04/2021</span>
        </div>

        <!-- جدول الحركات المالية -->
        <table class="table table-bordered table-hover text-center">
            <thead class="table-primary">
                <tr>
                    <th>التاريخ</th>
                    <th>الوصف</th>
                    <th>المبلغ</th>
                    <th>الرصيد بعد</th>
                </tr>
            </thead>
            <tbody>
                <tr class="fw-bold">
                    <td colspan="3" class="text-start">رصيد بداية المدة</td>
                    <td>156,295 ر.س</td>
                </tr>
                <tr>
                    <td>12/04/2021</td>
                    <td>مدفوعات الفواتير #950, وسيلة دفع: Cash, لـفاتورة# 00639</td>
                    <td>156.00</td>
                    <td>156,451.00</td>
                </tr>
                <tr>
                    <td>12/04/2021</td>
                    <td>مدفوعات الفواتير #951, وسيلة دفع: Cash, لـفاتورة# 00640</td>
                    <td>156.00</td>
                    <td>156,607.00</td>
                </tr>
                <tr>
                    <td>12/04/2021</td>
                    <td>مدفوعات الفواتير #953, وسيلة دفع: Cash, لـفاتورة# 00642</td>
                    <td>156.00</td>
                    <td>156,763.00</td>
                </tr>
                <tr>
                    <td>12/04/2021</td>
                    <td>مدفوعات الفواتير #954, وسيلة دفع: Cash, لـفاتورة# 00643</td>
                    <td>156.00</td>
                    <td>156,919.00</td>
                </tr>
                <tr>
                    <td>12/04/2021</td>
                    <td>مدفوعات الفواتير #955, وسيلة دفع: Cash, لـفاتورة# 00645</td>
                    <td>156.00</td>
                    <td>157,075.00</td>
                </tr>
                <tr>
                    <td>12/04/2021</td>
                    <td>مدفوعات الفواتير #956, وسيلة دفع: Cash, لـفاتورة# 00646</td>
                    <td>78.00</td>
                    <td>157,153.00</td>
                </tr>
                <tr>
                    <td>12/04/2021</td>
                    <td>مدفوعات الفواتير #957, وسيلة دفع: Cash, لـفاتورة# 00647</td>
                    <td>260.00</td>
                    <td>157,413.00</td>
                </tr>
                <tr>
                    <td>12/04/2021</td>
                    <td>مدفوعات الفواتير #1089, وسيلة دفع: Cash, لـفاتورة# 00818</td>
                    <td>936.00</td>
                    <td>158,349.00</td>
                </tr>
            </tbody>
            <tfoot>
                <tr class="table-success fw-bold">
                    <td colspan="3" class="text-start">إجمالي الإيراد</td>
                    <td>2,054 ر.س</td>
                </tr>
                <tr class="table-danger fw-bold">
                    <td colspan="3" class="text-start">إجمالي المصروفات</td>
                    <td>0.00 ر.س</td>
                </tr>
                <tr class="table-info fw-bold">
                    <td colspan="3" class="text-start">رصيد نهاية المدة</td>
                    <td>158,349 ر.س</td>
                </tr>
            </tfoot>
        </table>
    </div>




@endsection

