@extends('master')

@section('title')
دليل الحسابات العامة
@stop

@section('content')

<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">دليل الحسابات العامة</h2>
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
                                <label for="branch" class="form-label">مستوى الحساب</label>
                                <select id="branch" class="form-control">
                                    <option>الكل</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="status" class="form-label">نوع الحساب</label>
                                <select id="status" class="form-control">
                                    <option>الكل</option>
                                </select>
                            </div>

                       

                            <div class="col-md-4 mb-3">
                                <label for="account_type" class="form-label">عرض كل الحسابات بأستثناء</label>
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
                            <div class="col-md-4 mb-3">
                                <label for="branch_sub" class="form-label">ترتيب حسب</label>
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
        <div class="card-header bg-primary text-white text-center">
            <h5 class="mb-0">دليل الحسابات العامة</h5>
        </div>
        <div class="card-body">
            <div class="text-center mb-3">
                <p class="mb-1">الوقت: 19/12/2024 01:18</p>
                <p class="mb-1 fw-bold">مؤسسة أعمال خاصة للتجارة</p>
                <p class="mb-1">الرياض</p>
                <p class="mb-1">الرياض، الرياض</p>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead class="bg-light">
                        <tr>
                            <th>كود الحساب</th>
                            <th>اسم الحساب</th>
                            <th>نوع الحساب</th>
                            <th>مستوي الحساب</th>
                            <th>مركز التكلفة</th>
                            <th>فرع الحساب</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td>دائن</td>
                            <td>حساب فرعي</td>
                            <td>كل الفروع</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>دائن</td>
                            <td>حساب رئيسي</td>
                            <td>كل الفروع</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>الأصول</td>
                            <td>مدين</td>
                            <td>حساب رئيسي</td>
                            <td>كل الفروع</td>
                        </tr>
                        <tr>
                            <td>11</td>
                            <td>الأصول الثابتة</td>
                            <td>مدين</td>
                            <td>حساب رئيسي</td>
                            <td>كل الفروع</td>
                        </tr>
                        <tr>
                            <td>112</td>
                            <td>الأجهزة والمعدات</td>
                            <td>مدين</td>
                            <td>حساب رئيسي</td>
                            <td>كل الفروع</td>
                        </tr>
                        <tr>
                            <td>11201</td>
                            <td>113004-معدات معمل</td>
                            <td>مدين</td>
                            <td>حساب فرعي</td>
                            <td>كل الفروع</td>
                        </tr>
                        <tr>
                            <td>11202</td>
                            <td>113005-بوكسات العطور</td>
                            <td>مدين</td>
                            <td>حساب فرعي</td>
                            <td>كل الفروع</td>
                        </tr>
                        <tr>
                            <td>11203</td>
                            <td>عدد وادوات متنوع</td>
                            <td>مدين</td>
                            <td>حساب فرعي</td>
                            <td>كل الفروع</td>
                        </tr>
                        <tr>
                            <td>113</td>
                            <td>وسائل النقل</td>
                            <td>مدين</td>
                            <td>حساب رئيسي</td>
                            <td>كل الفروع</td>
                        </tr>
                        <tr>
                            <td>114</td>
                            <td>مباني</td>
                            <td>مدين</td>
                            <td>حساب رئيسي</td>
                            <td>كل الفروع</td>
                        </tr>
                        <tr>
                            <td>115</td>
                            <td>أراضي</td>
                            <td>مدين</td>
                            <td>حساب رئيسي</td>
                            <td>كل الفروع</td>
                        </tr>
                        <tr>
                            <td>116</td>
                            <td>113003-برامج واجهزه</td>
                            <td>مدين</td>
                            <td>حساب فرعي</td>
                            <td>كل الفروع</td>
                        </tr>
                        <tr>
                            <td>117</td>
                            <td>اثاث مكتب</td>
                            <td>مدين</td>
                            <td>حساب رئيسي</td>
                            <td>كل الفروع</td>
                        </tr>
                        <tr>
                            <td>11701</td>
                            <td>اثاث مكتب</td>
                            <td>مدين</td>
                            <td>حساب فرعي</td>
                            <td>كل الفروع</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>






@endsection