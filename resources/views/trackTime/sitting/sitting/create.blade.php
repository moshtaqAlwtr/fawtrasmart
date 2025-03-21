@extends('master')

@section('title')
    اعدادات تتبع الوقت
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">اعدادات تتبع الوقت</h2>
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




    <div class="content-body">
        <div class="container-fluid">

            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <label> اعدادات متابعة الوقت <span style="color: red"></span> </label>
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
            <div class="card">
                <div class="card-content">


                    <div class="card-body">
                        <form class="form">
                            <div class="form-body row">
                                <div class="d-flex flex-wrap gap-3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" readonly id="project"
                                            style="width: 1.5em; height: 1.5em; margin-bottom: 20px;">
                                        <label class="form-check-label fs-5" for="project" style="margin-bottom: 20px;">
                                            حساب تتبع الوقت في تقرير المصروفات، وتقرير الربح والخسارة وتقارير مالية أخري?
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-body row">

                                <div class="form-group col-md-3">
                                    <label for="feedback2" class="" style="margin-bottom: 10px"> اول يوم الاسبوع:</label>
                                    <select name="project_id" class="form-control select2">
                                        <option value=""> الاحد </option>
                                        <option value="1"> الاثنين </option>
                                        <option value="2"> الثلاثاء </option>
                                        <option value="3"> الاربعاء </option>
                                        <option value="4"> الخميس </option>
                                        <option value="5"> الجمعه </option>
                                        <option value="6"> السبت </option>


                                    </select>
                                </div>


                                </div>
                                    <div class="form-body row">
                                        <div class="form-group col-md-3">
                                            <label for="feedback2" class="" style="margin-bottom: 10px">معدل ساعة الأدمن ( محمد العتيبي )
                                            </label>
                                            <input type="text" id="feedback2" class="form-control" placeholder="">
                                        </div>
                                    </div>






                        </form>

                    </div>

                </div>

            </div>


            <!-- Modal delete -->



        </div>
    </div>
    </div>
@endsection
@section('scripts')

@endsection
