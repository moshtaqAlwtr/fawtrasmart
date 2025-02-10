@extends('master')

@section('title')
أضافة محطة عمل
@stop

@section('content')

<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">أضافة محطة عمل</h2>
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

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
            </div>
            <div>
                <a href="" class="btn btn-outline-danger">
                    <i class="fa fa-ban"></i> الغاء
                </a>
                <button type="submit" class="btn btn-outline-primary">
                    <i class="fa fa-save"></i> حفظ
                </button>
            </div>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<div class="card mt-4">
    <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">الاسم</label>
                    <input type="text" class="form-control" id="name" required>
                </div>
                <div class="col-md-6">
                    <label for="code" class="form-label">الكود</label>
                    <input type="text" class="form-control" id="code" value="000001" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="unit" class="form-label">الوحدة</label>
                    <input type="text" class="form-control" id="unit" required>
                </div>
                <div class="col-md-6">
                    <label for="description" class="form-label">الوصف</label>
                    <input type="text" class="form-control" id="description" required>
                </div>
            </div>

<div class="card mt-4">
    <div class="card-body">
        <h4 class="mb-4">المصروفات</h4>
        <table class="table table-bordered" id="dailyCostTable">
            <thead class="table-light">
                <tr>
                    <th style="width: 50%;">التكلفة</th>
                    <th style="width: 40%;">الحساب</th>
                    <th style="width: 10%;">حذف</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="number" class="form-control" value="0"></td>
                    <td><input type="number" class="form-control" value="0"></td>
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
        <h4 class="mb-4">الأصل</h4>
        <table class="table table-bordered" id="assetsTable">
            <thead class="table-light">
                <tr>
                    <th style="width: 50%;">التكلفة</th>
                    <th style="width: 40%;">أصل</th>
                    <th style="width: 10%;">حذف</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="number" class="form-control" value="0"></td>
                    <td><input type="number" class="form-control" value="0"></td>
                    <td class="text-center">
                        <button class="btn btn-danger btn-sm delete-row">🗑️</button>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="1" class="text-center">الإجمالي</td>
                    <td class="text-center" id="totalAssetsCost">0</td>
                </tr>
            </tfoot>
        </table>
        <div class="d-flex">
            <button class="btn btn-secondary me-2" id="addAssetsBulkRows">إضافة بالجملة</button>
            <button class="btn btn-primary" id="addAssetsRow">إضافة</button>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-body">
        <h4 class="mb-4">الأجور</h4>
        <table class="table table-bordered" id="manufacturingTable">
            <thead class="table-light">
                <tr>
                    <th style="width: 50%;">التكلفة</th>
                    <th style="width: 40%;">الحساب</th>
                    <th style="width: 10%;">حذف</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="number" class="form-control" value="0"></td>
                    <td><input type="number" class="form-control" value="0"></td>
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
    // Function to add a new row to a table
    function addRowToTable(tableBody) {
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td><input type="number" class="form-control" value="0"></td>
            <td><input type="number" class="form-control" value="0"></td>
            <td class="text-center">
                <button class="btn btn-danger btn-sm delete-row">🗑️</button>
            </td>
        `;
        tableBody.appendChild(newRow);
    }

    // Function to update the total of a table
    function updateTotal(table, totalId) {
        const inputs = table.querySelectorAll('tbody input[type="number"]');
        let total = 0;
        inputs.forEach(input => {
            total += parseFloat(input.value) || 0;
        });
        document.getElementById(totalId).textContent = total.toFixed(2);
    }

    // Initialize assets table
    const assetsTable = document.getElementById('assetsTable');
    const addAssetsRow = document.getElementById('addAssetsRow');
    const addAssetsBulkRows = document.getElementById('addAssetsBulkRows');

    addAssetsRow.addEventListener('click', () => {
        const tableBody = assetsTable.querySelector('tbody');
        addRowToTable(tableBody);
        updateTotal(assetsTable, 'totalAssetsCost');
    });

    addAssetsBulkRows.addEventListener('click', () => {
        const tableBody = assetsTable.querySelector('tbody');
        const bulkCount = prompt("كم عدد الصفوف التي ترغب في إضافتها؟", "3");
        if (bulkCount && !isNaN(bulkCount)) {
            for (let i = 0; i < Number(bulkCount); i++) {
                addRowToTable(tableBody);
            }
        }
        updateTotal(assetsTable, 'totalAssetsCost');
    });

    assetsTable.addEventListener('input', (event) => {
        if (event.target.type === 'number') {
            updateTotal(assetsTable, 'totalAssetsCost');
        }
    });

    assetsTable.addEventListener('click', (event) => {
        if (event.target.classList.contains('delete-row')) {
            event.target.closest('tr').remove();
            updateTotal(assetsTable, 'totalAssetsCost');
        }
    });

    // Initialize manufacturing table
    const manufacturingTable = document.getElementById('manufacturingTable');
    const addManufacturingRow = document.getElementById('addManufacturingRow');
    const addManufacturingBulkRows = document.getElementById('addManufacturingBulkRows');

    addManufacturingRow.addEventListener('click', () => {
        const tableBody = manufacturingTable.querySelector('tbody');
        addRowToTable(tableBody);
        updateTotal(manufacturingTable, 'totalManufacturingCost');
    });

    addManufacturingBulkRows.addEventListener('click', () => {
        const tableBody = manufacturingTable.querySelector('tbody');
        const bulkCount = prompt("كم عدد الصفوف التي ترغب في إضافتها؟", "3");
        if (bulkCount && !isNaN(bulkCount)) {
            for (let i = 0; i < Number(bulkCount); i++) {
                addRowToTable(tableBody);
            }
        }
        updateTotal(manufacturingTable, 'totalManufacturingCost');
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
