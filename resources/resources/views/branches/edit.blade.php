@extends('master')

@section('title')
تعديل فرع
@stop

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">تعديل فرع</h2>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">الرئيسيه</a></li>
                        <li class="breadcrumb-item active">تعديل</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>


<form action="{{ route('branches.update', $branch->id) }}" method="POST" >
            @csrf
            @method('PUT')
            <!-- عرض الأخطاء -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
            </div>
            <div>
                <a href="{{ route('branches.index') }}" class="btn btn-outline-danger">
                    <i class="fa fa-ban"></i>الغاء
                </a>
                <button type="submit" class="btn btn-outline-primary">
                    <i class="fa fa-save"></i> حفظ
                </button>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <h5 class="card-title text-center">بيانات الفرع</h5>
       
            <!-- الحقول -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">الاسم <span style="color: red">*</span></label>
                    <input type="text" id="name" name="name" value="{{ $branch->name ?? '' }}" class="form-control" placeholder="اسم الفرع" required>
                </div>
                <div class="col-md-6">
    <label for="code" class="form-label">الكود <span style="color: red">*</span></label>
    <input 
        type="text" 
        id="code" 
        name="code" 
        class="form-control" 
        value="{{ old('code', $branch->code) }}" 
        @if(isset($branch->code)) readonly @endif 
        @if(!isset($branch->code)) required @endif>
</div>


            </div>
            <!-- باقي الحقول -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="phone" class="form-label">الهاتف</label>
                    <input type="text" id="phone" name="phone" class="form-control" placeholder="رقم الهاتف" value="{{ $branch->phone ?? '' }}">
                </div>
                <div class="col-md-6">
                    <label for="mobile" class="form-label">جوال</label>
                    <input type="text" id="mobile" name="mobile" class="form-control" placeholder="رقم الجوال" value="{{ $branch->mobile ?? '' }}">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="address1" class="form-label">العنوان 1</label>
                    <input type="text" id="address1" name="address1" class="form-control" placeholder="العنوان الأول" value="{{ $branch->address1 ?? '' }}">
                </div>
                <div class="col-md-6">
                    <label for="address2" class="form-label">العنوان 2</label>
                    <input type="text" id="address2" name="address2" class="form-control" placeholder="العنوان الثاني">
                </div>
            </div>
            <!-- مدينة وبلد -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="city" class="form-label">المدينة</label>
                    <input type="text" id="city" name="city" class="form-control" placeholder="المدينة" required>
                </div>
                <div class="col-md-4">
                    <label for="region" class="form-label">المنطقة</label>
                    <input type="text" id="region" name="region" class="form-control" placeholder="المنطقة">
                </div>
                <div class="col-md-4">
                    <label for="country" class="form-label">البلد</label>
                    <input type="text" id="country" name="country" class="form-control" placeholder="البلد" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="work_hours" class="form-label">ساعات العمل</label>
                    <textarea id="work_hours" name="work_hours" class="form-control" rows="2" placeholder="أدخل ساعات العمل"></textarea>
                </div>
                <div class="col-md-6">
                    <label for="description" class="form-label">الوصف</label>
                    <textarea id="description" name="description" class="form-control" rows="2" placeholder="الوصف"></textarea>
                </div>
            </div>

            <div class="col-12 mb-3">
                <button type="button" class="btn btn-outline-primary mb-2" onclick="toggleMap()">
                    <i class="feather icon-map"></i> إظهار الخريطة
                </button>
                <div id="map-container" style="display: none;">
                    <div id="map" style="height: 400px; width: 100%;"></div>
                </div>
            </div>

    </div>
    </form>
</div>
@endsection
