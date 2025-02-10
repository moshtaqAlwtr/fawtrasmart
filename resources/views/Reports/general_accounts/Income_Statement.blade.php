@extends('master')

@section('title')
قائمة الدخل
@stop


@section('content')




<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">قائمة الدخل</h2>
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
    <div class="card-body">
        <div class="d-flex justify-content-right align-items-center gap-2 flex-wrap">
            <!-- زر شهري -->
            <button type="button" class="btn btn-outline-success">
                <i class="fa fa-calendar"></i> شهري
            </button>
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



    <div class="card shadow-sm p-3 mb-5 bg-body rounded">
        <h5 class="card-title mb-3">Filters</h5>
        <form>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="dateFrom" class="form-label">الفترة من / إلى:</label>
                    <input type="text" id="dateFrom" class="form-control" placeholder="الفترة من / إلى">
                </div>
                <div class="col-md-4">
                        <label for="account">فرع الحسابات:</label>
                        <select class="form-control" id="account">
                            <option>أختر</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="journal">فرع القيود:</label>
                        <select class="form-control" id="journal">
                            <option> أختر</option>
                        </select>
                    </div>
                
            </div>
            <div class="row mb-3">
            <div class="col-md-4">
                        <label for="measure">المستويات:</label>
                        <select class="form-control" id="measure">
                            <option>أختر مستوى </option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="">مراكز التكلفة:</label>
                        <select class="form-control" id="">
                            <option> أختر مركز</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="account">عرض جميع الحسابات:</label>
                        <select class="form-control" id="account">
                            <option>الكل </option>
                        </select>
                    </div>
            </div>
            <button type="submit" class="btn btn-primary">عرض التقرير</button>
        </form>
    </div>
   
        <!-- البطاقة الرئيسية -->
        <div class="card shadow">
            <div class="card-header bg-primary text-white text-center">
                <h4>📋 مؤسسة أعمال خاصة للتجارة</h4>
                <h5>قائمة الدخل - بتاريخ 17/12/2024</h5>
            </div>
            <div class="card-body">
                <!-- المعلومات الأساسية -->
                <p><strong>📌 الفرع:</strong> كل الفروع</p>
                <p><strong>📌 السنة المالية:</strong> جميع السنوات</p>
                <p><strong>📌 مراكز التكلفة:</strong> كل مراكز التكلفة</p>

                <!-- الإيرادات -->
                <h5 class="mt-4">الإيرادات</h5>
                <table class="table table-bordered">
                    <thead class="table-success">
                        <tr>
                            <th>رقم الحساب</th>
                            <th>اسم الحساب</th>
                            <th>المبلغ (ر.س)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>41</td>
                            <td>المبيعات</td>
                            <td>1,800</td>
                        </tr>
                        <tr>
                            <td>42</td>
                            <td>المرتجعات</td>
                            <td>-270</td>
                        </tr>
                        <tr>
                            <td>43</td>
                            <td>إيرادات أخرى</td>
                            <td>0.00</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="table-info">
                            <td colspan="2" class="text-end"><strong>إجمالي الإيرادات</strong></td>
                            <td><strong>1,530 ر.س</strong></td>
                        </tr>
                    </tfoot>
                </table>

                <!-- المصروفات -->
                <h5 class="mt-4">المصروفات</h5>
                <table class="table table-bordered">
                    <thead class="table-danger">
                        <tr>
                            <th>رقم الحساب</th>
                            <th>اسم الحساب</th>
                            <th>المبلغ (ر.س)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>35</td>
                            <td>تكلفة المبيعات</td>
                            <td>1,530</td>
                        </tr>
                        <tr>
                            <td>31</td>
                            <td>مصروفات أخرى</td>
                            <td>0.00</td>
                        </tr>
                        <tr>
                            <td>32</td>
                            <td>مصروفات الإهلاك</td>
                            <td>0.00</td>
                        </tr>
                        <!-- يمكنك إضافة المزيد من المصروفات هنا -->
                    </tbody>
                    <tfoot>
                        <tr class="table-warning">
                            <td colspan="2" class="text-end"><strong>إجمالي المصروفات</strong></td>
                            <td><strong>1,530 ر.س</strong></td>
                        </tr>
                    </tfoot>
                </table>

                <!-- صافي الدخل -->
                <h5 class="mt-4 text-center">📊 <strong>صافي الدخل: 0.00 ر.س</strong></h5>
            </div>
            <div class="card-footer text-center bg-light">
                <small>📆 تاريخ إعداد التقرير: 17 ديسمبر 2024 | 📝 مؤسسة أعمال خاصة للتجارة</small>
            </div>
        </div>

    @endsection
