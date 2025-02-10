@extends('master')

@section('title')
    الاصول
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">الاصول </h2>
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
                            id="dropdownMenuButton303" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
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

                <a href="{{ route('Assets.create') }}" class="btn btn-success btn-sm d-flex align-items-center ">
                    <i class="fa fa-plus me-2"></i> اصل جديد
                </a>

                <!-- زر "المواعيد" -->
                <a href="{{ route('journal.index') }}"
                    class="btn btn-outline-primary btn-sm d-flex align-items-center">
                    <i class="fa fa-calendar-alt me-2"></i>سجل التعديلات
                </a>

            </div>
        </div>
    </div>
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
        <div class="card-content">
            <div class="card-body">
                <h4 class="card-title">بحث</h4>
            </div>

            <div class="card-body">
                <form class="form">
                    <div class="form-body row">
                        <div class="form-group col-md-4">
                            <label for="feedback1" class="sr-only">الاسم </label>
                            <input type="text" id="feedback1" class="form-control" placeholder="الاسم " name="name">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="feedback2" class="sr-only">الكود </label>
                            <input type="text" id="feedback2" class="form-control" placeholder="الكود " name="code">
                        </div>
                        <div class="form-group col-md-4">
                            <select name="" class="form-control" id="">
                                <option value="">موظف</option>
                                <option value="1">الكل </option>
                                <option value="0"></option>
                            </select>
                        </div>
                        <!-- من (التاريخ) -->


                    </div>

                    <div class="form-body row d-flex align-items-center g-0">
                        <div class="form-group col-md-4">
                            <select name="" class="form-control" id="">
                                <option value=""> حالة اي اصل  </option>
                                <option value="1"> في الخدمة</option>
                                <option value="0">غير نشط</option>
                                <option value="1"> مهلك</option>
                                <option value="0">تم بيعة  </option>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
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


                    </div>

                    <div class="collapse" id="advancedSearchForm">

                        <div class="form-body row d-flex align-items-center g-2">

                            <div class="form-group col-md-4">
                                <select name="" class="form-control" id="">
                                    <option value=""> مكان اي اصل  </option>
                                    <option value="1"> في الخدمة</option>
                                    <option value="0">غير نشط</option>
                                    <option value="1"> مهلك</option>
                                    <option value="0">تم بيعة  </option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
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

        <div class="card-body">
            @if($assets->count() > 0)
                @foreach($assets as $asset)
                    <div class="row border-bottom py-2 align-items-center">
                        <div class="col-md-2">
                            @if($asset->attachments)
                                <img src="{{ asset('storage/' . $asset->attachments) }}" alt="صورة الأصل" class="img-thumbnail" width="100">
                            @else
                                <img src="{{ asset('assets/images/no-image.jpg') }}" alt="لا توجد صورة" class="img-thumbnail" width="100">
                            @endif
                        </div>
                        <div class="col-md-3">
                            <p class="mb-0">
                                <strong>{{ $asset->name }}</strong>
                            </p>
                            <small class="text-muted">
                                كود: {{ $asset->code }}
                            </small>
                        </div>
                        <div class="col-md-3">
                            <p class="mb-0">القيمة: {{ number_format($asset->purchase_value, 2) }}</p>
                            <small class="text-muted">
                                بواسطة: {{ $asset->employee ? $asset->employee->full_name : 'غير محدد' }}
                            </small>
                        </div>
                        <div class="col-md-2 text-center">
                            <strong class="text-danger">{{ number_format($asset->depreciation ? $asset->depreciation->book_value : 0, 2) }}</strong>
                            <span class="badge bg-info d-block mt-1">
                                @if($asset->depreciation)
                                    @switch($asset->depreciation->dep_method)
                                        @case(1)
                                            القسط الثابت
                                            @break
                                        @case(2)
                                            القسط المتناقص
                                            @break
                                        @case(3)
                                            وحدات الإنتاج
                                            @break
                                        @case(4)
                                            بدون إهلاك
                                            @break
                                        @default
                                            بدون إهلاك
                                    @endswitch
                                @else
                                    بدون إهلاك
                                @endif
                            </span>
                        </div>
                        <div class="col-md-2 text-end">
                            <div class="btn-group">
                                <div class="dropdown">
                                    <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="{{ route('Assets.edit', $asset->id) }}">
                                            <i class="fa fa-edit me-2 text-success"></i>تعديل
                                        </a>
                                        <a class="dropdown-item" href="{{ route('Assets.show', $asset->id) }}">
                                            <i class="fa fa-eye me-2 text-primary"></i>عرض
                                        </a>
                                        <form action="{{ route('Assets.destroy', $asset->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fa fa-trash me-2"></i>حذف
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="mt-3">
                    {{ $assets->links() }}
                </div>
            @else
                <div class="alert alert-warning" role="alert">
                    <p class="mb-0">لا توجد أصول</p>
                </div>
            @endif
        </div>
    </div>




    <!-- Modal delete -->


@endsection
