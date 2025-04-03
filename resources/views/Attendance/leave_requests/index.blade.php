@extends('master')

@section('title')
طلبات الأجازة
@stop

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">طلبات الأجازة</h2>
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
    <div class="card-header d-flex justify-content-between align-items-center">
        <!-- التبويبات -->
        <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="true">الكل</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab" aria-controls="pending" aria-selected="false">تحت المراجعة</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved" type="button" role="tab" aria-controls="approved" aria-selected="false">موافق عليه</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#rejected" type="button" role="tab" aria-controls="rejected" aria-selected="false">مرفوض</button>
            </li>
        </ul>

        <!-- الأزرار -->
        <div>
        <div>
                                <a href="{{ route('attendance.leave_requests.create') }}" class="btn btn-outline-success">
                                    <i class="fa fa-plus me-2"></i>أضف طلب الأجازة
                                </a>

                                <button class="btn btn-outline-primary">
                                    <i class="fa fa-calendar-alt me-2"></i>رصيد الأجازات
                                </button>
                            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                <p>عرض جميع الطلبات.</p>
            </div>
            <div class="tab-pane fade" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                <p>عرض الطلبات تحت المراجعة.</p>
            </div>
            <div class="tab-pane fade" id="approved" role="tabpanel" aria-labelledby="approved-tab">
                <p>عرض الطلبات الموافق عليها.</p>
            </div>
            <div class="tab-pane fade" id="rejected" role="tabpanel" aria-labelledby="rejected-tab">
                <p>عرض الطلبات المرفوضة.</p>
            </div>
        </div>
    </div>
</div>

<div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="card-title">

                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>بحث </div>
                            <div>
                                <a href="{{ route('products.create') }}" class="btn btn-outline-success">
                                    <i class="fa fa-plus me-2"></i>أضف أذن أجازة
                                </a>

                              
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form class="form" method="GET" action="{{ route('products.search') }}">
                        <div class="form-body row">
                            <div class="form-group col-md-3">
                                <label for="">البحث بواسطة الموظف</label>
                                <input type="text" class="form-control" placeholder="ادخل الإسم او الكود"name="keywords">
                            </div>
                            <div class="form-group col-3">
                                    <label for="">من تاريخ</label>
                                    <input type="date" class="form-control" name="from_date">
                                </div>

                                <div class="form-group col-3">
                                    <label for="">الي تاريخ</label>
                                    <input type="date" class="form-control"  name="to_date">
                                </div>
                                <div class="form-group col-3">
                                    <label for=""> تاريخ الأنشاء</label>
                                    <input type="date" class="form-control"  name="to_date">
                                </div>
              
                        </div>
                        <!-- Hidden Div -->
                        <div class="collapse" id="advancedSearchForm">
                            <div class="form-body row">

                           

                                <div class="form-group col-4">
                                    <label for="">جميع الحالات</label>
                                    <input type="text" class="form-control" name="product_code">
                                </div>
                                <div class="col-md-4">
                    <label for="searchDepartment" class="form-label">أختر قسم</label>
                    <input type="text" class="form-control" id="searchDepartment" placeholder="كل الأقسام">
                </div>
                    <div class="col-md-4">
                    <label for="searchDepartment" class="form-label">أختر فرع</label>
                    <input type="text" class="form-control" id="searchDepartment" placeholder="كل الفروع">
                </div>
                <div class="col-md-4">
                    <label for="searchDepartment" class="form-label">أختر مسمى وظيفي</label>
                    <input type="text" class="form-control" id="searchDepartment" placeholder="كل المسميات الوظيفية">
                </div>
                <div class="col-md-4">
                    <label for="searchDepartment" class="form-label">أختر ودرية</label>
                    <input type="text" class="form-control" id="searchDepartment" placeholder="كل الورديات">
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
                            <a href="{{ route('products.index') }}" class="btn btn-outline-danger waves-effect waves-light">الغاء الفلترة</a>
                        </div>
                    </form>

                </div>

            </div>
            <div class="card mt-4">
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered" dir="rtl">
            <thead class="table-light">
                <tr>
                    <th scope="col">المعرف </th>
                    <th scope="col">موظف</th>
                    <th scope="col">النوع</th>
                    <th scope="col"> تاريخ الأنشاء</th>
                    <th scope="col">التاريخ</th>
                    <th scope="col">الحالة</th>
                    <th scope="col">ترتيب بواسطة</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#1 </td>
                    <td>#2 راكان الخشابي</td>
                    <td> أجازة عارضة 5 أيام</td>
                    <td> 20/12/2024</td>
                    <td>من الأثنين 01/12/2024 الى الجمعة 05/12/2024</td>
                    <td><span class="badge bg-blue text-dark">مرفوض </span></td>
                    <td>
                        <div class="btn-group">
                            <button class="btn bg-gradient-info fa fa-ellipsis-v" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#"><i class="fa fa-eye me-2 text-primary"></i>عرض</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-edit text-primary me-2"></i>تعديل</a>
                                <div class="dropdown-divider"></div>
                                <button class="dropdown-item text-danger delete-client">
                                    <i class="fas fa-trash me-2"></i>حذف
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>#1 </td>
                    <td>#2 راكان الخشابي</td>
                    <td> أجازة عارضة 5 أيام</td>
                    <td> 20/12/2024</td>
                    <td>من الأثنين 01/12/2024 الى الجمعة 05/12/2024</td>
                    <td><span class="badge bg-green text-dark">موافق عليه </span></td>
                    <td>
                        <div class="btn-group">
                            <button class="btn bg-gradient-info fa fa-ellipsis-v" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#"><i class="fa fa-eye me-2 text-primary"></i>عرض</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-edit text-primary me-2"></i>تعديل</a>
                                <div class="dropdown-divider"></div>
                                <button class="dropdown-item text-danger delete-client">
                                    <i class="fas fa-trash me-2"></i>حذف
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>#1 </td>
                    <td>#2 راكان الخشابي</td>
                    <td> أجازة عارضة 5 أيام</td>
                    <td> 20/12/2024</td>
                    <td>من الأثنين 01/12/2024 الى الجمعة 05/12/2024</td>
                    <td><span class="badge bg-blue text-dark">تحت المراجعة  </span></td>
                    <td>
                        <div class="btn-group">
                            <button class="btn bg-gradient-info fa fa-ellipsis-v" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#"><i class="fa fa-eye me-2 text-primary"></i>عرض</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-edit text-primary me-2"></i>تعديل</a>
                                <div class="dropdown-divider"></div>
                                <button class="dropdown-item text-danger delete-client">
                                    <i class="fas fa-trash me-2"></i>حذف
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
                <!-- أضف المزيد من الصفوف حسب الحاجة -->
            </tbody>
        </table>
    </div>
</div>
@endsection