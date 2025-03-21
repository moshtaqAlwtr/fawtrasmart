@extends('master')

@section('title', 'إضافة طلب إجازة')

@section('content')
    <!-- Header Section -->
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">إضافة طلب إجازة</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">الرئيسية</a></li>
                            <li class="breadcrumb-item active">إضافة</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                </div>
                <div>
                    <a href="{{ route('Assets.index') }}" class="btn btn-outline-danger">
                        <i class="fa fa-ban"></i> إلغاء
                    </a>
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fa fa-save"></i> حفظ
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-4">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title mb-4">معلومات طلب الإجازة</h4>
            <form>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="employee" class="form-label">موظف <span class="text-danger">*</span></label>
                        <select class="form-control" id="employee" required>
                            <option selected disabled>اختر موظف</option>
                            <!-- Add options here -->
                        </select>
                        <hr>
                        <p class="text-primary" >تفقد رصيد الإجازات</p>
                    </div>
                    <div class="col-md-6">
                        <label for="type" class="form-label">النوع <span class="text-danger">*</span></label>
                        <select class="form-control" id="type" required>
                            <option selected disabled>إجازة</option>
                            <!-- Add options here -->
                        </select>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label for="days" class="form-label">أيام <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="days" placeholder="تفقد رصيد الإجازات" required>
                    </div>
                    <div class="col-md-4">
                        <label for="start-date" class="form-label">تاريخ البدء <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="start-date" required>
                    </div>
                    <div class="col-md-4">
                        <label for="end-date" class="form-label">تاريخ الانتهاء <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="end-date" required>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="leave-type" class="form-label">نوع الإجازة <span class="text-danger">*</span></label>
                        <select class="form-control" id="leave-type" required>
                            <option selected disabled>أجازة أعتيادية</option>
                            <option>أجازة عرضية </option>
                            <!-- Add options here -->
                        </select>
                        <hr>
                        <p class="text-primary">رصيد الأجازات 0</p>
                    </div>
                    <div class="col-md-6">
                        <label for="attachments" class="form-label">المرفقات</label>
                        <input type="file" name="attachments" id="attachments" class="d-none">
                        <div class="upload-area border rounded p-3 text-center position-relative" onclick="document.getElementById('attachments').click()">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <i class="fas fa-cloud-upload-alt text-primary"></i>
                                <span class="text-primary">اضغط هنا</span>
                                <span>أو</span>
                                <span class="text-primary">اختر من جهازك</span>
                            </div>
                            <div class="position-absolute end-0 top-50 translate-middle-y me-3">
                                <i class="fas fa-file-alt fs-3 text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">الوصف</label>
                    <textarea class="form-control" id="description" rows="3" placeholder="أدخل الوصف"></textarea>
                </div>

              
            </form>
        </div>
    </div>
</div>
@endsection