@extends('master')

@section('title')
    فترة المبيعات
@stop

@section('content')
<div class="fs-5">
    <div class="fs-5">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0"> فترة المبيعات</h2>
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
                            <a href="{{ route('SalesPeriods.create') }}" class="btn btn-success">
                                <i class="fa fa-plus me-2"></i>
                                أضف فترة مبيعات
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
                                    <label for="feedback1" class=""> البحث بواسطة الموظف </label>
                                    <select name="" class="form-control" id="feedback1" id="">
                                        <option value="">اختر الموظف </option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="feedback2" class="">قواعد العمولة </label>
                                    <input type="text" id="feedback2" class="form-control" placeholder="قواعد العمولة" name="name">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="feedback2" class=""> الحالة </label>
                                    <select id="feedback2" class="form-control">
                                        <option value="">اختر الحالة </option>

                                    </select>
                                </div>
                            </div>
                            <div class="form-body row">
                                <!-- Row 1 -->
                                <div class="form-group col-md-6">
                                    <label>  فترة المبيعات(من )</label>
                                    <input type="date" class="form-control" placeholder="">

                                </div>
                                <div class="form-group col-md-6">
                                    <label>  فترة المبيعات(الى  )</label>
                                    <input type="date" class="form-control" placeholder="">

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

                    <table class="table fs-5">
                        <thead>
                            <tr>
                                <th class="fs-5">المعرف</th>
                                <th class="fs-5">موظف</th>
                                <th class="fs-5">التاريخ</th>
                                <th class="fs-5">المبيعات</th>
                                <th class="fs-5">عمولة</th>
                                <th class="fs-5">الحالة</th>
                                <th class="fs-5">ترتيب بواسطة</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($SalesCommission_periods as $SalesCommission_period)
                                <tr>
                                    <td class="fs-5">#1</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                                <span class="text-white fs-5"></span>
                                            </div>
                                            <div>
                                                <span class="fs-5">{{ $SalesCommission_period->employee->name }}</span>
                                                <small class="text-muted d-block fs-6">#5</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="fs-5">01/12/2024</span>
                                            <small class="text-muted d-block fs-6">02/01/2025</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <div class="d-flex justify-content-between" style="margin-bottom: 2px;">
                                                <span class="fs-5">
                                                    
                                                  
                                                    {{ $SalesCommission_period->total_sales ? number_format($SalesCommission_period->total_sales * 1.15, 2) : '' }}
                                                   
                                                </span>
                                            </div>
                                            <div class="progress" style="height: 4px; margin: 2px 0;">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: 0%;"
                                                     aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="d-flex justify-content-between" style="margin-top: 2px;">
                                                <span class="fs-5">0.00 ر.س</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fs-5">{{ $SalesCommission_period->total_sales && $SalesCommission_period->total_ratio ? number_format((($SalesCommission_period->total_sales * 1.15) * $SalesCommission_period->total_ratio) / 100, 2) : '' }} ر.س</span><br>
                                        {{-- <small class="text-danger fs-6">الهدف لم يتحقق</small> --}}
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="bg-warning rounded-circle me-2" style="width: 8px; height: 8px;"></span>
                                            <span class="fs-5">
                                                @if($SalesCommission_period->status == "open")
                                                مفتوح
                                                @else
                                                مفتوح
                                                @endif
                                            </span>
                                        </div>
                                    </td>
                        
                                    <td>
                                        <div class="btn-group">
                                            <div class="dropdown">
                                                <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1 btn-sm"
                                                        type="button" id="dropdownMenuButton303" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false"></button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton303">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('SalesPeriods.show', 1) }}">
                                                            <i class="fa fa-eye me-2 text-primary"></i>عرض
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
                            @endforeach
                        </tbody>
                        
                        
                    </table>
                    {{-- @else
                            <div class="alert alert-danger text-xl-center" role="alert">
                                <p class="mb-0">
                                    لا توجد مسميات وظيفية مضافة حتى الان !!
                                </p>
                            </div>
                        @endif --}}
                    {{-- {{ $shifts->links('pagination::bootstrap-5') }} --}}
                </div>
            </div>
    </div>
</div>
@endsection
