@extends('master')

@section('title')
تقرير ميزان مراجعة أرصدة
@stop

@section('content')

<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">تقرير ميزان مراجعة أرصدة</h2>
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

<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">البحث</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="">
                <div class="row">
                    <!-- موظف -->
                  

                    <!-- تاريخ الشراء من -->
                    <div class="col-md-3 mb-3">
                        <label for="purchase_from" class="form-label">تاريخ  من</label>
                        <input type="date" id="purchase_from" class="form-control">
                    </div>

                    <!-- تاريخ الشراء إلى -->
                    <div class="col-md-3 mb-3">
                        <label for="purchase_to" class="form-label">تاريخ  إلى</label>
                        <input type="date" id="purchase_to" class="form-control">
                    </div>

                    <!-- تاريخ الإهلاك من -->
                    <div class="col-md-3 mb-3">
                        <label for="branch" class="form-label">نوع الحساب</label>
                        <select id="branch" class="form-control">
                            <option>الكل</option>
                            <!-- أضف أسماء الفروع هنا -->
                        </select>
                    </div>

                    <!-- تاريخ الإهلاك إلى -->
                    <div class="col-md-3 mb-3">
                        <label for="branch" class="form-label">حساب  رئيسي</label>
                        <select id="branch" class="form-control">
                            <option>الكل</option>
                            <!-- أضف أسماء الفروع هنا -->
                        </select>
                    </div>

                    <!-- الحالة -->
                    <div class="col-md-3 mb-3">
                        <label for="status" class="form-label">فرع الحسابات</label>
                        <select id="status" class="form-control">
                            <option>الكل</option>
                            <!-- أضف خيارات للحالة هنا -->
                        </select>
                    </div>

                    <!-- فرع -->
                    <div class="col-md-3 mb-3">
                        <label for="branch" class="form-label">أضيفت بواسطة</label>
                        <select id="branch" class="form-control">
                            <option>الكل</option>
                            <!-- أضف أسماء الفروع هنا -->
                        </select>
                    </div>

                    <!-- تجميع حسب -->
                    <div class="col-md-3 mb-3">
                        <label for="group_by" class="form-label">فرع القيود</label>
                        <select id="group_by" class="form-control">
                            <option>الكل</option>
                            <!-- أضف خيارات التجميع هنا -->
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="group_by" class="form-label">عرض جميع الحسابات</label>
                        <select id="group_by" class="form-control">
                            <option>الكل</option>
                            <!-- أضف خيارات التجميع هنا -->
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="group_by" class="form-label">المستويات </label>
                        <select id="group_by" class="form-control">
                            <option>الكل</option>
                            <!-- أضف خيارات التجميع هنا -->
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="group_by" class="form-label">مراكز التكلفة</label>
                        <select id="group_by" class="form-control">
                            <option>الكل</option>
                            <!-- أضف خيارات التجميع هنا -->
                        </select>
                    </div>
                </div>

                <!-- أزرار البحث والإلغاء -->
                <div class="form-actions text-right mt-3">
                    <button type="submit" class="btn btn-primary mr-2 waves-effect waves-light">بحث</button>
                    <button type="reset" class="btn btn-outline-warning waves-effect waves-light">إلغاء</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="container mt-5">
    <!-- الكرت -->
    <div class="card-center">
    <div class="card-header  text-white">
    <h5 class="mb-0 text-center">
        تقرير ميزان مراجعة مجاميع وأرصدة<br>
        من 2024-01-01 إلى 2024-12-18<br>
        مؤسسة أعمال خاصة للتجارة<br>
        العملة: الجميع (إلى SAR)
    </h5>
