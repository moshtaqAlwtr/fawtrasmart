@extends('master')

@section('title')
سندات القبض حسب البائع
@stop

@section('content')

<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">سندات القبض حسب البائع</h2>
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
        <div class="card-header bg-primary text-white text-center">
            <h5 class="mb-0">البحث</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="">
                <!-- الصف الأول -->
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="branch" class="form-label">خزينة</label>
                        <select id="branch" class="form-control">
                            <option>الكل</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="status" class="form-label">البائع</label>
                        <select id="status" class="form-control">
                            <option>الكل</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="purchase_from" class="form-label">تاريخ من</label>
                        <input type="date" id="purchase_from" class="form-control">
                    </div>
                </div>

                <!-- الصف الثاني -->
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="purchase_to" class="form-label">تاريخ إلى</label>
                        <input type="date" id="purchase_to" class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="account_type" class="form-label">الحساب الفرعي</label>
                        <select id="account_type" class="form-control">
                            <option>الكل</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="branch_sub" class="form-label">فرع</label>
                        <select id="branch_sub" class="form-control">
                            <option>الكل</option>
                        </select>
                    </div>
                </div>

                <!-- الصف الثالث -->
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="group_by" class="form-label">تجميع حسب</label>
                        <select id="group_by" class="form-control">
                            <option>يومياً</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="currency" class="form-label">العملة</label>
                        <select id="currency" class="form-control">
                            <option>الكل</option>
                        </select>
                    </div>
                    
                    <div class="col-md-4 mb-3"></div> <!-- فراغ لتنسيق الأعمدة -->
                </div>

                <!-- أزرار البحث والإلغاء -->
                <div class="form-actions text-end mt-3">
                    <button type="submit" class="btn btn-primary me-2 waves-effect waves-light">بحث</button>
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
<div class="card mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white text-center">
            <h5 class="mb-0">سندات القبض - تجميع حسب البائع</h5>
        </div>
        <div class="card-body">
            <p class="mb-1">الوقت: 19/12/2024 01:49</p>
            <p>التاريخ من: 19/11/2024 | التاريخ إلى: 19/12/2024</p>
            <p class="mb-0 fw-bold">مؤسسة أعمال خاصة للتجارة</p>
            <p class="mb-0">الرياض</p>
            <p class="mb-0">الرياض، الرياض</p>
            <div class="table-responsive mt-4">
                <table class="table table-bordered table-striped text-center">
                    <thead class="bg-light">
                        <tr>
                            <th>التصنيف</th>
                            <th>الكود</th>
                            <th>التاريخ</th>
                            <th>خزينة</th>
                            <th>البائع</th>
                            <th>الحساب الفرعي</th>
                            <th>فرع</th>
                            <th>المبلغ</th>
                            <th>الضرائب</th>
                            <th>الإجمالي مع الضريبة (SAR)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- صف التصنيف الأول -->
                        <tr class="table-primary">
                            <td colspan="10" class="text-start fw-bold">محمد العتيبي</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>3</td>
                            <td>24/11/2024</td>
                            <td>Main</td>
                            <td>محمد العتيبي</td>
                            <td>بنزين</td>
                            <td>Main Branch</td>
                            <td>79.00</td>
                            <td>0.00</td>
                            <td>79.00</td>
                        </tr>
                        <!-- المجموع للتصنيف -->
                        <tr>
                            <td colspan="7" class="text-end fw-bold">المجموع</td>
                            <td>79.00</td>
                            <td>0.00</td>
                            <td>79.00</td>
                        </tr>
                    </tbody>
                    <tfoot class="bg-light">
                        <tr>
                            <th colspan="7" class="text-end">الإجماليات</th>
                            <th>79.00 ر.س</th>
                            <th>0.00 ر.س</th>
                            <th>79.00 ر.س</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>







@endsection