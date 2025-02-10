@extends('master')

@section('title')
    أدارة قائمة جهات الاتصال
@stop

@section('head')
    <!-- تضمين ملفات Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2"></i>
                <strong>{{ session('success') }}</strong>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">ادارة قائمة جهات الاتصال </h2>
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
        <div class="card shadow-lg border-0 rounded-lg mb-4">
            <div class="card-header bg-white py-3">
                <div class="row justify-content-between align-items-center mx-2">
                    <!-- القسم الأيمن -->
                    <div class="col-auto d-flex align-items-center gap-5">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="selectAll">
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle px-4" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-filter me-2"></i>
                            </button>
                            <ul class="dropdown-menu shadow-sm">
                                <li><a class="dropdown-item py-2" href="#"><i
                                            class="fas fa-sort-alpha-down me-2"></i>ترتيب حسب الاسم</a></li>
                                <li><a class="dropdown-item py-2" href="#"><i
                                            class="fas fa-sort-numeric-down me-2"></i>ترتيب حسب الرقم</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item py-2" href="#"><i class="fas fa-sync me-2"></i>تحديث</a>
                                </li>
                            </ul>
                        </div>
                        <div class="dropdown">

                            <ul class="dropdown-menu shadow-sm">
                                <li><a class="dropdown-item py-2" href="#"><i class="fas fa-edit me-2"></i>تعديل
                                        المحدد</a></li>
                                <li><a class="dropdown-item py-2" href="#"><i class="fas fa-trash me-2"></i>حذف
                                        المحدد</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item py-2" href="#"><i
                                            class="fas fa-file-export me-2"></i>تصدير</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- القسم الأيسر -->
                    <div class="col-auto d-flex align-items-center gap-5">
                        <!-- التنقل بين الصفحات -->
                        <nav aria-label="Page navigation" class="d-flex align-items-center">
                            <ul class="pagination mb-0 pagination-sm">
                                <li class="page-item">
                                    <a class="page-link border-0 rounded-start" href="#" aria-label="First">
                                        <i class="fas fa-angle-double-right"></i>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link border-0" href="#" aria-label="Previous">
                                        <i class="fas fa-angle-right"></i>
                                    </a>
                                </li>
                                <li class="page-item"><span class="page-link border-0">صفحة 1 من 10</span></li>
                                <li class="page-item">
                                    <a class="page-link border-0" href="#" aria-label="Next">
                                        <i class="fas fa-angle-left"></i>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link border-0 rounded-end" href="#" aria-label="Last">
                                        <i class="fas fa-angle-double-left"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>

                        <div class="d-flex gap-4">

                            <button class="btn btn-outline-secondary sitting px-4" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="fas fa-cog me-2"></i>
                            </button>
                            <!-- زر إضافة عميل -->
                            <a href="{{ route('clients.create') }}" class="btn btn-success px-4">
                                <i class="fas fa-plus-circle me-2"></i>
                                إضافة عميل
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- محتوى الجدول -->

        </div>

        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <h4 class="card-title">بحث</h4>
                </div>

                <div class="card-body">
                    <form class="form">
                        <div class="form-body row">
                            <div class="form-group col-md-3">
                                <select name="" class="form-control" id="">
                                    <option value="">اي العميل</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->trans_name }}
                                            {{ $client->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="feedback2" class="sr-only">الأسم </label>
                                <input type="email" id="feedback2" class="form-control" placeholder="الأسم "
                                    name="email">
                            </div>

                            <div class="form-group col-md-3">
                                <select id="feedback2" class="form-control">
                                    <option value="">الحالة</option>
                                    <option value="1">فعال</option>
                                    <option value="0">غير فعال</option>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <select id="feedback2" class="form-control">
                                    <option value="">أختر التصنيف</option>
                                    <option value="1">فعال</option>
                                    <option value="0">غير فعال</option>
                                </select>
                            </div>
                        </div>

                        <div class="collapse" id="advancedSearchForm">
                            <div class="form-body row d-flex align-items-center g-0">



                                <div class="form-group col-md-1.5">
                                    <input type="date" id="feedback1" class="form-control" placeholder="من"
                                        name="from_date">
                                </div>

                                <!-- إلى (التاريخ) -->
                                <div class="form-group col-md-1.5">
                                    <input type="date" id="feedback2" class="form-control" placeholder="إلى"
                                        name="to_date">
                                </div>
                                <div class="form-group col-md-3">
                                    <select name="" class="form-control" id="">
                                        <option value=""> العنوان </option>

                                    </select>
                                </div>


                                <div class="form-group col-md-3">
                                    <select name="" class="form-control" id="">
                                        <option value="">البلد </option>
                                        <option value="1">السعودية </option>
                                        <option value="0">اليمن </option>
                                    </select>
                                </div>


                                <div class="form-group col-md-3">
                                    <select name="" class="form-control" id="">
                                        <option value=""> الرمز البريدي </option>

                                    </select>
                                </div>

                            </div>

                            <div class="form-body row d-flex align-items-center g-2">
                                <!-- حالة الدفع -->
                                <div class="form-group col-md-3">
                                    <select name="" class="form-control" id="">
                                        <option value="">أختر وسم</option>
                                        <option value="1">الكل </option>

                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <select name="" class="form-control" id="">
                                        <option value="">اضيفت بواسطة</option>
                                        <option value="1">الكل </option>
                                        <option value="0"></option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <select name="" class="form-control" id="">
                                        <option value="">أختر الموظفين المعينين</option>
                                        <option value="1">الكل </option>
                                        <option value="0"></option>
                                    </select>
                                </div>
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



            </div>
        </div>
        @if (@isset($clients) && !@empty($clients) && count($clients) > 0)
        @foreach ($clients as $client)
            <div class="card">
                <div class="card-body">
                    <div class="card-body row align-items-center">
                        <div class="col-md-1 text-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $client->id }}">
                            </div>
                        </div>
                        <div class="col-md-3">

                            <small class="text-muted">{{ $client->code }}</small>

                        </div>
                        <div class="col-md-3">
                            <h5 class="mb-0">{{ $client->trade_name }}</h5>
                        </div>
                        <div class="col-md-3 text-center">
                            <strong class="text-primary">
                                <i class="fas fa-phone me-2"></i>{{ $client->phone }}
                            </strong>
                        </div>
                        <div class="col-md-2 text-end">
                            <div class="btn-group">
                                <div class="dropdown">
                                    <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1" type="button"id="dropdownMenuButton303" data-toggle="dropdown" aria-haspopup="true"aria-expanded="false"></button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton303">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('clients.show_contant', $client->id) }}">
                                                <i class="fa fa-eye me-2 text-primary"></i>شاهد العميل
                                            </a>
                                        </li>

                                        <div class="dropdown-divider"></div>
                                        <form id="delete-client-{{ $client->id }}"
                                            action="{{ route('clients.destroy', $client->id) }}"
                                            method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="dropdown-item text-danger delete-client"
                                                data-id="{{ $client->id }}"
                                                onclick="return confirm('هل أنت متأكد من حذف هذا العميل؟')">
                                                <i class="fas fa-trash me-2"></i>حذف
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="alert alert-danger" role="alert">
            <p class="mb-0">
                لا توجد  عملاء
            </p>
        </div>
    @endif
    </div>
    </div>
    </div>




@endsection

@section('scripts')
    <!-- تضمين ملفات JavaScript الخاصة بـ Bootstrap -->


    <!-- تهيئة القوائم المنسدلة -->
    <script></script>
@endsection
