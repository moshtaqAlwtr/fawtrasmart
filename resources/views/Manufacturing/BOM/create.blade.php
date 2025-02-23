@extends('master')

@section('title')
قوائم مواد الإنتاج
@stop

@section('css')
    <style>
        .section-header {
            cursor: pointer;
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

            <form class="form-horizontal" action="{{ route('Bom.store') }}" method="POST" enctype="multipart/form-data">
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
                                    <input type="text" class="form-control" name="code" value="{{ $serial_number }}">
                                </div>

                                <div class="form-group col-md-2 mt-2">
                                    <div class="custom-control custom-switch custom-switch-success custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch1" name="status" checked="1" value="1">
                                        <label class="custom-control-label" for="customSwitch1">
                                        </label>
                                        <span class="switch-label">نشط</span>
                                    </div>
                                </div>

                                <div class="form-group col-md-2 mt-2">
                                    <div class="custom-control custom-switch custom-switch-success custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch2" name="default" value="1">
                                        <label class="custom-control-label" for="customSwitch2">
                                        </label>
                                        <span class="switch-label">الافتراضي</span>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">المنتجات <span class="text-danger">*</span></label>
                                    <select class="form-control" name="product_id">
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">الحساب <span class="text-danger">*</span></label>
                                    <select class="form-control" id="basicSelect" name="account_id">
                                        <option value="" disabled selected>-- اختر الحساب --</option>
                                        @foreach ($accounts as $account)
                                            <option value="{{ $account->id }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>{{ $account->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>الكمية <span style="color: red">*</span></label>
                                    <input type="number" class="form-control" name="quantity" value="{{ old('quantity') }}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">مسار الانتاج <span class="text-danger">*</span></label>
                                    <select class="form-control" id="basicSelect" name="production_path_id">
                                        <option value="" disabled selected>-- اختر المسار الانتاج --</option>
                                        @foreach ($paths as $path)
                                            <option value="{{ $path->id }}" {{ old('production_path_id') == $path->id ? 'selected' : '' }}>{{ $path->name }}</option>
                                        @endforeach
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
                                                    <th>وقت التشغيل</th>
                                                    <th>التكلفة</th>
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
                                                    <th>السعر</th>
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
                                        <input type="hidden" name="last_total_cost" id="last_total_cost">
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
        function updateLastTotalCost() {
            const totalCost = parseFloat(document.querySelector('.total-cost').textContent) || 0;
            document.getElementById('last_total_cost').value = totalCost.toFixed(2);
        }
    </script>

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

            // Update the hidden input field
            updateLastTotalCost();
        }
    </script>

    <!-- المواد الخام -->
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
                        <select name="raw_product_id[]" class="form-control select2 product-select">
                            <option value="" disabled selected>-- اختر البند --</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->sale_price }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" name="raw_unit_price[]" class="form-control unit-price" readonly></td>
                    <td><input type="number" name="raw_quantity[]" class="form-control quantity" value="1" min="1"></td>
                    <td>
                        <select name="raw_production_stage_id[]" class="form-control select2 product-select" required>
                            
                            @foreach ($stages as $stage)
                                <option value="{{ $stage->id }}">{{ $stage->stage_name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" name="raw_total[]" class="form-control total" readonly></td>
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
                        <select name="expenses_account_id[]" class="form-control select2 product-select">
                            <option value="" disabled selected>-- اختر الحساب --</option>
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}" {{ old('account') == $account->id ? 'selected' : '' }}>{{ $account->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="expenses_cost_type[]" class="form-control select2 product-select">
                            <option value="1">مبلغ ثابت</option>
                            <option value="2">بناءً على الكمية</option>
                            <option value="3">معادلة</option>
                        </select>
                    </td>
                    <td><input type="number" name="expenses_price[]" class="form-control expenses-price"></td>
                    <td><textarea name="expenses_description[]" class="form-control" rows="1"></textarea></td>
                    <td>
                        <select name="expenses_production_stage_id[]" class="form-control select2 product-select" required>
                            
                            @foreach ($stages as $stage)
                                <option value="{{ $stage->id }}">{{ $stage->stage_name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" name="expenses_total[]" class="form-control expenses-total" readonly></td>
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
                const totalCost = parseFloat(row.querySelector('.total_cost').value) || 0;
                const operatingTime = parseFloat(row.querySelector('.operating_time').value) || 0;
                const manufacturingTotal = totalCost * operatingTime;

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

            // Function to fetch total_cost from the server
            function fetchTotalCost(workstationId, row) {
                fetch(`/api/workstations/${workstationId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.total_cost !== undefined) {
                            row.querySelector('.total_cost').value = data.total_cost;
                            calculateTotal(row); // إعادة حساب الإجمالي بعد تعبئة total_cost
                        } else {
                            console.error("total_cost غير موجود في الاستجابة:", data);
                        }
                    })
                    .catch(error => console.error('Error fetching total cost:', error));
            }

            // Attach events to a row
            function attachRowEvents(row) {
                const totalCostInput = row.querySelector('.total_cost');
                const operatingTimeInput = row.querySelector('.operating_time');
                const workstationSelect = row.querySelector('select[name="workstation_id[]"]');

                totalCostInput.addEventListener('input', function () {
                    calculateTotal(row);
                });

                operatingTimeInput.addEventListener('input', function () {
                    calculateTotal(row);
                });

                workstationSelect.addEventListener('change', function () {
                    const workstationId = this.value;
                    if (workstationId) {
                        fetchTotalCost(workstationId, row);
                    }
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
                            @foreach ($workstations as $workstation)
                                <option value="{{ $workstation->id }}">{{ $workstation->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="manu_cost_type[]" class="form-control select2 product-select">
                            <option value="1">مبلغ ثابت</option>
                            <option value="2">بناءً على الكمية</option>
                            <option value="3">معادلة</option>
                        </select>
                    </td>
                    <td><input type="number" name="operating_time[]" class="form-control operating_time"></td>
                    <td><input type="number" name="manu_total_cost[]" class="form-control total_cost" readonly></td>
                    <td><textarea name="manu_description[]" class="form-control" rows="1"></textarea></td>
                    <td>
                        <select name="manu_production_stage_id[]" class="form-control select2 product-select" required>
                            
                            @foreach ($stages as $stage)
                                <option value="{{ $stage->id }}">{{ $stage->stage_name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" name="manu_total[]" class="form-control manufacturing-total" readonly></td>
                    <td>
                        <button type="button" class="btn btn-outline-danger btn-sm removeRow"><i class="fa fa-minus"></i></button>
                    </td>
                `;

                manufacturingTable.appendChild(newRow);
                attachRowEvents(newRow);
                updateTotalCost();
            });

            // Remove Row
            manufacturingTable.addEventListener('click', function (e) {
                if (e.target.classList.contains('removeRow')) {
                    const row = e.target.closest('tr');
                    if (manufacturingTable.rows.length > 1) {
                        row.remove();
                        updateGrandTotal();
                        updateTotalCost();
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
                        <select name="end_life_product_id[]" class="form-control select2 end-life-product-select">
                            <option value="" disabled selected>-- اختر البند --</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->sale_price }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" name="end_life_unit_price[]" class="form-control end-life-unit-price"></td>
                    <td><input type="number" name="end_life_quantity[]" class="form-control end-life-quantity" value="1" min="1"></td>
                    <td>
                        <select name="end_life_production_stage_id[]" class="form-control select2 product-select" required>
                            
                            @foreach ($stages as $stage)
                                <option value="{{ $stage->id }}">{{ $stage->stage_name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" name="end_life_total[]" class="form-control end-life-total" readonly></td>
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
