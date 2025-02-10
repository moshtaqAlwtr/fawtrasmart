@extends('master')

@section('title')
    ادارة الاستهلاك والارصدة
@stop

@section('content')
    <div style="font-size: 1.1rem;">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0"> ادارة الاستهلاك والارصدة </h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                                <li class="breadcrumb-item active">عرض</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-body">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">


                        <div class="d-flex align-items-center gap-3">
                            <div class="btn-group">
                                <button class="btn btn-light border">
                                    <i class="fa fa-chevron-right"></i>
                                </button>
                                <button class="btn btn-light border">
                                    <i class="fa fa-chevron-left"></i>
                                </button>
                            </div>
                            <span class="mx-2">1 - 1 من 1</span>
                            <div class="input-group" style="width: 150px">
                                <input type="text" class="form-control text-center" value="صفحة 1 من 1">
                            </div>

                        </div>
                        <div class="d-flex" style="gap: 15px">
                            <a href="{{ route('ManagingBalanceConsumption.create') }}" class="btn btn-success">
                                <i class="fa fa-plus me-2"></i>
                                اضف استخدام رصيد
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
                                <div class="form-group col-md-6">
                                    <label for="feedback1" class=""> البحث بواسطة العميل   </label>
                                    <input type="text" id="feedback1" class="form-control"
                                        placeholder="البحث بواسطة العميل  " name="name">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="feedback1" class=""> البحث بواسطة اسم الرصيد  او الرقم التعريفي </label>
                                    <input type="text" id="feedback1" class="form-control"
                                        placeholder="البحث بواسطة اسم الرصيد  او الرقم التعريفي" name="name">
                                </div>


                            </div>
                            <div class="form-body row">
                                <!-- Row 1 -->
                                <div class="form-group col-md-3">
                                    <label> تاريخ  الاستهلاك(من )</label>
                                    <input type="date" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label> تاريخ الاستهلاك(الى  )</label>
                                    <input type="date" class="form-control">
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

                    <table class="table" style="font-size: 1.1rem;">
                        <thead>
                            <tr>
                                <th>معرف الاستهلاك</th>
                                <th>بيانات العميل </th>
                                <th>نوع الرصيد</th>


                                <th>تاريخ الاستهلاك</th>
                                <th>الرصيد المستخدم</th>
                                <th>ترتيب بواسطة</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#1</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar avatar-sm bg-danger">
                                            <span class="avatar-content">أ</span>
                                        </div>
                                        <div>
                                            أسواق السلطان
                                            <br>
                                            <small class="text-muted">#123234</small>
                                        </div>
                                    </div>
                                </td>
                                <td>نقاط الولاء<br><small class="text-muted">#1</small></td>

                                <td>
                                    <div class="text-muted">12-12-2024</div>

                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-info" style="width: 8px; height: 8px;"></div>
                                        <span class="text-muted">10</span>
                                        <span class="text-muted">نقطة</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <div class="dropdown">
                                            <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1 btn-sm"
                                                type="button"id="dropdownMenuButton303" data-toggle="dropdown"
                                                aria-haspopup="true"aria-expanded="false"></button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton303">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('ManagingBalanceConsumption.show', 1) }}">
                                                        <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('ManagingBalanceConsumption.edit', 1) }}">
                                                        <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                    </a>
                                                </li>

                                                <li>
                                                    <a class="dropdown-item text-danger" href="#" data-toggle="modal"
                                                        data-target="#modal_DELETE">
                                                        <i class="fa fa-trash me-2"></i>حذف
                                                    </a>
                                                </li>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>




        @endsection
