@extends('master')

@section('title')
ايرادات
@stop

@section('css')
<style>
    .ex-card{
        background:#7367F0;
        color: #fff
    }
    .ex-card h2{
        color: #fff
    }
</style>
@endsection

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0"> سندات قبض</h2>
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

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                    </div>

                    <div>
                        <a href="#" class="btn btn-outline-dark">
                            <i class="fas fa-upload"></i>استيراد
                        </a>
                        <a href="{{ route('incomes.create') }}" class="btn btn-outline-primary">
                            <i class="fa fa-plus"></i>سند قبض
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.alerts.error')
        @include('layouts.alerts.success')

        <div class="card ex-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">

                    <div>
                        <p>آخر 7 أيام</p>
                        <h2>ر.س 0.00</h2>
                    </div>

                    <div>
                        <p>آخر 30 يوم</p>
                        <h2>ر.س 0.00</h2>
                    </div>

                    <div>
                        <p>آخر 365 يوم</p>
                        <h2>ر.س 0.00</h2>
                    </div>

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="card-title">

                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>بحث</div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form class="form" method="GET" action="{{ route('products.search') }}">
                        <div class="form-body row">
                            <div class="form-group col-md-4">
                                <label for="">البحث بكلمة مفتاحية</label>
                                <input type="text" class="form-control" placeholder="ادخل الإسم او الكود"name="keywords">
                            </div>

                            <div class="form-group col-2">
                                <label for="">من تاريخ</label>
                                <input type="date" class="form-control" name="from_date">
                            </div>

                            <div class="form-group col-2">
                                <label for="">الي تاريخ</label>
                                <input type="date" class="form-control"  name="to_date">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="">التصنيف</label>
                                <select name="category" class="form-control" id="">
                                    <option value=""> جميع التصنيفات</option>
                                    <option value="1">منتج</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <select class="form-control" name="status">
                                    <option value="">الحالة</option>
                                    <option value="1">نشط</option>
                                    <option value="2">متوقف</option>
                                    <option value="3">غير نشط</option>
                                </select>
                            </div>

                        </div>
                        <!-- Hidden Div -->
                        <div class="collapse" id="advancedSearchForm">
                            <div class="form-body row">

                                <div class="form-group col-md-4">
                                    <label for="">الوصف</label>
                                    <input type="text" class="form-control" name="keywords">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="">البائع</label>
                                    <select class="form-control" name="status">
                                        <option value="">اي بائع</option>
                                        <option value="1">بائع 1</option>
                                        <option value="2">بائع 2</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="">اكبر مبلغ</label>
                                    <input type="text" class="form-control" name="keywords">
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="">اقل مبلغ</label>
                                    <input type="text" class="form-control" name="keywords">
                                </div>

                                <div class="form-group col-2">
                                    <label for="">من (تاريخ الانشاء)</label>
                                    <input type="date" class="form-control" name="from_date">
                                </div>

                                <div class="form-group col-2">
                                    <label for="">الى (تاريخ الانشاء)</label>
                                    <input type="date" class="form-control"  name="to_date">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="">الحساب الفرعي</label>
                                    <select class="form-control" name="status">
                                        <option value="">اي حساب</option>
                                        <option value="1">حساب 1</option>
                                        <option value="2">حساب 2</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="">اضيفت بواسطه</label>
                                    <select class="form-control" name="status">
                                        <option value="">اي موظف</option>
                                        <option value="1">اي موظف</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary mr-1 waves-effect waves-light">بحث</button>

                            <a class="btn btn-outline-secondary ml-2 mr-2" data-toggle="collapse"
                                data-target="#advancedSearchForm">
                                <i class="bi bi-sliders"></i> بحث متقدم
                            </a>
                            <a href="{{ route('incomes.index') }}" class="btn btn-outline-danger waves-effect waves-light">الغاء الفلترة</a>
                        </div>
                    </form>

                </div>

            </div>
        </div>

        <div class="card">
            <div class="card-header">النتائج</div>
            <div class="card-body">
                @if (@isset($incomes) && !@empty($incomes) && count($incomes) > 0)
                    <table class="table">
                        <tbody>
                            @foreach ($incomes as $income)
                                <tr>
                                    <td style="width: 80%">
                                        <p><strong>{{ $income->seller }}</strong></p>
                                        <p><small>{{ $income->date }} | {{ $income->description }}</small></p>
                                        <img src="{{ asset('assets/uploads/incomes/'.$income->attachments) }}" alt="img" width="100"><br>
                                        <i class="fa fa-user"></i> <small>اضيفت بواسطة :</small> <strong>ابو فالح</strong>
                                    </td>
                                    <td>
                                        <p><strong>{{ $income->amount }} رس</strong></p>
                                        <i class="fa fa-archive"></i> <small>{{ $income->store_id }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <div class="dropdown">
                                                <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1" type="button"id="dropdownMenuButton303" data-toggle="dropdown" aria-haspopup="true"aria-expanded="false"></button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton303">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('incomes.show',$income->id) }}">
                                                            <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('incomes.edit',$income->id) }}">
                                                            <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#modal_DELETE{{ $income->id }}">
                                                            <i class="fa fa-trash me-2"></i>حذف
                                                        </a>
                                                    </li>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Modal delete -->
                                    <div class="modal fade text-left" id="modal_DELETE{{ $income->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background-color: #EA5455 !important;">
                                                    <h4 class="modal-title" id="myModalLabel1" style="color: #FFFFFF">حذف سند صرف</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true" style="color: #DC3545">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <strong>
                                                        هل انت متاكد من انك تريد الحذف ؟
                                                    </strong>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light waves-effect waves-light" data-dismiss="modal">الغاء</button>
                                                    <a href="{{ route('incomes.delete',$income->id) }}" class="btn btn-danger waves-effect waves-light">تأكيد</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end delete-->

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-danger text-xl-center" role="alert">
                        <p class="mb-0">
                            لا توجد سندات قبض
                        </p>
                    </div>
                @endif
                {{ $incomes->links('pagination::bootstrap-5') }}
            </div>
        </div>

    </div><!-- content-body -->
    @endsection
