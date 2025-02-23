@extends('master')

@section('title')
التكاليف غير المباشرة - تعديل
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
                    <h2 class="content-header-title float-left mb-0">التكاليف غير المباشرة - تعديل</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a></li>
                            <li class="breadcrumb-item active">تعديل</li>
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

            <form class="form-horizontal" action="{{ route('manufacturing.indirectcosts.update', $indirectCost->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                            </div>

                            <div>
                                <a href="{{ route('manufacturing.orders.index') }}" class="btn btn-outline-danger">
                                    <i class="fa fa-ban"></i>الغاء
                                </a>
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fa fa-save"></i>تحديث
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
                                <div class="form-group col-md-6">
                                    <label for="">الحساب <span class="text-danger">*</span></label>
                                    <select class="form-control" id="basicSelect" name="account_id">
                                        <option value="" disabled selected>-- اختر الحساب --</option>
                                        @foreach ($accounts as $account)
                                            <option value="{{ $account->id }}" {{ $indirectCost->account_id == $account->id ? 'selected' : '' }}>{{ $account->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="">التاريخ من<span style="color: red">*</span></label>
                                    <input type="date" class="form-control" name="from_date" value="{{ $indirectCost->from_date }}">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="">التاريخ الى<span style="color: red">*</span></label>
                                    <input type="date" class="form-control" name="to_date" value="{{ $indirectCost->to_date }}">
                                </div>

                                <div class="form-group col-md-12">
                                    <p>نوع التوزيع <span style="color: red">*</span> </p>
                                    <ul class="list-unstyled mb-0">
                                        <li class="d-inline-block mr-2">
                                            <fieldset>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input vs-radio-lg" name="based_on" id="customRadio1" value="1" {{ $indirectCost->based_on == 1 ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="customRadio1">بناءً على الكمية</label>
                                                </div>
                                            </fieldset>
                                        </li>
                                        <li class="d-inline-block mr-2">
                                            <fieldset>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input vs-radio-lg" name="based_on" id="customRadio2" value="2" {{ $indirectCost->based_on == 2 ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="customRadio2">بناءً على التكلفة</label>
                                                </div>
                                            </fieldset>
                                        </li>
                                    </ul>
                                </div>

                                <div class="form-group col-md-12 mt-1">
                                    <p onclick="toggleSection('expenses')" class="d-flex justify-content-between section-header" style="background: #DBDEE2; width: 100%;">
                                        <span class="p-1 font-weight-bold"><i class="fa fa-money"></i> القيود اليومية (<span id="rowExpensesCount">{{ count($indirectCost->indirectCostItems) }}</span>)</span>
                                        <i class="feather icon-plus-circle p-1"></i>
                                    </p>
                                    <div id="expenses" style="display: block">
                                        <table class="table table-striped" id="itemsTable">
                                            <thead style="background: #f8f8f8">
                                                <tr>
                                                    <th>قيد</th>
                                                    <th>المجموع</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($indirectCost->indirectCostItems as $index => $item)
                                                    <tr>
                                                        <td>
                                                            <select class="form-control" name="restriction_id[]">
                                                                <option value="" disabled selected>-- اختر القيد --</option>
                                                                <option value="1" {{ $item->restriction_id == 1 ? 'selected' : '' }}>قيد 1</option>
                                                                <option value="2" {{ $item->restriction_id == 2 ? 'selected' : '' }}>قيد 2</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="restriction_total[]" value="{{ $item->restriction_total }}" readonly>
                                                        </td>
                                                        <td style="width: 10%">
                                                            <button type="button" class="btn btn-outline-danger btn-sm removeRow"><i class="fa fa-minus"></i></button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <hr>
                                        <div class="d-flex justify-content-between mt-2">
                                            <button type="button" class="btn btn-outline-success btn-sm" id="ExpensesAddRow"><i class="fa fa-plus"></i> إضافة</button>
                                            <strong style="margin-left: 13rem;"><small class="text-muted">الإجمالي الكلي : </small><span class="expenses-grand-total">0.00</span></strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <p onclick="toggleSection('manufacturing')" class="d-flex justify-content-between section-header" style="background: #DBDEE2; width: 100%;">
                                        <span class="p-1 font-weight-bold"><i class="feather icon-package"></i> أوامر التصنيع (<span id="rowManufacturingCount">{{ count($indirectCost->indirectCostItems) }}</span>)</span>
                                        <i class="feather icon-plus-circle p-1"></i>
                                    </p>
                                    <div id="manufacturing" style="display: block">
                                        <table class="table table-striped" id="manufacturingTable">
                                            <thead style="background: #f8f8f8">
                                                <tr>
                                                    <th>طلب التصنيع</th>
                                                    <th>المبلغ</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($indirectCost->indirectCostItems as $index => $item)
                                                    <tr>
                                                        <td>
                                                            <select name="manufacturing_order_id[]" class="form-control">
                                                                <option value="">-- اختر طلب التصنيع --</option>
                                                                @foreach ($manufacturing_orders as $manufacturing_order)
                                                                    <option value="{{ $manufacturing_order->id }}" {{ $item->manufacturing_order_id == $manufacturing_order->id ? 'selected' : '' }}>{{ $manufacturing_order->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td><input type="number" step="0.01" name="manufacturing_price[]" class="form-control manufacturing-price" value="{{ $item->manufacturing_price }}"></td>
                                                        <td style="width: 10%">
                                                            <button type="button" class="btn btn-outline-danger btn-sm removeRow"><i class="fa fa-minus"></i></button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <hr>
                                        <div class="d-flex justify-content-between mt-2">
                                            <button type="button" class="btn btn-outline-success btn-sm" id="ManufacturingAddRow"><i class="fa fa-plus"></i> إضافة</button>
                                            <strong style="margin-left: 13rem;"><small class="text-muted">الإجمالي الكلي : </small><span class="manufacturing-grand-total">0.00</span></strong>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" step="0.01" id="total" name="total" class="form-control" value="{{ $indirectCost->total }}">
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
        function toggleSection(sectionId) {
            const section = document.getElementById(sectionId);
            if (section.style.display === "none") {
                section.style.display = "block";
            } else {
                section.style.display = "none";
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const itemsTable = document.getElementById('itemsTable').querySelector('tbody');
            const ExpensesAddRowButton = document.getElementById('ExpensesAddRow');
            const manufacturingTable = document.getElementById('manufacturingTable').querySelector('tbody');
            const ManufacturingAddRowButton = document.getElementById('ManufacturingAddRow');
            const totalInput = document.getElementById('total');

            function updateRowCount(table, countElementId) {
                const rowCount = table.querySelectorAll('tr').length;
                document.getElementById(countElementId).textContent = rowCount;
            }

            function calculateTotal(table, totalElementClass) {
                let total = 0;
                table.querySelectorAll('tr').forEach(row => {
                    const priceInput = row.querySelector('.manufacturing-price');
                    if (priceInput) {
                        const price = parseFloat(priceInput.value) || 0;
                        total += price;
                    }
                });
                document.querySelector(totalElementClass).textContent = total.toFixed(2);
                updateTotalSum();
            }

            function updateTotalSum() {
                const expensesTotal = parseFloat(document.querySelector('.expenses-grand-total').textContent) || 0;
                const manufacturingTotal = parseFloat(document.querySelector('.manufacturing-grand-total').textContent) || 0;
                const totalSum = expensesTotal + manufacturingTotal;
                totalInput.value = totalSum.toFixed(2);
            }

            function attachRowEvents(row, table, totalElementClass) {
                const priceInput = row.querySelector('.manufacturing-price');
                if (priceInput) {
                    priceInput.addEventListener('input', function () {
                        calculateTotal(table, totalElementClass);
                    });
                }
            }

            ExpensesAddRowButton.addEventListener('click', function (e) {
                e.preventDefault();

                const exNewRow = document.createElement('tr');
                exNewRow.innerHTML = `
                    <td>
                        <select class="form-control" name="restriction_id[]">
                            <option value="" disabled selected>-- اختر القيد --</option>
                            <option value="1">قيد 1</option>
                            <option value="2">قيد 2</option>
                        </select>
                    </td>
                    <td><input type="number" name="restriction_total[]" class="form-control expenses-total" readonly value="0"></td>
                    <td>
                        <button type="button" class="btn btn-outline-danger btn-sm removeRow"><i class="fa fa-minus"></i></button>
                    </td>
                `;

                itemsTable.appendChild(exNewRow);
                attachRowEvents(exNewRow, itemsTable, '.expenses-grand-total');
                updateRowCount(itemsTable, 'rowExpensesCount');
            });

            ManufacturingAddRowButton.addEventListener('click', function (e) {
                e.preventDefault();

                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td>
                        <select name="manufacturing_order_id[]" class="form-control">
                            <option value="">-- اختر طلب التصنيع --</option>
                            @foreach ($manufacturing_orders as $manufacturing_order)
                                <option value="{{ $manufacturing_order->id }}">{{ $manufacturing_order->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" step="0.01" name="manufacturing_price[]" class="form-control manufacturing-price"></td>
                    <td style="width: 10%">
                        <button type="button" class="btn btn-outline-danger btn-sm removeRow"><i class="fa fa-minus"></i></button>
                    </td>
                `;

                manufacturingTable.appendChild(newRow);
                attachRowEvents(newRow, manufacturingTable, '.manufacturing-grand-total');
                updateRowCount(manufacturingTable, 'rowManufacturingCount');
            });

            itemsTable.addEventListener('click', function (e) {
                if (e.target.classList.contains('removeRow')) {
                    const row = e.target.closest('tr');
                    if (itemsTable.rows.length > 1) {
                        row.remove();
                        calculateTotal(itemsTable, '.expenses-grand-total');
                        updateRowCount(itemsTable, 'rowExpensesCount');
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

            manufacturingTable.addEventListener('click', function (e) {
                if (e.target.classList.contains('removeRow')) {
                    const row = e.target.closest('tr');
                    if (manufacturingTable.rows.length > 1) {
                        row.remove();
                        calculateTotal(manufacturingTable, '.manufacturing-grand-total');
                        updateRowCount(manufacturingTable, 'rowManufacturingCount');
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

            itemsTable.querySelectorAll('tr').forEach(row => attachRowEvents(row, itemsTable, '.expenses-grand-total'));
            manufacturingTable.querySelectorAll('tr').forEach(row => attachRowEvents(row, manufacturingTable, '.manufacturing-grand-total'));
            updateRowCount(itemsTable, 'rowExpensesCount');
            updateRowCount(manufacturingTable, 'rowManufacturingCount');
        });
    </script>
@endsection
