@extends('master')

@section('title')
مراكز التكلفة
@stop

@section('content')

<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">مراكز التكلفة</h2>
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
                                <label for="branch" class="form-label">مركز التكلفة الرئيسي</label>
                                <select id="branch" class="form-control">
                                    <option>الكل</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="status" class="form-label">مركز التكلفة الفرعي</label>
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
                                <label for="account_type" class="form-label">نوع الحساب</label>
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
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">تقرير مراكز التكلفة</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead class="bg-light">
                        <tr>
                            <th>المعرف</th>
                            <th>التاريخ</th>
                            <th>الحساب الفرعي</th>
                            <th>رقم القيد</th>
                            <th>الوصف</th>
                            <th>نسبة</th>
                            <th>العملية مدين</th>
                            <th>العملية دائن</th>
                            <th>الرصيد مدين</th>
                            <th>الرصيد دائن</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>12/12/2024</td>
                            <td>41</td>
                            <td>48733</td>
                            <td>فاتورة #09131 مبيعات</td>
                            <td>100%</td>
                            <td>0.00</td>
                            <td>216.00</td>
                            <td>0.00</td>
                            <td>216.00</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>14/12/2024</td>
                            <td>41</td>
                            <td>48736</td>
                            <td>فاتورة #09132 مبيعات</td>
                            <td>100%</td>
                            <td>0.00</td>
                            <td>15.65</td>
                            <td>0.00</td>
                            <td>231.65</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>14/12/2024</td>
                            <td>41</td>
                            <td>48738</td>
                            <td>فاتورة #09133 مبيعات</td>
                            <td>100%</td>
                            <td>0.00</td>
                            <td>126.00</td>
                            <td>0.00</td>
                            <td>357.65</td>
                        </tr>
                        <!-- يمكنك إضافة المزيد من الصفوف حسب الحاجة -->
                        <tr>
                            <td colspan="6" class="text-end fw-bold">المجموع</td>
                            <td>0.00</td>
                            <td>7,199.65</td>
                            <td>0.00</td>
                            <td>7,199.65</td>
                        </tr>
                    </tbody>
                    <tfoot class="bg-light">
                        <tr>
                            <th colspan="6" class="text-end">الإجمالي</th>
                            <th>0.00</th>
                            <th>7,199.65</th>
                            <th>0.00</th>
                            <th>7,199.65</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>





@endsection