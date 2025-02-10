@extends('master')

@section('title')
تقرير التدفقات النقدية 

@stop


@section('content')




<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">التدفقات النقدية </h2>
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
            <a href="{{ route('reports.general_accounts.tacses') }}" class="btn btn-outline-success">
    <i class="fa fa-calendar"></i> تخصيص
</a>

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
<div class="cart mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white text-center">
            <h4>بحث التدفقات النقدية</h4>
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
       

        <!-- تقرير الفترة -->
        <div class="alert alert-info text-center fw-bold">
            
        <h4 class="fw-bold mb-3">مؤسسة أعمال خاصة للتجارة</h4>
                <p class="mb-0">الرياض</p>
                <p>الرياض، الرياض</p>
            تقرير التدفقات النقدية<br>
            Period Beginning : 18/12/2023 | Period Ending : 18/12/2024
        </div>
        <table class="table table-bordered text-center align-middle">
            <!-- التدفق النقدي من العمليات التشغيلية -->
            <thead class="table-primary">
                <tr>
                    <th colspan="2" class="text-start">تدفق النقدية من العمليات</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>صافي الدخل</td>
                    <td>0.00</td>
                </tr>
                <tr>
                    <td>مصروفات الإهلاك</td>
                    <td>0.00</td>
                </tr>
                <tr>
                    <td>زيادة في حسابات العملاء المدينة</td>
                    <td>-1,020</td>
                </tr>
                <tr>
                    <td>زيادة في حسابات الدائنون</td>
                    <td>0.00</td>
                </tr>
                <tr>
                    <td>زيادة في المخزون</td>
                    <td>1,530</td>
                </tr>
            </tbody>
            <tfoot>
                <tr class="table-success fw-bold">
                    <td class="text-start">إجمالي التدفق النقدي من العمليات التشغيلية</td>
                    <td>510.00 ر.س</td>
                </tr>
            </tfoot>

            <!-- التدفق النقدي من الاستثمارات -->
            <thead class="table-secondary">
                <tr>
                    <th colspan="2" class="text-start">التدفق النقدي من الاستثمارات</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>النقد المستلم من بيع الأصول</td>
                    <td>0.00</td>
                </tr>
                <tr>
                    <td>النقد المُنفق لشراء الأصول</td>
                    <td>0.00</td>
                </tr>
            </tbody>
            <tfoot>
                <tr class="table-success fw-bold">
                    <td class="text-start">إجمالي التدفق النقدي من الاستثمارات</td>
                    <td>0.00 ر.س</td>
                </tr>
            </tfoot>

            <!-- التدفق النقدي من التمويل -->
            <thead class="table-warning">
                <tr>
                    <th colspan="2" class="text-start">تدفق النقدية من التمويل</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>زيادة في الأسهم المشتركة</td>
                    <td>0.00</td>
                </tr>
            </tbody>
            <tfoot>
                <tr class="table-success fw-bold">
                    <td class="text-start">إجمالي التدفق النقدي من التمويل</td>
                    <td>0.00 ر.س</td>
                </tr>
            </tfoot>

            <!-- إجمالي التغير في التدفق النقدي -->
            <tfoot>
                <tr class="table-info fw-bold">
                    <td class="text-start">إجمالي التغير في التدفق النقدي</td>
                    <td>510.00 ر.س</td>
                </tr>
            </tfoot>
        </table>
    </div>







@endsection

