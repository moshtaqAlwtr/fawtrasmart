@extends('master')

@section('title')
أعدادات الفروع
@stop

@section('content')

<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">أعدادات الفروع </h2>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">الرئيسيه</a></li>
                        <li class="breadcrumb-item active">أضافة</li>
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
                <button type="submit" class="btn btn-outline-primary">
                    <i class="fa fa-save"></i> حفظ
                </button>
            </div>
        </div>
    </div>
</div>
<div class="card"> 
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <!-- تسمية الحقل -->
                <label for="name" class="form-label">الفرع الرئيسي</label>

                <!-- حقل الإدخال مع النص داخل الحقل -->
                <input type="text" id="name" name="name" class="form-control" placeholder="الفرعي الرئيسي" required>
            </div>
        </div>
        <div class="col-md-6 mb-3">
                        <div class="vs-checkbox-con vs-checkbox-primary">
                            <input type="checkbox" checked value="false">
                            <span class="vs-checkbox">
                                <span class="vs-checkbox--check">
                                    <i class="vs-icon feather icon-check"></i>
                                </span>
                            </span>
                            <span class="">مشاركة مركز التكلفة بين الفروع </span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="vs-checkbox-con vs-checkbox-primary">
                            <input type="checkbox" checked value="false">
                            <span class="vs-checkbox">
                                <span class="vs-checkbox--check">
                                    <i class="vs-icon feather icon-check"></i>
                                </span>
                            </span>
                            <span class="">مشاركة العملاء بين الفروع</span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="vs-checkbox-con vs-checkbox-primary">
                            <input type="checkbox" checked value="false">
                            <span class="vs-checkbox">
                                <span class="vs-checkbox--check">
                                    <i class="vs-icon feather icon-check"></i>
                                </span>
                            </span>
                            <span class="">مشاركة المنتجات بين الفروع</span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="vs-checkbox-con vs-checkbox-primary">
                            <input type="checkbox" checked value="false">
                            <span class="vs-checkbox">
                                <span class="vs-checkbox--check">
                                    <i class="vs-icon feather icon-check"></i>
                                </span>
                            </span>
                            <span class="">مشاركة الموردين بين الفروع</span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="vs-checkbox-con vs-checkbox-primary">
                            <input type="checkbox" checked value="false">
                            <span class="vs-checkbox">
                                <span class="vs-checkbox--check">
                                    <i class="vs-icon feather icon-check"></i>
                                </span>
                            </span>
                            <span class="">تخصيص الحسابات في شجرة الحسابات لكل فرع</span>
                        </div>
                    </div>
    </div>
</div>


@endsection