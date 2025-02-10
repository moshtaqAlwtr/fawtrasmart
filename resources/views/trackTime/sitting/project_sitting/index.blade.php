@extends('master')

@section('title')
    المشاريع تتبع الوقت
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0"> مشاريع تتبع الوقت</h2>
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
                            <label> المشاريع <span style="color: red"></span> </label>
                        </div>

                        <div>

                            <a  href="{{ route('ProjectTrackTime.create') }}" class="btn btn-outline-primary">
                                <i class="fa fa-save"></i>اضافة مشروع
                            </a>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <h4 class="card-title">بحث</h4>
                    </div>

                    <div class="card-body">
                        <form class="form">
                            <div class="form-body row">

                                <div class="form-group col-md-4">
                                    <label for="feedback2" class=""> الاسم</label>
                                    <input type="email" id="feedback2" class="form-control" placeholder=" الاسم   "
                                        name="email">
                                </div>

                            </div>


                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary mr-1 waves-effect waves-light">بحث</button>


                                <button type="reset" class="btn btn-outline-warning waves-effect waves-light">الغاء الفلتر
                                </button>
                            </div>
                        </form>

                    </div>

                </div>

            </div>
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="width: 20px">
                                    <input type="checkbox" class="form-check-input">
                                </th>
                                <th>الرقم التعريفي</th>
                                <th>الاسم</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input type="checkbox" class="form-check-input">
                                </td>
                                <td>1</td>
                                <td>General</td>
                                <td>لا</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="#" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                            تعديل
                                        </a>
                                        <a href="#" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                            حذف
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="d-flex align-items-center gap-2">
                            <span>1-1 من 1 النتائج المعروضة</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash"></i>
                                حذف للمحدد
                            </button>
                            <button class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    </div>
@endsection
