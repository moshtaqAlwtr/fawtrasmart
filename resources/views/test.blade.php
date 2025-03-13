

@extends('master')

@section('title')
 سجل النشاطات
@stop

@section('css')
<link rel="stylesheet" href="ass{{asset('assets/css/style.css')}}">

@endsection

    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">  سجل النشاطات</h2>
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
<div class="container">
<div class="row mt-4">
    <div class="col-12">
        <div class="filter-bar d-flex justify-content-between align-items-center">
            <div>
                <button class="btn btn-outline-secondary"><i class="fas fa-th"></i></button>
                <button class="btn btn-outline-secondary"><i class="fas fa-list"></i></button>
            </div>
            <div class="d-flex">
                <input type="text" class="form-control me-2" placeholder="الكلمة المفتاحية">
                <input type="text" class="form-control me-2" placeholder="الفترة من / إلى">

                <!-- زر "كل المستخدمين" مع قائمة منسدلة -->
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="usersDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        كل المستخدمين
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="usersDropdown">
                        <li><a class="dropdown-item" href="#">المستخدم 1</a></li>
                        <li><a class="dropdown-item" href="#">المستخدم 2</a></li>
                        <li><a class="dropdown-item" href="#">المستخدم 3</a></li>
                    </ul>
                </div>

                <!-- زر "كل الإجراءات" مع قائمة منسدلة -->
                <div class="dropdown ms-2">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="actionsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        كل الإجراءات
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="actionsDropdown">
                        <li><a class="dropdown-item" href="#">إنشاء فاتورة</a></li>
                        <li><a class="dropdown-item" href="#">تحديث فاتورة</a></li>
                        <li><a class="dropdown-item" href="#">إرسال فاتورة</a></li>
                        <li><a class="dropdown-item" href="#">طباعة الفاتورة</a></li>
                        <li><a class="dropdown-item" href="#">حذف الفاتورة</a></li>
                        <li><a class="dropdown-item" href="#">Preview Invoice</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="timeline-day">اليوم</div>
        <ul class="timeline">
            <li class="timeline-item">
                <div class="timeline-content">
                    <div class="time">
                        <i class="far fa-clock"></i> 13:19:58
                    </div>
                    <div>
                        <strong>محمد المنصوب مدير</strong> قام بإضافة إذن صرف مخزن <span class="text-muted">#10134</span> لفاتورة <span class="text-muted">#08842</span>
                        <div class="text-muted">Main Branch - مدير</div>
                    </div>
                </div>
            </li>
            <li class="timeline-item">
                <div class="timeline-content">
                    <div class="time">
                        <i class="far fa-clock"></i> 13:19:58
                    </div>
                    <div>
                        أنشأ <strong>محمد المنصوب مدير</strong> فاتورة جديدة <span class="text-danger">غير مدفوعة</span> ورقمها <span class="text-muted">#08842</span>
                        للعميل <strong>مؤسسة حنان سلطان العمري للتجارة حي طويق</strong> <span class="text-muted">(270#)</span> بإجمالي <strong>216.00</strong> والمبلغ مستحق الدفع.
                        <div class="text-muted">Main Branch - مدير</div>
                    </div>
                </div>
            </li>
            <li class="timeline-item">
                <div class="timeline-content">
                    <div class="time">
                        <i class="far fa-clock"></i> 13:19:28
                    </div>
                    <div>
                        حدث النظام الفاتورة <span class="text-muted">#08011</span> بإجمالي <strong>216.00</strong> والمبلغ المستحق أصبح: <strong>0.00</strong>
                        <div class="text-muted">Main Branch - النظام</div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
