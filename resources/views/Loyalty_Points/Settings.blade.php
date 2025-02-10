@extends('master')

@section('title')
الأعدادات
@stop

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">الأعدادات</h2>
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


<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-light">
            الإعدادات
        </div>
        <div class="card-body">
            <form>
                <div class="row mb-3">
                    <div class="col-sm-6">
                        <label for="loyaltyType" class="form-label">نوع رصيد ولاء العملاء <span
                                class="text-danger">*</span></label>
                        <select id="loyaltyType" class="form-control">
                            <option value="">اختيار</option>
                            <option value="points">نقاط الولاء</option>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label for="minPoints" class="form-label">الحد الأدنى من نقاط الاسترداد <span
                                class="text-danger">*</span></label>
                        <input type="number" id="minPoints" class="form-control" placeholder="">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-6">
                        <label for="conversionFactor" class="form-label">معامل التحويل</label>
                        <div class="input-group">
                            <span class="input-group-text">1 نقطة =</span>
                            <input type="number" id="conversionFactor" class="form-control" placeholder="1">
                        </div>
                    </div>
                    <div class="col-sm-6 mt-0 ">
                    <label for="conversionFactor" class="form-label">أتاحة الأرقام العشرية</label>
                        <fieldset>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <div class="vs-checkbox-con">
                                            <input type="checkbox" checked value="false">
                                            <span class="vs-checkbox vs-checkbox-sm">
                                                <span class="vs-checkbox--check">
                                                    <i class="vs-icon feather icon-check"></i>
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <input type="text" class="form-control" aria-label="Text input with checkbox">
                            </div>
                        </fieldset>
                    </div>





                    <p class="text-muted">1 نقطة ولاء = مقدار العملة الأساسية؟</p>
            </form>
        </div>
    </div>
</div>



@endsection