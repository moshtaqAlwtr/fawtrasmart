@extends('master')

@section('title')
    أنواع الطلبات
@stop

@section('content')

<div class="card"></div>

<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0"> أنواع الطلبات</h2>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">الرئيسيه</a></li>
                        <li class="breadcrumb-item active">أضافة</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content-body">
    <div class="card p-4">
        <form action="#" method="POST" id="products_form">
            @csrf

            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                <div>
                    <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('products.index') }}" class="btn btn-outline-danger">
                        <i class="fa fa-ban"></i> إلغاء
                    </a>
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fa fa-save"></i> حفظ
                    </button>
                </div>
            </div>

            <h5 class="mb-3">معلومات عامة</h5>

            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">الاسم <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">الحالة</label>
                    <select class="form-control">
                        <option selected>نشط</option>
                        <option>غير نشط</option>
                    </select>
                </div>
            </div>

<div class="d-flex align-items-center gap-4 mt-2">
    <div class="custom-control custom-switch custom-switch-success custom-control-inline">
        <input type="checkbox" class="custom-control-input" id="customSwitch1">
        <label class="custom-control-label" for="customSwitch1"></label>
        <span class="switch-label">Notify Approvers by Email</span>
    </div>

    <div class="custom-control custom-switch custom-switch-success custom-control-inline">
        <input type="checkbox" class="custom-control-input" id="customSwitch2">
        <label class="custom-control-label" for="customSwitch2"></label>
        <span class="switch-label">السماح بالموافقة أو رفض طلباتي</span>
    </div>
</div>
      <!-- اختيار القالب الافتراضي -->
      <div class="mb-3">
        <label class="form-label">Default Request Email Template</label>
        <select class="form-control">
            <option selected>من فضلك اختر</option>
            <option>Template 1</option>
            <option>Template 2</option>
        </select>
    </div>
            <p>الصلاحيات</p>

            <!-- إضافة طلب جديد -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">إضافة طلب جديد</label>
                    <select class="form-control permission-select">
                        <option value="all" selected>الكل</option>
                        <option value="none">لاشيء</option>
                        <option value="employees"> أفرع محددة</option>
                        <option value="employees">موظفين محددين</option>

                    </select>
                </div>

                <div class="col-md-6 employee-search-container" style="display: none;">
                    <label class="form-label">ابحث عن موظف</label>
                    <input type="text" class="form-control employee-search-input" placeholder="أدخل اسم الموظف">
                    <div class="employee-results"></div>
                    <div class="selected-employees mt-2">
                        <label>الموظفون المختارون:</label>
                        <ul class="list-group employee-list"></ul>
                    </div>
                </div>
            </div>

            <!-- موافقة / رفض الطلبات -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">موافقة / رفض الطلبات</label>
                    <select class="form-control permission-select">
                        <option value="all" selected>الكل</option>
                        <option value="none">لاشيء</option>
                        <option value="employees">موظفين محددين</option>
                    </select>
                </div>

                <div class="col-md-6 employee-search-container" style="display: none;">
                    <label class="form-label">ابحث عن موظف</label>
                    <input type="text" class="form-control employee-search-input" placeholder="أدخل اسم الموظف">
                    <div class="employee-results"></div>
                    <div class="selected-employees mt-2">
                        <label>الموظفون المختارون:</label>
                        <ul class="list-group employee-list"></ul>
                    </div>
                </div>
            </div>

            <!-- إدارة الطلبات للآخرين -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">إدارة الطلبات للآخرين</label>
                    <select class="form-control permission-select">
                        <option value="all" selected>الكل</option>
                        <option value="none">لاشيء</option>
                        <option value="employees">موظفين محددين</option>
                    </select>
                </div>

                <div class="col-md-6 employee-search-container" style="display: none;">
                    <label class="form-label">ابحث عن موظف</label>
                    <input type="text" class="form-control employee-search-input" placeholder="أدخل اسم الموظف">
                    <div class="employee-results"></div>
                    <div class="selected-employees mt-2">
                        <label>الموظفون المختارون:</label>
                        <ul class="list-group employee-list"></ul>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".permission-select").forEach(select => {
            select.addEventListener("change", function () {
                const parentRow = this.closest(".row");
                const employeeSearch = parentRow.querySelector(".employee-search-container");

                if (this.value === "employees") {
                    employeeSearch.style.display = "block";
                } else {
                    employeeSearch.style.display = "none";
                }
            });
        });
    });

    $(document).ready(function () {
        let searchRoute = "{{ route('employees.search') }}";

        $(".employee-search-input").on("input", function () {
            let query = $(this).val();
            let resultBox = $(this).siblings(".employee-results");

            if (query.length > 1) {
                $.ajax({
                    url: searchRoute,
                    method: "GET",
                    data: { query: query },
                    success: function (response) {
                        resultBox.empty();
                        if (Array.isArray(response) && response.length > 0) {
                            response.forEach(employee => {
                                resultBox.append(`<div class="employee-item" data-id="${employee.id}">${employee.name}</div>`);
                            });
                            resultBox.show();
                        } else {
                            resultBox.hide();
                        }
                    }
                });
            } else {
                resultBox.hide();
            }
        });

        $(document).on("click", ".employee-item", function () {
            let employeeId = $(this).data("id");
            let employeeName = $(this).text();
            let employeeList = $(this).closest(".employee-search-container").find(".employee-list");

            if (employeeList.find(`[data-id='${employeeId}']`).length === 0) {
                employeeList.append(`
                    <li class="list-group-item d-flex justify-content-between align-items-center" data-id="${employeeId}">
                        ${employeeName}
                        <button type="button" class="btn btn-danger btn-sm remove-employee">×</button>
                    </li>
                `);
            }

            $(".employee-search-input").val("");
            $(".employee-results").hide();
        });

        $(document).on("click", ".remove-employee", function (event) {
            event.preventDefault();
            $(this).closest("li").remove();
        });
    });
</script>

@endsection
