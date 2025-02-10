@extends('master')

@section('title')
قوائم مواد الإنتاج
@stop

@section('css')
    <style>
        .section-header {
            cursor: pointer; /* تغيير المؤشر إلى يد للإشارة إلى أنه قابل للنقر */
            font-weight: bold;
        }
    </style>
@endsection

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">قوائم مواد الإنتاج</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a>
                            </li>
                            <li class="breadcrumb-item active">اضافة
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">
        <div class="container-fluid">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                            </div>

                            <div>
                                <a href="{{ route('BOM.index') }}" class="btn btn-outline-danger">
                                    <i class="fa fa-ban"></i>الغاء
                                </a>
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fa fa-save"></i>حفظ
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <h4 class="card-title">معلومات قائمة مواد الإنتاج</h4>
                        </div>

                        <div class="card-body">
                            <div class="row">

                                <div class="form-group col-md-4">
                                    <label for="">الاسم <span style="color: red">*</span></label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">كود <span style="color: red">*</span></label>
                                    <input type="text" class="form-control" name="code" value="{{ old('code') }}">
                                </div>

                                <div class="form-group col-md-2 mt-2">
                                    <div class="custom-control custom-switch custom-switch-success custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch1">
                                        <label class="custom-control-label" for="customSwitch1">
                                        </label>
                                        <span class="switch-label">نشط</span>
                                    </div>
                                </div>

                                <div class="form-group col-md-2 mt-2">
                                    <div class="custom-control custom-switch custom-switch-success custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch2">
                                        <label class="custom-control-label" for="customSwitch1">
                                        </label>
                                        <span class="switch-label">غير نشط</span>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">المنتجات <span class="text-danger">*</span></label>
                                    <select class="form-control" name="store_houses_id">
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" {{ old('store_houses_id') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">الحساب <span class="text-danger">*</span></label>
                                    <select class="form-control" id="basicSelect" name="sub_account">
                                        <option value="1" {{ old('sub_account') == 0 ? 'selected' : '' }}>الحساب الفرعي 1</option>
                                        <option value="2" {{ old('sub_account') == 1 ? 'selected' : '' }}>الحساب الفرعي 2</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>الكمية <span style="color: red">*</span></label>
                                    <input type="number" class="form-control" name="number" value="{{ old('number') }}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">مسار الانتاج <span class="text-danger">*</span></label>
                                    <select class="form-control" id="basicSelect" name="sub_account">
                                        <option value="1" {{ old('sub_account') == 0 ? 'selected' : '' }}>الحساب الفرعي 1</option>
                                        <option value="2" {{ old('sub_account') == 1 ? 'selected' : '' }}>الحساب الفرعي 2</option>
                                    </select>
                                </div>

                                <br>

                                <div class="form-group col-md-12">
                                    <p onclick="toggleSection('rawMaterials')" class="d-flex justify-content-between section-header" style="background: #DBDEE2; width: 100%;">
                                        <span class="p-1 font-weight-bold"><i class="feather icon-package"></i> المواد الخام (<span id="rawMaterialCount">0</span>)</span>
                                        <i class="feather icon-plus-circle p-1"></i>
                                    </p>
                                    <div id="rawMaterials">
                                        <table class="table table-striped" id="itemsTable">
                                            <thead style="background: #f8f8f8">
                                                <tr>
                                                    <th>المنتجات</th>
                                                    <th>سعر الوحدة</th>
                                                    <th>الكمية</th>
                                                    <th>المرحلة الإنتاجية</th>
                                                    <th>الإجمالي</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                        <hr>
                                        <div class="d-flex justify-content-between mt-2">
                                            <button type="button" class="btn btn-outline-success btn-sm" id="addRow"><i class="fa fa-plus"></i> إضافة</button>
                                            <strong style="margin-left: 13rem;"><small class="text-muted">الإجمالي الكلي : </small><span class="grand-total">0.00</span></strong>
                                        </div>
                                    </div>
                                </div>
                                <br><hr>

                                <div class="form-group col-md-12">
                                    <p onclick="toggleSection('expenses')" class="d-flex justify-content-between section-header" style="background: #DBDEE2; width: 100%;">
                                        <span class="p-1 font-weight-bold"><i class="fa fa-money"></i> المصروفات (<span id="rowExpensesCount">0</span>)</span>
                                        <i class="feather icon-plus-circle p-1"></i>
                                    </p>
                                    <div id="expenses" style="display: none">
                                        <table class="table table-striped" id="ExpensesTable">
                                            <thead style="background: #f8f8f8">
                                                <tr>
                                                    <th>الحساب</th>
                                                    <th>نوع التكلفة</th>
                                                    <th>المبلغ</th>
                                                    <th>الوصف</th>
                                                    <th>المرحلة الإنتاجية</th>
                                                    <th>الإجمالي</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                        <hr>
                                        <div class="d-flex justify-content-between mt-2">
                                            <button type="button" class="btn btn-outline-success btn-sm" id="ExpensesAddRow"><i class="fa fa-plus"></i> إضافة</button>
                                            <strong style="margin-left: 13rem;"><small class="text-muted">الإجمالي الكلي : </small><span class="expenses-grand-total">0.00</span></strong>
                                        </div>
                                    </div>
                                </div>
                                <br><hr>

                                <div class="form-group col-md-12">
                                    <p onclick="toggleSection('manufacturing')" class="d-flex justify-content-between section-header" style="background: #DBDEE2; width: 100%;">
                                        <span class="p-1 font-weight-bold"><i class="feather icon-settings"></i> عمليات التصنيع (<span id="manufacturingCount">0</span>)</span>
                                        <i class="feather icon-plus-circle p-1"></i>
                                    </p>
                                    <div id="manufacturing" style="display: none">
                                        <table class="table table-striped" id="manufacturingTable">
                                            <thead style="background: #f8f8f8">
                                                <tr>
                                                    <th>محطة العمل</th>
                                                    <th>نوع التكلفة</th>
                                                    <th>المبلغ</th>
                                                    <th>الوصف</th>
                                                    <th>المرحلة الإنتاجية</th>
                                                    <th>الإجمالي</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                        <hr>
                                        <div class="d-flex justify-content-between mt-2">
                                            <button type="button" class="btn btn-outline-success btn-sm" id="manufacturingAddRow"><i class="fa fa-plus"></i> إضافة</button>
                                            <strong style="margin-left: 13rem;"><small class="text-muted">الإجمالي الكلي : </small><span class="manufacturing-grand-total">0.00</span></strong>
                                        </div>
                                    </div>
                                </div>
                                <br><hr>

                                <div class="form-group col-md-12">
                                    <p onclick="toggleSection('endLife')" class="d-flex justify-content-between section-header" style="background: #DBDEE2; width: 100%;">
                                        <span class="p-1 font-weight-bold"><i class="feather icon-trash-2"></i> المواد الهالكة (<span id="EndLifeCount">0</span>)</span>
                                        <i class="feather icon-plus-circle p-1"></i>
                                    </p>
                                    <div id="endLife" style="display: none">
                                        <table class="table table-striped" id="EndLifeTable">
                                            <thead style="background: #f8f8f8">
                                                <tr>
                                                    <th>المنتجات</th>
                                                    <th>الكمية</th>
                                                    <th>السعر</th>
                                                    <th>المرحلة الإنتاجية</th>
                                                    <th>الإجمالي</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                        <hr>
                                        <div class="d-flex justify-content-between mt-2">
                                            <button type="button" class="btn btn-outline-success btn-sm" id="EndLifeAddRow"><i class="fa fa-plus"></i> إضافة</button>
                                            <strong style="margin-left: 13rem;"><small class="text-muted">الإجمالي الكلي : </small><span class="end-life-grand-total">0.00</span></strong>
                                        </div>
                                    </div>
                                </div>
                                <br><hr>

                                <div class="form-group col-md-6"></div>

                                <div class="form-group col-md-6">
                                    <div class="d-flex justify-content-between p-1" style="background: #CCF5FA;">
                                        <strong>إجمالي التكلفة : </strong>
                                        <strong class="total-cost">0.00 ر.س</strong>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')

    <script>
        // Function to update the raw material count
        function updateRawMaterialCount() {
            const rowCount = document.querySelectorAll('#itemsTable tbody tr').length;
            document.getElementById('rawMaterialCount').textContent = rowCount;
        }
        // Function to update the raw material count
        function updateRawExpensesCount() {
            const rowCount = document.querySelectorAll('#ExpensesTable tbody tr').length;
            document.getElementById('rowExpensesCount').textContent = rowCount;
        }
        // Function to update the manufacturing count
        function updateManufacturingCount() {
            const rowCount = document.querySelectorAll('#manufacturingTable tbody tr').length;
            document.getElementById('manufacturingCount').textContent = rowCount;
        }
        // Function to update the end life count
        function updateEndLifeCount() {
            const rowCount = document.querySelectorAll('#EndLifeTable tbody tr').length;
            document.getElementById('EndLifeCount').textContent = rowCount;
        }
    </script>

    <script>
        function toggleSection(sectionId) {
            const section = document.getElementById(sectionId);
            if (section.style.display === "none") {
                section.style.display = "block";
            } else {
                section.style.display = "none";
            }
        }
    </script>

    <script>
        // Function to calculate the grand total for all sections
        function updateTotalCost() {
            let totalCost = 0;

            // Add raw materials total
            const rawMaterialsTotal = parseFloat(document.querySelector('.grand-total').textContent) || 0;
            totalCost += rawMaterialsTotal;

            // Add expenses total
            const expensesTotal = parseFloat(document.querySelector('.expenses-grand-total').textContent) || 0;
            totalCost += expensesTotal;

            // Add manufacturing total
            const manufacturingTotal = parseFloat(document.querySelector('.manufacturing-grand-total').textContent) || 0;
            totalCost += manufacturingTotal;

            // Add end life total
            const endLifeTotal = parseFloat(document.querySelector('.end-life-grand-total').textContent) || 0;
            totalCost += endLifeTotal;

            // Update the total cost display
            document.querySelector('.total-cost').textContent = totalCost.toFixed(2) + ' ر.س';
        }
    </script>

    <!--  المواد الخام -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const itemsTable = document.getElementById('itemsTable').querySelector('tbody');
            const addRowButton = document.getElementById('addRow');

            // Function to calculate total for a row
            function calculateTotal(row) {
                const unitPrice = parseFloat(row.querySelector('.unit-price').value) || 0;
                const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
                const total = unitPrice * quantity;
                row.querySelector('.total').value = total.toFixed(2);
                updateGrandTotal();
                updateTotalCost();
            }

            // Function to update grand total
            function updateGrandTotal() {
                let grandTotal = 0;
                document.querySelectorAll('.total').forEach(totalInput => {
                    grandTotal += parseFloat(totalInput.value) || 0;
                });
                document.querySelector('.grand-total').textContent = grandTotal.toFixed(2);
            }

            // Function to attach event listeners to a row
            function attachRowEvents(row) {
                const productSelect = row.querySelector('.product-select');
                const quantityInput = row.querySelector('.quantity');

                if (productSelect) {
                    productSelect.addEventListener('change', function () {
                        const selectedOption = productSelect.options[productSelect.selectedIndex];
                        const unitPrice = selectedOption.getAttribute('data-price');
                        row.querySelector('.unit-price').value = unitPrice;
                        calculateTotal(row);
                    });
                }

                if (quantityInput) {
                    quantityInput.addEventListener('input', function () {
                        calculateTotal(row);
                    });
                }
            }

            // Attach events to the first row
            const firstRow = document.getElementById('firstRow');
            if (firstRow) {
                attachRowEvents(firstRow);
            }

            // Add Row
            addRowButton.addEventListener('click', function (e) {
                e.preventDefault();

                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td>
                        <select name="product_id[]" class="form-control select2 product-select">
                            <option value="" disabled selected>-- اختر البند --</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->sale_price }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" name="unit_price[]" class="form-control unit-price" readonly></td>
                    <td><input type="number" name="quantity[]" class="form-control quantity" value="1" min="1"></td>
                    <td>
                        <select name="product_id[]" class="form-control select2 product-select">
                            <option value="" disabled selected>-- اختر المرحلة الانتاجية --</option>
                            <option value="1">مرحلة 1</option>
                            <option value="2">مرحلة 2</option>
                        </select>
                    </td>
                    <td><input type="number" name="total[]" class="form-control total" readonly></td>
                    <td>
                        <button type="button" class="btn btn-outline-danger btn-sm removeRow"><i class="fa fa-minus"></i></button>
                    </td>
                `;

                itemsTable.appendChild(newRow);
                attachRowEvents(newRow); // Attach events to the new row
                updateRawMaterialCount(); // Update the raw material count
                updateTotalCost(); // Update the total cost
            });

            // Remove Row
            itemsTable.addEventListener('click', function (e) {
                if (e.target.classList.contains('removeRow')) {
                    const row = e.target.closest('tr');
                    if (itemsTable.rows.length > 1) {
                        row.remove();
                        updateGrandTotal();
                        updateRawMaterialCount(); // Update the raw material count
                        updateTotalCost(); // Update the total cost
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            text: 'لا يمكنك حذف جميع الصفوف!',
                            confirmButtonText: 'حسناً',
                            confirmButtonColor: '#d33'
                        });
                    }
                }
            });

        });
    </script>
    <!-- المصروفات -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ExpensesTable = document.getElementById('ExpensesTable').querySelector('tbody');
            const ExpensesAddRowButton = document.getElementById('ExpensesAddRow');

            // Function to calculate total for a row
            function calculateTotal(row) {
                const expensesPrice = parseFloat(row.querySelector('.expenses-price').value) || 0;
                const expensesTotal = expensesPrice;
                row.querySelector('.expenses-total').value = expensesTotal.toFixed(2);
                updateGrandTotal();
                updateTotalCost();
            }

            // Function to update grand total
            function updateGrandTotal() {
                let expensesGrandTotal = 0;
                document.querySelectorAll('.expenses-total').forEach(totalInput => {
                    expensesGrandTotal += parseFloat(totalInput.value) || 0;
                });
                document.querySelector('.expenses-grand-total').textContent = expensesGrandTotal.toFixed(2);
            }

            // Attach events to a row
            function attachRowEvents(row) {
                const priceInput = row.querySelector('.expenses-price');
                priceInput.addEventListener('input', function () {
                    calculateTotal(row);
                });
            }

            // Add Row
            ExpensesAddRowButton.addEventListener('click', function (e) {
                e.preventDefault();

                const exNewRow = document.createElement('tr');
                exNewRow.innerHTML = `
                    <td>
                        <select name="account_id[]" class="form-control select2 product-select">
                            <option value="" disabled selected>-- اختر الحساب --</option>
                            <option value="1">حساب 1</option>
                            <option value="2">حساب 2</option>
                        </select>
                    </td>
                    <td>
                        <select name="cost_type[]" class="form-control select2 product-select">
                            <option value="" disabled selected>-- اختر نوع التكلفة --</option>
                            <option value="1">مبلغ ثابت</option>
                            <option value="2">بناءً على الكمية</option>
                            <option value="3">معادلة</option>
                        </select>
                    </td>
                    <td><input type="number" name="expenses_price[]" class="form-control expenses-price"></td>
                    <td><textarea name="description[]" class="form-control" rows="1"></textarea></td>
                    <td>
                        <select name="product_id[]" class="form-control select2 product-select">
                            <option value="" disabled selected>-- اختر المرحلة الانتاجية --</option>
                            <option value="1">مرحلة 1</option>
                            <option value="2">مرحلة 2</option>
                        </select>
                    </td>
                    <td><input type="number" name="total[]" class="form-control expenses-total" readonly></td>
                    <td>
                        <button type="button" class="btn btn-outline-danger btn-sm removeRow"><i class="fa fa-minus"></i></button>
                    </td>
                `;

                ExpensesTable.appendChild(exNewRow);
                attachRowEvents(exNewRow); // Attach events to the new row
                updateRawExpensesCount();
                updateTotalCost(); // Update the total cost
            });

            // Remove Row
            ExpensesTable.addEventListener('click', function (e) {
                if (e.target.classList.contains('removeRow')) {
                    const row = e.target.closest('tr');
                    if (ExpensesTable.rows.length > 1) {
                        row.remove();
                        updateGrandTotal();
                        updateRawExpensesCount();
                        updateTotalCost(); // Update the total cost
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            text: 'لا يمكنك حذف جميع الصفوف!',
                            confirmButtonText: 'حسناً',
                            confirmButtonColor: '#d33'
                        });
                    }
                }
            });

            // Attach events to existing rows
            ExpensesTable.querySelectorAll('tr').forEach(attachRowEvents);
        });
    </script>
    <!-- عمليات التصنيع -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const manufacturingTable = document.getElementById('manufacturingTable').querySelector('tbody');
            const manufacturingAddRowButton = document.getElementById('manufacturingAddRow');

            // Function to calculate total for a row
            function calculateTotal(row) {
                const manufacturingPrice = parseFloat(row.querySelector('.unit-price').value) || 0;
                const manufacturingTotal = manufacturingPrice; // يمكن تعديل هذه العملية إذا كان الإجمالي يتطلب حسابات أخرى
                row.querySelector('.manufacturing-total').value = manufacturingTotal.toFixed(2);
                updateGrandTotal();
                updateTotalCost();
            }

            // Function to update grand total
            function updateGrandTotal() {
                let manufacturingGrandTotal = 0;
                document.querySelectorAll('.manufacturing-total').forEach(totalInput => {
                    manufacturingGrandTotal += parseFloat(totalInput.value) || 0;
                });
                document.querySelector('.manufacturing-grand-total').textContent = manufacturingGrandTotal.toFixed(2);
            }

            // Attach events to a row
            function attachRowEvents(row) {
                const priceInput = row.querySelector('.unit-price');
                priceInput.addEventListener('input', function () {
                    calculateTotal(row);
                });
            }

            // Add Row
            manufacturingAddRowButton.addEventListener('click', function (e) {
                e.preventDefault();

                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td>
                        <select name="workstation_id[]" class="form-control select2 product-select">
                            <option value="" disabled selected>-- اختر محطة العمل --</option>
                            <option value="1">محطة 1</option>
                            <option value="2">محطة 2</option>
                        </select>
                    </td>
                    <td>
                        <select name="cost_type[]" class="form-control select2 product-select">
                            <option value="" disabled selected>-- اختر نوع التكلفة --</option>
                            <option value="1">مبلغ ثابت</option>
                            <option value="2">بناءً على الكمية</option>
                            <option value="3">معادلة</option>
                        </select>
                    </td>
                    <td><input type="number" name="price[]" class="form-control unit-price"></td>
                    <td><textarea name="description[]" class="form-control" rows="1"></textarea></td>
                    <td>
                        <select name="product_stage_id[]" class="form-control select2 product-select">
                            <option value="" disabled selected>-- اختر المرحلة الانتاجية --</option>
                            <option value="1">مرحلة 1</option>
                            <option value="2">مرحلة 2</option>
                        </select>
                    </td>
                    <td><input type="number" name="total[]" class="form-control manufacturing-total" readonly></td>
                    <td>
                        <button type="button" class="btn btn-outline-danger btn-sm removeRow"><i class="fa fa-minus"></i></button>
                    </td>
                `;

                manufacturingTable.appendChild(newRow);
                attachRowEvents(newRow); // Attach events to the new row
                updateManufacturingCount();
                updateTotalCost(); // Update the total cost
            });

            // Remove Row
            manufacturingTable.addEventListener('click', function (e) {
                if (e.target.classList.contains('removeRow')) {
                    const row = e.target.closest('tr');
                    if (manufacturingTable.rows.length > 1) {
                        row.remove();
                        updateGrandTotal();
                        updateManufacturingCount();
                        updateTotalCost(); // Update the total cost
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            text: 'لا يمكنك حذف جميع الصفوف!',
                            confirmButtonText: 'حسناً',
                            confirmButtonColor: '#d33'
                        });
                    }
                }
            });

            // Attach events to existing rows
            manufacturingTable.querySelectorAll('tr').forEach(attachRowEvents);
        });
    </script>
    <!-- المواد الهالكة -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const EndLifeTable = document.getElementById('EndLifeTable').querySelector('tbody');
            const EndLifeAddRowButton = document.getElementById('EndLifeAddRow');

            // Function to calculate total for a row
            function calculateTotal(row) {
                const EndLifeUnitPrice = parseFloat(row.querySelector('.end-life-unit-price').value) || 0;
                const EndLifeQuantity = parseFloat(row.querySelector('.end-life-quantity').value) || 0;
                const total = EndLifeUnitPrice * EndLifeQuantity;
                row.querySelector('.end-life-total').value = total.toFixed(2);
                updateGrandTotal();
                updateTotalCost();
            }

            // Function to update grand total
            function updateGrandTotal() {
                let grandTotal = 0;
                document.querySelectorAll('.end-life-total').forEach(totalInput => {
                    grandTotal += parseFloat(totalInput.value) || 0;
                });
                document.querySelector('.end-life-grand-total').textContent = grandTotal.toFixed(2);
            }

            // Function to attach event listeners to a row
            function attachRowEvents(row) {
                const productSelect = row.querySelector('.end-life-product-select');
                const quantityInput = row.querySelector('.end-life-quantity');

                if (productSelect) {
                    productSelect.addEventListener('change', function () {
                        const selectedOption = productSelect.options[productSelect.selectedIndex];
                        const unitPrice = selectedOption.getAttribute('data-price');
                        row.querySelector('.end-life-unit-price').value = unitPrice || 0;
                        calculateTotal(row);
                    });
                }

                if (quantityInput) {
                    quantityInput.addEventListener('input', function () {
                        calculateTotal(row);
                    });
                }
            }

            // Attach events to the first row
            const firstRow = document.getElementById('firstRow');
            if (firstRow) {
                attachRowEvents(firstRow);
            }

            // Add Row
            EndLifeAddRowButton.addEventListener('click', function (e) {
                e.preventDefault();

                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td>
                        <select name="product_id[]" class="form-control select2 end-life-product-select">
                            <option value="" disabled selected>-- اختر البند --</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->sale_price }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" name="unit_price[]" class="form-control end-life-unit-price" readonly></td>
                    <td><input type="number" name="quantity[]" class="form-control end-life-quantity" value="1" min="1"></td>
                    <td>
                        <select name="product_stage_id[]" class="form-control select2 product-select">
                            <option value="" disabled selected>-- اختر المرحلة الانتاجية --</option>
                            <option value="1">مرحلة 1</option>
                            <option value="2">مرحلة 2</option>
                        </select>
                    </td>
                    <td><input type="number" name="total[]" class="form-control end-life-total" readonly></td>
                    <td>
                        <button type="button" class="btn btn-outline-danger btn-sm removeRow"><i class="fa fa-minus"></i></button>
                    </td>
                `;

                EndLifeTable.appendChild(newRow);
                attachRowEvents(newRow); // Attach events to the new row
                updateEndLifeCount();
                updateTotalCost(); // Update the total cost
            });

            // Remove Row
            EndLifeTable.addEventListener('click', function (e) {
                if (e.target.classList.contains('removeRow')) {
                    const row = e.target.closest('tr');
                    if (EndLifeTable.rows.length > 1) {
                        row.remove();
                        updateGrandTotal();
                        updateEndLifeCount();
                        updateTotalCost(); // Update the total cost
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            text: 'لا يمكنك حذف جميع الصفوف!',
                            confirmButtonText: 'حسناً',
                            confirmButtonColor: '#d33'
                        });
                    }
                }
            });

        });
    </script>

@endsection
