@extends('master')

@section('title')
مشتريات الموردين
@stop


@section('content')


<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">مشتريات الموردين</h2>
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
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-body">
            <!-- نموذج البحث -->
            <form>
                <div class="row">
                    <!-- السطر الأول (التاريخ من / إلى / الحساب) -->
                    <div class="col-md-4">
                        <label for="date-from">التاريخ من:</label>
                        <input type="text" class="form-control" id="date-from" placeholder="اختر التاريخ من">
                    </div>
                    <div class="col-md-4">
                        <label for="date-to">التاريخ إلى:</label>
                        <input type="text" class="form-control" id="date-to" placeholder="اختر التاريخ إلى">
                    </div>
                    <div class="col-md-4">
                        <label for="account">الحساب:</label>
                        <select class="form-control" id="account">
                            <option>اختر الحساب</option>
                            <option>حساب 1</option>
                            <option>حساب 2</option>
                        </select>
                    </div>
                </div>

                <div class="row mt-4">
                    <!-- السطر الثاني (أضيفت بواسطة / فرع القيود / عرض جميع الحسابات / مركز التكلفة) -->
                    <div class="col-md-4">
                        <label for="added-by">أضيفت بواسطة:</label>
                        <input type="text" class="form-control" id="added-by" placeholder="أدخل اسم الشخص الذي أضاف">
                    </div>
                    <div class="col-md-4">
                        <label for="branch">فرع القيود:</label>
                        <select class="form-control" id="branch">
                            <option>اختر الفرع</option>
                            <option>فرع 1</option>
                            <option>فرع 2</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="all-accounts">عرض جميع الحسابات:</label>
                        <select class="form-control" id="all-accounts">
                            <option>نعم</option>
                            <option>لا</option>
                        </select>
                    </div>
                   
                </div>
                <div class="row mt-4">
                <div class="col-md-4">
                        <label for="cost-center">مركز التكلفة:</label>
                        <select class="form-control" id="cost-center">
                            <option>اختر مركز التكلفة</option>
                            <option>مركز 1</option>
                            <option>مركز 2</option>
                        </select>
                    </div>
                </div>
                <!-- السطر الثالث (زر البحث و إلغاء) -->
                <div class="row mt-3">
                <div class="form-actions">
                        <button type="submit" class="btn btn-primary mr-1 waves-effect waves-light">بحث</button>

                        <button type="reset" class="btn btn-outline-warning waves-effect waves-light">ألغاء</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection