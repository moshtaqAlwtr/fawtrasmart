@extends('master')

@section('title')
 أضافة أمر تصنيع
@stop

@section('content')

    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">أضافة أمر تصنيع</h2>
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
\


    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                </div>
    
                <div>
                    <a href="" class="btn btn-outline-danger">
                        <i class="fa fa-ban"></i>الغاء
                    </a>
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fa fa-save"></i>حفظ
                    </button>
                </div>
    
            </div>
        </div>
    </div>
        <div class="card mt-4">
           <div class="card-body">
            <form>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="name" class="form-label">الاسم</label>
                        <input type="text" class="form-control" id="name" required>
                    </div>
                    <div class="col-md-3">
                        <label for="code" class="form-label">الكود</label>
                        <input type="text" class="form-control" id="code" value="000001" required>
                    </div>
                    <div class="col-md-3">
                        <label for="date" class="form-label">التاريخ من</label>
                        <input type="date" class="form-control" id="date" required>
                    </div>
                    <div class="col-md-3">
                        <label for="date" class="form-label">التاريخ ألى</label>
                        <input type="date" class="form-control" id="date" required>
                    </div>
               
                </div>
                
               
            <div class="row mb-3">
             
                <div class="col-md-6">
                    <label for="account" class="form-label">الحساب <span class="text-danger">*</span></label>
                    <select class="form-control" id="account" required>
                        <option value="">اختر الحساب</option>
                        <option value="1">حساب 1</option>
                        <option value="2">حساب 2</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="account" class="form-label">الموظفين <span class="text-danger">*</span></label>
                    <select class="form-control" id="account" required>
                        <option value="">اختر موظف</option>
                        <option value="1">موظف 1</option>
                        <option value="2">موظف 2</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="account" class="form-label">العميل <span class="text-danger">*</span></label>
                    <select class="form-control" id="account" required>
                        <option value="">اختر العميل</option>
                        <option value="1">عميل 1</option>
                        <option value="2">عميل 2</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="products" class="form-label">المنتجات <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="products" required>
                </div>
                <div class="col-md-6">
                    <label for="products" class="form-label">الكمية <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="products" required>
                </div>
                <div class="col-md-6">
                    <label for="products" class="form-label">قائمة المواد<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="products" required>
                </div>
                <div class="col-md-6">
                    <label for="products" class="form-label">مسار الأنتاج <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="products" required>
                </div>
            </div>
   
           
            <div class="card mt-4">
                <div class="card-body">
                <h4>المواد الخام</h4>
                <table class="table table-bordered table-striped text-center align-middle">
                    <thead class="table-light">
                                <tr>
                                    <th>المنتجات</th>
                                    <th>الكمية</th>
                                    <th>السعر</th>
                                    <th>المرحلة الإنتاجية</th>
                                    <th>المجموع</th>
                                    <th>إجراءات</th>
                                </tr>
                            </thead>
                            <tbody id="raw-materials-body">
                                <tr>
                                    <td>
                                        <select class="form-select form-select-sm">
                                            <option value="">اختر المنتج</option>
                                            <option value="1">منتج 1</option>
                                            <option value="2">منتج 2</option>
                                        </select>
                                    </td>
                                    <td><input type="number" class="form-control form-control-sm quantity" step="0.01" value="0"></td>
                                    <td><input type="number" class="form-control form-control-sm price" step="0.01" value="0"></td>
                                    <td>
                                        <select class="form-select form-select-sm">
                                            <option value="">اختر المرحلة</option>
                                            <option value="1">مرحلة 1</option>
                                            <option value="2">مرحلة 2</option>
                                        </select>
                                    </td>
                                    <td class="row-total">0.00</td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm remove-row">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end fw-bold">الإجمالي</td>
                                    <td id="total-amount">0.00</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                        <button type="button" class="btn btn-primary btn-sm m-3" id="add-raw-material-row">
                            <i class="bi bi-plus"></i> إضافة
                        </button>
                    </div>
                </div>
            </div>
                         
                <!-- المواد الخام -->

                    <div class="card mt-4">
                        <div class="card-body">
                        <h4>المصروفات</h4>
                        <table class="table table-bordered table-striped text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>الحساب</th>
                                    <th>نوع التكلفة</th>
                                    <th>المبلغ</th>
                                    <th>الوصف</th>
                                    <th>المرحلة الإنتاجية</th>
                                    <th>المجموع</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="expensesTable">
                                <tr>
                                    <td><input type="text" class="form-control form-control-sm" placeholder="الحساب"></td>
                                    <td>
                                        <select class="form-select form-select-sm">
                                            <option value="fixed">مبلغ ثابت</option>
                                            <option value="variable">مبلغ متغير</option>
                                        </select>
                                    </td>
                                    <td class="row-total">0.00</td>
                                   
                                    <td><input type="text" class="form-control form-control-sm" placeholder="الوصف"></td>
                                    <td>
                                        <select class="form-select form-select-sm">
                                            <option value="1">المرحلة 1</option>
                                            <option value="2">المرحلة 2</option>
                                        </select>
                                    </td>
                                    <td class="row-total">0.00</td>
                                    
                                 
                                 
                                    <td>
                                        <button class="btn btn-outline-danger btn-sm remove-row">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                
                                <tr>
                                    
                                    <td colspan="0" class="text-start">
                                        <button id="addRowBtn" class="btn btn-success btn-sm">إضافة +</button>
                                       
                                    </td>
                                    <td colspan="25" class="text-end">
                                        <strong>الإجمالي:</strong> <span id="totalAmount">0.00</span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-body">
                <h4>عمليات التصنيع</h4>
                <table class="table table-bordered table-striped text-center align-middle">
                    <thead class="table-light">
                                <tr>
                                    <th>محطة العمل</th>
                                    <th>نوع التكلفة</th>
                                    <th>وقت التشغيل</th>
                                    <th>الوصف</th>
                                    <th>المرحلة الإنتاجية</th>
                                    <th>المجموع</th>
                                    <th>إجراءات</th>
                                </tr>
                            </thead>
                            <tbody id="manufacturing-body">
                                <tr>
                                    <td>
                                        <select class="form-select form-select-sm">
                                            <option value="">اختر المحطة</option>
                                            <option value="1">محطة 1</option>
                                            <option value="2">محطة 2</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-select form-select-sm">
                                            <option value="">اختر النوع</option>
                                            <option value="fixed">مبلغ ثابت</option>
                                            <option value="variable">مبلغ متغير</option>
                                        </select>
                                    </td>
                                    <td><input type="number" class="form-control form-control-sm runtime" step="0.01" value="0"></td>
                                    <td><input type="text" class="form-control form-control-sm" placeholder="الوصف"></td>
                                    <td>
                                        <select class="form-select form-select-sm">
                                            <option value="">اختر المرحلة</option>
                                            <option value="1">مرحلة 1</option>
                                            <option value="2">مرحلة 2</option>
                                        </select>
                                    </td>
                                    <td class="row-total">0.00</td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm remove-row">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-end fw-bold">الإجمالي</td>
                                    <td id="total-amount">0.00</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                        <button type="button" class="btn btn-primary btn-sm m-3" id="add-manufacturing-row">
                            <i class="bi bi-plus"></i> إضافة
                        </button>
                    </div>
                </div>
                <div class="card mt-4">
                    <!-- المواد الهالكة -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">المواد الهالكة <span class="badge bg-secondary" id="row-count">(1)</span></h5>
                            <button class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-chevron-down"></i>
                            </button>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-bordered text-center mb-0">
                                <thead>
                                    <tr>
                                        <th>المنتجات</th>
                                        <th>الكمية</th>
                                        <th>السعر</th>
                                        <th>المرحلة الإنتاجية</th>
                                        <th>المجموع</th>
                                        <th>إجراءات</th>
                                    </tr>
                                </thead>
                                <tbody id="waste-materials-body">
                                    <tr>
                                        <td>
                                            <select class="form-select form-select-sm">
                                                <option value="">اختر المنتج</option>
                                                <option value="1">منتج 1</option>
                                                <option value="2">منتج 2</option>
                                            </select>
                                        </td>
                                        <td><input type="number" class="form-control form-control-sm quantity" step="0.01" value="0"></td>
                                        <td><input type="number" class="form-control form-control-sm price" step="0.01" value="0"></td>
                                        <td>
                                            <select class="form-select form-select-sm">
                                                <option value="">اختر المرحلة</option>
                                                <option value="1">مرحلة 1</option>
                                                <option value="2">مرحلة 2</option>
                                            </select>
                                        </td>
                                        <td class="row-total">0.00</td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm remove-row">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-end fw-bold">الإجمالي</td>
                                        <td id="total-amount">0.00</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <button type="button" class="btn btn-primary btn-sm m-3" id="add-waste-material-row">
                                <i class="bi bi-plus"></i> إضافة
                            </button>
                        </div>
                    </div>
                    <!-- التكلفة الإجمالية -->
                    <div class="mt-3 text-center">
                        <h5 class="bg-dark text-white py-2">إجمالي التكلفة: <span id="final-total">0.00</span> ريال</h5>
                    </div>
                </div>
            <script>
                // Function to add a new row
                function addRow() {
                    const tableBody = document.getElementById('raw-materials-body');
                    const newRow = `
                        <tr>
                            <td>
                                <select class="form-select form-select-sm">
                                    <option value="">اختر المنتج</option>
                                    <option value="1">منتج 1</option>
                                    <option value="2">منتج 2</option>
                                </select>
                            </td>
                            <td><input type="number" class="form-control form-control-sm" step="0.01"></td>
                            <td><input type="number" class="form-control form-control-sm" step="0.01"></td>
                            <td>
                                <select class="form-select form-select-sm">
                                    <option value="">اختر المرحلة</option>
                                    <option value="1">مرحلة 1</option>
                                    <option value="2">مرحلة 2</option>
                                </select>
                            </td>
                            <td>0.00</td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm remove-row">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    tableBody.insertAdjacentHTML('beforeend', newRow);
                }
        
                // Add row event listener
                document.getElementById('add-raw-material-row').addEventListener('click', addRow);
        
                // Remove row functionality
                document.body.addEventListener('click', function (e) {
                    if (e.target.closest('.remove-row')) {
                        e.target.closest('tr').remove();
                    }
                });
            </script>
        
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const expensesTable = document.getElementById("expensesTable");
                const totalAmountEl = document.getElementById("totalAmount");
        
                // إضافة صف جديد
                document.getElementById("addRowBtn").addEventListener("click", () => {
                    const newRow = `
              <tr>
                                    <td><input type="text" class="form-control form-control-sm" placeholder="الحساب"></td>
                                    <td>
                                        <select class="form-select form-select-sm">
                                            <option value="fixed">مبلغ ثابت</option>
                                            <option value="variable">مبلغ متغير</option>
                                        </select>
                                    </td>
                                    <td class="row-total">0.00</td>
                                   
                                    <td><input type="text" class="form-control form-control-sm" placeholder="الوصف"></td>
                                    <td>
                                        <select class="form-select form-select-sm">
                                            <option value="1">المرحلة 1</option>
                                            <option value="2">المرحلة 2</option>
                                        </select>
                                    </td>
                                    <td class="row-total">0.00</td>
                                    
                                 
                                 
                                    <td>
                                        <button class="btn btn-outline-danger btn-sm remove-row">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
            `;
                    expensesTable.insertAdjacentHTML("beforeend", newRow);
                    updateTotal();
                });
        
                // إزالة صف
                expensesTable.addEventListener("click", (e) => {
                    if (e.target.closest(".remove-row")) {
                        e.target.closest("tr").remove();
                        updateTotal();
                    }
                });
        
                // تحديث المجموع لكل صف
                expensesTable.addEventListener("input", (e) => {
                    if (e.target.classList.contains("amount-input")) {
                        const row = e.target.closest("tr");
                        const amount = parseFloat(e.target.value) || 0;
                        row.querySelector(".row-total").textContent = amount.toFixed(2);
                        updateTotal();
                    }
                });
        
                // حساب الإجمالي
                function updateTotal() {
                    let total = 0;
                    document.querySelectorAll(".row-total").forEach((cell) => {
                        total += parseFloat(cell.textContent) || 0;
                    });
                    totalAmountEl.textContent = total.toFixed(2);
                }
            });
        </script>
    
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const manufacturingBody = document.getElementById("manufacturing-body");
        const totalAmountEl = document.getElementById("total-amount");
        const rowCountEl = document.getElementById("row-count");

        // إضافة صف جديد
        document.getElementById("add-manufacturing-row").addEventListener("click", () => {
            const newRow = `
            <tr>
                <td>
                    <select class="form-select form-select-sm">
                        <option value="">اختر المحطة</option>
                        <option value="1">محطة 1</option>
                        <option value="2">محطة 2</option>
                    </select>
                </td>
                <td>
                    <select class="form-select form-select-sm">
                        <option value="">اختر النوع</option>
                        <option value="fixed">مبلغ ثابت</option>
                        <option value="variable">مبلغ متغير</option>
                    </select>
                </td>
                <td><input type="number" class="form-control form-control-sm runtime" step="0.01" value="0"></td>
                <td><input type="text" class="form-control form-control-sm" placeholder="الوصف"></td>
                <td>
                    <select class="form-select form-select-sm">
                        <option value="">اختر المرحلة</option>
                        <option value="1">مرحلة 1</option>
                        <option value="2">مرحلة 2</option>
                    </select>
                </td>
                <td class="row-total">0.00</td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-row">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>`;
            manufacturingBody.insertAdjacentHTML("beforeend", newRow);
            updateRowCount();
        });

        // إزالة صف
        manufacturingBody.addEventListener("click", (e) => {
            if (e.target.closest(".remove-row")) {
                e.target.closest("tr").remove();
                updateTotal();
                updateRowCount();
            }
        });

        // تحديث المجموع لكل صف
        manufacturingBody.addEventListener("input", (e) => {
            if (e.target.classList.contains("runtime")) {
                const row = e.target.closest("tr");
                const runtime = parseFloat(row.querySelector(".runtime").value) || 0;
                const rowTotal = (runtime).toFixed(2); // يمكن التعديل لحساب أكثر تعقيدًا
                row.querySelector(".row-total").textContent = rowTotal;
                updateTotal();
            }
        });

        // تحديث العدد الكلي للصفوف
        function updateRowCount() {
            const rowCount = manufacturingBody.querySelectorAll("tr").length;
            rowCountEl.textContent = `(${rowCount})`;
        }

        // تحديث الإجمالي الكلي
        function updateTotal() {
            let total = 0;
            manufacturingBody.querySelectorAll(".row-total").forEach((cell) => {
                total += parseFloat(cell.textContent) || 0;
            });
            totalAmountEl.textContent = total.toFixed(2);
        }

        // تحديث العدد والإجمالي عند البداية
        updateRowCount();
        updateTotal();
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const materialsBody = document.getElementById("waste-materials-body");
        const totalAmountEl = document.getElementById("total-amount");
        const finalTotalEl = document.getElementById("final-total");
        const rowCountEl = document.getElementById("row-count");

        // إضافة صف جديد
        document.getElementById("add-waste-material-row").addEventListener("click", () => {
            const newRow = `
            <tr>
                <td>
                    <select class="form-select form-select-sm">
                        <option value="">اختر المنتج</option>
                        <option value="1">منتج 1</option>
                        <option value="2">منتج 2</option>
                    </select>
                </td>
                <td><input type="number" class="form-control form-control-sm quantity" step="0.01" value="0"></td>
                <td><input type="number" class="form-control form-control-sm price" step="0.01" value="0"></td>
                <td>
                    <select class="form-select form-select-sm">
                        <option value="">اختر المرحلة</option>
                        <option value="1">مرحلة 1</option>
                        <option value="2">مرحلة 2</option>
                    </select>
                </td>
                <td class="row-total">0.00</td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-row">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>`;
            materialsBody.insertAdjacentHTML("beforeend", newRow);
            updateRowCount();
        });

        // إزالة صف
        materialsBody.addEventListener("click", (e) => {
            if (e.target.closest(".remove-row")) {
                e.target.closest("tr").remove();
                updateTotal();
                updateRowCount();
            }
        });

        // تحديث المجموع لكل صف
        materialsBody.addEventListener("input", (e) => {
            if (e.target.classList.contains("quantity") || e.target.classList.contains("price")) {
                const row = e.target.closest("tr");
                const quantity = parseFloat(row.querySelector(".quantity").value) || 0;
                const price = parseFloat(row.querySelector(".price").value) || 0;
                const rowTotal = (quantity * price).toFixed(2);
                row.querySelector(".row-total").textContent = rowTotal;
                updateTotal();
            }
        });

        // تحديث العدد الكلي للصفوف
        function updateRowCount() {
            const rowCount = materialsBody.querySelectorAll("tr").length;
            rowCountEl.textContent = `(${rowCount})`;
        }

        // تحديث الإجمالي الكلي
        function updateTotal() {
            let total = 0;
            materialsBody.querySelectorAll(".row-total").forEach((cell) => {
                total += parseFloat(cell.textContent) || 0;
            });
            totalAmountEl.textContent = total.toFixed(2);
            finalTotalEl.textContent = total.toFixed(2);
        }

        // تحديث العدد والإجمالي عند البداية
        updateRowCount();
        updateTotal();
    });
</script>
    @endsection