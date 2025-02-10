@extends('master')

@section('title')

دليل الموردين
@stop


@section('content')


<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">دليل الموردين</h2>
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
                    <!-- السطر الأول -->
                    <div class="col-md-6">
                        <label for="text">المدينة</label>
                        <input type="text" class="form-control" id="text" placeholder="ادخل المدينة">
                    </div>
                    <div class="col-md-6">
                        <label for="supplier">البلد:</label>
                        <input type="text" class="form-control" id="supplier" placeholder="ادخل البلد">
                    </div>
                </div>

                <div class="row mt-3">
                    <!-- السطر الثاني -->
                    <div class="col-md-6">
                        <label for="text">فرع</label>
                        <select class="form-control" id="text">
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

                <!-- السطر الثالث لزر "عرض التقرير" -->
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



<!-- إضافة رابط الجافاسكربت الخاص بـ Bootstrap Datepicker -->


<script>
    // تفعيل الـ Datepicker على حقل الفترة
    $('#date-range').datepicker({
        format: 'dd/mm/yyyy',
        startView: 1,
        minViewMode: 0,
        autoclose: true
    });
</script>


@endsection