@extends('master')

@section('title')
تقرير حساب الأستاذ العام
@stop

@section('content')

<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">تقرير حساب الاستاذ العام</h2>
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

<div class="card mt-5">
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
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-right align-items-center gap-2 flex-wrap">
           
            <!-- زر الطباعة -->
            <button type="button" class="btn btn-outline-secondary" onclick="window.print()">
                <i class="fa fa-print"></i> طباعة
            </button>
            <!-- زر خيارات التصدير -->
            <div class="dropdown">
                <button class="btn btn-outline-info dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-file-export"></i> خيارات التصدير
                </button>
                <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                    <li><a class="dropdown-item" href="#">تصدير كـ PDF</a></li>
                    <li><a class="dropdown-item" href="#">تصدير كـ Excel</a></li>
                    <li><a class="dropdown-item" href="#">تصدير كـ CSV</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
    <div class="container mt-5">
        <h3 class="text-center mb-4">تقرير حساب الأستاذ العام</h3>
        <!-- الجدول الرئيسي -->
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>رقم القيد</th>
                        <th>رقم مستند التحويل</th>
                        <th>التاريخ</th>
                        <th>الوصف</th>
                        <th>الموظف</th>
                        <th>المدين (SAR)</th>
                        <th>الدائن (SAR)</th>
                        <th>الرصيد</th>
                    </tr>
                </thead>
                <!-- القسم الأول: المبيعات -->
                <tbody>
                    <tr class="table-light">
                        <th colspan="8" class="text-start">المبيعات</th>
                    </tr>
                    <tr>
                        <td>00001</td>
                        <td>57028</td>
                        <td>16/12/2024</td>
                        <td>فرع 00001</td>
                        <td>أحمد الشمري</td>
                        <td>0.00</td>
                        <td>270.00</td>
                        <td>270.00</td>
                    </tr>
                    <tr>
                        <td>00002</td>
                        <td>57029</td>
                        <td>16/12/2024</td>
                        <td>فرع 00002</td>
                        <td>خالد السبيعي</td>
                        <td>510.00</td>
                        <td>0.00</td>
                        <td>510.00</td>
                    </tr>
                    <tr>
                        <th colspan="5">الإجمالي</th>
                        <th>510.00</th>
                        <th>270.00</th>
                        <th>1,820.00</th>
                    </tr>
                </tbody>
                <!-- القسم الثاني: تكلفة المبيعات -->
                <tbody>
                    <tr class="table-light">
                        <th colspan="8" class="text-start">تكلفة المبيعات</th>
                    </tr>
                    <tr>
                        <td>00003</td>
                        <td>57030</td>
                        <td>17/12/2024</td>
                        <td>فرع 00001</td>
                        <td>محمد الأنصاري</td>
                        <td>0.00</td>
                        <td>1,020.00</td>
                        <td>1,020.00</td>
                    </tr>
                    <tr>
                        <td>00004</td>
                        <td>57031</td>
                        <td>17/12/2024</td>
                        <td>فرع 00002</td>
                        <td>عبدالله القحطاني</td>
                        <td>1,550.00</td>
                        <td>0.00</td>
                        <td>1,550.00</td>
                    </tr>
                    <tr>
                        <th colspan="5">الإجمالي</th>
                        <th>1,550.00</th>
                        <th>1,020.00</th>
                        <th>2,570.00</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>



@endsection