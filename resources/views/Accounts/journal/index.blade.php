@extends('master')

@section('title')
    القيود اليومية
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">القيود اليومية</h2>
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
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <!-- زر "فاتورة جديدة" -->
                <div class="form-group col-outdo">
                    <input class="form-check-input" type="checkbox" id="selectAll">
                </div>
                <div class="btn-group">
                    <div class="dropdown">
                        <button class="btn  dropdown-toggle mr-1 mb-1" type="button" id="dropdownMenuButton302"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton302">
                            <a class="dropdown-item" href="#">Option 1</a>
                            <a class="dropdown-item" href="#">Option 2</a>
                            <a class="dropdown-item" href="#">Option 3</a>
                        </div>
                    </div>
                </div>
                <div class="btn-group col-md-5">
                    <div class="dropdown">
                        <button class="btn bg-gradient-info dropdown-toggle mr-1 mb-1" type="button"
                            id="dropdownMenuButton303" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            الاجراءات
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton303">
                            <a class="dropdown-item" href="#">Option 1</a>
                            <a class="dropdown-item" href="#">Option 2</a>
                            <a class="dropdown-item" href="#">Option 3</a>
                        </div>
                    </div>
                </div>
                <!-- مربع اختيار -->

                <!-- الجزء الخاص بالتصفح -->
                <div class="d-flex align-items-center">
                    <!-- زر الصفحة السابقة -->
                    <button class="btn btn-outline-secondary btn-sm" aria-label="الصفحة السابقة">
                        <i class="fa fa-angle-right"></i>
                    </button>

                    <!-- أرقام الصفحات -->
                    <nav class="mx-2">
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item active"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">4</a></li>
                            <li class="page-item"><a class="page-link" href="#">5</a></li>
                        </ul>
                    </nav>

                    <!-- زر الصفحة التالية -->
                    <button class="btn btn-outline-secondary btn-sm" aria-label="الصفحة التالية">
                        <i class="fa fa-angle-left"></i>
                    </button>
                </div>

                <!-- قائمة الإجراءات -->

                <a href="{{ route('journal.create') }}" class="btn btn-success btn-sm d-flex align-items-center ">
                    <i class="fa fa-plus me-2"></i> قيد جديد
                </a>

                <!-- زر "المواعيد" -->
                <a href="{{ route('journal.index') }}" class="btn btn-outline-primary btn-sm d-flex align-items-center">
                    <i class="fa fa-calendar-alt me-2"></i>سجل التعديلات
                </a>

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
                            <select name="" class="form-control" id="">
                                <option value="">اي حساب </option>
                                <option value="1">الكل </option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="feedback2" class="sr-only">الوصف </label>
                            <input type="email" id="feedback2" class="form-control" placeholder="الوصف " name="email">
                        </div>
                        <div class="form-group col-outdo pe-1">
                            <select name="" class="form-control" id="">
                                <option value="">تخصيص</option>
                                <option value="1">شهريًا</option>
                                <option value="0">أسبوعيًا</option>
                                <option value="2">يوميًا</option>
                            </select>
                        </div>

                        <!-- من (التاريخ) -->
                        <div class="form-group col-md-1.5">
                            <input type="date" id="feedback1" class="form-control" placeholder="من"
                                name="from_date">
                        </div>

                        <!-- إلى (التاريخ) -->
                        <div class="form-group col-md-1.5">
                            <input type="date" id="feedback2" class="form-control" placeholder="إلى" name="to_date">
                        </div>

                    </div>

                    <div class="form-body row d-flex align-items-center g-0">
                        <div class="form-group col-md-4">
                            <select name="" class="form-control" id="">
                                <option value=""> المصدر </option>
                                <option value="1"></option>
                                <option value="0">غير فعال</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="feedback1" class="sr-only"></label>
                            <input type="text" id="feedback1" class="form-control" placeholder="رقم "
                                name="name">
                        </div>

                        <div class="form-group col-md-4">
                            <select name="" class="form-control" id="">
                                <option value="">حالة القيد</option>
                                <option value="1">الكل </option>
                                <option value="0">غير مدفوعة</option>
                            </select>
                        </div>

                    </div>

                    <div class="form-footer d-flex justify-content-between">
                        <div class="form-group col-md-4">
                            <select name="" class="form-control" id="">
                                <option value="">مركز التكلفة </option>
                                <option value="1">الكل </option>
                                <option value="0">غير مدفوعة</option>
                            </select>
                        </div>
                    </div>

                    <div class="collapse" id="advancedSearchForm">

                        <div class="form-body row d-flex align-items-center g-2">

                            <div class="form-group col-md-2">
                                <label for="" class="sr-only">Status</label>

                                <input type="text" id="feedback1" class="form-control"
                                    placeholder="الاجمالي اكبر من " name="name">

                            </div>
                            <div class="form-group col-md-2">
                                <label for="" class="sr-only">Status</label>

                                <input type="text" id="feedback1" class="form-control"
                                    placeholder="الاجمالي اصغر من " name="name">

                            </div>

                            <div class="form-group col-md-1">
                                <select name="" class="form-control" id="">
                                    <option value="">تخصيص</option>
                                    <option value="1">شهريًا</option>
                                    <option value="0">أسبوعيًا</option>
                                    <option value="2">يوميًا</option>
                                </select>
                            </div>

                            <!-- من (التاريخ) -->
                            <div class="form-group col-md-1.5">
                                <input type="date" id="feedback3" class="form-control" placeholder="من"
                                    name="from_date_2">
                            </div>

                            <!-- إلى (التاريخ) -->
                            <div class="form-group col-md-1.5">
                                <input type="date" id="feedback4" class="form-control" placeholder="إلى"
                                    name="to_date_2">
                            </div>
                            <div class="form-group col-md-4">
                                <select name="" class="form-control" id="">
                                    <option value="">اضيفت بواسطة</option>
                                    <option value="1">الكل </option>
                                    <option value="0"></option>
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
                        <button type="reset" class="btn btn-outline-warning waves-effect waves-light">Cancel</button>
                    </div>
                </form>

            </div>



        </div>

        <!--end delete-->




    </div>
    <div class="card">
        <div class="card-body p-0">
            @if (count($entries) > 0)
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>


                            <th>العملية</th>
                            <th>الحساب</th>

                            <th>التاريخ</th>
                            <th>بواسطة</th>

                            <th>المبلغ</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($entries as $entry)
                            <tr>
                                <!-- القسم الأيمن - رقم القيد والمبلغ -->



                                <!-- القسم الأوسط - نوع العملية -->
                                <td>
                                    <span class="badge bg-light text-dark">{{ $entry->id ?? 'قيد محاسبي' }}</span>
                                </td>

                                <!-- القسم الأيمن - الحساب والوصف -->
                                <td>
                                    @if ($entry->details->count() > 0)
                                        <div class="account-flow d-flex justify-content-center align-items-center">
                                            @foreach ($entry->details->reverse() as $detail)
                                                @if ($detail->account && $detail->account->name)
                                                    <a href="{{ route('accounts_chart.index', $detail->account->id) }}"
                                                        class="btn btn-outline-primary mx-2">
                                                        {{ $detail->account->name }}
                                                    </a>
                                                    @if (!$loop->last)
                                                        <i class="fas fa-long-arrow-alt-left text-muted mx-2"></i>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-muted">لا توجد تفاصيل</span>
                                    @endif
                                </td>
                                <td>{{ $entry->date->format('Y-m-d') }}</td>
                                <td>{{ $entry->createdByEmployee->name ?? 'غير محدد' }}</td>
                                <td>
                                    <span class="badge bg-{{ $entry->status == 1 ? 'success' : 'warning' }}">
                                        {{ $entry->status == 1 ? 'معتمد' : 'غير معتمد' }}
                                    </span>
                                </td>
                                <td>{{ number_format($entry->details->sum('debit'), 2) }} ر.س</td>
                                <!-- الإجراءات -->
                                <td>
                                    <div class="btn-group">
                                        <div class="dropdown">
                                            <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="{{ route('journal.edit', $entry->id) }}">
                                                    <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                </a>
                                                <a class="dropdown-item" href="{{ route('journal.show', $entry->id) }}">
                                                    <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                </a>
                                                <form action="{{ route('journal.destroy', $entry->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="fa fa-trash me-2"></i>حذف
                                                    </button>
                                                </form>

                                                <a class="dropdown-item" href="">
                                                    <i class="fa fa-edit me-2 text-success"></i>عرض  المصدر
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-warning m-3" role="alert">
                    <p class="mb-0">لا توجد قيود محاسبية</p>
                </div>
            @endif
        </div>
    </div>


    <!-- Modal delete -->


@endsection