</div>

        <div class="card-body">
            <!-- التبويبات -->
            <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="level1-tab" data-bs-toggle="tab" data-bs-target="#level1" type="button" role="tab" aria-controls="level1" aria-selected="true">مستوى 1</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="level2-tab" data-bs-toggle="tab" data-bs-target="#level2" type="button" role="tab" aria-controls="level2" aria-selected="false">مستوى 2</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="level3-tab" data-bs-toggle="tab" data-bs-target="#level3" type="button" role="tab" aria-controls="level3" aria-selected="false">مستوى 3</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="level4-tab" data-bs-toggle="tab" data-bs-target="#level4" type="button" role="tab" aria-controls="level4" aria-selected="false">مستوى 4</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="level5-tab" data-bs-toggle="tab" data-bs-target="#level5" type="button" role="tab" aria-controls="level5" aria-selected="false">مستوى 5</button>
                </li>
            </ul>

            <!-- محتويات التبويبات -->
            <div class="tab-content" id="myTabContent">
                <!-- مستوى 1 -->
                <div class="tab-pane fade show active" id="level1" role="tabpanel" aria-labelledby="level1-tab">
                    <div class="container mt-5">
    <div class="card">
        
        </div>
        <div class="card-body">
            <!-- الجدول -->
            <table class="table table-bordered table-hover text-center">
                <thead class="table-dark">
                    <tr>
                        <th>الاسم</th>
                        <th>الكود</th>
                        <th>الرصيد قبل (SAR) مدين</th>
                        <th>الرصيد قبل (SAR) دائن</th>
                        <th>رصيد الحركات (SAR) مدين</th>
                        <th>رصيد الحركات (SAR) دائن</th>
                        <th>الرصيد بعد (SAR) مدين</th>
                        <th>الرصيد بعد (SAR) دائن</th>
                        <th>الأرصدة (SAR) مدين</th>
                        <th>الأرصدة (SAR) دائن</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>الأصول</td>
                        <td>1</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>2,600</td>
                        <td>2,600</td>
                        <td>2,600</td>
                        <td>2,600</td>
                        <td>1,550</td>
                        <td>1,550</td>
                    </tr>
                    <tr>
                        <td>الخصوم</td>
                        <td>2</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>المصروفات</td>
                        <td>3</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>1,820</td>
                        <td>270.00</td>
                        <td>1,820</td>
                        <td>270.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>الإيرادات</td>
                        <td>4</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>270.00</td>
                        <td>1,820</td>
                        <td>1,820</td>
                        <td>270.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="table-secondary">
                        <td colspan="2">الإجمالي</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>4,690</td>
                        <td>4,690</td>
                        <td>4,690</td>
                        <td>4,690</td>
                        <td>1,550</td>
                        <td>1,550</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
                </div>
                <!-- مستوى 2 -->
                <div class="tab-pane fade" id="level2" role="tabpanel" aria-labelledby="level2-tab">
                       <!-- الجدول -->
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover text-center align-middle">
                <!-- رأس الجدول -->
                <thead class="table-dark">
                <tr>
                    <th rowspan="2">الاسم</th>
                    <th rowspan="2">الكود</th>
                    <th colspan="2">الرصيد قبل</th>
                    <th colspan="2">رصيد الحركات</th>
                    <th colspan="2">الرصيد بعد</th>
                    <th colspan="2">الأرصدة</th>
                </tr>
                <tr>
                    <th>مدين (SAR)</th>
                    <th>دائن (SAR)</th>
                    <th>مدين (SAR)</th>
                    <th>دائن (SAR)</th>
                    <th>مدين (SAR)</th>
                    <th>دائن (SAR)</th>
                    <th>مدين (SAR)</th>
                    <th>دائن (SAR)</th>
                </tr>
                </thead>
                <!-- جسم الجدول -->
                <tbody>
                <!-- مثال على البيانات -->
                <tr>
                    <td>الأصول</td>
                    <td>1</td>
                    <td>0.00</td>
                    <td>0.00</td>
                    <td>2,600</td>
                    <td>2,600</td>
                    <td>2,600</td>
                    <td>2,600</td>
                    <td>—</td>
                    <td>—</td>
                </tr>
                <tr>
                    <td>الأصول المتداولة</td>
                    <td>12</td>
                    <td>0.00</td>
                    <td>0.00</td>
                    <td>2,600</td>
                    <td>2,600</td>
                    <td>2,600</td>
                    <td>2,600</td>
                    <td>0.00</td>
                    <td>0.00</td>
                </tr>
                <tr>
                    <td>المصروفات</td>
                    <td>3</td>
                    <td>0.00</td>
                    <td>0.00</td>
                    <td>1,820</td>
                    <td>270</td>
                    <td>1,820</td>
                    <td>270</td>
                    <td>1,550</td>
                    <td>—</td>
                </tr>
                <tr>
                    <td>الإيرادات</td>
                    <td>4</td>
                    <td>0.00</td>
                    <td>0.00</td>
                    <td>270</td>
                    <td>1,820</td>
                    <td>270</td>
                    <td>1,820</td>
                    <td>—</td>
                    <td>1,550</td>
                </tr>
                </tbody>
                <!-- تذييل الجدول -->
                <tfoot>
                <tr class="table-secondary fw-bold">
                    <td colspan="2">الإجمالي</td>
                    <td>0.00 ر.س</td>
                    <td>0.00 ر.س</td>
                    <td>4,690 ر.س</td>
                    <td>4,690 ر.س</td>
                    <td>4,690 ر.س</td>
                    <td>4,690 ر.س</td>
                    <td>1,550 ر.س</td>
                    <td>1,550 ر.س</td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
                </div>
                <!-- مستوى 3 -->
                <div class="tab-pane fade" id="level3" role="tabpanel" aria-labelledby="level3-tab">
                      <!-- الجدول -->
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover text-center align-middle">
                <!-- رأس الجدول -->
                <thead class="table-dark">
                <tr>
                    <th rowspan="2">الاسم</th>
                    <th rowspan="2">الكود</th>
                    <th colspan="2">الرصيد قبل</th>
                    <th colspan="2">رصيد الحركات</th>
                    <th colspan="2">الرصيد بعد</th>
                    <th colspan="2">الأرصدة</th>
                </tr>
                <tr>
                    <th>مدين (SAR)</th>
                    <th>دائن (SAR)</th>
                    <th>مدين (SAR)</th>
                    <th>دائن (SAR)</th>
                    <th>مدين (SAR)</th>
                    <th>دائن (SAR)</th>
                    <th>مدين (SAR)</th>
                    <th>دائن (SAR)</th>
                </tr>
                </thead>
                <!-- جسم الجدول -->
                <tbody>
                <!-- مثال على البيانات -->
                <tr>
                    <td>الأصول</td>
                    <td>1</td>
                    <td>0.00</td>
                    <td>0.00</td>
                    <td>2,600</td>
                    <td>2,600</td>
                    <td>2,600</td>
                    <td>2,600</td>
                    <td>—</td>
                    <td>—</td>
                </tr>
                <tr>
                    <td>الأصول المتداولة</td>
                    <td>12</td>
                    <td>0.00</td>
                    <td>0.00</td>
                    <td>2,600</td>
                    <td>2,600</td>
                    <td>2,600</td>
                    <td>2,600</td>
                    <td>0.00</td>
                    <td>0.00</td>
                </tr>
                <tr>
                    <td>المصروفات</td>
                    <td>3</td>
                    <td>0.00</td>
                    <td>0.00</td>
                    <td>1,820</td>
                    <td>270</td>
                    <td>1,820</td>
                    <td>270</td>
                    <td>1,550</td>
                    <td>—</td>
                </tr>
                <tr>
                    <td>الإيرادات</td>
                    <td>4</td>
                    <td>0.00</td>
                    <td>0.00</td>
                    <td>270</td>
                    <td>1,820</td>
                    <td>270</td>
                    <td>1,820</td>
                    <td>—</td>
                    <td>1,550</td>
                </tr>
                </tbody>
                <!-- تذييل الجدول -->
                <tfoot>
                <tr class="table-secondary fw-bold">
                    <td colspan="2">الإجمالي</td>
                    <td>0.00 ر.س</td>
                    <td>0.00 ر.س</td>
                    <td>4,690 ر.س</td>
                    <td>4,690 ر.س</td>
                    <td>4,690 ر.س</td>
                    <td>4,690 ر.س</td>
                    <td>1,550 ر.س</td>
                    <td>1,550 ر.س</td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
                </div>
                <!-- مستوى 4 -->
                <div class="tab-pane fade" id="level4" role="tabpanel" aria-labelledby="level4-tab">
                       <!-- الجدول -->
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover text-center align-middle">
                <!-- رأس الجدول -->
                <thead class="table-dark">
                <tr>
                    <th rowspan="2">الاسم</th>
                    <th rowspan="2">الكود</th>
                    <th colspan="2">الرصيد قبل</th>
                    <th colspan="2">رصيد الحركات</th>
                    <th colspan="2">الرصيد بعد</th>
                    <th colspan="2">الأرصدة</th>
                </tr>
                <tr>
                    <th>مدين (SAR)</th>
                    <th>دائن (SAR)</th>
                    <th>مدين (SAR)</th>
                    <th>دائن (SAR)</th>
                    <th>مدين (SAR)</th>
                    <th>دائن (SAR)</th>
                    <th>مدين (SAR)</th>
                    <th>دائن (SAR)</th>
                </tr>
                </thead>
                <!-- جسم الجدول -->
                <tbody>
                <!-- مثال على البيانات -->
                <tr>
                    <td>الأصول</td>
                    <td>1</td>
                    <td>0.00</td>
                    <td>0.00</td>
                    <td>2,600</td>
                    <td>2,600</td>
                    <td>2,600</td>
                    <td>2,600</td>
                    <td>—</td>
                    <td>—</td>
                </tr>
                <tr>
                    <td>الأصول المتداولة</td>
                    <td>12</td>
                    <td>0.00</td>
                    <td>0.00</td>
                    <td>2,600</td>
                    <td>2,600</td>
                    <td>2,600</td>
                    <td>2,600</td>
                    <td>0.00</td>
                    <td>0.00</td>
                </tr>
                <tr>
                    <td>المصروفات</td>
                    <td>3</td>
                    <td>0.00</td>
                    <td>0.00</td>
                    <td>1,820</td>
                    <td>270</td>
                    <td>1,820</td>
                    <td>270</td>
                    <td>1,550</td>
                    <td>—</td>
                </tr>
                <tr>
                    <td>الإيرادات</td>
                    <td>4</td>
                    <td>0.00</td>
                    <td>0.00</td>
                    <td>270</td>
                    <td>1,820</td>
                    <td>270</td>
                    <td>1,820</td>
                    <td>—</td>
                    <td>1,550</td>
                </tr>
                </tbody>
                <!-- تذييل الجدول -->
                <tfoot>
                <tr class="table-secondary fw-bold">
                    <td colspan="2">الإجمالي</td>
                    <td>0.00 ر.س</td>
                    <td>0.00 ر.س</td>
                    <td>4,690 ر.س</td>
                    <td>4,690 ر.س</td>
                    <td>4,690 ر.س</td>
                    <td>4,690 ر.س</td>
                    <td>1,550 ر.س</td>
                    <td>1,550 ر.س</td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
                </div>
                <!-- مستوى 5 -->
                <div class="tab-pane fade" id="level5" role="tabpanel" aria-labelledby="level5-tab">
                       <!-- الجدول -->
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover text-center align-middle">
                <!-- رأس الجدول -->
                <thead class="table-dark">
                <tr>
                    <th rowspan="2">الاسم</th>
                    <th rowspan="2">الكود</th>
                    <th colspan="2">الرصيد قبل</th>
                    <th colspan="2">رصيد الحركات</th>
                    <th colspan="2">الرصيد بعد</th>
                    <th colspan="2">الأرصدة</th>
                </tr>
                <tr>
                    <th>مدين (SAR)</th>
                    <th>دائن (SAR)</th>
                    <th>مدين (SAR)</th>
                    <th>دائن (SAR)</th>
                    <th>مدين (SAR)</th>
                    <th>دائن (SAR)</th>
                    <th>مدين (SAR)</th>
                    <th>دائن (SAR)</th>
                </tr>
                </thead>
                <!-- جسم الجدول -->
                <tbody>
                <!-- مثال على البيانات -->
                <tr>
                    <td>الأصول</td>
                    <td>1</td>
                    <td>0.00</td>
                    <td>0.00</td>
                    <td>2,600</td>
                    <td>2,600</td>
                    <td>2,600</td>
                    <td>2,600</td>
                    <td>—</td>
                    <td>—</td>
                </tr>
                <tr>
                    <td>الأصول المتداولة</td>
                    <td>12</td>
                    <td>0.00</td>
                    <td>0.00</td>
                    <td>2,600</td>
                    <td>2,600</td>
                    <td>2,600</td>
                    <td>2,600</td>
                    <td>0.00</td>
                    <td>0.00</td>
                </tr>
                <tr>
                    <td>المصروفات</td>
                    <td>3</td>
                    <td>0.00</td>
                    <td>0.00</td>
                    <td>1,820</td>
                    <td>270</td>
                    <td>1,820</td>
                    <td>270</td>
                    <td>1,550</td>
                    <td>—</td>
                </tr>
                <tr>
                    <td>الإيرادات</td>
                    <td>4</td>
                    <td>0.00</td>
                    <td>0.00</td>
                    <td>270</td>
                    <td>1,820</td>
                    <td>270</td>
                    <td>1,820</td>
                    <td>—</td>
                    <td>1,550</td>
                </tr>
                </tbody>
                <!-- تذييل الجدول -->
                <tfoot>
                <tr class="table-secondary fw-bold">
                    <td colspan="2">الإجمالي</td>
                    <td>0.00 ر.س</td>
                    <td>0.00 ر.س</td>
                    <td>4,690 ر.س</td>
                    <td>4,690 ر.س</td>
                    <td>4,690 ر.س</td>
                    <td>4,690 ر.س</td>
                    <td>1,550 ر.س</td>
                    <td>1,550 ر.س</td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>




@endsection
