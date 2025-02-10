@extends('master')

@section('title')
أرصدة الموردين
@stop


@section('content')


<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">أرصدة الموردين</h2>
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
                    <!-- السطر الأول (التاريخ من / إلى) -->
                    <div class="col-md-6">
                        <label for="date-range-from">التاريخ من:</label>
                        <input type="date" class="form-control" id="date-range-from">
                    </div>
                    <div class="col-md-6">
                        <label for="date-range-to">التاريخ إلى:</label>
                        <input type="date" class="form-control" id="date-range-to">
                    </div>
                </div>

                <div class="row mt-3">
                    <!-- السطر الثاني (الفرع و تجميع حسب) -->
                    <div class="col-md-6">
                        <label for="branch">الفرع</label>
                        <select class="form-control" id="branch">
                            <option>الكل</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="order">تجميع حسب</label>
                        <select class="form-control" id="order">
                            <option>المورد</option>
                        </select>
                    </div>
                </div>

                <!-- السطر الثالث (زر "إخفاء الرصيد صفر") -->
                <div class="row mt-3">
                    <div class="col-md-12 text-center">
                        <input type="checkbox" id="hide-zero-balance"> <label for="hide-zero-balance">إخفاء الرصيد الصفري</label>
                    </div>
                </div>

                <!-- السطر الرابع (زر عرض التقرير) -->
                <div class="row mt-3">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-success">عرض التقرير</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- رسالة لا توجد نتائج -->
        <div class="card-footer bg-light border-0">
            <div class="alert alert-warning text-center mb-0" role="alert">
                لا توجد نتائج تطابق هذه الاختيارات <br>
                قم بتغيير فترة البحث وحاول مجدداً.
            </div>
        </div>
    </div>
</div>

@endsection