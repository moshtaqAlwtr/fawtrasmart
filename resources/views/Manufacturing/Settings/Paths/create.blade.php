@extends('master')

@section('title')
    أضافة مسار الإنتاج
@stop

@section('content')

<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">أضافة مسار الإنتاج</h2>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">الرئيسيه</a></li>
                        <li class="breadcrumb-item active">عرض</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
            </div>
            <div>
                <a href="" class="btn btn-outline-danger">
                    <i class="fa fa-ban"></i> إلغاء
                </a>
                <button type="submit" class="btn btn-outline-primary">
                    <i class="fa fa-save"></i> حفظ
                </button>
            </div>
        </div>
    </div>
</div>

<div class="card mt-5">
    <div class="card-body">
        <!-- معلومات مسار الإنتاج -->
        <div class="mb-4">
            <h5>معلومات مسار الإنتاج</h5>
            <div class="mb-3 row">
                <label for="code" class="col-sm-2 col-form-label">الكود <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="code" value="000002">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-sm-2 col-form-label">الاسم <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name">
                </div>
            </div>
        </div>

        <!-- المرحلة الإنتاجية -->
        <div>
            <h5>المرحلة الإنتاجية</h5>
            <table class="table table-bordered" id="productionTable">
                <thead>
                    <tr>
                        <th style="width: 10%;">رقم</th>
                        <th>الاسم</th>
                        <th style="width: 10%;">حذف</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td><input type="text" class="form-control" placeholder="أدخل الاسم"></td>
                        <td><button class="btn btn-danger btn-sm delete-row"><i class="bi bi-trash"></i></button></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td><input type="text" class="form-control" placeholder="أدخل الاسم"></td>
                        <td><button class="btn btn-danger btn-sm delete-row"><i class="bi bi-trash"></i></button></td>
                    </tr>
                </tbody>
            </table>
            <button class="btn btn-success" id="addRowBtn">إضافة +</button>
        </div>
    </div>
</div>

<script>
    // مرجع للجدول
    const productionTable = document.getElementById("productionTable").getElementsByTagName("tbody")[0];
    const addRowBtn = document.getElementById("addRowBtn");

    // دالة لإضافة صف جديد
    addRowBtn.addEventListener("click", () => {
        const newRow = productionTable.insertRow();
        const rowIndex = productionTable.rows.length;

        // الخلايا الجديدة
        const cell1 = newRow.insertCell(0);
        const cell2 = newRow.insertCell(1);
        const cell3 = newRow.insertCell(2);

        // إضافة البيانات إلى الخلايا
        cell1.textContent = rowIndex;
        cell2.innerHTML = `<input type="text" class="form-control" placeholder="أدخل الاسم">`; // حقل الإدخال
        cell3.innerHTML = `<button class="btn btn-danger btn-sm delete-row"><i class="bi bi-trash"></i></button>`;

        // تحديث الحدث للنقر على أيقونة الحذف
        attachDeleteEvent();
    });

    // دالة لحذف الصف
    function attachDeleteEvent() {
        const deleteButtons = document.querySelectorAll(".delete-row");
        deleteButtons.forEach((btn) => {
            btn.addEventListener("click", (e) => {
                const row = e.target.closest("tr");
                row.remove();

                // تحديث أرقام الصفوف بعد الحذف
                updateRowNumbers();
            });
        });
    }

    // تحديث أرقام الصفوف
    function updateRowNumbers() {
        const rows = productionTable.rows;
        for (let i = 0; i < rows.length; i++) {
            rows[i].cells[0].textContent = i + 1;
        }
    }

    // تفعيل الحذف عند التحميل الأول
    attachDeleteEvent();
</script>

@endsection
