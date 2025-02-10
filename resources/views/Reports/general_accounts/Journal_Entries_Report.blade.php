@extends('master')

@section('title')
تقرير حركة القيود
@stop

@section('content')

<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">تقرير حركة القيود</h2>
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
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">البحث</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="">
                        <div class="row">
                            <!-- كل 3 حقول في سطر -->
                            <div class="col-md-4 mb-3">
                                <label for="branch" class="form-label">المصدر  </label>
                                <select id="branch" class="form-control">
                                    <option>الكل</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="status" class="form-label">الحساب الفرعي</label>
                                <select id="status" class="form-control">
                                    <option>الكل</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="purchase_from" class="form-label">تاريخ من</label>
                                <input type="date" id="purchase_from" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="purchase_to" class="form-label">تاريخ إلى</label>
                                <input type="date" id="purchase_to" class="form-control">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="account_type" class="form-label">تجميع حسب </label>
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
<div class="card mt-5">
    <!-- Header -->
    <div class="card mb-4">
      
           
        </div>
        <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
    <h5 class="mb-0">حركات القيود - تجميع حسب قيد</h5>
    <p class="mb-1">الوقت: 19/12/2024 00:56</p>
    <p>التاريخ من: 19/11/2024 | التاريخ إلى: 19/12/2024 |</p>
    <p class="mb-0 fw-bold">مؤسسة أعمال خاصة للتجارة</p>
    <p class="mb-0">الرياض</p>
    <p class="mb-0">الرياض، الرياض</p>
</div>

    </div>

    <!-- جدول الحركات -->
    <div class="card- mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white text-center">
            <h5 class="mb-0">تقرير حركات القيود - تجميع حسب قيد</h5>
        </div>
        <div class="card-body text-center">
            <p class="mb-1">الوقت: 19/12/2024 00:56</p>
            <p>التاريخ من: 19/11/2024 | التاريخ إلى: 19/12/2024 |</p>
            <p class="mb-0 fw-bold">مؤسسة أعمال خاصة للتجارة</p>
            <p class="mb-0">الرياض</p>
            <p class="mb-0">الرياض، الرياض</p>
        </div>

        <!-- الجدول -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center">
                <thead class="bg-light">
                    <tr>
                        <th>التاريخ</th>
                        <th>رقم</th>
                        <th>الحساب</th>
                        <th>كود الحساب</th>
                        <th>الوصف</th>
                        <th>المصدر</th>
                        <th>فرع</th>
                        <th>مدين</th>
                        <th>دائن</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- قيد 00001 -->
                    <tr class="bg-secondary text-white">
                        <td colspan="9">قيد رقم: 00001</td>
                    </tr>
                    <tr>
                        <td>16/12/2024</td>
                        <td>000002</td>
                        <td>عميل نقدي</td>
                        <td>125952</td>
                        <td>فاتورة #00001</td>
                        <td>فاتورة</td>
                        <td>فرع الغربية</td>
                        <td>270.00</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>16/12/2024</td>
                        <td>000002</td>
                        <td>المبيعات</td>
                        <td>41</td>
                        <td>فاتورة #00001 مبيعات</td>
                        <td>فاتورة</td>
                        <td>فرع الغربية</td>
                        <td>0.00</td>
                        <td>270.00</td>
                    </tr>
                    <tr class="fw-bold">
                        <td colspan="7" class="text-end">المجموع</td>
                        <td>270.00</td>
                        <td>270.00</td>
                    </tr>

                    <!-- قيد 00002 -->
                    <tr class="bg-secondary text-white">
                        <td colspan="9">قيد رقم: 00002</td>
                    </tr>
                    <tr>
                        <td>16/12/2024</td>
                        <td>000003</td>
                        <td>تكلفة المبيعات</td>
                        <td>35</td>
                        <td>تكلفة مبيعات - فاتورة #00001</td>
                        <td>قيد يدوي</td>
                        <td>فرع الغربية</td>
                        <td>270.00</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>16/12/2024</td>
                        <td>000003</td>
                        <td>مستودع راكان الخشابي</td>
                        <td>12307</td>
                        <td>تكلفة مبيعات - فاتورة #00001</td>
                        <td>قيد يدوي</td>
                        <td>فرع الغربية</td>
                        <td>0.00</td>
                        <td>270.00</td>
                    </tr>
                    <tr class="fw-bold">
                        <td colspan="7" class="text-end">المجموع</td>
                        <td>270.00</td>
                        <td>270.00</td>
                    </tr>

                    <!-- قيد 00003 -->
                    <tr class="bg-secondary text-white">
                        <td colspan="9">قيد رقم: 00003</td>
                    </tr>
                    <tr>
                        <td>16/12/2024</td>
                        <td>000004</td>
                        <td>عميل نقدي</td>
                        <td>125952</td>
                        <td>فاتورة مرتجعة #00001</td>
                        <td>فاتورة مرتجعة</td>
                        <td>فرع الغربية</td>
                        <td>0.00</td>
                        <td>270.00</td>
                    </tr>
                    <tr>
                        <td>16/12/2024</td>
                        <td>000004</td>
                        <td>المرتجعات</td>
                        <td>42</td>
                        <td>فاتورة مرتجعة #00001 returns</td>
                        <td>فاتورة مرتجعة</td>
                        <td>فرع الغربية</td>
                        <td>270.00</td>
                        <td>0.00</td>
                    </tr>
                    <tr class="fw-bold">
                        <td colspan="7" class="text-end">المجموع</td>
                        <td>270.00</td>
                        <td>270.00</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>






@endsection