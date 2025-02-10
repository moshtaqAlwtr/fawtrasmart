@extends('master')

@section('title')
أضف وكيل تأمين
@stop

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">أضف وكيل تأمين</h2>
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




<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title text-center mb-0">أضافة وكيل تأمين</h5>
        </div>
        <div class="card-body">
            <!-- خطوات التنقل -->
            <ul class="nav nav-tabs" id="steps" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="step1-tab" data-toggle="tab" href="#step1" role="tab" aria-controls="step1" aria-selected="true">الخطوة الأولى</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="step2-tab" data-toggle="tab" href="#step2" role="tab" aria-controls="step2" aria-selected="false">الخطوة الثانية</a>
                </li>
            </ul>

            <!-- محتوى الخطوات -->
            <div class="tab-content mt-3" id="stepsContent">
                <!-- الخطوة الأولى -->
                <div class="tab-pane fade show active" id="step1" role="tabpanel" aria-labelledby="step1-tab">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="name">الاسم</label>
                                <input type="text" id="name" class="form-control" placeholder="أدخل الاسم">
                            </div>
                            <div class="col-md-6">
                                <label for="image">الصورة</label>
                                <input type="file" id="image" class="form-control">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label for="phone">الهاتف</label>
                                <input type="text" id="phone" class="form-control" placeholder="أدخل الهاتف">
                            </div>
                            <div class="col-md-6">
                                <label for="email">البريد الإلكتروني</label>
                                <input type="email" id="email" class="form-control" placeholder="أدخل البريد الإلكتروني">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label for="status">الحالة</label>
                                <select id="status" class="form-control">
                                    <option value="active">نشط</option>
                                    <option value="inactive">غير نشط</option>
                                </select>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary float-right mt-3" data-toggle="tab" href="#step2">التالي</button>
                    </form>
                </div>

                <!-- الخطوة الثانية -->
                <div class="tab-pane fade" id="step2" role="tabpanel" aria-labelledby="step2-tab">
                    <form id="dynamicForm">
                        <div class="d-flex flex-wrap align-items-center mb-3">
                            <input type="text" class="form-control col-md-2 mr-2" placeholder="الحد الأقصى للدفع">
                            <input type="number" class="form-control col-md-2 mr-2" placeholder="% Client copayment">
                            <input type="number" class="form-control col-md-2 mr-2" placeholder="% Company copayment">
                            <input type="number" class="form-control col-md-2 mr-2" placeholder="الخصم">
                            <select class="form-control col-md-2 mr-2">
                                <option value="">Nothing selected</option>
                                <option value="admin">العميل</option>
                                <option value="user">المستخدم</option>
                            </select>
                            <button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash-alt"></i></button>
                        </div>

                        <div id="newRowsContainer"></div>

                        <button type="button" class="btn btn-success mt-3" id="addRow"><i class="fas fa-plus"></i> إضافة سطر</button>
                        <button type="button" class="btn btn-secondary float-left mt-3" data-toggle="tab" href="#step1">السابق</button>
                        <button type="submit" class="btn btn-primary float-right mt-3">حفظ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    // إضافة سطر جديد
    document.getElementById('addRow').addEventListener('click', function () {
        const newRow = `
            <div class="d-flex flex-wrap align-items-center mb-3">
                <input type="text" class="form-control col-md-2 mr-2" placeholder="الحد الأقصى للدفع">
                <input type="number" class="form-control col-md-2 mr-2" placeholder="% Client copayment">
                <input type="number" class="form-control col-md-2 mr-2" placeholder="% Company copayment">
                <input type="number" class="form-control col-md-2 mr-2" placeholder="الخصم">
                <select class="form-control col-md-2 mr-2">
                    <option value="">Nothing selected</option>
                    <option value="admin">العميل</option>
                    <option value="user">المستخدم</option>
                </select>
                <button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash-alt"></i></button>
            </div>
        `;
        document.getElementById('newRowsContainer').insertAdjacentHTML('beforeend', newRow);
    });

    // حذف السطر
    document.addEventListener('click', function (event) {
        if (event.target.closest('.remove-row')) {
            event.target.closest('.d-flex').remove();
        }
    });
</script>
</body>
</html>










@endsection