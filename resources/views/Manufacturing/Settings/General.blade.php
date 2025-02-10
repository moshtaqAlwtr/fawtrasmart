@extends('master')

@section('title')
أعدادات عامة 
@stop

@section('content')

<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">أعدادات عامة </h2>
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
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
            </div>

            <div>
                <a href="" class="btn btn-outline-danger">
                    <i class="fa fa-ban"></i>الغاء
                </a>
                <button type="submit" class="btn btn-outline-primary">
                    <i class="fa fa-save"></i>حفظ
                </button>
            </div>

        </div>
    </div>
</div>
<div class="card mt-4">
    <div class="card">
      <div class="card-header bg-light">
        <strong>الإعدادات العامة</strong>
      </div>
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
          <label for="toggleSwitch" class="form-label mb-0">تجاوز الكمية المطلوبة في أمر التصنيع</label>
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="toggleSwitch">
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection