@extends('master')

@section('title')
أضافة تكاليف غير مباشرة 
@stop

@section('content')

<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">أضافة تكاليف غير مباشرة </h2>
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
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<div class="card mt-4">
    <div class="card-body">
        <h4 class="mb-4">معلومات التكلفة غير المباشرة</h4>
        
        <!-- الحقول الجديدة -->
        <div class="row mb-4">
            <div class="col-md-4">
                <label for="accountSelect" class="form-label">الحساب <span style="color: red">*</span></label>
                <select id="accountSelect" class="form-control">
                    <option value="" disabled selected>اختر الحساب</option>
                    <option value="1">حساب 1</option>
                    <option value="2">حساب 2</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="startDate" class="form-label">تاريخ البدء <span style="color: red">*</span></label>
                <input type="date" id="startDate" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="endDate" class="form-label">تاريخ الانتهاء <span style="color: red">*</span></label>
                <input type="date" id="endDate" class="form-control">
            </div>
        </div>

        <!-- أزرار الراديو -->
        <div class="mb-4">
            <label class="form-label">نوع التوزيع <span style="color: red">*</span></label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="distributionType" id="quantityBased" value="quantity" checked>
                    <label class="form-check-label" for="quantityBased">بناء على الكمية</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="distributionType" id="costBased" value="cost">
                    <label class="form-check-label" for="costBased">بناء على التكلفة</label>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-body">
                <h4 class="mb-4">القيود اليومية</h4>
                <table class="table table-bordered" id="dailyCostTable">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50%;">المبلغ</th>
                            <th style="width: 40%;">المجموع</th>
                            <th style="width: 10%;">حذف</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="number" class="form-control" value="0"></td>
                            <td class="text-center total-cell">0</td>
                            <td class="text-center">
                                <button class="btn btn-danger btn-sm delete-row">🗑️</button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="1" class="text-center">الإجمالي</td>
                            <td class="text-center" id="totalDailyCost">0</td>
                        </tr>
                    </tfoot>
                </table>
                <div class="d-flex">
                    <button class="btn btn-secondary me-2" id="addDailyBulkRows">إضافة بالجملة</button>
                    <button class="btn btn-primary" id="addDailyCostRow">إضافة</button>
                </div>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-body">
                <h4 class="mb-4">أوامر التصنيع</h4>
                <table class="table table-bordered" id="manufacturingTable">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50%;">المبلغ</th>
                            <th style="width: 40%;">المجموع</th>
                            <th style="width: 10%;">حذف</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="number" class="form-control" value="0"></td>
                            <td class="text-center total-cell">0</td>
                            <td class="text-center">
                                <button class="btn btn-danger btn-sm delete-row">🗑️</button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="1" class="text-center">الإجمالي</td>
                            <td class="text-center" id="totalManufacturingCost">0</td>
                        </tr>
                    </tfoot>
                </table>
                <div class="d-flex">
                    <button class="btn btn-secondary me-2" id="addManufacturingBulkRows">إضافة بالجملة</button>
                    <button class="btn btn-primary" id="addManufacturingRow">إضافة</button>
                </div>
            </div>
        </div>
        
        <script>
            // تحديث الإجمالي عند التغيير في أي خلية من الخلايا
            function updateTotal(table, totalElementId) {
                const rows = table.querySelectorAll('tbody tr');
                let total = 0;
                rows.forEach(row => {
                    const amount = row.querySelector('td input').value;
                    total += parseFloat(amount) || 0;
                });
                document.getElementById(totalElementId).innerText = total.toFixed(2);
            }
        
            // التعامل مع الجدول الأول (القيود اليومية)
            const dailyCostTable = document.getElementById('dailyCostTable');
            const addDailyCostRow = document.getElementById('addDailyCostRow');
            const addDailyBulkRows = document.getElementById('addDailyBulkRows');
        
            const addRowToTable = (tableBody) => {
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td><input type="number" class="form-control" value="0"></td>
                    <td class="text-center total-cell">0</td>
                    <td class="text-center">
                        <button class="btn btn-danger btn-sm delete-row">🗑️</button>
                    </td>
                `;
                tableBody.appendChild(newRow);
                updateTotal(dailyCostTable, 'totalDailyCost');
            };
        
            addDailyCostRow.addEventListener('click', () => {
                const tableBody = dailyCostTable.querySelector('tbody');
                addRowToTable(tableBody);
            });
        
            addDailyBulkRows.addEventListener('click', () => {
                const tableBody = dailyCostTable.querySelector('tbody');
                const bulkCount = prompt("كم عدد الصفوف التي ترغب في إضافتها؟", "3");
                if (bulkCount && !isNaN(bulkCount)) {
                    for (let i = 0; i < Number(bulkCount); i++) {
                        addRowToTable(tableBody);
                    }
                }
            });
        
            dailyCostTable.addEventListener('input', (event) => {
                if (event.target.type === 'number') {
                    updateTotal(dailyCostTable, 'totalDailyCost');
                }
            });
        
            dailyCostTable.addEventListener('click', (event) => {
                if (event.target.classList.contains('delete-row')) {
                    event.target.closest('tr').remove();
                    updateTotal(dailyCostTable, 'totalDailyCost');
                }
            });
        
            // التعامل مع الجدول الثاني (أوامر التصنيع)
            const manufacturingTable = document.getElementById('manufacturingTable');
            const addManufacturingRow = document.getElementById('addManufacturingRow');
            const addManufacturingBulkRows = document.getElementById('addManufacturingBulkRows');
        
            addManufacturingRow.addEventListener('click', () => {
                const tableBody = manufacturingTable.querySelector('tbody');
                addRowToTable(tableBody);
            });
        
            addManufacturingBulkRows.addEventListener('click', () => {
                const tableBody = manufacturingTable.querySelector('tbody');
                const bulkCount = prompt("كم عدد الصفوف التي ترغب في إضافتها؟", "3");
                if (bulkCount && !isNaN(bulkCount)) {
                    for (let i = 0; i < Number(bulkCount); i++) {
                        addRowToTable(tableBody);
                    }
                }
            });
        
            manufacturingTable.addEventListener('input', (event) => {
                if (event.target.type === 'number') {
                    updateTotal(manufacturingTable, 'totalManufacturingCost');
                }
            });
        
            manufacturingTable.addEventListener('click', (event) => {
                if (event.target.classList.contains('delete-row')) {
                    event.target.closest('tr').remove();
                    updateTotal(manufacturingTable, 'totalManufacturingCost');
                }
            });
        </script>
        
@endsection



