@extends('master')

@section('title')
أعمار الديون
@stop


@section('content')


<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">أعمار الديون (حساب الأستاذ )</h2>
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
                 
                    <div class="col-md-6">
                        <label for="days">الفترة (أيام):</label>
                        <input type="number" class="form-control" id="days" placeholder="أدخل عدد الأيام">
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
                        <label for="order">المورد</label>
                        <select class="form-control" id="order">
                            <option>المورد</option>
                        </select>
                    </div>
                </div>

                <!-- السطر الثالث (زر "إخفاء الرصيد صفر") -->
               

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