@extends('master')

@section('title')
المصروفات السنويه
@stop

@section('content')

<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">المصروفات السنويه</h2>
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
                            <option>سنوي</option>
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
            <h5 class="mb-0">المصروفات - تجميع سنوي</h5>
        </div>
        <div class="card-body">
            <div class="text-center mb-3">
                <p class="mb-1">الوقت: 19/12/2024 01:22</p>
                <p class="mb-1">التاريخ من: 19/11/2024 | التاريخ إلى: 19/12/2024 |</p>
                <p class="mb-1 fw-bold">مؤسسة أعمال خاصة للتجارة</p>
                <p class="mb-1">الرياض</p>
                <p class="mb-1">الرياض، الرياض</p>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead class="bg-light">
                        <tr>
                            <th>الكود</th>
                            <th>التاريخ</th>
                            <th>خزينة</th>
                            <th>التصنيف</th>
                            <th>البائع</th>
                            <th>الحساب الفرعي</th>
                            <th>موظف</th>
                            <th>ملاحظة</th>
                            <th>فرع</th>
                            <th>المبلغ</th>
                            <th>الضرائب</th>
                            <th>الإجمالي مع الضريبة (SAR)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="12" class="bg-light text-start fw-bold">2023 سنة</td>
                        </tr>
                        <tr>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td colspan="9" class="text-end fw-bold">المجموع</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td colspan="12" class="bg-light text-start fw-bold"> سنة 2024</td>
                        </tr>
                        <tr>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td colspan="9" class="text-end fw-bold">المجموع</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>






@endsection